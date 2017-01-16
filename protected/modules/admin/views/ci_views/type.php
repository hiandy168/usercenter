<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>部分模块分类</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?=base_url('public/css/admin.css')?>" />
        <script type="text/javascript" src="<?=base_url('public/js/jquery-1.11.0.min.js')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/artDialog/jquery.artDialog.js?skin=default')?>"></script>
        <script type="text/javascript" src="<?=base_url('public/js/admin.js')?>"></script>
    
 </head>
 <body>
<div class='bgf clearfix'>
             
<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li class="btn_b"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("type/del")?>')">删除</a></li>    
            <li class="btn_b"><a href="javascript:;" onclick="submitorder('<?php echo admin_url("type/order")?>')">排序</a></li>   
            <li class="btn_b"><a href="<?php echo admin_url('type/add')?>"><?php echo lang('add')?><?php echo lang('type')?></a></li>   
        </ul>
    </div>

</div>

     
<div class="clearfix"></div>
<div class="list2">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th>id</th>
			  <th><?php echo lang('title')?></th>
                          <th><?php echo lang('type')?></th>
                          <th><?php echo lang('remark')?></th>
                          <th><?php echo lang('status')?></th>
			  <th><?php echo lang('operation')?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($type as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]"  value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" >&nbsp;<?php echo $item['title']?></td>
                          <td><?php echo lang($item['type'])?></td>
                          <td><?php echo $item['remark']?></td>
                          <td><?php echo $item['status']?lang('state_1'):lang('state_2');?></td>
                          <td><a href="<?php echo admin_url("type/edit/{$item['id']}")?>"><?php echo lang('edit')?></a> <a onclick="del('<?php echo admin_url("type/del")?>','<?php echo $item['id'] ?>')" href="javascript:;"><?php echo lang('del')?></a></td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li class="btn_b"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("type/del")?>')"><?php echo lang('del')?></a></li>    
            <li class="btn_b"><a href="<?php echo admin_url('type/add')?>"><?php echo lang('add')?></a></li>   
        </ul>
 </div>   
      
              
	</form>
</div>


    
 </div>   
</body>
</html>
