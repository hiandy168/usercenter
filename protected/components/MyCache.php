<?php
/**
 * @author        wenlijiang 5367604@qq.com
 * @link          http://www.9open.com
 * @version       v1.0
 */
class MyCache {

    public static function getCache_type(){
       $cache_type = 'memcache';
//        if(!$cache_type){
//             $lang = MyLang::getLang('front');//获取当前语言版本
//             $result  = Setting::model()->find("type='cache' and lang ='".$lang."'");   
//            if(!empty($result)){ 
//                $cache_type = $result['value'];
//            }else{
//                $cache_type = 'filecache';
//            }
//            Mod::app()->session['cache_type'] = $cache_type;
//        }
        return $cache_type;
    }  

    /* 取缓存*/
    public static function get($key,$cache_type='') {
        !$cache_type && $cache_type = self::getCache_type();
        $value = Mod::app()->$cache_type->get($key);
        if ( $value === false ) 
            return '';
         else 
            return $value;
    }

    /* 设置缓存*/
    public static function set( $key = '', $data = '', $expirse = 3600,$cache_type='') {
       !$cache_type && $cache_type = self::getCache_type();
       return Mod::app()->$cache_type->set( $key, $data, mt_rand(3600, 7200) );
    }
    
    /* 增加缓存*/
    public static function add( $key = '', $data = '', $expirse = 3600,$cache_type='') {
       !$cache_type && $cache_type = self::getCache_type();
       return Mod::app()->$cache_type->add( $key, $data, mt_rand(3600, 7200)  );
    }
    
     /* 删除缓存*/
    public static function delete($key,$cache_type='') {
       !$cache_type && $cache_type = self::getCache_type();
        return Mod::app()->$cache_type->delete($key);
    }
    
     /* 清除缓存*/
    public static function flush($cache_type='') {
       !$cache_type && $cache_type = self::getCache_type();
        return Mod::app()->$cache_type->flush();
    }


}
