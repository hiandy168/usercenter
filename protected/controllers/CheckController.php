<?php

class CheckController extends AController {
    
  
    public function actionIndex() {
        header("Content-type: text/html; charset=utf-8");
		 $data =array();
                 $data['bill_date'] = Mod::app()->request->getPost('bill_date');//post
                 $data['out_trade_no'] = Mod::app()->request->getPost('out_trade_no');//post
                 
        include_once("protected/components/wx/WxPayPubHelper.php");
	
        
        
        //对账单日期
	if ($data["bill_date"]){
	    $bill_date = $data["bill_date"];
		
		//使用对账单接口
		$downloadBill = new DownloadBill_pub();
		//设置对账单接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$downloadBill->setParameter("bill_date","$bill_date");//对账单日期 
		$downloadBill->setParameter("bill_type","ALL");//账单类型 
		//非必填参数，商户可根据实际情况选填
		//$downloadBill->setParameter("device_info","XXXX");//设备号  
		
		//对账单接口结果
		$downloadBillResult = $downloadBill->getResult();
		echo $downloadBillResult['return_code'];
		
		if ($downloadBillResult['return_code'] == "FAIL") {
			echo "通信出错：".$downloadBillResult['return_msg'];
		}else{
			 $res = $downloadBill->response;
			 $res = $this->do_formart($res);
                         foreach($tenpay_result as $t){
                           $t_order_id = (string)str_replace(' `', '',$t['商家订单号']);
                            //订单返回值
                            $sql = 'select * from {{order}} where out_trade_no="'.$t_order_id.'"';
                            $res_u = Mod::app()->db->createCommand($sql)->queryRow();
                            if(empty($res_u)){
                                echo '本地数据不存在';die(); 
                            }
                            
                            if(($t['交易状态'] =='`SUCCESS' || strstr($t['交易状态'], 'SUCCESS')) && $res_u['pay_status']!=1) {
                                             echo '订单号：'.$t_order_id.'数据有错误 我们自动修复';
                                             $code = substr(md5($res_u['phone'].$res_u['out_trade_no'].'ufenc'), 0, 16).substr(md5($res['num'].'wen'), -16, 16);
                                             $sql_up = 'update {{order}} set pay_status =1,code ="'.$code.'",transaction_id="'. $orderQueryResult['transaction_id'].'"  where  id ="'.$res_u['id'].'"';
                                             Mod::app()->db->createCommand($sql_up)->execute();
                                
                            }
                            
                            if(!strstr($t['交易状态'], 'SUCCESS') && $res_u['pay_status']==1) {
                                             echo '订单号：'.$t_order_id.'数据有错误 我们自动修复';
                                             $sql_up = 'update {{order}} set pay_status =0,code ="",transaction_id="'. $orderQueryResult['transaction_id'].'"  where  id ="'.$res_u['id'].'"';
                                             Mod::app()->db->createCommand($sql_up)->execute();
                                
                            }
                            
                         
                        
                         }

		}
        }
        
        
        
	//退款的订单号
	if ($data['out_trade_no']){
	    $out_trade_no = $data['out_trade_no'];

		//使用订单查询接口
		$orderQuery = new OrderQuery_pub();
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		//非必填参数，商户可根据实际情况选填
		//$orderQuery->setParameter("sub_mch_id","XXXX");//子商户号  
		//$orderQuery->setParameter("transaction_id","XXXX");//微信订单号
		
		//获取订单查询结果
		$orderQueryResult = $orderQuery->getResult();
		
		//商户根据实际情况设置相应的处理流程,此处仅作举例
		if ($orderQueryResult["return_code"] == "FAIL") {
			echo "通信出错：".$orderQueryResult['return_msg']."<br>";
		}
		elseif($orderQueryResult["result_code"] == "FAIL"){
			echo "错误代码：".$orderQueryResult['err_code']."<br>";
			echo "错误代码描述：".$orderQueryResult['err_code_des']."<br>";
		}
		else{
			echo "交易状态：".$orderQueryResult['trade_state']."<br>";
//			echo "设备号：".$orderQueryResult['device_info']."<br>";
			echo "用户标识：".$orderQueryResult['openid']."<br>";
			echo "是否关注公众账号：".$orderQueryResult['is_subscribe']."<br>";
			echo "交易类型：".$orderQueryResult['trade_type']."<br>";
			echo "付款银行：".$orderQueryResult['bank_type']."<br>";
			echo "总金额：".$orderQueryResult['total_fee']."<br>";
			echo "现金券金额：".$orderQueryResult['coupon_fee']."<br>";
			echo "货币种类：".$orderQueryResult['fee_type']."<br>";
			echo "微信支付订单号：".$orderQueryResult['transaction_id']."<br>";
			echo "商户订单号：".$orderQueryResult['out_trade_no']."<br>";
//			echo "商家数据包：".$orderQueryResult['attach']."<br>";
			echo "支付完成时间：".$orderQueryResult['time_end']."<br>";
                       $sql = 'select * from {{order}} where out_trade_no="'.$data['out_trade_no'].'"';
                      
                        $res = Mod::app()->db->createCommand($sql)->queryRow();
                        if(empty($res)){
                            echo '本地数据不存在';die(); 
                        }
                        if($orderQueryResult['trade_state']=='SUCCESS' && $res['pay_status']!=1){
                                         echo '订单号：'.$orderQueryResult['out_trade_no'].'数据有错误 我们自动修复';
                                         $code = substr(md5($res['phone'].$res['out_trade_no'].'ufenc'), 0, 16).substr(md5($res['num'].'wen'), -16, 16);
                                         $sql_up = 'update {{order}} set pay_status =1,code ="'.$code.'",transaction_id="'. $orderQueryResult['transaction_id'].'"  where  id ="'.$res['id'].'"';
                                         $res = Mod::app()->db->createCommand($sql_up)->execute();
                        }
                        
                        if($orderQueryResult['trade_state']=='NOTPAY' && $res['pay_status']==1){
                                         echo '订单号：'.$orderQueryResult['out_trade_no'].'数据有错误 我们自动修复';
                                         $sql_up = 'update {{order}} set pay_status =0,code ="",transaction_id="'. $orderQueryResult['transaction_id'].'"  where  id ="'.$res['id'].'"';
                                         $res = Mod::app()->db->createCommand($sql_up)->execute();
                            
                        }
		}	
	}
        
//        NOTPAY
//        SUCCESS

	//商户自行增加处理流程
	//......
        
            $this->render('check', $data);
    }


