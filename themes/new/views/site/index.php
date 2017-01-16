    <?php  echo $this->renderpartial('/common/header_new',$config); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/js/jquery.fullPage-2.1.9.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery.fullPage-2.2.2.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery.easing.min.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function() {
            $('.section').show();
            $(".ad-top-bg").addClass('ad-top-bgno')
            for (var i = 2; i < 9; i++) {
                $('.section' + i).children().addClass("hide");
                $('.section' + i).children().last().children().addClass("hide");
            }
            $("#maindiv").fullpage({
                verticalCentered: false,
                anchors: ['page1', 'page2', 'page3', 'page4', 'page5', 'page6', 'page7', 'page8'],
                navigation: true,
                navigationTooltips: ['首页', '业务范围', '核心业务', '平台概述', '用户体系 ', '开放能力', '数据留存', '合作伙伴'],
                scrollingSpeed: 700,
                scrollOverflow: false,
                onLeave: function(index, nextIndex, direction) {
                    if (nextIndex == 1) {
                        $(".section1 .bg").removeClass("hide");
                    }
                    if (nextIndex == 7||nextIndex == 6) {
                        $(".section7 .bg").removeClass("hide");
                    }
                },
                afterLoad: function(index, nextIndex, direction) {
                    if (nextIndex) {
                        for (var i = 1; i < 9; i++) {
                            $('.section' + i).children().addClass("hide");
                            $('.section' + i).children().last().children().addClass("hide");
                        }

                        $('.section' + nextIndex).children().removeClass("hide");
                        $('.section' + nextIndex).children().last().children().removeClass("hide");
                    }

                    if (nextIndex == 1) {
                        $(".ad-top-bg").addClass("ad-top-bgno");
                    } else {
                        $(".ad-top-bg").removeClass("ad-top-bgno");
                    }
                },

            });

            $(window).resize(function() {
                rs()
            });

            function rs() {
                var h = $(window).height();
                if (h < 800) {
                    $(".pt-about .img1").width("34%");
                    $(".pt-about .img2").width("30%");
                } else {
                    $(".pt-about .img1").width("auto");
                    $(".pt-about .img2").width("auto");
                }
            }
            rs()
        });
    </script>



