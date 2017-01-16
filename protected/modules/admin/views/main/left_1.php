<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl;?>/assets/public/css/left.css" />
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/admin.js"></script>
<title>后台管理LEFT</title>
</head>

<body>
<div id="left_nav"></div>
<script type="text/javascript">
var admin_url = "<?php echo $this->_adminUrl;?>";
$(document).ready(function(){
    getleft_menu('notice');
    $("#left_nav").delegate('li',"click",function(){   
                      set_center(admin_url+'/'+$(this).attr('ref')+'/index');
                      $("#left_nav li").removeClass('active');
                      $(this).addClass('active');
    });    

});
</script>

</body>
</html>
