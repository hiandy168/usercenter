<?php

class UsergroupController extends AController {

    public function actionIndex(){
           $this->actionlists();
    }
        
    public function actionlists ()
    {
        
        $this->check_permission(__CLASS__,__FUNCTION__);
                
                
        $model = new Usergroup();
        $criteria = new CDbCriteria();
        $criteria->condition = "";

        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('usergroup', array ('group' => $result , 'pagebar' => $pages ));
    }
    
      public function actionAdd ()
    {
        $this->check_permission(__CLASS__,'add');

        if( !empty($_POST) ){
            $model = new Usergroup;
                $model->attributes = $data = $_POST;
                $has_model = Usergroup::model()->find('name ="'.$model->name.'"' );
//                var_dump($has_model);
                if($has_model){
                    $target_url = $this->createUrl('/admin/usergroup/add');
                    $this->admin_message('添加失败!组名已存在.', $target_url);
                    exit();
                } else if($model->save()){
                    $target_url = $this->createUrl('/admin/usergroup/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }
        $this->render('usergroup_edit', array ('fun'=>'add'));
    }


    public function actionEdit ()
    {
        $this->check_permission(__CLASS__,'edit');
        $id =intval( isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Usergroup::model()->findbypk($id);
        if(!empty($_POST)){
                    $data = $_POST;
                    $model->attributes = $data; 
                    $has_model = Usergroup::model()->find('name ="'.$model->name.'"' );
                    if($has_model &&  $has_model->id != $model->id){
                        $target_url = $this->createUrl('/admin/usergroup/add');
                        $this->admin_message('编辑失败!组名已存在.', $target_url);
                        exit();
                    }else if($model->save()){
                       $this->admin_message('编辑成功', $target_url);
                    exit();
                    }
        }
        $this->render('usergroup_edit', array ('model' => $model,'fun'=>'edit'));
    
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
                     $model = new Usergroup;
                    $res = $model->deleteAll( 'id IN(' . $id_str . ') and id!=1');
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
        
    public function actionPermission(){
            $this->check_permission(__CLASS__,__FUNCTION__);
            $permissionarr = Permission::model()->findAll();
            foreach($permissionarr as $k=>$v){
                $data['permissionarr'][$k] = $v->attributes;
                if($v->fun){
                    $data['permissionarr'][$k]['fun_arr'] = explode(',', $v->fun);
                }
            }
            
            if(!empty($_POST)){
                 $id = Tool::getValidParam('id','integer');
                if($id){
                    foreach( $data['permissionarr'] as $pk=>$pv){
                        if(isset($_POST[$pv['class']]))
                            $res['permissionarr'][$pv['class']]= $_POST[$pv['class']];
                    }
//                    var_dump($res['permissionarr']);
                
//                    
                    //刷新权限
                    Usergroup::model()->updateByPk($id,array('permission'=>serialize($res['permissionarr'])));
                    $user_info = $this->user;
                     if($user_info['group_id'] == $id){
                            $user_info['permission'] = serialize($res['permissionarr']);
                            $this->user = Mod::app()->session['admin_user'] = $user_info;
                    }
                        
                             
                    $target_url = $this->createUrl('usergroup/index');
                    $this->admin_message('更新成功', $target_url);
                }   
            }else{

                   $id = Mod::app()->request->getParam('id');//request
             
                    if($id){
                        $result = Usergroup::model()->find(" id = $id");
                    }
                    if(isset($result)){
                       if($result['permission'])
                              $result['permission'] = unserialize($result['permission']);
                       $data['view'] = $result;
                    }
                    
//                    var_dump($data['view']['permission']);
                    
             
                
                    $tree =  new Tree($data['permissionarr']);
                    $data['list'] = $tree->tree2(0);
//                    var_dump($data['list'] );
        
                    $this->render('usergroup_permission',$data);
            }
        }
    
}

