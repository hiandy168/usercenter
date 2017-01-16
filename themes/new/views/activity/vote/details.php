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
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js"></script>
</head>
<body>

<div class="div-main">

    <div class="vote-main">
        <div class="pos-r">
            <img src="<?php echo JkCms::show_img($edit['img']) ?>" width="100%" />
            <div class="pos-a linear-bg"></div>
        </div>

        <div class="vote-detail1 bsd1 mgrl10 mgb20">

            <?php if($isjoin=="bg2"){?>
                <div onclick="vote(<?php echo $join['id']; ?>,'<?php echo JkCms::show_img($join['img']) ?>')" class="bsd2 bg2 fcfff fs30 fr vote-detail1-r">投票</div>
            <?php }else{?>
                <div onclick="vote(<?php echo $join['id']; ?>,'<?php echo JkCms::show_img($join['img']) ?>')" class=" bg1 fcfff fs30 fr vote-detail1-r">已投票</div>
            <?php }?>
            <div class="vote-detail1-l">
				   	<span class="fc259 fs24">
				   		<i><?php echo $join['vote_number']?></i>票
				   	</span>
				   	<span class="fs24 fc9b9">
				   		<i><?php echo $join['id']?>号&nbsp;&nbsp;<?php echo $join['title']?></i>
				   		当前排名<b><?php echo $join['top']?></b>名
				   	</span>
            </div>

        </div>



        <!-- <div class="fs24 bsd1 clearfix mgrl10 mgb20 vote-detail2 vote-detail2-name">
            <i>
                <img src="<?php echo $this->_theme_url; ?>assets/vote/images/User.png"/>
            </i>
            <label class=" fc9b9">名称</label>
            <em class=" fc259"><?php echo isset($edit['title']) ? $edit['title'] : ''; ?></em>
        </div>-->
        <?php if(!empty($formList)){?>
            <div class="vote-detail3 fs24 bsd1 clearfix mgrl10 mgb20">

                <?php foreach($formList as $form){if($form['forms']==0){?>
                    <div class="vote-detail2 pos-r bb">
                        <i>
                            <img src="<?php echo $this->_theme_url; ?>assets/vote/images/uniline.png"/>
                        </i>
                        <label class=" fc9b9"><?php echo $form['title'] ?></label>
                        <em class=" fc259"><?php echo $form['answer']['message']  ?></em>
                    </div>
                <?php }elseif($form['forms']==1){?>
                    <div class="vote-detail2 pos-r bb">
                        <i>
                            <img src="<?php echo $this->_theme_url; ?>assets/vote/images/rowmuch.png"/>
                        </i>
                        <label class=" fc9b9"><?php echo $form['title'] ?></label>
                    </div>

                    <div class="pos-r bb vote-form-inp" style="margin: 0rem .4rem;">
                        <i class="left-icon">
                        </i>
					<span>
						<em class="fc259 fs24" style="display: block;word-wrap: break-word;"><?php echo $form['answer']['message']  ?></em>
					</span>
                    </div>

                <?php } elseif($form['forms']==2){?>
                    <div class="vote-detail2 pos-r bb">
                        <i>
                            <img src="<?php echo $this->_theme_url; ?>assets/vote/images/radio.png"/>
                        </i>
                        <label class=" fc9b9"><?php echo $form['title'] ?></label>
                        <?php foreach($form['question'] as $ss){?>
                            <em class=" fc259"><?php if($ss['id']==$form['answer']['message']){ ?><?php echo $ss['question']?><?php } ?> </em>
                        <?php }?>
                    </div>
                <?php }elseif($form['forms']==3){ ?>
                    <div class="vote-detail2 pos-r ">
                        <i style="    position: relative; top: -2px;">
                            <img src="<?php echo $this->_theme_url; ?>assets/vote/images/checkbox.png"/>
                        </i>
                        <label class=" fc9b9"><?php echo $form['title'] ?></label>
                        <em class=" fc259 vote-detail2-ahlist">
                            <?php if(!empty($form['checkbox'])){foreach($form['question'] as $ss){if((in_array($ss['id'],$form['checkbox']))){?>
                                <li class="fs24 fcfff bg1"><?php echo $ss['question']?></li>
                            <?php }}}?>
                        </em>
                    </div>

                <?php } ?>
                <?php } ?>

            </div>
        <?php } ?>

        <!--
        <div class="fs24 bsd1 clearfix mgrl10 mgb20 vote-detail3">
            <div class="vote-detail2 pos-r bb">
                <i>
                    <img src="<?php echo $this->_theme_url; ?>assets/vote/images/Cup.png"/>
                </i>
                <label class=" fc9b9">活动宣言</label>
            </div>

            <div class="fc259 vote-detail4-txt" style="font-size: .48rem;">
                <?php echo $edit['remark'] ?>
            </div>
        </div>
