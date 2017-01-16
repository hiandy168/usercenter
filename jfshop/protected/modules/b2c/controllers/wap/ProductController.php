<?php
/**
 *  wap
 */

class ProductController extends B2cController
{
    
    public $layout=false;
    /**
     * 商品详情
     */
    public function actionDetail()
    {
        $id = intval(Tool::getValidParam('id','int'));
        $Goods = new ModelGoods();
        $model['product'] = $Goods->Item($id);



        if (!$model['product']['row']['goods_id']) {
            $this->redirect($this->_siteUrl);
        }
        
        $cid = $model['product']['row']['cat_id'];
        //分类
        $Cat = new ModelCat();
        $model['cat'] = $Cat->Item("cat_id = {$cid}");
        //品牌
        $brand_id = $model['product']['row']['brand_id'];
        if($brand_id){
        $Brand = new ModelBrand();
        $model['brand'] = $Brand->Item("brand_id = {$brand_id}");
        }

        $model['parent_cat'] = $Cat->Item("cat_id = {$model['cat']['parent_id']}");
//        var_dump($model['product']['image']);die;
        $this->render('detail',array('model'=>$model,'row'=>$model['product']['row'],'image'=>$model['product']['image']));
    }

    // 图文详情
    public function actionDetail_tw()
    {
        if (!$this->username) $this->redirect($this->_siteUrl."/b2c/wap/account/login");

        $id = intval(Tool::getValidParam('id','int'));

        $Goods = new ModelGoods();
        $model['product'] = $Goods->Item($id);

        if (!$model['product']['row']['goods_id']) {
            $this->redirect($this->_siteUrl);
        }

        $cid = $model['product']['row']['cat_id'];
        //分类
        $Cat = new ModelCat();
        $model['cat'] = $Cat->Item("cat_id = {$cid}");
        //品牌
        $brand_id = $model['product']['row']['brand_id'];
        if($brand_id){
        $Brand = new ModelBrand();
        $model['brand'] = $Brand->Item("brand_id = {$brand_id}");
        }

        $model['parent_cat'] = $Cat->Item("cat_id = {$model['cat']['parent_id']}");

        $this->render('detail_tw',array('model'=>$model,'row'=>$model['product']['row'],'image'=>$model['product']['image']));
    }

    // 商品列表
    public function actionDetailList()
    {
        
        $this->render('detaillist');

    }

    public function actionAjaxDetailList()
    {
        

        //最新上架
        $Goods = new ModelGoods();
        $condition = " marketable='true'  ";
        $pagecount=$Goods->getCount($condition);
        $ys=ceil($pagecount/8);

        $on = false;
        if($_POST['page']){
            $page = Tool::getValidParam('page','int');
            $on = Tool::getValidParam('one');

        }

        if($on){
            $startlimit = 0;
            $model['new_list'] = $Goods->getGoods(
                'goods_id,name,image_default_id,price,mktprice,update_time,bn,paytype,price_jifen,store',
                $condition,'update_time DESC',0,8*$page
            );
            echo json_encode(array('code'=>200,'data'=>$model['new_list']));
            die;
        }

        $startlimit = ($page - 1) * 8 ;
        $model['new_list'] = $Goods->getGoods(
            'goods_id,name,image_default_id,price,mktprice,update_time,bn,paytype,price_jifen,store',
            $condition,'update_time DESC',$startlimit,8
        );
        if($ys>=$page) {echo json_encode(array('code'=>200,'data'=>$model['new_list'])); die;}
        echo json_encode(array('code'=>400,'mess'=>'已是最后一页啦'));

    }

