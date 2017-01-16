<div class='bgf clearfix'>

<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li><span class="btn btn-primary">模块管理</span></li>
            <li><a  class="btn btn-primary" href="<?php echo $this->createUrl('slider/add')?>">添加</a></li>   
        </ul>
    </div>
     <?php if(!empty($type_arr)){?>
    <div class="center_search"> 
        <form name="search_frm" action="<?php echo $this->createUrl("/admin/slider/lists")?>" id="SearchFrm" method="post"> 
                  <select name="type_id">
                     <option value=""><?php echo Mod::t('admin','select')?></option>
                    <?php foreach($type_arr as $type):?>
                    <option value="<?php echo $type['id']?>" <?php if (isset($type_id)&&$type_id==$type['id']): ?>selected<?php endif; ?>><?php echo $type['title']?></option>
                    <?php endforeach;?>
		</select>
            <input type="submit" name="search" class="btn btn-danger"  value="搜索" /> 
        </form>           
    </div>  
    <?php } ?>

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
                     <?php if(!empty($list)){foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" style='text-align:center' ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2" ></td>
                          <td><span  style="font-size:14px;color:green"><?php echo (($item['type_id'] && !empty($type_arr[$item['type_id']]))?"[".$type_arr[$item['type_id']]['title']."]":'')?></span><?php echo $item['title']?></td>
                          <td><?php if($item['picture']){ ?><img height="80" src="<?php  echo isset($item['picture'])?(Tool::show_img($item['picture'])):(Tool::show_img(''))?>"><?php } ?></td>
                          <td><?php echo $item['url']?></td>
                          <td>
                              <a class='a_edit' href="<?php echo $this->createUrl("slider/edit/",array('id'=>$item['id']))?>">编辑</a>
                              <a class='a_del' onclick="del('<?php echo $this->createUrl("slider/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                    <?php }} ?>
		</tbody>
	</table>
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
       <div class="center_footer clearfix">
        <ul>
            <li><a  class="btn btn-primary"href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("slider/del")?>')">删除</a></li>    
            <li><a  class="btn btn-primary"href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("slider/order")?>')">排序</a></li>   
        </ul>
    </div>
	</form>
  
</div>
 </div>   
