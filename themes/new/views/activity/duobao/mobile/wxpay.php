<html lang="zh-CN" style="height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>支付订单 - 大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/pay.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        object,
        embed {
            -webkit-animation-duration: .001s;
            -webkit-animation-name: playerInserted;
            -ms-animation-duration: .001s;
            -ms-animation-name: playerInserted;
            -o-animation-duration: .001s;
            -o-animation-name: playerInserted;
            animation-duration: .001s;
            animation-name: playerInserted;
        }

        @-webkit-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @-ms-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @-o-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }
    </style>
    <style id="style-1-cropbar-clipper">
        /* Copyright 2014 Evernote Corporation. All rights reserved. */

        .en-markup-crop-options {
            top: 18px !important;
            left: 50% !important;
            margin-left: -100px !important;
            width: 200px !important;
            border: 2px rgba(255, 255, 255, .38) solid !important;
            border-radius: 4px !important;
        }

        .en-markup-crop-options div div:first-of-type {
            margin-left: 0px !important;
        }
    </style>
</head>

<body>



    <?php
    if($weixin){
    ?>
        <form method="post" action="<?php echo $this->createUrl('doPay')?>">
    <?php
    }else{
    ?>
        <form method="post" action="<?php echo $this->createUrl('doPays')?>">
    <?php
    }
    ?>
<div class="m-pay-order">
    <div data-pro="list">
        <div id="pro-view-1">
            <div data-pro="entry" class="m-pay-order-list">
                <div class="m-pay-order-list-item" id="pro-view-2"><span class="m-pay-order-list-item-name"><?php echo $title?> 等</span><span class="m-pay-order-list-item-num"><b class="txt-red"><?php echo $price ?></b>人次</span></div>
            </div>
            <div class="m-pay-order-total">商品合计：<b class="txt-red"><?php echo $price ?>众筹币</b></div>
        </div>
    </div>
    <div data-pro="options" class="m-pay-order-options">
        <div class="w-option w-option-unfold" id="pro-view-6">
            <div class="w-bar-content" data-pro="groupItems">
                    <span class="pro-radioGroup" id="pro-view-7">
						<div class="w-radioBar w-bar w-radioBar-checked " id="pay_weixin" onclick="weixin()">
                            <b class="w-radio"></b>
                            微信支付
                            <div class="w-bar-ext">
                                <input name="pro-radio34" value="9999" type="radio">
                            </div>
                        </div>
						<!--<div class="w-radioBar w-bar" id="pay_zhongchoubi" onclick="zhongchoubi()">
                            <b class="w-radio"></b>
                            众筹币支付
                            <span class="txt-red w-bar-extText">剩余众筹币：0</span>
                            <div class="w-bar-ext">
                                <input name="pro-radio34" value="2404" type="radio">
                            </div>
                        </div>-->
                </span>
            </div>
        </div>
    </div>
    <input type="hidden" name="way" id="way">
    <input type="hidden" value="<?php echo $pid ?>" name="pid">
    <input type="hidden" value="<?php echo $code ?>" name="code" id="code">
    <input type="hidden" value="<?php echo $price ?>" name="price">
    <div data-pro="submit" class="m-pay-order-submit">
        <button type="submit" class="w-button w-button-main w-button-l" id="pro-view-20">确认支付</button>
    </div>
</div></form>
<script>
    weixin();

    function weixin() {
        $('#pay_weixin').removeAttr('class');
        $('#pay_zhongchoubi').removeAttr('class');
        $('#pay_weixin').attr('class', 'w-radioBar w-bar w-radioBar-checked');
        $('#pay_zhongchoubi').attr('class', 'w-radioBar w-bar');
        $('#way').val('pay_weixin');
    }

    function zhongchoubi() {
        $('#pay_weixin').removeAttr('class');
        $('#pay_zhongchoubi').removeAttr('class');
        $('#pay_weixin').attr('class', 'w-radioBar w-bar');
        $('#pay_zhongchoubi').attr('class', 'w-radioBar w-bar  w-radioBar-checked');
        $('#way').val('pay_zhongchoubi');

    }

    function submit() {
        var way = $('#way').val();
        if (way == 'pay_weixin') {
            location.href = "<?php echo $this->createUrl('/activity/duobao/doPay') ?>";
        } else if (way == 'pay_zhongchoubi') {
            location.href = "./index.php?i=29&c=entry&remark=bi_buy&do=pay_zhongchoubi&m=duobao_gz";
        } else {
            alert('请选择支付方式');
        }
    }

    window.onload = function(){

        var code = $('#code').val();
        if(code!=""){
            alert("非法访问！");
            top.location='<?php echo $this->createUrl('/activity/duobao/user', array('uid' => $uid,'pid'=>$pid)) ?>';
        }

    }

</script>
<div class="m-simpleHeader" id="pro-view-0"><a href="javascript:void(0);" data-pro="back" data-back="true" class="m-simpleHeader-back"><i class="ico ico-back"></i></a>
    <h1>支付订单</h1></div>
</body>

</html>
