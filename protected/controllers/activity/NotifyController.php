<?php
ini_set('date.timezone', 'Asia/Shanghai');
error_reporting(E_ERROR);

require_once dirname(dirname(dirname(__FILE__))) . '/vendor/wxpay/lib/WxPay.Api.php';

require_once dirname(dirname(dirname(__FILE__))) . '/vendor/wxpay/lib/WxPay.Notify.php';
require_once dirname(dirname(dirname(__FILE__))) . '/vendor/wxpay/example/log.php';

//初始化日志
$logHandler = new CLogFileHandler("../logs/" . date('Y-m-d') . '.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function Queryorder($transaction_id)
    {
        /*file_put_contents("notify.txt","回调开始",FILE_APPEND);*/
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
        ) {
            //支付成功之后的操作
            $ordersn = "select * from {{activity_duobao_gz_order}} where ordersn=" . $result["out_trade_no"];
            $ordersns = Mod::app()->db->createCommand($ordersn)->queryAll();
            if (!$ordersns[0]['status']) {
                //修改订单状态
                $sqlorder = "UPDATE  {{activity_duobao_gz_order}} SET status=1 WHERE ordersn= " . $result["out_trade_no"];
                $query = Mod::app()->db->createCommand($sqlorder)->execute();
                if ($query) {
                    $sqlog = "SELECT *,g.total as totals,m.productprice as priceone,m.ticket_total as totaoone FROM dym_activity_duobao_gz_order as o left JOIN dym_activity_duobao_gz_order_goods as g on o.id=g.orderid LEFT JOIN dym_activity_duobao_gz_goods as m on g.goodsid=m.id WHERE o.ordersn=".$result["out_trade_no"];
                    $ogoods = Mod::app()->db->createCommand($sqlog)->queryAll();
                    foreach ($ogoods as $row) {
                        for ($k = 0; $k < $row['totals']; $k++) {
                            if (empty($row)) {
                                continue;
                            }
                            $sqlt = "select max(ticket) as ticket from {{activity_duobao_gz_ticket}} where pid=" . $row['pid'] . " and goodsid=" . $row['goodsid'] . " ";
                            $oticket = Mod::app()->db->createCommand($sqlt)->queryAll();

                            for ($i = 0; $i < count($oticket); $i++) {
                                if (empty($oticket[$i]['ticket'])) {
                                    $ticket = intval($row['goodsid']) * 100000;
                                } else {
                                    $ticket = intval($oticket[$i]['ticket']) + 1;
                                }
                                $d = array(
                                    'pid' => $row['pid'],
                                    'openid' => $row['from_user'],
                                    'memberid' => $row['from_user'],
                                    'createtime' => time(),
                                    'orderid' => $row['orderid'],
                                    'goodsid' => $row['goodsid'],
                                    'ticket' => $ticket,
                                );
                                /*  for($k=0;$k<$row['total'];$k++){
                                      $querys = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_ticket',$d);
                                  }*/
                                $querys = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_ticket', $d);
                                if ($querys) {
                                    $gosql = " SELECT * FROM {{activity_duobao_gz_goods}} WHERE id=" . $row['goodsid'];
                                    $goods = Mod::app()->db->createCommand($gosql)->queryAll();
                                    for ($j = 0; $j < count($goods); $j++) {
                                        //file_put_contents("notify.txt","回调成功",FILE_APPEND);
                                        $ticket_total = intval($goods[$j]['ticket_total']) + 1;
                                        $sql = "UPDATE  {{activity_duobao_gz_goods}} SET ticket_total=" . $ticket_total . ",ticket_time=".time()." WHERE id= " . $row['goodsid'];
                                        $queryo = Mod::app()->db->createCommand($sql)->execute();
                                    }
                                }
                            }
                        }
                        file_put_contents("notify.txt","成功",FILE_APPEND);
                        $ss=$row['totaoone']+1;
                        if ($row['priceone'] == $ss) {
                            file_put_contents("notify.txt",$ss,FILE_APPEND);
                            $goodsid = $row['goodsid'];
                            $ticket_id = intval($goods['goodsid']) * 100000;
                            $max = $row['priceone'];
                            $fancy = " SELECT max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t  WHERE t.goodsid=$goodsid GROUP BY t.openid order by ordertime desc limit 5";
                            for ($tt = 0; $tt < 5; $tt++) {
                                $getData = $this->getUrl("http://m.dachuw.net/activity/duobao/caipiao");
                                if ($getData['retMsg'] != "error") {
                                    break;
                                }
                                sleep(1);
                            }
                            if ($getData && is_array($getData) && ("success" == $getData['retMsg'])) {
                                $openCode = intval(preg_replace("/\,/", "", $getData['data']['openCode']));//彩票码
                                $openExpect = $getData['data']['expect'];//彩票期数
                            }
                            $ogoods = Mod::app()->db->createCommand($fancy)->queryAll();
                            $totalTime = 0;
                            foreach ($ogoods as $key => $value) {
                                $totalTime += intval(date("His", $value['ordertime']));
                            }
                            $award = ($openCode + $totalTime) % ($max);
                            $result_ticket = intval($goodsid) * 100000 + $award;
                            $sqlst = "SELECT * FROM {{activity_duobao_gz_ticket}} WHERE  ticket=$result_ticket ";
                            $rows=Mod::app()->db->createCommand($sqlst)->queryRow();
                            $mid=$rows['memberid'];
                            $sqlm = "SELECT username FROM {{member}} WHERE  id=$mid";
                            $rowm=Mod::app()->db->createCommand($sqlm)->queryRow();
                            $sql = "UPDATE  {{activity_duobao_gz_goods}} SET ticket=".$result_ticket.",ticket_nickname='".$rowm['username']."',ticket_expect='".$openExpect."',ticket_code=".$openCode.",ticket_openid=".$rows['memberid']." WHERE id= ".$goodsid." ";
                            $query=Mod::app()->db->createCommand($sql)->execute();
                        }
                    }
                }
            }
            /*file_put_contents("notify.txt","回调成功",FILE_APPEND);*/

        }
        return false;
    }


    public function getUrl($url){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($curl);
        curl_close($curl);
        return json_decode($data,true);
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . json_encode($data));
        $notfiyOutput = array();
        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
            /*file_put_contents("notify.txt","订单查询失败",FILE_APPEND);*/
        }
        /* file_put_contents("notify.txt","订单查询ok",FILE_APPEND);*/
        return true;
    }
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
