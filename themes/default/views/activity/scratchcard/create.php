<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>i用后台管理</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <!-- Le styles -->
    <link type="text/css" href="<?php echo Mod::app()->createUrl('/')?>/assets/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo Mod::app()->createUrl('/')?>/assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo Mod::app()->createUrl('/')?>/assets/css/main.css?v=2.1&d=20140618" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Mod::app()->createUrl('/')?>/assets/lessCss/style.css?v=2.1&d=20140618" rel="stylesheet"/>
    <link href="<?php echo Mod::app()->createUrl('/')?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js" type="text/javascript"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<script type="text/javascript">if(typeof window.console == 'undefined'){window.console={'log':function(){},'error':function(){}}}</script>
        
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/bootstrap-wysiwyg.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery.form.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/form_validator.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery.hotkeys.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery_extend.js" type="text/javascript"></script>
</head>

<body>
<style>
.table th {
    font-weight: normal;border:none;
    width:11%;
    background:#ccc
}
.table .tr2{background:#f2f2f2}
.white_alert {
    background-color: #ffffff;
    border-bottom: 1px solid #ddd;
    border-radius: 4px;
    margin:0 10px 20px 10px;
    padding: 8px 35px 8px 14px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
}

.white_alert .t2 {color: #c09853;}
.white_alert .t2{border-bottom: 1px solid #ddd;line-height:32px;margin:0 0 10px 0;padding:0 5px }
.on{background:#ccc}
</style>
<div class="wrap p_t_20 container">
	<div class="row">
		<div class="span12">
			<!--中间布局开始-->
			<div class="row">
                             <?php $this->render('left',  compact('pid',$pid));?>
                <!--整体右侧开始-->
                <div class="span9">
                    <div class="row">
                        <!--右侧设置开始-->
                        <div class="span5" style='width:798px'>
                            <div class="inner_container clearfix">
                                <div class="inner_container_title row-fluid">
                                    <div style="margin-left: 0;" class="span5">
                                        <h5><font id="selectedPageName">添加活动 <?php //echo $tables['type_name'];?></h5>
                                    </div>
                                    <div style="" class="span7 text-right">
                                                <div class="right_btns">
                                                <a class="vb_btn_info m-r-5" id="review_for_phone" href="<?php echo $this->createurl('activity/scratchcard/create/',array('pid'=>$pid)); ?>">+ 新建活动</a>
                                                <a class="vb_btn_danger m-r-10" onclick="triggerIframeSubmit();" href="javascript:void(0);">保存</a>
                                                </div>
				     </div>
                                </div>
                                <div id="right_opera_panel" class="inner_container_box iframe_cont clearfix" style="background:#fafafa">       
                                        <iframe src="<?php echo $this->createurl('activity/scratchcard/createfrom',array('pid'=>$pid))?>" name="right_opera_panel_iframe" id="right_opera_panel_iframe"></iframe>   
                                </div>
                            </div>
                        </div>
                 
                       
                    </div>
                </div>
                <!--整体右侧结束-->
			</div>
			<!--中间布局结束-->
			<div class="line20"></div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
   
        var tr=document.getElementsByTagName('tr'); 
        for(var i=0,j=0;i<tr.length;i++) { 
            j++; 
            tr[i].className=j%2==0?'':'tr2'; 
        } 
})
</script>