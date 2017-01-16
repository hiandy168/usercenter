<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no" />
		<meta name="Keywords" content="报名" />
		<meta name="description" content="报名" />
		<title>报名</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/1.1/css/style.css" />
		<script src="<?php echo $this->_theme_url; ?>/scrtch_files/jquery.js"></script>
	</head>

		<script type="text/javascript">
		openid = "<?php echo $param['openid']?>"; 
		id = "<?php echo $id ?>"; 
		token = "<?php echo $param['token']?>";         
		backUrl = "<?php echo $param['backUrl']?>"; 
		mid = "<?php echo $param['mid'] ?>";
		table = "signup";
		</script>
	<script src="<?php echo $this->_theme_url;?>h5/login/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/login/css/login1.css"/>
	<body>
<?php

    $pid = $pid; //服务器传过来的应用id,直接使用
    $openid=$param['openid'];//微信开实时获取用户的openid
    $userinfo = Activity_signup::getuserinfo($openid,$pid);

?>
		<div class="div-main" >

			<div class="top-title clearfix">
				 <a class="lefta fl" href="javascript:history.back();void(0)">报名</a>
			</div>

			<div class="jf-bm1"><img src="<?php echo ($signup['img'] == '')?$this->_theme_url."h5/1.1/images/jf-img1.jpg":"/".$signup['img'];?>" width="100%" /></div>

			<div class="jf-bm2">
				<h2><?php echo $signup['title'] ?></h2>
				<p><?php echo $signup['desc'] ?></p>
				<em><?php echo date("H:i:s",$signup['start_time']) == "00:00:00"?date("Y-m-d",$signup['start_time']):date("Y-m-d H:i:s",$signup['start_time']) ?>
				-<?php echo date("H:i:s",$signup['end_time']) == "00:00:00"?date("Y-m-d",$signup['end_time']-1):date("Y-m-d H:i:s",$signup['end_time']) ?></em>
				<i>免费活动</i>
				<i id="actxxshow" style="background: none;bottom: 10px;top: auto;color: #858585;">活动详情</i>
			</div>

			<div class="jf-bm3">
				<form>

					<div class="jf-bm3-1">
						<label><i>*</i>姓名：</label>
						<input type="text" name="uname" id="uname" value="" placeholder="请填写您的姓名" />
					</div>

					<div class="jf-bm3-1">
						<label><i>*</i>手机：</label>
						<input type="tel" name="utel" id="utel" value="" placeholder="请填写您的联系方式" />
					</div>

					<div class="error" id="error">带<i>*</i>为 必填项目</div>

					<div class="btn">
						<input id="btn" type="button" value="报名" />
						<i class="loadingdiv" id="loadingdiv"><img src="<?php echo $this->_theme_url;?>h5/1.1/images/load.gif"/></i>
					</div>
				</form>

			</div>

		</div>

		<!--mask-->


		<div class="cal-mask">
			<div class="cal-mask-con" id="regtips">
				<span class="img">
         			<img src="<?php echo $this->_theme_url;?>h5/1.1/images/cal-error-icon.png"/>
         		</span>
				<p>提示文字</p>
			</div>
		</div>


		 <div class="more-mask"></div>
          
          	  <div class="act-xx">	
          	  	<div class="act-xx-img">
          	  		<img src="<?php echo $this->_theme_url;?>h5/1.1/images/jf-img1.jpg" width="100%" />
          	  		<i></i>
          	  	</div>
          	  	
          	  	<div class="act-xx-scroll">
          	  		<div class="act-xx-txt">
          	  			<div class="act-xx-h1">
          	  				  活动名称
          	  			</div>
          	  			
          	  			<div class="act-xx-txtcon">
          	  				<!-- <h3>活动说明</h3>
          	  				
          	  				<h4>1、 如何享受满减优惠？    </h4>
          	  				<p>满减活动期间，单一订单购买商品总金额达到满减活动额度要求，便可享受相应的满减优惠。部分商品可能并不在满减活动商品范围之内，这部分商品不参与满减活动商品总金额的计算。</p>
          	  				
          	  				<h4>2、 如何享受满减优惠？    </h4>
          	  				<p>满减活动期间，单一订单购买商品总金额达。</p>
          	  				 -->
          	  				 <?php echo $signup['desc'] ?>
          	  			</div>
          	  			
          	  			<div class="act-xx-txtcon1">
          	  				<p>活动时间/活动性质</p>
          	  				<p><?php echo date("H:i:s",$signup['start_time']) == "00:00:00"?date("Y-m-d",$signup['start_time']):date("Y-m-d H:i:s",$signup['start_time']) ?>
				-<?php echo date("H:i:s",$signup['end_time']) == "00:00:00"?date("Y-m-d",$signup['end_time']-1):date("Y-m-d H:i:s",$signup['end_time']) ?><i>免费活动</i></p>
          	  				<!-- <p><i>报名人数 </i>/ <i>总需人数 </i> / <i>咨询电话</i></p>
          	  				<p><i>564人次 </i> / <i>20</i> / <i>15107130636</i></p> -->
          	  			</div>
          	  			
          	  			<div class="act-xx-txtcon3">更多问题请咨询主办方</div>
          	  		</div>
          	  	</div>
	
          	  </div>




		<script src="<?php echo $this->_theme_url;?>h5/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>
		
		<script type="text/javascript">
			<?php 
				if($param['status'] == 0){
					?>
					showlogin();
					<?php
				}
			?>

			 $("#actxxshow").on("touchstart",function(){
		     	$(".more-mask").addClass("more-mask-active");
		     	$(".act-xx").addClass("act-xx-active");
		     })
		     $(".act-xx-img i").on("touchstart",function(){
		     	$(".more-mask").removeClass("more-mask-active");
		     	$(".act-xx").removeClass("act-xx-active");
		     })
		     
			function hiderror() {
				setTimeout(function() {
					$("#error").html("带<i>*</i>为 必填项目");
				}, 2000)
			}
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
				}, 2000)
			}

			function checkform() {

			<?php 
				if($param['status'] == 0){
					?>
					showlogin();
					return false;
					<?php
				}
			?>
				var a = $("#uname").val(),
					b = $("#utel").val(),
					c = $("#error"),
					d = $("#regtips");
				if (a == "" || b == "") {
					c.html("<i>信息不能为空</i>");
					hiderror();
					return false;
				} else if (!a.match(/^[\u4e00-\u9fa5]{0,}$/)) {
					c.html("<i>姓名只能为中文</i>");
					hiderror();
					return false;
				} else if (!b.match(/^(0|86|17951)?(13[0-9]|15[012356789]|17[0678]|18[0-9]|14[57])[0-9]{8}$/)) {
					c.html("<i>请填写正确手机号</i>");
					hiderror();
					return false;
				} else {
					$.ajax({
						type: "post",
						cache: !1,
						async: !1,
						data: {
							uname: a,
							utel: b,
							openid:'<?php echo $openid;?>',
							pid:'<?php echo $pid?>',
							appid:'<?php echo $id?>',//应用ID
							mid:'<?php echo $param['mid'] ?>'
						},
						url: "<?php echo $this->createUrl('/activity/signup/AddUser')?>",
						dataType: "json",
						beforeSend: function() {
							$("#loadingdiv").show()
						},
						success: function(data) {
							$("#loadingdiv").hide();
							if (data.code == 1) {
								d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>h5/1.1/images/cal-right-icon.png"/></span><p>报名成功</p>');
								showtips();
							}else if(data.code == 2){
								d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>h5/1.1/images/cal-error-icon.png"/></span><p>'+data.msg+'</p>');
								showtips();
							}else {
								d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>h5/1.1/images/cal-error-icon.png"/></span><p>报名失败，再试一次吧</p>');
								showtips();
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							$("#loadingdiv").hide();
							d.html('<span class="img"><img src="<?php echo $this->_theme_url;?>h5/1.1/images/cal-error-icon.png"/></span><p>服务器异常请检查网络</p>');
							showtips();
						}
					})

				}

			}

			function touchb() {
				return false;
			}
			document.addEventListener("touchstart", touchb, false);
			$(function(){
				$("#btn").click(function(){
					checkform();
				});
			})
			// document.getElementById("btn").addEventListener("touchstart", checkform, false);
		</script>

	</body>

</html>
<?php  exit; ?>