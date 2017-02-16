<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>

    <!--top end-->

<div class="mgt4 bgfff fs28">
    <div class="f-order-info3 pos-r bb f-form-div1"><i>理财</i>[<?php echo $houseinfo['city']?>]  <?php echo $houseinfo['dtitle']?></div>
    <div class="f-order-info3  pos-r bb">专属优惠：<?php echo $houseinfo['coupon']?></div>
    <div class="f-order-info3  pos-r bb">预存产品：<?php echo $houseinfo['title']?></div>
    <div class="f-order-info3  pos-r bb">购买期限：<?php echo $houseinfo['cycle']==0?"无限": $houseinfo['cycle']."个月"?></div>
    <div class="f-order-info3  pos-r bb">支付金额：<i class="fcf74"><?php echo $houseinfo['figue']?>元</i></div>
</div>
<input type="hidden" name="money" id="money" value="<?php echo $houseinfo['figue']?>"/>


<div class="mgt4 bgfff fs28">
    <input type="hidden" name="houseid" id="houseid" value="<?php echo $houseinfo['id']?>" />
    <?php if($memberinfo['wxstatus']==2){?>
        <div class="pos-r bb f-form-inp">
            <label>用户姓名：</label>
            <i class=""></i>
            <span><input type="text" name="username" id="username" placeholder="请填写用户姓名" value="" /></span>
        </div>

        <div class="pos-r bb f-form-inp">
            <label>联系电话：</label>
            <i class=""></i>
            <span><input type="tel" name="usertel" id="usertel" placeholder="请填写联系电话" value="<?php echo $this->member['phone'] ?>" /></span>
        </div>

        <div class="pos-r bb f-form-inp">
            <label>身份证号：</label>
            <i class=""></i>
            <span><input type="text" name="usercodeid" id="usercodeid" placeholder="请填写身份证号" value=""  /></span>
        </div>
    <?php } elseif($memberinfo['wxstatus']==1){?>
        <div class="pos-r bb f-form-inp">
            <label>用户姓名：</label>
            <i class=""></i>
            <span><input type="text" name="username" id="username" disabled="disabled" placeholder="请填写用户姓名" value="<?php echo $memberinfo['realname'] ?>" /></span>
        </div>

        <div class="pos-r bb f-form-inp">
            <label>联系电话：</label>
            <i class=""></i>
            <span><input type="tel" name="usertel" id="usertel" disabled="disabled" placeholder="请填写联系电话" value="<?php echo $memberinfo['phone'] ?>" /></span>
        </div>

        <div class="pos-r bb f-form-inp">
            <label>身份证号：</label>
            <i class=""></i>
            <span><input type="text" name="usercodeid" id="usercodeid" disabled="disabled" placeholder="请填写身份证号" value="<?php echo $memberinfo['realcard'] ?>"  /></span>
        </div>
    <?php } ?>
</div>

<div class="f-form-xy fs28">
    <label for="xyid">
        <input type="checkbox" name="" id="xyid" value="" checked="checked" />
        <i></i>
        <span>我已经仔细阅读《用户协议》，了解并同时遵守</span>
    </label>
</div>


<div class="f-form-btn">
    <a class="bg1 fcfff fs28 boru5 fbtn" onclick="checkform()" href="javascript:void(0)">下一步</a>
</div>

</div>

<!--mask-->

<div class="mask"></div>
<div class="dial-pop">
    <div class="dial-pop-txt">
        <h3 class="fs32 fcf74">加载中....</h3>
        <i class="dial-closebtn pos-r bt fs28 fc444" onclick="closepop()">确定</i>
    </div>
</div>
</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>

