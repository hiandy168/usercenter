<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
<!-- 浮层样式2 start-->
<div class="float_layer_wrap float_layer_wrap1">
    <div class="float_layer_style float_layer_style_1 float_layer_style_2 ">
        <div style="height: 64px;"></div>
        <div class="item item1 style_item_3 clearfix">
            <div class="l">
                应用名称：
            </div>
            <div class="r">
                <?php echo $model->name; ?>
            </div>
        </div>
        <div class="item item1 style_item_2 clearfix">
            <div class="l">
                修改应用名称：
            </div>
            <div class="r">
                <input id="name2" name="name" type="text" value="" class="input_text" />
            </div>
        </div>
        <div class="item item1 item2 style_item_3 clearfix">
            <div class="l">
                当前简介：
            </div>
            <div class="r">
                <?php echo $model->introduction; ?>
            </div>
        </div>
        <div class="item item1 item3 style_item_5  clearfix">
            <div class="l">
                修改应用简介：
            </div>
            <div>
                <textarea  style="border: 1px solid #CCCCCC;font-size: 12px;front-family:'微软雅黑'" name="introduction" id="introduction2" cols="30" rows="3"></textarea>
            </div>
        </div>

        <div class="item item1 style_item_3 clearfix">
            <div class="l">
                服务器URL：
            </div>
            <div class="r">
                <?php echo $model->url; ?>
            </div>
        </div>
        <div class="item item1 style_item_2 clearfix">
            <div class="l" style="width: 150px;">
                修改服务器URL：
            </div>
            <div class="r"  style="width: 290px;">
                <input id="url2" name="name" type="text" value="<?php echo $model->url; ?>" class="input_text" />
            </div>
        </div>
        <div style="height: 20px;"></div>
        <div class="save_button" onclick="updatePro()">保存</div>
    </div>
</div>
<!-- 浮层样式2 end-->

<script>
function updatePro() {
    var name = $('#name2').val();
    var info = $('#introduction2').val();
    var url = $('#url2').val();

    if (name.trim() == '') {
        layer.msg('应用名不能为空',{icon:5});
        return false;
    }
    if (info.trim() == '') {
        layer.msg('应用简介不能为空',{icon:5});
        return false;
    }
    //验证url
    url = url.trim();
    var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{1,3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
    var reg = new RegExp(strRegex);
    if(!reg.test(url)){
        ship_mess_big('url格式不正确');
        return false;
    }

    $.ajax({
        url: '<?php echo $this->createUrl("/project/edit",array('id'=>$model->id)); ?>',
        data: {name: name, introduction: info, url: url},
        dataType: 'json',
        type: 'post',
        success: function (data) {
            if (data.state == 1) {
                layer.msg(data.mess,{
                icon:6,
                shift: 5,
                time:1000,
                end:function(){
                parent.location.reload();
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
</script>
