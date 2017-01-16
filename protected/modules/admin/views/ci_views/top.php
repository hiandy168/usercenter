<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/top.css')?>" />
<script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
<title>无标题文档</title>
</head>

<body>
<div class="top">
<div  class="logo"><img src="<?php echo base_url('public')?>/images/logo.png"></div>
<!--<div  class="" style=''><img src='<?php echo base_url('public')?>/images/main_21.gif' height="33"></div>-->
<div class="top_nr">
    <div class="member_mess">当前登录用户：<?php echo $member_info['name']?> 用户角色：<?php  echo $group[$member_info['group_id']]['name']?>&nbsp;&nbsp;<a class="logout" style="text-decoration: underline" href="<?php echo admin_url('main/logout')?>">退出</a></div>
    <div  class="nav_r">
        <ul>
            <li><img src="<?php echo base_url('public')?>/images/top_2.gif" width="14" height="14" /><a target='_blank' href="<?php echo base_url()?>">首页</a></li>
            <li><img src="<?php echo base_url('public')?>/images/top_5.gif" width="14" height="14" /><a href="javascript:;" id="refresh" >刷新</a></li>
            <li><a class="logout" href="<?php echo admin_url('main/logout')?>">退出</a></li>
        </ul>
    </div>
   
    <div class="nav_m">
        <div>
        <ul  class="clearfix">
            <?php $i=1;$num =count($menu);foreach($menu as $k=>$v){ ?>
            <li   <?php if($i==1)echo 'class="active"';  ?>onclick='changeLeft("<?php echo $k; ?>",this)'><span  href="#" class="v1"><?php echo $v['title']; ?></span></li>
            <?php $i++;} ?>
        </ul>
            </div>
    </div>
    
<!--     <div class="nav_y">
        <ul>
            <li><img src="<?php echo base_url('public')?>/images/top_8.gif" width="16" height="16" /><a href="#" class="v1">发布信息</a></li>
            <li><img src="<?php echo base_url('public')?>/images/top_9.gif" width="16" height="16" /><a href="#" class="v1">更新缓存</a></li>
            <li><img src="<?php echo base_url('public')?>/images/top_10.gif" width="20" height="20" /><a href="#" class="v1">管理用户</a></li>
       </ul>
    </div>-->
</div>
</div>
 
    
    
<!--           <div  class="nav_daohang">
            <ul>
               <li><a href="<?php echo base_url();?>" target="_blank"><span>浏览站点</span></a>|</li>
               <li><a  href='#' rel="sidebar"  onclick="AddFavorite(window.location,document.title)"><span>收藏后台</span></a>|</li>
               <li><a href="http://www.9open.com" target="_blank"><span>官方网站|技术支持</span></a></li>
            </ul>
      </div>     

         <div  class="nav_main">
            <ul>
               <?php $i=1;$num =count($menu);foreach($menu as $k=>$v){ ?>
                <li  <?php if($i==1)echo 'class="active"';  ?> onclick='changeLeft("<?php echo $k; ?>",this)'><span><?php echo $v['title']; ?></span></li>
               <?php $i++;} ?>
               </ul>
      </div>     -->
    
</body>
</html>
<body
    
    
    


    






