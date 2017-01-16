<?php echo $this->renderpartial('/common/header_new',$config); ?>

<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/js/echarts.min.js"></script>

    <!-- 数据分析 start -->
    <div class="data_analysis w960 clearfix">
        <div class="left">
            <a href="<?php echo $this->createUrl('behavior/index',array('id'=>$pid))?>"><div class="icon icon1">应用趋势</div></a>
            <a href="<?php echo $this->createUrl('behavior/userBehavior',array('id'=>$pid))?>"><div class="icon icon1 on1">用户分析</div></a>          
            <!-- //活动列表 -->
            <?php foreach($asList as $list):?>
            <a href="<?php echo $this->createUrl('behavior/view',array('fid'=>$list->FID,'id'=>$pid))?>"><div class="icon icon1"><?php echo $list->FTitle?></div></a>
           <?php endforeach;?>
        </div>

        <div class="right">
            <div class="title_wrap clearfix">
                <div class="title icon1">
                </div>
                <div class="search">
                    
                </div>
            </div>
            <div class="date_wrap clearfix">
                

<div class="content content1">
    <style type="text/css">
        .content_table {
            width: 100%;
            border-collapse: collapse;
        }
        thead{
            color: #fff;
    background-color: #888;
    height: 35px;
    line-height: 35px;
        }
        .content_table td {
            height: 58px;
            line-height: 58px;
            text-align: center;
            border-bottom: 1px solid #1399e5;
        }
        
        .content_table .no1 {
            width: 120px;
        }
        
        .content_table .no2 {
            width: 220px;
        }
        
        .content_table .no3 {
            width: 120px;
        }
        
        .content_table .no4 {
            width: 190px;
        }
        
        .content_table .no5 {
            width: 100px;
        }
        .content_table .no6 {
            width: 180px;
        }
        </style>
                    <table class="content_table">
                        <thead>
                            <tr>
                                <th>手机号</th>
                                <th>openid</th>
                                <th>行为</th>
                                <th>ip</th>
                                <?php if ($pid==8) {?><th>车牌号</th><?php }?>
                                <th>时间</th>
                            </tr>
                        </thead>
                        
                      <?php foreach ($datalist as $k => $v) {?>
                        <tr>
                            <td class="no1"><?php echo $v['phone']; ?></td>
                            <td class="no2"><?php echo $v['openid']; ?></td>
                            <td class="no3"><?php echo $v['type']; ?></td>
                            <td class="no4"><?php echo $v['ip']; ?></td>
                            <?php if ($pid==8) {?><td class="no5"><?php echo $v['carnumber']; ?></td><?php }?>                            
                            <td class="no6"><?php echo date('Y-m-d H:i:s',$v['createtime']); ?></td>
                            
                        </tr>
                      <?php } ?>
                    </table>
                  <div class="pages cl">
                    <?php
              $this->widget('CLinkPager', array('pages' => $pagebar,
                      'cssFile' => false,
                      'header'=>'<span style="float: right;margin: 0 2px;line-height: 28px;height: 28px;">总条数:'.$count.'</span>',
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


    <!-- 数据分析 end -->
    <!-- 底部样式 start -->
    <div class="foot">
        <div class="w980">
            <ul class="clearfix">
                <li>联系我们</li>
                <li>用户中心</li>
                <li>认证空间</li>
                <li>官方微博</li>
                <li>在线客服</li>
                <li>反馈意见</li>
            </ul>
            <div class="copy_right copy_right1">
                Copyright © 1998 - 2016 Tencent. All Rights Reserved.
            </div>
            <div class="copy_right copy_right2">
                腾讯·大楚网 版权所有
            </div>
        </div>
    </div>
</body>

</html>
