<?php echo $this->renderpartial('/common/header',$config); ?>
<div id="calendar" class="calendar">
        <div class="title">
            <div class="prev"></div>
            <div class="next"></div>
            <div class="show_date"></div>
        </div>
        <div class="week_day">
            <div class="day">日</div>
            <div class="day">一</div>
            <div class="day">二</div>
            <div class="day">三</div>
            <div class="day">四</div>
            <div class="day">五</div>
            <div class="day">六</div>
        </div>
        <div class="calendar_content border_box clearfix">
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
            <div class="day"></div>
        </div>
    </div>
    <div class="event_wrap border_box">
        <!--<div class="event">-->
        <!--<div class="title">-->
        <!--2016/03/04-->
        <!--</div>-->
        <!--<div class="content">-->
        <!--<div class="img">-->
        <!--<img src="./images/3.jpg" alt="" width="100%" height="100%">-->
        <!--</div>-->
        <!--<div class="co web_flex_1">-->
        <!--<div class="p1">上海-毛里求斯 7天5晚自由行 ）</div>-->
        <!--<div class="p2">上海-毛里求斯 7天5晚自由行 ）</div>-->
        <!--</div>-->
        <!--</div>-->
        <!--</div>-->
    </div>
    <div class="tips_layer_wrap">
        <div class="tips_layer"></div>
    </div>
    <script type="text/javascript">
    /**
     * 消息通知
     * @param  {string} content 内容
     * @param  {int} time    时间，默认2秒
     */
    function showTips(content, time) {
        if (arguments.length < 1) {
            alert("缺少参数");
            return false;
        }

        var time;

        if (arguments.length < 2) {
            time = time || 2000;
        }

        $(".tips_layer_wrap").find('.tips_layer').text(content);
        $(".tips_layer_wrap").show();

        setTimeout(function() {
            $(".tips_layer_wrap").fadeOut();
        }, time);
    }
    </script>
    <script>
    ;
    (function($, window, document, undefined) {
        //定义Calendar的构造函数
        var Calendar = function(ele, opt) {
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
                    "calendarContent": this.$element.find('.calendar_content .day'),
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
                init: function() {
                    this.createCalendar(this.year, this.month);
                    if ($.isFunction(this.options.changeMonth)) {
                        this.options.changeMonth(this.year, this.month, this.calendarContent);
                    }
                },
                //获取每月天数
                getDaysInOneMonth: function(year, month) {
                    var month = parseInt(month);
                    var year = parseInt(year);
                    var date = new Date(year, month, 0);
                    return date.getDate();
                },
                //获取每月1日的星期
                getFirstDayWeekOfMonth: function(year, month) {
                    var year = parseInt(year);
                    var month = parseInt(month);
                    var day = 1;
                    var date = new Date(this.year, month, day);

                    return date.getDay();
                },
                //创建日历
                createCalendar: function(year, month) {

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

                        this.calendarContent.eq(i).html("<span>" + daysArray[i] + "</span>");
                        if ($.isNumeric(i)) {
                            if (this.isSameDay(new Date(this.year, this.month - 1, i), new Date())) {
                                var temp = '<div class="today border_box"></div>';
                                this.calendarContent.eq(i - 1).append(temp);
                            }
                        } else {
                            this.calendarContent.eq(i).removeClass("day");
                        }
                    }

                    this.dayClcik();
					
					var today = (new Date()).getMonth() + 1;
					var year = (new Date()).getFullYear();
	
					if(today <= this.month && this.year >= year) {
						this.options.nextMonth.hide();
					} else {
						this.options.nextMonth.show();
					}
                },
                //日期点击事件
                dayClcik: function() {
                    var self = this;

                    this.calendarContent.on("click", function() {
                        var day = $(this).find('span').text();

                        $.isFunction(self.clickDay) && self.clickDay(self.year, self.month, day, $(this), self.calendarContent);
                    });
                },
                //上个月
                prevClick: function() {
                    var self = this;

                    this.options.prevMonth.on("click", function() {
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
                nextClick: function() {
                    var self = this;

                    this.options.nextMonth.on("click", function() {
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
                isSameDay: function(d1, d2) {
                    return (d1.getFullYear() == d2.getFullYear() && d1.getMonth() == d2.getMonth() && d1.getDate() == d2.getDate());
                }
            }
            //calendar
        $.fn.calendar = function(options) {
            //创建Beautifier的实体
            var calendar = new Calendar(this, options);
            //调用其方法
            return calendar;
        }
    })(jQuery, window, document);

    //     日期格式:2016-5-12
    //    每月活动,点json格式
    //    有活动:
    //    {
    //        "code": 1, "event": [1, 3, 5, 7, 9]
    //    }
    //
    //    没活动:
    //    {
    //        "code": 0, "event": []
    //    }
    //活动详情
    //有活动详情
    //    {
    //        "code": 1,
    //            "event": [
    //        {"eventDay": 1, "title": "2016年5月12日", "icon": "./images/xxx.png", "title1": "上海你好呀", "title2": "上海你好呀"},
    //        {"eventDay": 3, "title": "2016年5月12日", "icon": "./images/xxx.png", "title1": "上海你好呀", "title2": "上海你好呀"},
    //        {"eventDay": 5, "title": "2016年5月12日", "icon": "./images/xxx.png", "title1": "上海你好呀", "title2": "上海你好呀"},
    //        {"eventDay": 7, "title": "2016年5月12日", "icon": "./images/xxx.png", "title1": "上海你好呀", "title2": "上海你好呀"},
    //        {"eventDay": 9, "title": "2016年5月12日", "icon": "./images/xxx.png", "title1": "上海你好呀", "title2": "上海你好呀"},
    //    ]
    //    }
    //无活动详情
    //    {
    //        "code": 0,
    //            "event": [
    //    ]
    //    }

    var json_detail_data = "";

    $("body").calendar({
        "changeMonth": function(year, month, all_elem) {

            json_detail_data = "";
            all_elem.removeClass("event_day");
            $(".event_wrap").find(".event").remove();
			
			console.log(year + '-' + month + '-' + '10');

            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "<?php echo $this->createUrl('/h5/member/calendar',array('openid'=>$openid,'appid'=>$appid,'appkey'=>$appkey))?>",
		data: 'eventTime=' + year + '-' + month + '-' + '10',
                dataType: 'json',
                success: function(json_data) {
                    if (json_data.code == 1) {
                        var event_day = json_data.list;
                        json_detail_data = json_data;


                        for (var i = 0; i < event_day.length; i++) {
                            for (var n = 0; n < all_elem.size(); n++) {
                                if (parseInt(event_day[i].eventDay) == parseInt(all_elem.eq(n).find("span").text())) {
                                    all_elem.eq(n).addClass("event_day");

                                }
                            }
                        }
                    } else {
                        //showTips("无事件");
                    }
                }
            });
        },
        "setEventDay": function(all_day) {

        },
        "clickDay": function(year, month, day, this_elem, all_this_elem) {
			
			$(".event_wrap").find(".event").remove();
            if (this_elem.text().length == 0) return;
            all_this_elem.find(".select_day").remove();
            var temp = '<div class="select_day">' + this_elem.find('span').text() + '</div>';
            this_elem.append(temp);


            //如果有活动
            if (this_elem.hasClass("event_day")) {
                $(".event_wrap").find(".event").remove();
                
                if (json_detail_data.code == 1) {
                    for (var i = 0; i < json_detail_data.list.length; i++) {
                        if (parseInt(json_detail_data.list[i].eventDay) == parseInt(day)) {
                            var html_temp = '<div class="event"><div class="title">' + json_detail_data.list[i].title + '</div><div class="content"><div class="img"><img src="' + json_detail_data.list[i].icon + '" alt="" width="100%" height="100%"> </div> <div class="co web_flex_1"><div class="p1">' + json_detail_data.list[i].title + '</div> <div class="p2">' + json_detail_data.list[i].remark + '</div></div></div></div>';
                            $(".event_wrap").append(html_temp);
                        }
                    }
                } else {
                    showTips("无");
                }
            }


        }
    });
    </script>
</body>

</html>
