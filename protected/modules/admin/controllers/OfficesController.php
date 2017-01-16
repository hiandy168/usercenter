<?php

class OfficesController extends AController {

    public function actionIndex() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = $data = array();
        $result = Offices::model()->findAll(array(
          'order' => 'id asc',
        ));
        foreach ($result as $c) {
            $data['officesarr'][] = $c->attributes;
        }
        
        if(!empty($data['officesarr'])){
            $tree = new Tree($data['officesarr']);
            $data['list'] = $tree->tree2(0);
        }


        $this->render('offices', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if( !empty($_POST) ){
            $model = new Offices;
                $model->attributes = $data = $_POST;
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->createtime = strtotime($data['createtime']);
                $model->tpl_list = $data['tpl_list']?('/'.trim($data['tpl_list'],'/')):'';
                $model->tpl_detail =  $data['tpl_detail']?('/'.trim($data['tpl_detail'],'/')):'';
                $model->lang = $this->lang;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/offices/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request
            //获取栏目
             $officesmodel =  Offices::model()->findAll("lang=:lang",array(":lang"=>$this->lang));
             foreach($officesmodel as $cm){
                 $data['officesarr'][] = $cm->attributes;
             }
            $tree = new Tree($data['officesarr']);
            $data['officesarr'] = $tree->tree2(0);
 

            $data['fun'] = 'add';
            $this->render('offices_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Offices::model()->findbypk($id);
        if( !empty($_POST) ){
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                 $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->tpl_list = $data['tpl_list']?('/'.trim($data['tpl_list'],'/')):'';
                $model->tpl_detail =  $data['tpl_detail']?('/'.trim($data['tpl_detail'],'/')):'';
                $model->updatetime = time();
                if($model->save()){
                    $target_url = $this->createUrl('/admin/offices/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
            }
            $data['fun'] = 'edit';
            
           //获取栏目
             $officesmodel =Offices::model()->findAll();
             foreach($officesmodel as $cm){
                 $data['officesarr'][] = $cm->attributes;
             }
             
            $tree = new Tree($data['officesarr']);
            $data['officesarr'] = $tree->tree2(0);
            
             
 
//            //获取模型
//            $Models =Models::model()->findAll('status =1');
//             foreach($Models as $m){
//                 $data['modelarr'][] = $m->attributes;
//             }

            $this->render('offices_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);

            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Offices;
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
            $model = new Offices;
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
