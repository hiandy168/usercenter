<?php

class DemoController extends WController {
    
    public $demoHost = 'http://m.dachuw.net';
    public $openid = 'testopenid';

    public function Init(){
        parent::init();
        $this->demoHost = 'http://' . $_SERVER['HTTP_HOST'];
    }
    
    public function actionIndex() {
         $token = trim(Tool::getValidParam('token', 'string'));
         $this->render('index');
    }
    
    public function actionAddSignLog() {
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $login = '';
//        var_dump($this->member);exit;
        if(!$this->member){
            $login = true;
        }
        $url = $this->demoHost . $this->createUrl('/activity/checkIn/index') . '?access_token=' . $token . '&openid=' . $this->openid.'&login='.$login;
        $this->redirect($url);
    }
    
    public function actionStart() {
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $url = $this->demoHost . $this->createUrl('/activity/lottery/index') . '?access_token=' . $token . '&openid=' . $this->openid;
        $this->redirect($url);
    }

    public function actionAddSignUp() {
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $url = $this->demoHost . $this->createUrl('/activity/signUp/index') . '?access_token=' . $token . '&openid=' . $this->openid;
        $this->redirect($url);
    }

    public function actionMemberReg(){
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $tel = trim(Tool::getValidParam('tel', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $password= trim(Tool::getValidParam('password', 'string'));
        $repassword= trim(Tool::getValidParam('repassword', 'string'));
        $url = $this->demoHost . $this->createUrl('api/member/Reg') . '?access_token=' . $token . '&appid='.$appid.'&openid=' . $this->openid.'&tel='.$tel.'&password='.$password.'&repassword='.$repassword;
        $this->redirect($url);
    }

    public function actionMemberLogin(){
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $name = trim(Tool::getValidParam('name', 'string'));
        $password= trim(Tool::getValidParam('password', 'string'));
        $url = $this->demoHost . $this->createUrl('api/member/Login') . '?access_token=' . $token . '&appid='.$appid.'&openid=' . $this->openid.'&name='.$name.'&password='.$password;
        $this->redirect($url);
    }

    public function actionMemberTag(){
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $pid = trim(Tool::getValidParam('pid', 'string'));
        $type= trim(Tool::getValidParam('type', 'string'));
        $url = $this->demoHost . $this->createUrl('api/Behavior/Tag') . '?access_token=' . $token . '&appid='.$appid.'&openid=' . $this->openid.'&type='.$type.'&pid='.$pid;
        $this->redirect($url);
    }


      public function actionGetOpenId(){
       // $code = Mod::app()->request->getParam("code");
        $code = Tool::getValidParam("code","string");
        $options = Mod::app()->params['wechat'];
        $weObj = new Wechat($options);
        if($code) {
            $weObj = new Wechat($options);
            $jsonToken = $weObj->getOauthAccessToken();
            if (is_array($jsonToken)) {
                $wechatMember = $weObj->getOauthUserinfo($jsonToken['access_token'], $jsonToken['openid']);
                return $wechatMember['openid'];
            }
        }
        else{
            $callback = $this->createAbsoluteUrl("demo/getopenid");
            #得到code
            $url = $weObj->getOauthRedirect($callback);
            $this->redirect($url);
        }
    }

    public function operGetAccessToken($appid,$appkey) {
        $token = Mod::app()->memcache->get('access_token');
        if (!$token) {
            $json = $this->operFetch($this->demoHost . $this->createUrl('/api/token/get') . '?appid=' . $appid . '&appkey=' . $appkey);
            $result = json_decode($json,true);
            $token = $result['access_token'];
//            var_dump($result);exit;
            Mod::app()->memcache->set('access_token',$token,86400);
        }
        return $token;
    }

    private function operFetch($url) {
        $content = file_get_contents($url);
        return $content;
    }


    
    public function actionOpenid() {
        $token = Mod::app()->memcache->get('access_token_weixin');
        if (!$token) {
            $token = WxConf::GetAccessToken();
            Mod::app()->memcache->set('access_token_weixin',$token,86400);
        }
        
        $code = trim(Tool::getValidParam('code', 'string'));
        if ($code) {
            $openid = WxConf::getInfo($code);
            //Mod::app()->session['wx1_openid'] = $this->openid = $openid;
            print_r($openid);
        } else {
            $urlObj["appid"] = WxConf::APPID;
            $urlObj["redirect_uri"] = $this->demoHost . '/demo/openid';
            $urlObj["response_type"] = "code";
//                    $urlObj["scope"] = "snsapi_base";
            $urlObj["scope"] = "snsapi_userinfo";
            $urlObj["state"] = "STATE"."#wechat_redirect";
            $bizString = http_build_query($urlObj);
            $url =  "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
            $this->redirect($url);
        }
    }


    public function actionProjectreg() {
        $name = trim(Tool::getValidParam('name', 'string'));
        $introduction = trim(Tool::getValidParam('introduction', 'string'));
        $url = $this->demoHost . $this->createUrl('/project/reg');
        $this->redirect($url);
    }


    public function actionProjectlist() {
        $url = $this->demoHost . $this->createUrl('/project/projectlist');
        $this->redirect($url);
    }

    public function actionBehaviorstatistics() {
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $type= trim(Tool::getValidParam('type', 'string'));
        $remark= trim(Tool::getValidParam('remark', 'string'));
        $token = $this->operGetAccessToken($appid, $appkey);
        $url = $this->demoHost . $this->createUrl('/api/behavior/statistics') . '?access_token=' . $token . '&openid=' . $this->openid . '&type=' . $type. '&remark=' . $remark;
        $this->redirect($url);
    }


    public function actionCitylife() {
        $citylife_model = new CityLife();

        $criteria = new CDbCriteria();
        $criteria->condition = "status = 1";
        $criteria->order = 'position ASC';
        $result = $citylife_model->findAll($criteria);

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
        $this->render('citylife', $data);
    }
     
}
