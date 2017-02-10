<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ECharts</title>
    <!-- 引入 echarts.js -->
    <script src="<?php echo $this->_theme_url; ?>assets/js/src/echarts-all.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/src/vintage.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="width: 600px;height:400px;"></div>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var chart = echarts.init(document.getElementById('main'), 'vintage');


    // 指定图表的配置项和数据
    option = {
        title : {
            text: '活动用户参与和新增数据',
            subtext: '纯属虚构',
            x:'center'
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
                data:[
                    {value:335, name:'用户参与'},
                    {value:310, name:'新增用户量'}
                ],
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
</body>
</html>

