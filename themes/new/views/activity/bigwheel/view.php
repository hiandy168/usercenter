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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/css/style.css?v201568asdas61269"/>
</head>
<body>

<div id="loaddiv" class="loading-div">
    <span>
        <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/loading.gif"/>
        <i>努力加载中...</i>
    </span>
</div>

<div class="mask"></div>

<div class="dial-pop">

    <div class="dial-popmain">

        <div class="popbg">
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img3.png"
                 width="100%"/>
        </div>
        <div style="display: none" class="dial-poptuletxt"><p
                style="max-height: 14rem;overflow: scroll;"><?php echo $info['rule'] ?></p></div>
        <div class="poptxt">
            <div class="dial-poptxt">
                <p><br/>
                    <em>加载中...</em>
                </p>
            </div>
        </div>

        <div class="confirmbtnall">
            <div class="confirmbtn">
                <img
                    src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-confirmbtn.png"
                    width="100%"/>
            </div>
        </div>

    </div>

</div>


<div class="div-main">
    <div class="">
        <!--banner-->
        <?php if ($images->biaoyu) { ?>
            <img src="<?php echo JkCms::show_img($images->biaoyu); ?>" width="100%"/>
        <?php } else { ?>
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-bg1.jpg"
                 width="100%"/>
        <?php } ?>
        <!-- end banner-->
    </div>
    <div class="pos-r dial-div1">
        <!--转盘背景图片-->
        <?php if ($images->background) { ?>
            <img src="<?php echo JkCms::show_img($images->background); ?>" width="100%"/>
        <?php } else { ?>
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-bg2.jpg"
                 width="100%"/>
        <?php } ?>
        <!--转盘背景图片-->
        <div class="dial-zp">
            <!--转盘图片-->
            <?php if ($images->rotaryfive) { ?>
                <img src="<?php echo JkCms::show_img($images->rotaryfive); ?>" width="100%"/>
            <?php } else { ?>

                <img class="dial-zp1" id="lotteryBg"
                     src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img1_<?php echo $countprize ?>.png"/>
            <?php } ?>
            <!--end 转盘图片-->
            <!--指针图片-->
            <?php if ($images->pointer) { ?>
                <img src="<?php echo JkCms::show_img($images->pointer); ?>" width="100%"/>
            <?php } else { ?>
                <img class="dial-zp2" id="lotteryBtn"
                     src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img2.png"/>
            <?php } ?>
            <!-- end 指针图片-->
        </div>
    </div>
    <div class="pos-r dial-div2">
        <!--底部背景图片-->
        <?php if ($images->bootmbackground) { ?>
            <img src="<?php echo JkCms::show_img($images->bootmbackground); ?>" width="100%"/>
        <?php } else { ?>
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-bg3.jpg"
                 width="100%"/>
        <?php } ?>
        <!--end 底部背景图片-->
        <!--中奖纪录按钮-->
        <?php if ($images->recordbutton) { ?>
            <img src="<?php echo JkCms::show_img($images->recordbutton); ?>" width="100%"/>
        <?php } else { ?>
            <img class="dial-logbtn"
                 src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-logbtn.png"/>
        <?php } ?>
        <!--end 中奖纪录按钮-->

        <div class="dial-zjlist">
            <ul>
                <?php foreach ($prize as $k => $v): ?>
                    <li><?php echo $v['title'] ?>:<?php echo $v['name'] ?><?php if ($info['prize_number'] == 1) {
                            echo "：" . $v['count'] . "名";
                        } ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="javascript:void(0)">
            <!--活动规则按钮-->
            <?php if ($images->rules) { ?>
                <img src="<?php echo JkCms::show_img($images->rules); ?>" width="100%"/>
            <?php } else { ?>
                <img class="dial-rulebtn"
                     src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-rulebtn.png"/>
            <?php } ?>
            <!--end   活动规则按钮-->
        </a>
    </div>

</div>


