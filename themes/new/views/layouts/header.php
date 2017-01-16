<!--  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php  echo $this->site_title;?>-大楚开放平台</title>
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/index.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>Vonders/Font-Awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/admin.js"></script>
    </head>
<body>-->
<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>

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
                                <a href="<?php echo $this->createUrl('/activity/scratchcard/list',array('pid'=>$this->pid,'active_1'=>1));?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_1==1){echo 'zj_5_hover.jpg'; echo '" class="mark_hover"';}else{echo 'zj_5.jpg';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/zj_5_hover.jpg">
                                <div class="text">刮刮卡</div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/pccheckin/list',array('pid'=>$this->pid,'acitvie_2'=>1)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_2==1){echo 'fp_hover.jpg';  echo '" class="mark_hover"';}else{echo 'fp.png';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/fp_hover.jpg">
                                <div class="text">签到</div>
                                </a>
                            </div>                            
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/signup/signupList',array('pid'=>$this->pid)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_3==1){echo 'zj_zxbm_hover.jpg';  echo '" class="mark_hover"';}else{echo 'zj_zxbm.png';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/zj_zxbm_hover.jpg">
                                <div class="text">报名</div>
                                </a>
                            </div>

                        </div>
                    </li>
                </ul>
            </div>
			<script>
				var img, hover_image;
				$(".components .left .item_wrap .item").find('img').hover(function(){
					if($(this).hasClass("mark_hover")) {
						return false;
					}
					
					hover_image = $(this).attr('data-hover');
					img = $(this).attr('src');
					$(this).attr('src', hover_image);
				}, function(){
					if($(this).hasClass("mark_hover")) {
						return false;
					}
					$(this).attr('src', img);
				});
			</script>
            <div class="hd clearfix">
                <ul>
                    <li></li>
                    <!-- <li></li> -->
                </ul>
            </div>
        </div>
    </div>

        <div class="center">
<!--            <div class="title"></div>-->