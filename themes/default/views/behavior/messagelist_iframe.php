<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
<div class="new_wrap" style="width: 870px;">
    <div class="other_333 clearfix" style="margin-top: 0;">
        <div class="right_222" style="float:left;">
            <div class="content_222">
                <table class="table_222">
                    <thead>
                    <tr>
                        <td>消息标题</td>
                        <td>消息内容</td>
                        <td>发送时间</td>
                        <td>消息状态</td>
                    </tr>
                    </thead>
                    <tbody>
                        
                    <?php if($datalist):foreach($datalist as $val): ?>
                    <tr>    
                        <td><?php echo $val->title;?></td>
                        <td><?php echo $val->content;?></td>
                        <td><?php echo date('Y-m-d H:i:s',$val->sendTime);?></td>
                        <td><?php echo $val->status?'已读':'未读';?></td> 
                    </tr>
                    <?php endforeach;else:?>               
                    <tr><td colspan="4"><span style=" padding: 5px; border: 1px solid #ccc;">未发送消息！</span></td></tr>
                    <?php endif;?>
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