<script src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/js/layout.js?v20156861269"
        type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/js/jquery-1.12.0.min.js"
        type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/js/awardRotate.js"
        type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js" type="text/javascript"
        charset="utf-8"></script>
<script type="text/javascript">
    openid = "<?php echo $param['openid']?>";
    id = "<?php echo $param['id']?>";
    pid = "<?php echo $param['id']?>";
    //  backUrl = "<?php echo $param['backUrl']?>";
    mid = "<?php echo $param['mid'] ?>";
    table = "bigwheel";
    //table = "activity_bigwheel";
    day_count = "<?php echo $info['day_count'] ?>";
    console.log(openid);
</script>

<script type="text/javascript" charset="utf-8">
    $(function () {

        var rotateTimeOut = function () {
            $('#lotteryBg').rotate({
                angle: 0,
                animateTo: 2160,
                duration: 8000,
                callback: function () {
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };
        var bRotate = false;
        // 转动后调用
        var rotateFn = function (awards, angles, txt, prizekind, daycount) {
            bRotate = !bRotate;
            $('#lotteryBg').stopRotate();
            $('#lotteryBg').rotate({
                angle: 0,
                animateTo: angles + 1800,
                duration: 8000,
                callback: function () {
                    if (prizekind == 0) {
                        <?php if($images->alertno){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertno);?>', '<?php echo $info['lose_msg']  ?>', txt, daycount, 2)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img4.png', '<?php echo $info['lose_msg']  ?>', txt, daycount, 2)
                        <?php } ?>
                    } else {
                        <?php if($images->alertyes){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertyes);?>', '<?php echo $info['win_msg']  ?>', txt, daycount, 2)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img3.png', '<?php echo $info['win_msg']  ?>', txt, daycount, 1)
                        <?php } ?>
                    }
                    bRotate = !bRotate;
                }
            })
        };

        // 点击转盘

        $('#lotteryBtn').click(function () {
            <?php if(!$param['mid']){?>
            showloginssss();
            return false;
            <?php } ?>

            if (bRotate)return;
            var prizeTotalnum =<?php echo $countprize?>;
            $.ajax({
                type: "post",
                cache: !1,
                async: !1,
                url: "<?php echo $this->createUrl('activity/bigwheel/getwin')?>",
                dataType: "json",
                data: {
                    "id":<?php echo $_GET['id']?>,
                },
                beforeSend: function () {
                    $(".mask").show();
                },
                success: function (data) {
                    if (data.code == -1) {
                        <?php if($images->alertno){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertno);?>', '', '', '', 3)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img4.png', '', '', '', 3)
                        <?php } ?>
                        return false;
                    }

                    if (data.code == -2) {
                        <?php if($images->alertno){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertno);?>', '', '', '', 6)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img4.png', '', '', '', 6)
                        <?php } ?>
                        return false;
                    }

                    if (data.code == -3) {
                        <?php if($images->alertno){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertno);?>', '', '', '', 4)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img4.png', '', '', '', 4)
                        <?php } ?>
                        return false;
                    }

                    $(".mask").hide();
                    var time = parseInt(((new Date()).getTime()) / 1000);

                    if (data.dayCount != 'undefined' && data.dayCount == 0) {
                        <?php if($images->alertno){ ?>
                        showpop('<?php echo JkCms::show_img($images->alertno);?>', '', '', '', 5)
                        <?php }else{ ?>
                        showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img4.png', '', '', '', 5)
                        <?php } ?>
                        return false;
                    } else {

                        if (prizeTotalnum == 5) {
                            switch (data.prizeKind) {
                                case 1:
                                    rotateFn(1, 0, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 2:
                                    rotateFn(2, 288, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 3:
                                    rotateFn(3, 216, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 4:
                                    rotateFn(4, 144, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 5:
                                    rotateFn(5, 72, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                default:
                                    var angle = [36, 108, 180, 252, 324];
                                    var txt1 = ["谢谢惠顾", "加油加油", "谢谢参与", "不要灰心", "再接再励"];
                                    var num = num1 = Math.floor(Math.random() * angle.length);
                                    rotateFn(0, angle[num], txt1[num1], data.prizeKind, data.dayCount);
                                    break;
                            }
                        } else if (prizeTotalnum == 4) {
                            switch (data.prizeKind) {
                                case 1:
                                    rotateFn(1, 0, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 2:
                                    rotateFn(2, 270, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 3:
                                    rotateFn(3, 180, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 4:
                                    rotateFn(4, 90, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                default:
                                    var angle = [45, 135, 225, 315];
                                    var txt1 = ["谢谢惠顾", "谢谢参与", "不要灰心", "再接再励"];
                                    var num = num1 = Math.floor(Math.random() * angle.length);
                                    rotateFn(0, angle[num], txt1[num1], data.prizeKind, data.dayCount);
                                    break;
                            }
                        } else if (prizeTotalnum == 3) {
                            switch (data.prizeKind) {
                                case 1:
                                    rotateFn(1, 0, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 2:
                                    rotateFn(2, 240, data.prizeName, data.prizeKind, data.dayCount);
                                    break;
                                case 3:
                                    rotateFn(3, 120, data.prizeName, data.prizeKind, data.dayCount);
                                    break;

                                default:
                                    var angle = [60, 180, 300];
                                    var txt1 = ["谢谢参与", "不要灰心", "再接再励"];
                                    var num = num1 = Math.floor(Math.random() * angle.length);
                                    rotateFn(0, angle[num], txt1[num1], data.prizeKind, data.dayCount);
                                    break;
                            }
                        } else {
                            alert("奖项设置有问题");

                        }


                    }

                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("网络异常");
                    $(".mask").hide();


                }
            })


        });


// 按钮点击

        $(".dial-logbtn").on("click", function () {
            <?php if(!$param['mid']){?>
            showloginssss();
            return false;
            <?php } ?>
            showpop('<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-img5.png', "", "", "", "");
            myjiangp();
        })
        $(".dial-rulebtn").on("click", function () {
            showpop();
            $(".popbg").html('');
            $(".dial-poptxt").html('');
            $(".popbg").next().show();
        })

        $(".confirmbtn").on("click", function () {
            $(".popbg").next().hide();
            $(".dial-pop").hide().removeClass("pop-active");
            $(".mask").hide();
        })

// 中奖纪录

        function myjiangp() {

            var _myjiangp = $(".dial-poptxt");
            _myjiangp.html("<p><br /><em>加载中...</em></p>");
            $.post('<?php echo $this->createUrl('/activity/bigwheel/userwinprize')?>', {id:<?php echo $param['id']?>}, function (data) {
                var data = JSON.parse(data);
                _myjiangp.html("");
                var _li = '<li ><span>奖项</span><span>奖品名称</span><span>中奖码</span></li>';
                if (data.code == 1) {
                    for (var i in data.msg) {
                        _li += '<li ><span>' + data.msg[i].title + '</span><span>' + data.msg[i].name + '</span><span>' + data.msg[i].code + '</span></li>';
                    }
                } else {
                    _li = '<li>无中奖记录</li>';
                }
                _myjiangp.append(_li);

            });

        }

    });

    // 弹窗方法

    function showpop(bg, zjtxt, jdname, daycount, kind) {
        $(".mask").show();
        $(".dial-pop").show().addClass("pop-active");
        $(".popbg").html('<img src="' + bg + '" width="100%" />');
        $(".popbg").next().hide();
        if (kind == 1) {
            if (daycount == 1) {
                $(".dial-poptxt").html('<p><span>' + zjtxt + '</span><br />'
                    + '<em>中得"' + jdname + '"</em>'
                    + '</p>'
                    + '<i>您的机会已经用完了</i>');
                if ("<?php echo $param['backUrl'];?>" != 0) {
                    $(".confirmbtnall").html('<div><a href="<?php echo $param['backUrl'];?>"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-confirmbtn.png" width="100%" /></a></div>');
                }
            } else {
                $(".dial-poptxt").html('<p><span>' + zjtxt + '</span><br />'
                    + '<em>中得"' + jdname + '"</em>'
                    + '</p>'
                    + '<i>你还有<b>' + (daycount - 1) + '</b>次机会</i>');
            }

        }
        if (kind == 2) {
            if (daycount == 1) {
                $(".dial-poptxt").html('<p><span>' + zjtxt + '</span><br />'
                    + '<em>' + jdname + '</em>'
                    + '</p>'
                    + '<i>您的机会已经用完了</i>');
                if ("<?php echo $param['backUrl'];?>" != 0) {
                    $(".confirmbtnall").html('<div class="confirmbtn"><a href="<?php echo $param['backUrl'];?>"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-confirmbtn.png" width="100%" /></a></div>');
                }
            } else {
                $(".dial-poptxt").html('<p><span>' + zjtxt + '</span><br />'
                    + '<em>' + jdname + '</em>'
                    + '</p>'
                    + '<i>你还有<b>' + (daycount - 1) + '</b>次机会</i>');
            }


        }
        if (kind == 3) {
            $(".dial-poptxt").html('<p><br />'
                + '<em>活动未开始</em>'
                + '</p>');
        }
        if (kind == 4) {
            $(".dial-poptxt").html('<p><br />'
                + '<em>活动已结束</em>'
                + '</p>');
        }
        if (kind == 5) {
            $(".dial-poptxt").html('<p><br />'
                + '<em>今天次数用完了，明天在玩吧</em>'
                + '</p>');
            if ("<?php echo $param['backUrl'];?>" != 0) {
                $(".confirmbtnall").html('<div class=""><a href="<?php echo $param['backUrl'];?>"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/dial-confirmbtn.png" width="100%" /></a></div>');
            }
        }
        if (kind == 6) {
            $(".dial-poptxt").html('<p><br />'
                + '<em>活动已暂停</em>'
                + '</p>');
        }


    }


</script>


</body>
</html>
<script>
    <?php if(!$param['mid']){?>
    showlogin();
    $("#winlogin").hide();
    <?php } ?>




    var url_user = "/Components/f/ID/117/do/bigwheelWinner";
    var openId = '617954';
    var FID = 72;
    var flag = 1;
    var win = 0;
    var form_flag = '1';
    var userId = "148394";
    var shareUrl = "/Components/f/ID/117/do/ajaxBigwheelShare";//分享后触发的连接地址
    var getPriceUrl = "/Components/f/ID/117/do/bigwheelGetMyPrice";//获取我的奖品列表
    var getUserUrl = "/Components/f/ID/117/do/AjaxBigwheelGetUserInfo";//收集用户信息连接
    var time = '1470363197';
    var startTime = '1470208864';
    var endTime = '1472628064';


    var wxData = {
        "appId": "", // 服务号可以填写appId
        "imgUrl": '',
        "link": '1',
        "desc": '1',
        "title": '1'
    };
    var numMax = "1";
    var FEndNumMess = '1';


</script>

<script type="text/javascript"
        src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/assets/globe.js"></script>

<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == true) {
    if ($info['share_switch'] == 1) {
        echo $this->renderpartial('/common/wxshare', array('signPackage' => $signPackage, 'info' => $info, 'url' => $this->createUrl('/activity/bigwheel/view', array('id' => $param['id']))));
    } else { ?>
        <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script>
            wx.config({
                debug: false,
                appId: '<?php echo $signPackage["appId"];?>',
                timestamp: <?php echo $signPackage["timestamp"];?>,
                nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                signature: '<?php echo $signPackage["signature"];?>',
            });

            wx.ready(function () {
                wx.hideOptionMenu();

            })

        </script>
    <?php }
} ?>
