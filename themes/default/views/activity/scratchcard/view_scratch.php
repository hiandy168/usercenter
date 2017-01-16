<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
	<title>刮刮乐</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>/scrtch_files/base.css">
	<style type="text/css">
		.winning_list .list {
		height: 180px;
		overflow-y: scroll;
		}
	</style>
	<script src="<?php echo $this->_theme_url; ?>/scrtch_files/jquery.js"></script>
	<script src="<?php echo $this->_theme_url; ?>/scrtch_files/wScratchPad.js"></script>
    <script src="<?php echo $this->_theme_url; ?>/scrtch_files/wx.js"></script>
	<script src="<?php echo $this->_theme_url; ?>/scrtch_files/preloadjs.js"></script>

	<script type="text/javascript">
	openid = "<?php echo $param['openid']?>"; 
	id = "<?php echo $param['id']?>";
        pid = "<?php echo $param['id']?>";
//	backUrl = "<?php echo $param['backUrl']?>"; 
	mid = "<?php echo $param['mid'] ?>";
	table = "scratch";
	</script>
        <script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/login/css/login1.css"/>
</head>
<?php 
$mid = $param['mid'];
$openid = $param['openid'];
$day_count     = $info['day_count'];
$num = Activity_scratch::getNum($info['id'],$mid,$openid,$day_count);
/* echo '<pre>';
print_r($num);exit; */
?>
<!-- body background: 背景图片铺平颜色 -->
<body style="background: #ff0000">
<img src="<?php echo $this->_theme_url; ?>/scrtch_files/bg_3.png" alt="" height="0" width="0">
	<!-- banner以及背景图，640*960，多余部分使用纯色铺开 -->
	<div class="scratch_wrap" id="scratch_wrap" style="display:block;">
	<div class="content_wrap_style_1" style="background:url(<?php echo $this->_theme_url; ?>/scrtch_files/bg_1.png) no-repeat center top;background-size: 320px 480px;">
		<div class="style_1_part_1">
			<div class="change" style="background:url(<?php echo $this->_theme_url; ?>/scrtch_files/bg_2.png) no-repeat center center;background-size: 276px 133px ">
				<div class="text">
					您还有<span id="changeNumber"><?php echo $num?></span>次机会
				</div>
				<div style="cursor: crosshair;" class="scratchCard" id="scratchCard">
				    <img style="position: absolute; width: 100%; height: 100%; display: block;" crossorigin="" src="<?php echo $this->_theme_url; ?>/scrtch_files/bg_4.png">
				    <canvas height="40" width="185" style="position: absolute; width: 100%; height: 100%;"></canvas>
				</div>
				<div class="prizeText" id="prizeText"></div>
				<div class="prizeZero" id="prizeText"></div>
			</div>
		</div>
		<div class="style_1_part_2 web_flex">
			<div class="button button1 web_flex_1" id="share"></div>
			<div class="button button2 web_flex_1" id="myPrizeRecord"></div>
		</div>
		<div class="style_1_part_3" style="background:url(<?php echo $this->_theme_url; ?>/scrtch_files/bg_7.png) repeat left top;">
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>活动时间</strong></div>
				</div>
				<div class="content">
					<p><span class="icon"></span><?php echo date('Y年m月d日 H时i分',$info['start_time']). '--' .date('Y年m月d日 H时i分',$info['end_time']);?></p>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>惊喜奖品</strong></div>
				</div>
				<div class="content">
				<?php foreach($prize as $val){?>
					<p><span class="icon"></span><?php echo $val['title']?>:<?php echo $val['name']?>：<?php echo $val['count']?>名</p>
			     <?php }?>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>活动规则</strong></div>
				</div>
				<div class="content">
					<p>
					   <span class="icon"></span>
					   <?php echo $info['rule']?>
					</p>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>领取规则</strong></div>
				</div>
				<div class="content">
					<p>
					   <span class="icon"></span>
					   <?php echo $info['lingjiang']?>
					</p>
				</div>
			</div>
		</div>
	</div>
	<!-- 中奖列表浮层 -->
	<div class="winning_list" id="winning_list">
		<div class="title">
			中奖列表
		</div>
		<div class="content">
			<div class="head_wrap web_flex">
				<div class="h h1 web_flex_1">中奖名称</div>
				<div class="h h2 web_flex_1">兑换码</div>
			</div>
			<ul class="list">
				
			</ul>
			<div class="button" id="winning_button"></div>
		</div>
	</div>
	<!-- 中奖浮层 -->
	<div class="prize_layer_wrap" id="prize_layer_wrap">
		<div class="prize_layer">
			<div class="top"></div>
			<div class="content">
				<p class="text">
					
				</p>
			</div>
			<div class="button" id="make_sure"></div>
			<div class="button" id="make_sure_and_showlogin" style="display:none;" ></div>
			<div class="button" id="make_sure_ok" style="display:none"></div>
		</div>
	</div>

	<!-- 分享浮层 -->
	<div class="wx_share_layer" id="wx_share_layer"></div>
	<div>
	
	<script>
            <?php if(!$param['mid']){?>
                            showlogin();
            <?php } ?>
	    var count = "<?php echo $num?>"; //当前用户今天可刮奖的次数
	    var id = "<?php echo $info['id']?>";           //刮奖活动的id
	    //进入页面后获取用户的mid或openid在页面最上面
		//var openid = "<?php echo $openid;?>";          //微信用的openid，用于区分是哪个微信用户
		//var mid = "<?php echo $mid?>";           //用户登录注册后的 用户id

 

		var flag  = 0;                                 //分享用到的字段
		var number = 0;
		var show   = 0;  
		$('#scratchCard').wScratchPad({
			size: 15,
    		bg: '<?php echo $this->_theme_url; ?>/scrtch_files/bg_4.png',
    		fg: '<?php echo $this->_theme_url; ?>/scrtch_files/bg_3.png',
    		scratchMove: function (e, percent) {
    			var time = <?php echo $time;?>;
    			var startTime = <?php echo $info['start_time']?>;
    			var endTime = <?php echo $info['end_time']?>;
    			if(parseInt(count)<1){
    				$("#prize_layer_wrap").show();
    				$("#prize_layer_wrap p").text('亲！今天次数已经用完，明天再来!');
    				return false;
    			}
    			if(time<startTime){
    				$("#prize_layer_wrap").show();
					$("#prize_layer_wrap p").text('亲！活动尚未开始!');
					return false;
        		}
    			if(time>endTime){
    				$("#prize_layer_wrap").show();
					$("#prize_layer_wrap p").text('亲！活动已结束!');
					return false;
        		}
    			if(percent >= 50) {
    				this.clear();
    				show++;
    				if(show == 1) {
    					$("#prize_layer_wrap").show();
    				}
    			}
    			//ajax请求
    			number++;
    			if(number == 1){
					<?php if(!$param['mid']){?>
        			    	$("#prizeText").text('请先登录!');
    						$("#prize_layer_wrap p").text('登陆之后才能玩耍哦!');
    						$('#make_sure').hide();
    						$('#make_sure_and_showlogin').show();
   
    						return false;
							<?php
						}
					?>
    			    var url = "<?php echo $this->createUrl('/activity/scratchcard/getwin')?>";
    			    var data ={id:id,openid:openid,mid:mid};
    			    $.post(url,data,function(res){
        			    var res = JSON.parse(res);
        			    if(res.statue==0){
        			    	$("#prizeText").text(res.msg);
    						$("#prize_layer_wrap p").text('很遗憾你没有中奖！您还有'+(count-1)+'次刮卡机会！');
        			    }
        			    if(res.statue == 1){
        			    	$("#prizeText").text(res.msg);
    						$("#prize_layer_wrap p").text('恭喜您，中得 "'+res.msg+'" 领奖码"'+res.code+'" 您还有'+(count-1)+'次刮卡机会！');
        			    }
        			    
    			    })
        		}
    	  }
    	});

		//点击关闭
		$("#make_sure").on('click', function(){
			window.location.reload();
		})
		$("#make_sure_and_showlogin").on('click',function(){
			$(".prize_layer_wrap").hide();
			showlogin();
		})
		//中奖列表
		$("#myPrizeRecord").on('click', function() {
			var url = "<?php echo $this->createUrl('/activity/scratchcard/userwinprize')?>";
		    var data= {id:id,openid:openid,mid:mid};
			$.post(url,data,function(data){
				var data = JSON.parse(data);
				$("#winning_list").show();
				$('#winning_list .list').html('');
				var _li = '';
				if(data.code == 1){
					for(var i in data.msg){
						_li+= '<li class="web_flex"><div class = "l l1 web_flex_1">'+data.msg[i].title+'</div><div class = "l l2 web_flex_1">'+data.msg[i].code+'</div></li>';
					}
				}else{
					_li = '<li class="web_flex"><div class = "l web_flex_1" style="text-align:center;">无中奖记录</div></li>';
				}
				$('#winning_list .list').append(_li);
				$("#winning_list").show();
			});
		});
		$("#winning_list").on('click', function() {
			$(this).hide();
		});

	
	</script>
	

	
	<!-- 微信分享 -->
	<script>
	//点击关闭浮层
	$("#wx_share_layer").on('click', function() {
		$(this).hide();
	});

	//打开浮层
	$("#share").on('click', function() {
		$("#wx_share_layer").show();
	});
	
	
	</script>

</div></div>

<?php $a = JkCms::getAdsbyid(30);?>
<?php if($a["type"]==1){?>
<a href="<?php echo $a["url"]?>">
<img src="<?php echo JkCms::show_img($a["picture"])?>" style="<?php if(intval($a["width"])){?>width:<?php echo intval($a["width"])?>px;<?php } ?><?php if(intval($a["height"])){?>height:<?php echo intval($a["height"])?>px;<?php } ?>">
</a>
<?php }else if($a["type"]==2){?>
<?php echo $a["code"]?>
<?php } exit; ?>

</body></html>