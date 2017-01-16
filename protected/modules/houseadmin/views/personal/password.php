
<div class='bgf clearfix'>
              
<div class="center_top clearfix">
  
</div>


<div class="clearfix"></div>

<div class="form_list">
<form class="form-horizontal" name="save" method="post" action="<?php echo $this->createAbsoluteUrl('personal/password'); ?>"  autocomplete='off'>
                <input type="hidden" name="id" value="<?php echo isset($info['id']) ? $info['id'] : ''; ?>">

                <div class="form-group">
                    <label class="col-sm-2 control-label">密码密码：</label>
                    <div class="col-sm-3">
                        <input type="password" name="password" class="form-control" id="pwd" value="123456" onblur="if (value == '') {value = '123456'}" onfocus="if (value == '123456') {value = ''}"   autocomplete="off">
                    </div>
					<label class="control-label text-muted">默认密码：123456</label>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">重复输入密码：</label>
                    <div class="col-sm-3">
                        <input type="password" name="repassword" class="form-control" id="repwd" value="123456" onblur="if (value == '') {value = '123456'}" onfocus="if (value == '123456') {value = ''}" >
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

