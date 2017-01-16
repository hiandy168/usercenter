<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php /*echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); */?>

<title>报名</title>
<form action="<?php echo $this->createUrl('/activity/vote/admin',array('vid'=>$vid))?>" method="post">
    <div class="ad-app-list w1000 clearfix bxbg mgt30">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>列表</h3>
            </div>
            <div class="fr tr">
                <a href="<?php echo $this->createUrl('/activity/vote/adminAdd',array('vid'=>$vid))?>">
                    <i class="aicon linear"></i> 新增
                </a>
            </div>
            <div class="fr tr">
              <input type="submit" style="border: 1px solid #008bcc; border-radius: 3px; color: #008bcc; display: block; font-size:16px; height:38px; lin-hight:38px; padding: 0 30px" value="搜索">
            </div>
            <div class="fr tr">
                <select name="whojoins" style="display: block;width: 100%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;" id="whojoins" class="display_type">
                <option value="" <?php if($whojoins=="null"){ echo 'selected ="selected "';} ?>>请选择</option>
                <option value="ok" <?php if($whojoins===0){ ?>selected ="selected "<?php } ?>>已审核</option>
                <option value="1" <?php if($whojoins==1){ ?>selected ="selected "<?php } ?>>未审核</option>
                </select>

            </div>
            <input style="float: right;border-radius: 4px; cursor: pointer; height: 36px; width: 30%" type="text" value="<?php echo $votename ?>" name="votename"/>
        </div>
        </form>
        <div class="ad-data-map">
        <div class="ad-data-jf-table">
          <table class="bxbg" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <tr class="t1">
                    <td>ID</td>
                    <td>名称</td>
                    <td>票数</td>
                    <td>image</td>
                    <td>排名</td>
                    <td>状态</td>
                    <td>操作</td>
                </tr>
              <?php $i=1; if($list):foreach($list as $val): ?>
                <tr>
                    <td><?php echo $val['id'];?></td>
                    <td><?php echo $val['title'];?></td>
                    <td><?php echo $val['vote_number'];?></td>
                    <td><img src="<?php echo JkCms::show_img($val['img']) ?>" width="35px" height="35px"/></td>
                    <td><?php echo $i;?></td>

                    <td><a href="javascript:;" onclick="checkstatus(<?php echo $val['id'];?>,<?php echo $val['whojoin'];?>)"><?php echo ($val['whojoin'] == 1 ? '<span class="notification ok_bg">未审核</span>' : '<span style="color: #F32043">已审核</span>');?></a></td>
                    <td>
                        <a href="<?php echo $this->createUrl('/activity/vote/adminEdit',array('id'=>$val['id'],'vid'=>$vid))?>">编辑</a>|
                        <a onclick="delActivity(<?php echo $val['id']?>)" >删除</a>
                    </td>
                </tr>
                    <?php
            $i++;
            endforeach;endif;
            ?>
              </tbody>
          </table>
          
        </div>
        <!--list end-->
            <div class="pages">
                <?php
                $this->widget('CoLinkPager', array('pages' => $pagebar,
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
      </div>
    </div>
    <script>

        //ajax 请求获取中奖名单
        function getWinList(id,title){
            //var index = layer.load(2,{shade: [0.3, '#393D49']});
            layer.open({
                type: 2,
                title:'报名活动用户列表',
                area: ['700px', '500px'],
                skin: 'layui-layer-rim', //加上边框
                content: ["<?php echo $this->createUrl('/activity/vote/AddList')?>/fid/"+id+"/title/"+title]
            });
        }
        //ajax  更新用户参加活动的状态
        function checkstatus(id,whojoin){
            layer.confirm('确认审核/取消审核吗', {
                btn: ['确定','取消']
            }, function(){
                $.ajax({
                    url:"<?php echo $this->createUrl('check');?>",
                    type: "POST",
                    data:{id:id,whojoin:whojoin},
                    dataType:"json",
                    success:function(data){
                        if(data==100){
                            layer.msg('审核成功！', {icon: 1,time:2000},function(){
                                location.reload()
                            });
                        }
                        else{
                            layer.msg('审核失败', {icon: 1,time:2000},function(){
                                location.reload()
                            });
                        }
                    }
                });
            });return;
        }

        //活动状态提示
        function getStatus(state,fid){
            if(state=='未开始'){
                layer.confirm('活动还未开始？活动的开始时间将被置为当前时间！', {
                    btn: ['确定','取消']
                }, function(){
                    var url = "<?php echo $this->createUrl('/activity/vote/activitystatus')?>";
                    $.post(url, {fid:fid,type:1}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg,{time:2000},function(){
                            location.reload();
                        })
                    })
                })
            }
            if(state=='进行中'){
                layer.confirm('活动正在进行中？活动的结束时间将被置为当前时间！', {
                    btn: ['确定','取消']
                }, function(){
                    var url = "<?php echo $this->createUrl('/activity/vote/activitystatus')?>";
                    $.post(url, {fid:fid,type:2}, function (res) {
                        var res = JSON.parse(res);
                        layer.msg(res.msg,{time:2000},function(){
                            location.reload();
                        })
                    })
                })
            }
            if(state=='已结束'){
                layer.msg('活动已经结束')
            }
        }

        function delActivity(fid){
            layer.confirm('确认要删除吗？', {
                btn: ['确定','取消']
            }, function(){
                $.post('<?php echo $this->createUrl('/activity/vote/adminDel')?>', { id: fid,vid:<?php echo $vid ?> }, function (data) {
                    var data = JSON.parse(data);
                    if(data.errorcode == 0){
                        layer.msg('活动已删除！', {icon: 1,time:2000},function(){
                            location.reload()
                        });
                    }
                    else if(data.errorcode == 1){
                        layer.msg('活动删除失败', {icon: 1});
                    }
                    else{
                        layer.msg('系统错误...', {icon: 1});
                    }
                });
            });return;

        }
    </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>