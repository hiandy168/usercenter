
<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <ul>
            <li><span class="btn btn-primary">管理城市服务分类</span></li>
            <li><a class="btn btn-primary" href="<?php echo $this->createUrl('citylife/category',array('action'=>'add')) ?>"><?php echo Mod::t('admin', 'add') ?></a></li>
        </ul>

    </div>

    <div class="clearfix"></div>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');"></th>
                    <th>id</th>
                    <th>分类名称</th>
                    <th>排序</th>
                    <th>添加时间</th>
                    <th>更新时间</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($list)){foreach($list as $k=>$item){ ?>
                    <tr id="list_<?php echo $item['id']?>">
                        <td class="first_td"  width="40">
                            <input type="checkbox" name="id[]" value="<?php echo $item['id']?>" >
                        </td>
                        <td><?php echo $item['id']?></td>
                        <td><?php echo $item['name']?></td>
                        <td><?php echo $item['position']?></td>
                        <td><?php echo date('Y-m-d H:i:s', $item['createtime']) ?></td>
                        <td><?php echo $item['updatetime']?date('Y-m-d H:i:s', $item['updatetime']):''; ?></td>
                        <td><?php echo $item['status'] ? '启用' : '禁用' ?></td>

                        <td>
                            <a  class='a_edit' href="<?php echo $this->createUrl("citylife/category/",array('id'=>$item['id'],'action'=>'edit') ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>

                            <a   class='a_del' id="cate_del" onclick="javascript:var state = window.confirm('确定删除?'); if(state){ cateDel();}"></a>
                            <input type="hidden" id="cate_id" value="<?php echo $item['id']; ?>">
                        </td>
                    </tr>
                <?php }} ?>
                </tbody>
            </table>

            <div class="pages clearfix">
                <?php
                $this->widget('CLinkPager', array('pages' => $pagebar,
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

<script type="text/javascript">
    function cateDel(){
        var id = $('#cate_id').val();
            $.ajax({
                url:"<?php echo $this->createUrl('/admin/citylife/cateDel'); ?>",
                data:{id:id},
                dataType:'json',
                type:'post',
                success: function (data) {
                    alert(data.mess);
//                    ship_mess_big(data.mess);
                    window.location.reload();
                }
            });
    }
</script>

