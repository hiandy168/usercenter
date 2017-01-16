
<div class='bgf clearfix'>
   
<div class="center_top">
     <?php if(!empty($categoryarr)){?>
    <div class="center_search"> 
        <form name="search_frm" action="<?php echo $this->createUrl("guestbook/lists")?>" id="SearchFrm" method="post"> 
                  <select name="category_id">
                     <option value=""><?php echo Mod::t('admin','select')?></option>
                    <?php foreach($categoryarr as $category):?>
                    <option value="<?php echo $category['id']?>"<?php if (isset($category_id)&&$category_id==$category['id']): ?>selected<?php endif; ?>><?php echo $category['name']?></option>
                    <?php endforeach;?>
		</select>
            <input type="submit" name="search" class="btn btn-info"  value="搜索" /> 
        </form>           
    </div>  
    <?php } ?>
    
    <div class="control_nav"> 
        <ul>
            <li><span class="btn btn-primary">留言板</span></li> 
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("guestbook/del")?>')">删除</a></li>    
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
			  <th width="40">id</th>
                          <th  width="120"><?php echo Mod::t('admin','name')?></th>
                          <th  width="150"> <?php echo Mod::t('admin','email')?></th>
                          <th  width="120"><?php echo Mod::t('admin','phone')?></th>  
			  <th><?php echo Mod::t('admin','content')?></th>
                          <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php if(!empty($list)){foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td width="40"><?php echo $item['id']?></td>
                          <td  width="120"><span style='color:#06c'>[<?php echo  $categoryarr[$item['category_id']]['name'] ?>]</span><?php echo $item['name']?></td>
                          <td  width="150"><?php echo $item['email']?></td>
                          <td  width="120"><?php echo $item['phone']?></td>
                          <td><textarea  rows="5" cols="60" style="margin:5px;"><?php echo $item['content']?></textarea></td>
                          <td><a class="a_btn a_del" onclick="del('<?php echo $this->createUrl("guestbook/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                      <?php }}else{ ?>
                        <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                     <?php } ?>
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
	</form>
</div>
 </div>   


