<?php

class BehaviorController extends FrontController {
        
    public function Init()
    {
        parent::init();
    }


//    传入的参数有mark（用户行为操作的标识，在后台积分管理里面有一个积分标识），openid（用户的openid），pid（用户创建应用的id）
//    日历工具控制器
     public function actionStatistics(){
        $behaviorid  =Tool::getValidParam('behavior','string');//操作的标识
        $openid = Tool::getValidParam('openid','string');//用户openid
        
        
        if (!$openid) {
            echo json_encode(array('result'=>false,'code' => 101006, 'mess' => $this->error_code[101006]));  exit;
        }
   
        if (!$behaviorid) {
            echo json_encode(array('result'=>false,'code' => 101008, 'mess' => $this->error_code[101008])); exit;//行为类型id错误
        }
     
        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);  
        
        $pid   = $project_info['id'];  
        if (!$pid) {
            echo json_encode(array('result'=>false,'code' => 101007, 'message' => $this->error_code[101007])); exit;
        }
        /* 向数据库中添加用户操作 */
        //根据行为ID和pid查询 是什么操作和可得到的积分
        $behavior_model = Member_behavior_type::model()->findByPk($behaviorid);
        if(!$behavior_model){
              echo json_encode(array('result'=>false,'code' => 101008, 'mess' => $this->error_code[101008])); exit;//行为类型id错误
        }
        //根据openid和应用id查询用户信息
        $user = Mod::app()->db->createCommand()->select("*")->from('{{member_project}}')->where('openid = "'.$openid.'" and pid='.$pid)->queryRow();
        if(!$user){
              //开始绑定用户
              echo json_encode(array('result'=>false,'code' => 101009, 'mess' => $this->error_code[101009])); exit;//用户不存在
        }

        $member_behavior =  new Member_behavior();
        $member_behavior->remark =Tool::getValidParam('remark','string');
        $member_behavior->mid   =$user['mid'];
        $member_behavior->pid   =$pid;
        $member_behavior->point =$behavior_model->point;
        $member_behavior->type  = $behavior_model->id;
        $member_behavior->year  =date('Y',time());
        $member_behavior->month =date('m',time());
        $member_behavior->day   =date('d',time());
        $member_behavior->ip    =Mod::app()->request->userHostAddress;
        $member_behavior->createtime=time();
        $res = $member_behavior->save();
      
        if($res){
            //根据行为操作给用户添加积分
            //先查询用积分
            $memberinfo = JkCms::getMemberById($user['mid']);
            $memberinfo['points'] = $memberinfo['points']+$behavior_model->point;//增加积分后的总和
            //修改用户的积分
            Member::model()->updateByPk($user['mid'], array( 'points'=>$memberinfo['points']));
            MyCache::set('member_'.$user['mid'],$memberinfo);//刷新缓存
            echo json_encode(array('result'=>true,'code' => 200, 'mess' => $this->error_code[200])); exit;
        }else{
            echo json_encode(array('result'=>false,'code' => 502, 'mess' => $this->error_code[502])); exit;
        }
    }
    


 
}
