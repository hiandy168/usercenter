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
.on{background:#ccc}
.tjiao{ padding:20px}
.closezxb{text-align:center}
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
                                        <h5><font id="selectedPageName">刮刮卡列表</h5>
                                    </div>
                                    <div style="" class="span7 text-right">
                                                <div class="right_btns">
                                                <a class="vb_btn_info m-r-5" id="review_for_phone" href="<?php echo $this->createUrl('activity/scratchcard/create',array('pid'=>$pid)); ?>">+ 新建活动</a>
                                                <a class="vb_btn_danger m-r-10" onclick="triggerIframeSubmit();" href="javascript:void(0);">保存</a>
                                                </div>
				     </div>
                                </div>
                                <div id="right_opera_panel" class="inner_container_box iframe_cont clearfix" style="background:#fafafa;">
                                        <table class="table cl clearfix" style="width:775px;margin:11px;background:#fff;border:1px solid #ccc;border-radius:4px;display:block">
                                        <?php if(!empty($events)){ ?>  <tr>
                                            <th>活动名称</th>
                                            <th style="width:13%">有效参与人数</th>
                                            <th>总浏览数</th>
                                            <th>中奖个数</th>
                                            <th style="width:13%">开始/结束时间</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                          </tr>
                                                                                                             
                                        <?php foreach((array)$events as $event) : ?>
                                          <tr>
                                            <td><?php echo $event['FTitle']?></td>
                                            <td><?php echo $event['partake_num']?></td>
                                            <td><?php echo $event['FFlowCount']?$event['FFlowCount']:0?></td>
                                            <td><?php echo $event['win_num']?></td>
                                            <td><?php echo date('Y-m-d',$event['FStartTime'])?>/<?php echo date('Y-m-d',$event['FEndTime'])?></td>
                                             <td><?php echo $event['FStatus']?'启用':'禁用'?></td>
                                            <td>
                                                <span style="cursor: pointer; font-size:13px;color:#0066cc" data-href="<?php echo $this->createurl('activity/scratchcard/edit/id/'.$event['FID']); ?>" class='edit_activtity'>编辑</span>
                                                &nbsp;&nbsp;<span  style="cursor: pointer;  font-size:13px;color:#0066cc" data-href="<?php echo $this->createurl('activity/scratchcard/del/id/'.$event['FID']); ?>" class='del_activtity'>删除</span>
                                                <br/><span  style="cursor: pointer; font-size:13px;color:#0066cc" data-index="<?php echo urldecode($event['url']); ?>" class='show_activtity'>显示链接</span>
                                                &nbsp;&nbsp;
                                               <br/> 
                                               &nbsp;&nbsp;<a  style=" font-size:13px;color:#0066cc" target="_blank"  href="<?php echo $this->frontURL().'/do/scratch_demo/FID/'.$event['FID']; ?>"><span data-index="<?php echo $event['url']; ?>" class="review_for_phone">预览</span></a>
												 <br/>      &nbsp;&nbsp;<a  style=" font-size:13px;color:#0066cc" target="_blank"  href=""><span data-index="<?php echo $event['weixin_url']; ?>" class="review_for_weixin">非微信预览</span></a>
                                          
                                               <br/>
                                               <a  style=" font-size:13px;color:#0066cc" target="_self"  href="<?php echo $this->URL('do/getScratchcardWin/id/'.$event['FID']); ?>">查看参与记录</a>
						<br/>
                                                <a  style=" font-size:13px;color:#0066cc" target="_self"  href="<?php echo $this->URL('do/getScratchcardExcel/id/'.$event['FID']); ?>">导出中奖记录</a>
                                          </td>
                                          </tr>
                                        <?php endforeach; ?>
                                        <?php }else{ ?>
                                           <tr>
                                            <td>请选择对应的活动或者没有该活动</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                          </tr>
                                        <?php } ?>
                                        </table>
                                   <div class="pager2" style="height:22px;margin:5px 30px;text-align:center"> <?php $this->widget('CLinkPager', array('pages' => $pages));?></div>
                                   
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
<div class="zxbtchuang" style=" display:none;width: 240px; border:10px solid #ddd; padding:20px; position: absolute; z-index:22;background:#fff; top:100px; left:50%; margin-left:-150px"><p style="list-style: 24px; text-align:center; color:#333; font-size:12px"></p><div class="closezxb"><button>关闭</button></div></div>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/main.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/editor_init.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/timepicker.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/activity_main.js" type="text/javascript"></script>
<script>
$(".closezxb button").click(function(){$(".zxbtchuang").hide();})
$(document).ready(function(){

    var host_url = '<?php echo Mod::app()->request->hostInfo;?>';
  
	 $('.review_for_phone').hover(
	   function(){
		   var url='http://api.kuaipai.cn/qr?chs=180x180&chl=';
		  // var FWechatID = "<?php echo $numberInfo['FWechatID'];?>";
		  // var FAppID = "<?php echo $numberInfo['FAppID'];?>";
		   url+=$(this).attr('data-index');
		   
           var $img=$('#review_for_phone_img');
           if($img.length<1){
               $img=$('<img id="review_for_phone_img" src="'+url+'" style="position: absolute;top:190px; right:-20px;">');
               $img.appendTo('body');
               $img.mouseout(function(){
                   $img.hide();
               });
           }else{
               $img.attr('src',url).css('right','-20px').show();
           }
     },
     function(){$('#review_for_phone_img').hide()});

	 $('.review_for_weixin').hover(
			   function(){
				   var url='http://api.kuaipai.cn/qr?chs=180x180&chl=';
					   url+=$(this).attr('data-index');
					   
		           var $img=$('#review_for_weixin_img');
		           if($img.length<1){
		               $img=$('<img id="review_for_weixin_img" src="'+url+'" style="position: absolute;top:190px; right:-20px;">');
		               $img.appendTo('body');
		               $img.mouseout(function(){
		                   $img.hide();
		               });
		           }else{
		               $img.attr('src',url).css('right','-20px').show();
		           }
		     },
		     function(){$('#review_for_weixin_img').hide()});


    
     $('.show_activtity').on('click',function(){
    	 var d = $(this).attr('data-index'); 
    	 $(".zxbtchuang p").html(d);
			$(".zxbtchuang").show();
     });

	   
        var tr=document.getElementsByTagName('tr'); 
        for(var i=0,j=0;i<tr.length;i++) { 
            j++; 
            tr[i].className=j%2==0?'':'tr2'; 
        } 
        
        
       
           
      
})
</script>