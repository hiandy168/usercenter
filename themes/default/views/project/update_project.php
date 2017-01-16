<?php echo $this->renderpartial('/common/header_new',$config); ?>

<div class="new_wrap clearfix">

    <?php echo $this->renderpartial('/common/left_new'); ?>

    <div class="right">
        <div class="tips">
            创建一个项目后才能申请入驻
        </div>
        <div class="fill_table">
            <div class="item clearfix">
                <div class="l">应用名称</div>
                <div class="r">
                    <div class="input">
                        <input id="name" type="text" placeholder="<?php echo $project->name; ?>"/>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">简介</div>
                <div class="r">
                    <div class="input">
                        <textarea id="introduction" placeholder="<?php echo $project->introduction; ?>"></textarea>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">服务器地址</div>
                <div class="r">
                    <div class="input">
                        <input id="url" type="text" placeholder="<?php echo $project->url; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="save_button" onclick="updatePro()">保存</div>
    </div>

</div>
<script>
    $(document).ready(function () {

//        $(".new_wrap .left .title2").hover(function () {
//            $(this).find('.arrow').addClass("arrow_down");
//            $(this).find('.title22').addClass('on_hover');
//            $(this).find(".subtitle").show();
//        }, function () {
//            $(this).find('.arrow').removeClass("arrow_down");
//            $(this).find('.title22').removeClass('on_hover');
//            $(this).find(".subtitle").hide();
//        });

        $("#change_td_bg tr").hover(function () {
            $(this).addClass('hover');
        }, function () {
            $(this).removeClass('hover');
        });

    });

    function updatePro() {
        var name = $('#name').val();
        var info = $('#introduction').val();
        var url = $('#url').val();

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
            url: '<?php echo $this->createUrl("/project/edit",array('id'=>$project->id)); ?>',
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
//                            parent.location.reload();
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                            window.location.href = "<?php echo Mod::app()->request->urlReferrer; ?>";
                        }
                    });
                } else {
                    layer.msg(data.mess,{icon:5});
                }
            }
        });
    }

</script>

</body>
</html>