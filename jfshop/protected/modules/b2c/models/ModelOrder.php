<?php
/**
 * 订单处理模型类.
 *
 
 
 
 * @package       yiishop.model
 * @license       http://www.yiitian.com/license
 
 */

class ModelOrder extends B2cModel
{
    
    public function Row($condition=''){

        $sql = "SELECT * FROM {{b2c_orders}} ";
        if ($condition) $sql .= ' WHERE '.$condition;

        return $this->ModelQueryRow($sql);
    }
    
    
    
    /**
     * 查询订单列表
     * @param string $select
     * @param $condition
     * @param int $is_page
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function items($select="*",$condition='',$is_page=0,$start=0,$limit=10)
    {
        $sql = "SELECT {$select} FROM {{b2c_orders}}";
        if ($condition) $sql .= ' WHERE '.$condition;
        $sql .= " ORDER BY createtime DESC";
        if ($is_page) $sql .= " LIMIT {$start},{$limit}";
        return $this->ModelQueryAll($sql);
    }

    /**
     * 获取积分兑换信息
     */
    public function GetPro($order_id,$select="*"){
        $sql = "SELECT {$select} FROM {{b2c_orders_items}} a ,{{b2c_goods}} b WHERE a.order_id = '{$order_id}' AND  a.goods_id=b.goods_id ";
        return $this->ModelQueryAll($sql);
    }


    /**
     * 获取图片
     */
    public function GetImg($goods_id){
        $attach = $this->ModelQueryAll("SELECT * FROM car_image_image_attach WHERE target_id IN ('{$goods_id}')");

        $image_id = array();
        foreach ($attach as $v) {
            $image_id[] = $v['image_id'];
        }

        $image = array();
        if (!empty($image_id)) $image = $this->ImageIds($image_id);

        return $image;
    }

    /**
     * 根据image_ids 获取图片
     *
     * @param $image_id
     * @return mixed
     */
    public function ImageIds($image_id)
    {
        foreach ($image_id as $v) {
            $image_id_Arr[] = "'".$v."'";
        }

        $image_ids = implode(',',$image_id_Arr);

        return $this->ModelQueryAll("SELECT * FROM car_image_image WHERE image_id IN ({$image_ids})");
    }

    /**
     * 根据image_id 获取默认图片
     *
     * @param $image_id
     * @return mixed
     */
    public function ImageDeafultId($image_id)
    {
      

        return $this->ModelQueryRow("SELECT * FROM car_image_image WHERE image_id ='".$image_id."'");
    }

    /**
     * 订单确认
     *
     * @param $member_id
     * @return array
     */
    public function Confirm($member_id)
    {
        header("Pragma:no-cache");
        header("Cache-Control:no-cache,must-revalidate,no-store");
        header("Expires:-1");
        $order_info = Mod::app()->cache->get('b2c-cart-product-set-'.$member_id);
        if ($order_info) return $order_info;

        $Cart = new ModelCart();
        $Product = new ModelProduct();
        $Addr = new ModelAddr();

        $cart_list = $Cart->Rows($member_id);
        $cart_list_new = $Product->CartGoods($cart_list);

        $item = $cart_list_new['item'];
        $num = $Cart->CartProductSum($member_id);
        $amount = $Cart->CartProductAmount($member_id);

        //收货地址
        $addr_row = $Addr->AddrOrderDefault($member_id);

        return array('item'=>$item,'num'=>$num,'amount'=>$amount,'addr_row'=>$addr_row);
    }

    /**
     * 配送方式
     */
    public function DlyType()
    {
        $dly_sql = "SELECT dt_id,dt_name,firstprice,detail FROM {{b2c_dlytype}} WHERE dt_status = '1' AND disabled = 'false'";
        $dly_list = $this->ModelQueryAll($dly_sql);

        return $dly_list;
    }

    /**
     * 配送方式设置
     *
     * @param $member_id
     * @param $dt_id
     * @return array
     */
    public function DlyTypeSet($member_id,$dt_id)
    {
        $dly_sql = "SELECT dt_id,dt_name,firstprice FROM {{b2c_dlytype}} WHERE dt_id = $dt_id and disabled = 'false'";
        $dly_row = $this->ModelQueryRow($dly_sql);

        $order_info = Mod::app()->cache->get('b2c-cart-product-set-'.$member_id);
//        var_dump($order_info);
        $order_info['dly'] = $dly_row;
        $order_info['total'] = sprintf('%01.2f',$order_info['amount'] + $dly_row['firstprice']);
        if (!$result) return false;
        return true;
    }



