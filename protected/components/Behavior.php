<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/29
 * Time: 17:21
 */
class Behavior
{


    public static  function behavior_points($behaviorid,$mid,$pid,$name,$win,$aid,$tablename)
    {/* 向数据库中添加用户操作 */
        //根据行为ID和pid查询 是什么操作和可得到的积分
        $behavior_model = Member_behavior_type::model()->findByPk($behaviorid);
        if (!$behavior_model) {
            return array( 'code' => 400, 'mess' => 'fail no behavior ');
        }
        isset($_SERVER['REMOTE_ADDR'])? $addr=$_SERVER['REMOTE_ADDR']:$addr='127.0.0.1';

        $member_behavior = new Member_behavior();
        $member_behavior->remark = '';
        $member_behavior->mid = $mid;
        $member_behavior->pid = $pid;
        $member_behavior->aid = $aid;
//        $member_behavior->openid=$openid;
        $member_behavior->point = $behavior_model->point;
        $member_behavior->type = $behavior_model->id;
        $member_behavior->year = date('Y', time());
        $member_behavior->month = date('m', time());
        $member_behavior->day = date('d', time());
        $member_behavior->ip = $addr;
        $member_behavior->createtime = time();
        $member_behavior->win_name = $name;
        $member_behavior->win = $win;
        $member_behavior->tablename = $tablename;

        $res = $member_behavior->save();

        if ($res) {
            //根据行为操作给用户添加积分
            //先查询用积分
            $memberinfo = Member::model()->findByPk($mid)->attributes;
            $memberinfo['points'] =(int)$memberinfo['points'] + (int)$behavior_model->point;//增加积分后的总和
//            return array( 'code' => 200, 'mess' => $memberinfo['points']);
            //修改用户的积分
            Member::model()->updateByPk($mid, array('points' => $memberinfo['points']));
            MyCache::set('member_' . $mid, $memberinfo);//刷新缓存
            return array( 'code' => 200, 'mess' => $mid,'points'=>$behavior_model->point);
        } else {
            return array( 'code' => 502, 'mess' => 'fail');
        }

    }
}

