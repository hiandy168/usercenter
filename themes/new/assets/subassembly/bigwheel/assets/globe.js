function zxb(globedy) {
   wxData.imgUrl = globedy.imgUrl || {}; //分享图片
   wxData.link = globedy.wxlink || {}; //分享url
   wxData.desc = globedy.wxdesc || {}; //分享描述
   wxData.title = globedy.wxtitle || {}; //分享标题
	
    var zpbg;
    var jiangnum = globedy.jiangnum || {};
    var resultshow = globedy.resultshow || {};
    if (resultshow == 1) {
        $("#result,#zl").show();
    } else {
        $("#result,#zl").hide();
    }
    switch (jiangnum) {
    case 1:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-1.png"
        break;
    case 2:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-2.png"
        break;
    case 3:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-3.png";
        break;
    case 4:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-4.png"
        break;
    case 5:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-5.png"
        break;
    case 6:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-6.png"
        break;
    default:
        zpbg = globedy && globedy.zimg ? globedy.zimg :"/statics/activity/turn/default/images/activity-lottery-1.png"
    }
 
    $("#outer img").attr("src", zpbg); //转盘地址
    var htmlzxb = "";
	var innerimg = globedy && globedy.innerimg ? globedy.innerimg : "http://mat1.gtimg.com/hb/00000011/activity-lottery.png";
    var globedy = globedy || {};
    var bgcolor = globedy && globedy.bgcolor ? globedy.bgcolor : "#c0c0c0";
    var sming = globedy.sming || "活动木有说明";
    var myjiangp = globedy.myjiangp || "木有中奖";
    $(".activity-lottery-winning").css({
        "backgroundimage": "url(" + globedy.bgimage + ")",
        "background-color": globedy.bgcolor
    });
    //  var thiszxb=zxb(this);
 
    $("#sming").html(sming);
    $("#myjiangp").html(myjiangp);
	$("#inner img").attr("src",innerimg);
    $.each(globedy.jiangp, function (key, val) {
        if (val['jiangpcs'] > 0 && val['jiangpname'] != "") {
            htmlzxb = htmlzxb + "<p>" + val['jiangpname'] + "，奖品数量：" + val['jiangpcs'] + "</p>";
        }
 
        if (key > 5) {
            htmlzxb = "奖品种类超过转盘容纳量。";
        }
 
    });
 
    $("#jiangp").html(htmlzxb);
 
 
    //alert(bgcolor);
 
}
	// JavaScript Document