    /**
     * 支付方式列表
     *
     * @return array
     */
    public function PaymentList()
    {
        $payment_sql = "SELECT * FROM {{base_setting}} WHERE app = 'ectools'";
        $payment_list = $this->ModelQueryAll($payment_sql);

        $item_list = array();
        foreach ($payment_list as $v) {
            $value = unserialize(unserialize($v['value']));
            $keyArr = explode('_',$v['key']);
            $item = array();
            if ($value['status'] == 'true' && $value['pay_type'] == 'true') {
                $item['pay_name'] = $value['setting']['pay_name'];

                $item['pay_app_id'] = $keyArr[3];
            }
            if (!empty($item)){
                $item_list[] = $item;
            }
        }
        return $item_list;
    }

    /**
     * 支付方式写入
     *
     * @param $member_id
     * @param $payment
     * @return array
     */
    public function PaymentSet($member_id,$payment)
    {
        $order_info = Mod::app()->cache->get('b2c-cart-product-set-'.$member_id);

        $order_info['payment'] = $payment;

        $result = Mod::app()->cache->set('b2c-cart-product-set-'.$member_id,$order_info,$this->cart_expire);

        if (!$result) return false;
        return true;
    }

    /**
     * 订单提交
     *
     * @param int $member_id
     * @return array
     */
    public function Create($member_id,$data)
    {

       $Cart = new ModelCart();
       $Cart_result = $Cart->CardIdentProduct($member_id);


        if (!$Cart_result['data'] || empty($Cart_result['data'] )){
             return array('code'=>400,'msg'=>'购物车快饿瘪了');
        }

        $Cart_item = $Cart_result['data'];



        $cart['count_item'] = count($Cart_item);
        $cart['total_amount'] = $cart['use_point']   = $cart['final_amount']= 0;
        foreach($Cart_item as $tc){
           $cart['total_amount']   += $tc['price'];
           if($tc['paytype']==3){
               $cart['use_point']   += $tc['price_jifen'] * $tc['quantity'];//要支付的积分
           }else{
               $cart['final_amount']   += $tc['price'] * $tc['quantity'];//要支付的money
           }   
           
        }
//        if (empty($cart['addr'])) return array('code'=>400,'msg'=>'请选择收货地址');

        if (!$data['payment']) return array('code'=>400,'msg'=>'请选择支付方式');
        //是否有积分购买
        $url = Myconfig::DACHUHOST.'/api/point/getmemberpoints';
        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
        $dachu->Get_token();
        $res = $dachu->getmemberpoints($member_id);
        if($res['data']['points'] < $cart['use_point']) return array('code'=>404,'msg'=>'积分不足');
//        $dt_id =intval($cart['dly']['dt_id']);
//        if (empty($dt_id))return array('code'=>400,'msg'=>'请选择配送方式');

        //配送方式
//        $dly_sql = "SELECT dt_id,dt_name,firstprice FROM {{b2c_dlytype}} WHERE dt_id =".$dt_id;
//        $dly_row = $this->ModelQueryRow($dly_sql);
//        $cart['dly'] = $dly_row;
        //加上快递费
        $cart['dly']['firstprice']=0.00;
//        $cart['total'] = sprintf('%01.2f',$cart['amount'] + $dly_row['firstprice']);
//        $cart['use_point'] = isset($cart['use_point'] )?$cart['use_point']:0;
        //订单信息
        $order_id = $this->build_order_no();    //生成订单号
        $order_info = array(
            'member_id'=>$member_id,
            'count_item'=>$cart['count_item'],//商品数量
            'total_amount'=>$cart['total_amount'], //商品价格
            'final_amount'=>$cart['final_amount'], //商品价格
            'score_u'=>$cart['use_point'],//花掉的积分
            'addr'=>$cart['addr'],
            'payment'=>$data['payment'],
            'shipping_id'=>1,
            'shipping'=>'大楚网自提',
            'ship_addr'=>array(),
            'cost_freight'=>$cart['dly']['firstprice'],//快递费用
            'is_delivery'=>'N',//是否要运输
            'remark'=>$data['remark'],//是否要运输
        );


        $orderParams = $this->OrderParams($order_id,$order_info);
        //订单商品信息
        $order_item = $this->ItemParams($order_id,$Cart_item);

//        var_dump($orderParams);
//        var_dump($order_item);die;

        $sql="select * from {{b2c_cart_objects}} where member_id=".$member_id;
        $arr = Mod::app()->db->createCommand($sql)->queryAll();
        $sqld="";
        foreach($arr as $k=>$v){
            foreach ($order_item as $k2=>$v2){
                 if($v['goods_id']==$v2['goods_id'] && $v['price_jifen'] != $v2['price_jifen']){
                            $tmp[]=$v2;
                            $sqld.=" update {{b2c_cart_objects}} set  price_jifen=".$v2['price_jifen']." where member_id=".$member_id." and goods_id=".$v2['goods_id'] .";";
                 }
            }

        }
        if(!empty($tmp)){

            $res= Mod::app()->db->createCommand($sqld)->execute();
            return array('code'=>405,'msg'=>'有部分商品价格发生了改变');
        }


        $transaction=Mod::app()->db->beginTransaction();
         try{
                    //订单表 b2c_order
                    $this->insertRow('{{b2c_orders}}',$orderParams);

                    //订单商品信息表
                    $this->insertAll('{{b2c_orders_items}}',$order_item);
                    
                    //订单冻结库存
                    $freeze_flag = $this->orderFreeze($Cart_item);
 
                    if(!$freeze_flag){
        //                $transaction->rollback();
                        return array('code'=>400,'msg'=>$freeze_flag['name'].'库存不足');
                    }
              
                    //清除购物车
                   $this->ModelExecute($this->DelCart($member_id,$Cart_item));

              
                    $transaction->commit();
                    return array('code'=>200,'order_id'=>$order_id,'final_amount'=>$orderParams['final_amount']);
         }catch(Exception $e){ //如果有一条查询失败，则会抛出异常
                    $transaction->rollBack();
                    return array('code'=>400,'msg'=>'生成订单失败');
         }
 
 
    }

