<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
<style type="text/css">
 .float_layer_style {
    width: 650px;
    height: 568px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -196px;
    margin-left: -325px;
    background: #fff;
    border-radius: 4px;
}
</style>
<!-- 浮层样式2 start-->
<div class="float_layer_wrap float_layer_wrap1">
    <div class="float_layer_style float_layer_style_1 float_layer_style_2 ">
        <div style="height: 64px;"></div>
        <div class="item item1 style_item_2 clearfix">
            <div class="l">
                标 题：
            </div>
            <div class="r">
                <input id="title" name="title" type="text" value="" class="input_text" />
                <input id="pid" name="pid" value="<?php echo $pid;?>" type="text"/>
                <input id="mid" name="mid" value="<?php echo $mid;?>" type="text"/>
            </div>
        </div>

        <div class="item item1 style_item_2 clearfix">
            <div class="l">
                发送内容：
            </div>
            <div>
                <textarea  style="border: 1px solid #CCCCCC;padding: 3px;font-size: 12px;width: 320px; height: 104px; front-family:'微软雅黑'" name="content" id="content"></textarea>
            </div>
        </div>
        
        <div style="height: 20px;"></div>
        <div class="save_button" onclick="sendMessage();">发送</div>
    </div>
</div>
<!-- 浮层样式2 end-->

<script>
function sendMessage() {
    var pid = $('#pid').val();
    var mid = $('#mid').val();
    var title = $('#title');
    var content = $('#content');

    if (title.val().trim() == '') {
        layer.msg('消息标题不能为空',{icon:5});
        title.focus();
        return false;
    }
    if (content.val().trim() == '') {
        layer.msg('消息内容不能为空',{icon:5});
        content.focus();
        return false;
    }

    $.ajax({
        url: '<?php echo $this->createUrl("/behavior/sendMessage");?>',
        data: {title: title.val(), content: content.val(), mid: mid, pid: pid},
        dataType: 'json',
        type: 'post',
        success: function (data) {
            if (data.state == 1) {
                layer.msg(data.mess,{
                icon:6,
                shift: 5,
                time:1000,
                end:function(){               
                var index = parent.layer.getFrameIndex(window.name); 
                parent.layer.close(index); 
                parent.location.reload();
                }
                 });
            } else {
                layer.msg(data.mess,{icon:5});
            }
        }
    });
}
</script>
