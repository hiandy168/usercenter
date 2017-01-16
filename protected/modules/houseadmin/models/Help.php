<?php

class Help extends CActiveRecord {

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
        return '{{help}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }

    function order_bat($ids,$res){
        $num = count($ids);
        $data = array();
        for($i=0;$i<$num;$i++){
                $data[] = array('id'=>$ids[$i],'order'=>$res[$i]);
                $count =$this->updateByPk($ids[$i],array('order'=>$res[$i])); 
        }
 
        return true;
    }
    
      function add_hits($id,$num = 1){
        $sql  = "UPDATE {{page}} SET `hits`=`hits`+".$num." WHERE `id`=".$id;
        return $res = Mod::app()->db->createCommand($sql)->execute();  
    }
        
    
         

}
