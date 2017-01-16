<?php

class Dachuw {

    public $appid = '';
    public $appskey = '';
    public $openid = '';
    public $demoHost = 'http://m.dachuw.net';

    function __construct($appid, $appkey, $openid) {
        $this->appid = $appid;
        $this->appskey = $appkey;
        $this->openid = $openid;
    }


    /**
     * 获取access_token,mid
     * @return json access_token,mid,expires_in
     */
    public function getAccessTokenAndMid() {        
        $url = $this->demoHost .'/api/TokenMid/get'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    
    /**
     * 用户注册
     * @param string $name,$password
     * @return json 1成功,0失败
     */
     public function reg() {
        $url = $this->demoHost .'/api/reg'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&name=scott&password=123456&repassword=123456';
        $json=  self::http_get($url);
        return json_decode($json, true);
    }
    
    /**
     * 用户登录
     * @param string $name $password
     * @return json 1成功,0失败
     */
     public function login() {
        $url = $this->demoHost .'/api/login'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&name=scott&password=123456';
        $json=  self::http_get($url);
        return json_decode($json, true);
    } 
    
    /**
     * 用户标签设置
     * @param string $name $password
     * @return json 1成功,0失败
     */
     public function tag() {
        $url = $this->demoHost .'/api/tag'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&name=scott&password=123456';
        $json=  self::http_get($url);
        return json_decode($json, true);
    }    
   
    /**
     * 记录用户签到行为
     * @param string $type $remark
     * @return json 1成功,0失败
     */
     public function addsignlog() {
        $url = $this->demoHost .'/api/addsignlog'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&type=签到';
        $json=  self::http_get($url);
        return json_decode($json, true);
    }     
 
    /**
     * 用户行为上报
     * @param string $type $remark
     * @return json 1成功,0失败
     */
     public function statistics() {
        $url = $this->demoHost .'/api/statistics'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&type=抽奖&remark=简介';
        $json=  self::http_get($url);
        return json_decode($json, true);
    } 
    
    /**
     * 获取用户中心用户
     * @param string $page $limit
     * @return array()
     */
     public function getmember() {
        $url = $this->demoHost .'/api/getmember'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&page=1&limit=10';
        $json=  self::http_get($url);
        return json_decode($json, true);
    }  
    
    /**
     * 获取会员信息
     * @param string $openid $access_token
     * @return array()
     */
     public function meminfo() {
        $url = $this->demoHost .'/api/meminfo'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey;
        $json=  self::http_get($url);
        return json_decode($json, true);
    } 
    
    /**
     * 抽奖
     * @param type
     * @return string $code
     */
     public function lottery() {
        $url = $this->demoHost .'/api/lottery/start'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey;
        $json=  self::http_get($url);
        return json_decode($json, true);
    }    

    
    /**
     * 报名 
     * @param string $name $email $description
     * @return json 1成功,0失败
     */
     public function signup() {
        $url = $this->demoHost .'/api/signup/addsignup'. '?openid=' . $this->openid . '&appid=' . $this->appid . '&appkey=' . $this->appskey.'&name=scott&email=scott@126.com&description=描述';
        $json=  self::http_get($url);
        return json_decode($json, true);
    }      
    
    
    /**
     * GET 请求
     * @param string $url
     */
    static public function http_get($url) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
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
     * POST 请求
     * @param string $url
     * @param array $param
     * @return string content
     */
    static public function http_post($url, $param) {
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
    
}

