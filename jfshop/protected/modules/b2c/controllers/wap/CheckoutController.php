<?php
/**
 * 订单确认管理
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class CheckoutController extends B2cController
{
    public $layout=false;
     
    public function init()
    {        
        parent::init();
        if (!$this->member_id){
            $this->redirect($this->_siteUrl.'/b2c/wap/account/login');
        }
    }

    /**
     * 订单提交
     */
    public function actionIndex()
    {
       //1. var_dump(Mod::app()->cache->get('b2c-cart-product-set-31'));exit;
        $Cart = new ModelCart();

        $result = $Cart->CardIdentProduct($this->member_id);
        if ($result['code'] == 400 || empty($result)) $this->redirect($this->_siteUrl);

        
        $item = $result['data'];

        if ($item){
            $num = count($item);
            $amount_price = $amount_price_jifen = 0;
            if($num){
                foreach($item as $i){
                    if($i['paytype']==3) {
                        $amount_price_jifen = $amount_price_jifen+$i['price_jifen']*$i['quantity'];
                    }else{
                        $amount_price = $amount_price + $i['price']*$i['quantity'];
                    }
                }
            }
            $amount =  array('amount_price'=>sprintf('%01.2f',$amount_price),'amount_price_jifen'=>$amount_price_jifen);
        }else{
            $items = $total = $num = $amount =0;
        }


        $this->render('checkout',
            array(
                'item'=>$item,
                'amount'=>$amount,
            )
        );
    }

    /**
     * 订单提交
     */
    public function actionSubmit()
    {
        $data['payment'] = Tool::getValidParam('payment', 'string','alipay');
        $data['remark'] = addslashes(Tool::getValidParam('remark', 'string'));

        $Order = new ModelOrder();

        $result = $Order->Create($this->member_id,$data);  //创建订单

        if($result['code']== 200){
            echo  json_encode(array('code'=>200,'order_id'=>$result['order_id']));
        } else if($result['code']== 404){
            echo json_encode(array('code'=>0,'mess'=>'积分不足'));
        }else if($result['code']== 405){
            echo json_encode(array('code'=>-1,'mess'=>'有部分商品价格发生了改变'));
        }else {
             echo json_encode(array('code'=>0,'mess'=>'提交失败'));
        }
    }
    
    /**
     * 订单支付
     */
    public function actionPayment(){
//        $_POST['orderid'] = '2016062450579949';
        $data['paynum'] = Tool::getValidParam('paynum', 'string',''); //直接兑换用的参数
        $data['orderid'] = Tool::getValidParam('orderid', 'string','');
        if(!ctype_digit($data['orderid'])){ die('数据不合法');  }
         
        $Order = new ModelOrder();
        $payment_no = $Order->payment_no(); 
        $res = $Order->OrderPayment($data['orderid'],$payment_no,$data['paynum']);

        if($res['code']==1){
            echo "<script>alert('购买成功！');window.location.href='".Mod::app()->request->hostInfo ."/jfshop/b2c/wap/account/order_jf.html'</script>";
        }else{
            echo  $res['mess'];die;
        }

       
    }
    
    
    public function actionTestpoint(){
          $this->Payment_point('2016062450579949');
    }

//    public function Payment_point($orderid){
//
//        if($orderid && !ctype_digit($orderid)){
//           return  array('code'=>'4001','mess'=>'订单号不合法');
//        }
//        $Ordermodel =  new ModelOrder();
//        $orderinfo = $Ordermodel->Row("order_id = {$orderid} and member_id ={$this->member_id}");
//
////        echo $orderinfo['score_u'];
//
//        //通过接口扣除大楚通行证的积分
//        $url = Myconfig::DACHUHOST.'/api/point/spend';
//        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
//        $dachu->Get_token();
//        $res = $dachu->pointspend($this->member_id, $orderinfo['score_u']);
//        if($res['code']==200){
//            return array('code'=>'200','order_id'=>$orderid);
//            //积分支付成功
//        }else{
//            return array('code'=>-1,'mess'=>'积分支付失败');
//        }
////         var_dump($res);
//
//
//
////        var_dump($orderinfo);
////        die;
//        // 通过接口扣除积分
//
//
//
//    }
}