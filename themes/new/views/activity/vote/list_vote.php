<?php echo $this->renderpartial('/common/header_new', $config); ?>

    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $config['pid'])) ?>

    <div class="ad-act-list w1000 bxbg mgt30 clearfix">

        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>我的应用</h3>
            </div>
            <div class="fr tr">
                <a href="<?php echo $this->createUrl('/activity/vote/add', array('pid' => $config['pid'])) ?>">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>
        </div>
        <!--tit end-->

        <?php if (!$asList) { ?>
            <div class="ad-nodata w1000 mgb30 mgt30">

                <img src="<?php echo $this->_theme_url; ?>assets/images/ad-nodata-bg.png"/>
                <p>噢噢，还没有记录！！！</p>
                <a href="<?php echo $this->createUrl('/activity/vote/add', array('pid' => $config['pid'])) ?>" class="linear adbtn">创建活动</a>
            </div>
        <?php } ?>

        <!--没有记录的情况-->


        <div class="ad-act-list-table">

            <?php if ($asList) { ?>
            <div class="ad-act-list-table-tit clearfix">
                <ul>
                    <li class="lw1">活动ID<i></i></li>
                    <li class="lw2">活动名称<i></i></li>
                    <li class="lw3">开始时间</li>
                    <li class="lw3">结束时间<i></i></li>
                    <li class="lw2">活动状态</li>

                </ul>
            </div>
            <?php } ?>
            <div class="ad-act-list-table-con">
                <ul>
                    <?php if ($asList):foreach ($asList as $val): ?>
                        <li class="li">
                            <div class="ad-act-list-table-con1 clearfix">
                                <ul>
                                    <li class="lw1"><?php echo $val->id; ?></li>
                                    <li class="lw2"><?php echo $val->title; ?></li>
                                    <li class="lw3"><?php echo date('Y-m-d', $val->start_time); ?></li>
                                    <li class="lw3"><?php echo date('Y-m-d', $val->end_time); ?></li>
                                    <li class="lw2"><?php $result = Activity_vote::activityStatus($val->start_time, $val->end_time);
                                        echo $result['message'] ?></li>
                                </ul>
                            </div>
                           
                            <div class="ad-act-list-table-con2">
                                <ul>
                               <!-- <li class="l6"><i></i>活动链接
                    <div class="ad-act-list-wlink">
                      <h4>活动链接</h4>
                      <span><textarea name="" rows="" cols=""><?php /*echo "http://".$_SERVER['HTTP_HOST'].$this->createUrl('/activity/vote/view',array('id'=>$val->id))*/?></textarea></span>
                      <em onclick="Copy(this)">点击复制</em>
                    </div>
                    </li>-->
                                    <li class="l5"><a
                                            href="<?php echo $this->createUrl('/activity/vote/add', array('fid' => $val->id, 'pid' => $config['pid'])) ?>"><i></i>编辑</a>
                                    </li>
                                    <?php if($val['component']==1){?>
                                    <li class="l1"><a href="<?php echo $this->createUrl('/activity/vote/pcview', array('id' => $val->id)) ?>" target="_blank"><i></i>预览</a></li>
                                    <?php }else{ ?>
                                    <li class="l1"><a href="<?php echo $this->createUrl('/activity/vote/pcviews', array('id' => $val->id)) ?>" target="_blank"><i></i>预览</a></li>
                                    <?php } ?>
                                    <?php if($val['component']==1){if($result['status'] == 1||$result['status'] == 0){?>
                                    <li class="l1"><a
                                            href="<?php echo $this->createUrl('/activity/vote/admin', array('vid' => $val->id, 'pid' => $config['pid'])) ?>"
                                            target="_blank"><i></i>管理</a></li>
                                    <?php }}?>
                                    <li class="l2"
                                        onclick="getWinList(<?php echo $val->id ?>,'<?php echo $val->title ?>')"><i></i>用户数据
                                    </li>
                                    <li <?php if ($result['status'] == 1) {
                                        echo 'class="l3_1" ';
                                    } else {
                                        echo 'class="l3" ';
                                    } ?> href="javascript:void(0)"
                                         onclick="getStatus('<?php echo $result['message'] ?>',<?php echo $val->id ?>)"><?php if ($result['status'] == 0) {
                                            echo '<i></i>活动已结束';
                                        }
                                        if ($result['status'] == -1) {
                                            echo '<i></i>活动未开始';
                                        }
                                        if ($result['status'] == 1) {
                                            echo '<i></i>活动进行中';
                                        } ?></li>
                                    <li class="l4" onclick="delActivity(<?php echo $val->id ?>)"><i></i>删除活动</li>
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
        //ajax 请求获取中奖名单
        function getWinList(id, title) {
            //var index = layer.load(2,{shade: [0.3, '#393D49']});
            layer.open({
                type: 2,
                title: '参加活动用户列表',
                area: ['700px', '500px'],
                skin: 'layui-layer-rim', //加上边框
                content: ["<?php echo $this->createUrl('/activity/vote/AddList')?>/fid/" + id + "/title/" + title]
            });
        }

        //活动状态提示
        function getStatus(state, fid) {
            if (state == '未开始') {
                layer.confirm('活动还未开始？活动的开始时间将被置为当前时间！', {
                    btn: ['确定', '取消']
                }, function () {

                    var url = "<?php echo $this->createUrl('/activity/vote/activitystatus')?>";
                    $.post(url, {fid: fid, type: 1}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg, {time: 2000}, function () {
                            location.reload();
                        })
                    })
                })
            }
            if (state == '进行中') {
                layer.confirm('活动正在进行中？活动的结束时间将被置为当前时间！', {
                    btn: ['确定', '取消']
                }, function () {
                    var url = "<?php echo $this->createUrl('/activity/vote/activitystatus')?>";
                    $.post(url, {fid: fid, type: 2}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg, {time: 2000}, function () {
                            location.reload();
                        })
                    })
                })
            }
            if (state == '已结束') {
                layer.msg('活动已经结束')
            }
        }

        function delActivity(fid) {
            layer.confirm('确认要删除活动吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.post('<?php echo $this->createUrl('/activity/vote/Delete')?>', {fid: fid}, function (data) {
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