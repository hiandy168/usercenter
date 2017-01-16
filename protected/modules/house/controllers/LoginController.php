<?php


class LoginController extends Controller{

    /**
     * 登陆测试
     * author  Fancy
     */
    protected $_siteUrl;
    public function actionIndex(){
        $data = array(
            'reurl' => "/?state=".$this->_siteUrl."/house/site",
        );
        $this->render("login",$data);
    }




}