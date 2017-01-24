<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/26
 * Time: 17:20
 */

class MoneyController extends Controller{

    /**
     * 理财产品详情页
     * author  Fancy
     */
    protected $_siteUrl;
    public function actionIndex(){
        $id=Tool::getValidParam('id','integer');
        if(!empty($id)){
            $sql = "SELECT a.figue,a.financingid,m.title,m.earnings,m.cycle,m.details FROM {{house_activity}} as a LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE a.status=1 and m.id=$id";
            $moneyinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($moneyinfo){
                if (mb_strlen($moneyinfo['title'], 'utf8') > 23){
                    $moneyinfo['title']=mb_substr($moneyinfo['title'], 0, 23, 'utf8') . '...';
                }
            }else{
                echo "error";
                die();
            }
        }else{
            echo "error";
            die();
        }
        $data = array(
            'config'=>array(
                'site_title'=>$moneyinfo['title'],
                'Keywords'=>$moneyinfo['title'],
                'Description'=>$moneyinfo['title']
            ),
            'moneyinfo'=>$moneyinfo,
        );
        $this->render("index",$data);
    }


}