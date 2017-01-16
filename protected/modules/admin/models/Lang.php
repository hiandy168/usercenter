<?php

class Lang extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{lang}}';
    }

    public function rules() {
        return array(
		    );
    }
    
    static public function setLang($type, $lang) {
        Mod::app()->session[$type . '_lang'] = $lang;
    }
    
    static public function getLang($type='admin') {
        $lang = Mod::app()->session[$type . '_lang'];
        if(!$lang){
            $lang = 'zh_cn';
            self::setLang($type,$lang);
        }
        return $lang;
    }

}