<style type="text/css">
    .section { min-height: 700px; min-width: 1140px; width: 100%; display: none; }
    .w1140 { width: 1140px; }
    .ad-top-bg { position: fixed; z-index: 99; top: 0; left: 0; right: 0; }
    .ad-top-bg .ad-head { width: 1140px; }
    .ad-top-bgno { background: none; }
    .ad-foot-bg { position: absolute; left: 0; bottom: 0; right: 0; z-index: 99; }
    .section .bg { position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: #ededed; z-index: -1; }
    .section .bg img { display: block; width: 100%; height: 100%; }
    .section .top-bg-color { position: absolute; z-index: 9; top: 0; left: 0; right: 0; height: 70px; background: #3b3b4b; }
    .section1 .p1-txt { position: absolute; top: 50%; left: 50%; text-align: center; margin-left: -400px; margin-top: -150px; }
    .section1 .p1-txt h1 { font-size: 72px; color: #fff; }
    .section1 .p1-txt h1 em { color: #24aa98; }
    .section1 .p1-txt h3 { color: #fff; font-size: 28px; margin: 20px 0px 80px; }
    .section1 .p1-txt a { width: 200px; display: inline-block; height: 50px; border: 1px solid #fff; border-radius: 5px; line-height: 50px; font-size: 20px; color: #fff; }
    .section1 .p1-txt a:hover { background: #b9beba; background: rgba(255, 255, 255, .4); }
    .section .title { margin: 0 auto; position: relative; top: 70px; font-size: 30px; text-align: center; padding: 30px 0px; border-bottom: 1px solid #d1d1d1; }
    .section .title i { margin-right: 15px; }
    .section .title i img { }
    .yw-list { position: absolute; left: 50%; margin-left: -570px; top: 50%; margin-top: -80px; }
    .yw-list ul li { float: left; text-align: center; width: 300px; margin: 0px 40px; }
    .yw-listdiv { }
    .yw-listdiv span { display: block; height: 120px; border: 2px solid; border-radius: 100px; position: relative; }
    .yw-listdiv span i { display: inline-block; position: relative; top: -36px; background: #ededed; width: 80px; }
    .yw-listdiv span i img { }
    .yw-listdiv span h3 { font-size: 24px; margin-top: -22px; }
    .yw-listdiv span h4 { font-size: 16px; color: #999; }
    .yw-listdiv p { font-size: 36px; margin-top: 30px; }
    .yw-listdiv p i { font-size: 16px; margin-left: 5px; }
    .yw-listdiv .bline { width: 50px; height: 0; border-bottom: 2px solid; margin: 30px auto; }
    .yw-listdiv .c1 { border-color: #2484c6; }
    .yw-listdiv .c2 { border-color: #f96a30; }
    .yw-listdiv .c3 { border-color: #24aa98; }
    .yw-listdiv a { font-size: 14px;width: 150px;display: inline-block;height: 40px;border-radius: 5px;line-height: 40px;border: 1px solid #0091d5;color: #0091d5; }
    .yw-listdiv a:hover{background: #0091d5;color: #FFFFFF;}
    .yw1-list { position: absolute; left: 50%; margin-left: -570px; top: 50%; margin-top: -140px; }
    .yw1-list ul li { float: left; width: 50%; text-align: center; }
    .yw1-listdiv { }
    .yw1-listdiv img { }
    .yw1-listdiv p { margin: 30px auto; }
    .yw1-listdiv a { width: 150px; height: 40px; display: inline-block; line-height: 40px; border: 1px solid #0091d5; color: #0091d5; border-radius: 5px; }
    .yw1-listdiv a:hover {background: #0091d5; color: #FFFFFF; }
    .yw1-listdiv a.a1 { margin-left: 20px; }
    .pt-about { position: absolute; left: 50%; margin-left: -570px; bottom: 0; }
    .pt-about .img1 { position: absolute; bottom: 20px; left: 0; }
    .pt-about .img2 { position: absolute; right: 100px; bottom: 310px; }
    .pt-about .img3 { position: absolute; right: 100px; bottom: 50px; }
    .pt-about1 { height: 20px; position: absolute; width: 100%; bottom: 0; left: 0; background: #7a9fd3; }
    .yh-about { position: absolute; left: 50%; margin-left: -570px; top: 50%; margin-top: -140px; }
    .yh-about .img1 { }
    .yh-about .img2, .yh-about .img4 { margin: 0px 30px; }
    .yh-about .img3 { }
    .yh-about .img4 { }
    .yh-about .img5 { }
    .kf-ablity { position: absolute; top: 50%; margin-top: -80px; left: 50%; margin-left: -570px; }
    .kf-ablity { }
    .kf-ablity ul { width: 1200px; }
    .kf-ablity ul li { float: left; text-align: center; margin-right: 27px; }
    .kf-ablity ul li a { }
    .kf-ablity ul li span { display: block; background: #fff; border: 1px solid #d9d9d9; border-radius: 10px; }
    .kf-ablity ul li:hover span, .hz-hzlogo ul li a:hover { border-color: #0091d5; -webkit-box-shadow: inset 0px 5px 5px #e5f4ff, 0 0 3px #0091d5; box-shadow: inset 0px 5px 5px #e5f4ff, 0 0 3px #0091d5; }
    .kf-ablity ul li:hover p { color: #0091d5; }
    .kf-ablity ul li p { font-size: 18px; color: #333; margin-top: 10px; }
    .sj-data { position: absolute; top: 50%; margin-top: -80px; left: 50%; margin-left: -570px; }
    .sj-data ul { }
    .sj-data ul li { color: #fff; width: 33.333%; float: left; position: relative; text-align: center; }
    .sj-data ul li h3 { font-size: 24px; }
    .sj-data ul li p { line-height: 34px; margin-top: 10px; }
    .sj-data ul li .dbtn { line-height: 40px; display: inline-block; width: 160px; height: 40px; text-align: center; border-radius: 5px; font-size: 16px; border: 1px solid #0091d5; margin: 0px 25px; color: #0091d5; margin-top: 60px; }
    .sj-data ul li a:hover{  background: #767d84;background: rgba(255, 255, 255, .3);color: #fff;}
    .sj-data ul li .icon { position: absolute; top: 33px; right: -30px; }
    .hz-hzlogo { position: absolute; top: 50%; margin-top: -70px; left: 50%; margin-left: -570px; }
    .hz-hzlogo { }
    .hz-hzlogo ul { width: 1200px; }
    .hz-hzlogo ul li { float: left; margin-right: 28px; margin-bottom: 28px; }
    .hz-hzlogo ul li a { display: block; background: #fff; border: 1px solid #d9d9d9; border-radius: 10px; }
    .hz-hzlogo ul li a img { width: 262px; }
    #maindiv .section .hide { display: none; }
    @-webkit-keyframes moveFromLeftFade {
        from { opacity: 0; -webkit-transform: translateX(-100%); -moz-transform: translateX(-100%); -ms-transform: translateX(-100%); transform: translateX(-100%); }
    }
    @-moz-keyframes moveFromLeftFade {
        from { opacity: 0; -webkit-transform: translateX(-100%); -moz-transform: translateX(-100%); -ms-transform: translateX(-100%); transform: translateX(-100%); }
    }
    @-ms-keyframes moveFromLeftFade {
        from { opacity: 0; -webkit-transform: translateX(-100%); -moz-transform: translateX(-100%); -ms-transform: translateX(-100%); transform: translateX(-100%); }
    }
    @keyframes moveFromLeftFade {
        from { opacity: 0; -webkit-transform: translateX(-100%); -moz-transform: translateX(-100%); -ms-transform: translateX(-100%); transform: translateX(-100%); }
    }
    @keyframes moveFromRightFade {
        from { opacity: 0; -webkit-transform: translateX(100%); -moz-transform: translateX(100%); -ms-transform: translateX(100%); transform: translateX(100%); }
    }
    @-webkit-keyframes moveFromRightFade {
        from { opacity: 0; -webkit-transform: translateX(100%); -moz-transform: translateX(100%); -ms-transform: translateX(100%); transform: translateX(100%); }
    }
    @-moz-keyframes moveFromRightFade {
        from { opacity: 0; -webkit-transform: translateX(100%); -moz-transform: translateX(100%); -ms-transform: translateX(100%); transform: translateX(100%); }
    }
    @-ms-keyframes moveFromRightFade {
        from { opacity: 0; -webkit-transform: translateX(100%); -moz-transform: translateX(100%); -ms-transform: translateX(100%); transform: translateX(100%); }
    }
    @keyframes moveFromTopFade {
        from { opacity: 0; -webkit-transform: translateY(-100%); -moz-transform: translateY(-100%); -ms-transform: translateY(-100%); transform: translateY(-100%); }
    }
    @-webkit-keyframes moveFromTopFade {
        from { opacity: 0; -webkit-transform: translateY(-100%); -moz-transform: translateY(-100%); -ms-transform: translateY(-100%); transform: translateY(-100%); }
    }
    @-moz-keyframes moveFromTopFade {
        from { opacity: 0; -webkit-transform: translateY(-100%); -moz-transform: translateY(-100%); -ms-transform: translateY(-100%); transform: translateY(-100%); }
    }
    @-ms-keyframes moveFromTopFade {
        from { opacity: 0; -webkit-transform: translateY(-100%); -moz-transform: translateY(-100%); -ms-transform: translateY(-100%); transform: translateY(-100%); }
    }
    @keyframes moveFromBottomFade {
        from { opacity: 0; -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%); }
    }
    @keyframes moveFromBottomFade {
        from { opacity: 0; -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%); }
    }
    @-webkit-keyframes moveFromBottomFade {
        from { opacity: 0; -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%); }
    }
    @-moz-keyframes moveFromBottomFade {
        from { opacity: 0; -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%); }
    }
    @-ms-keyframes moveFromBottomFade {
        from { opacity: 0; -webkit-transform: translateY(100%); -moz-transform: translateY(100%); -ms-transform: translateY(100%); transform: translateY(100%); }
    }
    .animate-moveFromLeftFade { -webkit-animation: moveFromLeftFade .7s ease both; -moz-animation: moveFromLeftFade .7s ease both; -ms-animation: moveFromLeftFade .7s ease both; animation: moveFromLeftFade .7s ease both; }
    .animate-moveFromRightFade { -webkit-animation: moveFromRightFade .7s ease both; -moz-animation: moveFromRightFade .7s ease both; -ms-animation: moveFromRightFade .7s ease both; animation: moveFromRightFade .7s ease both; }
    .animate-moveFromTopFade { -webkit-animation: moveFromTopFade .7s ease both; -moz-animation: moveFromTopFade .7s ease both; -ms-animation: moveFromTopFade .7s ease both; animation: moveFromTopFade .7s ease both; }
    .animate-moveFromBottomFade { -webkit-animation: moveFromBottomFade .7s ease both; -moz-animation: moveFromBottomFade .7s ease both; -ms-animation: moveFromBottomFade .7s ease both; animation: moveFromBottomFade .7s ease both; }

    /* animation delay classes */
    .animate-delay100 { -webkit-animation-delay: .1s; -moz-animation-delay: .1s; -ms-animation-delay: .1s; animation-delay: .1s; }
    .animate-delay180 { -webkit-animation-delay: .18s; -moz-animation-delay: .18s; -ms-animation-delay: .18s; animation-delay: .18s; }
    .animate-delay200 { -webkit-animation-delay: .2s; -moz-animation-delay: .2s; -ms-animation-delay: .2s; animation-delay: .2s; }
    .animate-delay300 { -webkit-animation-delay: .3s; -moz-animation-delay: .3s; -ms-animation-delay: .3s; animation-delay: .3s; }
    .animate-delay400 { -webkit-animation-delay: .4s; -moz-animation-delay: .4s; -ms-animation-delay: .4s; animation-delay: .4s; }
    .animate-delay500 { -webkit-animation-delay: .5s; -moz-animation-delay: .5s; -ms-animation-delay: .5s; animation-delay: .5s; }
    .animate-delay700 { -webkit-animation-delay: .7s; -moz-animation-delay: .7s; -ms-animation-delay: .7s; animation-delay: .7s; }
    .animate-delay1000 { -webkit-animation-delay: 1s; -moz-animation-delay: 1s; -ms-animation-delay: 1s; animation-delay: 1s; }
    .animate-delay1500 { -webkit-animation-delay: 1.5s; -moz-animation-delay: 1.5s; -ms-animation-delay: 1.5s; animation-delay: 1.5s; }
    .animate-delay2000 { -webkit-animation-delay: 2s; -moz-animation-delay: 2s; -ms-animation-delay: 2s; animation-delay: 2s; }
    .animate-delay2500 { -webkit-animation-delay: 2.5s; -moz-animation-delay: 2.5s; -ms-animation-delay: 2.5s; animation-delay: 2.5s; }
    .animate-delay3000 { -webkit-animation-delay: 3s; -moz-animation-delay: 3s; -ms-animation-delay: 3s; animation-delay: 3s; }

</style>




<div id="maindiv">

    <div class="section section1">

        <div class="bg"><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-bg.jpg"/></div>

        <div class="p1-txt ">
            <h1 class="animate-delay200 animate-moveFromTopFade">大楚区域门户<em>云数据平台</em></h1>
            <h3 class="animate-delay700 animate-moveFromTopFade">一个用户中心,多个运营组件,配套积分体系!</h3>
            <?php if(!$this->member){?>
            <a href="<?php echo $this->createUrl('/member/regone'); ?>" class="linear animate-delay1000 animate-moveFromTopFade">立即注册</a>
            <?php }?>
        </div>
    </div>

    <!--section1 end-->

    <div class="section section2">

        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon.png"/></i>业务范围
        </div>

        <div class="yw-list w1140">
            <ul>
                <li>
                    <div class="yw-listdiv animate-delay200 animate-moveFromTopFade">
       	  	    		<span class="c1">
       	  	    			<i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img3.png"/></i>
       	  	    			<h3>积分商城</h3>
       	  	    			<h4>统一体系，通存通兑</h4>
       	  	    		</span>

                        <p>13<i>个</i></p>

                        <div class="bline c1"></div>
                        <?php if($this->member){?>
                        <a class="linear" href="<?php echo $this->createUrl('/project/prolist');?>">立即查看</a>
                        <?php }else{?>
                        <a class="linear activity_pclogin"  href="javascript:;">登录查看</a>
                        <?php }?>
                    </div>
                </li>

                <li>
                    <div class="yw-listdiv animate-delay400 animate-moveFromTopFade">
       	  	    		<span class="c2">
       	  	    			<i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img2.png"/></i>
       	  	    			<h3>活动组件</h3>
       	  	    			<h4>积分聚拢，散落用户</h4>
       	  	    		</span>

                        <p>45<i>个</i></p>

                        <div class="bline c2"></div>
                        <?php if($this->member){?>
                            <a class="linear" href="<?php echo $this->createUrl('/project/prolist');?>">立即查看</a>
                        <?php }else{?>
                            <a class="linear activity_pclogin" href="javascript:;">登录查看</a>
                        <?php }?>
                    </div>
                </li>

                <li>
                    <div class="yw-listdiv animate-delay700 animate-moveFromTopFade">
       	  	    		<span class="c3">
       	  	    			<i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img1.png"/></i>
       	  	    			<h3>城市服务</h3>
       	  	    			<h4>民生服务，家庭链条</h4>
       	  	    		</span>

                        <p>137<i>个</i></p>

                        <div class="bline c3"></div>
                        <?php if($this->member){?>
                            <a class="linear" href="<?php echo $this->createUrl('/project/prolist');?>">立即查看</a>
                        <?php }else{?>
                            <a class="linear activity_pclogin" href="javascript:;">登录查看</a>
                        <?php }?>
                    </div>
                </li>
            </ul>

        </div>

    </div>

    <!--section2 end-->

    <div class="section section3">

        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_03.png"/></i>核心业务
        </div>

        <div class="yw1-list w1140">
            <ul>
                <li>
                    <div class="yw1-listdiv">
                        <img class="animate-delay400 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img5.png"/>
                        <p class="animate-delay700 animate-moveFromTopFade">开放平台的商户可以通过创建应用来生成APPID及秘钥<br />就可以在此添加组件(如：签到，报名，日历等)</p>
                        <a class="linear animate-delay1500 animate-moveFromTopFade" href="<?php echo $this->createUrl('/project/prolist');?>">活动组件</a>
                        <a class="a1 linear  animate-delay1500 animate-moveFromTopFade" href="<?php echo $this->createUrl('/project/prolist');?>">创建应用</a>
                    </div>
                </li>
                <li>
                    <div class="yw1-listdiv">
                        <img class="animate-delay400 animate-moveFromRightFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img4.png"/>
                        <p class="animate-delay700 animate-moveFromTopFade">通过登录签到、报名、投票、分享、游戏、抽奖等互动<br />活动上到积分商城里，用户获取积分兑换相应奖品。</p>
                        <a class="animate-delay1500 linear  animate-moveFromTopFade" href="<?php echo $this->createUrl('/project/prolist');?>">城市服务</a>
                        <a class="a1 linear  animate-delay1500 animate-moveFromTopFade" href="<?php echo $this->createUrl('/project/prolist');?>">积分商城</a>
                    </div>
                </li>
            </ul>

        </div>

    </div>

    <!--section3 end-->


    <div class="section section4" style="min-height: 600px;">

        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_07.png"/></i>平台概述
        </div>

        <div class="pt-about1"></div>
        <div class="pt-about w1140">
            <img class="img1 animate-delay200 animate-moveFromBottomFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img6.png"/>
            <img class="img2 animate-delay1000 animate-moveFromTopFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img7.png"/>
            <img class="img3 animate-delay700 animate-moveFromRightFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img8.png"/>
        </div>
    </div>
    <!--section4 end-->
    <div class="section section5">

        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_11.png"/></i>用户体系
        </div>
        <div class="yh-about w1140">
            <img class="img1 animate-delay200 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img9.png"/>
            <img class="img2 animate-delay400 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img12.png"/>
            <img class="img3 animate-delay700 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img10.png"/>
            <img class="img4 animate-delay1000 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img13.png"/>
            <img class="img5 animate-delay1500 animate-moveFromLeftFade" src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-img11.png"/>
        </div>

    </div>
    <!--section5 end-->
    <div class="section section6">


        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_15.png"/></i>开放能力
        </div>

        <div class="kf-ablity clearfix w1140">
            <ul>
                <li class="animate-delay200 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img1.png"></span>
                        <p>海量用户</p>
                    </a>
                </li>

                <li class="animate-delay400 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img2.png"></span>
                        <p>账号体系</p>
                    </a>
                </li>
                <li class="animate-delay700 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img3.png"></span>
                        <p>积分体系</p>
                    </a>
                </li>
                <li class="animate-delay1000 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img4.png"></span>
                        <p>数据收集</p>
                    </a>
                </li>
                <li class="animate-delay1500 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img5.png"></span>
                        <p>行为分析</p>
                    </a>
                </li>
                <li class="animate-delay2000 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <span><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-ablity-img6.png"></span>
                        <p>构建画像</p>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <!--section6 end-->
    <div class="section section7">


        <div class="bg"><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/ad-index-bg1.jpg"/></div>
        <div class="title w1140" style="border-bottom: 1px solid #6f6f6f; color: #fff;">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_19.png"/></i>数据留存
        </div>

        <div class="sj-data w1140 clearfix">
            <ul>
                <li class="animate-delay200 animate-moveFromBottomFade">
                    <h3>数据收集</h3>
                    <p>行为数据,通过城市服务产生的缴<br>费记录，以及相关服务信息</p>
                    <a class="linear dbtn" href="<?php echo $this->createUrl('/project/prolist');?>">查看更多</a>
                    <i class="icon"><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-data-img2.png"></i>
                </li>
                <li class="animate-delay400 animate-moveFromBottomFade">
                    <h3>行为分析</h3>
                    <p>根据前期采集的数据进行标<br>签分类，及关联运算</p>
                    <a class="linear dbtn" href="<?php echo $this->createUrl('/project/prolist');?>">查看更多</a>
                    <i class="icon"><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-data-img2.png"></i>
                </li>

                <li class="animate-delay700 animate-moveFromBottomFade">
                    <h3>构建画像</h3>
                    <p>基本属性，行为特征购买能<br>力，对前期结果分析</p>
                    <a class="linear dbtn" href="<?php echo $this->createUrl('/project/prolist');?>">查看更多</a>

                </li>
            </ul>
        </div>

    </div>
    <!--section7 end-->
    <div class="section section8" style="min-height: 600px;">

        <div class="bg"></div>
        <div class="title w1140">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-title-icon_23.png"/></i>合作伙伴
        </div>


        <div class="ad-bg ad-foot-bg">
            <div class="ad-app-foot clearfix w1000">
                <div class="fl ad-app-footl">
                    <ul>
                        <li><a href="javascript:;">关于平台</a></li>
                        <li><a href="javascript:;">应用管理</a></li>
                        <li><a href="javascript:;">文档中心</a></li>
                        <li><a href="javascript:;">帮助问答</a></li>
                        <li><a href="javascript:;">意见反馈</a></li>
                        <li><a href="javascript:;">联系我们</a></li>
                    </ul>
                    <p>Copyright © 1998 - 2016 Tencent. All Rights Reserved. 腾讯·大楚网·版权所有 鄂ICP备15021300号 <a>网站统计</a></p>
                </div>
                <div class="fr ad-app-footr">
                    <img src="<?php echo $this->_theme_url; ?>assets/images/ad-tel-icon.png" height="49" width="49" alt="">
                <span>
						<p>400-888-5555</p>
						<em>电话（工作日  9:00-18:00）</em>
					</span>
                </div>
            </div>
        </div>


        <div class="hz-hzlogo">

            <ul>
                <li class="animate-delay200 animate-moveFromTopFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img1.png">
                    </a>
                </li>
                <li class="animate-delay400 animate-moveFromTopFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img2.png">
                    </a>
                </li>
                <li class="animate-delay700 animate-moveFromTopFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img3.png">
                    </a>
                </li>
                <li class="animate-delay1000 animate-moveFromTopFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img4.png">
                    </a>
                </li>
                <li class="animate-delay200 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img5.png">
                    </a>
                </li>
                <li class="animate-delay400 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img6.png">
                    </a>
                </li>
                <li class="animate-delay700 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img7.png">
                    </a>
                </li>
                <li class="animate-delay1000 animate-moveFromBottomFade">
                    <a href="javascript:;">
                        <img src="<?php echo $this->_theme_url; ?>assets/images/indeximg/d-hzlogo-img8.png">
                    </a>
                </li>
            </ul>

        </div>



    </div>
    <!--section8 end-->




</div>
</body>

</html>