    /**
     * 冻结库存
     * @param $cart_list
     * @return bool
     */
    public function orderFreeze($cart_list){


        foreach($cart_list as $k=>$v){
            $sql =" select * from {{b2c_goods}}  where goods_id=".intval($v['goods_id']);

            $product_info = $this->ModelQueryRow($sql);

            if(($product_info['freez']+$v['quantity'])>$product_info['store']){
                return false;
            }
//            $sql = "update {{b2c_goods}} set freez=freez+".intval($v['quantity'])." where goods_id=".intval($v['goods_id']);
//            if(!$this->ModelExecute($sql)){
//                return false;
//            }
        }
        return true;
    }

    /**
     * 直接兑换查看库存
     * @param $cart_list
     * @return bool
     */
    public function orderCheckFreeze($product_one){


        $sql =" select * from {{b2c_goods}}  where goods_id=".intval($product_one['goods_id']);
        $product_info = $this->ModelQueryRow($sql);

        if(($product_info['freez']+1)>$product_info['store']){
            return false;
        }

        return true;
    }

    /**
     * 直接兑换减去库存
     * @param $cart_list
     * @return bool
     */
    public function orderCutFreeze($order_product_list){


        foreach ($order_product_list as $v) {

//            //减去商品表库存
//            $set_str = "store = store - {$v['nums']} ";
//            $condition = "product_id = {$v['product_id']}";
//            $this->ModelExecute("UPDATE {{b2c_products}} SET $set_str WHERE $condition");

            //减去货品表库存
            $set_str =" store = store-{$v['nums']}";
            $condition = "goods_id = {$v['goods_id']}";
            $this->ModelExecute("UPDATE {{b2c_goods}} SET $set_str WHERE $condition");
        }
        
    }

