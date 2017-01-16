<?php

class DoctorsController extends AController {
    
    public function actionIndex() {
        $this->actionLists();
    }
    
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
//        $result = Doctors::model()->findAll();
        $model = new Doctors();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
        if(isset($_REQUEST['offices_id'])&& $_REQUEST['offices_id']){
           $data['offices_id'] = isset($_REQUEST['offices_id'])?intval($_REQUEST['offices_id']):'';
           
            $child_offices_model = Offices::model()->findAll("fid ='" . intval($_REQUEST['offices_id']) . "' and lang ='" . $this->lang . "'");
            $child_id_arr =  array();
            $id_arr = array(intval($_REQUEST['offices_id']));
            foreach($child_offices_model as $c){
                $child_id_arr[] = $c->id;
            }
            if(!empty($child_id_arr)){
                $id_arr = array_merge(array(intval($_REQUEST['offices_id'])),$child_id_arr);
            }
            $criteria->addCondition("t.offices_id in(".implode(',', $id_arr).")");
           $data['s']['offices_id'] = intval($_REQUEST['offices_id']);
        }
        if(isset($_REQUEST['title'])&& $_REQUEST['title']){
           $criteria->addCondition("t.title like '%".trim($_REQUEST['title']."%'"));
            $data['s']['title'] = trim($_REQUEST['title']);
        }

        isset($_REQUEST['recommend']) && $data['s']['recommend'] = trim($_REQUEST['recommend']);
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'top')){
            $criteria->addCondition("t.top = 1");
        }
        if( isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'focus')){
            $criteria->addCondition("t.focus = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'recommend')){
            $criteria->addCondition("t.recommend = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'choiceness')){
            $criteria->addCondition("t.choiceness = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'hot')){
            $criteria->addCondition("t.hot = 1");
        }

        $criteria->order = 't.`top` desc,t.`order` desc,t.`id` desc';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        
        if(isset($data['offices_id'])){
        $pages->params=array('offices_id'=>$data['offices_id']); 
        }
        if(isset($data['title'])){
        $pages->params=array('title'=>$data['title']); 
        }
        
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;   
          
        $result = $model->findAll($criteria);
        
        $data['pagebar'] = $pages ;
        
        
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

        //获取文章栏目
        $officesmodel =  Offices::model()->findAll();
        foreach($officesmodel as $c){
                $data['officesarr'][$c->id] = $c->attributes;
        }
        
        if(isset($data['officesarr'])){
        $tree = new Tree($data['officesarr']);
        $data['officesarr'] = $tree->tree2(0);
        }


        $this->render('doctors', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if(Mod::app()->request->isPostRequest){
            $model = new Doctors;
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                 $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->createtime = strtotime($data['createtime']);
                $model->tags = Tags::loadTagIds($data['tags'],$this->lang);
                $model->keywords = isset($data['keywords'])?Keywords::loadKeywordIds($data['keywords'],$this->lang):'';
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                $model->lang = $this->lang;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/doctors/lists');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request

            //获取栏目
              $officesmodel =Offices::model()->findAll();
             foreach($officesmodel as $cm){
                 $data['officesarr'][] = $cm->attributes;
             }
            $tree = new Tree($data['officesarr']);
            $data['officesarr'] = $tree->tree2(0);

            $data['fun'] = 'add';
            $this->render('doctors_edit', $data);
        }
    }
   
    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:'');
        $model = Doctors::model()->findbypk($id);

        if(Mod::app()->request->isPostRequest){
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->updatetime = time();
                $model->createtime = strtotime($data['createtime']);
                $model->tags = Tags::loadTagIds($data['tags'],$this->lang);
                $model->keywords = isset($data['keywords'])?Keywords::loadKeywordIds($data['keywords'],$this->lang):'';
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                if($model->save()){
                      $target_url = $this->createUrl('/admin/doctors/lists');
                      $this->admin_message('添加成功', $target_url);
                      exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
                $data['view']['tags'] = Tags::loadTags($data['view']['tags'],$this->lang);
                $data['view']['keywords'] = Keywords::loadKeywords($data['view']['keywords'],$this->lang);
            }
            $data['fun'] = 'edit';
            
             //获取栏目
              $officesmodel =Offices::model()->findAll();
             foreach($officesmodel as $cm){
                 $data['officesarr'][] = $cm->attributes;
             }
            $tree = new Tree($data['officesarr']);
            $data['officesarr'] = $tree->tree2(0);

            $this->render('doctors_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
 
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Doctors;
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
            $model = new Doctors;
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
