<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl;?>/assets/public/css/top.css" />
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/admin.js"></script>
<title>后台管理TOP</title>
</head>

<body>
<div class="top">

<!--<div  class="" style=''><img src='<?php echo $this->_baseUrl;?>/assets/public/images/main_21.gif' height="33"></div>-->
<div class="top_nr">
    <div class="member_mess">当前登录用户：<?php echo $user_info['name']?> 用户角色：<?php  echo $group[$user_info['group_id']]->name?>&nbsp;&nbsp;<a class="logout" style="text-decoration: underline" href="<?php echo Mod::app()->createAbsoluteUrl('admin/login/logout') ?>">退出</a></div>
    <div  class="nav_r">
        <ul >
            <li style="border:1px solid #ddd;padding:0;margin:3px 0 0 0;height:22px;">
            <select name="lang" id='lang' class="lang"  style="padding:0 5px 0 0;margin:0;height:24px;">
            <?php if(!empty($lang_arr)){foreach($lang_arr as $lang){?>
            <option value="<?php echo $lang['dir']?>"  <?php if (isset($this->lang)&&$this->lang==$lang['dir']): ?>selected<?php endif; ?>><?php echo $lang['title']?></option>
            <?php }}?>
            </select>
            </li>
            <li><img src="<?php echo $this->_baseUrl;?>/assets/public/images/top_2.gif" width="14" height="14" /><a target='_blank' href="<?php echo $this->_baseUrl.'/'?>">首页</a></li>
            <li><img src="<?php echo $this->_baseUrl;?>/assets/public/images/top_5.gif" width="14" height="14" /><a href="javascript:;" id="refresh" >刷新</a></li>
            <li><a href="<?php echo Mod::app()->createAbsoluteUrl('admin/login/logout') ?>">退出</a></li>
        </ul>
    </div>
   
    <div class="nav_m">
        <div>
        <ul  class="clearfix">
            <?php if(isset($menu)){$i=1;$num =count($menu);foreach($menu as $k=>$v){ ?>
            <li   <?php if($i==1)echo 'class="active"';  ?>onclick='changeLeft("<?php echo $k; ?>",this)'   ref="<?php echo $v['children'][0]['url']?>"><span  href="#" class="v1"><?php echo $v['title']; ?></span></li>
            <?php $i++;}}?>
        </ul>
            </div>
    </div>
    
   
   
</div>
</div>
 <script type="text/javascript">
var admin_url = "<?php echo $this->_adminUrl;?>";
    $(function(){

        $('select#lang').change(function(){
            var val = $(this).val();
            $.ajax({
            type: "post",
            url: "<?php echo $this->createUrl('/admin/main/changelang');?>",
            data:{lang:val},
            dataType:'json',
            beforeSend: function(){},
            success: function(data){
                    top.location.reload();
                    return false;
            },
            error: function(){ }
            });

        });
    })
</script>
    
 
    
</body>
</html>

    
    
    


    






