<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="楚蓄罐" />
    <meta name="description" content="楚蓄罐" />
    <title>楚蓄罐-日历</title>
    <link rel="stylesheet" type="text/css" href="/assets/calendar/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/calendar/css/mui.picker.min.css" />

</head>
<body style="background: #F2F2F2;overflow: hidden;">

<div class="cal-main">

    <!--<div class="cal-head clearfix">
        <a class="lefta fl" href="javascript:history.back();void(0)">记事</a>
    </div>-->
    <!--head end-->

    <form >

        <div class="cal-reg-form">
            <div class="cal-reg-txt pd20">
                <textarea name="Remindtxt" id="Remindtxt" placeholder="请输入记事标题" rows="" cols=""></textarea>
            </div>


            <div class="cal-reg-sel clearfix pd20 btn" data-options='{}'>
                <span class="fl">时间</span>
            		<span class="fr" id="result">
            			07月20日  <i>15:58</i>
            		</span>
                <input type="hidden" name="Remindtime" id="Remindtime" value="" />
            </div>

         <!--   <div class="cal-reg-sel clearfix pd20">
                <span class="fl">提醒设置</span>
                <span class="fr">不提醒</span>
                <input type="hidden" name="Remindnum" id="Remindnum" value="1" />
            </div>-->





            <!--<div class="cal-reg-sel clearfix pd20">
                <span class="fl">重复</span>
                <span class="fr">
                    按年重复(公历)
                </span>
                <input type="hidden" name="Remindonoff" id="Remindonoff" value="" />
            </div>-->



        </div>


        <div class="cal-reg-btn">
            <input type="button" onclick="checkform()" value="保存" />
        </div>

    </form>
    <!--all end-->

</div>

<div id="popdiv1" class="cal-popdiv cal-popdiv1">
    <div class="btn1 clearfix">
        <span onclick="closethis(this)" class="fl">取消</span>
        <span id="confirm1" onclick="closethis(this)" class="fr">确定</span>
    </div>
    <div class="cal-popdiv1-list cal-popdiv1-list1">
        <ul>
            <li class="selected tl">
                <i><input type="radio" id="set1" name="selectkind"  value="1" />
                    <label for="set1"><b>不提醒</b></label></i></li>
            <li><i><input type="radio" id="set2" name="selectkind"  value="2" />
                    <label for="set2"><b>正点提醒</b></label></i></li>
            <li class="tr"><i><input type="radio" id="set3" name="selectkind"  value="3" />
                    <label for="set3"><b>提前十五分钟</b></label></i></li>
            <li class="tl"><i><input type="radio" id="set4" name="selectkind"  value="4" />
                    <label for="set4"><b>提前三十分钟</b></label></i></li>
            <li><i><input type="radio" id="set5" name="selectkind"  value="5" />
                    <label for="set5"><b>提前1小时</b></label></i></li>
            <li class="tr"><i><input type="radio" id="set6" name="selectkind"  value="6" />
                    <label for="set6"><b>提前1天</b></label></i></li>
            <li class="tl"><i><input type="radio" id="set7" name="selectkind"  value="7" />
                    <label for="set7"><b>提前2天</b></label></i></li>
            <li><i><input type="radio" id="set8" name="selectkind"  value="8" />
                    <label for="set8"><b>提前3天</b></label></i></li>
            <li class="tr"><i><input type="radio" id="set9" name="selectkind"  value="9" />
                    <label for="set9"><b>提前一周</b></label></i></li>
        </ul>
    </div>
</div>

<!--<div id="popdiv2" class="cal-popdiv cal-popdiv2">
    <div class="btn1 clearfix">
        <span onclick="closethis(this)" class="fl">取消</span>
        <span id="confirm1" onclick="closethis(this)" class="fr">确定</span>
    </div>
    <div class="cal-popdiv1-list cal-popdiv1-list2">

   <ul>
        <li class="selected">
            <i><input type="radio" id="set10" name="selectrep"  value="1" />
            <label for="set10"><b>重复</b></label></i></li>
        <li><i><input type="radio" id="set11" name="selectrep"  value="2" />
            <label for="set11"><b>不重复</b></label></i></li>
            </ul>
        </div>
</div>
-->

<div class="cal-mask">
    <div class="cal-mask-con" id="regtips">
         		<span class="img">
         			<img src="/assets/calendar/images/cal-error-icon.png"/>
         		</span>
        <p>提示文字</p>
    </div>
</div>




<script src="/assets/calendar/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/calendar/js/mui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/assets/calendar/js/mui.picker.min.js" type="text/javascript" charset="utf-8"></script>
<script>
    (function($) {
        $.init();
        var result = $('#result')[0];
        var ret=$("#Remindtime")[0];
        var btns = $('.btn');
        btns.each(function(i, btn) {
            btn.addEventListener('tap', function() {
                var optionsJson = this.getAttribute('data-options') || '{}';
                var options = JSON.parse(optionsJson);
                var id = this.getAttribute('id');
                var picker = new $.DtPicker(options);
                picker.show(function(rs) {
                    result.innerHTML = rs.y.value+"年"+rs.m.value+"月"+rs.d.value+"日"+"<i>"+rs.h.value+":"+rs.i.value+"</i>";
                    ret.value=rs.y.value+"/"+rs.m.value+"/"+rs.d.value+"/"+rs.h.value+":"+rs.i.value;
                    picker.dispose();
                });
            }, false);
        });
    })(mui);