    /**
     * 订单表提交数据
     *
     * @param $order_id
     * @param $order_info
     * @return array
     */
    public function OrderParams($order_id,$order_info)
    {
        $time  = time();
        $params = array(
            'order_id'=>$order_id,
            'total_amount'=>$order_info['total_amount'],
            'final_amount'=>$order_info['final_amount'],
            'count_item'=>$order_info['count_item'],
            'pay_status'=>0,
            'ship_status'=>0,
            'is_delivery'=>$order_info['is_delivery'],
            'payment'=>$order_info['payment'],
            'shipping_id'=>$order_info['shipping_id'],
            'shipping'=>$order_info['shipping'],
            'member_id'=>$order_info['member_id'],
            'confirm'=>'N',
            'ship_area'=>$order_info['addr']['def_area'],
            'ship_name'=>$order_info['addr']['name'],
            'weight'=>0,
            'tostr'=>$order_info['tostr'],
            'ship_addr'=>$order_info['ship_addr']['area'].$order_info['ship_addr']['addr'],
            'ship_zip'=>$order_info['ship_addr']['zip'],
            'ship_tel'=>$order_info['ship_addr']['tel'],
            'ship_email'=>'',
            'ship_time'=>$order_info['ship_addr']['ship_time'],
            'ship_mobile'=>$order_info['addr']['mobile'],
            'cost_tax'=>0,
            'is_protect'=>'false',
            'score_u'=>$order_info['score_u'],
            'score_g'=>0,
            'remark'=>$order_info['remark'],
            'cost_freight'=>$order_info['cost_freight'],//运送费用
            'source'=>'pc',
//            'ip'=>Mod::app()->request->userHostAddress,
            'createtime'=>$time,
            'updatetime'=>$time,
            'status'=>1,
        );
        return $params;
    }

    /**
     * 订单商品表提交数据
     *
     * @param $order_id
     * @param $order_item
     * @return bool
     */
    public function ItemParams($order_id,$order_item)
    {
        $params = array();
        foreach ($order_item as $v) {
            $params[] = array(
                'order_id'=>$order_id,
                'goods_id'=>$v['goods_id'],
                'quantity'=>$v['quantity'],
                'paytype'=>$v['paytype'],
                'price'=>$v['price'],
                'price_jifen'=>$v['price_jifen'],
                'createtime'=>time(),
                'oldata'=> serialize($v),
                'status'=>1,
            );
        }
        return $params;
    }

 
    /**
     * 删除已购买商品在购物车情况
     *
     * @param $member_id
     * @param $order_cart
     * @return string
     */
    public function DelCart($member_id,$order_cart)
    {
        foreach ($order_cart as $v) {
            $obj_ident[] = "'".'goods_'.$v['goods_id']."'";
        }
        $obj_idents = implode(',',$obj_ident);
        $sql = "DELETE FROM {{b2c_cart_objects}}
        WHERE obj_ident IN ({$obj_idents}) AND member_id = $member_id ";

        return $sql;
    }

    /**
     * 购物车同步及清空缓存
     *
     * @param $member_id
     * @return mixed
     */
    public function Sync($member_id)
    {
        return Mod::app()->cache->delete('b2c-cart-product-set-'.$member_id);
    }

