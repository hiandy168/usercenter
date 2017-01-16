<div class='bgf clearfix'>

        <?php  if(isset($view['title'])){ ?>
                <div class="center_top clearfix">
                        <ul>
                            <li class="btn"><span><?php  echo  'id:'. $view['id'] .'  '. Mod::t('admin','title').':'. $view['title']   ?></span>  </li>
                        </ul>
                </div>
        <?php } ?>
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/type/'.$fun);?>" method="post" >
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                      
    
                          <tr>
                            <td width='120' align="right"><?php echo Mod::t('admin','title')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="title"  class="required" value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align="right"><?php echo Mod::t('admin','type')?><em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                 <select name="type"  class="required" >
                                    <option value=""><?php echo Mod::t('admin','type')?></option>
                                    <option value="nav" <?php if ( (isset($view['type']) && 'nav' == $view['type']) ){ ?>selected<?php } ?>><?php echo  Mod::t('admin','nav') ?></option>
                                    <option value="friendlink" <?php if ( (isset($view['type']) && 'friendlink' == $view['type'])){ ?>selected<?php } ?>><?php echo  Mod::t('admin','friendlink') ?></option>
                                    <option value="slider" <?php if ( (isset($view['type']) && 'slider' == $view['type'])  ){ ?>selected<?php } ?>><?php echo  Mod::t('admin','slider') ?></option>
                                    <option value="ads" <?php if ( (isset($view['type']) && 'ads' == $view['type'])  ){ ?>selected<?php } ?>><?php echo  Mod::t('admin','ads') ?></option>
                                        
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
                           <td width='120' align="right"><?php echo  Mod::t('admin','status') ?>:</td>
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
     


