
<div class='bgf clearfix'>
          
<div class="center_top clearfix">
<ul>
    <li><a  class="btn btn-primary"  href="javascript:;">权限设置</a></li>
</ul>

</div>
    
     
<div class="clearfix"></div>
<div class="list">                     
<form name="list_frm" id="ListFrm" action="<?php echo $this->createUrl('usergroup/permission');?>" method="post">
<input type="hidden" name="id" value="<?php echo isset($view['id'])?$view['id']:'';?>">
  <table width="100%" cellspacing="0">
		<thead>
			<tr> 
                            <th  width="80">模块</th>
			  <th class="first_td" width="40"></th>
			  <th  width="140">功能</th>
                          <th  width="350">内部操作</th>
                          <!--<th>子栏目</th>-->
                          <th></th>
			</tr>
		</thead>
		<tbody>	
                     <?php foreach($list as $k=>$item){?>
                        <tr id="list_<?php echo $item['id']?>"     >
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['module']?></td>
                          <td class="first_td"  width="80" style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                              <?php  if($item['fid']){?>
                              <input type="checkbox" name="" value="<?php echo $item['id']?>"  <?php  if(isset($view['permission'][$item['class']])){ echo 'checked=checked'; } ?>  >
                     <?php }else{echo '<b>大分类:</b>';} ?>
                          </td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6"><?php echo $item['fix']?><?php echo Mod::t('admin',$item['class']).Mod::t('admin','model')?></td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6">
                                <?php if(!empty($item['fun_arr'])){?>
                                    <input type="checkbox" onclick='checkall2(this,"<?php echo $item['class'].'[]'?>")' name=""><?php echo Mod::t('admin','all') ?>
                                    <?php foreach ($item['fun_arr'] as $fun): ?>
                                    <input type="checkbox" value="<?php echo $fun?>"  <?php  if(isset($view['permission'][$item['class']])&&in_array($fun,$view['permission'][$item['class']])){ echo 'checked';}?>  name="<?php echo $item['class'].'[]'?>"><?php echo Mod::t('admin',$fun) ?>
                                    <?php endforeach; ?>
                                <?php } ?>
                          </td>
                          <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
                            
                          </td>
                          </tr>	
                    <?php  } ?>
                            
                            <tr>	
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" ></td>
                            <td style="height:38px;background:none;border-bottom:1px solid #e6e6e6" >
                            <input type="submit" value='提交' class="btn btn-success">
                            </td>
                            </tr>	
		</tbody>
	</table>
<!--      <div class="center_footer clearfix">
        <ul>
            <li><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this,'id[]');"><?php echo Mod::t('admin','all') ?></li>
        </ul>
    </div>-->
   </form>
</div>


</div>

 </div>   

