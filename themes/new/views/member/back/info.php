<?php $this->renderPartial('/common/header', array('config' => $config)); ?>

<!--cobntent-->
<div class="content member w1200 mgauto mt50">
    <?php $left_active = 'member';?>
    <?php $this->renderPartial('/common/left', array('config' => $config,'left_active'=>$left_active)); ?>

    <!--member_nav end-->
    <div id="loadDiv" class="fr" style="width:860px;" >
    <style>.pl108{padding-left: 108px;}</style>
   	<form id="member_info"> 
        	<div class="member_con register pb50">
            <h2 class="tc mt50">基本信息</h2>
        	<label class="form-con">
                <h3 class="fl w100"><b>*</b> 用户名：</h3>
                <input class="fl" type="text" value="<?php echo isset($this->member['name'])?$this->member['name']:''; ?>" placeholder="用户名"  name="member[name]"></input>
                <span class="fl commom">建议用产品名称，如滴滴打车，不超过6个字</span>
                
             </label>
            <div class="cl"></div> 
            <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>上传头像：</h3>
                  <div class="fl" style="">
                      <input id="file_upload" name="file_upload" type="file" multiple="true">
                      <img id="form_headImg" width="50px" src="<?php echo isset($this->member['picture'])?Tool::show_member_thumb($this->member['picture']):''; ?>" style="margin:auto;<?php  if(isset($this->member['picture']) && $this->member['picture']){ echo 'display:block';}else{ echo 'display:none';} ?>">
                      <input name="member[picture]" value="<?php echo isset($this->member['picture'])?$this->member['picture']:''; ?>" type="hidden" id="headerimg" class="fl" ></div>
                  <span class="fl commom btm">图片尺寸120x120</span>
            </label>
            <div class="cl"></div>
            <label class="form-con">
                <h3 class="fl w100"><b>*</b> 绑定QQ：</h3>
                <input class="fl" type="text" name="member[qq]"  value="<?php echo isset($this->member['qq'])?$this->member['qq']:''; ?>"   placeholder="QQ" ></input>
                <span class="fl commom">建议绑定公司公共QQ，后续上传图文或视频只能通过该QQ登录</span>
              </label>
            <div class="cl"></div> 
             <label class="form-con ">
            	 <h3 class="fl w100"><b>*</b>联系方式：</h3>
                 <input class="fl" type="text"  placeholder="手机号码"   name="member[phone]"  value="<?php echo isset($this->member['phone'])?$this->member['phone']:''; ?>" ></input>
                 <span class="fl commom">手机，只有管理员可见</span>
                 <div class="cl"></div>
                 <div class="ml108">
                 <input class="fl" type="email"  placeholder="email@admin.com"   name="member[email]"  value="<?php echo isset($this->member['email'])?$this->member['email']:''; ?>" ></input>
                 <span class="fl commom">邮箱，只有管理员可见</span>
                 </div >
                 <div class="cl"></div>
                 <div class="ml108">
                 <input class="fl" type="text"  placeholder="微信号"  name="member[wx]"  value="<?php echo isset($this->member['wx'])?$this->member['wx']:''; ?>"></input>
                 <span class="fl commom">微信，只有管理员可见</span>
                 </div>
            </label>
            <div class="cl"></div>
            
            <h2 class="tc pt30 cb">公司信息</h2>
            
           
            <label class="form-con ">
            	 <h3 class="fl w100"><b>*</b>所属公司</h3>
                 <input class="fl" type="text"  name="member[company_name]"  value="<?php echo isset($this->member['company_name'])?$this->member['company_name']:''; ?>"  placeholder="公司名称"></input>
                 <span class="fl commom">政府部门登记名称，如腾楚科技科技有限公司</span>
            </label>
            <div class="cl"></div>
            
             <label class="form-con ">
            	 <h3 class="fl w100"><b>*</b>公司地址</h3>
                 <input class="fl" type="text"  name="member[address]"  value="<?php echo isset($this->member['address'])?$this->member['address']:''; ?>"  placeholder="公司名称"></input>
                 <span class="fl commom"></span>
            </label>
            
            
            <div class="cl"></div>
            <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>行业分类</h3>
                <?php $project_type_arr = JkCms::getproject_type();  ?>
                <select class="fl" name="member[company_type]">
                     <option value="" selected="">--请选择行业--</option>
                <?php foreach($project_type_arr as $project_type):?>
                <option value="<?php echo $project_type['id']?>" <?php if (isset($this->member['company_type'])&&$this->member['company_type']==$project_type['id']): ?>selected<?php endif; ?>><?php echo  $project_type['title']?></option>
                <?php endforeach;?>
                </select>
                 
        
 
             </label>
            <div class="cl"></div>
            <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>融资进度</h3>
              	 <select class="fl" name="member[company_finance]">
                 <?php 
                 $company_finance_arr =array('天使轮','Pre A轮','A轮','A+轮','B轮','B+轮','C轮','D轮','E轮','F轮','G轮','H轮','暂未融资');
                 foreach ($company_finance_arr as $company_finance) {
                      echo "<option value='".$company_finance."' ".((isset($this->member['company_finance']) && $this->member['company_finance']==$company_finance)?"selected=selected":'').">".$company_finance."</option>";
                 }
                 ?>      
                </select>
             </label>
            <div class="cl"></div>
            <label class="form-con " style="position: relative;"  >
            	<h3 class="fl w100 "><span>总融资金额</span></h3>
                 <input class="fl" type="text"  placeholder="" name="member[company_finacetotal]" value="<?php echo isset($this->member['company_finacetotal'])?$this->member['company_finacetotal']:''; ?>"></input>
                <span class="fl commom">格式：2000万元人民币，2亿美元等</span>
              </label>
            <div class="cl"></div>
            <label class="form-con " style="position:relative;">
            	 <h3 class="fl w100"><b>*</b>团队规模</h3>
              	 <select class="fl" name="member[company_size]">
                    <?php 
                    $company_size_arr =array('1-10人','11-50人','51-300人','300-1000人','1000人以上');
                    foreach ($company_size_arr as $company_size) {
                            echo "<option value='".$company_size."' ".((isset($this->member['company_size']) && $this->member['company_size']==$company_size)?"selected=selected":'').">".$company_size."</option>";
                    }
                    ?>   
                </select>
             </label>
            <div class="cl"></div>
             <label class="form-con " style="position: relative;"  >
            	<h3 class="fl w100 "><b>*</b><span>高管组成</span></h3>
                <div  style="display:inline-block;width:560px" class="gaoguan" >
                    <?php $company_leaders = unserialize($this->member['company_leaders']);?>
                    <?php
