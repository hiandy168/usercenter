<?php echo $this->renderpartial('/common/header_1',$config); ?>
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
            <li class="lo_style">第二步：完善信息<span></span></li>
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

            .Validform_checktip {
    position: relative;
    left: 73px;
    top: 10px;
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
        <form class="registerform2" action="<?php echo Mod::app()->createUrl('/member/regthree')?>" method="post">
            <div class="company_hide">
                <em>公司名称</em>

                <input id="company" name="company" type="text" placeholder="请输入公司名称">

            </div>

            <div class="company_hide">
                <em>公司地址</em>

                <input id="address" name="address" type="text" placeholder="请输入公司地址">

            </div>

            <div class="input_style04">
                <em>联系人姓名</em>

                <input id="contact" name="contact" type="text" placeholder="请输入联系人姓名">
            </div>

            <div class="input_style04">
                <em>联系人邮箱</em>
                <input type="text" name="email" id="email" class="inputxt" datatype="e"  errormsg="请输入正确的邮箱！" ignore="ignore" placeholder="请输入邮箱"/>
                <div class="Validform_checktip"></div> 
            </div>

<!--            <div class="input_style05">
                <em>手机号</em>
                <input style="border-color: #e7e7eb;" type="text" name="phone" id="edit_mobile_number" class="inputxt" datatype="m" errormsg="请输入正确的手机号！" ignore="ignore" ajaxurl="<?php echo Mod::app()->createUrl('/member/isUserNull')?>"  value="<?php echo Mod::app()->session['member']['name']; ?>" readonly="readonly"/>
                <a href="javascript:void(0);" id="change_mobile_number">修改</a>
                <div class="Validform_checktip"><i class="icon-exclamation-sign"></i> 点击修改可更换手机号</div> 
            </div>-->

            <script type="text/javascript">
            $("#change_mobile_number").on('click', function() {
                $("#mobile_number").hide();
                $("#edit_mobile_number").removeAttr("readonly");
                $("#edit_mobile_number").addClass('on_color');
                $("#edit_mobile_number").focus();
            })
            </script>

            <div class="company_hide">
                <em style="float: left;">公司资质</em>
                <div id="u48" class="text" style="float: left;">
                    <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','icon')"  src="<?php  echo JkCms::show_img('')?>"  id="img_thumb">

                    <input type="hidden" name="icon" id="icon" value="">
                    <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                        <span  class="btn btn-danger" onclick="upload_pic('img_thumb','icon')"><?php echo Mod::t('admin','upload_pic')?></span>
                    </p>
                </div>
            </div>

            <input type="submit" value="确 定" class="button" style="margin-top: 30px;"/>
        </form>

        <dl>
            <dt><img src="<?php echo $this->_theme_url; ?>/images/lo_bg06.png" alt="tu"></dt>
            <dd>大楚开放平台服务热线</dd>
            <dd>400-999-8888</dd>
        </dl>
    </div>
</div>

<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/validform.css">
<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/Validform_v5.3.2_min.js"></script>

<script>
$(function(){	
	$(".registerform2").Validform({
		tiptype:function(msg,o,cssctl){
			if(!o.obj.is("form")){
				var objtip=o.obj.siblings(".Validform_checktip");
				cssctl(objtip,o.type);
				objtip.text(msg);
			}
		},                                        
	});
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