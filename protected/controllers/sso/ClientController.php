<?php

/**
 * 单点登录服务
 */
class ClientController extends FrontController
{
    /**
     * 取消服务端 HTTP401
     */
    public $pass401 = false;

    /**
     * SSO服务地址
     * @var string
     */
    public $url = "/sso/service/";

    /**
     * 代理ID
     * @var string
     */
    public $agentid = "101011";

    /**
     * 密匙
     * @var string
     */
    public $secret = "f7d0b291df927f5d";

    /**
     * 不能比服务端设置的小
     * @var string
     */
    public $sessionExpire = 1800;

    /**
     * SESSION hash
     * @var string
     */
    protected $sessionToken;

    /**
     * 用户信息
     * @var array
     */
    protected $userinfo;

    public $ip;
    public $user;
    public $pass;
    /**
     * 错误信息
     *
     * 1. no_username 缺少用户名
     * 2. no_password 缺少密码
     * 3. user_not_exists 用户不存在
     * 4. bad_password 密码错误
     * 4. unknown  未知
     *
     */
    public $error;

    private $key = "dachuw";

    /**
     * 构造函数
     */
    public function init($auto_attach = true)
    {
        parent::init();
        $this->url = $this->_siteUrl . $this->url;
        $this->test_connectiong();   //测试通讯
        //如果cookie存在session_token

        $this->sessionToken = Mod::app()->request->cookies['session_token'];
        //如果设置自动粘贴token并且sessiontoken为假,带上参数跳转的服务端
        $this->ip=Tool::getValidParam('ip','string')?Tool::getValidParam('ip','string'):$_SERVER['REMOTE_ADDR'];
        $this->user =Tool::getValidParam("username","string");
        $this->pass =Tool::getValidParam("password","string");
        $ticket = Tool::getValidParam("ticket", "string");
     //   echo  $this->sessionToken;
        if ($auto_attach && !$this->sessionToken && !$ticket) {
            //跳转至SSO

           header("Location: " . $this->getAttachUrl() . "&redirect=" . urlencode("http://{$_SERVER["SERVER_NAME"]}{$_SERVER["REQUEST_URI"]}/username/$this->user/password/$this->pass"), true, 307);
            exit;
        }
        //如果session有值的话，写入this->member
        if (isset(Mod::app()->session['member'])) {
            $this->member = Mod::app()->session['member'];
        }

    }

    //测试通讯

    public function test_connectiong()
    {
        if (isset($_GET['testsso']) && $_GET['testsso'] == 1) {
            echo "connected";
        }
    }

    /**
     * 获取客户端的session_token
     *
     * @return string
     */
    public function getSessionToken()
    {
        //如果没有生成过session_token 生成session_token
        if (!$this->sessionToken) {
            //随机生成session_token
            $this->sessionToken = md5(uniqid(rand(), true));

            //把session_token写入cookie
            $cookie_key = 'session_token';
            $cookie = new CHttpCookie($cookie_key, $this->sessionToken);
            $cookie->expire = time() + $this->sessionExpire;
            Mod::app()->request->cookies[$cookie_key] = $cookie;
        }

        return $this->sessionToken;
    }

    /**
     * 生成session id
     *
     * @return string
     */
    protected function getSessionId()
    {
        if (!isset($this->sessionToken)) return null;

        return "SSO-{$this->agentid}-{$this->sessionToken}-" . md5('session' . $this->sessionToken . $this->ip . $this->secret);
    }

    /**
     * 生成ticket
     *
     * @return string
     */
    protected function getTicket($uid)
    {
        if (!isset($this->sessionToken)) return null;

        return "SSO-{$this->ip}-{$uid}-" . md5('session' . $this->sessionToken . $this->agentid . $this->secret);
    }

    /**
     * 获取URL并传递session到sso服务器
     *
     * @return string
     */
    public function getAttachUrl()
    {
        $token = $this->getSessionToken();
        //根据token和IP和代理端密钥生成校验码传递给服务端
        $checksum = md5("attach{$token}{$this->ip}{$this->secret}");
        //拼接URL 传递 sessioin_token和校验码到服务端
        return "{$this->url}attach?agentid={$this->agentid}&token=$token&checksum=$checksum&ip=$this->ip";
    }

    public function actionindex()
    {
//        $cookie = new CHttpCookie('zxcv',$_GET['sid']);
//        $cookie->expire = time()+60*60*24*30;  //有限期30天
//        Mod::app()->request->cookies["zxcv"] = $cookie;
        // '15997567510', '888888'
        //进行登录请求
        if($this->user && $this->pass && Mod::app()->request->isPostRequest) {
            $backurl = urldecode(Tool::getValidParam("backurl", "string"));
            $re = $this->login($this->user, $this->pass);

            //d登录成功，写入cookie  跨域
            if ($re['ret'] == 200 && is_array(json_decode($re['body'], true))) {
                //header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
                $this->member = json_decode($re['body'], true);
                $phpsessid = session_id();//phpsessionid
                $session_token = Mod::app()->request->cookies['session_token']; //token  还没有想好怎么用
                $ticket = $this->getTicket($this->member['id']); //票据，用户可以更具这个来换取用户信息
                //把票据加密 然后分发给其他域名
                $secretstring = $this->string_secret($ticket);

                //广播通知白名单上的域名
                $agentids = Sso_broker::model()->findAll();

                $res = '';
                foreach ($agentids as $k => $v) {
                    if (trim($v['url']) != '') {
                        $tmp_s = strstr($v['url'], '?') ? '&' : '?';
                        $url = $v['url'] . $tmp_s;
                        echo '<script type="text/javascript" src="' . $v['url'] . $tmp_s . 'ticket=' . $secretstring . '&sid=' . $phpsessid . '&token=' . $session_token . '" reload="1"></script>';
                    }

                }
                //header("Location: $backurl", true, 307);
                echo $phpsessid;
                exit;
            } else if ($re['body'] == 2) {
                echo "账号密码错误";
            } else {
                echo $re['body'];
            }
        }else{
            $this->render('login', $parame);
        }
    }


