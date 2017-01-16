<?php

class Member_message extends CActiveRecord {

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
        return '{{member_message}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mid,pid,title,content','safe')
        );
    }
     
    // 发送用户消息
    public static function snedMessage($pid,$mid,$title,$content){           
       $result = array('result'=>null,'status'=>0);
       if(!empty($pid) && !empty($mid) && !empty($title) && !empty($content)){
           $memsgModel = new Member_message;
           $memsgModel->pid = $pid;
           $memsgModel->mid = $mid;
           $memsgModel->title = $title;
           $memsgModel->content = $content;
           $memsgModel->sendTime = time();
           
           if($memsgModel->save()){
               $result['result'] = '发送成功';
               $result['status'] = 1;
           }
       }
       
       return $result;
               
    }        
    
    
}
