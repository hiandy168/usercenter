
<div class='bgf clearfix'>
     
<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li><a  class="btn btn-primary" href="<?php echo $this->createUrl('nav/add/')?>">添加</a></li>   
            <li><a  class="btn btn-primary" href="<?php echo $this->createUrl('nav/addtype')?>"><?php echo Mod::t('admin','add').Mod::t('admin','type')?></a></li>
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
			  <th>标题</th>
                          <th>图片</th>
                          <th>链接</th> 
                          <th>状态</th> 
			  <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php  if(isset($list)){foreach($list as $k=>$item){?>
                    <tr id="list_<?php echo $item['id']?>">
                    <!--<tr id="list_<?php echo $item['id']?>" <?php if($item['level']>1){ echo 'style="display:none"'; }?> >-->
                          <td class="first_td"  width="40" style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['id']?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                              <?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$item['level']-1);?>
                              <!--<span style="font-size:16px;margin:0 5px;"><?php if(isset($item['has_childen'])&&$item['has_childen']){ echo '+'; }else{ echo '&nbsp;'; }?></span>-->
                              <input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" >
                                  <?php echo $item['title']?> 
                               <a class="add_for_type" href="<?php echo $this->createUrl("nav/add/{$item['id']}")?>">添加子类</a>
                          </td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php if($item['picture']){ ?><img height="50" src="<?php  echo isset($item['picture'])?(Tool::show_img($item['picture'])):(Tool::show_img(''))?>"><?php } ?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['url']?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['status']?'启用':'禁用'; ?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                              <a  class='a_edit' href="<?php echo $this->createUrl("nav/edit/",array('id'=>$item['id']))?>">编辑</a> 
                              <a  class='a_del' onclick="del('<?php echo $this->createUrl("nav/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                     <?php }} ?>
		</tbody>
	</table>
	</form>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("nav/del")?>')">删除</a></li>    
            <li><a class="btn btn-primary" href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("nav/order")?>')">排序</a></li>   
        </ul>
 </div>    
</div>
 </div>   


