<?php  echo $this->renderpartial('/common/header_new',$config); ?>

<!--top end-->

<style>
    a:hover{color: #9bc200!important;}
    strong{ font-weight: normal;}
    body{ line-height: 1.5;}
    .d-servicemain1 ul li .btn1:hover, .d-data1 ul li .dbtn:hover {background: #9BC200;color: #FFFFFF!important;}
    .d-banner-txt h1 {font-size: 72px;margin: 0;}
    .d-top-head .login .btn1:hover, .d-banner-txt .dbtn:hover {border: 1px solid #9bc200;background: #9BC200;color: #FFFFFF!important;}
    .d-top-head .nav ul li a:hover{    color: #97ff00!important;}
    .d-servicemain1 ul li a,.d-title .dbtn,.d-data1 ul li .dbtn {
    line-height: 36px;}
</style>

<div class="d-bg d-banner">
            <div class="w1140 d-banner-txt">
                <h1>大楚区域门户<strong>云数据平台</strong></h1>
                <h4>转向随心所欲的应用创建</h4>

                <?php if(!$this->member){?>
                    <a class="linear dbtn btn-hover1" href="<?php echo $this->createUrl('/member/regone'); ?>">立即注册</a>
                <?php }?>
            </div>
        </div>

        <div class="d-bg d-ededed-bg clearfix">
            <div class="d-servicemain w1140 mgb40 mgt40">

                <div class="d-title clearfix mgb40">
                    <i><img src="/assets/index/images/d-title-icon_03.png"/></i>
                    <h3>核心业务</h3>
                    <em>用户平台的核心业务</em>
                    <!--<a class="linear fr dbtn" href="">
                    了解详情
                </a>-->
                </div>

                <div class="d-servicemain1 clearfix w1140">
                    <span><img src="/assets/index/images/d-servicemain-img1.png"/></span>
                    <ul>
                        <li>
                            <p>开放平台的商户可以通过创建应用来生成APPID及秘钥<br />就可以在此添加组件(如：签到，报名，日历等)</p>
                            <a class="linear btn1" href="">活动组件</a>
                            <a class="linear btn2" href="">创建应用</a>
                        </li>
                        <li>
                            <p>通过登录签到、报名、投票、分享、游戏、抽奖等互动<br />活动上到积分商城里，用户获取积分兑换相应奖品。</p>
                            <a class="linear btn1" href="">城市服务</a>
                            <a class="linear btn2" href="">积分商城</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        <div class="d-bg d-f7f7f7-bg clearfix">
            <div class="d-service w1140 mgb40 mgt40">

                <div class="d-title clearfix">
                    <i><img src="/assets/index/images/d-title-icon.png"/></i>
                    <h3>业务范围</h3>
                    <em>用户平台的业务范围</em>
                    <a class="linear fr dbtn" href="">
                        了解详情
                    </a>
                </div>

                <div class="d-service1 clearfix">
                    <ul>
                        <li>
                            <img src="/assets/index/images/d-data-bg1.png" />
                            <h4>积分商城</h4>
                            <p>统一体系，通存通兑</p>
                            <span><i>35,454</i><font>个</font></span>
                        </li>

                        <li>
                            <img src="/assets/index/images/d-data-bg2.png" />
                            <h4>活动组件</h4>
                            <p>积分聚拢，散落用户</p>
                            <span><i>68</i><font>个</font></span>
                        </li>

                        <li>
                            <img src="/assets/index/images/d-data-bg3.png" />
                            <h4>城市服务</h4>
                            <p>民生服务，家庭链条</p>
                            <span><i>412,54</i><font>个</font></span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        <div class="d-bg d-ededed-bg clearfix">
            <div class="d-title clearfix w1140 mgt40">
                <i><img src="/assets/index/images/d-title-icon_07.png"/></i>
                <h3>平台概述 </h3>
                <em>用户数据沉淀，提供上传下拉</em>
                <!--<a class="linear fr dbtn" href="">
                    了解详情
                </a>-->
            </div>

            <div class="d-about1 clearfix w1140">
                <span class="s1 fl"><img src="/assets/index/images/d-about-bg2.png"/></span>
                <span class="s3 fr"><img src="/assets/index/images/d-about-bg1.png"/></span>
                <span class="s2">
                    <p>
                    1. 帮助大楚网旗下的公众号及应用建立统一的用户体系；<br />
                    2. 提供公众号及应用运营人员相关活动的组件功能；<br />
                    3. 聚拢散落的大楚网用户，实现单点登录，通过运营增加用户粘性；<br />
                    4. 通过接入城市民生服务，打造家庭关系链；<br />
                    5. 通过对用户中心沉淀的用户数据挖掘，进行精准的广告投放。
                    </p>
                    
                </span>
            </div>

        </div>

        <div class="d-bg d-f7f7f7-bg clearfix">
            <div class="d-userinfo w1140 mgb40 mgt40">

                <div class="d-title clearfix mgb40">
                    <i><img src="/assets/index/images/d-title-icon_11.png"/></i>
                    <h3>用户体系</h3>
                    <em>用户登录体系、接入平台，数据中心、广告营收</em>
                    <a class="linear fr dbtn" href="">
                        了解详情
                    </a>
                </div>

                <div class="d-userinfo1">
                    <span><img src="/assets/index/images/d-userinfo-img1.png"/></span>
                </div>

            </div>

        </div>

        <div class="d-bg d-ededed-bg clearfix">
            <div class="d-ablity w1140 mgb40 mgt40">

                <div class="d-title clearfix mgb40">
                    <i><img src="/assets/index/images/d-title-icon_15.png"/></i>
                    <h3>开放能力</h3>
                    <em>开放平台的专属优势</em>
                    <a class="linear fr dbtn" href="">
                        了解详情
                    </a>
                </div>

                <div class="d-ablity1 clearfix">
                    <ul>
                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img1.png"/></span>
                                <p>海量用户</p>
                            </a>
                        </li>

                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img2.png"/></span>
                                <p>账号体系</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img3.png"/></span>
                                <p>积分体系</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img4.png"/></span>
                                <p>数据收集</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img5.png"/></span>
                                <p>行为分析</p>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span><img src="/assets/index/images/d-ablity-img6.png"/></span>
                                <p>构建画像</p>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        <div class="d-bg d-data-bg clearfix">
            <div class="d-data w1140 mgb40 mgt40">

                <div class="d-title clearfix mgb40">
                    <i><img src="/assets/index/images/d-title-icon_19.png"/></i>
                    <h3>数据留存</h3>
                    <em>将数据进行精准的数据储存</em>
                    <a class="linear fr dbtn" href="">
                        了解详情
                    </a>
                </div>

                <div class="d-data1 clearfix">
                    <ul>
                        <li>
                            <h3>数据收集</h3>
                            <p>行为数据,通过城市服务产生的缴<br />费记录，以及相关服务信息</p>
                            <a class="linear dbtn" href="">查看更多</a>
                            <i class="icon"><img src="/assets/index/images/d-data-img2.png"/></i>
                        </li>
                        <li>
                            <h3>行为分析</h3>
                            <p>根据前期采集的数据进行标<br />签分类，及关联运算</p>
                            <a class="linear dbtn" href="">查看更多</a>
                            <i class="icon"><img src="/assets/index/images/d-data-img2.png"/></i>
                        </li>

                        <li>
                            <h3>构建画像</h3>
                            <p>基本属性，行为特征购买能<br />力，对前期结果分析</p>
                            <a class="linear dbtn" href="">查看更多</a>

                        </li>
                    </ul>
                </div>

            </div>

        </div>

        <div class="d-bg d-ededed-bg clearfix">
            <div class="d-hzlogo w1140  mgt40">

                <div class="d-title clearfix mgb40">
                    <i><img src="/assets/index/images/d-title-icon_23.png"/></i>
                    <h3>合作伙伴 </h3>
                    <em>广大合作商的首要选择</em>
                    <a class="linear fr dbtn" href="">
                        了解详情
                    </a>
                </div>

                <div class="d-hzlogo1">

                    <ul>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img1.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img2.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img3.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img4.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img5.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img6.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img7.png" />
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="/assets/index/images/d-hzlogo-img8.png" />
                            </a>
                        </li>
                    </ul>

                </div>

            </div>

        </div>

        <div class="d-bg d-foot-bg">
            <div class="d-foot w1200">
                <ul>
                    <li>
                        <a href="#">联系我们</a>
                    </li>|
                    <li>
                        <a href="#">用户中心</a>
                    </li>|
                    <li>
                        <a href="#">认证空间</a>
                    </li>|
                    <li>
                        <a href="#">官方微博</a>
                    </li>|
                    <li>
                        <a href="#">在线服务</a>
                    </li>|
                    <li>
                        <a href="#">反馈建议</a>
                    </li>
                </ul>
                <p>Copyright © 1998 - 2016 Tencent. All Rights Reserved. 腾讯·大楚网 版权所有</p>
            </div>

        </div>

      

</body>

</html>