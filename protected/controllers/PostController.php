<?php

class PostController extends FrontController {
    
    public function actionGuestbook() {
          if(Mod::app()->request->isPostRequest){
                $model = new Guestbook();
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = Tool::getValidParam($k);
                }
                $model->createtime = time();
                $model->lang = $this->lang;
                
                if($model->save()){
                    $this->redirect($data['redirect_url']);
                }
        }
    }
      
  

 
}
