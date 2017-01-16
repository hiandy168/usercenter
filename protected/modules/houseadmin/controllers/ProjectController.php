<?php

class ProjectController extends HaController {
    
    public function actionIndex() {
        $this->actionLists();
    }
    
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
//        $result = Project::model()->findAll();
        $model = new Project();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
        
         if(isset($_REQUEST['status']) ){
            $data['s']['status'] = intval($_REQUEST['status']);
            $criteria->addCondition("t.status = ".$data['s']['status'] );
        }
        
//        var_dump( $data);
        if(isset($_REQUEST['type_id'])&& $_REQUEST['type_id']){
            $data['s']['type_id'] = isset($_REQUEST['type_id'])?intval($_REQUEST['type_id']):'';
            $criteria->addCondition("t.type_id  =".  $data['s']['type_id']);
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

        $criteria->order = 't.`top` desc,t.`order` desc,t.`createtime` desc';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        
        if(isset($data['category_id'])){
        $pages->params=array('category_id'=>$data['category_id']); 
        }
        if(isset($data['title'])){
        $pages->params=array('title'=>$data['title']); 
        }
        
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;   
          
        $result = $model->findAll($criteria);
        
        $data['pagebar'] = $pages ;
        
        
        foreach ($result as $c) {
            $data['list'][$c->id] = $c->attributes;
            $data['list'][$c->id]['ip'] = long2ip($c->ip);
        }

        //获取文章栏目
        $data['progect_type_arr'] = JkCms::getproject_type();
      
  

        $this->render('project', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if(Mod::app()->request->isPostRequest){
            $model = new Project;
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->content  = str_replace($this->_siteUrl,'{{site_path}}', $data['view']['content'] );
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
                    $target_url = $this->createUrl('/admin/Project/lists',array('category_id'=>$model->category_id));
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            $data['view']['category_id'] = intval($_REQUEST['category_id']);
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request

            //获取栏目
              $categorymodel =Category::model()->findAll("lang=:lang and model=:model",array(":lang"=>$this->lang,':model'=>'Project'));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }
            $tree = new Tree($data['categoryarr']);
            $data['categoryarr'] = $tree->tree2(0);

            $data['fun'] = 'add';
            $this->render('project_edit', $data);
        }
    }
   
    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval(isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:''));
        $model = Project::model()->findbypk($id);

        if(Mod::app()->request->isPostRequest){
                $data = $_POST['project'];
                $data['typefor'] = $_POST['typefor'];
                $company_leaders = $_POST['company_leaders'];
                foreach ($model->attributes as $k => $v) {
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->company_leaders = serialize($company_leaders);
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                $res = $model->save();
                
                $mess = '提交失败请联系管理员！';
                $state = 0;
                if ($res) {
                    $mess = '更新成功！';
                    $state = 1;
                }
                echo json_encode(array('state' => $state, 'mess' => $mess));
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
                $data['view']['attachments_arr'] = array();
                if($data['view']['attachments']){
                    $attachments_models= Attachment::model()->findAll('id in('.$data['view']['attachments'].')');
                    foreach($attachments_models as $a){
                        $data['view']['attachments_arr'][] = $a->attributes;
                    }
                }
            }
            $data['fun'] = 'edit';
            
            
            //获取文章栏目
            $data['progect_type_arr'] = JkCms::getproject_type();

//            var_dump($data);die;
            $this->render('project_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
//        $_POST['id'] = 98748;
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
 
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Project;
                $res = $model->updateAll(array('status'=>8),'id IN(' . $id_str . ')'); //8为管理员删除
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
            $model = new Project;
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
    
//   	 * 审核项目
    public function actionDostatus() {
        $this->check_permission(__CLASS__, __FUNCTION__);

        $id = intval(Mod::app()->request->getParam('id'));
        $action = intval(Mod::app()->request->getParam('action'));
        $comment = intval(Mod::app()->request->getParam('comment'));
        
        if($action ==1)$status = 1;//审批通过
        if($action ==0)$status = 7;//审批拒绝
 
        if ($id) {
               $project = Project::model()->findbypk($id);
              
               $res='';     
                //获取珊瑚品论ID 并更新
               if (! $project->targetid && $status==1) {
//                    var_dump($project);die;
                    // 将报料信息提交到评论系统
                    $targetid = Shcomment::postAritcleToCoral ($project->category_id,$project->id, Tool::noscript ( $project->title ), Tool::noscript ( $project->description ) );
       
                    // 保存评论系统targetid到report表对应记录
                    $res = Project::model ()->updateByPk ( $project->id, array (
                                    'targetid' => $targetid ,'status'=>$status
                    ) );
                }
//            $res = '';
//            $model = new Project;
//            $res = $model->updateByPk($id,array('status'=>$status));
            if ($res) {
                $mess = '操作成功！';
                $state = 1;
            } else {
                $mess = '操作成功！';
                $state = 0;
            }
        }else{
                 $mess = '数据错误！';
                 $state = 0;
        }
     
        $Projecteditlog_model = new Projecteditlog;
        $Projecteditlog_model->project_id = $id;
        $Projecteditlog_model->uid =   $this->user['id']; 
        $Projecteditlog_model->status =  $state;
        $Projecteditlog_model->comment =   $comment;
        $Projecteditlog_model->content =  '审核/否决';
        $Projecteditlog_model->save();
        
        

        
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }
    
    //设置聚焦
    public function actionDofocus() {
        $this->check_permission(__CLASS__, __FUNCTION__);

        $id = intval(Mod::app()->request->getParam('id'));
        $focus = intval(Mod::app()->request->getParam('focus'));

 
        if ($id) {
            $res = '';
            $model = new Project;
            $res = $model->updateByPk($id,array('focus'=>$focus));
            if ($res) {
                $mess = '操作成功！';
                $state = 1;
            } else {
                $mess = '操作成功！';
                $state = 0;
            }
        }else{
                 $mess = '数据错误！';
                 $state = 0;
        }
     
        $Projecteditlog_model = new Projecteditlog;
        $Projecteditlog_model->project_id = $id;
        $Projecteditlog_model->uid =   $this->user['id']; 
        $Projecteditlog_model->status =  $state;
        $Projecteditlog_model->comment =   '';
        $Projecteditlog_model->content =  '设置为聚焦';
        $Projecteditlog_model->save();
        
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }
    
      //设置精选
    public function actionDochoiceness() {
        $this->check_permission(__CLASS__, __FUNCTION__);

        $id = intval(Mod::app()->request->getParam('id'));
        $choiceness = intval(Mod::app()->request->getParam('choiceness'));
        if ($id) {
            $res = '';
            $model = new Project;
            $res = $model->updateByPk($id,array('choiceness'=>$choiceness));
            if ($res) {
                $mess = '操作成功！';
                $state = 1;
            } else {
                $mess = '操作成功！';
                $state = 0;
            }
        }else{
                 $mess = '数据错误！';
                 $state = 0;
        }
     
        $Projecteditlog_model = new Projecteditlog;
        $Projecteditlog_model->project_id = $id;
        $Projecteditlog_model->uid =   $this->user['id']; 
        $Projecteditlog_model->status =  $state;
        $Projecteditlog_model->comment =   '';
        $Projecteditlog_model->content =  '设置为精选';
        $Projecteditlog_model->save();
        
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