//                    var_dump($company_leaders);die;
                       $leaders_count = count($company_leaders['name']);
                       if($leaders_count){
                           for($i=0;$i<$leaders_count;$i++){
                    ?>
                    <div class="ggdiv fl " style="position:relative;margin:0 0 10px 0">
                        <div>
                            <input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名" value="<?php echo $company_leaders['name'][$i]?>"></input>
                            <input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写职位"  value="<?php echo $company_leaders['position'][$i]?>"></input>
                            <span class="commom" style="position:absolute;top:0px;left:370px;">
                                <?php if($i){?>
                                      <a class="reduceGg">(点击 -进行删除))</a>
                                <?php }else{ ?>
                                      <a id="addGg">(点击+继续添加))</a>
                                <?php } ?>
                            </span>
                        </div>
                        <div>
                        <textarea class=''   name='company_leaders[remark][]' id='' placeholder='过往经历，如：教育背景、曾就职信息等'><?php echo $company_leaders['remark'][$i]; ?></textarea>
                        </div>
                        <div class="cl"></div> 
                     </div>
                       <?php }}else{ ?>

                     <div class="ggdiv fl "  style="position:relative;margin:0 0 10px 0">
                        <div>
                            <input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名"></input>
                            <input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写职位"></input>
                            <span class="commom" style="position:absolute;top:0px;left:370px;">
                                 <a id="addGg">(点击+继续添加))</a>
                            </span>
                        </div>
                        <div>
                        <textarea class=''   name='company_leaders[remark][]' id='' placeholder='过往经历，如：教育背景、曾就职信息等'></textarea>
                        </div>
                         <div class="cl"></div> 
                     </div>
                    
                     <?php }?>
                     
                     
                </div>
                 
            
                          
              </label>
            <div class="cl"></div>
            <h2 class="tc pt30 cb">上传附件</h2>
            <div style="margin-left:364px;line-height:2; color:#333; font-size:16px;">（双击图片删除）</div>
            
            <label class="form-con " style="position:relative;">
            	 <h3 class="fl user-upload-label">上传营业执照图片:</h3>
                 <div class="fl" style="">
                     <input id="file_upload1" name="file_upload" type="file" multiple="true">
                     <img id="company_business_img" width="50px" src="<?php echo isset($this->member['company_business'])?  Tool::show_img($this->member['company_business']):''; ?>" style="margin:auto;<?php  if(isset($this->member['picture']) && $this->member['picture']){ echo 'display:block';}else{ echo 'display:none';} ?>">
                     <input type="hidden" id="company_business" class="fl" name="member[company_business]" value="<?php echo isset($this->member['company_business'])?$this->member['company_business']:''; ?>">
                 </div>
                  <span class="fl commom btm">格式：JPG</span>
            </label>
            <div class="cl"></div>
             <label class="form-con " style="position:relative;">
            	 <h3 class="fl user-upload-label"><b>*</b>上传产品图片:</h3>
                 <div class="fl" style="">
                     <input id="file_upload2" name="file_upload" type="file" multiple="true">
                     <img id="company_productpics_img" width="50px" src="<?php echo isset($this->member['company_productpics'])?  Tool::show_img($this->member['company_productpics']):''; ?>" style="margin:auto;<?php  if(isset($this->member['picture']) && $this->member['picture']){ echo 'display:block';}else{ echo 'display:none';} ?>">
                     <input type="hidden" id="company_productpics" class="fl" name="member[company_productpics]" value="<?php echo isset($this->member['company_productpics'])?$this->member['company_productpics']:''; ?>">
                 </div>
                  <span class="fl commom btm">格式：JPG</span>
            </label>
            <div class="cl"></div>
           <label class="form-con " style="position:relative;">
            	 <h3 class="fl user-upload-label">上传产品二维码:</h3>
                 <div class="fl" style="">
                     <input id="file_upload3" name="file_upload" type="file" multiple="true">
                     <img id="company_productrcode_img" width="50px" src="<?php echo isset($this->member['company_productrcode'])?  Tool::show_img($this->member['company_productrcode']):''; ?>" style="margin:auto;<?php  if(isset($this->member['picture']) && $this->member['picture']){ echo 'display:block';}else{ echo 'display:none';} ?>">
                     <input type="hidden" id="company_productrcode" class="fl" name="member[company_productrcode]" value="<?php echo isset($this->member['company_productrcode'])?$this->member['company_productrcode']:''; ?>">
                 </div>
                  <span class="fl commom btm">格式：JPG</span>
            </label>
            <div class="cl"></div>
             <label class="form-con " style="position:relative;">
            	 <h3 class="fl user-upload-label">上传商业计划书、战略规划:</h3>
                 <div class="fl" style="">
                     <input id="file_upload4" name="file_upload" type="file" multiple="true">
                    
                     <input type="hidden" id="company_plan" class="fl" name="member[company_plan]" value="<?php echo isset($this->member['company_plan'])?$this->member['company_plan']:''; ?>">
                 </div>
                  <span class="fl commom btm">可上传Word、PPt、Excel、JPG图片文件</span>
                  <div class="cl fl" style='margin:0 0 0 240px;'>
                  <span id="company_plan_str" style="display:block"><?php echo isset($this->member['company_plan'])?$this->member['company_plan']:''; ?></span></div>
            </label>
            <div class="cl"></div>
            <div class="reg_gz">
            	<!--<i id="reg_rule_id"class="active"></i>-->
                
            
            	<p class="tc f16">
                    <input type="checkbox" class="xz_che" id="xieyi"  onclick="agree();" checked="checked"></input>
            		<span>
                	请您确认已阅读并同意遵守
                        <a  href="">大楚创业服务规则</a>
                    </span>
           		 </p>
                 <div class="cl"></div>
           </div>
           <p class="member_submit fl">
          		<button  type="button" id="" class=" submit_btn btn blue_btn" onclick="submit_member_info();" >保存</button>
          </p>
          <div class="cl"></div>
           </div>
       </form>
      </div>
   
