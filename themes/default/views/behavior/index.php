<?php echo $this->renderpartial('/common/header_new',$config); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/dateRange.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>css/monthPicker.css"/>

<style>

    .ta_calendar_cont .i_pre, .ta_calendar_cont .i_next {
        top: -64px;
    }

    .ta_calendar_cont .i_pre {
        left: -100px;
    }

    .ta_calendar_cont .i_next {
        right: -100px;
    }

    .ta_date .date_title {
        width: 186px !important;
        display: inline-block;
    }

    .ta_date .i_orderd {
        position: relative;
        top: 10px
    }
</style>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/dateRange.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/monthPicker.js"></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/js/echarts.min.js"></script>

<div class="new_wrap clearfix">

    <?php echo $this->renderpartial('/common/left_new'); ?>
    <div class="right">
        <div class="edit_app">
            <div class="t">应用名称：<?php echo $config['project_now']->name?></div>
            <div class="edit_button"><a href="<?php echo $this->createUrl('/project/updatePro',array('pid'=>$pid)); ?>" style="color:#333;">编辑应用</a></div>
        </div>
        <div class="data_list clearfix">
            <div class="chose_wrap clearfix">
                <a class="chose <?php if(isset($_GET['activity']) && $_GET['activity'] == 2){echo 'on';}?>" href="<?php echo $this->createUrl('/behavior/index',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'2','id'=>$pid,'begin'=>$_GET['begin'],'end'=>$_GET['end'])); ?>">注册</a>
                    <a class="chose <?php if(isset($_GET['activity']) && $_GET['activity'] == 1){echo 'on';}?>" href="<?php echo $this->createUrl('/behavior/index',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'1','id'=>$pid,'begin'=>$_GET['begin'],'end'=>$_GET['end'])); ?>">登陆</a>
                    <a class="chose <?php if(isset($_GET['activity']) && $_GET['activity'] == 3){echo 'on';}?>" href="<?php echo $this->createUrl('/behavior/index',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'3','id'=>$pid,'begin'=>$_GET['begin'],'end'=>$_GET['end'])); ?>">签到</a>
                    <a class="chose <?php if(isset($_GET['activity']) && $_GET['activity'] == 4){echo 'on';}?>" href="<?php echo $this->createUrl('/behavior/index',array('day'=>isset($_GET['day'])?$_GET['day']:'1','activity'=>'4','id'=>$pid,'begin'=>$_GET['begin'],'end'=>$_GET['end'])); ?>">红包</a>
                
            </div>
            <div class="data_content">
                <div class="time_select clearfix">
                    
                    <span class="se <?php if((!isset($_GET['day']) || $_GET['day'] == 1)&&!$_GET['begin']){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/index',array('day'=>'1','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">今天</a></span>
                    <span class="se <?php if(isset($_GET['day']) && $_GET['day'] == 2){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/index',array('day'=>'2','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">昨天</a></span>
                    <span class="se <?php if(isset($_GET['day']) && $_GET['day'] == 7){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/index',array('day'=>'7','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">7天</a></span>
                    <span class="se <?php if(isset($_GET['day']) && $_GET['day'] == 30){echo 'on';}?>"><a href="<?php echo $this->createUrl('/behavior/index',array('day'=>'30','activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>">30天</a></span>
                    
                    <div class="ta_date" id="div_date1">
                        <span class="date_title" id="date1"></span>
                        <a class="opt_sel" id="input_trigger1" href="#">
                            <i class="i_orderd"></i>
                        </a>
                    </div>
                    <script>
                        var dateRange1 = new pickerDateRange('date1', {
                            isTodayValid: true,
                            <?php
                            if ($_GET['begin']) {
                                echo "startDate: '".$_GET['begin']."',";
                            }
                            ?>
                            <?php
                            if ($_GET['end']) {
                                echo "endDate: '".$_GET['end']."',";
                            }
                            ?>
                            needCompare: false,
                            defaultText: ' 至 ',
                            autoSubmit: false,
                            inputTrigger: 'input_trigger1',
                            theme: 'ta',
                            success: function (obj) {

                                window.location.href="<?php echo $this->createUrl('/behavior/index',array('activity'=>isset($_GET['activity'])?$_GET['activity']:'','id'=>$pid)); ?>/begin/"+obj.startDate+"/end/"+obj.endDate; 
                                //回调
                                console.log(obj);

                            }
                        });

                    </script>
                </div>
                <div id="main" style="width: 800px;height:400px;"></div>
            </div>
        </div>
    </div>
</div>
 <?php
    foreach ($datalist as $k => $v){
        $days[] = '"'.$v['day'].'"';
        $counts[] = $v['count'];
    }
?>       
        
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
<script>
    $(document).ready(function () {

//        $(".new_wrap .left .title2").hover(function () {
//            $(".new_wrap .left .title2 .subtitle").hide();
//            $('.new_wrap .left .title2 .arrow').removeClass("arrow_down");
//            $('.new_wrap .left .title2 .title22').removeClass('on_hover');
//            $(this).find('.arrow').addClass("arrow_down");
//            $(this).find('.title22').addClass('on_hover');
//            $(this).find(".subtitle").show();
//        }, function () {
//
////            $(this).find(".subtitle").hide();
//        });

        $("#change_td_bg tr").hover(function () {
            $(this).addClass('hover');
        }, function () {
            $(this).removeClass('hover');
        });

    });
</script>

</body>
</html>