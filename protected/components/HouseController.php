<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class HouseController extends FrontController {

    /**
     * @var string the def ault layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'application.modules.house.views.layouts.admin';
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
    protected $member;//登录的用户信息
    protected $user = array();
    protected  $bankurl="https://test-svrapi.webank.com/";
    static public $treeList = array();
    public function init() {
        parent::init();
       if(!$this->member['id']){
            header("location:".$this->_siteUrl."/house/login");
            exit;
        }
        $this->_wwwPath = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
//        $this->_wwwPath = str_replace(array('\\', '\\\\'), DIRECTORY_SEPARATOR, dirname(__FILE__));
         Wzbank::check_lce(); //检查是否有证书
         Wzbank::sign(); //获取访问令牌（access token）
         Wzbank::ticket(); //获取API票据（ticket3600）
         //Wzbank::h5ticket(); //获取API票据（ticket120）
    }




}
