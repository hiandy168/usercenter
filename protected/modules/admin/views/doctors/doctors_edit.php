
<div class='bgf clearfix'>
              
<div class="center_top clearfix">
  
</div>


<div class="clearfix"></div>

<div class="form_list">
    <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/doctors/'.$fun); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
	<table cellSpacing=0 width="780px" class="content_view">
            
<!--             <tr>
                <td class="t">分类</td>
                <td colspan='3'> 
                <label> PC网页
                <input  class='w_30' type="checkbox" name="web" value="1" <?php if (isset($view['web']) && $view['web'] == 0) {
                echo 'checked';
                }else{ echo 'checked'; } ?> />
                </label>
                <label>WAP手机
                <input  class='w_30' type="checkbox" name="wap" value="1" <?php if (isset($view['wap']) && $view['wap'] == 0) {
                echo 'checked';
                }else{ echo 'checked'; }  ?>  />
                </label>
                </td>
                <td class="t"></td><td></td>
	</tr>-->
	<tr>
                <td class="t"><?php echo Mod::t('admin','selecttype')?></td>
		<td colspan='4'>
       
                <select name="offices_id"  class="required" id="offices_id">
                     <option value=""><?php echo Mod::t('admin','select')?></option>
                    <?php if(!empty($officesarr)){foreach($officesarr as $offices){?>
                    <option value="<?php echo $offices['id']?>"<?php if (isset($view['offices_id'])&&$view['offices_id']==$offices['id']): ?>selected<?php endif; ?>>
                    <?php echo $offices['fix'].$offices['name']?>
                    </option>
                    <?php }}?>
		</select>

                </td>
                <td rowspan="3" class="thumb" width="200" >
                    <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')" src="<?php  echo isset($view['picture'])?(Tool::show_img($view['picture'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumb">
                    <input type="hidden" name="picture" id="picture" value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                    <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                    <span  class="btn btn-danger" onclick="upload_pic('img_thumb','picture')"><?php echo Mod::t('admin','upload_pic')?></span>
                    </p>
                </td>
	</tr>
        
        
	<tr>
		<td class="t">姓名</td>
		<td  colspan='4'>
                    <input  style="float: left;display:inline-block" type="text" name="title" id="title" class="required"  size='40' value="<?php echo isset($view['title'])?$view['title']:'';?>">
                    <label  style="float: left;display:inline-block;width:30px;" class='w_10'>&nbsp;名医</label>
                    <input   style="float: left;display:inline-block" class='w_30' type="checkbox" name="typefor[recommend]"  value='1'  <?php if(isset($view['recommend']) && $view['recommend'] == 1) {
                    echo 'checked';
                    } ?>  />
		</td>
	</tr>
<!--	<tr>
		<td class="t"><?php echo Mod::t('admin','keywords')?></td>
		<td  colspan='4'><input type="text" name="keywords" id="keywords"   size='58' value="<?php echo isset($view['keywords'])?$view['keywords']:'';?>"></td></tr>-->
	<tr>
		<td class="t"><?php echo Mod::t('admin','description')?></td>
		<td  colspan='5'><textarea rows="5" cols="55" class="txtarea" name="description" id="description"><?php echo isset($view['description'])?$view['description']:'';?></textarea></td></tr>
<!--	<tr>
		<td class="t">tags:</td>
		<td  colspan='4'><input type="text" name="tags" id="tags"   size='58' value="<?php echo isset($view['tags'])?$view['tags']:'';?>">tags请用','(英语逗号)  或者   '空格'隔开</td></tr>-->
	
        <tr>
		<td class="t"><?php echo Mod::t('admin','content')?></td>
		<td  colspan='5'><textarea style="width:650px;height:300px;" name="content" id="content" class="editor"><?php echo isset($view['content'])?htmlspecialchars($view['content']):'';?></textarea></td></tr>
<!--	 <tr>
            <td class="t"><?php echo Mod::t('admin','tpl')?></td>
		<td><input type="text" name="tpl" id="tpl"  value="<?php echo isset($view['tpl'])?$view['tpl']:'';?>"></td>
            </tr>-->
<!--	<tr>
		<td class="t"><?php echo Mod::t('admin','copyfrom')?></td>
		<td><input type="text" name="copyfrom" id="copyfrom"  value="<?php echo isset($view['copyfrom'])?$view['copyfrom']:'';?>"></td>
		<td class="t"><?php echo Mod::t('admin','auther')?></td>
		<td  colspan='3'><input type="text" name="auther" id="auther" size="52"  value="<?php echo isset($view['auther'])?$view['auther']:''?>"></td>
	</tr>-->
<!--	<tr>
		<td class="t"><?php echo Mod::t('admin','hits')?></td>
		<td><input type="text" name="hits" id="hits"   value="<?php echo isset($view['hits'])?$view['hits']:0?>"></td>
		<td class="t"><?php echo Mod::t('admin','createtime')?></td>
		<td colspan='3'><input type="text" name="createtime" id="createtime"   size="52" value="<?php echo isset($view['createtime'])?date('Y-m-d H:i:s',$view['createtime']):date('Y-m-d H:i:s')?>"></td>
	</tr>-->
        <tr>
		<td class="t">排序</td>
		<td colspan='5'><input type="text" name="order" id="order" value="<?php if(isset($view['order'])){echo $view['order'];}else{echo '99';} ?>" ></td>
        </tr>
<!--         <tr>
		<td class="t">类型</td>
		<td>
                   <label  class='w_10'>顶置</label>
                    <input  class='w_30' type="checkbox" name="typefor[top]" value='1' <?php if(isset($view['top']) && ($view['top'] == 1)) {
                    echo 'checked';
                    } ?> />
                    <label  class='w_10'>焦距</label>
                    <input  class='w_30' type="checkbox" name="typefor[focus]" value='1' <?php if(isset($view['focus']) && ($view['focus'] == 1)) {
                    echo 'checked';
                    } ?> 
                    <label class='w_10'>名医</label>
                    <input  class='w_30' type="checkbox" name="typefor[recommend]"  value='1'  <?php if(isset($view['recommend']) && $view['recommend'] == 1) {
                    echo 'checked';
                    } ?>  />
                   <label  class='w_10'>精选</label>
                    <input  class='w_30' type="checkbox" name="typefor[choiceness]"  value='1'  <?php if(isset($view['choiceness']) && $view['choiceness'] == 1) {
                    echo 'checked';
                    } ?> />
                    <label class='w_10'>热点</label>
                    <input  class='w_30' type="checkbox" name="typefor[hot]"  value='1'  <?php if(isset($view['hot']) && $view['hot'] == 1) {
                    echo 'checked';
                    } ?>  />
                </td>
                <td class="t"></td><td></td>
	</tr>
 -->     
        <tr>
                <td class="t"><?php echo Mod::t('admin','status')?></td>
                <td colspan='5'> 
                <label  class='w_10'> <?php echo  Mod::t('admin','yes') ?></label>
                <input  class='w_30' type="radio" name="status" value="1" <?php if (!isset($view['status']) || $view['status'] == 1) {
                echo 'checked';
                } ?> />
                <label class='w_10'> <?php echo  Mod::t('admin','no') ?></label>
                <input  class='w_30' type="radio" name="status" value="0" <?php if (isset($view['status']) && $view['status'] == 0) {
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


