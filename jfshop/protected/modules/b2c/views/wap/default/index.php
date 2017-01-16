<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no" />
	<meta name="Keywords" content="积分商城" />
	<meta name="description" content="积分商城" />
	<title>积分商城</title>
	<link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/css/style.css"/>
	<script src="<?php echo $this->_siteUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/layout.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/slides.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/js/com/com.js"></script>

	<script type="text/javascript">
		window.onload = function () {
			var mySwiper1 = new Swiper('.shop-banner1', {
				visibilityFullFit: true,
				loop: true,
				pagination: '.pagination',
				centeredSlides: true,
				speed:600,
				autoplay: 3000,
				autoplayDisableOnInteraction: false
			});
		}

		$(function(){
			$(".rnav1").click(function(){
				if($(this).hasClass("selected")){
					$(this).removeClass("selected")
					$(".shop-top-form").hide();
				}else{
					$(this).addClass("selected")
					$(".shop-top-form").show();
				}
			})
			$(".shop-hotnavr ul li").click(function(){
        	 	    var num=$(this).index();
        	 		$("html,body").animate({
        	 			scrollTop: $('#a'+num+'').offset().top},500)
      })
		})

	</script>
</head>

<body>



<div class="div-main">
	<?php $this->renderPartial('/wap/common/header', array('config' => $config)); ?>
	<link type="text/css" rel="stylesheet" href="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/css/home/index.css"/>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/js/com/jquery.touchslider.min.js"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/js/home/index.js"></script>	<script>
		jQuery(function($) {
			$(window).resize(function(){
				var width=$('#js-com-header-area').width();
				$('.touchslider-item a').css('width',width);
				$('.touchslider-viewport').css('height',300*(width/640));
			}).resize();
			$(".touchslider").touchSlider({mouseTouch: true, autoplay: true});
		});
	</script>
	<!--	<div class="shop-top clearfix">-->
<!---->
<!--		<div class="logo fl"><a href=""><img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img1.png"/></a></div>-->
<!---->
<!--		<div class="fr shop-rnav">-->
<!--			<ul>-->
<!--				<li>-->
<!--					<div class="rnav1"><a href=""><img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img6.png"/></a></div>-->
<!--				</li>-->
<!--				<li><div class="rnav2"><a href=""><img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img5.png"/></a></div></li>-->
<!--				<li>-->
<!--					<div class="rnav3">-->
<!--						<a href="">-->
<!--							<img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img7.png"/>-->
<!--							<i>2</i>-->
<!--						</a>-->
<!--					</div>-->
<!--				</li>-->
<!--			</ul>-->
<!---->
<!--		</div>-->
<!---->
<!--	</div>-->


	<!--top end-->


	<div class="shop-banner">
		<div class="shop-banner1 swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?php if(empty($pic_arr)){?>
				<div class="swiper-slide">
					<a href="" target="_blank"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img2.jpg" /></a>
				</div>
				<div class="swiper-slide">
					<a href="" target="_blank"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img2.jpg" /></a>
				</div>
				<div class="swiper-slide">
					<a href="" target="_blank"><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img2.jpg" /></a>
				</div>
				<?php }else{  foreach ($pic_arr as  $k=>$v){?>
					<div class="swiper-slide">
						<a href="<?php echo $v['url'];?>" target="_blank"><img src="http://<?php echo  $_SERVER['HTTP_HOST'] ."/".$v['picture']; ?>" /></a>
					</div>
				<?php }}?>

			</div>
			<div class="pagination"></div>
		</div>

		<!--banner end-->
		<div class="shop-mnav clearfix">
			<ul>
				<li>
					<?php if(Mod::app()->session['member_project']){?>
					<a href="/h5/member/point">
						<?php }else{?>
					<a href="<?php  echo isset(Mod::app()->session['member'])?"/jfshop/b2c/wap/default/Redhref/href/point/mid/".Mod::app()->session['member']['id']:"/jfshop/b2c/wap/account/login"; ?>">
						<?php } ?>
						<div class="shop-mnav1">
   	            				<span class="clearfix">
   	            					<i><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img12.png"/></i>
   	            			         <em>赚积分</em>
   	            				</span>
							<p>多种任务赚到手软</p>

						</div>
					</a>

				</li>
				<li>
					<?php if(Mod::app()->session['member_project']){?>
						<a href="/h5/member/index">
					<?php }else{?>
						<a href="<?php echo isset(Mod::app()->session['member'])? "/jfshop/b2c/wap/default/Redhref/mid/".Mod::app()->session['member']['id']:"/jfshop/b2c/wap/account/login"; ?>">
					<?php }?>
							<div class="shop-mnav1">
   	            				<span class="clearfix">
   	            					<i><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img3.png"/></i>
   	            			         <em>个人中心</em>
   	            				</span>
							<p>积分<?php echo  isset(Mod::app()->session['member']['points'])? Mod::app()->session['member']['points']:0;?></p>
						</div>
					</a>
				</li>
			</ul>
		</div>





