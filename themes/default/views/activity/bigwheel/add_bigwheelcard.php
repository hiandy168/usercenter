<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.placeholder.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>

 
<div class="components w980 clearfix">
<?php echo $this->renderpartial('/common/assembly',array('pid'=>$config['pid'],'active'=>$config['active']))?>

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
<div class="center"  style="background:#f2f2f2;border:0"> 
<div style="background:white;float:left;width:410px;border:1px solid #dbdbdb;border-radius: 20px;">
<div class="title" style="border-top-left-radius: 20px;border-top-right-radius: 20px;">新增活动</div>
<div style="">
            <input type="hidden" value="<?php echo $config['pid']?>" name="pid">
            <?php 
                if(isset($activity_info['id'])){
            ?>
            <input type="hidden" value="<?php echo $activity_info['id']?>" name="id">
            <?php 
                }
            ?>
            <div class="content" style="margin-top:20px;">
                <div class="t_title">活动名称<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>"
                           placeholder="请填写活动名称" class="input_text" name="title"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动开始时间<span>请填写活动开始时间</span></div>
                <div class="input">
                    <input type="text"
                           value="<?php echo isset($activity_info['start_time']) ? date('Y-m-d H:i:s', $activity_info['start_time']) : ''; ?>"
                           placeholder="请填写活动开始时间" class="input_text"
                           name="start_time" id="start"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                <div class="input">
                    <input type="text"
                           value="<?php echo isset($activity_info['end_time']) ? date('Y-m-d H:i:s', $activity_info['end_time']) : ''; ?>"
                           placeholder="请填写活动结束时间" class="input_text"
                           name="end_time" id="end"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">用户可中奖次数<span>（请填写整数）</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['win_num']) ? $activity_info['win_num'] : ''; ?>"
                           placeholder="用户可中奖次数" class="input_text" name="win_num"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">每人每天抽奖次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['day_count']) ? $activity_info['day_count'] : ''; ?>"
                           name='day_count' placeholder="每天每天可以抽奖的次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                <!--  
                <div class="t_title">最大分享有效次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['share_num']) ? $activity_info['share_num'] : '' ?>"
                           name='share_num' placeholder="最大分享有效次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">每次有效分享后能获得的抽奖次数</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['share_add_num']) ? $activity_info['share_add_num'] : ''; ?>"
                           name='share_add_num' placeholder="每次有效分享后能获得的抽奖次数" class="input_text"/>
                    <div class="del"></div>
                </div>
                -->
                <div class="t_title">中奖提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['win_msg']) ? $activity_info['win_msg'] : ''; ?>"
                           name='win_msg' placeholder="中奖提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动规则</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['rule']) ? $activity_info['rule'] : ''; ?>" name='rule'
                           placeholder="活动规则" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">领奖方式</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['lingjiang']) ? $activity_info['lingjiang'] : ''; ?>"
                           name='lingjiang' placeholder="领奖方式" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">次数结束提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['end_num_msg']) ? $activity_info['end_num_msg'] : ''; ?>"
                           name='end_num_msg' placeholder="次数结束提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动结束提示</div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['end_msg']) ? $activity_info['end_msg'] : ''; ?>"
                           name='end_msg' placeholder="活动结束提示" class="input_text"/>
                    <div class="del"></div>
                </div>
                <!-- 上传图片1 start -->
                
                <div class="t_title">分享图片(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($activity_info['share_img']) ?>" id="img_thumb1" width="30%"/>
                    <input type="hidden" name="share_img" id="icon1" value="<?php echo $activity_info['share_img']?>">
                </div>
                <!-- 上传图片2 start -->
                <!-- 
                <div class="t_title">活动banner(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb2','icon2')" src="<?php echo JkCms::show_img($activity_info['banner_img']) ?>" id="img_thumb2" width="30%"/>
                    <input type="hidden" name="banner_img" id="icon2" value="<?php echo $activity_info['banner_img']?>">
                </div>
                 -->
                <!-- 上传图片3 start -->
                <!--
                <div class="t_title">活动背景(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb3','icon3')" src="<?php echo JkCms::show_img($activity_info['bg_img']) ?>" id="img_thumb3" width="30%"/>
                    <input type="hidden" name="bg_img" id="icon3" value="<?php echo $activity_info['bg_img']?>">
                </div> 
                 -->               
                <!-- 上传图片4 start -->
                <!--
                <div class="t_title">刮奖区域(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb4','icon4')" src="<?php echo JkCms::show_img($activity_info['scratch_img']) ?>" id="img_thumb4" width="30%"/>
                    <input type="hidden" name="scratch_img" id="icon4" value="<?php echo $activity_info['scratch_img']?>">
                </div>
                -->
                <!-- 上传图片5 start -->
                <!--
                <div class="t_title">活动详情(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb5','icon5')" src="<?php echo JkCms::show_img($activity_info['desc_img']) ?>" id="img_thumb5" width="30%"/>
                    <input type="hidden" name="desc_img" id="icon5" value="<?php echo $activity_info['desc_img']?>">
                </div>
                -->
                <?php 
                    if($prize){
                        foreach ($prize as $val){
                ?>
                    <div class="s_num">
                    <input type="hidden" value="<?php echo $val['id']?>" name="p_id[]">
                    <div class="t_title">自定义名称</div>
                    <div class="input">
                    <input type="text" value="<?php echo $val['title']?>"  disabled="true " placeholder="" class="input_text" name="p_title[]" />
                    <div class="del"></div>
                    </div>
                    <div class="t_title">奖品名称</div>
                    <div class="input">
                    <input type="text" value="<?php echo $val['name']?>" placeholder="" class="input_text"  name="p_name[]" />
                    <div class="del"></div>
                    </div>
                    <div class="t_title">奖品数量</div>
                    <div class="input">
                    <input type="text" value="<?php echo $val['count']?>" placeholder="" class="input_text" name="p_num[]"/>
                    <div class="del"></div>
                    </div>
                    <div class="t_title">奖品概率<span>(填入整数)</span></div>
                    <div class="input">
                    <input type="text" value="<?php echo $val['probability']?>" placeholder="" class="input_text" name="p_v[]"/>
                    <div class="del"></div>
                    </div>
                    </div>
               <?php
                        }
                    }else{
                ?>
                <div class="input upload_pic clearfix">
                    <div class="button1" id="continue_ad_20160422">添加奖项</div>
                </div>
                <?php } ?>
                <div class="t_title">概率基数<span>(奖品概率5,概率基数1000,则中奖概率千分之五)</span></div>
                <div class="input">
                    <input type="text" value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : ''; ?>"
                           name='jishu' placeholder="概率基数(填入整数)" class="input_text"/>
                    <div class="del"></div>
                </div>
               <!-- 上传图片 end -->
                <button class="save_button">保存</button>
            </div>
</div>
    </div>
    <?php if($activity_info['id']){ ?>
        <div class="right" style="float:right;margin:0">

            <div class="iphone" style="margin: 123px 10px 0px 12px;  height: 358px; overflow: hidden;">
                    <iframe style="width:100%;border:0px;height: 375px;" src="<?php echo $this->createUrl('/activity/bigwheel/view',array('id'=>$activity_info['id']))?>" scrolling="yes"></iframe>
            </div>
        </div>
        <div style="float: right; width: 305px;text-align: center; margin-top: 20px;">
            <a style="display: inline-block; padding: 10px 20px; border-radius: 3px; border: 1px solid #00AFD8;" target="view_window"  href="<?php echo $this->createUrl('/activity/bigwheel/view',array('id'=>$activity_info['id']))?>">请点击->>>活动链接</a>
        </div>
    <?php }else{?>
        <div class="right" style="float:right;margin:0">
            <div class="iphone" style="margin: 123px 10px 0px 12px;  height: 358px; ">
                <iframe style="width:100%;border:0px;height: 375px;" src="<?php // echo $this->createUrl('/activity/bigwheel/view',array('id'=>$activity_info['id']))?>" scrolling="yes"></iframe>
            </div>
        </div>
    <?php }?>
</div>
</div>
<!-- 组件 end -->
<script type="text/javascript">
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
    var len=$(".s_num").length+1;
    if(len > 6){
        alert("大转盘奖品最多只能添加6个噢！");
        return false;
    }
    var tit='';
    if(len==1){
        tit='一等奖';
    }else if(len==2){
        tit='二等奖';
    }else if(len==3){
        tit='三等奖';
    }else if(len==4){
        tit='四等奖';
    }else if(len==5){
        tit='五等奖';
    }else if(len==6){
        tit='六等奖';
    }
    var temp_html = '<div class="s_num"><div class="t_title">自定义名称</div>'+
        '<div class="input">'+
        '<input type="text" value='+tit+' placeholder="" disabled="true "  class="input_text" name="p_title[]" />'+
        '<div class="del"></div>'+
        '</div>'+
        '<div class="t_title">奖品名称</div>'+
        '<div class="input">'+
        '<input type="text" value="" placeholder="" class="input_text"  name="p_name[]" />'+
        '<div class="del"></div>'+
        '</div>'+
        '<div class="t_title">奖品数量</div>'+
        '<div class="input">'+
        '<input type="text" value="" placeholder="" class="input_text" name="p_num[]"/>'+
        '<div class="del"></div>'+
        '</div>'+
        '<div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div>'+
        '<div class="input">'+
        '<input type="text" value="" placeholder="" class="input_text" name="p_v[]"/>'+
        '<div class="del"></div>'+
        '</div></div>';
    var parent = $(this).parents(".upload_pic");
    $(temp_html).insertBefore(parent);
});
var url          = "<?php echo $this->createUrl('/activity/bigwheel/add'); ?>";
$('.save_button').click(function(){
	var id           = $("input[name='id']").val();
	var pid          = $("input[name='pid']").val();
	var title        = $("input[name='title']").val();
	var start_time   = $("input[name='start_time']").val();
	var end_time     = $("input[name='end_time']").val();
	var win_num      = $("input[name='win_num']").val();
	var day_count    = $("input[name='day_count']").val();
	var share_num    = $("input[name='share_num']").val();
	var share_add_num= $("input[name='share_add_num']").val();
	var win_msg      = $("input[name='win_msg']").val();
	var rule         = $("input[name='rule']").val();
	var lingjiang    = $("input[name='lingjiang']").val();
	var end_num_msg  = $("input[name='end_num_msg']").val();
	var end_msg      = $("input[name='end_msg']").val();
	var jishu        = $("input[name='jishu']").val();
	var share_img    = $("input[name='share_img']").val();
	var banner_img   = $("input[name='banner_img']").val();
	var bg_img       = $("input[name='bg_img']").val();
	var scratch_img  = $("input[name='scratch_img']").val();
	var desc_img     = $("input[name='desc_img']").val();
	var obj_p_title      = $("input[name='p_title[]']");

    if(!title|| !start_time|| !end_time|| !win_num|| !day_count|| !win_msg|| !rule|| !lingjiang|| !end_num_msg|| ! end_msg|| !jishu|| !share_img|| !obj_p_title){
        layer.msg("所有参数为必填");
        return false;
    }


	var p_title=new Array();
    if($(".s_num").length <= 0){
        alert("请至少添加一个奖品噢！");
        return false;
    }
	obj_p_title.each(function(index,item){
		p_title[index]=$(this).val();
	});
	var obj_p_name     = $("input[name='p_name[]']");
	var p_name=new Array();
	obj_p_name.each(function(index,item){
		p_name[index]=$(this).val();
	});
	var obj_p_num      = $("input[name='p_num[]']");
	var p_num=new Array();
	obj_p_num.each(function(index,item){
		p_num[index]=$(this).val();
	});
	var obj_p_v      = $("input[name='p_v[]']");
	var p_v=new Array();
	obj_p_v.each(function(index,item){
		p_v[index]=$(this).val();
	});
	var obj_p_id      = $("input[name='p_id[]']");
	var p_id=new Array();
	obj_p_id.each(function(index,item){
		p_id[index]=$(this).val();
	});
	var data = {
			id:id,
			pid:pid,
			title:title,
			start_time:start_time,
			end_time:end_time,
			win_num:win_num,
			day_count:day_count,
			share_num:share_num,
			share_add_num:share_add_num,
			win_msg:win_msg,
			rule:rule,
			lingjiang:lingjiang,
			end_num_msg:end_num_msg,
			end_msg:end_msg,
			jishu:jishu,
			share_img:share_img,
			banner_img:banner_img,
			bg_img:bg_img,
			scratch_img:scratch_img,
			desc_img:desc_img,
			p_title:p_title,
			p_name:p_name,
			p_num:p_num,
			p_v:p_v,
			p_id:p_id
			};
	$.post(url,data,function(res){
		var res = JSON.parse(res);
		if(res.statue==1){
		    layer.msg(res.msg,{time:2000},function(){
		        window.location.href="<?php echo $this->createUrl('/activity/bigwheel/list').'/pid/'.$config['pid'].'/active/1'; ?>";
			})
		}else{
			layer.msg(res.msg)
		}
	})
})

</script>

<?php echo $this->renderpartial('/common/footer', $config); ?>