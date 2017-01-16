
<div class='bgf clearfix'>
              
<div class="center_top clearfix">
    <?php if(!empty($categoryarr)){?>
    <div class="center_search"> 
        <form name="search_frm" action="<?php echo $this->createUrl("nav/lists")?>" id="SearchFrm" method="post"> 
                  <select name="type_id">
                     <option value=""><?php echo Mod::t('admin','select')?></option>
                    <?php foreach($categoryarr as $category):?>
                    <option value="<?php echo $category['id']?>"<?php if (isset($type_id)&&$type_id==$category['id']): ?>selected<?php endif; ?>><?php echo $category['name']?></option>
                    <?php endforeach;?>
		</select>
            <input type="submit" name="search" class="btn btn-info"  value="搜索" /> 
        </form>           
    </div>  
    <?php } ?>
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
			  <th class="first_td" width="40"></th>
			  <th width="60">id</th>
                          <th width="60" >排序</th>
			  <th><?php echo Mod::t('admin','title')?></th>
                          <th width="300"><?php echo Mod::t('admin','remark')?></th>
                          <th width="60"><?php echo Mod::t('admin','status')?></th>
			  <th width="100"><?php echo Mod::t('admin','operation')?></th>
			</tr>
		</thead>
		<tbody>	
                     <?php if(!empty($list)){foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"></td>
                          <td><?php echo $item['id']?></td>
                          <td><input type="text" name="order[]" ref="<?php echo $item['id']?>" value="<?php echo $item['order']?>" size="2"  style="text-align:center"  ></td>
                          <td><a href="<?php echo $this->createUrl("nav/lists/",array('type_id'=>$item['id']))?>" style="text-decoration:underline;color:#000"><?php echo $item['title']?> <em style="font-size:11px;color:#999999"><--点击查看导航树</em></a></td>
                          <td><?php echo $item['remark']?></td>
                          <td><?php echo $item['status']?'启用':'禁用'; ?></td>
                          <td>
                              <a class="a_edit" href="<?php echo $this->createUrl("nav/edittype/",array('id'=>$item['id']))?>">编辑</a>
                              <a class="a_del" onclick="del('<?php echo $this->createUrl("nav/deltype")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
                     <?php }}else{ ?>
                        <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                     <?php } ?>
		</tbody>
	</table>
<div class="center_footer clearfix">
        <ul>
            <li></li>
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("nav/deltype")?>')">删除</a></li>    
            <li style='margin:0 0 0 5px;'><a class="btn btn-primary" href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("nav/ordertype")?>')">排序</a></li>   
        
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


