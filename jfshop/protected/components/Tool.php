<?php

class Tool {

    public static function myPager($pages) {
        return array('pages' => $pages,
            'header' => '',
            'cssFile' => '',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'firstPageLabel' => '第一页',
            'lastPageLabel' => '最后页',
            'maxButtonCount' => 13,
            'htmlOptions' => array('class' => 'pagination')
        );
    }

    public static function ajaxResponde($info) {
        header("Content: application/json");
        header("Content-type: text/json");
        echo json_encode($info);
    }


    /*
     * $name 参数名
     * $type 参数类型
     * $default*/
    public static function getValidParam($name, $type="string", $default = NULL) {
        $value = Mod::app()->request->getParam($name);

        if ((empty($value)||$value==""||$value==null)&&$value!==0) {
            return $default ? $default : false;
        }
        //如果是数据强制转换数组
        if (is_array($value)) {
            $type = 'array';
        }
        switch ($type) {
            case 'int':
                $value = intval($value);
                break;
            case 'array'://如果是数组 我们全部当做字符串去做过滤 多为数组不考虑 规定不传多为数组
                foreach($value as  $k=>&$v){
                    $v = strval($v);
                    $v = Safetool::SafeFilter($v);
                } unset($k,$v);
                break;
            case 'bool':
                $value = $value ? floatval($value) : 0;
                break;
            case 'bigint':
                $value = strval($value);
                break;
            case 'string':
                $value = strval($value);
                $value = Safetool::SafeFilter($value);
                $value = $value ? $value : '';
                break;
            case 'sentence':
                $value = strval($value);
                $value = str_replace(' ', '&nbsp;', $value);
                break;
        }
        if ((empty($value)||$value==""||$value==null)&&$value!==0) {
            return $default ? $default : false;
        }
        return $value;
    }

    static function md5str($password, $source) {
        return md5(md5($password) . $source . '9open');
    }

    static function random_keys($length) {
        $returnStr = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
//    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i ++) {
            $returnStr .= $pattern {mt_rand(0, 35)}; //生成php随机数
        }
        return $returnStr;
    }

    static function get_ip() {
        $onlineip = "";
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
    }
    
    static function get_position($array='') {
        if (is_array($array)) {
            $position = '';
            $end = array_pop($array);
            foreach ($array as $k => $v) {
                $position .=   '<a  href="' . ((isset($v['url']) && $v['url']) ? $v['url'] : 'javascript:;') . '">' . $v['name'] . '</a> > ';
            }
            $position .=  '<a  href="' . ((isset($end['url']) && $end['url']) ? $end['url'] : 'javascript:;') . '">' . $end['name'] . '</a>';
        }
        return $position;
    }
    
    //$thumb　前面有'／'就代表是根目录的图片
    static function show_img($thumb='',$host ='') {
        if ($thumb) {
            $key_str ='data/attachment/';
            $host = $host?$host:str_replace('index.php', '', Yii::app()->createAbsoluteUrl('/'));
            if(substr(trim($thumb), 0,4) == 'http'){
                    $new_thumb =$thumb;
            }else{
                if(substr(trim($thumb), 0,1) =='/'){
                    $new_thumb = $host.$thumb;
                }else if(substr(trim($thumb), 0,16) == $key_str || strstr($thumb,$key_str)){
                   $new_thumb = $host.'/' .$thumb;
                }else{
                   $new_thumb = $host.'/' .$key_str. $thumb;
                }
            }
        } else {
            $new_thumb = Yii::app()->baseUrl.'/data/nopic.jpg';
        }
        return $new_thumb;
    }

