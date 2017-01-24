function a() {
  return !1
}! function(n, e) {
  var t = n.documentElement,
    d = "orientationchange" in window ? "orientationchange" : "resize",
    i = function() {
      var n = t.clientWidth;
      n && (n < 750 || 750 == n ? t.style.fontSize = 1 * (n / 15) + "px" : t.style.fontSize = "50px")
    };
  n.addEventListener && (e.addEventListener(d, i, !1), n.addEventListener("DOMContentLoaded", i, !1))
}(document, window), document.addEventListener("touchstart", a, !1)

//banner
if ($(".f-index-banner").length) {
  var mySwiper1 = new Swiper('.f-index-banner', {
    autoplay: 5000,
    visibilityFullFit: true,
    loop: true,
    pagination: '.pagination'
  });
}

// topnav touch
$(".f-head-selectcitydiv").height("0");
$(".f-head-selectcity").on("click", function(e) {
  $(".f-head-selectcitydiv").height() == 0 ? $(".f-head-selectcitydiv").height("auto") : $(".f-head-selectcitydiv").height(0)
});
$(".f-head-selectcitydiv").on("touchstart", function(e) {
  (e || window.e).cancelBubble = true;
  return false
});
$(".f-head-selectcitydiv a,.f-head-selectcity").on("touchstart", function(e) {
  (e || window.e).stopPropagation()
});
$(document).on("touchstart", function() {
  $(".f-head-selectcitydiv").height("0")
});


// cpdetail tab
var cptabLi = $(".f-cpdetail-div6-nav li");
cptabLi.on("click", function() {
  cptabLi.removeClass("selected");
  $(this).addClass("selected");
  var i = $(this).index();
  $(".f-cpdetail-div6-tabcon").hide();
  $(".f-cpdetail-div6-tabcon").eq(i).show();
})

// cpdetail loadingmore
var cploadmoreBtn = $(".cpdetail-loadmore-btn");
cploadmoreBtn.on("click", function() {
  //  $(this).attr("disabled","true")
  var data1 = [{
    "uName": "夏",
    "uPhone": "168****2525",
    "uTime": "2015-11-05 21:00:12",
    "uMeony": "1000"
  }, {
    "uName": "夏",
    "uPhone": "168****2525",
    "uTime": "2015-11-05 21:00:12",
    "uMeony": "1000"
  }, {
    "uName": "夏",
    "uPhone": "168****2525",
    "uTime": "2015-11-05 21:00:12",
    "uMeony": "1000"
  }, {
    "uName": "夏",
    "uPhone": "168****2525",
    "uTime": "2015-11-05 21:00:12",
    "uMeony": "1000"
  }, {
    "uName": "夏",
    "uPhone": "168****2525",
    "uTime": "2015-11-05 21:00:12",
    "uMeony": "1000"
  }];
  var data = eval(data1);
  var html = "";
  for (var i = 0; i < data.length; i++) {
    html += '<li>';
    html += '<i>' + data[i].uName;
    html += ' (' + data[i].uPhone + ')</i>';
    html += '<i>' + data[i].uTime + '</i>';
    html += '<i>￥' + data[i].uMeony + '</i>';
    html += '</li>';
  }
  $(".f-cpdetail-tab-cyjl ul").append(html);
})

//form

var mask = $(".mask");
var dialpop = $(".dial-pop");
var in_txt = $(".dial-pop-txt h3");
var popshow = function(txt) {
  mask.show();
  dialpop.show();
  in_txt.html(txt);
}
var closepop = function() {
  mask.hide();
  dialpop.hide();
  in_txt.html("");
}

var v1 = $("#username"),
  v2 = $("#usertel"),
  v3 = $("#usercodeid");
var reg = /^1[3|5|7|8]\d{9}$/;
var num=0;
var checkform = function() {
    var money=$('#money').val();
  if (!v1.val()) {
    v1.parent().prev().show().addClass("icon-error");
    popshow("请填写姓名");
    return false;
  } else if (!v2.val() || !reg.test(v2.val())) {
    $(".f-form-inp i").hide().removeClass("icon-error");
    v2.parent().prev().show().addClass("icon-error");
    popshow("请填写正确手机号");
    return false;
  } else if (!v3.val() || !IdentityCodeValid(v3.val())) {
    $(".f-form-inp i").hide().removeClass("icon-error");
    v3.parent().prev().show().addClass("icon-error");
    popshow("请填写正确身份证号");
    return false;
  } else if (!$("#xyid").is(":checked")) {
    popshow("请同意协议");
    return false;
  } else {
    $(".f-form-inp i").hide().removeClass("icon-error");
      num++
      if(num==1){
          $.ajax({
              type: "post",
              data: {
                  realname: v1.val(),
                  realphone:v2.val(),
                  realid: v3.val(),
                  money: money,
                  id: $("#houseid").val()
              },
              url: "/house/stored/ajaxinfo",
              dataType: "json",
              beforeSend: function() {
              },
              success: function(data) {
                  if(data.code==0){
                      popshow("填写正确，提交中....");
                      $(".dial-closebtn").remove();
                      location.href = data.url;//location.href实现客户端页面的跳转
                      num=0;
                  }else if(data.code==1){
                      popshow(data.message);
                      $(".dial-closebtn").remove();
                      $(".dial-pop-txt").append('<i class="pos-r bt fs28 fc444 dial-hrefbtn"><a href="'+data.murl+'" class="fc444 pos-r br">个人中心</a><a href="'+data.ourl+'" class="fc444">订单详细</a></i>')
                      num=0;
                  }

              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
                  closepop()
                  alert("网络异常");
                  num=0;
              }
          })
      }
  }
}

