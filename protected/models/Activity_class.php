<?php

class Activity_class extends CActiveRecord {

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
        return '{{activity_class}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            
        );
    }
    
    //活动列表带分页
    public function getActivityListPager($pid){   
        $as_list = array();
        $list = null;
        $asModel = new Activity_class;
        $criteria = new CDbCriteria();
        $criteria->order = 'createtime DESC';
        $criteria->condition ='pid='.$pid;
        $count = $asModel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;             
        $as_list['pagebar'] = $pages;
        $as_list['criteria'] = $asModel->findAll($criteria); 
        return $as_list;                
    }
    

}
