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
            //array('fid,name,alias,model,title,keywords,description,picture,content,tpl_list,tpl_detail,pagesize,status,order', 'safe'),
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

        function message_read($pid,$mid,$msgid){
            $sql="select * from {{message_read}} where pid=".$pid." AND mid=".$mid." AND msgid=".$msgid;

            $re=Mod::app()->db->createCommand($sql)->queryRow();
            if($re){
                return true;
            }
            return false;
        }
    
         

}
