<?php echo $this->renderpartial('/common/header1',$config); ?>
		
		<div class="div-main">
          
              <!--<div class="top-title clearfix">
                    <a class="lefta fl" href="javascript:history.back();void(0)">城市服务</a>
                </div>-->


             <div><img src="<?php echo $this->_theme_url;?>assets/h5/1.1/images/city-banner.jpg" width="100%" /></div>

             <div class="city-stips bb bt">
                <a href="">
                <span><img src="<?php echo $this->_theme_url;?>assets/h5/1.1/images/city-service-icon18.png"/></span>
                <i class="btnmore"></i>
                <em>湖北省6.24发布暴雨橙色预警雨橙色雨橙色雨橙色</em>
                </a>
             </div>


             <div class="city-service1 bt clearfix">




            <?php foreach($cates as $v){ ?>
                    <div class="city-service1 bt clearfix">
                        <h2 class="bb"><?php echo $v->name; ?></h2>
                    <ul>
                    <?php $lists = CityLife::model()->findAllByAttributes(array('cateid'=>$v->id,'status'=>1));
                    if($lists){
                        foreach($lists as $k => $list){  ?>
                            <li>
                                <a href="<?php echo $list->url; ?>">
                                <div class="city-service1-1 bb">
                                    <i><img src="<?php echo '/'.$list->icon; ?>"/></i>
                                    <em><?php echo $list->name; ?></em>
                                </div>
                                </a>
                            </li>
                        <?php } } ?>
                    </ul></div>
                <?php } ?>
            </div>
        </div>
	</body>
</html>
