<?php


class LoginController extends Controller{

    /**
     * 登陆测试
     * author  Fancy
     */
    protected $_siteUrl;
    protected $_theme_url;
    public function init(){
        $this->_theme_url = $this->_siteUrl.'/themes/new/';
    }
    public function actionIndex(){
        $city=Tool::getValidParam('city','string');
        $house=md5('wxa8ba3a5d0f323f33');
        $data = array(
            'reurl' => "/house/$house?state=".$this->createAbsoluteUrl('/house/site/index',array('city'=>$city?$city:1)),
            'city' => $city,
        );

         if(Mod::app()->request->hostInfo == DACHUUC_HOST_INFO){
               $this->render("login",$data);
         }else{
               $this->render("login_test",$data);
         }
    }
}