<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>大楚开放平台</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.placeholder.js"></script>
</head>

<body>
    <!-- 头部导航 start-->
    <?php echo $this->renderpartial('/header/header_pro'); ?>
<!--    <div class="head w1700">-->
<!--        <div class="w980">-->
<!--            <div class="logo">-->
<!--                <a href="#" target="_blank">-->
<!--                    <img src="--><?php //echo $this->_theme_url; ?><!--images/1.png" height="46" width="192">-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="nav_item clearfix">-->
<!--                <div class="item">-->
<!--                    <a href="#" target="_blank">首页</a>-->
<!--                </div>-->
<!--                <div class="item active">-->
<!--                    <a href="#" target="_blank">功能组件</a>-->
<!--                </div>-->
<!--                <div class="item">-->
<!--                    <a href="#" target="_blank">管理中心</a>-->
<!--                </div>-->
<!--                <div class="item">-->
<!--                    <a href="#" target="_blank">文档资料</a>-->
<!--                </div>-->
<!--                <div class="item">-->
<!--                    <a href="#" target="_blank">FAQ</a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="register_login">-->
<!--                <span class="i_1">第一次使用公众平台？</span>-->
<!--                <span class="i_2">-->
<!--                    <a href="#" target="_blank">立即注册</a>-->
<!--                </span>-->
<!--                <span class="i_3">|</span>-->
<!--                <span class="i_4">-->
<!--                    <a href="#" target="_blank">使用帮助</a>-->
<!--                </span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- 头部导航 end-->
    <!-- 组件 start -->
    <div class="components w980 clearfix">
        <div class="left">
            <div class="title">组件</div>
            <div class="slider_show">
                <div class="bd">
                    <ul class="clearfix">
                        <li>
                            <div class="item_wrap">
                                <div class="item">
                                    <img src="<?php echo $this->_theme_url; ?>images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo $this->_theme_url; ?>images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo $this->_theme_url; ?>images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo $this->_theme_url; ?>images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                            </div>
                        </li>
                        <!-- <li>
                            <div class="item_wrap">
                                <div class="item">
                                    <img src="./images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="./images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="./images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                                <div class="item">
                                    <img src="./images/18.png" height="53" width="53">
                                    <div class="text">大转盘</div>
                                </div>
                            </div>
                        </li> -->
                    </ul>
                </div>
                <div class="hd clearfix">
                    <ul>
                        <li></li>
                        <!-- <li></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="center">
            <div class="title">设置</div>
            <div class="content">
                <div class="t_title">关键字<span>（多个关键字请以空格隔开，每个关键字最多15个字）</span></div>
                <div class="input">
                    <input type="text" value="" placeholder="请设置关键字" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动名称<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text" value="" placeholder="请填写活动名称" class="input_text"/>
                     <div class="del"></div>
                </div>
                <div class="t_title">活动简称<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />
                     <div class="del"></div>
                </div>
                 <div class="t_title">活动开始封面</div>
                 <div class="input upload_pic clearfix">
                     <div class="button1">上传图片</div>
                     <div class="button2">抽奖开始</div>
                 </div>
<!--                 <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
<!--                <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
<!--                <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
<!--                <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
<!--                <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
<!--                <div class="t_title">活动简称<span>（1-20个字符）</span></div>-->
<!--                <div class="input">-->
<!--                    <input type="text" value="" placeholder="请填写活动名称" class="input_text" />-->
<!--                     <div class="del"></div>-->
<!--                </div>-->
                <div class="save_button">保存</div>
            </div>
        </div>
        <div class="right">
            <!-- 右边iframe部分 -->
            <div class="content">
                
            </div>
        </div>
    </div>
    <!-- 组件 end -->
    <!-- 底部样式 start -->
    <div class="foot">
        <div class="w980">
            <ul class="clearfix">
                <li>联系我们</li>
                <li>用户中心</li>
                <li>认证空间</li>
                <li>官方微博</li>
                <li>在线客服</li>
                <li>反馈意见</li>
            </ul>
            <div class="copy_right copy_right1">
                Copyright © 1998 - 2016 Tencent. All Rights Reserved.
            </div>
            <div class="copy_right copy_right2">
                腾讯·大楚网 版权所有
            </div>
        </div>
    </div>
    <!-- 底部样式 end -->
    <script type="text/javascript">
    $(document).ready(function() {
        $(".components .slider_show").slide({
            mainCell: ".bd ul",
            effect: "left",
            autoPlay: false
        });
        $(":input[placeholder]").placeholder();

        $(".components .center input").focus(function() {
            var parsent = $(this).parents(".components .center .input");

            $(".components .center .input").find('.del').hide();

            $(".components .center .input").removeClass("focus");

            parsent.addClass("focus");
            parsent.find('.del').show();
        });

        $(".components .center .del").on('click', function() {
            var this_input = $(this).parents(".components .center .input");
            var val = this_input.find('.input_text').val();

            if (val.length > 0) {
                this_input.find('.input_text').val("");
            } else {
                return;
            }
        })
    });
    </script>
</body>

</html>
