<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/css/site.css">
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
<style>
.components .center {
    overflow: hidden;
    border: none;
    overflow-y: hidden; 
}
</style>
<div class="new_wrap" style="width: 870px;">
    <div class="other_333 clearfix" style="margin-top: 0;">

        <div class="right_222" style="float:left;">
            <div class="i_222">用户行为</div>
            <div class="content_222">
                <table class="table_222">
                    <thead>
                    <tr>
                        <td>用户名</td>
                        <td>OpenID</td>
                        <td>行为</td>
                        <td>IP</td>
                        <td>时间</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($datalist):foreach($datalist as $val): ?>
                    <tr>    
                        <td><?php echo $val['phone'];?></td>
                        <td><?php echo $val['openid'];?></td>
                        <td><?php echo $val['type'];?></td>
                        <td><?php echo $val['address'];?></td> 
                        <td><?php echo date('Y-m-d H:i:s',$val['createtime']);?></td>
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