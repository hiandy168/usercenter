<?php

class Application_class extends CActiveRecord {
        public $aid;
        public $type;
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
        return '{{application_class}}';
    }


        
    
         

}