<!--		<div class="shop-hotnav clearfix bb bt">-->
<!---->
<!--			<div class="fl">-->
<!--				<h2>热门专区</h2>-->
<!--			</div>-->
<!---->
<!--			<div class="shop-hotnavr">-->
<!--				<ul>-->
<!--					<li>-->
<!--						<a>-->
<!--							<div class="nav">-->
<!--          						<span>-->
<!--          							<i>兑</i>-->
<!--          						</span>-->
<!--								<p>兑换专区</p>-->
<!--							</div>-->
<!--						</a>-->
<!--					</li>-->
<!--					<li>-->
<!--						<a>-->
<!--							<div class="nav c1">-->
<!--          						<span>-->
<!--          							<i>购</i>-->
<!--          						</span>-->
<!--								<p>换购专区</p>-->
<!--							</div>-->
<!--						</a>-->
<!--					</li>-->
<!--					<li>-->
<!--						<a href="">-->
<!--							<div class="nav c2">-->
<!--          						<span>-->
<!--          							<i>奖</i>-->
<!--          						</span>-->
<!--								<p>抽奖专区</p>-->
<!--							</div>-->
<!--						</a>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!---->
<!--		</div>-->





		<div id="a0" class="shop-cplist bb bt clearfix">
			<div class="fl">
				<h2>积分兑换</h2>
			</div>

			<div class="shop-cplistr">

				<div class="shop-cplistr1">

					<div class="tit clearfix">
						<span>共<?php echo $count;?>件商品</span>
						<span class="fr"><a href="<?php echo $this->_siteUrl;?>/b2c/wap/product/detaillist.html">点击查看更多...</a></span>
					</div>


					<div class="shop-cplistrdiv clearfix">
						<ul>
							<?php  $i=1;foreach ($model['new_list'] as $v):?>

							<li>
								<a href="<?php echo $this->createAbsoluteUrl('/b2c/wap/product/detail',array('id'=>$v['goods_id']))?>">
									<div class="shop-cpdiv">
										<img style="width: 100%; " src="<?php echo $this->_siteUrl.'/'.$v['s_url']?>"/>
          						<span>
          							<h3><?php echo GlobalFunc::globalSubstr($v['name'],10);?></h3>
          							
									<?php if($v['paytype'] != 3 ){ ?>
										<h4>价格：￥<?php echo $v['price']?></h4>
									<?php }else{?>
										<h4>积分：<?php echo $v['price_jifen']?></h4>
									<?php } ?>
          							<p>已有<?php echo $v['con'];?>人兑换</p>
									<?php if($v['store'] <= 0) echo "<i class=\"i3\">已兑完</i>"; else echo "<i class=\"i1\">当前可兑</i>";?>
          						</span>
									</div>

								</a>
							</li>
							<?php $i++;endforeach;?>

							
						</ul>
					</div>

				</div>

			</div>


		</div>



<!--		<div id="a1" class="shop-cplist bb bt clearfix">-->
<!--			<div class="fl">-->
<!--				<h2>积分换购</h2>-->
<!--			</div>-->
<!---->
<!---->
<!--			<div class="shop-cplistr">-->
<!---->
<!--				<div class="shop-cplistr1">-->
<!---->
<!--					<div class="tit clearfix">-->
<!--						<span>共12356件商品</span>-->
<!--						<span class="fr"><a href="--><?php //echo $this->_siteUrl;?><!--/b2c/wap/product/detaillist.html">点击查看更多...</a></span>-->
<!--					</div>-->
<!---->
<!---->
<!--					<div class="shop-cplistrdiv clearfix">-->
<!--						<ul>-->
<!--							--><?php // $i=1;foreach ($model['new_list'] as $v):?>
<!---->
<!--								<li>-->
<!--									<a href="--><?php //echo $this->createAbsoluteUrl('/b2c/wap/product/detail',array('id'=>$v['product_id']))?><!--">-->
<!--										<div class="shop-cpdiv">-->
<!--											<img style="width: 100%; height: 180px;" src="--><?php //echo $this->_siteUrl.'/'.$v['s_url']?><!--"/>-->
<!--          						<span>-->
<!--          							<h3>--><?php //echo GlobalFunc::globalSubstr($v['name'],10);?><!--</h3>-->
<!---->
<!--									--><?php //if($v['paytype'] != 3 ){ ?>
<!--										<h4>价格：￥--><?php //echo $v['price']?><!--</h4>-->
<!--									--><?php //}else{?>
<!--										<h4>积分：--><?php //echo $v['price_jifen']?><!--</h4>-->
<!--									--><?php //} ?>
<!--									<p>已有5000人兑换</p>-->
<!--									--><?php //if($v['store']==0) echo "<i class=\"i3\">已兑完</i>"; else echo "<i class=\"i1\">当前可兑</i>";?>
<!--          						</span>-->
<!--										</div>-->
<!---->
<!--									</a>-->
<!--								</li>-->
<!--							--><?php //$i++;endforeach;?>
<!---->
<!--						</ul>-->
<!--					</div>-->
<!---->
<!---->
<!--				</div>-->
<!---->
<!--			</div>-->
<!---->
<!---->
<!--		</div>-->





	</div>




</body>
</html>
