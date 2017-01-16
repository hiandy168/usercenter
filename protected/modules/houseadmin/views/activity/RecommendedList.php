
        <div class='bgf clearfix'>

            <!-- <div class="center_top clearfix">
                <span>项目</span>
             <select  name="activity" id="project">

                    <?php /*foreach ($project as $k=>$v){*/?>
                        <option value="<?php /*echo $v['id']*/?>" <?php /*if($v['id'] == $projectid){echo "selected";} */?>><?php /*echo $v['name']*/?></option>
                    <?php /*}*/?>
                </select>-->

    <!--        <span>活动组件</span>
           <select  name="activity" onchange="chooes($(this).val())">
               <option value="2" <?php /*if($_GET['id'] == 2){echo "selected";} */?>>刮刮卡</option>
               <option value="1" <?php /*if($_GET['id'] == 1){echo "selected";} */?>>签到</option>
               <option value="3" <?php /*if($_GET['id'] == 3){echo "selected";} */?>>报名</option>
               <option value="4" <?php /*if($_GET['id'] == 4){echo "selected";} */?>>投票</option>
               <option value="5" <?php /*if($_GET['id'] == 5){echo "selected";} */?>>大转盘</option>
               <option value="6" <?php /*if($_GET['id'] == 6){echo "selected";} */?>>海报</option>
           </select>



                
            </div>-->



            <div class="clearfix"></div>
            <div class="list">
                <form name="list_frm" id="ListFrm" action="" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>标题</th>
                                <th>类型</th>
                                <th>项目</th>
                                <th>描述</th>
                                <th>活动图片</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>状态</th>
                                <th>操作</th>
                     
					 </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">

                                    <td><?php echo $item['id'] ?></td>
                                    <td><?php echo $item['title'] ?></td>
                                    <td>
                                        <?php echo $item['type'][0] ;$type=$item['type'][1]?>
                                    </td>
                                    <td><?php echo $item['project'] ?></td>
                                    <td><?php echo $item['describe'] ?></td>
                                    <td><img width="80px" height="80px" src="<?php echo JkCms::show_img($item['image']) ?>" alt="活动图片"/></td>
                                    <td><?php
                                        if(!empty($item['start_time'])){
                                            echo date('Y-m-d H:i:s',$item['start_time']);
                                        }
                                    ?></td>
                                    <td><?php
                                        if(!empty($item['end_time'])){
                                            echo date('Y-m-d H:i:s',$item['end_time']);
                                        }
                                        ?></td>
                                    <td><?php echo $item['status']==1?'已推荐':'未推荐'; ?></td>
                                    <td>
<!--                                        <a href="http://<?php /*echo $_SERVER['HTTP_HOST'] */?>/activity/<?php /*echo $type*/?>/view/id/<?php /*echo $item['id']*/?>">预览</a>&nbsp;|&nbsp;-->

                                       <?php if($item['status']==1){?>
                                           <a href="javascript:;" onclick="recommend(<?php echo $item['id'];?>,2);">取消推荐</a>
                                        <?php }else{?>
                                           <a href="javascript:;" onclick="recommend(<?php echo $item['id'];?>,1);">推荐</a>
                                        <?php  }?>
                                    </td>
                                </tr>
                            <?php } ?>
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
    function chooes(type){
        if(type){
            var project=  $('#project').val();
            window.location.href='<?php echo $this->createUrl('activity/list')?>/id/'+type+'/project/'+project;
        }

    }

    function recommend(id,isStar){
      var project=  $('#project').val();
        $.ajax({
            type: "get",
            url: "<?php echo $this->createUrl('activity/recommende')?>",
            data:{
                "id": id,
                "aid":<?php echo intval($_GET['id'])?>,
                "isstar":isStar,
                "project":project
            },
            success: function(msg){
                //  alert(msg);
                if(msg=='ok'){
                    alert("推荐成功");
                    window.location.reload();
                    return false;
                }else if(msg==2){
                    alert("取消成功");
                    window.location.reload();
                    return false;
                }else{
                    alert("失败了");
                    return false;
                }
            }
        });

    }

</script>