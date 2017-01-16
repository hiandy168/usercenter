<!DOCTYPE html>
<html>
<head>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
    </script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no" />
    <title>绑定手机号</title>
    <meta name="Keywords" content="<?php echo $Keywords ?>" />
    <meta name="Description" content="<?php echo $Description ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <script src="<?php echo $this->_theme_url;?>assets/h5/login/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
         var disable_click = false;
    //发送短信验证码
    $(function(){
    $("#sendCode").on('click',function(){
        if(disable_click) {
            return false;
        }
        disable_click = true;
        var mobile = $.trim($("#mobile").val());
        if(mobile==''){
            setTimeout(function () {
                showTips('请输入手机号');
                $("#mobile").focus();
            }, 300);
            disable_click = false;
            return;
        }
        if(!mobile.match((/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/))){
            setTimeout(function () {
                showTips('请输入正确的手机号');
                $("#mobile").focus();
            }, 300);
            disable_click = false;
            return;
        }

        $.ajax({
            url: '/h5/member/SendMsCode',
            data: {mobile: mobile},
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (data.status == 1) {
                    setTimeout(function () {
                        //短信验证码已发送禁用60s
                        var count_time = 60;
                        t = setInterval(function() {
                            if (count_time <0) {
                                $(".send_message").removeAttr("disabled");
                                $(".send_message").removeClass('send_status');
                                $("#hq").attr("value",'获取验证码');
                                disable_click = false;
                                clearInterval(t);

                            }else {
                                $(".send_message").addClass("send_status");
                                $(".send_message").attr("disabled", true);
                                $("#hq").attr("value",'('+count_time--+')秒后重获');
                            }
                        }, 1000);
                    }, 600);
                }
                if (data.status == -1 || data.status == 0) {
                    setTimeout(function () {
                        showTips(data.info);
                        disable_click = false;
                    }, 600);
                }
            }
        });
    });

 })

         //登录
    function ajaxlogin(){
        var account=$("#mobile").val(),codes = $("#smsCode").val();
           if(account==''){
            setTimeout(function () {
                showTips('请输入手机号');
                $("#mobile").focus();
            }, 300);
            return false;
        }else if(!account.match((/^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/))){
            setTimeout(function () {
                showTips('请输入正确的手机号');
                $("#mobile").focus();
            }, 300);
            return false;
        }else if(codes==''){
            setTimeout(function () {
                showTips('请输入验证码');
                $("#mobile").focus();
            }, 300);
            return false;
        }else {
            $.ajax({
                type: "post",
                cache: !1,
                async: !1,
                data: {
                    account:account,
                    codes:codes,
                },
                url: Siteurl+'/member/bind',  //输入验证码登录地址
                dataType: "json",
                success: function(data) {
                    if (data.state == 1) {
                        showTips(data.message,'<?php echo $this->_siteUrl.$this->_theme_url;?>assets/h5/login/images/cal-right-icon.png');
                        setTimeout(function(){
                            window.location.href = data.return_url;
                        },400);
                    } else {
                        showTips(data.message);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    showTips("网络异常");
                }
            })

        }
    }
     
     //提示
     function showTips(content,picsrc) {
        if(picsrc){
            $("#tsimg").html(" <img src="+picsrc+">");
        }
        $(".cal-mask").css({
            "z-index": "999",
            "opacity": "1"
        }).children(".cal-mask-con").css({
            "top": "50%"
        });
        $("#msg").html(content);
        setTimeout(function() {
            $(".cal-mask").css({
                "z-index": "-10",
                "opacity": "0"
            }).children(".cal-mask-con").css({
                "top": "-50%"
            });
        }, 2000)
    }

    </script>

</head>

<body>


  
<div class="login-mask" style="background:#6bbcd3;background: -webkit-linear-gradient(0deg, #6bbcd3, #326683);">
    
    <div class="login-mian" id="loginslide" style="left: 0%">
          
          <div class="login-mian-tab login-mian-slide">
            <div class="login-tab login-mian-slide-div">
                <div class="login-title clearfix">
                    <h3>绑定大楚通行证</h3>
                   <!--  <a class="close" href="javascript:;"></a> -->
                </div>
                <!--title end-->
                <div class="login-tabcon" style="border-radius: 0px 0px 5px 5px;">
                    <div class="login-tabcon-nav">
                        <ul>
                            <li style="width: 100%;" class="selected">
                                <b>手机号绑定</b>
                            </li>
                            <!-- <li>
                                <b>账号登录</b>
                            </li> -->
                        </ul>
                    </div>
                    <!--tabcon-nav end-->
                    <div class="login-tabcon-div">
                        <div class="login-tabcon-div1" style="display: block;">
                            <div class="login-inp has-focus"><input type="tel" name="mobile" id="mobile" placeholder="手机号"></div>
                        <div class="login-inp has-focus"><input type="tel" name="smsCode" id="smsCode" value="" placeholder="验证码">
                        <a id="sendCode" href="javascript:;"><div class="login-inp-codebtn" id="send_message"><input id="hq" type="button" value="获取验证码"></div></a>
                        </div>
                        <div class="login-inp"><input type="submit" onclick="ajaxlogin()" value="绑定"></div>
                        </div>
                        
                        <!-- <div class="login-tabcon-div1" style="display: none;">
                            <div class="login-inp has-focus"><input type="tel" name="mobile2" id="mobile2" value="" placeholder="手机号"></div>
                            <div class="login-inp has-focus"><input type="password" name="upwd" id="upwd" value="" placeholder="密码"></div>
                            <div class="login-inp"><input type="submit"  value="登录"></div>
                        </div> -->
                        
                    </div>
                    <!--tabcon-div end-->
                </div>
                
                <!--tabcon end-->
                
            
            </div>
          </div>
         
         <!--div1 end-->
         
     
    </div>
    
    
    
</div>


        
        
        <div class="cal-mask">
            <div class="cal-mask-con" id="regtips">
                <span class="img" id="tsimg">
                    <img src="<?php echo $this->_theme_url;?>assets/h5/login/images/cal-error-icon.png"/>
                </span>
                <p id="msg">加载中...</p>
            </div>
        </div>



</body>
</html>
