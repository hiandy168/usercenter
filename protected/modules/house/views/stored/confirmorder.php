<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
    <!--top end-->

   <!-- <div class="pos-r bb bgfff f-form-backnav">
        <a href="javascript:history.go(-1)"><i class="icon-left"></i></a>
        <h3 class="fs36">确认订单</h3>
    </div>-->
<?php if($type==1){?>
    <?php if($status==1){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">恭喜，购买成功啦！</i>
                进入个人中心去看看吧。
            </p>
        </div>
        <div class="mgt4 fs28 f-form-confirmdiv">
            <div class="f-order-info3  pos-r bb">订单号：<?php echo $orderdetail['ordernum']?></div>
            <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[<?php echo $orderdetail['city']==1?"武汉":"郑州"?>] <?php echo $orderdetail['title']?></div>
            <div class="f-order-info3  pos-r bb">专属优惠：<?php echo $orderdetail['coupon']?></div>
            <div class="f-order-info3  pos-r bb f-form-confirmdiv1"><span>用户信息：</span><i><?php echo $this->member['realname'] ?><b></b> <?php echo $this->member['phone']?><br />
                    <?php echo $this->member['realcard']?></i></div>
            <div class="f-order-info3  pos-r bb">预定金额：<i class="fcf74"><?php echo $orderdetail['money']?>元</i></div>
            <div class="f-form-confirmdivtxt fs24 fcbbb">支付成功，可享受腾讯房产独家优</div>

        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==2){  ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">购买失败！</i>
                进入个人中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==3){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">订单处理中！</i>
                进入个人中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==4){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">拉去订单失败！</i>
                进入个人中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php } ?>

<?php }elseif($type==2){ ?>
    <?php if($status==1){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">恭喜，退款成功啦！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="mgt4 fs28 f-form-confirmdiv">
            <div class="f-order-info3  pos-r bb">订单号：<?php echo $orderdetail['ordernum']?></div>
            <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[<?php echo $orderdetail['city']==1?"武汉":"郑州"?>] <?php echo $orderdetail['title']?></div>
            <div class="f-order-info3  pos-r bb">专属优惠：<?php echo $orderdetail['coupon']?></div>
            <div class="f-order-info3  pos-r bb f-form-confirmdiv1"><span>用户信息：</span><i> <?php echo $this->member['realname'] ?><b></b> <?php echo $this->member['phone']?><br />
                    <?php echo $this->member['realcard']?></i></div>
            <div class="f-order-info3  pos-r bb">退款金额：<i class="fcf74"><?php echo $orderdetail['money']?>元</i></div>
            <div class="f-form-confirmdivtxt fs24 fcbbb">退款成功</div>

        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
    <?php }elseif($status==2){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">退款失败！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
    <?php }elseif($status==3){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">处理中！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
    <?php }elseif($status==4){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">拉取订单失败！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
    <?php } ?>

<?php }elseif($type==3){ ?>
    <?php if($status==1){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">恭喜，使用成功啦！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="mgt4 fs28 f-form-confirmdiv">
            <div class="f-order-info3  pos-r bb">订单号：<?php echo $orderdetail['ordernum']?></div>
            <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[<?php echo $orderdetail['city']==1?"武汉":"郑州"?>] <?php echo $orderdetail['title']?></div>
            <div class="f-order-info3  pos-r bb">专属优惠：<?php echo $orderdetail['coupon']?></div>
            <div class="f-order-info3  pos-r bb f-form-confirmdiv1"><span>用户信息：</span><i><?php echo $this->member['realname'] ?><b></b> <?php echo $this->member['phone']?><br />
                    <?php echo $this->member['realcard']?></i></div>
            <div class="f-order-info3  pos-r bb">使用金额：<i class="fcf74"><?php echo $orderdetail['money']?>元</i></div>
            <div class="f-form-confirmdivtxt fs24 fcbbb">使用成功</div>

        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==2){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">使用失败！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==3){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon2.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">处理中！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php }elseif($status==4){ ?>
        <div class="pos-r bb"></div>
        <div class="f-refund1-txt">
            <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-refund-icon3.png"/></span>
            <p class="fs26 fc777">
                <i class="fs36 fc444">拉取订单失败！</i>
                进入中心去看看吧。
            </p>
        </div>
        <div class="f-form-confirmdivbg"></div>
        <div class="f-form-btn">
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入个人中心</a>
        </div>
        <div class="f-form-btn">
            <a style=" border: 1px solid #f7463c;box-sizing: border-box;color: #f7463c;" class=" fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$orderdetail['id'])) ?>">查看订单详细</a>
        </div>
    <?php } ?>

<?php } ?>
</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>
