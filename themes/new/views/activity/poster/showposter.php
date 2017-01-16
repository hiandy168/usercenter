<img src="<?php echo "/data".$poster_img;?>">

<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/poster/showposter',array('poster_id'=>$poster_id) ))); ?>
