<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="<?php echo $info['title']?>" />
    <meta name="description" content="<?php echo $info['title']?>" />
    <title>我的报名</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css?vdassdaddss"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main">


    <div class="vote-main" >
        <div class="pos-r vote-hd-rankdiv1">
            <h3 class="tit">我的报名</h3>
            <img src="<?php echo JkCms::show_img($vote['img']); ?>" width="100%" />
            <div class="pos-a linear-bg"></div>
        </div>


        <?php if(!empty($mylist)){?>
        <div class="vote-myvote-list clearfix">
            <ul>
                <?php foreach ($mylist as $k=>$v){?>
                    <a href="<?php echo $this->createUrl('/activity/vote/signup/', array('id' => $v['vote']->id));?>">
                    <li class="clearfix bsd1">
                        <span class="fl"><img src="<?php echo JkCms::show_img($v['vote']->img) ?>" /></span>

                        <span class="">
                            <p class="fs24">活动标题：<?php echo $v->vote->title ?></p>
                            <p class="fs24">报名名称：<?php echo $v->title ?></p>
                            <p class="fs24">报名时间：<?php echo date("Y-m-d H:i",$v->create_time) ?></p>
                            <p class="fs24">报名电话：<b><?php echo $v->phone?></b></p>
                        </span>
                    </li>
                    </a>
                <?php } ?>
            </ul>

        </div>
        <?php }else{?>

            <div class="mgrl10 fs30 bsd1" style="margin-top: -1rem; background: #FFFFFF;overflow: hidden;text-align: center;border-radius: .2rem;padding: 2rem 0rem;color: #259AFF;position: relative;">^_^<br/><br/>暂无数据</div>

        <?php }?>


    </div>



</div>
</body>
</html>
