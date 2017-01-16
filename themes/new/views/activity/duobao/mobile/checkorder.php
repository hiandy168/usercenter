<html lang="zh-CN">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>购买清单 - 大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description" />
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width" />
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/commonbuy.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/cart.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/mcss/flytip.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery.gcjs.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/flytip.js" type="text/javascript" charset="utf-8"></script>
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
foreach($adList as $goods){
?>
<div class="m-cart" id="pro-view-5">
    <div class="item" id="item_17396">
        <div class="pic">
            <a href="<?php echo $this->createUrl('/activity/duobao/mobileIndex', array('id' => $goods['goods']['id'],'pid'=>$goods['goods']['pid'])) ?>"><img src="<?php echo JkCms::show_img($goods['goods']['thumb']) ?>" alt="<?php echo $goods['goods']['title'] ?>" /></a>
        </div>
        <form method="post" action="<?php echo $this->createUrl('info',array('pid'=>$goods['goods']['pid']))?>">
            <div class="text">
                <h1 class="title"><a href="<?php echo $this->createUrl('/activity/duobao/mobileIndex', array('id' => $goods['goods']['id'],'pid'=>$goods['goods']['pid'])) ?>"><?php echo $goods['goods']['title'] ?></a></h1>
                <div>
                    总需 <?php echo $goods['goods']['productprice'] ?> 人次，剩余
                    <em class="remain" id='stock'>
                        <?php echo $goods['goods']['productprice']-$goods['goods']['ticket_total'] ?> <span style="color: #222;">人次</span>
                    </em>
                </div>
                <div>
                    参与人次
                    <div class="w-number" id="pro-view-7">
                        <div style="display:none">
                            <input id="sprice_<?php echo $goods['goods']['id'] ?>" value="1"></input>
                            <span class='singletotalprice' id="goodsprice_<?php echo $goods['id'] ?>"><?php echo $goods['total'] ?></span>
                            <span id="stock_<?php echo $goods['id'] ?>" style='display:none'><?php echo $goods['goods']['total'] ?></span>
                            <span id="singleprice_<?php echo $goods['id'] ?>">1</span>
                        </div>
                        <!--        <input class="w-number-input goods_total" data-pro="input" price="1.00" pricetotal="1" value="1" maxbuy="0" id="103" pattern="[0-9]*" name="goods_103" style="height:28px"   />
    -->
                        <input class="w-number-input goods_total" data-pro="input" price="1.00" pricetotal="1" value="<?php echo $goods['total'] ?>" maxbuy="<?php echo $goods['goods']['productprice']-$goods['goods']['ticket_total'] ?>" id="<?php echo $goods['goods']['id'] ?>" pattern="[0-9]*" name="goods_<?php echo $goods['goods']['id'] ?>" style="height:28px" />

                        <a class="w-number-btn w-number-btn-plus" data-pro="plus" href="javascript:void(0);" onclick="addNum(<?php echo $goods['goods']['id'] ?>,<?php echo $goods['goods']['productprice']-$goods['goods']['ticket_total'] ?>,<?php echo $goods['id'] ?>)">+</a>
                        <a class="w-number-btn w-number-btn-minus" data-pro="minus" href="javascript:void(0);" onclick="reduceNum(<?php echo $goods['goods']['id'] ?>,<?php echo $goods['id'] ?>)">-</a>
                    </div>
                </div>
                <a href="javascript:void(0);" onclick="removeCart(<?php echo $goods['id'] ?>)" data-pro="del" class="del">删除<i class="ico ico-del"></i></a>
            </div>
    </div>


    <script>
        $("#103").keyup(function() {
            var total = 0;
            var num = $("#103").val();
            var chr = $('.goods_total');
            var goods_total = new Array(); //或者写成：var btns= [];
            jQuery('.goods_total').each(function(key, value) {
                goods_total[key] = $(this).val();
                total = total + parseInt(goods_total[key]);
            });
            $("#pricetotal").html(total);
        });
    </script>
    <?php
    }
    ?>
    <div class="g-footer">
        <div class="g-wrap">
            <ul class="m-state f-clear">
                <li><i class="ico ico-state ico-state-1"></i>公平公正公开</li>
                <li><i class="ico ico-state ico-state-2"></i>正品保证</li>
                <li class="last"><i class="ico ico-state ico-state-3"></i>权益保障</li>
            </ul>
            <p class="m-link">
                <a href="./index.php?i=29&c=entry&do=clause&m=duobao_gz">点击查看游戏说明
                </a>
            </p>
            <p>活动最终解释权归大楚网所有</p>
        </div>
    </div>
    <div class="m-simpleFooter" id="pro-view-3">
        <div data-pro="text" class="m-simpleFooter-text">
            <div id="pro-view-4" style="display: none;">
                总计：
                <em class="txt-red" id="pricetotal">2 </em>众筹币,当前剩余0众筹币
            </div>
        </div>
        <div data-pro="ext" class="m-simpleFooter-ext">
            <!-- <a href="./index.php?i=29&c=entry&do=submit_order&m=duobao_gz"><button class="w-button w-button-main" id="pro-view-2">提交</button></a> -->
            <a>
                <button class="w-button w-button-main" id="pro-view-2">提交</button>
            </a>
        </div>
    </div>
    </form>
