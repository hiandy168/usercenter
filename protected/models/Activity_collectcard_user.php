<?php

class Activity_collectcard_user extends CActiveRecord {

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
        return '{{activity_collectcard_user}}';
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
            'member'=>array(self::BELONGS_TO, 'Member', '', 'on'=>'t.mid=member.id')
        );
    }


    public static function getPartakeNum($AId){
        $sql = "select count(distinct Mid) as amount from {{activity_collectcardcard_user}} where  FAid=".$AId."";
        $count = Mod::app()->db->createCommand($sql)->queryRow();
        return $count['amount'];
    }


    //活动列表带分页
    public function getUserListPager($id,$is_win="",$search="",$username=""){
        $as_list = array();
        $list = null;
        $asModel = new Activity_collectcard_user;
        $criteria = new CDbCriteria();
        $criteria->order = 'time DESC';
        $criteria->group = 'mid';
        if($is_win==2){

            $criteria->condition ='is_win=0 and collectcard_id='.$id;
        }elseif($is_win==1){
            $criteria->condition ='is_win=99 and collectcard_id='.$id;

        }else{
            if(!empty($search)&&!empty($username)){
                $criteria->condition = 't.collectcard_id =:collectcard_id and t.code like :code and member.username like :username';
                $criteria->params = array(':collectcard_id'=>$id,':code'=> '%'.$search.'%',':username'=>'%'.$username.'%');
            }elseif(!empty($search)&&empty($username)){
                $criteria->condition = 't.collectcard_id =:collectcard_id and t.code like :code';
                $criteria->params = array(':collectcard_id'=>$id,':code'=> '%'.$search.'%');
            }elseif(!empty($username)&&empty($search)){
                $criteria->condition = 't.collectcard_id =:collectcard_id and member.phone like :phone';
                $criteria->params = array(':collectcard_id'=>$id,':phone'=>'%'.$username.'%');
            }else{

                $criteria->condition ='collectcard_id='.$id;
            }
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
