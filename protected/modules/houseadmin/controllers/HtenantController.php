<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/22
 * Time: 18:03
 */

class HtenantController extends HaController{
    /**
     * 商户管理列表
     * author  Fancy
     */
    public function actionList(){
        $member=Mod::app()->session['admin_user'];
        $application_class = House_tenant::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'authorid=:authorid and status=:status';
        $criteria->params = array(':authorid'=>$member['id'],':status'=>1);
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);
        $sql = "SELECT id FROM  {{house_tenant}} WHERE status=1 and  authorid= ".$member['id'];
        $res=Mod::app()->db->createCommand($sql)->execute();
        if($res){
            $result=0;
        }else{
            $result=1;
        }
        $returnData['tenantlist']= $application_class->findAll($criteria);
        $returnData['pages'] = $pages;
        $returnData['result'] = $result;
        $this->render('list',$returnData);
    }
    /**
     * 添加编辑商户信息
     * author  Fancy
     */
    public function actionAdd(){
        $admininfo  = Mod::app()->session['admin_user'];
        $id =Tool::getValidParam('id','integer');
        $house_model = House_tenant::model();
        $tenantinfo = null;
        if(!empty($id)){
            $tenantinfo = $house_model->findByPk($id);
            if(empty($tenantinfo) || $tenantinfo['authorid'] != $admininfo['id']){
                echo "error";die();
            }
        }
        if(Mod::app()->request->isPostRequest){
            if(empty($id)) {
                $house_model = new House_tenant();
                $house_model -> createtime = time();
            }
            $data = $_POST;
            foreach($data as $k=>&$value){
                $value=Safetool::SafeFilter($value);
            }
            foreach($data as $_k => $_v){
                $house_model -> $_k = $_v;
            }
            $house_model -> updatetime = time();
            $house_model -> authorid = $admininfo['id'];
            $house_model -> author = $admininfo['name'];
            $newtenant=array();
            foreach($house_model->attributes as $k=>$v){
                $newtenant['userId']="h".$house_model['authorid'];//平台id
                $newtenant['userName']=$house_model['author'];//平台用户名
                $newtenant['corpName']=$house_model['companyname'];//公司名称
                $newtenant['businessLicense']=$house_model['busnum'];//营业执照号
                $newtenant['organizationCode']=$house_model['code'];//组织机构代码
                $newtenant['texRegistrationNo']=$house_model['taxid'];//税务登记证件号
                $newtenant['openBranchName']=$house_model['bankname'];//开户行名
                $newtenant['accountNo']=$house_model['banknum'];//账号
                $newtenant['accountName']=$house_model['accountname'];//账户名
                $newtenant['legalPerName']=$house_model['busentity'];//法人姓名
                $newtenant['respPerIdType']=$house_model['idtype'];//责任人证件类型
                $newtenant['respPerIdNo']=$house_model['operatornum'];//责任人证件号
                $newtenant['respPerName']=$house_model['operatorname'];//责任人姓名
                $newtenant['respPerTelephoneNo']=$house_model['operatorphone'];//责任人手机
            }
            $app_Id=Wzbank::appid;
            $version=Wzbank::version;
            $nonce = Wzbank::strings(32);
            $access_token=Mod::app()->memcache->get('access_token');
            $timestamp=time();
            $userid="h".$admininfo['id'];
            $sign =Wzbank::housesign($nonce,$version,strval($timestamp),json_encode($newtenant));
            $postUrl =Wzbank::bankurl."/h/api/wallet/server/corporation/sync?appId=".$app_Id."&sign=".$sign."&nonce=".$nonce."&version=".$version."&timestamp=".$timestamp;
            $postData = $newtenant;
            $result= Wzbank::curl_post_ssl($postUrl,json_encode($postData));//同步公司信息
            if($result['code']==0){
                $ticket =Wzbank::h5ticket($access_token,$userid);
                $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
                $Url="https://test-open.webank.com/s/web-wallet/#!/company/main/".$userid."/".$nonce."/".$sign."/".$app_Id;
            }elseif($result['code']==100013){
                $ticket =Wzbank::h5ticket($access_token,$userid);
                $sign =Wzbank::h5housesign($nonce,$ticket,$userid);
                $Url="https://test-open.webank.com/s/web-wallet/#!/company/main/".$userid."/".$nonce."/".$sign."/".$app_Id;
            }
            //var_dump($Url);die();
            if($tenantinfo){
                $this->redirect($Url);
            }else{
                if($house_model->save()){
                    $this->redirect($Url);
                }
            }
        }
        $viewData['tenantinfo'] = $tenantinfo;
        $this->render("add",$viewData);
    }

    /**
     * 未开户成功商户可删除
     * author  Fancy
     */
    public function actionDel(){
        $id =Tool::getValidParam('id','integer');
        $admininfo  = Mod::app()->session['admin_user'];
        $tennatInfo = House_tenant::model()->find('id=:id and authorid=:authorid', array(':id'=>$id,':authorid'=>$admininfo['id']));
        if(!empty($tennatInfo)){
            $tennatInfo->status = 2;
            if ($tennatInfo->save()) {
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



}