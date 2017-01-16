<?php $this->load->view('header.php');?>
<div class='bgf clearfix'>
            
                <div class="center_top clearfix">
                        <ul>
                            <li class="btn"><span>添加/编辑</span>  
                        </li>
                        </ul>
                </div>
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('ads').'/'.$fun;?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
    
                          <tr>
                            <td width='120' class="t">标题<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title" id="title"  class="required"  size="30"   value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                            </td>
                        </tr>
                         <tr>
                            <td width='120' class="t"><?php echo lang('type')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <select name='type_id' class="required" >
                                    <option value="" ><?php echo lang('select')?></option>
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
                             <td width='120' class="t">图片:</td>
                              <td  class="thumb">
                                <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')"  src="<?php  echo isset($view['picture'])?show_img($view['picture']):show_img('')?>"  id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
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
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
     

</body>
</html>
