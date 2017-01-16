<?php
/**
 * 全局函数
 *
 
 
 
 * @package       /protected/modules/b2c/components
 
 */

class GlobalFunc {
    /**
     * 字符串截取
     * @access public
     * @param $String
     * @param $CutNum
     * @param string $Style
     * @param string $encoding
     * @return string
     */

    public static function globalSubstr($String,$CutNum,$Style='',$encoding='utf-8'){
        if(!function_exists('mb_substr')) {
            die('must support php_mb_substr');
        }
        if(!$String) return false;
        $String = strip_tags($String);
        $strCounter = mb_strlen($String,$encoding);
        if($CutNum > $strCounter) $CutNum = $strCounter;
        $tempStr  = mb_substr($String,0,$CutNum,$encoding);
        if($strCounter > $CutNum) {
            $tempStr .= $Style;
        }
        return $tempStr;
    }

    /**
     * 多维数组字段组合成字符
     *
     * @param array $arr
     * @param $key
     * @return bool|string
     */
    public static function ArrayToString(Array $arr,$key)
    {
        if (!$arr) return false;
        foreach ($arr as $v) {
            $item[] = $v[$key];
        }
        $str = implode(',',$item);

        return $str;
    }

    /**
     * 组合对象列表信息
     *
     * @param $data
     * @param $val
     * @return array
     */
    public static function ArrayListByKey($data,$val)
    {
        $items = array();
        foreach ($data as $v) {
            $items[$v[$val]] = $v;
        }

        return $items;
    }

    /**
     * 字符编码转换
     *
     * @param $word
     * @return string
     */
    public static function WordEncode($word)
    {
        $encode = mb_detect_encoding($word, array('ASCII','UTF-8','GB2312','GBK','BIG5',"ISO-8859-1"));
        if ($encode != 'UTF-8') $word = iconv($encode,'UTF-8',$word);
        return $word;
    }
} 