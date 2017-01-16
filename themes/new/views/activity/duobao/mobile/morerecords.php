<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>所有参与记录</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> - 大楚特产</title>
    <meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" />
    <meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta content="telephone=no" name="format-detection">
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js"></script>

    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/detail.css">
</head>
<body>

<div class="m-detail-record">
    <div class="w-bar">所有参与记录<span class="w-bar-hint"><!--( 自2015-10-20 11:50:47开始 )--></span></div>
    <div class="m-detail-record-wrap">
        <div class="w-loading" afmoldstyle="block" style="display: none;">
            <img style="display:inline;vertical-align:middle" width="20" height="20" src="http://mimg.127.net/p/yymobile/lib/img/common/loading.gif"> 正在努力加载中……
        </div>
        <div id="pro-view-4">
            <ul class="m-detail-record-list" data-pro="entry">

                <?php
                foreach($ret as $adVal){
                ?>
                <li id="pro-view-5">
                    <div class="f-clear">
                        <div class="avatar">
                                <img width="35" height="35"  src="<?php echo JkCms::show_img($adVal['headimgurl']) ?>">
                        </div>
                        <div class="text">
                            <p class="f-breakword">
                                <a href=""><?php echo $adVal['username']?></a>
                                <span class="address">(<?php echo $adVal['city']?> IP：<?php echo $adVal['regip']?>)</span>
                            </p>
                            <p>
                                <span class="num">参与了<span class="txt-red"><?php echo $adVal['total']?></span>人次</span> <?php echo date('Y-m-d H:i:s',$adVal['ordertime'])?>
                        </div>
                    </div>
                </li>
                <?php
                }
                ?>

            </ul>
            <div style="height:30px;text-align: center;">
            </div>
            <div style="display:none">
                <span id='stock'>  </span>
                <input type="hidden" class="form-control input-sm pricetotal goodsnum" style="width:50px;text-align:center" value="1" id="total"/>
            </div>


        </div>
    </div>

</div>

<div class="g-footer">
    <div class="g-wrap">
        <ul class="m-state f-clear">
            <li><i class="ico ico-state ico-state-1"></i>公平公正公开</li>
            <li><i class="ico ico-state ico-state-2"></i>正品保证</li>
            <li class="last"><i class="ico ico-state ico-state-3"></i>权益保障</li>
        </ul>
        <p class="m-link">
            <a href="./index.php?i=29&c=entry&do=clause&m=duobao_gz">点击查看游戏说明</a>
        </p>
        <p>活动最终解释权归大楚网所有</p>
    </div>
</div>

</body>
</html>