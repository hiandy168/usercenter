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
     * 定期存入支取结果通知
     * author  Fancy
     */

    public function actionIndex(){


        $type = Tool::getValidParam('type','string');
        $nonce = Tool::getValidParam('nonce','string');
        $sign = Tool::getValidParam('sign','string');
        $timestamp = Tool::getValidParam('timestamp','string');
        $data = $_POST;
        $myfile = fopen("notify.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $type.'|');
        fwrite($myfile, $nonce.'|');
        fwrite($myfile, $sign.'|');
        fwrite($myfile, $timestamp.'|');
        fwrite($myfile, $data.'|');
        fclose($myfile);
        die();
        //开户结果通知
        if($type=="OPEN_ACCOUNT_NOTICE"){
           // file_put_contents("notify.txt",2,FILE_APPEND);
            file_put_contents("notify.txt",1,FILE_APPEND);
            $signs =Wzbank::housesign($nonce,$timestamp,$type,$data);
            if($sign==$signs){
                $info=json_decode($data);
                $sql = "UPDATE  {{member}} SET wxstatus=2 WHERE id= ".$info['userId'];
                $res=Mod::app()->db->createCommand($sql)->execute();
                file_put_contents("notify.txt","开户成功",FILE_APPEND);
            }
        }
        //支付结果通知
        if($type=="TERM_RESULT_NOTICE"){
            $signs =Wzbank::housesign($nonce,$timestamp,$type,$data);
            if($sign==$signs){
                $info=json_decode($data);
                if($info['type'==1]){
                    //支付失败
                    $sql = "UPDATE  {{house_order}} SET paystatus=1 WHERE ordernum= ".$info['orderNo']."and mid=".$info['userId'];
                    $res=Mod::app()->db->createCommand($sql)->execute();
                    if($res){
                        return "支付失败";die();
                    }
                }elseif($info['type'==2]){
                    //支付成功
                    if($info['result']==1){
                        $sql = "UPDATE  {{house_order}} SET paystatus=2 WHERE ordernum= ".$info['orderNo']."and mid=".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                        if($res){
                            return "支付成功";die();
                        }
                    }
                }elseif($info['type'==3]){
                    //确定使用成功
                    if($info['result']==1){
                        $sql = "UPDATE  {{house_order}} SET paystatus=3 WHERE ordernum= ".$info['orderNo']."and mid=".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                        if($res){
                            return "确定使用成功";die();
                        }
                    }
                }elseif($info['type'==4]){
                    //提现成功
                    if($info['result']==1){
                        $sql = "UPDATE  {{house_order}} SET paystatus=4 WHERE ordernum= ".$info['orderNo']."and mid=".$info['userId'];
                        $res=Mod::app()->db->createCommand($sql)->execute();
                        if($res){
                            return "提现成功";die();
                        }
                    }
                }
            }
    }


        /*$nonce = trim(Tool::getValidParam('nonce','string'));
        $timestamp = trim(Tool::getValidParam('timestamp','string'));
        $type = "TERM_RESULT_NOTICE";
        $sign = trim(Tool::getValidParam('sign','string'));
        $data = trim(Tool::getValidParam('Json String','string'));
        $signs =Wzbank::housesign($nonce,$timestamp,$type,$data);
        if($sign==$signs){
            $info=json_decode($data);
            $sql = "UPDATE  {{house_order}} SET paytime=$timestamp WHERE ordernum= ".$info['orderNo'];
            $res=Mod::app()->db->createCommand($sql)->execute();
        }*/
    }




}