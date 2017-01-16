
<div class='bgf clearfix'>
              
<div class="center_top clearfix">
  
</div>


<div class="clearfix"></div>

<div class="form_list">
  <form class="form-horizontal" name="save" method="post" action="<?php echo $this->createAbsoluteUrl('personal/info'); ?>"  autocomplete='off'>
                <input type="hidden" name="id" value="<?php echo isset($info['id']) ? $info['id'] : ''; ?>">
		<div class="form-group">
                    <label class="col-sm-2 control-label">姓名：</label>
                    <div class="col-sm-5">
                       <?php echo isset($info['name']) ? $info['name']: ''; ?>
                    </div>
                </div>
                
          


                <div class="form-group">
                    <label class="col-sm-2 control-label">性别：</label>
                    <div class="col-sm-5">
                        <?php if ($info['status'] == 1) {
                            echo '男';
                        }else{
                            echo '女';
                        }
                        ?>
                    </div>
                </div>
                
<!--                <div class="form-group">
                            <label class="col-sm-2 control-label">头像：</label>
                            <div class="col-sm-3">
                                <img  style="max-height:80px;width:80px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','picture')" src="<?php  echo isset($info['picture'])?Tool::showuserthumb($info['picture']):'';?>" width="176" height='123' width="150" id="img_thumb">
                                <input type="hidden" name="picture" id="picture" value="<?php echo  isset($info['picture']) ? $info['picture'] : ''; ?>">
                                <span  class="btn btn-danger" onclick="upload_pic('img_thumb','picture')">上传头像</span>
                            </div>
                 </div>
                -->
                            
                <div class="form-group">
                    <label class="col-sm-2 control-label">手机号码：</label>
                    <div class="col-sm-5">
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo isset($info['phone']) ?$info['phone']: ''; ?>"  >
                    </div>
                </div>
                            
				<div class="form-group">
                    <label class="col-sm-2 control-label">电话：</label>
                    <div class="col-sm-5">
                        <input type="text" name="tel" id="tel" class="form-control" value="<?php echo isset($info['tel']) ? $info['tel'] : ''; ?>"  >
                    </div>
                </div>
							
                <div class="form-group">
                    <label class="col-sm-2 control-label">联系地址：</label>
                    <div class="col-sm-5">
                        <input type="text" name="address" id="address" class="form-control" value="<?php echo isset($info['address']) ? $info['address']: ''; ?>"  >
                    </div>
                </div>
							
                <div class="form-group">
                    <label class="col-sm-2 control-label">email：</label>
                    <div class="col-sm-5">
                        <input  type="text" name="email" id="email" class="form-control" value="<?php echo isset($info['email']) ?$info['email']: ''; ?>"  >
                    </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">qq：</label>
                    <div class="col-sm-5">
                        <input  type="text" name="qq" id="qq" class="form-control" value="<?php echo isset($info['qq']) ?$info['qq']: ''; ?>"  >
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">微信：</label>
                    <div class="col-sm-5">
                        <input  type="text" name="wx" id="wx" class="form-control" value="<?php echo isset($info['wx']) ?$info['wx']: ''; ?>"  >
                    </div>
                </div>
				


                <div class="form-group form-actions">
				    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-primary" type="submit">提交</button>
                    </div>
                </div>
            </form>

</div>

 </div>   


