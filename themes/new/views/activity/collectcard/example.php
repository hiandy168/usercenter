<?php echo $this->renderpartial('/common/header_new', $config); ?>
    <style>
        .ceil_thumbs li {
            float: left;
            width: 77px;
            height: 77px;
            border: 1px solid #e2e2e2;
            background-size: cover;
            margin-right: 10px;
            position: relative;
            background-image: url( <?php echo $this->_theme_url."assets/images/d-data-img2.png"?>)
        }

        .ceil_thumbs li input[type=file] {
            opacity: 0;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .ceil_thumbs li:before, .ceil_thumbs li:after {
            content: " ";
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            background-color: #D9D9D9;
        }
    </style>

    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $config['pid'])) ?>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jqueryform.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/laydate/laydate.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>

    <!--act nav-->
    <div class="ad-act-list  bxbg  ">
      <!--   <div class="ad-app-list-tit ">
            <div class="fl tl">
                <h3>编辑活动</h3>
            </div>
            <div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>
        </div> -->
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-navsd">
                <ul>
                   <li  >
                        <a href="<?php echo $this->createUrl('/activity/collectcard/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                    </li>
                    <li  class="selected">
                        <a href="<?php echo $this->createUrl('/activity/collectcard/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                    </li>
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">

             

                 <style type="text/css">
                .dail-formdiv1 { margin: 0px 0px 50px 50px; }
.dail-formdiv1 h3 { font-size: 16px; color: #008bcc; font-weight: bold; border-left: 2px solid #008bcc; padding-left: 10px; }
.dail-formdiv1 .tips { padding: 10px 20px; background: #eaf8ff; color: #7f7f7f; border: 1px solid #55c9ff; border-radius: 5px; margin: 20px 66px 20px 0px; }
.dail-formdiv1 .tips em { display: inline-block; float: left; color: #ff4141; }
.dail-formdiv1 .tips p { display: block; margin-left: 50px; color: #999; font-size: 12px; line-height: 24px; }
.dail-upimg { }
.dail-upimg ul li { margin-bottom: 40px; }
.dail-upimgl { position: relative; width: 150px; height: 150px; background: #fff; border-radius: 5px; border: 1px solid #dedede; }
.dail-upimgl:before { content: ""; display: block; width: 80px; height: 0px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -1px; margin-left: -40px; }
.dail-upimgl:after { content: ""; display: block; width: 0px; height: 80px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -40px; margin-left: -1px; }
.dail-upimgr { margin-left: 200px; margin-right: 66px; }
.dail-upimgr img { height: 150px; float: left; }
.dail-upimgr span { display: block; float: left; margin-left: 40px; width: 300px; }
.dail-upimgr span p { display: inline-block; }
.dail-upimgr span h4 { color: #008bcc; margin-bottom: 20px; }
.s_num{        border-bottom: 1px solid #c1c1c1;
    padding-bottom: 30px;
    margin-bottom: 10px;
    width: 93%;}
.s_num .form-control{ width:97%}    
.s_num .t_title{padding: 10px 0px;}  
.s_num .delbtn{display: inline-block;
    float: right;
    width: 10%;
    height: 30px;
    line-height: 30px;
    text-align: center;
    position: relative;
    top: -5px;}  
            </style>    

                <!--right form-->


                <!--right form-->
                <style>
                    .add-tags {
                        margin-top: 5px;
                    }

                    .add-tags label {
                        display: inline-block;
                        margin-right: 15px;
                        cursor: pointer;
                        margin-bottom: 5px;
                    }

                    .add-tags label input {
                        margin: 0;
                        position: relative;
                        top: 2px;
                    }

                    .add-tags label i {
                    }
                </style>

              <!--   <div class="ad-view-app-1 ad-edit-app-condiv clearfix">

                    <div class="ad-view-app-sx"><a href=""><i><img
                                    src="<?php echo $this->_theme_url; ?>assets/images/ad-act-reflash-icon.png"/></i>刷新</a>
                    </div>

                    <div class="ad-view-app-code">
                        <?php if ($activity_info['id']) { ?>
                            <img
                                src="http://qr.topscan.com/api.php?text=<?php echo $this->_siteUrl . '/activity/collectcard/view/id/' . $activity_info['id'] ?>"
                                width="150" height="150"/>
                        <?php } else { ?>
                            <img src="http://qr.topscan.com/api.php?text=http://m.dachuw.net/h5" width="150"
                                 height="150"/>
                        <?php } ?>
                        <p>扫码在移动设备上<br/>体验效果更加</p>
                    </div>


                    <div class="ad-view-app-main">


                        <img class="phonebg" src="<?php echo $this->_theme_url; ?>assets/images/ad-act-phone-bg.png"/>

                        <div class="ad-view-app-maindiv">
                            <?php if ($activity_info['id']) { ?>
                                <iframe
                                    src="<?php echo $this->createUrl('/activity/collectcard/view', array('id' => $activity_info['id'])) ?>"
                                    scrolling="yes" width="" height=""></iframe>
                            <?php } else {
                                if ($status['see_status'] == 1) {
                                    echo "PC";
                                } else if ($status['see_status'] == 2) {
                                    echo "weixin";
                                } else {
                                    echo "all";
                                } ?>
                                <iframe src="http://m.dachuw.net/h5" width="" height=""></iframe>
                            <?php } ?>
                        </div>

                    </div>


                </div> -->

                <!--view end-->

                <div class="ad-example-app-1 ad-edit-app-condiv clearfix" style="display:block">


                    <div class="ad-example-app-2">
                        <ul>
                            <li><span>开发者示例：</span>
                                <em>&nbsp;</em>
                                <i></i>
                            </li>
                            <li>
<pre name="code" class="c-sharp">
include 'Dachuw.php';
$dachu=new Dachu('aapid','appsercert');
//项目的用户的唯一标识符;
$openid= '***';
//$redirect = $dachu->getMemberUrl();//获取会员中心URL
$redirect   =   'http://m.dachuw.net/activity/collectcardcard/view/id/<?php echo $_GET['fid'] ?>';
//获取自动登录URL
$url        = $dachu->buildAutoLoginRequest($openid,$redirect);
//跳转
$dachu->redirect($url);
</pre>
                            </li>
                            <!--                            <li><span>URL<b style="visibility: hidden;">方式</b>：</span>
                                                            <em>http://m.hb.qq.com/activity/SignUp/index/id/$id</em>
                                                            <i></i>
                                                        </li>-->
                            <!--                            <li><span>传入参数：</span>-->
                            <!--                                <em>openid : 微信用户的openid</em>-->
                            <!--                            </li>-->
                        </ul>

                        <a href="/dachu/activity_sdk.zip" class="demo-down linear adbtn">DEMO下载</a>

                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        function upload(id) {
            document.getElementById(id).click();
        }
    </script>



<?php echo $this->renderpartial('/common/footer', $config); ?>