<?php

class JfshopController extends FrontController {
  

    /*
     * 轮播图接口
     * echo json
     *
    */
   public function actionSlide(){

      $re= Slider::model()->getlist();
       $data=array();
      /* $re->picture
       order
       url
       title
       id*/
       if(!$re){
           echo null;
           exit;
       }
       foreach($re as $key=>$value){
           $data[$key]['picture']=$value->picture;
           $data[$key]['order']=$value->order;
           $data[$key]['url']=$value->url;
           $data[$key]['title']=$value->title;
           $data[$key]['id']=$value->id;
       }
          echo  json_encode($data);
       exit;

   }

    
}