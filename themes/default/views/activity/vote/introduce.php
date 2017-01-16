<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="投票" />
    <meta name="description" content="投票" />
    <title>投票</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>vote/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>vote/js/zepto.js"></script>
    <script src="<?php echo $this->_theme_url; ?>vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main" style="background: #f6f7f7;">


    <div class="">
        <img src="<?php echo $this->_theme_url; ?>vote/images/vote-img1.jpg" width="100%" />
    </div>


    <div class="acdetails-div1">
        <h3 class="acdetails-tit">活动介绍</h3>
        <p><?php echo $desc?></p>

    </div>

    <div class="acdetails-div2">
        <h3 class="acdetails-tit">活动介绍</h3>

        <ul>
            <li><a href="">腾讯大楚网</a></li>
            <li><a href="">中邮保险</a></li>
            <li><a href="">中国邮政</a></li>
        </ul>

    </div>



    <div class="acdetails-div3">
        <h3 class="acdetails-tit">活动背景</h3>

        <p>“益暖中华”――谷歌杯中国大学生公益创意大赛是由谷歌（Google）发起，通过征集公益创意、资助获奖项目的形式，以促进社会公益事业发展、倡导大学生积极投身社会公益为目的的比赛。大赛将以大学生为主体，通过对他们公益创意的评选、优化、引导和资助，共同实现“创意改善社会，公益温暖中国”的主旨。</p>

    </div>

    <div class="acdetails-div4">

        <ul>
            <li><a href="<?php echo $this->createUrl('/activity/vote/view',array('id'=>$id,'pid'=>$pid))?>">我要投票</a></li>
            <li><a href="">看看别人</a></li>
        </ul>

    </div>




</div>



</body>
</html>





