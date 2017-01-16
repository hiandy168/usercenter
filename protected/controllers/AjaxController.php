<?php

class AjaxController extends FrontController {
    
     public function actionHitAdd() {
       if(Mod::app()->request->isPostRequest){
                $id = trim(Mod::app()->request->getPost('id', 0));
                $model = ucfirst(trim(Mod::app()->request->getPost('model')));
                if ($id && $model) {
                    $model = new $model;
                    $res = $model->add_hits($id);
                    if ($res) {
                        $mess = '更新成功！';
                        $state = 1;
                    } else {
                        $mess = '更新失败！';
                        $state = 0;
                    }
                }
                echo json_encode(array('state' => $state, 'mess' => $mess));
       }else{
            echo json_encode(array('state' => 0, 'mess' => '非法的数据提交'));
       }
    }
    public function actionGuestbook() {
         if(Mod::app()->request->isAjaxRequest){
                $model = new Guestbook();
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k =Tool::getValidParam($k);
                }
                $model->createtime = time();
                $model->lang = $this->lang;
                if($model->save()){
                        $mess = '提交成功！';
                        $state = 1;
                    } else {
                        $mess = '提交失败！';
                        $state = 0;
                }
                echo json_encode(array('state' => $state, 'mess' => $mess));
        }else{
                echo json_encode(array('state' => 0, 'mess' => '非法的数据提交'));
       }
    }

 
}
