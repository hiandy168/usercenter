<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
    <!--top end-->

    <div class="pos-r bb bgfff f-form-backnav">
        <a href="javascript:history.go(-1)"><i class="icon-left"></i></a>
        <h3 class="fs36">确认订单</h3>
    </div>
    <div class="mgt4 fs28 f-form-confirmdiv">
        <div class="f-order-info3  pos-r bb">订单号：<?php echo $orderdetail['ordernum']?></div>
        <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[<?php echo $orderdetail['city']==1?"武汉":"郑州"?>] <?php echo $orderdetail['title']?></div>
        <div class="f-order-info3  pos-r bb">专属优惠：<?php echo $orderdetail['coupon']?></div>
        <div class="f-order-info3  pos-r bb f-form-confirmdiv1"><span>用户信息：</span><i><?php echo $this->member['username']?><b></b> <?php echo $this->member['phone']?><br />
                <?php echo $this->member['realcard']?></i></div>
        <div class="f-order-info3  pos-r bb">预定金额：<i class="fcf74"><?php echo $orderdetail['money']?>元</i></div>
        <div class="f-form-confirmdivtxt fs24 fcbbb">支付成功，即可享受腾讯房产独家优</div>

    </div>
    <div class="f-form-confirmdivbg"></div>
    <div class="f-form-btn">
        <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>$orderdetail['mid'])) ?>">进入我的个人中心</a>
    </div>
</div>
</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>
