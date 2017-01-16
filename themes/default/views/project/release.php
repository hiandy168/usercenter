<?php $this->renderPartial('/common/header', array('config' => $config)); ?>
<!--cobntent-->
<div class="content member w1200 mgauto mt50">
    <?php
    $left_active = 'project';
    $left_active2 = 'release';
    ?>
    <?php $this->renderPartial('/common/left', array('config' => $config, 'left_active' => $left_active, 'left_active2' => $left_active2)); ?>
    <!--member_nav end-->
    <div style="width:860px;" class="fr" id="loadDiv">
        <style>.pl108{padding-left: 108px;}</style>
        <div class="member_con pb50">

            <form id="form_fabu">
                <label class="form-con">
                    <h3 class="fl w100"><b>*</b> 行业分类</h3>
                    
                <?php $project_type_arr = JkCms::getproject_type(); ?>
                <select class="fl" name="project[type_id]">
                     <option value="" selected="">--请选择行业--</option>
                <?php foreach($project_type_arr as $project_type):?>
                <option value="<?php echo $project_type['id']?>" <?php if (isset($this->member['company_type'])&&$this->member['company_type']==$project_type['id']): ?>selected<?php endif; ?>><?php echo $project_type['title']?></option>
                <?php endforeach;?>
                </select>


                </label>
                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>项目名称</h3>
                    <input type="text" name="project[title]" class="fl" style="width:500px;">
                </label>
                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>项目负责人</h3>
                    <input type="text" name="project[director]" class="fl">
                    <h3 class="fl w100"><b>*</b>负责人电话</h3>
                    <input type="text" name="project[phone]" class="fl">
                </label>

                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>负责人职务</h3>
                    <input type="text" name="project[job]" class="fl">
                    <h3 class="fl w100"><b>*</b>邮箱</h3>
                    <input type="text" name="project[email]" class="fl">
                </label>
                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>项目网址</h3>
                    <input type="text" name="project[app_address]" class="fl" style="width:550px;">
                </label>
                <!--            <div class="cl"></div>
                            <label class="form-con ">
                                 <h3 class="fl w100"><b>*</b>产品下载地址</h3>
                                 <input type="text" name="project[title]" class="fl" style="width:550px;">
                            </label>-->
                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>融资进度</h3>
                    <select class="fl" name="project[finance]">
                        <?php
                        $company_finance_arr = array('天使轮', 'Pre A轮', 'A轮', 'A+轮', 'B轮', 'B+轮', 'C轮', 'D轮', 'E轮', 'F轮', 'G轮', 'H轮', '暂未融资');
                        foreach ($company_finance_arr as $company_finance) {
                            echo "<option value='" . $company_finance . "' " . ((isset($this->member['company_finance']) && $this->member['company_finance'] == $company_finance) ? "selected=selected" : '') . ">" . $company_finance . "</option>";
                        }
                        ?>      
                    </select>
                </label>
                
                 <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>融资金额</h3>
                            <input type="text" name="project[money]" class="fl" style="width:550px;" value="<?php echo isset($view['money']) ? $view['money'] : ''; ?>">
                        </label>


                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>banner图</h3>
                    <div style="margin:0 0 0 105px;">
                      <div class="fl" style="">
                       <input id="file_upload1" name="file_upload" type="file" multiple="true">
                       <img id="form_banner_img" height="150px" src="" style="margin:auto;display:none">
                       <input name="project[banner_attachment]" value="" type="hidden" id="banner_attachment" class="fl" ></div>
                       <div class="clearfix"></div>
                    </div>
                </label>
                
                <div class="cl"></div>
                <label class="form-con ">
                    <h3 class="fl w100"><b>*</b>项目描述</h3>
                    <div style="margin:0 0 0 105px;">
                        <textarea name="project[description]" placeholder="800字之内" class="fl" style="width:680px;height:200px;"> </textarea>
                        <div class="clearfix"></div>
                
