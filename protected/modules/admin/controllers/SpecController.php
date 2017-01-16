<?php

class SpecController extends AController {
    public function actionIndex(){
        $where = array();
//        $result = Article::model()->findAll();
        $model = new Spec();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";

        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;   
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;      
        $result = $model->findAll($criteria);
        
        $data['pagebar'] = $pages ;
          
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        
        //end我的位置
        $this->render('index', $data);
    }
    
    public function actionAdd(){
        if( !empty($_POST) ){
                $model = new Spec;
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->createtime =  $model->updatetime = time(); 
                if($model->save()){
                    $id = Mod::app()->db->lastInsertID;
                    if(!empty( $data['element'])&&  $data['element']){
                        foreach($data['element'] as $key=>$val){
                                 Mod::app()->db->createCommand()->insert('{{spec_element}}',array('spec_id'=>$id,'name'=>$val));         
                        }
                    }
                    $target_url = $this->createUrl('spec/');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
                $data = $where = array();

                $data['fun'] = 'add';
                $this->render('edit', $data);
        }
    }
    
    public function actionEdit() {
        $id = intval(isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:''));
        $model = Spec::model()->findbypk($id);
        if(Mod::app()->request->isPostRequest){
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
               if(!empty( $data['element'])&&  $data['element']){
                    foreach($data['element'] as $key=>$val){
                        $res = array();
                        $res = Mod::app()->db->createCommand()->select('name')->from('{{spec_element}}')->where('spec_id=:spec_id and name=:name', array(':spec_id'=>$id,':name'=>$val))->queryRow();
                        if(empty($res)||!$res){
                            Mod::app()->db->createCommand()->insert('{{spec_element}}',array('spec_id'=>$id,'name'=>$val));        
                        }
                    }
               }
                $model->updatetime = time();
                if($model->save()){
                      $target_url = $this->createUrl('spec/');
                      $this->admin_message('添加成功', $target_url);
                      exit();
                }
        }else {
                $data = $where = array();
                if (isset($model)) {
                    $data['view'] = $model->attributes;
                    $Specelement = Specelement::model()->findAll('spec_id='.$id);
                    foreach ($Specelement as $s) {
                        $data['view']['element'][] = $s->attributes;
                    }
                }
                $data['fun'] = 'edit';
                
                $this->render('edit', $data);
        }
    }
    
    //删除流程
    public function actionDel() {
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Spec;
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
    
   

}
