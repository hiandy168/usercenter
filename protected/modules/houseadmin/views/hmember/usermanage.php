<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>

<div class='bgf clearfix'>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 30px;text-align: center">ID</th>
                    <th style="width: 80px;text-align: center">姓名</th>
                    <th style="width: 100px;text-align: center">电话</th>
                    <th style="width: 100px;text-align: center">订单号</th>
                    <th style="width: 120px;text-align: center">下单时间</th>
                    <th style="width: 120px;text-align: center">下单状态</th>
                    <th style="width: 120px;text-align: center">金额</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($houslist)){
                    foreach ($houslist as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td style="text-align: center"><?php echo $item['id']; ?></td>
                            <td style="text-align: center"><?php echo $item['member']['realname'] ?></td>
                            <td style="text-align: center"><?php echo $item['member']['phone'] ?></td>
                            <td style="text-align: center"><?php echo $item['ordernum'] ?></td>
                            <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$item['createtime']); ?></td>
                            <td style="text-align: center">
                                <?php
                                if($item['paystatus']==1){
                                    echo "未支付";
                                }elseif($item['paystatus']==2){
                                    echo "已支付";
                                }elseif($item['paystatus']==3){
                                    echo "已使用";
                                }elseif($item['paystatus']==4){
                                    echo "已退款";
                                }
                                ?>
                            </td>
                            <td style="text-align: center"><?php echo $item['money']; ?></td>
                        </tr>
                    <?php }}?>
                </tbody>
            </table>

            <div class="pages clearfix">
                <?php
                $this->widget('CLinkPager', array('pages' => $pages,
                        'cssFile' => false,
                        'header'=>'',
                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                        'prevPageLabel' => '前一页',
                    )
                );
                ?></div>
        </form>
    </div>
</div>