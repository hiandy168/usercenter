<?php
/**
 *  wap
 */
class DefaultController extends B2cController
{
    public $layout=false;
    /**
     * 商城入口
     */
    public function actionIndex()
    {
        $appid = trim(Tool::getValidParam('appid', 'integer'));
        $appsecret = trim(Tool::getValidParam('appsecret', 'string'));
        $openid = trim(Tool::getValidParam('openid', 'string'));
        $id = trim(Tool::getValidParam('id', 'integer'));

        //分类列表
        $Cat = new ModelCat();
        $model['cat_list'] = $Cat->Items();
        
        //最新上架
        $Goods = new ModelGoods();
        $condition = " marketable='true' ";
        $model['new_list'] = $Goods->getGoods(
            'goods_id,name,image_default_id,price,mktprice,update_time,bn,paytype,price_jifen,store',
            $condition,'update_time DESC',0,4
        );
        $count=$Goods->getCount($condition);
        
        
//        $url = "http://" . $_SERVER['HTTP_HOST'] . "/api/Jfshop/slide"; //  幻灯片接口
//
//        $pic_arr = json_decode(urldecode($this->curl_get($url)),true);
//        if(empty($pic_arr)){
//            $pic_arr=array();
//        }
        

//        foreach ($model['new_list'] as $k=>$val){
//            $sql ="select count(0) con from {{b2c_orders_items}} where product_id=".$val['product_id'];
//            $arr_con=Mod::app()->db->createCommand($sql)->queryRow();
//            $val['con']=$arr_con['con'];
//            $model['new_list'][$k]=$val;
//        }
//        echo "<pre>";
//        print_r($model);

        $this->render('index',array('model'=>$model,'id'=>$id,'count'=>$count,'appid'=>$appid,'appsecret'=>$appsecret,'openid'=>$openid,'pic_arr'=>$pic_arr));
    }

    public function actionMemberhobby(){
        $mid = trim(Tool::getValidParam('mid', 'integer'));
        $Goods = new ModelGoods();
        if($mid){
//        $mid=293;
        $sql = "SELECT count(0) con,b.goods_id FROM {{b2c_orders}} a,{{b2c_orders_items}} b,{{b2c_goods}} ca WHERE a.order_id=b.order_id  and ca.goods_id=b.goods_id  and  ca.disabled = 'false' and ca.marketable='true' and a.member_id=".$mid." group by b.goods_id  order by con desc";
        $arr = Mod::app()->db->createCommand($sql)->queryAll();
        }else{
            $arr=array();
        }


        $temp_arr=array();
        $arr_one=array();
        $arr_id=array();
        $new_list=array();
        if(count($arr)>0){
            if(count($arr)>5){
                $arr=array_slice($arr,0,5);
            }else{
                $ne=5-count($arr); //补充产品
            }
            foreach ($arr as $k=>$v){
                $product_arr = $Goods->Item($v['goods_id']);
//                if($product_arr['row']['is_default']) {
                    $arr_one['goods_id'] = $product_arr['row']['goods_id'];
                    $arr_one['s_url'] = isset($product_arr['image']['m_image']['0']) ? $product_arr['image']['m_image']['0'] : '';
                    $arr_one['m_url'] = isset($product_arr['image']['s_image']['0']) ? $product_arr['image']['s_image']['0'] : '';
                    $arr_one['l_url'] = isset($product_arr['image']['l_image']['0']) ? $product_arr['image']['l_image']['0'] : '';
                    $arr_id[] = $v['goods_id'];
                    $temp_arr[] = $arr_one;
//                }
            }
            $str_id=implode(",",$arr_id);

//            $condition = "p.is_default = 'true' and p.product_id  IN(" . $str_id . ")";
//            $new_list = $Product->getProducts(
//                'g.image_default_id,p.product_id',
//                $condition, 'p.uptime DESC', 0, 5);

            if($ne>0) {
                $condition = " marketable='true'  and goods_id NOT IN(" . $str_id . ")";
                $new_list = $Goods->getGoods(
                    'image_default_id,goods_id',
                    $condition, 'update_time DESC', 0, $ne
                );
            }
            $last_arr=array_merge($temp_arr,$new_list);
        }else{
            //最新上架
            $condition = " marketable='true' ";
            $last_arr = $Goods->getGoods(
                'image_default_id,goods_id',
                $condition, 'update_time DESC', 0, 5
            );

        }
        echo json_encode($last_arr);

    }

    /**
     * 物品搜索
     */
    public function actionSearchpro(){
        $keyword = trim(Tool::getValidParam('keyword', 'string'));
        $this->render('searchpro',array("keyword"=>$keyword));

    }
    /**
     * 物品关键字搜索
     */
    public function actionAjaxsearchpro(){
        $keyword = trim(Tool::getValidParam('keyword', 'string'));

        //商品关键字
        $sql="select goods_id from {{b2c_goods_keywords}} where keyword like '%".$keyword."%'";
        $arr = Mod::app()->db->createCommand($sql)->queryAll();

        $sql="select goods_id from {{b2c_goods}} where name like '%".$keyword."%' and  disabled='false'";
        $arr2 = Mod::app()->db->createCommand($sql)->queryAll();

        $arr3=array_merge($arr,$arr2);
        foreach ($arr3 as $v){
            $v=join(',',$v);//降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[]=$v;
        }
        $temp=array_unique($temp);//去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v){
            $temp_arr[]=$v;
        }

        $str_id=implode(",",$temp_arr);
        $Goods = new ModelGoods();

        //最新上架
        $condition = " marketable='true' and goods_id  IN(" . $str_id . ")";
        $pagecount= $Goods->getCount($condition);


        $ys=ceil($pagecount/8);

        $on = false;
        if($_POST['page']){
            $page = Tool::getValidParam('page','int');
            $on = Tool::getValidParam('one');

        }else{
            $page =1;
        }

        if($on){
            $startlimit = 0;
            $model['new_list'] = $Goods->getGoods(
                'goods_id,name,image_default_id,price,mktprice,update_time,bn,paytype,price_jifen,store',
                $condition,'update_time DESC',0,8*$page
            );
            foreach ($model['new_list'] as $k=>$val){
                $sql ="select count(0) con from {{b2c_orders_items}} where goods_id=".$val['goods_id'];
                $arr_con=Mod::app()->db->createCommand($sql)->queryRow();
                $val['con']=$arr_con['con'];
                $model['new_list'][$k]=$val;
            }
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


    public  function actionRedhref(){
        $mid = trim(Tool::getValidParam('mid', 'integer'));
        $href = trim(Tool::getValidParam('href', 'string'));
        $id = trim(Tool::getValidParam('id', 'integer'));
        switch ($href){
            case 'point':
                $redirect="http://".$_SERVER['HTTP_HOST']."/h5/member/point/id/$id";
                break;
            default:
                $redirect="http://".$_SERVER['HTTP_HOST']."/h5/member/index/id/$id";
                break;
        }
        $params=array("openid"=>$mid,"appid"=>'101012',"appsecret"=>'9581ceffr346bc53',"timestamp"=>time(),'redirect'=>$redirect);
            ksort($params);
            $string="";
            while (list($key, $val) = each($params)){
                $string = $string . $val ;
            }
        $sign = md5($string);
        $params['sign'] = $sign;
        $params['id'] = $id;
        unset($params['appsecret']);
        $str = "";
        foreach ($params as $key => $value) {
            $str .= $key."=".$value."&";
        }
        $str = trim($str,"&");
        header("Location: http://".$_SERVER['HTTP_HOST']."/api/member/autoLogin?".$str);
    }

    


}