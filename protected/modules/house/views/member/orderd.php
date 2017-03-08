<?php echo $this->renderpartial('/layouts/main',$config); ?>
<div class="div-main">
    <div class="f-user-ddlistdiv bgfff mgt4">
        <div class="fs28 f-user-ddlistdiv1">
            <i>订单号：<?php echo $orderdetail['ordernum']?></i>
            <input type="hidden" id="id" name="id" value="<?php echo $orderdetail['id']?>">
            <i class="fr fcf74">
                <?php
                if($orderdetail['paystatus']==1){
                    echo "未支付";
                }elseif($orderdetail['paystatus']==2){
                    echo "已预存";
                }elseif($orderdetail['paystatus']==3){
                    echo "已使用";
                }elseif($orderdetail['paystatus']==4){
                    echo "已退款";
                }
                ?>
            </i>
        </div>
        <div class="f-index-listdiv clearfix pos-r bb bt">
            <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $orderdetail['houseid'],'city' => $orderdetail['citynum'])) ?>">
                <div class="f-index-listdiv-img"><img src="<?php echo $this->_siteUrl . '/' . $orderdetail['img'] ?>"></div>
                <div class="f-index-listdiv-txt">
                    <h3>[<?php echo $orderdetail['city']?>] <?php echo $orderdetail['title']?></h3>
                    <p>在线预存：<i><?php echo $orderdetail['money']?></i></p>
                </div>
            </a>
        </div>
        <?php if($orderdetail['paystatus']==1){?>
            <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>请于<?php echo date('Y-m-d H:i:s',$orderdetail['createtime'])?> 前完成存款</p></div>
        <?php }elseif($orderdetail['paystatus']==2){ ?>
            <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>活动于<?php echo date('Y-m-d H:i:s',$orderdetail['createtime'])?>  过期，请于案场使用</p></div>
        <?php }elseif($orderdetail['paystatus']==3){ ?>
            <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>您于<?php echo date('Y-m-d H:i:s',$orderdetail['usetime'])?>取出存款</p></div>
        <?php }elseif($orderdetail['paystatus']==4){ ?>
            <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>活动于<?php echo date('Y-m-d H:i:s',$orderdetail['createtime'])?> 已结束</p></div>
        <?php } ?>
    </div>
    <div class="bgfff mgt4 f-order-info">
        <a href="<?php echo $this->createUrl('/house/money/index',array('id'=>$orderdetail['financingid'])) ?>">
            <div class="f-order-info1 pos-r">
                <i class="fs28 fc444">微众银行预存款</i>
                <i class="fr icon-right"></i>
            </div>
        </a>
        <div class="f-order-info2 pos-r bb bt">
            <ul>
                <li class="br pos-r">
                    <p class="fs36 fcf74"><?php echo $orderdetail['earnings']?>%</p>
                    <i class="fs24 fcbbb">最高预存收益率</i>
                </li>
                <li>
                    <p class="fs36 fcf74"><?php echo $orderdetail['cycle']==0?"无限":$orderdetail['cycle']?><b class="fs32 pos-r"><?php echo $orderdetail['cycle']==0?"":"个月"?></b></p>
                    <i class="fs24 fcbbb">预存周期</i>
                </li>
            </ul>
        </div>

        <div class="f-order-info3 fs26">购房优惠：<?php echo $orderdetail['coupon']?></div>

        <div class=" pos-r bb bt f-order-info4">
            <i>购房优惠</i>
            <ul>
                <?php if($orderdetail['paystatus']==1){?>
                    <?php if($orderdetail['actime']<time() && $orderdetail['createtime']>time()){?>
                        <li><a onclick="checkpay()" href="javascript:void(0)" class="bg1 fcfff">立即预存</a></li>
                    <?php }else{?>
                        <li><a  href="javascript:void(0)" class="bg2 fcfff">立即预存</a></li>
                    <?php } ?>
                <?php }elseif($orderdetail['paystatus']==2){ ?>

                    <?php if($orderdetail['validity']<time() && $orderdetail['updatetime']>time() ){?>
                        <li><a onclick="confirmorder()" href="javascript:void(0)" class="bgfff fcf74 b1px boru5">确认使用</a></li>
                    <?php }else{ ?>
                        <li><a href="javascript:void(0)" class="bg2 fcfff">确认使用</a></li>
                    <?php } ?>
                    <?php if($orderdetail['createtime']<time()){?>
                        <li><a onclick="withdraw()" href="javascript:void(0)" class="bg1 fcfff">申请提现</a></li>
                    <?php }else{ ?>
                        <li><a href="javascript:void(0)" class="bg2 fcfff">申请提现</a></li>
                    <?php } ?>
                <?php }elseif($orderdetail['paystatus']==3){ ?>
                    <li><a href="javascript:void(0)" class="bg2 fcfff">已使用</a></li>
                <?php }elseif($orderdetail['paystatus']==4){ ?>
                    <li><a href="javascript:void(0)" class="bg2 fcfff">已退款</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="fs28 f-user-ddlistdiv3 bgfff pos-r bb mgt4"><p>购买详情</p></div>
    <div class="bgfff pos-r bb f-order-buyinfo fs26 fc777">
        <p>用户姓名：<?php echo $this->member['realname']?></p>
        <p>联系电话：<?php echo $this->member['phone']?></p>
        <p>下单时间：<?php echo date('Y-m-d H:i:s',$orderdetail['applytime'])?></p>
        <p>活动有效期：<?php echo date('Y-m-d H:i:s',$orderdetail['actime'])?> 至 <?php echo date('Y-m-d H:i:s',$orderdetail['createtime'])?></p>
        <?php if($orderdetail['paystatus']==1){?>
        <?php }else{ ?>
            <p>预存状态：
                <i class="fcf74">
                    <?php
                    if($orderdetail['paystatus']==2){
                        echo "已预存";
                    }elseif($orderdetail['paystatus']==3){
                        echo "已使用";
                    }elseif($orderdetail['paystatus']==4){
                        echo "已退款";
                    }
                    ?>
                </i>
            </p>
            <p>兑 换 码：<?php echo $orderdetail['code']?></p>
        <?php } ?>

        <!--<p>兑换二维码：</p>

        <div class="f-order-qcode">
            <span><img src="<?php /*echo $this->_siteUrl;*/?>/assets/house/images/f-order-qcode.png"/></span>
        </div>-->

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
