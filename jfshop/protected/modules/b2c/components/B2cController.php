<?php
/**
 * 控制器基础类，所有控制器均需继承此类
 
 */

class B2cController extends Controller
{
    public $layout='column_default';
    public $pagesize = 15;
    public $username;
    public $member_id = '';
    public $img = '/';
    public $cart;
    public $controller;
    public $_siteUrl;
    public $dachu;

    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
        $this->username = Mod::app()->session['member']['name'];
        $this->member_id = Mod::app()->session['member']['id'];
        $this->controller = $id;
        if(Mod::app()->session['member']){
            //更改session积分值
//            $url = Myconfig::DACHUHOST.'/api/point/getmemberpoints';
            $this->dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
            $this->dachu->Get_token();
//            $res = $dachu->getmemberpoints($this->member_id);
            $this->dachu->checkmemberproject($this->member_id,$this->member_id);
//            $memberinfo=Mod::app()->session['member'];
//            $memberinfo['points'] = $res['data']['points'];
//            Mod::app()->session['access_token'] = $token['access_token'];
//            Mod::app()->session['member'] = $memberinfo;

        }
    }

    public function init()
    {
        $this->_siteUrl =Mod::app()->request->hostInfo.Mod::app()->request->baseUrl;
        $this->cart = Layouts::Cart($this->member_id);
        header("Content-type: text/html; charset=utf-8");  
    }

    /**
     * 登录设置
     */
    public function CheckLogin()
    {
        if (!$this->username) $this->redirect('/account/login');
    }

    /**
     * GET获取单个数据
     */
    public function get($val,$type='str')
    {
        if ($type == 'str') {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):'';
        } else if($type == 'int') {
            $data = Tool::getValidParam($val)?intval(Tool::getValidParam($val)):0;
        } elseif ($type == 'bool') {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):'false';
        } else {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):'';
        }
        return $this->_CheckAndQuote($data);
    }

    /**
     * POST获取单个数据
     */
    public function post($val,$type='str')
    {
        if ($type == 'str') {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):'';
        } else if($type == 'int') {
            $data = Tool::getValidParam($val)?intval(Tool::getValidParam($val)):0;
        } elseif ($type == 'bool') {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):false;
        } else {
            $data = Tool::getValidParam($val)?Tool::getValidParam($val):'';
        }


        return $this->_CheckAndQuote($data);
    }

    /**
     * prevent from invalidate sql sentense is put in advanced
     *
     * @param  $value value of waiting for format
     * @return string formatted value
     */
    function _CheckAndQuote($value)
    {
        if (is_int($value)) {//如果是整形
            return intval($value);
        }elseif( is_float($value)){//如果是浮点型
           return floatval($value);
        }else{//如果是字符串
            $value = strval($value);
            $value = str_replace(' ', '', $value);
            $value=$this->remove_xss($value);
            return $value;
        }

        //return '\'' . mysql_real_escape_string($value) . '\'';
        return htmlspecialchars(addslashes($value));
    }


    public  function remove_xss($val) {
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
        $ra1 = array('javascript','alert', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
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



    /**
     * 加载js文件
     * @param $file
     * @param string $type
     * @param string $theme
     */
    public function registerJs($file,$type='end',$theme='b2c')
    {
        switch($type) {
            case 'end':
                $js = CClientScript::POS_END;
                break;
            default:
                $js = CClientScript::POS_END;
        }
        if (is_array($file)) {
            foreach ($file as $model)
                Mod::app()->clientScript->registerScriptFile(Mod::app()->baseUrl .'/themes/'.$theme.'/js/'.$model.'.js',$js);
        } else
            Mod::app()->clientScript->registerScriptFile(Mod::app()->baseUrl .'/themes/'.$theme.'/js/'.$file.'.js',$js);
    }

    //返回json响应
    /**
     * @param int $code
     * @param string $msg
     * @param array $data
     */
    public function sendJsonResponse($code=200,$msg='',$data=array()){
        $result = array('code'=>$code,'msg'=>$msg,'data'=>$data);
        echo json_encode($result);
        die();
    }


    public function  curl_get($url){
        //猜你喜欢积分商城接口
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        //设置cURL允许执行的最长秒数。
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        return $sContent;
    }
}