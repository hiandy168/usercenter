<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:03
 */

class HmoneyController extends HaController{

    /**
     * 理财列表页
     * author  Fancy
     */

    public function actionList(){
        $member=Mod::app()->session['admin_user'];
        $application_class = House_money::model();
        $criteria = new CDbCriteria();
        if(Mod::app()->request->isPostRequest) {
            $type =Tool::getValidParam('type','string');
            //$createtime =strtotime(Tool::getValidParam('createtime','string'));
            $title =Tool::getValidParam('title','string');
            if(empty($type)&&empty($title)){
                $criteria->condition = 'authorid=:authorid and status=:status';
                $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
            }elseif(empty($type)&&$title){
                $criteria->condition = 'authorid=:authorid and status=:status and (title like :title or author like :author or id like :id)';
                $criteria->params = array(':authorid'=>$member['id'],':status'=>1,":title"=>'%'.$title.'%',":author"=>'%'.$title.'%',":id"=>'%'.$title.'%');
            }elseif($type&&empty($title)){
                $criteria->condition = 'authorid=:authorid and status=:status and type=:type';
                $criteria->params = array(':authorid'=>$member['id'],'type'=>$type,':status'=>1);

            }elseif($type&&$title){
                $criteria->condition = 'authorid=:authorid and status=:status and type=:type and (title like :title or author like :author or id like :id)';
                $criteria->params = array(':authorid'=>$member['id'],':status'=>1,'type'=>$type,":title"=>'%'.$title.'%',":author"=>'%'.$title.'%',":id"=>'%'.$title.'%');

            }
        }else{
            $criteria->condition = 'authorid=:authorid and status=:status';
            $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
        }
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        $returnData['moneylist']= $application_class->findAll($criteria);
        $returnData['pages'] = $pages;
        $returnData['type'] = $type;
        $returnData['title'] = $title;
        $this->render('list',$returnData);
    }
    /**
    * 添加理财活动
    * author  Fancy
    */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_money::model();
        $houseinfo = null;
        if(!empty($id)){
            $houseinfo = $house_model->findByPk($id);
            if(empty($houseinfo) || $houseinfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_money();
                $house_model -> createtime = time();
            }
            $data = $_POST;
            foreach($data as $k=>&$value){
                $value=Safetool::SafeFilter($value);
            }
            foreach($data as $_k => $_v){
                $house_model -> $_k = $_v;
            }
            $house_model -> updatetime = time();
            $house_model -> authorid = $admininfo['id'];
            $house_model -> author = $admininfo['name'];
            if($house_model->save()){
                Tool::alert('操作成功','/houseadmin/hmoney/list');
            }
        }
        $viewData['houseinfo'] = $houseinfo;
        //var_dump($viewData['houseinfo']);
        $this->render("add",$viewData);
    }

    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $houseInfo = House_money::model()->find('id=:id', array(':id'=>$id));
        if(!empty($houseInfo)){
            $houseInfo->status = 2;
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }
        echo $returnData;
    }



}