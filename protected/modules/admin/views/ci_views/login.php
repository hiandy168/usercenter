<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>登录控制台</title>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/reg.css')?>" />
<script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
</head>
    <body>
        
        
        
        
<div class="logobox">
    <div class="logo">
        <h2>管理控制台--登录 </h2>
        <div class="mess">
			<p>轻松管理站点各种配置,快速发布编辑各种信息资源!完全开源,方便二次开发。开发者7*12小时在线,热情友好！</p>
		</div>
    </div>
</div>

<div class="loginbox">

    <div class="cl">  
         
        <div class="recommend">
            <img src="<?php echo base_url();?>public/images/login_say.jpg" alt=""/>  <!---登陆左边广告--->
        </div>
 
	    <div class="formLogin">
			<h2>管理员登陆</h2>
			<div class="login-form" id="login-form">
                                <form class="gc-form" id="form1" method="post" action="/login.html">
                                    <div class="con-box">
                                        <div class="fLRow">
                                            <label for="username">会员名：</label>
                                            <div class="fLRcell">
                                                <input vform_needverify="true" id="name" name="name" class="inputL" type="text">
                                            </div>
                                        </div>
                                        <div class="fLRow">
                                            <label for="passwd">密码：</label>
                                            <div class="fLRcell">
                                                <input vform_needverify="true" id="password" name="password" class="inputL" type="password">
                                            </div>
                                        </div>
                                       <div class="fLRow">
                                            <label for="passwd">验证码：</label>
                                            <div class="fLRcell">
                                                <input  style="width:50px;float:left" id='verify' name="verify" class="inputL"  type="text" style="">
                                                    <img id='verify_image' style="margin:0 0 0 5px;height:28px;float:right" src="<?php echo admin_url('login/verify_image')?>">
                                            </div>
                                        </div>
                                        <div class="fLRow rember">
                                            <input type="checkbox" id="rem" name="remember" value="1">
                                            <label for="rem">下次自动登录</label>
                                        </div>
                                    </div>
                                    <div class="loginBtm">
                                            <p><a href="#">登录遇见问题？<br>找回会员名或者密码</a></p>
                                            <div  id='lgBtn'><a class="lgBtn" href="javascript:;"><button type="button" onclick='login()'>登录</button></a></div>
                                    </div>
                                </form>
			</div>
		</div>

	</div>
	
	
</div>

<div id="footer">
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
                    ship_mess2('登陆中........',5000,'50','45');
            },
            success: function(data){
               if(data.state){
                   ship_mess2(data.mess,5000,'50','45');
                   location.href="<?php echo admin_url('main/index')?>"+'/'+ Math.random();
               }else{
                  ship_mess2(data.mess,5000,'50','45');
               }
            },
            error: function(){
                  ship_mess2('error',5000,'50','45');
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