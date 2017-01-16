<div class="ad-data-con w1000 clearfix bxbg mgt30">
        
  <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-data2.png"/></i>
                <span>新增用户数</span>
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
                                <option value="2017" <?php if($config['year']==2017){echo "selected=selected";}?>>2017</option>
                                <option value="2016" <?php if($config['year']==2016){echo "selected=selected";}?>>2016</option>

                                <!--                                <option value="2015">2015</option>-->
                            </select>
                        </span>
                        <span>
                            <b>月份</b>
                            <select name="z-month">
                                <option value="06" <?php if($config['month']==6){echo "selected=selected";}?>>上半年</option>
                                <option value="12" <?php if($config['month']==12){echo "selected=selected";}?>>下半年</option>
                            </select>
                        </span>
                        <input class="schbtn linear adbtn" type="submit" name="" id="" value="查询" />

                     </form>




                        <span>
                            <b>数据来源</b>
                            <select name="z-from" id="z-from" style="width: 120px;" onchange="from()">
                                <option value="0">全部来源</option>
                                <?php if($user['from']){ foreach ($user['from'] as $k=>$v){?>
                                <option value="<?php echo $v->activity_table_name?>" <?php if($activity==$v->activity_table_name){echo "selected=selected";}?>><?php echo $v->activity_name?></option>
                                <?php }}?>
                                <!--                                <option value="2015">2015</option>-->
                            </select>
                        </span>

                 </div>
                 </div>
                 
                <div class="fr">
                    <ul>
                        <li><i class="cc c1"></i><span>平均增长量</span></li>
                        <li><i class="cc c2"></i><span>新增用户数</span></li>
                    </ul>
                 </div>
            </div>
            
            
            <div class="ad-data-map-zhu fl">
                
                <div id="ad_data_map_zhu" style="width: 100%; height: 100%;"></div>
                
            </div>
            
            <div class="ad-data-rightnum fr">
                
              <div class="ad-data-rightnum1">
                    <h3>新增总人数</h3>
                    <span>
                        <img src="<?php echo $this->_theme_url; ?>assets/images/ad-data-icon3.png" style="margin-top: 5px;"/>
                        <em><?php echo $user['count'];?><font>人</font></em>
                    </span>
                </div>

                <div class="ad-data-rightnum1">
                    <h3>平均每月新增</h3>
                    <span>
                        <img src="<?php echo $this->_theme_url; ?>assets/images/ad-data-icon4.png" style="margin-top: 5px;" />
                        <em><?php echo $user['count_everymonth'];?><font>人</font></em>
                    </span>
                </div>
                
                <div class="ad-data-rightnum1">
                    <h3>新增用户最高和最低</h3>
                    <div class="ad-data-rightnum2">
                        <li>
                            <i><?php echo $user['res']['1'];?><font></font></i>
                            <em>人</em>
                        </li>
                        <li class="fr">
                            <i><?php echo $user['res']['0'];?><font></font></i>
                            <em>人</em>
                        </li>
                    </div>
                </div>
                
            </div>
            
        </div>
        
        
        
    </div>

<script>
    function from(){
       var id= $("#z-from").val();
        if(id){
            window.location.href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'user'))?>/behaviorid/"+id;
        }
    }

</script>

 <script src="<?php echo $this->_theme_url; ?>assets/js/src/echarts.js" type="text/javascript" charset="utf-8"></script>
      <script type="text/javascript">
var month = [];
var count_user = [];
var count = [];
<?php foreach($user['count_user'] as $key=>$val){?>
count_user.push(<?php echo $val['count(*)']?>)
month.push(<?php echo "'".$key."'"?>)

<?php }?>

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
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById("ad_data_map_zhu")); 
                
            option = {
            title : {
                text: '新增用户数',
                subtext: '每月新增用户数',
                textStyle:{
                    color:"#858585",
                    fontFamily: 'microsoft yahei',
                    fontWeight:"normal",
                    
                },
                itemGap: 10,
                
            },
            tooltip : {
                trigger: 'axis',
                axisPointer:{
                type: 'none'
               }
            },
            
           
            //工具导航显示 
            toolbox: {
                show : true,
                feature : { 
                    magicType : {show: true, type: ['line', 'bar']},
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
        
           grid:{
          x: 50,
          y:80,
          x2: 0,

width: '660px',
height: '240px',
 borderWidth:0,
          },
        
        
        //x轴坐标显示
        
        xAxis : {
            type : 'category',
            data :month,
            axisLine:{
                lineStyle:{
                    color: '#333',
                    width: 1,
                    type: 'solid',
                }
            },
            splitLine:{
                show:false,
            },    
           
        },

    yAxis : {
            type : 'value',
            splitNumber: 4,
            axisLine:{show:false,},
            splitLine:{
                lineStyle: {
                    color: ['#e6e6e6'],
                    width: 1,
                    type: 'solid',
                },
            }, 
            
        },
        
    series : [
        {
            name:'新增用户数',
            type:'line',
            symbol: 'circle',
            symbolSize:3,
            smooth: true,
            data:count_user,
            markPoint : {
                data : [
                    // {name : '年最高', value : 7000, xAxis: 2, yAxis: 7000, symbolSize:18},
                    // {name : '年最低', value : 2.0, xAxis: 0, yAxis: 2}
                ],
                 itemStyle:{
                normal: {
               color: '#6ed0d3',
             },
            },
            },

            itemStyle:{
                normal: {
//             barBorderRadius: [3, 3, 0, 0],
               color: '#6ed0d3',
             },
            },
               markLine : {
                   data : [
                       {type : 'average', name: '平均值'}
                   ]
               }
        },
        
    ]
};
        
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );

        
    </script>
