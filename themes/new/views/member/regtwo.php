<?php echo $this->renderpartial('/common/header_new',$config); ?>
<div class="ad-reg-form w1000 clearfix bxbg mgt30">

    <div class="ad-reg-form-tit clearfix">
        <ul>
            <li>
                第一步：创建用户
                <i></i>
            </li>
            <li class="selected">
                第二步：完善信息
                <i></i>
            </li>
            <li>
                第三步：注册成功
            </li>
        </ul>
    </div>
    <form action="<?php echo Mod::app()->createUrl('/member/regThree')?>" id="regform2" method="post" accept-charset="utf-8">

        <div class="ad-reg-form1">

            <div class="ad-creat-app-inp">
                <span class="sp1">姓名：</span>
            		<span class="sp2">
            			<input class="form-control" type="text" placeholder="例：张三" name="username" id="cname" value="" />
            		</span>


            </div>


            <div class="ad-creat-app-inp">
                <span class="sp1">邮箱：</span>
            		<span class="sp2">
            			<input class="form-control" type="text" placeholder="" name="email" id="cemail" value="" />
            		</span>

            </div>





    <!--        <div class="ad-creat-app-inp">
                <span class="sp1">所属行业：</span>
            		<span class="sp2 sp3">
            			<div class="ad-reg-form-sel">
                            <select name="company">
                                <option value="">请选择行业</option>
                                <option value="1">教育</option>
                                <option value="2">事业</option>
                                <option value="3">互联网</option>
                            </select>
                        </div>
            		</span>


            </div>
-->

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


<script type="text/javascript">
    var Validator = $("#regform2").validate({


        rules: {
            username: {
                required: true,
                minlength: 2

            },
            mobile: {
                required: true,
                minlength: 11,
                isMobile: true
            },
            email: {
                required: true,
                email: true

            },
            ckind:{
                required: true,
            },
        },

        messages: {
            username: {
                required: "请填写姓名",
                minlength: "姓名长度至少两位"

            },
            mobile: {
                required: "请填写手机号",
                minlength: "手机号长度为11位",
                isMobile: "请填写正确手机号"
            },
            email: {
                required: "请填写邮箱",
                email: "邮箱格式不正确"

            },
            ckind:{
                required: "请选择行业",
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


</script>
<?php echo $this->renderpartial('/common/footer',$config); ?>