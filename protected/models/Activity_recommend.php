<?php

class Activity_recommend extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{activity_recommend}}';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array();
    }

    //活动列表带分页
    public function getActivityListPager()
    {
        $as_list = array();
        $list = null;
        $asModel = new Activity_recommend;
        $criteria = new CDbCriteria();
        $criteria->order = 'createtime DESC';
        $criteria->condition = 'status=1';
        $count = $asModel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;
        $as_list['pagebar'] = $pages;
        $as_list['criteria'] = $asModel->findAll($criteria);
        return $as_list;
    }

    //活动列表带分页
    public function apiActivityListPager($page,$num){
        $as_list = array();
        $list = null;
        $asModel = new Activity_recommend;
        $criteria = new CDbCriteria();
        $criteria->order = 'createtime DESC';
        $criteria->condition ='status=:status';
        $criteria->params =array(':status'=>1);
        $count = $asModel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = $num;
        $criteria->limit = $pages->pageSize;
        $criteria->offset =  $page * $pages->pageSize;//$pages->currentPage * $pages->pageSize;
        $as_list['count'] = $count;
        $as_list['criteria'] = $asModel->findAll($criteria);
        return $as_list;
    }



    /*
     * 活动推荐列表带url 奖励积分  分类  活动点击量*/
    public function getRecommendList($datetime)
    {
        //名称，控制器方法，表名
        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            3 => array("报名", "signup", "signup"),
            4 => array("投票", "vote", "vote"),
            5 => array("大转盘", "bigwheel", "bigwheel"),
            6 => array("海报", "poster", "poster"),

        );
        //根据时间 查找数据   最近一天   最近三天  最近一周  最近半个月


        if ($datetime) {
            $where = " where status=1 AND start_time > " . $datetime . " ORDER BY id DESC";
        } else {
            $where = " where status=1 ORDER BY id DESC";
        }
        $sql = "SELECT * FROM {{activity_recommend}} $where";
        $recommend = Mod::app()->db->createCommand($sql)->queryAll();

        foreach ($recommend as $k => $v) {
            $recommend[$k]['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/activity/' . $type[$v['type']][1] . '/view/id/' . $v['aid'];
            if ($v['type'] == 2 || $v['type'] == 5) {
                $name = "抽奖";
            } else {
                $name = $type[$v['type']][0];
            }
            //查询奖励积分
            $sql = "SELECT * FROM {{member_behavior_type}} where name=" . '\'' . $name . '\'';
            $result = Mod::app()->db->createCommand($sql)->queryRow();
            if ($result) {
                $recommend[$k]['rule'] = $result['rule'];
                $recommend[$k]['point'] = $result['point'];
            }
            //查询点击量及参与人数
            $sql = " SELECT * FROM {{activity_click}} WHERE aid = " . $v['aid'] . " AND pid=" . $v['pid'];
            $pv = Mod::app()->db->createCommand($sql)->queryRow();

            $recommend[$k]['pv'] = $pv['pv'];
            $recommend[$k]['uv'] = $pv['uv'];

            //活动所属分类
            //组件
            $tablename = $type[$v['type']][2];
            $sql = " SELECT * FROM {{activity}} WHERE activity_table_name =" . '\'' . $tablename . '\'';
            $re = Mod::app()->db->createCommand($sql)->queryRow();
            //查找分类
            if ($re) {
                $class = Activity_class::model()->findByPk($re['cid']);
                $recommend[$k]['class'] = $class->class_name;
            }


        }

        return $recommend;
    }

    //活动推荐列表按 分类查看
    public function getRecommendClassList($classid)
    {
        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            3 => array("报名", "signup", "signup"),
            4 => array("投票", "vote", "vote"),
            5 => array("大转盘", "bigwheel", "bigwheel"),
            6 => array("海报", "poster", "poster"),
        );

        $sql = " SELECT * FROM {{activity}} WHERE cid = " . $classid;
        $re = Mod::app()->db->createCommand($sql)->queryAll();
        // $tablename= $type[$v['type']][2];activity_table_name

        if ($re) {
            $activityList=array();
            foreach ($re as $key => $value) {
                foreach ($type as $k => $v) {
                    if (in_array($value['activity_table_name'], $v)) {

                        $sql = "SELECT * FROM {{activity_recommend}} where status=1  AND type=" . $k . " order by id desc";
                        $recommend = Mod::app()->db->createCommand($sql)->queryAll();
                        if ($recommend) {
                            foreach ($recommend as $k => $v) {
                                $recommend[$k]['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/activity/' . $type[$v['type']][1] . '/view/id/' . $v['aid'];
                                if ($v['type'] == 2 || $v['type'] == 5) {
                                    $name = "抽奖";
                                } else {
                                    $name = $type[$v['type']][0];
                                }
                                //查询奖励积分
                                $sql = "SELECT * FROM {{member_behavior_type}} where name=" . '\'' . $name . '\'';
                                $result = Mod::app()->db->createCommand($sql)->queryRow();
                                if ($result) {
                                    $recommend[$k]['rule'] = $result['rule'];
                                    $recommend[$k]['point'] = $result['point'];
                                }
                                //查询点击量及参与人数
                                //点击量
                                $sql = " SELECT * FROM {{activity_click}} WHERE aid = " . $v['aid'] . " AND pid=" . $v['pid'];
                                $pv = Mod::app()->db->createCommand($sql)->queryRow();
                                //参与人数

//                            $table="activity_".$type[$v['type']][2]."_user";
//                             $sql = " SELECT * FROM {{$table}} WHERE mid = " . $v['aid'] . " AND pid=" . $v['pid'];
//                             $pv = Mod::app()->db->createCommand($sql)->queryRow();
//
                                $recommend[$k]['pv'] = $pv['pv'];
                                $recommend[$k]['uv'] = $pv['uv'];
                                $class = Activity_class::model()->findByPk($classid);
                                $recommend[$k]['class'] = $class->class_name;
                            }
                            $activityList[]=$recommend;
                        }
                    }
                }
            }

            return $activityList;
        }
        return false;

    }


}
