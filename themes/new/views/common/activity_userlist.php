<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <link rel="stylesheet" type"text/css" href="<?php echo $this->_theme_url; ?>assets/datetime-components/dateRange.css" />

    <!-- 引入 echarts.js -->
    <script src="<?php echo $this->_theme_url; ?>assets/js/src/echarts-all.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/src/vintage.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/datetime-components/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/datetime-components/dateRange.js"></script>
</head>
<body>
<form action="<?php echo $this->createUrl('/activity/bigwheel/Activitylist/fid/'.$aid.'/tag/user')?>" method="post">
<!-- <div id="datePicker">
    <input type="text" name="date" id="date" value="" class="gri_date" style="float:left"/>
</div -->
<button type="submit" class="btn btn-primary">按时间对比</button>
<div class="ta_date" id="div_date1">
    <span class="date_title" id="date1"></span>
    <a class="opt_sel" id="input_trigger1" href="#">
        <i class="i_orderd"></i>
    </a>
</div>
<div id="datePicker1"></div>
<input type="hidden" id="startdate" name="startdate" value="">
<input type="hidden" id="enddate" name="enddate" value="">
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="position:absolute;top:30px;z-index: -1;width: 600px;height:400px;"></div>
</form>    
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var chart = echarts.init(document.getElementById('main'), 'vintage');
    var data = [{value:<?php echo $userdata['signup'];?>,name:"用户参与"},{value:<?php echo $userdata['join'];?>, name:'新增用户量'}];



    // 指定图表的配置项和数据
    option = {
        title : {
            text: '活动用户参与和新增数据',
            subtext: '默认显示当前7天内的数据',
            x:'center'
        },
        toolbox: {
            feature: {
                dataView: {show: true, readOnly: false},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            left: 'left',
            data: ['用户参与','新增用户量']
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:data,
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    chart.setOption(option);
</script>
<script type="text/javascript">

    //var STATS_START_TIME = '1329148800';
    var dateRange1 = new pickerDateRange('date1', {
        isTodayValid : true,
        startDate : '<?php echo isset($time['start_time'])?$time['start_time']:date("Y-m-d",strtotime("-6 day"));?>',
        endDate : '<?php echo isset($time['end_time'])?$time['end_time']:date('Y-m-d',time())?>',
        needCompare : false,
        defaultText : ' 至 ',
        autoSubmit : true,
        inputTrigger : 'input_trigger1',
        theme : 'ta',
        success : function(obj) {
            var startdate = Date.parse(new Date(obj.startDate));
            startdate = startdate / 1000;
            var enddate = Date.parse(new Date(obj.endDate));
            enddate = enddate / 1000;
            $("#startdate").attr("value",startdate);
            $("#enddate").attr("value",enddate);

        }
    });

</script>
</body>
</html>

