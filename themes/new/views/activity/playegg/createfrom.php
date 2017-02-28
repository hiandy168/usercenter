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
</head>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/bootstrap-wysiwyg.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery.form.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/form_validator.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery.hotkeys.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery_extend.js" type="text/javascript"></script>
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
<input type="hidden" value="<?php echo Mod::app()->createUrl('/')?>" id="base_href"/>

                                       
                                    
                                    

                                    <div class="wrap gray_bg">
                                        <form id="iframe_form" data-msg-pos="right" method="post" action="<?php echo $this->createurl('activity/scratchcard/save/'); ?>" class="form-horizontal">
                                            <input type="hidden" value="<?php echo  isset($info['FID'])?$info['FID']:'';?>" name="FID">
                                            <input type="hidden" value="<?php echo $pid;?>" name="pid">
                                            <div class="white_alert">
                                                <div class="t2">活动类型</div>
                                                <div class="control-group block">
                                                    <lable   style="display:block;width:100px;float:left;text-align:right">&nbsp;</lable>
                                                    <input type="radio" name="type" value="scratchcard" checked="checked"><lable>砸金蛋</lable>
<!--                                                    <input type="radio" name="type" value="bigwheel" <?php if (isset($view['type']) && $view['type'] == 'scratchcard') { echo 'checked';} ?> ><lable>大转盘</lable> -->
                                                </div>
                                            </div>
                                            <div class="white_alert">
                                                <div class="t2">基本设置</div>
                                                <div class="control-group block">
                                                <!--<p><span style="display:block;width:240px;float:left;text-align:right">软文url：</span><input type="text"  value="<?php echo  isset($info['FSoftUrl'])?$info['FSoftUrl']:'';?>" name='FSoftUrl'  data-msg="不能为空" data-pattern="require" ><span style="margin:0 5px;font-size:12px;" >如：http://hb.qq.com</span></p>-->
                                                <lable   style="display:block;width:240px;float:left;text-align:right">活动名称：</lable><input type="text"  value="<?php echo  isset($info['FTitle'])?$info['FTitle']:'';?>" name='FTitle'  placeholder="大楚网十周年庆"  data-msg="不能为空" data-pattern="require" >
                                                </div>
                                           
                                                <div class="control-group block">
                                                    <label  style="display:block;width:240px;float:left;text-align:right">开始时间：</label>
                                                    <input name="FStartTime" type="text" style="width:200px;" value="<?php echo  isset($info['FStartTime'])?date('Y-m-d H:i:s',$info['FStartTime']):'';?>" placeholder="请填写活动开始时间" data-pattern="require" data-msg="请填写活动开始时间" class="row-fluid datepicker"  >
                                                </div>

                                                <div class="control-group block">
                                                    <label  style="display:block;width:240px;float:left;text-align:right">结束时间：</label>
                                                    <input name="FEndTime" type="text" style="width:200px;" value="<?php echo  isset($info['FEndTime'])?date('Y-m-d H:i:s',$info['FEndTime']):'';?>" placeholder="请填写活动结束时间" data-pattern="require" data-msg="请填写活动结束时间" class="row-fluid datepicker" >
                                                </div>
                                             </div>
                                 
                                                
                                              
                              
                                             <div class="white_alert">
                                                <div class="t2">奖项设置：</div>
                                                <div class="control-group block">
                                                    <label  style="display:block;width:240px;float:left;text-align:right">用户可中奖次数：</label><input type="text" name="FWinNum"  style='width:20px;'value="<?php echo  isset($info['FWinNum'])?$info['FWinNum']:'';?>" placeholder="1" data-msg="请输入用户可中奖次数" data-pattern="require" ></div>
                                             
                                             <p>中奖用户是否还能中奖 <input type="radio" name="FWin_again" value="1" <?php if (!isset($view['FWin_again']) || $view['FWin_again'] == 1) { echo 'checked';} ?> ><lable>是</lable>
                                                <input type="radio" name="FWin_again" value="0" <?php if (isset($view['FWin_again']) || $view['FWin_again'] == 0) { echo 'checked'; } ?> ><lable>否</lable></p>
                                             <hr>
                                              <?php if($info['price']){?>
                                                <?php $i=0;foreach($info['price'] as $p){?>
                                                    <div class="win_set" style="position:relative">
                                                           <?php if($i>=3){?>
                                                       <span class="del_this" style="position:absolute;left:400px;cursor:pointer">删除本项</span>
                                                       <?php } ?>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">自定义名称：</label><input type="text"  value="<?php echo  isset($p['FTitle'])?$p['FTitle']:'';?>" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品名称：</label><input type="text"  value="<?php echo  isset($p['FName'])?$p['FName']:'';?>" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品数量：</label><input type="text"  value="<?php echo  isset($p['FNum'])?$p['FNum']:'';?>" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" ></div>
                                                        <div class="control-group block"><label style="display:block;width:240px;float:left;text-align:right">奖品概率：</label><input type="text"  value="<?php echo  isset($p['FPv'])?$p['FPv']:'';?>" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></div>
                                                    <hr>
                                                    </div>
                                              <?php $i++;}}else{ ?>
                                                          <div class="win_set" >
                                                        <div class="control-group block"><label   style="display:block;width:240px;float:left;text-align:right">自定义名称：</label><input type="text"  value="" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品名称：</label><input type="text"  value="" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品数量：</label><input type="text"  value="" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品概率：</label><input type="text"  value="" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></div>
                                                   <hr>
                                                    </div>
                                               <div class="win_set" style="position:relative">
                                                        <div class="win_set" >
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">自定义名称：</label><input type="text"  value="" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品名称：</label><input type="text"  value="" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品数量：</label><input type="text"  value="" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品概率：</label><input type="text"  value="" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></div>
                                                   <hr>
                                                    </div>
                                               <div class="win_set" style="position:relative">
                                                        <div class="win_set" >
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">自定义名称：</label><input type="text"  value="" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品名称：</label><input type="text"  value="" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品数量：</label><input type="text"  value="" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" ></div>
                                                        <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">奖品概率：</label><input type="text"  value="" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></div>
                                                   <hr>
                                                    </div>
                                                <?php } ?>
                                             
                                                <button type="button" class="vb_btn_tiny vb_btn_blue" id="add_win_set">继续添加奖项</button>
                                    
                                             </div>
                                            <div class="hite_alert">
                                            <div class="t2">抽奖设置</div>
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">每人每天次数：</label><input type="text"  value="<?php echo  isset($view['FDaycount'])?$view['FDaycount']:'';?>" name='FDaycount'   placeholder="每天每天可以抽奖的次数" data-msg="不能为空" data-pattern="require"></div>
                                          
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">分享后是否能增加抽奖资格：</label><input type="radio" name="FShareIsAdd" value="1" <?php if (!isset($view['FShareIsAdd']) || $view['FShareIsAdd'] == 1) { echo 'checked';} ?>><lable>是</lable><input type="radio" name="FShareIsAdd" value="0" <?php if (!$view['FShareIsAdd']) { echo 'checked';} ?> ><lable>否</lable></div>
                                           
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">最大分享有效次数：</label><input type="text"  style='width:50px;' value="<?php echo  isset($info['FShareNum'])?$info['FShareNum']:'';?>" name='FShareNum'  placeholder="最大分享有效次数" data-msg="不能为空" data-pattern="require"></div>
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">每次有效分享后能获得的抽奖次数：</label><input type="text"  style='width:50px;' value="<?php echo  isset($info['FShareAddNum'])?$info['FShareAddNum']:'';?>" name='FShareAddNum'  placeholder="每次有效分享后能获得的抽奖次数"  data-msg="不能为空" data-pattern="require"></div>
                                           
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">中奖提示：</label><textarea name='FWin_mess'   placeholder="中奖提示"  data-msg="不能为空" data-pattern="require"><?php echo  isset($info['FWin_mess'])?$info['FWin_mess']:'';?></textarea></div>
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">活动规则：</label><textarea name='FRule'  placeholder="活动规则"  data-msg="不能为空" data-pattern="require"><?php echo  isset($info['FRule'])?$info['FRule']:'';?></textarea></div>
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">领奖方式：</label><textarea name='FLingjiang'  placeholder="领奖方式"  data-msg="不能为空" data-pattern="require"><?php echo  isset($info['FLingjiang'])?$info['FLingjiang']:'';?></textarea></div>
                                            <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">次数结束提示：</label><textarea name='FEndNumMess'  placeholder="次数结束提示"  data-msg="不能为空" data-pattern="require"><?php echo  isset($info['FEndNumMess'])?$info['FEndNumMess']:'';?></textarea></div>
                                                    
            
                                             </div>
                                            
                                            <div class="white_alert">
                                                <div class="t2">报名登录设置</div>
                                                <div class="control-group block">
                                                    <label  style="display:block;width:240px;float:left;text-align:right">是否在活动前显示弹窗：</label>
                                                    <input type="radio" name="FFrom_p" value="1" <?php if (!isset($view['FFrom_p']) || $view['FFrom_p'] == 1) { echo 'checked';} ?>><lable>是</lable>
                                                    <input type="radio" name="FFrom_p" value="0" <?php if (!$view['FFrom_p']) { echo 'checked';} ?>><lable>否</lable> 
                                                    <em style="font-size:0.9em">如勾选否，弹窗将在活动后弹出 </em>
                                                </div>
                                                <hr>
                                               
                                                <div class="alert_input" style="position:relative">
                                                    
                                                    <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">请选择表单输入框：</label>
                                                     
                                                     <?php if(!empty($inputs)){ ?>
                                                     <?php foreach($inputs as $input){ ?>

                                                        <input type="checkbox"  name='input[]' value="<?php echo $input['FID']?>" <?php  if(isset($info['FInputs'])&&in_array($input['FID'],$info['FInputs'])){echo 'checked="checked"';}?> ><?php echo $input['FTitle']?>&nbsp;&nbsp;
                                                     <?php }}?>
                                                    </div>  
                                                   
                                              
                                          
                                                <button type="button" class="vb_btn_tiny vb_btn_blue" id="add_input">继续添加输入框</button>
                                             </div>
                                            
