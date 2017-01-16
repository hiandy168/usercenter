<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="all">
    <meta name="renderer" content="webkit">
    <title><?php echo $config['site_title']?></title>
    <meta name="Keywords" content="<?php echo $config['Keywords']?>" />
    <meta name="Description" content="<?php echo $config['Description']?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/css/style.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/css/jquery.mCustomScrollbar.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/js/mCustomScrollbar.js" type="text/javascript" charset="utf-8"></script> -->
	<script src="<?php echo $this->_theme_url; ?>assets/js/ZeroClipboard.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
    $(function(){
    		// $(window).load(function(){
      //      	         		$("#reloadif").mCustomScrollbar({theme:"dark"});
      //      	         	})
    	var clip=new ZeroClipboard($("#d_clip_button"), {
        moviePath: '<?php echo $this->_theme_url; ?>assets/js/ZeroClipboard.swf'
       });
       clip.on("complete",function(){
      	alert("复制成功！");
      });
    })
    </script>

    
</head>
<style type="text/css">
html, body { height: 100%; }
.ad-view-main { width: 100%; height: 100%; max-width: 1200px; min-width: 800px; position: relative; margin: 0 auto; }
.ad-view-main1 { position: absolute; top: 50%; margin-top: -360px; width: 100%; min-height: 730px; }
.ad-left-views { position: absolute; left: 10%; }
.ad-left-views .bgiphone { }
.ad-left-views1 { left: 9px; top: 78px; }
.ad-right-views { position: absolute; right: 10%; top: 50%; margin-top: -230px; text-align:center;background: rgba(255,255,255,0.2);border-radius: 20px; padding: 20px;}
.ad-right-views span { display: inline-block; width: 200px; }
.ad-right-views span img { width: 100%; }
.ad-right-views p { font-size: 16px; text-align: center; margin-top: 20px; color:#fff; }
.ad-right-views-links { margin-top: 20px; width: 285px; overflow: hidden; }
.ad-right-views-links textarea { width: 300px; border: none; height: 50px; background: none; color:#bbb; font-family: microsoft yahei; line-height: 24px; }
.ad-right-views-links em { display: block; background: #52bd8a; color: #fff; text-align: center; border-radius: 100px; cursor: pointer; margin: 20px auto; line-height: 40px; }
.ad-right-views-links em:hover{}
</style>

<body style="background: url(<?php echo $this->_theme_url; ?>assets/images/ad-views-main-bg2.png) center; background-size: cover;">
	
    <div class="ad-view-main">
    		
    	<div class="ad-view-main1">
    		
    		<div class="ad-left-views">
    			<img class="bgiphone" src="<?php echo $this->_theme_url; ?>assets/images/iphone-bg.png"/>	
        <div class="ad-view-app-maindiv ad-left-views1" id="reloadif">	           		
        <iframe  src="<?php echo $this->createUrl('/activity/vote/signup',array('id'=>$id))?>"></iframe>
        </div>
        </div>
    	
    	<div class="ad-right-views">
    		<span> <?php if($id){ ?>
                      <img src="<?php echo  $this->createAbsoluteUrl('/qrcode/index',array('url'=>base64_encode($this->_siteUrl.'/activity/vote/view/id/'.$id)));?>" />
                        <?php }else{?>
                           <img src="<?php echo  $this->createAbsoluteUrl('/qrcode/index',array('url'=>base64_encode($this->_siteUrl.'/h5')));?>"/> 
                       
 <?php }?></span>
    		<p>为了您的体验更好<br />建议您扫码在手机上体验</p>
    		<div class="ad-right-views-links">
    		<textarea id="fe_text" readonly="readonly"><?php echo $this->createAbsoluteUrl('/activity/vote/signup',array('id'=>$id))?></textarea>
             <em id="d_clip_button" data-clipboard-target="fe_text" >活动链接（点击复制）</em>
    		</div>
    	</div>
    	
    	</div>
    	
    </div>

    <?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/pcviews',array('id'=>$id) ))); ?>
</body>


</html>
