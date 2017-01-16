<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>找回密码-大楚开放平台</title>
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/site.css">
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/home.js"></script>
    <style type="text/css">
        .psd-box .psd-body .field .btn_time {
            color: white;
            width: 194px;
            font-size: 14px;
            line-height: 32px;
            background: #ea524a;
            margin-left: 7px;
            padding: 6.5px 48px ;
        }

    </style>
</head>

<body>
    <!-- 头部导航 start-->
    <div class="da_header clearfix">
        <h1><a href="#">大楚开放平台</a></h1>
        <ul>
            <li class="action"><a href="<?php echo $this->createUrl('/'); ?>">首页</a></li>
            <li><a href="<?php echo $this->createUrl('/project/appMgt'); ?>">管理中心</a></li>
            <li><a href="<?php echo $this->createUrl('/wiki'); ?>">文档资料</a></li>
        </ul>
        <div class="header_login">
            <span>第一次使用公众平台？</span>
            <a href="<?php echo $this->createUrl('/member/regone'); ?>">立即注册</a> |
            <a href="#">使用帮助</a>
        </div>
    </div>
    <!-- 头部导航 end-->
<!--    <div class="clearH"></div>-->
    <!-- password recover start -->

    <div class="psd-box">
        <div class="psd-field">
            <div class="psd-head">
                <p>密码找回</p>
            </div>
            <div class="psd-body">
                <form>
                    <div class="field tel">
                        <label>手机号</label>
                        <input type="text" name="tel" class="col2" id="tel"/>
                        <p class="tel_error error">请填写正确的手机号</p>
                        <img src="<?php echo $this->_theme_url; ?>images/yl_19.png" class="reset">
                    </div>
                    <div class="field codes">
                        <label>短信验证</label>
                        <input id="codes" type="text" name="codes" class="col1"/>
