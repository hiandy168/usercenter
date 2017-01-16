<?php
/**
* 商品咨询/评论管理.
*



* @package       yiishop.model
* @license       http://www.yiitian.com/license

*/
class ModelComment extends B2CModel
{
    /**
     *商品咨询
     *
     * @param $product_id
     * @param $name
     * @param $email
     * @param $review
     * @param int $member_id
     * @return mixed
     */
    public function Add($product_id,$name,$email,$review,$member_id=0)
    {
        $product_info = $this->ModelQueryRow("SELECT goods_id FROM {{b2c_products}} WHERE product_id = {$product_id}");

        $insert_arr = array(
            'goods_id'=>$product_info['goods_id'],
            'product_id'=>$product_id,
            'author_id'=>$member_id?$member_id:0,
            'author'=>$name,
            'object_type'=>'ask',
            'contact'=>$email,
            'time'=>time(),
            'inbox'=>0,
            'comment'=>$review,
            'display'=>'false'
        );
        return $this->ModelInsert('{{b2c_member_comments}}',$insert_arr);
    }
} 