<?php $this->load->view('header');?>
<div class='bgf clearfix'>
            
<div class="center_top clearfix">
    <div class="center_search"> 
        <form name="search_frm" action="<?php echo admin_url("pic/lists")?>" id="SearchFrm" method="post"> 
                  <select name="type_id">
                     <option value=""><?php echo lang('select')?></option>
                    <?php foreach($categoryarr as $category):?>
                    <option value="<?php echo $category['id']?>"<?php if (isset($type_id)&&$type_id==$category['id']): ?>selected<?php endif; ?>><?php echo $category['name']?></option>
                    <?php endforeach;?>
		</select>
            <input type="submit" name="search" class="btn"  value="搜索" /> 
        </form> 
    </div> 
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th width="60">id</th>
                          <th width="60" ><?php echo lang('order')?></th>
			  <th><?php echo lang('title')?></th>
                          <th width="60"><?php echo lang('hits')?></th>
                          <th width="60"><?php echo lang('status')?></th>
                          <th width="160"><?php echo lang('createtime')?></th>
			  <th width="150"><?php echo lang('operation')?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]"  value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2"  style="text-align:center"  ></td>
                          <td><?php echo $item['title']?></td>
                          <td><?php echo $item['hits']?></td>
                          <td><?php echo $item['status']?lang('state_1'):lang('state_2');?></td>
                          <td><?php echo date('Y-m-d H:i:s',$item['createtime'])?></td>
                          <td>
                              <a class="a_pic" href="<?php echo admin_url("pic/pics/{$item['id']}")?>"><?php echo lang('pic')?></a>  
                              <a class="a_edit" href="<?php echo admin_url("pic/edit/{$item['id']}")?>"><?php echo lang('edit')?></a> 
                              <a class="a_del" onclick="del('<?php echo admin_url("pic/del")?>','<?php echo $item['id'] ?>')" href="javascript:;"><?php echo lang('del')?></a>
                          </td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li class="btn_b"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("pic/del")?>')"><?php echo lang('del')?></a></li>      
            <li class="btn_b" style='margin:0 0 0 5px;'><a href="javascript:;" onclick="submitorder('<?php echo admin_url("pic/order")?>')"><?php echo lang('order')?></a></li>   
            <li class="btn_b"><a href="<?php echo admin_url('pic/add')?>"><?php echo lang('add')?></a></li> 
        
        </ul>
 </div>   
      
                <div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>
	</form>
</div>


    
 </div>   
</body>
</html>
