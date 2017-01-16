<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>用户组</title>
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
            <li class="btn"><span>权限管理</a></span>  
<!--            <li class="btn_b"><a href="javascript:;" onclick="submitdel_bat('<?php echo admin_url("permission/del")?>')"><?php echo lang('del')?></a></li>    -->
            <li class="btn_b"><a href="<?php echo admin_url('permission/add')?>"><?php echo lang('add')?></a></li>   
        </ul>
    </div>
  
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"></th>
			  <th width="50">id</th>
                          <th width="250">标题</th>
                          <th width="250">控制器</th>
                          <th>方法</th>
                          <th width="50">状态</th>
			  <th width="100">操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40" style='height:38px;background:none;border-bottom:1px solid #e6e6e6'></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['id']?></td>
                          <td style='height:38px;line-height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['fix']?><input name="order[]" ref="<?php echo $item['id']?>" style='width:28px;height:20px;line-height:20px;text-align:center;margin:0 2px 0 0;' value="<?php echo $item['order']?$item['order']:'99'?>"><?php echo lang($item['class']).lang('model')?>  </td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['class']?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['fun']?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'><?php echo $item['status']?'启用':'禁用';?></td>
                          <td style='height:38px;background:none;border-bottom:1px solid #e6e6e6'>
                              <a class="a_btn a_edit" href="<?php echo admin_url("permission/edit/{$item['id']}")?>">编辑</a> 
                              <a class="a_btn a_del" onclick="del('<?php echo admin_url("permission/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
      
       <div class="center_footer clearfix">
        <ul> 
            <li class="btn_b" ><a href="<?php echo admin_url('permission/add')?>"><?php echo lang('add')?></a></li>   
            <li class="btn_b" style='margin:0 0 0 5px;'><a href="javascript:;" onclick="submitorder('<?php echo admin_url("permission/order")?>')"><?php echo lang('order')?></a></li>   
        </ul>
    </div>
      
	</form>
</div>
 </div>   
</body>
</html>
