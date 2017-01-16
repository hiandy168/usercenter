<?php

class CityLifeController extends FrontController
{
    //城市服务
    public function actionIndex()
    {
        $appid = trim(Tool::getValidParam('appid','integer'));
        $appsecret = trim(Tool::getValidParam('appsecret','string'));
        $openid = trim(Tool::getValidParam('openid','string'));
        $memInfo = Member_project::memberIslegal($appid,$appkey,$openid);

        $param = '';
        if(!empty($appid) && !empty($appsecret) && !empty($openid)){
            $param = '?appid='.$appid.'&appsecret='.$appsecret.'&openid='.$openid;
        }
        $cates = CityLifeCategory::model()->findAll();
//        $lists = CityLife::model()->findAll();
        $data = array(
            'cates'=>$cates,
//            'lists'=>$lists,
            'member'=>$memInfo,
            'param'=>$param,
            'config' =>array('site_title'=>'城市服务'),
        );
//        var_dump($data);exit(131);
        $this->render('index',$data);
    }
}