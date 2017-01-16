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
                           value="<?php echo isset($activity_info['starttime']) ? date('Y-m-d H:i:s', $activity_info['starttime']) : ''; ?>"
                           placeholder="请填写活动开始时间" class="input_text"
                           name="start_time" id="start"/>
                    <div class="del"></div>
                </div>
                <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                <div class="input">
                    <input type="text"
                           value="<?php echo isset($activity_info['endtime']) ? date('Y-m-d H:i:s', $activity_info['endtime']) : ''; ?>"
                           placeholder="请填写活动结束时间" class="input_text"
                           name="end_time" id="end"/>
                    <div class="del"></div>
                </div>
                
                
                <div class="t_title">分享图片(更换背景图)</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($activity_info['share_img']) ?>" id="img_thumb1" width="30%"/>
                    <input type="hidden" name="share_img" id="icon1" value="<?php echo $activity_info['share_img']?>">
                </div>
               <!-- 上传图片 end -->
                <button class="save_button">保存</button>
            </div>
</div>
    </div>
    <?php if($activity_info['id']){ ?>
        <div class="right" style="float:right;margin:0">

            <div class="iphone" style="margin: 123px 10px 0px 12px;  height: 358px; overflow: hidden;">
                    <iframe style="width:100%;border:0px;height: 375px;" src="<?php echo $this->createUrl('/activity/poster/view',array('id'=>$activity_info['id']))?>" scrolling="yes"></iframe>
            </div>
        </div>
        <div style="float: right; width: 305px;text-align: center; margin-top: 20px;">
            <a style="display: inline-block; padding: 10px 20px; border-radius: 3px; border: 1px solid #00AFD8;" target="view_window"  href="<?php echo $this->createUrl('/activity/poster/view',array('id'=>$activity_info['id']))?>">请点击->>>活动链接</a>
        </div>
    <?php }else{?>
        <div class="right" style="float:right;margin:0">
            <div class="iphone" style="margin: 123px 10px 0px 12px;  height: 358px; ">
                <iframe style="width:100%;border:0px;height: 375px;" src="<?php // echo $this->createUrl('/activity/scratchcard/view',array('id'=>$activity_info['id']))?>" scrolling="yes"></iframe>
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

var url          = "<?php echo $this->createUrl('/activity/poster/add'); ?>";
$('.save_button').click(function(){
	var id           = $("input[name='id']").val();
	var pid          = $("input[name='pid']").val();
	var title        = $("input[name='title']").val();
	var start_time   = $("input[name='start_time']").val();
	var end_time     = $("input[name='end_time']").val();
	var share_img      = $("input[name='share_img']").val();

    if(!title||!start_time||!end_time||!share_img){
        layer.msg("所有参数为必填");
        return false;
    }
	var data = {
			id:id,
			pid:pid,
			title:title,
			starttime:start_time,
			endtime:end_time,
            share_img:share_img
			};

	$.post(url,data,function(res){
		var res = JSON.parse(res);
		if(res.statue==1){
		    layer.msg(res.msg,{time:2000},function(){
		        window.location.href="<?php echo $this->createUrl('/activity/poster/list').'/pid/'.$config['pid'].'/active/4'; ?>";
			})
		}else{
			layer.msg(res.msg)
		}
	})
})

</script>

<?php echo $this->renderpartial('/common/footer', $config); ?>