<?php
$menu = array(
    'notice'=>array(
        'title'=>'首页',
        'children'=>array(
            array('title'=>'后台首页','url'=>'notice'),
        )
    ),

    'houseactiviy' => array(
        'title' => '活动管理',
        'children' => array(
            array('title' => '活动列表', 'url' => 'hactivity/list'),
            array('title' => '新增活动', 'url' => 'hactivity/add'),
        )
    ),
    'housemoney' => array(
        'title' => '理财管理',
        'children' => array(
            array('title' => '理财列表', 'url' => 'hmoney/list'),
            array('title' => '新增理财', 'url' => 'hmoney/add'),
        )
    ),
    'housemember' => array(
        'title' => '用户订单管理',
        'children' => array(
            array('title' => '用户列表', 'url' => 'hmember/list'),
          /*  array('title' => '新增用户', 'url' => 'hmember/add'),*/
        )
    ),
    'housetenant' => array(
        'title' => '商户管理',
        'children' => array(
            array('title' => '商户列表', 'url' => 'htenant/list'),
          /*  array('title' => '新增商户', 'url' => 'htenant/add'),*/
        )
    ),
  /*  'houseorder' => array(
        'title' => '订单管理',
        'children' => array(
            array('title' => '订单列表', 'url' => 'horder/list'),
        )
    ),*/

   /* 'activity' => array(
        'title' => '活动组件',
        'menu'=>'true',//是否是多级菜单 一定要加啊 不然报错
        'children'=>array(
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
    ),*/

    /*'member' => array(
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
    ),*/

);

?>