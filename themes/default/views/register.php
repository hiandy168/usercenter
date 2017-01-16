<?php $this->renderPartial('/common/header',array('config'=>$config));?>

    <script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/ui.js"></script>
	
	<div class="wp">
	    <div class="logo2">
		    <a href="www.cbo.cn"><img src="<?php echo $this->_theme_url ?>images/logo2.gif" /></a>
		</div>
	</div>

	<!--头部 end -->
	<!--主体部分 begin-->
	<div class="regist">
		<div class="register cl">
			<!--表单部分 begin-->
			<div class="registbox ">
				<div class="registboxer">
					<h2>注册化妆品财经在线</h2>
					<div class="formbox">
                                            <form id="form3" name="form1" method="POST" action="" autocomplete="off">
							<div class="linebox">
								<span class="line_titler">手机号</span>
								<span class="line_text">
									<input type="text" id="username" name="phone" class="telephone focus" placeholder="输入手机号" />
								</span>
							</div>
<!--							<div class="linebox">
								<span class="line_titler">验证码</span>
								<span class="line_text">
									<input type="text" name="verify" id="verify" class="verificatCode " placeholder="验证码" />
								</span>
								<span class="getyzm">
									<a href="javascript:void(0);">
										<img class="zhuceyzm"   id='verify_image' src="<?php echo Mod::app()->createUrl('member/verify_image')?>" />
									</a>
									<a data-url="" href="javascript:void(0);" class="nextyzm" id ='verify_image'>
										换一张
									</a>
								</span>
							</div>-->
							<div class="linebox">
								<span class="line_titler littersize">
									短信验证码
								</span>
								<span class="line_text">
									<input type="text" name="phoneverify" id="phoneverify" class="verificatCode telephone"
									placeholder="短信验证码" autocomplete="off" onblur="if(this.value=='') this.value='';" onfocus="if(this.value=='') this.value='';" />
								</span>
								<span class="getcode">
									<a href="javascript:void(0);" id="getphoneverify">
										获取验证码
									</a>
								</span>
							</div>
                                                        <script type="text/javascript">
                                                        var getphoneverify_btn  = "getphoneverify";
                                                        var wait=60;
                                                        var waittime=wait;
                                   
                                                        $('#'+getphoneverify_btn).click(function(){getVerify();});
                                                        
                                                        function getVerify() {
                                                            var  btnobj =  $('#'+getphoneverify_btn) ;
                                                            var  phone = $('#username').val();
                                                           
                                                            if(phone==""){
                                                                    UI.popup({
                                                                            type:1,
                                                                            html:'手机号码不能为空xx'
                                                                    });
                                                                    return false;
                                                            }else{
                                                                    var reg = /^1[3|5|8]\d{9}$/;
                                                                    if(reg.test(phone)==false){
                                                                            UI.popup({
                                                                                    type:1,
                                                                                    html:'请输入正确的电话号码格式'
                                                                            });
                                                                            return false;
                                                                    }
                                                            }
                                                            
                                                            $.ajax({
                                                                type: "post",
                                                                url: "<?php echo  $this->createUrl('member/sendverifycode')?>",
                                                                data:{phone:phone},
                                                                dataType:'json'
                                                            });
                                                           timeshow(btnobj);
                                                        //   setInterval(timeshow,1000);
                                                        }
                                                        function timeshow(btnobj){
                                                                 btnobj.attr("disabled","disabled"); 
                                                                if (wait == 0) {
                                                                   btnobj.removeAttr("disabled");       
                                                                   btnobj.html("获取验证码");
                                                                    wait = waittime;
                                                                } else {
                                                                    btnobj.attr("disabled","disabled"); 
                                                                    btnobj.html("重新发送(" + wait + ")");
                                                                    wait--;
                                                                    setTimeout(function() {
                                                                        timeshow(btnobj);
                                                                    },
                                                                    1000);
                                                                }
                                                        }

                                                        </script> 

							<div class="linebox">
								<span class="line_titler">
									密码
								</span>
								<span class="line_text">
									<input type="password" id="password" name="password" class="telephone" placeholder="8 — 16 位字母数字组合 "
									/>
								</span>
							</div>
                                                        <div class="linebox">
								<span class="line_titler">
									重复密码
								</span>
								<span class="line_text">
									<input type="password" id="repassword" name="repassword" class="telephone" placeholder="8 — 16 位字母数字组合 "
									/>
								</span>
							</div>

                                                         <div class="linebox">
								<span class="line_titler">
                                                                    
								</span>
								<span class="line_text">
									<input type="checkbox" id="agree" name="agree" class=""  checked='checked' />勾选同意<a targrt="_blank"  style="color:#00a0e9 " href="./xieyi.html">本站协议</a>
								</span>
							</div>


							<div class="lineboxsure">
								<input type="button" name="button" value="注册" id="zhuce" class="goregist"
								/>
								<span>
									已经有账号？
									<a href="/login/index.html">
										请登录
									</a>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!--表单部分 end-->
			<!--二维码部分 begin-->
			<div class="qrcode">
				<div class="codepic" id="login_container">
                         
                                </div>
			</div>
			<!--二维码部分 end-->
		</div>
	</div>
	<!--主体部分 -->
	
	
	<!--底部 end-->
	<div class="footer">
		<div id="main_width">
					
			<?php $this->renderPartial('/common/footer',array('config'=>$config));?>

		</div>
		<div class="clear"></div>
	</div>


	

</body>
<script>
var Siteurl ="<?php echo $this->_siteUrl; ?>";
</script>
<script src="<?php echo $this->_theme_url ?>js/login.js"></script>

</html>