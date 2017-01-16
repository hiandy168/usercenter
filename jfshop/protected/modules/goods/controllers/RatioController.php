<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/19
 * Time: 15:12
 */
/**
 * 积分比例设置
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */

class RatioController extends BaseController
{
    /**
     * 积分比例设置
     */
    public function actionIndex()
    {
        $sql = "SELECT * FROM {{b2c_ratio}} WHERE id=1";
        $arr=Mod::app()->db->createCommand($sql)->queryRow();
        $ratio=ceil($arr['numerator']/$arr['denominator']);
        $res=false;
        if($_POST){
            $sqld = '';
               $updatesql="update {{b2c_ratio}} set numerator='".Tool::getValidParam('numerator')."',denominator='".Tool::getValidParam('denominator')."'  where id=1 ";
               $result=Mod::app()->db->createCommand($updatesql)->execute();
                if($result){
                    $sql="select * from {{b2c_goods}} where disabled='false' ";
                    $arr = Mod::app()->db->createCommand($sql)->queryAll();
                    foreach($arr as $k=>$v){
                        $price_jifen=ceil(Tool::getValidParam('denominator')*$v['mktprice']/Tool::getValidParam('numerator'));
                        $sqld.=" update {{b2c_goods}} set price_jifen=$price_jifen where goods_id=".$v['goods_id'].";";
                    }
                    $res= Mod::app()->db->createCommand($sqld)->execute();

                    if($res){
                        echo "<script>location.reload(); </script>";
                        exit;
                    }
                }
            

        }

        $this->render('index',array('arr'=>$arr));
    }


}