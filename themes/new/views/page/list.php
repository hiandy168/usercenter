<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<style>
.pages{width:100%;text-align:center;height:28px;margin:15px auto;}
.pages ul{height:28px;line-height:28px;padding:0;margin:0 auto;display:inline-block; *display:inline;}
.pages ul li{float:left;margin:0 2px;line-height:28px;height:28px;}
.pages ul li a,.pages ul li span{color:#000;padding:5px 10px;border:1px solid #c8c8c8;border-radius: 3px}
.pages ul li a:hover,.pages ul li a.hover{color:#fff;background:#ccc;font-weight:bold;}
.pages ul li.selected{background:#ccc}
.pages ul li.selected a{font-weight:bold}
</style>
<div class="sidecon">
    <div class="wp">
        
        <div class="sidebanner"><img src="<?php echo $this->_theme_url ?>images/sidebanner.jpg" width="1000" height="203" /></div>
        
        <div class="wp location">
	        <a class="base" href="<?php echo $this->_siteUrl?>" title="<?php echo $this->site_config['site_title'];?>">网站主页</a>
			<?php  echo isset($position)?JkCms::get_position($position):'';?>
	        <strong>列表</strong>
			
        </div>


    <div class="sidecon_box cl">
        
        <div class="sidebar">
          <div class="tit png"><h5>其他单页</h5></div>
                
                <div class="list">
 
                              <ul>
		 <?php $navs = JkCms::getList('page'); ?>
         <?php $i = 1;$count=count($navs);if($navs){foreach ($navs as $n) { ?>
			    <li><a href="<?php echo $n['url'] ?>"><?php echo $n['title'] ?></a></li>
         <?php $i++;}} ?>
				</ul>
                </div>

        </div>
        
        <div class="sidemain">
            
            <div class="news">
                <ul class="cl">


        <?php if(!empty($list)){foreach($list as $item){?>    
		 <li><a href="<?php echo Mod::app()->createUrl('page/',array('id'=>$item['id']))?>" title="<?php echo $item['title']?>"><?php echo $item['title']?> 
		 <?php if((date('Ymd',time())- date('Ymd',$item['createtime']))<=2){?>
		 <img src="<?php echo $this->_theme_url ?>images/new.png" />
		 <?php } ?>
		 </a><span class="time"><?php echo date('Y-m-d H:i:s',$item['createtime'])?></span></li>
        <?php  } } ?>

                </ul>
            </div>

			<div class="pages cl">
            <?php  $this->widget('MyLinkPager', array('pages' => $pagebar,
                                                    'cssFile' => false,
                                                    'header'=>'',
                                                    'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                    'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                    'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                    'prevPageLabel' => '前一页',
                                                    'maxButtonCount'=>8,
                                                        )
                    );
            ?>
    </div>
            
        </div>
    
    </div>
    </div>
</div>


<?php $this->renderPartial('/common/footer',array('config'=>$config));?>


