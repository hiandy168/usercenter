<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/artDialog/jquery.artDialog.js?skin=default"></script>
    </head>
    <body>
<div class='bgf clearfix'>
               
<div class="center_top clearfix">
        <ul>
            <li><span class="btn btn-primary">管理用户分组</span>  
        </ul>

<!--    <div class="center_search"> 
        <form name="search_frm" id="SearchFrm" method="get"> 
            <select name="member[status]" id="member_status">
            <option value="1">超级管理员</option>
            </select>
            <input type="submit" name="search" class="btn"  value="搜索" /> 
        </form> 
    </div> -->
</div>

     
<div class="clearfix"></div>
<div class="list">
  <form name="list_frm" id="ListFrm" action="" method="post">
  <table width="100%" cellspacing="0">
		<thead>
			<tr>
			  <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"></th>
			  <th>id</th>
                          <!--<th>排序</th>-->
			  <th>用户组名称</th>
                          <th>状态</th>
			  <th>描述</th>
                          <th>是否管理分组</th>
			  <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($group as $k=>$item){?>
                        <tr id="list_<?php echo $item->id?>"     >
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item->id?>"   <?php if($item->id==1){?>disabled="disabled"<?php } ?>></td>
                          <td><?php echo $item->id?></td>
                          <!--<td><input type="text" name="order[]" ref="<?php echo $item->id?>" value="<?php echo $item->order?>" size="2"  style="text-align:center"  ></td>-->
                          <td><?php echo $item->name?></td>
                          <td><?php echo $item->status?启用:禁用?></td>
                          <td><?php echo $item->description?></td>
                          <td>
                              <?php echo $item->admin?'是':'否';?>
                              <?php  if($item->admin && $item->id!=1){ ?>
                              <a href="<?php echo $this->createUrl("membergroup/permission/",array("id"=>$item->id));?>">权限设置</a>
                              <?php }?>
                          </td>
                          <td>
                            <a class='a_edit' href="<?php echo $this->createUrl("membergroup/edit/",array('id'=>$item->id))?>">编辑</a> 
                            <?php if($item->id!=1){?>
                            <a class='a_del' onclick="del('<?php echo $this->createUrl("membergroup/del")?>','<?php echo $item->id ?>')" href="javascript:;">删除</a>
                            <?php } ?>
                          </td>
                        </tr>	
                    <?php  } ?>
		</tbody>
	</table>
      <div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');">全选</li>
            <li><a class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("membergroup/del")?>')">删除</a></li>    
<!--            <li><a class="btn btn-primary" href="javascript:;" onclick="submitorder('<?php echo $this->createUrl("membergroup/order")?>')">排序</a></li>   -->
            <li><a class="btn btn-primary" href="<?php echo $this->createUrl('membergroup/add')?>">添加</a></li>   
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

 </div>   
</body>
</html>
