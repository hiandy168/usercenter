<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="Keywords" content="楚蓄罐"/>
    <meta name="description" content="楚蓄罐"/>
    <title>日历</title>
    <link rel="stylesheet" type="text/css" href="/assets/calendar/css/style.css"/>
    <script src="/assets/calendar/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/js/layer/layer.js"></script>
</head>
<body>

<div class="cal-main">

    <!-- <div class="cal-head clearfix">
        <a class="lefta fl" href="javascript:history.back();void(0)">日历</a>
    </div> -->
    <!--head end-->

    <div class="cal-mid" id="calendar">

        <div class="cal-mid1">
            <span class="prev"></span>
            <span class="show_date"></span>
            <span class="next"></span>
            <!-- <a href="<?php echo $this->createUrl('/h5/notepad/index') ?>" class="cal-add-note"></a> -->
        </div>

        <!--cal-mid1 end-->
        <div class="cal-mid2">

            <div class="cal-mid2-1">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>日</td>
                        <td>一</td>
                        <td>二</td>
                        <td>三</td>
                        <td>四</td>
                        <td>五</td>
                        <td>六</td>
                    </tr>

                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>
                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>
                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>
                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>
                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>
                    <tr>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                        <td><i></i></td>
                    </tr>


                </table>
            </div>

            <div class="cal-downup-icpn">
                <img class="img iconup" src="/assets/calendar/images/cal-dwonup-icon.png"/>
            </div>


        </div>

        <!--cal-mid2 end-->
    </div>






     <div class="cal-sj pd20">
        

        
        <!--有记事且可以增加记事-->
        
        
        <div class="cal-sj1">
            
            <ul>
                <?php if(is_array($signup) && intval(count($signup))>0){foreach($signup as $ke=>$val){?>
            <li>
            <p><?php echo $val['title'] ?></p>
            <span>
               <?php echo date('Y-m-d H:i:s',$val['remind']) ?>
                <i class="cal-icon icon-entips"></i>
                <!-- <i class="cal-icon icon-distips"></i> -->
            </span>
            </li>

            <?php }?>
                <a href="<?php echo $this->createUrl('/h5/notepad/index') ?>" class="act-add-note1">
             <?php  }else{?>
                    <!--没有记事的情况-->
                     <a href="<?php echo $this->createUrl('/h5/notepad/index') ?>" class="act-add-note">
                    点击添加今日记事
                    </a>
                <?php }?>
            </ul>

           </a>
        </div>
        
                
    </div>




   <!--  <div class="cal-date pd20">
        <div class="cal-date1 clearfix">
             		<span>
             		<i>一</i>
             		<i>二</i>
             		</span>
             		<span>
             			<em>
                            <i>丙申猴年 五月</i>
                            <i>甲午月 甲申日</i>
                        </em>
             		</span>
             		<span>
             			<i>建党节</i>
             		</span>
        </div>
        <div class="cal-date2">
             		<span>
             			<i class="cal-icon icon-yi"></i>
             			<em>结婚 开光 出行</em>
             		</span>
             		<span>
             			<i class="cal-icon icon-ji"></i>
             			<em>结婚 开光 出行</em>
             		</span>
        </div>
    </div> -->

    <div class="cal-addsj">
        <h3 class="cal-tit pd20"><i class="rq">07月01日 周五</i><i class="ll" style="padding-left: 15px"></i></h3>
       <!--  <a href="<?php echo $this->createUrl('/h5/notepad/index') ?>" class="pd20">
            <i class="cal-icon icon-add"></i>
            添加记事
        </a> -->
    </div>


    <!--    <div class="cal-datejr">-->
    <!--        <h3 class="cal-tit pd20">07月02日 周六</h3>-->
    <!--        <div class="cal-datejr1 pd20 clearfix">-->
    <!--            <span>12:00</span>-->
    <!--             		<span>-->
    <!--             			<em>-->
    <!--                            <p>中国无烟日</p>-->
    <!--                            <i>距今天还有1天</i>-->
    <!--                        </em>-->
    <!--             		</span>-->
    <!--            <i class="cal-icon icon-tx"></i>-->
    <!--        </div>-->
    <!--    </div>-->

   
           <div class="cal-hd">
       <div class="cal-hdtit">
        <i class="cal-icon icon-hd"></i>
        我参与过的活动
       </div>
        
        <div class="cal-hd-list">
                <ul>
            <?php if(is_array($activitylist) && intval(count($activitylist))>0){foreach($activitylist as $key=>$value){?>
                    <li>
                     <div class="cal-hd-listdiv">
                        <i></i>
                        <span><?php echo date('Y-m-d H:i',$value['createtime'])?>&nbsp;</span>
                        <p><?php echo $value['type']?>-<?php echo $value['title']?></p>
                     </div>
                        
                    </li>
                <?php }}else{?>
                    <div class="nodata-div" style=" margin: 20px;text-align: center;">
            <span><img style="width: 40%;"  src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-info.png"/></span>
            <p style="color: #666;margin-top: 10px;">暂无活动记录</p>
        </div>
                    <?php }?>
                    
                </ul>
                
        </div>
        
    </div>

      <!--cal-hd end-->   
      
      
      
      <div class="cal-tj">
        
        <div class="cal-hdtit">
        <i class="cal-icon icon-tj"></i>
        活动推荐
       </div>
        
        
        <div class="cal-tjlist">
            <ul>
            <?php if(is_array($recommend) && intval(count($recommend))>0){foreach($recommend as $k=>$v){?>
                <li>
                    <a href="<?php echo $v['url']?>">
                        <div class="cal-tjlistdiv">
                            <span class="c3">
                                <img src="<?php echo $v['image'] ?>"/>
                                <em>立即参与</em>
                            </span>
                            <p><?php echo $v['title']?></p>
                        </div>
                    </a>    
                </li>
              <?php }}else{?>

                <!--没有推荐活动-->

                <?php }?>
            </ul>
            
        </div>
        



    <!--all end-->
