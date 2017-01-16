<?php $this->load->view('header.php');?>
<div class='bgf clearfix'>
        
                <div class="center_top clearfix">
                <ul>
                <li class="btn"><a  href="javascript:;">添加/编辑会员</a></span>  
                </ul>
                </div>
    

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('member').'/'.$fun;?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
                        <tr>
                            <td width='120' align='right'>会员分组<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <select name="group_id"  class="required" >
                                    <?php foreach($view['group'] as $kg=>$vg){?>
                                    <option value="<?php echo $vg['id']?>"  <?php echo (isset($view['group_id'])&&($view['group_id']==$vg['id']))?'selected="selected"':'';?> ><?php echo $vg['name']?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php if($fun!='edit'){?>
                          <tr>
                            <td width='120' align="right">会员名<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <input  type="text" name="name" id="name"  class="required"  value="<?php echo isset($view['name'])?$view['name']:'';?>"  >
                                <div id="name_msg"></div>
                            </td>
                        </tr>
                      
                        <?php }else{ ?>
                         <tr>
                            <td width='120' align="right">会员名<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                               <?php echo isset($view['name'])?$view['name']:'';?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td width='120' align="right">会员密码<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td><input  type="password" name="password"   class="required" id="pwd"  value=""><div id="pwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align="right">重复输入会员密码:</td>
                            <td><input  type="password" name="repassword"   class="required" id="repwd"   value=""><div id="repwd_msg"></div></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>会员状态<em style="color:#ff0000">*</em>&nbsp;:</td>
                            <td>
                                <label for="status1">启用</label> <input id='status1' type="radio" name="status" value="1" <?php if(!isset($view['status'])||$view['status']==1){echo 'checked';} ?> />   
    
                                <label for="status0">&nbsp;&nbsp;禁用</label> <input id='status0' type="radio" name="status" value="0" <?php if(isset($view['status'])&&$view['status']==0){echo 'checked';} ?>  />
                            </td>
                        </tr> 
                        <tr>
                            <td width='120' align="right">会员备注:</td>
                            <td>
                                <textarea name='remark'><?php echo isset($view['remark'])?$view['remark']:'';?></textarea>
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
