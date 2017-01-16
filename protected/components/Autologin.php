<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/8
 * Time: 10:37
 */
class Autologin 
{


    /*
    * 自动登录地址
    */
    public static function actionAutoLogin(){
        $openid =  Tool::getValidParam('openid', 'string');
        $redirect =  Tool::getValidParam('redirect', 'string');
        $appid =  Tool::getValidParam('appid', 'string');
        $sign =  Tool::getValidParam('sign', 'string');
        $timestamp =  Tool::getValidParam('timestamp', 'string');
        $headimg =  urldecode(Tool::getValidParam('avatar', 'string'));  //微信头像


        // $a=array( "openid"=>$openid,"appid"=>$appid,"timestamp"=>$timestamp,'redirect'=>urlencode($redirect));
        // var_dump($a);exit;
        //1 根据APPID查project表
        $projectinfo=Project::model()->findByAttributes(array('appid'=>$appid));

        $appsecret=$projectinfo->appsecret;

        //签名参数
        $params=array("openid"=>$openid,"appid"=>$appid,"appsecret"=>$appsecret,"timestamp"=>$timestamp,'redirect'=>$redirect);
        // $newsign = Tool::sign($params);
        // echo $sign;
        // echo '<br>';
        // echo $newsign;
        // echo '<br>';
        // echo $redirect;die;

        $params['sign'] = $sign;

        // echo "sign1: ".md5($sign)."<br>sign2: <br>";
        $res  = Tool::signVerify($projectinfo->appsecret,$params);

        //验证$sgin失效验证
        if(!$res){
            //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40005;
            $returnCode['mess'] = urlencode($returnCode['code']);

            echo urldecode(json_encode($returnCode));exit;
        }
        //根据timestamp验证$sgin  5分钟失效验证 


        //根据openid 和appid判断用户
        $Member_projectinfo=Member_project::model()->findByAttributes(array('pid'=>$projectinfo->id,'openid'=>$openid));

        if(empty($Member_projectinfo)){//新用户
            //帮他做注册  设置未激活status=0
            $member_model = new Member();
            $member_model->name ='匿名用户'.date('MDHi',time());
            $member_model->regtime = time();
            $member_model->regip = Mod::app()->request->userHostAddress;
            $member_model->status = 0;
            $member_model->headimgurl = $headimg;
            $member_model->save();
            $member_id= Mod::app()->db->getLastInsertID();
            $member_info= $member_model->attributes;
            $member_info['id'] = Mod::app()->db->getLastInsertID();

            //绑定mid,openid,pid
            $member_project_model = new Member_project();
            $member_project_model->mid = $member_id;
            $member_project_model->pid = $projectinfo->id;
            $member_project_model->openid = $openid;
            $member_project_model->status = 1;
            $member_project_model->createtime = time();
            $member_project_model->save();
            $status = 0;

            //注册的行为
            Autologin::regbehavior($member_model->id, $projectinfo->id);

        }else{
            $member_model=Member::model()->findByPk($Member_projectinfo->mid);
            $member_info= $member_model->attributes;
            Member::model()->updateAll(array('headimgurl' =>$headimg ), 'id =' . $Member_projectinfo->mid);
            //插入行为表(注册得积分)
            $win = 0;
            $name = "";
            if(date("Y-m-d",$member_model->attributes['lastlogintime']) != date("Y-m-d",time()) ){
                $res=Behavior::behavior_points(2,$member_model->id,$projectinfo->id,$name,$win,0,'null');
                if($res['code']==200) {
                    $jifen = array(
                        'pid' => $projectinfo->id,
                        'mid' => $member_model->id,
                        'qty' => $res['points'],
                        'type' => 1,
                        'createtime' => time(),
                        'content' => '登录',
                    );
                    $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);

                    $sql = " UPDATE {{member}} SET lastlogintime = ".time()." WHERE id = ".$member_model->id;

                    $res = Mod::app()->db->createCommand($sql)->execute();

                }
            }

            $status = $member_model->status;
        }

        // session 存储用户

        Mod::app()->session['member'] = $member_info;

        // session 存储用户房钱关联的项目
        $member_project = array();
        $member_project['openid'] = $openid;
        $member_project['pid'] = $projectinfo->id;
        $member_project['mid'] = $member_info['id'];
        Mod::app()->session['member_project'] = $member_project;

//        $this->redirect(urldecode($redirect));
    }

    //注册行为
    public static function regbehavior($mid,$pid){
        //插入行为表(注册得积分)
        $win = 0;
        $name = "";

        $res = Behavior::behavior_points(1, $mid, $pid, $name, $win, 0, 'null');
        if ($res['code'] == 200) {
            $jifen = array(
                'pid' => $pid,
                'mid' => $mid,
                'qty' => $res['points'],
                'type' => 1,
                'createtime' => time(),
                'content' => '注册',
            );
            $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);
        }
    }
}