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
    <title></title>
    <link href="<?php echo $this->_theme_url; ?>assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_theme_url; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
    </script>
</head>
<body>
<!--登录框-->
<div class="op-mask"></div>
<div class="op-login-div" style="padding: 20px 40px; " >
    <!-- <i class="close" id="loginhide"><img src="<?php echo $this->_theme_url; ?>assets/index/images/login-close.png"></i> -->
    <form id="op-login-div">

        <div class="op-login-tit">
            <img src="<?php echo $this->_siteUrl; ?>/assets/index/images/login-div-txt.png"/>
        </div>

        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" value="">
        </div>

        <div class="op-login-input">
             <input type="password" id="upwd" name="password" placeholder="请输入密码">
          <!--  <input type="text" style="width: 60%;" id="codes" name="codes" placeholder="请输入验证码">-->
          <!--  <span>
                <a href="javascript: void(0);" style=" padding: 8px 10px;  cursor: pointer;  position: relative;  right: -24px;" id="send_message" class="adbtn linear" onclick="send_code()">免费获取验证码</a>
            </span>-->
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
    </form>
</div>
</body>
</html>
<script>
    /*pc首页登陆*/
    function ajaxlogin(){
        var account=$("#uname").val(),
            password=$("#upwd").val(),
            win=$(".op-login-error");
        var verify = $('#verify').val();
        var rember = 0;
        var codes = $('#codes').val();
        var ckbox = $('#regname:checked').val();
        var backUrl=window.location.href;
        if(ckbox){
            rember = 1;
        }
        // if($('#checkbox').is(':checked')) {
        // 	rember = 1;
        // }
        if(account=="" || account=="请输入用户名"){
            win.html("请填写用户名");
            return false;
        }else if(password=="" || password=="请输入密码"){
            win.html("请输入密码");
            return false;
        }else {

            $.ajax({
                type: "post",
                cache: !1,
                async: !1,
                data: {
                    username:account,
                    password:password,
                    backurl:backUrl,
                    codes:codes,
                },
                //  url: Siteurl+'/member/Ajaxsitelogin',   //输入密码登录地址
                url: Siteurl+'/sso/client/index',  //输入验证码登录地址
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        win.html(data.message);
                        setTimeout(function(){
                            window.location.href = data.return_url;
                        },400);
                    } else {
                        win.html(data.message);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    win.html("网络异常");
                }
            })

        }
    }
</script>