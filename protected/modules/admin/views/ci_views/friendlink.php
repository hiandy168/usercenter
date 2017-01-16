<?php $this->load->view('header');?>
<div class='bgf clearfix'>
    
<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li class="btn"><span>模块管理</a></span>  
            <li class="btn_left"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("friendlink/del")?>')">删除</a></li>    
            <li class="btn_right"><a href="javascript:;" onclick="submitorder('<?php echo admin_url("friendlink/order")?>')">排序</a></li>   
            <li class="btn_b"><a href="<?php echo admin_url('friendlink/add')?>"><?php echo lang('add')?></a></li>   
        </ul>
    </div>

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
			  <th>标题</th>
                          <th>图片</th>
                          <th>链接</th>  
			  <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" ></td>
                          <td><span  style="font-size:14px;color:green"><?php echo (($item['type_id'])?"[".$type_arr[$item['type_id']]['title']."]":'')?></span><?php echo $item['title']?></td>
                          <td><?php if($item['picture']){ ?><img height="50" src="<?php echo show_img($item['picture']) ?>"><?php } ?></td>
                          <td><?php echo $item['url']?></td>
                          <td><a href="<?php echo admin_url("friendlink/edit/{$item['id']}")?>">编辑</a> <a onclick="del('<?php echo admin_url("friendlink/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
                <div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>
	</form>
</div>
 </div>   
</body>
</html>
