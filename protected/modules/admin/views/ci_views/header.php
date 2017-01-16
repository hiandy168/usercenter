<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?php echo base_url('public/js/jquery-1.11.0.min.js')?>"></script>
        <script type="text/javascript" src="<?php echo base_url('public/js/artDialog/jquery.artDialog.js?skin=default')?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/kindeditor/kindeditor-min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/kindeditor/lang/zh_CN.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/admin.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/validation.js') ?>"></script>  

        <script type="text/javascript">
        var admin_url = "<?php echo admin_url()?>";
        var id = "<?php echo $member['id']?>"; 
        var token = "<?php echo $member['token']?>"; 
        $(document).ready(function(){
            var editor1 = KindEditor.create('textarea[name="content"]', {
                fileManagerJson:admin_url+"/files/file_manager",
                uploadJson:admin_url+'files/upload/?id='+id+'&token='+token,
                allowFileManager : true,
                formatUploadUrl :false,
            });
        })
        </script>
 </head>
 <body>