	function do_formart($result) {
//                if(strstr(iconv("GB2312","UTF-8",$result),'没有生成对账单文件')){
//                     return array();
//                }
//                if(strstr(iconv("GB2312","UTF-8",$result),'1137:签名abstract验证失败')){
//                     return array('error'=>1,'mess'=>'1137:签名abstract验证失败');
//                }
//                $str_arr = explode("总交易单数",iconv("GB2312","UTF-8",$result));
                
                if(strstr($result,'没有生成对账单文件')){
                     return array();
                }
                if(strstr($result,'1137:签名abstract验证失败')){
                     return array('error'=>1,'mess'=>'1137:签名abstract验证失败');
                }
                $str_arr = explode("总交易单数",$result);
                
                $result = explode("\n",$str_arr[0]);
                $key = explode(',',array_shift($result));
                foreach($result as $k=>$r){
                    $temp[$k]  = explode(',',$r);
                    foreach($key as $kk=>$vv){
                       $vv && $temp[$k][$kk] && $res[$k][$vv] = $temp[$k][$kk];
                    }
                }
                return $res;
   }
   
   function getdata() {
       $sql1 ='select count(*) from {{order}}' ;
       $sql2 ='select count(*) from {{order}} where pay_status=1';
       $res1 = Mod::app()->db->createCommand($sql1)->execute();
       $res2 = Mod::app()->db->createCommand($sql2)->execute();
   }
   
  
}
