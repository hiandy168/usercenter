<?php
/**
* 	配置账号信息
*/

class WxConf
{
	//=======【基本信息设置】=====================================
	//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
		//微信公众号身份的唯一标识。审核通过后，在微信发送的邮件中查看
//	 const APPID='wxa8ba3a5d0f323f33';
//	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
//	const APPSECRET='d749c960c8e71ffb82b65055ab29a637';
         const APPID='111111';
	//JSAPI接口中获取openid，审核后在公众平台开启开发模式后可查看
	     const APPSECRET='*****';
         const TOKEN='1111111';
   
    
	
	//=======【JSAPI路径设置】===================================
	//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
//	const JS_API_CALL_URL = 'http://hb.qq.com/pay/index';
//	
//	const NOTIFY_URL = 'http://hb.qq.comcom/pay/notify';

	//=======【curl超时设置】===================================
	//本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
	const CURL_TIMEOUT = 30;
        
        
         static  public function getInfo($code)
	{
                $url = self::createOauthUrl($code);
                $oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		curl_setopt($oCurl, CURLOPT_URL, $url);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return json_decode($sContent,true);
		}else{
			return false;
		}
            
	}
        
       static public  function createOauthUrl($code)
	{
    
		$urlObj["appid"] = WxConf::APPID;
		$urlObj["secret"] = WxConf::APPSECRET;
		$urlObj["code"] = $code;
		$urlObj["grant_type"] = "authorization_code";
		$bizString = http_build_query($urlObj);
		return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
	}
        
        static public  function GetUserInfoForOpenid($openid,$access_token)
	{
		$urlObj["access_token"] = $access_token;
		$urlObj["openid"] = $openid;
		$urlObj["lang"] = 'zh_CN';
		$bizString = http_build_query($urlObj);
		$url =  "https://api.weixin.qq.com/sns/userinfo?".$bizString;
                $ch = curl_init();
                //设置超时
                curl_setopt($ch, CURLOPT_TIMEOUT, WxConf::CURL_TIMEOUT);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
                curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                //运行curl，结果以jason形式返回
                $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		return $data = json_decode($res,true);
	}
        
        
//        public function getToken(){
//		return $this->access_token;
//	}
//	/**
//	 * 如果access_token过期,重新刷新之
//	 *
//	 * @param int 是否直接刷新不判断缓存
//	 */
        
        //
         static public  function GetAccessToken()
	{
                $urlObj["grant_type"] = 'client_credential';
                $urlObj["appid"] = WxConf::APPID;
		$urlObj["secret"] = WxConf::APPSECRET;
		$bizString = http_build_query($urlObj);
		$url =  "https://api.weixin.qq.com/cgi-bin/token?".$bizString;
                $ch = curl_init();
                //设置超时
                curl_setopt($ch, CURLOPT_TIMEOUT, WxConf::CURL_TIMEOUT);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
                curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                //运行curl，结果以jason形式返回
                $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
                $data = json_decode($res,true);
		return  $data['access_token'];
	}
        
        
        //关注的才能获取吧？
         static public  function GetUserInfo($openid,$access_token)
	{
                $urlObj["access_token"] =$access_token;
                $urlObj["openid"] = $openid;
		$bizString = http_build_query($urlObj);
		$url =  "https://api.weixin.qq.com/cgi-bin/user/info?".$bizString;
                $ch = curl_init();
                //设置超时
                curl_setopt($ch, CURLOPT_TIMEOUT, WxConf::CURL_TIMEOUT);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
                curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                //运行curl，结果以jason形式返回
                $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
                $data = json_decode($res,true);
		return  $data;
	}

        
            
            
	public function refreshToken($siteId, $renew = 0) {
		//判断memcache里如果没有token,则去数据库取
		$site_info = Mod::app()->db->CreateCommand('select * from  t_public_number_info  where FSiteID = '.$siteId)->queryRow();
		if(!isset($site_info['FAppID']) || !isset($site_info['FAppSecret'])) return false;
		$this->appid = $site_info['FAppID'];
		$this->appsecret =  $site_info['FAppSecret'];
		$this->access_token = time() >= $site_info['FExpireTime'] ? '' : $site_info['FAccessToken'];
		if($renew) {
			$debug_info = $_SERVER['REQUEST_URI'];
			$this->logger('api_refresh_token', 'warning', '['. $site_info['FAccessToken'] . ']' . $debug_info);		
			$this->checkAuth();
		} else {
			if (!$this->access_token)
				return false;
			}
		//获取了之后保存到数据库及缓存中
		$sql = "update t_public_number_info set FAccessToken = '{$this->access_token}', FExpireTime = ".(time() + 7000)." where FUserID = '$site_info[FUserID]'";
		Mod::app()->db->CreateCommand($sql)->query();
	}
        
        

        
}
	
?>