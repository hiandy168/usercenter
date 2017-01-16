
<div class='bgf clearfix'>
              
<div class="center_top clearfix">
    <a  style="float:right;padding:4px 20px;" class="btn btn-danger" href="<?php echo $this->createUrl('spec/add')?>">添加规格</a>
</div>


     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th width="60">id</th>
                          <th width="60" >排序</th>
			  <th>规格名称</th>
                          <th>规格选项</th>
			  <th width="100"><?php echo Mod::t('admin','operation')?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php if(!empty($list)){foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]"  value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2"  style="text-align:center"  ></td>
                          <td><?php echo $item['title']?></td>
                          <td></td>
                          <td><a class="a_edit" href="<?php echo $this->createUrl("spec/edit/",array('id'=>$item['id']))?>">编辑</a> <a class="a_del" onclick="del('<?php echo $this->createUrl("spec/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                     <?php }}else{ ?>
                        <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                     <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("spec/del")?>')">删除</a></li>    
            <li style='margin:0 0 0 5px;'><a class="btn btn-primary" href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("spec/order")?>')">排序</a></li>   
        
        </ul>
 </div>   

      <div class="pages clearfix">
            <?php
                        $this->widget('CLinkPager', array('pages' => $pagebar,
                                                        'cssFile' => false,
                                                        'header'=>'',
                                                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                        'prevPageLabel' => '前一页',
                                                            )
                        );
             ?>
      </div>
	</form>
</div>


    
 </div>   


