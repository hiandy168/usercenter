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
            'reurl' => "/house/$house?state=".$this->_siteUrl."/house/site/index",
            'city' => $city,
        );
        $this->render("login",$data);
    }
}