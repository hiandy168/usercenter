
<div class="ad-right-navfix">
    <ul>
        <li class="selected"><a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$id))?>">
                <div class="ad-right-navfix1 ad-right-navfix1bg1">
                    <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-right-nav-rate.png"/></i>
                    <em>应用数据</em>
                </div>
            </a></li>
        <li class="selected"><a href="<?php echo $this->createUrl('project/activityall',array('pid'=>$id))?>">
                <div class="ad-right-navfix1 ad-right-navfix1bg2">
                    <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-right-nav-thumbnails.png"/></i>
                    <em>活动组件</em>
                </div>
            </a></li>
        <li class="selected"><a href="<?php echo $this->createUrl('/project/appinfo',array('id'=>$id))?>">
                <div class="ad-right-navfix1 ad-right-navfix1bg3">
                    <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-right-nav-save.png"/></i>
                    <em>应用配置</em>
                </div>
            </a></li>
    </ul>

</div>
