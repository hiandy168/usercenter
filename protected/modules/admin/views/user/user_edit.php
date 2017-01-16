       <div class='bgf clearfix'>
               
                <div class="center_top clearfix">
                <ul>
                <li><a   class="btn btn-primary" href="javascript:;">添加/编辑用户</a></span>  
                </ul>
                </div>
    

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/user/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                        <tr>
                            <td width='120' align='right'>用户分组:</td>
                            <td>
                                <select name="group_id"  class="required" >
                                    <?php foreach($group as $kg=>$vg){?>
                                    <option value="<?php echo $vg['id']?>"  <?php echo (isset($model->group_id)&&($model->group_id==$vg['id']))?'selected="selected"':'';?> ><?php echo $vg['name']?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        
                         <tr>
                            <td width='120' align='right'>是否管理员:</td>
                            <td>
                                <label for="status1" class='w_10'>是</label> <input class='w_30'  id='status1' type="radio" name="admin" value="1" <?php if(isset($model->admin)&&$model->admin==1){echo 'checked';} ?> />   
    
                                <label for="status0" class='w_10'>否</label> <input  class='w_30' id='status0' type="radio" name="admin" value="0" <?php if(!isset($model->admin)|| !$model->admin){echo 'checked';} ?>  />
                            </td>
                        </tr> 
                        
                        <?php if($fun!='edit'){?>
                          <tr>
                            <td width='120' align="right">用户名:</td>
                            <td>
                                <input  type="text" name="name" id="name"  class="required"  value="<?php echo isset($model->name)?$model->name:'';?>"  >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                      
                        <?php }else{ ?>
                         <tr>
                            <td width='120' align="right">用户名:</td>
                            <td>
                               <?php echo isset($model->name)?$model->name:'';?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td width='120' align="right">用户密码:</td>
                            <td><input  type="password" name="password"   class="required" id="pwd"  value="" style="float:left"><div style="float:left" id="pwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align="right">重复输入用户密码:</td>
                            <td><input  type="password" name="repassword"   class="required" id="repwd"   value="" style="float:left"><div style="float:left" id="repwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>用户状态:</td>
                            <td>
                                <label for="status1" class='w_30'>启用</label> <input class='w_30'  id='status1' type="radio" name="status" value="1" <?php if(!isset($model->status)||$model->status==1){echo 'checked';} ?> />   
    
                                <label for="status0" class='w_30'>禁用</label> <input  class='w_30' id='status0' type="radio" name="status" value="0" <?php if(isset($model->status)&&$model->status==0){echo 'checked';} ?>  />
                            </td>
                        </tr> 
                        <tr>
                            <td width='120' align="right">用户备注:</td>
                            <td>
                                <textarea name='remark'><?php echo isset($model->remark)?$model->remark:'';?></textarea>
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
