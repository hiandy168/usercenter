<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="<?php echo $info['title']?>" />
    <meta name="description" content="<?php echo $info['title']?>" />
    <title><?php echo $info['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css?vdassdaddss"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main">


    <div class="vote-main" >
        <div class="pos-r vote-hd-rankdiv1">
            <h3 class="tit">我的投票</h3>
            <img src="<?php echo JkCms::show_img($vote['img']); ?>" width="100%" />
            <div class="pos-a linear-bg"></div>
        </div>


        <?php if(!empty($mylist)){?>
        <div class="vote-myvote-list clearfix">
            <ul>
                <?php foreach ($mylist as $k=>$v){?>
                    <li class="clearfix bsd1">
                        <span class="fl"><img src="<?php echo JkCms::show_img($v['join']['img']) ?>" /></span>
                        <em class="fc259 fs24 fr">
                            <i><?php echo $v['join']['vote_number'] ?></i>票
                        </em>
                        <span class="">
                            <h3 class="fs30"><?php echo $v['join']['title'] ?></h3>
                            <i class="fs24"><?php echo $v['join']['id'] ?>号</i>
                            <p class="fs24">当前排名第<b><?php echo $v['join']['top']?></b>名</p>
                        </span>
                    </li>
                <?php } ?>
            </ul>

        </div>
        <?php }else{?>

            <div class="mgrl10 fs30 bsd1" style="margin-top: -1rem; background: #FFFFFF;overflow: hidden;text-align: center;border-radius: .2rem;padding: 2rem 0rem;color: #259AFF;position: relative;">^_^<br/><br/>暂无数据</div>

        <?php }?>


    </div>

    <!--main end-->

    <?php echo $this->renderpartial('/common/footer_app',array('active'=>3,'id'=>$id,'pid'=>$pid,'param'=>$param)); ?>

    <div class="mask"></div>

    <!--pop-->

    <div class="vote-pop bg4">
        <span><img src="images/vote-test.jpg"/></span>
        <p class="fcfff fs30">恭喜，您已成功投票</p>
        <!--<p class="fcfff fs30">遗憾，不可重复投票！</p>-->
        <div class="closebtn fs30">确定</div>
    </div>


</div>
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/myvote',array('id'=>$id) ))); ?>
</body>
</html>
