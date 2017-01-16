<?php

class SendmsgController extends AController {
    
    public function actionIndex() {
        
        $this->render('send_msg');
      
    }
    
    public function actionSendlist(){
        
        $this->render('send_list');
    }
    
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
       $model = new Ads();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
        $type_id = Mod::app()->request->getParam('type_id', 0);
        if(isset($type_id)&& $type_id){
           $criteria->addCondition("t.type_id=".intval($type_id));
           $data['type_id'] = intval($type_id);
        }
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
        $type_model = new Type();
        $type_result = $type_model->findAll("lang ='" . $this->lang . "' and type = 'ads'   and status = 1");
        foreach ($type_result as $c) {
            $data['type_arr'][$c->id] = $c->attributes;
        }
        unset($c);
            
        $this->render('ads', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if( !empty($_POST) ){
               $model = new Ads;
               $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->createtime = time();
                $model->lang = $this->lang;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/ads/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request
   
             //分类
            $type_model = new Type();
            $type_result = $type_model->findAll("lang ='" . $this->lang . "' and type = 'ads'   and status = 1");
            foreach ($type_result as $c) {
                $data['type_arr'][$c->id] = $c->attributes;
            }
            unset($c);
 
            $data['fun'] = 'add';
            $this->render('ads_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval( isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Ads::model()->findbypk($id);
        if(Mod::app()->request->isPostRequest){
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                if($model->save()){
                    $target_url = $this->createUrl('/admin/ads/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';
            
 
            //分类
            $type_model = new Type();
            $type_result = $type_model->findAll("lang ='" . $this->lang . "' and type = 'ads'   and status = 1");
            foreach ($type_result as $c) {
                $data['type_arr'][$c->id] = $c->attributes;
            }
            unset($c);
        


            $this->render('ads_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
 
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Ads;
                $res = $model->deleteAll( 'id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }
     
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

   public function actionOrder() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Tool::getValidParam('id','string');
        $order_str = Tool::getValidParam('order','string');
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Ads;
            $res = $model->order_bat($id_arr, $order_arr);
            if ($res) {
                $mess = '更新成功！';
                $state = 1;
            } else {
                $mess = '更新失败！';
                $state = 0;
            }
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
