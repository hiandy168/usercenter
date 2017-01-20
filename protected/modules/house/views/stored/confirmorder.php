<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
    <!--top end-->

    <div class="pos-r bb bgfff f-form-backnav">
        <a href="javascript:history.go(-1)"><i class="icon-left"></i></a>
        <h3 class="fs36">确认订单</h3>
    </div>
    <div class="mgt4 fs28 f-form-confirmdiv">
        <div class="f-order-info3  pos-r bb">订单号：00001</div>
        <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[北京] 华业东方玫瑰180套户型预售火热启动预定,即可享受理财抄底优惠</div>
        <div class="f-order-info3  pos-r bb">专属优惠：预存1万优惠20万</div>
        <div class="f-order-info3  pos-r bb f-form-confirmdiv1"><span>用户信息：</span><i>符云云<b></b> 13476587657<br />
                430723198702117548</i></div>
        <div class="f-order-info3  pos-r bb">预定金额：<i class="fcf74">10000元</i></div>
        <div class="f-form-confirmdivtxt fs24 fcbbb">请尽快支付，即可享受腾讯房产独家优</div>

    </div>
    <div class="f-form-confirmdivbg"></div>
    <div class="f-form-btn">
        <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/member/index',array('id'=>1)) ?>">进入我的个人中心</a>
    </div>
</div>
</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>