</div>
<!--
<script>
var maxbuy = 0;


function addNum() {
    var total = $("#total");
    if (!total.isInt()) {
        total.val("1");
    }
    var stock = $("#stock").html() == '' ? -1 : parseInt($("#stock").html());
    var mb = maxbuy;
    if (mb > stock && stock != -1) {
        mb = stock;
    }
    var num = parseInt(total.val()) + 1;
    if (num > stock) {
        alert("您最多可购买 " + stock + " 件!", true);
        num--;
    }
    if (num > mb && mb > 0) {
        alert("您最多可购买 " + mb + " 件!", true);
        num = mb;
    }
    total.val(num);
}

function reduceNum() {
    var total = $("#total");
    if (!total.isInt()) {
        total.val("1");
    }
    var num = parseInt(total.val());
    if (num - 1 <= 0) {
        return;
    }
    num--;
    total.val(num);
}
</script> 
-->
<script>
    function addNum(id, maxbuy, cid) {
        var mb = maxbuy;
        var stock = $("#stock_" + id).html() == '' ? -1 : parseInt($("#stock_" + id).html());
        if (mb > stock && stock != -1) {
            mb = stock;
        }
        var sprice = parseFloat($("#sprice_" + id).val());
        var num = parseInt($("#" + id).val()) + sprice;
        if (num > mb && mb > 0) {
            	alert("最多只能购买 " + mb + " 件!",true);
            	return;
        }
        $("#" + id).val(num);
        var price = parseFloat($("#singleprice_" + id).html()) * num;
        $("#goodsprice_" + id).html(price);
        canculate();
        updateCart(id, num, cid);
    }

    function reduceNum(id, cid) {
        var num = parseInt($("#" + id).val());
        var sprice = parseFloat($("#sprice_" + id).val());
        if (num - sprice <= 0) {
            return;
        }
        num = num - sprice;
        //alert(parseFloat( $("#singleprice_"+id).html() ));
        $("#" + id).val(num);
        var price = parseFloat($("#singleprice_" + id).html()) * num;
        $("#goodsprice_" + id).html(price);
        canculate();
        updateCart(id, num, cid);
    }

    function canculate() {
        var total = 0;
        $(".goods_total").each(function() {
            total += parseFloat($(this).val());
        });
        console.log(total);
        $("#pricetotal").html(total);
    }


    function updateCart(id, num, cid) {
        var url = "<?php echo $this->_siteUrl?>/activity/duobao/updateCart" + "/id/" + cid + "/num/" + num;
        $.getJSON(url, function(s) {});
    }

    function removeCart(id) {
        if (confirm('您确定要删除此商品吗？')) {
            $.flytip("正在处理数据...");
            var url = "<?php echo $this->_siteUrl?>/activity/duobao/remove" + "/id/" + id;
            $.getJSON(url, function(s) {
                console.log("#item_" + s.cartid);
                $("#item_" + s.cartid).remove();
                if ($(".shopcart-item").length <= 0) {
                    $("#cartempty").show();
                    $("#cartfooter").hide();
                }
                canculate();
                history.go(0);
            });
        }
    }
</script>
</body>

</html>
