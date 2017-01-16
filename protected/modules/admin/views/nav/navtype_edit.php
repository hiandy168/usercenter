
   
    <div class='bgf clearfix'>
              
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/nav/'.$fun.'type');?>" method="post" onsubmit="return checkfrom();">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                         <input type="hidden" name="type_id" value="<?php echo isset($type_id)?$type_id:(isset($view['type_id'])?$view['type_id']:'');?>">
                        <table cellSpacing=0 width="100%" class="content_view">  
    
                        <tr>
                            <td width='120' class="t">标题:</td>
                            <td>
                                <input  type="text" name="title"  class="required"  size="30"   value="<?php echo isset($view['title'])?$view['title']:'';?>" >
                            </td>
                        </tr>
                
                        <tr>
                            <td width='120' class="t">备注:</td>
                            <td>
                                <textarea   name="remark"><?php echo isset($view['remark'])?$view['remark']:'';?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td width='120' class="t"><?php echo  Mod::t('admin','status') ?>:</td>
                            <td > 
                                  <label  class='w_10'> <?php echo  Mod::t('admin','yes') ?></label>
                                <input  class='w_30' type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label class='w_10'> <?php echo  Mod::t('admin','no') ?></label>
                                 <input  class='w_30' type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
                            </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-primary"></td>
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


