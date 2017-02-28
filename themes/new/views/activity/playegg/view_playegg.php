<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no" />
	<meta name="Keywords" content="砸金蛋" />
	<meta name="description" content="砸金蛋" />
	<title>砸金蛋</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/css/app.css"/>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js" type="text/javascript" charset="utf-8"></script>
 
	<script type="text/javascript">
		openid = "<?php echo $param['openid']?>";
		id = "<?php echo $param['id']?>";
		pid = "<?php echo $param['id']?>";
		backUrl = "<?php echo $param['backUrl']?>";
		mid = "<?php echo $param['mid'] ?>";
		table = "scratch";
		start_time="<?php echo$info['start_time'];?>"
		end_time="<?php echo$info['end_time'];?>"
	</script>
	

</head>

<body>
<?php
$mid = $param['mid'];
$openid = $param['openid'];
$day_count     = $info['day_count'];//美人每天抽奖次数
$num = Activity_playegg::getNum($info['id'],$mid,$openid,$day_count);//剩余次数
$start_time=$info['start_time'];
$end_time=$info['end_time'];

?>
<div id="loaddiv" class="loading-div">
		<span>
			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/loading.gif"/>
			<i>努力加载中...</i>
		</span>
</div>

<div class="mask"></div>
<div class="dial-pop">

	<div class="dial-poptxt">
		<h3>恭喜！你中奖了</h3>
		<p>中得<i>“一等奖”</i>领奖码 <i>123456</i><br />
			你还有<b>8</b>次刮奖机会</p>
	</div>

	<div class="dial-confirmbtn">
		<a href="/activity/playegg/view/id/<?php echo $info['id']?>">确定</a>
	</div>
</div>


<div class="div-main">

	<div class="">
		<?php if($info['banner_img']){?>
			<img src="<?php echo Tool::show_img($info['banner_img']); ?>" width="100%"/>
		<?php }else{?>
			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img1.jpg" width="100%"/>
		<?php }?>
	</div>

	<div class="deggs-za pos-r">
		<ul>

			<li class="pos-a">
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img5.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img4.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img3.png"/>
			</li>
			<li class="pos-a">
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img5.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img4.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img3.png"/>
			</li>
			<li class="pos-a">
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img5.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img4.png"/>
				<img class="pos-a" src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/images/deggs-img3.png"/>
			</li>
		</ul>

	</div>

	<div class="deggs-jlbtn">中奖记录</div>

	<div style="overflow: hidden;padding-top: 10px;">


		<div class="deggs-rule">
			<h3>惊喜奖品</h3>
	    		<span>
	    			<?php foreach($prize as $val){?>
						<p><?php echo $val['title']?>:<?php echo $val['name']?>：<i><?php echo $val['count']?></i>名</p>
					<?php }?>
	    		</span>
		</div>

		<div class="deggs-rule">
			<h3>活动规则</h3>
	    		<span>
	    			<?php echo $info['rule']?>
	    		</span>
		</div>


		<div class="deggs-rule">
			<h3>领取规则</h3>
	    		<span>
	    			<?php echo $info['lingjiang']?>
	    		</span>
		</div>


	</div>

</div>

<script src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/js/zepto.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/js/touch.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/playegg/js/layout.js" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript" charset="utf-8">
	var bRotate = false;
	var egg=$(".deggs-za ul li");
	var d = <?php echo $time;?>;
	var f = <?php echo $info['start_time'] ?>;
	var g = <?php echo $info['end_time'] ?>;
	var count = "<?php echo $num?>"; //当前用户今天可刮奖的次数
	var id = "<?php echo $info['id']?>";           //刮奖活动的id
    <?php if(!$param['mid']){?>
			showlogin();
			$("#winlogin").hide();
	<?php } ?>

	var eggBroken=function(){
     $.ajax({
					type: "post",
					cache: !1,
					async: !1,
					url: "<?php echo $this->createUrl('/activity/playegg/getwin') ?>",
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
							
							setTimeout(function() {
								showpop("", a.msg, "", (count - 1), 2)
							}, 500)
						}
						if (a.state == 1) {

							setTimeout(function() {
								showpop("", a.msg, a.code, (count - 1), 1)
							}, 500)
						}
					},
					error: function(a, b, c) {
						showpop("", data.msg, "", "", 3)
					}
				})

	}


	egg.on("click",function(){
	
		

		/*
		* 登录模块*/

		

		<?php if(!$param['mid']){ ?>
		showloginssss();
		return false;
		<?php } ?>

        var _this=$(this);   
		if(bRotate)return;

		bRotate=!bRotate;

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

		egg.removeClass("za");
		_this.addClass("za");
		eggBroken()
		
		
	});

function myjiangp() {
	var c = $(".pop-zjlist");
	c.html("<p><br />加载中...</p>");
	$.post("<?php echo $this->createUrl('/activity/playegg/userwinprize') ?>", {
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
$(".deggs-jlbtn").on("click", function() {
	<?php if(!$param['mid']){?>
	showloginssss();
	return false;
	<?php } ?>
    showpop('', "", "", "", "4"); 
	myjiangp()
})

function showpop(a, b, c, d, e) {
	$(".mask").show();
	$(".dial-pop").show().addClass("active");
	if (e == 1) {
		$(".dial-poptxt").html('<h3>恭喜！你中奖了</h3>' + '<p>中得<i>“' + b + '”</i>领奖码 <i>' + c + '</i><br />' + '你还有<b>' + d + '</b>次刮奖机会</p>')
	}
	if (e == 2) {
		$(".dial-poptxt").html('<h3>很遗憾！没中奖</h3>' + '<p><i>“' + b + '”</i><br />你还有<b>' + d + '</b>次刮奖机会</p>')
	}
	if (e == 3) {
		$(".dial-poptxt").html('<h3>@__@</h3>' + '<p>' + b + '</p>')
	}
	if (e == 4) {
		$(".popbg").html('<img src="' + a + '" width="100%" />');
		$(".dial-poptxt").html('<h3>中奖记录</h3>' + '<div class="pop-zjlist"></div>')
	}
	if (e == 5) {
		$(".dial-poptxt").html('<h3>@__@</h3>' + '<p>' + b + '</p>');
		$("[data-href='votelink']").removeAttr("href").attr('href', backUrl);
	}
}

</script>

<!--微信分享-->

<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info)); ?>

<!--微信分享-->



</body>
</html>
