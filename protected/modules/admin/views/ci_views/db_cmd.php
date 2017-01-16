<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/formcheck.js')?>"></script>  
 </head>
 <body>
   
    <div class='bgf clearfix'>

                <div class="center_top clearfix">
                <ul>
                    <li class="btn_b"><a href="<?php echo admin_url('db/index')?>">数据库管理</a></li>    
                    <li class="btn_b"><a href="<?php echo admin_url('db/download')?>"><?php echo  lang('sqldown') ?></a></li>   
                    <li class="btn_b btn"><a href="<?php echo admin_url('db/mysqlcmd')?>"><?php echo  lang('sqlcmd') ?></a></li>   
                </ul>
                </div>


                <div class="clearfix"></div>
                
                <div class="form_list">
                       <form onsubmit="" method="post" action="<?php echo admin_url('db/mysqlcmd')?>" id="formview" name="formview">
                                    <table cellSpacing=0 width="100%">
                                    <tr><td width="100"><?php echo lang('mysql_sql')?>:</td>
                                    <td><textarea name="upgradesql" id="upgradesql"  style="width:600px;height:400px;background:#ffffff" class="txtarea validate"  validtip="required"></textarea></td></tr>   
                                    <tr>
                                    <td width="120" align="right" style="border:none"></td>
                                    <td style="border:none"><input type="submit" class="btn" value="<?php echo lang('submit')?>"></td>
                                    </tr>
                                    </table> 
                        </form>
                     
                </div>
    </div>
     
</body>
</html>
