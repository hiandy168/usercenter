
<div class='bgf clearfix'>
              

<div class="form_list">
    <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/fragment/'.$fun); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
	<table cellSpacing=0 width="780px" class="content_view">
        <tr>
               <td class="t"><?php echo Mod::t('admin','title')?></td>
		<td  colspan='4'>
                    <input type="text" name="title" id="title" class="required"   size='58' value="<?php echo isset($view['title'])?$view['title']:'';?>">
		</td>
                </td>
	</tr>
        
         <tr>
               <td class="t"><?php echo Mod::t('admin','alias')?></td>
		<td  colspan='4'>
                    <input type="text" name="alias" id="alias" class="required"   size='58' value="<?php echo isset($view['alias'])?$view['alias']:'';?>">
		</td>
                </td>
	</tr>
        <tr>
		<td class="t"><?php echo Mod::t('admin','content')?></td>
		<td  colspan='5'><textarea style="width:650px;height:300px;" name="content" id="content" class="editor"><?php echo isset($view['content'])?htmlspecialchars($view['content']):'';?></textarea></td>
        </tr>
	<tr>
		<td class="t">排序</td>
		<td><input type="text" name="order" id="order" value="<?php if(isset($view['order'])){echo $view['order'];}else{echo '99';} ?>" ></td>
	</tr>
        <tr>
            <td class="t"><?php echo Mod::t('admin','status')?></td>
                <td colspan='3'> 
                                <label class="w_10"> <?php echo  Mod::t('admin','yes') ?></label>
                                <input class="w_30" type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label class="w_10"> <?php echo  Mod::t('admin','no') ?></label>
                                 <input class="w_30" type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
        </tr>
          <tr>
                            <td width='80' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn2"></td>
                            <td width='80' align='right' style="border:none"></td>
                        </tr>
	</table>
	</form>

</div>


    
 </div>   


