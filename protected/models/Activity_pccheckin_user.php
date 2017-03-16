<?php

class Activity_pccheckin_user extends CActiveRecord {

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
        return '{{activity_pccheckin_user}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }
    
    /**
     * 根据用户的openid和活动id查找用户的签到次数
     */
    public static function getcheckinnum($mid,$pid){
        //查询一条数据
        $sql = "SELECT count(*) FROM dym_activity_pccheckin_user WHERE mid='".$mid."' and pid=$pid";
        $count=Mod::app()->db->createCommand($sql)->queryRow();
        $count=$count['count(*)'];
        return $count;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'member'=>array(self::BELONGS_TO, 'Member', '', 'on'=>'t.mid=member.id')
        );
    }

    //活动列表带分页
    public function getUserListPager($pid,$username){
        $as_list = array();
        $list = null;
        $asModel = new Activity_pccheckin_user;
        $criteria = new CDbCriteria();
        $criteria->order = 't.add_time DESC';
        if(!empty($username)){
//            $criteria->condition ='t.pid='.$pid;
            $criteria->condition = 't.pid =:pid and (member.username like :username or member.name like :username)';
            $criteria->params = array(':pid'=>$pid,':username'=> '%'.$username.'%');
        }else{
            $criteria->condition ='t.pid='.$pid;
        }

        $count = $asModel->with('member')->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;
        $as_list['pagebar'] = $pages;
        $as_list['criteria'] = $asModel->with('member')->findAll($criteria);
        return $as_list;
    }
}
