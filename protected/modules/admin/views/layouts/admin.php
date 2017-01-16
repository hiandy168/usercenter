<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" />


        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/kindeditor.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>


        <script type="text/javascript">
        <?php $member = Mod::app()->session['admin_member'];?>
        var site_url = "<?php echo $this->_siteUrl; ?>";
        var admin_url = "<?php echo $this->_adminUrl;?>";
        var id = "<?php echo $user['id']?>"; 
        var token = "<?php echo $user['token']?>";
        var lang = "<?php echo $this->lang?>";
        $(document).ready(function(){  
            var editor1 = KindEditor.create('.editor', {
                fileManagerJson:admin_url+"/files/file_manager",
                uploadJson:admin_url+'/files/upload?id='+id+'&token='+token+'&lang='+lang,
                allowFileManager : true,
                formatUploadUrl :false,
                filterMode : false,//关闭 要不然会过滤一些代码
                urlType:'',
                afterBlur: function(){this.sync();},
                extraFileUploadParams : {
                    PHPSESSID : '<?php echo session_id(); ?>'
                }
            });
        });
        </script>
 </head>
 <body>
	    <?php echo $content; ?>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/validation.js"></script>  
 </body>
 </html>