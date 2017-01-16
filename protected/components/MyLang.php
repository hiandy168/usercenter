<?php
/**
 * @author        wenlijiang 5367604@qq.com
 * @link          http://www.9open.com
 * @version       v1.0
 */
class MyLang {

    static public function getLang($type='admin') {
        $lang = Mod::app()->session[$type . '_lang'];
        if(!$lang){
            $lang = 'zh_cn';
            self::setLang($type,$lang);
        }
        return $lang;
    }
    
    static public function setLang($type, $lang) {
        Mod::app()->session[$type . '_lang'] = $lang;
    }
        

}
