<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TestController extends FrontController{
 
    protected $appid;
    protected $appkey;
    protected $openid;


    public function init() {
        $this->appid = '101518';
        $this->appkey = '9e4638e0b047cabc';
        $this->openid ='ojIMLt_6xMWICbFraFD-S3_ZXEow';
        
        header("Content-Type: text/html; charset=UTF-8");
    }
    
    public function actionTag(){
        echo "开发中";exit;
         require_once '/dachu/api.php';  
         $winning = '中小米note3';
         $url='http://m.dachuw.net/geturl/1_hx/0112';
         $winpc='http://m.dachuw.net/geturl/1_hx/0112/11023.jpg';
         $api = new api($this->appid, $this->appkey, $this->openid,'http://tt.dachuw.net');
         $api->tag($winning, $url, $winpc);
    }
    
    public function actionActivity(){
        echo "开发中";exit;
         require_once '/dachu/api.php';  
         $activity_title = '特价机票'. mt_rand(100, 999);
         $activity_url='http://m.dachuw.net/activity/ac_01/a0211';
         $activity_pic='http://m.dachuw.net/activity/ac_01/a0211/a11022.jpg';
         $api = new api($this->appid, $this->appkey, $this->openid,'http://tt.dachuw.net');
         $api->activity($activity_title, $activity_url, $activity_pic);
    }    
    public function actionIndex(){
        echo "开发中";exit;
        echo $this->createurl('/project/appMgt');
        echo '<hr>';
        echo Mod::app()->request->getHostInfo();
        echo '<hr>';
        echo Mod::app()->baseUrl;
        
    }


    public function actionScandir($dir="D:/www/dachuwang/themes/new/views/activity")
    {
        $files = array();
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {
                while (($file = readdir($handle)) !== false) {
                    if ($file != "." && $file != "..") {
                        if (is_dir($dir . "/" . $file)) {
                            $files[$file] = $this->actionScandir($dir . "/" . $file);
                        } else {
                            $url =$dir . "/" . $file;
                            if (preg_match ("http://", file_get_contents($url), $m))
                            {
                                var_dump($m);exit;
                            }
                            echo  $dir . "/" . $file."<br/>";
                        }
                    }
                }
                closedir($handle);
//                var_dump($files)  ."<br/>";
            }
        }
    }

    
}
