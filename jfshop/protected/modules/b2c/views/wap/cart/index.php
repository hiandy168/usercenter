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
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/cart.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/fastclick.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/fx.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/js_tracker.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/stack.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/util.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        Zepto(function($){
            $("#showbtn").click(function(){
                if($(this).hasClass("imgbtnact")){
                    $(this).removeClass("imgbtnact");
                    $(this).parent().removeClass("shop-buycar-tipsshowmore")
                }else{
                    $(this).addClass("imgbtnact");
                    $(this).parent().addClass("shop-buycar-tipsshowmore")
                }
            })
        })
    </script>
    <script type="text/javascript">
        var siteUrl = "<?php echo $this->_siteUrl; ?>";
    </script>
</head>

<body>


<div class="div-main">
    <!--<div class="top-title clearfix">
        <a class="lefta fl" href="javascript:history.back();void(0)">购物车</a>
    </div>-->


    <!-- <div class="shop-buycar-tips">
        <ul>
            <li>
                <div class="city-stips  bt">
                    <a href="">
                        <span><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/city-service-icon18.png"/></span>
                        <i class="btnmore"></i>
                        <em>湖北省6.24发布暴雨橙色预警雨橙色雨橙色雨橙色</em>
                    </a>
                </div>
            </li>
            <li>
                <div class="city-stips  bt">
                    <a href="">
                        <span><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/city-service-icon18.png"/></span>
                        <i class="btnmore"></i>
                        <em>湖北省6.24发布暴雨橙色预警雨橙色雨橙色雨橙色</em>
                    </a>
                </div>
            </li>
            <li>
                <div class="city-stips  bt">
                    <a href="">
                        <span><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/city-service-icon18.png"/></span>
                        <i class="btnmore"></i>
                        <em>湖北省6.24发布暴雨橙色预警雨橙色雨橙色雨橙色</em>
                    </a>
                </div>
            </li>
        </ul>


        <div class="imgbtn" id="showbtn">
            <img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img11.png"/>
        </div>
    </div> -->



    <div class="shop-buycar cart_list">
        <ul>
            <?php if($item){foreach ($item as $v){?>
            <li>

                <div class="shop-buycar1 cart_item clearfix" id="1100604422" item_id="<?php echo $v['goods_id'];?>" stock="<?php echo $v['quantity'];?>">
                    <img src="<?php echo $this->_siteUrl.'/'.$v['image'];?>"/>
	    			<span>
	    				<h2><?php echo $v['name'] ;?></h2>
                        <?php if($v['paytype']==3){?>
                            <h3><?php echo $v['price_jifen']*$v['quantity']?>积分</h3>
                        <?php }else{?>
                            <h3>￥<?php echo $v['price']*$v['quantity']?></h3>
                        <?php } ?>
	    				<i>当前可兑</i>
                        <b>x<?php echo $v['quantity'];?></b>
	    				<p><a href="">点击查看商品详情...</a></p>
	    				<em class="garbage">删除</em>
	    			</span>
                </div>
            </li>
            <?php }}else{ ?>
                <div class="cart_item" style='padding:80px 0;text-align:center'>
                    您当前购物车空荡荡的，赶快去添加吧！
                </div>
            <?php } ?>

        </ul>
    </div>




    <footer class="total_result">
        <?php if($item){ ?>

        <div class="fr">

            <a class="c_btn payBtn" id="do_checkout" href="<?php echo $this->_siteUrl;?>/b2c/wap/checkout/index.html">去结算(<span id="cart_quantity"><?php echo $num?></span>)</a>
        </div>
        <div class=" totalPrice">
            <span>商品金额总计</span>
            <p id="cart_price"> <span>￥<?php echo $amount['amount_price'];?>&nbsp;积分<?php echo $amount['amount_price_jifen'];?></span>
            </p>
        </div>
        <?php }else{ ?>
<!--            <div class="fr">-->
<!--                <a class="c_btn payBtn" id="do_checkout" href="--><?php //echo $this->_siteUrl;?><!--/b2c/wap/product/detaillist.html">去兑换</a>-->
<!--            </div>-->
<!--            <div class=" totalPrice">-->
<!---->
<!--            </div>-->
        <?php } ?>
    </footer>

    <section class="m_block" style="display: none;">
        <div class="m_block_pos">
            <div class="m_content">确定要删除该商品吗？</div>
            <div class="m_btns">
                <a class="m_ok_2" style="display: none;">确定</a>
                <a class="m_cancel">取消</a><a class="m_ok">确定</a>
            </div>
        </div>
    </section>

</div>


</body>
</html>