-->


    </div>

    <!--main end-->

    <?php echo $this->renderpartial('/common/footer_app',array('active'=>0,'id'=>$vid,'pid'=>$pid,'param'=>$param)); ?>


    <div class="mask"></div>

    <!--pop-->

    <div class="mask"></div>
    <div class="vote-pop bg4">
        <span id="imgsrc"><img src="<?php echo $this->_theme_url; ?>assets/vote/images/vote-test.jpg"/></span>
        <p class="fcfff fs30" id="vote-txt">恭喜，您已成功投票</p>
        <div id="btnall">
            <div class="closebtn fs30" id="closeBtn">确定</div>
        </div>
    </div>


</div>


<script>

    function showpop(t,k,i){
        $(".mask").show();
        $("#vote-txt").html(t);
        $("#imgsrc").html("<img src="+i+">");
        $(".vote-pop").show().addClass("pop-active");
        if(k==1){
            $("#closeBtn").click(function(){
                window.location.reload();//刷新当前页面
            })
        }
        if(k==2){
            $("#closeBtn").click(function(){
                $(".vote-pop").hide().removeClass("pop-active");
                $(".mask").hide();
            })
        }
    }
    function vote(vid,imgsrc){
        var voteids=74;
        var voteid=<?php echo $vid ?>;
        <?php if(!$param['mid']){?>
        showloginssss();
        return false;
        <?php } ?>
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('/activity/vote/ajaxvote');?>",
            data:{
                "vid": <?php echo $vid?>,
                "id":vid,
                "mid":<?php echo $mid?>
            },
            success: function(msg){
                // alert(msg);
                if(msg==1){
//                    var pnum=parseInt($('#'+vid).prev().find('i').text());
//                    $('#'+vid).prev().find('i').text(pnum+1);
//                    var waspnum=parseInt($("#wasPnum").text());
//                    $("#wasPnum").text(waspnum+1);
//                    $('#'+vid).removeClass('bg2 bsd2').addClass('bg1').text('已投票');
                    if(voteid==voteids){
                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div><a href=<?php echo $this->_siteUrl;?>."/activity/bigwheel/view/id/2003/voteid/74"><div  class="closebtn fs30" >前往抽奖</div></a>');
                        showpop('恭喜，您已成功投票，点击"前往抽奖"每日三次抽奖机会！',1,imgsrc,vid);
                        $("#closeBtn").html("关闭");
                    }else{
                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div>');
                        showpop('恭喜，您已成功投票',1,imgsrc,vid);
                        $("#closeBtn").html("确定");
                    }

                }else if(msg==4){
                    if(voteid==voteids){
                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div><a href=<?php echo $this->_siteUrl;?>."/activity/bigwheel/view/id/2003/voteid/74"><div  class="closebtn fs30" >前往抽奖</div></a>');
                        showpop('已经投过票了',2,imgsrc,vid);
                        $("#closeBtn").html("关闭");
                    }else{ showpop('已经投过票了',2,imgsrc,vid);}

                }else if(msg==-1){

                    showpop('活动已结束',2,imgsrc,vid);
                }
            }

        });

    }



</script>
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/details',array('id'=>$id,'vid'=>$vid) ))); ?>
</body>
</html>
