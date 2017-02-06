<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 16:03
 */

class CallbackController extends Controller{

    /**
     * 开户结果通知
     * author  Fancy
     */
    public function actionAccountopen(){
        echo "车公共";
    }

    /**
     * 微众返回结果通知
     * author  Fancy
     */

    public function actionIndex(){
        $type = Tool::getValidParam('type','string');
        $nonce = Tool::getValidParam('nonce_str','string');
        $sign = strtolower(Tool::getValidParam('sign','string'));
        $timestamp = Tool::getValidParam('timestamp','string');
        $data = $GLOBALS['HTTP_RAW_POST_DATA'];
        $info=json_decode($data,true);
        $signs =Wzbank::housesign($nonce,$timestamp,$type,$data);
        $paytime=intval(mb_substr($timestamp,0,10));
        $myfile = fopen("notify.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $type.'|');
        fwrite($myfile, $nonce.'|');
        fwrite($myfile, $sign.'|');
        fwrite($myfile, $timestamp.'|');
        fwrite($myfile, $data.'|');
        fwrite($myfile, $signs.'|');
        fclose($myfile);

        //开户结果通知
        if($type=="OPEN_ACCOUNT_NOTICE"){
            if($sign==$signs){
                if($info['result']==1){
                    if($info['usertype']==0){
                        $sql = "UPDATE  {{member}} SET wxstatus=1 WHERE id= ".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                    }elseif($info['usertype']==1){
                        $authorid=substr($info['userId'],1);
                        $sql = "UPDATE  {{house_tenant}} SET wxstatus=1 WHERE authorid= ".$authorid;
                        $res=Mod::app()->db->createCommand($sql)->execute();
                    }
                    if($res){
                        $results=array(
                            'code'=>0,
                            'message'=>"成功"
                        );
                    }else{
                        $results=array(
                            'code'=>1,
                            'message'=>"失败"
                        );
                    }
                    return $results;die();
                }
            }
        }
        //支付结果通知
        if($type=="TERM_RESULT_NOTICE"){
            if($sign==$signs){
                if($info['type']==1&&$info['result']==0){
                    //支付成功
                    $sql = "UPDATE  {{house_order}} SET paystatus=2,paytime=".$paytime." WHERE ordernum= '".$info['orderNo']."' and mid=".$info['userId'];
                    $res=Mod::app()->db->createCommand($sql)->execute();
                    if($res){
                        $results=array(
                            'code'=>1,
                            'message'=>"支付成功"
                        );
                    }
                }elseif($info['type']==2&&$info['advanceWithdrawFlg']=="N"){
                    //确定使用成功
                    if($info['result']==0){
                        $sql = "UPDATE  {{house_order}} SET paystatus=3,usetime=".$paytime." WHERE ordernum= '".$info['orderNo']."'and mid=".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                        if($res){
                            return "确认使用支付成功";die();
                        }
                    }
                }elseif($info['type']==2&&$info['advanceWithdrawFlg']=="Y"){
                    //提现成功
                    if($info['result']==0){
                        $sql = "UPDATE  {{house_order}} SET paystatus=4,usetime=".$paytime." WHERE ordernum= ".$info['orderNo']." and mid=".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                        if($res){
                            return "提现成功";die();
                        }
                    }
                }
                return $results;die();
            }
    }
    }

}