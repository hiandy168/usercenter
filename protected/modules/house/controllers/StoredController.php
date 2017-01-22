<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30
 * Time: 15:44
 */

class StoredController extends HouseController{

    /**
     * 我要预存
     * author  Fancy
     */
    public function actionIndex(){
        $id=Tool::getValidParam('id','integer');
        $cookie_mod=Cookie::get('city');
        if(!empty($id)){
            $sql = "SELECT a.id,a.phone,a.city,a.financingid,a.actime,a.coupon,a.desc,a.figue,a.img,a.dtitle,m.title,m.earnings,m.cycle FROM {{house_activity}} as a LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE a.status=1 and a.type=1 and city=$cookie_mod and a.id=$id";
            $houseinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($houseinfo){
                if($houseinfo['city']==1){
                    $houseinfo['city']="武汉";
                }elseif($houseinfo['city']==2){
                    $houseinfo['city']="郑州";
                }
                $houseinfo['actime']=explode("|",$houseinfo['actime'])[1];
                if($houseinfo['actime']<time()){
                    echo "error";
                    die();
                }
                if (mb_strlen($houseinfo['dtitle'], 'utf8') > 23){
                    $houseinfo['dtitle']=mb_substr($houseinfo['dtitle'], 0, 23, 'utf8') . '...';
                }
            }else{
                echo "error";
                die();
            }
        }else{
            echo "error";
            die();
        }
        $userid=$this->member['id'];
       /* $sqls="SELECT phone,realcard,realname,wxstatus FROM {{member}} WHERE id=78120";
        $memberinfo=Mod::app()->db->createCommand($sqls)->queryRow();*/
        $data = array(
            'config'=>array(
                'site_title'=> $houseinfo['dtitle'],
                'Keywords'=>'产品详细',
                'Description'=>'产品详细'
            ),
            'houseinfo'=>$houseinfo,
            //'memberinfo'=>$memberinfo,
        );
        $this->render("index",$data);

    }
    /**
     * 我要预存
     * author  Fancy
     */

