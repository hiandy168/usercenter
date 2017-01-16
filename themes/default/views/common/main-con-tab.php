<div class="index-data-tab clearfix">
    <ul>
        
        <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'user')); ?>"><li data-id="order" class="index-data-tab-singe <?php echo $tab=='user' ? 'active' : '';?>">用户数据</li></a>
        <li><span></span></li>
        <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'behavior')); ?>"><li data-id="consumption-integral" class="index-data-tab-singe <?php echo $tab=='behavior' ? 'active' : '';?>">行为数据</li></a>
        <li><span></span></li>
        <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'points')); ?>"><li data-id="consumption-money" class="index-data-tab-singe <?php echo $tab=='points' ? 'active' : '';?>">积分数据</li></a>
        <li><span></span></li>
        <a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid)); ?>"><li data-id="access" class="index-data-tab-singe <?php echo $tab=='' ? 'active' : '';?>">访问数据</li></a>
        
    </ul>
</div>