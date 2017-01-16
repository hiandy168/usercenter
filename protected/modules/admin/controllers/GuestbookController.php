<?php

class GuestbookController extends AController {

    public function actionIndex() {
        $this->actionLists();
    }
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $model = new Guestbook();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
        if(isset($_REQUEST['category_id'])&& $_REQUEST['category_id']){
           $data['category_id'] = isset($_REQUEST['category_id'])?trim($_REQUEST['category_id']):'';
           $criteria->addCondition("t.category_id=".intval($_REQUEST['category_id']));
           $data['category_id'] = intval($_REQUEST['category_id']);
        }
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $data['pagebar'] = $pages ;
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        
         //获取留言板栏目
        $categorymodel =  Category::model()->findAll("lang=:lang and model = 'guestbook'",array(":lang"=>$this->lang));
        foreach($categorymodel as $c){
                $data['categoryarr'][$c->id] = $c->attributes;
        }
            


        $this->render('guestbook', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if( !empty($_POST) ){
            $model = new Guestbook;
                $model->attributes = $data = $_POST;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/guestbook/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request


            $data['fun'] = 'add';
            $this->render('guestbook_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval( isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Guestbook::model()->findbypk($id);
        if( !empty($_POST) ){
                $model->attributes  = $_POST;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/guestbook/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';
            
    


            $this->render('guestbook_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Guestbook;
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
        $id_str = $_POST['id'];
        $order_str = $_POST['order'];
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Guestbook;
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
