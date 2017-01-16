<?php

class ServiceController extends FrontController
{


    const ERROR_NONE = 0;
    const ERROR_USERNAME_INVALID = 1;
    const ERROR_PASSWORD_INVALID = 2;
    const ERROR_UNKNOWN_IDENTITY = 100;
    const ERROR_PSTATUS = 9;
    const ERROR_STATUS = 11;
    public $member_info;
    // public $agentid_model;
    public $username;
    public $password;
    private $_id;
    public $errorCode;
    public $client_addr;

    /**
     * session存储位置
     * @var string
     */
    public $links_path;

    /**
     * 标识sessioin是否开启
     * @var boolean
     */
    protected $started = false;

    /**
     * 当前应用
     * @var string
     */
    protected $agentid = null;

    /**
     * 当前用户
     */
    protected $user = null;

    /**
     * 构造函数
     */
    public function init()
    {
        parent::init();

//        $this->load->model('broker_model');
//
//        $this->load->model('user_model');

        //如果创建连接函数没有开启，$link_path系统默认存储session目录
        //if (!function_exists('symlink')) $this->links_path = sys_get_temp_dir();
//        $this->links_path = sys_get_temp_dir();
    }






    /**
     * 登录
     */
    public function actionLogin()
    {


        $this->username = Tool::getValidParam('username', 'string');
        $this->client_addr = Tool::getValidParam('client_addr', 'string');
        $this->password = Tool::getValidParam('password', 'string');

        $this->_session_start();
//        $this->username= 15997567510;
//        $this->password=  888888;

        if (empty($this->username))
            $this->failLogin("no_user_name");

        if (empty($this->password))
            $this->failLogin("no_password");

        //数据库验证
        $member_model = Member::model()->with('Membergroup')->find('( t.name=:name)', array(':name' => $this->username));

        //如果用户名不存在
        if ($member_model == null || empty($member_model)) {
            // echo  $member_model->password ."!==". Tool::md5str($this->password,$member_model->source);
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->failLogin(self::ERROR_USERNAME_INVALID);
        } else if ($member_model->password !== Tool::md5str($this->password, $member_model->source)) {
            //密码判断
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->failLogin(self::ERROR_PASSWORD_INVALID);
        } /*else if ($member_model->pstatus == 0) {
            //账号类型判断
            $this->errorCode = self::ERROR_PSTATUS;  //==9 表示 不是pc端注册用户不能登陆
            $this->failLogin(self::ERROR_PSTATUS);
        } else if ($member_model->status == 0) {
            //审核状态判断
            $this->errorCode = self::ERROR_STATUS;  //==11 表示 没有通过审核
            $this->failLogin(self::ERROR_STATUS);
        } */else {
            $this->errorCode = self::ERROR_NONE;
            Mod::app()->session['member'] = $member_model->attributes;
            $this->info();
        }

    }

    /**
     * PC登录
     */
    public function pc_login()
    {

        $this->_session_start();

        $cihiuserno = Tool::getValidParam('cihiuserno', 'string');

        $cihikey = Tool::getValidParam('cihikey', 'string');

        if (empty($cihiuserno))
            $this->failLogin("no_cihiuserno");

        if (empty($cihikey))
            $this->failLogin("no_cihikey");

        //数据库验证
//        $info = $this->user_model->_pc_login($cihiuserno, $cihikey);
        $member_model = Member::model()->with('Membergroup')->find('( t.name=:name)', array(':name' => $this->username));

        //如果用户名不存在
        if ($member_model == null || empty($member_model)) {
            // echo  $member_model->password ."!==". Tool::md5str($this->password,$member_model->source);
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->failLogin(self::ERROR_USERNAME_INVALID);
        } else if ($member_model->password !== Tool::md5str($this->password, $member_model->source)) {
            //密码判断
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->failLogin(self::ERROR_PASSWORD_INVALID);
        } else if ($member_model->pstatus == 0) {
            //账号类型判断
            $this->errorCode = self::ERROR_PSTATUS;  //==9 表示 不是pc端注册用户不能登陆
            $this->failLogin(self::ERROR_PSTATUS);
        } else if ($member_model->status == 0) {
            //审核状态判断
            $this->errorCode = self::ERROR_STATUS;  //==11 表示 没有通过审核
            $this->failLogin(self::ERROR_STATUS);
        } else {
            $this->errorCode = self::ERROR_NONE;
            Mod::app()->session['member'] = $member_model->attributes;
            $this->info();
        }
    }

