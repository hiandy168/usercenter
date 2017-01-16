<div class='bgf clearfix'>
           
            <div class="center_top clearfix">
                <ul>
                    <li><a   class="btn btn-primary" href="<?php echo $this->createUrl('offices/add') ?>">添加栏目</a></span>  
                </ul>

            </div>


            <div class="form_list">
                <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/offices/'.$fun); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
                    <table cellSpacing=0 width="100%" class="content_view">
                        <tr>
                            <td class='t'>名称:</td>
                            <td width="240" ><input  size="24" type="text" name="name" id="name" class="required"  value="<?php echo  isset($view['name']) ? $view['name'] : ''; ?>"></td>
<!--                            <td rowspan="4" class="thumb" width="200" >
                                <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')" src="<?php  echo isset($view['picture'])?(Tool::show_img($view['picture'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                             	<span  class="btn btn-danger" onclick="upload_pic('img_thumb','picture')"><?php echo Mod::t('admin','upload_pic')?></span>
                                </p>
                            </td>
                            <td rowspan="4" class="thumb" style='border:0'></td>-->
                        </tr>
                         
                        <tr>
                              <td class='t' style='width:50px'><?php echo  Mod::t('admin','alias') ?>:</td>
                            <td><input size="20"  type="text" name="alias" id="dir"  value="<?php echo  isset($view['alias']) ? $view['alias'] : ''; ?>"></td>
     
                        </tr>    
                        
                        <tr>
                              <td class='t'><?php echo  Mod::t('admin','parent') ?>:</td><td>
                                <select name="fid"  >
                                      <option value="0" <?php if (isset($view['fid']) && 0 == $view['fid']): ?>selected<?php endif; ?>>顶级分类</option>
                                      <?php foreach ($officesarr as $key => $cat): ?>
                                    <option value="<?php echo $cat['id'] ?>" <?php if ( (isset($view['fid']) && $cat['id'] == $view['fid']) ||  (isset($fid) && $cat['id'] == $fid) ){ ?>selected<?php } ?>><?php echo  $cat['fix'].$cat['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                    
                        </tr>
<!--                          <tr>
                             <td class='t'><?php echo  Mod::t('admin','offices_model') ?>:</td>
                            <td>
                                <select name="model" id="model" class="required"  style="width:150px">
                                <?php foreach ($modelarr as $model): ?>
                                    <option value="<?php echo  $model['table'] ?>" <?php if (isset($view['model']) && $model['table'] == $view['model']): ?>selected<?php endif; ?>><?php echo  $model['name'] ?></option>
                                <?php endforeach; ?>
                                </select>
                            </td>
                     
                        </tr>-->
                        <tr>
                            <td class='t'><?php echo  Mod::t('admin','status') ?>:</td>
                            <td>
                                <label class='w_30'> <?php echo  Mod::t('admin','yes') ?></label>
                                <input class='w_30' type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label class='w_30'> <?php echo  Mod::t('admin','no') ?></label>
                                 <input class='w_30' type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                         
                            
                        </tr>
<!--                        <tr><td class='t'><?php echo  Mod::t('admin','seo').Mod::t('admin','title') ?>:</td><td colspan="3"><input type="text" name="title" id="title"  size="60"  value="<?php echo  isset($view['title']) ? $view['title'] : ''; ?>"></td>
                        <tr><td class='t'><?php echo  Mod::t('admin','seo').Mod::t('admin','keywords') ?>:</td><td colspan="3"><input type="text" name="keywords" id="keywords" size="60"  value="<?php echo  isset($view['keywords']) ? $view['keywords'] : ''; ?>"></td>
                        <tr><td class='t'><?php echo  Mod::t('admin','seo').Mod::t('admin','description') ?>:</td><td colspan="3"><textarea rows="3" cols="50" name="description" id="description" class="txtarea"><?php echo  isset($view['description']) ? $view['description'] : ''; ?></textarea></td></tr>-->
                        <tr>
                            <td class='t'><?php echo  Mod::t('admin','content') ?>:</td>
                            <td colspan="4"><textarea style="width:600px;height:280px;" name="content" id="content" class="editor"><?php echo  isset($view['content']) ? htmlspecialchars($view['content']) : ''; ?></textarea></td></tr>
                        <tr>
                        <tr>
                            <td class='t'><?php echo  Mod::t('admin','pagesize') ?>:</td>
                            <td ><input type="text" name="pagesize" id="pagesize" size="5"  value="<?php echo  isset($view['pagesize']) ? $view['pagesize'] : ''; ?>"></td>
                            <td class='t'><?php echo  Mod::t('admin','order') ?>:</td>
                            <td colspan="2"><input type="text" name="order" id="order" value="<?php if (isset($view['order'])) {
                                                                                                    echo $view['order'];
                                                                                                } else {
                                                                                                    echo '99';
                                                                                                } ?>"  >
                            </td>
                        </tr>
<!--                        <tr>
                            <td class='t'><?php echo  Mod::t('admin','tpl_list') ?>:</td>
                            <td ><input type="text" name="tpl_list" id="tpl_list"  value="<?php echo  isset($view['tpl_list']) ? $view['tpl_list'] : ''; ?>"></td>
                            <td class='t'><?php echo  Mod::t('admin','tpl_detail') ?>:</td>
                            <td colspan="2"><input type="text" name="tpl_detail" id="tpl_detail"  value="<?php echo  isset($view['tpl_detail']) ? $view['tpl_detail'] : ''; ?>"></td>
                            
                        </tr>-->
                        <tr>
                            <td class="t"><?php echo Mod::t('admin','createtime')?></td>
                            <td colspan='3'><input type="text" name="createtime" id="createtime"   size="52" value="<?php echo isset($view['createtime'])?date('Y-m-d H:i:s',$view['createtime']):date('Y-m-d H:i:s')?>"></td>
                        </tr>
                        <tr>
                            <td width='80' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                            <td width='80' align='right' style="border:none"></td>
                        </tr>
                    </table>        
                </form>
            </div>
        </div>