//排序
    static function cmp_func($a, $b) {
        global $order;
        if ($a['is_dir'] && !$b['is_dir']) {
            return -1;
        } else if (!$a['is_dir'] && $b['is_dir']) {
            return 1;
        } else {
            if ($order == 'size') {
                if ($a['filesize'] > $b['filesize']) {
                    return 1;
                } else if ($a['filesize'] < $b['filesize']) {
                    return -1;
                } else {
                    return 0;
                }
            } else if ($order == 'type') {
                return strcmp($a['filetype'], $b['filetype']);
            } else {
                return strcmp($a['filename'], $b['filename']);
            }
        }
    }

    static function change_array_index($arr, $key = 'id') {
        $newarr = array();
        foreach ($arr as $item) {
            $newarr[$item[$key]] = $item;
        }
        return $newarr;
    }

    static function change_array($arr, $key = 'id', $value = 'value') {
        $newarr = array();
        foreach ($arr as $item) {
            $newarr[$item[$key]] = $item[$value];
        }
        return $newarr;
    }

  

    static function mult_to_idarr($arr, $key = 'id') {
        $newarr = array();
        foreach ($arr as $item) {
            $newarr[] = $item[$key];
        }
        return $newarr;
    }
    
      /**
     * 去掉字符串中的HTML标签
     *
     * @param string $string 输入字符串
     * @return string 返回结果
     */
    public static function nohtml($string)
    {
      $string = preg_replace("'<script[^>]*?>.*?</script>'si", "", $string);  //去掉javascript
      $string = preg_replace("'<[\/\!]*?[^<>]*?>'si", "", $string);  //去掉HTML标记 <!DOCTYPE <span> </span>
      $string = preg_replace("@<style[^>]*?>.*?</style>@siU", "", $string);  //去掉style
      $string = preg_replace("@<![\s\S]*?--[ \t\n\r]*>@", "", $string);  //去掉<!--Multi-Line -->
      $string = preg_replace("'([\r\n])[\s]+'", "", $string);  //去掉空白字符
      $string = preg_replace("'&(quot|#34);'i", "", $string);  //替换HTML实体
      $string = preg_replace("'&(amp|#38);'i", "", $string);
      $string = preg_replace("'&(lt|#60);'i", "", $string);
      $string = preg_replace("'&(gt|#62);'i", "", $string);
      $string = preg_replace("'&(nbsp|#160);'i", "", $string);
      return $string;
    }
     
    /**
     * 去掉字符串中的Script/Style标签和onload/on...等方法
     *
     * @param string $string 输入字符串
     * @return string 返回结果
     */
    public static function noscript($string)
    {
        $string = preg_replace("'<script[^>]*?>.*?</script>'si", "", $string);  //去掉javascript
        $string = preg_replace("'<style[^>]*?>.*?</style>'si", "", $string);  //style
        $string = preg_replace("/<\?/", '', $string); //去掉php
        $string = preg_replace("/\?>/", '', $string);
        $string = preg_replace('#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?)\s*>#is', '<${1}>',$string); //去掉onload/onxxxx
        //$string = preg_replace('#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?|style=["\'].+?["\'])\s*>#is', '<${1}>',$string);
     
         // realign javascript href to onclick
        $string = preg_replace("/href=(['\"]).*?javascript:(.*)? \\1/i", "onclick=' $2 '", $string);
     
        //remove javascript from tags
        while( preg_match("/<(.*)?javascript.*?\(.*?((?>[^()]+) |(?R)).*?\)?\)(.*)?>/i", $string))
            $string = preg_replace("/<(.*)?javascript.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $string);
     
        // dump expressions from contibuted content
        if(0) $string = preg_replace("/:expression\(.*?((?>[^(.*?)]+)|(?R)).*?\)\)/i", "", $string);
     
        while( preg_match("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", $string))
            $string = preg_replace("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $string);
     
        // remove all on* events
        /*
        while( preg_match("/<(.*)?\s?on.+?=?\s?.+?(['\"]).*?\\2 \s?(.*)?>/i", $string) )
            $string = preg_replace("/<(.*)?\s?on.+?=?\s?.+?(['\"]).*?\\2\s?(.*)?>/i", "<$1$3>", $string);
        */
        $aDisabledAttributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $string = preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", $string);
        return $string;
    }
    
    public static function truncate_utf8_string($string, $length, $etc = '...')  
        {  
            $result = '';  
            $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');  
            $strlen = strlen($string);  
            for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)  
                {  
                if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))  
                        {  
                    if ($length < 1.0)  
                                {  
                        break;  
                    }  
                    $result .= substr($string, $i, $number);  
                    $length -= 1.0;  
                    $i += $number - 1;  
                }  
                        else  
                        {  
                    $result .= substr($string, $i, 1);  
                    $length -= 0.5;  
                }  
            }  
            $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');  
            if ($i < $strlen)  
                {  
                        $result .= $etc;  
            }  
            return $result;  
        }  
    
        public static function delhtmlimg($html){
            return preg_replace('/<img[^>]+>/i','',$html);
        }
        
        public static function delhtmltags($html){
            return preg_replace('/<[^>]+>/','',$html);
        }
        
        /**
	 * GET 请求
	 * @param string $url
	 */
	public static  function http_get($url){
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
			return $sContent;
		}else{
			return false;
		}
	}
	
	/**
	 * POST 请求
	 * @param string $url
	 * @param array $param
	 * @return string content
	 */
	public static  function http_post($url,$param){
		$oCurl = curl_init();
		if(stripos($url,"https://")!==FALSE){
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
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
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($oCurl, CURLOPT_POST,true);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS,$strPOST);
		$sContent = curl_exec($oCurl);
		$aStatus = curl_getinfo($oCurl);
		curl_close($oCurl);
		if(intval($aStatus["http_code"])==200){
			return $sContent;
		}else{
			return false;
		}
	}
