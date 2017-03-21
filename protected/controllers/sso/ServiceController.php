<?php

/**
 * 单点登录服务
 */
class ServiceController extends FrontController
{
    /**
     * 取消服务端 HTTP401
     */
    public $pass401 = false;

    /**
     * 用户信息
     * @var array
     */
    protected $userinfo;

    public $ip;
    public $project;
    public $pass;

    public $error;

    private $key = "dachuw";

    /**
     * 构造函数
     */
    public function init()
    {
        parent::init();
        $this->testconnected();//测试是否连接 
    }
    
    
     /**
     * testsso
     */
     public function testconnected(){
        if (isset($_GET['testsso']) && $_GET['testsso'] == 1) {
            echo "connected";
            exit();
        }
    }

    /**
     * 退出单点登录
     */
    public function actionLogout()
    {

        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        unset(Mod::app()->session['member']);
        Mod::app()->session->clear();
        Mod::app()->session->destroy();
        
        $callback =  Tool::getValidParam('callback', 'string',$this->_siteUrl);
        header( "Location:" . $callback);
    }

    /*
     * 登录
     * 通过账号密码或者验证码登录
     * */
    public function actionLogin(){
 
        $appid =  Tool::getValidParam('appid', 'string');
        $sign =  Tool::getValidParam('sign', 'string');
        $timestamp =  Tool::getValidParam('timestamp', 'string');
        
        Mod::app()->session['ssoproject'] =  $this->project = Project::model()->findByAttributes(array('appid'=>$appid))->attributes;

        
        $params=array("appid"=>$appid,"appsecret"=>$this->project['appsecret'],"timestamp"=>$timestamp);
        $params['sign'] = $sign;

        // echo "sign1: ".md5($sign)."<br>sign2: <br>";
        $res  = Tool::signVerify($this->project['appsecret'],$params);

        //验证$sgin失效验证
        if(!$res){
            //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40005;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);

            echo urldecode(json_encode($returnCode));exit;
        }
       //根据timestamp验证$sgin  5分钟失效验证
        if(($timestamp/1000 +300) < time()){
             //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40006;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);
            echo urldecode(json_encode($returnCode));exit;
        }


        
        
        //接受表单
        if (Mod::app()->request->isPostRequest) {
            $data['username'] = trim(Tool::getValidParam('username', 'string'));
            $codes = trim(Tool::getValidParam('codes', 'integer'));
            //验证用户名(手机合法性)
            $pattern = '/^1[3-9]+\\d{9}$/';
            $match = preg_match($pattern, $data['username']);
            if (!$match) {
                echo 'state: 0, message: 手机号码不合法';
              //  echo json_encode(array('state' => 0, 'message' => '手机号码不合法'));
                exit;
            }
            if ($data['username']) {
                //短信验证码是否正确或已过期
                $auth_code = Mod::app()->memcache->get('dachuw' . $data['username']);
                if ($codes != $auth_code || !$codes) {
                  //  echo json_encode(array('state' => 0, 'message' => '验证码错误'));
                    echo 'state: 0, message: 验证码错误';
                    exit;
                }
            }

            //初始化登陆模型
            $login_model = new Memberloginform();
            $login_model->username = $data['username'];
            $login_model->password = "";
            //不能直接把数组给attributes  但是可以单独的给key赋值
            $member = $login_model->login();
            $array['phone']=$data['username'];
            $array['name']=$this->project['name']."接入用户";

            if ($member && is_array($member)) {
                $uid = $member['id'];
                if ($uid > 0) {
                    $ticket=self::getTicket($uid);

                    header("Location: ".$this->project['callback']."?ticket=$ticket");
                    exit;
                } else if ($uid == -1) {
                    echo 'state: 0, message: UCenter数据错误';
                   // echo json_encode(array('state' => 0, 'message' => 'UCenter数据错误'));
                    exit;

                } else if ($uid == -2) {
                    echo 'state: 0, message: UCenter密码错';
                   // echo json_encode(array('state' => 0, 'message' => 'UCenter密码错'));
                    exit;
                } else {
                    echo 'state: 0, message: 未定义';
                   // echo json_encode(array('state' => 0, 'message' => '未定义'));
                    exit;
                }
            } else if ($member == 1) {
                //如果用户不存在就要给用户进行注册,返回 mid
                $re=$this->reg_member($array);
                $ticket=self::getTicket($re);

                header("Location: ".$this->project['url']."?ticket=$ticket");
                exit;

            } else if ($member == 9) {
                echo 'state: 0, message: 用户不能登陆没有平台权限，需审核';
               // echo json_encode(array('state' => 0, 'message' => '用户不能登陆没有平台权限，需审核'));

                exit;
            } else if ($member == 11) {
                echo 'state: 0, message: 请等待审核';
             //   echo json_encode(array('state' => 0, 'message' => '请等待审核'));

                exit;
            } else {
                echo 'state: 0, message: 用户名或者密码错误';
              //  echo json_encode(array('state' => 0, 'message' => '用户名或者密码错误'));

            }

        } else {

           $this->render('login', array("backurl" => $this->project['url']));
        }


    }

