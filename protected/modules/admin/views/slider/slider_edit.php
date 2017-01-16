<div class='bgf clearfix'>

              
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/slider/'.$fun);?>" method="post" onsubmit="return checkfrom();">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
    
                          <tr>
                            <td width='120' class="t">标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title" id="title" class="required" size="30"   value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                            </td>
                        </tr>
                         <tr>
                            <td width='120' class="t"><?php echo Mod::t('admin','type')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <select name='type_id' class="required" >
                                    <option value="" ><?php echo Mod::t('admin','select')?></option>
                                    <?php foreach ($type_arr as $key => $t): ?>
                                    <option value="<?php echo  $t['id'] ?>" <?php if ( (isset($view['type_id']) && $t['id'] == $view['type_id']) ){ ?>selected<?php } ?>><?php echo  $t['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                        
                          <tr>
                            <td width='120' class="t">链接:</td>
                            <td>
                                <input  type="text" name="url" id="url"  size="50"  value="<?php echo isset($view['url'])?$view['url']:'';?>" >
                            </td>
                        </tr>
                         <tr>
                             <td width='120' class="t">图片<em style="color:#ff0000">*</em>&nbsp;:</td>
                              <td  class="thumb">
                                <img style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')"  src="<?php  echo isset($view['picture'])?Tool::show_img($view['picture']):Tool::show_img('')?>"  id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                             	<span  class="btn2" onclick="upload_pic('img_thumb','picture')"><?php echo Mod::t('admin','upload_pic')?></span>
                                </p>
                            </td>
                        </tr>
                         <tr>
                            <td width='120' class="t">打开方式<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td> 
                                <label  style="width:40px;float:left">_self</label>
                                <input  class='w_30' type="radio" name="target" value="" <?php if (!isset($view['target']) || $view['target'] == '_self') {
                                    echo 'checked';
                                } ?> />
                                 <label style="width:40px;float:left">_blank</label>
                                 <input  class='w_30' type="radio" name="target" value="_blank" <?php if (isset($view['target']) && $view['target'] == '_blank') {
                                    echo 'checked';
                                } ?>  />
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
                           <td width='120' class="t"><?php echo  Mod::t('admin','status') ?>:</td>
                            <td> 
                                <label class="w_10"> <?php echo  Mod::t('admin','yes') ?></label>
                                <input  class="w_30" type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label  class="w_10"> <?php echo  Mod::t('admin','no') ?></label>
                                 <input   class="w_30" type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-danger"></td>
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

