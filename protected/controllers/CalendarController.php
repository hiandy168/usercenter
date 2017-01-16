<?php
/**
 * 
 * @author yuwanqiao
 * 日历控制器
 *
 */
class CalendarController extends FrontController {
    public function init() {
        parent::init();
    }
    //应用的日历
    public function actionIndex(){
        //应用id
        $pid   = trim(Tool::getValidParam('pid','integer'));
        //用户openid
        $openid= trim(Tool::getValidParam('openid','string'));
        //根据应用id查询应用
        $project = Mod::app()->db->createCommand()->select('*')->from('{{project}}')->where('id='.$pid)->queryRow();
        //根据openid查询和应用id查询用户数据
        $member_project = Mod::app()->db->createCommand()->select('*')->from('{{member_project}}')->where("pid=$pid and openid='$openid'")->queryRow();
        $userid = $member_project['mid'];
        $parame = array(
            'project'=>$project,
            'userid' =>$userid,
            'openid' =>$openid
        );
        $this->render('index',$parame);
    }
    //添加记事
    public function actionReg(){
        if(Mod::app()->request->isPostRequest){
            //应用id
            $pid   = trim(Tool::getValidParam('pid','integer'));
            //用户id
            $mid= trim(Tool::getValidParam('mid','integer'));
            $rtxtval=trim(Tool::getValidParam('rtxtval','string'));
            $rtimeval=trim(Tool::getValidParam('rtimeval','string'));
            $rnumval=trim(Tool::getValidParam('rnumval','string'));
            $arr = array(
                'mid'=>$mid,
                'pid'=>$pid,
                'content'=>$rtxtval,
                'time'   =>strtotime($rtimeval),
                'remind' =>$rnumval,
                'add_time'=>time()
            );
            $query = Mod::app()->db->createCommand()->insert('{{calender_remember}}',$arr);
            if($query){
                $arr = array(
                    'code'=>1
                );
            }
            echo json_encode($arr);
        }else{
            //应用id
            $pid   = trim(Tool::getValidParam('pid','integer'));
            //用户id
            $userid= trim(Tool::getValidParam('userid','integer'));
            $openid= trim(Tool::getValidParam('openid','string'));
            //根据应用id查询应用
            $project = Mod::app()->db->createCommand()->select('*')->from('{{project}}')->where('id='.$pid)->queryRow();
            $parame = array(
                'pid'=>$pid,
                'userid'=>$userid,
                'openid'=>$openid,
                'project'=>$project
            );
            $this->render('reg',$parame);
        }
    }
    //测试万年历
    public function actionTest(){
        $this->render('test');
    }
}