<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no" />
		<meta name="Keywords" content="积分兑换" />
		<meta name="description" content="积分兑换" />
		<title>海报</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/signup_pccheckin/css/style.css" />
		<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/jquery.js"></script>

		<script type="text/javascript">
			openid = "<?php echo $param['openid']?>";
			id = "<?php echo $param['id'] ?>";
			token = "<?php echo $param['token']?>";         
			backUrl = "<?php echo $param['backUrl']?>"; 
			mid = "<?php echo $param['mid'] ?>";
			//table = "activity_poster";
			table = "poster";

		

		</script>
		<script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/h5/login/css/login1.css"/>

	</head>

	<body style="background: #F2F2F2">

		<div class="cal-main">

			<div class="cal-head clearfix">
				<a class="lefta fl" href="javascript:window.history.go(-1);">海报</a>
			</div>

			<form action="<?php echo $this->createUrl('/activity/poster/generateimg',array('id'=>$_GET['id'],'openid'=>$_GET['openid'],'mid'=>$mid))?>" method="post" enctype="multipart/form-data" >
				<div class="jf-signin1">上传图片</div>
				<div class="jf-signin2">
					<img id='preview' onclick="$('#icon1').click()" src="<?php echo JkCms::show_img($activity_info['share_img']) ?>" id="img_thumb1" width="30%"/>
                    <input type="file" style="display:none;" name="share_img" id="icon1" value="<?php echo $activity_info['share_img']?>" onchange="preview_new(this);" >
				</div>
				<div class="jf-signin3">
					<input id="text" style="border:0;border-radius:0;background:#F2F2F2;border-bottom:1px solid #000;height:24px;font-size:16px;" size="24" name="content" maxlength="10" type="text" placeholder="插入文字" />
				</div>
				<div class="jf-signin3">
					<select name="color" style="border:0;border-radius:0;background:#F2F2F2;border-bottom:1px solid #000;height:24px;width:150px;font-size:16px;">
						<option value="255,255,255" >选择颜色</option>
						<option value="0,0,0" >黑色</option>
						<option value="255,255,255" >白色</option>
						<option value="255,0,0" >红色</option>
						<option value="0,0,255" >蓝色</option>
						<option value="0,255,0" >绿色</option>
					</select><br>
					<select name="family" style="border:0;border-radius:0;background:#F2F2F2;border-bottom:1px solid #000;height:24px;width:150px;font-size:16px;">
						<option value="msyh" >选择字体</option>
						<option value="msyh" >微软雅黑</option>
						<option value="arial" >Arial(该选项不支持中文)</option>
						<option value="SURSONG" >宋体</option>
					</select><br>
					<select name="angle" style="border:0;border-radius:0;background:#F2F2F2;border-bottom:1px solid #000;height:24px;width:150px;font-size:16px;">
						<option value="左上角" >选择角度</option>
						<option value="左上角" >左上角</option>
						<option value="右上角" >右上角</option>
						<option value="左下角" >左下角</option>
						<option value="右下角" >右下角</option>
					</select><br>
					<select name="fontsize" style="border:0;border-radius:0;background:#F2F2F2;border-bottom:1px solid #000;height:24px;width:150px;font-size:16px;">
						<option value="20" >选择字体大小</option>
						<option value="16" >16px</option>
						<option value="18" >18px</option>
						<option value="20" >20px</option>
						<option value="22" >22px</option>
						<option value="24" >24px</option>

					</select>
				</div>
				<div class="jf-bm3 jf-signin4">
					<div class="btn">
						<?php if(isset($activity_status)){?>
							<input id="error" type="button" value="生成海报" />
						<?php }else{ ?>
						<input id="btn" type="submit" value="生成海报" />
						<?php }?>
						<i class="loadingdiv" id="loadingdiv"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/signup_pccheckin/images/load.gif"/></i>
					</div>

				</div>
			</form>

		</div>


		<script src="<?php echo $this->_theme_url; ?>assets/subassembly/signup_pccheckin/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">

			$("#error").click(function(){
				alert("<?php echo $activity_status?>");
			})

			<?php 
				if($param['status'] == 0){
					?>
					showlogin();
					<?php
				}
			?>

			function preview_new(file){
				if (file.files && file.files[0]){  
				var reader = new FileReader();  
				reader.onload = function(evt){  
					$("#preview").attr('src',evt.target.result);
				}    
				reader.readAsDataURL(file.files[0]);

				}else{  
					$("#preview").attr('style','filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\')');
				}  
			}  
		</script>
		<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/poster/view',array('id'=>$param['id']) ))); ?>

		
<?php $a = JkCms::getAdsbyid(30);?>
<?php if($a["type"]==1){?>
<a href="<?php echo $a["url"]?>">
<img src="<?php echo JkCms::show_img($a["picture"])?>" style="<?php if(intval($a["width"])){?>width:<?php echo intval($a["width"])?>px;<?php } ?><?php if(intval($a["height"])){?>height:<?php echo intval($a["height"])?>px;<?php } ?>">
</a>
<?php }else if($a["type"]==2){?>
<?php echo $a["code"]?>
<?php }
	exit;
?>

	</body>

</html>