</script>

<script type="text/javascript">
    function closethis(a) {
        $(".cal-reg-sel").eq(1).removeClass("selected"), $(".cal-reg-sel").eq(2).removeClass("selected"), $(".cal-popdiv").css({
            bottom: "-100%"
        })
    }

    function showtips() {
        $(".cal-mask").css({
            "z-index": "999",
            opacity: "1"
        }).children(".cal-mask-con").css({
            top: "50%"
        }), setTimeout(function() {
            $(".cal-mask").css({
                "z-index": "-10",
                opacity: "0"
            }).children(".cal-mask-con").css({
                top: "-50%"
            })
        }, 2000)

      // location.href="<?php echo $this->createUrl('/h5/calendar/index')?>";
    }

    function checkform() {
        var a = $("#Remindtxt").val(),//记事标题
            b = $("#Remindtime").val(),//提醒时间
          //  c = $("#Remindnum").val(),//提醒设置
            d = $("#regtips");
        return "" == a || "" == b ? (d.html("请选择或填写信息！"), showtips(), !1) : void $.ajax({
            type: "post",
            cache: !1,
            async: !1,
            data: {
                rtxtval: a,
                rtimeval: b,
              //  rnumval: c
            },
            url: "<?php echo $this->createUrl('/h5/notepad/from')?>",
            dataType: "json",

            success: function(a) {
                alert("提交成功");
                location.href="<?php echo $this->createUrl('/h5/calendar/index')?>";
             //   $("#loadingdiv").hide(), 1 == a ? (d.html('<span class="img"><img src="/assets/calendar/images/cal-right-icon.png"/></span><p>提交成功</p>'), showtips()): (d.html('<span class="img"><img src="/assets/calendar/images/cal-error-icon.png"/></span><p>提交失败，再试一次吧</p>'), showtips())

            },
            error: function(a, b, c) {
                alert("提交失败");
               // $("#loadingdiv").hide(), d.html('<span class="img"><img src="/assets/calendar/images/cal-error-icon.png"/></span><p>网络异常</p>'), showtips()
            }
        })
    }

    function touchb() {
        return !1
    }! function(a) {
        var b = a(".cal-reg-sel");
        b.click(function() {
            b.removeClass("selected"), a(this).addClass("selected")
        }), a(".cal-reg-sel").eq(0).click(function() {
            a(".cal-popdiv").css({
                bottom: "-100%"
            })
        }), a(".cal-reg-sel").eq(1).click(function() {
            a(".cal-popdiv").css({
                bottom: "-100%"
            }), a("#popdiv1").css({
                bottom: "0"
            }), a(".mui-dtpicker").removeClass("mui-active")
        }), a(".cal-reg-sel").eq(2).click(function() {
            a(".cal-popdiv").css({
                bottom: "-100%"
            }), a("#popdiv2").css({
                bottom: "0"
            }), a(".mui-dtpicker").removeClass("mui-active")
        });
        var c = new Date;
        $('#Remindtime').val(c.getFullYear() + "/" + (c.getMonth() + 1) + "/" + c.getDate() + "/&nbsp;&nbsp;<i>" + c.getHours() + ":" + c.getMinutes() + "</i>");
        a("#result").html(c.getFullYear() + "\u5e74" + (c.getMonth() + 1) + "\u6708" + c.getDate() + "\u65e5&nbsp;&nbsp;<i>" + c.getHours() + ":" + c.getMinutes() + "</i>"), a(".cal-popdiv1-list1 ul li").click(function(b) {
            a(this).addClass("selected").siblings().removeClass("selected");
            for (var c = a(".cal-popdiv1-list1 ul li input"), d = a(".cal-popdiv1-list1 ul li input").length, e = 0; d > e; e++)
                if (c[e].checked) {
                    a("#Remindnum").val(c[e].value);
                    var f = a(".cal-popdiv1-list1 ul li").eq(e).find("b").html();
                    a("#Remindnum").prev().html(f)
                }
        }), a(".cal-popdiv1 span:nth-of-type(1)").click(function() {
            a("#Remindnum").val(""), a("#Remindnum").prev().html("")
        }), a(".cal-popdiv1 span:nth-of-type(2)").click(function() {
            for (var b = a(".cal-popdiv1-list1 ul li input"), c = a(".cal-popdiv1-list1 ul li input").length, d = 0; c > d; d++)
                if (b[d].checked) {
                    a("#Remindnum").val(b[d].value);
                    var e = a(".cal-popdiv1-list1 ul li").eq(d).find("b").html();
                    a("#Remindnum").prev().html(e)
                }
        })
    }(jQuery), $(".cal-reg-txt textarea").focus(function() {
        $(".mui-dtpicker").removeClass("mui-active"), $(".cal-popdiv").css({
            bottom: "-100%"
        }), $(".cal-reg-sel").removeClass("selected")
    }), document.addEventListener("touchstart", touchb, !1);



</script>

</body>
</html>
