<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('public/css/left.css')?>" />
<title>无标题文档</title>
</head>
<body>
<div id="left_nav"></div>
<script type="text/javascript">
var admin_url = "<?php echo admin_url()?>";
$(document).ready(function(){
    getleft_menu('notice');
    $("#left_nav").delegate('li',"click",function(){   
                      set_center(admin_url+$(this).attr('ref')+'/index');
                      $("#left_nav li").removeClass('active');
                      $(this).addClass('active');
    });    

});
</script>

</body>
</html>
