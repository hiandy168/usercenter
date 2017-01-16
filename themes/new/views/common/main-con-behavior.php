<div class="ad-data-con w1000 clearfix bxbg mgt30">
        
   <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-data3.png"/></i>
                <span>用户行为数据分析</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                <!--选择分类跳转-->

                   <div class="ad-newkind fr">
                   <div class="ad-newkind1">
                    <span><?php echo $view->name; ?></span>
                    <i></i>
                   </div>
                   <div class="ad-newkind2 bxbg">
                    <ul>
                        <?php if(!empty($project_list)){?>
                    <?php foreach($project_list as $project){?>
                    <?php if($view->id ==$project->id ){continue;}?>
                        <li>
                        <a style="" href="<?php echo $this->createAbsoluteUrl('/project/appmgt',array('id'=>$project->id)); ?>" style='color: #177c77;'><?php echo $project->name?></a>
                        </li>
                    <?php } ?>
                    <?php }?>
                    </ul>
                   </div>
                   </div>
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                    <!-- <a href="" class="a2" title="添加应用"></a> -->
                </div>
 
            </div>
            
            
            
        </div>
       
        
            
        <!--tit end-->
        
        <div class="ad-data-map">
            
            <div class="ad-data-maptit clearfix">
                 
                 <div class="fl date-select">
                        <form action="" method="post">
                        <div class="ad-data-search">
                        <span>
                            <b>年份</b>
                            <select name="z-year">
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                            </select>
                        </span>
                        <span>
                            <b>月份</b>
                            <select name="z-month">
                                <?php for($i=1;$i<=12;$i++){ ?>
                                 <option value="<?php echo $i;?>" <?php if($config['month']==$i){echo "selected=selected";}?>><?php echo $i;?>月</option>
                                <?php }?>
                            </select>
                        </span>
                        <input class="schbtn linear adbtn" type="submit" name="" id="" value="查询" />
                           
                        </div>
                        
                    </form>
                
                 </div>
                 
                 <div class="fr">
                    <ul>
                        <!-- <li><i class="cc c1"></i><span>平均增长量</span></li> -->
                        <li><i class="cc c2"></i><span>用户各项行为数据</span></li>
                    </ul>
                 </div>
            </div>
            
            
            <div class="ad-data-map-pai fl" style="height: 800px" >
                
            <div id="ad_data_map_zhu" style="width: 100%; height: 100%;"></div>
                
                
            </div>
            
        
        </div>
        
        
    </div>
  
    <script src="<?php echo $this->_theme_url; ?>assets/js/src/echarts.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript">
       require.config({
            paths: {
                echarts: '<?php echo $this->_theme_url; ?>assets/js/src/'
            }
        });
        
        require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/line', 
                'echarts/chart/pie', 
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表

    var radius = [45, 55];

    var labelFromatter = {
        normal : {
            label : {
                formatter : function (params){
                    return  params.name 
                },
                textStyle: {
                    baseline : 'top'
                }
            }
        },
    }
    var labelBottom = {
        normal : {
            color: '#efefef',
            label : {
                show : true,
                position : 'center'
            },
            labelLine : {
                show : false
            }
        },
        emphasis: {
            color: 'rgba(0,0,0,0)'
        }
    };
    var myChart = ec.init(document.getElementById("ad_data_map_zhu")); 
                            
    var labelTop = {
        normal : {
            label : {
                show : true,
                position : 'center',
                formatter : '{c}次',
                textStyle: {
                    baseline : 'bottom'
                }
            },
            labelLine : {
                show : false
            }
        }
    };
option = {
    legend: {
        x : 'center',
        y : 'center',
        data:[
          
        ]
    },

     //工具导航显示 
            toolbox: {
                show : true,
                feature : {                    
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },

            // tooltip: {
            //     formatter: '{b}: {c}',
            // },
    series : [

    <?php
        $px = 80;
        $percentage = 10;
        foreach ($behavior['behavior'] as $key => $value) {
        if(($key)%5 == 0 && $key != 0){
            $px = $px+190;
        }
        if($key != 0){
            $percentage = $percentage + 20;
            if($percentage>100){
                $percentage = 10;
            }
        }
    ?>
        {
            type : 'pie',
            center : ['<?php echo $percentage; ?>%', '<?php echo $px; ?>px'],
            radius : radius,
            x: '0%', // for funnel
            itemStyle : labelFromatter,
            data : [
                {name:'<?php echo $value['name'] ?>', value:<?php echo $value['value'] ?>,itemStyle : labelTop},
                {name:'<?php echo $value['name'] ?>', value:100, itemStyle : labelBottom}
            ]
        },
    <?php
        }
    ?>

    ],
    // series : [
    //     {
    //         type : 'pie',
    //         center : ['10%', '80px'],
    //         radius : radius,
    //         x: '0%', // for funnel
    //         itemStyle : labelFromatter,
    //         data : [
    //             {name:'注册', value:600,itemStyle : labelTop},
    //             {name:'注册', value:100, itemStyle : labelBottom}
    //         ]
    //     },
   
    // ],
     color: ['rgb(254,67,101)','rgb(252,157,154)','rgb(249,205,173)','rgb(20,200,169)','rgb(131,175,155)',
             'rgb(24,67,101)','rgb(252,157,14)','rgb(249,25,173)','rgb(200,201,169)','rgb(11,175,155)',
             'rgb(54,255,11)','rgb(23,157,255)','rgb(49,205,13)','rgb(20,20,236)','rgb(131,175,15)',
             'rgb(24,67,101)','rgb(252,17,154)','rgb(255,163,255)','rgb(200,20,169)','rgb(11,175,12)', 
     ]
};
             
             
             
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
        
        
    
    
        
        
        
    </script>
    
</body>

</html>