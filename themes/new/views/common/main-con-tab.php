 
    <div class="ad-data-nav w1000 clearfix bxbg mgt30">
        
        <ul>
            <li>
                <div class="ad-data-nav1">
                    <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid)); ?>">
                        <i class="b1 linear"></i>
                        <span class="b1"><em class="linear">访问数据</em></span>
                        <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-num-icon1.png" />
                   </a>
                </div>
            </li>
            
            <li>
                <div class="ad-data-nav1">
                    <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'user')); ?>">
                        <i class="b2 linear"></i>
                        <span class="b2"><em class="linear">用户数据</em></span>
                        <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-num-icon2.png" />
                   </a>
                </div>
            </li>
            
           <li>
                <div class="ad-data-nav1">
                    <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'behavior')); ?>">
                        <i class="b3 linear"></i>
                        <span class="b3"><em class="linear">行为数据</em></span>
                        <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-num-icon3.png" />
                   </a>
                </div>
            </li>
            
            <li>
                <div class="ad-data-nav1">
                    <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>"points")); ?>">
                        <i class="b4 linear"></i>
                        <span class="b4"><em class="linear">积分数据</em></span>
                        <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-num-icon4.png" />
                   </a>
                </div>
            </li>
           
        </ul>
        
    </div>