    /*当session过期之后可以通过票据来换取用户信息*/
    public function checkTicket()
    {
        $ticket = Tool::getValidParam("ticket", "string");
        if (!empty($ticket)) {
            //解密字符串
            $ticketstring = $this->secret_string($ticket);
            //验证是否解密成功
            $ticketarray = explode('-', $ticketstring);
            if ($ticketarray[0] == "SSO") {
                $uid = $ticketarray[2];
                $member = Member::model()->findByPk($uid);
                $this->member = $member->attributes;
                Mod::app()->session['member'] = $this->member;

                header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
                $phpsessid = session_id();//phpsessionid
                $session_token = Mod::app()->request->cookies['session_token']; //token  还没有想好怎么用
                $ticket = $this->getTicket($this->member['id']); //票据，用户可以更具这个来换取用户信息
                //把票据加密 然后分发给其他域名
                $secretstring = $this->string_secret($ticket);

                //广播通知白名单上的域名
                $agentids = Sso_broker::model()->findAll();

                $res = '';
                foreach ($agentids as $k => $v) {
                    if (trim($v['url']) != '') {
                        $tmp_s = strstr($v['url'], '?') ? '&' : '?';
                        $res .= '<script type="text/javascript" src="' . $v['url'] . $tmp_s . '&ticket=' . $secretstring . '&sid=' . $phpsessid . '&token=' . $session_token . '" reload="1"></script>';
                    }

                }
                echo $res;
                echo true;

                exit;

            } else {
                echo false;
            }


        } else {
            echo false;
        }
    }

/*
 * 验证tickte，并返回用户信息*/

    public  function actionreuser(){
        $ticket = Tool::getValidParam("ticket", "string");
        if (!empty($ticket)) {
            //解密字符串
            $ticketstring = $this->secret_string($ticket);
            //验证是否解密成功
            $ticketarray = explode('-', $ticketstring);
            if ($ticketarray[0] == "SSO") {
                $uid = $ticketarray[2];
                $member = Member::model()->findByPk($uid);
               // $this->member = $member->attributes;
                echo json_encode($member->attributes);
                //Mod::app()->session['member'] = $this->member;
                exit;
            }else{
                echo 1;
                exit;
            }
        }else{
            echo -1;
            exit;
        }
    }



    /**
     * WEB登录
     *
     * @param string $username
     * @param string $password
     * @return boolean
     *
     */
    public function login($username, $password)
    {

        list($ret, $body) = $this->serverCmd('login', array('username' => $username, 'password' => $password, 'client_addr' => $this->ip));
        return array('ret' => $ret, 'body' => $body);
        switch ($ret) {
            case 200:
                $this->parseInfo($body);
                return 1;
            case 401:
                $this->error = $body;
                return 2;
            default:
                $this->error = $body;
                return 0;

        }
    }

    /**
     * PC登录
     *
     * @param string $username
     * @param string $password
     * @return boolean
     *
     */
    public function pc_login($cihiuserno, $cihikey)
    {
        list($ret, $body) = $this->serverCmd('pc_login', array('cihiuserno' => $cihiuserno, 'cihikey' => $cihikey));

        switch ($ret) {

            case 200:
                $this->parseInfo($body);
                return 1;
            case 401:
                $this->error = $body;
                return 0;
            default:
                $this->error = $body;
                return 0;

        }
    }


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


    /**
     * 获取SSO当前登陆用户信息
     */
    public function actionGetInfo()
    {
        if (!isset($this->userinfo)) {

            list($ret, $body) = $this->serverCmd('info');
            switch ($ret) {
                case 200:
                    return $this->parseInfo($body);
                case 401:
                    $this->error = $body;
                    return 0;
                default:
                    $this->error = $body;
                    return 0;
            }
        }

        return $this->userinfo;
    }

    /**
     * 执行CURL请求
     *
     * @param string $cmd Command
     * @param array $vars Post variables
     * @return array
     *
     */
    protected function serverCmd($cmd, $vars = array())
    {
        $curl = curl_init($this->url . urlencode($cmd));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_COOKIE, "PHPSESSID=" . $this->getSessionId());

        if (!empty($vars)) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $body = curl_exec($curl);
        $ret = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl) != 0) throw new Exception("SSO failure: HTTP request to server failed. " . curl_error($curl));
        return array($ret, $body);
    }


    /**
     * 解析返回用户信息数据
     *
     * @param string $json
     */
    protected function parseInfo($json)
    {
        $josn = json_decode($json);
        return $this->userinfo = (array)$josn;
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

}