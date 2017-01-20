<?php echo $this->renderpartial('/common/header_new',$config); ?>


<!--组件目录-->
<?php echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>



<div class="ad-act-list  bxbg ">

    <div class="ad-app-list-tit">
        <div class="fl tl">
            <h3>我的应用</h3>
        </div>
        <div class="fr tr">
            <a href="<?php echo $this->createUrl('/activity/scratchcard/add',array('pid'=>$config['pid']))?>">
                <i class="aicon linear"></i>新增活动
            </a>
        </div>
    </div>
    <!--tit end-->





    <!--没有记录的情况-->
    <?php if(empty($asList)){ ?>
    <div class="ad-nodata  mgb30 mgt30">
        <img src="<?php echo $this->_theme_url; ?>assets/images/ad-nodata-bg.png"/>
        <p>噢噢，还没有记录！！！</p>
        <a href="<?php echo $this->createUrl('/activity/scratchcard/add',array('pid'=>$config['pid']))?>" class="linear adbtn">创建活动</a>
    </div>
    <?php  }else {
    ?>

    <div class="ad-act-list-table">


        <div class="ad-act-list-table-tit">
            <ul>
                <li class="lw1">活动ID<i></i></li>
                <li class="lw2">活动名称<i></i></li>
                <li class="lw3">开始时间</li>
                <li class="lw3">结束时间<i></i></li>
                <li class="lw2">活动状态</li>
            </ul>
        </div>
<style>
    
.ad-act-list-table-con1 .l3 {
    color: #f1aa02;
}
.ad-act-list-table-con1 .l3_1 {
    color: #f1aa02;
}
 .ad-act-list-table-con1 span {width:150px;display:inline-block}
 .ad-act-list-table-con1 i { display: inline-block; height: 20px; margin: 0 10px; position: relative; top: 4px; width: 25px;}
 .ad-act-list-table-con1 .l3 i {
    background: rgba(0, 0, 0, 0) url("<?php echo $this->_theme_url?>assets/images/ad-act-opt-icon3.png") no-repeat scroll center center;
}
.ad-act-list-table-con1 .l3_1 i {
    background: rgba(0, 0, 0, 0) url("<?php echo $this->_theme_url?>assets/images/ad-act-opt-icon3_1.png") no-repeat scroll center center;
}
.ad-act-list-table-con1 .l4 i {
    background: rgba(0, 0, 0, 0) url("<?php echo $this->_theme_url?>assets/images/ad-act-opt-icon4.png") no-repeat scroll center center;
}
.ad-act-list-table-con1 .l5 i {
    background: rgba(0, 0, 0, 0) url("<?php echo $this->_theme_url?>assets/images/ad-act-opt-icon5.png") no-repeat scroll center center;
}
.ad-act-list-table-con1 .l6 i {
    background: rgba(0, 0, 0, 0) url("<?php echo $this->_theme_url?>assets/images/ad-act-opt-icon6.png") no-repeat scroll center center;
}
</style>
        <div class="ad-act-list-table-con">
            <ul>
                <?php if($asList):foreach($asList as $val): ?>
                    <li class="li">
                        <div class="ad-act-list-table-con1 ">
                            <ul>
                                <li class="lw1"><?php echo $val->id;?></li>
                                <li class="lw2"><?php echo $val->title;?></li>
                                <li class="lw3"><?php echo date('Y-m-d H:i:s',$val->start_time);?></li>
                                <li class="lw3"><?php echo date('Y-m-d H:i:s',$val->end_time);?></li>
                                 <li class="lw2" style='cursor:pointer;'><?php $result = Activity_scratch::activityStatus($val->start_time,$val->end_time,$val->id);?>
                                 <span style='display:inline-block;height:20px;line-height:20px;font-size:14px;padding:0 5px;text-decoration: underline' <?php if($result['status'] == 1 ||  $result['message']=='已结束'){echo 'class="l3_1" ';}else{echo 'class="l3" '; }?>  href="javascript:void(0)" onclick="getStatus('<?php echo $result['message']?>',<?php echo $val->id?>)">
                                     <?php
                                    if($result['status'] == 0 ){
                                        echo '活动已结束<i></i>';
                                    } elseif( $result['status']==-1){
                                        echo '活动未开始<i></i>';
                                    }elseif($result['status'] == 1){
                                        echo '活动进行中<i></i>';
                                    }elseif($result['status'] == 2){
                                        echo $result['message'].'<i></i>';
                                    }
                                    ?>
                                     </span>
                                </li>
                              
                            </ul>
                        </div>

                        <div class="ad-act-list-table-con2">
                            <ul>
                                  <li class="l5"><a href="<?php echo $this->createUrl('/activity/scratchcard/prize',array('id'=>$val->id,'pid'=>$config['pid']))?>"><i></i>奖品/概率</a></li>
                                <li class="l5"><a href="<?php echo $this->createUrl('/activity/scratchcard/add',array('id'=>$val->id,'pid'=>$config['pid']))?>"><i></i>编辑</a></li>
                                <li class="l1"><a href="<?php echo $this->createUrl('/activity/scratchcard/pcview',array('id'=>$val->id))?>" target="_blank"><i></i>预览</a></li>
                                <li class="l2" onclick="getWinList(<?php echo $val->id?>)"><i></i>用户数据</li>
                              
                                <li class="l4" onclick="delActivity(<?php echo $val->id?>)"><i></i>删除活动</li>
                            </ul>
                        </div>
                    </li>

                        <?php
                endforeach;endif;
                ?>


            </ul>
        </div>


        <!--list end-->
        <div class="ad-page-list mgt30 mgb30">
            <ul class="pagelist">
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

            </ul>
        </div>


    </div>

    <?php } ?>