<!--                        <input type="button" name="get_codes" class="btn" value="免费获取验证码"/>-->
                        <a href="javascript: void(0);" id="send_message" class="btn_time" onclick="send_code()">免费获取验证码</a>
                        <p class="codes_error error">请输入正确验证码</p>
                    </div>
                    <div class="field password">
                        <label>新密码</label>
                        <span id="show_pass">
                            <input id="pass" type="password" name="pass" class="col2"/>
                        </span>
                        <p class="password_error error">请输入规范密码</p>
                        <p class="tips">字母、数字或者英文符号，最短8位，区分大小写</p>
                        <div class="view" onclick="showPass('pass')"></div>
                    </div>
                    <div class="field comfirm">
                        <label>确认密码</label>
                        <span id="show_repass">
                            <input id="repass" type="password" name="repass" class="col1"/>
                        </span>
                        <p class="comfirm_error error">密码不一致</p>
                        <p class="tips">请再次输入密码</p>
                        <div class="view" onclick="showPass('repass')"></div>
                    </div>
                    <div class="field sub_btn">
                        <input id="sub" type="button" name="btn" class="btn" value="确认"/>
                    </div>
                </form>

                <div class="contact">
                    <p style="margin-top: 20px;"><span style="font-size: 14px;">上述方法无法找回？客服来帮助你：</span>1、发邮件到<span>guest@tengchuqq.com</span>(邮件记得备注登录名哦~)</p>
                    <p style="margin-left: 50px;">2、拨打客服热线：<span>027-88889989</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- password recover end -->

	<!-- 底部样式 start -->
	<div class="foot">
		<div class="w980">
			<ul class="clearfix">
				<?php $friendlinks = JkCms::getFriendlink(3); ?>
        <?php if($friendlinks){$i=1;foreach ($friendlinks as $f) { ?>
                <li><a href="<?php echo $f['url'] ?>" title="<?php echo $f['title'] ?>" target="_blank"><?php echo $f['title'] ?></a></li>
        <?php }}?>
			</ul>
			<div class="copy_right copy_right1">
				Copyright © 1998 - 2016 Tencent. All Rights Reserved.
			</div>
			<div class="copy_right copy_right2">
				腾讯·大楚网 版权所有
			</div>
		</div>
	</div>
	<!-- 底部样式 end -->
    <script type="text/javascript">
     //显示密码
    function showPass(id){
//        alert(id);
        var type = $('#'+id).attr('type');
//        alert(type);
        var temp=$('#'+id).val();

        var col ;
        if (id == 'pass') {
            col = 'col2'
        }  else {
            col = 'col1';
        }
        if(type == 'password'){
            $('#show_'+id).html('<input type="text" id="'+id+'" name="'+id+'" class='+col+'>');
        }else{
            $('#show_'+id).html('<input type="password" id="'+id+'" name="'+id+'" class='+col+'>');
        }
        $('#'+id).val(temp);;
    }

    $.fn.showIn = function(){
        $(this).css("display","inline-block");
    }
    $.fn.hideIn = function(){
        $(this).css("display","none")
    }
    $(function(){

        $(".psd-body .field input[type!=button]").focus(function(){
            $(this).addClass("active");
        }).blur(function(){
            $(this).removeClass("active");
            var name = $(this).attr("name"),
                isLagel = false,
                $error = $(this).nextAll(".error");
            switch(name){
                case "tel":
                    isLagel = telValidation($(this).val());
                    break;
                case "codes":
                isLagel = true;
                    break;
                case "password":
                    isLagel = passwordValidation($(this).val());
                    break;
                case "comfirm":
                    isLagel = comfirmValidation($(this).parent().prev().find("input[name=password]").val(),$(this).val());
                    break;
            }
            if(isLagel){
                $error.hideIn();
            }else{
                $error.showIn();
            }
        });

        function telValidation(value){
            return /^1[3|4|5|7|8]\d{9}$/.test($.trim(value));
        }

        function passwordValidation(value){
            value = $.trim(value);
            if(value.length <= 8){return false;}
            return !(/[^\d|\w|!|@|#|$|%|^|&|*|\/|\*|\+|\-|~]/.test($.trim(value)));
        }

        function comfirmValidation(value,comfirmValue){
            return $.trim(value) === $.trim(comfirmValue);
        }

        $(".psd-body .field .reset").click(function(){
            $(this).prevAll("[name=tel]").val("");
        });

        $(".psd-box .psd-body .field .view").click(function(){

            var $field = $(this).prevAll("input");
            if($(this).hasClass("active")){
                $field.attr("type","password");
                $(this).removeClass("active");
            }else{
                $field.attr("type","text");
                $(this).addClass("active");
            }

        });

    });

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
             $("#send_message").attr('style', "background: #EA524A" );
             $("#send_message").attr("onclick",'send_code()');
             $("#send_message").html('免费获取验证码');

         }
     }

    function send_code(){

        var tel = $("#tel").val();

        if(tel.trim() == ''){
            ship_mess_big('手机号码不能为空');
            return false;
        }
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if(!reg.test($.trim(tel))){
            $("#tel").focus();
            ship_mess_big('请填写正确的手机号');
            return false;
        }

        $.ajax({
            url: '/member/SendMessage',
            data: {mobile: tel},
            dataType: 'json',
            type: 'post',
            beforeSend:function(){
                $("#send_message").attr('style', "background:#C6C6C6 " );
                $("#send_message").attr("onclick",'');
            },
            success: function (data) {
                ship_mess_big(data.info);
                if (data.status) {
//                        $('#ver').attr("ajaxurl","<?php //echo Mod::app()->createUrl('/member/verifyMsg')?>//?mobile="+mobile);
                    setTimeout(function () {
                        $("#send_message").html('<span class="time">60</span>秒后重新获取');
                        timer();
                    }, 100);
                }
            }
        });
    }

    //提交表单
    $(function(){
        //提交表单
        $('#sub').click(function(){
            var phone = $('#tel').val();
            var codes = $('#codes').val();
            var pass = $('#pass').val();
            var repass = $('#repass').val();
            if(phone.trim() == ''){
                ship_mess_big('手机号不能为空');
                return false;
            }
            var reg = /^1[3|4|5|7|8]\d{9}$/;
            if(!reg.test($.trim(phone))){
                ship_mess_big('请填写正确的手机号');
                return false;
            }
            //验证码不能为空
            if(codes.trim() == ''){
                ship_mess_big('验证码不能为空');
                return false;
            }
            //判断验证码是否正确
//            $.ajax({
//                url:'/member/verifyMsg',
//                data:{mobile:phone,param:codes},
//                dataType:'json',
//                type:'post',
//                success: function (data) {
//                    if(data.status == 'n'){
//                        ship_mess_big(data.info);
//                        return false;
//                    }
//                }
//
//            });

            if(pass !== repass){
                ship_mess_big('两次密码输入不一致');
                return false;
            }
//            console.log(pass+repass);
            $.ajax({
                url:'/member/ajaxFindPass',
                data:{phone:phone,ver:codes,pass:pass,repass:repass},
                dataType:'json',
                type:'post',
                success: function (data) {
                    ship_mess_big(data.mess);
                    if (data.state) {
                        alert(data.mess);
                       // window.location.href = "<?php echo $this->createUrl('/member/login'); ?>";
                        window.location.href = "http://<?php echo $_SERVER['HTTP_HOST']; ?>";
                    }

                }

            });
        })
    });
    </script>
</body>

</html>
