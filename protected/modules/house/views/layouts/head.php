<div class="div-main">

    <div class="f-head clearfix pos-r bgfff">
        <div class="f-head-logo fl"><a href="<?php echo $this->_siteUrl;?>/house/site"><img src="<?php echo $this->_siteUrl;?>/assets/house/images/f-head-logo.png" alt="腾讯楼盘商城" /></a></div>
        <div class="f-head-selectcity pos-r fl">

            <span class="fs28"><?php echo Cookie::get('city')==1 ?"武汉":"郑州"?></span>
        </div>
        <div class="f-head-help fr">
            <ul>
               <!--  <li><a href=""><i class="icon-help"></i></a></li> -->
                <li><a href="<?php echo $this->createUrl('/house/member/index',array('id'=>$this->member['id'])) ?>"><i class="icon-member"></i></a></li>
            </ul>
        </div>

        <div class="f-head-selectcitydiv">
		   			<span>
		   				<a href="<?php echo $this->createUrl('/house/site/index', array('city' => 1)) ?>">武汉</a>
		   				<a href="<?php echo $this->createUrl('/house/site/index', array('city' => 2)) ?>">郑州</a>
		   			</span>
        </div>
    </div>
    <div class="pos-r bb"></div>