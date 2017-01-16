<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="积分兑换" />
    <meta name="description" content="积分兑换" />
    <title>积分兑换</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/css/style.css" />
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/layout.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>
<script>
    var siteUrl = "<?php echo $this->_siteUrl; ?>";
</script>
<div class="div-main">

    <div class="top-title clearfix">
        <h2>登陆用户中心账号</h2>
<!--        <a class="righta fr" href="register.html">注册</a>-->
    </div>


    <div class="login-form">

        <form action="" method="post">

            <div class="login-inp bb bt">
                <input type="text" placeholder="您的账号（手机号）" name="uname" id="uname" value="" />

            </div>

            <div class="login-inp bb bt">
                <input type="password" placeholder="您的用户中心账号密码" name="upwd" id="upwd" value="" />
            </div>



            <div class="login-btn">
                <input type="button" name="" id="" onclick="login()" value="登录" />
                <i class="loadingdiv"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/load.gif"/></i>
            </div>
        </form>


        <div class="clearfix login-tips">
<!--            <label class="fl" for="jzlogin">-->
<!--                <input type="checkbox" name="jzlogin" id="jzlogin" value="" />-->
<!--                <i>下次自登录</i>-->
<!--            </label>-->

<!--            <a class="fr" href="">忘记密码？</a>-->

        </div>



    </div>





</div>


<div class="cal-mask" style="display: block;">
    <div class="cal-mask-con" id="regtips">
         		<span class="img">
         			<img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/cal-error-icon.png">
         		</span>
        <p>提示文字</p>
    </div>
</div>


<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    function showtips() {
        $(".cal-mask").css({
            "z-index": "999",
            opacity: "1"
        }).children(".cal-mask-con").css({
            top: "50%"
        }), setTimeout(function() {
            $(".cal-mask").css({
                "z-index": "-10",
                opacity: "0"
            }).children(".cal-mask-con").css({
                top: "-50%"
            })
        }, 2000)
    }

    function login(){
        var a=$("#uname").val(),
            b=$("#upwd").val(),
            c= $("#regtips");
        if(a==""||b==""){
            alert("请填写信息");
            return false;
        }else if(!a.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/)){
            alert("请填写正确手机号");
            return false;
        }else{
            $.ajax({
                type: "post",
                cache: !1,
                async: !1,
                data: {
                    username: a,
                    password: b,
                },
                url: siteUrl+'/b2c/wap/account/Logincheckall',
                dataType: "json",
                beforeSend: function() {
                    $(".loadingdiv").show()
                },
                success: function(data) {
                    $(".loadingdiv").hide();
                    if (data.code == 200) {
                        c.html('<span class="img"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/cal-right-icon.png"/></span><p>登录成功</p>');
                        showtips();
                        history.go(-1);
//                        setTimeout('location.href="#"',2000);
                    } else {
                        c.html('<span class="img"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/cal-error-icon.png"/></span><p>登录失败，再试一次吧</p>');
                        showtips();
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $(".loadingdiv").hide();
                    c.html('<span class="img"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/cal-error-icon.png"/></span><p>服务器异常请检查网络</p>');
                    showtips();
                }
            })


        }

    }


</script>



</body>

</html>