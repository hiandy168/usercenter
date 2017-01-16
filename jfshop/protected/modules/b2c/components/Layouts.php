<?php
/**
 * 页面数据
 *
 
 
 
 * @package       /protected/modules/b2c/components
 
 */
class Layouts {
    /**
     * 全部分类
     * @return mixed
     */
    public static function category()
    {
        $Cat = new ModelCat();
        return $Cat->Items();
    }

    /**
     * 推荐品牌
     *
     * @return mixed
     */
    public static function brand()
    {
        //品牌列表
        $Brand = new ModelBrand();
        return $Brand->Items("brand_setting = '1'");
    }

    /**
     * 特卖商品
     *
     * @param $position
     * @param $limit
     * @return array
     */
    public static function Recomman($position,$limit)
    {
        $Recommand = new ModelRecommend();
        $goods_id = $Recommand->RemmandGoods($position,$limit);
        if ($goods_id) {
            $Product = new ModelProduct();
            $goods_ids = implode(',',$goods_id);
            return $Product->getProducts(
                'g.goods_id,g.name,g.image_default_id,g.price,p.uptime,p.product_id,p.bn',
                "g.goods_id IN ({$goods_ids}) AND p.is_default = 'true'",'p.uptime DESC',0,0,false
            );
        }
        return array();
    }

    /**
     * 最后欢迎商品
     *
     * @return mixed
     */
    public static function Popular()
    {
        $Product = new ModelProduct();
        $condition = "p.is_default = 'true'";
        $popular_list = $Product->getProducts(
            'g.goods_id,g.name,g.image_default_id,g.price,p.uptime,p.product_id,p.bn',
            $condition,'p.uptime DESC',0,10
        );

        return $popular_list;
    }

    /**
     * 购物车列表
     *
     * @param string $member_id
     * @return array
     */
    public static function Cart($member_id = '')
    {
        $Goods = new ModelGoods();
        if ($member_id) {
            $Cart = new ModelCart();
            //判断临时数据库信息
            $num = $Cart->CartProductSum($member_id);
            $cart_list = $Cart->Rows($member_id);
            $cart_list_new = $Goods->CartGoods($cart_list);
            $item = isset($cart_list_new['item'])?$cart_list_new['item']:array();

            $amount = $Cart->CartProductAmount($member_id);
        } else {
            
            $CartCache = new ModelCartCache();
 
            $product_list = $CartCache->Product();
            $item = $Goods->CartGoodsCache($product_list);

            if($item){
                $num = count($item);
                $amount_price = $amount_price_jifen = 0;
                    foreach($item as $i){
                        $amount_price +=$i['price'];
                        $amount_price_jifen +=$i['price_jifen'];
                    }
                $amount =  array('amount_price'=>sprintf('%01.2f',$amount_price),'amount_price_jifen'=>$amount_price_jifen);
            }else{
                $amount =  array('amount_price'=>sprintf('%01.2f',0),'amount_price_jifen'=>0);
            }

        }

        return array('item'=>$item,'num'=>$num,'amount'=>$amount);
    }
} 