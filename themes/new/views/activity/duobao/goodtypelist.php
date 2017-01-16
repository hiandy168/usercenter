<?php echo $this->renderpartial('/common/header_new', $config); ?>
    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $pid)) ?>

    <div class="ad-act-list w1000 bxbg mgt30 clearfix">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>商品分类</h3>
            </div>
            <div class="fr tr">
                <a href="<?php echo $this->createUrl('/activity/duobao/typeAdd',array('pid'=>$pid,'active' => $config['active']))?>">
                    <i class="aicon linear"></i> 新增分类
                </a>
            </div>
        </div>
        <!--tit end-->
        <?php if (!$asList) { ?>
            <div class="ad-nodata w1000 mgb30 mgt30">
                <img src="<?php echo $this->_theme_url; ?>assets/images/ad-nodata-bg.png"/>
                <p>噢噢，还没有分类！！！</p>
                <a href="<?php echo $this->createUrl('/activity/duobao/typeAdd', array('pid' => $pid)) ?>" class="linear adbtn">创建分类</a>
            </div>
        <?php } ?>
        <!--没有记录的情况-->
        <div class="ad-act-list-table">
            <?php if ($asList) { ?>
                <div class="ad-act-list-table-tit clearfix">
                    <ul>
                        <li class="lw1">分类名称<i></i></li>
                        <li class="lw2">描述<i></i></li>
                    </ul>
                </div>
            <?php } ?>
            <div class="ad-act-list-table-con">
                <ul>
                    <?php if ($asList):foreach ($asList as $val): ?>
                        <li class="li">
                            <div class="ad-act-list-table-con1 clearfix">
                                <ul>
                                    <li class="lw1"><?php echo $val['name']; ?></li>
                                    <li class="lw2"><?php echo $val['description']; ?></li>
                                </ul>
                            </div>
                            <div class="ad-act-list-table-con2">
                                <ul>
                                    <li class="l5"><a
                                            href="<?php echo $this->createUrl('/activity/duobao/typeEdit', array('id' => $val['id'], 'pid' => $pid)) ?>"><i></i>编辑</a>
                                    </li>
                                    <li class="l4" onclick="delActivity(<?php echo $val['id'] ?>)"><i></i>删除活动</li>
                                </ul>
                            </div>
                        </li>
                    <?php endforeach;endif; ?>
                </ul>
            </div>
            <!--list end-->
            <div class="ad-page-list mgt30 mgb30">
                <ul class="pagelist">
                    <?php
                    $this->widget('CoLinkPager', array('pages' => $pagebar,
                            'cssFile' => false,
                            'header' => '',
                            'firstPageLabel' => '首页', //定义首页按钮的显示文字
                            'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                            'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                            'prevPageLabel' => '前一页',
                        )
                    );
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf-8">
        function delActivity(id) {
            layer.confirm('确认要删除活动吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('<?php echo $this->createUrl('/activity/duobao/typeDel')?>', {id: id}, function (data) {
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