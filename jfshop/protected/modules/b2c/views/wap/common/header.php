<script>
var siteUrl = "<?php echo $this->_siteUrl; ?>";
</script>
<div class="shop-top clearfix" id="js-com-header-area">

    <div class="logo fl"><a href=""><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img1.png"/></a></div>

    <div class="fr shop-rnav">
        <ul>
            <li>
                <div class="rnav1"><a><img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img6.png"/><del></del></a></div>
            </li>
<!--            <li><div class="rnav2"><a href=""><img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img5.png"/></a></div></li>-->
            <li>
                <div class="rnav3">
<!--                    <a href="--><?php //echo $this->_siteUrl;?><!--/b2c/wap/cart/index.html" class="com-header-cart "><b id="header-cart-num">--><?php //echo $this->cart['num']?$this->cart['num']:0;?><!--</b><del></del></a>-->

                    <a href="<?php echo $this->_siteUrl;?>/b2c/wap/cart/index.html" class="com-header-cart ">
                        <img src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/images/shop-img7.png"/>
                        <i id="header-cart-num"><?php echo $this->cart['num']?$this->cart['num']:0;?></i>
                    </a>
<!--                    <a href="--><?php //echo $this->_siteUrl;?><!--/b2c/wap/cart/index.html" class="com-header-cart "><b id="header-cart-num">--><?php //echo $this->cart['num']?$this->cart['num']:0;?><!--</b><del></del></a>-->
                </div>
            </li>
        </ul>

    </div>

    <div class="shop-top-form">
        <form  action="searchpro" method="get">
            <strong>
                <input type="text" name="keyword" id="keyword" value=""  placeholder="搜索">
                <input type="submit" value="">
                </strong>
        </form>
    </div>

</div>



