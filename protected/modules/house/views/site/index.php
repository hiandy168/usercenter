<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
<div class="f-index-banner swiper-container-horizontal">
    <div class="swiper-wrapper">
        <?php foreach($imglist as $house) {?>
            <div class="swiper-slide">
                <a href="<?php echo $house['url'] ?>"><img src="<?php echo $this->_siteUrl . '/' . $house['img_url'] ?>"/></a>
            </div>
        <?php } ?>
    </div>
    <div class="pagination"></div>
</div>

<!--banner end-->
<?php if($houseinfo){ ?>
<div class="f-index-list" id="indexlist">
    <ul>
        <?php if($recommondlist) { ?>
            <?php foreach ($recommondlist as $house) {
                if ($house['type'] == 2) { ?>
                    <li>
                        <div class="f-index-listdiv clearfix">
                            <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $house['id'])) ?>">
                                <div class="f-index-listdiv-img"><img
                                        src="<?php echo $this->_siteUrl . '/' . $house['img'] ?>"/></div>
                                <div class="f-index-listdiv-txt">
                                    <h3>[<?php echo $house['city'] ?>
                                        ]<?php echo isset($house['title']) ? $house['title'] : "" ?></h3>

                                    <p>在线预存<i><b>￥</b><?php echo isset($house['figue']) ? $house['figue'] : "" ?></i>
                                    </p>
                                    <em><?php echo isset($house['coupon']) ? $house['coupon'] : "" ?></em>
                                </div>
                            </a>
                        </div>
                        <div class="f-index-listdiv-time pos-r bb bt">
                            <i class="icon-time"
                               data-seconds="<?php echo $house['actime2'] ?>"> <?php if ($house['end'] == "bg1") { ?>
                                    <span>--天</span><span>--时</span><span>--分</span><span>--秒</span>
                                <?php } else { ?>
                                    <?php echo "该活动已结束"; ?>
                                <?php } ?></i>
                            <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $house['id'])) ?>"
                               class="<?php echo isset($house['end']) ? $house['end'] : "" ?> fcfff"><?php if ($house['end'] == "bg1") {
                                    echo "我要预存";
                                } else {
                                    echo "活动结束";
                                } ?></a>
                        </div>
                    </li>
                <?php
                }
            }
        }
        ?>

        <?php foreach($houseinfo as $house) {
            if ($house['type'] ==2) { ?>
                <li>
                    <div class="f-index-listdiv clearfix">
                        <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $house['id'],'city' => $cityurl)) ?>">
                            <div class="f-index-listdiv-img"><img
                                    src="<?php echo $this->_siteUrl . '/' . $house['img'] ?>"/></div>
                            <div class="f-index-listdiv-txt">
                                <h3>[<?php echo $house['city'] ?>]<?php echo isset($house['title']) ? $house['title'] : "" ?></h3>

                                <p>在线预存<i><b>￥</b><?php echo isset($house['figue']) ? $house['figue'] : "" ?></i>
                                </p>
                                <em><?php echo isset($house['coupon']) ? $house['coupon'] : "" ?></em>
                            </div>
                        </a>
                    </div>
                    <div class="f-index-listdiv-time pos-r bb bt">
                        <i class="icon-time" data-seconds="<?php echo $house['actime2'] ?>"> <?php if ($house['end'] == "bg1") {?>
                                <span>--天</span><span>--时</span><span>--分</span><span>--秒</span>
                            <?php } else { ?>
                                <?php   echo "该活动已结束";?>
                            <?php } ?></i>
                        <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $house['id'])) ?>"
                           class="<?php echo isset($house['end']) ? $house['end'] : "" ?> fcfff"><?php if ($house['end'] == "bg1") {
                                echo "我要预存";
                            } else {
                                echo "活动结束";
                            } ?></a>
                    </div>
                </li>
            <?php
        }
        }
        ?>
    </ul>
    <div class="f-index-list-loading fs28" style="display: none;">
        加载中<i class="icon-loading"></i>
    </div>
</div>
<?php
}else{
?>

    <div style="text-align: center;padding: 30px 0px;">
        <span style="display: inline-block;width: 6rem;"><img width="100%" src="<?php echo $this->_siteUrl;?>/assets/house/images/f-user-nolist.png"/></span>

        <p class="fs24" style="margin-top: 20px"><b class="fs36">暂无数据</b><br/>切换到其它城市看看吧</p>

    </div>

<?php } ?>
<div class="f-foot-tel bg1">
    <a href="tel:<?php echo $phone[0] ?>" class="fs28 fcfff">
        <i class="icon-tel"></i><?php echo $phone[0] ?><?php if($phone[1]){ ?>转<?php echo $phone[1] ?><?php } ?>
    </a>
</div>
<div class="f-foot-logo">
    <a href=""><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-foot-logo.png" alt="腾讯房产"/></a>
</div>
</div>
<script src="<?php echo $this->_siteUrl;?>/assets/house/js/slides.js" type="text/javascript" charset="utf-8"></script>

<!--微信分享-->
<?php  echo $this->renderpartial('/layouts/wxshare',array('signPackage'=>$signPackage,'info'=>$info)); ?>

<!--微信分享-->

</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>


