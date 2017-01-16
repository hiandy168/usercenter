
   <div class='bgf clearfix'>
    

    
<div class="clearfix"></div>

    

             
                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('lang/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">
                        <tr>
                            <td width='120' align="right">语言名称:</td>
                            <td><input type="text" name="title" id="title" class="required"  class="validate input-text" validtip="required" value="<?php echo isset($view['title'])?$view['title']:'';?>"></td>
                        </tr>
                        <tr>
                            <td width='120' align="right">语言目录:</td>
                            <td><input type="text" name="dir" id="dir" class="validate input-text" validtip="required" value="<?php echo isset($view['dir'])?$view['dir']:'';?>"></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>会员分组状态:</td>
                            <td>
                                <label for="status1"  class="w_30">启用</label> <input  class="w_30" id='status1' type="radio" name="status" value="1" <?php if(!isset($view['status'])||$view['status']==1){echo 'checked';} ?> />   

                                <label for="status0" class="w_30">禁用</label> <input  class="w_30"id='status0' type="radio" name="status" value="0" <?php if(isset($view['status'])&&$view['status']==0){echo 'checked';} ?>  />
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


