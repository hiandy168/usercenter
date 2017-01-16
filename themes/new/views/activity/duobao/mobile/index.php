<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="一元购" />
    <meta name="description" content="一元购" />
    <title>一元购</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/one/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/one/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/one/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/one/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/one/js/slides.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <script type="text/javascript">
        openid = "<?php echo $param['openid']?>";
        id = "<?php echo $id?>";
        pid = "<?php echo $param['id']?>";
        //	backUrl = "<?php echo $param['backUrl']?>";
        mid = "<?php echo $mid ?>";
        table = "duobao_gz_goods";
        //table = "activity_bigwheel";
        day_count  = "<?php echo $info['day_count'] ?>";
    </script>
    <script type="text/javascript">
        window.onload = function () {
            var mySwiper1 = new Swiper('.ydmain-banner', {
                autoplay: 5000,
                visibilityFullFit: true,
                loop: true,
                pagination: '.pagination',
            });

        }
    </script>
</head>
<body>

<div class="div-main">
    <div class="pos-r fs40 fcdd bb top-tit">
        商品详情
    </div>

    <div class="ydmain-banner swiper-container-horizontal">

        <div class="swiper-wrapper">
            <?php
            foreach($thumb_url as $adVal){
                ?>
                <div class="swiper-slide">
                    <a><img src="<?php echo JkCms::show_img($adVal) ?>"/></a>
                </div>
            <?php
            }
            ?>
        </div>


        <div class="pagination"></div>

    </div>

    <!--banner end-->


    <?php
    if(!$adList && empty($good['ticket'])){
        ?>
        <div class="pd06 yyg-info pos-r bb">
            <h2 class="fs30 fc00 infotit"><i>进行中</i><?php echo $good['title'] ?></h2>
            <p class="fs24 fc80"><?php echo $good['share_desc'] ?></p>
            <span><i style="width: <?php echo ($good['ticket_total'])/$good['productprice']*100 ?>%;"></i></span>
            <em class="clearfix fs24 fc00">
                <i class="fl">总需人次：<?php echo $good['productprice'] ?></i>
                <i class="fr">剩余人次：<b class="fcdd"><?php echo $good['productprice']-$good['ticket_total'] ?></b></i>
            </em>
        </div>
        <p class="m-detail-userCodes-blank">您没有参与本次夺宝哦！</p>
    <?php
    }elseif($adList && empty($good['ticket'])){
        ?>
        <div class="pd06 yyg-info pos-r bb">
            <h2 class="fs30 fc00 infotit"><i>进行中</i><?php echo $good['title'] ?></h2>
            <p class="fs24 fc80"><?php echo $good['share_desc'] ?></p>
            <span><i style="width: <?php echo ($good['ticket_total'])/$good['productprice']*100 ?>%;"></i></span>
            <em class="clearfix fs24 fc00">
                <i class="fl">总需人次：<?php echo $good['productprice'] ?></i>
                <i class="fr">剩余人次：<b class="fcdd"><?php echo $good['productprice']-$good['ticket_total'] ?></b></i>
            </em>
        </div>
        <div class="yyg-info-zj3">
            <ul>
                <li>
                    <i>参与人次</i>
                    <span><b class="fcdd"><?php echo $count ?></b>人次</span>
                </li>
                <li>
                    <i>参与号码</i>
              	    	<span>
                            <?php
                            foreach($adList as $adVal){
                                ?>
                                <em><?php echo $adVal['ticket']?></em>
                            <?php
                            }
                            ?>
                            <em><a href="" class="fc16">全部号码</a></em>
              	    	</span>
                </li>
            </ul>
        </div>
    <?php
    }else{
        ?>
        <div class="pd06 yyg-info pos-r">
            <h2 class="fs30 fc00 infotit"><i>进行中</i><?php echo $good['title'] ?></h2>
            <p class="fs24 fc80"><?php echo $good['share_desc'] ?></p>
        </div>
        <div class="yyg-info-zj pd06 pos-r bb bgfff">
            <div class="clearfix yyg-info-zj1">
                <i class="fl fs24">中奖号码：<b class="fs30"><?php echo $tret[0]['ticket']?></b></i>
                <a class="fr" href="<?php echo $this->createUrl('/activity/duobao/ticketTotal',array('id'=> $id)) ?>">计算详情</a>
            </div>
            <div class="yyg-info-zj2">
           		<span class="fl">
           			<img class="img1" src="<?php echo $this->_theme_url; ?>assets/one/images/yyg-xq-img3.png"/>
           			<img class="img2" src="images/yyg-xq-img1.png"/>
           		</span>
           		<span>
           			<h3 class="fc00 fs30">中奖人：<?php echo $tret[0]['ticket_nickname']?><i class="fc16 fs24 fr">北京市</i></h3>
           			<p class="fc80 fs24">揭晓时间：<?php echo date('Y-m-d H:i:s',$tret[0]['ticket_time'])?></p>
           			<p class="fc80 fs24">本期参与<b class="fcdd"><?php echo $counts['count']?></b>人次</p>
           		</span>
            </div>
            <div class="yyg-info-zj3">
                <ul>
                    <!-- <li>
                         <i>参与时间</i>
                         <span>2016-09-10  00:32:03,198</span>
                     </li>-->
                    <li>
                        <i>参与人次</i>
                        <span><b class="fcdd"><?php echo $count ?></b>人次</span>
                    </li>
                    <li>
                        <i>参与号码</i>
              	    	<span>
                            <?php
                            foreach($adList as $adVal){
                                ?>
                                <em><?php echo $adVal['ticket']?></em>
                            <?php
                            }
                            ?>
                            <em><a href="" class="fc16">全部号码</a></em>
              	    	</span>
                    </li>
                </ul>
            </div>
        </div>
    <?php
    }
    ?>


    <!--info end-->

    <div class="yyg-rule mgt bb bt clearfix fs30  bgfff pos-r pdrl06">
        <a href="">
            <i class="fc00">中奖规则</i>
            <i class="left-more"></i>
        </a>
    </div>

    <div class="yyg-cyjl clearfix bgfff pdrl06 pos-r">
        <i class="fl fs30 fc00">所有参与记录</i>
        <i class="fr fs24 fc80"></i>
    </div>

    <div class="yyg-cyjl1">
        <ul>
            <?php
            foreach($ret as $adVal){
            ?>
            <li class="bt pos-r">
                <div class="yyg-cyjl2 fc00 clearfix pdrl06">
                    <img class="fl" src="<?php echo JkCms::show_img($adVal['headimgurl']) ?>"/>
		        		<span>
		        			<h3>
                                <i class="fl fs30"><?php echo $adVal['username']?></i>
                                <i class="fr fs24"><?php echo $adVal['total']?>人次</i>
                            </h3>
		        			<p class="fs24">
                                <i><?php echo $adVal['city']?> IP:<?php echo $adVal['regip']?></i>
                                <i><?php echo date('Y-m-d H:i:s',$adVal['ordertime'])?></i>
                            </p>
		        		</span>
                </div>
            </li>
            <?php
            }
            ?>
        </ul>

    </div>

    <div class="bb bt bgfff yyg-allcyjl pos-r">
        <a href="<?php echo $this->createUrl('/activity/duobao/moreRecords', array('id' => $id)) ?>" class="fs24 fc00 db">
            查看所有参与记录
        </a>
    </div>
    <div style="display:none">
                                <span id='stock'>
                                    <?php if($good['totalcnf'] == 2){
                                        ?>
                                        无限
                                    <?php
                                    }else {
                                        ?>
                                        <?php echo $good['total']?>

                                    <?php
                                    }
                                    ?>
                                </span>
        <input type="hidden" class="form-control input-sm pricetotal goodsnum" style="width:50px;text-align:center" value="<?php echo $good['total'] ?>" id="total" />

        <input type="hidden" class="form-control input-sm pricetotal goodsnum" style="width:50px;text-align:center" value="<?php echo $id ?>" id="id" />

        <input type="hidden" class="form-control input-sm pricetotal goodsnum" style="width:50px;text-align:center" value="<?php echo $pid ?>" id="pid" />
    </div>

    <div class=" bgfff bt  pos-r fs24 fc00 yyg-xq-foot mgt">
        <ul>
            <li>公平公正公开</li>
            <li class="l1">正品保证</li>
            <li class="l2">权益保障</li>
        </ul>
        <a href="" class="fc00 db">点击查看游戏说明</a>
        <p>活动最终解释权归大楚网所有</p>
    </div>



    <div class="yyg-xq-footbar bgfff bt">
        <ul class="pdrl06">


            <?php
            if($tret[0]['productprice']!=$tret[0]['ticket_total']){
                ?>
               <!-- <a id="quickBuy" class="w-button w-button-main" href="<?php /*echo $this->createUrl('/activity/duobao/buy', array('id' => $id,'pid'=>$pid)) */?>">立即参与</a>
                <a id="addToCart" class="w-button" onclick="addtocart()">加入清单</a>
                <a id="" class="w-button" href="<?php /*echo $this->createUrl('/activity/duobao/user', array('uid' => $uid,'pid'=>$pid)) */?>">个人中心</a>-->

                <li><a class="abtn abtnc1 fs30" href="<?php echo $this->createUrl('/activity/duobao/user', array('uid' => $uid,'pid'=>$pid)) ?>" class="">
                        我的首页
                    </a></li>

                <li><a class="abtn abtnc2 fs30" href="<?php echo $this->createUrl('/activity/duobao/buy', array('id' => $id,'pid'=>$pid)) ?>" class="">
                        立即参与
                    </a></li>
            <?php
            }else{
                ?>
                <!--<a id="" class="w-button" href="<?php /*echo $this->createUrl('/activity/duobao/user', array('uid' => $uid,'pid'=>$pid)) */?>">个人中心</a>-->
                <li style="width: 100%;"><a style="margin: 0;" class="abtn abtnc1 fs30" href="<?php echo $this->createUrl('/activity/duobao/user', array('uid' => $uid,'pid'=>$pid)) ?>" class="">
                        我的首页
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>



    </div>

</div>
</body>
<script>
    var options = [];
    var specs = [];
    var hasoption = false;

    function option_selected() {
        var ret = {
            no: "",
            all: []
        };
        if (!hasoption) {
            return ret;
        }
        $(".optionid").each(function() {
            ret.all.push($(this).val());
            if ($(this).val() == '') {
                ret.no = $(this).attr("title");
                return false;
            }
        })
        return ret;
    }

    function addtocart() {
        var ret = option_selected();
        if (ret.no != '') {
            alert("请选择" + ret.no + "!", true);
            return;
        }
        var total = $("#total").val();
        var id = $("#id").val();
        var pid = $("#pid").val();
        var stock = parseInt($('#stock').text());
        //alert(stock);
        if (stock == 0) {
            alert('库存不足，无法购买。');
            return;
        }
        var url = "<?php echo $this->_siteUrl?>/activity/duobao/buys" + "/id/" + id + "/pid/" + pid;
        $.getJSON(url, function(s) {
            if (s.result == 0) {
                alert("超过剩余次数!");
            } else {
                // tip_close();
                alert("已加入购物车!");
                $('#carttotal').css({
                    'width': '50px',
                    'height': '50px',
                    'line-height': '50px'
                }).html(s.total).animate({
                    'width': '20px',
                    'height': '20px',
                    'line-height': '20px'
                }, 'slow');
            }
        });
    }
</script>
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$good,'url'=>$this->createUrl('/activity/duobao/MobileIndex',array('id'=>$id,'pid'=>$pid) ))); ?>
<script type="text/javascript">
    <?php if(!$mid){?>
    showlogin();
    <?php } ?>
</script>
</html>
