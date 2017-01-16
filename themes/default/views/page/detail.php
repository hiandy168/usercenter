<?php $this->renderPartial('/common/header',array('config'=>$config));?>


  <div class="banners">
    <img src="../img/banner_01.jpg" />
  </div>
  <table width="988" border="0" cellspacing="0" cellpadding="0" class="scallout">
    <tr>
      <td class="left" valign="top">
        <div class="leftmenu">
          <div class="top">医院概况</div>
          <?php  $about_page_arr = JkCms::getList('page',$view['category_id'],'','', '`order` desc,id desc','',1); ?>
          <?php if($about_page_arr){foreach($about_page_arr as $a){?>
          <a href="<?php echo Mod::app()->createUrl('page/'.($a['alias']?$a['alias']:$a['id']));?>" <?php  if($a['id']==$view['id']){?>class="hover"<?php } ?>><?php echo $a['title']?></a>
          <?php }} ?>
          <a href="http://www.whuh.com/" target="_blank">医院本部</a>
        </div>
<?php $this->renderPartial('/common/nva',array('config'=>$config));?>
      </td>
      <td class="right" valign="top">
        <div class="pagetitle">
          <span class="title"><?php echo $view['title']?>&nbsp;&nbsp;&nbsp;&nbsp;INTRODUCTION</span>
          <span class="sitemap">所在位置：协和西院 -> 医院概况 -> <?php echo $view['title']?>   
              <?php // echo isset($position)?JkCms::get_position($position):'';?>
          </span>
        </div>
        <div class="content">
          <?php echo $view['content']?>　　
        </div>
      </td>
    </tr>
  </table>

  
  



<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
