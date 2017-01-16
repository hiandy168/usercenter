<?php
/**
 * 商品特卖管理.
 *
 
 
 
 * @package       yiishop.model
 * @license       http://www.yiitian.com/license
 
 */

class ModelRecommend extends B2CModel
{
    /**
     * 推荐商品列表页
     *
     * @param $position
     * @param $limit
     * @return mixed
     */
    public function RemmandGoods($position,$limit)
    {
        $now_time = time();

        $sql = "SELECT goods_id
        FROM {{recommend_loaction}} l LEFT JOIN {{recommend_dimension}} i ON l.dimension_id = i.dimension_id
        WHERE l.disabled = 'false' AND {$now_time} >= l.start_time
        AND {$now_time} < l.end_time AND l.status = 'A' AND i.position_no = {$position} AND i.disabled = 'false'
        ORDER BY l.p_order ASC,l.location_id DESC LIMIT {$limit}";

        $list = $this->ModelQueryAll($sql);
        $goods_id = array();
        foreach ($list as $v) $goods_id[] = $v['goods_id'];
        return $goods_id;
    }
}