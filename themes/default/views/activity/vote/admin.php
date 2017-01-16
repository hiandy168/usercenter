<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php// echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/site.css">
    <style>
        .w980{width: auto;}
        .new_wrap .other_333 .right_222 .table_222 thead td, .new_wrap .other_333 .right_222 .table_222 tbody td{width: auto}
        .components .left, .components .center, .components .right{float: none;margin: 0 auto;}
        .components .center{float: none; }
    </style>
    <div class="components w980 clearfix">
        <?php // echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>
        <div class="center">
            <div class="new_wrap">
                <div class="other_333 clearfix">
                    <div class="right_222">
                        <div class="i_222">列表 <span class="add-activity"><a href="<?php echo $this->createUrl('/activity/vote/adminAdd',array('vid'=>$vid))?>">+ 新增</a><span></div>
                        <div class="content_222">
                            <table class="table_222">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>名称</td>
                                    <td>票数</td>
                                    <td>image</td>
                                    <td>排名</td>
                                    <td>操作</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; if($list):foreach($list as $val): ?>
                                    <tr>
                                        <td><?php echo $val['id'];?></td>
                                        <td><?php echo $val['title'];?></td>
                                        <td><?php echo $val['vote_number'];?></td>
                                        <td><img src="<?php echo JkCms::show_img($val['img']) ?>" width="35px" height="35px"/></td>
                                        <td><?php echo $i;?></td>
                                        <td>
                                            <a href="<?php echo $this->createUrl('/activity/vote/adminEdit',array('id'=>$val['id'],'vid'=>$vid))?>">编辑</a>|
                                            <a onclick="delActivity(<?php echo $val['id']?>)" >删除</a>
                                        </td>
                                    </tr>
                                        <?php
                                $i++;
                                endforeach;endif;
                                ?>
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
        </div>
    </div>
    <script>

        //ajax 请求获取中奖名单
        function getWinList(id,title){
            //var index = layer.load(2,{shade: [0.3, '#393D49']});
            layer.open({
                type: 2,
                title:'报名活动用户列表',
                area: ['700px', '500px'],
                skin: 'layui-layer-rim', //加上边框
                content: ["<?php echo $this->createUrl('/activity/vote/AddList')?>/fid/"+id+"/title/"+title]
            });
        }

        //活动状态提示
        function getStatus(state,fid){
            if(state=='未开始'){
                layer.confirm('活动还未开始？活动的开始时间将被置为当前时间！', {
                    btn: ['确定','取消']
                }, function(){
                    var url = "<?php echo $this->createUrl('/activity/vote/ActivityPause')?>";
                    $.post(url, {fid:fid,type:1}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg,{time:2000},function(){
                            location.reload();
                        })
                    })
                })
            }
            if(state=='进行中'){
                layer.confirm('活动正在进行中？活动的结束时间将被置为当前时间！', {
                    btn: ['确定','取消']
                }, function(){
                    var url = "<?php echo $this->createUrl('/activity/vote/ActivityPause')?>";
                    $.post(url, {fid:fid,type:2}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg,{time:2000},function(){
                            location.reload();
                        })
                    })
                })
            }
            if(state=='已结束'){
                layer.msg('活动已经结束')
            }
        }

        function delActivity(fid){
            layer.confirm('确认要删除吗？', {
                btn: ['确定','取消']
            }, function(){
                $.post('<?php echo $this->createUrl('/activity/vote/adminDel')?>', { id: fid,vid:<?php echo $vid ?> }, function (data) {
                    var data = JSON.parse(data);
                    if(data.errorcode == 0){
                        layer.msg('活动已删除！', {icon: 1,time:2000},function(){
                            location.reload()
                        });
                    }
                    else if(data.errorcode == 1){
                        layer.msg('活动删除失败', {icon: 1});
                    }
                    else{
                        layer.msg('系统错误...', {icon: 1});
                    }
                });
            });return;

        }
    </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>