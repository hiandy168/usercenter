<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link rel="stylesheet" href="<?php echo $this->_theme_url ?>css/reg.css" type="text/css" > 
<!--{literal}-->
<style>
label.error {font-weight: bold;color: #b80000;}
.normal,.error,.ok{margin:0;background:none;}
.register label {float: left; height:30px; line-height: 30px;  margin-right: 15px;}
label.error { color: #B80000;font-weight: normal;}

#resend:hover{cursor: pointer;}
.footer{top:500px;}
</style>
<script>
$(document).ready(function() {
  $('#resend').click(function (){
	 $.ajax({
                    url:$('#resend').attr('href') ,
                    type: 'POST',
                    dataType: 'json',
                    timeout: 10000,
                    error: function(){alert('Error Comment');},
                    success: function(data){
                        ship_mess(data.mess);
                    }
            });
	 return false;
   });	
 })                                  
</script>
                                    


<div class="register">
    <div class="step">
        <div class="step1">
            <h5>1</h5>
            <p>填写基本信息</p>
        </div>
        <div class="step2 active">
            <h5>2</h5>
            <p>注册成功</p>
        </div>
    </div>
<!-- {if $result===true} -->
	<div class="success">
		<h3><i>&radic;</i>恭喜您：{$username}  注册成功！您是<font style="color:#910A2B">{$groupname}</font><img src="{$groupimg}" alt="{$groupname}" title="{$groupname}" /><br>您可以直接登录{$_G.site_name}。</h3>
		<p>为了保证您的帐号安全，帮助您及时把握商机，建议您立即验证邮箱：</p>
        <div class="link"><a class="enterLogin" href="virtual-office/">进入商务室</a><a href="./index.php">返回首页</a></div>
	</div>
	
	<div class="wanshan">
		<h4>完善资料</h4>
		<p style="margin-bottom:15px;">发布供求信息、提交产品资料，均需要有完善的个人联系资料</p>
                 {if $is_company}
                    <a href="virtual-office/company.php"  class="checkmail" >点此处完善资料</a>
		 {else}
                    <a href="virtual-office/personal.php"  class="checkmail" >点此处完善资料</a>
                 {/if}
	</div>

<!-- {else}-->
        <div class="success">
		<h3><i>&radic;</i>恭喜您：{$username}  注册成功！您是<font style="color:#910A2B">{$groupname}</font><img src="{$groupimg}" alt="{$groupname}" title="{$groupname}" /><br>但是要<font style="color:#910A2B">验证邮箱</font>才可以登录！<br>为了保证您的帐号安全，帮助您及时把握商机，请您立即<font style="color:#910A2B">验证邮箱</font>：</h3>
	</div>
	
	<div class="wanshan">
		{$RegTips}
	</div>
<!-- {/if} -->
</div>

<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
