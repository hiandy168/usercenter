<!-- 组件 start -->
     <style>
         .components .left .slider_show .bd ul li .item {margin: 15px 20px;}
         .components .left .slider_show .bd, .components .left .slider_show .bd ul, .components .left .slider_show .bd ul li, .components .left .slider_show .bd ul li .item_wrap { height: 560px;}
     </style>
    <div class="left" style="width:24%">
        <div class="title" style="background: white;border-bottom:1px solid #CDCDCD;">组件</div>
        <div class="slider_show" style="background: white;padding-top:15px;">
            <div class="bd">
                <ul class="clearfix">
                    <li>
                        <div class="item_wrap" style="width: 86%;margin: 0 auto;">
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/scratchcard/list',array('pid'=>$pid,'active'=>1));?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==1){echo 'act-left-icon_hover_03.png'; echo '" class="mark_hover"';}else{echo 'act-left-icon_03.png';}?>" height="60"
                                     width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_03.png">
                                <div class="text">刮刮卡</div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/pccheckin/list',array('pid'=>$pid,'acitvie'=>2)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==2){echo 'act-left-icon_hover_05.png';  echo '" class="mark_hover"';}else{echo 'act-left-icon_05.png';}?>" height="60"
                                     width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_05.png">
                                <div class="text">签到</div>
                                </a>
                            </div>                            
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/signup/list',array('pid'=>$pid,'acitvie'=>3)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==3){echo 'act-left-icon_hover_09.png';  echo '" class="mark_hover"';}else{echo 'act-left-icon_09.png';}?>" height="60"
                                     width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_09.png">
                                <div class="text">报名</div>
                                </a>
                            </div>                            
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/poster/list',array('pid'=>$pid,'acitvie'=>4)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==4){echo 'act-left-icon_hover_10.png';  echo '" class="mark_hover"';}else{echo 'act-left-icon_10.png';}?>" height="60"
                                     width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_10.png">
                                <div class="text">海报</div>
                                </a>
                            </div>                            
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/vote/list',array('pid'=>$pid,'acitvie'=>5)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==5){echo 'act-left-icon_hover_13.png';  echo '" class="mark_hover"';}else{echo 'act-left-icon_13.png';}?>" height="60"
                                     width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_13.png">
                                <div class="text">投票</div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/bigwheel/list',array('pid'=>$pid,'acitvie'=>6)); ?>">
                                    <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($active==6){echo 'act-left-icon_hover_14.png';  echo '" class="mark_hover"';}else{echo 'act-left-icon_14.png';}?>" height="60"
                                         width="60" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/act-left-icon_hover_14.png">
                                    <div class="text">大转盘</div>
                                </a>
                            </div>

                            <div class="item">
                                <a>
                                <img src="/assets/images/act-left-icon_17.png" height="60" width="60">
                                <div class="text" style="color: #9d9d9d;">零元购</div>
                                </a>
                            </div>

                            <div class="item">
                                <a>
                                <img src="/assets/images/act-left-icon_18.png" height="60" width="60" >
                                <div class="text" style="color: #9d9d9d;">一元购</div>
                                </a>
                            </div>


                            <div class="item">
                                <a>
                                <img src="/assets/images/act-left-icon_21.png" height="60" width="60" >
                                <div class="text" style="color: #9d9d9d;">众筹</div>
                                </a>
                            </div>





                        </div>
                    </li>
                </ul>
            </div>
			<script>
				var img, hover_image;
				$(".components .left .item_wrap .item").find('img').hover(function(){
					if($(this).hasClass("mark_hover")) {
						return false;
					}
					
					hover_image = $(this).attr('data-hover');
					img = $(this).attr('src');
					$(this).attr('src', hover_image);
				}, function(){
					if($(this).hasClass("mark_hover")) {
						return false;
					}
					$(this).attr('src', img);
				});
			</script>
            <div class="hd clearfix">
                <ul>
                    <li></li>
                    <!-- <li></li> -->
                </ul>
            </div>
        </div>
    </div>

    
            