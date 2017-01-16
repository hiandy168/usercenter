<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>后台首页</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
                <script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
 </head>
 <body>
 <style>
body{color:#444444}
.box{float:left;border: 1px solid #C2D1D8;width:600px;margin:10px;}
.box .title{font-weight:700;border-bottom: 1px solid #C2D1D8;color: #3A6EA5;height: 26px;line-height: 28px;padding: 0 10px;}
.box p{height:22px;line-height:22px;padding:0 10px;}
 </style>
<div class='bgf clearfix'>
              
<div class="box" >
<div class="title">登录信息</div>
<p></p>
<p>当前登录用户：<?php echo $member_info['name']?> 用户角色：<?php  echo $group[$member_info['group_id']]['name']?>&nbsp;&nbsp;</p>
<p></p>
</div>
    

<div class="box" >
<div class="title">系统信息</div>
<p>操作系统:<?php echo (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')?"Windows":"Linux";?></p>
<p>服务器环境:<?php echo $_SERVER['SERVER_SOFTWARE']?></p>
<p>最大上传大小限制:<?php echo ini_get('upload_max_filesize')?></p>
<p>mysql版本:<?php echo $mysql_version?></p>
<p >Safe Mode:<?php echo (boolean) ini_get('safe_mode') ? '是':'否';?></p>
<p>Safe Mode ID:<?php echo (boolean) ini_get('safe_mode_gid') ? '是':'否';?></p>
<p>GD库支持:<?=$gd?></p>
<p>剩余空间:<?php echo round((@disk_free_space(".")/(1024*1024)),2).'M'?></p>
</div>

    
<div class="box" >
<div class="title">发开团队</div>
<p>版权所有：www.9open.com</p>
<p>程序员QQ：5367604</p>
<p>官网：www.9open.com</p>
</div>
    

</div>    
</body>
</html>
