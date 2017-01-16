<?php

class Data2meController extends FrontController {
       
    //武汉交警导入数据
    public function actionIndex() {
        $pid = 8;
        $sql = 'SELECT * FROM `t_traffic_feedback_1` where FStatus="1" limit 1';
        
        $result = Mod::app()->db->createCommand($sql)->queryRow(); 

        if ($result['FCellphone']) {
            $regtime = strtotime($result['FUpdateTime']);
            $sql = 'SELECT * FROM `t_traffic_users_6` where `FOpenId`="'.$result['FOpenId'].'" ';
            
            $traffic = Mod::app()->db->createCommand($sql)->queryRow(); 
            var_dump($traffic['FCarNumber']);
            if (!$traffic['FCarNumber']) {
                file_put_contents('/tmp/up.log', $result['FCellphone']."\r\n");   
            } else {
                file_put_contents('/tmp/p.log', $result['FCellphone']."\r\n");  
            }
            $sql = 'SELECT * FROM `dym_member` where `name`="'.$result['FCellphone'].'"';
            $check = Mod::app()->db->createCommand($sql)->queryRow();
            
            if (!$check) {
              $sql = 'insert into `dym_member` (name,phone,username,carnumber,regtime,createtime) values ("'.$result['FCellphone'].'","'.$result['FCellphone'].'","","'.$traffic['FCarNumber'].'","'.$regtime.'","'.$regtime.'")';
              echo $sql;
              Mod::app()->db->createCommand($sql)->execute();
              $lastid = Mod::app()->db->getLastInsertID();
            } else {
                $lastid = $check['id'];
                $sql = 'update `dym_member` set carnumber="'.$traffic['FCarNumber'].'" where id="'.$lastid.'"';
                Mod::app()->db->createCommand($sql)->execute();
            }
            echo $lastid;
            $sql = 'insert into `dym_member_project` (mid,pid,openid,createtime) values ("'.$lastid.'","'.$pid.'","'.$result['FOpenId'].'","'.$regtime.'")';
            echo $sql;
            Mod::app()->db->createCommand($sql)->execute();
            
            $sql = 'update `t_traffic_feedback_1` set FStatus=0 where FId="'.$result['FId'].'"';
            Mod::app()->db->createCommand($sql)->execute();
        }
       
        
        
        
    }
    
    
    public function actionCxg() {
        $sql = 'SELECT * FROM `weiqin_cg_hongbao_winning` where `status`="0" limit 1';
        $result = Mod::app()->db->createCommand($sql)->queryRow(); 
        if (!$result) {
            exit;
        }
        if ($result['openid']) {
            $sql = 'SELECT * FROM `dym_member_project` where `openid`="'.$result['openid'].'" limit 1';
            $minfo = Mod::app()->db->createCommand($sql)->queryRow();   
            if($minfo['mid']) {
                $arr = array('card'=>'卡卷','prize'=>'奖品','cash'=>'现金');
                
                $year = date('Y',$result['ctime']);
                $month = date('m',$result['ctime']);
                $day = date('d',$result['ctime']);
                
                $sql = 'insert into `dym_member_behavior` (openid,mid,pid,type,year,month,day,createtime) values ("'.$result['openid'].'","'.$minfo['mid'].'","1","4","'.$year.'","'.$month.'","'.$day.'","'.$result['ctime'].'")';
              echo $sql;
              Mod::app()->db->createCommand($sql)->execute();
              
              $sql = 'insert into `dym_member_behavior_activity` (openid,mid,pid,activity_title,createtime) values ("'.$result['openid'].'","'.$minfo['mid'].'","1","储蓄罐活动","'.$result['ctime'].'")';
              echo $sql;
              Mod::app()->db->createCommand($sql)->execute();
              $code =null;
              if ($result['code']) {
                  $code = '<br/>兑换码'.$result['code'];
              }
              $sql = 'insert into `dym_member_behavior_prize` (openid,mid,pid,winning,createtime) values ("'.$result['openid'].'","'.$minfo['mid'].'","1","'.$arr[$result['type']].$code.'","'.$result['ctime'].'")';
              echo $sql;
              Mod::app()->db->createCommand($sql)->execute();
            }
        }
        $sql = 'update `weiqin_cg_hongbao_winning` set `status`=1 where id="'.$result['id'].'"';
        Mod::app()->db->createCommand($sql)->execute();        
        
    }

    
    
}

