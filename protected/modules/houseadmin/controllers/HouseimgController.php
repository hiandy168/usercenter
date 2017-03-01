<?php
class HouseimgController extends HaController
{
    /**
     * 对应城市幻灯片列表
     * author  Fancy
     */
    public function actionList(){
        $id =Tool::getValidParam('id','integer');
        $application_class = House_img::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'status=:status and city=:city';
        $criteria->params = array(':status'=>1,':city'=>$id);
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $cityinfo= $application_class->findAll($criteria);
        foreach($cityinfo as $k=>$v){
            $sql = "SELECT city as city FROM {{house_city}} WHERE status=1 and id=".$v['city'];
            $city=Mod::app()->db->createCommand($sql)->queryRow();
            $cityinfo[$k]['city']=$city['city'];
        }
        $returnData['housecity']=$cityinfo;
        $returnData['pages'] = $pages;
        $this->render('list',$returnData);
    }

    /**
     * 添加对应城市幻灯片列表
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $city =Tool::getValidParam('city','integer');
        $house_model = House_img::model();
        $imginfo = null;
        if(!empty($id)){
            $imginfo = $house_model->findByPk($id);
            if(empty($imginfo) || $imginfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_img();
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
            if($imginfo){
                $city=$imginfo['city'];
            }else{
                $city=$city;
            }
            if($house_model->save()){
                Tool::alertpop('操作成功','/houseadmin/houseimg/list/id/'.$city);
            }
        }

        $sql = "SELECT id,city FROM {{house_city}} WHERE status=1 and authorid=".$admininfo['id'];
        $city=Mod::app()->db->createCommand($sql)->queryAll();
        $viewData['city'] = $city;
        $viewData['imginfo'] = $imginfo;
        $this->render("add",$viewData);
    }


    /**
     * 删除幻灯片
     * author  Fancy
     */
    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $houseInfo = House_img::model()->find('id=:id', array(':id'=>$id));
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