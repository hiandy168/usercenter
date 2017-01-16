<?php

class CategoryController extends AController {

    public function actionIndex() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = $data = array();
        $result = Category::model()->findAll(array(
          'order' => 'id asc',
        ));
        foreach ($result as $c) {
            $data['categoryarr'][] = $c->attributes;
        }
        
        if(!empty($data['categoryarr'])){
            $tree = new Tree($data['categoryarr']);
            $data['list'] = $tree->tree2(0);
        }


        $this->render('category', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if( !empty($_POST) ){
            $model = new Category;
                $model->attributes = $data = $_POST;
                $model->content  = str_replace($this->_siteUrl,'{{site_path}}', $data['view']['content'] );
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->createtime = strtotime($data['createtime']);
                $model->tpl_list = $data['tpl_list']?('/'.trim($data['tpl_list'],'/')):'';
                $model->tpl_detail =  $data['tpl_detail']?('/'.trim($data['tpl_detail'],'/')):'';
                $model->lang = $this->lang;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/category/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request
            //获取栏目
             $categorymodel =  Category::model()->findAll("lang=:lang",array(":lang"=>$this->lang));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }
                  if(isset($data['categoryarr'])&& !empty($data['categoryarr'])){
                $tree = new Tree($data['categoryarr']);
                $data['categoryarr'] = $tree->tree2(0);
            }
 
             
            //获取模型
            $Models =Models::model()->findAll('status =1');
             foreach($Models as $m){
                 $data['modelarr'][] = $m->attributes;
             }

            $data['fun'] = 'add';
            $this->render('category_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Category::model()->findbypk($id);
        if( !empty($_POST) ){
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->content  = str_replace($this->_siteUrl,'{{site_path}}', $data['view']['content'] );
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->tpl_list = $data['tpl_list']?('/'.trim($data['tpl_list'],'/')):'';
                $model->tpl_detail =  $data['tpl_detail']?('/'.trim($data['tpl_detail'],'/')):'';
                $model->updatetime = time();
                if($model->save()){
                    $target_url = $this->createUrl('/admin/category/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
                $data['view']['content']  = str_replace('{{site_path}}', $this->_siteUrl, $data['view']['content'] );
            
            }
            
            $data['fun'] = 'edit';
            
           //获取栏目
             $categorymodel =Category::model()->findAll("lang=:lang",array(":lang"=>$this->lang));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }
                 if(isset($data['categoryarr'])&& !empty($data['categoryarr'])){
                $tree = new Tree($data['categoryarr']);
                $data['categoryarr'] = $tree->tree2(0);
            };
 
            //获取模型
            $Models =Models::model()->findAll('status =1');
             foreach($Models as $m){
                 $data['modelarr'][] = $m->attributes;
             }

            $this->render('category_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);

            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Category;
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
            $model = new Category;
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
