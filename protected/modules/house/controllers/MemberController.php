<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 17:04
 */
class MemberController extends HouseController{

    /**
     * 个人中心首页
     * author  Fancy
     */

    public function actionIndex(){
        $userid=$this->member['id'];
        //$userid=7776;
        //$userid=78120;
        $wxstatus=$this->member['wxstatus'];
        if($wxstatus==1){
            $sql = "SELECT o.ordernum,o.id,o.money,o.paystatus,o.mid,a.title,a.img,a.actime,a.city  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a on o.houseid=a.id WHERE o.status=1 and o.mid=$userid order by o.createtime desc";
            $orderlist=Mod::app()->db->createCommand($sql)->queryAll();
            //var_dump($orderlist);
        }
        $data = array(
            'config'=>array(
                'site_title'=> '腾讯●楼盘商城',
                'Keywords'=>'腾讯●楼盘商城',
                'Description'=>'腾讯●楼盘商城',
            ),
            'orderlist'=>$orderlist,
        );
        $this->render('index',$data);
    }
    /**
     * 订单详情页面
     * author  Fancy
     */
    public function actionOrderd(){
        $orderid=Tool::getValidParam('id','string');
        $userid=$this->member['id'];
        $sql = "SELECT o.ordernum,o.id,o.money,o.paystatus,o.applytime,o.code,a.title,a.img,a.actime,a.city,a.coupon,m.earnings,m.cycle  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a on o.houseid=a.id LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE o.status=1 and o.mid=$userid and o.id=$orderid order by o.createtime desc";
        $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        //var_dump($orderdetail);
        if(!$orderdetail){
            echo "error";
            die();
        }
        $data = array(
            'config'=>array(
                'site_title'=> $orderdetail['title'],
                'Keywords'=>$orderdetail['title'],
                'Description'=>$orderdetail['title'],
            ),
            'orderdetail'=>$orderdetail,
        );
        $this->render("orderd",$data);
    }
    /**
     * 确认使用
     * author  Fancy
     */
    public function actionConfirmorder(){
        $access_token=Mod::app()->memcache->get('access_token');
        $orderid=Tool::getValidParam('orderid','string');
        //$orderid="011911665728";
        $userid=$this->member['id'];
        $app_Id=Wzbank::appid;
        $nonce = Wzbank::strings(32);
        $ticket =Wzbank::h5ticket($access_token,$userid);
        $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
        $Url="https://test-open.webank.com/s/web-wallet-wx/#/person/deposits/confirm/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;
        $this->redirect($Url);
        //var_dump($Url);die();
    }

    /**
     * 提现
     * author  Fancy
     */
    public function actionWithdraw(){
        $access_token=Mod::app()->memcache->get('access_token');
        $orderid=Tool::getValidParam('orderid','string');
        $userid=$this->member['id'];
        //$orderid="011911665728";
        //$userid="7776";
        $app_Id=Wzbank::appid;
        $nonce = Wzbank::strings(32);
        $ticket =Wzbank::h5ticket($access_token,$userid);
        $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
        $Url="https://test-open.webank.com/s/web-wallet-wx/#/person/deposits/transOut/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;
        $this->redirect($Url);
       // var_dump($Url);die();
    }
    /**
     * 未支付订单支付
     * author  Fancy
     */
    public function actionPay(){
        $orderid=Tool::getValidParam('orderid','string');
        $userid=$this->member['id'];
        $sql = "SELECT id,ordernum  FROM {{house_order}}  WHERE status=1 and mid=$userid and id=$orderid";
        $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        $ordernum=$orderdetail['ordernum'];
        if($orderdetail){
            $access_token=Mod::app()->memcache->get('access_token');
            $app_Id=Wzbank::appid;
            $nonce = Wzbank::strings(32);
            $ticket =Wzbank::h5ticket($access_token,$userid);
            $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
            $Url="https://test-open.webank.com/s/web-wallet-wx/#/person/deposits/transIn/".$ordernum."/".$userid."/".$nonce."/".$sign."/".$app_Id;
            $results=array(
                'code'=>0,
                'url'=>$Url
            );
            echo json_encode($results);
        }else{
            echo "error";
            die();
        }



    }




    /**
     * 查询定期存入支取订单结果
     * author  Fancy
     */
    public function actionChecksave(){
      /*  $orderid="011911665728";
        $userid="7776";*/
        $orderid=Tool::getValidParam('orderid','string');
        $userid=$this->member['id'];
        $app_Id=Wzbank::appid;
        $nonce = Wzbank::strings(32);
        $version=Wzbank::version;
        $timestamp=time();
        $data=array(
            'userId'=>$userid,//个人用户userId
            'appId'=>$app_Id,//平台号(webank分配appId)
            'orderNo'=>$orderid,//订单号
            'type'=>"1",//1 存入 2 支取
        );
        $sign =Wzbank::housesign($nonce,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/h/api/wallet/server/person/term/result?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
        $postData = array(
            'userId'=>$userid,//个人用户userId
            'appId'=>$app_Id,//平台号(webank分配appId)
            'orderNo'=>$orderid,//订单号
            'type'=>"1",//1 存入 2 支取
        );
        $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));
        var_dump($result);
    }

    /**
     * 查询定期支取订单结果
     * author  Fancy
     */

    public function actionCheckget(){
       /* $orderid="011911665728";
        $userid="7776";*/
        $orderid=Tool::getValidParam('orderid','string');
        $userid=$this->member['id'];
        $app_Id=Wzbank::appid;
        $nonce = Wzbank::strings(32);
        $version=Wzbank::version;
        $timestamp=time();
        $data=array(
            'userId'=>$userid,//个人用户userId
            'appId'=>$app_Id,//平台号(webank分配appId)
            'orderNo'=>$orderid,//订单号
            'type'=>"2",//1 存入 2 支取
        );
        $sign =Wzbank::housesign($nonce,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/h/api/wallet/server/person/term/result?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
        $postData = array(
            'userId'=>$userid,//个人用户userId
            'appId'=>$app_Id,//平台号(webank分配appId)
            'orderNo'=>$orderid,//订单号
            'type'=>"2",//1 存入 2 支取
        );
        $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));
        var_dump($result);
    }





}