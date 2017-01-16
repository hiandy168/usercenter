<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AController extends CController {

    /**
     * @var string the def ault layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'application.modules.admin.views.layouts.admin';
//    public  $layout='//layouts/admin';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    public $admin_menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    protected $_gets;
    protected $_baseUrl;
    protected $_wwwPath;
    protected $_theme;
    protected $_themePath;
    protected $_adminUrl;
    protected $_siteUrl;
    protected $lang;
    protected $cache_type;
    protected $_module_id;
    protected $user = array();
    static public $treeList = array();
    public function init() {
    if(!in_array(Mod::app()->request->userHostAddress,array('127.0.0.1','111.47.243.43','14.17.22.54','27.17.15.94','183.61.38.182'))){die('非法的IP访问地址');}
//        echo DIRECTORY_SEPARATOR;
         $this->_module_id = $this->getModule()->id;
        $this->lang = Lang::getLang();
        $this->_gets = Mod::app()->request;
        $this->_wwwPath = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        $this->_baseUrl = Mod::app()->baseUrl;
		$this->_siteUrl = str_replace('index.php', '', Mod::app()->createAbsoluteUrl('/'));
        $this->_adminUrl =$this->_siteUrl.'/admin';

        $this->_theme = Mod::app()->theme;
        $this->_themePath = str_replace(array('\\', '\\\\'), '/', Mod::app()->theme->basePath);
        $this->check_install(); //检查是否被安装
        $this->check_user_login(); //验证登陆状态
        $this->user = Mod::app()->session['admin_user']; //主要用在批量上传 flash上传 单独session  取不到管理员session信息  验证用到token
        $this->cache_type = $this->get_cachetype();//获取缓存类型
        $this->admin_menu = $this->get_admin_menu();
    }

    public function check_install() {
//        检测系统是否已经安装
    }

    /**
     * 导航菜单数据
     */
    public function admin_menu() {
        $menu = array();
        require 'menu.php';
        return $menu;
    }

    /**
     * 关闭状态
     */
    protected function _closed() {
        $this->render('/error/close', array('message' => '本站关闭中'));
        exit;
    }

    function admin_message($content, $target_url = '', $delay_time = 0) {
        if ($delay_time < 0)
            $delay_time = 0;
        $data = array('content' => $content, 'target_url' => $target_url, 'delay_time' => $delay_time);
        $message = $this->renderPartial('/message', $data, true);
        echo $message;
        exit;
    }

    function check_user_login() {
        $user_info = Mod::app()->session['admin_user'];
        if (!$user_info['id']) {
            header("Content-Type: text/html; charset=utf-8");
            $str = '<script type="text/javascript">';
            $str .= 'top.location.href="' . Mod::app()->createUrl('/admin/login').'"';
            $str .= '</script>';
            echo $str;
            exit;
        }
    }

    function check_permission($control, $fun) {
        $control = str_replace('controller', '', strtolower($control));
        $fun = str_replace('action', '', strtolower($fun));
        $permission = unserialize($this->user['permission']);
        //$this->printOut($permission);
        if($this->user['group_id']==1){
            //超级管理员有所有权限
        }else if (!isset($permission[$control]) || !in_array($fun, $permission[$control])) {
                $this->admin_message('没有权限，禁止操作！！！！！！！！！！！');
        }
    }


    
    function get_cachetype(){
         $result  = Setting::model()->find("type='cache' and lang ='".$this->lang."'");   
        if(!$result){
            return $cache_type = 'filecache';
        }else{
            return $cache_type = $result->attributes['value'];
        }
    }
    
    
       public function get_admin_menu() {
            $menu = $this->admin_menu();
            if($this->user['group_id'] ==1){
                return $menu;
            }
            $html = '';
            $permission = unserialize($this->user['permission']);       
            $class_arr = array_keys($permission);
            //print_r($permission);
         
             //过滤有没有权限的菜单
           foreach($menu as $m_k=>$m_v){
               if(isset($m_v['children'])){
                foreach ($m_v['children'] as $k=>$c) {
                        $temp_class_arr = explode('/', $c['url']);
                        //print_r($temp_class_arr) ;
                        //echo "<br>";
                        
                        $qiangzhi_view = (isset($menu[$m_k]['children'][$k]['view']) && $menu[$m_k]['children'][$k]['view']);
                       if(!$qiangzhi_view){
                        if(!in_array(strtolower($temp_class_arr[0]),$class_arr)  ){
                                unset($menu[$m_k]['children'][$k]);
                        }else if(isset($temp_class_arr[1])&& $temp_class_arr[1]){
                            if(!in_array(strtolower($temp_class_arr[1]),$permission[$temp_class_arr[0]])){
                                unset($menu[$m_k]['children'][$k]);
                            }
                        } 
                       }
                }
               }
                if(isset($menu[$m_k]['children']) &&!count($menu[$m_k]['children'] ))
                    unset($menu[$m_k]);
            }
//            var_dump($menu);die;
            return $menu;
           
//            foreach($menu as $m_k=>$m_v){
//                $submenu='';
//                if(isset($m_v['children'])&&$m_v['children']){
//                      $submenu='treeview';
//                }
//			    $html .='<li class="'.$submenu.'" data-id="'.$m_k.'">';
//				$html .='<a href="'.((isset($m_v['url'])&&$m_v['url'])?Mod::app()->createAbsoluteUrl($this->_module_id.'/'.$m_v['url']):'javascript:void(0)').'"><i class="fa '.$m_v['ico_class'].'"></i> <span>'.$m_v['title'].'</span>';
//                if(isset($m_v['children'])&&$m_v['children']){
//                    $html .='<span class="label label-primary pull-right">'.count($m_v['children']).'</span>';
//                }else{
//					$html .='<i class="fa fa-angle-left pull-right"></i>'; 
//				}
//                $html .='</a>';
//                
//                $i = 1;
//                if(isset($m_v['children'])&&$m_v['children']){
//					$html .= '<ul class="treeview-menu  nav_childen_two" >';
//                    foreach ($m_v['children'] as $c) {
//                        $html .= '<li data-id="'.$c['url'].'" data-ico-class="'.(isset($c['ico_class'])?$c['ico_class']:'').'"><a href="' . Mod::app()->createAbsoluteUrl($this->_module_id.'/'.$c['url']) . '"><i class="fa fa-circle-o"></i>' . $c['title'] . '</a>';
//                        if(isset($c['children'])&& $c['children']){
//                            $html2='';
//                            $html2 .='<ul class="treeview-menu nav_childen_three">';
//                            foreach ($c['children'] as $cckey => $ccvalue) {
//                                $html2 .= '<li data-id="'.$ccvalue['url'].'" data-ico-class="'.(isset($ccvalue['ico_class'])?$ccvalue['ico_class']:'').'"><a href="' . Mod::app()->createAbsoluteUrl($this->_module_id.'/'.$ccvalue['url']) . '"><i class="fa fa-circle-o"></i>' . $ccvalue['title'] . '</a></li>';
//                            }
//                            $html2 .='</ul>';
//                            $html .=$html2;
//                        }
//                         $html .='</li>';
//                        $i++;
//                    }
//					$html .= '</ul>';
//                }
//                $html .= '</li>';
//            }
//            return $html;
    }

    public function printOut($param){
        echo '<pre>';
        print_r($param);
        exit;
    }


    public function  tree($data,$pid = 0,$count = 1) {
        foreach ($data as $key => $value){
            if($value['parent_id']==$pid){
                $value['count'] = $count;
                self::$treeList []=$value;
                unset($data[$key]);
                $this->tree($data,$value['id'],$count+1);
            }
        }
        return self::$treeList;
    }
}
