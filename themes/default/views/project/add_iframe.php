<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>

<!-- 浮层样式1 start-->
<div class="float_layer_wrap float_layer_wrap1 float_layer_wrap3" <?php if($member){echo "style='display:none;'";} ?>>
    <div class="float_layer_style float_layer_style_1">
        <div class="tips">
            创建一个项目后才能申请入驻
        </div>
        <div class="item item1 clearfix">
            <div class="l">
                应用名称：
            </div>
            <div class="r">
                <input name="name" type="text" value="" class="input_text" />
            </div>
        </div>
        <div class="item item1 item2 clearfix">
            <div class="l">
                简介：
            </div>
            <div class="r">
                <textarea name="introduction" class="textarea_text"></textarea>
            </div>
        </div>
        <div class="item item1 clearfix">
            <div class="l" style="width: 180px;">
                URL(服务器地址)：
            </div>
            <div class="r">
                <input id="url" name="url" type="text" placeholder="http://www.baidu.com" class="input_text" />
            </div>
        </div>
        <div class="item item1 item4 clearfix">
            <div class="l">
                帮助文档：
            </div>
            <div class="r">
                项目创建完毕后可在项目管理页面进行项目信息编辑
            </div>
        </div>
        <div class="check">
            <label>
                <input type="checkbox" name="" id="inputbox" value="1" checked />同意<span><a href="<?php echo $this->createurl('/agreement')?>" target="_blank" style="color: #1b66c7;">《大楚开放平台协议》</a></span>
                <input type="hidden" name="back_url" id="back_url" value="<?php echo $back_url;?>">
            </label>
        </div>
        <div class="save_button" onclick="addPro()">保存</div>
    </div>
</div>
<!-- 浮层样式1 end-->
<!-- 浮层样式3 start-->
<div class="float_layer_wrap float_layer_wrap2" <?php if(!$member){echo "style='display:none;'";} ?>>
    <div class="float_layer_style float_layer_style_1 float_layer_style_3">
        <div class="item item1 item_style_3_1 clearfix">
            <div class="l">
                开发平台：
            </div>
            <div class="r">
                <div class="icon">
                    <img src="<?php echo $this->_theme_url; ?>images/1.png" height="100%" width="100%">
                </div>
            </div>
        </div>
        <div class="item item1 item_style_3_2 item_style_3_5 clearfix">
            <div class="l">
                开发者ID：
            </div>
            <div class="r">
                <span class="tel"><?php echo $this->member['phone']?></span>
            </div>
        </div>
        <div class="item item1 item_style_3_2 clearfix">
            <div class="l">
                姓名：
            </div>
            <div class="r">
                <input name="username" id="username" type="text" value="<?php echo $this->member['username']?>" class="input_text" />
            </div>
            <div class="status right" style="display: none">
                okok
            </div>
        </div>
        <div class="item item1 item_style_3_2 item_style_3_3 clearfix">
            <div class="l">
                邮箱：
            </div>
            <div class="r">
                <input name="email" id="email" type="text" value="<?php echo $this->member['email']?>" class="input_text" />
            </div>
            <div class="status error" style="display: none">
                okok
            </div>
        </div>
        <div class="item item1 item_style_3_2 item_style_3_4 clearfix">
            <div class="l">
                公司名称：
            </div>
            <div class="r">
                <input name="company" id="company" type="text" value="<?php echo $this->member['company']?>" class="input_text" />
            </div>
        </div>
        <div class="item item1 item_style_3_2 item_style_3_4 clearfix">
            <div class="l">
                公司地址：
            </div>
            <div class="r">
                <input name="address" id="address" type="text" value="<?php echo $this->member['address']?>" class="input_text" />
            </div>
        </div>

        <div style="height: 16px;"></div>
        <div class="save_button" onclick="saveInfo()">保存</div>
    </div>
</div>
<!-- 浮层样式3 end-->

<script>
    function addPro(){
        var name = $('.input_text').val();
        var info = $('.textarea_text').val();
        var url = $('#url').val();
        if(name.trim() == ''){
            layer.msg('应用名不能为空',{icon:5});
            return false;
        }
        if(info.trim() == ''){
            layer.msg('应用简介不能为空',{icon:5});
            return false;
        }
        if(url.trim() == ''){
            layer.msg('URL不能为空',{icon:5});
            return false;
        }
        //验证url
        url = url.trim();
        var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{1,3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
        var reg = new RegExp(strRegex);
        if(!reg.test(url) ){
            layer.msg('url格式不正确',{icon:5});
            return false;
        }

        var ckbox = $('#inputbox:checked').val();
        if(!ckbox){
            layer.msg('没有同意本站协议',{icon:5});
            return false;
        }

        $.ajax({
            url:'<?php echo $this->createUrl("/project/projectReg",array('id'=>$model->id)); ?>',
            data:{name:name,introduction:info,url:url},
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
                $('.save_button').attr('onclick','javascript:void(0)'); 
            },
            success : function (data) {
                if (data.state == 1) {               
                        layer.msg(data.mess,{
                        icon:6,
                        shift: 5,
                        time:1000,
                        end:function(){
                        top.location.href = "<?php echo $this->createUrl('/project/appMgt'); ?>";
                        var index = parent.layer.getFrameIndex(window.name); 
                        parent.layer.close(index); 
                        }
                        });
                        
                } else {
                    layer.msg(data.mess,{icon:5});
                }
            }
        });
    }

    function saveInfo(){
        var username = $('#username').val();
        var email = $('#email').val();
        var company = $('#company').val();
        var address = $('#address').val();
        var back_url = $('#back_url').val();

        //验证邮箱
        if(email.trim()){
            var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
            if(!reg.test(email)){
                layer.msg('邮箱格式错误');
                return false;
            }
        }

        $.ajax({
            url:'<?php echo $this->createUrl("/site/updateMemInfo",array('id'=>$this->member['id']));?>',
            data:{username:username,email:email,company:company,address:address},
            dataType:'json',
            type:'post',
            success : function (data) {
                if (data.state == 1) {
                    layer.msg(data.mess,{
                        icon:6,
                        shift: 5,
                        time:1000,
                        end:function(){
                            top.location.href = back_url;
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }
                    });
                } else {
                    layer.msg(data.mess);
                }
            }
        });
    }
</script>
