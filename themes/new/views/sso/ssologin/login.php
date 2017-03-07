<?php
/**
 * Created by PhpStorm.
 * User: xiaoxindezhihui
 * Date: 2017/3/1
 * Time: 16:20
 */

?>
<html>
<head>
    <title>大楚通行证登录</title>
    <link href="<?php echo $this->_theme_url; ?>assets/css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $this->_theme_url; ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js" type="text/javascript"></script>

    <script src="<?php echo $this->_theme_url; ?>assets/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
    </script>
</head>
<body>
<!--登录框-->
<div class="op-mask"></div>
<div class="op-login-div" style="padding: 20px 40px; ">
    <!-- <i class="close" id="loginhide"><img src="<?php echo $this->_theme_url; ?>assets/index/images/login-close.png"></i> -->
    <form id="op-login-div" action="<?php echo $this->createUrl('/sso/ssologin/login'); ?>" method="post">

        <div class="op-login-tit">
            <img src="<?php echo $this->_siteUrl; ?>/assets/index/images/login-div-txt.png"/>
        </div>

        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" name="username" value="">
        </div>

        <div class="op-login-input">
            <!--   <input type="password" id="upwd" name="password" placeholder="请输入密码">-->
            <input type="text" style="width: 60%;" id="codes" name="codes" placeholder="请输入验证码">
        <span>
                <a href="javascript: void(0);"
                   style=" padding: 8px 10px;  cursor: pointer;  position: relative;  right: -24px;" id="send_message"
                   class="adbtn linear" onclick="send_code()">免费获取验证码</a>
            </span>
        </div>

        <div class="op-login-error" style="margin: 5px auto;"></div>

        <div class="op-login-reg clearfix">
        </div>

        <div class="op-login-dlbtn">
            <a id="loginbtn">登录</a>
        </div>

        <div class="op-login-dlbtn op-login-regbtn">
            <a href="<?php echo $this->createUrl('/member/regone'); ?>">注册</a>
        </div>
        <a href="<?php echo $this->createUrl('member/qqlogin/')?>?state=<?php echo urlencode($this->createUrl('/sso/ssologin/Callsetticket/'))?>" class="three" ><img src="<?php echo $this->_theme_url; ?>assets/images/QQ.png"></a>
        <a href="<?php echo $this->createUrl('member/WXgetcode/')?>?state=<?php echo urlencode($this->createUrl('/sso/ssologin/Callsetticket/'))?>" ><img src="<?php echo $this->_theme_url; ?>assets/images/weixin.png"></a>

    </form>
</div>
</body>
</html>
<script>
    //倒计时60秒
    function timer(){
        var times = $('#send_message .time').html();
//        alert(times);
        if(times > 1){
            --times;
            $('#send_message .time').html(times);
            setTimeout(function(){
                timer();
            },1000);
        }else{
            $('#codes').focus();
            $("#send_message").removeClass('unclick');
            $("#send_message").attr("onclick",'send_code()');
            $("#send_message").html('免费获取验证码');

        }
    }



    /*发送验证码*/
    function send_code() {
        var tel = $("#uname").val();
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if (!reg.test($.trim(tel))) {
            $("#uname").focus();
            layer.msg('请填写正确的手机号!');
            return false;
        }

        $.ajax({
            url: Siteurl + '/member/SendMessage',
            data: {mobile: tel},
            dataType: 'json',
            type: 'post',
            beforeSend: function () {
                $("#send_message").addClass('unclick');
                $("#send_message").attr("onclick", '');
            },
            success: function (data) {
                layer.msg(data.info);
                if (data.status) {
//                        $('#ver').attr("ajaxurl","<?php //echo Mod::app()->createUrl('/member/verifyMsg')?>//?mobile="+mobile);
                    setTimeout(function () {
                        $("#send_message").html('<i class="time">60</i>秒后重新获取');
                        timer();
                    }, 100);
                } else {
                    $('#codes').focus();
                    $("#send_message").removeClass('unclick');
                    $("#send_message").attr("onclick", 'send_code()');
                    $("#send_message").html('免费获取验证码');
                }
            }
        });
    }
</script>


<script>
    /*pc首页登陆*/
    function ajaxlogin() {
        var account = $("#uname").val(),
            win = $(".op-login-error");

        var codes = $('#codes').val();


        // if($('#checkbox').is(':checked')) {
        // 	rember = 1;
        // }
        if (account == "" || account == "请输入用户名") {
            win.html("请填写用户名");
            return false;
        } else if (codes == "" || codes == "请输入验证码") {
            win.html("请输入验证码");
            return false;
        } else {

            /*      $.ajax({
             type: "post",
             cache: !1,
             async: !1,
             data: {
             username:account,
             codes:codes,
             },
             //  url: Siteurl+'/member/Ajaxsitelogin',   //输入密码登录地址
             url: Siteurl+'/sso/ssologin/login',  //输入验证码登录地址
             dataType: "json",
             success: function(data) {
             if (data.state == 1) {
             win.html(data.message);
             setTimeout(function(){
             window.location.href = <?php //echo $backurl?>;
             },400);
             } else {
             win.html(data.message);
             }
             },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
             win.html("网络异常");
             }
             })*/

            //用 sumbit  提交

            $("#op-login-div").submit()
        }
    }
</script>