    /*
     * 这个是为了快捷登录  qq  微信  登录成功之后回调过来生成票据 ticket
     * */
    public function actionCallsetticket(){
        //如果登录成功之后  session 应该是有值的
        $mid= $this->member['id'];
        if(!$mid){
            echo 'state: 0, message: 登录失败，请重试！';
            exit;
        }
       
       $this->project =   Mod::app()->session['ssoproject'];
        if($this->project){
            Mod::app()->session['ssoproject'] =  $this->project = Project::model()->findByPk($this->project['id'])->attributes;
        }
        
       $ticket= self::getTicket($mid);//生成ticket 并加密
        
        
       if($this->project['callback']){
            header("Location: ".$this->project['callback']."?ticket=$ticket");
            exit;
       }else{
            //回调地址没有设置
            $returnCode['code'] = 40007;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);
            echo urldecode(json_encode($returnCode));exit;
 
       }

    }



    /*
     * 注册用户
     * */

    public function reg_member($array){

        $member_model = new Member();
        $member_model->name =$array['name'] ;
        $member_model->regtime = time();
        $member_model->regip = Mod::app()->request->userHostAddress;
        $member_model->status = 1;
        $member_model->pstatus = 1;
        $member_model->phone = $array['phone'];
        $member_model->sex = 1;
        $member_model->username = "匿名用户";
        $member_model->createtime = time();
        $member_model->updatetime = time();
        $member_model->save();
        $member_id = Mod::app()->db->getLastInsertID();
        $member_info = $member_model->attributes;
        if($member_id){
            return $member_id;
        }else{
            return false;
        }

    }

    /*
     * 接收 ticket返回对应的用户信息
     * */
    public function actionGetinfo(){

       
        $ticket = Tool::getValidParam("ticket", "string");
        $appid =  Tool::getValidParam('appid', 'string');
        $sign =  Tool::getValidParam('sign', 'string');
        $timestamp =  Tool::getValidParam('timestamp', 'string');
        
        Mod::app()->session['ssoproject'] =  $this->project = Project::model()->findByAttributes(array('appid'=>$appid))->attributes;

        
        $params=array("appid"=>$appid,"appsecret"=>$this->project['appsecret'],"timestamp"=>$timestamp,'ticket'=>$ticket);
        $params['sign'] = $sign;


        // echo "sign1: ".md5($sign)."<br>sign2: <br>";
         $res  = Tool::signVerify($this->project['appsecret'],$params);

        //验证$sgin失效验证
        if(!$res){
            //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40005;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);

            echo urldecode(json_encode($returnCode));exit;
        }
       //根据timestamp验证$sgin  5分钟失效验证
        if(($timestamp/1000 +300) < time()){
             //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40006;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);
            echo urldecode(json_encode($returnCode));exit;
        }
       

        if ($ticket) {
            //解密字符串
            $ticketstring =AESMcrypt::decrypt($ticket);
            //验证是否解密成功
            $ticketarray = explode('-', $ticketstring);
            $str=md5('session' . $this->key . $appid . $this->project['appsecret']);
            if ($ticketarray[0] == "SSO") {
                if($ticketarray[4]==$str){
                    echo json_encode(array('state' => 10004, 'message' => 'ticket is invalid'));
                    exit;
                }
                //检查时间是否超时，默认是7200 秒
                if($ticketarray[3]<time()){
                    echo json_encode(array('state' => 10001, 'message' => 'ticket is overdue'));
                    exit;
                }
                $uid = $ticketarray[2];
                //查看 该用户是否存在
                $member = Member::model()->findByPk($uid);
                if(!$member){
                    echo json_encode(array('state' => 10005, 'message' => 'ticket is invalidu'));
                    exit;
                }
                $this->member=Mod::app()->session['member']= $member->attributes;
                echo json_encode( $this->member);
                exit;
            }else{
                echo json_encode(array('state' => 10002, 'message' => 'ticket is invalid'));
                exit;
            }
        }else{
            echo json_encode(array('state' => 10004, 'message' => 'ticket is null'));
            exit;
        }
    }


    /**
     * 生成ticket
     *@param uid  int
     *@param key  bool
     * @return string
     *
     */
    protected function getTicket($uid,$key=true)
    {
        //过期时间为7200 秒
        $time=time()+7200;
        $str="SSO-{$this->getIp()}-{$uid}-{$time}-" . md5('session' . $this->key . $this->project['appid'] . $this->project['secret']);
        //如果为真进行加密处理
        if($key){
        
            $str = AESMcrypt::encrypt($str);
        }

        return $str;
    }
  

    /**
     * 获取错误信息
     */

    public function get_error()
    {
        return $this->error;
    }


   

  
    public function getIp()
    {
        $ip = '0.0.0.0';
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $this->is_ip($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $ip;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $this->is_ip($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $ip;
        } else {
            return $this->is_ip($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $ip;
        }
    }

    public function is_ip($str)
    {
        $ip = explode('.', $str);
        for ($i = 0; $i < count($ip); $i++) {
            if ($ip[$i] > 255) {
                return false;
            }
        }
        return preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $str);
    }
    
        /**
     * 错误
     *
     * @param string $message
     */
    protected function fail($message)
    {
        header("HTTP/1.1 406 Not Acceptable");
        echo $message;
        exit;
    }

    /**
     * 登录失败
     *
     * @param string $message
     */
    protected function failLogin($message)
    {
        header("HTTP/1.1 401 Unauthorized");
        echo $message;
        exit;
    }

}