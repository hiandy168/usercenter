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
    
     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th>id</th>
                          <th>语言名称</th>
			  <th>目录名</th>
                          <th>状态</th>
			  <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($group as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><?php echo $item['title']?></td>
                          <td><?php echo $item['dir']?></td>
                          <td><?php echo $item['status']?'启用':'禁用';?></td>
                          <td><a href="<?php echo admin_url("lang/edit/{$item['id']}")?>">编辑</a> <a onclick="del('<?php echo admin_url("lang/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
                <div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>
	</form>
</div>

<div class="center_top">
    <div class="control_nav clearfix"> 
        <ul>
            <li class="btn_b"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("lang/del")?>')">删除</a></li>    
            <li class="btn_b"><a href="<?php echo admin_url('lang/add')?>">添加</a></li>   
        </ul>
    </div>
</div>

 </div>   
</body>
</html>
