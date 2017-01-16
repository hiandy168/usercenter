
<div class='bgf clearfix'>
     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th  width="40">id</th>
                          <th>语言名称</th>
                          <th  width="80">状态</th>
			  <th  width="80">操作</th>
			</tr>
		</thead>
		<tbody>	
               
                    <?php foreach($language as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td><?php echo $item['id']?></td>
                          <td><?php echo $item['title']?></td>
                          <td><?php echo $item['status']?'启用':'禁用';?></td>
                          <td>
                              <a class="a_edit" href="<?php echo $this->createUrl("lang/edit/",array('id'=>$item['id']))?>">编辑</a> 
                              <a class="a_del " onclick="del('<?php echo $this->createUrl("lang/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a>
                          </td>
                        </tr>	
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
                        ?></div>
	</form>
</div>

<div class="center_top">
    <div class="control_nav clearfix"> 
        <ul>
            <li><a  class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("lang/del")?>')">删除</a></li>    
            <li><a  class="btn btn-primary" href="<?php echo $this->createUrl('lang/add')?>">添加</a></li>   
        </ul>
    </div>
</div>

 </div>   


