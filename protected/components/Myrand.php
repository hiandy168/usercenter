<?php

class Myrand {

    public static function Randstr($num=32) {
        $alpha = "abcdefghklmnpqrstuvxy"; //验证码内容1:字母
            $randcode = ""; //验证码字符串初始化
            $how =$num;
            for ($i = 0; $i < $how; $i++) {
                $str = $alpha;
                $which = mt_rand(0, strlen($str) - 1); //取哪个字符
                $code = substr($str, $which, 1); //取字符
                $randcode .= $code; //逐位加入验证码字符串
            }
			return $randcode;
    }

}
