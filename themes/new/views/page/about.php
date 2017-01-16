<?php $this->renderPartial('/common/header',array('config'=>$config));?>

<!--banner-->
<div id="slider">
	<div id="slideshow">
		<div class="slider-item" style='height:347px;  background:transparent  url(<?php echo $this->_theme_url ?>images/banner.png) repeat scroll center top;'>
         </div>
</div>
</div>
<!--banner end-->

<?php echo $view['content'];?>



  <?php $this->renderPartial('/common/footer',array('config'=>$config));?>
