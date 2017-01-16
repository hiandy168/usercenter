<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="投票-大楚用户开放平台" />
    <meta name="description" content="投票-大楚用户开放平台" />
    <title><?php echo $info['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css?v=dasd"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js?v=164654313"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/masonry-docs.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery.infinitescroll.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div id="loaddiv" class="loading-div">
    <span>
        <img src="<?php echo $this->_theme_url; ?>assets/vote/images/loading.gif"/>
        <i>努力加载中...</i>
    </span>
</div>

<div class="div-main">
    <div class="vote-search">
        <form action="" method="get">
            <div class="vote-search-btn">
                <input type="submit" value="搜索" />
            </div>
            <div class="vote-search-inp">
                <input type="text" placeholder="请输入参赛者ID或姓名"  name="search" id="searchinp" value="<?php echo $search?>" />
            </div>
        </form>
    </div>

    <!--search end-->

    <div class="vote-main">
        <div class="pos-r">
            <?php if(isset($vote['img'])){?>
                <img src="<?php echo JkCms::show_img($vote['img']); ?>" width="100%" />
            <?php }else{ ?>
                <img src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/images/vote-img1.jpg" width="100%" />
            <?php }?>

            <!-- <div class="pos-a linear-bg"></div> -->
        </div>

        <div class="vote-num bsd1">
            <ul>
                <li>
                    <p class="fc259"><?php echo $joinnum?></p>
                    <em class="fc9b9 fs24">参与项目</em>
                </li>
                <li>
                    <p class="fc259" id="wasPnum"><?php echo $mynum?></p>
                    <em class="fc9b9 fs24">已投票数</em>
                </li>
                <li>
                    <p class="fc259"><?php echo $usernum?></p>
                    <em class="fc9b9 fs24">投票人数</em>
                </li>
            </ul>
        </div>

        <!--num end-->
        <?php if(!empty($votelist)&&empty($voucher)){?>
            <div class="vote-list clearfix event-list">
                <ul id="container" class="bloglist">
                    <?php foreach($votelist as $key=>$value){?>
                        <li class="item">
                            <div class="vote-listdiv bsd1">
                                <div class="vote-list-img">
                                    <a href="<?php echo $this->createUrl('/activity/vote/details',array('id'=>$value['id'],'vid'=>$id,'mid'=>$param['mid']))?>">
                                        <span><img src="<?php echo JkCms::show_img($value['img']) ?>"/></span>
                                        <!--  <em class="fs24 fcfff bg3">
                                    <i class="fl"><?php echo $value['id']; ?>号</i>
                                    <i class="fr"><?php echo $value['title']; ?></i>
                                </em> -->
                                    </a>
                                </div>

                                <div class="pos-r bb vote-list-tit">
                                    <p class="fs24"><?php echo $value['title']; ?></p>
                                </div>

                                <div class="fc9b9 vote-list-pnumnew fs24">
                                    <span class="fl"><i><?php echo $value['vote_number']; ?></i>票</span>
                                    <span class="fr"><i>&nbsp;</i><?php echo $value['id']; ?>号</span>
                                </div>

                                <!-- <div class="fc259 vote-list-pnum fs24"><i><?php echo $value['vote_number']; ?></i>票</div> -->
                                <?php if($value['isjoin']=="bg2"){?>
                                    <div id="<?php echo $value['id']; ?>" onclick="vote(<?php echo $value['id']; ?>,'<?php echo JkCms::show_img($value['img']) ?>')" class="<?php echo $value['isjoin']?> fcfff fs30 vote-list-btn bsd2">投票</div>
                                <?php }else{?>
                                    <div id="<?php echo $value['id']; ?>" onclick="vote(<?php echo $value['id']; ?>,'<?php echo JkCms::show_img($value['img']) ?>')" class="<?php echo $value['isjoin']?> fcfff fs30 vote-list-btn">已投票</div>
                                <?php }?>
                            </div>
                        </li>
                    <?php }?>
                </ul>
                <div class="loading" style="text-align: center; color: #999">
                    加载中...
                </div>
            </div>
        <?php }elseif(empty($votelist)&&!empty($voucher)){?>

            <div class="vote-list clearfix">
                <ul id="container">
                    <li class="item">
                        <div class="vote-listdiv bsd1">
                            <div class="vote-list-img">
                                <a href="javascript:void(0)">
                                    <span><img src="<?php echo JkCms::show_img($voucher['img']) ?>"/></span>
                                    <!--  <em class="fs24 fcfff bg3">
                                            <i class="fl"><?php echo $voucher['id']; ?>号</i>
                                            <i class="fr"><?php echo $voucher['title']; ?></i>
                                        </em> -->
                                </a>
                            </div>

                            <div class="pos-r bb vote-list-tit">
                                <p class="fs24"><?php echo $value['title']; ?></p>
                            </div>

                            <div class="fc9b9 vote-list-pnumnew fs24">
                                <span class="fl"><i>0</i>票</span>
                                <span class="fr"><i>&nbsp;</i><?php echo $value['id']; ?>号</span>
                            </div>



                            <!-- <div class="fc259 vote-list-pnum fs24"><i>0</i>票</div> -->
                            <div onclick="voucher('<?php echo JkCms::show_img($voucher['img']) ?>')" class="bg1 fcfff fs30 vote-list-btn">待审核</div>
                        </div>
                    </li>
                </ul>
            </div>

        <?php }elseif(!empty($votelist)&&!empty($voucher)){?>

            <div class="vote-list clearfix">
                <ul id="container">
                    <li class="item">
                        <div class="vote-listdiv bsd1">
                            <div class="vote-list-img">
                                <a href="javascript:void(0)">
                                    <span><img src="<?php echo JkCms::show_img($voucher['img']) ?>"/></span>
                                    <!-- <em class="fs24 fcfff bg3">
                                        <i class="fl"><?php echo $voucher['id']; ?>号</i>
                                        <i class="fr"><?php echo $voucher['title']; ?></i>
                                    </em> -->
                                </a>
                            </div>
                            <div class="pos-r bb vote-list-tit">
                                <p class="fs24"><?php echo $value['title']; ?></p>
                            </div>

                            <div class="fc9b9 vote-list-pnumnew fs24">
                                <span class="fl"><i>0</i>票</span>
                                <span class="fr"><i>&nbsp;</i><?php echo $value['id']; ?>号</span>
                            </div>

                            <!-- <div class="fc259 vote-list-pnum fs24"><i>0</i>票</div> -->
                            <div onclick="showpop('待审核',2,'<?php echo JkCms::show_img($voucher['img']) ?>')" class="bg1 fcfff fs30 vote-list-btn ">待审核</div>
                        </div>
                    </li>

                    <?php foreach($votelist as $key=>$value){?>
                        <li class="item">
                            <div class="vote-listdiv bsd1">
                                <div class="vote-list-img">
                                    <a href="<?php echo $this->createUrl('/activity/vote/details',array('id'=>$value['id'],'vid'=>$id,'mid'=>$param['mid']))?>">
                                        <span><img src="<?php echo JkCms::show_img($value['img']) ?>"/></span>
                                        <!--  <em class="fs24 fcfff bg3">
                                            <i class="fl"><?php echo $value['id']; ?>号</i>
                                            <i class="fr"><?php echo $value['title']; ?></i>
                                        </em> -->
                                    </a>
                                </div>

                                <div class="pos-r bb vote-list-tit">
                                    <p class="fs24"><?php echo $value['title']; ?></p>
                                </div>

                                <div class="fc9b9 vote-list-pnumnew fs24">
                                    <span class="fl"><i><?php echo $value['vote_number']; ?></i>票</span>
                                    <span class="fr"><i>&nbsp;</i><?php echo $value['id']; ?>号</span>
                                </div>



                                <!-- <div class="fc259 vote-list-pnum fs24"><i><?php echo $value['vote_number']; ?></i>票</div> -->
                                <?php if($value['isjoin']=="bg2"){?>
                                    <div id="<?php echo $value['id']; ?>" onclick="vote(<?php echo $value['id']; ?>,'<?php echo JkCms::show_img($value['img']) ?>')" class="<?php echo $value['isjoin']?> fcfff fs30 vote-list-btn bsd2">投票</div>
                                <?php }else{?>
                                    <div id="<?php echo $value['id']; ?>" onclick="vote(<?php echo $value['id']; ?>,'<?php echo JkCms::show_img($value['img']) ?>')" class="<?php echo $value['isjoin']?> fcfff fs30 vote-list-btn">已投票</div>
                                <?php }?>
                            </div>
                        </li>
                    <?php }?>
                </ul>
                <div class="loading" style="text-align: center; color: #999">
                    加载中...
                </div>
            </div>



        <?php }else{?>
            <div class="mgrl10 fs30 bsd1" style="margin-top:10px; background: #FFFFFF;overflow: hidden;text-align: center;border-radius: .2rem;padding: 2rem 0rem;color: #259AFF;">^_^<br/><br/>暂无数据</div>
        <?php }?>
        <!-- list end-->
    </div>

    <!--main end-->

    <!-- --><?php /*echo $this->renderpartial('/common/footer_app',array('active'=>1,'id'=>$id,'pid'=>$pid,'param'=>$param)); */?>

    <div class="vote-foot clearfix   <?php if($isshow!=1){echo "vote-foot-havebb";  }?>">

        <ul>
            <li>
            <span class="active">
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
                <span <?php if($active==4){?>class="active"<?php }?>>
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
    <div class="vote-pop bg4">
        <span id="imgsrc"><img src="<?php echo $this->_theme_url; ?>assets/vote/images/vote-test.jpg"/></span>
        <p class="fcfff fs30" id="vote-txt">恭喜，您已成功投票</p>

        <div id="btnall">
            <div class="closebtn fs30" id="closeBtn">确定</div>
        </div>
    </div>

</div>


<script>

    $(function(){

        var $container = $('#container');
        $container.imagesLoaded(function(){
            $container.masonry({
                itemSelector: '.item',
                isAnimated:true
            });
        });

        var page=1;
        $(window).scroll(function(){
            //获取滚动条当前的位置
            function getScrollTop() {
                var scrollTop = 0;
                if (document.documentElement && document.documentElement.scrollTop) {
                    scrollTop = document.documentElement.scrollTop;
                }
                else if (document.body) {
                    scrollTop = document.body.scrollTop;
                }
                return scrollTop;
            }

            //获取当前可视范围的高度
            function getClientHeight() {
                var clientHeight = 0;
                if (document.body.clientHeight && document.documentElement.clientHeight) {
                    clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
                }
                else {
                    clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
                }
                return clientHeight;
            }

            //获取文档完整的高度
            function getScrollHeight() {
                return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
            }
            if (getScrollTop() + getClientHeight() == getScrollHeight()) {
                var count=<?php echo $count ?>;
                if(page<count){
                    console.log(page);
                    $.ajax({
                        url:"<?php echo $this->createUrl('/activity/vote/view')?>",
                        data:{"page":page,"id":<?php echo $id ?>,'pid':<?php echo $pid ?>},
                        dataType:'json',
                        type:'GET',
                        success:function(json){
                            page++;
                            if(json){
                                var html="";
                                for(var i= 0;i<json.length;i++){
                                    html+='<li class="item">';
                                    html+='<div class="vote-listdiv bsd1">';
                                    html+='<div class="vote-list-img">';
                                    html+='<a href="<?php echo $this->createUrl('/activity/vote/details')?>/id/'+json[i].id+'/vid/'+json[i].voteid+'/mid/'+json[i].mid+'">';
                                    html+='<span><img src="/'+json[i].img+'"></span>';
                                    // html+='<em class="fs24 fcfff bg3">';
                                    // html+='<i class="fl">'+json[i].id+'号</i>';
                                    // html+='<i class="fr">'+json[i].title+'</i>';
                                    // html+='</em>';
                                    html+='</a>';
                                    html+='</div>';
                                    html+='<div class="pos-r bb vote-list-tit">';
                                    html+='<p class="fs24">'+json[i].title+'</p>';
                                    html+='</div>';
                                    html+='<div class="fc9b9 vote-list-pnumnew fs24">';
                                    html+='<span class="fl"><i>'+json[i].vote_number+'</i>票</span>';
                                    html+='<span class="fr"><i>&nbsp;</i>'+json[i].id+'号</span>';
                                    html+='</div>';

                                    // html+='<div class="fc259 vote-list-pnum fs24"><i>'+json[i].vote_number+'</i>票</div>';

                                    if(json[i].isjoin=="bg2"){
                                        html+='<div id="'+json[i].id+'" onclick=vote('+json[i].id+',"/'+json[i].img+'") class="bg2 fcfff fs30 vote-list-btn bsd2">投票</div>';
                                    }else{
                                        html+='<div id="'+json[i].id+'" onclick=vote('+json[i].id+',"/'+json[i].img+'") class="bg1 fcfff fs30 vote-list-btn">已投票</div>';
                                    }
                                    html+='</div>';
                                    html+='</li>';
                                }
                                var timer=setTimeout(function(){
                                    var $newElems = $(html).css({ opacity: 0}).appendTo(container);
                                    $newElems.imagesLoaded(function(){
                                        $container.masonry( 'appended', $newElems,true);
                                        clearTimeout(timer);
                                    });
                                },200)

                            }

                        }

                    })
                }else{
                    $(".loading").html("已经到底了！");
                }

            }
        });

    })
    //  pop
    function showpop(t,k,i,num){
        $(".mask").show();
        $("#vote-txt").html(t);
        $("#imgsrc").html("<img src="+i+">");
        $(".vote-pop").show().addClass("pop-active");
        if(k==1){
            $("#closeBtn").click(function(){
                $(".vote-pop").hide().removeClass("pop-active");
                $(".mask").hide();
            })
        }
        if(k==2){
            $("#closeBtn").click(function(){
                $(".vote-pop").hide().removeClass("pop-active");
                $(".mask").hide();
            })
        }
    }

    //  投票
    function vote(vid,imgsrc){

        var voteid=<?php echo $id ?>;
        <?php if(!$param['mid']){?>
        showloginssss();
        return false;
        <?php } ?>
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('/activity/vote/ajaxvote');?>",
            dataType:"json",
            data:{
                "vid": <?php echo $id?>,
                "pid":<?php echo $pid?>,
                "id":vid,
                "mid":mid
            },
            success: function(msg){
                // alert(msg);
                if(msg.code==1){
                    var pnum=parseInt($('#'+vid).prev().find('.fl').find('i').text());
                    $('#'+vid).prev().find('.fl').find('i').text(pnum+1);
                    var waspnum=parseInt($("#wasPnum").text());
                    $("#wasPnum").text(waspnum+1);
                    if(msg.num<2){
                        $('#'+vid).removeClass('bg2 bsd2').addClass('bg1').text('已投票');
                    }
                    //是否参与抽奖
                    if(<?php echo $info['is_lucky']?true:false;?>){
                        //是否支持回调
                        var callback="";
                        <?php if($info['callback']){ ?>
                             callback="/voteid/"+voteid;
                        <?php } ?>
                        //抽奖组件 等于2 是大转盘  等于1 是刮刮卡
                        <?php if($info['activity_type']==2){ ?>
                            var url="<?php echo $this->createUrl('/activity/bigwheel/view/id/'.$info['activity_id'])?>"+callback;
                        <?php }else{ ?>
                            var url="<?php echo $this->createUrl('/activity/scratchcard/view/id/'.$info['activity_id'])?>"+callback;
                        <?php }?>

                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div><a href="'+url+'"><div  class="closebtn fs30" >前往抽奖</div></a>');
                        showpop('恭喜，您已成功投票，点击"前往抽奖"！',1,imgsrc,vid);
                        $("#closeBtn").html("关闭");
                    }else{
                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div>');
                        showpop('恭喜，您已成功投票',1,imgsrc,vid);
                        $("#closeBtn").html("确定");
                    }

                }else if(msg==4){
                    if(voteid==voteids){
                        $("#btnall").html('<div class="closebtn fs30" id="closeBtn">确定</div><a href="http://m.hb.qq.com/activity/bigwheel/view/id/2003/voteid/74"><div  class="closebtn fs30" >前往抽奖</div></a>');
                        showpop('已经投过票了',2,imgsrc,vid);
                        $("#closeBtn").html("关闭");
                    }else{ showpop('已经投过票了',2,imgsrc,vid);}

                }else if(msg==-1){

                    showpop('活动已结束',2,imgsrc,vid);
                }else if(msg==-2){
                    showpop('请在移动设备上打开投票',2,imgsrc,vid);
                }else{
                    showpop('投票失败',2,imgsrc,vid);
                }
            }
        });

    }

    openid = "<?php echo $param['openid']?>";
    id = "<?php echo $id?>";
    pid = "<?php echo $pid?>";
    //  backUrl = "<?php echo $param['backUrl']?>";
    mid = "<?php echo $param['mid'] ?>";
    table = "vote";
</script>




<script>

    <?php if(!$param['mid']){?>
    showlogin();
    $("#winlogin").hide();
    <?php } ?>

</script>
<script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js?v=dasd" type="text/javascript" charset="utf-8"></script>
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/view',array('id'=>$id) ))); ?>

</body>
</html>
