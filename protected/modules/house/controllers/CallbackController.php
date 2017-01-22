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
        echo "open";
    }

    /**
     * 定期存入支取结果通知
     * author  Fancy
     */

    public function actionIndex(){

        $type = trim(Tool::getValidParam('type','string'));
        $nonce = trim(Tool::getValidParam('nonce','string'));
        $sign = trim(Tool::getValidParam('sign','string'));
        $timestamp = trim(Tool::getValidParam('timestamp','string'));
        $data = trim(Tool::getValidParam('Json String','string'));
        //开户结果通知
        if($type=="OPEN_ACCOUNT_NOTICE"){
            $signs =Wzbank::housesign($nonce,$timestamp,$type,$data);
            if($sign==$signs){
                file_put_contents("notify.txt","开户成功",FILE_APPEND);
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