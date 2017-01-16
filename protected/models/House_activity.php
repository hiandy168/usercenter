<?php

class House_activity extends CActiveRecord {
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
        return '{{house_activity}}';
    }

    /**
     * @return array relational rules.
     */
   /* public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'house_money'=>array(self::BELONGS_TO, 'house_money', 'financingid'),
        );
    }*/



}