    /**
     * 订单提交
     */
    public function actionSubmit()
    {
        $goods_id=intval(Tool::getValidParam('goods_id'));
        $sql =" select * from {{b2c_goods}}  where goods_id=".$goods_id;
        $arr=Mod::app()->db->createCommand($sql)->query();


        $data['payment'] = Tool::getValidParam('payment', 'string','alipay');

        $Goods = new ModelGoods();
        $model['Goods'] = $Goods->Item($goods_id);

        //是否有积分购买
        $url = Myconfig::DACHUHOST.'/api/point/getmemberpoints';
        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
        $dachu->Get_token();
        $res = $dachu->getmemberpoints($this->member_id);
        if($res['data']['points'] < $model['Goods']['row']['price_jifen']) {
            echo json_encode(array('code' => 400, 'msg' => '积分不足'));
            exit;
        }
//        Mod::app()->db->createCommand($sql)->query();
        $Order = new ModelOrder();

//        $result = $Order->Create($this->member_id,$data);

        if (!$data['payment']){
            echo  json_encode(array('code'=>400,'msg'=>'请选择支付方式'));
            exit;
        }

        //订单冻结库存
        $freeze_flag = $Order->orderCheckFreeze($model['Goods']['row']);


        if(!$freeze_flag){
            //                $transaction->rollback();
//            echo json_encode(array('code'=>400,'msg'=>'支付失败'));
//            exit;
//        }else if($freeze_flag['code']==401){
            echo json_encode(array('code'=>400,'msg'=>$model['Goods']['row']['name'].'库存不足'));
            exit;
        }

//        $dt_id =intval($cart['dly']['dt_id']);
//        if (empty($dt_id))return array('code'=>400,'msg'=>'请选择配送方式');

        //配送方式
//        $dly_sql = "SELECT dt_id,dt_name,firstprice FROM {{b2c_dlytype}} WHERE dt_id =".$dt_id;
//        $dly_row = $this->ModelQueryRow($dly_sql);
//        $cart['dly'] = $dly_row;
        //加上快递费
        $cost_freight=0.00;
//        $cart['total'] = sprintf('%01.2f',$cart['amount'] + $dly_row['firstprice']);
//        $cart['use_point'] = isset($cart['use_point'] )?$cart['use_point']:0;
        //订单信息
        $order_id = $Order->build_order_no();    //生成订单号
        $order_info = array(
            'member_id'=>$this->member_id,
            'count_item'=>1,//商品数量
            'total_amount'=>$model['Goods']['row']['price_jifen'], //商品价格
            'final_amount'=>$model['Goods']['row']['price_jifen'], //商品价格
            'score_u'=>$model['Goods']['row']['price_jifen'],//花掉的积分
            'addr'=>'',
            'payment'=>$data['payment'],
            'shipping_id'=>1,
            'shipping'=>'大楚网自提',
            'ship_addr'=>array(),
            'cost_freight'=>$cost_freight,//快递费用
            'is_delivery'=>'N',//是否要运输
            'remark'=>'',//是否要运输
        );


        $orderParams = $this->OrderParams($order_id,$order_info);

        //订单商品信息
        $order_item = $this->ItemParams($order_id,$model['Goods']['row']);

//        echo "<pre>";
//        print_r($order_item);
//        exit;

//        var_dump($orderParams);
//        var_dump($order_item);die;



        $transaction=Mod::app()->db->beginTransaction();
        try{
            //订单表 b2c_order
            $Order->insertRow('{{b2c_orders}}',$orderParams);

            //订单商品信息表
            $Order->insertRow('{{b2c_orders_items}}',$order_item);

            $transaction->commit();
            echo json_encode(array('code'=>200,'order_id'=>$order_id,'final_amount'=>$orderParams['final_amount']));
        }catch(Exception $e){ //如果有一条查询失败，则会抛出异常
            $transaction->rollBack();
            echo json_encode(array('code'=>400,'msg'=>'生成订单失败'));
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
            'ship_area'=>'',
            'ship_name'=>'',
            'weight'=>0,
            'tostr'=>'',
            'ship_addr'=>$order_info['ship_addr']['area'].$order_info['ship_addr']['addr'],
            'ship_zip'=>$order_info['ship_addr']['zip'],
            'ship_tel'=>$order_info['ship_addr']['tel'],
            'ship_email'=>'',
            'ship_time'=>$order_info['ship_addr']['ship_time'],
            'ship_mobile'=>'',
            'cost_tax'=>0,
            'is_protect'=>'false',
            'score_u'=>$order_info['score_u'],
            'score_g'=>0,
            'remark'=>'',
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
        $params= array(
            'order_id'=>$order_id,
            'goods_id'=>$order_item['goods_id'],
            'quantity'=>1,
            'paytype'=>3,
            'price'=>$order_item['price'],
            'price_jifen'=>$order_item['price_jifen'],
            'createtime'=>time(),
            'oldata'=> serialize($order_item),
            'status'=>1,
        );
        return $params;
    }





 





//    /**
//     * 预览详情
//     */
//    public function actionView()
//    {
     //  $id =Tool::getValidParam('id');
//
//        $Product = new ModelProduct();
//        $model['product'] = $Product->Item($id);
//        echo $this->renderPartial('view',array('row'=>$model['product']['row'],'image'=>$model['product']['image']),true);
//    }
//
//    /**
//     * 咨询
//     */
//    public function actionReview()
//    {
//        $product_id = Tool::getValidParam('product_id');
//        $name = Tool::getValidParam('name');
//        $email = Tool::getValidParam('email');
//        $review = Tool::getValidParam('review');
//
//        $Comment = new ModelComment();
//        if ($Comment->add($product_id,$name,$email,$review)) {
//            $this->sendJsonResponse(200,'咨询成功，客服尽快回复');
//        } else {
//            $this->sendJsonResponse(400,'咨询失败');
//        }
//    }
} 