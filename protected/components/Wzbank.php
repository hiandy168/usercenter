<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 11:57
 */

class Wzbank {

    const  bankurl="https://test-svrapi.webank.com/h/api";
    const  appid="W0000020";
    const  secret="AaE7mchalDQygkuA2uxVo3BEv6qaCT4kTidraGLuvUEbCCp4xuKZM7apHoQtkTQH";
    const  version="1.0.0";
    /**
     * 检测是否有证书
     * author  Fancy
     */
    public static function check_lce() {
        if(!is_file(Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.p12')) {
            echo "非法请求";
        }
    }
    /**
     * 获取访问令牌（access token）
     * author  Fancy
     */
    public static function sign(){
        //如果 accesstoken memcache 如果为真,表示没有过期
        $appid=self::appid;
        $secret=self::secret;
        $version = self::version;
        $access_token=Mod::app()->memcache->get('access_token');
        if($access_token){
            return $access_token;
        }else{
            Mod::app()->memcache->delete('tickets');
            $url=self::bankurl."/oauth2/access_token?app_id=".$appid."&secret=".$secret."&grant_type=client_credential&version=".$version;
            $result=self::curl_get_ssl($url);
            Mod::app()->memcache->set('access_token', $result['access_token'], 3000);
            return $result['access_token'];
        }
    }

    /**
     * 获取API票据（ticket）3600
     * author  Fancy
     */
    public static function ticket(){
        //如果 ticket memcache 如果为真,表示没有过期
        $appid=self::appid;
        $version = self::version;
        $access_token=Mod::app()->memcache->get('access_token');
        $tickets=Mod::app()->memcache->get('tickets');
        if($tickets){
            return $tickets;
        }else{
            $url=self::bankurl."/oauth2/api_ticket?app_id=".$appid."&access_token=".$access_token."&type=SIGN&version=".$version."&user_id=1";
            $result=self::curl_get_ssl($url);
            Mod::app()->memcache->set('tickets', $result['tickets'][0]['value'], 3000);
            return $result['tickets'][0]['value'];
        }
    }

    /**
     * 证书签名算法sign 3600
     * author  Fancy
     */
    public static function housesign($nonce="",$timestamp="",$data="",$type="",$version=""){
        $app_Id=self::appid;
        $ticket = Mod::app()->memcache->get('tickets');
        $_signatureParamArr = array($version,$app_Id,$nonce,$ticket,$timestamp,$type,$data);
        sort($_signatureParamArr);
        $_signature =sha1(implode($_signatureParamArr));
        return $_signature;
    }

    /**
     * 获取API票据（ticket）120
     * author  Fancy
     */
    public static  function h5ticket($access_token="",$userid=""){
        //如果 ticket memcache 如果为真,表示没有过期
        $appid=self::appid;
        $version = self::version;
        $url=self::bankurl."/oauth2/api_ticket?app_id=".$appid."&access_token=".$access_token."&type=NONCE&version=".$version."&user_id=".$userid;
        $result=self::curl_get_ssl($url);
        Mod::app()->memcache->set('h5tickets', $result['tickets'][0]['value'], $result['tickets'][0]['expire_in']);
        return $result['tickets'][0]['value'];
    }


    /**
     * 证书签名算法nonce 120
     * author  Fancy
     */
    public static function h5housesign($nonce="",$ticket="",$user_Id=""){
        $app_Id=self::appid;
        $version = self::version;
        $_signatureParamArr = array($version,$app_Id,$user_Id,$nonce,$ticket);
        sort($_signatureParamArr);
        $_signature =sha1(implode($_signatureParamArr));
        return $_signature;
    }



    /**
     * 32位随机字符串
     * author  Fancy
     */
    public static function strings($len, $chars=null){
        if (is_null($chars)){
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        }
        mt_srand(10000000*(double)microtime());
        for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++){
            $str .= $chars[mt_rand(0, $lc)];
        }
        return $str;
    }



    /**
     * @name ssl Curl get数据
     * @param string $url 接收数据的api
     * @return string or boolean 成功且对方有返回值则返回
     */
    public static function curl_get_ssl($url)
    {
        $curl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
            curl_setopt($curl, CURLOPT_SSLCERT, Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.crt');
            curl_setopt($curl, CURLOPT_SSLCERTPASSWD, 'App1234.'); //client证书密码
            curl_setopt($curl, CURLOPT_SSLKEY, Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.key');
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
            return $aStatus['http_code'];
        }

    }


    /**
     * POST 请求
     * @param string $url
     * @param array $param
     * @return string content
     */
    public static function curl_post_ssl($url,$param,$referer=''){
        $oCurl = curl_init();
        $header = array(
            'Content-Type: application/json',
        );
        curl_setopt($oCurl, CURLOPT_HTTPHEADER, $header);
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 1);
            curl_setopt($oCurl, CURLOPT_SSLCERT, Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.crt');
            curl_setopt($oCurl, CURLOPT_SSLCERTPASSWD, 'App1234.'); //client证书密码
            curl_setopt($oCurl, CURLOPT_SSLKEY, Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.key');
        }
        if (is_string($param)) {
            $strPOST = $param;
        } else {
            $aPOST = array();
            foreach($param as $key=>$val){
                $aPOST[] = $key."=".urlencode($val);
            }
            $strPOST =  join("&", $aPOST);
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST,true);
        if($referer){
            curl_setopt($oCurl,CURLOPT_REFERER,$referer);
        }
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$param);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return json_decode($sContent, true);
        }else{
            return $aStatus['http_code'];
        }
    }


}