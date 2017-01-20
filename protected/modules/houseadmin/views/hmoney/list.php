<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>

<div class='bgf clearfix'>
    <div class="center_top clearfix" style="position: relative;">

        <table class="">
            <form name="search_frm" action="<?php echo $this->createUrl("/houseadmin/hmoney/list") ?>" id="SearchFrm" method="post">
                <tr>
                    <td>
                        <select name="type">
                            <option value="" >产品类型</option>
                            <option value="1" <?php echo $type==1?"selected='selected'":""?> >活期</option>
                            <option value="2" <?php echo $type==2?"selected='selected'":""?>>固定</option>
                        </select>
                    </td>
                   <!-- <td><input type="date" name="createtime"  value="<?php /*echo $createtime?date("Y-m-d",$createtime):'' */?>" /></td>-->
                    <td><input type="text" name="title" size="50" placeholder="请输入产品名称/创建者/产品编号"  value="<?php echo $title?$title:'' ?>" /></td>
                    <td>&nbsp;<input type="submit" class="btn btn-success"  value="查询" /></td>
                    <td>&nbsp;  <a class="btn btn-primary" href="<?php echo $this->createUrl('add') ?>">新增理财</a></td>
                </tr>
            </form>
        </table>
    </div>
    <div class="clearfix"></div>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th style="width: 60px;text-align: center">产品编号</th>
                    <th style="width: 80px;text-align: center">产品类型</th>
                    <th style="width: 100px;text-align: center">产品名称</th>
                    <th style="width: 80px;text-align: center">预定周期</th>
                    <th style="width: 100px;text-align: center">预存收益</th>
                    <th style="width: 120px;text-align: center">创建用户</th>
                    <th style="width: 120px;text-align: center">创建时间</th>
                    <th style="width: 100px;text-align: center">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($moneylist)){
                    foreach ($moneylist as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td style="text-align: center"><?php echo $item['id']; ?></td>
                            <td style="text-align: center"><?php echo $item['type']==1 ? "活期" : "固定" ; ?></td>
                            <td style="text-align: center"><?php echo $item['title']; ?></td>
                            <td style="text-align: center"><?php echo $item['cycle']!=0?$item['cycle']."个月":"无限"; ?></td>
                            <td style="text-align: center"><?php echo $item['earnings']; ?>%</td>
                            <td style="text-align: center"><?php echo $item['author']; ?></td>
                            <td style="text-align: center"><?php echo date('Y-m-d H:i:s',$item['createtime']); ?></td>
                            <td style="text-align: center">
                                <a class='delete' href="<?php echo $this->createUrl('add',array('id'=>$item['id']));?>">修改</a>
                                <a class='delete' href="javascript:;" onclick="delActivity(<?php echo $item['id']?>)" >删除</a>
                            </td>
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