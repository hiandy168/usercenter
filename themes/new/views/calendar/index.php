<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no" />
        <meta name="Keywords" content="<?php echo $project['name']?>" />
        <meta name="description" content="<?php echo $project['name']?>" />
        <title><?php echo $project['name']?>-日历</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>Calendar/css/style.css"/>
	</head>
	<body>
		
		<div class="cal-main">
		
             <div class="cal-head clearfix">
             	<a class="lefta fl" href="">家庭日历</a>
             </div>
             <!--head end-->
             
             <div class="cal-mid" id="calendar">
 	
             	<div class="cal-mid1">
             		<span class="prev"></span>
             		<span class="show_date">2016年7月</span>
             		<span class="next"></span>
             		<i class="cal-add-note"></i>
             	</div>
             	
             	<!--cal-mid1 end-->
             	<div class="cal-mid2">
             	
                 <div class="cal-mid2-1">
                 	<table border="0" cellspacing="0" cellpadding="0">
                 		<tr><td>日</td><td>一</td><td>二</td><td>三</td><td>四</td><td>五</td><td>六</td></tr>
                 		
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		<tr><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td><td><i></i></td></tr>
                 		
                 
                 	</table>
                 </div>
             	
             	<div class="cal-downup-icpn">
             		<img class="img iconup" src="<?php echo $this->_theme_url?>Calendar/images/cal-dwonup-icon.png"/>
             	</div>
             	
             	
             	</div>
             	
             	<!--cal-mid2 end-->
             </div>
             
             
             <div class="cal-sj pd20">
             	<h3>今晚6点开会</h3>
             	<span>
             		<i class="cal-icon icon-day"></i>
             		16:30
             	</span>
             </div>
             
             <div class="cal-date pd20">
             	<div class="cal-date1 clearfix">
             		<span>
             		<i>一</i>
             		<i>二</i>
             		</span>
             		<span>
             			<em>
             			<i>丙申猴年 五月qqq</i>
             			<i>甲午月 甲申日ss</i>
             			</em>
             		</span>
             		<span>
             			<i>建党节qq</i>
             		</span>
             	</div>
             	<div class="cal-date2">
             		<span>
             			<i class="cal-icon icon-yi"></i>
             			<em>结婚 开光 出行qq</em>
             		</span>
             		<span>
             			<i class="cal-icon icon-ji"></i>
             			<em>结婚 开光 出行qq</em>
             		</span>
             	</div>
             </div>
             
             <div class="cal-addsj">
             	<h3 class="cal-tit pd20">07月01日2 周五s</h3>
             	<a href="<?php echo $this->createUrl('/Calendar/reg',array('pid'=>$project['id'],'userid'=>$userid,'openid'=>$openid))?>" class="pd20">
             		<i class="cal-icon icon-add"></i>
             		添加记事
             	</a>
             </div>
             
          
             <div class="cal-datejr">
             	<h3 class="cal-tit pd20">07月02日 c周六</h3>
             	<div class="cal-datejr1 pd20 clearfix">
             		<span>12:00</span>
             		<span>
             			<em>
             			<p>中国无烟日</p>
             			<i>距今天还有1天</i>
             			</em>
             		</span>
             		<i class="cal-icon icon-tx"></i>
             	</div>
             </div>
             
             <div class="cal-act">
             	
             	<div class="cal-act-tit clearfix">
             		<h3 class="fl">我的活动</h3>
              <a href="" class="fr">查看全部></a>
             	</div>
              
              <div class="cal-act-list">
              	<ul>  		
              		
              		<a href="">
              			<li>
              			<div class="cal-act-con">
              				<span>
              				<img src="<?php echo $this->_theme_url?>Calendar/images/test.jpg"/>
              			</span>
              			<span>
              		    <h3>上海-毛里求斯 7天5晚自由行 （往返含税机票+三星酒店5晚含早）</h3>
                        <h4>华东福利，上海往返单机票好价。</h4>
              			</span>
              			<span>
              				<i>抢</i>
              				<em>18000关注</em>
              			</span>
              			</div>
              		</li>
              		</a>
              		
              		<a href="">
              			<li>
              			<div class="cal-act-con">
              				<span>
              				<img src="<?php echo $this->_theme_url?>Calendar/images/test.jpg"/>
              			</span>
              			<span>
              				<h3>上海-毛里求斯 7天5晚自由行 （往
