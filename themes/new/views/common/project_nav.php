<div class="nav_cont" id="nav_cont">
	<ul>
		<li class="title_nav"><strong>基础配置</strong></li>
		<li><a href="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$view->id)); ?>" class="">应用信息</a><span></span></li>
		<li><a href="<?php echo $this->createAbsoluteUrl('/project/setting',array('id'=>$view->id)); ?>" class="">接口配置</a><span></span></li>

	</ul>
</div>

<script>
    var  thisurl  = "<?php echo Mod::app()->request->hostInfo.Mod::app()->request->url;?>";
    thisurl  = thisurl.toLowerCase();
    var  lias = $('#nav_cont').find('li >a');
    lias.each(function(){
         if($(this).attr('href') === thisurl){
             $(this).addClass('active');
         }
    });
</script>