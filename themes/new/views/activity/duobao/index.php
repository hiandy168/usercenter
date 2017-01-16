<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title>{$_W['account']['name']}</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
    <meta http-equiv="Expires" CONTENT="0">

    <meta http-equiv="Cache-Control" CONTENT="no-cache">

    <meta http-equiv="Pragma" CONTENT="no-cache">
    <script src="<?php echo $this->_theme_url;?>assets/subassembly/duobao/jquery-1.11.1.min.js"></script>
    <script language="javascript" src="<?php echo $this->_theme_url;?>assets/subassembly/duobao/touchslider.min.js"></script>
    <script language="javascript" src="<?php echo $this->_theme_url;?>assets/subassembly/duobao/swipe.js"></script>
    <script language='javascript' src='<?php echo $this->_theme_url;?>assets/subassembly/duobao/simple-inheritance.min.js'></script>
    <script language='javascript' src='<?php echo $this->_theme_url;?>assets/subassembly/duobao/photoswipe-1.0.11.min.js'></script>
    <link href="<?php echo $this->_theme_url;?>assets/subassembly/duobao/photoswipe.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo $this->_theme_url;?>assets/subassembly/duobao/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url;?>assets/subassembly/duobao/index.css">

</head>
<body >
<div class="g-header">

    <!-- 导航栏 -->
    <div class="m-nav">
        <div class="g-wrap">
            <ul class="m-nav-list">
                <li class="selected"><a href="{php echo $this->createMobileUrl('list')}"><span>首页<span></span></span></a></li>
                <li><a href="{php echo $this->createMobileUrl('list2')}"><span>全部商品<span></span></span></a></li>
                <li><a href="{php echo $this->createMobileUrl('shai_view')}"><span>晒单<span></span></span></a></li>
                <li><a href="{php echo $this->createMobileUrl('home')}"><span>个人中心<span></span></span></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="g-body">

    <div class="m-index">
        <div id="banner_box" class="box_swipe">
            <ul style="background:#FFF;" data-ad="{$piclist}">
                <?php
                foreach($msgList as $msg){
                ?>

                <li style="text-align:center;list-style: none;">
                    <a href="<?php echo $msg['id'];?>" rel="<?php echo $msg['id'];?>">
                        <img src="<?php echo Mod::app()->createAbsoluteUrl("") . (empty($msg['thumb']) ? '' : $msg['thumb']); ?>" height="200px" style="text-align: -webkit-center;display: -webkit-inline-box;"/>
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
            <ol>
                {loop $piclist $row}
                <li class="on"></li>
                {/loop}
            </ol>
        </div>








        <script>
            var proimg_count = {php echo count($piclist)};
            $(function () {
                new Swipe($('#banner_box')[0], {
                    speed: 500,
                    auto: 3000,
                    callback: function () {
                        var lis = $(this.element).next("ol").children();
                        lis.removeClass("on").eq(this.index).addClass("on");
                    }
                });
                if (proimg_count > 0) {
                    (function (window, $, PhotoSwipe) {
                        //   $('#banner_box ul li a[rel]').photoSwipe({});
                    }(window, window.jQuery, window.Code.PhotoSwipe));
                }
            });
        </script>


        <div class="g-wrap g-body-bd">
            <input type="hidden" id="Ntime" value="111">
            {if !empty($countdown)}
            <div class="m-index-mod m-index-reveal">
                <div class="m-index-mod-hd">
                    <h3>最新揭晓</h3>
                </div>
                <div class="m-index-mod-bd">
                    <ul class="m-index-reveal-list w-goodsList-brief" data-pro="entry" id="pro-view-3">
                        {loop $countdown $asdf}
                        <li class="w-goodsList-item" id="pro-view-4">
                            <div class="w-goods w-goods-brief">
                                <div class="w-goods-pic">
                                    <a href="{php echo $this->createMobileUrl('detail', array('id' => $asdf['id']))}">
                                        <img onerror="this.srcthis.src../addons/hc_zhongchou/style/img/m.png'" src="{$_W['attachurl']}{$asdf['thumb']}" alt="{$asdf['title']}" class="">
                                    </a>
                                </div>
                                <div class="w-countdown" data-pro="countdownWrap">
                                    <span class="w-countdown-title" id="t_re{$asdf['id']}">倒计时</span>
								<span data-pro="countdown" data-time="358188" class="w-countdown-nums remove{$asdf['id']}" id="remove{$asdf['id']}">
									<span id="t_d{$asdf['id']}">00天</span>
									<span id="t_h{$asdf['id']}">00时</span>
									<span id="t_m{$asdf['id']}">00分</span>
									<span id="t_s{$asdf['id']}">00秒</span>
								</span>
                                </div>
                                <div class="w-countWaiting" data-pro="countdownWaiting" style="display:none">正在计算...</div>
                            </div>
                        </li>
                        {/loop}
                    </ul>
                </div>
            </div>
            {/if}

            <script>
                gettime();
                function gettime(){
                    var temptime;
                    $.ajax({
                        "type": "post",
                        "url": "{php echo $this->createMobileUrl('get_time',array('op' => 'ajax'),true)}",
                        // "data": {"id": {$asdf['id']}},
                        "dataType": "json",
                        "async": "false",
                        "success": function(data){
                            if(data.success){
                                if(data.error == 'error'){
                                }else{
                                    temptime = data.time;
                                    console.log(11111);
                                    console.log(temptime);
                                    $('#Ntime').val(temptime);
                                    //test2(temptime);
                                    return temptime
                                }
                            }else{
                                // alert('操作失败，可能是网络有问题');
                            }
                        }
                    });
                    console.log(2342);console.log(temptime);
                    return temptime;

                }








            </script>


            <script>

            </script>

            {if !empty($countdown)}
            {loop $countdown $asdf}
            <script>
                var Ntime = $('#Ntime').val();
                var NowTime = 0;
                var NowTime = {php echo TIMESTAMP};
                if(Ntime !=111){
                    NowTime = Ntime;
                }

                //alert(NowTime);
                var loop{$asdf['id']} = setInterval(GetRTime,1000);
                var NowTime{$asdf['id']} =	NowTime * 1000 - 2000;

                function GetRTime(){
                    var EndTime= {php echo $asdf['ticket_time'] + $setting['countdown'] *60 };
                    //var NowTime = new Date();
                    NowTime{$asdf['id']} = NowTime{$asdf['id']} + 1000;
                    var t =EndTime*1000 - NowTime{$asdf['id']};
                    var d=Math.floor(t/1000/60/60/24);
                    var h=Math.floor(t/1000/60/60%24);
                    var m=Math.floor(t/1000/60%60);
                    var s=Math.floor(t/1000%60);

                    if(EndTime*1000 <= NowTime{$asdf['id']}){
                        //console.log(EndTime);console.log(NowTime{$asdf['id']});
                        window.clearInterval(loop{$asdf['id']});

                        $.ajax({
                            "type": "post",
                            "url": "{php echo $this->createMobileUrl('countdown_query',array('op' => 'ajax'),true)}",
                            "data": {"id": {$asdf['id']}},
                            "dataType": "json",
                            "success": function(data){
                                if(data.success){
                                    if(data.error == 'error'){
                                        alert(data.message);
                                    }else{
                                        var nickname = data.nickname;
                                        $("#remove{$asdf['id']}").remove();
                                        document.getElementById("t_re{$asdf['id']}").innerHTML = "中奖人："+ nickname;

                                    }
                                }else{
                                    alert('操作失败，可能是网络有问题');
                                }
                            }
                        });





                    }
                    if(d>=0 && h>=0 && m>=0 && s>=0){
                        document.getElementById("t_d{$asdf['id']}").innerHTML = d + "天";
                        document.getElementById("t_h{$asdf['id']}").innerHTML = h + "时";
                        document.getElementById("t_m{$asdf['id']}").innerHTML = m + "分";
                        document.getElementById("t_s{$asdf['id']}").innerHTML = s + "秒";

                    }



                }




            </script>
            {/loop}
            {/if}
















            <div class="m-index-mod m-index-newArrivals">
                <div class="m-index-mod-hd">
                    <h3>上架新品</h3>
                    <a href="{php echo $this->createMobileUrl('list2',array('isnew'=>1))}" class="m-index-mod-more">更多</a>
                </div>
                <div class="m-index-mod-bd">
                    <ul class="w-goodsList w-goodsList-brief m-index-newArrivals-list">
                        {loop $rhot $hot}
                        <li class="w-goodsList-item">
                            <div class="w-goods w-goods-brief">
                                <div class="w-goods-pic">
                                    <a title="{$hot['title']}" href="{php echo $this->createMobileUrl('detail', array('id' => $hot['id']))}">
                                        <img onerror="this.srcthis.src../addons/hc_zhongchou/style/img/m.png'" src="{$_W['attachurl']}{$hot['thumb']}" alt="{$hot['title']}" class="">
                                    </a>
                                </div>
                                <p class="w-goods-title f-txtabb"><a href="{php echo $this->createMobileUrl('detail', array('id' => $list['id']))}" title="{$hot['title']}"><!-- {if !empty($hot['qi'])}(第{$hot['qi']}期){/if} -->{$hot['title']}</a></p>
                            </div>
                            {/loop}
                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-index-mod m-index-popular">
                <div class="m-index-mod-hd">
                    <h3>今日热门商品</h3>
                    <a href="{php echo $this->createMobileUrl('list2',array('ishot'=>1))}" class="m-index-mod-more">更多</a>
                </div>
                <div class="m-index-mod-bd">
                    <ul class="w-goodsList w-goodsList-s m-index-popular-list" id="content">
                        {loop $rlist $list}
                        <li class="w-goodsList-item">
                            {if $list['isten'] == 1}
                            <i class="ico ico-label ico-label-ten"></i>
                            {/if}
                            {if $list['isfive'] == 1}

                            <i class="ico ico-label ico-label-five"></i>
                            {/if}
                            <div data-buyunit="1" data-price="6088" data-period="16418" data-gid="148" class="w-goods w-goods-ing">
                                <div class="w-goods-pic">
                                    <a href="{php echo $this->createMobileUrl('detail', array('id' => $list['id']))}">
                                        <img onerror="this.src../addons/hc_zhongchou/style/img/m.png'" src="	{$_W['attachurl']}{$list['thumb']}" alt="{$list['title']}" class="">
                                    </a>
                                </div>
                                <div class="w-goods-info">
                                    <p class="w-goods-title f-txtabb"><a href="{php echo $this->createMobileUrl('detail', array('id' => $list['id']))}"><!-- {if !empty($list['qi'])}(第{$list['qi']}期){/if} -->{$list['title']}</a></p>
                                    <p class="w-goods-price">总需：{$list['total']} 人次</p>
                                    <div class="w-progressBar">
                                        <p class="wrap">
                                            <span style="width:{php echo round($list['ticket_total']*100/$list['total'],2) }%;" class="bar"><i class="color"></i></span>
                                        </p>
                                        <ul class="txt">
                                            <li class="txt-l"><p><b>{$list['ticket_total']}</b>已参与</p></li>
                                            <li class="txt-r"><p>剩余<b class="txt-blue">{php echo $list['total'] - $list['ticket_total']}</b></p></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {/loop}
                    </ul>

                    <div class="w-more">
                        <a href="{php echo $this->createMobileUrl('list')}" style="height:5%">点击查看更多商品</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="g-footer">
    <div class="g-wrap">
        <ul class="m-state f-clear">
            <li><i class="ico ico-state ico-state-1"></i>公平公正公开</li>
            <li><i class="ico ico-state ico-state-2"></i>正品保证</li>
            <li class="last"><i class="ico ico-state ico-state-3"></i>权益保障</li>
        </ul>
        <p class="m-link">
            <a href="{php echo $this->createMobileUrl('clause')}">点击查看游戏说明</a>
        </p>
        <p>活动最终解释权归大楚网所有</p>
    </div>
</div>
<input type="hidden" name="page" value="0">

<button style="display: none;" class="w-button w-button-round w-button-backToTop" id="pro-view-0">返回顶部</button>
<a onclick="header()" class="w-miniCart" id="pro-view-1"><span class="w-miniCart-text">清单</span><i class="ico ico-miniCart"></i><b style="display:none" data-pro="count" class="w-miniCart-count">0</b></a>

<!--下拉加载-->
<script type="text/javascript">
    $(document).ready(function(){
        var range = 0;             //距下边界长度/单位px
        var elemt = 500;           //插入元素高度/单位px
        var maxnum = 20;            //设置加载最多次数
        var num = 1;
        var totalheight = 0;
        var main = $("#content");                     //主体元素
        $(window).scroll(function(){
            var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)

            //console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());
            //console.log("页面的文档高度 ："+$(document).height());
            //console.log('浏览器的高度：'+$(window).height());
            //页面的文档高度-距下边界长度 <= 浏览器高度 + 滚动条距顶部距离（页面超出窗口的高度）
            totalheight = parseFloat($(window).height()) + parseFloat(srollPos);
            if(($(document).height()-range) == totalheight  && num != maxnum) {







            }
        });
    });
