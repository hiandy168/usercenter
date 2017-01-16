<?php echo $this->renderpartial('/common/header_new',$config); ?>

<style>
    .enclick{
        width: 150px;display: inline-block;line-height: 36px;float: right;margin-right: 14px;text-align: center;
    }
    .unclick{
        background: #999;
    }
</style>
<div class="ad-reg-form w1000 clearfix bxbg mgt30">

    <div class="ad-reg-form-tit clearfix">
        <ul>
            <li class="selected">
                第一步：创建用户
                <i></i>
            </li>
            <li>
                第二步：完善信息
                <i></i>
            </li>
            <li>
                第三步：注册成功
            </li>
        </ul>
    </div>

    <form action="<?php echo Mod::app()->createUrl('/member/RegTwo')?>" id="regform1" method="post" accept-charset="utf-8">

        <div class="ad-reg-form1">
            <div class="ad-creat-app-inp">
                <span class="sp1">手机号：</span>
            		<span class="sp2">
            			<input class="form-control"  type="text" placeholder="" name="uname" id="uname1" value="" />
            		</span>
                    <br/>
            </div>
            <div class="ad-creat-app-inp">
                <span class="sp1">短信验证</span>
                <span class="sp2">
                <input id="codes" type="text" name="codes" class="form-control" style="width: 45%;float: left;";/>
                 <a href="javascript: void(0);"  id="rsend_message" class="adbtn enclick linear" onclick="rsend_code()">免费获取验证码</a>
                </span>  
            </div>

            <div class="ad-creat-app-inp">
                <span class="sp1">密码：</span>
            		<span class="sp2">
            			<input class="form-control" onkeyup="checkpwrank(this)" type="password" placeholder="" name="upassword" id="upassword" value="" />
            		</span>


            </div>

            <div class="ad-creat-app-inp ad-reg-form-passrank1">
                <span class="sp1">密码强度：</span>
            		<span class="sp2">
            	<div class="ad-reg-form-passrank">
                    <li>弱</li>
                    <li>中</li>
                    <li>强</li>
                </div>
            		</span>
            </div>




            <div class="ad-creat-app-inp">
                <span class="sp1">确认密码：</span>
            		<span class="sp2">
            			<input class="form-control" type="password" placeholder="" name="upwd1" id="upwd1" value="" />
            		</span>


            </div>


            <div class="ad-creat-app-inp">
                <span class="sp1">&nbsp;</span>
                <label for="xiyi" class="sp2 clearfix" style="display: inline-block;float: left;
line-height: 36px;">

                    <input style=" margin: 0;position: relative;top: 2px;" type="checkbox" checked="checked" name="xiyi" id="xiyi" value="" />
                    我同意并遵守<a href="<?php echo $this->createurl('agreement/index')?>" style="color: #0091d5">《大楚开放平台服务协议》</a>
                </label>

            </div>


            <div class="ad-creat-app-inp">
                <span class="sp1">&nbsp;</span>
            		<span class="sp2">
            			<div class="ad-creat-app-formbtn">
                            <input class="linear adbtn" type="submit" name="" id="" value="下一步" />
                        </div>
            		</span>

            </div>


        </div>

    </form>


</div>

<style>
    #uname1-error{margin-left: 120px;}
</style>

