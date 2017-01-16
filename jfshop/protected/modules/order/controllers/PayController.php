<?php

/**
 * 订单支付
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */
class PayController extends BaseController
{
    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
    }

//    /**
//     * 订单支付
//     */
//    public function actionIndex()
//	{
//        $order_id = Tool::getValidParam('order_id');
//        $order_info = Orders::model()->find('order_id = :order_id',array(':order_id'=>$order_id));
//
//        echo $this->renderPartial('index',array('order_id'=>$order_id,'order_info'=>$order_info),true);
//	}
//
//    /**
//     * 订单支付创建
//     */
//    public function actionCreate()
//    {
//        $order_id = Tool::getValidParam('order_id');
//        $payments_attributes = Tool::getValidParam('Payments');
//        $payments_attributes['pay_name'] = Mod::app()->params['pay_app_id'][$payments_attributes['pay_app_id']];
//
//        $Payments = new Payments();
//        $result = $Payments->OrderPayment($order_id,$payments_attributes);
//
//        echo json_encode($result);
//    }

    /**
     * 订单退款
     */
    public function actionRefund()
    {
        $order_id = Tool::getValidParam('order_id','int');
        $order_info = Orders::model()->find('order_id = :order_id',array(':order_id'=>$order_id));

        echo $this->renderPartial('refund',array('order_id'=>$order_id,'order_info'=>$order_info),true);
    }

    /**
     * 订单退款创建
     */
    public function actionRefundcreate()
    {
        $order_id = Tool::getValidParam('order_id','int');
        $refunds_attributes = Tool::getValidParam('Refunds');
        $refunds_attributes['pay_name'] = Mod::app()->params['pay_app_id'][$refunds_attributes['pay_app_id']];

        $Payments = new Payments();
        $result = $Payments->OrderRefund($order_id,$refunds_attributes);

        echo json_encode($result);
    }

}