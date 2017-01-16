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
        <script type="text/javascript" src="<?php echo  base_url('public/js/validation.js') ?>"></script>  
 </head>
 <body>
   
    <div class='bgf clearfix'>

  
                <div class="center_top clearfix">
                        <ul>
                            <li class="btn"><span>添加/编辑</span>  
                        </li>
                        </ul>
                </div>
        
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('model').'/'.$fun;?>" method="post" onsubmit="return checkfrom();">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                      
    
                          <tr>
                            <td width='120' align="right">模块名<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="name"   class="required" value="<?php echo isset($view['name'])?$view['name']:'';?>" >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align="right">表名<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="table" id="table"  class="required"  value="<?php echo isset($view['table'])?$view['table']:'';?>"  >
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
