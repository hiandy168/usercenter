<?php echo $this->renderpartial('/layouts/main',$config); ?>
<?php echo $this->renderpartial('/layouts/head'); ?>
    <div class="f-index-banner swiper-container-horizontal">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-banner-test.jpg"/></a>
            </div>
            <div class="swiper-slide">
                <a><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-banner-test.jpg"/></a>
            </div>
            <div class="swiper-slide">
                <a><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-banner-test.jpg"/></a>
            </div>
        </div>
        <div class="pagination"></div>
    </div>

    <!--banner end-->

    <div class="f-index-list" id="indexlist">
        <ul>
            <?php foreach($houseinfo as $house) {
                if ($house['type'] ==2) { ?>
                    <li>
                        <div class="f-index-listdiv clearfix">
                            <a href="<?php echo $this->createUrl('/house/site/detail', array('id' => $house['id'])) ?>">
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
    <div class="f-foot-tel bg1">
        <a href="" class="fs28 fcfff">
            <i class="icon-tel"></i>400-819-1111转612345
        </a>
    </div>
    <div class="f-foot-logo">
        <a href=""><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-foot-logo.png" alt="腾讯房产"/></a>
    </div>
</div>
<script src="<?php echo $this->_siteUrl;?>/assets/house/js/slides.js" type="text/javascript" charset="utf-8"></script>



</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>


