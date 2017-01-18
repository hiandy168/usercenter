<!DOCTYPE html>
<html>
	<head>
				<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no" />
		<meta name="Keywords" content="刮刮卡" />
		<meta name="description" content="刮刮卡" />
		<title>刮刮卡</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/css/app.css"/>
		<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/wScratchPad.js" type="text/javascript" charset="utf-8"></script>

		<script type="text/javascript">
			openid = "<?php echo $param['openid']?>";
			id = "<?php echo $param['id']?>";
			pid = "<?php echo $param['id']?>";
			//	backUrl = "<?php echo $param['backUrl']?>";
			mid = "<?php echo $param['mid'] ?>";
			table = "scratch";
		</script>
		<script src="<?php echo $this->_theme_url;?>assets/h5/login/js/login.js" type="text/javascript" charset="utf-8"></script>
		
	</head>
	<?php
	$mid = $param['mid'];
	$openid = $param['openid'];
	$day_count     = $info['day_count'];
	$num = Activity_scratch::getNum($info['id'],$mid,$openid,$day_count);

	?>
	<body>
		
		<div id="loaddiv" class="loading-div">
		<span>
			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/loading.gif"/>
			<i>努力加载中...</i>
		</span>
	    </div>
	    
	    
	    <div class="mask">
	    	<div class="dial-pop">
	    		
	       <div class="popbg">
		  	<img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img8.png" width="100%" />
		  </div>
	    	
	        <div class="poptxt">
		  		<div class="dial-poptxt">
		  		<h3>恭喜！你中奖了</h3>
		  		<p>中得<i>“一等奖”</i>领奖码 <i>123456</i><br />
                                         你还有<b>8</b>次刮奖机会</p>
		  		</div>
		  	</div>
		 
		 <a href="" title=""><div class="confirmbtn">
		 	<img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img9.png" width="100%" />
		 </div></a>
	    		
	    	</div>
	    </div>
	    
	    <!--mask pop end-->
	    
	    
	    
		<div class="div-main">
		  
		  <div class=""><img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img1.jpg" width="100%"/></div>
		  
		  <!--top end-->
		  
		  <div class="gg-div1 pos-r">
		  	<div class="gg-div1-bg1"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img2.jpg" width="100%"/></div>
		  	
		  	<div class="gg-div1-info">
		  		<span>
		  			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img5.png"/>
		  			<i><b><?php echo $all_prize_count;?></b>个奖品</i>
		  		</span>
		  		<span><i>您有 <b><?php echo $num ?></b>次抽奖机会</i></span>
		  	</div>
		  	
		  	<div class="gg-div1-ggmain">
		  		<img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img3.png" width="100%"/>
		  		<div class="" id="wScratchPad3"></div>
		  		<div class="" id="wScratchPad2"></div>
		  	</div>
		  	
		  	<div class="gg-div1-btnimg">
		  		<ul>
		  		    <li><img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img6.png"/></li>
		  		    <li class="dial-logbtn"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img7.png"/></li>
		  		</ul>
		  	</div>
		  	
		  </div>
		  <!--mid end-->
		  
		  <div class="gg-div2">
		  	
		  	<div class="gg-div2-info1">
		  		<h2>活动时间</h2>
		  		<p><?php echo date('Y年m月d日 H时i分',$info['start_time']). '--' .date('Y年m月d日 H时i分',$info['end_time']);?></p>
		  	</div>
		  	<!--活动时间-->
		  	
		  	<div class="gg-div2-info1">
		  		<h2>惊喜奖品</h2>

                   <?php foreach($prize as $val){?>
						<p><?php echo $val['title']?>:<?php echo $val['name']?>：<i><?php echo $val['count']?></i>名</p>
					<?php }?>
		  	</div>
		  	<!--奖品奖励-->
		  	
		  	<div class="gg-div2-info1 gg-div2-gz">
		  		<h2>活动规则</h2>
		  		<p>
						<?php echo $info['rule']?>
					</p>
		  	</div>
		  	<!--活动规则-->
		  	
		  	<div class="gg-div2-info1 gg-div2-gz">
		  		<h2>领取规则</h2>
		  		<p>
						<?php echo $info['lingjiang']?>
					</p>
		  	</div>
		  	<!--领取规则-->
		  	
		  </div>
		  
		  <!--text end-->
		  
		</div>





		<script type="text/javascript">


		  <?php if(!$param['mid']){?>
			showlogin();
			$("#winlogin").hide();
			<?php } ?>
			var count = "<?php echo $num?>"; //当前用户今天可刮奖的次数
			var id = "<?php echo $info['id']?>";           //刮奖活动的id
			var flag  = 0;                                 
			var number = 0;
			var show   = 0;

	$("#wScratchPad2").wScratchPad({
	image2: '<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img4.png',
	scratchMove: function(e) {
		<?php if(!$param['mid']){ ?>
		showloginssss();
		return false;
		<?php } ?>
		var d = <?php echo $time;?>;
		var f = <?php echo $info['start_time'] ?>;
		var g = <?php echo $info['end_time'] ?>;
		if (d < f) {
			showpop("", "活动未开始！", "", "", 3);
			return false
		}
		if (d > g) {
			showpop("", "活动已结束！", "", "", 3);
			return false
		}
		<?php if(!$info['status']){?>
		showpop("", "活动暂停中！", "", "", 3);
		return false;
		<?php } ?>
		if (parseInt(count) < 1) {
			showpop("", "今天次数用完了，明天再玩吧", "", "", 3);
			return false
		}
		var h = this.ctx;
		h.lineTo(e.pageX, e.pageY);
		h.stroke();
		if (e.pageX > 80 && e.pageX < 160) {
			number++;
			if (number == 1) {
				$.ajax({
					type: "post",
					cache: !1,
					async: !1,
					url: "<?php echo $this->createUrl('/activity/scratchcard/getwin') ?>",
					dataType: "json",
					data: {
						"id": id,
						"mid": mid
					},
					beforeSend: function() {},
					success: function(a) {
						console.log(a);
						if (a.code == 0) {
							showpop("", a.msg, "", "", 3);
							return false
						}
						if (a.code == -1) {
							showpop("", a.msg, "", "", 3);
							return false
						}
						if (a.code == -2) {
							showpop("", a.msg, "", "", 3);
							return false
						}
						if (a.code == -3) {
							showpop("", a.msg, "", "", 3);
							return false
						}
						if (a.state == 0) {
							$("#wScratchPad3").text(a.msg);
							setTimeout(function() {
								h.lineTo(40, 28);
								h.lineTo(80, 28);
								h.lineTo(120, 28);
								h.lineTo(160, 28);
								h.lineTo(200, 28);
								h.stroke();
								showpop("", a.msg, "", (count - 1), 2)
							}, 1500)
						}
						if (a.state == 1) {
							$("#wScratchPad3").text(a.msg);
							setTimeout(function() {
								h.lineTo(40, 28);
								h.lineTo(80, 28);
								h.lineTo(120, 28);
								h.lineTo(160, 28);
								h.lineTo(200, 28);
								h.stroke();
								showpop("", a.msg, a.code, (count - 1), 1)
							}, 1500)
						}
					},
					error: function(a, b, c) {
						showpop("", data.msg, "", "", 3)
					}
				})
			}
		}
	},
	scratchUp: function(e) {
		this.ctx.closePath()
	},
});

