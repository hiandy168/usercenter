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
        $data = array(
            'reurl' => "?state=".$this->_siteUrl."/house/site",
        );
        $this->render("login",$data);
    }
}