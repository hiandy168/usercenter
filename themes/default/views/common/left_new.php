<div class="left" id='leftmenu'>
    <div class="title2">
        <div class="title22">
            <span class="arrow"></span> 管理中心
        </div>
        <ul class="subtitle">
            <li>
                <a href="<?php echo $this->createAbsoluteUrl('/project/prolist'); ?>">应用管理</a>
            </li>
            <li>
                <a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" >创建应用</a>
            </li>
            <li>
                <a href="<?php echo $this->createAbsoluteUrl('/wiki'); ?>" target="_blank">帮助中心</a>
            </li>
            <li>
                <a href="<?php echo $this->createAbsoluteUrl('/dachu/sdk.zip'); ?>" >SDK下载</a>
            </li>
        </ul>
    </div>

    <div class="title2">
        <div class="title22">
            <span class="arrow"></span> 基本信息
        </div>
        <ul class="subtitle">
            <li>
                <a href="<?php echo $this->createAbsoluteUrl('/site/updatememinfo'); ?>">修改资料</a>
            </li>
        </ul>
    </div>

</div>
<script>
    var  thisurl  = "<?php echo Mod::app()->request->hostInfo.Mod::app()->request->url;?>";
    thisurl  = thisurl.toLowerCase();
    var  lias = $('#leftmenu').find('li >a');
    lias.each(function(){
         if($(this).attr('href') === thisurl){
              $(this).parent('li').css('background','#e6e6e6');
              $(this).parents('.title2').find('.subtitle').css('display','block');
              $(this).parents('.title2').find('.arrow').addClass('arrow_down');
         }
    });
    

</script>