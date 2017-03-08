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
        $return_url=Tool::getValidParam('return_url','string');
//        $cookie_mod =     Cookie::get('city', $cityurl);
        
        $backuRl =  base64_decode($return_url);
      
      
        if(substr(trim($backuRl), 0,4) != 'http'){
                $backuRl = Mod::app()->request->hostInfo.$backuRl;
        }else if(substr(trim($backuRl), 0,21) != Mod::app()->request->hostInfo){
              $backuRl =  $this->createAbsoluteUrl('/house/site/index');
        }else{
           $backuRl =  $this->createAbsoluteUrl('/house/site/index');
        }
        
        $backuRl = substr(trim($backuRl), 21);

        $house=md5('wxa8ba3a5d0f323f33');  
        if($backuRl){
            $reurl = "/house/$house?state=".$backuRl;
        }else{
           $reurl =  "/house/$house?state=".$this->createAbsoluteUrl('/house/site/index',array('city'=>$city?$city:1));
        }
                  
        $data = array(
            'reurl' => $reurl,
            'city' => $city,
        );

         if(Mod::app()->request->hostInfo == DACHUUC_HOST_INFO){
               $this->render("login",$data);
         }else{
               $this->render("login_test",$data);
         }
    }
}