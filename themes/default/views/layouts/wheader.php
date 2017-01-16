<!-- 组件 start -->

    <div class="left" style="width:24%">
        <div class="title" style="background: white;border-bottom:1px solid #CDCDCD;">组件</div>
        <div class="slider_show" style="background: white;padding-top:15px;">
            <div class="bd">
                <ul class="clearfix">
                    <li>
                        <div class="item_wrap">
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/scratchcard/list',array('pid'=>$this->pid,'active_1'=>1));?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_1==1){echo 'zj_5_hover.jpg'; echo '" class="mark_hover"';}else{echo 'zj_5.jpg';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/zj_5_hover.jpg">
                                <div class="text">刮刮卡</div>
                                </a>
                            </div>
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/pccheckin/list',array('pid'=>$this->pid,'acitvie_2'=>1)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_2==1){echo 'fp_hover.jpg';  echo '" class="mark_hover"';}else{echo 'fp.png';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/fp_hover.jpg">
                                <div class="text">签到</div>
                                </a>
                            </div>                            
                            <div class="item">
                                <a href="<?php echo $this->createUrl('/activity/signup/signuplist',array('pid'=>$this->pid)); ?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/<?php if($this->active_3==1){echo 'zj_zxbm_hover.jpg';  echo '" class="mark_hover"';}else{echo 'zj_zxbm.png';}?>" height="47"
                                     width="47" data-hover="<?php echo Mod::app()->baseUrl ?>/assets/images/zj_zxbm_hover.jpg">
                                <div class="text">报名</div>
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

    
            