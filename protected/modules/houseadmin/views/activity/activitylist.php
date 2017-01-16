
<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <div class="center_top clearfix">
            <ul>
                <li><a class="btn btn-primary" href="<?php echo $this->createUrl('addactivity') ?>">添加</a></li>
            </ul>
<!--            <ul>-->
<!--                <li><a class="btn btn-primary" href="--><?php //echo $this->createUrl('ClassManager') ?><!--">分类管理</a></li>-->
<!--            </ul>-->
        </div>






    </div>



    <div class="clearfix"></div>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <table width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>组件名</th>
                    <th>权限设置</th>
                    <th>修改时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($list)){
                    foreach ($list as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">
                            <td><?php echo $item['activity_name']; ?></td>
                            <td>
                                <a   href="<?php echo $this->createUrl("activity/ProjectManager",array('activity_id'=>$item['id']) ) ?>">应用权限设置</a>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s',$item['update_time']); ?></td>
                            <td>
                                <a  class='a_edit' href="<?php echo $this->createUrl("activity/ActivityEdit",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>
                                <a   class='a_del'  onclick="del('<?php echo $this->createUrl("activity/delClass") ?>', '<?php echo $item['id'] ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>

                            </td>
                        </tr>
                    <?php } }?>
                </tbody>
            </table>

            <div class="pages clearfix">
                <?php
                /* $this->widget('CLinkPager', array('pages' => $pagebar,
                                                'cssFile' => false,
                                                'header'=>'',
                                                'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                'prevPageLabel' => '前一页',
                                                    )
                ); */
                ?></div>
        </form>
    </div>



</div>

<script>


</script>