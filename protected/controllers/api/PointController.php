<?php

class PointController extends FrontController {
  
    
    /**
     * 增加积分 
     */
//    public function actionAdd(){
//        $openid = Tool::getValidParam('openid','string');
//        $appid = Tool::getValidParam('appid','string');
//        $appsecret = Tool::getValidParam('appsecret','string');
//        $type = Tool::getValidParam('type','string');
//        $sign = Tool::getValidParam('sign','string');//接口验证加密
//        
//        $screct = md5($openid.$appid.$appsecret.$type."this's a screct!");
//        //if ($screct!=$sign) {
//          //  exit('unsign');
//        //}
//        
//        $project_info = Jkcms::getProjectByidsecret($appid,$appsecret);
//       //验证appid,appsecret是否合法
//       if($project_info){   
//            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid));
//            if($member_project_info){
//                $member_info = Member::model()->findByPk($member_project_info->mid);               
//                if($member_info){
//                    $behavior_type = Member_behavior_type::model()->findByPk($type);
//                    if (!$behavior_type) {
//                        exit('undefine type');
//                    }
//                    $qty = $behavior_type->point;
//                    //还需要添加pid下面是否有积分可以使用
//                    $log = null;
//                    $member_point_log = new Member_point_log();
//                    $log['pid'] = $project_info['id'];
//                    $log['mid'] = $member_info->id;
//                    $log['qty'] = $qty;
//                    $log['type'] = $type;
//                    $log['createtime'] = time();
//                    $member_point_log->attributes = $log;
//                    if($member_point_log->save()){
//                        // Member::model()->updateByPk($member_info->id,array('points'=>$member_info->points+$qty));
//                        Member::model()->updateCounters(array('points'=>$qty),'id="'.$member_info->id.'"');
//                         $returnCode['status'] =1;
//                         $returnCode['message'] = '积分添加成功';
//                    }
//                } else {
//                    $returnCode['status'] =0;
//                    $returnCode['message'] = '用户不存在';
//                }
//            } else {
//                $returnCode['status'] =0;
//                $returnCode['message'] = '非法请求';
//            } 
//       }
//        echo json_encode($returnCode); 
//        
//        
//    }
    
    /**
     * 花费积分 
    */
    public function actionSpend(){
        $mopenid = Tool::getValidParam('mopenid','string');//mopenid是大楚网通行证的ID
//        $appid = Tool::getValidParam('appid','string');
//        $appsecret = Tool::getValidParam('appsecret','string');
        $point = Tool::getValidParam('point','string');

        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);

        //验证appid,appsecret是否合法
//        $project_info = Jkcms::getProjectByidsecret($appid,$appsecret);

        if($project_info){   
                //消费白名单
                $whitearr = array(101012);
                if(!in_array($project_info['appid'],$whitearr)){
                      echo json_encode(array('code'=>40004)); die;//未知错误
                }
                $member_point_log = new Member_point_log();
                $member_point_log->pid = $project_info['id'];
                $member_point_log->mid = $mopenid;
                $member_point_log->qty = '-'.abs($point);
                $member_point_log->type = 2;
                $member_point_log->createtime = time();
                $member_point_log->content = "积分兑换";
            if($member_point_log->save()){
                    // Member::model()->updateByPk($member_info->id,array('points'=>$member_info->points+$qty));
                    $res =Member::model()->updateCounters(array('points'=>'-'.abs($point)),'id="'.$mopenid.'"');
                    if($res){  
                        echo json_encode(array('code'=>200)); die; 
                    }
                }
        }
         
        echo json_encode(array('code'=>49999)); die;//未知错误
        

    }


    /**
     * 获取用户个人积分信息
     */
    public function actionGetMemberPoints(){
//        $appid = Tool::getValidParam('appid','string');
//        $appsecret = Tool::getValidParam('appsecret','string');
        $member_id = Tool::getValidParam('member_id','string');


//        $project_info = Jkcms::getProjectByidsecret($appid,$appsecret);

        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);
        if($project_info){
            //消费白名单
            $whitearr = array(101012);
            if(!in_array($project_info['appid'],$whitearr)){
                echo json_encode(array('code'=>400,'message'=>'非法请求')); die;//未知错误
            }
            $sql = "SELECT * FROM {{member}} WHERE id=".$member_id;
            $member_info = Mod::app()->db->createCommand($sql)->queryRow();
            echo json_encode(array('code'=>200,'data'=>$member_info)); die;

        }

        echo json_encode(array('code'=>400,'message'=>'非法请求')); die;//错误


    }

    /**
     * 获取用户个人积分记录
     */
    public function actionGetMemberPointsLog(){
//        $appid = Tool::getValidParam('appid','string');
//        $appsecret = Tool::getValidParam('appsecret','string');
        $member_id = Tool::getValidParam('member_id','string');

        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);
//        $project_info = Jkcms::getProjectByidsecret($appid,$appsecret);


        if($project_info){
            //消费白名单
            $whitearr = array(101012);
            if(!in_array($project_info['appid'],$whitearr)){
                echo json_encode(array('code'=>400,'message'=>'非法请求')); die;//未知错误
            }
            $sql = "SELECT * FROM {{member_point_log}} WHERE mid=".$member_id." order by  createtime desc";

            $arr = Mod::app()->db->createCommand($sql)->queryAll();
            echo json_encode(array('code'=>200,'data'=>$arr)); die;

        }

        echo json_encode(array('code'=>400,'message'=>'非法请求')); die;//错误


    }

    
}