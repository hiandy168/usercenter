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
        <script type="text/javascript" src="<?php echo  base_url('public/js/validation.js') ?>"></script>  
 </head>
 <body>
   
    <div class='bgf clearfix'>
              
                <div class="form_list">
                       <form onsubmit="" method="post" action="<?php echo admin_url('setting')?>" id="formview" name="formview">
                        <table width="100%" cellspacing="0" class="content_view">  
                      
    
                                                     <tbody><tr>
                            <td width="120" align="right">站点名称<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_name']?>" id="site_name" name="site_name"  class="required">
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">站点标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_title']?>" id="site_title" name="site_title"  class="required"> 
                            </td>
                        </tr>
                        
                         <tr>
                            <td width="120" align="right">安全码<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_safe_code']?>" id="site_safe_code" name="site_safe_code"  class="required"> 
                            </td>
                        </tr>
                        
                        
                                                  <tr>
                            <td width="120" align="right">关键字:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_keywords']?>" id="site_keywords" name="site_keywords" style='width:300px;'>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">站点描述:</td>
                            <td>
                                <textarea name="site_description"  style='padding:5px;width:300px;height:100px'><?php echo $setting['site_description']?></textarea>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">第三方代码:</td>
                            <td>
                                <textarea name="site_code" style='padding:5px;width:300px;height:100px'><?php echo $setting['site_code']?></textarea>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">logo<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_logo']?>" id="site_logo" name="site_logo"  style='width:240px;'>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">模板<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_template']?>" id="site_template" name="site_template"  style='width:240px;'  class="required">
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">备案<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo $setting['site_beian']?>" id="site_beian" name="site_beian"  style='width:240px;'>
                            </td>
                        </tr>
                                                
                         <tr>
                            <td width="120" align="right" style="border:none"></td>
                            <td style="border:none"><input type="submit" class="btn" value="提交"></td>
                        </tr>
                        </tbody></table>        
                        </form>
                </div>
    </div>
     
</body>
</html>
