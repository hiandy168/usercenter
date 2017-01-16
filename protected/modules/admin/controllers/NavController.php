<?php

class NavController extends AController {
    public function actionIndex() {
//        $this->actionLists();
         $this->actionNavtype();
    }

    public function actionNavtype() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $model = new Type();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and type = 'nav'";
        $type_id = Mod::app()->request->getParam('type_id', 0);
        if(isset($type_id)&& $type_id){
            $criteria->addCondition("t.id=" . intval($type_id));
            $data['type_id'] = intval($type_id);
        }
        $criteria->order = 't.order ASC';
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



        $this->render('navtype', $data);
    }

    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $data=array();
        $model = new Nav();
        $criteria = new CDbCriteria();
        $criteria->condition = "type_id =".Tool::getValidParam('type_id')." and lang ='" . $this->lang . "'";
//        if(isset($_POST['type_id'])&& $_POST['type_id']){
//           $criteria->addCondition("t.category_id=".intval($_POST['type_id']));
//           $data['type_id'] = intval($_POST['type_id']);
//        }
        $criteria->order = 't.order desc,t.path ASC';
        $result = $model->findAll($criteria);
        foreach ($result as $c) {
            $data['list'][$c->id] = $c->attributes;
            $c->fid && ($c->type_id == $_GET['type_id']) && $data['list'][$c->fid]['has_childen'] = true; //是否有孩子
        }


//        $result = Nav::model()->findAll("lang=:lang",array(":lang"=>$this->lang));
//        foreach ($result as $c) {
//            $data['navarr'][] = $c->attributes;
//        }
//        $tree = new Tree($data['navarr']);
//        $data['list'] = $tree->tree2(0);

        $this->render('nav', $data);
    }
    
    public function actionAddtype() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        if (!empty($_POST)) {
            $model = new Type;
            $data = $_POST;
            foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
            }
            $model->type = 'nav';
            $model->lang = $this->lang;
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/nav/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {

            
            $data['fun'] = 'add';
            $this->render('navtype_edit', $data);
        }
    }
    
     public function actionEdittype() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id']) ? $_GET['id'] : $_POST['id']);
        $model = Type::model()->findbypk($id);
        if (!empty($_POST)) {
            $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/nav/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {
             if (isset($model)) {
                $data['view'] = $model->attributes;
            }
 
            
            $data['fun'] = 'edit';
            $this->render('navtype_edit', $data);
        }
    }
    

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        if (!empty($_POST)) {
                $data = $_POST;
                $model = new Nav();
                //不能直接把数组给attributes  但是可以单独的给key赋值
                foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->createtime = time();
                $model->lang = $this->lang;
                
                //计算level，path
                if(!$model->fid){
                    $model->level = 1;
                }else{
                     $sql = 'select * from {{nav}} where id ='.$model->fid;
                     $res = Mod::app()->db->createCommand($sql)->queryRow();
                     $model->level = $res['level']+1;
                }
                
            if ($model->save()) {
                $new_id = Mod::app()->db->getLastInsertID();
                //更新path
                $new_path = isset($res['path'])?$res['path'].','.$new_id:$new_id;
                $sql = "update {{nav}} set `path`='".$new_path."' where `id`='".$new_id."'";
                $update_res = Mod::app()->db->createCommand($sql)->query();
                $target_url = $this->createUrl('/admin/nav/lists',array('type_id'=>$model->type_id));
                
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {

            //分类
            $type_model = new Type();
            $type_result = $type_model->findAll("lang ='" . $this->lang . "' and type = 'nav'");
            foreach ($type_result as $c) {
                $data['type_arr'][] = $c->attributes;
            }
            unset($c);
        
            $data['fun'] = 'add';
            $this->render('nav_edit', $data);
        }
    }
    
    //导航树
    public function actionAjaxNavTree(){
        if(Mod::app()->request->isPostRequest && Mod::app()->request->getPost('id')){
            $type_id = Mod::app()->request->getPost('id');
            $model = new Nav();
            $criteria = new CDbCriteria();
            $criteria->condition = "type_id ='" . $type_id . "'   and lang ='" . $this->lang . "'";
            $criteria->order = 't.path ASC';
            $result = $model->findAll($criteria);
            foreach ($result as $c) {
                $nav_arr[$c->id] = $c->attributes;
                $c->fid && $nav_arr[$c->fid]['has_childen'] = true; //是否有孩子
            }
            unset($c);
            $html='';
            if(!empty($nav_arr)){
                foreach ( $nav_arr as $n) {
                    $html .='<option value="'.$n['id'].'" >'.str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$n['level']-1).$n['title'].'</option>';
                }
            }
            echo $html;
            
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval( isset($_GET['id']) ? $_GET['id'] : $_POST['id']);
        $model = Nav::model()->findbypk($id); 
        if (!empty($_POST)) {
            $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                //重新计算level，path
                if(!$model->fid){
                    $model->level = 1;
                }else{
                     $sql = 'select * from {{nav}} where id ='.$model->fid;
                     $res = Mod::app()->db->createCommand($sql)->queryRow();
                     $model->path = $res['path']?$res['path'].','.$model->id:$model->id;
                     $model->level = $res['level']+1;
                }
                $model->updatetime = time();
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/nav/lists',array('type_id'=>$model->type_id));
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {
            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';
            

            $nav_model = new Nav();
            $criteria = new CDbCriteria();
//            $criteria->condition = "type_id ='" . $model->type_id . "'   and  id !='" . $model->id . "'   and lang ='" . $this->lang . "'";
            $criteria->condition = "type_id ='" . $model->type_id . "'  and lang ='" . $this->lang . "'";
            $criteria->order = 't.path ASC';
            $result = $nav_model->findAll($criteria);
            foreach ($result as $c) {
                $data['nav_arr'][$c->id] = $c->attributes;
                $c->fid && $data['nav_arr'][$c->fid]['has_childen'] = true; //是否有孩子
            }
            unset($c);
            
           
            
            $type_model = new Type();
            $type_result = $type_model->findAll("lang ='" . $this->lang . "' and type = 'nav'");
            foreach ($type_result as $c) {
                $data['type_arr'][] = $c->attributes;
            }
            unset($c);
        
        
        
 

            $this->render('nav_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);

        if ($id_arr && !empty($id_arr)) {
            $res = '';
            $model = new nav;
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
        $id_str = $_POST['id'];
        $order_str = $_POST['order'];
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Nav;
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
    
     public function actionDeltype() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);

        if ($id_arr && !empty($id_arr)) {
            $res = '';
            $model = new Nav;
            $count = $model->count('type_id  = '.$id_str .'');
            if($count<=0){
                $model = new Type;
                $res = $model->deleteAll('id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }else{
                  $mess = '删除失败！ 请先清空分类下的导航类容';
                  $state = 0;
            }
        }

        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

    public function actionOrdertype() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = $_POST['id'];
        $order_str = $_POST['order'];
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Type;
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
