<div class="main-cont-left fl">
    <div class="index-data-area mb20">
        <?php echo $this->renderpartial('/common/main-con-tab',array('pid'=>$config['pid'],'tab'=>$config['tab']));?>
        <div class="index-data-tab-cont" id="behavior" style="margin-bottom: 20px;"></div>
        
    </div>
    <!--数据区end-->
    <!--用户数据-->
            <div class="table-data cylindrical-pir-fr clearfix">
                <table>
                    <thead>
                        <tr>
                            <th>用户行为</th>
                            <th>统计</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($behavior['behavior'] as $val){?>
                        <tr>
                            <td><?php echo $val['name']?></td>
                            <td><?php echo $val['value']?></td>
                        </tr>
                        <?php }?>
                        
                    </tbody>
                </table>
            </div>
            <!--用户数据end-->
</div>
<script type="text/javascript">
var behavior = [];
var result = [];
<?php foreach($behavior['behavior'] as $key=>$val){?>
behavior.push(<?php echo "'".$val['name']."'";?>)
result.push({value:<?php echo $val['value']?>,name:'<?php echo $val['name']?>'})
<?php }?>
var res = result;

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
                'echarts/chart/pie' // 使用柱状图就加载bar模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('behavior')); 
                
                option = {
                	    title : {
                	        text: '用户行为数据统计',
                	        x:'center'
                	    },
                	    tooltip : {
                	        trigger: 'item',
                	        formatter: "{a} <br/>{b} : {c} ({d}%)"
                	    },
                	    legend: {
                	        orient : 'vertical',
                	        x : 'left',
                	        data:behavior
                	    },
                	    toolbox: {
                	        show : true,
                	        feature : {
                	            
                	           
                	            saveAsImage : {show: true}
                	        }
                	    },
                	    calculable : true,
                	    series : [
                	        {
                	            name:'用户行为',
                	            type:'pie',
                	            radius : '55%',
                	            center: ['50%', '60%'],
                	            data:res
                	        }
                	    ]
                	};
                	                    
                	                    
        
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
    </script>