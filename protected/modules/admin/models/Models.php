<?php

class Models extends CActiveRecord {

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
        return '{{model}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,table,order,status', 'safe'),
        );
    }
    
    public function relations()
    {
        return array(
//            'membergroup'=>array(self::HAS_ONE, 'membergroup', 'group_id'),
            'membergroup'=>array(self::BELONGS_TO, 'membergroup', 'group_id'),
        );
    }
    
        
   
}
