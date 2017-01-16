<?php

class WeixinController extends CController
{
    public function actionAuth()
    {
        echo "开发中";exit;
        $code = Tool::getValidParam("code",'string');
        $options = Mod::app()->params['wechat'];
        $weObj = new Wechat($options);

        if ($code) {
            #得到token
            $jsonToken = $weObj->getOauthAccessToken();

              #得到userinfo
             if (is_array($jsonToken)) {
                 $wechatMember = $weObj->getOauthUserinfo($jsonToken['access_token'], $jsonToken['openid']);
                // echo '<pre>';
                 //print_r($wechatMember);exit;
//
//                //随机生成name获取mid
//                $data['name'] = mt_rand(1000000000,9999999999).mt_rand(1,9);
//                $dbUser = Member::model()->savedata($data);
//
                  $wechatMember['access_token'] = $jsonToken['access_token'];
                  Mod::app()->session->add('member', array('wechat' => $wechatMember));
//
                 $callback = Mod::app()->session['wechat_callback'];
                 $this->redirect($callback);
            }
        } else {
            $callback = $this->createAbsoluteUrl("weixin/auth");
            #得到code
            $url = $weObj->getOauthRedirect($callback);
            $this->redirect($url);
        }
    }
}
