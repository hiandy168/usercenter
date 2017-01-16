<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php //echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.SuperSlide.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.placeholder.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>

 <style>
     .components .center{width:100%}

 </style>
<div class="components w980 clearfix">

<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/kindeditor.js"></script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    var admin_url = site_url + '/admin';
    $(document).ready(function () {
        var editor1 = KindEditor.create('.editor', {
            uploadJson: admin_url + '/files/upload',
        });
    });
</script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.validator.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.validator.cn.js"></script>
<div class="center"  style="background:#f2f2f2;border:0"> 
<div style="background:white;float:left;width:100%;border:1px solid #dbdbdb;border-radius: 20px;">
<div class="title" style="border-top-left-radius: 20px;border-top-right-radius: 20px;">编辑参赛作品</div>
<div style="">
            <input type="hidden" value="<?php echo $vid?>" name="vid">
            <?php 
                if(isset($id)){
            ?>
            <input type="hidden" value="<?php echo $id ?>" name="id">
            <?php 
                }
            ?>
            <div class="content" style="margin-top:20px;">
                <div class="t_title">名称<span>（1-20个字符）</span></div>
                <div class="input">

                    <input type="text" value="<?php echo isset($edit['title']) ? $edit['title'] : ''; ?>"
                           placeholder="请填写活动名称" class="input_text" name="title"/>
                    <div class="del"></div>
                </div>

                <div class="content" style="margin-top:20px;">
                    <div class="t_title">宣言<span>（200个字符）</span></div>
                    <div style="margin-top:10px;margin-bottom:20px;">
                                <textarea  placeholder="请填写活动宣言"  name="remark"  id="remark" style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;">
                                <?php echo $edit['remark']?>
                                </textarea>
                        <div class="del"></div>
                    </div>

                <!-- 上传图片1 start -->

                <div class="t_title">作品</div>
                <div class="">
                    <img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($edit['img']) ?>" id="img_thumb1" width="30%"/>
                    <input type="hidden" name="share_img" id="icon1" value="<?php echo $edit['img']?>">
                </div>
               
                <button class="save_button">编辑</button>
            </div>
</div>
    </div>

</div>
</div>
<!-- 组件 end -->
<script type="text/javascript">

var url          = "<?php echo $this->createUrl('/activity/vote/adminEdit'); ?>";
$('.save_button').click(function(){
	var id           = $("input[name='id']").val();
	var vid          = $("input[name='vid']").val();
	var title        = $("input[name='title']").val();
	var start_time   = $("input[name='start_time']").val();
    var remark     = $("#remark").val();
	var desc         = $("textarea[name='desc']").val();
	var share_img    = $("input[name='share_img']").val();
	var data = {
			id:id,
			vid:vid,
			title:title,
             remark:remark,
			img:share_img,
			};
	$.post(url,data,function(res){
		var res = JSON.parse(res);
		if(res.statue==1){
		    layer.msg(res.msg,{time:2000},function(){
                window.location.href="<?php echo $this->createUrl('/activity/vote/admin').'/vid/'.$vid; ?>";
			})
		}else{
			layer.msg(res.msg)
		}
	})
})

</script>

<?php echo $this->renderpartial('/common/footer', $config); ?>