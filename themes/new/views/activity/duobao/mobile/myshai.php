<html lang="zh-CN" style="height: 100%;"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>晒单记录 - 大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta content="telephone=no" name="format-detection">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/user.css">
</head>
<body>
<div class="m-user" style="padding-top:0px">
    <div class="m-user-duobaoRecord" id="duobaoRcd_dvWrapper" style="padding-top:0px">
        <div class="m-user-summary m-user-summary-simple">
            <img class="bg" src="" width="100%">
            <div class="info">
                <div class="m-user-avatar">    <img width="50" height="50"  src="<?php echo JkCms::show_img($this->member['headimgurl']) ?>">
                </div>
                <div class="txt">
                    <div class="name"><?php echo $this->member['name'] ?></div>
                </div>
            </div>
        </div>
        <div id="pro-view-2"><div data-pro="loading"></div>
            <ul class="w-goodsList w-goodsList-l m-user-goodsList" data-pro="list">
                <?php
                foreach($goods as $type){
                    ?>
                    <li class="w-goodsList-item" id="pro-view-4">
                        <div class="w-goods w-goods-l w-goods-ing m-user-goods">
                            <div class="w-goods-pic">
                                <a href="{">
                                    <img alt="{$aaa['title']}" src="<?php echo JkCms::show_img($this->member['headimgurl']) ?>"  class="" style="width:80px,height:80px">
                                </a>
                            </div>
                            <div class="w-goods-info">
                                <p class="w-goods-title f-txtabb"><?php echo $type['title']?></p>
                                <p class="w-goods-price">总需：<?php echo $type['productprice'] ?> 人次</p>
                                <p class="f-breakword">幸运码:<?php echo $type['ticket'] ?><span class="txt-green" id="province"></span></p>
                                <p id="createtime">揭晓时间：<?php echo date('Y-m-d H:i:s', $type['ticket_time']) ?></p>
                            </div>
                            <div class="w-goods-shortFunc">
                            </div>
                        </div>
                    </li>
                <?php
                }
                ?>
            </ul><div data-pro="more"><div class="w-more" id="pro-view-6"><div data-pro="link" style="display: none;"><a href="javascript:void(0);">上拉加载更多</a></div><div data-pro="loading" style="display: none;"><b class="ico ico-loading"></b> 努力加载中</div><div data-pro="disable">已经没有更多</div></div></div></div></div>
</div>



<button class="w-button w-button-round w-button-backToTop" style="display:none" id="pro-view-0">返回顶部</button></body></html>