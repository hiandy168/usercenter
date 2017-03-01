<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
<?php if($orderlist){?>
    <div class="div-main">

    <div class="f-user-sy bgfff">
        <div class="f-user-sy1"><span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-index-listtest.jpg"/></span>
            <i class="fs36"><?php echo $this->member['phone'] ?></i>
        </div>
        <div class="f-user-sy2">
            <i class="fs24 fcbbb">总投入(元)</i>
            <p class="fcf74"><?php echo isset($invest)?$invest:'0' ?>.00</p>
        </div>
    </div>

    <div class="pos-r  bt bgfff  clearfix f-user-sy3">
        <ul>
            <li class="br pos-r">
                <i class="fs24 fcbbb">收益率</i>
                <p class="fs36 fcf74"><?php echo $earning ?>%</p>
            </li>
            <li>
                <i class="fs24 fcbbb">当天收益（元）</i>
                <p class="fs36 fcf74"><?php echo $revenue ?></p>
            </li>
        </ul>

    </div>

    <div class="pos-r bb bt bgfff f-user-sy4">
        <p class="fcbbb fs24">申请提现，需进入订单详情完成</p>
    </div>


    <div class="f-user-ddlist">
    <ul>
    <?php foreach($orderlist as $order){?>
        <li>
            <div class="f-user-ddlistdiv">
                <div class="fs28 f-user-ddlistdiv1">
                    <i>订单号：<?php echo $order['ordernum']?></i>
                    <i class="fr fcf74">
                        <?php
                        if($order['paystatus']==1){
                            echo "未支付";
                        }elseif($order['paystatus']==2){
                            echo "已支付";
                        }elseif($order['paystatus']==3){
                            echo "已使用";
                        }elseif($order['paystatus']==4){
                            echo "已退款";
                        }
                        ?>
                    </i>
                </div>
                <div class="f-index-listdiv clearfix pos-r bb bt">
                    <a href="<?php echo $this->createUrl('/house/member/orderd',array('id'=>$order['id'])) ?>">
                        <div class="f-index-listdiv-img"><img src="<?php echo $this->_siteUrl . '/' . $order['img'] ?>"></div>
                        <div class="f-index-listdiv-txt">
                            <h3>[<?php echo $order['city']?>] <?php echo $order['title']?></h3>
                            <p>在线预存：<i><?php echo $order['money']?>元</i></p>
                        </div>
                    </a>
                </div>

                <?php if($order['paystatus']==1){?>
                    <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>请于<?php echo date('Y-m-d H:i:s',$order['createtime']) ?> 前完成存款</p></div>
                <?php }elseif($order['paystatus']==2){ ?>
                    <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>活动于<?php echo date('Y-m-d H:i:s',$order['createtime']) ?> 过期，请于案场使用</p></div>
                <?php }elseif($order['paystatus']==3){ ?>
                    <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>您于<?php echo date('Y-m-d H:i:s',$order['usetime']) ?>取出存款</p></div>
                <?php }elseif($order['paystatus']==4){ ?>
                    <div class="fs26 f-user-ddlistdiv3 pos-r bb"><p>活动于<?php echo date('Y-m-d H:i:s',$order['createtime']) ?> 已结束</p></div>
                <?php } ?>
            </div>
        </li>
    <?php }}else{?>
    <div class="f-user-nolist">
        <span><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-user-nolist.png"/></span>

        <p class="fs24"><b class="fs36">暂无订单</b>赶紧去商城看看吧</p>

        <a href="<?php echo $this->_siteUrl;?>/house/site" class="bg1 fcfff fs24">活动首页</a>
    </div>
<?php } ?>
        </ul>
    </div>
</div>
</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>