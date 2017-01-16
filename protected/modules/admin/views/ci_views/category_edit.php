<?php $this->load->view('header');?>
<div class='bgf clearfix'>
    
            <div class="center_top clearfix">
                <ul>
                    <li class="btn"><a  href="<?php echo admin_url('category/add') ?>">添加栏目</a></span>  
                </ul>

            </div>


            <div class="form_list">
                <form name="formview" id="formview" action="<?php echo admin_url('category') . '/' . $fun; ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
                    <table cellSpacing=0 width="100%" class="content_view">
                        <tr>
                            <td class='t'><?php echo  lang('category_name') ?>:</td>
                            <td width="200" ><input  size="18" type="text" name="name" id="name" class="required"  value="<?php echo  isset($view['name']) ? $view['name'] : ''; ?>"></td>
                            <td width="40"  class='t'><?php echo  lang('out_link') ?>:</td>
                            <td width="145"> <label> <?php echo  lang('yes') ?></label>
                                <input type="radio" name="is_link" value="1" <?php if (isset($view['is_link']) && $view['is_link'] == 1) {
                                    echo 'checked';
                                } ?> onclick="$('#link').show();" />
                                 <label> <?php echo  lang('no') ?></label>
                                 <input type="radio" name="is_link" value="0" <?php if (!isset($view['is_link']) || $view['is_link'] == 0) {
                                    echo 'checked';
                                } ?>  onclick="$('#link').hide();"  />
                            </td>
                            <td rowspan="4" class="thumb" width="200" >
                                <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')" src="<?php  echo isset($view['picture'])?show_img($view['picture']):show_img('')?>" width="176" height='123' width="150" id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                             	<span  class="btn2" onclick="upload_pic('img_thumb','picture')"><?php echo lang('upload_pic')?></span>
                                </p>
                            </td>
                            <td rowspan="4" class="thumb" style='border:0'></td>
                        </tr>
                        <tr <?php if (!isset($view['is_link']) || $view['is_link'] == 0): ?>style="display:none;"<?php endif; ?> id="link" ><td class='t'><?php echo  lang('links') ?>:</td><td colspan="3"><input type="text" name="link" id="link" size="60"  value="<?php echo  isset($view['link']) ? $view['link'] : ''; ?>"></td>
                        <tr>
                            <td class='t'><?php echo  lang('alias') ?>:</td>
                            <td><input size="18" class="required"   type="text" name="alias" id="dir"  value="<?php echo  isset($view['alias']) ? $view['alias'] : ''; ?>"></td>
                            <td class='t'><?php echo  lang('target') ?>:</td>
                            <td width="145"><label> <?php echo  lang('_self') ?></label><input type="radio" name="target" value="_self" <?php if (!isset($view['target']) || $view['target'] == '_self') {
                                        echo 'checked';
                                    } ?> />
                                        <label> <?php echo  lang('_blank') ?></label>
                                        <input type="radio" name="target" value="_blank" <?php if (isset($view['target']) && $view['target'] == 1) {
                                        echo 'checked';
                                    } ?>  /></td>
                        </tr>
                        <tr>
                              <td class='t'><?php echo  lang('parent') ?>:</td><td>
                                <select name="fid"  >
                                      <option value="0" <?php if (isset($view['fid']) && 0 == $view['fid']): ?>selected<?php endif; ?>>顶级分类</option>
                                    <?php foreach ($categoryarr as $key => $cat): ?>
                                    <option value="<?php echo  $key ?>" <?php if ( (isset($view['fid']) && $key == $view['fid']) ||  (isset($fid) && $key == $fid) ){ ?>selected<?php } ?>><?php echo  $cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                              <td class='t'><?php echo  lang('isnav') ?>:</td>
                            <td width="145">  <label> <?php echo  lang('yes') ?></label><input type="radio" name="is_nav" value="1" <?php if (!isset($view['is_nav']) || $view['is_nav'] == 1) {
                                    echo 'checked';
                                } ?> /><label > <?php echo  lang('no') ?></label><input type="radio" name="is_nav" value="0" <?php if (isset($view['is_nav']) && $view['is_nav'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                        </tr>
                        <tr>
                            <td class='t'><?php echo  lang('category_model') ?>:</td>
                            <td>
                                <select name="model" id="model" class="validate" va>
                                <?php foreach ($modelarr as $model): ?>
                                    <option value="<?php echo  $model['table'] ?>" <?php if (isset($view['model']) && $model['table'] == $view['model']): ?>selected<?php endif; ?>><?php echo  $model['name'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </td>
                              <td class='t'><?php echo  lang('status') ?>:</td>
                            <td width="145"> 
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
                        <tr><td class='t'><?php echo  lang('seo').lang('title') ?>:</td><td colspan="3"><input type="text" name="title" id="title"  size="60"  value="<?php echo  isset($view['title']) ? $view['title'] : ''; ?>"></td>
                        <tr><td class='t'><?php echo  lang('seo').lang('keywords') ?>:</td><td colspan="3"><input type="text" name="keywords" id="keywords" size="60"  value="<?php echo  isset($view['keywords']) ? $view['keywords'] : ''; ?>"></td>
                        <tr><td class='t'><?php echo  lang('seo').lang('description') ?>:</td><td colspan="3"><textarea rows="3" cols="50" name="description" id="description" class="txtarea"><?php echo  isset($view['description']) ? $view['description'] : ''; ?></textarea></td></tr>
                        <tr>
                            <td class='t'><?php echo  lang('content') ?>:</td>
                            <td colspan="4"><textarea style="width:600px;height:280px;" name="content" id="content" class="editor"><?php echo  isset($view['content']) ? htmlspecialchars($view['content']) : ''; ?></textarea></td></tr>
                        <tr>
                        <tr>
                            <td class='t'><?php echo  lang('pagesize') ?>:</td>
                            <td ><input type="text" name="pagesize" id="pagesize" size="5"  value="<?php echo  isset($view['pagesize']) ? $view['pagesize'] : ''; ?>"></td>
                            <td class='t'><?php echo  lang('tpl_list') ?>:</td>
                            <td colspan="2"><input type="text" name="tpl_list" id="tpl_list"  value="<?php echo  isset($view['tpl_list']) ? $view['tpl_list'] : ''; ?>"></td>
                        </tr>
                        <tr>
                            <td class='t'><?php echo  lang('tpl_detail') ?>:</td>
                            <td class='t'><input type="text" name="tpl_detail" id="tpl_detail"  value="<?php echo  isset($view['tpl_detail']) ? $view['tpl_detail'] : ''; ?>"></td>
                            <td class='t'><?php echo  lang('order') ?>:</td>
                            <td colspan="2"><input type="text" name="order" id="order" value="<?php if (isset($view['order'])) {
                                                                                                    echo $view['order'];
                                                                                                } else {
                                                                                                    echo '99';
                                                                                                } ?>"  >
                            </td>
                        </tr>
                        <tr>
                            <td width='80' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn2"></td>
                            <td width='80' align='right' style="border:none"></td>
                        </tr>
                    </table>        
                </form>
            </div>
        </div>
    </body>
</html>
