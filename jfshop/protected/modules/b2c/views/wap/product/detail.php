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
<script>
    /*是否下线*/
    var isDown = false;
    var branddir="361sport";
    function GoodInfo(){
        this.goods_id = '<?php echo $row['goods_id'];?>';
//        this.product_id= '<?php //echo $row['default_product_id'];?>//';
    }

    var goodInfo = new GoodInfo();


</script>
<div class="div-main" style="height: 100%;">
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/js/good/index.js"></script>

    <div class="shop-scroll">

       <!-- <div class="top-title clearfix">
            <a class="lefta fl" href="javascript:history.back();void(0)">商品详情</a>
        </div>-->


        <div class="shop-buybanner" style=" overflow: hidden; "><img src="<?php echo    $this->_siteUrl.'/'.$image['m_image'][0]?>" width="100%" /></div>

        <div class="shop-buyinfo bb">
            <div class="jf-bm2">
                <h2><?php  echo $row['name'];?></h2>
                    <?php if($row['paytype']==3){?>
                        <p>所需金额：<?php echo $row['price_jifen']?>积分</p>
                    <?php }else{?>
                        <p>所需金额：￥ <?php echo $row['price']?></p>
                    <?php } ?>
                <em>温馨提示：所有礼品兑换需到腾讯大楚网办公地点领取</em>
                <?php if($row['store'] <= 0){ echo "<i class=\"i3\">已兑完</i>"; }else {echo "<i class=\"i1\">当前可兑</i>";}?>
            </div>
        </div>



        <div class="bt bb shop-buytxt">

            <h2>商品详情</h2>
            <?php  if(!empty($row['intro'])){ echo $row['intro'];}else{?>

            <p style="margin-top: 10px;">
                物品为<?php if($row['paytype']==3){?><?php echo $row['price_jifen']?>积分<?php }else{?>￥ <?php echo $row['price']?> <?php } ?>，可以用于积分兑换.
            </p>

            <p style="margin-top: 10px;">
                1.我们会将奖品的兑换码直接发送到已兑换用户的手机， 用户通过获得的兑换码直接在商城输入即可获得相应的点劵.
            </p>
            <?php
            //                                  foreach($image['m_image'] as $img ){
            //                                  foreach($image['l_image'] as $img ){
            foreach($image['s_image'] as $img ){
            ?>
                <img src="<?php echo    $this->_siteUrl.'/'.$img?>"/>
            <?php }}?>

        </div>


    </div>



    <div class="shop-foot-buy">

        <div class="shop-foot-buy1 clearfix">

            <ul>
                <li class="fl">
                    <div class="jf">
                        <?php if($row['paytype']==3){?>
                            <p>所需金额：<?php echo $row['price_jifen']?>积分</p>
                        <?php }else{?>
                            <p>所需金额：￥ <?php echo $row['price']?></p>
                        <?php } ?>
                        <p>剩余金额：<?php  echo  isset(Mod::app()->session['member']['points'])? Mod::app()->session['member']['points']:0;?>积分</p>
                    </div>
                </li>


                <li class="fr">
                    <div class="car dh">
                        <?php if($row['store'] <= 0){ ?>
                            <a href="">
                                已兑完
                            </a>
                        <?php }else { ?>
                            <a href="<?php echo $this->createUrl('wap/product/detail_tw/',array('id'=>$row['goods_id']))?>">
                                立即兑换
                            </a>
                        <?php } ?>
                    </div>
                </li>


                <li class="fr">
                    <div class="car">
                        <a class="pxui-light-button addtocart" >
                            加入购物车
                        </a>
                    </div>
                </li>


            </ul>

        </div>

    </div>





</div>



</body>
</html>
