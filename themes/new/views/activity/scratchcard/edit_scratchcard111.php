    <?php echo $this->renderpartial('/common/header_1', $config)?>
    <link href="<?php echo Mod::app()->baseUrl?>/assets/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo Mod::app()->baseUrl?>/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo Mod::app()->baseUrl?>/assets/lessCss/style.css?v=2.1&d=20140618" rel="stylesheet"/>
  
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/jquery-1.11.0.min.js" type="text/javascript"></script>
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/jquery-ui.js" type="text/javascript"></script>
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/bootstrap-wysiwyg.js" type="text/javascript"></script>
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/jquery.form.min.js" type="text/javascript"></script>
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/form_validator.js" type="text/javascript"></script>
<!--    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/bootstrap.min.js" type="text/javascript"></script>-->
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/jquery.hotkeys.js" type="text/javascript"></script>
    <script src="<?php echo Mod::app()->baseUrl?>/assets/js/jquery_extend.js" type="text/javascript"></script>

    <!-- 组件 start -->
    <div class="components w980 clearfix">
        <div class="left">
            <div class="title">组件</div>
            <div class="slider_show">
                <div class="bd">
                    <ul class="clearfix">
                        <li>
                            <div class="item_wrap">
                                <div class="item">
                                    <img src="<?php echo Mod::app()->baseUrl?>/assets/images/18.png" height="53" width="53">
                                    <div class="text">刮刮卡</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo Mod::app()->baseUrl?>/assets/images/18.png" height="53" width="53">
                                    <div class="text">刮刮卡</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo Mod::app()->baseUrl?>/assets/images/18.png" height="53" width="53">
                                    <div class="text">刮刮卡</div>
                                </div>
                                <div class="item">
                                    <img src="<?php echo Mod::app()->baseUrl?>/assets/images/18.png" height="53" width="53">
                                    <div class="text">刮刮卡</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="hd clearfix">
                    <ul>
                        <li></li>
                    </ul>
                </div>
            </div>
        </div>
        <form name="iframe_form" id="iframe_form" data-msg-pos="right" method="post" action="<?php echo $this->createurl('activity/scratchcard/save/'); ?>" class="form-horizontal">
            <input type="hidden" value="<?php echo  isset($info['FID'])?$info['FID']:'';?>" name="FID">
            <input type="hidden" value="<?php echo  isset($info['pid'])?$info['pid']:'';?>" name="pid">
            <div class="center">
            <div class="title">设置</div>
            <div class="content">
                <div class="t_title">活动名称<span>（1-20个字符）</span></div>
                <div class="input">
                    <!--<input type="text" value="" placeholder="请填写活动名称" class="input_text"/>-->
                    <input type="text"  value="<?php echo  isset($info['FTitle'])?$info['FTitle']:'';?>" name='FTitle'  placeholder="请填写活动名称"  data-msg=标题不能为空" data-pattern="require" class="input_text">
                     <div class="del"></div>
                </div>
                <div class="t_title">活动开始时间<span>（1-20个字符）</span></div>
                <div class="input">
                    <input name="FStartTime" type="text"  value="<?php echo  isset($info['FStartTime'])?date('Y-m-d H:i:s',$info['FStartTime']):'';?>" placeholder="活动开始时间" data-pattern="require" data-msg="请填写活动开始时间" class="input_text" />
                     <div class="del"></div>
                </div>
                <div class="t_title">活动结束时间<span>（1-20个字符）</span></div>
                <div class="input">
                    <input name="FEndTime" type="text" value="<?php echo  isset($info['FEndTime'])?date('Y-m-d H:i:s',$info['FEndTime']):'';?>" placeholder="活动结束时间" data-pattern="require" data-msg="请填写活动结束时间" class="input_text" />
                     <div class="del"></div>
                </div> 
                <div class="t_title">用户可中奖次数<span>（数字）</span></div>
                <div class="input">
                     <input type="text" name="FWinNum"  style='width:20px;' value="<?php echo  isset($info['FWinNum'])?$info['FWinNum']:'';?>" placeholder="0" data-msg="请输入用户可中奖次数" data-pattern="require" class="input_text" />
                     <div class="del"></div>
                </div>                   
                 <div class="t_title">中奖用户是否还能中奖<span></span></div>
                 <div class="input" style="border:none;">
                     <input type="radio" name="FWin_again" value="1" <?php if (!isset($info['FWin_again']) || $info['FWin_again'] == 1) { echo 'checked';} ?> ><lable>是</lable>
                     <input type="radio" name="FWin_again" value="0" <?php if (isset($info['FWin_again']) || $info['FWin_again'] == 0) { echo 'checked'; } ?> ><lable>否</lable>
                </div>  
                 
            <!--设置奖项 start//---->        
                       <div class="t_title">自定义名称<span></span></div>
                       <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FTitle'])?$p['FTitle']:'';?>" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" >
                           <div class="del"></div>    
                       </div>
                               
                      <div class="t_title">奖品名称<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FName'])?$p['FName']:'';?>" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" >
                            <div class="del"></div>    
                       </div>                     
                               
                      <div class="t_title">奖品数量<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FNum'])?$p['FNum']:'';?>" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                           
                            
                      <div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div>
                      <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FPv'])?$p['FPv']:'';?>" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                      
                      <hr>
                        <div class="t_title">自定义名称<span></span></div>
                       <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FTitle'])?$p['FTitle']:'';?>" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" >
                           <div class="del"></div>    
                       </div>
                               
                      <div class="t_title">奖品名称<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FName'])?$p['FName']:'';?>" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" >
                            <div class="del"></div>    
                       </div>                     
                               
                      <div class="t_title">奖品数量<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FNum'])?$p['FNum']:'';?>" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                           
                            
                      <div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div>
                      <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FPv'])?$p['FPv']:'';?>" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                      
                      <hr>                         
                        <div class="t_title">自定义名称<span></span></div>
                       <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FTitle'])?$p['FTitle']:'';?>" name='p_title[]' placeholder="一等奖" data-msg="不能为空" data-pattern="require" >
                           <div class="del"></div>    
                       </div>
                               
                      <div class="t_title">奖品名称<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FName'])?$p['FName']:'';?>" name='p_name[]' placeholder="iphone"  data-msg="不能超于50个字符" data-pattern="require" >
                            <div class="del"></div>    
                       </div>                     
                               
                      <div class="t_title">奖品数量<span></span></div>
                      <div class="input">
                            <input type="text"  value="<?php echo  isset($p['FNum'])?$p['FNum']:'';?>" name='p_num[]'  placeholder="10"  data-msg="请填写奖品数量" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                           
                            
                      <div class="t_title">奖品概率<span>(填入整数5就是中奖概率为5%)</span></div>
                      <div class="input">
                           <input type="text"  value="<?php echo  isset($p['FPv'])?$p['FPv']:'';?>" name='p_v[]'  placeholder="5" data-msg="请填入一个整数" data-pattern="require" >
                            <div class="del"></div>    
                      </div>                      
                      <hr>                         
                       <button type="button" class="vb_btn_tiny vb_btn_blue" id="add_win_set">继续添加奖项</button>                             
               <!----- end//--->   
                <div class="t_title">每人每天抽奖次数<span></span></div>
                <div class="input">
                     <input type="text"  value="<?php echo  isset($info['FDaycount'])?$info['FDaycount']:'';?>" name='FDaycount'   placeholder="每天每天可以抽奖的次数" data-msg="每人每天次数不能为空" data-pattern="require" class="input_text" >
                     <div class="del"></div>
                </div>
                 
                <div class="t_title">分享后是否能增加抽奖资格<span>（1-20个字符）</span></div>
                <div class="input">
                     <input type="radio" name="FShareIsAdd" value="1" <?php if (!isset($info['FShareIsAdd']) || $info['FShareIsAdd'] == 1) { echo 'checked';} ?>><lable>是</lable>
                     <input type="radio" name="FShareIsAdd" value="0" <?php if (isset($info['FShareIsAdd']) && !$info['FShareIsAdd']) { echo 'checked';} ?> ><lable>否</lable>
                </div>
                
                <div class="t_title">最大分享有效次数<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text"  style='width:50px;' value="<?php echo  isset($info['FShareNum'])?$info['FShareNum']:''?>" name='FShareNum'  placeholder="最大分享有效次数" data-msg="最大分享有效次数不能为空" data-pattern="require" class="input_text">
                     <div class="del"></div>
                </div>
                
                <div class="t_title">每次有效分享后能获得的抽奖次数<span>（1-20个字符）</span></div>
                <div class="input">
                    <input type="text"  style='width:50px;' value="<?php echo  isset($info['FShareAddNum'])?$info['FShareAddNum']:'';?>" name='FShareAddNum'  placeholder="每次有效分享后能获得的抽奖次数"  data-msg="每次有效分享后能获得的抽奖次数不能为空" data-pattern="require" class="input_text">
                     <div class="del"></div>
                </div>

               <div class="t_title">中奖提示<span>（1-20个字符）</span></div>
               <div class="input">
                   <input name='FWin_mess'   placeholder="中奖提示"  data-msg="中奖提示不能为空" data-pattern="require" value="<?php echo  isset($info['FWin_mess'])?$info['FWin_mess']:'';?>" class="input_text"/>
               <div class="del"></div>
               </div>
                
               <div class="t_title">活动规则<span>（1-20个字符）</span></div>
               <div class="input">
                   <input name='FRule' placeholder="活动规则"  data-msg="活动规则不能为空" data-pattern="require" value="<?php echo  isset($info['FRule'])?$info['FRule']:'';?>" class="input_text"/>
               <div class="del"></div>
               </div>
            
               <div class="t_title">领奖方式<span>（1-20个字符）</span></div>
               <div class="input">
                   <input name='FLingjiang'  placeholder="领奖方式"  data-msg="领奖方式不能为空" data-pattern="require" value="<?php echo  isset($info['FLingjiang'])?$info['FLingjiang']:'';?>" class="input_text"/>
               <div class="del"></div>
               </div>
               
               <div class="t_title">次数结束提示<span>（1-20个字符）</span></div>
               <div class="input">
                   <input name='FEndNumMess'  placeholder="次数结束提示"  data-msg="次数结束提示不能为空" data-pattern="require" value="<?php echo  isset($info['FEndNumMess'])?$info['FEndNumMess']:'';?>" class="input_text"/>
               <div class="del"></div>
               </div>
    
               <div class="t_title">活动结束提示<span>（1-20个字符）</span></div>
               <div class="input">
                   <input name='FEndMess'  placeholder="活动结束提示"  data-msg="活动结束提示不能为空" data-pattern="require" value="<?php echo  isset($info['FEndMess'])?$info['FEndMess']:'';?>" class="input_text"/>             
               <div class="del"></div>
               </div>
                
                 <div class="t_title">分享图片</div>
                 <div class="input upload_pic clearfix">                     
                     <button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FShareImg" type="button">更换背景图</button>                              
                 </div>   
                
                 <div class="t_title">活动banner</div>
                 <div class="input upload_pic clearfix">   
                    <button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FBannerImg" type="button">更换背景图</button>               
                 </div>
                 
                 <div class="t_title">活动背景图</div>
                 <div class="input upload_pic clearfix">   
                    <button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FBannerImg" type="button">更换背景图</button>               
                 </div>                
                 
                 <div class="t_title">刮奖区域</div>
                 <div class="input upload_pic clearfix">  
                   <button class="vb_btn_tiny vb_btn_blue upload_img" data-id="FScratchImg" type="button">更换背景图</button>
                 </div>
                 
                 <div class="t_title">活动详情背景图</div>
                 <div class="input upload_pic clearfix">  
                   <button  class="vb_btn_tiny vb_btn_blue upload_img" data-id="FDescImg" type="button">更换背景图</button>
                 </div>                
                
                 <div class="save_button" onclick="triggerIframeSubmit();" href="javascript:void(0);">保存</div>
            </div>
        </div>
        </form>
        <div class="right">
            <!-- 右边iframe部分 -->
            <div class="content">
                
            </div>
        </div>
    </div>
    <!-- 组件 end -->
  
<script src="<?php echo Mod::app()->baseUrl?>/assets/js/src/plugins/main.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->baseUrl?>/assets/js/src/plugins/editor_init.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->baseUrl?>/assets/js/src/plugins/timepicker.js" type="text/javascript"></script>
<script src="<?php echo Mod::app()->baseUrl?>/assets/js/src/plugins/activity_main.js" type="text/javascript"></script>

<?php echo $this->renderpartial('/common/footer_1')?>
