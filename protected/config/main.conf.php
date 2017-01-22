<?php
  
define('CONFIG_PATH', dirname(__FILE__));
// uncomment the following to define a path alias
// Mod::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


/***********************qq 相关参数-----*********************/
//申请到的appid
//define('APPID', 101369824);
define('APPID', 101370101);

//申请到的appkey
//define('APPKEY', "d871e0e6c55f34b068e7ee1813acfcc4");
define('APPKEY', "d808fd63cf99a7fb06e87cc4582d0067");

//QQ登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
//define('CALLBACK',"https://m.hb.qq.com/member/qqcallback");//
define('CALLBACK',"https://m.tengchu.com/member/qqcallback");

//QQ授权api接口.按需调用
define('SCOPE',"get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo");
/********************qq 相关参数-  ende   ************************----*/




/***********************微信开放平台相关参数***********************/
//申请到的appid
//define('WXAPPID', 'wx8790b043d7f3b4ab');
define('WXAPPID', 'wx4d8ae9e53cd0d563');

//申请到的appkey
//define('WXAPPKEY', "16ea0ab125d072adfdb85c8ba5eee647");
define('WXAPPKEY', "cb590d2800edacadbc2fc62840807ee1");

//登录成功后跳转的地址,请确保地址真实可用，否则会导致登录失败。
//define('REDIRECT_URI',"https://m.hb.qq.com/member/WXgetaccesstoken");
define('REDIRECT_URI',"https://m.tengchu.com/member/WXgetaccesstoken");
/***********************微信相关参数***********************/



/***********************微信 公众 平台相关参数***********************/
//申请到的appid
define('WEIXINAPPID', 'wx37e6cc950b4fd03a');

//申请到的appkey
define('WEIXINSECRET', "84ca70e17f41cf53e8994c353c40318f");


/***********************微信相关参数***********************/



return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'language'=>'zh_cn', //不设置的话缺省为 en_us
    'timeZone'=>'Asia/Shanghai',
    'name' => 'hbucenter',
    'theme' => 'default',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'modules' => array(
        'admin' => array(
            'class' => 'application.modules.admin.AdminModule',
            'defaultController' => 'main',
        ),
        'h5' => array(
            'class' => 'application.modules.h5.H5Module',
            'defaultController' => 'member',
        ),
        'shop' => array(
            'class' => 'application.modules.shop.ShopModule',
            'defaultController' => 'install',
        ),
        'house' => array(
            'class' => 'application.modules.house.HouseModule',
            'defaultController' => 'site',
        ),
        'houseadmin' => array(
            'class' => 'application.modules.houseadmin.HouseadminModule',
            'defaultController' => 'main',
        ),
    // uncomment the following to enable the Gii tool
    /*
      'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'Enter Your Password Here',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
      ),
     */
    ),
    // application components
    'components' => array(
        "messages"=>array(
            'class'=>'CPhpMessageSource',
            'basePath'=> realpath(dirname(__FILE__).'/../messages'),
    ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName'=>false,
            //'urlSuffix'=>'.html',
            'rules'=>array(
                                //后台路由
                                'admin/<controller:\w+>/'=>'admin/<controller>',
                                'admin/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',
                                'admin/<controller:\w+>/<action:\w+>/*'=>'admin/<controller>/<action>',
                                'admin/*'=>'admin',
                                //房产后台路由
                                'houseadmin/<controller:\w+>/'=>'houseadmin/<controller>',
                                'houseadmin/<controller:\w+>/<action:\w+>'=>'houseadmin/<controller>/<action>',
                                'houseadmin/<controller:\w+>/<action:\w+>/*'=>'houseadmin/<controller>/<action>',
                                'houseadmin/*'=>'houseadmin',
                                 
            ),
        ),
        //数据库组件
        'db'=>require(CONFIG_PATH.'/db.php'),
        'log' => require(CONFIG_PATH.'/log.php'),
        'errorHandler' => array(
//            // use 'site/error' action to display errors
//               'errorAction'=>'error/index',
        ),
         
        //用户认证组件 正式环境要开启
//        'user'=>array(
//                'class'=>'system.components.user.CPtUser',
//                'login_type'=>0x04 //　限制强登陆
//        ),
//        passport
        'passport'=>array(
                'class'=>'system.components.roles.CWaePassport',
                //'ip'=>'172.25.39.75',
                //'port'=>'8801'
        ),
        //缓存配置
        'memcache'     => require(CONFIG_PATH.'/memcache.php'),
    
//        'cache'        => require(CONFIG_PATH.'/redis.php'),
//        'session'=>array(
////            'class'=>'CCacheHttpSession',
//            'Timeout'=>43200
//        ),
        
        'session' => array(
                'class' => 'CCacheHttpSession',
                'autoStart' => true,
                'cacheID' => 'memcache', // we only use the sessionCache to store the session
                'cookieMode' => 'only',
                'timeout' => 86400,
        ),
    ),
      
//    'defaultController'=>'Member/login',
    // application-level parameters that can be accessed
    // using Mod::app()->params['paramName']
   'params'=> require(dirname(__FILE__).DIRECTORY_SEPARATOR.'params.php'),
);