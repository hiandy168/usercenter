<!DOCTYPE html>
<html lang="en"><head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<title><?php echo $config['site_title']?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/base.css">
	<style type="text/css">
		.winning_list .list {
			height: 180px;
			overflow-y: scroll;
		}
	</style>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/jquery.js"></script>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/wScratchPad.js"></script>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/wx.js"></script>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/preloadjs.js"></script>
	<script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/layer/layer.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript">
		openid = "<?php echo $param['openid']?>";
		id = "<?php echo $param['id']?>";
		pid = "<?php echo $param['id']?>";
		//	backUrl = "<?php echo $param['backUrl']?>";
		mid = "<?php echo $param['mid'] ?>";
		table = "scratch";
	</script>
	<script src="<?php echo $this->_theme_url;?>assets/h5/login/js/login.js" type="text/javascript" charset="utf-8"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
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
<body >
<!-- <img src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/bg_3.png" alt="" height="0" width="0"> -->
<!-- banner以及背景图，640*960，多余部分使用纯色铺开 -->




<div class="" id="scratch_wrap" style="display:block;">
	<div class="scratch-main">

    <div class="scratch-img">
    	<img src="<?php echo JkCms::show_img($info['img']) ?>" alt="" >
    </div>
    
		<div class="scratch-ca">
			<div class="scratch-ca1">
				<div class="num">
					您还有<span id="changeNumber"><?php echo $num?></span>次机会
				</div>
				<div  class="scratchCard" id="scratchCard">
					<canvas></canvas>
				<div class="prizeText" id="prizeText"></div>
				<div class="prizeZero" id="prizeText"></div>
				</div>			
			</div>
		</div>

		<div class="scratch-sbtn">
			<div class="sbtn sbtn1" id="share"></div>
			<div class="sbtn sbtn2" id="myPrizeRecord"></div>
		</div>

           
          <div class="scratch-info">    
		     <div class="scratch-info1">
				<div class="scratch-info2">活动时间</div>
					<p><?php echo date('Y年m月d日 H时i分',$info['start_time']). '--' .date('Y年m月d日 H时i分',$info['end_time']);?></p>
				</div>

				<div class="scratch-info1">
				<div class="scratch-info2">惊喜奖品</div>
					<?php foreach($prize as $val){?>
						<p><?php echo $val['title']?>:<?php echo $val['name']?>：<?php echo $val['count']?>名</p>
					<?php }?>
				</div>

					<div class="scratch-info1">
				<div class="scratch-info2">活动规则</div>
					<p>
						<?php echo $info['rule']?>
					</p>
				</div>

					<div class="scratch-info1">
				<div class="scratch-info2">领取规则</div>
					<p>
						<?php echo $info['lingjiang']?>
					</p>
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
			$("#winlogin").hide();
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
				bg: '<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/bg_4.png',
				fg: '<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/bg_3.png',
				scratchMove: function (e, percent) {
					<?php if(!$param['mid']){?>
					showloginssss();
					return false;
					<?php } ?>

					var time = <?php echo $time;?>;
					var startTime = <?php echo $info['start_time']?>;
					var endTime = <?php echo $info['end_time']?>;
					if(parseInt(count)<1){
						layer.msg('亲！今天次数已经用完，明天再来!',{shade: 0.3}, {icon: 5});
						return false;
					}
					if(time<startTime){
					layer.msg('亲！活动尚未开始!',{shade: 0.3}, {icon: 5});
					
						return false;
					}
					if(time>endTime){
						layer.msg('亲！活动已结束!',{shade: 0.3}, {icon: 5});
						
						return false;
					}
					if(percent >= 50) {
						this.clear();
						show++;
						if(show == 1) {
							// $("#prize_layer_wrap").show();
						}
					}
					//ajax请求
					number++;
					if(number == 1){
						<?php if(!$param['mid']){?>
						$("#prizeText").text('请先登录!');
						layer.msg('登陆之后才能玩耍哦!',{shade: 0.3}, {icon: 5});
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
                                                        
                                                       if(data.code ==-1){
                                                               layer.alert(data.msg, {icon: 5});
                                                               return false;
                                                        }

                                                        if(data.code ==-2){
                                                              layer.alert(data.msg, {icon: 5});
                                                                  return false;
                                                        }

                                                        if(data.code ==-3){
                                                                  layer.alert(data.msg, {icon: 5});
                                                                  return false;
                                                        }
                                                        
							if(res.state==0){
								$("#prizeText").text(res.msg);
								setTimeout(function(){	
									layer.alert('很遗憾你没有中奖！您还有'+(count-1)+'次刮卡机会！', {icon: 5},function(){
									window.location.reload();
								});},1500)
							}
							if(res.state == 1){
								$("#prizeText").text(res.msg);
                   setTimeout(function(){	
									layer.alert('恭喜您，中得 "'+res.msg+'" 领奖码"'+res.code+'" 您还有'+(count-1)+'次刮卡机会！', {icon: 6},function(){
									window.location.reload();
								});},1500)

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
				showloginssss();
			})
			//中奖列表
			$("#myPrizeRecord").on('click', function() {
				<?php if(!$param['mid']){?>
				showloginssss();
				return false;
				<?php } ?>
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
			WeixinApi.ready(function(Api){

				// 微信分享的数据
				var wxData = {
					"imgUrl":'http://f.seals.qq.com/filestore/10031/73/0b/63/1000344/160515111317_ccbbde51af72979e6e4ec2e1cdc52da1.png',
					"link":'http://mp.weixin.qq.com/s?__biz=MzA4NDY5MzAyNw==&amp;mid=517180370&amp;idx=1&amp;sn=da69672db55227746f6ba4144912b5ea#rd',
					"desc":'中邮保险湖北分公司给你送大奖',
					"title":'中邮保险湖北分公司给你送大奖'
				};

				// 分享的回调
				var wxCallbacks = {
					// 分享操作开始之前
					ready:function () {

						// 你可以在这里对分享的数据进行重组
					},
					// 分享被用户自动取消
					cancel:function (resp) {
						// 你可以在你的页面上给用户一个小Tip，为什么要取消呢？
					},
					// 分享失败了
					fail:function (resp) {

						// 分享失败了，是不是可以告诉用户：不要紧，可能是网络问题，一会儿再试试？
					},
					// 分享成功
					confirm:function (resp) {
						var shareFlag = "1";
						if(shareFlag==1){
							$.post("/Components/f/ID/117/do/ajaxScratchShare",{FID:FID,openId:openId},function(){},'json');
							// 分享成功了，我们是不是可以做一些分享统计呢？
						}
					},
					// 整个分享过程结束
					all:function (resp) {
						// 如果你做的是一个鼓励用户进行分享的产品，在这里是不是可以给用户一些反馈了？
					}
				};

				// 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
				Api.shareToFriend(wxData, wxCallbacks);

				// 点击分享到朋友圈，会执行下面这个代码
				Api.shareToTimeline(wxData, wxCallbacks);

				// 点击分享到腾讯微博，会执行下面这个代码
				Api.shareToWeibo(wxData, wxCallbacks);
			});


		</script>

	</div></div>

<script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/assets/globe.js"></script>

<?php if($info['share_switch']==1){
	 echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/scratchcard/view',array('id'=>$param['id']) )));
}else { ?>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
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
<?php }?>

</body></html>
