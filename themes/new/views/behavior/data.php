<?php echo $this->renderpartial('/common/header_new',$config); ?>

<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/js/echarts.min.js"></script>

    <!-- 数据分析 start -->
    <div class="data_analysis w960 clearfix">
        <div class="left">
            <a href="<?php echo $this->createurl('behavior/dataAnalysis',array('id'=>$pid))?>"><div class="icon icon1 on1">应用趋势</div></a>
            <a href="<?php echo $this->createurl('behavior/index',array('id'=>$pid))?>"><div class="icon icon1">用户分析</div></a>
        </div>
        <div class="right">
            <div class="title_wrap clearfix">
                <div class="title icon1">
                </div>
                <div class="search">
                    <input type="text" name="" id="" />
                </div>
            </div>
            <div class="date_wrap clearfix">
                <div class="date">
                    <div class="day <?php if(!isset($_GET['day']) || $_GET['day'] == 1){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>'1','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">今天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 2){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>'2','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">昨天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 7){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>'7','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">7天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 30){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>'30','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">30天</a></div>
                    <div class="long_day">
                        <div class="time">2016-04-10至2014-06-28</div>
                    </div>
                </div>
                <div class="sort">
                    <div class="box box1 on">按活动分析</div>
                    <div class="box box2">按活动分析</div>
                </div>
                <div class="long_list long_list_1 clearfix">
                    <div class="item <?php if(isset($_GET['activity']) && $_GET['activity'] == 2){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'2','id'=>$pid)); ?>">注册</a></div>
                    <div class="item <?php if(isset($_GET['activity']) && $_GET['activity'] == 1){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'1','id'=>$pid)); ?>">登陆</a></div>
                    <div class="item <?php if(isset($_GET['activity']) && $_GET['activity'] == 3){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'3','id'=>$pid)); ?>">签到</a></div>
                    <div class="item <?php if(isset($_GET['activity']) && $_GET['activity'] == 4){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/dataAnalysis',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'4','id'=>$pid)); ?>">红包</a></div>
                </div>
            </div>
            <div id="main" style="width: 600px;height:400px;"></div>
        </div>
    </div>

<?php
    foreach ($datalist as $k => $v){
        $days[] = '"'.$v['day'].'"';
        $counts[] = $v['count'];
    }
?>

    <script type="text/javascript">
    $(".data_analysis .icon2").hover(function() {
        $(this).addClass('on');
        // $(this).find('.show_detail').show();
    }, function() {
        $(this).removeClass('on');
        // $(this).find('.show_detail').hide();
    });

    // $(".data_analysis .icon1").hover(function() {
    //     $(this).addClass('on1');
    //     // $(this).find('.show_detail').show();
    // }, function() {
    //     $(this).removeClass('on1');
    //     // $(this).find('.show_detail').hide();
    // });

//    $(".long_list_1 .item").hover(function() {
//        $(this).addClass("on");
//    }, function() {
//        $(this).removeClass("on");
//    });
    </script>


<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        title: {
            text: ''
        },
        tooltip: {},
        legend: {
            data:['']
        },
        xAxis: {
//            data: ["2016-04-18","2016-04-19","2016-04-20","2016-04-21","2016-04-22","2016-04-23"]
            data:[<?php echo implode(',',$days); ?>]
        },
        yAxis: {},
        series: [{
            name: '<?php
                        if(isset($_GET['activity'])){
                                switch ($_GET['activity']){
                                    case '1':
                                        echo '登陆';
                                        break;
                                    case '2':
                                        echo '注册';
                                        break;
                                    case '3':
                                        echo '签到';
                                        break;
                                    case '4':
                                        echo '红包';
                                        break;
                                }
                        }else{
                                echo '行为';
                            } ?>',
            type: 'bar',
//            data: [5, 3, 0, 3, 2, 1]
            data:[<?php echo implode(',',$counts); ?>]
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
    <!-- 数据分析 end -->
    <!-- 底部样式 start -->
    <div class="foot">
        <div class="w980">
            <ul class="clearfix">
                <?php $friendlinks = JkCms::getFriendlink(3); ?>
        <?php if($friendlinks){$i=1;foreach ($friendlinks as $f) { ?>
                <li><a href="<?php echo $f['url'] ?>" title="<?php echo $f['title'] ?>" target="_blank"><?php echo $f['title'] ?></a></li>
        <?php }}?>
            </ul>
            <div class="copy_right copy_right1">
                Copyright © 1998 - 2016 Tencent. All Rights Reserved.
            </div>
            <div class="copy_right copy_right2">
                腾讯·大楚网 版权所有
            </div>
        </div>
    </div>
</body>

</html>