    /**
     * 订单号生成
     */
    public function build_order_no()
    {
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * 生成支付单号
     *
     * @return string
     */
    public function payment_no()
    {
        return time().substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }


    /**
     * 订单支付
     *
     * @param $order_id
     * @param string $buyer_email
     * @param string $payment_no
     * @param int $pay_status
     * @return array
     */
    public function OrderPayment($order_id,$payment_no='',$paynum=''){
        if($order_id && !ctype_digit($order_id)){
           return  array('code'=>'4001','mess'=>'订单号不合法');
        }
        
        //订单信息
        $sql = "SELECT * FROM {{b2c_orders}} WHERE order_id = $order_id";
        $order_row = $this->ModelQueryRow($sql);
           
       //订单状态已经操作过返回
        if ($order_row['pay_status'] == 1){
              return array('code'=>2,'mess'=>'订单状态已经操作过返回');
        }
        $more_mess = '';
        $pay_status = false;//支付状态
        //支付积分
        if($order_row['score_u']>0){
            //通过接口扣除大楚通行证的积分
            $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
            $dachu->Get_token();
            $res = $dachu->pointspend($order_row['member_id'], $order_row['score_u']);
            if($res['code']==200){
                $more_mess .= '支付积分'.$order_row['score_u'];
                $pay_status = true;
                //积分支付成功
            }else{
                 return array('code'=>-1,'mess'=>'积分支付失败');
            }
        }
           
        
        //支付money
        if($order_row['final_amount'] > '0.000'){
//           积分商城目前不支持线上付款
        }

        
        //商品库存变更
        $order_product_list = $this->ModelQueryAll("SELECT b.goods_id,a.quantity as nums FROM {{b2c_orders_items}} a,{{b2c_goods}} b WHERE a.order_id = '".$order_id."' and a.goods_id = b.goods_id");
        if($paynum){
            $this->orderCutFreeze($order_product_list);
        }else{
            $this->orderStoreMinus($order_product_list);
        }

        if($pay_status){//订单支付状态更新
            $this->ModelEdit('{{b2c_orders}}',array('order_id'=>$order_id),array('pay_status'=>1));
        }
        
         //生成支付单
        $this->ModelInsert(
            '{{ectools_payments}}',
            array(
                'money'=>$order_row['final_amount'],
                'cur_money'=>$order_row['final_amount'],
                'member_id'=>$order_row['member_id'],
                'status'=>'succ',
                'pay_name'=>'',
                'pay_type'=>'online',
                't_payed'=>time(),
                'op_id'=>$order_row['member_id'],
                'payment_bn'=>$payment_no,
                'currency'=>'CNY',
                'paycost'=>'',
                'pay_app_id'=>'1.0',
                'ip'=>'',
                't_begin'=>time(),
                't_confirm'=>time(),
                'memo'=>'积分支付',
                'return_url'=>'',
                'disabled'=>'false',
                'order_id'=>$order_id,
                'thirdparty_account'=>'',
            )
        );
        
        //更改session积分值
        $url = Myconfig::DACHUHOST.'/api/point/getmemberpoints';
        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
        $dachu->Get_token();
        $res = $dachu->getmemberpoints($order_row['member_id']);
        $meminfo=Mod::app()->session['member'];
        $meminfo['points']= $res['data']['points'];
        Mod::app()->session['member']=$meminfo;

//       Mod::app()->session['points']
        return array('code'=>1,'mess'=>'支付成功!'.$more_mess);


//            
//        $transaction = Mod::app()->db->beginTransaction();
//        try {
//            //订单支付状态更新
//            $this->ModelEdit('{{b2c_orders}}',array('order_id'=>$order_id),array('pay_status'=>$pay_status,'score_g'=>ceil($order_row['final_amount'])));
//
//            //订单钱款单据
//            $this->ModelInsert(
//                '{{ectools_order_bills}}',
//                array(
//                    'rel_id'=>$order_id,
//                    'bill_type'=>'payments',
//                    'pay_object'=>'order',
//                    'bill_id'=>$paymentNo,
//                    'money'=>$order_row['final_amount']
//                )
//            );
//
//            //订单支付日志
//            $this->ModelInsert(
//                '{{b2c_order_log}}',
//                array(
//                    'rel_id'=>$order_id,
//                    'op_id'=>$order_row['member_id'],
//                    'op_name'=>$member_row['name'],
//                    'alttime'=>time(),
//                    'bill_type'=>'order',
//                    'behavior'=>'payments',
//                    'result'=>'SUCCESS',
//                    'log_text'=>serialize(
//                        array(
//                            array(
//                                'txt_key'=>'订单已付款，订单号'.$order_id.'付款'.$order_row['final_amount'].'元',
//                                'data'=>array(
//                                    $order_id,$order_row['final_amount']
//                                )
//                            )
//                        )
//                    ),
//                )
//            );
//
//            //花生经验值变化
//            $this->MemberPoint($order_row['member_id'],$order_id,ceil($order_row['final_amount']));
//
//            $transaction->commit();
//            return array('code'=>200,'msg'=>'订单支付成功','order_id'=>$order_id,'total_amount'=>$order_row['final_amount']);
//        } catch(Exception $e) {
//            $transaction->rollback();
//            return array('code'=>400,'msg'=>'订单支付失败');
//        }
        
    }

    /**
     * 订单支付减去商品表  货品表库存
     * @param $order_product_list
     */
    public function orderStoreMinus($order_product_list){

        foreach ($order_product_list as $v) {

            //减去商品表库存
//            $set_str = "store = store - {$v['nums']} , freez=freez -{$v['nums']}";
//            $condition = "product_id = {$v['product_id']}";
//            $this->ModelExecute("UPDATE {{b2c_products}} SET $set_str WHERE $condition");

            //减去货品表库存
            $set_str =" store = store-{$v['nums']}";
            $condition = "goods_id = {$v['goods_id']}";
            $this->ModelExecute("UPDATE {{b2c_goods}} SET $set_str WHERE $condition");
        }
    }

    /**
     * 取消解冻库存
     * @param array $order_product_list
     */
    public function orderFreezeCancel($order_product_list){
        foreach ($order_product_list as $v) {
            //减去商品表库存
            $set_str = " freez=freez-{$v['nums']}";
            $condition = "product_id = {$v['product_id']}";
            $this->ModelExecute("UPDATE {{b2c_products}} SET $set_str WHERE $condition");
        }
    }

    /**
     * 会员订单
     *
     * @param $member_id
     * @param int $start
     * @param int $pageSize
     * @param bool|string $status
     * @param bool|string $pay_status
     * @param bool|string $ship_status
     * @return mixed
     */
    public function OrderList($member_id,$start=0,$pageSize=15,$status='',$pay_status='false',$ship_status='false')
    {
        $condition = "member_id = $member_id";

        if ($status) $condition .= " AND status = '$status'";
        if ($pay_status != 'false') $condition .= " AND pay_status = '$pay_status'";
        if ($ship_status != 'false') $condition .= " AND ship_status = '$ship_status'";

        $list = $this->items('order_id,createtime,payment,total_amount,final_amount,status,pay_status,ship_status',$condition,1,$start,$pageSize);
        if (!$list) return false;

        foreach ($list as $v) $order_idArr[] = $v['order_id'];

        $order_product = $this->OrderProduct($order_idArr);
        foreach ($list as $k=>$v) {
            $list[$k]['createtime'] = date('Y-m-d H:i',$list[$k]['createtime']);
            $list[$k]['product'] = $order_product[$v['order_id']];

            $sql = "select sum(nums) as sum  from {{b2c_order_items}}  where order_id = '".$v['order_id']."'";
            $product_sum = $this->ModelQueryRow($sql);
            $list[$k]['product_sum'] = $product_sum['sum'];
            $list[$k]['total_amount'] =number_format($v['total_amount'],2,'.', '') ;
            $list[$k]['final_amount'] =number_format($v['final_amount'],2,'.', '') ;
        }
        return $list;
    }

    /**
     * 订单商品
     *
     * @param $order_idArr
     * @return array|bool|string
     */
    public function OrderProduct($order_idArr)
    {
        if (!$order_idArr) return '';
        $item_sql = "SELECT i.order_id,i.product_id,i.goods_id,i.bn,i.name,i.price,i.nums,i.addon,i.cost,p.mktprice
                        FROM {{b2c_order_items}} as i left join {{b2c_products}}
                        as p on p.product_id = i.product_id";
        if (is_array($order_idArr)) {
            $order_ids = implode(',',$order_idArr);
            $item_sql .= " WHERE order_id IN ({$order_ids})";
        } else $item_sql .= " WHERE order_id = {$order_idArr}";

        $items = $this->ModelQueryAll($item_sql);
        $itemsOrder = $goods_ids = $goods_image = array();
        foreach ($items as $k=>$v) {
            $goods_ids[] = $v['goods_id'];
            $items[$k]['price'] = number_format($v['price'],'2','.', '');
            $items[$k]['cost'] = number_format($v['cost'],'2','.', '');
            $items[$k]['mktprice'] = number_format($v['mktprice'],'2','.', '');
        }

        $itemProduct = Help::ArrayListByKey($items,'goods_id');
        if (!$goods_ids) return $itemsOrder;
        $goods_str = implode(',',$goods_ids);
        $Product = new ModelProduct();
        $goods_image = $Product->GoodsDefaultImage($goods_str);

        foreach ($goods_image as $k=>$v) {
            $itemProduct[$k]['image'] = $this->img_url.$v['s_url'];
        }

        foreach ($items as $v) {
            $item = $v;
            $item['image'] = isset($itemProduct[$v['goods_id']]['image'])?$itemProduct[$v['goods_id']]['image']:'';
            $itemsOrder[$v['order_id']][] = $item;
        }

        if (!is_array($order_idArr)) return $itemsOrder[$order_idArr];

        return $itemsOrder;
    }

    /**
     * 订单详情
     *
     * @param $order_id
     * @return mixed
     */
    public function orderDetail($order_id){
        $sql = "select order_id,createtime,total_amount,final_amount,status,ship_status,pay_status,payment,order_refer,ship_addr,
        ship_zip,ship_tel,ship_time,shipping,ship_mobile,ship_name,cost_item,cost_freight,is_tax,tax_type,tax_company,tax_content,source,
        score_u,score_g
        from {{b2c_orders}} where order_id = {$order_id}";
        return $this->ModelQueryRow($sql);
    }

    /**
     * 更改订单状态
     * @param $order_id
     * @param $member_id
     * @param $status
     * @return mixed
     */
    public function changeOrderStatus($order_id,$member_id,$status){
        $sql = " update {{b2c_orders}} set status = '".$status."' where order_id = '".$order_id."' and member_id = '".$member_id."' ";
        return $this->ModelExecute($sql);
    }

   
} 