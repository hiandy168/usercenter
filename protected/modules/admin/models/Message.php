<?php

class Message extends CActiveRecord {

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
        return '{{message}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }
      public function insertAll($data) {
    	$sql = "insert into ".$this->tableName()." %s VALUES %s";
    	$sqlValue = '';
    	foreach($data as $k => $value) {
    		$keys = array_keys($value);
    		foreach ($value as $key=>$val){
    			$sqlValue.= "'$val',";
    		}
    		$sqlValue = substr($sqlValue, 0, -1);
    		$sqlV[] = "(".$sqlValue.")";
    		$sqlValue='';
    	}
    	
    	$keys = '('.join(',', $keys).")";
    	$sqlVs = join(',', $sqlV);
    	$sql = sprintf($sql, $keys, $sqlVs);
    	return Mod::app()->db->createCommand($sql)->execute();
    	 
    }
    
   
    
        
   
}
