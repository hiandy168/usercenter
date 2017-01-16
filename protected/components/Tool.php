<?php

class Tool
{

    /*
    *  md5签名，$array中务必包含 appSecret
    */
    static function sign($array)
    {
        ksort($array);
        // var_dump($array);
        $string = "";
        while (list($key, $val) = each($array)) {
            $string = $string . $val;
        }

        return md5($string);
    }

    /*
    *  签名验证,通过签名验证的才能认为是合法的请求
    */
    static function signVerify($appSecret, $array)
    {
        $newarray = array();
        // $newarray["appSecret"]=$appSecret;
        reset($array);
        while (list($key, $val) = each($array)) {
            if ($key != "sign") {
                $newarray[$key] = $val;
            }

        }
        $sign = self::sign($newarray);
        if ($sign == $array["sign"]) {
            return true;
        }
        return false;
    }


    public static function getIplookup($ip)
    {
        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=' . $ip;
        $res = json_decode(self::http_get($url), true);
        $result = array(
            'province' => $res['province'],
            'city' => $res['city'],
        );
        return $result;

    }

    public static function myPager($pages)
    {
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

    public static function ajaxResponde($info)
    {
        header("Content: application/json");
        header("Content-type: text/json");
        echo json_encode($info);
    }

    /*
     * $name 参数名
     * $type 参数类型
     * $default*/
    public static function getValidParam($name, $type = "string", $default = '')
    {
        $value = Mod::app()->request->getParam($name);

        if ((!$value || (is_array($value) && empty($value))) && ($value !== 0 || $value !== '0' || $value !== '' || $value !== NULL || $value !== FALSE)) {
            return $default;
        }

        //如果是数据强制转换数组
        if (is_array($value)) {
            $type = 'array';
        }

        switch ($type) {
            case 'integer':
                $value = intval($value);
                break;
            case 'array'://如果是数组 我们全部当做字符串去做过滤 多为数组不考虑 规定不传多为数组
                foreach ($value as $k => &$v) {
                    $v = strval($v);
                    $v = Safetool::SafeFilter($v);
                }
                unset($k, $v);
                break;
            case 'double':
                $value = $value ? floatval($value) : 0;
                break;
            case 'int':
            case 'bigint':
                $value = intval($value);
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
        if ((empty($value) || $value == "" || $value == null) && $value !== 0) {
            if ($default === 0) {
                return $default;
            }
            return $default ? $default : false;
        }
        return $value;
    }


    //防注入函数
    public static function inject_check($sql_str)
    {
        $check = preg_match('/DROP|select|insert|update|delete|\*|\/\*|\'|\.\.\/|\.\/|UNION|into|load_file|outfile/', $sql_str);
        if ($check) {
            return false;
        } else {
            return $sql_str;
        }
    }

    static function md5str($password, $source)
    {
        return md5(md5($password) . $source . '9open');
    }

    static function random_keys($length)
    {
        $returnStr = '';
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
//    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $returnStr .= $pattern{mt_rand(0, 35)}; //生成php随机数
        }
        return $returnStr;
    }

    static function get_ip()
    {
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

    static function get_position($array, $img)
    {
        if (is_array($array)) {
            $position = '';
            $end = array_pop($array);
            foreach ($array as $k => $v) {
                $position .= '<a  class="txt" href="' . ((isset($v['url']) && $v['url']) ? $v['url'] : 'javascript:;') . '">' . $v['name'] . '</a> <span class="arrow"><img alt="" src="' . $img . '"></span> ';
            }
            $position .= '<a  class="txt" href="' . ((isset($end['url']) && $end['url']) ? $end['url'] : 'javascript:;') . '">' . $end['name'] . '</a>';
        }
        return $position;
    }

    static function show_img($thumb = '', $host = '')
    {
        if ($thumb) {
            $key_str = 'data/attachment/';
            $host = $host ? $host : Mod::app()->baseUrl;
            if (substr(trim($thumb), 0, 4) == 'http') {
                $new_thumb = $thumb;
            } else {
                if (substr(trim($thumb), 0, 16) == $key_str || strstr($thumb, $key_str))
                    $new_thumb = $host . '/' . $thumb;
                else
                    $new_thumb = $host . '/' . $key_str . $thumb;
            }
        } else {
            $new_thumb = Mod::app()->baseUrl . '/data/nopic.jpg';
        }

        return $new_thumb;
    }

    static function show_member_thumb($thumb = '', $host = '')
    {
        if ($thumb) {
            $key_str = 'data/attachment/';
            $host = $host ? $host : Mod::app()->baseUrl;
            if (substr(trim($thumb), 0, 4) == 'http') {
                $new_thumb = $thumb;
            } else {
                if (substr(trim($thumb), 0, 16) == $key_str || strstr($thumb, $key_str))
                    $new_thumb = $host . '/' . $thumb;
                else
                    $new_thumb = $host . '/' . $key_str . $thumb;
            }
        } else {
            $new_thumb = Mod::app()->baseUrl . '/data/nopic.jpg';
        }
        return $new_thumb;
    }


//排序
    static function cmp_func($a, $b)
    {
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

    static function change_array_index($arr, $key = 'id')
    {
        $newarr = array();
        foreach ($arr as $item) {
            $newarr[$item[$key]] = $item;
        }
        return $newarr;
    }

    static function change_array($arr, $key = 'id', $value = 'value')
    {
        $newarr = array();
        foreach ($arr as $item) {
            $newarr[$item[$key]] = $item[$value];
        }
        return $newarr;
    }


    static function mult_to_idarr($arr, $key = 'id')
    {
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
        $string = preg_replace('#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?)\s*>#is', '<${1}>', $string); //去掉onload/onxxxx
        //$string = preg_replace('#\s*<(/?\w+)\s+(?:on\w+\s*=\s*(["\'\s])?.+?\(\1?.+?\1?\);?\1?|style=["\'].+?["\'])\s*>#is', '<${1}>',$string);

        // realign javascript href to onclick
        $string = preg_replace("/href=(['\"]).*?javascript:(.*)? \\1/i", "onclick=' $2 '", $string);

        //remove javascript from tags
        while (preg_match("/<(.*)?javascript.*?\(.*?((?>[^()]+) |(?R)).*?\)?\)(.*)?>/i", $string))
            $string = preg_replace("/<(.*)?javascript.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $string);

        // dump expressions from contibuted content
        if (0) $string = preg_replace("/:expression\(.*?((?>[^(.*?)]+)|(?R)).*?\)\)/i", "", $string);

        while (preg_match("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", $string))
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
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen) {
            $result .= $etc;
        }
        return $result;
    }

    public static function delhtmlimg($html)
    {
        return preg_replace('/<img[^>]+>/i', '', $html);
    }

    public static function delhtmltags($html)
    {
        return preg_replace('/<[^>]+>/', '', $html);
    }

    /**
     * GET 请求
     * @param string $url
     */
    static function http_get($url)
    {
        //  echo $url;
        //初始化
        $curl = curl_init();
        //设置抓取的url
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        $aStatus = curl_getinfo($curl);
        //$error=curl_error($curl);
        //关闭URL请求
        curl_close($curl);
        if (intval($aStatus["http_code"]) == 200) {
            return $data;
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
    public static function http_post($url, $param, $referer = '')
    {
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
        if ($referer) {
            curl_setopt($oCurl, CURLOPT_REFERER, $referer);
        }
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
//参数$outfile表示是否输出二维码图片 文件，默认否；
//参数$level表示容错率，也就是有被覆盖的区域还能识别，分别是 L（QR_ECLEVEL_L，7%），M（QR_ECLEVEL_M，15%），Q（QR_ECLEVEL_Q，25%），H（QR_ECLEVEL_H，30%）； 
//参数$size表示生成图片大小，默认是3；
//参数$margin表示二维码周围边框空白区域间距值；
//参数$saveandprint表示是否保存二维码并 显示。
    static function Qrcode($url, $outfile = false, $level = '', $size = 8, $margin = 2, $saveandprint = false)
    {
        if (substr(trim($url), 0, 4) == 'http') {
            $url = $url;
        } else {
            $url = 'http://' . $url;
        }
        defined('PHPQRCODE_PATH') || define('PHPQRCODE_PATH', dirname(__FILE__) . '/../vendor/phpqrcode/');
        require_once PHPQRCODE_PATH . 'phpqrcode.php';
        return QRcode::png($url, $outfile, $level, $size, $margin, $saveandprint);
    }

    static function Project_status($status)
    {
        switch ($status) {
            case 0:
                $str = '审核中';
                break;
            case 1:
                $str = '已审核';
                break;
            case 7:
                $str = '审批拒绝';
                break;
            case 8:
                $str = '管理员删除';
                break;
            case 9:
                $str = '用户删除';
                break;
        }
        return $str;
    }

    static function Attachment_status($status)
    {
        switch ($status) {
            case 0:
                $str = '审核中';
                break;
            case 1:
                $str = '已审核';
                break;
            case 7:
                $str = '审批拒绝';
                break;
            case 8:
                $str = '管理员删除';
                break;
            case 9:
                $str = '用户删除';
                break;
        }
        return $str;
    }

    //xss
    public static function xss_clean($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20\"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
        do {// Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);
        // we are done...
        return $data;
    }


    //xss
    public static function SafeFilter(&$arr)
    {

        $ra = Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/script/', '/javascript/', '/vbscript/', '/expression/', '/applet/', '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/', '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/', '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/', '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/');

        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (!is_array($value)) {
                    if (!get_magic_quotes_gpc())             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
                    {
                        $value = addslashes($value);           //给单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）加上反斜线转义
                    }
                    $value = preg_replace($ra, '', $value);     //删除非打印字符，粗暴式过滤xss可疑字符串
                    $arr[$key] = htmlentities(strip_tags($value)); //去除 HTML 和 PHP 标记并转换为 HTML 实体
                } else {
                    SafeFilter($arr[$key]);
                }
            }
        }
    }


    //xss
    public static function remove_xss($val)
    {
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
            $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(�{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
        }
        // now the only remaining whitespace attacks are \t, \n, and \r
        $ra1 = array('javascript', 'alert', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
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
                $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
                $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }
        return $val;
    }

    static function getrandtoken($id)
    {
        $randchar = substr(self::getRandChar(16), strlen($id));
        return $randchar . $id . mt_rand();
    }

    static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

    static function geterroecode()
    {
        $error_code = array();
        require 'Errorcode.php';
//                 var_dump($error_code);
        return $error_code;
    }


    static function get_sessionidbysign($sign)
    {
        $sessionid = $sign;
        return $sessionid;
    }

    static function get_signbysessionid($sessionid)
    {
        $sign = $sessionid;
        return $sign;
    }


    /**
     * @abstract 投票提示消息弹框
     * @param string $msg 消息内容
     * @param string $redirect 跳转地址 -1为跳转到上一个页面 默认为-1
     */
    public static function alert($msg = '', $redirect = '-1')
    {
        $strInfo = '<html><head><link rel="stylesheet" href="' . Mod::app()->baseUrl . '/themes/new/assets/vote/css/style.css">';
        $strInfo .= '<script type="text/javascript" src="' . Mod::app()->baseUrl . '/themes/new/assets/vote/js/jquery-1.12.0.min.js"></script></head>';
        $strInfo .= '<body>';
        $strInfo .= '<script language="JavaScript" type="text/javascript">';
        $location = empty($redirect) || $redirect == '-1' ? 'window.history.back(-1)' : 'window.location.href="' . $redirect . '?status#";';
        $strInfo .= '</script>';
        $strInfo .= '<div class="mask" style="display: block"></div><div style="display: block" class="vote-pop bg4"><span id="imgsrc"><img src="' . Mod::app()->baseUrl . '/themes/new/assets/vote/images/vote-test.jpg"/></span><p class="fcfff fs30" id="vote-txt">' . $msg . '</p><div class="closebtn fs30" onclick=' . $location . ' >确定</div></div>';
        $strInfo .= '</body></html>';
        echo $strInfo;
        exit;
    }

    static function is_weixin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }
        return false;
    }


    /*移动端判断*/
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }


}
