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
        $group_id=$member['group_id'];
        $application_class = House_activity::model();
        $criteria = new CDbCriteria();
        if($group_id==1){
            $criteria->condition = 'status=:status';
            $criteria->params = array(':status'=>1);
        }else{
            $criteria->condition = 'authorid=:authorid and status=:status';
            $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
        }
        $criteria->order = 'id desc';   // 排序
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $activityinfo= $application_class->findAll($criteria);
        foreach($activityinfo as $k=>$v) {
            $sql = "SELECT count(id) as count FROM {{house_order}} WHERE houseid=".$activityinfo[$k]['id'];
            $orderinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($orderinfo['count']>0){
                $activityinfo[$k]['status']=1;
            }else{
                $activityinfo[$k]['status']=2;
            }
            $actime=explode("|",$activityinfo[$k]['actime']);
            $validitys=explode("|",$activityinfo[$k]['validity']);
            $activityinfo[$k]['actime']=$actime[0];
            $activityinfo[$k]['createtime']=$actime[1];
            $activityinfo[$k]['validity']=$validitys[0];
            $activityinfo[$k]['updatetime']=$validitys[1];
        }

        $returnData['houslist']=$activityinfo;
        /*$endtime_temp=explode("|", $returnData['houslist']['validity']);
        $endtime=$endtime_temp[1];*/
        $returnData['pages'] = $pages;
        $returnData['group_id'] = $group_id;
        $this->render('list',$returnData);
    }
    /**
     * 添加活动
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $group_id=$admininfo['group_id'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_activity::model();
        $houseinfo = null;
        if(!empty($id)){
            $sql = "SELECT count(id) as count FROM {{house_order}} WHERE houseid=".$id;
            $orderinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($orderinfo['count']>0){
                echo "error";
                die();
            }
            $houseinfo = $house_model->findByPk($id);
            $actime=explode("|",$houseinfo['actime']);
            $validitys=explode("|",$houseinfo['validity']);
            $houseinfo['actime']=$actime[0];
            $houseinfo['createtime']=$actime[1];
            $houseinfo['validity']=$validitys['0'];
            $houseinfo['updatetime']=$validitys['1'];
            if($group_id==1){
                if(empty($houseinfo)){
                    echo "error";die();
                }
            }else{
                if(empty($houseinfo) || $houseinfo['authorid'] != $admininfo['id']){
                    echo "error";die();
                }
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
            if($houseinfo['poststatus']!=1){
                $actime=$house_model['actime'];
                $tmp=explode("|",$actime);
                if(!empty($tmp[0])&&$tmp[0]){
                    $actime1=$tmp[0];
                }else{
                    echo "error";
                    die();
                }
                if(!empty($tmp[1])&&$tmp[1]){
                    $actime2=$tmp[1];
                }else{
                    echo "error";
                    die();
                }
                $actimes=strtotime($actime1).'|'.strtotime($actime2);
                $validity=$house_model['validity'];
                $tmps=explode("|",$validity);
                if(!empty($tmps[0])&&$tmps[0]){
                    $validity1=$tmps[0];
                }else{
                    echo "error";
                    die();
                }
                if(!empty($tmps[1])&&$tmps[1]){
                    $validity2=$tmps[1];
                }else{
                    echo "error";
                    die();
                }
                $validitys=strtotime($validity1).'|'.strtotime($validity2);
                $house_model -> actime = $actimes;
                $house_model -> validity = $validitys;
            }

            if(!isset($_POST['type'])){
                $house_model -> type = 1;
            }

            $house_model -> preview = "h5";
            $house_model -> updatetime = time();
            if($group_id!=1){
                $house_model -> authorid = $admininfo['id'];
                $house_model -> author = $admininfo['name'];
            }

            if($house_model->save()){
                Tool::alertpop('操作成功','/houseadmin/hactivity/list');
            }
        }
        $sql = "SELECT id,title FROM {{house_money}} WHERE status=1";
        $moneyinfo=Mod::app()->db->createCommand($sql)->queryAll();

        $sql = "SELECT id,site FROM {{house_tenant}} WHERE status=1 and wxstatus=1 and authorid=".$admininfo['id'];
        $tenant=Mod::app()->db->createCommand($sql)->queryRow();
        if($tenant){
            $result=1;
        }else{
            $result=2;
        }
        $viewData['result'] = $result;
        $viewData['tenant'] = $tenant;
        $viewData['houseinfo'] = $houseinfo;
        $viewData['moneyinfo'] = $moneyinfo;
        $this->render("add",$viewData);
    }


    /**
     * 删除活动
     * author  Fancy
     */
    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $admininfo  = Mod::app()->session['admin_user'];
        $group_id=$admininfo['group_id'];
        if($group_id==1){
            $houseInfo = House_activity::model()->find('id=:id', array(':id'=>$id));
        }else{
            $houseInfo = House_activity::model()->find('id=:id and authorid=:authorid', array(':id'=>$id,':authorid'=>$admininfo['id']));
        }
        if(!empty($houseInfo)){
            $houseInfo->status = 2;
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }else{
            echo "200";
            die();
        }
        echo $returnData;
    }

    /**
     * 发布状态
     * author  Fancy
     */
    public function actionChangestatus(){
        $id =Tool::getValidParam('id','integer');
        $poststatus =Tool::getValidParam('poststatus','integer');
        $admininfo  = Mod::app()->session['admin_user'];
        $group_id=$admininfo['group_id'];
        if($group_id==1){
            $houseInfo = House_activity::model()->find('id=:id', array(':id'=>$id));
        }else{
            $houseInfo = House_activity::model()->find('id=:id and authorid=:authorid', array(':id'=>$id,':authorid'=>$admininfo['id']));
        }

        if(!empty($houseInfo)){
            if($poststatus==1){
                $houseInfo->poststatus = 1;
            }elseif($poststatus==2){
                $houseInfo->poststatus = 2;
            }
            else{
                echo "error";
            }
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }else{
            echo "error";
            die();
        }
        echo $returnData;
    }

    /**
     * 推荐状态
     * author  Fancy
     */
    public function actionRecommend(){
        $id =Tool::getValidParam('id','integer');
        $poststatus =Tool::getValidParam('poststatus','integer');
        $admininfo  = Mod::app()->session['admin_user'];
        $group_id=$admininfo['group_id'];
        if($group_id==1){
            $houseInfo = House_activity::model()->find('id=:id', array(':id'=>$id));
        }else{
            $houseInfo = House_activity::model()->find('id=:id and authorid=:authorid', array(':id'=>$id,':authorid'=>$admininfo['id']));
        }

        if(!empty($houseInfo)){
            if($poststatus==1){
                $houseInfo->recommend = 1;
            }elseif($poststatus==2){
                $houseInfo->recommend = 2;
            }
            else{
                echo "error";
            }
            if ($houseInfo->save()) {
                $returnData = '100';
            }else{
                $returnData = '200';
            }
        }else{
            echo "error";
            die();
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
     * 获取已经推荐数量
     * author  Fancy
     */
    public function actionCount(){
        $sql = "SELECT count(id) as count FROM {{house_activity}} WHERE recommend=1;";
        $tenant=Mod::app()->db->createCommand($sql)->queryRow();
        if($tenant){
            echo $tenant['count'];
        }else{
            echo "error";
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