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
            <li class="btn_b"><a href="<?php echo admin_url('db/index')?>">数据库管理</a></li>    
            <li class="btn_b  btn"><a href="<?php echo admin_url('db/download')?>"><?php echo  lang('sqldown') ?></a></li>   
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
                          <th>文件名称</th>
			  <th>文件大小</th>
                          <th>备份时间</th>
                          <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($items as $k=>$item){?>
                        <tr id="list_<?php echo base64_encode($item['name'])?>">
                            <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo base64_encode($item['name'])?>" ></td>
                          <td><?php echo $item['name']?></td>
                          <td><?php echo $item['size']?></td>
                          <td><?php echo $item['date']?></td>
                          <td>
                              <a href="<?php echo admin_url("db/download").'/'.base64_encode($item['name']) ?>"><?php echo lang('down')?></a>
                              <a onclick="del('<?php echo admin_url("db/del")?>','<?php echo base64_encode($item['name']) ?>')" href="javascript:;"><?php echo lang('del')?></a>
                          </td>
                          </tr>	
                    <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
    <ul>
        <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li class="btn_b"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("db/del")?>')"><?php echo lang('del')?></a></li>    
    </ul>
 </div>
                <!--<div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>-->
	</form>
   
</div>


 </div>   
</body>
</html>
