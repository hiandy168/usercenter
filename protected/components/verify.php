<?php

class verify {

    var $width = '100';
    var $num = '5';
    var $height = '32';
    var $name = 'verify_code';
    var $font;

    public function __construct($conf = "") {
        if ($conf != "") {
            foreach ($conf as $key => $value) {
                $this->$key = $value;
            }
        }
//             $this->font = dirname(__FILE__).DIRECTORY_SEPARATOR.'LiberationSans-Bold.ttf';
    }

    function show() {
        Header("Content-type: image/gif");
        // 初始化
        $border = 0; //是否要边框 1要:0不要
        $how = $this->num; //验证码位数
        $w = $this->width; //图片宽度
        $h = $this->height; //图片高度
        $fontsize = 25; //字体大小
        $alpha = "abcdefghknpqrstuvxy3456789"; //验证码内容1:字母
        $number = "3456789"; //验证码内容2:数字
        $this->randcode = ""; //验证码字符串初始化
        srand((double) microtime() * 1000000); //初始化随机数种子

        $im = ImageCreate($w, $h); //创建验证图片

        // 绘制基本框架
        $bgcolor = ImageColorAllocate($im, 255, 255, 255); //设置背景颜色
        ImageFill($im, 0, 0, $bgcolor); //填充背景色
        if ($border) {
            $black = ImageColorAllocate($im, 0, 0, 0); //设置边框颜色
            ImageRectangle($im, 0, 0, $w - 1, $h - 1, $black); //绘制边框
        }

        //逐位产生随机字符
        for ($i = 0; $i < $how; $i++) {
            $str = $alpha;
            $which = mt_rand(0, strlen($str) - 1); //取哪个字符
            $code = substr($str, $which, 1); //取字符
            $j = !$i ? 4 : $j + 18; //绘字符位置
//            echo $j.'<br>';
            $color3 = ImageColorAllocate($im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)); //字符随即颜色
            imagettftext($im, $fontsize, 0, $j, 24, $color3, $this->font, $code);
            $this->randcode .= $code; //逐位加入验证码字符串
        }

        // 添加干扰
        for ($i = 0; $i < 5; $i++) {//绘背景干扰线
            $color1 = ImageColorAllocate($im, mt_rand(0, 255), mt_rand(0, 255),mt_rand(0, 255)); //干扰线颜色
            ImageArc($im, mt_rand(-5, $w), mt_rand(-5, $h), mt_rand(20, 300), mt_rand(20, 200), 55, 44, $color1); //干扰线
        }
        for ($i = 0; $i < $how * 8; $i++) {//绘背景干扰点
            $color2 = ImageColorAllocate($im, 0, 0, 0); //干扰点颜色
            ImageSetPixel($im, mt_rand(0, $w), mt_rand(0, $h), $color2); //干扰点
        }
//        
        //把验证码字符串写入session
//        $_SESSION[$this->name] = $randcode;
//        $this->session->set_userdata($this->name, $randcode);
        /* 绘图结束 */
        Imagegif($im);
        ImageDestroy($im);
        /* 绘图结束 */
    }
    
    public function get_randcode(){
        return $this->randcode;
    }
    
    public function get_lujing(){
       return dirname(__FILE__);
    }

}

?>