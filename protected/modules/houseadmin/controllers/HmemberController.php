<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:20
 */
class HmemberController extends HaController{

    /**
     * 用户管理列表页
     * author  Fancy
     */
    public function actionList(){
        $member=Mod::app()->session['admin_user'];
        $group_id=$member['group_id'];
        $application_class = House_activity::model();
        $criteria = new CDbCriteria();
        if($group_id==1){
            $criteria->condition = 'status=:status';
            $criteria->params = array(':status'=>1);
        }else{
            $criteria->condition = 'authorid=:authorid and status=:status';
            $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
        }
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $house= $application_class->findAll($criteria);
        $houseinfo = json_decode(CJSON::encode($house),TRUE);
        $tmp = array();
        foreach($houseinfo as $key=>$val){
            $sql = "SELECT count(id) as sign FROM {{house_order}} WHERE status=1 and houseid=".$val['id']." and (paystatus=2 or paystatus=3) ";
            $sign=Mod::app()->db->createCommand($sql)->queryRow();
            $sql = "SELECT count(id) as pay FROM {{house_order}} WHERE status=1 and houseid=".$val['id']." and paystatus=3";
            $pay=Mod::app()->db->createCommand($sql)->queryRow();
            $tmp[$key]['id'] = $val['id'];
            $tmp[$key]['title'] = $val['title'];
            $tmp[$key]['createtime'] = $val['createtime'];
            $tmp[$key]['author'] = $val['author'];
            $tmp[$key]['createtime'] = $val['createtime'];
            $tmp[$key]['sign'] = $sign['sign'];
            $tmp[$key]['pay'] = $pay['pay'];
        }
        $returnData['houslist']=$tmp;
        $returnData['pages'] = $pages;
        $returnData['group_id'] = $group_id;
        $this->render('list',$returnData);
    }

    /**
     * 参与用户数据
     * author  Fancy
     */
    public function actionUsermanage(){
        $houseid =Tool::getValidParam('id','integer');
        $member=Mod::app()->session['admin_user'];
        $group_id=$member['group_id'];
        $application_class = House_order::model();
        $criteria = new CDbCriteria();
        if($group_id==1){
            $criteria->condition = 't.status=:status and t.houseid=:houseid';
            $criteria->params = array(':status'=>1,':houseid'=>$houseid);
        }else{
            $criteria->condition = 't.authorid=:authorid and t.status=:status and t.houseid=:houseid';
            $criteria->params = array(':authorid'=>$member['id'],':status'=>1,':houseid'=>$houseid);
        }
        $criteria->order = 't.id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $returnData['houslist']= $application_class->with('member')->findAll($criteria);
        $returnData['pages'] = $pages;
        $returnData['group_id'] = $group_id;
        $this->render('usermanage',$returnData);
    }

    public function actionDel(){

    }



}