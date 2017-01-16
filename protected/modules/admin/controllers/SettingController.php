<?php

class SettingController extends AController {

    public function init()  {      
        parent::init();     
    }  
    
    public function actionIndex() {
        $this->actionSetting();
    }
    
    public function actionSetting() {
          $this->check_permission(__CLASS__,'setting');
          $type = Mod::app()->request->getParam('type', 'base');//request
//         Mod::app()->clientScript->registerCssFile(Mod::app()->baseUrl.'/css/my.css');  
//         Mod::app()->clientScript->registerScriptFile(Mod::app()->baseUrl.'/css/my.js');  
//         Mod::app()->request->getParam('type', 'base');//request
//         Mod::app()->request->getQuery('type', 1);//get
//         Mod::app()->request->getPost('type', 1);//post
//         在view中得到当前controller的ID方法 ：Mod::app()->getController()->id;      
//         在view中得到当前action的ID方法 ：Mod::app()->getController()->getAction()->id;     
//         yii获取ip地址 ：Mod::app()->request->userHostAddress;   
//         yii判断提交方式 ：Mod::app()->request->isPostRequest  
//         得到当前域名: Mod::app()->request->hostInfo   
//         得到proteced目录的物理路径 ：Mod::app()->basePath;     
//         获得上一页的url以返回 ：Mod::app()->request->urlReferrer;  
//         得到当前url ：Mod::app()->request->url;  
//         得到当前home url ：Mod::app()->homeUrl  
//         得到当前return url ：Mod::app()->user->returnUrl 
//         项目路径 ：dirname(Mod::app()->BasePath) 
//         项目目录 Mod::app()->request->baseUrl

           if($_POST){
                $systemArr = array('site_title','site_keywords','site_description','site_code','site_logo','site_template','site_home','site_beian','site_safe_code');
                $setting_model = new Setting();
                $res = $setting_model->findAll("lang=:lang",array(":lang"=>$this->lang));   
                foreach ($res as $key => $value) {
                     $setting[$value->name] = $value->attributes;
                }
                foreach($_POST as $key=>$val){
                        $issystem = in_array($key,$systemArr)?1:0;
                        if(isset($setting[$key])){
                               $count =$setting_model->updateAll(array('value'=>addslashes($val),'issystem'=>$issystem),'name=:name and lang=:lang',array(':name'=>$key,':lang'=>$this->lang));           
                        }else{
                               Mod::app()->db->createCommand()->insert('{{setting}}',array('name'=>$key,'value'=>addslashes($val),'type'=>'base','issystem'=>$issystem,'lang'=>$this->lang));         
                        }
                }
                  MyCache::flush(); 
                  $target_url = $this->_adminUrl.'/setting';
                  $this->admin_message('操作成功', $target_url);
           }else{
                  $data =$where= array();
                  //获取配置信息
                  $result  = Setting::model()->findAll(array('condition'=>'type=:type and lang=:lang', 'params'=>array(':type'=>$type,'lang'=>$this->lang)));        
                  foreach($result as $k=>$v){
                             $data['setting'][$v->name] = $v->attributes;
                  }
                  
           
		$this->renderPartial('index',$data);
           }
    }
    
    public function actionUcenter() {
        $this->actionSetting();
    }
}

