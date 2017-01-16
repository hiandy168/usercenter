<?php

class PermissionController extends AController {
    public function actionIndex() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $Permission_obj = Permission::model()->findAll();
        foreach ($Permission_obj as $p) {
            $data['permissionarr'][] = $p->attributes;
        }

        $tree = new Tree($data['permissionarr']);
        $data['list'] = $tree->tree2(0);
        $this->renderPartial('permission', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        if( !empty($_POST) ){
            $model = new Permission;
                $model->attributes = $data = $_POST;
                if($model->save()){
                    $target_url = $this->createUrl('permission/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');

            $data['type_model'] = Permission::model()->findAll('fid = 0');

            $data['fun'] = 'add';
            $this->render( 'permission_edit', $data);
        }
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id']) ? $_GET['id'] : $_POST['id']);
        $model = Permission::model()->findbypk($id);
        $data['item'] = $model->attributes;
        if (!empty($_POST)) {
            $model->attributes = $data= $_POST;
            if ($model->save()) {
                $target_url = $this->createUrl('/admin/membergroup/edit/id/'.$data['id']);
                $this->admin_message('编辑成功', $target_url);
                exit();
            }
        }

        $data['fun'] = 'edit';
        //获取栏目
         $data['type_model'] = Permission::model()->findAll('fid = 0');



        $this->render( 'permission_edit', $data);
    }

    
    public function actionDel(){
            $this->check_permission(__CLASS__,__FUNCTION__);
            $id_str = Mod::app()->request->getParam('id');
            $id_arr =  explode(',', $id_str);
//            file_put_contents('/text.txt', var_export($id_arr, 1));
    
                if($id_arr && !empty($id_arr)){ 
                     $res='';
                     $model = new Permission;
                    $res = $model->deleteAll( 'id IN(' . $id_str . ')');
                     if($res){
                         $mess = '删除成功！';
                         $state = 1;
                     }else{
                         $mess = '删除失败！';
                         $state = 0;
                     }
                }
          
            echo json_encode(array('state'=>$state,'mess'=>$mess));     
	}

    public function actionOrder() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Tool::getValidParam('id','string');
        $order_str = Tool::getValidParam('order','string');
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Permission;
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
