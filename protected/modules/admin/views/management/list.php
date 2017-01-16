
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <ul>
                     <li><a class="btn btn-primary" href="<?php echo $this->createUrl('add') ?>">添加</a></li>  
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
                                <th>行为操作</th>
                                <th>所属应用</th>
                                <th>积分标识</th>
                                <th>积分数值</th>
                                <th>积分规则</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php 
                            foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">
                                    <td class="first_td"  width="40">
                                        <input type="checkbox" name="id[]"  value="<?php echo $item['id'] ?>"  >
                                    </td>
                                    <td><?php echo $item['id'] ?></td>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['project_name']?></td>
                                    <td><?php echo $item['mark']?>
                                    <td><?php echo $item['point'] ?></td>
                                    <td><?php echo $item['rule']?></td>
                                    <td><?php 
                                        if(!empty($item['create_time'])){
                                            echo date('Y-m-d H:i:s',$item['create_time']);
                                        }
                                    ?></td>
                                    
                                    <td>
                                        <a  class='a_edit' href="<?php echo $this->createUrl("management/edit",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a> 
                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("management/del") ?>', '<?php echo $item['id'] ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>
                                        
                                    </td>
                                </tr>	
                            <?php } ?>
                        </tbody>
                    </table>
                     <div class="center_footer clearfix" >
                        <ul>
                            <li style="line-height:30px;"><input style='margin:5px 5px 0 0' type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');"><label style="display:inline;" for="idAll">全选</label></li>
                            <li><a  class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("management/del") ?>')"><?php echo Mod::t('admin', 'del') ?></a></li>    
                        </ul>
                    </div>
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
                        ?>
                    </div>
                </form>
            </div>
        </div>   

