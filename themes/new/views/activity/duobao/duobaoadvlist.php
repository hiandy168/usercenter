<?php echo $this->renderpartial('/common/header_new',$config); ?>
    <div class="ad-app-list w1000 clearfix bxbg mgt30">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>列表</h3>
            </div>
            <div class="fr tr">
                <a href="<?php echo $this->createUrl('/activity/duobao/advAdd',array('pid'=>$pid))?>">
                    <i class="aicon linear"></i> 新增幻灯片
                </a>
            </div>
        </div>
        <div class="ad-data-map">
            <div class="ad-data-jf-table">
                <table class="bxbg" border="0" cellspacing="0" cellpadding="0">
                    <tbody> <tr class="t1">
                        <td width="10">ID</td>
                        <td width="100">显示顺序</td>
                        <td>标题</td>
                        <td>链接</td>
                        <td width="100">操作</td>
                    </tr>
                    <?php $i=1; if($list):foreach($list as $val): ?>
                        <tr>
                            <td><?php echo $val['id'];?></td>
                            <td><?php echo $val['displayorder'];?></td>
                            <td><?php echo $val['advname'];?></td>
                            <td><?php echo $val['link'];?></td>
                            <td>
                                <a href="<?php echo $this->createUrl('/activity/duobao/advedit',array('id'=>$val['id'],'pid'=>$pid))?>">编辑</a>|
                                <a onclick="delActivity(<?php echo $val['id']?>)" >删除</a>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    endforeach;endif;
                    ?>
                    </tbody></table>

            </div>


            <!--list end-->
            <div class="pages">
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
    <script type="application/javascript">
        function delActivity(fid) {
            layer.confirm('确认要删除活动吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('<?php echo $this->createUrl('/activity/duobao/delete')?>', {fid: fid}, function (data) {
                    var data = JSON.parse(data);
                    if (data.errorcode == 0 && data.status == 'success') {
                        layer.msg('活动已删除！', {icon: 1, time: 2000}, function () {
                            location.reload()
                        });
                    }
                    else if (data.errorcode == 1) {
                        layer.msg('活动删除失败', {icon: 1});
                    }
                    else {
                        layer.msg('系统错误...', {icon: 1});
                    }
                });
            });
            return;
        }
    </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>