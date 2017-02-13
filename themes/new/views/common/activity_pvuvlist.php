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

<!-- <div id="datePicker">
    <input type="text" name="date" id="date" value="" class="gri_date" style="float:left"/>
</div -->
<div class="ta_date" id="div_date1">
    <span class="date_title" id="date1"></span>
    <a class="opt_sel" id="input_trigger1" href="#">
        <i class="i_orderd"></i>
    </a>
</div>
<div id="datePicker1"></div>
<div id="main" style="  position:absolute;top:30px;z-index: -1;width: 600px;height:400px;"></div>

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var chart = echarts.init(document.getElementById('main'), 'vintage');
    var day = [],
        pv = [],
        uv = [];

    <?php foreach($pvuv as $key=>$val){?>
    pv.push(<?php echo $val['pv'];?>);
    uv.push(<?php echo $val['uv'];?>);
    day.push(<?php echo "'".$key."'"?>);

    <?php }?>

    // 指定图表的配置项和数据
    var  option = {
        tooltip: {
            trigger: 'axis',
            axisPointer :{
                type: 'none'
            }
        },
        toolbox: {
            feature: {
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        legend: {
            data:['PV浏览量','UV独立访问量']
        },

        xAxis: [
            {
                type: 'category',
                data: day,
                splitLine:{
                    show:false,
                },
            }
        ],
        yAxis: [
            {
                type: 'value',
                splitNumber :5,
                minInterval: 1,
                name: '访问数据',
                axisLine:{show:false,},
                axisLabel: {
                    formatter: '{value} 次'
                }
            }
        ],
        series: [
            {
                name:'PV',
                type:'bar',
                data:pv
            },
            {
                name:'UV',
                type:'bar',
                data:uv
            },
//            {
//                name:'平均温度',
//                type:'line',
//                yAxisIndex: 1,
//                data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
//            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    chart.setOption(option);
</script>
<script type="text/javascript">
    //var STATS_START_TIME = '1329148800';
    var dateRange1 = new pickerDateRange('date1', {
        isTodayValid : true,
        startDate : '2012-06-14',
        endDate : '2012-07-10',
        needCompare : false,
        defaultText : ' 至 ',
        autoSubmit : true,
        inputTrigger : 'input_trigger1',
        theme : 'ta',
        success : function(obj) {
        }
    });

</script>
</body>
</html>

