<?php

class CacherController extends AController {

    public function actionIndex() {
            $this->check_permission(__CLASS__,'index');
            $flush = Mod::app()->request->getParam('flush');//request
            $setting = Mod::app()->request->getParam('setting');//request
            $cache_type = Mod::app()->request->getParam('type');//request
            $target_url = $this->createUrl('/admin/cacher');
            if($setting && $cache_type){
                try {
                     Mod::app()->$cache_type->set('cache_type',$cache_type); 
                     $count =Setting::model()->updateAll(array('value'=>addslashes($cache_type),'issystem'=>1),"name='cache'"); 
                     $this->admin_message('缓存类型变更为'.$cache_type,$target_url);
                } catch (Exception $exc) {
                     $this->admin_message('您的服务器不支持'.$cache_type,$target_url,'10');
                     exit;
                }    
               
            }else if( $flush === 'flush'){
               MyCache::flush(); 
               $this->admin_message('清理成功', $target_url);
            }else{   
                $result  = Setting::model()->find("type='cache' and lang ='".$this->lang."'");   
                if(!$result){
                      $cache_type = 'filecache';
                       Mod::app()->db->createCommand()->insert('{{setting}}',array('title'=>'cache','name'=>'cache','type'=>'cache','value'=>$cache_type,'issystem'=>1,'lang'=>$this->lang));     
                       $data['cache'] = $cache_type;
                }else{
                       $data['cache'] = $result->attributes['value'];
                }
        	$this->renderPartial('index',$data);
            }
    }
    
 
}

