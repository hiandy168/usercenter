<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
    <!--top end-->

    <div class="f-index-banner swiper-container-horizontal">

        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a><img src="<?php echo $this->_siteUrl . '/' . $houseinfo['img']?>"/></a>
            </div>
            <div class="swiper-slide">
                <a><img src="<?php echo $this->_siteUrl . '/' . $houseinfo['share_img']?>"/></a>
            </div>
        </div>
        <div class="pagination"></div>

    </div>

    <!--banner end-->


    <div class="fs28 fcf74 f-cpdetail-div1">最高年化收益率 <?php echo $houseinfo['earnings']?></div>

    <div class="bgfff fs28 f-cpdetail-div2">
        <h3>[<?php echo $houseinfo['city']?>] <?php echo $houseinfo['dtitle']?></h3>
        <p class="fcbbb fs26"><?php echo $houseinfo['coupon']?></p>
        <input type="hidden" id="houseid" value="<?php echo $houseinfo['id']?>">
    </div>

    <div class="mgt4 bgfff">

        <div class="fs28 pos-r bb f-cpdetail-div3">
            <span>在线预存<i class="fcf74">￥<b><?php echo $houseinfo['figue']?></b></i></span>
            <span class="fcbbb fr"><?php echo $count?>人参与</span>
        </div>

        <a href="<?php echo $this->createUrl('/house/money/index',array('id'=>$houseinfo['financingid'])) ?>">
            <div class="f-order-info1 pos-r bb">
                <i class="fs28 fc444">预存产品：<?php echo $houseinfo['title']?></i>
                <i class="fr icon-right"></i>
            </div>
        </a>

        <div class="f-index-listdiv-time pos-r bb">
            <i class="icon-time fs28" data-seconds="<?php echo $houseinfo['actime'] ?>">
                <?php if ($houseinfo['end'] == "bg1") {?>
                    <span>--天</span><span>--时</span><span>--分</span><span>--秒</span>
                <?php } else { ?>
                    <?php   echo "该活动已结束";?>
                <?php } ?>

        </div>

        <div class="fs24 fcbbb pos-r bb f-cpdetail-div4">
            <ul>
                <li>腾讯出品</li>
                <li>价格透明</li>
                <li>认证商家</li>
            </ul>
        </div>


    </div>


    <div class="mgt4 bgfff">
        <div class="f-order-info1 pos-r bb">
            <i class="fs28">点击进入楼盘详情</i>
            <i class="fr icon-right"></i>
        </div>

        <div class=" pos-r bb  f-order-info4 f-cpdetail-div5">
            <i><?php echo explode('|',$houseinfo['phone'])[0]?> <?php if(explode('|',$houseinfo['phone'])[1]){?>转 <?php echo explode('|',$houseinfo['phone'])[1]?><?php }?></i>
            <ul>
                <li><a href="tel:<?php echo explode('|',$houseinfo['phone'])[0]?>" class="bgfff fcf74 b1px boru5">打电话</a></li>
            </ul>
        </div>

    </div>


    <!--tab star-->
    <div class="f-cpdetail-div6 mgt4 bgfff pos-r bb">
        <div class="f-cpdetail-div6-nav pos-r bb">
            <li class="selected">活动详情</li>
            <li>用户协议</li>
            <li>报名记录</li>
        </div>

        <div class="f-cpdetail-div6-tab">

            <div class="f-cpdetail-div6-tabcon" style="display: block;">
                <div class="f-cpdetail-tab-info">
                    <!--<p><i>商品名称：</i>APPLE iPhone6 （16G) 国行</p>
                    <p><i>楼座：</i>3-5号楼1-12单元   </p>
                    <p><i>建筑面积：</i>58.82m² </p>
                    <p><i>户型： </i>3室2厅1卫</p>
                    <p><i>开发商： </i>沈阳华凌房地产有限公司</p>
                    <p><i>地址：</i>沈阳市浑南区红椿东路2号（南京南街与全运北路交汇处东行……</p>-->
                    <?php echo $houseinfo['desc']?>
                </div>

               <!-- <div class="fs28 f-user-ddlistdiv3 bgfff pos-r bt"><p>商品展示</p></div>

                <div class="f-cpdetail-tab-info1">
                    <div class=""><img src="<?php /*echo $this->_siteUrl;*/?>/assets/house/images/f-detail-banner.jpg" width="100%"/></div>
                    <div class="">我司商品属于高价格商品，恕不支持拆封退货，所有产品出库前均经过库房专业人员验货质量可100%放心</div>
                </div>-->

            </div>

            <div class="f-cpdetail-div6-tabcon">
                <div class="f-cpdetail-tab-xy">

                    <p>1.请确保参与人年满18周岁，具备完全行为能力；您参加本活动的行为应符合相关法律法规规定， 且不会给任何第三人造成权利损失，否则腾讯有权取消您参加活动的资格，并拒绝退还相关款项。</p>

                    <p>2.因地区限购政策等原因导致参与人无法完成购房的，由参与人自行负责。</p>

                    <p>3.活动期间，因参与人操作不当或参与人所在区域网络故障、支付平台网络不畅、 电信运营商故障等非腾讯房产所能控制的原因导致的参与人无法参与活动、或者参与失败，腾讯房产不予负责。</p>

                </div>

            </div>

            <div class="f-cpdetail-div6-tabcon">
                <div class="f-cpdetail-tab-cyjl">
                    <ul>
                        <li>
                            <i>报名用户</i>
                            <i>报名时间</i>
                            <i>金额</i>
                        </li>
                        <?php foreach($orderinfo as $info){?>
                        <li>
                            <i><?php echo mb_substr($info['realname'],0,1,'utf-8') ?> (<?php echo substr($info['phone'],0,3)?>****<?php
echo substr($info['phone'],7,10)?>)</i>
                            <i><?php echo date('Y-m-d H:i:s',$info['applytime'])?></i>
                            <i>￥<?php echo $info['money'] ?></i>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php if($count>3){ ?>
                   <div class="f-index-list-loading fs28" style="display: none;">
                            加载中<i class="icon-loading"></i>
                   </div>
                    <input  class="more fs28 fc444 boru5 cpdetail-loadmore-btn" value="点击加载更多" readonly="readonly"/>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
    <!--tab end-->
    <div class="fs26 f-user-ddlistdiv3 bgfff pos-r bb mgt4"><p>活动流程</p></div>
    <div class="f-cpdetail-footimg bgfff pos-r bb">
        <img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-detail-foot.jpg" width="100%"/>
    </div>
    <div class="f-cpdetail-btn bt bgfff">
        <?php if ($houseinfo['end'] == "bg1") {?>
            <a class="bg1 fcfff fs28 boru5 fbtn" href="<?php echo $this->createUrl('/house/stored/index', array('id' => $houseinfo['id'])) ?>">立即预存</a>
        <?php } else { ?>
            <a class="bg2 fcfff fs28 boru5 fbtn" href="javascript:void(0)">活动结束</a>
        <?php } ?>

    </div>
</div>


</body>
<script src="<?php echo $this->_siteUrl;?>/assets/house/js/slides.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_siteUrl;?>/assets/house/js/zepto.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_siteUrl;?>/assets/house/js/layout.js" type="text/javascript" charset="utf-8"></script>
</html>
