<div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                        <ul>
                            <li><span  class="btn btn-primary">添加/编辑</span>   </li>
                        </ul>
                </div>
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/ads/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                           <table cellSpacing=0 width="100%">
                          <tr>
                            <td width='120' class="t">标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title" id="title"  class="required"  size="30"   value="<?php echo isset($view['title'])?$view['title']:'';?>" >
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
                           <td width='120' class="t">广告类型:</td>
                            <td> 
                                <label class="w_10" for="adimg" style="width:67px;"> 自定义广告</label>
                                <input id="adimg"  class="w_30" type="radio" name="type" value="1" <?php if (!isset($view['type']) || $view['type'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label  class="w_10" for="adcode" style="width:100px;">&nbsp;第三方广告代码</label>
                                 <input  id="adcode"  class="w_30" type="radio" name="type" value="2" <?php if (isset($view['type']) && $view['type'] == 2) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                        </tr>
                         </table>
                     
                        <table cellSpacing=0 width="100%" id="box_img" <?php if(isset($view['type'])&& $view['type']==2){?>style="display:none"<?php } ?>>
                          <tr>
                            <td width='120' class="t">链接:</td>
                            <td>
                                <input  type="text" name="url" id="url"  size="50"  value="<?php echo isset($view['url'])?$view['url']:'';?>" >
                            </td>
                        </tr>
                         <tr>
                             <td width='120' class="t">图片:</td>
                              <td  class="thumb">
                                <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')"  src="<?php  echo isset($view['picture'])?JkCms::show_img($view['picture']):JkCms::show_img('')?>"  id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                             	<span  class="btn btn-danger" onclick="upload_pic('img_thumb','picture')"><?php echo Mod::t('admin','upload_pic')?></span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' class="t">尺寸<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td> 
                                <label  style="width:60px;float:left">宽度px</label>
                                <input   class='w_30' style="width:100px;" type="text" name="width" value="<?php echo (isset($view['width']) && $view['width'])?$view['width']:'auto';?>"  />
                                <label style="width:60px;float:left">&nbsp;&nbsp;&nbsp;高度px</label>
                                <input  class='w_30' style="width:100px;" type="text" name="height" value="<?php echo (isset($view['height'])&& $view['width'])?$view['height']:'auto';?>"   />
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
                        </table>
                        <table cellSpacing=0 width="100%" id="box_code" <?php if(!isset($view['type'])|| !$view['type'] ||$view['type']==1){?>style="display:none"<?php } ?>>
                          <tr>
                            <td width='120' class="t">广告代码:</td>
                            <td>
                                <textarea name="code" id="code"  style="height:300px;width:600px;" ><?php echo isset($view['code'])?$view['code']:'';?></textarea>
                            </td>
                        </tr>
                        </table>
                          <table cellSpacing=0 width="100%">
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
                        </table>        
                        </form>
                </div>
    </div>
     



<script>
$(function(){
    $("input:radio[name='type']").change(function (){ //拨通
        var typeval =  $('input:radio[name="type"]:checked').val();
        if(typeval == 1){
             $('#box_code').hide();
             $('#box_img').show();
        }else if(typeval == 2){
             $('#box_code').show();
             $('#box_img').hide();
        }
    });
});
    </script>