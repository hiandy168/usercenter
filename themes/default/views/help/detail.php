<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<script type="text/javascript" src="<?php echo $this->_theme_url ?>/Scripts/menu.js"></script>
<script type="text/javascript">
<!--
/*第一种形式 第二种形式 更换显示样式*/
function setTab(name,cursel,n){
for(i=1;i<=n;i++){
  var menu=document.getElementById(name+i);
  var con=document.getElementById("con_"+name+"_"+i);
  menu.className=i==cursel?"hover":"";
  con.style.display=i==cursel?"block":"none";
}
}
//-->
</script>

  <div class="banners">
      
      <img src="<?php echo $this->_theme_url?>img/banner_08.jpg" />
  </div>
  <table width="988" border="0" cellspacing="0" cellpadding="0" class="scallout">
    <tr>
      <td class="left" valign="top">
        <div class="leftmenu">
          <div class="top">就医指南</div>
          <?php  $about_page_arr = JkCms::getList('help',$view['category_id'],'','', '`order` desc,id desc','',1);?>
          <?php if($about_page_arr){foreach($about_page_arr as $a){?>
          <a href="<?php echo Mod::app()->createUrl('help/'.$a['alias']);?>" <?php  if($a['id']==$view['id']){?>class="hover"<?php } ?>><?php echo $a['title']?></a>
          <?php }} ?>
        </div>
<?php $this->renderPartial('/common/nva',array('config'=>$config));?>
      </td>
      <td class="right" valign="top">
        <div class="pagetitle">
          <span class="title"><?php echo $view['title']?> &nbsp;&nbsp;&nbsp;&nbsp;NAVIGATION</span>
          <span class="sitemap">所在位置：协和西院 -> 就医指南 -> <?php echo $view['title']?>   
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