返含税机票+三星酒</h3>
                        <h4>华东福利，上海往返单机票好价。</h4>
              			</span>
              			<span>
              				<i>抢</i>
              				<em>18000关注</em>
              			</span>
              			</div>
              		</li>
              		</a>
              	
              	</ul>

              </div>
              
             </div>
             
             
        <!--all end-->         
        </div>
             
             
             
         <script src="<?php echo $this->_theme_url?>Calendar/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>    
		<script type="text/javascript">
			(function($){
				$(".cal-downup-icpn").click(function(){
					if($(this).find("img").hasClass("iconup")){
						$(this).find("img").removeClass("iconup");
						$(".cal-mid2-1").addClass("cal-mid2-1up");
						$(".cal-addsj,.cal-datejr").hide();
					}else{
                        $(this).find("img").addClass("iconup");
                        $(".cal-mid2-1").removeClass("cal-mid2-1up");
                        $(".cal-addsj,.cal-datejr").show();
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
        //Calendar
        Calendar.prototype = {
            init: function () {
                this.createCalendar(this.year, this.month);
                if ($.isFunction(this.options.changeMonth)) {
                    this.options.changeMonth(this.year, this.month, this.calendarContent);
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
                var firstDay = this.getFirstDayWeekOfMonth(year, month - 1);
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
                        	
                        	if(firstDay==7){
                        		var ss=i+0
                        	}else if(firstDay<=6){
                        		var ss=firstDay+i-1;
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

//              if(today <= this.month && this.year >= year) {
//                  this.options.nextMonth.hide();
//              } else {
//                  this.options.nextMonth.show();
//              }
                
//              console.log(year + '===' + this.year);
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
                        self.options.changeMonth(self.year, self.month, self.calendarContent);
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
                        self.options.changeMonth(self.year, self.month, self.calendarContent);
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
     	"changeMonth": function (year, month, all_elem) {
     		
//   	  	all_elem.parent().removeClass("thisday selected");
     	  	
     	  	   //模拟ajax开始
                    var string = '{"code": 1, "event": [1,2,3]}';
                    //var string1 = '{"code1": 1, "thisday": [1,2,3,5]}';
                    //var json_data1=eval("(" + string1 + ")");
                    var json_data = eval("(" + string + ")");
                    //console.log(json_data1);
//                  $.ajax({
//                      type: "GET",
//                      contentType: "application/json",
//                      url: "test.php",
//                      dataType: 'json',
//                      success: function (result) {
//                          console.log(result);
//                      }
//                  });
//                  return false;
                    if (json_data.code == 1) {
                        var event_day = json_data.event; 
                        for (var i = 0; i < event_day.length; i++) {
                        	
                            for (var n = 0; n < all_elem.size(); n++) {
                            	
                                if ((event_day[i]) == (all_elem.eq(n).parent().find("i").text())) {
                                	
                                    all_elem.eq(n).parent().addClass("act");
                                    
                                }
                            }
                        }
                    } else {
                        showTips("无事件");
                    }
                    
     	  	
     	},
     	
     	
 "clickDay": function (year, month, day, this_elem, all_this_elem) {
 	
                    all_this_elem.parent().removeClass("selected");
                    this_elem.parent().addClass("selected");
                    $(".cal-date").find("div").remove();
                   
                    //显示日历信息 模拟ajax
                    var string1='{"code1": 1,"thisday":[{"dayinfo":2,"title3": "0","title4": "2","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开光DSA 出行","title9": "结婚 出行"},{"dayinfo":3,"title3": "0","title4": "3","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开光 出行","title9": "结婚 开光 出行"},{"dayinfo":4,"title3": "0","title4": "4","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开DSA光 出行","title9": "结婚 开光大S 出行"},{"dayinfo":5,"title3": "0","title4": "5","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开光 出行","title9": "结婚 开光 出行"},{"dayinfo":6,"title3": "0","title4": "6","title5": "丙申猴年 七的撒旦月","title6": "甲午月 甲大声道申日","title7": "建党节","title8": "结婚 开光 出大S行","title9": "结婚 开光 出行"},{"dayinfo":7,"title3": "0","title4": "7","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开光 出行","title9": "结婚 开光 出行"},{"dayinfo":8,"title3": "0","title4": "8","title5": "丙申猴年 七月","title6": "甲午月 甲申日","title7": "建党节","title8": "结婚 开光 出DSA行","title9": "结婚 开光 出行"}]}';
                    var json_data1 = eval("(" + string1 + ")");
                    
                    console.log(json_data1);
                    
                    json_detail_data1 = json_data1;
                    
                     if (json_detail_data1.code1 == 1) {
                      
                         for (var i = 0; i < json_detail_data1.thisday.length; i++) {

                                if (parseInt(json_detail_data1.thisday[i].dayinfo) == parseInt(day)) {
                                	
                                    var html_temp1='<div class="cal-date1 clearfix"><span><i>'+json_detail_data1.thisday[i].title3+'</i><i>'+json_detail_data1.thisday[i].title4+'</i></span><span><em><i>'+json_detail_data1.thisday[i].title5+'</i><i>'+json_detail_data1.thisday[i].title6+'</i></em></span><span><i>'+json_detail_data1.thisday[i].title7+'</i></span></div><div class="cal-date2"><span><i class="cal-icon icon-yi"></i><em>'+json_detail_data1.thisday[i].title8+'</em></span><span><i class="cal-icon icon-ji"></i><em>'+json_detail_data1.thisday[i].title9+'</em></span></div>';
                                	$(".cal-date").append(html_temp1);
                               
                                }
                                
                              }  
                     }
                    
  
                    //如果有活动
                    if (this_elem.parent().hasClass("act")) {
                        $(".cal-act-list ul").find("a").remove();
                        
                        //模拟ajax
                        var string = '{"code": 1,"event": [{"eventDay": 1, "title": "活动主题", "icon": "./images/3.jpg", "title1": "活动标题", "title2": "1800关注"},{"eventDay": 5, "title": "活动主题", "icon": "./images/3.jpg", "title1": "活动标题", "title2": "18000关注"},{"eventDay": 5, "title": "活动主题2", "icon": "./images/3.jpg", "title1": "活动标题", "title2": "18000关注"}]}';
                        var json_data = eval("(" + string + ")");
                          
                        console.log(json_data);

                        json_detail_data = json_data;

                        if (json_detail_data.code == 1) {
                        	
                            for (var i = 0; i < json_detail_data.event.length; i++) {

                                if (parseInt(json_detail_data.event[i].eventDay) == parseInt(day)) {
                                	
                                	
                                    var html_temp = '<a href=""><li><div class="cal-act-con"><span><img src="'+json_detail_data.event[i].icon+'"/></span><span><h3>'+json_detail_data.event[i].title+'</h3><h4>'+ json_detail_data.event[i].title1+'</h4></span><span><i>抢</i><em>'+json_detail_data.event[i].title2+'</em></span></div></li></a>';
                                    
                                    $(".cal-act-list ul").append(html_temp);
                                     
                                }
                            }
                        } 
                        
                        
                    }


                }
            
     });
		</script>
		
	</body>
</html>
