
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <ul>
                    <li><span class="btn btn-primary">管理城市服务链接</span></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('citylife/add') ?>"><?php echo Mod::t('admin', 'add') ?></a></li>
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
                                <th>服务名称</th>
                                <th>所属分类</th>
                                <th   style="width:300px">服务链接</th>
                                <th>服务图标</th>
                                <th>服务位置</th>
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
                                    <td><?php echo CityLife::model()->getCateName($item['cateid']); ?></td>
                                    <td style="width:300px;display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" ><?php echo $item['url']?></td>
                                    <td><?php if($item['icon']){ ?><img height="50" src="<?php echo Tool::show_img($item['icon']) ?>"><?php } ?></td>
                                    <td><?php echo $item['position']?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item['createtime']) ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item['updatetime']) ?></td>
                                    <td><?php echo $item['status'] ? '启用' : '禁用' ?></td>

                                    <td>
                                        <a  class='a_edit' href="<?php echo $this->createUrl("citylife/edit/",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>

                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("citylife/del") ?>', '<?php echo $item['id'] ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>

                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                     <div class="center_footer clearfix" >
                        <ul>
                            <li style=""><input style='margin:5px 5px 0 0' type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');">全选</li>
                            <li><a  class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("member/del") ?>')"><?php echo Mod::t('admin', 'del') ?></a></li>

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

