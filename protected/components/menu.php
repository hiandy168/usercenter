<?php
 $menu = array(
     'notice'=>array(
        'title'=>'首页',
         'children'=>array(
                 array('title'=>'后台首页','url'=>'notice'),
         )
    ), 
     'management'=>array(
         'title'=>'积分管理',
         'children'=>array(
             array('title'=>'管理列表','url'=>'management/list'),
             array('title'=>'积分记录','url'=>'management/jilu'),

         )
     ),


    'activity' => array(
        'title' => '活动组件',
         'menu'=>'true',//是否是多级菜单 一定要加啊 不然报错
         'children'=>array(
             array('title'=>'活动项目管理', 'children'=>array(
                 array('title'=>'项目列表','url'=>'activity/projectlist'),
             )),
             array('title'=>'活动管理', 'children'=>array(
                array('title'=>'活动列表','url'=>'activity/list'),
                array('title'=>'推荐列表','url'=>'activity/RecommendedList'),
             )),
             array('title'=>'组件管理', 'children'=>array(
                array('title'=>'组件分类','url'=>'activity/ClassList'),
                array('title'=>'组件管理列表','url'=>'activity/activityList'),
             )),
             array('title'=>'标签管理', 'children'=>array(
                 array('title'=>'应用分类','url'=>'activity/alctionClass'),
                 array('title'=>'标签列表','url'=>'activity/alctionTag'),
             )),
         )
    ),

    'category'=>array(
        'title'=>'栏目管理',
         'children'=>array(
             array('title'=>'栏目管理','url'=>'category'),
             array('title'=>'模块管理','url'=>'model'),
         )
    ),

  'content'=>array(
        'title'=>'内容文章模块',
        'menu'=>'true',//是否是多级菜单 一定要加啊 不然报错
         'children'=>array(
             array('title'=>'栏目分类', 'children'=>array(
                        array('title'=>'栏目分类管理','url'=>'category/index/model/article'),
             )),
             array('title'=>'内容管理', 'children'=>array(
                        array('title'=>'文章管理','url'=>'article'),
                        array('title'=>'帮助中心','url'=>'help'),
                        array('title'=>'单页管理','url'=>'page'),
//                       array('title'=>'碎片管理','url'=>'fragment'),
//                       array('title'=>'用户消息','url'=>'message'),
//                       array('title'=>'网站地图','url'=>'map'),
//                       array('title'=>'产品管理','url'=>'product'),
//                       array('title'=>'产品规格','url'=>'spec'),
//                       array('title'=>'模块管理','url'=>'model'),
//                       array('title'=>'图片管理','url'=>'pic'),
             )),
         )
    ), 

//    'attachment'=>array(
//        'title'=>'素材管理',
//         'children'=>array(
//             array('title'=>'素材管理','url'=>'attachment'),
//             array('title'=>'上传图片','url'=>'attachment/add'),
//             array('title'=>'上传视频','url'=>'attachment/add'),
//         )
//    ),
    'other' => array(
        'title' => '广告链接',
        'children' => array(
            array('title' => '导航管理', 'url' => 'nav'),
            array('title' => '幻灯片管理', 'url' => 'slider'),
            array('title' => '广告管理', 'url' => 'ads'),
            array('title' => '友情链接', 'url' => 'friendlink'),
            array('title' => '分类管理', 'url' => 'type'),
        )
    ),

    'member' => array(
        'title' => '会员中心',
        'menu'=>'true',//是否是多级菜单 一定要加啊 不然报错
        'children' => array(
             array('title'=>'用户管理', 'children'=>array(
                  array('title' => '会员分组', 'url' => 'membergroup'),
                  array('title' => '会员管理', 'url' => 'member'),
             )),
             array('title'=>'平台用户', 'children'=>array(
                array('title' => '平台用户', 'url' => 'member/pclists'),
             )),
            array('title'=>'用户来源列表', 'children'=>array(
                array('title' => '用户来源列表', 'url' => 'member/fromlists'),
            )),
            array('title'=>'大楚通行证登录管理', 'children'=>array(
                array('title' => '列表管理', 'url' => 'member/ssolist'),
                array('title' => '添加', 'url' => 'member/ssoadd'),
            )),
          
        )
    ),


    'user' => array(
        'title' => '用户中心',
        'children' => array(
            array('title' => '用户管理', 'url' => 'user'),
            array('title' => '用户分组', 'url' => 'usergroup'),
            array('title' => '权限管理', 'url' => 'permission'),
            array('title' => '个人中心', 'url' => 'personal/info'),
            array('title' => '密码修改', 'url' => 'personal/password'),
        )
    ),

    'system' => array(
        'title' => '系统全局',
        'children' => array(
            array('title' => '站点设置', 'url' => 'setting'),
//             array('title'=>'语言管理','url'=>'lang'),
            array('title' => '数据库管理', 'url' => 'db'),
            array('title' => '缓存管理', 'url' => 'cacher'),
        )
    ),

    'citylife' => array(
        'title' => '城市服务',
        'children' => array(
            array('title' => '城市服务管理', 'url' => 'citylife'),
            array('title' => '城市服务分类', 'url' => 'citylife/cateList'),
        )
    ),

    'message' => array(
        'title' => '站内信',
        'children' => array(
            array('title' => '发送短信', 'url' => 'sendmsg/index'),
            array('title' => '短信列表', 'url' => 'sendmsg/sendlist'),
        )
    ),

);

?>