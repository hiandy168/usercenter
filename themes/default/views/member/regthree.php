<?php echo $this->renderpartial('/common/header_new',$config); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.SuperSlide.js"></script>

    <!-- 注册成功 start-->

    
    <div class="lo_content">
    <div class="lo_box">
        <ul>
            <li>第一步：创建账户<span></span></li>
            <li>第二步：完善信息<span></span></li>
            <li class="lo_style lo2">第三步：注册成功</li>
        </ul>
        <div class="register-ok">
                    <div class="done">
                        <img src="<?php echo $this->_theme_url; ?>images/03_03.png" alt="">
                    </div>
                    <div class="done-l l">
                        恭喜你，成功注册大楚开放平台，请等待审核通过！
                    </div>
        </div>
        
    </div>
    </div>
    
    
    
    
  
    <!-- 注册成功 start-->
    <!-- 底部样式 start -->
    <div class="foot">
        <div class="w980">
            <ul class="clearfix">
                                        <li><a href="http://www.qq.com" title="关于我们" target="_blank">关于我们</a></li>
                        <li><a href="http://www.qq.com" title="关于腾讯" target="_blank">关于腾讯</a></li>
                        <li><a href="http://www.qq.com" title="服务协议" target="_blank">服务协议</a></li>
                        <li><a href="http://www.qq.com" title="隐私政策" target="_blank">隐私政策</a></li>
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
        $(".add_components .slider_show .bd .item").hover(function() {

            $(this).addClass('hover');

            var index = $(this).index();

            $(this).parents(".slider_show").find('.show_item_info .angle').css({
                'left': 27 + (293 + 8) * index + 'px'
            });

            $(this).parents(".slider_show").find('.show_item_info').show();

        }, function() {
            $(this).removeClass('hover');
            $(this).parents(".slider_show").find('.show_item_info').hide();
        });

        $(".add_components .slider_show").slide({
            mainCell: ".bd ul",
            effect: "left",
            autoPlay: false
        });
    });
    </script>



</body>
</html>