</script>


<script>
    function header(){
        var url = "{php echo $this->createMobileUrl('check_order')}";
        location.href = url;
    }
</script>

<!--转发js-->
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
{php $signPackage=$_W['account'][jssdkconfig];}
{php $setting=$this->module['config'];}
<script type="text/javascript">
    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: '<?php echo $signPackage["timestamp"];?>',
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
            'onMenuShareAppMessage',
            'onMenuShareTimeline',
            'onMenuShareQQ',
        ]
    });
    wx.ready(function () {
        wx.onMenuShareAppMessage({
            title: "{$setting['zhuanfa_title']}",
            desc: "{$setting['zhuanfa_content']}",
            link: "{php echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)}",
            imgUrl: "{php echo $_W['attachurl'].$setting['zhuanfa_img']}",
            trigger: function (res) {
                //alert('用户点击发送给朋友');
            },
            success: function (res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function (res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function (res) {
                alert(JSON.stringify(res));//失败回调
            }
        });
        wx.onMenuShareTimeline({
            title: "{$setting['zhuanfa_title']}",
            desc: "{$setting['zhuanfa_content']}",
            link: "{php echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)}",
            imgUrl: "{php echo $_W['attachurl'].$setting['zhuanfa_img']}",
            trigger: function (res) {
                //alert('用户点击发送给朋友');
            },
            success: function (res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function (res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function (res) {
                alert(JSON.stringify(res));//失败回调
            }
        });
        wx.onMenuShareQQ({
            title: "{$setting['zhuanfa_title']}",
            desc: "{$setting['zhuanfa_content']}",
            link: "{php echo $_W['siteroot'].'app/'.$this->createMobileUrl('list',array(),true)}",
            imgUrl: "{php echo $_W['attachurl'].$setting['zhuanfa_img']}",
            trigger: function (res) {
                //alert('用户点击发送给朋友');
            },
            success: function (res) {
                //window.location.href =adurl;//分享成功回调
            },
            cancel: function (res) {
                //window.location.href =adurl;//取消回调
            },
            fail: function (res) {
                alert(JSON.stringify(res));//失败回调
            }
        });
    });
</script>
</body></html>