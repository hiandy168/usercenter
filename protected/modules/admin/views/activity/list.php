
        <div class='bgf clearfix'>
          
            <div class="center_top clearfix">
                <form action="" method="post">
                    <span>项目</span>
                    <select name="project" id="project">
                        <option value="">全部</option>
                        <?php foreach ($project as $k => $v) { ?>
                            <option value="<?php echo $v->id ?>" <?php if ($v->id == $projectid) {
                                echo "selected";
                            } ?>><?php echo $v->name ?></option>
                        <?php } ?>
                    </select>

                    <span>活动组件</span>
                    <select name="activity">
                        <option value="2" <?php if ($id == 2) {
                            echo "selected";
                        } ?>>刮刮卡
                        </option>
                        <option value="1" <?php if ($id == 1) {
                            echo "selected";
                        } ?>>签到
                        </option>

                        <option value="4" <?php if ($id == 4) {
                            echo "selected";
                        } ?>>投票
                        </option>
                        <option value="5" <?php if ($id == 5) {
                            echo "selected";
                        } ?>>大转盘
                        </option>
                        <option value="6" <?php if ($id == 6) {
                            echo "selected";
                        } ?>>海报
                        </option>
                        <option value="7" <?php if ($id == 7) {
                            echo "selected";
                        } ?>>砸金蛋
                        </option>
                        <option value="8" <?php if ($id == 8) {
                            echo "selected";
                        } ?>>问答
                        </option>
                    </select>
                    <span>标题</span>
                    <input type="text" name="title" value="<?php echo $title?>" placeholder="请输入标题">
                    <input type="submit" class="button" value="查找">
                    <input type="button" onclick="chooes()" class="button" value="全部列表">
            </div>
            </from>

            <?php
            switch ($id){
                case "1":
                    $model = "";
                    break;
                case "2":
                    $model = "scratchcard";
                    break;
                case "3":
                    $model = "";
                    break;
                case "4";
                    $model = "vote";
                    break;
                case "5";
                    $model = "bigwheel";
                    break;
                case "6";
                    $model = "poster";
                    break;
                case "7";
                    $model = "playegg";
                    break;
                case "8";
                    $model = "wenda";
                    break;
                default:
                    $model = "scratchcard";
                    break;
            }

            ?>

            <div class="clearfix"></div>
            <div class="list">
                <form name="list_frm" id="ListFrm" action="" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style='width:50px;text-align:center'>id</th>
                                <th>标题</th>
                                <th>类型</th>
                                <th>项目</th>
                                <th>活动图片</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                                <th>状态</th>
                                <th>数据统计</th>
                                <th>操作</th>
                     
					 </tr>
                        </thead>
                        <tbody>	
                            <?php 
                            foreach ($datalist as $k => $item) { ?>
                                <tr id="list_<?php echo $item['id'] ?>">

                                <?php $image=isset($item['img'])?$item['img']:$item['share_img'];?>
                                    <td style='width:50px;text-align:center'><?php echo $item['id'] ?></td>
                                    <td><?php echo $item['title'] ?></td>
                                    <td>
                                        <?php echo $type_id[0] ;$type=$type_id[1]?>
                                    </td>
                                    <td><?php echo $item['project'] ?></td>
                                    <td><img width="80px" height="80px" src="<?php echo JkCms::show_img($image) ?>" alt="活动图片"/></td>
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
                                    <td><a href="javascript:;" onclick="getActivityList(<?php echo $item['id'];?>,'<?php echo $model; ?>');">数据统计</a></td>
                                    <td>
<!--                                        <a href="http://<?php /*echo $_SERVER['HTTP_HOST'] */?>/activity/<?php /*echo $type*/?>/view/id/<?php /*echo $item['id']*/?>">预览</a>&nbsp;|&nbsp;-->

                                       <?php if($item['status']==1){?>
                                           <a href="javascript:;" onclick="recommend(<?php echo $item['rid'];?>,2);">取消推荐</a>
                                        <?php }else{?>
                                           <a href="javascript:;" onclick="recommend(<?php echo $item['id'];?>,1);">推荐</a>
                                        <?php  }?>
                                       <!-- <?php /*if($_GET['id'] ==3){*/?>
                                            <a  href="<?php /*echo $this->createUrl("activity/SignupEdit",array('id'=>$item['id']) ) */?>">编辑</a>
                                        --><?php
/*                                        }
                                        */?>
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

<script type="text/javascript" src="<?php echo $this->_baseUrl;?>/themes/new/assets/js/layer/layer.js"></script>

<script>
    function chooes(){
            window.location.href='<?php echo $this->createUrl('activity/list')?>';

    }

    function recommend(id,isStar){
      var project=  $('#project').val();
        $.ajax({
            type: "get",
            url: "<?php echo $this->createUrl('activity/recommende')?>",
            data:{
                "id": id,
                "aid":<?php echo intval($id)?>,
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

    //ajax 请求获取中奖名单
    function getActivityList(param,model){
        layer.confirm('查看以下哪种统计图', {
            btn: ['PVUV统计图','用户参与注册统计'] //按钮
        }, function(){
            layer.closeAll('dialog');
            layer.open({
                type: 2,
                title:'PVUV数据统计图',
                area: ['700px', '500px'],
                skin: 'layui-layer-rim', //加上边框
                content: ["<?php echo $this->createUrl('/activity')?>/"+model+"/Activitylist/fid/"+param+"/tag/pvuv"]
            });
        }, function(){
            layer.open({
                type: 2,
                title:'用户参与注册数据统计图',
                area: ['700px', '500px'],
                skin: 'layui-layer-rim', //加上边框
                content: ["<?php echo $this->createUrl('/activity')?>/"+model+"/Activitylist/fid/"+param+"/tag/user"]
            });
        });
        //var index = layer.load(2,{shade: [0.3, '#393D49']});

    }
</script>