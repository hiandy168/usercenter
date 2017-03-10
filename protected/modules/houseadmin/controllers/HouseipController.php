<?php
class HouseipController extends HaController
{
    /**
     * 白名单列表
     * author  Fancy
     */
    public function actionList(){
        $application_class = House_ip::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'status=:status';
        $criteria->params = array(':status'=>1);
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $ipinfo= $application_class->findAll($criteria);
        $returnData['ipinfo']=$ipinfo;
        $returnData['pages'] = $pages;
        $this->render('list',$returnData);
    }

    /**
     * 添加白名单
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_ip::model();
        $imginfo = null;
        if(!empty($id)){
            $imginfo = $house_model->findByPk($id);
            if(empty($imginfo) || $imginfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_ip();
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
            $house_model -> author = $admininfo['name'];
            $house_model -> authorid = $admininfo['id'];
            if($house_model->save()){
                Tool::alertpop('操作成功','/houseadmin/houseip/list/');
            }

        }
        $viewData['imginfo'] = $imginfo;
        $this->render("add",$viewData);
    }


    /**
     * 删除白名单
     * author  Fancy
     */
    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $houseInfo = House_ip::model()->find('id=:id', array(':id'=>$id));
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

    /**
     * 白名单
     * author  Fancy
     */
    /**
     * 发布状态
     * author  Fancy
     */
    public function actionChangestatus(){
        $id =Tool::getValidParam('id','integer');
        $enable =Tool::getValidParam('enable','integer');
        $admininfo  = Mod::app()->session['admin_user'];
        $group_id=$admininfo['group_id'];
        if($group_id==1){
            $houseInfo = House_ip::model()->find('id=:id', array(':id'=>$id));
        }else{
            $houseInfo = House_ip::model()->find('id=:id and authorid=:authorid', array(':id'=>$id,':authorid'=>$admininfo['id']));
        }

        if(!empty($houseInfo)){
            if($enable==1){
                $houseInfo->enable = 1;
            }elseif($enable==2){
                $houseInfo->enable = 2;
            }
            else{
                echo "error";
            }
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }else{
            echo "error";
            die();
        }
        echo $returnData;
    }



}