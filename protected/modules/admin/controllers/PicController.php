<?php

class PicController extends AController {

    public function actionIndex() {
        $this->actionLists();
    }

    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $model = new Pic();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "'";
        if (isset($_REQUEST['type_id']) && $_REQUEST['type_id']) {
//            $criteria->addCondition("t.category_id=" . intval($_REQUEST['type_id']));
                $child_category_model = Category::model()->findAll("fid ='" . intval($_REQUEST['type_id']) . "' and lang ='" . $this->lang . "'");
                $child_id_arr =  array();
                $id_arr = array(intval($_REQUEST['type_id']));
                foreach($child_category_model as $c){
                $child_id_arr[] = $c->id;
                }
                if(!empty($child_id_arr)){
                $id_arr = array_merge(array(intval($_REQUEST['type_id'])),$child_id_arr);
                }

                $criteria->addCondition("t.category_id in(".implode(',', $id_arr).")");
        
            $data['type_id'] = intval($_REQUEST['type_id']);
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

        $data['pagebar'] = $pages;


        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        //获取图片栏目
        $categorymodel = Category::model()->findAll("lang=:lang and model = 'pic'",array(":lang"=>$this->lang));
        foreach ($categorymodel as $c) {
            $data['categoryarr'][$c->id] = $c->attributes;
        }

 

        $this->render('pic', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        if (!empty($_POST)) {
            $model = new Pic;
             $data = $_POST;		
           //不能直接把数组给attributes  但是可以单独的给key赋值
            foreach($model->attributes as $k=>$v){
                isset($data[$k]) && $model->$k = $data[$k];
            }
            $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
            $model->createtime = strtotime($data['createtime']);
            $model->keywords = keywords::loadKeywordIds($data['keywords'],$this->lang);
            $model->lang =$this->lang;
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/pic/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {

            $data['fid'] = $fid = Mod::app()->request->getParam('fid'); //request
  
            
            //获取图片
            $picmodel = Models::model()->findAll();
            foreach ($picmodel as $cm) {
                $data['picarr'][] = $cm->attributes;
            }


             //获取图片栏目
        $categorymodel = Category::model()->findAll("lang=:lang and model = 'pic'",array(":lang"=>$this->lang));
        foreach ($categorymodel as $c) {
            $data['categoryarr'][] = $c->attributes;
        }

            $data['fun'] = 'add';
            $this->render('pic_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval( isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : ''));
        $model = Pic::model()->findbypk($id);
        if (!empty($_POST)) {
           $data = $_POST;		
           //不能直接把数组给attributes  但是可以单独的给key赋值
            foreach($model->attributes as $k=>$v){
                isset($data[$k]) && $model->$k = $data[$k];
            }
            $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
            $model->updatetime = time();
            $model->createtime = strtotime($data['createtime']);
            $model->keywords = keywords::loadKeywordIds($data['keywords'],$this->lang);
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/pic/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';

            //获取图片
            $picmodel = Models::model()->findAll();
            foreach ($picmodel as $cm) {
                $data['picarr'][] = $cm->attributes;
            }

              //获取图片栏目
        $categorymodel = Category::model()->findAll("lang=:lang and model = 'pic'",array(":lang"=>$this->lang));
        foreach ($categorymodel as $c) {
            $data['categoryarr'][] = $c->attributes;
        }

            $this->render('pic_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);

        if ($id_arr && !empty($id_arr)) {
            $res = '';
            $model = new Pic;
            $res = $model->deleteAll('id IN(' . $id_str . ')');
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
        $order_str =Tool::getValidParam('order','string');
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Pic;
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

    public function actionPictures() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
        $id =$data['id']=  intval(isset($_GET['id']) ? $_GET['id'] :0);
        if ($id) {
            
            $model = new Pic_picture();
            $criteria = new CDbCriteria();
            $criteria->condition = "pid ='" . $id . "'";
            $criteria->order = 't.id DESC';
            $count = $model->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 15;
            $criteria->limit = $pages->pageSize;
            $criteria->offset = $pages->currentPage * $pages->pageSize;
            $result = $model->findAll($criteria);

            $data['pagebar'] = $pages;
            
            foreach ($result as $c) {
                $data['list'][] = $c->attributes;
            }
      
        }
      

        //获取文章栏目
        $categorymodel =  Category::model()->findAll("lang=:lang and model = 'pic'",array(":lang"=>$this->lang));
        foreach($categorymodel as $c){
                $data['categoryarr'][] = $c->attributes;
        }


        $this->render('pic_picture', $data);
    }

    public function actionPictures_edit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $pid = $_POST['id'];
//        $_POST = array ( 'id' => '16', 'newpic' => array ( 0 => array ( 'pics' => 'data/attachment/image/20141007/20141007110801_88357.jpg', 'order' => '99', 'title' => '', ), ), 'save' => '鎻惵犱氦', );
        if ($pid) {
            $time = time();
             $command = Mod::app()->db->createCommand();
            //新加图片
            if (isset($_POST['newpic'])) {
                $newpic_arr = $_POST['newpic'];
                $data_pic = array();
                $data_pic['pid'] = $pid;
                $data_pic['createtime'] = $time;

                foreach ($newpic_arr as $k => $v) {
                    is_array($v) && $data_pic['picture'] = str_replace('data/attachment/', '', trim($v['pics']));
                    $data_pic['description'] = isset($v['description']) ? $v['description'] : '';
                    $data_pic['order'] = $v['order'] ? $v['order'] : 99;

                    $command->insert('{{pic_picture}}',$data_pic);
                    $command->reset();
                }
            }
            //更新老图片
            if (isset($_POST['pic'])) {
           
                $data_pic = array();
                $pic_arr = $_POST['pic'];
                $data_pic['updatetime'] = $time;
                foreach ($pic_arr as $k => $v) {
                    $id = $k; //图片ID
                    is_array($v) &&  $data_pic['picture'] =  str_replace('data/attachment/','', trim($v['pics']));
                    $data_pic['description'] = $v['description'];
                    $data_pic['order'] = $v['order'];
                    
                    $command->update('{{pic_picture}}',$data_pic,"id = '".$id."'");
                    $command->reset();
                }
            }

            $this->admin_message(
                    Mod::t('admin','success'), 
                    $this->createUrl('pic/pictures/',array('id'=> $pid))
                    );
        }
    }

    public function actionPictures_del() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Tool::getValidParam("ids",'string');
//        $id_arr = explode(',', $id_str);
//        if ($id_arr && !empty($id_arr)) {
        if ($id_str) {
            $res = '';
//            $res = $this->common_model->deldata($id_arr, 'id', 'picpictures');
            $res = Mod::app()->db->createCommand()->delete('{{pic_picture}}',"id  in(".$id_str.")");
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

}
