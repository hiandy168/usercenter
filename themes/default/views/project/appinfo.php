<?php echo $this->renderpartial('/common/header_new', $config); ?>

<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/common-v1.css">
<!--  <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index_application_new.css">-->
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/font-awesome.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/basis_config.css">
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
	var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
	var admin_url = site_url + '/admin';
	$(document).ready(function () {
		var editor1 = KindEditor.create('.editor', {
			uploadJson: admin_url + '/files/upload',
		});
	});
</script>


<?php echo $this->renderpartial('/common/header_app',array ('project_list'=>$project_list,'view'=> $view,'fun'=>'edit','activity'=>$activity,'signUp'=>$signUp,'config'=>$config,'pid'=>$pid,'behavior'=>$behavior)); ?>
	<!-- 正文开始 -->
	<section id="main-content" class="clearfix">
		<div class="content">
			<!-- 引用基础配置模板（左侧导航） -->
<?php echo $this->renderpartial('/common/project_nav',array ('view'=> $view)); ?>

			<div class="content-right">
				<h4>应用信息</h4>
				<form novalidate="novalidate" action="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$view->id)); ?>" method="post" id="form">
                                <input name="id" value="<?php echo $view->id?>" type="hidden">
					<div class="label-cont clearfix">
					        <dl class="clearfix">
							<dt>应用名称：</dt>
							<dd><input value="<?php echo $view['name']?$view['name']:''?>" name="name" maxlength="15" placeholder="请输入你的应用名称" type="text"></dd>
						</dl>
						<dl class="clearfix">


							<dt class="line50i">应用图标：</dt>
							<dd>
								<div class="appli_icon">
<!--									<img src="--><?php //echo $this->_theme_url; ?><!--images/appli_icon_img.png" alt="" id="logo-image" onclick="file.click()" height="50" width="50">-->
									<input name="wechat_url" value="<?php echo $view['wechat_url']?>" id="icon1" type="hidden">
									<img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($view['wechat_url']) ?>" id="img_thumb1"  height="50" width="50"/>
									<p><label class="orange">注</label>：应用图标为<strong>选填项</strong>，规格为100*100像素png图片</p>
								</div>
							</dd>
						</dl>
	
						<dl class="clearfix">
							<dt>简介</dt>
                                                        <dd><textarea name='introduction'style='width:430px;height:100px;'><?php echo $view['introduction']?$view['introduction']:''?></textarea></dd>
						</dl>
						
						<dl class="clearfix">
							<dt>服务器地址：：</dt>
							<dd><input class="unitNameInput" name="url" value="<?php echo $view['url']?$view['url']:''?>" type="text"></dd>
							
						</dl>
						
						
						<dl class="clearfix">
							<dt>应用类别：</dt>
							<dd>
								<select name="type" class="select" >
                                    <option value="" >请选择</option>
                                    <option value="新闻" <?php if($view['type']=='新闻'){?>selected="selected"<?php } ?>>新闻</option>
                                    <option value="房产"<?php if($view['type']=='房产'){?>selected="selected"<?php } ?>>房产</option>
                                    <option value="汽车"<?php if($view['type']=='汽车'){?>selected="selected"<?php } ?>>汽车</option>
                                    <option value="家居"<?php if($view['type']=='家居'){?>selected="selected"<?php } ?>>家居</option>
                                    <option value="健康"<?php if($view['type']=='健康'){?>selected="selected"<?php } ?>>健康</option>
                                    <option value="社区"<?php if($view['type']=='社区'){?>selected="selected"<?php } ?>>社区</option>
                                    <option value="教育"<?php if($view['type']=='教育'){?>selected="selected"<?php } ?>>教育</option>
                                    <option value="亲子" <?php if($view['type']=='亲子'){?>selected="selected"<?php } ?>>亲子</option>
                                    <option value="体育" <?php if($view['type']=='体育'){?>selected="selected"<?php } ?>>体育</option>
                                    <option value="时尚" <?php if($view['type']=='时尚'){?>selected="selected"<?php } ?>>时尚</option>
                                    <option value="旅游" <?php if($view['type']=='旅游'){?>selected="selected"<?php } ?>>旅游</option>
                                    <option value="创业" <?php if($view['type']=='创业'){?>selected="selected"<?php } ?>>创业</option>
                                    <option value="电商" <?php if($view['type']=='电商'){?>selected="selected"<?php } ?>>电商</option>
                                    <option value="文化" <?php if($view['type']=='文化'){?>selected="selected"<?php } ?>>文化</option>
                                    <option value="视频" <?php if($view['type']=='视频'){?>selected="selected"<?php } ?>>视频</option>
                                    <option value="其他" <?php if($view['type']=='其他'){?>selected="selected"<?php } ?>>其他</option>
								</select> 
								
							</dd>
						</dl>
						
						<dl hidden="">
							<dt>应用类型：</dt>
							<dd>
							<input id="creditsType" name="creditsType" value="normal" checked="checked" type="radio">普通积分消耗式
							<input id="creditsType" name="creditsType" value="nothing" type="radio">无积分体系
							<i class="dbIcon dbIcon-question-rect tooltips white-tooltip" data-placement="right" data-toggle="tooltip" data-original-title="选用此类型后，仅能使用免费次数参与活动"></i>
							</dd>
							
						</dl>
						<dl hidden="">
							<dt>待领奖文案：</dt>
							<dd><input name="entranceDesc" maxlength="24" style="width: 300px" placeholder="也可在首页&quot;兑换记录&quot;中领奖" type="text">，24小时内有效
							<i class="dbIcon dbIcon-question-rect tooltips white-tooltip" data-placement="right" data-toggle="tooltip" data-original-title="用户参与抽奖活动中奖后的待领奖提示，配置您的兑换记录位置"></i>
							</dd>
						</dl>
						<dl class="clearfix">
							<dt>&nbsp;</dt>
							<dd>
								<input class="button_sumbit"  value="保存配置" type="button" onclick="appinfo();" id="fromsubmit">
							</dd>
						</dl>
					</div>
				</form>
			</div>
		</div>
	</section>
	<!-- 正文结束 -->
	
<script>
    function appinfo(){
    $.ajax({
            url:'<?php echo $this->createUrl("/project/appinfo")?>',
            data:$("#form").serialize(),
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
               $('#fromsubmit').attr("disabled",true);
            },
            success : function (data) {
               $('#fromsubmit').removeAttr("disabled");
                if (data.state == 200) {
                    layer.msg(data.mess,{
                        icon:6,
                        shift: 5,
                        time:1000,
                        end:function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }
                    })
                } else {
                    layer.msg(data.mess,{icon:5});
                }
            }
        });
   
    }
</script>
<?php echo $this->renderpartial('/common/footer', $config); ?>
