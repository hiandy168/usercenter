<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>
<body>
<style>
*{margin:0;padding:0;}
body{font-size:12px;}
html{height: 100%}
body{height:100%}
#switch_bar{width:10px;height:100%;background:#E2E9EA;  position:relative; }
#switch_bar #p{position:absolute; height:47px;width:10px;top:50%; left:0;}
#switch_bar #p img{ width: 10px;height: 47px;position: absolute;     margin-top: -24px; overflow: hidden;} 
</style>
<div id="switch_bar" onclick='switchSysBar()'>
    <div id='p'>
       <img src="<?php echo base_url('public')?>/images/bar.gif" name="img1"  >
    </div>
</div>
    
<script type="text/javascript">
function switchSysBar(){ 
  warp = parent.document.getElementById('warp');
  if (warp.cols == "176,10,*")
  {
    warp.cols="0,10,*";
  }else{
	warp.cols="176,10,*";
  }
 
} 
</script>

</body>
</html>






