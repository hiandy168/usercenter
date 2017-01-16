<div class="main-cont-left fl">
            <div class="index-data-area mb20">
                <?php echo $this->renderpartial('/common/main-con-tab',array('pid'=>$config['pid'],'tab'=>$config['tab']));?>
                <div class="index-data-tab-cont">
                    <!--积分数据-->
            <div class="table-data cylindrical-pir-fr clearfix">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>手机号</th>
                            <th>积分</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($point['user'] as $val){?>
                        <tr>
                            <td><?php echo $val['id']?></td>
                            <td><?php echo $val['username']?></td>
                            <td><?php echo $val['phone']?></td>
                            <td><?php echo $val['point']?></td>
                        </tr>
                     <?php }?>
                    </tbody>
                </table>
                <div class="page_222">
                    <div class="ep-pages">
                    <?php
                      $this->widget('CoLinkPager', array('pages' => $point['pagebar'],
                      'cssFile' => false,
                      'header'=>'',
                      'footer'=>'共 '.$point['count'].' 条数据',
                      'firstPageLabel' => '首页', //定义首页按钮的显示文字
                      'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                      'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                      'prevPageLabel' => '前一页',
                       'maxButtonCount'=>5
                       )
                     );
                    ?>                                                                      
                    </div>
                </div>
            </div>
            <!--积分数据end-->
                    
                </div>
            </div>
            <!--数据区end-->
        </div>