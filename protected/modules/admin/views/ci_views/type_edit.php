<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo lang('add')?>/<?php echo lang('edit')?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
             <script type="text/javascript" src="<?php echo  base_url('public/js/validation.js') ?>"></script>   
 </head>
 <body>
   
    <div class='bgf clearfix'>
               
        <?php  if(isset($view['title'])){ ?>
                <div class="center_top clearfix">
                        <ul>
                            <li class="btn"><span><?php  echo  'id:'. $view['id'] .'  '. lang('title').':'. $view['title']   ?></span>  </li>
                        </ul>
                </div>
        <?php } ?>
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('type').'/'.$fun;?>" method="post" >
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                      
    
                          <tr>
                            <td width='120' align="right"><?php echo lang('title')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title"  class="required" value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align="right"><?php echo lang('type')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                 <select name="type"  class="required" >
                                    <option value=""><?php echo lang('type')?></option>
                                    <option value="nav" <?php if ( (isset($view['type']) && 'nav' == $view['type']) ){ ?>selected<?php } ?>><?php echo  lang('nav') ?></option>
                                    <option value="friendlink" <?php if ( (isset($view['type']) && 'friendlink' == $view['type'])){ ?>selected<?php } ?>><?php echo  lang('friendlink') ?></option>
                                    <option value="slider" <?php if ( (isset($view['type']) && 'slider' == $view['type'])  ){ ?>selected<?php } ?>><?php echo  lang('slider') ?></option>
                                    <option value="ads" <?php if ( (isset($view['type']) && 'ads' == $view['type'])  ){ ?>selected<?php } ?>><?php echo  lang('ads') ?></option>
                                        
                                </select>
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align="right">备注:</td>
                            <td>
                                <textarea  name="remark" ><?php echo isset($view['remark'])?$view['remark']:'';?></textarea>
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align="right">排序<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="order" id="order"   value="<?php echo isset($view['order'])?$view['order']:'99';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                        
                        <tr>
                           <td width='120' align="right"><?php echo  lang('status') ?>:</td>
                            <td> 
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
     
</body>
</html>
