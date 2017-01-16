<div class="main-cont-left fl">
    <div class="index-data-area mb20">
        <?php echo $this->renderpartial('/common/main-con-tab',array('pid'=>$config['pid'],'tab'=>$config['tab']));?>
        <div class="index-data-tab-cont" id="user" style="margin-bottom:20px;"></div>
          
    </div>
    <!--数据区end-->
</div>

<script type="text/javascript">
var month = [];
var count_pv = [];
var count_uv = [];
<?php if($visit){foreach($visit['count_visit'] as $key=>$val){?>
count_pv.push(<?php echo $val['count_pv']?>);
count_uv.push(<?php echo $val['count_uv']?>);
month.push(<?php echo "'".$key."'"?>)
<?php }}?>
console.log(count_pv,count_uv);
// 路径配置
        require.config({
            paths: {
                echarts: '<?php echo $this->_theme_url; ?>js/echarts/dist'
            }
        });
        
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载action.brush.brush
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('user')); 
                
              option = option = {
                title : {
                    text: '访问数据柱状图'
                },
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['PV','UV']
                },
                toolbox: {
                    show : true,
                    feature : {
                        dataView : {show: true, readOnly: false},
                        // magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : month
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value} 人'
                        }
                    }
                ],
                series : [
                    {
                        name:'PV',
                        type:'bar',
                        data:count_pv,
                        markPoint : {
                            data : [
                                {type : 'max', name: '最大值'},
                                {type : 'min', name: '最小值'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: '平均值'}
                            ]
                        }
                    },
                    {
                        name:'UV',
                        type:'bar',
                        data:count_uv,
                        markPoint : {
                            data : [
                                {type : 'max', name: '最大值'},
                                {type : 'min', name: '最小值'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name : '平均值'}
                            ]
                        }
                    }
                ]
            };

        
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
        document.getElementById('user').style.backgroundColor="white"; 
    </script>