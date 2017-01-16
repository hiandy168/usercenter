<?php

class Application_tag extends CActiveRecord {
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
        return '{{application_tag}}';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'application_class'=>array(self::BELONGS_TO, 'Application_class', '', 'on'=>'t.classid=application_class.id')
        );
    }
}
