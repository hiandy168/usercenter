<?php

class TokenController extends FrontController {
        
    public function Init(){
        header("Content-Type: text/html; charset=UTF-8");
    }
    
    /**
     *获取access_token
     */
   public function actionGet(){

        $appid =  Tool::getValidParam('appid', 'string');
        $sign =  Tool::getValidParam('sign', 'string');
        $timestamp =  Tool::getValidParam('timestamp', 'string');
        $grant_type = Tool::getValidParam('grant_type','string');
         if($grant_type!='client_credential'){//客户端证书
            $returnCode['code'] = '40003';//grant_type请求参数错误
            echo json_encode($returnCode);die;
       }
       $project_info = Project::model()->findByAttributes(array('appid'=>$appid))->attributes;

        $params=array("appid"=>$appid,"appsecret"=>$project_info['appsecret'],"timestamp"=>$timestamp,'grant_type'=>'client_credential');
        $params['sign'] = $sign;
        
        // echo "sign1: ".md5($sign)."<br>sign2: <br>";
        $res  = Tool::signVerify($project_info['appsecret'],$params);

        //验证$sgin失效验证
        if(!$res){
            //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40005;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);

            echo urldecode(json_encode($returnCode));exit;
        }
       //根据timestamp验证$sgin  5分钟失效验证
        if(($timestamp/1000 +300) < time()){
             //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40006;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);
            echo urldecode(json_encode($returnCode));exit;
        }
       

       
       //验证appid,appsecret是否合法
       if($project_info){
            if(!Mod::app()->memcache->get("project_access_token_".$project_info['id'])){
               $expires_in = mt_rand(86400, 100000);
               $str = Tool::getrandtoken($project_info['id']);
               Mod::app()->memcache->set($str, $project_info['id'], $expires_in - 100);//通过access_token设置project_id;
               Mod::app()->memcache->set('project_access_token_' . $project_info['id'], $str, $expires_in - 100);//设置access_token
               Mod::app()->memcache->set('project_access_token_time' . $project_info['id'], $expires_in, $expires_in - 100);//设置access_token
            }else{
                $str=Mod::app()->memcache->get("project_access_token_".$project_info['id']);
                $expires_in=Mod::app()->memcache->get("project_access_token_time".$project_info['id']);
            }
            $returnCode['code'] = 200;
            $returnCode['access_token'] = $str;
            $returnCode['expires_in'] = $expires_in;    //凭证有效时间，单位：秒       
       }else{
           $returnCode['code'] = '40001';//appid或者appsecret错误
       }


        
       echo json_encode($returnCode);    
   }
  
  
  
   
}