</div>


<script src="<?php echo $this->_siteUrl ?>/assets/public/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.css">


<script type="text/javascript">
var site_url = "<?php echo $this->_siteUrl; ?>";
    $(function() {
        $('#file_upload').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "选择照片",
            'buttonImage' : '',
            'height':'32',
            'width':'100',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
//                alert(obj.url);
//                alert(obj.id);
                $('#J_headImg').attr('src',showimg(obj.url));
                $('#form_headImg').attr('src',showimg(obj.url));
                $('#form_headImg').show();
                $('#headerimg').val(obj.url);
                
            }
        });
        
          $('#file_upload1').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传文件",
            'buttonImage' : '',
            'height':'32',
            'width':'100',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
//                alert(obj.url);
//                alert(obj.id);
                $('#company_business_img').attr('src',showimg(obj.url));
                $('#company_business_img').show();
                $('#company_business').val(obj.url);

            }
        });
        
        $('#file_upload2').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传文件",
            'buttonImage' : '',
            'height':'32',
            'width':'100',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
//                alert(obj.url);
//                alert(obj.id);
                $('#company_productpics_img').attr('src',showimg(obj.url));
                $('#company_productpics_img').show();
                $('#company_productpics').val(obj.url);
                
           
            }
        });
          $('#file_upload3').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传文件",
            'buttonImage' : '',
            'height':'32',
            'width':'100',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
