<?php

/**
 * 单点登录服务
 */
class SsologinController extends FrontController
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
    public $user;
    public $pass;

    public $error;

    private $key = "dachuw";



    /**
     * 退出单点登录
     */
    public function actionLogout()
    {
        if (isset($_GET['testsso']) && $_GET['testsso'] == 1) {
            echo "connected";
            exit();
        }
        //header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

        list($ret, $body) = $this->serverCmd('logout');

//                setcookie('session_token', '');

        $cookie = Yii::app()->request->getCookies();
        unset($cookie['session_token']);
        echo $body;

    }

    /*
     * 登录
     * 通过账号密码或者验证码登录
     * */
    public function actionLogin()
    {
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
            $array['name']=$this->user['name']."接入用户";

            if ($member && is_array($member)) {
                $uid = $member['id'];
                if ($uid > 0) {
                    $ticket=self::getTicket($uid);

                    header("Location: ".$this->user['url']."?ticket=$ticket");
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
                $re=$this->actionIntermember($array);
                $ticket=self::getTicket($re);

                header("Location: ".$this->user['url']."?ticket=$ticket");
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

           $this->render('login', array("backurl" => $this->user['url']));
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
       $ticket= self::getTicket($mid);//生成ticket 并加密
        header("Location: ".$this->user['url']."?ticket=$ticket");
        exit;

    }



    /*
     * 注册用户
     * */

    public function actionIntermember($array){

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
    public function actionGetuserinfo(){

        $ticket = Tool::getValidParam("ticket", "string");
        $agentids = Tool::getValidParam('agentids', 'string');
        $secret = Tool::getValidParam('secret', 'string');
        if ($secret && $agentids) {
            $res = Sso_broker::model()->find("agentid=:agentid and secret=:secret", array(':agentid' => $agentids, ':secret' => $secret));
            //如果为真表示身份合法
            if (!$res) {
                echo "非法访问！";
                exit;
            }
        }else{
            echo json_encode(array('state' => 10005, 'message' =>  "agentids or secret is null"));

            exit;
        }
        if ($ticket) {
            //解密字符串
            $ticketstring = $this->secret_string($ticket);
            //验证是否解密成功
            $ticketarray = explode('-', $ticketstring);
            $str=md5('session' . $this->key . $agentids . $secret);
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
        $str="SSO-{$this->getIp()}-{$uid}-{$time}-" . md5('session' . $this->key . $this->user['agentids'] . $this->user['secret']);
        //如果为真进行加密处理
        if($key){
            $str=$this->string_secret($str);
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


    /*
     * 对称加密字符串
     * */

    public function string_secret($string)
    {
        $key = $this->key;

        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';
        //随机找一个数字，并从密锁串中找到一个密锁值
        $lockLen = strlen($lockstream);
        $lockCount = rand(0, $lockLen - 1);
        $randomLock = $lockstream[$lockCount];
        //结合随机密锁值生成MD5后的密码
        $password = md5($key . $randomLock);
        //开始对字符串加密
        $txtStream = base64_encode($string);
        $tmpStream = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = (strpos($lockstream, $txtStream[$i]) + $lockCount + ord($password[$k])) % ($lockLen);
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return $tmpStream . $randomLock;
    }

    /*
     * 解密字符串*/
    public function secret_string($string)
    {
        $key = $this->key;

        //密锁串，不能出现重复字符，内有A-Z,a-z,0-9,/,=,+,_,
        $lockstream = 'st=lDEFABCNOPyzghi_jQRST-UwxkVWXYZabcdef+IJK6/7nopqr89LMmGH012345uv';

        $lockLen = strlen($lockstream);
        //获得字符串长度
        $txtLen = strlen($string);
        //截取随机密锁值
        $randomLock = $string[$txtLen - 1];
        //获得随机密码值的位置
        $lockCount = strpos($lockstream, $randomLock);
        //结合随机密锁值生成MD5后的密码
        $password = md5($key . $randomLock);
        //开始对字符串解密
        $txtStream = substr($string, 0, $txtLen - 1);
        $tmpStream = '';
        $i = 0;
        $j = 0;
        $k = 0;
        for ($i = 0; $i < strlen($txtStream); $i++) {
            $k = ($k == strlen($password)) ? 0 : $k;
            $j = strpos($lockstream, $txtStream[$i]) - $lockCount - ord($password[$k]);
            while ($j < 0) {
                $j = $j + ($lockLen);
            }
            $tmpStream .= $lockstream[$j];
            $k++;
        }
        return base64_decode($tmpStream);
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

}