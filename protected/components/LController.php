<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class LController extends CController {

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

    public function init() {
       if(!in_array(Mod::app()->request->userHostAddress,array('127.0.0.1','111.47.243.43','14.17.22.54','27.17.15.94',
        '183.61.38.182','10.68.51.192','14.17.22.35','61.135.172.68'//微众
        ))){die('非法的IP访问地址');}
         header("Content-type: text/html; charset=utf-8");

    }

 
    
}
