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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css?vdasdss"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main">


    <div class="vote-main">
        <div class="pos-r vote-hd-rankdiv1">
            <h3 class="tit">投票排行</h3>
            <img src="images/vote-banner.jpg" width="100%" />
            <div class="pos-a linear-bg"></div>
        </div>
        <div class="bsd1 vote-hd-rankdiv2 clearfix">
            <i class="fl fs30 fc259">排名</i>
            <i class="fr fs30 fc259">票数</i>
            <i class="fs30 fc259">名称/排号</i>
        </div>
        <?php if(!empty($votelist)){?>
        <div class="bsd1 vote-hd-rankdiv3">
            <ul>
                <?php
                $i=1;
                foreach ($votelist as $k=>$v){
                ?>
                <li class="pos-r clearfix bb bgfff">
                    <i class="fl fs30 "><?php echo $i?></i>
                    <i class="fr fs30 fc259"><?php echo $v['vote_number']?></i>
                    <i class="fs30"><?php echo $v['title']?><b></b><?php echo $v['id']?>号</i>
                </li>
                <?php
                $i++;
                }
                ?>
            </ul>
        </div>
        <?php }else{?>

            <div class="mgrl10 fs30 bsd1" style="margin-top: 10px; background: #FFFFFF;overflow: hidden;text-align: center;border-radius: .2rem;padding: 2rem 0rem;color: #259AFF;">^_^<br/><br/>暂无数据</div>

        <?php }?>

    </div>

    <!--main end-->

    <?php /*echo $this->renderpartial('/common/footer_app',array('active'=>4,'id'=>$id,'pid'=>$pid,'param'=>$param)); */?>

    <div class="vote-foot clearfix <?php if($isshow!=1){echo "vote-foot-havebb";  }?>">

        <ul>
            <li>
            <span <?php if($active==1){?>class="active"<?php }?>>
                <a href="<?php echo $this->createUrl('/activity/vote/view',array('id'=>$id))?>">
                    <i class="vote-icon vote-icon1"></i>
                    <em>投票首页</em>
                </a>
            </span>

            <span <?php if($active==2){?>class="active"<?php }?>>
                <a href="<?php echo $this->createUrl('/activity/vote/introduce',array('id'=>$id,'pid'=>$pid))?>">
                    <i class="vote-icon vote-icon2"></i>
                    <em>活动说明</em>
                </a>
            </span>
            </li>
            <?php if($isshow==1){?>
            <?php
            $re= Activity_vote_join::model()->find("mid=:mid AND status=:status",array(':mid'=>$this->member['id'],':status'=>1));
            if($re){
                ?>
                <div class="bg4 pos-a bsd1 vote-bm-btn">
                    <a href="<?php echo $this->createUrl('/activity/vote/participate',array('id'=>$id,'pid'=>$pid,'joinid'=>$re['id']))?>">
                        <i class="vote-icon5"></i>
                        <em>我要报名</em>
                    </a>
                </div>
            <?php }else{?>

                <div class="bg4 pos-a bsd1 vote-bm-btn">
                    <a href="<?php echo $this->createUrl('/activity/vote/participate',array('id'=>$id,'pid'=>$pid))?>">
                        <i class="vote-icon5"></i>
                        <em>我要报名</em>
                    </a>
                </div>

            <?php }}?>
            <li>
                <span class="active">
                    <a href="<?php echo $this->createUrl('/activity/vote/ranking',array('id'=>$id,'pid'=>$pid))?>">
                        <i class="vote-icon vote-icon4"></i>
                        <em>投票排名</em>
                    </a>
                </span>
                <span <?php if($active==3){?>class="active"<?php }?>>
                    <a href="<?php echo $this->createUrl('/activity/vote/myvote',array('id'=>$id,'pid'=>$pid))?>">
                        <i class="vote-icon vote-icon3"></i>
                        <em>我的投票</em>
                    </a>
                </span>
            </li>
        </ul>

    </div>
    <div class="mask"></div>
    <!--pop-->
    <div class="vote-pop bg4">
        <span><img src="images/vote-test.jpg"/></span>
        <p class="fcfff fs30">恭喜，您已成功投票</p>
        <!--<p class="fcfff fs30">遗憾，不可重复投票！</p>-->
        <div class="closebtn fs30">确定</div>
    </div>
</div>
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/ranking',array('id'=>$id) ))); ?>

</body>
</html>
