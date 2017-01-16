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
	<title>结算</title>
	<link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/css/style.css"/>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/layout.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/jweixin-1.js"></script>
	<script type="text/javascript" src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/util.js"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/require.js"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/config.js"></script>
	<script type="text/javascript" src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/jquery-1.js"></script>
	<script type="text/javascript" src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/mui.js"></script>
	<script type="text/javascript" src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/common.js"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/util_002.js" data-requiremodule="util" data-requirecontext="_" async="" charset="utf-8" type="text/javascript"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/bootstrap.js" data-requiremodule="bootstrap" data-requirecontext="_" async="" charset="utf-8" type="text/javascript"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/css.js" data-requiremodule="css" data-requirecontext="_" async="" charset="utf-8" type="text/javascript"></script>
	<script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/chenkout/webuploader.js" data-requiremodule="webuploader" data-requirecontext="_" async="" charset="utf-8" type="text/javascript"></script>
</head>

<body>


<div class="div-main" style="background: #f7f7f7;">
<!--	<div class="top-title clearfix">-->
<!--		<a class="lefta fl" href="javascript:history.back();void(0)">结算</a>-->
<!--	</div>-->


	<form class="form-horizontal" method="post" role="form" onsubmit="return check()">
		<input name="goodstype" value="" type="hidden">
		<input name="address" value="" type="hidden">
		<div class="order-main">

			<h5>配送方式</h5>
			<div class="order-select">
				<select id="dispatch" name="dispatch" class="form-control">
					<!--<option selected="selected" value="3" price="0.00">在线兑换票券密码 (0.00积分)</option>-->
					<option value="1" price="0.00">暂时仅支持自行到大楚网领取</option>
				</select>
			</div>
			<h5>订单详情</h5>
			<!-- 商品列表 -->
			<?php echo $this->renderPartial('checkout/_goods_list',array(
				'item'=>$item,
				'num'=>$num,
				'amount'=>$amount,
			));?>
			

			<h5>留言</h5>
			<div class="message-box">
				<textarea class="form-control" rows="3" name="remark" id="remark" placeholder="亲，还用什么能帮助到您吗？就写到这里吧！"></textarea>
			</div>
			<button type="button" name="submit" id="mysubmit" value="yes" class="btn btn-success order-submit btn-lg" style="margin-bottom:20px;" onclick="_checkout()">提交订单</button>
			<input name="token" value="xIjY" type="hidden">
		</div>
	</form>



	<script language="javascript">

		function _checkout(){
			$('#mysubmit').attr("disabled", true);
			var $url = '<?php echo $this->_siteUrl;?>/b2c/wap/checkout/submit';
			var remark = $('#remark').val();
			$.ajax({
				type: "post",
				url: $url,
//                data:{remark:remark,payment:payment},
				data:{remark:remark},
				dataType:'json',
				beforeSend: function(XMLHttpRequest){},
				success: function(data){
					if(data.code==200){
						window.location.href = '<?php echo $this->_siteUrl;?>/b2c/wap/checkout/payment/orderid/'+data.order_id;
					}
					if(data.code==0){
						alert(data.mess);
						//window.location.reload();
					}
					if(data.code==-1){
						if(confirm("有部分商品价格发生了改变,您是否继续购买!")){
							_checkout();
						}else{
							window.location.reload();
						}
//						alert(data.mess);
					}
				},
				error: function(){}
			});

		}

		function changeAddress(){
			location.href = './index.php?i=1&c=entry&from=confirm&returnurl='.Mod::app()->request->hostInfo .'%252Fdachu%252Fapp%252Findex.php%253Fi%253D1%2526c%253Dentry%2526do%253Dconfirm%2526id%253D18%2526op%253Dconfirm%2526m%253Dewei_shopping%2526optionid%253D%2526total%253D6%2526wxref%253Dmp.weixin.qq.com&do=address&m=ewei_shopping'
		}
		function check(){
			if((".address_item").length<=0){
				alert("请添加收货地址!");
				return false;
			}
			return true;
		}

//		$("#dispatch").change(canculate);
//
//		function canculate(){
//			var prices = 0;
//			$(".goodsprice").each(function() {
//				var total = $(this).prev().text();
//				var price = $(this).next().text();
//				prices += parseFloat(total * price);
//			});
//			var dispatchprice = parseFloat($("#dispatch").find("option:selected").attr("price"));
//			if (dispatchprice > 0){
//				$("#totalprice").html(prices + dispatchprice + " 积分 (含运费"+dispatchprice + ")");
//			} else {
//				$("#totalprice").html(prices + " 积分");
//			}
//		}
//		$(function(){
//			canculate();
//		})
	</script>


	<script>require(['bootstrap']);</script>

</div>






</div>


</body>
</html>
