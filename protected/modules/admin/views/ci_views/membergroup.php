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
    
<div class="center_top clearfix">
        <ul>
            <li class="btn"><span>管理会员分组</a></span>  
        </ul>

<!--    <div class="center_search"> 
        <form name="search_frm" id="SearchFrm" method="get"> 
            <select name="member[status]" id="member_status">
            <option value="1">超级管理员</option>
            </select>
            <input type="submit" name="search" class="btn"  value="搜索" /> 
        </form> 
    </div> -->
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th>id</th>
                          <th>排序</th>
			  <th>用户组名称</th>
                          <th>状态</th>
			  <th>描述</th>
			  <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($group as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>"     >
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2"  style="text-align:center"  ></td>
                          <td><?php echo $item['name']?></td>
                          <td><?php echo $item['status']?lang('state_1'):lang('state_2');?></td>
                          <td><?php echo $item['description']?></td>
                          <td><a href="<?php echo admin_url("membergroup/permission/{$item['id']}")?>">权限设置</a>  <a href="<?php echo admin_url("membergroup/edit/{$item['id']}")?>"><?php echo lang('edit')?></a> <a onclick="del('<?php echo admin_url("membergroup/del")?>','<?php echo $item['id'] ?>')" href="javascript:;"><?php echo lang('del')?></a></td>
                        </tr>	
                    <?php  } ?>
		</tbody>
	</table>
      <div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li class="btn_left"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("membergroup/del")?>')"><?php echo lang('del')?></a></li>    
            <li class="btn_right"><a href="javascript:;" onclick="submitorder('<?php echo admin_url("membergroup/order")?>')"><?php echo lang('order')?></a></li>   
            <li class="btn_b" style='margin:0 0 0 5px;'><a href="<?php echo admin_url('membergroup/add')?>"><?php echo lang('add')?></a></li>   
        </ul>
    </div>
    
                <div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>
	</form>
</div>


</div>

 </div>   
</body>
</html>
