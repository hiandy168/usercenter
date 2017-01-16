
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <ul>
                    <li><span class="btn btn-primary">管理用户</span></li>  
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('user/add') ?>"><?php echo Mod::t('admin', 'add') ?></a></li>  
                </ul>
                <div class="center_search"> 
                    <form name="search_frm" action="<?php echo $this->createUrl("user/lists") ?>" id="SearchFrm" method="post"> 
                        <select name="group_id" id="user_status">
                            <?php foreach ($group as $g) { ?>
                                <option value="<?php echo $g['id']; ?>"  <?php echo (isset($group_id) && ($group_id == $g['id'])) ? 'selected="selected"' : ''; ?> ><?php echo $g['name']; ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" name="search" class="btn btn-success"  value="搜索" /> 
                    </form> 
                    
                </div> 
            </div>


            <div class="clearfix"></div>
            <div class="list">
                <form name="list_frm" id="ListFrm" action="" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="first_td" width="40"><input type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');"></th>
                                <th>id</th>
                                <th>用户名</th>
                                <th>用户分组</th>
                                <th>状态</th>
                                <th>是否管理员</th>
                                <th>用户备注</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">
                                    <td class="first_td"  width="40">
                                        
                                        <input type="checkbox" name="id[]"  value="<?php echo $item->id ?>"   <?php if($item->admin==1){?>disabled="disabled"<?php } ?>>
                                    </td>
                                    <td><?php echo $item->id ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <td><?php echo $item->Usergroup->name ?></td>
                                    <td><?php echo $item->status ? Mod::t('admin', 'state_1') : Mod::t('admin', 'state_0'); ?></td>
                                    <td><?php echo $item->admin?'是':'否';?></td>
                                    <td><?php echo $item->remark ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item->regtime) ?></td>
                                    <td>
                                        <a  class='a_edit' href="<?php echo $this->createUrl("user/edit/",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a> 
                                        <?php if($item->admin!=1){?>
                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("user/del") ?>', '<?php echo $item->id ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>
                                        <?php } ?>
                                    </td>
                                </tr>	
                            <?php } ?>
                        </tbody>
                    </table>
                     <div class="center_footer clearfix" >
                        <ul>
                            <li style=""><input style='margin:5px 5px 0 0' type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');">全选</li>
                            <li><a  class="btn btn-primary" href="javascript:;" onclick="del_bat('<?php echo $this->createUrl("user/del") ?>')"><?php echo Mod::t('admin', 'del') ?></a></li>    
                               
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

