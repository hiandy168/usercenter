<?php

class UserController extends AController {

    public function actionIndex(){
           $this->actionlists();
    }
        
    public function actionlists ()
    {
        
        $this->check_permission(__CLASS__,'lists');
        //会员分组信息
        $group_model = new Usergroup();
        $group  = $group_model->findAll("status = 1");
         
        $group_id = Mod::app()->request->getParam('group_id');
                
                
        $model = new User();
        $criteria = new CDbCriteria();
        $criteria->condition = "";
        if($group_id){
        $criteria->addCondition("t.group_id=".$group_id);
        }
        $criteria->order = 't.id DESC';
        $criteria->with = 'Usergroup';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('user', array ('datalist' => $result ,'group'=>$group, 'pagebar' => $pages ));
    }
    
      public function actionAdd ()
    {
        $this->check_permission(__CLASS__,'add');
        $data['name'] = Mod::app()->request->getParam('name');
        $data['password'] =  Mod::app()->request->getParam('password');
        $repassword =  Mod::app()->request->getParam('repassword');
        if( isset($_POST) && $repassword == $data['password']){
                $data['group_id'] = Mod::app()->request->getParam('group_id');
                $data['source'] = Tool::random_keys(5);//随机生成5位字符串
                $data['password'] = Tool::md5str($data['password'],$data['source']);
                $data['status'] = Mod::app()->request->getParam('status');
                $data['admin'] = Mod::app()->request->getParam('admin');
                $data['remark'] = Mod::app()->request->getParam('remark');
                $data['regtime'] =$data['lastlogintime'] = time();
                $data['regip'] =$data['lastloginip'] = Tool::get_ip();
                $model = new User('create');
                $model->attributes = $data;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/user/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else{
                $target_url = $this->createUrl('/admin/user/add');
                $this->admin_message('两次密码不一致或者密码为空', $target_url);
                exit();
        }
      
              //会员分组信息
        $group_model = new Usergroup();
        $group  = $group_model->findAll("status = 1");
        
        $this->render('user_edit', array ('model' => $model,'group'=>$group,'fun'=>'add'));
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
        $model = User::model()->findbypk($data['id']);
        if( $data['id'] && !empty($_POST)){
            $data['password'] =  Tool::getValidParam('password','string');
            $repassword =   Tool::getValidParam('repassword','string');
            if($repassword == $data['password']){
                    $model->group_id = Mod::app()->request->getParam('group_id');
                    $model->source = Tool::random_keys(5);//随机生成5位字符串
                    $model->password = Tool::md5str($data['password'],$model->source);
         
                    $model->status = Mod::app()->request->getParam('status');
                    $model->admin = Mod::app()->request->getParam('admin');
                    $model->remark = Mod::app()->request->getParam('remark');
                    if($model->save()){
                        $target_url = $this->createUrl('/admin/user/edit/id/'.$data['id']);
                        $this->admin_message('编辑成功', $target_url);
                        exit();
                    }
            }else{
                    $target_url = $this->createUrl('/admin/user/add');
                    $this->admin_message('两次密码不一致', $target_url);
                    exit();
            }
            exit();
        }
 
//              会员分组信息
        $group_model = new Usergroup();
        $group  = $group_model->findAll("status = 1");
        
        $this->render('user_edit', array ('model' => $model,'group'=>$group,'fun'=>'edit'));
    
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
                     $model = new User;
                    $res = $model->deleteAll( 'id IN(' . $id_str . ') and admin=0');
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

