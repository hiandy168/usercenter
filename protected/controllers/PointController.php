<?php

class PointController extends FrontController {
  
    
    /**
     * 增加积分 
     */
    public function actionAdd($appid,$appkey,$openid,$type){
        
        
        
       $project_info = Project::model()->findByAttributes(array('appid'=>$apppid,'appkey'=>$appkey));
       //验证appid,appkey是否合法
       if($project_info){   
            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info->id,'openid'=>$openid));
            if($member_project_info){
                $member_info = Member::model()->findByPk($member_project_info->mid);               
                if($member_info){
                    $behavior_type = Member_behavior_type::model()->findByPk($type);
                    if (!$behavior_type) {
                        return 'undefine type';
                    }
                    $qty = $behavior_type->point;
                    //还需要添加pid下面是否有积分可以使用
                    $log = null;
                    $member_point_log = new Member_point_log();
                    $log['pid'] = $project_info->id;
                    $log['mid'] = $member_info->id;
                    $log['qty'] = $qty;
                    $log['type'] = $type;
                    $log['createtime'] = time();
                    $member_point_log->attributes = $log;
                    if($member_point_log->save()){
                        // Member::model()->updateByPk($member_info->id,array('points'=>$member_info->points+$qty));
                        Member::model()->updateCounters(array('points'=>$qty),'id="'.$member_info->id.'"');
                         $returnCode['status'] =1;
                         $returnCode['message'] = '积分添加成功';
                    }
                } else {
                    $returnCode['status'] =0;
                    $returnCode['message'] = '用户不存在';
                }
            } else {
                $returnCode['status'] =0;
                $returnCode['message'] = '非法请求';
            } 
       }
        return $returnCode; 
        
        
    }
    
    
    
    
    
    
}