<div class="main-cont-left fl">
    <div class="index-data-area mb20">
        <?php echo $this->renderpartial('/common/main-con-tab',array('pid'=>$config['pid'],'tab'=>$config['tab']));?>
        <div class="index-data-tab-cont" id="user" style="margin-bottom:20px;"></div>
        <!--用户数据-->
            <div class="table-data cylindrical-pir-fr clearfix">
                <table>
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>用户数</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>总计</td>
                            <td><?php echo $user['count']['count(*)']?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--用户数据end-->
    </div>
    <!--数据区end-->
</div>

<script type="text/javascript">
var month = [];
var count = [];
<?php foreach($user['count_user'] as $key=>$val){?>
count.push(<?php echo $val['count(*)']?>)
month.push(<?php echo "'".$key."'"?>)
<?php }?>
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
                'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('user')); 
                
                option = {
                	    title : {
                	        text: '新增用户数据'
                	    },
                	    tooltip : {
                	        trigger: 'axis'
                	    },
                	    legend: {
                	        data:['新增人数']
                	    },
                	    toolbox: {
                	        show : true,
                	        feature : {
                	            saveAsImage : {show: true}
                	        }
                	    },
                	    calculable : true,
                	    xAxis : [
                	        {
                	            type : 'category',
                	            boundaryGap : false,
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
                	            name:'新增人数',
                	            type:'line',
                	            data:count,
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
                	        }
                	    ]
                	};
                	                    
        
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
        document.getElementById('user').style.backgroundColor="white"; 
    </script>