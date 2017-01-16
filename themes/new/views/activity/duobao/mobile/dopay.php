<style>
    body{padding-bottom:50px;}
</style>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>楚蓄罐</title>
    <meta name="format-detection" content="telephone=no, address=no">
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="keywords" content="微擎,微信,微信公众平台,we7.cc" />
    <meta name="description" content="公众平台自助引擎（www.we7.cc），简称微擎，微擎是一款免费开源的微信公众平台管理系统，是国内最完善移动网站及移动互联网技术解决方案。" />
    <link href="http://weiqin.dachuw.net/app/resource/css/bootstrap.min.css" rel="stylesheet">

    <!------------------------------------------微信支付js ---------------------------->


    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $jsApiParameters; ?>,
                function(res){
                    WeixinJSBridge.log(res.err_msg);
                    if(res.err_msg == "get_brand_wcpay_request:ok"){
                        //alert(res.err_code+res.err_desc+res.err_msg);
                        window.location.href="http://m.dachuw.net/activity/duobao/mylog/pid/<?php echo $pid ?>";
                    }else{
                        //返回跳转到订单详情页面
                        alert(支付失败);
                    }
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
    <script type="text/javascript">
        //获取共享地址
        function editAddress()
        {
            WeixinJSBridge.invoke(
                'editAddress',
                <?php echo $editAddress; ?>,
                function(res){
                    var value1 = res.proviceFirstStageName;
                    var value2 = res.addressCitySecondStageName;
                    var value3 = res.addressCountiesThirdStageName;
                    var value4 = res.addressDetailInfo;
                    var tel = res.telNumber;

                 //   alert(value1 + value2 + value3 + value4 + ":" + tel);
                }
            );
        }

        window.onload = function(){
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', editAddress, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', editAddress);
                    document.attachEvent('onWeixinJSBridgeReady', editAddress);
                }
            }else{
                editAddress();
            }
        };

    </script>


    <!------------------------------------------微信支付js  end ---------------------------->


</head>
<body>
<div class="container container-fill">
    <style>
        body{background:#EEE;}
        .container-fill{padding:.5em;}
        h4{margin:15px 0;}
        h4:first-of-type{margin-top:10px;}
        .panel{padding:.5em; margin-bottom:10px;}
        .nav.nav-tabs{margin-bottom:.8em;}
        .alert .form-group{margin-bottom:0;}
        label.form-group{display:block;}
        label.form-group{font-weight:normal; overflow:hidden; border-top:1px #DDD solid; padding-top:10px;padding-bottom:0;margin-bottom:0 }
        label.form-group .col-xs-2{margin-top:0px;}
        label.form-group input[name="type"]{opacity:0; width:0;}
        #wq_card .form-group{border-top:none;border-bottom:1px solid #ccc;}
        #wq_card .form-group .col-xs-2{margin-top:15px;}
        #wq_card .form-group:last-child{border-bottom:none}
        form .btn.btn-block{padding:10px 12px; margin-bottom:10px;}
    </style>

    <h4>订单信息</h4>
    <div class="panel">
        <div class="clearfix" style="padding-top:10px;">
            <p>商品名称 :<span class="pull-right"><?php echo $title ?>等</span></p>
            <p>订单编号 :<span class="pull-right"><?php echo $ordersn ?></span></p>
            <p>支付金额 :<span class="pull-right">￥<?php echo $price ?>.00 元</span></p>
            <p id="order_card" style="display: none">商品优惠 :<span class="pull-right text-danger"></span></p>
        </div>
    </div>
    <h4>选择支付方式</h4>
    <ul class="nav nav-tabs" role="tablist" style="margin-bottom:0;">
        <li class="active" data-id="direct"><a href="#direct" role="tab" data-toggle="tab" style="border-left:0;">直接到账</a></li>
    </ul>
    <div class="panel clearfix" style="border-top-left-radius:0; border-top-right-radius:0;">
        <div class="tab-content">
            <!-- 直接到账 -->
            <div class="tab-pane animated active fadeInLeft" id="direct">
                <div class="pay-btn" id="wechat-panel">

                        <input type="hidden" name="params" value="eyJ0aWQiOjExNzYyLCJ1c2VyIjoib3FYbXB3WjdsY0NUNllCcTgydFoxcm9BaDJhWSIsImZlZSI6IjEiLCJ0aXRsZSI6Ilx1ODI2Zlx1NWZjM1x1NWI5ZVx1NzUyOFx1NmQzZVx1NTk3ZFx1NzI2OVx1ZmYwY1x1NmI2Nlx1NmM0OVx1OTAxYVx1N2VhYVx1NWZmNVx1NTM2MVx1OGJmNFx1NGUwYVx1NWMzMVx1NGUwYVx1MjAxNFx1MjAxNFx1NTE4NVx1NTQyYjEwMFx1NGVhNFx1OTAxYVx1OGQzOSBcdThkODVcdTUwM2NcdTZiNjZcdTZjNDlcdTkwMWFcdTUzNjEgIDFcdTUxNDNcdTU5M2FcdTUzNjEiLCJvcmRlcnNuIjoiMDkxOTAyNTgiLCJ2aXJ0dWFsIjpmYWxzZSwibW9kdWxlIjoiZHVvYmFvX2d6In0=" />
                        <input type="hidden" name="encrypt_code" id="encrypt_code" value="<?php echo $ordersn ?>" />
                        <input type="hidden" name="card_id" value="" />
                        <input type="hidden" name="coupon_id" value="" />
                        <button class="btn btn-success btn-block col-sm-12"  onclick="callpay()" value="wechat">微信支付(必须使用微信内置浏览器)</button>

                </div>

            </div>

            </div>
        </div>
    </div>



    <input type="hidden" name="token" value="gXAf" />

    <div class="text-center footer" style="margin:10px 0; width:100%; text-align:center; word-break:break-all;">
        <a href="http://hb.qq.com">关于大楚网</a>
        &nbsp;&nbsp;			</div>

</div>
<style>
    h5{color:#555;}
</style>

</body>
</html>
<style>
    .footerbar{position:fixed; left:0; bottom:0px; width:100%; height:50px; background:#f1f1f1; border-top:1px solid #c9c9c9; z-index:5;}
    .footerbar a{display:block; float:left; padding:5px 0; width:24.5%; height:50px; text-align:center; color: #4f4f4f; text-decoration:none; border-left:1px solid #e1e1e1;}
    .footerbar a:first-child{border-left:0;}
    .footerbar a i{font-size:20px; display:block;}
    #footer { position:fixed;width:100%;left:0;bottom:0px;height:30px;line-height:30px;color:#fff;background:#333;border-top:0;}
</style>

