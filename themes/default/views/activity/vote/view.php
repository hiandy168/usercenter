<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no" />
	<meta name="Keywords" content="投票" />
	<meta name="description" content="投票" />
	<title>投票</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>vote/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/login/css/login1.css"/>

	<script src="<?php echo $this->_theme_url; ?>assets/index/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>


	<script src="<?php echo $this->_theme_url; ?>vote/js/zepto.js"></script>
	<script src="<?php echo $this->_theme_url; ?>vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		Zepto(function($){
			$("#searchinp").focus(function(){
				$(".dis-footer").hide();
			})
			$("#searchinp").blur(function(){
				$(".dis-footer").show();
			})
		})
	</script>
	<script type="text/javascript">
		openid = "<?php echo $param['openid']?>";
		id = "<?php echo $id?>";
		pid = "<?php echo $pid?>";
		//	backUrl = "<?php echo $param['backUrl']?>";
		mid = "<?php echo $param['mid'] ?>";
		table = "vote";
	</script>
	<script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>


</head>
<body>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>

<?php if(isset($end_activity)){?>
	<script type="text/javascript">
		$(document).ready(function(){
				layer.alert('活动<?php echo $end_activity?>', {icon: 6});
		});
	</script>
<?php }?>
<div class="div-main">


	<?php if(isset($vote['img'])){?>
		<div><img id="imgh" style="display: block;" src="<?php echo JkCms::show_img($vote['img']); ?>" width="100%" /></div>
	<?php }else{ ?>
		<div><img id="imgh" style="display: block;" src="<?php echo $this->_theme_url; ?>vote/images/vote-img1.jpg" width="100%" /></div>
	<?php }?>



	<div class="vote-bm clearfix">
		<ul>
			<li><p>
					已报名<br />
					<?php echo $joinnum?>
				</p></li>
			<li>
				<a>已投票数<br /><?php echo $mynum?></a>
			</li>
			<li><p>
					投票人次<br />
					<?php echo $usernum?>
				</p></li>
		</ul>

	</div>



	<div class="vote-search">
		<form action="" method="post">
			<input type="text" placeholder="请输入参赛者ID或姓名" name="search" id="searchinp" value="" />
			<input type="submit" value=""/>
		</form>
	</div>



	<!--list star-->




	<div class="vote-list">

		<div class="vote-list1">

			<ul>
				<?php foreach($votelist as $key=>$value){?>
				<li>
					<div class="vote-listdiv">

						<i class="<?php echo $value['isjoin']?>">+1</i>
						<?php if( $value['isjoin']=="dz"){?>
						<i onclick="vote(<?php echo $value['id']; ?>)" class="<?php echo $value['isjoin']?>"></i>
							<?php }else{?>
							<i class="<?php echo $value['isjoin']?>"></i>
						<?php }?>
						<a href="<?php echo $this->createUrl('/activity/vote/Details',array('id'=>$value['id'],'vid'=>$id,'mid'=>$param['mid']))?>">
							<img src="<?php echo JkCms::show_img($value['img']) ?>"/>

							<dl>
								<dd>
									<p>ID:<?php echo $value['id']; ?></p>
									<p><i></i>:<?php echo $value['vote_number']; ?></p>
								</dd>
								<dd>
									<p><?php echo $value['title']; ?></p>
								</dd>
							</dl>

						</a>
					</div>
				</li>
				<?php }?>

		</ul>
		</div>


	</div>



	<!--list end-->



	<div class="dis-footer">

		<ul>
			<li><a href="index.html">首页</a></li>
			<li><a href="<?php echo $this->createUrl('/activity/vote/ranking',array('id'=>$id,'pid'=>$pid))?>">票数排行</a></li>
			<li><a href="<?php echo $this->createUrl('/activity/vote/Introduce',array('id'=>$id,'pid'=>$pid))?>">活动说明</a></li>
			<li><a href="<?php echo $this->createUrl('/activity/vote/myvote',array('id'=>$id,'pid'=>$pid))?>">我的投票</a></li>
		</ul>

		<!--<a class="bm" href="">我要报名</a>-->

	</div>

</div>
<script>
	<?php if(!$param['mid']){?>
	showlogin();
	<?php } ?>

function vote(vid){
	$.ajax({
		type: "POST",
		url: "<?php echo $this->createUrl('/activity/vote/ajaxvote');?>",
		data:{
			"vid": <?php echo $id?>,
			"pid":<?php echo $pid?>,
			"id":vid,
			"mid":mid,
		},
		success: function(msg){
			// alert(msg);
			if(msg==1){
				alert("投票成功");
				window.location.reload();//刷新当前页面
			}else if(msg==2){
				alert("参数错误");
			}else if(msg==4){
				alert("已经投过票了");
				//window.location.reload();
			}else if(msg==-1){
				alert("活动已结束");
				//window.location.reload();
			}else{
				alert("数据错误");
			}
		}
	});

}


</script>


</body>
</html>





