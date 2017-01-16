<?php

class Membergroup extends CActiveRecord {

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
        return '{{membergroup}}';
    }

    public function rules() {
      return array(
			array('name,description,status,admin,order', 'safe'),
		);
    }

}
