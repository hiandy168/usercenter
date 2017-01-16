<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/artDialog/jquery.artDialog.js?skin=default"></script>
    </head>
    <body>
<div class='bgf clearfix'>
             
<div class="center_top clearfix">
<ul>
        <li><a   class="btn btn-primary" href="#">编辑用户分组</a></li>
    <li><a  class="btn  btn-primary" href="<?php echo $this->createUrl('usergroup/add')?>">点击添加用户分组</a></span></li>
</ul>

</div>
    

                <div class="form_list">
                       <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/usergroup/'.$fun);?>" method="post">
                        <input type="hidden" name="id" value="<?php echo isset($model->id)?$model->id:'';?>">
                        <table cellSpacing=0 width="100%" class="content_view">
                        <tr>
                            <td width='120' align="right">用户分组名称:</td>
                            <td><input type="text" name="name"  class="required input-text"  value="<?php echo isset($model->name)?$model->name:'';?>"></td>
                        </tr>
                         <tr>
                            <td width='120' align='right'>是否管理员:</td>
                            <td>
                                <label for="status1" class='w_10'>是</label> <input class='w_30'  id='status1' type="radio" name="admin" value="1" <?php if(isset($model->admin)&&$model->admin==1){echo 'checked';} ?> />   
    
                                <label for="status0" class='w_10'>否</label> <input  class='w_30' id='status0' type="radio" name="admin" value="0" <?php if(!isset($model->admin)|| !$model->admin){echo 'checked';} ?>  />
                            </td>
                        </tr> 
                        <tr>
                            <td width='120' align='right'>用户分组状态:</td>
                            <td>
                                <label for="status1"  class='w_30'>启用</label> <input class='w_30'  type="radio" name="status" value="1" <?php if(!isset($model->status)||$model->status==1){echo 'checked';} ?> />   
                                <label for="status0"  class='w_30'>禁用</label> <input class='w_30'  type="radio" name="status" value="0" <?php if(isset($model->status)&&$model->status==0){echo 'checked';} ?>  />
                            </td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>用户分组排序:</td>
                            <td><input type="text" name="order" id="order[]" value="<?php echo isset($model->order)?$model->order:'99';?>" class="input-text" value=""></td>
                        </tr>
                        <tr>
                            <td width='120' align='right'>用户分组描述:</td>
                            <td><textarea name='description'><?php echo isset($model->description)?$model->description:''; ?></textarea></td>
                        </tr>
                         <tr>
                            <td width='120' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                        </tr>
                        </table>        
                        </form>
                </div>
    </div>
</body>
</html>
