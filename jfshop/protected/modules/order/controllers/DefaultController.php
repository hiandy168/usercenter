<?php

/**
 * 订单管理
 *
 */
class DefaultController extends BaseController
{
    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
    }

    public function init()
    {
        $this->registerJs(array('oct/order/order'));
    }

    /**
     * 订单列表
     */
    public function actionIndex()
	{

        $pageIndex = Tool::getValidParam('page','int')?Tool::getValidParam('page','int'):1;
        $view = Tool::getValidParam('view','int')?Tool::getValidParam('view','int'):0;
        $goods_id = Tool::getValidParam('goods_id','int')?Tool::getValidParam('goods_id','int'):0;
        $start_date = Tool::getValidParam('start_date')?Tool::getValidParam('start_date'):0;
        $over_date = Tool::getValidParam('over_date')?Tool::getValidParam('over_date'):0;
        $start_date=strtotime($start_date)?strtotime($start_date):0;
        $over_date=strtotime($over_date)?strtotime($over_date):0;

        $conditionArr = array();
        //待发货 pay_status:1;ship_status:0
        if ($view == 0) $conditionArr = array('t.pay_status'=>1,'t.ship_status'=>0);

        //已发货 ship_status:1
        if ($view == 1) $conditionArr = array('t.ship_status'=>1);

        //待支付 pay_status:0
        if ($view == 2) $conditionArr = array('t.pay_status'=>0);

        //已支付到担保方 pay_status:2
        if ($view == 3) $conditionArr = array('t.pay_status'=>2);

        //已支付 pay_status:1
        if ($view == 4) $conditionArr = array('t.pay_status'=>1);

        //货到付款
        if ($view == 5) $conditionArr = array('t.pay_status'=>10);

        //活动 status:active
        if ($view == 6) $conditionArr = array('t.status'=>'active','t.pay_status'=>0);

        //已作废 status:dead
        if ($view == 7) $conditionArr = array('t.status'=>'dead');

        //已完成 status:finish
        if ($view == 8) $conditionArr = array('t.status'=>'finish');

        //全部
        if ($view == 9) $conditionArr = array();


        if($goods_id!=0){
            $tmp_arr=array();
            $conditionArr['goods.goods_id']=$goods_id;
        }
        if($start_date!=0){
            $tmp_arr=array();
            $conditionArr['t.create_time']=$start_date;
            $start_showdate=date('Y-m-d',$start_date);
        }
        if($over_date!=0){
            $tmp_arr=array();
            $conditionArr['t.over_time']=$over_date;
            $over_showdate=date('Y-m-d',$over_date);
        }
        $sql="select * from car_b2c_goods where disabled='false' and marketable='true'";
        $goods_all= Mod::app()->db->createCommand($sql)->queryAll();

        
        $Order = new Orders();
        $result = $Order->orderList($conditionArr,$pageIndex,$this->pagesize);

        $order_list = array();
        foreach ($result['items'] as $k=>$v) {
            $v['member_info']=$Order->member_info($v['member_id']);
            $order_list[$k] = $v;
            $order_list[$k]['pay_status_name'] = Params::PayStatus($v['pay_status']);
            $order_list[$k]['ship_status_name'] = Params::ShipStatus($v['ship_status']);
            $order_list[$k]['member_name'] = Params::PamMember($v['member_id']);
        }

        //分页
        $pages = new CPagination($result['count']);

		$this->render(
            'index',
            array(
                'goods_id'=>$goods_id,
                'start_date'=>$start_showdate,
                'over_date'=>$over_showdate,
                'view'=>$view,
                'goods_all'=>$goods_all,
                'dataProvider'=>$order_list,
                'view'=>$view,
                'pages' => $pages,
                'pageIndex'=>$pageIndex-1,
                'page'=>$pageIndex,
            )
        );
	}

    //
    public function actionExportCsv(){
        Mod::import('ext.ECSVExport');

        $pageIndex = Tool::getValidParam('page','int')?Tool::getValidParam('page','int'):1;
        $view =Tool::getValidParam('view','int')?Tool::getValidParam('view','int'):0;
        $goods_id = Tool::getValidParam('goods_id','int')?Tool::getValidParam('goods_id','int'):'false';
        $start_date = Tool::getValidParam('start_date')?Tool::getValidParam('start_date'):0;
        $over_date = Tool::getValidParam('over_date')?Tool::getValidParam('over_date'):0;
        $start_date=strtotime($start_date)?strtotime($start_date):0;
        $over_date=strtotime($over_date)?strtotime($over_date):0;

        $conditionArr = array();
        //待发货 pay_status:1;ship_status:0
        if ($view == 0) $conditionArr = array('pay_status'=>1,'ship_status'=>0);

        //已发货 ship_status:1
        if ($view == 1) $conditionArr = array('ship_status'=>1);

        //待支付 pay_status:0
        if ($view == 2) $conditionArr = array('pay_status'=>0);

        //已支付到担保方 pay_status:2
        if ($view == 3) $conditionArr = array('pay_status'=>2);

        //已支付 pay_status:1
        if ($view == 4) $conditionArr = array('pay_status'=>1);

        //货到付款
        if ($view == 5) $conditionArr = array('pay_status'=>10);

        //活动 status:active
        if ($view == 6) $conditionArr = array('status'=>'active','pay_status'=>0);

        //已作废 status:dead
        if ($view == 7) $conditionArr = array('status'=>'dead');

        //已完成 status:finish
        if ($view == 8) $conditionArr = array('status'=>'finish');

        //全部
        if ($view == 9) $conditionArr = array();

        if($goods_id!=0){
            $tmp_arr=array();
            $conditionArr['goods.goods_id']=$goods_id;
        }
        if($start_date!=0){
            $tmp_arr=array();
            $conditionArr['t.create_time']=$start_date;
        }
        if($over_date!=0){
            $tmp_arr=array();
            $conditionArr['t.over_time']=$over_date;
        }
        $Order = new Orders();
        $result = $Order->orderList($conditionArr,$pageIndex,$this->pagesize);

        $order_list = array();
        if($result['count']>0){
        foreach ($result['items'] as $k=>$v) {
            $v['member_info']=$Order->member_info($v['member_id']);
            $order_list[$k] = $v;
            $order_list[$k]['pay_status_name'] = Params::PayStatus($v['pay_status']);
            $order_list[$k]['ship_status_name'] = Params::ShipStatus($v['ship_status']);
            $order_list[$k]['member_name'] = Params::PamMember($v['member_id']);
            $tmp_arr[$k]['订单号']= $v['order_id']."\t";
            $tmp_arr[$k]['会员名']= $v['member_info']['name'];
            $tmp_arr[$k]['下单时间']= date('Y-m-d H:i:s',$v['createtime']);
            $tmp_arr[$k]['更新时间']= date('Y-m-d H:i:s',$v['updatetime']);
            $tmp_arr[$k]['收货人']= $v['ship_name'];
            $tmp_arr[$k]['收货手机']= $v['ship_mobile'];
            $tmp_arr[$k]['收货地区']= $v['ship_area'];
            $tmp_arr[$k]['订单总额']= $v['score_u']."积分";
            $tmp_arr[$k]['付款状态']= Params::PayStatus($v['pay_status']);
            $tmp_arr[$k]['支付方式']= $v['payment'];
            $tmp_arr[$k]['发货方式']= Params::ShipStatus($v['ship_status']);
            $tmp_arr[$k]['来源']= $v['source'];


        }
        }else{
            $tmp_arr=array();
        }
//        var_dump($tmp_arr);exit;
        //生成cvs文件
        $csv = new ECSVExport($tmp_arr);
        $output = $csv->toCSV();
        Mod::app()->getRequest()->sendFile('订单列表.csv', $output, "text/csv", false);
        exit();
    }
}