    /**
     * 退出
     */
    public function logout()
    {
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

        $this->load->model('broker_model');

       // $agentids = $this->agentid_model->get_all_broker();
        $agentids = Sso_broker::model()->findAll();

        $res = '';
        foreach ($agentids as $k => $v) {
            if (trim($v['url']) != '') {
                $tmp_s = strstr($v['url'], '?') ? '&' : '?';
                $res .= '<script type="text/javascript" src="' . $v['url'] . $tmp_s . '&time=' . time() . ' reload="1"></script>';
            }
        }


        $this->_session_start();
        unset(Mod::app()->session['member']);
        echo $res;
    }

    /**
     * 输出用户信息
     */
    public function info()
    {
        $this->_session_start();
        //如果不存在登陆用户 返回提示
        $member = Mod::app()->session['member'];
        if (!$member) {
            $this->failLogin("Not logged in");
        }
        echo json_encode($member);
        exit();
    }

    /**
     * 连接session
     */
    public function actionAttach()
    {
        //开启回话
        $redirect = Tool::getValidParam('redirect', 'string');

        $this->_session_start();

        //检验broker

        $agentid = Tool::getValidParam('agentid', 'string');
        if (empty($agentid))
            $this->fail("No broker specified");
        //检验token
        $token = Tool::getValidParam('token', 'string');
        if (empty($token))
            $this->fail("No token specified");
        //检验校验码
        $checksum = Tool::getValidParam('checksum', 'string');
        $ip = Tool::getValidParam('ip', 'string');

        if (empty($checksum) || $this->generateAttachChecksum($agentid, $token,$ip) != $checksum) {
            $this->fail("Invalid_checksum");
        }

        //如果没有设置session存储位置

        if (!isset($this->links_path)) {

            //拼接session存储文件  
            $link = (session_save_path() ? session_save_path() : sys_get_temp_dir()) . "/sess_" . $this->generateSessionId($agentid, $token);
            //如果sessioin文件不存在 把本文件链接到系统的session_id上

            if (!file_exists($link))
                $attached = symlink('sess_' . session_id(), $link);
            //如果没有链接成功，报错
            if (!$attached)
                trigger_error("Failed to attach; Symlink wasn't created.", E_USER_ERROR);
        } else {
            //指定session路径存放session

            $link = "{$this->links_path}/" . $this->generateSessionId($agentid, $token);
            if (!file_exists($link))
                $attached = file_put_contents($link, session_id());
            if (!$attached)
                trigger_error("Failed to attach; Link file wasn't created.", E_USER_ERROR);
        }
        //跳转至broker经纪人

        if (isset($redirect)) {
            header("Location: " . $redirect, true, 307);
            exit;
        }

        // 输出图片用于ajax登录
        header("Content-Type: image/png");
        readfile("empty.png");
    }

    /*
     * 开启session并且防止session劫持
     */