//                alert(obj.url);
//                alert(obj.id);
                $('#company_productrcode_img').attr('src',showimg(obj.url));
                $('#company_productrcode_img').show();
                $('#company_productrcode').val(obj.url);
                
           
            }
        });
          $('#file_upload4').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传文件",
            'buttonImage' : '',
            'height':'32',
            'width':'100',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
//                alert(obj.url);
//                alert(obj.id);
                $('#company_plan_str').html(obj.original_name);
                $('#company_plan').val(obj.url);
                
           
            }
        });
    });
    


    
    
    var xiexi_agree=true;
    function agree(){
        if(document.getElementById('xieyi').checked){
            xiexi_agree = true;
        }else{
            xiexi_agree = false;
        }   
    }
    
    function submit_member_info() {
        if(xiexi_agree){
            $.ajax({
                url: "<?php echo $this->createUrl('member/info') ?>",
                data: $('#member_info').serialize(),
                type: 'post',
                dataType: 'json',
                beforeSend: function() {
                    ship_mess_big('提交中!!!', 8000, 40, 45);
                },
                success: function(data) {
                    ship_mess_big('提交成功', 5000, 40, 45);
                },
                error: function() {
                    ship_mess_big('提交失败', 5000, 40, 45);
                }
            });
        }else{
          ship_mess_big('您要先同意本站协议才可以提交。', 8000, 40, 45);
        }
        return false;
    }

    
</script>   

<?php $this->renderPartial('/common/footer', array('config' => $config)); ?>