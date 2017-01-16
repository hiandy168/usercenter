<html lang="zh-CN" style="height: 100%;"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>计算结果 - 大楚特产</title>
    <meta content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" name="description">
    <meta content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" name="keywords">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">

    <meta content="telephone=no" name="format-detection">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/detail.css">
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js"></script>

    <style type="text/css">

        .count-rule{
            padding: 10px 10px;
            background: #db3652;
            color: #ffffff;
            line-height: 22px;
            font-size: 12px;
            margin: 15px 10px;
            border-radius: 4px;
        }

        .numberA{
            width: 100%;
            background: #ffffff;
            padding: 10px 0;
        }
        .numberA h4{
            text-indent: 10px;
            font-size: 12px;
            font-weight: 900;
            line-height: 24px;
            color: #525252;
            letter-spacing: 1px;
        }
        .numberA p{
            font-size: 12px;
            padding: 0 10px;
            line-height: 20px;
            color: #db3652;
            letter-spacing: 0;
            position: relative;
        }
        .numberA p span{
            color: #989898;
            letter-spacing: 1px;
        }
        .numberA p a{
            color: #0079fe;
            position: absolute;
            top: 0;
            right: 0;
        }
        .numberB{
            width: 100%;
            margin-top: 16px;
            background: #ffffff;
            padding: 10px 10px;
        }
        .numberB h4,.result h4{
            font-size: 12px;
            font-weight: 900;
            line-height: 24px;
            color: #525252;
            letter-spacing: 1px;
        }
        .numberB p{
            font-size: 12px;
            line-height: 20px;
            color: #FF9103;
            letter-spacing: 0;
        }
        .numberB p span{
            color: #989898;
            letter-spacing: 1px;
        }

        .result{
            width: 100%;
            margin: 16px 0;
            background: #ffffff;
            padding: 10px 10px;
        }
        .result p{
            text-align: center;
            color: #989898;
            font-size: 16px;
        }
        .result p span{
            color: #FF9103;
        }
    </style>
<body>
<div class="g-body">
    <div class="m-calc">
        <div class="m-simpleHeader" id="dvHeader">
            <!-- <a href="javascript:void(0);" data-pro="back" data-back="true" class="m-simpleHeader-back"><i class="ico-back"></i></a> -->
            <h1>计算结果</h1>
        </div>
        <div class="count-rule">
            <h4>计算公式</h4>
            <p>[ (数值A+数值B) ÷ 商品参与总人次 ] 取余数+<?php echo $goods['id']*100000;?></p>
        </div>
        <a class="m-calc-viewIntroBtn" href="javascript:void(0)">计算方式</a>
        <div class="g-wrap">
            <div class="m-calc-rule">
                <h2>购买人次：<?php echo $goods['productprice'];?>人次</h2>
                <p>中奖号码： <?php echo $result_ticket;?></p>
                <!--  <p style="word-break:break-word;">所有购买号码：</p>
                 <p style="word-break:break-word;">{loop $award_list $award}
                     {$award['ticket']} &nbsp;&nbsp;
                      {/loop}
                 </p> -->
            </div>
            <div class="numberA">
                <h4>数值A</h4>
                <p><span>=截止该商品最后5位参与者夺宝时间数据之和</span></p>
                <p><span>=</span><?php echo $totalTime ?><a>展开所有记录</a></p>
                <div class="m-calc-list" style="display: none;height: auto;">
                    <table class="m-calc-resultList" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="time">夺宝时间</th>
                            <th class="user">用户帐号</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($ogoods as $type){
                        ?>
                        <tr class="calcRow">
                            <td class="time"><?php echo date('Y-m-d H:i:s',$type['ordertime'])?> <i class="ico ico-arrow-transfer"></i> <b class="txt-red"><?php echo date("His",$type['ordertime'])?></b></td>
                            <td class="user"><div class="f-breakword"><a class="goUserPage"  ><?php echo $type['username']?></a></div></td>
                        </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="numberB">
                <h4>数值B</h4>
                <P><span>=最近一期中国体育彩票“排列5”的揭晓结果</span></P>
                <p><span>=</span><?php echo $openCode?>(第<?php echo $openExpect?>期)</p>
            </div>
            <div class="result">
                <h4>计算结果</h4>
                <p>中奖号码：<span><?php echo $result_ticket;?></span></p>
            </div>
            <div class="m-calc-A">
                <p class="m-calc-A-title">奖品：<?php echo $goods['title']?></p>
                <p class="m-calc-A-title">中奖人：<?php echo $goods['ticket_nickname']?></p>
                <p class="m-calc-A-title">购买人次:<?php echo $ticket;?></p>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var count = 0;
        $(".numberA p a").click(function(){
            var $me = $(this),
                $icon = $me.find("i.ico-sortArrow-down"),
                $table = $(this).parents("p").next(".m-calc-list");
            if(count%2 == 0){
                $table.show();
                $me.text("收起");
            }else{
                $table.hide();
                $me.text("展开所有人购买记录");
            }
            count++;
        });

    });
</script>




