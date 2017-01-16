<?php

class Activity_vote_join extends CActiveRecord {

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
        return '{{activity_vote_join}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vote'=>array(self::BELONGS_TO, 'Activity_vote', '', 'on'=>'t.voteid=vote.id')
        );
    }

    //活动列表带分页
    public function getVoteListPager($vid,$votename="",$whojoins=""){


        $as_list = array();
        $list = null;
        $asModel = new Activity_vote_join;
        $criteria = new CDbCriteria();
        if((!empty($votename)&&$whojoins!="null")||$whojoins===0||$whojoins==1){
            $criteria->condition = 'voteid=:voteid and status=:status and title like :title and whojoin=:whojoin';
            $criteria->params = array(':voteid'=>$vid,':status'=>1,':title'=>'%'.$votename.'%',':whojoin'=>$whojoins);
        }elseif($whojoins=="null"){
            $criteria->condition = 'voteid=:voteid and status=:status and title like :title';
            $criteria->params = array(':voteid'=>$vid,':status'=>1,':title'=>'%'.$votename.'%');
        }else{
            $criteria->condition = 'voteid=:voteid and status=:status';
            $criteria->params = array(':voteid'=>$vid,':status'=>1);
        }
        $criteria->order = 'create_time DESC';
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
