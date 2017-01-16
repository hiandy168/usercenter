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
                          <td><input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" >
                              <a href="<?php echo admin_url("nav/lists/{$item['id']}")?>" style="text-decoration:underline">&nbsp;&nbsp;<?php echo $item['title']?> <em style="font-size:11px;color:#999999"><--点击查看导航树</em></a>
                          </td>
                          <td><?php echo lang($item['type'])?></td>
                          <td><?php echo $item['remark']?></td>
                          <td><?php echo $item['status']?lang('state_1'):lang('state_2');?></td>
                          <td><a href="<?php echo admin_url("nav/lists/{$item['id']}")?>"><?php echo lang('look')?></a></td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
  
      
              
	</form>
</div>


    
 </div>   
</body>
</html>
