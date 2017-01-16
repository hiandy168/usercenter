<?php

class NoticeController extends HaController {

    public function actionIndex() {


                if(@class_exists('Memcache')) {
                          $memcache=@new Memcache;
                          if(!@$memcache->connect(Mod::app()->memcache->servers[0]->host, Mod::app()->memcache->servers[0]->port)){
                              $data['memcache'] =  '不支持';
                          }else{
                              $data['memcache'] =  '支持';
                          }
                }else{
				        $data['memcache'] =  '不支持';
				}
              
        
                $data['mysql_version']  =  Mod::app()->db->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
                $GDSupport =  $this->checkGDSupport();
                $data['gd'] = !empty($GDSupport)?'是':'否';

     
               $data['member_info']  = Mod::app()->session['admin_user'];

                $cache_type = $this->cache_type;
               //获取用户分组数据
               $group_key  =  'cache_group'; 
               $data['group'] =Mod::app()->$cache_type->get($group_key);  
                if($data['group']===false  || empty($data['group']))  
                {  
                    $data['group'] = Tool::change_array_index(Membergroup::model()->findAll());
                    Mod::app()->$cache_type->set($group_key,$data['group']);  
                }  
                
               
                
                $this->renderPartial('index',$data);
    }

     
        public function checkGDSupport(){
            if(!function_exists("gd_info")){
                    return false;
            }else {
                    if(function_exists("ImageCreateFromGIF")) $return[] =  'GIF';
                    if(function_exists("ImageCreateFromJPEG")) $return[] = 'JPEG';
                    if(function_exists("ImageCreateFromPNG")) $return[] =  'PNG';
                    if(function_exists("ImageCreateFromWBMP")) $return[] =  'WBMP';
                    return $return;
            }
        }
}
