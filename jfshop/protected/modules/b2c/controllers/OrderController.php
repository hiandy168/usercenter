<?php
/**
 * 订单管理
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class OrderController extends B2cController
{
    public function init()
    {
        if (!$this->username) $this->redirect('/account/login');
    }

    /**
     * 我的订单
     */
    public function actionIndex()
    {
        $Order = new ModelOrder();
        $status = Tool::getValidParam('status');
        $model['pay_status'] = $pay_status = Tool::getValidParam('pay_status','bool');
        $model['ship_status'] =  $ship_status = Tool::getValidParam('pay_status','bool');
        $model['order_list'] = $Order->OrderList($this->member_id,0,15,$status,$pay_status,$ship_status);

        $this->render('index',array('model'=>$model));
    }

    /**
     * 订单详情
     */
    public function actionDetail()
    {
        $order_id = Tool::getValidParam('order_id');

        $Order = new ModelOrder();
        $model['order_info'] = $Order->orderDetail($order_id);
        $model['order_product'] = $Order->OrderProduct($order_id);

        $this->render('detail',array('model'=>$model));
    }
} 