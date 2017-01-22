<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
        var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="登录测试" />
    <meta name="description" content="登录测试" />
    <title>登录测试</title>
    <link href="<?php echo $this->_theme_url; ?>assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_theme_url; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_siteUrl;?>/assets/house/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js" type="text/javascript"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/validate.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
</head>


<!--<a id="wxlogin" href="<?php /*echo $this->_siteUrl */?>/member/WeixinLogin<?php /*echo $reurl*/?>"><em style="padding:30px"><img src="/themes/new/assets/h5/login/images/login-wx-icon.png"/></em><p>使用微信快捷登录</p></a>-->

<div class="op-login-div" style="padding: 20px 40px; z-index: 999;  " >
    <form id="op-login-div">

        <div class="op-login-tit">
            <img src="<?php echo $this->_siteUrl; ?>/assets/index/images/login-div-txt.png"/>
        </div>

        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" value="">
        </div>

        <div class="op-login-input">
            <!--  <input type="password" id="upwd" placeholder="请输入密码">-->
            <input type="text" style="width: 60%;" id="codes" name="codes" placeholder="请输入验证码">
            <span>
                <a href="javascript: void(0);" style=" padding: 8px 10px;  cursor: pointer;  position: relative;  right: -24px;" id="send_message" class="adbtn linear" onclick="send_code()">免费获取验证码</a>
            </span>
        </div>

        <div class="op-login-error" style="margin: 5px auto;"></div>

        <div class="op-login-reg clearfix">
            <!--            <span class="fl"><input type="checkbox" checked="checked" name="regname" id="regname" value="1"><label for="regname">记住账号</label></span>
            -->          <!--  <span class="fr"><a href="<?php /*echo $this->createUrl('/member/findPass'); */?>">忘记密码</a></span>-->
        </div>

        <div class="op-login-dlbtn">
            <a id="loginbtn">登录</a>
        </div>
    </form>
</div>


<script type="text/javascript">


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
    function send_code(){
        var tel = $("#uname").val();
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if(!reg.test($.trim(tel))){
            $("#uname").focus();
            layer.msg('请填写正确的手机号!');
            return false;
        }

        $.ajax({
            url: site_url+'/member/SendMessage',
            data: {mobile: tel},
            dataType: 'json',
            type: 'post',
            beforeSend:function(){
                $("#send_message").addClass('unclick');
                $("#send_message").attr("onclick",'');
            },
            success: function (data) {
                layer.msg(data.info);
                if (data.status) {
//                        $('#ver').attr("ajaxurl","<?php //echo Mod::app()->createUrl('/member/verifyMsg')?>//?mobile="+mobile);
                    setTimeout(function () {
                        $("#send_message").html('<i class="time">60</i>秒后重新获取');
                        timer();
                    }, 100);
                }else{
                    $('#codes').focus();
                    $("#send_message").removeClass('unclick');
                    $("#send_message").attr("onclick",'send_code()');
                    $("#send_message").html('免费获取验证码');
                }
            }
        });
    }
</script>
<script type="text/javascript">
    var childWindow;
    function toQzoneLogin()
    {
        window.location.href="<?php echo $this->createUrl('member/qqlogin/state/computer')?>";
        //childWindow = window.open("<?php echo $this->createUrl('member/qqlogin/state/computer')?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
    }

</script>
<script type="text/javascript">
    var childWindow;
    function WxLogin()
    {
        window.location.href="<?php echo $this->createUrl('member/WXgetcode/state/computer')?>";
        //  childWindow = window.("<?php //echo $this->createUrl('member/WXgetcode')?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
    }

    function closeChildWindow()
    {
        childWindow.close();
    }
</script>
<body>
