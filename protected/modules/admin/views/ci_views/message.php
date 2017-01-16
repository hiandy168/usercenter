<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加用户组</title>
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
   
    <div class='bgf clearfix'>
           
                <div class="form_list" style="text-align:center">
                    <?php echo $content;?>
                    <?php if($target_url&&$delay_time){?>
                        <?php echo '<em id="time">'.$delay_time.'</em>';?>秒后自动跳转  
                    <?php } ?>
                </div>
    </div>
<script type="text/javascript" >
var target_url ="<?php echo $target_url ?>"
var time = <?php echo $delay_time?$delay_time:0;?>;
$(document).ready(function(){
        parent.header.ship_mess("<?php echo $content;?>",3000,0,820);
        if(target_url){
            setInterval("jump()",1000);
        }
});
    
function jump(){
    if(time==0){
        document.location.href= target_url;
    }else {
        time=--time;
        document.getElementById("time").innerHTML = time;
    }
}

     
</script>
</body>
</html>