<!--                                            <div class="control-group white_alert">
                                               <div class="t2">图文设置（建议尺寸480x960）</div>
                                               <p>活动简介*     <input type="text"  name='FDesc' value='<?php echo  isset($info['FDesc'])?$info['FDesc']:'';?>'  placeholder="本次活动的简介" data-msg="活动简介不能为空"> </p>
                                               <p>活动封面*  <button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FImgUrl" type="button">更换背景图</button></p>
                                                <img style="width:100px;height:100px;<?php if(!$info['FImgUrl']){echo 'display:none';}?>" src="<?php echo $info['FImgUrl']?$info['FImgUrl']:'';?>" id="onload_image_FImgUrl">
                                                <input type="hidden" value="<?php echo  isset($info['FImgUrl'])?$info['FImgUrl']:'';?>" name="FImgUrl" id="img_FImgUrl">
                                            </div>-->
                                            
                                            
                                              <div class="white_alert">
                                                    <div class="t2">分享设置（建议尺寸480x960）</div>
                                                    <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">分享内容：</label><input type="text"  name='FShareTxt' value='<?php echo  isset($info['FShareTxt'])?$info['FShareTxt']:'';?>'  placeholder="分享的文字信息"  data-msg="不能超于50个字符" data-pattern="require"> </div>
                                                    <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">分享链接：</label><input type="text"  name='FShareUrl' value='<?php echo  isset($info['FShareUrl'])?$info['FShareUrl']:'';?>' placeholder="分享的链接地址"  data-msg="不能为空" data-pattern="require"></div>
                                                    <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">分享图片：</label><button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FShareImg" type="button">更换背景图</button></div>
                                                    <img style="width:100px;height:100px;<?php if(!$info['FShareImg']){echo 'display:none';}?>" src="<?php echo $info['FShareImg']?$info['FShareImg']:'';?>" id="onload_image_FShareImg">
                                                    <input type="hidden" value="<?php echo  isset($info['FShareImg'])?$info['FShareImg']:'';?>" name="FShareImg" id="img_FShareImg">
                                            </div>
                                            
                                              <div class="white_alert">
                                               <div class="t2">活动特殊设置（建议尺寸480x960）</div>
                                           
                                               <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">活动banner：</label><button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FBannerImg" type="button">更换背景图</button></div>
                                                <img style="width:100px;height:100px;<?php if(!$info['FBannerImg']){echo 'display:none';}?>" src="<?php echo $info['FBannerImg']?$info['FBannerImg']:'';?>" id="onload_image_FBannerImg">
                                                <input type="hidden" value="<?php echo  isset($info['FBannerImg'])?$info['FBannerImg']:'';?>" name="FBannerImg" id="img_FBannerImg">
                                                
                                                <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">活动背景图：</label><button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FBgImg" type="button">更换背景图</button></div>
                                                <img style="width:100px;height:100px;<?php if(!$info['FBgImg']){echo 'display:none';}?>" src="<?php echo $info['FBgImg']?$info['FBgImg']:'';?>" id="onload_image_FBgImg">
                                                <input type="hidden" value="<?php echo  isset($info['FBgImg'])?$info['FBgImg']:'';?>" name="FBgImg" id="img_FBgImg">
                                                
                                                 <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">刮奖区域：</label><button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FScratchImg" type="button">更换背景图</button></div>
                                                <img style="width:100px;height:100px;<?php if(!$info['FScratchImg']){echo 'display:none';}?>" src="<?php echo $info['FScratchImg']?$info['FScratchImg']:'';?>" id="onload_image_FScratchImg">
                                                <input type="hidden" value="<?php echo  isset($info['FScratchImg'])?$info['FScratchImg']:'';?>" name="FScratchImg" id="img_FScratchImg">
                                                
                                                 <div class="control-group block"><label  style="display:block;width:240px;float:left;text-align:right">活动详情背景图：</label><button  class="vb_btn_tiny vb_btn_blue upload_img" data-id="FDescImg" type="button">更换背景图</button></div>
                                                <img style="width:100px;height:100px;<?php if(!$info['DescImg']){echo 'display:none';}?>" src="<?php echo $info['DescImg']?$info['DescImg']:'';?>" id="onload_image_FDescImg">
                                                <input type="hidden" value="<?php echo  isset($info['FDescImg'])?$info['FDescImg']:'';?>" name="FDescImg" id="img_FDescImg">
                                                
                                            </div>
                                         
                                        </form>
                                    </div>


