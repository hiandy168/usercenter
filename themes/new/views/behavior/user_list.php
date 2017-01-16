<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>  
<div class="new_wrap" style="width: 870px;">
    <div class="other_333 clearfix" style="margin-top: 0;">

        <div class="right_222" style="float:left;">
            <div class="i_222">用户</div>
            <div class="content_222">
                <table class="table_222">
                    <thead>
                    <tr>
                        <td>用户名</td>
                        <td>OpenID</td>
                        <td>创建时间</td>
                        <td>状态</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($datalist):foreach($datalist as $val): ?>
                    <tr>    
                        <td><?php echo $val->minfo['phone'];?></td>
                        <td><?php echo $val->openid;?></td>
                        <td><?php echo date('Y-m-d H:i:s',$val->createtime);?></td>
                        <td><a href="javascript:void(0);" onclick="sendMsg(<?php echo $val->id?>);">发送消息</a> | <a href="javascript:void(0);" onclick="viewMsg(<?php echo $val->id?>);">查看</a></td> 
                    </tr>
                    <?php endforeach;endif;?>   
                    </tbody>

                </table>
                <div class="page_222">
                    <div class="ep-pages">
                    <?php
                      $this->widget('CoLinkPager', array('pages' => $pagebar,
                      'cssFile' => false,
                      'header'=>'',
                      'firstPageLabel' => '首页', //定义首页按钮的显示文字
                      'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                      'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                      'prevPageLabel' => '前一页',
                       )
                     );
                    ?>                                                                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//发送站内信息
function sendMsg(mid){
    layer.open({
     type: 2,
     title: '发送信息',
     shadeClose: true,
     shade: [0],
     area: ['650px', '379px'],
     content: '<?php echo $this->createUrl('/behavior/messageiframe',array('pid'=>$pid));?>/mid/'+mid, 
   }); 
 }

//浏览用户消息
function viewMsg(mid){
    layer.open({
      type: 2,
      title: '查看消息',
      shade: [0],
      area: ['893px', '600px'],
      shift: 2,
      content: '<?php echo $this->createUrl('/behavior/MessageListIframe',array('pid'=>$pid));?>/mid/'+mid,
    });   
}

</script>