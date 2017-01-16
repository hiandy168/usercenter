
<div class='bgf clearfix'>
            

<div class="form_list">
    <form name="formview" id="formview" action="<?php echo $this->createUrl('help/'.$fun); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
	<table cellSpacing=0 width="780px" class="content_view">
      	<tr>
<!--                <td class="t"><?php echo Mod::t('admin','selecttype')?></td>
		<td colspan='4'>
       
                <select name="category_id"  class="required" id="category_id">
                     <option value=""><?php echo Mod::t('admin','select')?></option>
                    <?php if(!empty($categoryarr)){foreach($categoryarr as $category){?>
                    <option value="<?php echo $category['id']?>"<?php if (isset($view['category_id'])&&$view['category_id']==$category['id']): ?>selected<?php endif; ?>>
                    <?php echo $category['fix'].$category['name']?>
                    </option>
                    <?php }}?>
		</select>

                </td>-->
                <td rowspan="3" class="thumb" width="200" >
                    <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')" src="<?php  echo isset($view['picture'])?(Tool::show_img($view['picture'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumb">
                    <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                    <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                    <span  class="btn btn-danger" onclick="upload_pic('img_thumb','picture')"><?php echo Mod::t('admin','upload_pic')?></span>
                    </p>
                </td>
	</tr>
	<tr>
		<td class="t"><?php echo Mod::t('admin','title')?></td>
		<td  colspan='4'>
                    <input type="text" name="title" id="title" class="required"  size='50' value="<?php echo isset($view['title'])?$view['title']:'';?>">
		</td>
	</tr>
        
        <tr>
		<td class="t">别名（英文）</td>
		<td  colspan='4'>
                    <input type="text" name="alias" id="alias" class="required"  size='50' value="<?php echo isset($view['alias'])?$view['alias']:'';?>">
		</td>
	</tr>
	<tr>
		<td class="t"><?php echo Mod::t('admin','keywords')?></td>
		<td  colspan='4'><input type="text" name="keywords" id="keywords"   size='58' value="<?php echo isset($view['keywords'])?$view['keywords']:'';?>"></td></tr>
	<tr>
		<td class="t"><?php echo Mod::t('admin','description')?></td>
		<td  colspan='5'><textarea rows="5" cols="77" class="txtarea" name="description" id="description"><?php echo isset($view['description'])?$view['description']:'';?></textarea></td></tr>
	<tr>
		<td class="t"><?php echo Mod::t('admin','content')?></td>
		<td  colspan='5'><textarea style="width:650px;height:300px;" name="content" id="content" class="editor"><?php echo isset($view['content'])?htmlspecialchars($view['content']):'';?></textarea></td></tr>
	 <tr>
            <td class="t"><span style="color:#ff0000">PC端模板文件</span></td>
		<td><input type="text" name="tpl" id="tpl"   onclick="if(this.value=='/help/detail'){ this.value='';this.style.color='#333';}" style="color:#ff0000" value="<?php echo isset($view['tpl'])?$view['tpl']:'/help/detail';?>"></td>
            </tr>
            
          <tr>
            <td class="t"><span style="color:#ff0000">手机端模板文件</span></td>
		<td><input type="text" name="tpl_wap" id="tpl_wap"   onclick="if(this.value=='/help/detail'){ this.value='';this.style.color='#333';}" style="color:#ff0000" value="<?php echo isset($view['tpl_wap'])?$view['tpl_wap']:'/help/detail';?>"></td>
         </tr>
<!--	<tr>
		<td class="t"><?php echo Mod::t('admin','copyfrom')?></td>
		<td><input type="text" name="copyfrom" id="copyfrom"  value="<?php echo isset($view['copyfrom'])?$view['copyfrom']:'';?>"></td>
		<td class="t"><?php echo Mod::t('admin','auther')?></td>
		<td  colspan='3'><input type="text" name="auther" id="auther" size="52"  value="<?php echo isset($view['auther'])?$view['auther']:''?>"></td>
	</tr>-->
	<tr>
		<td class="t"><?php echo Mod::t('admin','hits')?></td>
		<td><input type="text" name="hits" id="hits"   value="<?php echo isset($view['hits'])?$view['hits']:0?>"></td>
		<td class="t"><?php echo Mod::t('admin','createtime')?></td>
		<td colspan='3'><input type="text" name="createtime" id="createtime"   size="52" value="<?php echo isset($view['createtime'])?date('Y-m-d H:i:s',$view['createtime']):date('Y-m-d H:i:s')?>"></td>
	</tr>
       
	<tr>
		<td class="t">排序</td>
		<td><input type="text" name="order" id="order" value="<?php if(isset($view['order'])){echo $view['order'];}else{echo '99';} ?>" ></td>
		<td class="t"><?php echo Mod::t('admin','status')?></td>
                <td colspan='3'> 
                                <label class='w_10'> <?php echo  Mod::t('admin','yes') ?></label>
                                <input  class='w_30' type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                                    echo 'checked';
                                } ?> />
                                 <label class='w_10'> <?php echo  Mod::t('admin','no') ?></label>
                                 <input class='w_30' type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
                                    echo 'checked';
                                } ?>  />
                            </td>
	</tr>
          <tr>
                            <td width='80' align='right' style="border:none"></td>
                            <td  style="border:none"><input type="submit" value='提交' class="btn btn-success"></td>
                            <td width='80' align='right' style="border:none"></td>
                        </tr>
	</table>
	</form>

</div>


    
 </div>   