</div>



<script type="text/javascript">

    (function ($) {
        $(".cal-downup-icpn").click(function () {
            if ($(this).find("img").hasClass("iconup")) {
                $(this).find("img").removeClass("iconup");
                $(".cal-mid2-1").addClass("cal-mid2-1up");
                $(".cal-addsj,.cal-datejr").hide();
                if($(".cal-mid2-1 table tr td").hasClass("selected")){
                $(".cal-mid2-1 table tr td.selected").parent().siblings().hide(); 
                $(".cal-mid2-1 table tr").first().show();
                }
            } else {
                $(this).find("img").addClass("iconup");
                $(".cal-mid2-1").removeClass("cal-mid2-1up");
                $(".cal-addsj,.cal-datejr").show();
                $(".cal-mid2-1 table tr").show();
            }
        })
    })(jQuery)
</script>
<script type="text/javascript" charset="utf-8">
    (function ($, window, document, undefined) {
        //定义Calendar的构造函数
        var Calendar = function (ele, opt) {
            this.$element = ele;
            this.defaults = {
                "year": (new Date()).getFullYear(),
                "month": (new Date()).getMonth() + 1,
                "prevMonth": this.$element.find('.prev'),
                "nextMonth": this.$element.find('.next'),
                "setEventDay": null,
                "changeMonth": null,
                "day": (new Date()).getDate(),
                "showDate": this.$element.find('.show_date'),
                "calendarContent": this.$element.find('.cal-mid2-1 table i'),
                "clickDay": null
            };
            this.options = $.extend({}, this.defaults, opt);
            this.year = this.options.year;
            this.month = this.options.month;
            this.day = this.options.day;
            this.calendarContent = this.options.calendarContent;
            this.showDate = this.options.showDate;
            this.clickDay = this.options.clickDay;

            //初始化
            this.init();

            this.prevClick();
            this.nextClick();

        }
        $(document).ready(function () {
            var myDate = new Date();
            var day = myDate.getDate();
            var month = myDate.getMonth() + 1;
            var i = parseInt(firstDay) + parseInt(day);
            var i1 = i % 7;
            var xq = new Array("星期六", "星期日", "星期一", "星期二", "星期三", "星期四", "星期五");

            $('.cal-addsj .rq').text(month + "月" + day + "日" + xq[i1]);

            //请求数据，包括 记事 农历  活动
            $.ajax({
                type: "GET",
                url: "<?php echo $this->createUrl('curl');?>",
                dataType: 'json',
                data: {
                    'year': myDate.getFullYear(),
                    'month': parseInt(myDate.getMonth()) + 1,
                    'day': myDate.getDate()
                },
                beforeSend: function () {
                    $(".cal-date").find("div").remove();
                },
                success: function (result) {
                   
                    var json_data1 = result[0];
                    json_detail_data1 = json_data1;
                    if (json_detail_data1.status == 0) {
                        if (parseInt(json_detail_data1.result.day) == parseInt(myDate.getDate())) {
                            var html_temp1 = json_detail_data1.result.nongli;

                            $('.cal-addsj .ll').append(html_temp1);
                        }
                    }

                }
            });
        });


        //Calendar
        Calendar.prototype = {
            init: function () {
                this.createCalendar(this.year, this.month);
                if ($.isFunction(this.options.changeMonth)) {
                    this.options.changeMonth(this.year, this.month,this.day,this.calendarContent);
                }
            },
            //获取每月天数
            getDaysInOneMonth: function (year, month) {
                var month = parseInt(month);
                var year = parseInt(year);
                var date = new Date(year, month, 0);
                return date.getDate();
            },
            //获取每月1日的星期
            getFirstDayWeekOfMonth: function (year, month) {
                var year = parseInt(year);
                var month = parseInt(month);
                var day = 1;
                var date = new Date(this.year, month, day);

                return date.getDay();

            },
            //创建日历
            createCalendar: function (year, month) {

                this.showDate.text(year + "年" + month + "月");
                //清空日历
                this.calendarContent.text("");

                var year = parseInt(year);
                var month = parseInt(month);
                firstDay = this.getFirstDayWeekOfMonth(year, month - 1);
                var days = this.getDaysInOneMonth(year, month);
                var daysArray = [];

                if (firstDay > 0) {
                    for (var i = 0; i < firstDay; i++) {
                        daysArray.push("");
                    }
                }

                for (var n = 0; n < days; n++) {
                    daysArray.push(n + 1);
                }

                if ($.isFunction(this.options.setEventDay)) {
                    this.options.setEventDay(daysArray);
                }

                for (var i = 0; i < daysArray.length; i++) {

                    this.calendarContent.eq(i).html(daysArray[i]);
                    if ($.isNumeric(i)) {
                        if (this.isSameDay(new Date(this.year, this.month - 1, i), new Date())) {

                            if (firstDay == 7) {
                                var ss = i + 0
                            } else if (firstDay <= 6) {
                                var ss = firstDay + i - 1;
                            }
                            this.calendarContent.eq(ss).parent().addClass("thisday selected");
                        }
                    } else {
                        this.calendarContent.eq(ss).parent().removeClass("thisday selected");
                    }
                }

                this.dayClcik();

                var today = (new Date()).getMonth() + 1;
                var year = (new Date()).getFullYear();

            },
            //日期点击事件
            dayClcik: function () {
                var self = this;
                this.calendarContent.on("click", function () {
                    var day = $(this).parent().find('i').text();
                    $.isFunction(self.clickDay) && self.clickDay(self.year, self.month, day, $(this), self.calendarContent);
                });
            },
            //上个月
            prevClick: function () {
                var self = this;

                this.options.prevMonth.on("click", function () {
                    self.month--;

                    if (self.month == 0) {
                        self.month = 12;
                        self.year--;
                    }

                    self.createCalendar(self.year, self.month);
                    if ($.isFunction(self.options.changeMonth)) {
                        self.options.changeMonth(self.year, self.month,self.day, self.calendarContent);
                        self.calendarContent.parent().removeClass("thisday selected");
                        if ((new Date()).getFullYear() == self.year && ((new Date()).getMonth() + 1) == self.month) {

                            var i = (new Date()).getDate();
                            if (firstDay == 7) {
                                var ss = i + 0
                            } else if (firstDay <= 6) {
                                var ss = firstDay + i - 1;
                            }

                            self.calendarContent.parent().eq(ss).addClass("thisday");

                        }

                    }
                });
            },
            //下个月
            nextClick: function () {
                var self = this;
                this.options.nextMonth.on("click", function () {

                    self.month++;

                    if (self.month > 12) {
                        self.month = 1;
                        self.year++;
                    }

                    self.createCalendar(self.year, self.month);
                    if ($.isFunction(self.options.changeMonth)) {
                        self.options.changeMonth(self.year, self.month,self.day, self.calendarContent);
                        self.calendarContent.parent().removeClass("thisday selected");
                        if ((new Date()).getFullYear() == self.year && ((new Date()).getMonth() + 1) == self.month) {

                            var i = (new Date()).getDate();
                            if (firstDay == 7) {
                                var ss = i + 0
                            } else if (firstDay <= 6) {
                                var ss = firstDay + i - 1;
                            }

                            self.calendarContent.parent().eq(ss).addClass("thisday");

                        }

                    }
                });
            },
            //判断今天
            isSameDay: function (d1, d2) {
                return (d1.getFullYear() == d2.getFullYear() && d1.getMonth() == d2.getMonth() && d1.getDate() == d2.getDate());
            }
        }
        //calendar
        $.fn.calendar = function (options) {
            //创建Beautifier的实体
            var calendar = new Calendar(this, options);
            //调用其方法
            return calendar;
        }
    })(jQuery, window, document);

    var json_detail_data = "";


    $("body").calendar({
        //改变年月
        "changeMonth": function (year, month,day,all_elem) {
            //模拟ajax开始
            // // 
            // 
               $.ajax({
               type: "GET",
                url: "<?php echo $this->createUrl('monthtag');?>",
                dataType: 'json',
                data: {
                    'year': year,
                    'month': month,
                    'day': day
                },
                success: function (result) {
                    console.log(result);
                    // var model=result
                    // alert(model.length);
                    var dlist=[];
                    if( result.length>0){
                     for(var i=0; i < result.length; i++){
                      var d=  new Date(parseInt(result[i]['createtime'])*1000);
                          dlist.push(d.getDate())
                          console.log(dlist);
                    }
                    }else{
                           dlist.push("")
                    }
                    


                 var string = '{"code": 1, "event": ['+dlist+']}';
            var json_data = eval( "("+string+")" );
            console.log(json_data);
            if (json_data.code == 1) {
                 all_elem.parent().removeClass("act");
                var event_day = json_data.event;
                for (var i = 0; i < event_day.length; i++) {

                    for (var n = 0; n < all_elem.size(); n++) {

                        if ((event_day[i]) == (all_elem.eq(n).parent().find("i").text())) {

                            all_elem.eq(n).parent().addClass("act");

                        }
                    }
                }
            } 

                }
                 
                 });
               
                
            

               
        },


        "clickDay": function (year, month, day, this_elem, all_this_elem) {

            if (this_elem.parent().find("i").text().length != 0) {
                all_this_elem.parent().removeClass("selected");
                this_elem.parent().addClass("selected");
            }
            var i = parseInt(firstDay) + parseInt(day);
            var i1 = i % 7;
            var xq = new Array("星期六", "星期日", "星期一", "星期二", "星期三", "星期四", "星期 五");

            $('.cal-addsj .rq').text(month + "月" + day + "日" + xq[i1]);
            $(".cal-date").find("div").remove();

            $.ajax({
                type: "GET",
                url: "<?php echo $this->createUrl('curl');?>",
                dataType: 'json',
                data: {
                    'year': year,
                    'month': month,
                    'day': day
                },
                beforeSend: function () {
                    $(".cal-hd-list ul").html("<span style='display: block;text-align: center;padding: 50px 0px;'>数据加载中....</span>");
                },
                success: function (result) {
                    console.log(result);

                    //事件
                    var json_things=result[1];
                    if (json_things[0].code == 1) {
                         $(".cal-sj1 ul").html("");
                        for (var i = 0; i < json_things.length; i++) {
                            var html = '<li> <p>'+json_things[i].title+'</p><span>'+json_things[i].jointime+'<i class="cal-icon icon-entips"></i></span> </li>';
                            $(".cal-sj1 ul").append(html);
                        }
                        $(".cal-sj1").append("<a href=\"<?php echo $this->createUrl('/h5/notepad/index') ?>\" class='act-add-note1'></a>");
                    }else{
                      $(".cal-sj1 ul").html("");
                      $(".cal-sj1 ul").html("<a href=\"<?php echo $this->createUrl('/h5/notepad/index') ?>\" class='act-add-note'>点击添加今日记事</a>");
                       $(".cal-sj1 ul").next().remove();
                    }

                    //显示日历信息 模拟ajax

                    var json_data1 = result[0];

                    json_detail_data1 = json_data1;
                    if (json_detail_data1.status == 0) {

                        if (parseInt(json_detail_data1.result.day) == parseInt(day)) {

                            var html_temp1 = json_detail_data1.result.nongli;

                            $('.cal-addsj .ll').html(html_temp1);
                        }
                    }

                    //如果有活动
                    //if (this_elem.parent().hasClass("act")) {
                  

                    //接收ajax返回的活动数据
                    var json_data = result[2];

                    console.log(json_data);

                    json_detail_data = json_data;
                        
                    if (json_detail_data[0].code == 1) {
                        $(".cal-hd-list ul").html("");
                        for (var i = 0; i < json_detail_data.length; i++) {
                            var html_temp = '<li><div class="cal-hd-listdiv"> <i></i><span>'+json_detail_data[i].jointime+'&nbsp;</span><p>'+json_detail_data[i].type+'-'+json_detail_data[i].title+'</p> </div> </li>';
                            $(".cal-hd-list ul").append(html_temp);

                        }
                    }else{
                        var str= '<div class="nodata-div" style=" margin: 20px;text-align: center;">'+
            '<span><img style="width: 40%;"  src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-info.png"/></span>'+
            '<p style="color: #666;margin-top: 10px;">暂无活动记录</p>'+
        '</div>';
         $(".cal-hd-list ul").html("");
         $(".cal-hd-list ul").html(str);
                    }


                    //  }


                }
            });

        }

    });
</script>

</body>
</html>
<?php exit();?>