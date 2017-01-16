
<?php echo $this->renderpartial('/common/header1',$config); ?>

<script>
	window.onload = function(){
		getnumber();
	}
	function getnumber(){
		var html="";
		$.ajax({
			type: "post",
			cache: !1,
			async: !1,
			data: {
				num:1//这个值随意写的 ，不用都可以
			},
			url: "<?php echo $this->createUrl('/h5/member/ajaxnum')?>",
			dataType: "json",
			beforeSend: function() {
				//alert("ok");
			},
			success: function(data) {
				$("#points").html(data.points);
				$("#recom").html(data.recommendnum);
				$("#message").html(data.list);
				var shop=data.shop?data.shop:0;

				for(var i = 0;i < shop.length; i++) {
				<?php if( $this->member['status'] == 0){ ?>
					html = '<li class="bt"><a href="/h5/member/login"><img src="/jfshop/'+shop[i].l_url+'"/></a></li>';
					<?php }else{ ?>
					html = '<li class="bt"><a href="/jfshop/b2c/wap/product/detail/id/'+shop[i].goods_id+'.html"><img src="/jfshop/'+shop[i].l_url+'"/></a></li>';
					<?php }?>
					$("#shop ul").append(html);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(" 数据获取异常，请刷新页面重试！");
			}
		});
	}
</script>

<div class="div-main">
	<div class="user-top">
		<img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-bg.jpg" width="100%" />

		<?php if($this->member) {
			$username = $this->member['username'];
		}
		if(!$this->member['username']){
			$username = $this->member['name'];
		}
		?>
		<div class="user-top-1">
			<a href="<?php echo $this->createUrl('/h5/member/updateInfo'.$param)?>">
				<?php if($this->member['headimgurl']){?>
				<em><img src="<?php echo $this->member['headimgurl']?>"/></em>
				<?php }else{?>
				<em><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-test1.png"/></em>
				<?php }?>
                <?php if( $username){?>
					 <p><?php echo $username ?><i></i></p>
					<?php }else{?>
					 <p></p>
						<?php }?>
			</a>
		</div>

		<div class="user-top-2">
			<?php if($user==1){ ?>
				<a>已签到</a>
			<?php }else{?>
				<?php if( $this->member['status'] ==0){?>
				<a style="color: #fff;border-color: #fff;" href="/h5/member/login">去签到</a>
				<?php }else{?>
				<a style="color: #fff;border-color: #fff;" href="javascript:;" id="pccked">去签到</a>
			<?php } }?>
		</div>

	</div>


	<div class="mgb user-info clearfix">
		<ul>
			<li>
				<?php if( $this->member['status'] ==0){?>
					<a href="/h5/member/login">
					<?php }else{?>
					<a href="/jfshop/b2c/wap/account/order_jflog.html">
						<?php }?>
					<p id="points">0</p>
					<em>我的积分</em>
				</a>
			</li>

			<li class="bl">
				<?php if( $this->member['status'] ==0){?>
				<a href="/h5/member/login">
					<?php }else{?>
					<a href="<?php echo $this->createUrl('/h5/member/activity'.$param)?>">
						<?php }?>
					<p id="recom">0</p>
					<em>我的活动</em>
				</a>
			</li>
			<li class="bl">
				<?php if( $this->member['status'] ==0){?>
				<a href="/h5/member/login">
					<?php }else{?>
					<a href="<?php echo $this->createUrl('/h5/member/message'.$param)?>">
						<?php }?>
					<p><?php //echo $all_list?><i style="color: #e73434;" id="message">0</i></p>
					<em>我的信息</em>
				</a>
			</li>
		</ul>
	</div>

	<div class="mgb user-nav clearfix">
		<ul>
			<li class="bb">
				<?php if( $this->member['status'] ==0){?>
				<a href="/h5/member/login">
					<?php }else{?>
					<a href="<?php echo $this->createUrl('/h5/calendar/index'.$param)?>">
						<?php } ?>
					<span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-icon-img3.png"/></span>
					<em>日历</em>
				</a></li>
			<li class="bl bb">
				<?php if( $this->member['status'] ==0){?>
				<a href="/h5/member/login">
					<?php }else{?>
					<a href="<?php echo $jfshop; ?>">
						<?php } ?>
             	    	<span>
             	    		<!--<i class="tipsnum">2</i>-->
             	    		<img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-icon-img4.png"/></span>
					<em>积分商城</em>
				</a></li>
			<!--<li class="bl bb">
				<a href="<?php /*echo $this->createUrl('/h5/cityLife/index'.$param); */?>">
					<i><img src="<?php /*echo $this->_theme_url;*/?>assets/h5newstyle/images/user-icon-img5.png"/></i>
					<span><img src="<?php /*echo $this->_theme_url;*/?>assets/h5newstyle/images/user-icon-img2.png"/></span>
					<em>城市服务</em>
				</a></li>-->
			<li class="bl bb"><a href="http://weiqin.dachuw.net/app/index.php?i=1&c=entry&do=home&m=duobao_gz">
					<span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-icon-img1.png"/></span>
					<em>一元购</em>
				</a></li>
		 <li class="bl"><a href="/h5/hbbank">
             	       <span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-icon-img4_1.png"/></span>
             	    	<em>市民贷</em></a>
             	    </li>
      <li class="bl">
             	      <i>更多板块即将上线..</i>
             	    </li>
		</ul>
	</div>


	<div class="user-like clearfix mgb">
		<h3 class="clearfix">
			<span>猜你喜欢</span>
			<!--<a href="" class="fr">
				<img src="<?php /*echo $this->_theme_url;*/?>assets/h5newstyle/images/user-icon-img6.png"/>
			</a>-->
		</h3>


		<div class="clearfix user-like-list" id="shop">
			<ul>

			</ul>

		</div>


	</div>


	<input type="hidden" name="unum" id="unum" value="<?php echo $openid;?>" />

</div>


</body>
</html>
<script>



	if(<?php echo $user; ?> && <?php echo $user; ?>!=1 ){
		document.getElementById("pccked").addEventListener("click", clickbtn, false);
	}

	function clickbtn() {

		var a = $("#unum").val(),
			d = $("#regtips");
		var status = "<?php echo $pccheckin['status']?>"
		if(status=='活动已经结束'){
			alert("活动已经结束");
			return false;
		}
		if(<?php echo $user ?>==-8){
			alert('该商家还没有创建签到活动');
			return false;
		}
		$.ajax({
			type: "post",
			cache: !1,
			async: !1,
			data: {
				openid: a,
				//openid: "oqXmpwQMa3dL2OmGd4kt5XKYcOXY",
				pid:<?php echo $pccheckid?$pccheckid:1; ?>,
				mid:"<?php echo $this->member['id']; ?>",
				//mid:293,
			},
			url: "<?php echo $this->createUrl('/activity/pccheckin/AddUser')?>",
			dataType: "json",
			beforeSend: function() {
				//alert("ok");
			},
			success: function(data) {
				$("#loadingdiv").hide();
				if (data.code == 1) {
					alert("签到成功");
					window.location.reload();//刷新当前页面
				}else if(data.code==2){
					alert("您已经签到过了");
				} else {
					alert("签到失败");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("网络异常");
			}
		})

	}

</script>