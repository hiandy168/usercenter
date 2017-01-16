<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>幸运大转盘  - PHP+AJAX实现</title>
    <style type="text/css">
/*        .demo { height: 417px; margin: 50px auto; position: relative; width: 417px;}*/
/*        #disk { background: url("*/<?php //echo $this->_theme_url ?>/*images/activity-lottery-1.png") no-repeat; height: 317px; width: 317px;}*/
/*        /*#start { height: 320px; left: 130px; position: absolute; top: 46px; width: 163px;}*/*/
/*        #start{width:163px; height:320px; position:absolute; top:46px; left:130px;}*/
/*        #start img{cursor:pointer}*/
    </style>
    <link href="<?php echo $this->_theme_url ?>css/activity-style.css" rel="stylesheet" type="text/css">
    <sctipt src="<?php echo $this->_theme_url; ?>js/jquery.2.1.1.min.js"></sctipt>
    <title>幸运大转盘抽奖</title>
    <script src="<?php echo $this->_theme_url ?>js/jquery.js" type="text/javascript"></script>
<!--    <script type="text/javascript" src="jquery-1.8.3.js"></script>-->
    <script type="text/javascript" src="<?php echo $this->_theme_url ?>js/jQueryRotate.2.2.js"></script>
    <script type = "text/javascript" src = "<?php echo $this->_theme_url ?>js/jquery.easing.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#inner").click(function(){
                lottery();
            });
        });
        function lottery(){
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('/activity/lottery/start'); ?>',
                dataType: 'json',
                cache: false,
                error: function(){
                    alert('出错了！');
                    return false;
                },
                success:function(json){
                    $("#inner").unbind('click').css("cursor","default");
                    var a = json.angle; //角度
                    var p = json.prize; //奖项
//                    alert(json.prize);
                    $("#inner").rotate({
                        duration:3000, //转动时间
                        angle: 0,
                        animateTo:1800+a, //转动角度
                        easing: $.easing.easeOutSine,
                        callback: function(){
                            var con = confirm('恭喜你，中得'+p+'\n还要再来一次吗？');
                            if(con){
                                lottery();
                            }else{
                                return false;
                            }
                        }
                    });
                }
            });
        }
    </script>
</head>
<body>
<div class="main">
<!--    <script type="text/javascript">-->
<!--        var loadingObj = new loading(document.getElementById('loading'),{radius:20,circleLineWidth:8});-->
<!--        loadingObj.show();-->
<!--    </script>-->
    <div id="outercont">
        <div id="outer-cont">
            <div id="outer"><img src="<?php echo $this->_theme_url ?>images/activity-lottery-1.png" width="310px"></div>
        </div>
        <div id="inner-cont">
            <div id="inner"><img src="<?php echo $this->_theme_url ?>images/activity-lottery-2.png"></div>
        </div>
    </div>
    <div class="content">
        <div class="boxcontent boxyellow" id="result" style="display:none">
            <div class="box">
                <div class="title-orange" style="color:#000000;"><span>恭喜你中奖了</span></div>
                <div class="Detail">
                    <a class="ui-link" href="#" id="opendialog" style="display: none;" data-rel="dialog"></a>
                    <p>你中了：<span class="red" id="prizetype">一等奖</span></p>
                    <p>你的兑奖SN码：<span class="red" id="sncode"></span></p>
                    <p class="red">本次兑奖码已经关联你的微信号，你可向公众号发送 兑奖 进行查询!</p>

                    <p>
                        <input name="" class="px" id="tel" type="text" placeholder="输入您的手机号码">
                    </p>
                    <p>
                        <input class="pxbtn" id="save-btn" name="提 交" type="button" value="提 交">
                    </p>
                </div>
            </div>
        </div>
        <div class="boxcontent boxyellow">
            <div class="box">
                <div class="title-green"><span>奖项设置：</span></div>
                <div class="Detail">
                    <p>一等奖：iPhone5S 。奖品数量：100 </p>
                    <p>二等奖：iPad5 。奖品数量：500 </p>
                    <p>三等奖：iPad mini 。奖品数量：1000 </p>
                </div>
            </div>
        </div>
        <div class="boxcontent boxyellow">
            <div class="box">
                <div class="title-green">活动说明：</div>
                <div class="Detail">
                    <p>本次活动每人可以转 2 次 </p>
                    <p> 只为测试，中奖后请勿领奖 </p>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
<script type="text/javascript">
    jQuery(function($){
        $('#inner').click(function() {
            var a = Math.floor(Math.random() * 360);

            $(this).rotate({
                duration: 3000,
                angle: 0,
                animateTo: 1800 + a,
                easing: $.easing.easeOutSine,
                callback: function(){
//                    $self.unbind('click');
                    $('#result').show().children('span').text('谢谢参与');
                }
            });
        });
    });

//    $(function() {
//        $("#inner").rotate({
//            bind: {
//                click: function() {
//                    var random = Math.floor(Math.random() * 360), $self = $(this); //生成随机数
//                    $(this).rotate({
//                        duration: 3000,
//                        //转动时间间隔（速度单位ms）
//                        angle: 0,
//                        //指针开始角度
//                        animateTo: 3600 + random,
//                        //转动角度，当转动角度到达3600+random度时停止转动。
//                        easing: $.easing.easeOutSine,
//                        //easing动画效果
//                        callback: function() { //回调函数
//                            alert('恭喜您，中奖了！');
//                        }
//                    });
//                }
//            }
//        });
//    });
</script>