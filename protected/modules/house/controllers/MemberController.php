<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 17:04
 */
class MemberController extends HouseController{

    /**
     * 个人中心首页
     * author  Fancy
     */

    public function actionIndex(){
        $this->render('index');
    }


}