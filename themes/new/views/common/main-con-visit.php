<link rel="stylesheet" type"text/css" href="<?php echo $this->_theme_url; ?>assets/datetime-components/dateRange.css" />
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/datetime-components/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/datetime-components/dateRange.js"></script>

<div class="ad-data-con w1000 clearfix bxbg mgt30">


    <div class="clearfix ad-alltit mgb30 mgt30">

        <div class="fl ad-alltit-left">
            <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-data1.png"/></i>
            <span>访问数据柱状图</span>
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
                <form action="" method="post" name="reg_testdate">
                    <div class="ad-data-search" style=" margin-top: 5px;">
                        <button type="submit" class="btn btn-primary" style="    background: #0091d5;border: none;     margin-left: 10px; color: #fff;border-radius: 4px;height: 30px;font-size: 14px; cursor: pointer;outline: none;display: inline-block;padding: 0px 10px;">按时间对比</button>
                        <div class="ta_date" id="div_date1">
                            <em class="date_title" id="date1"></em>
                            <a class="opt_sel" id="input_trigger1" href="#">
                                <i class="i_orderd"></i>
                            </a>
                        </div>
                        <div id="datePicker1"></div>
                        <input type="hidden" id="startdate" name="startdate" value="">
                        <input type="hidden" id="enddate" name="enddate" value="">
<!--                        <select name="z-year" onchange="YYYYDD(this.value)">-->
<!--                            <option value="">请选择 年</option>-->
<!--                        </select>-->
<!--                        <select name="z-month" onchange="MMDD(this.value)">-->
<!--                            <option value="">选择 月</option>-->
<!--                        </select>-->
<!--                        <select name="DD">-->
<!--                            <option value="">选择 日</option>-->
<!--                        </select>-->
<!--                        <input class="schbtn linear adbtn" type="submit" name="" id="" value="查询" />-->
                </form>


            </div>


        </div>


        <div class="fr">
            <ul>
                <li><i class="cc c1"></i><span>UV</span></li>
                <li><i class="cc c2"></i><span>PV</span></li>
            </ul>
        </div>
    </div>


    <div class="ad-data-map-zhu fl">

        <div id="ad_data_map_zhu" style="width: 100%; height: 100%;"></div>

    </div>

    <div class="ad-data-rightnum fr">

        <div class="ad-data-rightnum1">
            <h3>浏览量总数</h3>
                    <span>
                        <img src="<?php echo $this->_theme_url; ?>assets/images/ad-data-icon2.png"/>
                        <em><?php echo $visit['count_all_pv'];?><font>次</font></em>
                    </span>
        </div>

        <div class="ad-data-rightnum1">
            <h3>独立访客总数</h3>
                    <span>
                        <img src="<?php echo $this->_theme_url; ?>assets/images/ad-data-icon1.png"/>
                        <em><?php echo $visit['count_all_uv'];?><font>次</font></em>
                    </span>
        </div>

        <div class="ad-data-rightnum1">
            <h3>(PV-UV)在当前中的占比</h3>
            <div class="ad-data-rightnum2">
                <li>
                    <i><?php echo $visit['pv_num']*100;?><font>%</font></i>
                    <em style="color: #6ED0D3;">PV</em>
                </li>
                <li class="fr">
                    <i><?php echo $visit['uv_num']*100;?><font>%</font></i>
                    <em style="color: #F96A30;">UV</em>
                </li>
            </div>
        </div>



    </div>

</div>



</div>

<script src="<?php echo $this->_theme_url; ?>assets/js/src/echarts.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var month = [];
    var count_pv = [];
    var count_uv = [];
    <?php if($visit){foreach($visit['count_visit'] as $key=>$val){?>
    count_pv.push(<?php echo $val['count_pv']?>);
    count_uv.push(<?php echo $val['count_uv']?>);
    month.push(<?php echo "'".$key."'"?>)
    <?php }}?>
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
                    text: '访问数据',
                    subtext: '独立访客数（UV）和浏览量（PV）',
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

//                grid:{
//                    x: 50,
//                    y:80,
//                    x2: 0,
//
//                    width: '660px',
//                    height: '240px',
//                    borderWidth:0,
//                },


                //x轴坐标显示

                xAxis : {
                    type : 'category',
                    data : month,
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
                    splitNumber: 7,
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
                        name:'独立访客数（UV）',
                        type:'bar',
                        data:count_uv,
                        markPoint : {
                            data : [
                                // {name : '年最高', value : 162.2, xAxis: 7, yAxis: 163, symbolSize:18},
                                // {name : '年最低', value : 2.0, xAxis: 0, yAxis: 2}
                            ]
                        },

                        itemStyle:{
                            normal: {
                                barBorderRadius: [3, 3, 0, 0],
                                color: '#f96a30',
                            },
                        },
                        // markLine : {
                        //     data : [
                        //         {type : 'average', name: '平均值'}
                        //     ]
                        // }
                    },
                    {
                        name:'浏览量（PV）',
                        type:'bar',
                        data:count_pv,
                        markPoint : {
                            data : [
                                // {name : '年最高', value : 182.2, xAxis: 7, yAxis: 183, symbolSize:18},
                                // {name : '年最低', value : 2.3, xAxis: 11, yAxis: 3}
                            ],
                            itemStyle:{
                                normal: {
                                    color: '#6ed0d3',
                                },
                            },
                        },

                        itemStyle:{
                            normal: {
                                barBorderRadius: [3, 3, 0, 0],
                                color: '#6ed0d3',
                            },
                        },
                        // markLine : {
                        //     data : [
                        //         {type : 'average', name : '平均值'}
                        //     ]
                        // }
                    }
                ]
            };

            // 为echarts对象加载数据
            myChart.setOption(option);
        }
    );


</script>

<script type="text/javascript">

    //var STATS_START_TIME = '1329148800';
    var dateRange1 = new pickerDateRange('date1', {
        isTodayValid : true,
        startDate : '<?php echo isset($visit['start_time'])?$visit['start_time']:date("Y-m-d",strtotime("-6 day"));?>',
        endDate : '<?php echo isset($visit['end_time'])?$visit['end_time']:date('Y-m-d',time())?>',
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

<script>
    //new YMDselect('year1','month1');
    //new YMDselect('year1','month1',1990);
    //new YMDselect('year1','month1',1990,2);
    //new YMDselect('year1','month1','day1');
    new YMDselect('year1','month1','day1');
    //new YMDselect('year1','month1','day1',1990,2);
    //new YMDselect('year1','month1','day1',1990,2,10);
</script>