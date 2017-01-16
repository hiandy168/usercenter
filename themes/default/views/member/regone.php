<?php echo $this->renderpartial('/common/header_new',$config); ?>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index.css">


<script>
    function showInfo(){
        layer.open({
            type:2,
            title:'编辑个人信息',
            shadeClose:true,
            shade:0.3,
            area:['650px','569px'],
            content:'/project/showInfo'
        });
    }
</script>
<style>   
.passwordStrength {
    margin-top: 10px;
}
.passwordStrength b {
    font-weight: normal;
}
.passwordStrength b, .passwordStrength span {
    display: inline-block;
    height: 16px;
    line-height: 16px;
    vertical-align: middle;
}
.passwordStrength span {
    background-color: #d0d0d0;
    border-right: 1px solid #fff;
    text-align: center;
    width: 45px;
}
.passwordStrength .last {
    border-right: medium none;
}
.passwordStrength .bgStrength {
    background-color: #71b83d;
    color: #fff;
} 
.icon-exclamation-sign{
    margin: 0 3px;
}
.button {
    display: inline-block;
    width: 236px;
    height: 44px;
    margin-left: 80px;
    line-height: 44px;
    font-size: 18px;
    text-align: center;
    color: #fff;
    background-color: #1399e5;
    border: 1px solid #e7e7eb;
    border-radius: 4px;
    cursor: pointer;
}

#checkboxFourInput02,
            #checkboxFourInput03 {
                opacity: 0;
                filter: alpha(opacity=0);
                position: relative;
                top: -3px;
            }
</style>
<div class="lo_content">
    <div class="lo_box">
        <ul>
            <li class="lo_style">第一步：创建用户<span></span></li>
            <li>第二步：完善信息<span></span></li>
            <li>第三步：注册成功<span></span></li>
        </ul>

        <form class="registerform" action="<?php echo Mod::app()->createUrl('/member/regTwo')?>" method="post">
            <div>
                <em>用户名</em>
                <input type="text" id="name" name="name" class="inputxt" datatype="s6-18" nullmsg="请填写用户名！" ajaxurl="<?php echo Mod::app()->createUrl('/member/nameIsNull')?>" errormsg="请输入6-18位字符！" sucmsg="验证通过！"/>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i> 作为登录账号</div>

            </div>



            <div class="input_style03">
                <em>密码</em>
                <input type="password" value="" name="password" class="inputxt" plugin="passwordStrength" ajaxurl="<?php echo Mod::app()->createUrl('/member/PassIsNull')?>" datatype="*6-18" nullmsg="请填写密码！"  errormsg="密码为6-18个字符！" sucmsg="验证通过！"/>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i>字母、数字或者英文符号，最短6位，区分大小写</div>
                <div class="passwordStrength">密码强度： <span style="margin-left: 18px;">弱</span><span>中</span><span class="last">强</span></div>
            </div>

            <div>
                <em>确认密码</em>
                <input type="password" value="" name="repassword" class="inputxt" recheck="password"  datatype="*6-18" nullmsg="请再次填写密码！" errormsg="两次输入密码不一致！" sucmsg="验证通过！"/>
                <div class="Validform_checktip"></div>
            </div>

            <style type="text/css">
                .send_status {
                    background: #d0d0d0 !important;
                    cursor: default;
                }
            </style>
            <script type="text/javascript">
            $("#checkboxFourInput02").on('click', function() {
                var parent = $(this).parents('.checkboxFour');
                $(".checkboxFour").removeClass('label_bg');
                parent.addClass('label_bg');
                $(".company_hide").show();
            });

            $("#checkboxFourInput03").on('click', function() {
                var parent = $(this).parents('.checkboxFour');
                $(".checkboxFour").removeClass('label_bg');
                parent.addClass('label_bg');
                $(".company_hide").hide();
            });

            //防止刷新页面验证短信码的手机号丢失
            $("#mobile").blur(function(){
               var mobile = $.trim($("#mobile").val());
               $('#ver').attr("ajaxurl","/member/verifyMsg?mobile="+mobile);
            });


            var send_click = false;
             //点击发送验证码
             $("#send_message").on('click', function() {
                if(send_click) {
                    return false;
                }

                //禁止频繁发送短信验证码
                send_click = true;
                var name = $.trim($("#name").val());
                 if(name.length == 0){
                     $(".registerform").submit();
                     send_click = false;
                     return false;
                 }

                var mobile = $.trim($("#mobile").val());
                //手机号为空先输入手机号
                if (mobile.length == 0) {
                    $(".registerform").submit();
                    send_click = false;
                    return false;
                }

                //禁用样式
                $(this).addClass('send_status');
                $("#send_message").html('验证码获取中...');
                $.ajax({
                    url: '/member/SendMsgCode',
                    data: {mobile: mobile},
                    dataType: 'json',
                    type: 'post',
                    success: function (data) {
                        if (data.status == 1) {
                            $('#ver').attr("ajaxurl","/member/verifyMsg?mobile="+mobile);
                            setTimeout(function () {
                                //短信验证码已发送禁用60s
                                var count_time = 60;
                                setInterval(function() {
                                       if (count_time < 0) {
                                           $("#send_message").html('免费获取验证码');
                                           //重置#send_message事件
                                           send_click = false;
                                           $("#send_message").removeAttr("disabled");
                                           $("#send_message").removeClass("send_status");

                                       }else {
                                           $("#send_message").attr("disabled", true);
                                           $("#send_message").html('('+count_time--+')秒后可重新获取');
                                       }
                                   }, 1000);
                            }, 600);
                        }
                        if (data.status == -1 || data.status == 0) {
                            setTimeout(function () {
                              $("#send_message").html('免费获取验证码');
                              $(".registerform").submit();
                            }, 600);
                        }
                    }
                });
            });

            </script>

            <div>
                    <div class="0427" style="margin-left: 83px; margin-top:-5px;">
                        <input style="position:relative;top: 3px;" name="agree" type="checkbox"  value="1" datatype="need" nullmsg="请同意微信服务协议！" sucmsg="验证通过！"/>
                        我同意并遵守<a href="#">《微信公众平台服务协议》</a>
                    <div class="Validform_checktip" style="left: -10px;"></div>
                    </div>
            </div>
            <input type="submit" value="下一步" class="button" style="margin-top: 30px;"/>
        </form>

        <dl>
            <dt><img src="<?php echo $this->_theme_url; ?>images/lo_bg06.png" alt="tu"></dt>
            <dd>大楚开放平台服务热线</dd>
            <dd>400-999-8888</dd>
        </dl>
    </div>
</div>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/validform.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/Validform_v5.3.2_min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/passwordStrength-min.js"></script>

<script type="text/javascript">
$(function(){
	$(".registerform").Validform({
		tiptype:function(msg,o,cssctl){
			if(!o.obj.is("form")){
				var objtip=o.obj.siblings(".Validform_checktip");
				cssctl(objtip,o.type);

                //判断密码的时候 没有用户已存在这一说
                if(o.obj.attr('name') == 'password' && msg == '用户已存在！'){
                    cssctl(objtip,2);
                    objtip.text('验证通过!');
                }else{
                    objtip.text(msg);
                }
			}
		},

		datatype:{
			"need":function(gets,obj,curform,regxp){
				numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
				if(numselected===1){
				   return true;
				}
				return  false;
			}
		},

               usePlugin:{
			passwordstrength:{
				minLen:6,
				maxLen:18
			}
		}

	});
});

//回车键提交表单
$(document).keypress(function(e) {
    if (e.which == 13){
        $(".registerform").submit();
    }
});
</script>
</body>
</html>