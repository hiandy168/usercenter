<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/user.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js" type="text/javascript" charset="utf-8"></script>
</head>
<body class="" onload="msg()">
<!-- 导航栏 -->
<div class="m-nav">
    <div class="g-wrap">
        <ul class="m-nav-list">
            <li class="selected"><a href=""><span>个人中心<span></span></span></a></li>
        </ul>
    </div>
</div>
<div class="m-user" id="dvWrapper" style="padding-top:0px">
    <div class="m-user-index">
        <div class="m-user-summary">
            <img class="bg" src="http://mimg.127.net/p/yymobile/lib/img/user/summary_bg.png" width="100%" />
            <div class="info">
                <div class="m-user-avatar"> <img width="50" height="50"  src="<?php echo JkCms::show_img($this->member['headimgurl']) ?>" />
                </div>
                <div class="txt">
                    <div class="name"></div>
                    <div class="money">用户名：<span class="num"><?php echo $adList[0]['name']?></span></div>
                </div>
            </div>
            <a class="aside">
                <b class="ico-next"></b>
            </a>
        </div>
        <div class="m-user-bar">
            <a href="<?php echo $this->createUrl('/activity/duobao/mylog',array('uid'=> $adList[0]['id'],'pid'=>$pid))?>" class="w-bar">夺宝记录<span class="w-bar-ext"><b class="ico-next"></b></span></a>
            <a href="<?php echo $this->createUrl('/activity/duobao/myaward',array('uid'=>$adList[0]['id'],'pid'=>$pid))?>" class="w-bar">中奖纪录<span class="w-bar-ext"><b class="ico-next"></b></span></a>
            <a href="<?php echo $this->createUrl('/activity/duobao/myshai',array('uid'=>$adList[0]['id'],'pid'=>$pid))?>" class="w-bar">我要晒单<span class="w-bar-ext"><b class="ico-next"></b></span></a>
            <a href="<?php echo $this->createUrl('/activity/duobao/checkorder',array('uid'=>$adList[0]['id'],'pid'=>$pid))?>" class="w-bar">购物车<span class="w-bar-ext"><b class="ico-next"></b></span></a>
            <a href="<?php echo $this->createUrl('/activity/duobao/myaddress',array('uid'=>$this->member['id'],'pid'=>$pid))?>" class="w-bar">收货地址<span class="w-bar-ext"><b class="ico-next"></b></span></a>
            <a href="<?php echo $this->createUrl('/activity/duobao/clause',array('uid'=>$adList[0]['id'],'pid'=>$pid))?>" class="w-bar">游戏说明<span class="w-bar-ext"><b class="ico-next"></b></span></a>
        </div>
        <div class="m-user-bar">
        </div>
    </div>
    <div class="m-user-duobaoRecord" id="duobaoRcd_dvWrapper" style="display:none;"></div>
    <div class="m-user-duobaoRecord" id="win_dvWrapper" style="display:none;"></div>
    <div class="m-user-shareList" id="share_dvWrapper" style="display:none;"></div>
    <div class="m-user-wishList" id="wish_dvWrapper" style="display:none;"></div>
</div>
</body>
<script>
    function msg() {
        $.ajax({
            "type": "post",
            "url": "",
            "data": {
                "id": 1
            },
            "dataType": "json",
            "success": function(data) {
                if (data.success) {





                } else {

                }
            }
        });


    }
</script>

<!--转发js-->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: '',
        timestamp: '',
        nonceStr: '',
        signature: '',
        jsApiList: [
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'onMenuShareQQ',
        ]
    });
    wx.ready(function() {
        wx.onMenuShareAppMessage({
            title: "",
            desc: "",
            link: "http://wqcs.dachuw.net/app/./index.php?i=29&c=entry&do=list&m=duobao_gz",
            imgUrl: "http://wqcs.dachuw.net/attachment/",
            trigger: function(res) {
                //alert('用户点击发送给朋友');
            },
            success: function(res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function(res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function(res) {
                alert(JSON.stringify(res)); //失败回调
            }
        });
        wx.onMenuShareTimeline({
            title: "",
            desc: "",
            link: "http://wqcs.dachuw.net/app/./index.php?i=29&c=entry&do=list&m=duobao_gz",
            imgUrl: "http://wqcs.dachuw.net/attachment/",
            trigger: function(res) {
                //alert('用户点击发送给朋友');
            },
            success: function(res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function(res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function(res) {
                alert(JSON.stringify(res)); //失败回调
            }
        });
        wx.onMenuShareQQ({
            title: "",
            desc: "",
            link: "http://wqcs.dachuw.net/app/./index.php?i=29&c=entry&do=list&m=duobao_gz",
            imgUrl: "http://wqcs.dachuw.net/attachment/",
            trigger: function(res) {
                //alert('用户点击发送给朋友');
            },
            success: function(res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function(res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function(res) {
                alert(JSON.stringify(res)); //失败回调
            }
        });




    });
</script>

</html>
