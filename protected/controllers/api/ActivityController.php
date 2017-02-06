<?php

class ActivityController extends FrontController
{

    public $type;

    public function Init()
    {
        parent::init();

        $this->type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            3 => array("报名", "signup", "signup"),
            4 => array("投票", "vote", "vote"),
            5 => array("大转盘", "bigwheel", "bigwheel"),
            6 => array("海报", "poster", "poster"),
        );
    }

    /*
     * 活动推荐 列表接口  报名
     * */

    public function actionRecommend()
    {


        //根据推荐活动
        $page = Tool::getValidParam("page", 'integer');
        $num = Tool::getValidParam("num", 'integer', 10);
        $Activity_recommend = new Activity_recommend;

        $list = $Activity_recommend->apiActivityListPager();
        /*        $list=Activity_recommend::model()->findAll("type=:type and status=:status",array(":type"=>4,':status'=>1)); */
        $data = array();
        if ($list['criteria']) {
            $msg = array();
            foreach ($list['criteria'] as $key => $val) {
                $model = "Activity_" . $this->type[$val->type][2];
                $res = $model::model()->find("id=:id", array(":id" => $val->aid));
                if ($res) {
                    if ($res->start_time > time()) {
                        $msg['status'] = 1; //未开始
                    }
                    if ($res->end_time < time()) {
                        $msg['status'] = 2; //已结束
                    }
                    $msg['title'] = $res->title;
                    if ($val->type == 4) {//投票
                        if ($res->component == 0) {//报名
                            $msg['type'] = "报名";
                            $msg['linkDetail'] = $this->_siteUrl . "/activity/vote/views/id/$res->id";
                            $msg['address'] = $res->address;
                            $msg['desc'] = $res->desc;
                            $msg['background'] = $res->background;
                        } else {
                            $msg['type'] = $this->type[$val->type][0];
                            $msg['linkDetail'] = $this->_siteUrl . "/activity/" . $this->type[$val->type][1] . "/view/id/$res->id";
                        }
                    } else {
                        $msg['type'] = $this->type[$val->type][0];
                        $msg['linkDetail'] = $this->_siteUrl . "/activity/" . $this->type[$val->type][1] . "/view/id/$res->id";
                    }
                    $img= $res->img?$res->img:$res->share_img;
                    $msg['id'] = $res->id;
                    $msg['img'] = $img?$this->_siteUrl . "/" . $img:"";
                    $msg['start_time'] = $res->start_time;
                    $msg['end_time'] = $res->end_time;
                    $msg['address'] = "";
                    $msg['desc'] = "";
                    $msg['background'] ="";

                    $datas[] = $msg;
                }
            }
            $page=$page?$page-1:0;
            $page = $page * $num ? $page : 0;
            if ($datas) {
                $datapage = array_slice($datas, $page, $num);
                $data = array('code' => 1, 'data' => $datapage);
            } else {
                $data = array("code" => 0, 'data' => "There is no data");
            }
        } else {
            $data = array("code" => 0, 'data' => "There is no data");
        }

        $result = json_encode($data);
        echo "flightHandler($result)";
    }

}
