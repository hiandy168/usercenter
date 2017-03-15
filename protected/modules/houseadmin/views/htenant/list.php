<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>

<div class='bgf clearfix'>
    <?php if($result==1){ ?>
    <div class="center_top clearfix">
        <div class="center_top clearfix">
            <ul>
                <li><a class="btn btn-primary" href="<?php echo $this->createUrl('add') ?>">新增商户</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <?php } ?>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 30px;text-align: center">站点ID</th>
                    <th style="width: 80px;text-align: center">城市</th>
                    <th style="width: 100px;text-align: center">运营站点</th>
                    <th style="width: 80px;text-align: center">运营联系人</th>
                    <th style="width: 100px;text-align: center">电话</th>
                    <th style="width: 120px;text-align: center">创建时间</th>
                    <th style="width: 120px;text-align: center">创建人</th>
                    <?php if($group_id==17){ ?>
                    <th style="width: 50px;text-align: center">操作管理</th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($tenantlist)){
                    foreach ($tenantlist as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td style="text-align: center"><?php echo $item['id']; ?></td>
                            <td style="text-align: center"><?php echo $item['city'] ?></td>
                            <td style="text-align: center"><?php echo $item['site']; ?></td>
                            <td style="text-align: center"><?php echo $item['operatorname']; ?></td>
                            <td style="text-align: center"><?php echo $item['operatorphone']; ?></td>
                            <td style="text-align: center"><?php echo date('Y-m-d H-m-s',$item['createtime']); ?></td>
                            <td style="text-align: center"><?php echo $item['author']; ?></td>
                        <?php if($group_id==17){ ?>
                            <td style="text-align: center">
                                <?php if($item['wxstatus']==2){ ?>
                                    <a class='delete' href="<?php echo $this->createUrl('add',array('id'=>$item['id']));?>">编辑</a>
                                    <a class='delete' href="javascript:;" onclick="delTenant(<?php echo $item['id']?>)" >删除</a>
                                <?php }elseif($item['wxstatus']==1){ ?>
                                    <a class='delete' href="<?php echo $this->createUrl('add',array('id'=>$item['id']));?>">钱包首页</a>
                                <?php } ?>
                            </td>
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
    function delTenant(id){
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
                            location.reload()
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