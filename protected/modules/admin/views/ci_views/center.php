<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>内容管理系统-cneter</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style type="text/css">
body {margin:0;padding:0}
</style>
<style> 
.navPoint { 
COLOR: white; CURSOR: hand; FONT-FAMILY: Webdings; FONT-SIZE: 9pt 
} 
</style> 
<script>
function switchSysBar(){ 

var ssrc=document.all("img1").src.replace(locate,'');
if (ssrc=="<?php echo base_url('public')?>/images/main_30.gif")
{ 
document.all("img1").src="<?php echo base_url('public')?>/images/main_30_1.gif";
document.all("frmTitle").style.display="none" 
} 
else
{ 
document.all("img1").src="<?php echo base_url('public')?>/images/main_30.gif";
document.all("frmTitle").style.display="" 
} 
} 
</script>
</head>
<body style="overflow:hidden">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156" id=frmTitle noWrap name="fmTitle" align="center" valign="top">
	<iframe name="I1" height="100%" width="156" src="<?php echo admin_url('main/left')?>" border="0" frameborder="0" scrolling="no">
	浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
    </td>
      <td width="4" valign="middle" background="<?php echo base_url('public')?>/images/main_27.gif" onclick=switchSysBar()>
          <SPAN class=navPoint id=switchPoint title=关闭/打开左栏><img src="<?php echo base_url('public')?>/images/main_30.gif" name="img1" width=4 height=47 id=img1></SPAN>
      </td>
    <td align="center" valign="top">
        <iframe name="I2" height="100%" width="100%" border="0" frameborder="0" src="<?php echo admin_url('notice')?>"> 浏览器不支持嵌入式框架，或被配置为不显示嵌入式框架。</iframe>
    </td>
  </tr>
</table>
</body>
</html>
