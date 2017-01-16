<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录控制台</title>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/login_color.css')?>" />
<script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/jquery.SuperSlide.2.1.1.source.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
</head>
    <body>
        
   

<div class="header">
    <div class="logo">
        
        <?php if(isset($setting['site_login'])){?>
        <a title="<?php echo $setting['site_name']?>" target="_blank" href="<?php echo base_url()?>"><img alt="<?php echo $setting['site_name']?>" src="<?php echo $setting['site_login']?>"> </a>
        <?php }else{ ?>
            <span>管理控制台--登录</span>
        <?php } ?>
       
    </div>
	<div class="nav">
            <p>轻松管理站点各种配置,快速发布编辑各种信息资源!完全开源,方便二次开发。开发者7*12小时在线,热情友好！<a style="text-decoration: underline" href="tencent://message/?uin=5367604&Site=&Menu=yes">在线咨询QQ：5367604</a></p>
                       
	</div>
</div>

<div class="banner">

<div class="login">
  <div id="bg"></div>
  <div id="down_box"  style="table-layout:fixed;">
            <div id="mess_box"></div>
            <form autocomplete='off'>
                <div class="fm-item">
                       <label for="logonId" class="form_label">用户名</label>
                       <input type="text" value="输入账号" maxlength="100" id="name" name="name" onfocus="$(this).val('')" onblur="if(!$(this).val())$(this).val('输入账号')"> 
                   <div class="ui-form-explain"></div>
                </div>
                <div class="fm-item">
                       <label for="logonId" class="form_label">登陆密码：</label>
                       <input type="password" value="" maxlength="100"  id="password" name="password" >     
                   <div class="ui-form-explain"></div>
                </div>

                <div class="fm-item pos-r">
                       <label for="logonId" class="form_label">验证码</label>
                       <input type="text" value="输入验证码" maxlength="100" id='verify' name="verify"  style="float:left;width:112px"  onfocus="$(this).val('')" onblur="if(!$(this).val())$(this).val('输入验证码')"> <img id='verify_image' style="margin:0 0 0 5px;height:32px;float:left" src="<?php echo admin_url('login/verify_image')?>">
                </div>

                <div class="fm-item">
                       <label for="logonId" class="form_label"></label>
                       <input type="button" value="登录" tabindex="4" class="btn" onclick='login()'> 
                   <div class="ui-form-explain"></div>
                </div>
            </form> 
  </div>
</div>

	<div class="bd">
		<ul>
                <li><img src='<?php echo base_url();?>public/images/Wallpaper/1.jpg'></li>
		</ul>
	</div>
</div>
<script type="text/javascript">jQuery(".banner").slide({ titCell:".hd ul", mainCell:".bd ul", effect:"fold",  autoPlay:true, autoPage:true, trigger:"click",interTime:5000});</script>
<div class="footer">
    Powered by  <a href="http://9open.com">9open.com</a>&nbsp;&nbsp;<a href="http://ufenc.com">ufenc.com</a>&nbsp;&nbsp;<a href="http://ufena.com">ufena.com</a>&nbsp;&nbsp;<a href="<?php echo base_url();?>" title="返回首页">返回首页</a>

</div>   
<script type="text/javascript">
var admin_url ="<?php echo admin_url()?>";
function login(){
       var name     = document.getElementById("name").value;
       var password = document.getElementById("password").value;
       var verify   = document.getElementById("verify").value;
        $.ajax({
            type: "post",
            url: "<?php echo admin_url('login/ajax_login')?>",
            data:{name:name,password:password,verify:verify},
            dataType:'json',
            beforeSend: function(){
                $('#mess_box').html('登陆中........');
            },
            success: function(data){
               if(data.state){
                      $('#mess_box').html(data.mess);
                   location.href="<?php echo admin_url('main/index')?>"+'/'+ Math.random();
               }else{
                        $('#mess_box').html(data.mess);
               }
            },
            error: function(){
                       $('#mess_box').html(data.mess);
            }
        });
        
}
$(document).keypress(function(e) {
if (e.which == 13)  
	login(); 
});
</script>


        

</body>
</html>