function myjiangp() {
	var c = $(".pop-zjlist");
	c.html("<p><br />加载中...</p>");
	$.post("<?php echo $this->createUrl('/activity/scratchcard/userwinprize') ?>", {
		id: id,
		openid: openid,
		mid: mid
	}, function(a) {
		var a = JSON.parse(a);
		c.html("");
		var b = '<li ><span>奖品名称</span><span>中奖码</span></li>';
		if (a.code == 1) {
			for (var i in a.msg) {
				b += '<li ><span>' + a.msg[i].title + '</span><span>' + a.msg[i].code + '</span></li>'
			}
		} else {
			b = '<li>无中奖记录</li>'
		}
		c.append(b)
	})
}
$(".dial-logbtn").on("click", function() {
	<?php if(!$param['mid']){?>
	showloginssss();
	return false;
	<?php } ?>
	showpop('<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/images/gg-img8-1.png', "", "", "", "4");
	myjiangp()
})
function showpop(a, b, c, d, e) {
	$(".mask").show();
	$(".dial-pop").show().addClass("active");
	if (e == 1) {
		$(".dial-poptxt").html('<h3>恭喜！你中奖了</h3>' + '<p>中得<i>“' + b + '”</i>领奖码 <i>' + c + '</i><br />' + '你还有<b>' + d + '</b>次刮奖机会</p>')
	}
	if (e == 2) {
		$(".dial-poptxt").html('<h3>很遗憾！没中奖</h3>' + '<p>你还有<b>' + d + '</b>次刮奖机会</p>')
	}
	if (e == 3) {
		$(".dial-poptxt").html('<h3>@__@</h3>' + '<p>' + b + '</p>')
	}
	if (e == 4) {
		$(".popbg").html('<img src="' + a + '" width="100%" />');
		$(".dial-poptxt").html('<h3>中奖记录</h3>' + '<div class="pop-zjlist"></div>')
	}
}
// $(".confirmbtn").on("click", function() {
// 	// location.replace(location.href);
// 	window.location.href=document.location.pathname+'?v='+Math.random();
// 	// window.location.href = "?status#"+Math.random();
// })
           
        </script>

		<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/layout.js" type="text/javascript" charset="utf-8"></script>
		<!--微信分享-->

		<?php

		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == true){
			if($info['share_switch']==1){
			echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/scratchcard/view',array('id'=>$param['id']) )));
			}else { ?>
			<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
			<script>
				wx.config({
					debug: false,
					appId: '<?php echo $signPackage["appId"];?>',
					timestamp: <?php echo $signPackage["timestamp"];?>,
					nonceStr: '<?php echo $signPackage["nonceStr"];?>',
					signature: '<?php echo $signPackage["signature"];?>',
				});

				wx.ready(function () {
					wx.hideOptionMenu();

				})

			</script>
		<?php }}?>
		<!--微信分享-->
	</body>
</html>
