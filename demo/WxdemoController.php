<?php
include "WxConf.php";
include "jssdk.php";
class WxdemoController{
    public $userinfo;
    public $wxopenid;
    public $access_token;
    public $refresh_token;
    public $url;
    public $signPackage;

    public function Init(){
        // parent::init();

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        if (strpos($user_agent, 'MicroMessenger') === true) {
            // 微信浏览器加载jssdk
            $jssdk = new Jssdk(WxConf::APPID, WxConf::APPSECRET);
            $this->signPackage = $jssdk->GetSignPackage();

            $this->url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

            if(empty($this->userinfo)){
                //获取user 信息
                $this->userinfo = $this->wx_myuserinfo();
                $openid = $this->userinfo['openid'];
            }
        }else{
            // 非微信浏览器

            $openid = "111111111111";//请自己获取
        }

        //进入活动页面  下面是刮刮卡的例子
        $this->redirect("http://m.dachuw.net/activity/scratchcard/view/id/16?openid=".$openid);

    } 
      
    public function wx_myuserinfo() {
        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))
        {
            //触发微信返回code码
            
            $urlObj["appid"] = WxConf::APPID;
            $urlObj["redirect_uri"] = $this->url;
            $urlObj["response_type"] = "code";
            $urlObj["scope"] = "snsapi_userinfo";
            $urlObj["state"] = "STATE"."#wechat_redirect";
            $bizString = http_build_query($urlObj);
            $url =  "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
            $this->redirect($url);
        }else{
            //获取code码，以获取openid
            $code = $_GET['code'];
            $info = WxConf::getInfo($code);

            if(!isset($info['openid'])){
                 $info = WxConf::getInfo($code);
            }
            $info['openid'];
            $this->access_token = $info['access_token'];
            $this->refresh_token = $info['refresh_token'];
            $user_info  = WxConf::GetUserInfoForOpenid($info['openid'],$info['access_token']);
            $res['wxopenid'] = $info['openid'];
            $res['username'] = $user_info['nickname'];
            $res['sex'] = $user_info['sex'];
            $res['headimgurl'] = $user_info['headimgurl'];
            $res['unionid'] = isset($user_info['unionid'])?$user_info['unionid']:'';
            
            return $res;
        }
            
    }
    
    //跳转
    public function redirect($url){
       header( "Location:" . $url);
    }
    


 
}
