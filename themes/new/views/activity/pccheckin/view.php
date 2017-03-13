<?php
/*
 * 这里通过用户的openid获取用户的信息，如果有直接将用户的信息填入表单，如果没又则需要用户自己填
 */
$pid = $pid; //服务器传过来的应用id,直接使用
$openid = $param['openid'];//微信开实时获取用户的openid
$mid = $param['mid'];
$count = Activity_pccheckin_user::getcheckinnum($mid, $id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <title><?php echo $config['site_title'] ?></title>
    <meta name="Keywords" content="<?php echo $config['Keywords'] ?>"/>
    <meta name="Description" content="<?php echo $config['Description'] ?>"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/js/layout.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/js/jquery-1.12.0.min.js"
            type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js"></script>

    <script type="text/javascript">
        openid = "<?php echo $param['openid']?>";
        id = "<?php echo $id ?>";
        token = "<?php echo $param['token']?>";
        backUrl = "<?php echo $param['backUrl']?>";
        mid = "<?php echo $param['mid'] ?>";
        //table = "activity_pccheckin";
        table = "pccheckin";
    </script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js" type="text/javascript"
            charset="utf-8"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/h5/login/css/login1.css"/>
</head>
<body>


<div class="signin-mask"></div>
<div class="signin-pop">
    <div class="signin-popinfo">
        <img class="txtimg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img5.png"/>
        <img class="t-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img2.png"
             width="100%"/>
        <div class="signin-poptxt">
						<span>
							<img
                                src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img7.png"/>
							<i>您已成功签到，请明日再来！</i>
						</span>

            <?php if ($explorer != 1) { ?>
                <a href="<?php echo $this->_siteUrl; ?>/h5/member/index">个人中心</a>
                <a href="<?php echo $this->_siteUrl; ?>/jfshop/b2c/wap/default/index" style="margin-left: 3%;">积分商城</a>
            <?php } ?>
        </div>
        <img class="b-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img4.png"
             width="100%"/>
    </div>
    <?php if ($explorer == 1) { ?>
        <div class="pcclose">
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-closebtn.png"/>
        </div>
    <?php } ?>
</div>


<div class="div-main"
     style="    background: url(<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-bg.jpg) #fff no-repeat fixed top center;background-size: cover; overflow: hidden;">

    <input type="hidden" name="openid" id="openid" value="<?php echo $openid; ?>"/>
    <div class="signin-div1">
        <img class="bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img1.png"
             width="100%"/>

        <div class="signin-div1-info">

            <div class="signin-div1-day">
                第<i id="dayNum"><?php echo $count; ?></i>天
            </div>

            <span>签到时间 ：<i><?php echo date('Y年m月d日 H时i分s秒', $pccheckin['start_time']) == "00:00:00" ? date("Y年m月d日", $pccheckin['start_time']) : date("Y年m月d日", $pccheckin['start_time']) ?>
                    至 <?php echo date("Y年m月d日 H时i分s秒", $pccheckin['end_time']) == "00:00:00" ? date("Y年m月d日", $pccheckin['end_time'] - 1) : date("Y年m月d日", $pccheckin['end_time']) ?></i></span>
        </div>
    </div>

    <!--1 end-->


    <div class="signin-div2">

        <img class="t-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img2.png"
             width="100%"/>
        <a>
            <div class="signin-div2-1">
                <img src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img7.png"/>
					<span>
						<h4>签到详情</h4>
						<p><?php echo $pccheckin['desc'] ?></p>
					</span>
                <i></i>

            </div>
        </a>

        <img class="b-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img4.png"
             width="100%"/>

    </div>

    <!--2 end-->


    <div class="signin-div2 signin-div3">

        <img class="t-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img2.png"
             width="100%"/>

        <div class="signin-div3-1">

            <?php if ($pccheckin['status'] == "活动已经结束") { ?>
                <a href="javascript:void(0)" onclick="checkinBtn(2)">
                    <i class="icon-note"></i>
                    活动已经结束
                </a>
            <?php } elseif ($pccheckin['status'] == "活动未开始") { ?>
                <a href="javascript:void(0)" onclick="checkinBtn(3)">
                    <i class="icon-note"></i>
                    活动未开始
                </a>
            <?php } elseif ($pccheckin['status'] == 1) { ?>
                <?php if ($param['is_pccheck']) { ?>
                    <a href="javascript:void(0)" onclick="checkinBtn(4)">
                        <i class="icon-note"></i>
                        已签到
                    </a>
                <?php } else { ?>
                    <a href="javascript:void(0)" onclick="checkinBtn(1)">
                        <i class="icon-note"></i>
                        马上签到
                    </a>
                <?php }
            } ?>
        </div>
        <img class="b-bg" src="<?php echo $this->_theme_url; ?>assets/subassembly/pccheckin/images/signin-img4.png"
             width="100%"/>
    </div>


</div>

<script type="text/javascript">

    <?php
    if(!$param['mid']){?>
    showlogin();
    $("#winlogin").hide();
    <?php } ?>

    function showpop(t, k) {
        $(".signin-mask").show();
        $(".signin-pop").show().addClass("active-pop");
        if (k == 1) {
            $(".txtimg").show();
            $(".signin-poptxt span i").html(t)
        }
        if (k == 2) {
            $(".txtimg").hide();
            $(".signin-poptxt span i").html(t)
        }
    }

    $(function () {
        $(".signin-mask,.pcclose").on("click", function () {
            $(".signin-pop").hide().removeClass("active-pop");
            $(".signin-mask").hide();
        })

        $(".signin-div2-1").on("click", function () {
            if ($(this).hasClass('flag')) {
                $(this).removeClass('flag');
                $(this).find('p').css({
                    height: '20px'
                });
            } else {
                $(this).addClass('flag');
                $(this).find('p').css({
                    height: 'auto'
                });
            }
        })
    })

    function checkinBtn(k) {
        <?php
        if(!$param['mid']){?>
        showloginssss();
        return false;
        <?php } ?>
        if (k == 1) {
            $.ajax({
                type: "post",
                cache: !1,
                async: !1,
                data: {
                    openid: openid,
                    pid: '<?php echo $id; ?>',
                    mid: "<?php echo $param['mid']; ?>"
                },
                url: "<?php echo $this->createUrl('/activity/pccheckin/AddUser')?>",
                dataType: "json",
                beforeSend: function () {
                    layer.load(1);
                },
                success: function (data) {
                    layer.closeAll('loading');
                    if (data.code == 1) {
                        $(".signin-div3-1 a").html('<i class="icon-note"></i> 已签到');
                        var daynum = parseInt($("#dayNum").text());
                        $("#dayNum").text((daynum + 1))
                        showpop('恭喜，签到成功', 1);
                    } else if (data.code == 2) {
                        showpop('今天已签到，明天再来吧', 2);
                    } else {
                        showpop('签到失败', 2);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.closeAll('loading');
                    showpop('服务器异常请检查网络', 2);

                }
            })

        }
        if (k == 2) {
            showpop('活动已经结束', 2);
        }
        if (k == 3) {
            showpop('活动未开始', 2);
        }
        if (k == 4) {
            showpop('今天已签到，明天再来吧', 2);
        }

    }
</script>

<script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js?v=dasd" type="text/javascript"
        charset="utf-8"></script>
<?php

    if($pccheckin['share_url']){
        $url=$pccheckin['share_url'];
    }else{
        $url=$this->createUrl('/activity/pccheckin/view', array('id' => $id));
    }
    echo $this->renderpartial('/common/wxshare', array('signPackage' => $signPackage, 'info' => $pccheckin, 'url' =>$url ));
 ?>
</body>
</html>
