// JavaScript Document 
$(function () {
	$("#zl").height($(window).height());
    window.requestAnimFrame = (function (globedy) {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback) {
            window.setTimeout(callback, 1000 / 60)
        }
    })();
    var totalDeg = 360 * 3 + 0;
    var steps = [];
	var jiangnum=globedy.jiangnum;
	var lostDeg,prizeDeg;
	switch(jiangnum)
{
case 1:
   lostDeg = [36, 96, 156, 216, 276, 336, 126, 246, 66, 186, 306];
     prizeDeg = [6];
  break;
case 2:
   lostDeg = [36, 96, 156, 216, 276, 336, 246, 66, 186, 306];
     prizeDeg = [6, 126];
  break;
  case 3:
  lostDeg = [36, 96, 156, 216, 276, 336, 66, 186, 306];
     prizeDeg = [6, 126, 246];
  break;
  case 4:
  lostDeg = [36, 96, 156, 216, 276, 336, 186, 306];
     prizeDeg = [6, 126, 246, 66];
  break;
  case 5:
   lostDeg = [36, 96, 156, 216, 276, 336, 306];
     prizeDeg = [6, 126, 246, 66, 186];
  break;
  case 6:
   lostDeg = [36, 96, 156, 216, 276, 336];
     prizeDeg = [6, 126, 246, 66, 186, 306];
  break;
default:
  lostDeg = [36, 96, 156, 216, 276, 336, 126, 246, 66, 186, 306];
     prizeDeg = [6];
}


      //中奖度数，对应1~6等奖
    var prize, sncode,statue,code,Mcount;
    var count = 0;
    var now = 0;
    var a = 0.01;
    var outter, inner, timer, running = false;
 
    function countSteps() {
        var t = Math.sqrt(2 * totalDeg / a);
        var v = a * t;
        for (var i = 0; i < t; i++) {
            steps.push((2 * v * i - a * i * i) / 2)
        }
        steps.push(totalDeg)
    }
 
    function step() {
        outter.style.webkitTransform = 'rotate(' + steps[now++] + 'deg)';
        outter.style.MozTransform = 'rotate(' + steps[now++] + 'deg)';
        if (now < steps.length) {
            requestAnimFrame(step)
        } else {
            running = false;
            setTimeout(function () {
                if (prize != null) {
 
 
                    switch (prize) {
                    case 1:
                        type = "一等奖"
                        break;
                    case 2:
                        type = "二等奖"
                        break;
                    case 3:
                        type = "三等奖"
                        break;
                    case 4:
                        type = "四等奖"
                        break;
                    case 5:
                        type = "五等奖"
                        break;
                    case 6:
                        type = "六等奖"
                        break;
                    default:
                        type = "未中奖"
                    }
 
 $("#zjiang").show();
 
                    $("#prizeText").text(prize);
                  //  $("#result").slideToggle(500);
                  //   $("#outercont").slideUp(500)
                    if(statue==0){
                        // $("#prize_layer_wrap p").text('很遗憾你没有中奖！您还有'+Mcount+'次刮卡机会！');
                        layer.alert('很遗憾你没有中奖！您还有'+Mcount+'次中奖机会！', {icon: 5},function(){
                                    window.location.reload();
                                });
                    }
                    if(statue==1){
                        // $("#prize_layer_wrap p").text('恭喜您，中得 "'+prize+'" 领奖码"'+code+'" 您还有'+Mcount+'次中奖机会！');
                         layer.alert('恭喜您，中得 "'+prize+'" 领奖码"'+code+'" 您还有'+Mcount+'次中奖机会！', {icon: 6},function(){
                                    window.location.reload();
                                });
                    }
                    // $("#prize_layer_wrap").show();
                }
                flags = 0;
            }, 200)
        }
    }
 
    function start(deg) {

        deg = deg || lostDeg[parseInt(lostDeg.length * Math.random())];
        // console.log(lostDeg.length );
        // console.log(Math.random());
        // console.log(lostDeg);
        //
        // console.log(deg);
        running = true;
        clearInterval(timer);
        totalDeg = 360 * 5 + deg;
        steps = [];
        now = 0;
        countSteps();
        requestAnimFrame(step)
    }
    window.start = start;
    outter = document.getElementById('outer');
    inner = document.getElementById('inner');
    i = 10;

    //点击关闭
    $("#make_sure").on('click', function(){
        window.location.reload();
    })
    flags = 0;
    $("#inner").click(function () {
        if(flags==1){
            return false;
        }
        if (running) return;
        if(time<startTime){
            layer.alert('亲！活动尚未开始!', {icon: 5});
            return false;
        }
        if(time>endTime){
             layer.alert('亲！活动已结束', {icon: 5});
            return false;
        }
        flags=1;
        if (count >= Maxcount) {
            flags = 0;
             layer.alert('您已经抽了'+ day_count +'次奖。', {icon: 5});
            return false;
        }

        // if (prize != null) {
        //     alert("亲，你不能再参加本次活动了喔！下次再来吧~");
        //     return
        // }
        $.ajax({
            url: url,
            dataType: "json",
            data: data,
            beforeSend: function () {
                running = true;
                timer = setInterval(function () {
                    i += 5;
                    outter.style.webkitTransform = 'rotate(' + i + 'deg)';
                    outter.style.MozTransform = 'rotate(' + i + 'deg)'
                }, 1)
            },
            success: function (data) {
                console.log(data);

                if(data.msg=='一等奖'){
                    prize=1;
                    start(prizeDeg[1 - 1]);
                }else if(data.msg=='二等奖'){
                    prize=2;
                    start(prizeDeg[2 - 1]);
                }else if(data.msg=='三等奖'){
                    prize=3;
                    start(prizeDeg[3 - 1]);
                }else if(data.msg=='四等奖'){
                    prize=4;
                    start(prizeDeg[4 - 1]);
                }else if(data.msg=='五等奖'){
                    console.log('五等奖aaaaaaaa');
                    prize=5;
                    start(prizeDeg[5 - 1]);
                }else if(data.msg=='六等奖'){
                    prize=6;
                    start(prizeDeg[6 - 1]);
                }else{
                    // prize=null;
                    start();
                }

                prize = data.msg;
                statue=data.statue;
                Mcount=Maxcount-1;

                // prize =1;
                // sncode = data.sn;
                // start(prizeDeg[1 - 1])
                running = false;
                count++;
                //
                if(data.statue==1){
                    code=data.code;
                //     $("#prizeText").text(data.msg);
                //     $("#prize_layer_wrap p").text('恭喜您，中得 "'+data.msg+'" 领奖码"'+data.code+'" 您还有'+(Maxcount-1)+'次刮卡机会！');
                //     $("#prize_layer_wrap").show();
                //
                }
                // if(data.statue==0){
                //     $("#prizeText").text(data.msg);
                //     $("#prize_layer_wrap p").text('很遗憾你没有中奖！您还有'+(Maxcount-1)+'次刮卡机会！');
                //     $("#prize_layer_wrap").show();
                //
                // }
            },
            error: function () {
		//		prize = 3;
 //start(prizeDeg[3 - 1]);
				
             prize = null;
             start();
				
                running = false;
                count++
            },
            timeout: 4000
        })
    })
});

