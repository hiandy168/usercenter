       <div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                <ul>
                <li><span><a class="btn btn-primary" href="javascript:;">添加/编辑城市服务</a></span></li>
                </ul>
                </div>

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/citylife/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">

                            <tr>
                                <td width='120' class="t">服务名称<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <input  type="text" name="name" id="name" class="required"  size="20"   value="<?php echo isset($model->name)?$model->name:'';?>" >
                                </td>
                            </tr>

                            <tr>
                                <td width='120' class="t">服务链接<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <input  type="text" name="url" id="url"  size="50"  value="<?php echo isset($model->url)?$model->url:'';?>" >
                                    <div id="name_msg"></div>
                                </td>
                            </tr>
                            <tr>
                                <td width='120' class="t">分类<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <select name="cateid" id="cateid">
                                    <?php foreach($cates as $v): ?>
                                        <option value="<?php echo $v->id; ?>" <?php if(isset($model->url) && $model->cateid == $v->id){echo 'selected=selected';} ?>><?php echo $v->name; ?></option>
                                    <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td width='120' class="t">服务图标<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td  class="thumbx">
                                    <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','icon')"  src="<?php  echo isset($model->icon)?JkCms::show_img($model->icon):JkCms::show_img('')?>"  id="img_thumb">
                                    <input type="hidden" name="icon" id="icon" value="<?php echo  isset($model->icon) ? $model->icon : ''; ?>">
                                    <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                                        <span  class="btn btn-danger" onclick="upload_pic('img_thumb','icon')"><?php echo Mod::t('admin','upload_pic')?></span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width='120' class="t">排序<em style="color:#ff0000">*</em>&nbsp;:</td>
                                <td>
                                    <input  type="text" name="position" id="position"  value="<?php echo isset($model->position)?$model->position:'99';?>" >
                                    <div id="name_msg"></div>
                                </td>
                            </tr>

                        <tr>
                            <td width='120' align='right'>服务状态:</td>
                            <td>
                                <label for="status1" class='w_30'>启用</label> <input class='w_30'  id='status1' type="radio" name="status" value="1" <?php if(!isset($model->status)||$model->status==1){echo 'checked';} ?> />
    
                                <label for="status0" class='w_30'>禁用</label> <input  class='w_30' id='status0' type="radio" name="status" value="0" <?php if(isset($model->status)&&$model->status==0){echo 'checked';} ?>  />
                            </td>
                        </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
