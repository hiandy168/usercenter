<?php
/**
 * 控制器基础类，所有控制器均需继承此类
 
 */

class BaseController extends Controller
{
    public $connection;
    public $layout='//layouts/main';
    public $action;
    public $pagesize = 15;
    public $ActList = array();
    public $admini;
    public $module;
    public $controller;
    public $default_img = '/images/';
    public $image_url = '/';
     public $_siteUrl;

    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
        if(!in_array(Mod::app()->request->userHostAddress,array('127.0.0.1','27.17.15.94'))){die('非法的IP访问地址');}
        if (isset($this->getModule()->id)) $this->module = $this->getModule()->id;
        $this->controller = $this->getId();
        if (empty(Mod::app()->session['_admini'])) $this->redirect('index.php?r=admin/login');
        $this->_siteUrl = Mod::app()->request->hostInfo.Mod::app()->baseUrl; 
        $this->admini = Mod::app()->session['_admini'];
        $this->ActList = XAdminiAcl::filterMenu($this->Act($this->admini['acl']),$this->admini['super']);
        $this->Pemission($this->Act($this->admini['acl']),$this->admini['super']);

        $this->connection = Mod::app()->db;
    }

    /**
     * 控制器Act解析
     *
     * @param $acl
     * @return array
     */
    public function Act($acl)
    {
        $item = array();
        foreach (explode(',',$acl) as $v) {
            if (strpos($v,'|') === false) {
                $item[] = $v;
                continue;
            }
            $route = explode('_',$v);
            $mod = $route[0];
            $ctl = $route[1];
            $act = $route[2];
            $actList = explode('|',$act);
            foreach ($actList as $vv) $item[] = $mod.'_'.$ctl.'_'.$vv;
        }

        return $item;
    }

    /**
     * 权限验证
     *
     * @param $acl
     * @param $super
     */
    public function Pemission($acl,$super)
    {
        if ($super == 1) return;
        $r = Tool::getValidParam('r');
        $permission = str_replace('/','_',$r);
        $except = array(
            'desktop/default/index',
            'desktop/default/permission'
        );
        if (!in_array($r,$except) && !in_array($permission,$acl)) {

            $this->redirect('?r=desktop/default/permission&redirect='.Mod::app()->request->urlReferrer);
        }
    }

    /**
     * 页面按钮是否显示
     *
     * @param $route
     * @return bool
     */
    public function ButtonPermission($route)
    {
        $acl = $this->admini['acl'];
        $super = $this->admini['super'];

        if ($super == 1) return true;
        $route = str_replace('/','_',$route);

        if (!in_array($route,explode(',',$acl))) return false;
        return true;
    }

    /**
     * 列表页按钮是否显示
     *
     * @param $actArr
     * @param string $implode
     * @return string
     */
    public function TemplateButton($actArr,$implode='&nbsp&nbsp&nbsp')
    {
        $item = array();
        foreach ($actArr as $v) {
            $route = $this->module.'/'.$this->controller.'/'.$v;
            if ($this->ButtonPermission($route)) $item[] = '{'.$v.'}';
        }
        return implode($implode,$item);
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
        }
        return $this->_CheckAndQuote($data);
    }

    /**
     * GET获取多个数据
     */
    public function gets(Array $arr)
    {
        foreach ($arr as $v) {
            $item[] = Tool::getValidParam($v);
        }

        return $item;
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
        }
        return $this->_CheckAndQuote($data);
    }

    /**
     * POST获取多个数据
     */
    public function posts(Array $arr)
    {
        foreach ($arr as $v) {
            $item[$v] = Tool::getValidParam($v);
        }

        return $item;
    }

    /**
     * prevent from invalidate sql sentense is put in advanced
     *
     * @param  $value value of waiting for format
     * @return string formatted value
     */
    function _CheckAndQuote($value)
    {
        if (is_int($value) || is_float($value)) {
            return $value;
        }

        //return '\'' . mysql_real_escape_string($value) . '\'';
        return $value;
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
     * 事务开启
     */
    public function begin()
    {

    }

    /**
     * 事务结束
     */
    public function end()
    {

    }

    /**
     * 加载js文件
     * @param $file
     * @param string $type
     * @param string $theme
     */
    public function registerJs($file,$type='end',$theme='ace')
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

    /**
     * 提示信息
     */
    public function message( $action = 'success', $content = '', $redirect = '', $timeout = 3 )
    {
        $body = $this->renderPartial(
            '//site/popup',
            array(
                'action'=>$action,
                'redirect'=>$redirect,
                'content'=>$content,
                'timeout'=>$timeout
            )
        );
        exit ($body);
    }

    /**
     * 返回上一个页面
     */
    public function referrer($type = 0,$action = array('index'))
    {
        if ($type == 1) {
            if (isset(Mod::app()->request->urlReferrer) && Mod::app()->request->urlReferrer)
                $this->redirect(Mod::app()->request->urlReferrer);
        } else {
            $this->redirect($action);
        }
    }

}