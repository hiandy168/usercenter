<?php

class ModelCartCache extends B2cModel
{
    /**
     * 临时购物车商品列表
     *
     * @return bool
     */
    public function Product()
    {
        if (isset(Mod::app()->session['b2c_cart']['items']) && Mod::app()->session['b2c_cart']['items'])
            return Mod::app()->session['b2c_cart']['items'];
        else return false;
    }

    /**
     * 添加购物车
     *
     * @param $quantity
     * @param $product_id
     * @param $goods_id
     * @param $store
     * @param $freez
     * @param $price
     * @param $quantity_type
     * @return array
     */
    public function Add($product_info,$quantity)
    {
        $items = Mod::app()->session['b2c_cart']['items']?Mod::app()->session['b2c_cart']['items']:array();
        $old_quantity = isset($items[$product_info['product_id']]['quantity'])?$items[$product_info['product_id']]['quantity']:0;
        if (isset($items[$product_info['product_id']]) && $items[$product_info['product_id']]['quantity']){
            $quantity += $items[$product_info['product_id']]['quantity'];
        }

        
        if (($quantity+$product_info['freez']) > $product_info['store']){
            return array('code'=>400,'msg'=>'此商品您已购买了'.$old_quantity.'件,库存超过限制','product_quantity'=>0);
        }
        
        $items[$product_info['product_id']] = array(
            'product_id'=>$product_info['product_id'],
            'quantity'=>$quantity,
        );

        Mod::app()->session['b2c_cart'] = array(
            'items'=>$items,
        );

        return array('code'=>200,'msg'=>'添加购物车成功',);
    }

    /**
     * 购物商品删除
     *
     * @param string $product_id
     * @return array|int
     */
    public function Del($product_id)
    {
        $items = Mod::app()->session['b2c_cart']['items'];
        if (!isset($items[$product_id])) return array('code'=>400,'msg'=>'删除失败');

        unset($items[$product_id]);
        $total_num = 0;
        $total_price= 0.00;
        foreach ($items as $v) {
            $total_num += $v['quantity'];
            $total_price += $v['quantity'] * $v['price'];
        }
        Mod::app()->session['b2c_member_total_num'] = $total_num;
        Mod::app()->session['b2c_cart'] = array(
            'items'=>$items,
            'total_num'=>$total_num,
            'total_price'=>sprintf('%1.2f',$total_price)
        );

        return array('code'=>200,'cart_sum'=>$total_num,'total_price'=>$total_price);
    }
}