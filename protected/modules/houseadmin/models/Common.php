<?php

class Common extends CActiveRecord {
    public   $table;

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
        return '{{'.$this->table.'}}';
    }

    
    public function set_table($table_name='') {
       $this->table = $table_name;
    }

}
