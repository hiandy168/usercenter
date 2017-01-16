<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:03
 */

class HmoneyController extends HaController{

    public function actionList(){
        $this->render("list");
    }

    public function actionAdd(){
        $this->render("add");
    }

    public function actionDel(){

    }



}