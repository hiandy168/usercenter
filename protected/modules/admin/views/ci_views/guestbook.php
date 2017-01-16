<?php $this->load->view('header');?>
<div class='bgf clearfix'>
  
<div class="center_top">
    <div class="control_nav"> 
        <ul>
            <li class="btn"><span>留言板</a></span>  
            <li class="btn_left"><a href="javascript:;" onclick="del_bat('<?php echo admin_url("guestbook/del")?>')">删除</a></li>    
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
                          <th  width="120"><?php echo lang('name')?></th>
                          <th  width="150"> <?php echo lang('email')?></th>
                          <th  width="120"><?php echo lang('phone')?></th>  
			  <th><?php echo lang('content')?></th>
                          <th>操作</th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>">
                          <td class="first_td"  width="40"><input type="checkbox" name="id[]" value="<?php echo $item['id']?>" ></td>
                          <td width="40"><?php echo $item['id']?></td>
                          <td  width="120"><?php echo $item['name']?></td>
                          <td  width="150"><?php echo $item['email']?></td>
                          <td  width="120"><?php echo $item['phone']?></td>
                          <td><textarea  rows="5" cols="60" style="margin:5px;"><?php echo $item['content']?></textarea></td>
                          <td><a class="a_btn a_del" onclick="del('<?php echo admin_url("guestbook/del")?>','<?php echo $item['id'] ?>')" href="javascript:;">删除</a></td>
                        </tr>	
                    <?php } ?>
		</tbody>
	</table>
                <div class="pages clearfix"><p class="clearfix"><?php echo $page_str;?></p></div>
	</form>
</div>
 </div>   
</body>
</html>
