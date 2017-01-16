<?php
class WechatController extends WController{

    public function actionIndex(){
        echo "开发中";exit;
        $memberInfo = Mod::app()->session['member'];

        echo "<pre>";
        echo 'mid：'.$this->mid."<br/>";
        echo 'openid：'.$this->openid."<br/>";
        print_r('accesstoken：'.$this->access_token); exit;
    }
}