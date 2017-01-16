var temp='<div style="position: fixed;left: 0;top: 0;right: 0;bottom: 0;background: rgba(0, 0, 0, .4);z-index: 90;">'+
    '<div class="login-main" style="background: #fff;position: absolute;width: 90%;left: 50%;top: 50%;transform: translate(-50%,-50%);-webkit-transform: translate(-50%,-50%);margin: 0;">'+
    '<div class="login-tit">绑定大楚通行证</div>'+

    '<div class="login-tab">'+

    '<div class="login-tabnav">'+
    '<ul class="clearfix">'+
    '<li class="selected">验证码登录</li>'+
    '<li>账号登录</li>'+
    '</ul>'+
    '</div>'+

    '<div class="login-tabdiv">'+

    '<div class="login-tabdiv1" style="display: block;">'+

    '<div class="login-inp has-focus"><input type="tel"  name="mobile" id="mobile" placeholder="手机号" /></div>'+
    '<a id="sendCode" href="javascript:;"><div class="login-inp"  id="send_message" class="send_message"><input id="hq" type="button" value="获取验证码" /></div></a>'+
    '<div class="login-inp has-focus"><input type="tel" name="smsCode" id="smsCode"  value="" placeholder="验证码" /></div>'+

    '<div class="login-inp"><input type="submit"  id="login" value="登录"/></div>'+


    '</div>'+

    '<div class="login-tabdiv1" style="display: none;">'+

    '<div class="login-inp has-focus"><input type="tel"name="mobile2" id="mobile2"  value="" placeholder="手机号" /></div>'+

    '<div class="login-inp has-focus"><input type="password" name="upwd" id="upwd" value="" placeholder="密码" /></div>'+

    '<div class="login-inp"><input type="submit" id="login2" value="登录"/></div>'+

    '</div>'+


    '</div>'+

    '</div>'+




    '</div>'+


    '</div>'+

    '</div>'+


    '<div class="cal-mask">'+
    '<div class="cal-mask-con" id="regtips">'+
    '<span class="img" id="tsimg">'+
    '<img  src="http://m.dachuw.net/themes/default/h5/login/images/cal-error-icon.png"/>'+
    '</span>'+
    '<p id="msg">提示文字</p>'+
    '</div>'+
    '</div>';


function showlogin(){
    $("body").append(temp);
}

var disable_click = false;
//发送短信验证码
$("html").on('click',"#sendCode",function(){
    if(disable_click) {
        return false;
    }
    disable_click = true;
    var mobile = $.trim($("#mobile").val());
    if(mobile==''){
        setTimeout(function () {
            showTips('请输入手机号');
            $("#mobile").focus();
        }, 300);
        disable_click = false;
        return;
    }
    if(!mobile.match((/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/))){
        setTimeout(function () {
            showTips('请输入正确的手机号');
            $("#mobile").focus();
        }, 300);
        disable_click = false;
        return;
    }

    $.ajax({
        url: '/h5/member/SendMsCode',
        data: {mobile: mobile},
        dataType: 'json',
        type: 'post',
        success: function (data) {
            if (data.status == 1) {
                setTimeout(function () {
                    //短信验证码已发送禁用60s
                    var count_time = 60;
                    t = setInterval(function() {
                        if (count_time <0) {
                            $(".send_message").removeAttr("disabled");
                            $(".send_message").removeClass('send_status');
                            $("#hq").attr("value",'获取验证码');
                            disable_click = false;
                            clearInterval(t);

                        }else {
                            $(".send_message").addClass("send_status");
                            $(".send_message").attr("disabled", true);
                            $("#hq").attr("value",'('+count_time--+')秒后重获');
                        }
                    }, 1000);
                }, 600);
            }
            if (data.status == -1 || data.status == 0) {
                setTimeout(function () {
                    showTips('短信验证码发送失败');
                    disable_click = false;
                }, 600);
            }
        }
    });
});

