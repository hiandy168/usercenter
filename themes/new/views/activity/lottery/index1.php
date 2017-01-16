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
</head>

<body class="activity-lottery-winning">
<div class="main">
<script type="text/javascript">
var loadingObj = new loading(document.getElementById('loading'),{radius:20,circleLineWidth:8});
    loadingObj.show();
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
	var prize, sncode;
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
			
				if (prize != null) {
					$("#sncode").text(sncode);
					var type = "";
					if (prize == 1) {
						type = "一等奖"
					} else if (prize == 5) {
						type = "二等奖"
					} else if (prize == 9) {
						type = "三等奖"
					}
					//alert(prize);
					$("#prizetype").text(type);
					$("#result").slideToggle(500);//这个是展开所在的id内容
					$("#outercont").slideUp(500) //这个是折叠所在的id内容
				} else {
						//alert(strmsg);
						alert("谢谢您的参与，下次再接再厉")
					
					
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
			alert("您已经抽了 2 次奖。");
			return
		}
		if (prize != null) {
			alert("亲，你不能再参加本次活动了喔！下次再来吧~");
			return
		}
		$.ajax({
			url: "<?php echo $this->createUrl('/activity/lottery/start'); ?>",
			dataType: "json",
			data: {
				access_token: "<?php echo $token; ?>",
				openid:"<?php echo $openid; ?>",
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
				if (data.error == "invalid") {
					alert("您已经抽了 3 次奖。");
					count = 3;
					clearInterval(timer);
					return
				}
				if (data.error == "getsn") {
					alert('本次活动你已经中过奖，本次只显示你上次抽奖结果!兑奖SN码为:' + data.sn);
					count = 3;
					clearInterval(timer);
					prize = data.prizetype;
					sncode = data.sn;
					start(prizeDeg[data.prizetype - 1]);
					return
				}
				if (data.success) {
					prize = data.prizetype;
					sncode = data.sn;
					//start(prizeDeg[data.prizetype - 1])//这是以前的
					start(data.angle)//这是我修改的。如果中奖后，则直接转的度数就是index.php返回的度数
				}
				
				//if (data.error) {
				else{
					prize = null;
					start()
					
				}
				
				running = false;
				count++
			},
			
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
		alert("请输入手机号码");
		return
	}
	var regu = /^[1][0-9]{10}$/;
	var re = new RegExp(regu);
	if (!re.test(tel)) {
		alert("请输入正确手机号码");
		return
	}
	var submitData = {
		tid: 5,
		code: $("#sncode").text(),
		tel: tel,
		action: "setTel"
	};
	/**
	jQuery.post( url, [data], [callback], [type] ) ：使用POST方式来进行异步请求
	参数：

	url (String) : 发送请求的URL地址.
	data (Map) : (可选) 要发送给服务器的数据，以 Key/value 的键值对形式表示。服务端index.php页面取data里的值时直接用:$_REQUEST['key值'],而不是$_REQUEST['data']
	callback (Function) : (可选) 载入成功时回调函数(只有当Response的返回状态是success才是调用该方法)。
	type (String) : (可选)官方的说明是：Type of data to be sent。其实应该为客户端请求的类型(JSON,XML,等等)
	**/
	$.post('index.php?ac=activityuser_sn', submitData,
	function(data) {
		if (data.success) {
			alert("提交成功，谢谢您的参与");
			$("#result").slideUp(500);
			$("#outercont").slideToggle(500);
			running = false;
			return
		} else {alert("提交失败");
			$("#result").slideUp(500);
			$("#outercont").slideToggle(500);
		}
		
		
	},
	"json")
	
	

	
	
});
</script>


</body></html>