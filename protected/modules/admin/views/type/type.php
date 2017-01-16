<div class='bgf clearfix'>

<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li><a class='btn btn-primary' href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("type/del")?>')">删除</a></li>    
            <li><a class='btn btn-primary' href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("type/order")?>')">排序</a></li>   
            <li><a class='btn btn-primary' href="<?php echo $this->createUrl('type/add')?>">添加<?php echo Mod::t('admin','type')?></a></li>   
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
			  <th><?php echo Mod::t('admin','title')?></th>
                          <th><?php echo Mod::t('admin','type')?></th>
                          <th><?php echo Mod::t('admin','remark')?></th>
                          <th><?php echo Mod::t('admin','status')?></th>
			  <th><?php echo Mod::t('admin','operation')?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php if(!empty($type)){foreach($type as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]"  value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" >&nbsp;<?php echo $item['title']?></td>
                          <td><?php echo Mod::t('admin',$item['type'])?></td>
                          <td><?php echo $item['remark']?></td>
                          <td><?php echo $item['status']?'启用':'禁用'; ?></td>
                          <td>
                              <a class="a_edit" href="<?php echo $this->createUrl("type/edit/",array('id'=>$item['id']))?>">编辑</a> 
                              <a class="a_del" onclick="del('<?php echo $this->createUrl("type/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                      <?php }}else{ ?>
                        <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                     <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li><a  class='btn btn-primary' href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("type/del")?>')">删除</a></li>    
            <li><a  class='btn btn-primary' href="<?php echo $this->createUrl('type/add')?>">添加</a></li>   
        </ul>
 </div>   
      
              
	</form>
</div>


    
 </div>   

</html>
