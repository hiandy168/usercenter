<?php

class Pic extends CActiveRecord {

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
        return '{{pic}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id,title,keywords,description,content,picture,tpl,order,status', 'safe'),
        );
    }
    
    public function relations()
    {
        return array(
//            'membergroup'=>array(self::HAS_ONE, 'membergroup', 'group_id'),
            'Pictures'=>array(self::HAS_MANY, 'Picture', 'pid'),
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
        $sql  = "UPDATE {{pic}} SET `hits`=`hits`+".$num." WHERE `id`=".$id;
        return $res = Mod::app()->db->createCommand($sql)->execute();  
    }
        
    
         

}