<!--                        <div style='margin:10px 0px 30px 3px;position:relative'>
                            <span id="file_upload"></span>
                            <span class="fl commom btm" style="display:block;position: absolute;top:15px;left:130px;">可上传Word、PPt、Excel、JPG图片文件</span>
                            <input  type="hidden" id="attachments" name="project[attachments]" value="">
                        </div>
                        
                        <div class="clearfix"></div>-->
                    </div>
                </label>

                <div class="cl"></div>
                <div class="J_items1110 oh-1110  tabs" style="margin:0 50px;">
                    <ul class="clearfix">
                        <li class="active"><label name="fenye" value="6" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">管理团队</label></li>
                        <li><label name="fenye" value="7" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">针对人群</label></li>
                        <li><label name="fenye" value="8" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">用户痛点</label></li>
                        <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">产品功能</label></li>
                        <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">产品未来规划</label></li>
                        <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">市场分析</label></li>
                    </ul>
                    <div style="border:1px solid #CFCDCE; ">
                        <div class="tabscon clearfix" style="padding:0 0 20px 0">
                            <div  style="display:inline-block;width:550px;margin:10px" class="gaoguan" >
                                
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
                                <div class="ggdiv fl "  style="position:relative;margin:0 0 10px 0">
                                    <div>
                                        <input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名"></input>
                                        <input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写职位"></input>
                                        <span class="commom" style="position:absolute;top:0px;left:370px;">
                                            <a class="reduceGg">(点击 -进行删除))</a>
                                        </span>
                                    </div>
                                    <div>
                                    <textarea class=''   name='company_leaders[remark][]' id='' placeholder='过往经历，如：教育背景、曾就职信息等'></textarea>
                                    </div>
                                    <div class="cl"></div> 
                                </div>

                            </div>
                        </div>
                        <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                            
                              <label style="position:relative" class="form-con  ">
                                <h4 class="tl">
                                    <span>产品的目标用户群体是谁？有哪些特征？打算如何获取早期用户？</span>
                                    
                                </h4>
                                <textarea placeholder="800字之内" class="w520-1110" name="project[zzrq]"></textarea>
    
                            </label>

                        </div>
                        <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                            <label style="position:relative" class="form-con  ">
                                <h4 class="tl">
                                    <span>当前用户的痛点是什么？如何解决目前的用户痛点?</span>
                                   
                                </h4>
                                <textarea placeholder="800字之内" class="w520-1110"  name="project[yhtd]"></textarea>
                    
                            </label>     
                        </div>
                        <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                            <label style="position:relative" class="form-con  ">
                                <h4 class="tl">
                                    <span>你的产品/服务定位是什么？你的产品/服务的最大特点或者核心要素是什么？你的产品/服务行业问题？</span>
                                   
                                </h4>
                                <textarea placeholder="800字之内" class="w520-1110"  name="project[cpgn]"></textarea>
                                
                            </label>
                        </div>
                        <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                            <label style="position:relative" class="form-con  ">
                                <h4 class="tl">
                                    <span>未来的产品规划是什么？</span>
                                    
                                </h4>
                                <textarea placeholder="800字之内" class="w520-1110"  name="project[wlgh]"></textarea>
                                
                            </label>
                        </div>
                        <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                            <label style="position:relative" class="form-con  ">
                                <h4 class="tl">
                                    <span>你所创业的领域，目前的现状是什么样？存在哪些问题？该领域前景如何？市场规模有多大？有哪些主要的用户？</span>
                                    
                                </h4>
                                <textarea placeholder="800字之内" class="w520-1110" name="project[scfx]"></textarea>
                                
                            </label>
                        </div>
                    </div>
                </div>


                <div class="cl"></div>
            </form>

            <p class="member_submit fl">
                <button class=" submit_btn btn blue_btn" id="submit_btn"  type="button" onclick="submit_project();">保存</button>
            </p>
            <div class="cl"></div>
        </div>
    </div>
</div>
</div>
<script src="<?php echo $this->_siteUrl ?>/assets/public/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.css">


<script type="text/javascript">
var site_url = "<?php echo $this->_siteUrl; ?>";
    $(function() {
//        $('#file_upload').uploadify({
//            'formData': {
//                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
//            },
//            'fileObjName': 'Filedata',
//            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp;*.xls;*.doc;*.xlsx;*.docx',
//            'fileSizeLimit': '10MB',
//            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
//            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
//            'buttonText': "上传文件资料",
//            'buttonImage' : '',
//            'height':'60',
//            'width':'120',
//            'onUploadSuccess': function(file, data, response) {
//                var strJSON = data;//得到的JSON
//                var obj = new Function("return" + strJSON)();//转换后的JSON对象
////                alert(obj.url);
////                alert(obj.id);
//                if ($('#attachments').val()){
//                        $('#attachments').val($('#attachments').val() + ',' + obj.id);
//                } else{
//                        $('#attachments').val(obj.id);
//                }
//
//                
//            }
//        });
        
        $('#file_upload1').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传图片",
            'buttonImage' : '',
            'height':'60',
            'width':'120',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                $('#banner_attachment').val(obj.id);
                $('#form_banner_img').attr('src',showimg(obj.url));
                $('#form_banner_img').show();
            }
        });
    })

    function submit_project() {
        $.ajax({
            url: "<?php echo $this->createUrl('project/ajaxsubmit') ?>",
            data: $('#form_fabu').serialize(),
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                ship_mess_big('提交中!!!', 8000, 40, 45);
            },
            success: function(data) {
                if (data.state) {
                    ship_mess_big('提交成功', 5000, 40, 45);
                } else {
                    ship_mess_big('提交失败,请联系管理员', 5000, 40, 45);
                }
            },
            error: function() {
            }
        });
        return false;
    }
</script>
<?php $this->renderPartial('/common/footer', array('config' => $config)); ?>