    protected function _session_start()
    {
        //如果session已经启  false

        if ($this->started) {
            return;
        }

        $this->started = true;
        // 应用session
        $matches = null;

//        $cookie=new CHttpCookie($name,$value);  
//        $cookie->expire =time()+60*60*24;  
//        Mod::app()->request->cookies[$name]=$cookie;  
//        //获取Cookie  
//        $cookie=Mod::app()->request->cookies[$name];  
//        $value=$cookie->value;  
//        //删除Cookie  
//        $cookie = Mod::app()->request->getCookies();  
//        unset($cookie[$name]);


        // 开启用户会话
        session_start();
        //如果存在客户端IP并且客户端IP和服务端不一致，更新SESSIONID
        /*$client_addr = Mod::app()->session['client_addr'];*/
        $client_addr = $this->client_addr;
        if ($client_addr && $client_addr != $_SERVER['REMOTE_ADDR']) {
            session_regenerate_id(true);
        }
        //如果存在客户端IP并且一致，客户端IP设置为服务端IP

        if (!$client_addr) {
            Mod::app()->session['client_addr'] = $this->getIp();
        }
        $cookie_mod = Mod::app()->request->cookies[session_name()];
        $cookie = $cookie_mod->value;

        //如果通过request方式获取到PHPSSID 并且匹配本规则
        if (isset($cookie) && preg_match('/^SSO-(\w*+)-(\w*+)-([a-z0-9]*+)$/', $cookie, $matches)) {
            $sid = $cookie;
            if (isset($this->links_path) && file_exists("{$this->links_path}/$sid")) {
                session_id(file_get_contents("{$this->links_path}/$sid"));
                session_start();
//                setcookie(session_name(), "", 1);
                $cookie = new CHttpCookie(session_name(), "");
                $cookie->expire = time() + 1;
                Mod::app()->request->cookies[session_name()] = $cookie;

            } else {
                session_start();
            }

            if (!$client_addr) {
                session_destroy();
                $this->fail("Not attached");
            }

            if ($this->generateSessionId($matches[1], $matches[2], $client_addr) != $sid) {
                session_destroy();
                $this->fail("Invalid session id");
            }

            $this->agentid = $matches[1];
            return;
        }

    }

    /**
     * 通过session token生成session id
     *
     * @return string
     */
    protected function generateSessionId($agentid, $token, $client_addr = null)
    {
        //验证broker
        // $info = $this->agentid_model->get_broker_by_broker($agentid);
        $info = Sso_broker::model()->find('agentid=:agentid', array(':agentid' => $agentid));

        if ($info) {
            $secret = $info['secret'];
        } else {
            return null;
        }
        //如果客户端地址没有设置，获取客户端IP

        if (!isset($client_addr))
            $client_addr = $_SERVER['REMOTE_ADDR'];
        //根据 参数生出客户端session文件名称

        return "SSO-{$agentid}-{$token}-" . md5('session' . $token . $client_addr . $secret);
    }

    /**
     * 通过session token生成session id
     *
     * @return string
     */
    protected function generateAttachChecksum($agentid, $token,$ip="")
    {


//    ctype_alnum — 检查字符串中只包含数字或字母，相当于正则[A-Za-z0-9].
//    ctype_alpha — 检查字符串中只包含字母。
//    ctype_cntrl — 检查字符串中是否只包含" '\n' '\r' '\t' " 这样的控制字符。
//    ctype_digit — 检查字符串中是否只包含数字。
//    ctype_graph — 检查字符串中是否只包含可以输出的字符。
//    ctype_lower — 检查字符串中是否只包含小写的英文字母。
//    ctype_print — 检查字符串中是否只包含可以打印的字符。
//    ctype_punct — 检查字符串中是否只包含可以打印的字符，并且这样字符不能是非空格、数字、字符。
//    ctype_space — 检查字符串中是否只包含空格或者" " .
//    ctype_upper — 检查字符串中是否只包含大写的英文字母。
//    ctype_xdigit — 检查字符串中是否是16进制的字符串。     
        //验证broker
        $sql = 'select * from {{sso_broker}} where agentid = ' . $agentid;
        $info = Mod::app()->db->createCommand($sql)->queryRow();

        if ($info) {
            $secret = $info['secret'];
        } else {
            return null;
        }

        $ip=$ip?$ip:$_SERVER['REMOTE_ADDR'];
        return md5('attach' . $token . $ip . $secret);
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
