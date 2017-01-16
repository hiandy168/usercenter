<!--        </div>

    <div class="right">
         右边iframe部分 
        <div class="content">

        </div>
    </div>
</div>-->
<!-- 组件 end -->
<script type="text/javascript">
    $(document).ready(function () {
    var start = {
    elem: '#start',
    event: 'focus',
    format: 'YYYY-MM-DD hh:mm:ss',
    min: laydate.now(), //设定最小日期为当前日期
    max: '2099-06-16 23:59:59', //最大日期
    istime: true,
    istoday: false,
    choose: function(datas){
         end.min = datas; //开始日选好后，重置结束日的最小日期
         end.start = datas //将结束日的初始值设定为开始日
         console.log(datas);
         $('input[name="FStartTime"]').trigger("validate");
    }
};
var end = {
    elem: '#end',
    event: 'focus',
    format: 'YYYY-MM-DD hh:mm:ss',
    min: laydate.now(),
    max: '2099-06-16 23:59:59',
    istime: true,
    istoday: false,
    choose: function(datas){
        start.max = datas; //结束日选好后，重置开始日的最大日期
        $('input[name="FEndTime"]').trigger("validate");
    }
};
laydate(start);
laydate(end);

        $("#iframe_form111").validator({
            fields: {
                FTitle: 'required',
                FWinNum: 'required',
                FDaycount: 'required',
                FShareNum:'required',
                FShareAddNum:'required',
                FWin_mess:'required',
                FStartTime: 'required',
                FEndTime: 'required',
                FRule:'required',
                FEndMess: 'required',
                FLingjiang: 'required',
                FEndNumMess: 'required',
            }
        }).on("click", ".save_button", function(e) {
              console.log(e.delegateTarget);
             $(e.delegateTarget).trigger("validate").submit();
        });        
        
        
        
        $(".components .slider_show").slide({
            mainCell: ".bd ul",
            effect: "left",
            autoPlay: false
        });
        $(":input[placeholder]").placeholder();

        $(".components .center input").live('focus', function () {
            var parsent = $(this).parents(".components .center .input");

            $(".components .center .input").find('.del').hide();

            $(".components .center .input").removeClass("focus");

            parsent.addClass("focus");
            parsent.find('.del').show();
        });


        $(".components .center .del").live('click', function () {
            var this_input = $(this).parents(".components .center .input");
            var val = this_input.find('.input_text').val();

            if (val.length > 0) {
                this_input.find('.input_text').val("");
            } else {
                return;
            }
        });

        $("#continue_ad_20160422").on('click', function () {
            var temp_html = '<div class="t_title">自定义名称</div><div class="input"><input type="text" value="" placeholder="" class="input_text" name="p_title[]" /><div class="del"></div></div><div class="t_title">奖品名称</div><div class="input"><input type="text" value="" placeholder="" class="input_text" /><div class="del" name="p_name[]"></div></div><div class="t_title">奖品数量</div><div class="input"><input type="text" value="" placeholder="" class="input_text" name="p_num[]"/><div class="del"></div></div><div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div><div class="input"><input type="text" value="" placeholder="" class="input_text" name="p_v[]"/><div class="del"></div></div>';
            var parent = $(this).parents(".upload_pic");
            $(temp_html).insertBefore(parent);
        });


        $(".components .center .content .upload_pic .button1").on('click', function () {
            $(this).parents(".upload_pic").find(".upload_pic_wrap_20160422").show();
        });

        $(".pic_20160422 .sure").on('click', function () {
            $(this).parents(".upload_pic_wrap_20160422").hide();
        });


        $(".pic_20160422 .cancel").on('click', function () {
            $(this).parents(".upload_pic_wrap_20160422").hide();
        });

        $(".pic_20160422 .imageFile").on('change', function (e) {
            $(this).parents(".upload_pic_wrap_20160422").find(".upload_text_0422").val(e.target.value);
        });
    });
</script>
<?php //echo $this->renderpartial('/common/footer_1') ?>