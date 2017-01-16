
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <ul>
                    <li><span class="btn btn-primary">管理用户</span></li>  
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('member/add') ?>"><?php echo Mod::t('admin', 'add') ?></a></li>
                    <li> <a class="btn btn-primary" href="<?php echo $this->createUrl('member/index/status/1') ?>">已审核</a></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('member/index/status/2') ?>">未审核</a></li>
                </ul>
<!--                <div class="center_search"> -->
<!--                    <form name="search_frm" action="--><?php //echo $this->createUrl("member/lists") ?><!--" id="SearchFrm" method="post"> -->
<!--                        <select name="group_id" id="member_status">-->
<!--                            --><?php //foreach ($group as $g) { ?>
<!--                                <option value="--><?php //echo $g['id']; ?><!--"  --><?php //echo (isset($group_id) && ($group_id == $g['id'])) ? 'selected="selected"' : ''; ?><!-- >--><?php //echo $g['name']; ?><!--</option>-->
<!--                            --><?php //} ?>
<!--                        </select>-->
<!--                        <input type="submit" name="search" class="btn btn-success"  value="搜索" /> -->
<!--                    </form> -->
<!--                    -->
<!--                </div>-->
                <div class="center_search">
                    <form name="search_frm" action="<?php echo $this->createUrl("member/lists") ?>" id="SearchFrm" method="post">
                        <input type="text" name="name"  placeholder="输入用户名"  value="<?php echo isset($name) ? $name : ""; ?>" />
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
                                <th>用户备注</th>
                                <th>注册时间</th>
                                <th>审核</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>	
                            <?php foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">
                                    <td class="first_td"  width="40">
                                        
                                        <input type="checkbox" name="id[]"  value="<?php echo $item->id ?>" >
                                    </td>
                                    <td><?php echo $item->id ?></td>
                                    <td><?php echo $item->name ?></td>
                                    <!--<td><?php /*echo $item->Membergroup->name */?></td>-->
                                    <td><?php echo $item->pstatus==0?'<span style="background: #ccc;color:red">h5用户</span>':"pc用户" ;?></td>
                                    <td><?php echo $item->status ? Mod::t('admin', 'state_1') : Mod::t('admin', 'state_0'); ?></td>
                                    <td><?php echo $item->remark ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item->regtime) ?></td>
                                    <td>
                                       <!-- $item->pstatus 为真 代表 是pc 端注册的用户-->
                                        <?php if(!$item->status && $item->pstatus){?>
                                            <a  class='btn btn-primary' href="javascript:;" onclick="audit(<?php echo $item->id ?>)">未审核</a>
                                        <?php }else if(!$item->pstatus && !$item->status){?>
                                            <a  class='btn btn-primary'onclick="audit(<?php echo $item->id ?>)" href="javascript:;">未审核</a>
                                            <?php }else{?>
                                            <a  class='btn btn-primary' style="background: #ccc;color:blue" href="javascript:;">已审核</a>
                                        <?php }?>
                                    </td>
                                    <td>
                                        <a  class='a_edit' href="<?php echo $this->createUrl("member/edit/",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>
                                       <!-- //pc 端注册的用户才能被删除-->
                                        <?php if( $item->pstatus){?>
                                        <a   class='a_del'  onclick="del('<?php echo $this->createUrl("member/del") ?>', '<?php echo $item->id ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>

                                        <?php }?>
                                    </td>
                                </tr>	
                            <?php } ?>
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
                        $this->widget('JumpLinkPager', array('pages' => $pagebar,
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
<script>
    function audit(id){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl("member/audit") ?>",
            data:{
                "id": id
            },
            success: function(msg){
                  //alert(msg);
                if(msg==1){
                    //alert("操作成功");
                    window.location.reload();//刷新当前页面
                }else {
                    alert("审核失败");
                }
            }
        });
    }
</script>
