<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>

<div class='bgf clearfix'>
    <div class="center_top clearfix">
        <div class="center_top clearfix">
            <ul>
                <li><a class="btn btn-primary" href="<?php echo $this->createUrl('add') ?>">新增活动</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 30px;text-align: center">Id</th>
                    <th style="width: 80px;text-align: center">活动类型</th>
                    <th style="width: 100px;text-align: center">活动名称</th>
                    <th style="width: 80px;text-align: center">活动楼盘</th>
                    <th style="width: 100px;text-align: center">创建时间</th>
                    <th style="width: 100px;text-align: center">活动时间</th>
                    <th style="width: 100px;text-align: center">使用有效期</th>
                    <th style="width: 50px;text-align: center">发布状态</th>
                    <th style="width: 50px;text-align: center">预览页</th>
                    <th style="width: 120px;text-align: center">管理操作</th>
                    <?php if($group_id==1){?>
                        <th style="width: 50px;text-align: center">推荐</th>
                    <?php } ?>

                </tr>
                </thead>
                <tbody>
                        <?php
                        if(!empty($houslist)){
                        foreach ($houslist as $k => $item) { ?>
                            <tr id="list_<?php echo $item['id'] ?>">
                                <td style="text-align: center"><?php echo $item['id']; ?></td>
                                <td style="text-align: center"><?php echo $item['type']==1 ? "正式" : "测试" ; ?></td>
                                <td style="text-align: center"><?php echo $item['title']; ?></td>
                                <td style="text-align: center"><?php echo $item['dtitle']; ?></td>
                                <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$item['createtime']); ?></td>

                                <td style="text-align: center"><?php echo date('Y-m-d H:i:s',explode("|",$item['actime'])[0]); ?> 至 <?php echo date('Y-m-d H:i:s',explode("|",$item['actime'])[1]); ?></td>
                                <td style="text-align: center"><?php echo date('Y-m-d H:i:s',explode("|",$item['validity'])[0]); ?> 至 <?php echo date('Y-m-d H:i:s',explode("|",$item['validity'])[1]); ?></td>
                                <td style="text-align: center">
                                    <?php
                                    if($item['poststatus']==1){
                                        echo "已发布";
                                    }elseif($item['poststatus']==2){
                                        echo "未发布";
                                    }
                                    ?>
                                </td>
                                <td style="text-align: center"><?php echo $item['preview']; ?></td>
                                <td style="text-align: center">
                                    <a class='delete' target="_blank" href="<?php echo $this->createUrl('/house/site/detail', array('id' => $item['id'])) ?>">详情</a>
                                    <a class='delete' href="<?php echo $this->createUrl('add',array('id'=>$item['id']));?>">编辑</a>
                                    <?php if($item['poststatus']==2){?>
                                        <a class='delete' data-fb-id="<?php echo $item['id']?>" href="javascript:;" onclick="changepoststatus(<?php echo $item['id']?>,1)">发布</a>
                                    <?php }elseif($item['poststatus']==1){ ?>
                                        <a class='delete' data-fb-id="<?php echo $item['id']?>" href="javascript:;" onclick="changepoststatus(<?php echo $item['id']?>,2)">取消发布</a>
                                    <?php } ?>
                                    <a class='delete' data-del-id="<?php echo $item['id']?>"  href="javascript:;" onclick="delActivity(<?php echo $item['id']?>)" >删除</a>
                                </td>
                                <?php if($group_id==1){?>
                                    <td style="text-align: center"><a class="delete" href="javascript:;">推荐</a></td>
                                <?php } ?>
                            </tr>
                        <?php } }?>
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
    function delActivity(id){
        var that=$(this);
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

    function changepoststatus(id,poststatus){
        var nu=0;
       if(poststatus==1){
           layer.confirm('确认发布吗', {
               btn: ['确定','取消']
           }, function(){
               nu++;
               if(nu==1){
                   $.ajax({
                       url:"<?php echo $this->createUrl('changestatus');?>",
                       type: "POST",
                       data:{id:id,poststatus:poststatus},
                       dataType:"json",
                       success:function(data){
                           if(data==100){
                               layer.msg('发布成功！', {icon: 1, time: 2000}, function () {
                                   $("[data-fb-id="+id+"]").text("取消发布");
                                   $("[data-fb-id="+id+"]").removeAttr("onclick").attr("onclick","changepoststatus("+id+",2)");
                                   nu=0;
                               });
                           }
                           else{
                               layer.msg('发布失败', {icon: 1,time:2000},function(){
                                   location.reload()
                               });
                           }
                       }
                   });
               }

           });

       }else if(poststatus==2){
           layer.confirm('确认取消发布吗', {
               btn: ['确定','取消']
           }, function(){
               nu++;
               if(nu==1){
               $.ajax({
                   url:"<?php echo $this->createUrl('changestatus');?>",
                   type: "POST",
                   data:{id:id,poststatus:poststatus},
                   dataType:"json",
                   success:function(data){
                       if(data==100){
                           layer.msg('取消成功！', {icon: 1, time: 2000}, function () {
                               $("[data-fb-id="+id+"]").text("发布");
                               $("[data-fb-id="+id+"]").removeAttr("onclick").attr("onclick","changepoststatus("+id+",1)");
                               nu=0;
                           });
                       }
                       else{
                           layer.msg('取消失败', {icon: 1,time:2000},function(){
                               location.reload()
                           });
                       }
                   }
               });
               }
           });

       }
    }
</script>