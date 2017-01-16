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
            <li class="btn_b btn"><a href="<?php echo admin_url('db/index')?>">数据库管理</a></li>    
            <li class="btn_b"><a href="<?php echo admin_url('db/download')?>"><?php echo  lang('sqldown') ?></a></li>   
            <li class="btn_b"><a href="<?php echo admin_url('db/mysqlcmd')?>"><?php echo  lang('sqlcmd') ?></a></li>   
        </ul>
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
                          <th><?php echo  lang('table_name') ?></th>
			  <th><?php echo  lang('table_type') ?></th>
                          <th><?php echo  lang('table_row') ?></th>
                          <th><?php echo  lang('table_size') ?></th>
			  <th><?php echo  lang('table_index') ?></th>
                          <th><?php echo  lang('table_free') ?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($items as $k=>$item){?>
                        <tr id="list_<?php echo $item['Name']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['Name']?>" ></td>
                          <td><?php echo $item['Name']?></td>
                          <td><?php echo $item['Engine']?></td>
                          <td><?php echo $item['Rows']?></td>
                          <td><?php echo $item['Data_length']?></td>
                          <td><?php echo $item['Index_length']?></td>
                          <td><?php echo $item['Data_free']?></td>
                          </tr>	
                    <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
    <ul>
        <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
        <li class="btn_b"><a href="javascript:;" onclick="submit_bat('<?php echo admin_url("db/backup")?>')">备份数据库</a></li>    
        <li class="btn_b"><a href="javascript:;" onclick="submit_bat('<?php echo admin_url("db/optimize")?>')">优化数据库</a></li> 
    </ul>
 </div>
                <!--<div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>-->
	</form>
   
</div>


 </div>   
</body>
</html>
