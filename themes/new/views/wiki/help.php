<?php echo $this->renderpartial('/common/header_new', $config); ?>

<?php
//左边接口导航列表，顺序不能改变
$left_menu = array(
    array('title' => '注册后台,创建应用', 'url' => $this->createurl('wiki/index', array('p' => 0))),
    array('title' => '服务器接口开发', 'url' => $this->createurl('wiki/index', array('p' => 1))),
    array('title' => '活动组件集成', 'url' => $this->createurl('wiki/index', array('p' => 2))),
    array('title' => '积分商城', 'url' => $this->createurl('wiki/index', array('p' => 3))),
);

//以下数组是右边内容区  顺序不可以改变
$right_content = array(
    array(
        '访问大楚开放平台&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'" style="color:#0091d5">m.hb.qq.com</a>',
        '注册账号&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'/member/regone" style="color:#0091d5">访问</a>',
        '<a target="_blank" href="'.Mod::app()->request->hostInfo.'/project/createpro" style="color:#0091d5">创建</a>&nbsp;属于你的应用',
    ),
    array(
        '活动组件是h5网页，开发者可以快速将其集成到微信,PCAPP中，',
        '完成自己的营销目的．如想获得更多平台资源，',
        '可&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'/dachu/activity_sdk.zip" style="color:#0091d5">下载SDK</a>&nbsp;参考文档资料实践体验&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'/wiki/Article/id/4" style="color:#0091d5">使用说明</a>',
    ),
    array(
        '进行服务器端接口的开发&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'/wiki/Article/id/5" style="color:#0091d5">开发指南</a>',
        '自动登录并跳转组件链接&nbsp;<a target="_blank" href="'.Mod::app()->request->hostInfo.'/wiki/Article/id/4" style="color:#0091d5">范例</a>',
        '用户积分扣除<a target="_blank" href="'.Mod::app()->request->hostInfo.'/wiki/Article/id/6" style="color:#0091d5">&nbsp;接口&nbsp;&nbsp;</a>',
        '用户消息通知<a target="_blank" href="'.Mod::app()->request->hostInfo.'/wiki/Article/id/7" style="color:#0091d5">&nbsp;接口&nbsp;&nbsp;</a>',
    ),
    array(
        '积分商城为大楚平台用户运营兼福利平台,使用开放平台组件方可对接',
        '大楚用户用心产生的相应积分可以登录积分商城,便可享受联合营销福利兑换礼品',
        '<a target="_blank" href="'.Mod::app()->request->hostInfo.'/jfshop/b2c/wap/default/index" style="color:#0091d5">访问积分商城</a>'
    ),
);
?>
<div class="ad-app-list w1000 clearfix bxbg mgt30">
    <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-document.png"></i>
                <span>帮助中心</span>
            </div>
    </div>
    <!--tit end-->
    <div class="ad-faq-tips">
        简单几步，让你迅速了解大楚开放平台。
    </div>
    <div class="ad-faq-list">
        <ul>
            <?php $i = 1;foreach ($right_content as $key => $value) { ?>
                <li>
                   <!--  <div class="ad-faq-list-licon">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/ad-faq-iocn9.png" alt=""></span>
                    </div> -->
                    <div class="ad-faq-listdiv">
                        <h2><?php echo $left_menu[$key]['title'] ?></h2>
                        <div class="ad-faq-listtxt">
                            <i>
                                <img src="<?php echo $this->_theme_url; ?>assets/images/ad-faq-iocn<?php echo $i ?>.png" height="36" width="36" alt="">
                            </i>
                            <?php foreach ($value as $arr) { ?>
                                <p><?php echo $arr; ?></p>
                            <?php } ?>
                        </div>
                        <i class="leftsj"></i>
                        <i class="tnum tbg<?php echo $i;?>"><?php echo $i ?></i>
                    </div>
                </li>
            <?php $i++;} ?>
        </ul>
    </div>
</div>

<?php echo $this->renderpartial('/common/footer', $config); exit; ?>
<body style="background: #e3e3e3">
<div class="w1200 clearfix op-doc">
    <div class="fl op-doc-l">
        <div class="op-doc-lnav">
            <ul>
                <?php foreach ($left_menu as $k => $v) { ?>
                    <li class="selected">
                        <h3><?php echo $v['title'] ?><i></i></h3>
                        <p <?php if ($p == $k) {
                            echo 'style="display: block;"';
                        } ?>>
                            <a onclick="window.location.href='<?php echo $v['url']; ?>'">
                                <i></i>
                                接口说明
                            </a>
                        </p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!--left end-->
    <div class="op-doc-r">
        <div class="op-doc-rdiv">
            <div class="op-doc-rdiv-tit">
                <h2><?php echo $right_content[$p]['name'] ?></h2>
                <h3><?php echo $right_content[$p]['describe'] ?></h3>
            </div>

            <div class="op-doc-rdiv-con">
                <table class="table table-bordered" style="text-align: center">
                    <tr>
                        <th width="100px">功能</th>
                        <th width="100px">方法名</th>
                        <th width="300px">url</th>
                        <th width="150px">提交方式</th>
                        <th width="200px">参数</th>
                        <th width="600px">返回数据</th>
                    </tr>
                    <tr style="text-align: center">
                        <td><?php echo $right_content[$p]['name'] ?></td>
                        <td><?php echo $right_content[$p]['function'] ?></td>
                        <td><?php echo $right_content[$p]['url'] ?></td>
                        <td><?php echo $right_content[$p]['method'] ?></td>
                        <td><?php echo $right_content[$p]['parameter'] ?></td>
                        <td style="word-wrap:break-word;word-break:break-all;"><?php echo $right_content[$p]['return'] ?></td>
                    </tr>
                </table>
                <h3 class="title">示例</h3>
                <p><?php echo $right_content[$p]['case'] ?></p>
            </div>
        </div>
    </div>
</div>