<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/main.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/editor_init.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/timepicker.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/src/plugins/activity_main.js" type="text/javascript"></script>
<script> 
    $(function(){
        $('#add_win_set').click(function(){
                    var $html='';
                    if($('.win_set').length>=3){
                      $html += '<div class=\"win_set\" style="position:relative"><span class=\"del_this\" style="position:absolute;left:580px;top:-20px ; cursor:pointer">删除本项</span>';
                    }else{
                      $html += '<div class=\"win_set\" style="position:relative">';
                    }
  
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">自定义名称：</span><input type=\"text\"  value=\"\" name=\"p_title[]\" placeholder=\"一等奖\" data-msg=\"不能为空\" data-pattern=\"require\"></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品名称：</span><input type=\"text\"  value=\"\" name=\"p_name[]\" placeholder=\"iphone\"  data-msg=\"不能超于50个字符\" data-pattern=\"require\" ></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品数量：</span><input type=\"text\"  value=\"\" name=\"p_num[]\"  placeholder=\"10\"  data-msg=\"请填写奖品数量\" data-pattern=\"require\"></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品概率：</span><input type=\"text\"  value=\"\" name=\"p_v[]\" placeholder=\"5\" data-msg=\"请填入一个整数\" data-pattern=\"require\" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></p>';
                      $html += '<hr>';
                      $html += '</div>';
                $($html).insertBefore($('#add_win_set'));
        });
        
        $('#iframe_form').delegate(".del_this","click",function(){
               $(this).parent().remove();
        });
        
        $('#add_input').click(function(){
                    var $html='';
                    if($('.alert_input').length>=2){
                      $html += '<div class=\"alert_input\" style="position:relative"><span class=\"del_this\" style="position:absolute;left:580px;top:-20px ; cursor:pointer">删除本项</span>';
                    }else{
                      $html += '<div class=\"alert_input\" style="position:relative">';
                    }
                    $html += '<p><span style="display:block;width:240px;float:left;text-align:right">自定义名称：</span><input type="text"  value="" name="input_name[]" ><span style="margin:0 5px;font-size:12px;" >提交的属性</span></p>';
                    $html += '<p><span style="display:block;width:240px;float:left;text-align:right">初始内容：</span><input type="text"  value="" name="input_value[]" ><span style="margin:0 5px;font-size:12px;" >提交的value</span></p>';
                    $html += '<hr>';
                    $html += '</div>';
                $($html).insertBefore($('#add_input'));
        });
        
     parent.window.triggerIframeSubmit = function() {
        console.log("parent.window.triggerIframeSubmit");
        $("#iframe_form").trigger("submit");
    };
})
</script>

</body>
</html>