    public function actionAjaxinfo(){
        if(Mod::app()->request->isPostRequest){
            $access_token=Mod::app()->memcache->get('access_token');
            $realname=Tool::getValidParam('realname','string');
            $realphone=Tool::getValidParam('realphone','string');
            $realid=Tool::getValidParam('realid','string');

            $userid=$this->member['id'];
            //var_dump($userid);die();
            $sqls = "UPDATE  {{member}} SET realcard='".$realid."',realname='".$realname."' WHERE id= ".$userid;
            $res=Mod::app()->db->createCommand($sqls)->execute();
            $id=Tool::getValidParam('id','string');
            $money=Tool::getValidParam('money','int');
            //var_dump($money);die();
            $app_Id=Wzbank::appid;
            $version=Wzbank::version;
            $orderid=date('md') . $this->random(8, 1);

            //$userid="7776";
            //$username=$this->member['username'];
            $username="fancy";
            $arr['mid']  =$userid;
            $arr['houseid']  =$id;
            $arr['ordernum']  =$orderid;
            $arr['code']  =date('md') .$this->random(8);
            $arr['money']  =$money;
            $arr['applytime']  =time();
            $arr['createtime']  =time();
            $query = Mod::app()->db->createCommand()->insert('dym_house_order',$arr);
            //$orderid= Mod::app()->db->getLastInsertID();
            if($query){
                $nonce = Wzbank::strings(32);
                $timestamp=time();
                $data=array('userId' => $userid, 'userName' => $username,'idType' => '01','idNo' => $realid, 'name' => $realname, 'phoneNo' =>$realphone,);
                $sign =Wzbank::housesign($nonce,strval($timestamp),json_encode($data));
                $postUrl =Wzbank::bankurl."/h/api/wallet/server/person/sync?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;//同步个人开户信息
                $postData = array(
                    'userId' => $userid,
                    'userName' =>$username,
                    'idType' => "01",
                    'idNo' => $realid,
                    'name' => $realname,
                    'phoneNo' => $realphone,
                );
                $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));
                //var_dump($result);die();
                if($result['code']==0){
                    $ticket =Wzbank::h5ticket($access_token,$userid);
                    $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
                    $result=self::actionAjaxorder($nonce,$userid,$orderid,$money);
                    if($result['code']==0){
                        $Url="https://test-open.webank.com/s/web-wallet-wx/#/person/deposits/transIn/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;//跳转开户链接
                        // var_dump($Url);die();
                        $results=array(
                            'code'=>0,
                            'url'=>$Url
                        );
                        echo json_encode($results);
                    }
                }elseif($result['code']==100013||$result['code']==100004){
                    $result=self::actionAjaxorder($nonce,$userid,$orderid,$money);
                    //var_dump($result);die();
                    if($result['code']==0){
                        $ticket =Wzbank::h5ticket($access_token,$userid);
                        $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
                        $Url="https://test-open.webank.com/s/web-wallet-wx/#/person/deposits/transIn/".$orderid."/".$userid."/".$nonce."/".$sign."/".$app_Id;
                        //var_dump($Url);die();
                        $results=array(
                            'code'=>0,
                            'url'=>$Url
                        );
                        echo json_encode($results);
                    }
                }

            }

        }
    }

    /**
     * 支付完成回跳页面
     * author  Fancy
     */
    public function actionConfirmorder(){
        $userid=$this->member['id'];
        $orderid=Tool::getValidParam('orderid','string');
        $sql = "SELECT o.ordernum,o.id,o.money,o.paystatus,o.mid,a.title,a.img,a.actime,a.city,a.coupon  FROM {{house_order}} as o LEFT JOIN {{house_activity}} as a on o.houseid=a.id WHERE o.status=1 and o.mid=$userid and o.ordernum=$orderid order by o.createtime desc";
        $orderdetail=Mod::app()->db->createCommand($sql)->queryRow();
        //var_dump($orderdetail);
        $data = array(
            'config'=>array(
                'site_title'=> $orderdetail['title'],
                'Keywords'=>$orderdetail['title'],
                'Description'=>$orderdetail['title']
            ),
            'orderdetail'=>$orderdetail,
        );
        $this->render('confirmorder',$data);
    }

    /**
     * 同步订单信息
     * author  Fancy
     */
    public function actionAjaxorder($nonce,$userid,$orderid,$money){
        $app_Id=Wzbank::appid;
        $version=Wzbank::version;
        $timestamp=time();
        $data=array(
            'orderNo'=>$orderid,//订单号
            'userId'=>$userid,//个人用户userId
            'companyUserId'=>"1",//公司用户userId
            'productId'=>"1",//产品ID
            'amount'=>$money.".10",//定期金额
            'companyProceeds'=>$money,//公司收款金额
            'expireTime'=>"2017-01-16",//定期到期日期
        );
        $sign =Wzbank::housesign($nonce,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/h/api/wallet/server/person/term/sync?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
        $postData = array(
            'orderNo'=>$orderid,//订单号
            'userId'=>$userid,//个人用户userId
            'companyUserId'=>"1",//公司用户userId
            'productId'=>"1",//产品ID
            'amount'=>$money.".10",//定期金额
            'companyProceeds'=>$money,//公司收款金额
            'expireTime'=>"2017-01-16",//定期到期日期
        );
        $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));
        return $result;
    }


    public function actionAccount(){

        echo "11";
        var_dump(date('md') . $this->random(8, 1));
    }



    /**
     * 订单号生成
     * author  Fancy
     */
    public function random($length, $numeric = FALSE) {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        if ($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }
    /**
     * 用户解锁
     * author  Fancy
     */
    public function actionUnlock(){
        $app_Id=Wzbank::appid;
        $version=Wzbank::version;
        $nonce = Wzbank::strings(32);
        $timestamp=time();
        $data=array(
            'userId'=>"2",//平台用户号
        );
        $sign =Wzbank::housesign($nonce,strval($timestamp),json_encode($data));
        $postUrl =Wzbank::bankurl."/h/api/wallet/server/account_manage/unlock?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
        $postData = array(
            'userId'=>"2",//平台用户号
        );
        $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));
        var_dump($postUrl,json_encode($postData));
        var_dump($result);

    }









}