</div>



<script>
    var hover_src;
    var temp;
    $(".content_222 li").hover(function () {
        hover_src = $(this).find('img').attr('data-hover');
        temp = $(this).find('img').attr('src');
        $(this).find('img').attr('src', hover_src);
    }, function () {
        $(this).find('img').attr('src', temp);
    });


    //ajax 请求获取中奖名单
    function getWinList(param){
        //var index = layer.load(2,{shade: [0.3, '#393D49']});
        layer.open({
            type: 2,
            title:'参加活动用户列表',
            area: ['700px', '500px'],
            skin: 'layui-layer-rim', //加上边框
            content: ["<?php echo $this->createUrl('/activity/scratchcard/WinList')?>/fid/"+param]
        });
    }


//活动状态提示
    function getStatus(state,fid) {
        //把活动暂停
        if (state == '进行中' || state == '已结束') {
            layer.confirm('确定是否要暂停活动！抽奖类活动暂停后方可编辑', {
                btn: ['确定', '取消']
            }, function () {
                var url = "<?php echo $this->createUrl('/activity/scratchcard/activitystatus')?>";
                $.post(url, {fid: fid, type: 2}, function (res) {
                    var res = JSON.parse(res);
                    layer.msg(res.msg, {time: 2000}, function () {
                        window.location.reload();
                    })
                })
            })
        } else if (state == '暂停中') {
            layer.confirm('确定是否要开始活动', {
                btn: ['确定', '取消']
            }, function () {
                var url = "<?php echo $this->createUrl('/activity/scratchcard/activitystatus')?>";
                $.post(url, {fid: fid, type: 1}, function (res) {
                    var res = JSON.parse(res);
                    layer.msg(res.msg, {time: 2000}, function () {
                        window.location.reload();
                    })
                })
            })
        }

    }
    
   

    function delActivity(fid){
        layer.confirm('确认要删除活动吗？', {
            btn: ['确定','取消']
        }, function(){
            $.post('<?php echo $this->createUrl('/activity/scratchcard/Delete')?>', { fid: fid }, function (data,status) {
                if(data.errorcode == 1){
                    layer.msg('活动已删除！', {icon: 1});
                    setTimeout(function(){ window.location.reload();},300);
                }
                else if(data.errorcode == 0){
                    layer.msg('活动删除失败', {icon: 1});
                }
                else{
                    layer.msg('系统错误...', {icon: 1});
                }
            },'json');
        });return;

    }
</script>




<?php echo $this->renderpartial('/common/footer', $config); ?>

