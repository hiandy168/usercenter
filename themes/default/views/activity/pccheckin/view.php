<?php 
    /*
     * 这里通过用户的openid获取用户的信息，如果有直接将用户的信息填入表单，如果没又则需要用户自己填
     */
    $pid = $pid; //服务器传过来的应用id,直接使用
    $openid=$param['openid'];//微信开实时获取用户的openid
	$mid=$param['mid'];
    $count = Activity_pccheckin_user::getcheckinnum($mid,$id);
?>
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
		<title>签到</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>signup_pccheckin/css/style.css" />
		<script src="<?php echo $this->_theme_url; ?>/scrtch_files/jquery.js"></script>

		<script type="text/javascript">
			openid = "<?php echo $param['openid']?>"; 
			id = "<?php echo $id ?>"; 
			token = "<?php echo $param['token']?>";         
			backUrl = "<?php echo $param['backUrl']?>"; 
			mid = "<?php echo $param['mid'] ?>";
			//table = "activity_pccheckin";
			table = "pccheckin";
		</script>
		<script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/login/css/login1.css"/>
		<script src="<?php echo $this->_theme_url;?>h5/login/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
	</head>

	<body style="background: #F2F2F2">

		<div class="cal-main">

			<div class="cal-head clearfix">
				<a class="lefta fl" href="javascript:history.back();void(0)">签到</a>
			</div>

			<form>
				<input type="hidden" name="unum" id="unum" value="<?php echo $openid;?>" />
				<div class="jf-signin1">已连续签到</div>
				<div class="jf-signin2">
					<img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/jf-img3.jpg" width="100%" />
					<span><i><?php echo $count;?></i>天</span>
				</div>
				<div class="jf-signin3">
					<!-- <h2>劳动节</h2> -->
					<p><?php echo $date?></p>
				</div>
				<div class="jf-bm3 jf-signin4">
					<div class="btn">
						<input id="btn" type="button" value="签到" />
						<i class="loadingdiv" id="loadingdiv"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/load.gif"/></i>
					</div>

				</div>
			</form>

		</div>

		<div class="cal-mask">
			<div class="cal-mask-con" id="regtips">
				<span class="img">
         			<img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-right-icon.png"/>
         		</span>
				<p>签到成功</p>
			</div>
		</div>

		<script src="<?php echo $this->_theme_url;?>signup_pccheckin/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			
			<?php
				if($param['status'] == 0){
					?>
					showlogin();
					<?php
				}
			?>

			function showtips() {
				$(".cal-mask").css({
					"z-index": "999",
					"opacity": "1"
				}).children(".cal-mask-con").css({
					"top": "50%"
				});
				setTimeout(function() {
					$(".cal-mask").css({
						"z-index": "-10",
						"opacity": "0"
					}).children(".cal-mask-con").css({
						"top": "-50%"
					});
					location.reload();
				}, 2000)
			}
			function clickbtn() {
				<?php 
				if($param['status'] == 0){
					?>
					showlogin();
					return false;
					<?php
				}
				?>
				var a = $("#unum").val(),
					d = $("#regtips");
				var status = "<?php echo $pccheckin['status']?>"
				if(status=='活动已经结束'){
					d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-error-icon.png"/></span><p>活动已经结束，您无法签到</p>');
					showtips();
					return false;
				}
				$.ajax({
					type: "post",
					cache: !1,
					async: !1,
					data: {
						openid: a,
						pid:'<?php echo $id; ?>',
						mid:"<?php echo $param['mid']; ?>",
					},
					url: "<?php echo $this->createUrl('/activity/pccheckin/AddUser')?>",
					dataType: "json",
					beforeSend: function() {
						$("#loadingdiv").show()
					},
					success: function(data) {
						$("#loadingdiv").hide();
						if (data.code == 1) {
							d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-right-icon.png"/></span><p>签到成功</p>');
							showtips();
						}else if(data.code==2){
							d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-error-icon.png"/></span><p>您今天已经签到了</p>');
							showtips();
						} else {
							d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-error-icon.png"/></span><p>签到失败</p>');
							showtips();
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						$("#loadingdiv").hide();
						d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>signup_pccheckin/images/cal-error-icon.png"/></span><p>服务器异常请检查网络</p>');
						showtips();
					}
				})

			}

			function touchb() {
				return false;
			}
			document.addEventListener("touchstart", touchb, false);
			document.getElementById("btn").addEventListener("click", clickbtn, false);
		</script>

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