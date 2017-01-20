<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:03
 */

class HactivityController extends HaController{


    /**
     * 活动列表页
     * author  Fancy
     */
    public function actionList(){
        $member=Mod::app()->session['admin_user'];
        $application_class = House_activity::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'authorid=:authorid and status=:status';
        $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 5;
        $pages->applyLimit($criteria);
        $returnData['houslist']= $application_class->findAll($criteria);
        $endtime=explode("|", $returnData['houslist']['validity'])[1];
        $returnData['pages'] = $pages;
        $this->render('list',$returnData);
    }
    /**
     * 添加活动
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_activity::model();
        $houseinfo = null;
        if(!empty($id)){
            $houseinfo = $house_model->findByPk($id);
            if(empty($houseinfo) || $houseinfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_activity();
                $house_model -> createtime = time();
            }
            $data = $_POST;
            foreach($data as $k=>&$value){
                $value=Safetool::SafeFilter($value);
            }
            foreach($data as $_k => $_v){
                $house_model -> $_k = $_v;
            }
            $actime=$house_model['actime'];
            $actime1=explode("|",$actime)[0];
            $actime2=explode("|",$actime)[1];
            $actimes=strtotime($actime1).'|'.strtotime($actime2);
            $validity=$house_model['validity'];
            $validity1=explode("|",$validity)[0];
            $validity2=explode("|",$validity)[1];
            $validitys=strtotime($validity1).'|'.strtotime($validity2);
            $house_model -> preview = "h5";
            $house_model -> updatetime = time();
            $house_model -> authorid = $admininfo['id'];
            $house_model -> author = $admininfo['name'];
            $house_model -> actime = $actimes;
            $house_model -> validity = $validitys;
            if($house_model->save()){
                Tool::alert('操作成功','/houseadmin/hactivity/list');
            }
        }
        $viewData['houseinfo'] = $houseinfo;
        //var_dump($viewData['houseinfo']);
        $this->render("add",$viewData);
    }


    /**
     * 删除活动
     * author  Fancy
     */
    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $houseInfo = House_activity::model()->find('id=:id', array(':id'=>$id));
        if(!empty($houseInfo)){
            $houseInfo->status = 2;
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }
        echo $returnData;
    }

    /**
     * 根据house_id  查询房产信息
     * author  Fancy
     */

    public function actionHoseinfo(){
        //$houseid=172631;
        $appId = 10000127;
        $appKey = 'c3a8c431d386516044e80211978aeab6';
        $houseid=Tool::getValidParam('houseid','integer');
        $rand = time();
        $_signatureParamArr = array ($appId, $appKey,$rand );
        sort ( $_signatureParamArr, SORT_STRING );
        $_signature = sha1 ( implode ( ($_signatureParamArr) ) );
        $url="http://api.wii.qq.com/app/access_token?app_id=".$appId."&rand=".$rand."&signature=".$_signature;
        if(empty(Mod::app()->session['facctoken'])){
            $info=$this->http_get($url);
            Mod::app()->session['facctoken'] = $info['data']['access_token'];
        }
        if($info['res']==0){
            $house=$this->http_post(Mod::app()->session['facctoken'],$houseid);
            echo $house;
        }else{
            echo $info;
        }
    }
    /**
     * curl  获取access_token
     * author  Fancy
     */
    static function http_get($url){
        $curl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $aStatus = curl_getinfo($curl);
        curl_close($curl);
        if(intval($aStatus["http_code"])==200){
            return json_decode($data, true);
        }else{
            return json_decode($data, true);
        }
    }
    /**
     * curl token,houseid  返回获取房产信息
     * author  Fancy
     */
    static function http_post($token,$houseid){
        $url = "http://api.wii.qq.com/s/house/house/house/get_house_info?access_token=".$token;
        $post_data = array ("house_id" => $houseid);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }



}