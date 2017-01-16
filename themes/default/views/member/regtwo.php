<?php echo $this->renderpartial('/common/header_new',$config); ?>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/main.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>Vonders/Font-Awesome/css/font-awesome.css">
<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/jquery.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/home.js"></script>

<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    var admin_url = site_url+'/admin';
    $(document).ready(function(){
        var editor1 = KindEditor.create('.editor', {
            fileManagerJson:admin_url+"/files/file_manager",
            uploadJson:admin_url+'/files/upload',
            allowFileManager : true,
            formatUploadUrl :false,
        });
    });
</script>

<div class="lo_content">
    <div class="lo_box">
        <ul>
            <li>第一步：创建账户<span></span></li>
            <li class="lo_style lo2">第二步：完善信息<span></span></li>
            <li>第三步：注册成功<span></span></li>
        </ul>
        <style type="text/css">
            #checkboxFourInput02,
            #checkboxFourInput03 {
                opacity: 0;
                filter: alpha(opacity=0);
                position: relative;
                top: -3px;
            }

            .label_bg {
                background: url(<?php echo $this->_theme_url; ?>images/h-bg03.png) no-repeat center center;
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

.on_color {
    border: 1px solid #3d7bc2 !important;
}
        </style>
        <form class="registerform2" action="<?php echo Mod::app()->createUrl('/member/regThree')?>" method="post">
            <div>
                <em>姓名</em>
                <input type="text" id="username" name="username" class="inputxt" datatype="s2-18"  errormsg="请输入2-18位字符！" sucmsg="验证通过！"/>

                <div class="Validform_checktip"><i class="icon-exclamation-sign">请填写姓名</i></div>

            </div>
            <div>
                <em>手机号</em>
                <input type="text" id="mobile" name="mobile" class="inputxt" datatype="m" nullmsg="请填写手机号！" ajaxurl="/member/userIsNull" errormsg="请输入正确的手机号！" sucmsg="验证通过！"/>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i> 作为商家唯一标识</div>
               
            </div>
            <div>
                <em>邮箱</em>
                <input type="text" id="email" name="email" class="inputxt" datatype="e" nullmsg="请填写邮箱！"  errormsg="请输入邮箱！" sucmsg="验证通过！"/>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i>可绑定邮箱</div>
               
            </div>
           
           <!-- <div >
                <em>所属行业</em>
                <select class="company" name="company" id="company">
                    <option>请选择</option>
                    <option value="1">图书</option>
                    <option value="2">音像</option>

                </select>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i> 所属行业</div>  
            </div>-->

            <script type="text/javascript">
            $("#change_mobile_number").on('click', function() {
                $("#mobile_number").hide();
                $("#edit_mobile_number").removeAttr("readonly");
                $("#edit_mobile_number").addClass('on_color');
                $("#edit_mobile_number").focus();
            })
            </script>

            <input type="button" value="下一步" class="button" style="margin-top: 30px;">
        </form>

        <dl>
            <dt><img src="<?php echo $this->_theme_url; ?>images/lo_bg06.png" alt="tu"></dt>
            <dd>大楚开放平台服务热线</dd>
            <dd>400-999-8888</dd>
        </dl>
    </div>
</div>

<link rel="stylesheet" href="/themes/default/css/validform.css">
<script type="text/javascript" src="/themes/default/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/themes/default/js/Validform_v5.3.2_min.js"></script>

<script>
$(function(){
    $('.button').click(function(){
        var username = $('#username').val().trim();
        var phone = $('#mobile').val().trim();
        var email = $('#email').val().trim();
        //var company = $('#company').val().trim();
        //if(username.length <18 ){
            if(username.length < 2 || username.length > 18){
                ship_mess_big('用户名由2-18位字符组成')
                return false;
            }
       // }
        var reg = /^1[3|4|5|7|8]\d{9}$/;
        //if(phone.length > 0){
            if(!reg.test($.trim(phone))){
                $("#mobile").focus();
                ship_mess_big('请填写正确的手机号');
                return false;
            }
       // }
       // if(email.length > 0){
            if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/)) {
                ship_mess_big("邮箱格式不正确！请重新输入");
                $("#email").focus();
                return false;
            }
       // }
        $('.registerform2').submit();
    });

//	$(".registerform2").Validform({
//		tiptype:function(msg,o,cssctl){
//			if(!o.obj.is("form")){
//                var name = $('#username').val().trim();
//                var obj_name = $('#username').siblings(".Validform_checktip");
//                if(name.length > 0){
//                    obj_name.show();
//                    $('#username').attr('datatype','s2-18');
//                }else{
//                    obj_name.hide();
//                    $('#username').attr('style','background:white;');
//                    $('#username').attr('placeholder','请输入姓名');
////                    return false;
//                }
//
//                var tel = $('#mobile').val().trim();
//                var obj_tel = $('#mobile').siblings(".Validform_checktip");
//                if(tel.length > 0){
//                    obj_tel.show();
//                    $('#mobile').attr('datatype','m');
//                }else{
//                    obj_tel.hide();
//                    $('#mobile').attr('style','background:white;');
//                    $('#mobile').attr('placeholder','请输入手机号');
////                    return false;
//                }
//
//                var email = $('#email').val().trim();
//                var obj_email = $('#email').siblings(".Validform_checktip");
//                if(email.length > 0){
//                    obj_email.show();
//                    $('#email').attr('datatype','e');
//                }else{
//                    obj_email.hide();
//                    $('#email').attr('style','background:white;');
//                    $('#email').attr('placeholder','请输入邮箱');
////                    return false;
//                }
//
//				var objtip=o.obj.siblings(".Validform_checktip");
//				cssctl(objtip,o.type);
//				objtip.text(msg);
//			}
//		},
//	});
})    

//回车键提交表单
$(document).keypress(function(e) {
    if (e.which == 13){
        $(".registerform2").submit();
    }
});

</script>

</body>
</html>