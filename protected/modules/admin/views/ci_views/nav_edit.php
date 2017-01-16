<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo  base_url('public/css/admin.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo  base_url('public/js/kindeditor/themes/default/default.css') ?>" />
        <script type="text/javascript" src="<?php echo  base_url('public/js/jquery-1.11.0.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/kindeditor/kindeditor-min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/kindeditor/lang/zh_CN.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/admin.js') ?>"></script>
        <script type="text/javascript" src="<?php echo  base_url('public/js/validation.js') ?>"></script>  
        <script type="text/javascript">
        var admin_url = "<?php echo admin_url()?>";
        </script>
 </head>
 <body>
   
    <div class='bgf clearfix'>
             
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('nav').'/'.$fun;?>" method="post" onsubmit="return checkfrom();">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                         <input type="hidden" name="type_id" value="<?php echo isset($type_id)?$type_id:(isset($view['type_id'])?$view['type_id']:'');?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
    
                        <tr>
                            <td width='120' class="t">标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title"  class="required" class="required" size="30"   value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                
<!--                         <tr>
                            <td width='120' class="t"><?php echo lang('type')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <select name='type_id'>
                                    <option value="0" ><?php echo lang('select')?></option>
                                    <?php foreach ($type_arr as $key => $t): ?>
                                    <option value="<?php echo  $t['id'] ?>" <?php if ( (isset($view['type_id']) && $t['id'] == $view['type_id']) ){ ?>selected<?php } ?>><?php echo  $t['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>-->
                         <tr>
                            <td width='120' class="t"><?php echo lang('parent')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <select name="fid" class="required">
                                     <option value="0" <?php if (isset($view['fid']) && 0 == $view['fid']): ?>selected<?php endif; ?>>顶级分类</option>
                                    <?php foreach ($nav_arr as $nav): ?>
                                    <option value="<?php echo  $nav['id'] ?>" <?php if ( (isset($view['fid']) && $nav['id'] == $view['fid']) ){ ?>selected<?php } ?>><?php echo  $nav['fix'].$nav['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            
                            </td>
                        </tr>
                          <tr>
                            <td width='120' class="t">链接</td>
                            <td>
                                <input  type="text" name="url" id="url"  size="50"  value="<?php echo isset($view['url'])?$view['url']:'';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                         <tr>
                             <td width='120' class="t">图片</td>
                              <td  class="thumb">
                                <div style="height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;">
                                <img onclick="upload_pic('img_thumb','picture')"  src="<?php  echo isset($view['picture'])?show_img($view['picture']):show_img('')?>"width="176" height='123' max-width='150' max-height='130px'  id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                </div>
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                             	<span  class="btn2" onclick="upload_pic('img_thumb','picture')"><?php echo lang('upload_pic')?></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' class="t">排序<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="order" id="order"   value="<?php echo isset($view['order'])?$view['order']:'99';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' class="t"><?php echo  lang('status') ?>:</td>
                            <td > 
                                <label> <?php echo  lang('yes') ?></label>
                                <input type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label> <?php echo  lang('no') ?></label>
                                 <input type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                            </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
     

                                
<script>  
function checkfrom(){
    var false_num =0;   
    <?php if($fun!='edit'){?>
    if(!nameCheck()){
        false_num++;
    }
     if(!repwdCheck()){
        false_num++;
    }
    if(!pwdCheck()){
        false_num++;
    } 
    <?php } ?>
   

    if(false_num){
        return false;
    }else{
        return true;
    }
}

</script>
</body>
</html>
