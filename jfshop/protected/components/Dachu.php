<?php
/**
 * 不要使用框架
 * 需要独立在框架之外使用
 * 
 */
class Dachu {
    
    public $appid = '';
    public $appsecret = '';
    public $openid = '';
//   public $demoHost = 'http://m.dachuw.net';

    public $demoHost = '';
   // public $demoHost = 'http://127.0.0.1';

    public $access_token = "";

    function __construct($appid, $appsecret, $openid='') {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
        $this->openid = $openid;
        
        $this->demoHost = $_SERVER['SERVER_NAME'];
    }
    
     /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @return string content
     */
    static public function http_post($url, $param, $timeout=1) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_string($param)) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($oCurl, CURLOPT_TIMEOUT,$timeout); 
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     * GET 请求
     * @param string $url
     */
    static public function http_get($url, $timeout=1) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
         //设置cURL允许执行的最长秒数。
        curl_setopt($oCurl,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($oCurl,CURLOPT_TIMEOUT,$timeout); 
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }

    /**
     *获取访问凭证  拉取数据的时候用accesstolen
     */
    public function getAccessToken() {
        $url = $this->host .'/api/token/get'.'?appid=' . $this->appid . '&appsecret=' . $this->appsecret.'&grant_type=client_credential';
        $json=  self::http_get($url);
        $json = json_decode($json, true);
        $this->access_token = $json['access_token'];
        return $json;
    }



    /*
    * 生成自动登录地址
    * 通过此方法生成的地址，可以设置用户登录状态
    * timestamp 	yes 	long 	20 	1970-01-01开始的时间戳，毫秒为单位。
    * redirect 	no 	string 	255 	登录成功后的重定向地址
    * sign 	yes 	string 	255 	MD5签名，详见签名规则
    */
    function buildAutoLoginRequest($openid,$redirect){
        $url = $this->host ."/api/member/autoLogin?";
        $timestamp=time()*1000;
        $params=array("openid"=>$openid,"appid"=>$this->appid,"appsecret"=>$this->appsecret,"timestamp"=>$timestamp,'redirect'=>urlencode($redirect));
        $sign= self::sign($params);
        $params['sign'] = $sign;
        unset($params['appsecret']);
        $url = $url.http_build_query($params);
        return $url;
    }

    /*
    *获取个人用户中心页面
    */
    public function getMemberUrl($type="wap") {
        switch ($type) {
            case "wap":
                $url = $this->host .'/h5/member/index';
                break;
            case "web":
                $url = $this->host .'/member/index';
                break;
            default:
                break;
        }
        return $url;
    }
    
     /**
     *获取访问凭证  token 暂时没用起来
     */
    public function Get_token() {
        $url = $this->demoHost .'/api/token/get'.'?appid=' . $this->appid . '&appsecret=' . $this->appsecret.'&grant_type=client_credential';
        $json=  self::http_get($url);
        $json = json_decode($json, true);
        $this->access_token = $json['access_token'];
        return $json;
    }

    
    /**
     * 检查openid和pid的绑定关系,是否有手机号
     * 
     * @return  有绑定返回手机号,没有绑定返回0
     */
    public function checkMember() {
        $url = $this->demoHost .'/api/member/checkphonebind'. '?openid=' . $this->openid . '&access_token=' . $this->access_token;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }

    /**
     * 跳转到用户中心登录页
     * 
     * @param string $url 登录后回跳url
     * 
     */
    public function redirect($backurl) {
        if (!$backurl) {
            return ;
        }
       $url = $this->demoHost .'/h5/member/login?openid=' . $this->openid . '&access_token=' . $this->access_token . '&backurl=' .urlencode($backurl);
       header( "Location:" . $url);
       die();
    }

    /**
     *
     * @param string $phone 手机号
     * @param string $ver  发送给手机的验证码
     * @param string $pass 登录密码,可以接受为空
     * @return 成功1,失败0
     */
    public function reg($phone,$ver,$pass='') {

        $url = $this->demoHost .'/api/member/reg'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&phone='.$phone.'&ver='.$ver.'&pass='.$pass.'&ip='.$_SERVER['REMOTE_ADDR'];
        $json=  self::http_get($url);
        return json_decode($json, true);
    }


    /**
     * 发送验证码
     *
     * @param string $phone 手机号
     * @return 成功1,失败0
     */
    public function sendver($phone) {
        //用户中心需要实现该接口
        $url = $this->demoHost .'/api/member/sendver'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&phone='.$phone;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }

    /**
     * 通过帐号密码登录
     *
     * @param string $phone 手机号
     * @param string $pass 密码
     *
     */
    public function login($phone,$pass) {
        //用户中心需要实现该接口
        $url = $this->demoHost .'/api/member/login'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&phone='.$phone.'&pass='.$pass;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    
    public function b2clogin($name,$pass){
        //B2C商城登录接口
        $url = $this->demoHost .'/api/member/B2cLogin'. '?name='.$name.'&pass='.$pass;
        $json=  self::http_get($url);
        return json_decode($json, true);        
    }
    
    /**
     * 短信验证码验证
     *
     * @param string $phone 手机号
     * @param string $code 短信验证码
     * @return json 成功1,失败0,过期-1
     */
    public function AuthCode($phone,$code) {
        //用户中心需要实现该接口
        $url = $this->demoHost .'/api/member/authcode?mobile='.$phone.'&param='.$code;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    
    /**
     * 通过帐号,短信验证码登录
     * @param string $phone 手机号
     * @param string $ver 短信验证码

     */
    public function loginByVer($phone,$ver) {
        //用户中心需要实现该接口
        $url = $this->demoHost .'/api/loginbyver'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&phone='.$phone.'&ver='.$ver.'&ip='.$_SERVER['REMOTE_ADDR'];
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    
    /**
     * 用户行为上报
     * $behavior 行为ID 可在文档中查看
     */
    public function Statistics($behavior='') {
        //用户中心需要实现该接口
        $url = $this->demoHost .'/api/behavior/statistics'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&behavior='.$behavior;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    

    /**
     * 发送大楚站内用户消息api
     */
    public function memberMesage($title,$content){
         $url = $this->demoHost .'/api/member/message'. '?openid=' . $this->openid . '&access_token=' . $this->access_token.'&title='.$title.'&content='.$content;
         $json=  self::http_get($url);
         return json_decode($json, true);         
    }
    
    
    //用户积分消费
    public function pointspend($mopenid,$point){
        //B2C商城登录接口
        $url = $this->demoHost .'/api/point/spend';
        $data =array(
            'access_token'=> $this->access_token,
            'point'=>abs($point),
            'mopenid'=>$mopenid,
        );
        $json=  self::http_post($url,$data);
        return json_decode($json, true);        
    }

    //获取用户个人积分信息
    public function getmemberpoints($member_id){
        $url = $this->demoHost .'/api/point/getmemberpoints';
        $data =array(
            'access_token'=> $this->access_token,
            'member_id'=>abs($member_id),
        );
        $json=  self::http_post($url,$data);
        return json_decode($json, true);
    }
    //获取用户个人积分记录
    public function getmemberpointslog($member_id){
        $url = $this->demoHost .'/api/point/getmemberpointslog';
        $data =array(
            'access_token'=> $this->access_token,
            'member_id'=>abs($member_id),
        );
        $json=  self::http_post($url,$data);
        return json_decode($json, true);
    }

    //验证积分商城mid openid pid 绑定关系，未绑定就绑定member_project
    public function checkmemberproject($mid,$openid){
        $url = $this->demoHost .'/api/member/B2cCheckIn';
        $data =array(
            'mid'=> $mid,
            'access_token'=>$this->access_token,
            'openid'=>abs($openid),
        );
        $json=  self::http_post($url,$data);
        return json_decode($json, true);
    }
    
}
