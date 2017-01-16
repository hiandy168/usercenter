<?php

class Member_activity extends CActiveRecord {

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
        return '{{member_activity}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mid,pid,aid,model,createtime', 'safe'),
        );
    }
    public function relations()
    {
        return array(
            'Member'=>array(self::BELONGS_TO, 'Member', 'mid'),
        );
    }

    
    //活动列表带分页
    public function getMemberListPager($where="",$params=array()){
        $as_list = array();
        $list = null;
        $asModel = new Member_activity;
        $criteria = new CDbCriteria();
        $criteria->condition =$where;
        $criteria->params =$params;
        $criteria->with ="Member";
        $criteria->order = 't.id DESC';
        $count = $asModel->count($criteria);
         $pages = new CPagination($count);
          $pages->pageSize = 20;
          $criteria->limit = $pages->pageSize;
          $criteria->offset = $pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;
        $as_list['pagebar'] = $pages;
        $as_list['criteria'] = $asModel->findAll($criteria);
        return $as_list;
    }


/*request = Mod::app()->request;
$adModel = Ad::model();
$criteria = new CDbCriteria();
$criteria->order = 't.ctime DESC';
$name = trim($request->getParam('name'));
$criteria->condition = 't.name like :name';
$criteria->params = array(':name'=> '%'.$name.'%');
$criteria->order = 't.is_pass ASC, t.ctime DESC';
$count = $adModel->count($criteria);
$pages = new CPagination($count);
$pages->pageSize = 10;
$pages->applyLimit($criteria);
$returnData['adList'] = $adModel->with('user')->with('typeSize')->findAll($criteria);
$returnData['pages'] = $pages;
$returnData['name'] = $name;
$this->render('adList',$returnData);*/




}
