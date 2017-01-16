<?php

class QqoauthController extends FrontController {
    
     public function init() {
          parent::init();
     }

    
    public function actionLogin() {
        
        //用户点击qq登录按钮调用此函数
        $this->qq_login(Qqoauth_config::APPID, Qqoauth_config::SCOPE, Qqoauth_config::CALLBACK);
    }
     
    public function actionCallback() {
        //QQ登录成功后的回调地址,主要保存access token
        $this->qq_callback();
        //获取用户标示id
        $this->get_openid();
        
        $userinfo =  $this->get_user_info();
        $member_info = Member::getMemberByopenid(Mod::app()->session['openid']);
        $member_info['qqoauth_info'] = $userinfo;
//        $userinfo['openid'] = Mod::app()->session['openid'];
//        $userinfo['mid'] = $member_info['id'];
//        $userinfo['createtime'] = $member_info['createtime'];
//        $userinfo['status'] = $member_info['status'];
//        $userinfo['tel'] = $member_info['tel'];
//        $userinfo['email'] = $member_info['email'];
//        $userinfo['address'] = $member_info['address'];
//        $userinfo['group_id'] = $member_info['group_id'];
//        $userinfo['is_info'] = $member_info['is_info'];//是否完善过信息
        $this->member = Mod::app()->session['member']   = $member_info;
//        print_r($this->member);die;
        echo "<script>window.opener.document.getElementById('toplogin').style.display='none';</script>";
        echo "<script>window.opener.document.getElementById('topnickname').innerHTML='<i class=\"icon-people-white\"></i>" . $this->member['qqoauth_info']['nickname']. "';</script>";
        echo "<script>window.opener.document.getElementById('topmember').style.display='block';</script>";
        echo '<script language="JavaScript">window.close()</script>';die;
    }
    
    function qq_login($appid, $scope, $callback){
        Mod::app()->session['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
            . $appid . "&redirect_uri=" . urlencode($callback)
            . "&state=" . Mod::app()->session['state']
            . "&scope=".$scope;
        header("Location:$login_url");
    }

    function qq_callback() {
        //debug
        //print_r($_REQUEST);
        //print_r($_SESSION);
        if ($_REQUEST['state'] == Mod::app()->session['state']) { //csrf
            $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
                    . "client_id=" . Qqoauth_config::APPID . "&redirect_uri=" . urlencode(Qqoauth_config::CALLBACK)
                    . "&client_secret=" . Qqoauth_config::APPKEY . "&code=" . $_REQUEST["code"];

            $response = file_get_contents($token_url);
            if (strpos($response, "callback") !== false) {
                $lpos = strpos($response, "(");
                $rpos = strrpos($response, ")");
                $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
                $msg = json_decode($response);
                if (isset($msg->error)) {
                    echo "<h3>error:</h3>" . $msg->error;
                    echo "<h3>msg  :</h3>" . $msg->error_description;
                    exit;
                }
            }

            $params = array();
            parse_str($response, $params);

//debug
//print_r($params);
//set access token to session
            Mod::app()->session["access_token"] = $params["access_token"];
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }

    function get_openid() {
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . Mod::app()->session['access_token'];

        $str = file_get_contents($graph_url);
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
        }

        $user = json_decode($str);
        if (isset($user->error)) {
            echo "<h3>error:</h3>" . $user->error;
            echo "<h3>msg  :</h3>" . $user->error_description;
            exit;
        }

//debug
//echo("Hello " . $user->openid);
//set openid to session
        Mod::app()->session["openid"] = $user->openid;
    }
    
    
    function get_user_info(){
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . Mod::app()->session['access_token']
        . "&oauth_consumer_key=" . Qqoauth_config::APPID
        . "&openid=" . Mod::app()->session['openid']
        . "&format=json";

    $info = file_get_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

}
