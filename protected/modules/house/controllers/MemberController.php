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
        $sql = "SELECT wxstatus  FROM {{member}} WHERE id=".$userid;
        $memberinfo=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$memberinfo){
            echo "error";die();
        }
        $osql = "SELECT SUM(money) as invest  FROM {{house_order}} WHERE mid=".$userid." and paystatus=2";
        $invest=Mod::app()->db->createCommand($osql)->queryRow();
        $msql = "SELECT m.earnings  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a ON o.houseid=a.id LEFT JOIN {{house_money}} as m on a.financingid=m.id";
        $earning=Mod::app()->db->createCommand($msql)->queryRow();

        if($memberinfo['wxstatus']==1){
            $sql = "SELECT o.ordernum,o.id,o.money,o.paystatus,o.mid,o.usetime,a.title,a.img,a.actime,a.city  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a on o.houseid=a.id WHERE o.status=1 and o.mid=$userid order by o.createtime desc";
            $orderlist=Mod::app()->db->createCommand($sql)->queryAll();
            if(!$orderlist){
                $orderlist = array();
            } else {
                
                    foreach($orderlist as $k=>$v) {
                        $sql = "SELECT city FROM {{house_city}}   WHERE status=1 and id=".$orderlist[$k]['city'];
                        $city=Mod::app()->db->createCommand($sql)->queryRow();
                        $orderlist[$k]['city']=$city['city'];
                        $actime=explode("|",$orderlist[$k]['actime']);
                        $orderlist[$k]['actime']=$actime[0];
                        $orderlist[$k]['createtime']=$actime[1];
                    }
            }   
        }
        $invest=$invest['invest'];
        $earning=$earning['earnings'];
        $revenue=mb_substr($invest*($earning/360/100),0,4);
        $data = array(
            'config'=>array(
                'site_title'=> '腾讯●楼盘商城',
                'Keywords'=>'腾讯●楼盘商城',
                'Description'=>'腾讯●楼盘商城',
            ),
            'orderlist'=>$orderlist,
            'invest'=>$invest,
            'earning'=>$earning,
            'revenue'=>$revenue,
        );
        $this->render('index',$data);
    }
    /**
     * 订单详情页面
     * author  Fancy
     */
    public function actionOrderd(){
        $orderid=Tool::getValidParam('id','integer');
        $userid=$this->member['id'];
        if(!empty($orderid)){
            try {
                $sql = "SELECT o.ordernum,o.id,o.money,o.paystatus,o.applytime,o.code,o.usetime,o.houseid,a.title,a.img,a.financingid,a.actime,a.city,a.validity,a.coupon,m.earnings,m.cycle  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a on o.houseid=a.id LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE o.status=1 and o.mid=$userid and o.id=$orderid order by o.createtime desc";
                $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
                $sql = "SELECT city FROM {{house_city}}   WHERE status=1 and id=".$orderdetail['city'];
                $city=Mod::app()->db->createCommand($sql)->queryRow();
            }
            catch(Exception $e) {
                echo "error";die();
            }
            $orderdetail['citynum']=$orderdetail['city'];
            $orderdetail['city']=$city['city'];
            $actime=explode("|",$orderdetail['actime']);
            $validitys=explode("|",$orderdetail['validity']);
            $orderdetail['actime']=$actime[0];
            $orderdetail['createtime']=$actime[1];
            $orderdetail['validity']=$validitys['0'];
            $orderdetail['updatetime']=$validitys['1'];
        }else{
            echo "error";die();
        }
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
        $id=Tool::getValidParam('id','integer');
        $app_Id=Wzbank::appid;
        $userid=$this->member['id'];
        try {
            $sql = "SELECT id,ordernum  FROM {{house_order}}  WHERE status=1 and mid=$userid and id=$id";
            $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        }
        catch(Exception $e) {
            echo "error";die();
        }
        $orderid=$orderdetail['ordernum'];
        if($orderdetail){
            $nonce = Wzbank::strings(32);
            $ticket =Wzbank::h5ticket($access_token,$userid);
            $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
            $Url=Wzbank::abankurl."/web-wallet-wx/#/person/deposits/confirm/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;
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
     * 提现
     * author  Fancy
     */
    public function actionWithdraw(){
        $access_token=Mod::app()->memcache->get('access_token');
        $id=Tool::getValidParam('id','integer');
        $userid=$this->member['id'];
        $app_Id=Wzbank::appid;
        try {
            $sql = "SELECT id,ordernum  FROM {{house_order}}  WHERE status=1 and mid=$userid and id=$id";
            $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        }
        catch(Exception $e) {
            echo "error";die();
        }
        $orderid=$orderdetail['ordernum'];
        if($orderdetail){
            $nonce = Wzbank::strings(32);
            $ticket =Wzbank::h5ticket($access_token,$userid);
            $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
            $Url=Wzbank::abankurl."/web-wallet-wx/#/person/deposits/transOut/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;
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
     * 未支付订单支付
     * author  Fancy
     */
    public function actionPay(){
        $id=Tool::getValidParam('id','integer');
        $userid=$this->member['id'];
        try {
            $sql = "SELECT id,ordernum  FROM {{house_order}}  WHERE status=1 and mid=$userid and id=$id";
            $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        }
        catch(Exception $e) {
            echo "error";die();
        }
        $ordernum=$orderdetail['ordernum'];
        if($orderdetail){
            $access_token=Mod::app()->memcache->get('access_token');
            $app_Id=Wzbank::appid;
            $nonce = Wzbank::strings(32);
            $ticket =Wzbank::h5ticket($access_token,$userid);
            $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
            $Url=Wzbank::abankurl."/web-wallet-wx/#/person/deposits/transIn/".$ordernum."/".$userid."/".$nonce."/".$sign."/".$app_Id;
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
        $sign =Wzbank::housesign($nonce,$version,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/wallet/server/person/term/result?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
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
        $sign =Wzbank::housesign($nonce,$version,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/wallet/server/person/term/result?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
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