<script type="text/javascript">


    //倒计时60秒
     function timer(){
         var times = $('#rsend_message .time').html();
//        alert(times);
         if(times > 1){
             --times;
             $('#rsend_message .time').html(times);
             setTimeout(function(){
                 timer();
             },1000);
         }else{
             $('#codes').focus();
             $("#rsend_message").removeClass('unclick');
             $("#rsend_message").attr("onclick",'send_code()');
             $("#rsend_message").html('免费获取验证码');

         }
     }
    /*发送验证码*/
    function rsend_code(){
            if($("#uname1").parent().next().next().text()=="正确"){
              var tel = $("#uname1").val();
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if(!reg.test($.trim(tel))){
            $("#uname1").focus();
            layer.msg('请填写正确的手机号!');
            return false;
        }

        $.ajax({
            url: site_url+'/member/SendMessage',
            data: {mobile: tel},
            dataType: 'json',
            type: 'post',
            beforeSend:function(){
                $("#rsend_message").addClass('unclick');
                $("#rsend_message").attr("onclick",'');
            },
            success: function (data) {
                layer.msg(data.info);
                if (data.status) {
//                        $('#ver').attr("ajaxurl","<?php //echo Mod::app()->createUrl('/member/verifyMsg')?>//?mobile="+mobile);
                    setTimeout(function () {
                        $("#rsend_message").html('<i class="time">60</i>秒后重新获取');
                        timer();
                    }, 100);
                }
            }
        });
            }else{
               layer.msg('请填正确手机号.');
            }
        
    }
  

    var Validator = $("#regform1").validate({
        rules: {
            uname: {
                required: true,
                minlength: 11,
                isMobile: true,
                remote: {
                    url: "<?php echo Mod::app()->createUrl('/member/nameIsNull')?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        parmar: function() {
                            return $("#uname1").val();
                        }
                    },
                    dataFilter: function (data) {
                        if (data ==0) {
                            return true;   
                        }else if(data ==2){
                            return false;   
                        }
                        else {
                            return false;   
                        }
                    },
                },
     
            },
            codes:{
               required: true,
                remote: {
                    url: "/member/PcverifyMsg",
                    type: "post",
                    dataType: "json",
                    data: {
                        mobile: function() {
                           return $("#uname1").val();
                        },
                        param: function() {
                            return $("#codes").val();
                        }
                    },
                    dataFilter: function (data) {
                    console.log(data);
                      if (data ==1) {
                            return true;   
                        }else{
                            return false;   
                        }
                    },
                },
            },
            upassword: {
                required: true,
                rangelength: [8, 16],
            },
            upwd1: {
                required: true,
                rangelength: [8, 16],
                equalTo: "#upassword"

            },
            xiyi: {
                required: true,
            },
        },

        messages: {
            uname: {
                required: "请输入用户名（手机号）",
                minlength: "手机号长度为11位",
                isMobile: "请输入正确手机号",
                remote:"该手机号已绑定大楚通行证，请补充设置密码并完善注册信息",

            },
            codes:{
               required: "请填写验证码",
                remote:"验证码不正确",
            },
            upassword: {
                required: "密码不能为空",
                rangelength: "密码长度为8到16位",
            },
            upwd1: {
                required: "请再次输入密码",
                rangelength: "密码长度为8到16位",
                equalTo: "两次输入密码不一致"

            },
            xiyi: {
                required: "请同意协议",
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            if (element.parent().parent().find('em') != null) {
                element.parent().parent().find('em').remove()
            }
            error.appendTo(element.parent().parent());
        },

        errorClass: "cerror",
        validClass: "cright",

        success: function(obj) {
            obj.text("正确").removeClass('cerror').addClass("cright");
        },
   


    });

    // 手机号码验证
    jQuery.validator.addMethod("isMobile", function(value, element) {
        var length = value.length;
        var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
        return this.optional(element) || (length == 11 && mobile.test(value));
    }, "请正确填写您的手机号码");


    //密码强度校验
    function checkpwrank(obj) {
        if ($(obj).val().length > 1) {
            $(".ad-reg-form-passrank li").eq(0).addClass("c1");
        } else {
            $(".ad-reg-form-passrank li").eq(0).removeClass("c1");

        }
        if ($(obj).val().length > 8) {
            $(".ad-reg-form-passrank li").eq(1).addClass("c1");
        } else {
            $(".ad-reg-form-passrank li").eq(1).removeClass("c1");

        }
        if ($(obj).val().length > 12) {
            $(".ad-reg-form-passrank li").eq(2).addClass("c1");
        } else {
            $(".ad-reg-form-passrank li").eq(2).removeClass("c1");

        }
    }
</script>
<?php echo $this->renderpartial('/common/footer',$config); ?>