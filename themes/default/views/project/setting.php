<?php echo $this->renderpartial('/common/header_new', $config); ?>

<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/common-v1.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index_application_new.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/font-awesome.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/basis_config.css">

<?php echo $this->renderpartial('/common/header_app',array ('project_list'=>$project_list,'view'=> $view,'activity'=>$activity,'signUp'=>$signUp,'config'=>$config,'behavior'=>$behavior)); ?>
	<!-- 正文开始 -->
	<section id="main-content" class="clearfix">
		<div class="content">
			<!-- 引用基础配置模板（左侧导航） -->
<?php echo $this->renderpartial('/common/project_nav',array ('view'=> $view)); ?>
			<div class="content-right">
				<h4 class="config-list">
	                <span class="active"> 接口配置</span>
	            </h4>
				<div class="config-tip-info">
					<span>请务必保持下面信息正确，否则你的接口将不能正常工作。<a class="delete-cont" href="#">X</a>
				</div>
	
				<form id="form" method="post" action="/dappConfig/updateApiConfig">
					<input type="hidden" value="13877" id="app-id" name="appId">
					<div class="port_config-cont">
						<dl class="clearfix">
							<dt><label class="redff6c60">*</label> appid：</dt>
							<dd>
								<div class="port_input">
									<?php echo $view['appid']?>
									
								</div>
								<label class="error" for=""></label>
								<p class="gray8">该参数用来请求API接口的数据<a target="_blank" href="">技术文档</a></p>
							</dd>
						</dl>
						<dl class="clearfix">
							<dt><label class="redff6c60">*</label> appsecret：</dt>
							<dd>
								<div class="port_input">
									<?php if(strlen($view['appsecret']) == 32){?>
										<span id="app_ser">
										<?php echo str_replace(substr($view['appsecret'],1,30),"******************************",$view['appsecret']);?>
										</span>
										&nbsp;&nbsp;&nbsp;
										<a  id="appser_a" target="_blank" href="javascript:void(0);" no="1" onclick="selall('<?php echo $view['appsecret'];?>','<?php echo str_replace(substr($view['appsecret'],1,30),"******************************",$view['appsecret']);?>')">查看appsecret</a>
								   <?php  }else{ ?>
									  	 <span id="app_ser">
										 <?php echo str_replace(substr($view['appsecret'],1,14),"**************",$view['appsecret']);?>
										 </span>
									   	 &nbsp;&nbsp;&nbsp;
									     <a  id="appser_a" target="_blank" href="javascript:void(0);" no="1" onclick="selall('<?php echo $view['appsecret'];?>','<?php echo str_replace(substr($view['appsecret'],1,14),"**************",$view['appsecret']);?>')">查看appsecret</a>
								   <?php } ?>
								</div>
								<label class="error" for=""></label>
								<p class="gray8">该参数用来请求API接口的数据，查看<a target="_blank" href="">技术文档</a></p>
								<p class="gray8">(<span style="color: red">注:刷新appsecret时,对应的access_token也会更新！</span>)
								<a  id="update_apper_a" target="_blank" href="javascript:void(0);"  onclick="updateapp_ser('<?php echo $view['id'];?>')">刷新appsecret</a>
								</p>
							</dd>
						</dl>
						<dl class="clearfix">
							<dt><label class="redff6c60">*</label> wechaturl：</dt>
							<dd>
								<div class="port_input">
									<input type="text" id="wechat_url"  value="<?php echo $view['wechat_url']?>" >
								</div>
								<label class="error" for=""></label>
								<p class="gray8">自定义活动组件链接</p>
							</dd>
						</dl>
						<dl class="clearfix">
							<input  class="button_sumbit" style="margin-left: 30%;" type="button" value="提交" onclick="update_wecharurl('<?php echo $view['id'];?>')" />
						</dl>
						
						<!--  
						<dl class='clearfix'>
							<dt>兑换记录通知：</dt>
							<dd>
								<div class="port_input">
									<input type="text" value='' name="recordNotifyUrl" class='virtual_input' placeholder='用户兑换记录，将通过该接口请求通知'/>
								</div>
								<p class='gray8'>该接口用来向您的服务器发起兑换记录通知请求</p>
							</dd>
						</dl>
						-->
<!--						<dl class="clearfix b-n">
							<dt>&nbsp;</dt>
							<dd>
								<input type="button" value="保存配置" data-submit-btn="" class="button_sumbit" data-default-val="保存配置">
							</dd>
						</dl>-->
					</div>
				</form>
			</div>
		</div>
	</section>
<script>
	function selall(appser,appser2){
		if($("#appser_a").attr("no")==1) {
			$("#app_ser").html(appser);
			$("#appser_a").html("隐藏appsecret");
			$("#appser_a").attr("no",2);
		}else{
			$("#app_ser").html(appser2);
			$("#appser_a").html("查看appsecret");
			$("#appser_a").attr("no",1);
		}
	}

	function update_wecharurl(pid){
		url = $("#wechat_url").val();
		$.ajax({
			url:'<?php echo $this->createUrl("/project/UpdateWecharurl");?>',
			data:{pid:pid,wechaturl:url},
			dataType:'json',
			type:'post',
			success : function (data) {
				if (data.code == 200) {
					alert("修改成功");
					location.reload();

				} else {
					alert(data.mess);
					location.reload();

				}
			}
		});
	}

	function updateapp_ser(pid){
		$.ajax({
			url:'<?php echo $this->createUrl("/project/UpdateAppsecret");?>',
			data:{pid:pid},
			dataType:'json',
			type:'post',
			beforeSend: function(){  //防止重复提交数据
				$('.button').attr('onclick','javascript:void(0)');
			},
			success : function (data) {
				if (data.code == 200) {
					alert("刷新成功");
					location.reload();

				} else {
					alert(data.mess);
					location.reload();

				}
			}
		});
	}
</script>
	<!-- 正文结束 -->
<?php echo $this->renderpartial('/common/footer', $config); ?>
