<?php
/**
 * 订单支付
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class PayController extends B2cController
{
    public function init()
    {
        if (!$this->username) $this->redirect('/account/login');
    }
} 