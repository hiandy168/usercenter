<?php

class MembergroupController extends AController {

    public function actionIndex(){
           $this->actionlists();
    }
        
    public function actionlists ()
    {
        
        $this->check_permission(__CLASS__,__FUNCTION__);
                
                
        $model = new Membergroup();
        $criteria = new CDbCriteria();
        $criteria->condition = "";

        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('membergroup', array ('group' => $result , 'pagebar' => $pages ));
    }
    
      public function actionAdd ()
    {
        $this->check_permission(__CLASS__,'add');

        if( !empty($_POST) ){
            $model = new Membergroup;
                $model->attributes = $data = $_POST;
                $has_model = Membergroup::model()->find('name ="'.$model->name.'"' );
//                var_dump($has_model);
                if($has_model){
                    $target_url = $this->createUrl('/admin/membergroup/add');
                    $this->admin_message('添加失败!组名已存在.', $target_url);
                    exit();
                } else if($model->save()){
                    $target_url = $this->createUrl('/admin/membergroup/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }
        $this->render('membergroup_edit', array ('fun'=>'add'));
    }


    public function actionEdit ()
    {
        $this->check_permission(__CLASS__,'edit');
        $id =intval( isset($_GET['id'])?$_GET['id']:$_POST['id']);
        $model = Membergroup::model()->findbypk($id);
        if(!empty($_POST)){
                    $data = $_POST;
                    $model->attributes = $data; 
                    $has_model = Membergroup::model()->find('name ="'.$model->name.'"' );
                    if($has_model &&  $has_model->id != $model->id){
                        $target_url = $this->createUrl('/admin/membergroup/add');
                        $this->admin_message('编辑失败!组名已存在.', $target_url);
                        exit();
                    }else if($model->save()){
                       $this->admin_message('编辑成功', $target_url);
                    exit();
                    }
        }
        $this->render('membergroup_edit', array ('model' => $model,'fun'=>'edit'));
    
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
                     $model = new Membergroup;
                     $member_admin = new Membergroup_admin();
                     $res = $member_admin->deleteAll( 'group_id IN(' . $id_str . ')');
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
                 $id = trim(Tool::getValidParam("id",'integer'));
                 $permission_id = trim(Tool::getValidParam("permission_id",'integer'));

                if($id){
//
                    //刷新权限
                    Membergroup::model()->updateByPk($id,array('permission_id'=>$permission_id));
                    $member_info = Mod::app()->session['admin_member'];
//                    var_dump($member_info);exit;
//                     if($member_info['group_id'] == $id){
//                            $member_info['permission'] = serialize($res['permissionarr']);
//                            Mod::app()->session['admin_member'] = $member_info;
//                    }

                             
                    $target_url = $this->createUrl('membergroup/index');
                    $this->admin_message('更新成功', $target_url);
                }   
            }else{

                   $id = Mod::app()->request->getParam('id');//request
             
                    if($id){
                        $result = Membergroup::model()->find(" id = $id");
                    }
                    if(isset($result)){
                            if ($result['permission']) {
                                $sql = "select a.id,a.phone,a.username,b.group_id,b.status from dym_member a left join dym_membergroup_admin b on a.id=b.mid where   a.id in (" . $result['permission'] . ") and b.group_id= $id";
                                $re = Mod::app()->db->createCommand($sql)->queryAll();
                                $result['permission'] = $re;
                            }
                        $data['view'] = $result;
//                        if(json_decode($result['permission'],true)){
//                            $arr=json_decode($result['permission'],true);
//                            $permission=implode(",",$arr);
//                            $sql = "select * from dym_member where id in ($permission)";
//                            $re = Mod::app()->db->createCommand($sql)->queryAll();
//                            foreach ($re as $v){
//                                $tmp[]=$v['phone'];
//                            }
//                            $result['permission']=implode(",",$tmp);
//                        }else{
//                            $result['permission']="";
//                        }
//                       $data['view'] = $result;
                    }
//                    
//                    var_dump($data['view']['permission_data']);
//                    exit;
             
                
                    $tree =  new Tree($data['permissionarr']);
                    $data['list'] = $tree->tree2(0);
//                    var_dump($data['list'] );
        
                    $this->render('membergroup_permission',$data);
            }
        }
    
    /*
     * 
     */
    public  function actionMembervalidate(){
        $phone = Tool::getValidParam("phone","string");
        $id = Tool::getValidParam("id","integer");
        $permission_id = Tool::getValidParam("permission_id","integer");

        $re = Member::model()->find("phone=$phone");
        if($re){
            $result = Membergroup::model()->find(" id = $id and permission_id = $permission_id ");
            $arr=array_filter(explode(",",$result['permission']));
            if(in_array($re->id,$arr)){
                echo json_encode(array("status"=>404,"msg"=>"该账号已添加"));
                exit;
            }
//            if(json_decode($result['permission'],true)){
//                $arr=json_decode($result['permission'],true);
//                if(in_array($re->id,$arr)){
//                    echo json_encode(array("status"=>404,"msg"=>"该账号已添加"));
//                    exit;
//                }
//
//            }
            echo json_encode(array("status"=>200,"msg"=>"已查到","data"=>$re->id));
            exit;
        }else{
            echo json_encode(array("status"=>-1,"msg"=>"无"));
            exit;
        }
    }


    public  function actionAddmemberpermission(){
        $mid = Tool::getValidParam("mid","integer");
        $id = Tool::getValidParam("id","integer");
        $permission_id = Tool::getValidParam("permission_id","integer");

        if($id){
            $result = Membergroup::model()->find(" id = $id and permission_id = $permission_id");
        }

        $arr=array_filter(explode(",",$result['permission']));
        if(in_array($mid,$arr)){
            echo json_encode(array("status"=>200,"msg"=>"请勿重复添加!"));
            exit;
        }

        array_push($arr,$mid);
        $result['permission']=implode(",",$arr);

        $ma = new Membergroup_admin();
        $ma->mid=$mid;
        $ma->group_id=$id;
        $ma->status=0;
        $ma->createtime=time();
        $ma->updatetime=time();
        $ma->save();
//        Member::model()->updateByPk($mid,array('group_id'=> $id));
        Membergroup::model()->updateByPk($id,array('permission'=> $result['permission'],'permission_id'=>$permission_id));
        echo json_encode(array("status"=>200,"msg"=>"添加成功"));

        exit;
    }


    public  function actionAddmembergroupadmin(){
        $mid = Tool::getValidParam("mid","integer");
        $id = Tool::getValidParam("id","integer");
        $re =  Membergroup_admin::model()->find(" mid = $mid and  group_id = $id");

        if($re) {
            if($re['status']==1){
                $re['status'] = 0;
            }else{
                $re['status'] = 1;
            }
            $re = Membergroup_admin::model()->updateByPk($re['id'], array('status' => $re['status']));
        }else{
            $ma = new Membergroup_admin();
            $ma->mid=$mid;
            $ma->group_id=$id;
            $ma->status=1;
            $ma->createtime=time();
            $ma->updatetime=time();
            $re = $ma->save();
        }
        if($re) {
            echo json_encode(array("status" => 200, "msg" => "添加成功"));
        }
        exit;
    }

    public  function actionDelmember(){
        $mid = Tool::getValidParam("mid","integer");
        $id = Tool::getValidParam("id","integer");
        $re =  Membergroup::model()->find(" id = $id");
        $re2 =  Membergroup_admin::model()->find(" mid = $mid and  group_id = $id");
        if($re2) {
            Membergroup_admin::model()->deleteByPk($re2['id']);
        }
        $arr = explode(",",$re['permission']);
        foreach ($arr as $k=>$v){
            if($v==$mid){
                unset($arr[$k]);
            }
        }
        if(count($arr)>0){
            $permission = implode(",",$arr);
        }else{
            $permission = "";
        }
        $reupdate = Membergroup::model()->updateByPk($id, array('permission' => $permission));

        if($reupdate) {
            echo json_encode(array("status" => 200, "msg" => "删除成功"));
        }
        exit;
    }

}

