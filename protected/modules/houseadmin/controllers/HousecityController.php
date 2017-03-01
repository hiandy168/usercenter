<?php
class HousecityController extends HaController
{

    /**
     * 城市列表
     * author  Fancy
     */
    public function actionList(){
        $application_class = House_city::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'status=:status';
        $criteria->params = array(':status'=>1);
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $cityinfo= $application_class->findAll($criteria);
        $returnData['housecity']=$cityinfo;
        $returnData['pages'] = $pages;
        $this->render('list',$returnData);
    }


    /**
     * 添加城市
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_city::model();
        $cityinfo = null;
        if(!empty($id)){
            $cityinfo = $house_model->findByPk($id);
            if(empty($cityinfo) || $cityinfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_city();
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
                Tool::alertpop('操作成功','/houseadmin/housecity/list');
            }
        }
        $viewData['cityinfo'] = $cityinfo;
        $this->render("add",$viewData);
    }

    /**
     * 删除城市
     * author  Fancy
     */

    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $houseInfo = House_city::model()->find('id=:id', array(':id'=>$id));
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
