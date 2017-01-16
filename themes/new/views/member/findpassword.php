<?php echo $this->renderpartial('/common/header_new',$config); ?>
    <!-- 头部导航 end-->
<style>
.psd-body { margin: 20px 100px; margin-top: 50px; }
.psd-body .contact { margin-left: 140px; line-height: 26px; }
.psd-body .field { position: relative; overflow: hidden; margin-bottom: 20px; }
.psd-body .field .view { }
.psd-body .field label { float: left; width: 130px; text-align: right; line-height: 36px; margin-right: 10px; }
.psd-body .field input { width: 50%; float: left; }
.psd-body .field .error { float: left; color: red; line-height: 36px; margin-left: 10px; display: none; }
.psd-body .field .tips { margin-top: 40px; margin-left: 140px; }
.psd-body .sub_btn { margin-left: 140px; width: 62%; }
.psd-body .tel { }
.psd-body .tel .reset { float: left; margin-left: -30px; margin-top: 8px; cursor: pointer; }
.psd-body .codes { }
.psd-body .codes input { width: 28%; }
.psd-body .codes .btn_time { float: left; margin-left: 2%; width: 20%; display: inline-block; line-height: 36px; text-align: center; }
.psd-body .password { }
.psd-body .confirm { }
</style>

<div class="ad-act-list w1000 bxbg mgt30 clearfix">

<div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>密码找回</h3>
            </div>
           <!--  <div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>登录
                </a>
            </div> -->
        </div>


           <div class="psd-body">
                <form>
                    <div class="field tel">
                        <label>手机号</label>
                        <input type="text" name="tel" class="col2 form-control" id="tel"/>
                        <img src="<?php echo $this->_siteUrl; ?>/themes/default/images/yl_19.png" class="reset">
                        <p class="tel_error error">请填写正确的手机号</p>
                        
                    </div>
                    <div class="field codes">
                        <label>短信验证</label>
                        <input id="codes" type="text" name="codes" class="col1 form-control"/>
<!--                        <input type="button" name="get_codes" class="btn" value="免费获取验证码"/>-->
                        <a href="javascript: void(0);" id="send_message" class="btn_time adbtn linear" onclick="send_code()">免费获取验证码</a>
                        <p class="codes_error error">请输入正确验证码</p>
                    </div>
                    <div class="field password">
                        <label>新密码</label>
                        <span id="show_pass">
                            <input id="pass" type="password" name="pass" class="col2 form-control"/>
                        </span>
                        <p class="password_error error">请输入规范密码</p>
                        <p class="tips">字母、数字或者英文符号，最短8位，区分大小写</p>
                        <div class="view" onclick="showPass('pass')"></div>
                    </div>
                    <div class="field comfirm">
                        <label>确认密码</label>
                        <span id="show_repass">
                            <input id="repass" type="password" name="repass" class="col1 form-control"/>
                        </span>
                        <p class="comfirm_error error">密码不一致</p>
                        <p class="tips">请再次输入密码</p>
                        <div class="view" onclick="showPass('repass')"></div>
                    </div>
                    <div class="field sub_btn">
                        <input id="sub" type="button" name="btn" class="adbtn linear" value="确认"/>
                    </div>
                </form>

                <div class="contact">
                    <p>上述方法无法找回？客服来帮助你：<br/>
                    1、发邮件到<span>guest@tengchuqq.com</span>(邮件记得备注登录名哦~)<br/>
                    2、拨打客服热线：<span>027-88889989</span></p>
                </div>

            </div>



</div>


            




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
            layer.msg('手机号码不能为空');
            return false;
        }
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        if(!reg.test($.trim(tel))){
            $("#tel").focus();
            layer.msg('请填写正确的手机号');
            return false;
        }

        $.ajax({
            url: site_url+'/member/SendMessage',
            data: {mobile: tel},
            dataType: 'json',
            type: 'post',
            beforeSend:function(){
                $("#send_message").attr('style', "background:#C6C6C6 " );
                $("#send_message").attr("onclick",'');
            },
            success: function (data) {
                layer.msg(data.info);
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
                layer.msg('手机号不能为空');
                return false;
            }
            var reg = /^1[3|4|5|7|8]\d{9}$/;
            if(!reg.test($.trim(phone))){
                layer.msg('请填写正确的手机号');
                return false;
            }
            //验证码不能为空
            if(codes.trim() == ''){
                layer.msg('验证码不能为空');
                return false;
            }
            //判断验证码是否正确
            $.ajax({
                url:'/member/verifyMsg',
                data:{mobile:phone,param:codes},
                dataType:'json',
                type:'post',
                success: function (data) {
                    if(data.status == 'n'){
                        layer.msg(data.info);
                        return false;
                    }
                }

            });

            if(pass==""){
                layer.msg('密码不能为空');
                return false;
            }
            if(pass != repass){
                layer.msg('两次密码输入不一致');
                return false;
            }
//            console.log(pass+repass);
            $.ajax({
                url:'/member/ajaxFindPass',
                data:{phone:phone,ver:codes,pass:pass,repass:repass},
                dataType:'json',
                type:'post',
                success: function (data) {
                    // layer.msg(data.mess);
                    if (data.state) {
                        layer.msg(data.mess);
                       // window.location.href = "<?php echo $this->createUrl('/member/login'); ?>";
                        window.location.href = "http://<?php echo $_SERVER['HTTP_HOST']; ?>";
                    }

                }

            });
        })
    });
    </script>
    
    

<?php echo $this->renderpartial('/common/footer',$config); ?>