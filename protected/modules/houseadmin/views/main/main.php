<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl;?>/assets/public/css/main.css" />
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/admin.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/jquery.SuperSlide.2.1.1.js"></script>
<title>后台管理TOP</title>
</head>

<body>
    
<!--start top-->
<div class="top">
<div  class="logo"><img src='<?php echo $this->_baseUrl;?>/assets/logo.png'></div>
<!--<div  class="" style=''><img src='<?php echo $this->_baseUrl;?>/assets/public/images/main_21.gif' height="33"></div>-->
<div class="top_nr">
    <div class="member_mess">当前登录用户：<?php echo $user_info['name']?> 用户角色：<?php  echo $group[$user_info['group_id']]->name?>&nbsp;&nbsp;
        <!--<a class="logout" style="text-decoration: underline" href="<?php echo Mod::app()->createAbsoluteUrl('admin/login/logout') ?>">退出</a>-->
    </div>
    <div  class="nav_r">
        <ul >
            <li><img src="<?php echo $this->_baseUrl;?>/assets/public/images/top_2.gif" width="14" height="14" /><a target='_blank' href="<?php echo $this->_baseUrl.'/'?>">首页</a></li>
            <li><img src="<?php echo $this->_baseUrl;?>/assets/public/images/top_5.gif" width="14" height="14" /><a href="javascript:;" id="refresh" >刷新</a></li>
            <li><a href="<?php echo Mod::app()->createAbsoluteUrl('houseadmin/login/logout') ?>">退出</a></li>
            <li style="display:none">
            &nbsp;切换站点后台：
            <select name="lang" id='lang' class="lang"  style="border:1px solid #ddd;">
            <?php if(!empty($lang_arr)){foreach($lang_arr as $lang){?>
            <option value="<?php echo $lang['dir']?>"  <?php if (isset($this->lang)&&$this->lang==$lang['dir']): ?>selected<?php endif; ?>><?php echo $lang['title']?></option>
            <?php }}?>
            </select>
            </li>
        </ul>
    </div>
   
    <div class="nav_m" id="nav_m" style=''>
        <div class="bd">
            <ul  class="clearfix">
                <?php 
                if(isset($menu)){$i=1;$num =count($menu);foreach($menu as $k=>$v){ 
                     if(isset($v['menu'])&&$v['menu']){
                             $frist_children = $v['children'][0]['children'][0];
                     }else{
                         $frist_children = $v['children'][0];
                     }
                ?>
                <li   <?php if($i==1)echo 'class="active"';  ?> onclick='changeLeft("<?php echo $k; ?>",this)'   ref="<?php echo $frist_children['url']?>"><span  href="javascript:void(0)" class="v1"><?php echo $v['title']; ?></span></li>
                <?php $i++;}}?>
            </ul>
        </div>
        
         <div id="navlr" style="float:right;position:relative;width:32px;height:16px;z-index:99;top:-25px;right:10px;margin:0;display:none">
            <a class="nav_m_prev" href="javascript:void(0)"></a>
            <a class="nav_m_next" href="javascript:void(0)"></a>
        </div> 

                                    
    </div>
       <!-- 下面是前/后按钮代码，如果不需要删除即可 -->
     
          <script id="jsID" type="text/javascript">

                for (var i=2;i<=$('#nav_m li').length;i++){
                        if($('#nav_m').width()<= Number(130)*Number(i)){
                                $('#navlr').show();
                                jQuery("#nav_m").slide({mainCell:".bd ul",autoPage:true,effect:"left",interTime:5000,autoPlay:false,scroll:i-1,vis:i-1,prevCell:".nav_m_prev",nextCell:".nav_m_next"});
                                break;
                        }
                }
           
//                                      jQuery(".slideBox").slide( { mainCell:".bd ul", effect:'fold',autoPlay:true,delayTime:2000,mouseOverStop:true,pnLoop:true });
                                    </script>
    
<style>
.nav_m_prev, .nav_m_next {
   float:left;
    display: block;
    height: 16px; 
    width: 16px;
    overflow:hidden;
}
.nav_m_prev{ background: rgba(0, 0, 0, 0) url("<?php echo $this->_baseUrl;?>/assets/public/images/opa-icons-white16.png") no-repeat scroll -95px -17px}
.nav_m_next{ background: rgba(0, 0, 0, 0) url("<?php echo $this->_baseUrl;?>/assets/public/images/opa-icons-white16.png") no-repeat scroll -30px -17px}
</style>
   
   
</div>
</div>
<!--end top-->

<!--左边菜单-->
<div id="left_nav"></div>

<!--左边菜单隐藏按钮-->
<div style='float:left;border-left:1px solid #c2d1d8; border-right:1px solid #c2d1d8;'>
<div id="switch_bar" onclick='switchSysBar()'>
    <div id='p'>
   
    </div>
</div>
</div>
    

<script type="text/javascript">
wSize();
var admin_url = "<?php echo $this->_adminUrl;?>";

function wSize(){
    var center_height = $(window).height() - parseInt('106');
    $('#left_nav').height(center_height);
    $('#switch_bar').height(center_height);
	$('.main_right').height(center_height);	
	var id_center_height = center_height- parseInt('28');
    $('#center').height(id_center_height);
	
}


window.onload = function(){
    wSize();
    if(!+"\v1" && !document.querySelector) { // for IE6 IE7
      document.body.onresize = resize;
    } else { 
      window.onresize = resize;
    }
    function resize() {
            wSize();
            return false;
    }  

    getleft_menu('notice',$('.nav_m').find('li').eq(0));
    $("#left_nav").delegate('li',"click",function(){   
                  set_center(admin_url+'/'+$(this).attr('ref'));
                  set_position(this);
                  $("#left_nav li").removeClass('active');
                  $(this).addClass('active');
    });    

};
function switchSysBar(){ 
     $("#left_nav").toggle();
} 


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

<!--核心内容部分-->
<div class='main_right' style='overflow:hidden'>
      <div class="position clearfix" id='position'>
        <div class='position_ico'></div>
                       <div class="position_title" >
                       您当前的位置：<span><a href="javascript:;"></a>首页</span> > <span><a href="javascript:;"></a>站点首页</span>
                       </div>
    </div>
<iframe SRC="<?php echo $this->_adminUrl.'/notice/index' ?>" id="center" name="center" width="100%" height="auto" frameborder="false" allowtransparency="true"  scrolling='auto'  style='z-index:9'></iframe>
</div>

<div style="position:fixed;bottom:0;height:26px;width:100%;text-align:center;line-height:26px;background:#E2E9EA;color:#000">
        <div style="float:right">日期：<?php echo date('Y-m-d',time())?>&nbsp;&nbsp;</div>
</div>
    
</body>
</html>
