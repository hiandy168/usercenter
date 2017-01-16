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
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<script>
    var siteUrl = "<?php echo $this->_siteUrl; ?>";
</script>

<div class="div-main" style="height: 100%;">
    <form class="form-horizontal" style="display: block; height: 100%;" method="post" role="form" onsubmit="return check()">

    <div class="shop-scroll">

       <!-- <div class="top-title clearfix">
            <a class="lefta fl" href="javascript:history.back();void(0)">商品详情</a>
        </div>-->

        <div class="shop-buybanner"><img src="<?php echo    $this->_siteUrl.'/'.$image['m_image'][0]?>" width="100%" /></div>

        <div class="shop-buyconfirm-info  bb">
            <h3><?php  echo $row['name'];?></h3>
            <?php if($row['paytype']==3){?>
                <p>所需金额：<?php echo $row['price_jifen']?>积分</p>
            <?php }else{?>
                <p>所需金额：￥ <?php echo $row['price']?></p>
            <?php } ?>
        </div>


    </div>




    <div class="shop-foot-buy">

        <div class="shop-buyconfirm-btn">
            <a class="btn" id="mysubmit"  onclick="_checkout()"  >确认兑换</a>
        </div>

    </div>


    </form>


</div>


</body>
</html>
<script language="javascript">

    function _checkout(){
        $('#mysubmit').attr("disabled", true);
//        var remark = $('#remark').val();
        $.ajax({
            type: "post",
            url: "<?php echo $this->_siteUrl;?>/b2c/wap/product/submit",
//                data:{remark:remark,payment:payment},
            data:{goods_id:<?php echo $row['goods_id'];?>},
            dataType:'json',
            beforeSend: function(XMLHttpRequest){},
            success: function(data){
                if(data.code==200){
                    window.location.href = '<?php echo $this->_siteUrl;?>/b2c/wap/checkout/payment/paynum/true/orderid/'+data.order_id;
                }
                if(data.code==400){
                    alert(data.msg);
                    window.location.reload();
                }
            },
            error: function(){}
        });

    }
</script>