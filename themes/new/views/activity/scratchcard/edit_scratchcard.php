<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>

<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    var admin_url = site_url + '/admin';
    $(document).ready(function () {
        var editor1 = KindEditor.create('.editor', {
            uploadJson: site_url + '/upload/imageupload',
        });        
    });
</script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.validator.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.validator.cn.js"></script>
     <form name="iframe_form" id="iframe_form" data-msg-pos="right" method="post" action="<?php echo $this->createurl('activity/scratchcard/save'); ?>" class="form-horizontal">
        <input type="hidden" name="fid" value="<?php echo $fid;?>">
        <input type="hidden" name="pid" value="<?php echo $pid;?>"> 
        <input type="hidden" name="backurl" value="<?php echo $backurl?>">
        <div class="title">设置</div>
            <div class="content">                
                <div class="t_title">活动名称<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FTitle']) ? $info['FTitle'] : ''; ?>"
                           placeholder="请填写活动名称" class="input_text" name="FTitle"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动开始时间<span>请填写活动开始时间</span></div>
                <div class="input">
                    <input type="text"
                           value="<?php echo isset($info['FStartTime']) ? date('Y-m-d H:i:s', $info['FStartTime']) : ''; ?>"
                           placeholder="请填写活动开始时间" class="input_text start_time"
                           name="FStartTime" id="start"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                <div class="input">
                    <input type="text"
                           value="<?php echo isset($info['FEndTime']) ? date('Y-m-d H:i:s', $info['FEndTime']) : ''; ?>"
                           placeholder="请填写活动结束时间" class="input_text end_time" name="FEndTime" id="end"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">用户可中奖次数<span>（请填写整数）</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FWinNum']) ? $info['FWinNum'] : ''; ?>"
                           placeholder="用户可中奖次数" class="input_text" name="FWinNum"/>
                    <div class="del"></div>
                </div>
                <div class="t_title"><span>中奖用户是否还能中奖</span>
                </div>
                <!-- 用户是否可以中奖 start-->
                <div class="check_radio">
                    <label>
                        <input type="radio" name="FWin_again"
                               value="1" <?php if ($info['FWin_again'] == 1) {
                            echo 'checked';
                        } ?> >是
                    </label>
                    <label>
                        <input type="radio" name="FWin_again"
                               value="0" <?php if ($info['FWin_again'] == 0) {
                            echo 'checked';
                        } ?> >否
                    </label>
                </div>
                <!-- 用户是否可以中奖 end-->
                <?php if($info->price){foreach ($info->price as $k=>$p){?>
                <div class="t_title">自定义名称</div>
                <div class="input">
                    <input type="hidden" value="<?php echo $p['FID']?>" name="p_fid[]">
                    <input type="text" value="<?php echo isset($p['FTitle']) ? $p['FTitle'] : ''; ?>" name="p_title[]"
                           placeholder="" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">奖品名称</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($p['FName']) ? $p['FName'] : ''; ?>" name='p_name[]'
                           placeholder="iphone" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">奖品数量</div>
                <div class="input">
                    <input type="text" value="<?php echo $p['FNum'] ? $p['FNum'] : ''; ?>" name='p_num[]'
                           placeholder="10" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($p['FPv']) ? $p['FPv'] : ''; ?>" name='p_v[]'
                           placeholder="5" class="input_text"/>
                    <div class="del"></div>
                </div>
                <?php }}?>

                <div class="input upload_pic clearfix">
                    <div class="button1" id="continue_ad_20160422">继续添加奖项</div>
                </div>
                <div class="t_title">每人每天抽奖次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FDaycount']) ? $info['FDaycount'] : ''; ?>"
                           name='FDaycount' placeholder="每天每天可以抽奖的次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">分享后是否能增加抽奖资格</div>
                <div class="check_radio">
                    <label>
                        <input type="radio" name="FShareIsAdd"
                               value="1" <?php if (!isset($info['FShareIsAdd']) || $info['FShareIsAdd'] == 1) {
                            echo 'checked';
                        } ?>>是
                    </label>
                    <label>
                        <input type="radio" name="FShareIsAdd"
                               value="0" <?php if (isset($info['FShareIsAdd']) && !$info['FShareIsAdd']) {
                            echo 'checked';
                        } ?> >否
                    </label>
                </div>
                <div class="t_title">最大分享有效次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FShareNum']) ? $info['FShareNum'] : '' ?>"
                           name='FShareNum' placeholder="最大分享有效次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">每次有效分享后能获得的抽奖次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FShareAddNum']) ? $info['FShareAddNum'] : ''; ?>"
                           name='FShareAddNum' placeholder="每次有效分享后能获得的抽奖次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">中奖提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FWin_mess']) ? $info['FWin_mess'] : ''; ?>"
                           name='FWin_mess' placeholder="中奖提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动规则</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FRule']) ? $info['FRule'] : ''; ?>" name='FRule'
                           placeholder="活动规则" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">领奖方式</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FLingjiang']) ? $info['FLingjiang'] : ''; ?>"
                           name='FLingjiang' placeholder="领奖方式" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">次数结束提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FEndNumMess']) ? $info['FEndNumMess'] : ''; ?>"
                           name='FEndNumMess' placeholder="次数结束提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动结束提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($info['FEndMess']) ? $info['FEndMess'] : ''; ?>"
                           name='FEndMess' placeholder="活动结束提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <!-- 上传图片1 start -->
                <div class="t_title">分享图片(更换背景图)</div>
                <div class="input">
                    <img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($info['FShareImg']) ?>" id="img_thumb1"
                         width="50%" height="100%"/>
                    <input type="hidden" name="FShareImg" id="icon1" value="<?php echo $info['FShareImg']?>">
                </div>
                <!-- 上传图片2 start -->
                <div class="t_title">活动banner(更换背景图)</div>
                <div class="input">
                    <img onclick="upload_pic('img_thumb2','icon2')" src="<?php echo JkCms::show_img($info['FBannerImg']) ?>" id="img_thumb2"
                         width="50%" height="100%"/>
                    <input type="hidden" name="FBannerImg" id="icon2" value="<?php echo $info['FBannerImg']?>">
                </div>
                <!-- 上传图片3 start -->
                <div class="t_title">活动背景(更换背景图)</div>
                <div class="input">
                    <img onclick="upload_pic('img_thumb3','icon3')" src="<?php echo JkCms::show_img($info['FBgImg']) ?>" id="img_thumb3"
                         width="50%" height="100%"/>
                    <input type="hidden" name="FBgImg" id="icon3" value="<?php echo $info['FBgImg']?>">
                </div>                
                <!-- 上传图片4 start -->
                <div class="t_title">刮奖区域(更换背景图)</div>
                <div class="input">
                    <img onclick="upload_pic('img_thumb4','icon4')" src="<?php echo JkCms::show_img($info['FScratchImg']) ?>" id="img_thumb4"
                         width="50%" height="100%"/>
                    <input type="hidden" name="FScratchImg" id="icon4" value="<?php echo $info['FScratchImg']?>">
                </div>
                <!-- 上传图片5 start -->
                <div class="t_title">活动详情(更换背景图)</div>
                <div class="input">
                    <img onclick="upload_pic('img_thumb5','icon5')" src="<?php echo JkCms::show_img($info['FDescImg']) ?>" id="img_thumb5"
                         width="50%" height="100%"/>
                    <input type="hidden" name="FDescImg" id="icon5" value="<?php echo $info['FDescImg']?>">
                </div>
               <!-- 上传图片 end -->
               <div class="save_button">保存</div>
            </div>
        
    </form>
  </div>

    <div class="right">
			<div class="iphone">
				<iframe style="width:320px;height: 480px;" src="<?php echo $this->createUrl('/activity/scratchcard/view',array('fid'=>$fid,'mid'=>$mid));?>" scrolling="yes"></iframe>
			</div>
    </div>

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
         var ts= new Date(document.getElementById("start").value);
        var ts1=ts.getTime()+86400000;
        var te= new Date(document.getElementById("end").value);
        var te1=te.getTime();
        if(te1<ts1){
         document.getElementById("end").value="";
          layer.msg("开始和结束时间必须间隔一天");
        }
        start.max = datas; //结束日选好后，重置开始日的最大日期
        $('input[name="FEndTime"]').trigger("validate");
    }
};
laydate(start);
laydate(end);

        $("#iframe_form").validator({
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
</div>