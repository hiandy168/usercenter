<?php

class Safetool {

    public static function SafeFilter($value) {
        $value = Safetool::remove_xss($value);
        $value = mysql_escape_string($value);
       // $value = mysql_real_escape_string($value);
        return $value;
    }

    /**
     * 去掉字符串中的HTML的图片
     */
    public static function delhtmlimg($html) {
        return preg_replace('/<img[^>]+>/i', '', $html);
    }

    /**
     * 去掉字符串中的HTML的tags
     */
    public static function delhtmltags($html) {
        return preg_replace('/<[^>]+>/', '', $html);
    }

    public static function remove_imgwidthheight($str) {
        /* PHP正则提取图片img标记中的任意属性 */
//            $str = '<div style="margin: 0px auto; width: 740px;"> <p><img width="748" height="444" alt="" src="/images/upload/Image/manmiao_0001.jpg" /></p></div>';
        //去掉图片宽度
        $search = '/(<img.*?)width=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
        //去掉图片高度
        $search1 = '/(<img.*?)height=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
        $content = preg_replace($search, '$1$3', $str);
        $content = preg_replace($search1, '$1$3', $content);
        //去掉div的style
        return $content;
    }

    public static function remove_style($str) {
        return $content = preg_replace("/style=.+?['|\"]/i", '', $str); //这种方式很简单易懂，但因为太简单，不知道有没有漏洞，否则去掉图片的宽高也用这种方法写了
    }

    public static function remove_imgborder($str) {
        $search = '/(<img.*?)border=(["\'])?.*?(?(2)\2|\s)([^>]+>)/is';
        return preg_replace($search, '$1$3', $str);
    }

    /**
     * 去掉字符串中的HTML标签
     * @param string $string 输入字符串
     * @return string 返回结果
     */
    public static function nohtml($string) {
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
     * @param string $string 输入字符串
     * @return string 返回结果
     */
    public static function noscript($string) {
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
        if (0)
            $string = preg_replace("/:expression\(.*?((?>[^(.*?)]+)|(?R)).*?\)\)/i", "", $string);

        while (preg_match("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", $string))
            $string = preg_replace("/<(.*)?:expr.*?\(.*?((?>[^()]+)|(?R)).*?\)?\)(.*)?>/i", "<$1$3$4$5>", $string);

        // remove all on* events
        /*
          while( preg_match("/<(.*)?\s?on.+?=?\s?.+?(['\"]).*?\\2 \s?(.*)?>/i", $string) )
          $string = preg_replace("/<(.*)?\s?on.+?=?\s?.+?(['\"]).*?\\2\s?(.*)?>/i", "<$1$3>", $string);
         */
        $aDisabledAttributes = array('alert', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $string = preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $aDisabledAttributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", $string);
        return $string;
    }

    

    //xss
    public static function remove_xss($val) {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
//        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
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
        $ra2 = array( 'alert','prompt','onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
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

    public static function SafeFilter2(&$arr) {

        $ra = Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '/script/', '/javascript/', '/vbscript/', '/expression/', '/applet/', '/meta/', '/xml/', '/blink/', '/link/', '/style/', '/embed/', '/object/', '/frame/', '/layer/', '/title/', '/bgsound/', '/base/', '/onload/', '/onunload/', '/onchange/', '/onsubmit/', '/onreset/', '/onselect/', '/onblur/', '/onfocus/', '/onabort/', '/onkeydown/', '/onkeypress/', '/onkeyup/', '/onclick/', '/ondblclick/', '/onmousedown/', '/onmousemove/', '/onmouseout/', '/onmouseover/', '/onmouseup/', '/onunload/');

        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (!is_array($value)) {
                    if (!get_magic_quotes_gpc()) {             //不对magic_quotes_gpc转义过的字符使用addslashes(),避免双重转义。
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

}
