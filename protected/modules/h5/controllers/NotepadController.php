<?php

class NotepadController extends FrontController
{
    //我的日历
    public function actionIndex()
    {

        //$cates = CityLifeCategory::model()->findAll();
//        $lists = CityLife::model()->findAll();
        $data = array(
           // 'cates'=>$cates,
            'config' =>array('site_title'=>'城市日历'),
        );
//        var_dump($data);exit(131);
        $this->render('index',$data);
    }


    /*
     * 城市日历添加记事
     * */
    public function actionFrom(){

    if($_POST['rtxtval']){
        $rtxtval= trim(Tool::getValidParam('rtxtval', 'string'));//记事标题
        $rtimeval=strtotime($_POST['rtimeval'])?strtotime($_POST['rtimeval']):time();//提醒时间
        $rnumval= Tool::getValidParam('rnumval', 'integer');//提醒设置
    //提醒设置：1;不提醒,2:正点提醒;3:提前十五分钟;4:提前三十分钟;5:提前1小时;6:提前1天;7:提前2天;8:提前3天;9:提前一周
        $data =array(
            'title'=>$rtxtval,
            'remind'=>$rtimeval,
            'createtime' =>time(),
           // 'rnumval'=>$rnumval,
            'mid'=>$this->member['id']
        );
        $res = Mod::app()->db->createCommand()->insert('dym_notepad', $data);

        if($res){
            echo 1; exit;
        }

    }else{
        echo 2;exit;
    }

    }


}