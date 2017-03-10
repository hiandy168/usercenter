<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<div class="center_top clearfix">
    <div class="center_top clearfix">
        <ul>
            <li><a class="btn btn-primary" href="<?php echo $this->createUrl('add') ?>">新增白名单</a></li>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
<div class='bgf clearfix'>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 30px;text-align: center">ID</th>
                    <th style="width: 80px;text-align: center">ip</th>
                    <th style="width: 100px;text-align: center">状态</th>
                    <th style="width: 100px;text-align: center">备注</th>
                    <th style="width: 100px;text-align: center">创建时间</th>
                    <th style="width: 50px;text-align: center">操作管理</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($ipinfo)){
                    foreach ($ipinfo as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td style="text-align: center"><?php echo $item['id']; ?></td>
                            <td style="text-align: center"><?php echo $item['ip'] ?></td>
                            <td style="text-align: center" data-fb-status="<?php echo $item['id']?>"><?php echo $item['enable']==1 ? "启用" : "未启用" ; ?></td>
                            <td style="text-align: center"><?php echo $item['remark'] ?></td>
                            <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$item['createtime']); ?></td>
                            <td style="text-align: center">
                                <?php if($item['enable']==2){?>
                           <a class="delete"  data-fb-id="<?php echo $item['id']?>" onclick="enable(<?php echo $item['id']?>,1)" href="javascript:;">开启</a>
                            <?php }elseif($item['enable']==1){ ?>
                               <a class="delete"  data-fb-id="<?php echo $item['id']?>" onclick="enable(<?php echo $item['id']?>,2)" href="javascript:;">关闭</a>
                            <?php } ?>
                                <a class='delete' href="<?php echo $this->createUrl('add',array('id'=>$item['id']));?>">编辑</a>
                                <a class='delete' data-del-id="<?php echo $item['id']?>" href="javascript:;" onclick="delip(<?php echo $item['id']?>)" >删除</a>
                            </td>
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

<script type="application/javascript">

    function enable(id,enable){
        var nu=0;
        if(enable==1){
            layer.confirm('确认开启白名单吗', {
                btn: ['确定','取消']
            }, function(){
                nu++;
                if(nu==1){
                    $.ajax({
                        url:"<?php echo $this->createUrl('changestatus');?>",
                        type: "POST",
                        data:{id:id,enable:enable},
                        dataType:"json",
                        success:function(data){
                            if(data==100){
                                layer.msg('开启成功！', {icon: 1, time: 2000}, function () {
                                    $("[data-fb-id="+id+"]").text("关闭");
                                    $("[data-fb-status="+id+"]").text("启用");
                                    $("[data-fb-id="+id+"]").removeAttr("onclick").attr("onclick","enable("+id+",2)");
                                    nu=0;
                                });
                            }
                            else{
                                layer.msg('发布失败', {icon: 2,time:2000},function(){
                                    location.reload()
                                });
                            }
                        }
                    });
                }

            });

        }else if(enable==2){
            layer.confirm('确认关闭白名单吗', {
                btn: ['确定','取消']
            }, function(){
                nu++;
                if(nu==1){
                    $.ajax({
                        url:"<?php echo $this->createUrl('changestatus');?>",
                        type: "POST",
                        data:{id:id,enable:enable},
                        dataType:"json",
                        success:function(data){
                            if(data==100){
                                layer.msg('关闭成功！', {icon: 1, time: 2000}, function () {
                                    $("[data-fb-id="+id+"]").text("启用");
                                    $("[data-fb-status="+id+"]").text("关闭");
                                    $("[data-fb-id="+id+"]").removeAttr("onclick").attr("onclick","enable("+id+",1)");
                                    nu=0;
                                });
                            }
                            else{
                                layer.msg('关闭失败', {icon: 2,time:2000},function(){
                                    location.reload()
                                });
                            }
                        }
                    });
                }
            });

        }
    }


    function delip(id){
        layer.confirm('确认删除吗', {
            btn: ['确定','取消']
        }, function(){
            $.ajax({
                url:"<?php echo $this->createUrl('del');?>",
                type: "POST",
                data:{id:id},
                dataType:"json",
                success:function(data){
                    if(data==100){
                        layer.msg('删除成功！', {icon: 1,time:2000},function(){
                            $("[data-del-id="+id+"]").parent().parent().remove();
                        });
                    }
                    else{
                        layer.msg('删除失败', {icon: 1,time:2000},function(){
                            location.reload()
                        });
                    }
                }
            });
        });return;
    }
</script>