//中奖列表
$("#myPrizeRecord").on('click', function() {
    $.post(url2,data ,function(data){
        var data = JSON.parse(data);
        $(".zj-listdiv").show();
        $('#sss').html('');
        var _li = '';
        if(data.code == 1){
            for(var i in data.msg){
                _li+= '<li >'+data.msg[i].title+'</li><li>'+data.msg[i].code+'</li>';
            }
        }else{
            _li = '<li>无中奖记录</li>';
        }
        $('#sss').append(_li);
        $(".zj-listdiv").show();
    });
});
$(".zj-listdiv").on('click', function() {
    $(this).hide();
});

$("#save-btn").bind("click", function () {
    var btn = $(this);
    var tel = $("#tel").val();
    if (tel == '') {
        alert("请输入手机号码");
        return
    }
    var regu = /^[1][0-9]{10}$/;
    var re = new RegExp(regu);
    if (!re.test(tel)) {
        alert("请输入正确手机号码");
        return
    }
    var submitData = {
        tid: 5,
        //     code: $("#sncode").text(),
        tel: tel,
        action: "setTel"
    };
    $.post('index.php?ac=activityuser', submitData, function (data) {
		
        if (data.success == true) {
            alert("提交成功，谢谢您的参与");
			$("#result,#zl").hide();
            return
        } else {}
    }, "json")
});