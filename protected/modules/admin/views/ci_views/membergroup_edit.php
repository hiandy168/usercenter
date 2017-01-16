<?php $this->load->view('header.php');?>
<div class='bgf clearfix'>
     
<div class="center_top clearfix">
<ul>
    <li class="btn"><a  href="<?php echo admin_url('membergroup/add')?>">添加会员分组</a></span>  
</ul>

</div>
    

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo admin_url('membergroup').'/'.$fun;?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">
                        <tr>
                            <td width='120' align="right">会员分组名称:</td>
                            <td><input type="text" name="name"  class="required input-text"  value="<?php echo isset($view['name'])?$view['name']:'';?>"></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>会员分组状态:</td>
                            <td>
                                <label for="status1">启用</label> <input id='status1' type="radio" name="status" value="1" <?php if(!isset($view['status'])||$view['status']==1){echo 'checked';} ?> />   
    
                                <label for="status0">&nbsp;&nbsp;禁用</label> <input id='status0' type="radio" name="status" value="0" <?php if(isset($view['status'])&&$view['status']==0){echo 'checked';} ?>  />
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>会员分组排序:</td>
                            <td><input type="text" name="order" id="order[]" value="<?php echo isset($view['order'])?$view['order']:'99';?>" class="input-text" value=""></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>会员分组描述:</td>
                            <td><textarea name='description'><?php echo isset($view['description'])?$view['description']:''; ?></textarea></td>
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
