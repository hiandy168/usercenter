<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class HouseController extends FrontController {

    /**
     * @var string the def ault layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'application.modules.house.views.layouts.admin';
//    public  $layout='//layouts/admin';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $admin_menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    protected $_gets;
    protected $_baseUrl;
    protected $member;//登录的用户信息
    protected $user = array();
    protected  $bankurl="https://test-svrapi.webank.com/";
    static public $treeList = array();
    public function init() {
        parent::init();
       /* if(!$this->member['id']){
            header("location:".$this->_siteUrl."/house/login");
            exit;
        }*/
        $this->_wwwPath = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
//        $this->_wwwPath = str_replace(array('\\', '\\\\'), DIRECTORY_SEPARATOR, dirname(__FILE__));
         $this->check_lce(); //检查是否有证书
         $this->sign(); //获取访问令牌（access token）
         $this->ticket(); //获取API票据（ticket）
         $this->h5ticket(); //证书签名算法
    }

    /**
     * 检测是否有证书
     * author  Fancy
     */
    public function check_lce() {
        if(!is_file(Mod::app()->basePath . DIRECTORY_SEPARATOR .'vendor'.DIRECTORY_SEPARATOR.'W0000020'.DIRECTORY_SEPARATOR.'W0000020.p12')) {
            echo "非法请求";
        }
    }
    /**
     * 获取访问令牌（access token）
     * author  Fancy
     */
    public function sign(){
        //如果 accesstoken memcache 如果为真,表示没有过期
        $appid="W0000020";
        $secret="AaE7mchalDQygkuA2uxVo3BEv6qaCT4kTidraGLuvUEbCCp4xuKZM7apHoQtkTQH";
        $access_token=Mod::app()->memcache->get('access_token');
        if($access_token){
            return $access_token;
        }else{
         /*   $url="https://test-svrapi.webank.com/h/api/oauth2/access_token?app_id=".$appid."&secret=".$secret."&grant_type=client_credential&version=1.0.0";*/
            $url=$this->bankurl."/h/api/oauth2/access_token?app_id=".$appid."&secret=".$secret."&grant_type=client_credential&version=1.0.0";
            $result=$this->curl_get_ssl($url);
            Mod::app()->memcache->set('access_token', $result['access_token'], $result['expire_in']);
            return $result['access_token'];
        }
    }

    /**
     * 获取API票据（ticket）3600
     * author  Fancy
     */
    public function ticket(){
        //如果 ticket memcache 如果为真,表示没有过期
        $appid="W0000020";
        $access_token=Mod::app()->memcache->get('access_token');
        $tickets=Mod::app()->memcache->get('tickets');
        if($tickets){
            return $tickets;
        }else{
            $url=$this->bankurl."/h/api/oauth2/api_ticket?app_id=".$appid."&access_token=".$access_token."&type=SIGN&version=1.0.0&user_id=2";
            $result=$this->curl_get_ssl($url);
            Mod::app()->memcache->set('tickets', $result['tickets'][0]['value'], $result['tickets'][0]['expire_in']);
            return $result['tickets'][0]['value'];
        }
    }

    /**
     * 证书签名算法
     * author  Fancy
     */
    public function housesign($nonce="",$timestamp="",$data){
        $app_Id="W0000020";
        $version = "1.0.0";
        $ticket = Mod::app()->memcache->get('tickets');
        $_signatureParamArr = array($version,$app_Id,$nonce,$ticket,$timestamp,$data);
        sort($_signatureParamArr);
        $_signature =sha1(implode($_signatureParamArr));
        return $_signature;
    }

    /**
     * 获取API票据（ticket）120
     * author  Fancy
     */
    public function h5ticket(){
        //如果 ticket memcache 如果为真,表示没有过期
        $appid="W0000020";
        $access_token=Mod::app()->memcache->get('access_token');
        $tickets=Mod::app()->memcache->get('h5tickets');
        if($tickets){
            return $tickets;
        }else{
            $url=$this->bankurl."/h/api/oauth2/api_ticket?app_id=".$appid."&access_token=".$access_token."&type=NONCE&version=1.0.0&user_id=2";
            $result=$this->curl_get_ssl($url);
            Mod::app()->memcache->set('h5tickets', $result['tickets'][0]['value'], $result['tickets'][0]['expire_in']);
            return $result['tickets'][0]['value'];
        }
    }


    /**
     * 证书签名算法
     * author  Fancy
     */
    public function h5housesign($nonce=""){
        $app_Id="W0000020";
        $user_Id = "78120";
        $version = "1.0.0";
        $ticket = Mod::app()->memcache->get('h5tickets');
        $_signatureParamArr = array($version,$app_Id,$user_Id,$nonce,$ticket);
        sort($_signatureParamArr);
        $_signature =sha1(implode($_signatureParamArr));
        return $_signature;
    }



    /**
     * 32位随机字符串
     * author  Fancy
     */
    public function strings($len, $chars=null){
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
    public function curl_get_ssl($url)
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
