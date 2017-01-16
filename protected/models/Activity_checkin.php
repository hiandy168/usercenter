<?php

class Activity_checkin extends CActiveRecord {

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
        return '{{activity_checkin}}';
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
        $asModel = new Activity_checkin;
        $criteria = new CDbCriteria();
        $criteria->order = 'add_time DESC';
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
    
    /**
     * 根据活动开始时间和结束时间判断活动状态
     * @param type $starTime
     * @param type $endTime
     * @param type $status
     * @return string
     */
    public static function activityStatus($starTime,$endTime){
        $returnCode = array('status'=>0,'message'=>'');
        $nowTime = time();
        if($endTime <= $nowTime){
            $returnCode['status'] = 0;
            $returnCode['message'] = '已结束';
        }else{
            if($starTime > $nowTime){
                $returnCode['status'] = -1;
                $returnCode['message'] = '未开始';
            }else{
                $returnCode['status'] = 1;
                $returnCode['message'] = '进行中';
            }
        }
        if($status==1){
            return $returnCode['message'];
        }else{
            return $returnCode;
        }
    }

}
