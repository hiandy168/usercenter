<?php
class Shcomment
{
    const CORALURL='dalapi.coral.nameserver.com';
    const INTERNETCORALURL='coral.qq.com';
    const INTERNETCORALURL1='w.coral.qq.com';
 
    const APPID='10076';
    const SERVICEID='10023';
    const SKEY='53323501cee6b';
 
    public static function postAritcleToCoral($cateid,$reportid,$title,$content,$ptime=0){
        $ip = '';
        $port = '';
        $ret = Mod::app ()->nameService->getHostByKey ( self::CORALURL, $ip, $port );
//      echo $ip.':'.$port;
        $apiurl='http://'.$ip.':'.$port.'/article/reg/hb';
        $params=array(
                'serviceid'=>self::SERVICEID,
                'skey'=>self::SKEY,
                'articleid'=>$reportid,
                'title'=>$title,
                'url'=>'http://hb.qq.com/baoliao/detail.htm?cateid='.$cateid.'&id='.$reportid,
                'time'=>$ptime?$ptime:time(),
                'abstract'=>$content?mb_substr($content,0,100,'utf-8'):mb_substr($title,0,100,'utf-8'),
                'pubsource'=>'web',
                'shorttitle'=>self::cn_substr_utf8($title,120),//不能大于128
                'mtype'=>0,
                '_method'=>'put',
                                'source'=>68,
                                'tag'=>'hb_xxx',
        );
        $result=json_decode(self::phpPost($apiurl,self::CORALURL,http_build_query($params),$cookie));
        $targetid=0;
        if(!empty($result)&&$result->errCode==0){
            $appid=$result->data->appid;
            $targetid=$result->data->targetid;
            $articleid=$result->data->articleid;
            $groupid=$result->data->groupid;
        }
        return $targetid;
    }
 
    public static function getCommentsNumberByTargetids($targetids){
        $tig='';
        foreach($targetids as $v)
            $tig .= 'targetid[]='.$v.'&';
        $apiurl = 'http://'.self::INTERNETCORALURL.'/article/batchcommentnum?'.$tig.'source=68';
        $tigs=json_decode(Tool::phpGet($apiurl),true);
         
        $arr=array();
        if($tigs['errCode']===0){
            foreach ($tigs['data'] as $k=>$v)
                $arr[$v['targetid']]['commentnum'] = $v['commentnum'];
        }
        return $arr;
    }
     
    public static function phpGet($url,$host,$refer=''){
        $ch = curl_init($url);
        $options = array(
                CURLOPT_RETURNTRANSFER => true,         // return web page
                CURLOPT_HTTPHEADER     => array('Host: '.$host),
                CURLOPT_FOLLOWLOCATION => true,         // follow redirects
                CURLOPT_ENCODING       => '',           // handle all encodings
                CURLOPT_USERAGENT      => '',           // who am i
                CURLOPT_AUTOREFERER    => true,         // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 5,            // timeout on connect
                CURLOPT_TIMEOUT        => 5,            // timeout on response
                CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
                CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_COOKIEFILE     =>'./',
                CURLOPT_COOKIEJAR      =>'./',
                CURLOPT_REFERER        =>$refer,
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
     
    public static function phpPost($url, $host, $postfields, $cookie='', $refer='')
    {
        $ch = curl_init($url);
        $options = array(
                CURLOPT_RETURNTRANSFER => true,         // return web page
                CURLOPT_HTTPHEADER     => array('Host: '.$host),
                CURLOPT_FOLLOWLOCATION => true,         // follow redirects
                CURLOPT_ENCODING       => '',           // handle all encodings
                CURLOPT_USERAGENT      => '',           // who am i
                CURLOPT_AUTOREFERER    => true,         // set referer on redirect
                CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
                CURLOPT_TIMEOUT        => 120,          // timeout on response
                CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
                CURLOPT_POST           => true,         // i am sending post data
                CURLOPT_POSTFIELDS     => $postfields,  // this are my post vars
                CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
                CURLOPT_SSL_VERIFYPEER => false,
        //          CURLOPT_COOKIEFILE     =>'./',
        //          CURLOPT_COOKIEJAR      =>'./',
                CURLOPT_COOKIE      =>$cookie,
                CURLOPT_REFERER     =>$refer,
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
         
        //utf-8中文截取，单字节截取模式
        public static function cn_substr_utf8($str,$length,$append='...',$start=0){
                if(strlen($str)<$start+1){
                        return '';
                }
                preg_match_all("/./su",$str,$ar);
                $str2='';
                $tstr='';
                for($i=0;isset($ar[0][$i]);$i++){
                        if(strlen($tstr)<$start){
                                $tstr.=$ar[0][$i];
                        }else{
                                if(strlen($str2)<$length + strlen($ar[0][$i])){
                                        $str2.=$ar[0][$i];
                                }else{
                                        break;
                                }
                        }
                }
                return $str==$str2?$str2:$str2.$append;
        }
 
}