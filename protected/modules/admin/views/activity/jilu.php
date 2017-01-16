
        <div class='bgf clearfix'>
          


            <div class="clearfix"></div>
            <div class="list">
                <form name="list_frm" id="ListFrm" action="" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');"></th>
                                <th>id</th>
                                <th>用户名</th>
                                <th>积分项目</th>
                                <th>积分数</th>
                                <th>访问IP</th>
                                <th>访问时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item->id ?>">
                                    <td class="first_td"  width="40">
                                        <input type="checkbox" name="id[]"  value="<?php echo $item->id ?>" >
                                    </td>
                                    <td><?php echo $item->id ?></td>
                                    <td><?php echo $item->userid ?></td>
                                    <td><?php echo $item->xiangmu_name ?></td>
                                    <td><?php echo 10 ?></td>
                                    <td><?php echo $item->ip ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item->add_time) ?></td>
                                    <td>
                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("management/del_jilu") ?>', '<?php echo $item->id ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>

                                    </td>
                                </tr>	
                            <?php } ?>
                        </tbody>
                    </table>
                     <div class="center_footer clearfix" >
                        <ul>
                            <li style="line-height:30px;"><input style='margin:5px 5px 0 0' type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');"><label for="idAll" style="display:inline;">全选</label></li>
                            <li><a  class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("management/del_jilu") ?>')"><?php echo Mod::t('admin', 'del') ?></a></li>    
                               
                        </ul>
                    </div>
                  

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

