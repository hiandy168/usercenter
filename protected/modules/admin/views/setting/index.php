<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl;?>/assets/public/css/admin.css" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/formcheck.js"></script>  
        <script type="text/javascript" src="<?php echo $this->_baseUrl;?>/assets/public/js/validation.js"></script>  
 </head>
 <body>
   
    <div class='bgf clearfix'>
           
           <div class="center_top clearfix">
                <ul>
                    <li><a href="<?php echo $this->createUrl('setting/index') ?>" class="btn btn-primary current">基本设置</a></li>
                    <!--<li><a href="<?php echo $this->createUrl('setting/ucenter') ?>" class="btn btn-primary current" ><span>ucenter</span></a></li>-->
                </ul>
            </div>
        
                <div class="form_list">
                       <form onsubmit="" method="post" action="<?php echo $this->createUrl('/admin/setting') ?>" id="formview" name="formview">
                        <table width="100%" cellspacing="0" class="content_view">  
                      
    
                        <tbody>
                        <tr>
                            <td width="120" align="right">站点标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_title']['value'])?$setting['site_title']['value']:''?>" id="site_title" name="site_title"  class="required"> 
                            </td>
                        </tr>
                        
                         <tr>
                            <td width="120" align="right">安全码<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_safe_code']['value'])?$setting['site_safe_code']['value']:''?>" id="site_safe_code" name="site_safe_code"  class="required"> 
                            </td>
                        </tr>
                        
                        
                                                  <tr>
                            <td width="120" align="right">关键字:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_keywords']['value'])?$setting['site_keywords']['value']:''?>" id="site_keywords" name="site_keywords" style='width:300px;'>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">站点描述:</td>
                            <td>
                                <textarea name="site_description"  style='padding:5px;width:300px;height:100px'><?php echo isset($setting['site_description']['value'])?$setting['site_description']['value']:''?></textarea>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">第三方代码:</td>
                            <td>
                                <textarea name="site_code" style='padding:5px;width:300px;height:100px'><?php echo isset($setting['site_code']['value'])?$setting['site_code']['value']:''?></textarea>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">logo<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_logo']['value'])?$setting['site_logo']['value']:''?>" id="site_logo" name="site_logo"  style='width:240px;'>
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">模板<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_template']['value'])?$setting['site_template']['value']:''?>" id="site_template" name="site_template"  style='width:240px;'  class="required">
                            </td>
                        </tr>
                                                  <tr>
                            <td width="120" align="right">备案<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input type="text" value="<?php echo isset($setting['site_beian']['value'])?$setting['site_beian']['value']:''?>" id="site_beian" name="site_beian"  style='width:240px;'>
                            </td>
                        </tr>
                                                
                         <tr>
                            <td width="120" align="right" style="border:none"></td>
                            <td style="border:none"><input type="submit" class="btn btn-primary" value="提交"></td>
                        </tr>
                        </tbody></table>        
                        </form>
                </div>
    </div>
     
</body>
</html>
