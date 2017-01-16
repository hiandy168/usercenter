<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<body>
<?php echo $this->renderpartial('/common/header_pro',array('active'=>$active,'project_list'=>$project_list,'project_now'=>$project_now)); ?>

<!-- 组件 start -->
<div class="components w980 clearfix" style="width: 1170px;">
    <!--左边开始-->
    <div class="left">
        <div class="title">用户管理</div>
        <ul class="text_list">
            <li <?php if($this->active_1==1){echo 'class="active"';}?>>
                <a href="<?php echo $this->createUrl('/behavior/userlist',array('pid'=>$this->pid));?>">用户列表</a>
                <!--鼠标移动会显示图标-->
                <!--<div class="click_icon clearfix">-->
                    <!--<a href="#" class="icon111"></a>-->
                    <!--<a href="#" class="icon222"></a>-->
                    <!--<a href="#" class="icon333"></a>-->
                <!--</div>-->
            </li>
            <li <?php if($this->active_2==1){echo 'class="active"';}?>>
                <a href="<?php echo $this->createUrl('/behavior/userbehavior',array('pid'=>$this->pid));?>">用户行为</a>
            </li>
        </ul>
    </div>

  <!--左边结束-->
  <div class="center" style="width: 892px;">
            