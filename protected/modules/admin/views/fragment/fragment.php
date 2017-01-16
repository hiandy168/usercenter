
<div class='bgf clearfix'>
               
<div class="center_top clearfix">
    <div class="center_search"> 
        <form name="search_frm" action="<?php echo $this->createUrl("fragment/lists")?>" id="SearchFrm" method="post"> 
            <label>输入关键字搜索：</label><input style="color:#000" name="keyword" type="text" value="<?php echo isset($keyword)?$keyword:''?>">
            <input type="submit" name="search" class="btn btn-success"  value="搜索" /> 
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
                          <th width="60" >排序</th>
			  <th><?php echo Mod::t('admin','title')?></th>
                          <th><?php echo Mod::t('admin','alias')?></th>
                          <th width="60"><?php echo Mod::t('admin','hits')?></th>
                          <th width="60"><?php echo Mod::t('admin','status')?></th>
                          <th width="160"><?php echo Mod::t('admin','createtime')?></th>
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
                          <td><?php echo $item['alias']?></td>
                          <td><?php echo $item['hits']?></td>
                          <td><?php echo $item['status']?'启用':'禁用'; ?></td>
                          <td><?php echo date('Y-m-d H:i:s',$item['createtime'])?></td>
                          <td><a class="a_edit" href="<?php echo $this->createUrl("fragment/edit/",array('id'=>$item['id']))?>">编辑</a> <a class="a_del" onclick="del('<?php echo $this->createUrl("fragment/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                     <?php }}else{ ?>
                        <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                     <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("fragment/del")?>')">删除</a></li>    
            <li><a class="btn btn-primary" href="<?php echo $this->createUrl('fragment/add')?>">添加</a></li>   
            <li style='margin:0 0 0 5px;'><a class="btn btn-primary" href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("fragment/order")?>')">排序</a></li>   
        
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