//未支付订单支付
var checkpay = function() {
    popshow("提交中....");
    $(".dial-closebtn").remove();
    var id=$('#id').val();
    $.ajax({
        type: "post",
        data: {
            id: id
        },
        url: "/house/member/pay",
        dataType: "json",
        success: function(data) {
            if(data.code==0){
                location.href = data.url;//location.href实现客户端页面的跳转
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("网络异常");
        }
    })
}
//确认使用
var confirmorder = function() {
    popshow("提交中....");
    $(".dial-closebtn").remove();
    var id=$('#id').val();
    $.ajax({
        type: "post",
        data: {
            id: id
        },
        url: "/house/member/confirmorder",
        dataType: "json",
        success: function(data) {
            if(data.code==0){
                location.href = data.url;//location.href实现客户端页面的跳转
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("网络异常");
        }
    })
}

//提现
var withdraw = function() {
    popshow("提交中....");
    $(".dial-closebtn").remove();
    var id=$('#id').val();
    $.ajax({
        type: "post",
        data: {
            id: id
        },
        url: "/house/member/withdraw",
        dataType: "json",
        success: function(data) {
            if(data.code==0){
                location.href = data.url;//location.href实现客户端页面的跳转
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("网络异常");
        }
    })
}




v1.blur(function() {
  if (!v1.val()) {
    v1.parent().prev().show().addClass("icon-error");
  } else {
    v1.parent().prev().show().removeClass("icon-error");
  }
});

v2.blur(function() {
  if (!v2.val() || !reg.test(v2.val())) {
    v2.parent().prev().show().addClass("icon-error");
  } else {
    v2.parent().prev().show().removeClass("icon-error");
  }
});

v3.blur(function() {
  if (!v3.val() || !IdentityCodeValid(v3.val())) {
    v3.parent().prev().show().addClass("icon-error");
  } else {
    v3.parent().prev().show().removeClass("icon-error");
  }
});


// 身份证验证

function IdentityCodeValid(code) {
  var city = {
    11: "北京",
    12: "天津",
    13: "河北",
    14: "山西",
    15: "内蒙古",
    21: "辽宁",
    22: "吉林",
    23: "黑龙江 ",
    31: "上海",
    32: "江苏",
    33: "浙江",
    34: "安徽",
    35: "福建",
    36: "江西",
    37: "山东",
    41: "河南",
    42: "湖北 ",
    43: "湖南",
    44: "广东",
    45: "广西",
    46: "海南",
    50: "重庆",
    51: "四川",
    52: "贵州",
    53: "云南",
    54: "西藏 ",
    61: "陕西",
    62: "甘肃",
    63: "青海",
    64: "宁夏",
    65: "新疆",
    71: "台湾",
    81: "香港",
    82: "澳门",
    91: "国外 "
  };
  var tip = "";
  var pass = true;
  if (!code || !/^[1-9]\d{5}((1[89]|20)\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])\d{3}[\dx]$/i.test(code)) {
    tip = "身份证号格式错误";
    pass = false;
  } else if (!city[code.substr(0, 2)]) {
    tip = "地址编码错误";
    pass = false;
  } else {
    //18位身份证需要验证最后一位校验位
    if (code.length == 18) {
      code = code.split('');
      //∑(ai×Wi)(mod 11)
      //加权因子
      var factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
      //校验位
      var parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
      var sum = 0;
      var ai = 0;
      var wi = 0;
      for (var i = 0; i < 17; i++) {
        ai = code[i];
        wi = factor[i];
        sum += ai * wi;
      }
      var last = parity[sum % 11];
      if (parity[sum % 11] != code[17]) {
        tip = "校验位错误";
        pass = false;
      }
    }
  }
  return pass;
}


//timeevent

(function($) {
  var countdown = function(item, config) {
    var now = new Date();
    var seconds = parseInt(parseInt($(item).attr(config.attribute)) - ((now.getTime()) / 1000));
    var timer = null;

    var doWork = function() {
      if (seconds >= 0) {
        if (typeof(config.callback) == "function") {
          var data = {
            total: seconds,
            second: Math.floor(seconds % 60),
            minute: Math.floor((seconds / 60) % 60),
            hour: Math.floor((seconds / 3600) % 24),
            day: Math.floor(seconds / 86400)
          };
          config.callback.call(item, seconds, data, item);
        }
        seconds--;
      } else {
        window.clearInterval(timer);
      }
    }
    timer = window.setInterval(doWork, 1000);
    doWork();
  };
  var main = function() {
    var args = arguments;
    var config = {
      attribute: 'data-seconds',
      callback: null
    };
    if (args.length == 1) {
      if (typeof(args[0]) == "function") config.callback = args[0];
      if (typeof(args[0]) == "object") $.extend(config, args[0]);
    } else {
      config.attribute = args[0];
      config.callback = args[1];
    }
    $(this).each(function(index, item) {
      countdown.call(item, item, config);
    });
  };
  $.fn.countdown = main;
})(Zepto);

$(function() {
  $('.icon-time').countdown(function(s, d) {
    var items = $(this).find("span");
    items.eq(0).text("距结束" + d.day + "天")
    items.eq(1).text(d.hour + "时")
    items.eq(2).text(d.minute + "分")
    items.eq(3).text(d.second + "秒")
  });
})

var page=2;
var number=0;  
  function scrollF(){
  //获取滚动条当前的位置
  function getScrollTop() {
    var scrollTop = 0;
    if (document.documentElement && document.documentElement.scrollTop) {
      scrollTop = document.documentElement.scrollTop;
    } else if (document.body) {
      scrollTop = document.body.scrollTop;
    }
    return scrollTop;
  }

  //获取当前可视范围的高度
  function getClientHeight() {
    var clientHeight = 0;
    if (document.body.clientHeight && document.documentElement.clientHeight) {
      clientHeight = Math.min(document.body.clientHeight, document.documentElement.clientHeight);
    } else {
      clientHeight = Math.max(document.body.clientHeight, document.documentElement.clientHeight);
    }
    return clientHeight;
  }

  //获取文档完整的高度
  function getScrollHeight() {
    return Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
  }

    if (getScrollTop() + getClientHeight() === getScrollHeight()) {
     $(".f-index-list-loading").show();
     // console.log(page);
     // console.log(getScrollTop());
     // console.log(getClientHeight());
     // console.log(getScrollHeight());
     
     number++;
     if(number==1){
         $.ajax({
          url:"/house/site/gethouse",
          data:{"page":page},
          dataType:'json',
          type:'GET',
          success:function(data){
                 page++;
                 if(data.fcode==0){
                  $(".f-index-list-loading").html("没有数据了");
                 }else{
                  var html = "";
                  for (var i = 0; i < data.length; i++) {
                    if (data[i].ftype == "2") {
                      html += '<li>'
                      html += '<div class="f-index-listdiv clearfix">'
                      html += '<a href="' + data[i].url + '">'
                      html += '<div class="f-index-listdiv-img"><img src="' + data[i].img + '"/></div>'
                      html += '<div class="f-index-listdiv-txt">'
                      html += '<h3>['+ data[i].city +']'+ data[i].ftitle + '</h3>'
                      html += '<p>在线预存<i><b>￥</b>' + data[i].figue + '</i></p>'
                      html += '<em>' + data[i].coupon + '</em>'
                      html += '</div>'
                      html += '</a>'
                      html += '</div>'
                      html += '<div class="f-index-listdiv-time pos-r bb bt">'
                      if (data[i].end == "bg1") {
                        html += '<i class="icon-time" data-seconds=' + data[i].actime2 + '><span>--天</span><span>--时</span><span>--分</span><span>--秒</span></i>'
                        html += '<a href="' + data[i].url + '" class="bg1 fcfff">我要预存</a>'
                      }
                      if (data[i].fflag == "bg2") {
                        html += '<i class="icon-time">该活动已结束</i>'
                        html += '<a href="javascript:void(0)" class="bg2 fcfff">活动结束</a>'
                      }

                      html += '</div>'
                      html += '</li>'
                    }

                  }
                  $(".f-index-list-loading").hide();
                  $(".f-index-list ul").append(html);
                  number=0;
                  $(function() {
                          $('.icon-time').countdown(function(s, d) {
                            var items = $(this).find("span");
                            items.eq(0).text("距结束" + d.day + "天")
                            items.eq(1).text(d.hour + "时")
                            items.eq(2).text(d.minute + "分")
                            items.eq(3).text(d.second + "秒")
                          });
                        })
                 }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $(".f-index-list-loading").html("网络超时");
                    setTimeout(function(){
                      $(".f-index-list-loading").hide();
                      $(".f-index-list-loading").html("加载中<i class='icon-loading'></i>");
                    },3000)
                }

          })
     }
   

   
   } 



} 



// loading
window.onload = function() {
  document.getElementById("loaddiv").style.display = "none"
};