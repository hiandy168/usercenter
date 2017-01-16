<?php

class Article extends CActiveRecord {


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
        return '{{article}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
         //   array('category_id,title,keywords,description,content,copyfrom,auther,picture,tpl,order,status', 'safe'),
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
        $sql  = "UPDATE {{article}} SET `hits`=`hits`+".$num." WHERE `id`=".$id;
        return $res = Mod::app()->db->createCommand($sql)->execute();  
    }

    //活动列表带分页
    public function getArticleListPager(){
        $as_list = array();
        $list = null;
        $asModel = new Article;
        $criteria = new CDbCriteria();
        $criteria->order = 'createtime DESC';
        $criteria->condition ='status=1';
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