//用户登录
$("html").on('click',"#login",function(){
    var mobile = $.trim($("#mobile").val());
    var smsCode = $.trim($("#smsCode").val());




    if(mobile==''){
        showTips("请输入手机号");
        $("#mobile").focus();
        return;
    }
    if(!mobile.match((/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/))){
        showTips("请输入正确的手机号");
        $("#mobile").focus();
        return;
    }
    if(smsCode==''){
        showTips("请输入验证码");
        $("#smsCode").focus();
        return;
    }
//    if(!openid || openid=='undefined'){
//        alert('openid不能位空!请按开发规范传递openid');return;
//    }
        if(openid=='undefined'){
            openid='';
        }
    $.ajax({
        url: '/member/Ajaxlogin',
        data: {mobile: mobile,smsCode:smsCode,openid:openid,id:id,table:table,type:"act_smslogin"},
        dataType: 'json',
        type: 'post',
        success: function (data) {
            console.log(data);
            if(data.status == 1){
                 showTips('登录中...','<img  src="http://m.dachuw.net/themes/default/h5/login/images/cal-right-icon.png"/>');
                if(openid && openid!='undefined'){
                    setTimeout(function () {
                        window.location.href = "?openid="+openid
                        return;
                    }, 600);
                }else{
                     setTimeout(function () {
                        // window.location.reload();
                        window.location.href = "?status#";
                        return;
                    }, 600);
                }
            }
            else if (data.status == -6) {
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else if (data.status == 0) {
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else if (data.status == -1 ) {
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else if(data.status == -5 ){
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else if(data.status == -3 ){
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else{
                showTips('系统错误');
            }
        }
    });
});

//showTips("ok");


$(function(){
    var navLi=$(".login-tabnav li");
    navLi.click(function(){
        navLi.removeClass("selected");
        $(this).addClass("selected");
        var i=navLi.index(this);
        $(".login-tabdiv1").hide();
        $(".login-tabdiv1").eq(i).show();
    })

})





//用户登录
$("html").on('click',"#login2",function(){
    var mobile = $.trim($("#mobile2").val());
    var upwd = $.trim($("#upwd").val());




    if(mobile==''){
        showTips("请输入手机号");
        $("#mobile").focus();
        return;
    }
    if(!mobile.match((/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/))){
        showTips("请输入正确的手机号");
        $("#mobile").focus();
        return;
    }
    if(smsCode==''){
        showTips("请输入验证码");
        $("#smsCode").focus();
        return;
    }
//    if(!openid || openid=='undefined'){
//        alert('openid不能位空!请按开发规范传递openid');return;
//    }

        if(openid=='undefined'){
            openid='';
        }
    $.ajax({
        url: '/member/Ajaxlogin',
        data: {mobile: mobile,upwd:upwd,openid:openid,id:id,table:table,type:"act_publogin"},
        dataType: 'json',
        type: 'post',
        success: function (data) {
            console.log(data);
            if(data.status == 1){
                 showTips('登录中...','<img  src="http://m.dachuw.net/themes/default/h5/login/images/cal-right-icon.png"/>');
                if(openid && openid!='undefined'){
                    setTimeout(function () {
                        window.location.href = "?openid="+openid
                        return;
                    }, 600);
                }else{
                     setTimeout(function () {
                        // window.location.reload();
                        window.location.href = "?status#";
                        return;
                    }, 600);
                }
             // setTimeout(function () {
             //            // window.location.reload();
             //            window.location.href = "?and#";
             //            return;
             //        }, 600);

            }
            else if(data.status == -1 ){
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else if(data.status == -3 ){
                setTimeout(function () {
                    showTips(data.info);
                }, 300);
            }
            else{
                showTips('系统错误');
            }
        }
    });
});

function showTips(content,picsrc) {
        if(picsrc){
            $("#tsimg").html(picsrc);
        }
    $(".cal-mask").css({
        "z-index": "999",
        "opacity": "1"
    }).children(".cal-mask-con").css({
        "top": "50%"
    });
    $("#msg").html(content);
    setTimeout(function() {
        $(".cal-mask").css({
            "z-index": "-10",
            "opacity": "0"
        }).children(".cal-mask-con").css({
            "top": "-50%"
        });
    }, 2000)
}


