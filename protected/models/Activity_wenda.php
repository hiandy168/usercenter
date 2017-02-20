<?php

class Activity_wenda extends CActiveRecord {

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
        return '{{activity_wenda}}';
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
        $asModel = new Activity_wenda;
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
    public static function activityStatus($starTime,$endTime,$id){

        $returnCode = array('status'=>0,'message'=>'');
        $re=Activity_wenda::model()->findByPk($id);
        if($re){
            if($re->status==0){
                $returnCode['status'] = 2;
                $returnCode['message'] = '暂停中';
            }else{
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
                }}
        }
        if($status==1){
            return $returnCode['message'];
        }else{
            return $returnCode;
        }
    }
    /**
     * @author yuwanqiao
     * 根据用户的userid或openid获取用户当天剩余的刮奖的次数
     */
    public static function getNum($id,$userid,$openid,$day_count){
        //判断客户端提交用户userid或openid 查询用户当天已经刮奖剩余的次数
        if($userid || $openid){
            $time = strtotime(date('Y-m-d',time()));
            if($openid) {
                $sql = "SELECT count(*) FROM dym_activity_bigwheel_user WHERE time > $time and bigwheel_id='" . $id . "' and openid='" . $openid . "'";
            }else if($userid){
                $sql = "SELECT count(*) FROM dym_activity_bigwheel_user WHERE time > $time and bigwheel_id='" . $id . "'  and  mid= '" . $userid . "'";
            }
            $count=Mod::app()->db->createCommand($sql)->queryRow();
            //return $count;
            $count=$count['count(*)'];
            $num = $day_count-$count;
            if($num <=0 ){
                return 0;
            }else{
                return $num;
            }
        }else{
            return 0;
        }
    }
}
