<?php

class CityLifeController extends AController {

    public function actionIndex(){
           $this->actionlists();
    }

    public function actionCateDel()
    {
        $this->check_permission(__CLASS__,'cateDel');

        $id = Mod::app()->request->getParam('id');
        $res = CityLifeCategory::model()->deleteByPk($id);
        if($res){
            exit(json_encode(array('state'=>'1','mess'=>'删除成功')));
        }else{
            exit(json_encode(array('state'=>'0','mess'=>'删除失败')));
        }
    }

    public function actionCategory()
    {   
        $this->check_permission(__CLASS__,'category');
        $id = Mod::app()->request->getParam('id');
        $model = new CityLifeCategory();
        if($_POST) {
           // var_dump($_POST);exit;
            $data['name'] = Mod::app()->request->getParam('name');
            $data['position'] = Mod::app()->request->getParam('position');
            $data['status'] = Mod::app()->request->getParam('status');

            $action = Mod::app()->request->getParam('action');
//            var_dump($action);exit;
            $target_url = $this->createUrl('/admin/citylife/cateList');
            if ($action == 'add') {
                $data['createtime'] = time();
                $model->attributes = $data;
//                var_dump($model->attributes);exit;
                if ($model->save()) {
                    $mess = '添加成功';
                }else{
                    $mess = '添加失败';
                }
            }else{
                $data['updatetime'] = time();
                $model = CityLifeCategory::model()->findByPk($id);
                $model->attributes = $data;
                if($model->save()){
                    $mess = '修改成功';
                }else{
                    $mess = '修改失败';
                }
            }
            $this->admin_message($mess, $target_url);
        }
        $model = CityLifeCategory::model()->findByPk($id);
        $this->render('category',array('fun'=>'category','model'=>$model));

    }

    public function actionCateList()
    {
        $this->check_permission(__CLASS__,'cateList');

        $model = new CityLifeCategory();
        $criteria = new CDbCriteria();

        $criteria->order = 'id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $list = $model->findAll($criteria);

        $this->render('cateList',array('pagebar'=>$pages,'list'=>$list));
    }


    public function actionLists()
    {
        $this->check_permission(__CLASS__,'lists');

        $where = array();
        $model = new CityLife();
        $criteria = new CDbCriteria();
        
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        if(isset($data['type_id'])){
            $pages->params=array('type_id'=>$data['type_id']);
        }
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $data['pagebar'] = $pages ;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        //分类
        $type_model = new CityLife();
        $type_result = $type_model->findAll();

        foreach ($type_result as $c) {
            $data['type_arr'][$c->id] = $c->attributes;
        }
        unset($c);
        $this->render('citylife', $data);
    }

    public function actionAdd ()
    {
        $this->check_permission(__CLASS__,'add');
        $model = new CityLife('create');
        $cates = CityLifeCategory::model()->findAll();
        if( isset($_POST)){
                $model->name = Mod::app()->request->getParam('name');
                $model->cateid = Mod::app()->request->getParam('cateid');
                $model->url = Mod::app()->request->getParam('url');
                $model->icon = Mod::app()->request->getParam('icon');
                $model->position = Mod::app()->request->getParam('position');
                $model->createtime = time();
                $model->updatetime = time();
                $model->status = Mod::app()->request->getParam('status');
                if($model->save()){
//                    var_dump($model->attributes);exit;
                    $target_url = $this->createUrl('/admin/citylife/lists');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }
        $this->render('citylife_edit', array ('cates'=>$cates,'model' => $model,'fun'=>'add'));
    }

    /**
     * 管理员编辑
     *
     * @param  $id
     */
    public function actionEdit ()
    {
        $this->check_permission(__CLASS__,'edit');
        $data['id'] = Mod::app()->request->getParam('id');
        $model = CityLife::model()->findByPk($data['id']);
        $cates = CityLifeCategory::model()->findAll();
        if( $data['id'] && !empty($_POST)){
            $model->name = Mod::app()->request->getParam('name');
            $model->cateid = Mod::app()->request->getParam('cateid');
            $model->url = Mod::app()->request->getParam('url');
            $model->icon = Mod::app()->request->getParam('icon');
            $model->position = Mod::app()->request->getParam('position');
            $model->updatetime = time();
            $model->status = Mod::app()->request->getParam('status');
            if($model->save()){
                $target_url = $this->createUrl('/admin/citylife/');
                $this->admin_message('修改成功', $target_url);
                exit();
            }
        }
//        var_dump($model);exit;
        $this->render('citylife_edit', array ('cates'=>$cates,'model' => $model,'fun'=>'edit'));
    
    }

    public function actionDel(){
            $this->check_permission(__CLASS__,'del');
            $id_str = Mod::app()->request->getParam('id');
            $id_arr =  explode(',', $id_str);
//            file_put_contents('/text.txt', var_export($id_arr, 1));
            if(in_array(1,$id_arr)){
                 $mess = '删除失败！超级分组不允许被删除！';
                 $state = 0;
            }else{
                if($id_arr && !empty($id_arr)){ 
                     $res='';
                     $model = new CityLife();
                    $res = $model->deleteAll( 'id IN(' . $id_str . ')');
                     if($res){
                         $mess = '删除成功！';
                         $state = 1;
                     }else{
                         $mess = '删除失败！';
                         $state = 0;
                     }
                }
            }
            echo json_encode(array('state'=>$state,'mess'=>$mess));
	}
}