//参数$outfile表示是否输出二维码图片 文件，默认否；
//参数$level表示容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）； 
//参数$size表示生成图片大小，默认是3；
//参数$margin表示二维码周围边框空白区域间距值；
//参数$saveandprint表示是否保存二维码并 显示。
        static function Qrcode($url,$outfile = false, $level='', $size = 8, $margin = 2, $saveandprint=false) {
            if(substr(trim($url), 0,4) == 'http'){
                    $url =$url;
            }else{
                   $url = 'http://'. $url;
            }
            defined('PHPQRCODE_PATH') || define('PHPQRCODE_PATH',  dirname(__FILE__).'/../vendor/phpqrcode/');
            require_once  PHPQRCODE_PATH.'phpqrcode.php';
            return QRcode::png($url,$outfile,$level,$size,$margin,$saveandprint);
        }
        
        
          public static   function remove_xss($val) {
          // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
          // this prevents some character re-spacing such as <java\0script>
          // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
          $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
          // straight replacements, the user should never need these since they're normal characters
          // this prevents like <IMG SRC=@avascript:alert('XSS')>
          $search = 'abcdefghijklmnopqrstuvwxyz';
          $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $search .= '1234567890!@#$%^&*()';
          $search .= '~`";:?+/={}[]-_|\'\\';
          for ($i = 0; $i < strlen($search); $i++) {
           // ;? matches the ;, which is optional
           // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
           // @ @ search for the hex values
           $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
           // @ @ 0{0,7} matches '0' zero to seven times
           $val = preg_replace('/(�{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
          }
          // now the only remaining whitespace attacks are \t, \n, and \r
          $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
          $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
          $ra = array_merge($ra1, $ra2);
          $found = true; // keep replacing as long as the previous round replaced something
          while ($found == true) {
           $val_before = $val;
           for ($i = 0; $i < sizeof($ra); $i++) {
             $pattern = '/';
             for ($j = 0; $j < strlen($ra[$i]); $j++) {
              if ($j > 0) {
                $pattern .= '(';
                $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                $pattern .= '|';
                $pattern .= '|(�{0,8}([9|10|13]);)';
                $pattern .= ')*';
              }
              $pattern .= $ra[$i][$j];
             }
             $pattern .= '/i';
             $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
             $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
             if ($val_before == $val) {
              // no replacements were made, so exit the loop
              $found = false;
             }
           }
          }
          return $val;
        }
        
        public static  function remove_imgwidthheight($str) {
            /*PHP正则提取图片img标记中的任意属性*/
//            $str = '<div style="margin: 0px auto; width: 740px;"> <p><img width="748" height="444" alt="" src="/images/upload/Image/manmiao_0001.jpg" /></p></div>';
            //去掉图片宽度
            $search = '/(<img.*?)width=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
            //去掉图片高度
            $search1 = '/(<img.*?)height=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
            $content = preg_replace($search,'$1$3',$str);
            $content = preg_replace($search1,'$1$3',$content);
            //去掉div的style
           return $content;
//            highlight_string($content);
        }
        
        public static   function remove_style($str) {
           return $content = preg_replace("/style=.+?['|\"]/i",'',$str);//这种方式很简单易懂，但因为太简单，不知道有没有漏洞，否则去掉图片的宽高也用这种方法写了
//            highlight_string($content);
        }
        
        public static   function remove_imgborder($str) {   
            $search = '/(<img.*?)border=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
            return preg_replace($search,'$1$3',$str);
        }
        
    static public function player($url,$width=400,$height=300,$autostart='false',$force=''){
	global $webdb;
	if( $force=='mp3' || preg_match('/\.mid$/i',$url) || preg_match('/\.mp3$/i',$url) || preg_match('/\.wma$/i',$url) )
	{
         $show="
         <CENTER><TABLE width=\"320\" height=\"50\" border=\"5\" cellPadding=3 cellSpacing=3 bgColor=#666666 style=\"BORDER-RIGHT: #666666 3px dashed; BORDER-TOP: #666666 3px dashed; BORDER-LEFT: #666666 3px dashed; BORDER-BOTTOM: #666666 3px dashed\"><TBODY><TR><TD><TABLE width=\"320\" height=\"45\" border=1 align=center cellpadding=\"0\" cellspacing=\"0\" borderColor=#000000><TBODY><TR><TD><P align=center><object classid='clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95' type='application/x-oleobject' style='width:{$width}px;height:50px;' align='middle' standby='Loading Microsoft?Windows?Media Player components...' id='MediaPlayer1'><param name='FileName' value='$url'><embed src='$url' wmode='transparent'  type='video/x-ms-asf-plugin' quality='high' ShowStatusBar='true' style='width:{$width}px;height:50px;'></embed><param name='EnableContextMenu' value=0></object></P></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></CENTER>
         ";
	}
	elseif( $force=='avi' || preg_match('/\.avi$/i',$url) || preg_match('/\.asf$/i',$url) || preg_match('/\.asx$/i',$url) || preg_match('/\.wmv$/i',$url) || preg_match('/\.mpg$/i',$url) || preg_match('/\.mpeg$/i',$url) )
	{
        $show="
         <CENTER><object classid='clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95' type='application/x-oleobject' style='width:{$width}px;height:{$height}px;' align='middle' standby='Loading Microsoft?Windows?Media Player components...' id='MediaPlayer1'><param name='FileName' value='$url'><embed src='$url' type='video/x-ms-asf-plugin' quality='high' ShowStatusBar='true' style='width:{$width}px;height:{$height}px;'></embed><param name='EnableContextMenu' value=0></object></CENTER>
         ";
	}
	elseif( $force=='rm' || preg_match('/\.ra$/i',$url) || preg_match('/\.rm$/i',$url) || preg_match('/\.ram$/i',$url) || preg_match('/\.rmvb$/i',$url) )
	{
         $show="
         <CENTER><object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"$width\" height=\"$height\" id=\"Player\"><param name=\"src\" value=\"$url\" /><param name=\"controls\" value=\"Imagewindow\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\"1\" /><embed src=\"$url\" type=\"audio/x-pn-realaudio-plugin\" autostart=\"1\" console=\"clip1\" controls=\"Imagewindow\" width=\"$width\" height=\"$height\"></embed></object><br /><object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\"$width\" height=\"44\"><param name=\"src\" value=\"$url\" /><param name=\"controls\" value=\"ControlPanel\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\"$url\" /><embed src=\"$url\" type=\"audio/x-pn-realaudio-plugin\" autostart=\"1\" console=\"clip1\" controls=\"ControlPanel\" width=\"$width\" height=\"44\"></embed></object></CENTER>
	     ";

	}
	elseif( $force=='flv' || preg_match('/\.flv$/i',$url) )
	{
		$show=flv_player($url,$width,$height);
	}
	elseif( $force=='swf' || preg_match('/\.swf$/i',$url) )
	{
          $show="<OBJECT 
      codeBase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' 
      width='$width' height='$height' classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000><PARAM NAME='movie' VALUE='$url'><embed type='application/x-shockwave-flash' src='$url' width='$width' height='$height'></embed></OBJECT>";
	}
	else
	{
		$show="{$url}";
	}
	return $show;
}


}
