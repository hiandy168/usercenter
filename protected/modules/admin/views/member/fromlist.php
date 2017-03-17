
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix" style="position: relative;">

                <table class="">
                    <form name="search_frm" action="<?php echo $this->createUrl("member/fromlists") ?>" id="SearchFrm" method="post">
                       <tr>
                           <td>组件列表</td>
                           <td>
                        <select name="activity">
                            <option value="" >请选择</option>
                            <?php foreach($activity as $value){?>
                            <option value="<?php echo $value['activity_table_name'] ?>" <?php echo $select==$value['activity_table_name']?'selected="selected"':""?>><?php echo $value['activity_name'] ?></option>
                            <?php }?>
                        </select>
                           </td>
                        <td>开始时间<input type="date" name="startdate"  value="<?php echo $startdate?date("Y-m-d",$startdate):'' ?>" /></td>
                        <td>结束时间<input type="date" name="enddate"  value="<?php echo $enddate?date("Y-m-d",$enddate):'' ?>" /></td>
                        <td><input type="submit" name="search" class="btn btn-success"  value="查询" /></td>
                        </tr>
                    </form>
                </table>
                <div class="" style="width: 20%;position: absolute;right: 5%;top: 0px;">
                    <form name="search_frm" action="<?php echo $this->createUrl("member/fromlists") ?>" id="SearchFrm" method="post">
                        <input type="text" name="phone"  placeholder="输入手机号"  value="<?php echo $phone?$phone:'' ?>" />
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
                                <th>编号</th>
                                <th>用户名</th>
                                <th>手机号码</th>
                                <th>用户来源</th>
                                <th>活动标题</th>
                                <th>状态</th>
                                <th>注册时间</th>
                                <th>审核</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;foreach ($datalist['criteria'] as $k => $item) { ?>
<!--                             如果 member 没有值则不显示-->
                                <?php if($item->Member){?>
                                <tr id="list_<?php echo $item['id'] ?>">
                                    <td class="first_td"  width="40">
                                        <input type="checkbox" name="id[]"  value="<?php echo $item->id ?>" >
                                    </td>

                                    <td><?php echo $i ?></td>
                                    <td><?php echo $item->Member->username ?></td>
                                    <td><?php echo $item->Member->phone ?></td>
                                    <td><?php echo $item->model ?></td>

<!--                                    查询活动标题-->
                                    <?php
                                    if($item->aid>1){
                                        $models="Activity_".$item->model;
                                        $activity=$models::model()->findByPk($item->aid);
                                    }

                                    ?>
                                    <td><a href="<?php echo $this->_siteUrl."/activity/".$item->model."/pcview/id/".$item->aid?>"><?php echo $activity->title ?></a></td>
                                    <td><?php echo $item->Member->status ? Mod::t('admin', 'state_1') : Mod::t('admin', 'state_0'); ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $item->Member->regtime) ?></td>
                                    <td>
                                       <!-- $item->pstatus 为真 代表 是pc 端注册的用户-->
                                        <?php if(!$item->Member->status && $item->Member->pstatus){?>
                                            <a  class='btn btn-primary' href="javascript:;" onclick="audit(<?php echo $item->Member->id ?>)">未审核</a>
                                        <?php }else if(!$item->Member->pstatus && !$item->Member->status){?>
                                            <a  class='btn btn-primary'onclick="audit(<?php echo $item->Member->id ?>)" href="javascript:;">未审核</a>
                                            <?php }else{?>
                                            <a  class='btn btn-primary' style="background: #ccc;color:blue" href="javascript:;">已审核</a>
                                        <?php }?>
                                    </td>
                                </tr>	
                            <?php $i++; }} ?>
                        </tbody>
                    </table>


                    <div class="pages clearfix"> 
                        <?php
                        $this->widget('JumpLinkPager', array('pages' => $datalist['pagebar'],
                                                        'cssFile' => false,
                                                        'header'=>'',
                                                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                        'prevPageLabel' => '前一页',
                                                            )
                        );
                        ?>
                    </div>
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
