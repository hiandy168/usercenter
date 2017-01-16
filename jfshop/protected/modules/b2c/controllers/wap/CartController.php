<?php
/**
 * 购物车列表wap
 */

class CartController extends B2cController
{
        public $layout=false;
    /**
     * 购物车列表
     */
    public function actionIndex()
    {
        if ($this->username) $this->_index();
        else $this->_indexcache();
    }

    /**
     * 登录用户购物车
     */
    private function _index()
    {
        $Cart = new ModelCart();
        $Goods = new ModelGoods();
        //判断临时数据库信息
        $num = $Cart->CartProductSum($this->member_id);
//        $Cart->CartCacheInsert($this->member_id,$num);

        $cart_list = $Cart->Rows($this->member_id);

//        var_dump($cart_list);
        $cart_list_new = $Goods->CartGoods($cart_list);

        if ($cart_list_new){
            $item = $cart_list_new;
            $amount = $Cart->CartProductAmount($this->member_id);
        }else{
            $item = 0;
            $amount = 0;
        }

        $this->render('index',array('item'=>$item,'num'=>$num,'amount'=>$amount));
    }

    /**
     * 游客购物车信息
     */
    public function _indexcache()
    {
        $CartCache = new ModelCartCache();
        $Product = new ModelProduct();

        $product_list = $CartCache->Product();

        if ($product_list){ 
            $items = $Product->CartGoodsCache($product_list);
            $num = count($items);
            $amount_price = $amount_price_jifen = 0;
            if($num){
                foreach($items as $i){
                    $amount_price =$amount_price+$i['price'];
                    $amount_price_jifen = $amount_price_jifen+$i['price_jifen'];
                }
            }
            $amount =  array('amount_price'=>sprintf('%01.2f',$amount_price),'amount_price_jifen'=>$amount_price_jifen);
        }else{
                $items = $total = $num = $amount =0;
        }
        $this->render('index',array('item'=>$items,'num'=>$num,'amount'=>$amount));
    }

    /**
     * 新增购物车商品
     */
    public function actionInsert()
    {
        if (!$this->username) {
            echo json_encode(array("code"=>-1,'msg'=>'请先登陆账号')); die;
        }
        $goods_id = Tool::getValidParam('goods_id','int');
        $quantity = Tool::getValidParam('quantity','int');
        $quantity_type = Tool::getValidParam('quantity_type');
        
        if ($this->username) $this->_insert($goods_id,$quantity);
        else $this->_insertcache($goods_id,$quantity);
    }

    /**
     * 登录状态新增
     *
     * @param $product_id
     * @param $quantity
     * @param $quantity_type
     */
    private function _insert($goods_id,$quantity)
    {
        $Cart = new ModelCart();
        $Goods = new ModelGoods();

        //购物车商品总数
        $num = $Cart->CartProductSum($this->member_id);
        //购物车商品信息
        $goods_info = $Goods->row($goods_id,'goods_id,store,freez,price_jifen');
//        var_dump($goods_info);
        if(empty($goods_info)){
            echo  json_encode(array('code'=>400,'msg'=>'加入购物车失败,商品已下架'));
        }

   

    
        $result = $Cart->CartInsert($this->member_id,$quantity,$goods_id,$num,$goods_info['store'],$goods_info['freez'],$goods_info['price_jifen']);

        echo json_encode($result);
    }

    /**
     * 未登录状态新增
     *
     * @param $product_id
     * @param $quantity
     * @param $quantity_type
     */
    private function _insertcache($product_id,$quantity)
    {
        $Product = new ModelProduct(); 
        $CartCache = new ModelCartCache();
        //购物车商品总数

        //购物车商品信息
        $product_info = $Product->row($product_id,'*');
        $result = $CartCache->Add($product_info,$quantity);

        echo json_encode($result);
    }

    /**
     * 删除购物车商品
     */
    public function actionDelete()
    {
        $product_id = Tool::getValidParam('goods_id','int');
        
        if ($this->username) $this->_delete($product_id);
        else $this->_deletecache($product_id);
    }

    private function _delete($product_id)
    {
        $Cart = new ModelCart();
        $Goods = new ModelGoods();

        
        //货品信息
        $product_info = $Goods->row($product_id,'goods_id,store');

        $result = $Cart->CartDelete($this->member_id,$product_id);

        echo json_encode($result);
    }

    private function _deletecache($product_id)
    {
        $CartCache = new ModelCartCache();

        $result = $CartCache->Del($product_id);
        echo json_encode($result);
    }

    /**
     * 购物车为空
     */
    public function actionEmpty()
    {
        if ($this->username) {
            $Cart = new ModelCart();
            $Product = new ModelProduct();

            $cart_list = $Cart->Rows($this->member_id);
            $cart_list_new = $Product->CartGoods($cart_list);
            if ($cart_list_new) $this->redirect('index');
        }
        $this->render('empty');

    }
}