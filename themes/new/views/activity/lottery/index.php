<!DOCTYPE html>
<!--微信大转盘抽奖程序由KuangGanlin于2014-2-25日修改
修改后,转动的度数和所得的奖项主要用index.php来控制-->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="description" content="乐享微信">
<sctipt src="<?php echo $this->_theme_url; ?>js/jquery.2.1.1.min.js"></sctipt>
<title>幸运大转盘抽奖</title>
<link href="<?php echo $this->_theme_url ?>css/activity-style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/css/bootstrap.min.css" />
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/js/main.js"></script>
	<style type="text/css">
		*{margin:0;padding:0;list-style-type:none;}
		a,img{border:0;}
		body{font:12px/180% Arial, Helvetica, sans-serif, "新宋体";}

		input[type="button"] {
			padding: 16px 0;
		}
		.cd-form input[type="button"] {
			-moz-appearance: none;
			background: #2f889a none repeat scroll 0 0;
			border: medium none;
			color: #fff;
			cursor: pointer;
			font-weight: bold;
			padding: 16px 0;
		}
		.cd-form input.has-border:focus, .cd-form input.has-padding{
			height: 50px;
			width: 480px;
		}
		.cd-form input.has-padding{
			padding: 0 40px;
		}
	</style>
	<script type="text/javascript">
		$(function(){
			var $form_modal = $('.cd-user-modal'),
					$form_login = $form_modal.find('#cd-login'),
					$form_signup = $form_modal.find('#cd-signup'),
					$form_modal_tab = $('.cd-switcher'),
					$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
					$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
					$main_nav = $('.main_nav');
			$status = "<?php echo $status; ?>";
//        alert($status);
			//自动加载登陆弹出窗
			if($status == 2) {
				$main_nav.children('ul').removeClass('is-visible');
				$form_modal.addClass('is-visible');
				( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();
				return false;
			}
			function login_selected(){
				$form_login.addClass('is-selected');
				$form_signup.removeClass('is-selected');
				$tab_login.addClass('selected');
				$tab_signup.removeClass('selected');
			}

			function signup_selected(){
				$form_login.removeClass('is-selected');
				$form_signup.addClass('is-selected');
				$tab_login.removeClass('selected');
				$tab_signup.addClass('selected');
			}
		});
	</script>
</head>

<body class="activity-lottery-winning">
<div class="main">
<script type="text/javascript">
//var loadingObj = new loading(document.getElementById('loading'),{radius:20,circleLineWidth:8});
//    loadingObj.show();
</script>
 <div id="outercont">
<div id="outer-cont">
<div id="outer"><img src="<?php echo $this->_theme_url ?>images/activity-lottery-1.png" width="310px"></div>
</div>
<div id="inner-cont">
<div id="inner"><img src="<?php echo $this->_theme_url ?>images/activity-lottery-2.png"></div>
</div>
</div>
<div class="content">
<div class="boxcontent boxyellow" id="result" style="display:none">
<div class="box">
<div class="title-orange" style="color:#000000;"><span>恭喜你中奖了</span></div>
<div class="Detail">
            <a class="ui-link" href="#" id="opendialog" style="display: none;" data-rel="dialog"></a>
<p>你中了：<span class="red" id="prizetype">一等奖</span></p>
<p>你的兑奖SN码：<span class="red" id="sncode"></span></p>
<p class="red">本次兑奖码已经关联你的微信号，你可向公众号发送 兑奖 进行查询!</p>
               
<p>
<input name="" class="px" id="tel" type="text" placeholder="输入您的手机号码">
</p>
<p>
<input class="pxbtn" id="save-btn" name="提 交" type="button" value="提 交">
</p>
</div>
</div>
</div>
<div class="boxcontent boxyellow">
<div class="box">
<div class="title-green"><span>奖项设置：</span></div>
<div class="Detail">
<p>一等奖：iPhone5S 。奖品数量：100 </p>
<p>二等奖：iPad5 。奖品数量：500 </p>
<p>三等奖：iPad mini 。奖品数量：1000 </p>
</div>
</div>
</div>
<div class="boxcontent boxyellow">
<div class="box">
<div class="title-green">活动说明：</div>
<div class="Detail">
<p>本次活动每人可以转 2 次 </p>
               <p> 只为测试，中奖后请勿领奖 </p>
</div>
</div>
</div>
</div>

</div>
<div class="cd-user-modal">
	<div class="cd-user-modal-container">
		<ul class="cd-switcher">
			<li><a href="#0">用户登录</a></li>
			<li><a href="#0">注册新用户</a></li>
		</ul>

		<div id="cd-login"> <!-- 登录表单 -->
			<form class="cd-form" action="<?php //echo Mod::app()->createUrl('member/Ajaxlogin')?>" method="post">
				<p class="fieldset">
					<label class="image-replace cd-username" for="signin-username">用户名</label>
					<input class="full-width has-padding has-border" id="signin-username" type="text" placeholder="输入用户名">
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signin-password">密码</label>
					<input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="输入密码">
				</p>

				<p class="fieldset">
					<input style="margin-top:-5px;" type="checkbox" id="remember-me" checked>
					<label style="display:inline;" for="remember-me">记住登录状态</label>
				</p>

				<p class="fieldset">
					<input class="full-width2" type="button" id="login" value="登 录">
				</p>
			</form>
		</div>

		<div id="cd-signup"> <!-- 注册表单 -->
			<form class="cd-form" method="post">
				<p class="fieldset">
					<label class="image-replace cd-username" for="signup-username">用户名</label>
					<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="输入手机号">
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signup-password">密码</label>
					<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="输入密码">
				</p>

				<p class="fieldset">
					<label class="image-replace cd-password" for="signup-password">重复密码</label>
					<input class="full-width has-padding has-border" id="signup-repassword" type="text" placeholder="再次输入密码">
				</p>

				<p class="fieldset">
					<input type="checkbox" name="rember" id="accept-terms" style="margin-top:-5px;">
					<label  style="display:inline;" for="accept-terms">我已阅读并同意 <a href="#0">用户协议</a></label>
				</p>

				<p class="fieldset">
					<input class="full-width2" id="zhuce" type="button" value="注册新用户">
				</p>
			</form>
		</div>

		<!--<a href="#0" class="cd-close-form">关闭</a>-->
	</div>
	<div>
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>"/>
		<input type="hidden" name="mid" id="mid" value="<?php echo $mid; ?>"/>
		<input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>"/>
		<input type="text" name="return_url" id="return_url" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"/>
	</div>
</div>
<script src="<?php echo $this->_theme_url; ?>js/jquery.2.1.1.min.js"></script>
<script src="<?php echo $this->_theme_url; ?>wap/js/login.js"></script>
<script src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<script src="<?php echo $this->_theme_url ?>js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	window.requestAnimFrame = (function() {
		return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame ||
		function(callback) {
			window.setTimeout(callback, 1000 / 60)
		}
	})();
	var totalDeg = 360 * 3 + 0;
	var steps = [];
	var lostDeg = [36, 66, 96, 156, 186, 216, 276, 306, 336];//这是以前不在获奖范围内的度数
	var prizeDeg = [6, 126, 246]; //这是以前获取的度数,分别为一等奖度数、二等奖度数、三等奖度数
	//var lostDeg = [36, 66, 96, 156, 186, 216, 276, 306, 336];//这是我修改后的,其实不起作用了
	//var prizeDeg = [6,36, 66, 96, 126,156, 186, 216,246, 276, 306, 336];//这是我修改后的,其实不起作用了
	var prize, sncode,lot_id;
	var count = 0;
	var now = 0;
	var a = 0.01;
	var strmsg;
	var outter, inner, timer, running = false;
	function countSteps() {
		var t = Math.sqrt(2 * totalDeg / a);
		var v = a * t;
		for (var i = 0; i < t; i++) {
			steps.push((2 * v * i - a * i * i) / 2)
		}
		steps.push(totalDeg)
	}
	function step() {
	
		outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
		outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
		if (now < steps.length) {
			requestAnimFrame(step)
		} else {
			running = false;
			setTimeout(function() {
			console.log(prize);
				if (lot_id < 4) {
					$("#sncode").text(sncode);
					var type = "";
					if (lot_id == 1) {
						type = "一等奖"
					} else if (lot_id == 2) {
						type = "二等奖"
					} else if (lot_id == 3) {
						type = "三等奖"
					}
					ship_mess(prize);
				//传入中奖信息来页面
					$("#prizetype").text(type);
					$("#sncode").text(sncode);
					$('.boxcontent').show();
//					$("#result").slideToggle(500);//这个是展开所在的id内容
//					$("#outercont").slideUp(500) //这个是折叠所在的id内容
				} else {
//						//ship_mess(strmsg);
						ship_mess(prize);
				}
			},
			200)
		}
	}
	//大概看了下，源码中是没有给start传参的，所以函数里的deg都是随机生成的，所以最后转盘转动的度数也会随机。如果给start传参，转盘的转动的度数就会确定（即你穿的角度+360*5），那么位置也就确定了。
	function start(deg) {
		deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
		running = true;
		clearInterval(timer);
		totalDeg = 360 * 5 + deg;
		steps = [];
		now = 0;
		countSteps();
		requestAnimFrame(step)
	}
	window.start = start;
	
	outter = document.getElementById('outer');
	inner = document.getElementById('inner');
	i = 10;
	$("#inner").click(function() {
		if (running) return;
		if (count >= 20) {
			ship_mess("您已经抽了 2 次奖。");
			return
		}
//		if (prize != null) {
		if(lot_id < 4){
			ship_mess("亲，你不能再参加本次活动了喔！下次再来吧~");
			return
		}
		$.ajax({
			url: "<?php echo $this->createUrl('/activity/lottery/start'); ?>",
			dataType: "json",
			data: {
				access_token: "<?php echo $token; ?>",
				mid:"<?php echo $mid; ?>",
//				ac: "activityuser",
				tid: "5",
				t: Math.random()
			},
			beforeSend: function() {
				running = true;
				timer = setInterval(function() {
					i += 5;
					outter.style.webkitTransform = 'rotate(' + i + 'deg)';
					outter.style.MozTransform = 'rotate(' + i + 'deg)'
				},
				1)
			},
			success: function(data) {
				if (data.id < 4) {
					lot_id = data.id;
					prize = data.prize;
					sncode = data.sn;
//					start(prizeDeg[data.prizetype - 1])//这是以前的
					start(data.angle)//这是我修改的。如果中奖后，则直接转的度数就是index.php返回的度数

				}else{
//					prize = null;
//					start()
					prize = data.prize;
//					ship_mess(data.prize);
					clearInterval(timer);
					start(data.angle);
					return
				}

			},
//			success: function(data) {
//				if (data.status == "100025") {
//					ship_mess(data.mess);
//					count = 3;
//					clearInterval(timer);
//					return
//				}
//				if (data.status == "100018") {
//					ship_mess('本次活动你已经中过奖，本次只显示你上次抽奖结果!兑奖SN码为:' + data.sn);
//					count = 3;
//					clearInterval(timer);
//					prize = data.prizetype;
//					sncode = data.sn;
////					start(prizeDeg[data.prizetype - 1]);
//					start(data.angle)
//					return
//				}
//				if(data.status == 2){
//					ckLogin();
//					return false;
//				}
//
//				if (data.success) {
//					prize = data.prize;
//					sncode = data.sn;
////					start(prizeDeg[data.prizetype - 1])//这是以前的
//					start(data.angle)//这是我修改的。如果中奖后，则直接转的度数就是index.php返回的度数
//				}else{
//					prize = null;
//					start()
//
//				}
//				running = false;
//				count++
//			},
			
			error: function() {
				
				prize = null;
				start();
				running = false;
				count++
			},
			
			timeout: 4000
		})
	})
});
$("#save-btn").bind("click",
function() {
	var btn = $(this);
	var tel = $("#tel").val();
	if (tel == '') {
		ship_mess("请输入手机号码");
		return
	}
	var regu = /^[1][0-9]{10}$/;
	var re = new RegExp(regu);
	if (!re.test(tel)) {
		ship_mess("请输入正确手机号码");
		return
	}
	var submitData = {
//		tid: 5,
		code: $("#sncode").text(),
		tel: tel,
//		action: "setTel",
		access_token: "<?php echo $token; ?>",
		mid:"<?php echo $mid; ?>",
	};
	/**
	jQuery.post( url, [data], [callback], [type] ) ：使用POST方式来进行异步请求
	参数：

	url (String) : 发送请求的URL地址.
	data (Map) : (可选) 要发送给服务器的数据，以 Key/value 的键值对形式表示。服务端index.php页面取data里的值时直接用:$_REQUEST['key值'],而不是$_REQUEST['data']
	callback (Function) : (可选) 载入成功时回调函数(只有当Response的返回状态是success才是调用该方法)。
	type (String) : (可选)官方的说明是：Type of data to be sent。其实应该为客户端请求的类型(JSON,XML,等等)
	**/
	console.log(tel);
	$.post('<?php echo $this->createUrl('/activity/lottery/updateLot'); ?>',
		{
			code: $("#sncode").text(),
			tel: tel,
			access_token: "<?php echo $token; ?>",
			mid:"<?php echo $mid; ?>",
		},
		function(data) {
			console.log(data);
			if (data.success) {
				ship_mess("提交成功，谢谢您的参与");
				$("#result").slideUp(500);
				$("#outercont").slideToggle(500);
				running = false;
				return
			} else {
				ship_mess("提交失败");
				$("#result").slideUp(500);
				$("#outercont").slideToggle(500);
			}
		
		
	},
	'json')

});

//function ckLogin(){
//	var $form_modal = $('.cd-user-modal'),
//			$form_login = $form_modal.find('#cd-login'),
//			$form_signup = $form_modal.find('#cd-signup'),
//			$form_modal_tab = $('.cd-switcher'),
//			$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
//			$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
//			$main_nav = $('.main_nav');
//	$status = "<?php //echo $status?$status:false ?>//";
////        alert($status);
//	//自动加载登陆弹出窗
//	$main_nav.children('ul').removeClass('is-visible');
//	$form_modal.addClass('is-visible');
//	( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();
//
//	function login_selected(){
//		$form_login.addClass('is-selected');
//		$form_signup.removeClass('is-selected');
//		$tab_login.addClass('selected');
//		$tab_signup.removeClass('selected');
//	}
//
//	function signup_selected(){
//		$form_login.removeClass('is-selected');
//		$form_signup.addClass('is-selected');
//		$tab_login.removeClass('selected');
//		$tab_signup.addClass('selected');
//	}
//}
</script>


</body></html>