<?php

class NewAppController extends FrontController
{
    //我的日历
    public function actionIndex()
    {
        //活动推荐列表
       // $recommendlist = Activity_recommend::model()->getActivityListPager();
        $classid = Tool::getValidParam('classid', 'integer');
        $date = Tool::getValidParam('datetime', 'string');
        switch ($date) {
            case "day":
                $datetime= strtotime('-1 day');
                break;
            case "three":
                $datetime= strtotime('-3 day');
                break;
            case "week":
                $datetime=strtotime('-1 week');
                break;
            case "month":
                $datetime=strtotime('-1 month');
                break;
            default :
                $datetime=strtotime('-1 year');
        }
        if ($classid) {
            $refult = Activity_recommend::model()->getRecommendClassList($classid);
            $recommendlist="";
            foreach($refult as $k=>$v){
                foreach($v as $key=>$val){
                    $recommendlist[]=$val;
                }
            }
            //返回结果为二维数组，
            $selected = $classid;//选中效果
        } else {
            $recommendlist = Activity_recommend::model()->getRecommendList($datetime);
        }

        $data = array(
            'config' => array('site_title' => '城市日历'),
            'recommendlist' => $recommendlist,
            'selected' => $selected,
        );
        $this->render('index', $data);
    }


}