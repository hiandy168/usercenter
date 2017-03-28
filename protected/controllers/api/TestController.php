<?php

class TestController extends FrontController
{


    public function Init()
    {
        parent::init();

    }


    /*
     * 测试方法*/
   public function actionWebchat(){

       $this->render('webchat');
   }
}
