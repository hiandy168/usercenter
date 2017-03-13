 $(function() {
        function t(t, e) {
            this.element = t;
            this.$ele = $(t);
            //						this.setting = $.extend({}, n, e);
            this.init()
        }

        t.prototype = {
            construct: t,
            init: function() {
                this.initDom();
                this.hover1();
                this.hover2();
            },
            initDom: function() {
                this.$dom = this.$ele;
            },
            hover1: function() {
                var t = this;
                this.$dom.on("mouseover", function(e) {
                    $(this).parent().addClass("active");
                })
            },
            hover2: function() {
                var t = this;
                this.$dom.on("mouseout", function(e) {
                    $(this).parent().removeClass("active");
                })
            }
        }
        var a1 = new t(".ad-haslogin-img");
        var a2 = new t(".ad-haslogin-info");
        var datanav = $(".ad-app-listdiv-datanav  li");
        datanav.on('click', function(event) {
            event.preventDefault();
            $(this).addClass("selected").siblings().removeClass("selected");
            var i = $(this).index();
            $(this).parent().parent().parent().find(".datadiv1").eq(i).show().siblings().hide();
        });
         var actnav=$(".ad-act-nav li");
        actnav.on('click', function(event) {
            event.preventDefault();
            $(this).addClass("selected").siblings().removeClass("selected");
            var i = $(this).index();
            $(".ad-act-con-d").hide().eq(i).show();
        });
         
         var editnav=$(".ad-edit-app-nav li");
         editnav.on('click', function(event) {
            event.preventDefault();
            $(this).addClass("selected").siblings().removeClass("selected");
            var i = $(this).index();
            $(".ad-edit-app-condiv").hide().eq(i).show();
        });
         
      $(".ad-data-selectkind").hover(function(){
      	$(this).find(".kind1-list").stop().slideDown(300);
      	$(this).find(".kind1").find("i").addClass("rotate");
      },function(){
      	$(this).find(".kind1-list").stop().slideUp(300);
      	$(this).find(".kind1").find("i").removeClass("rotate");	
      })
     
     $("#loginshow").click(function(){
		$(".op-mask").show();
		$(".op-login-div").show();
	})

     $(".activity_pclogin").click(function(){
         $(".op-mask").show();
         $(".op-login-div").show();
     })

     $("#loginshows").click(function(){
         $(".op-mask").show();
         $(".op-login-div").show();
     })

    $(".op-mask").click(function(){
    	  $(".op-login-div").hide();
        $(".op-mask").hide();
    })
     
    //   登录

     $(document).keypress(function(e) {
         if (e.which == 13){
             if($(".op-login-div").css("display")=="block"){
                 ajaxlogin();
             }
         }

     });


     $("#loginbtn").click(function(){

         ajaxlogin();
		
	})

     
    });

/*pc首页登陆*/
 function ajaxlogin(){
     var account=$("#uname").val(),
         password=$("#upwd").val(),
         win=$(".op-login-error");
     var verify = $('#verify').val();
     var rember = 0;
     var codes = $('#codes').val();
     var ckbox = $('#regname:checked').val();
     if(ckbox){
         rember = 1;
     }
     // if($('#checkbox').is(':checked')) {
     // 	rember = 1;
     // }
     if(account=="" || account=="请输入用户名"){
         win.html("请填写用户名");
         return false;
     }else if(password=="" || password=="请输入密码"){
         win.html("请输入密码");
         return false;
     }else {

         $.ajax({
             type: "post",
             cache: !1,
             async: !1,
             data: {
                 account:account,
                 password:password,
                 verify:verify,
                 rember:rember,
                 codes:codes,
             },
           //  url: Siteurl+'/member/Ajaxsitelogin',   //输入密码登录地址
             url: Siteurl+'/member/Ajaxsitelogincode',  //输入验证码登录地址
             dataType: "json",
             success: function(data) {
                 if (data.state == 1) {
                     win.html(data.message);
                     setTimeout(function(){
                         window.location.href = data.return_url;
                     },400);
                 } else {
                     win.html(data.message);
                 }
             },
             error: function(XMLHttpRequest, textStatus, errorThrown) {
                 win.html("网络异常");
             }
         })

     }
 }

     //复制
      function Copy(obj){ 
               var e=$(obj).prev().find("textarea");
               e.select(); 
               document.execCommand("Copy");
               alert("复制成功")  } 

     
  function nextBtn(obj){
  	    var n=5;
        var $v_show = $(obj).next().find("ul");
        var $v_content = $(obj).next(".ad-act-con-d2");
        var v_width = $v_content.height();
        var len = $v_show.find("li").length;
        var page_count = Math.ceil(len / n);
        if (!$v_show.is(":animated")) {
            if ($v_show.css("top")==((page_count-1)*(-500)+"px")) {
                /*$v_show.animate({
                    left: '0px'
                }, "slow");
                page = 1;*/
                return false;
                
            } else {
                $v_show.animate({
                    top: '-=' + v_width
                }, "slow");
            }
        }
  	
  }
        


  function prevBtn(obj){
        var n=5;
        var $v_show = $(obj).next().next().find("ul");
        var $v_content = $(obj).next().next(".ad-act-con-d2");
        var v_width = $v_content.height();
        var len = $v_show.find("li").length;
        var page_count = Math.ceil(len / n);
        if (!$v_show.is(":animated")) {
            if ($v_show.css("top")==(0+"px")) {
                /*$v_show.animate({
                    left: '-=' + v_width * (page_count - 1)
                }, "slow");
                page = page_count;*/
                return false;
            } else {
                $v_show.animate({
                    top: '+=' + v_width
                }, "slow");
                
            }
        }

  }



 /**
  * 上传图片的函数，全局可用
  * 调用方法：<input class="weui_uploader_input" type="file" onchange="return uploadImg(this)"/>
  * 说明：img在file的下面
  * @param	that
  * @param	name:隐藏表单提交的name属性
  * @param	isphysical:是否物理路径,是则不带URL,否则前面带网址头
  */
 function uploadImages(that, name, imgid,isphysical)
 {
     layer.open( { iconType:8, content:'正在上传中，请稍后……', time:15} );
     //增加标记
     $('input[type=file]').removeClass('file_remark');
     $(that).addClass('file_remark');
     var file_remark = $('.file_remark');
     var path = isphysical ? '&path=physical' : '' ;//path

     setTimeout(function(){
         lrz(that.files[0], { width: 600 })
             .then(function (rst) {
                 var xhr = new XMLHttpRequest();
                 xhr.open('POST', Siteurl+'/files/upload');
                 xhr.onload = function ()
                 {
                     var data = JSON.parse(xhr.response);//上传返回的json格式字符串
                     layer.closeAll();
                     console.log(data);
                     // 上传成功
                     if (data.error==0) {
                         var base64 = rst.base64;
                       //  var iv = document.getElementById(imgid);
                         var iv = $("#"+imgid);
                         iv.src = base64;
                         $("#"+name).attr("value",data.url);
                       /*  var html = '<img class="img" src="'+base64+'" width="79" height="79" /></li>';
                         if(name) html += '<input type="hidden" name="'+name+'" value="'+data.url+'" /></li>';
                         file_remark.parent().addClass('ceil_thumbs_my');
                         file_remark.after(html);*/
                         return true;
                     } else {
                         // 处理错误
                         layer.open({ content: data.message});
                         return false;
                     }
                 };
                 rst.formData.append('fileLen', rst.fileLen);//参数，可继续增加
                 xhr.send(rst.formData);// 触发上传
             })
     }, 500);
 }



 // 上传图片显示
 /*
 * file  文件流
 * inputid 接收返回上传路径隐藏域的id
 * image  预览img id*/
 function uploadImg(file,inputid,imgid,img_form) {

     var inputid = arguments[1] ? arguments[1] : "share_img";
     var imgid = arguments[2] ? arguments[2] : "imgPreview";
     var img_form = arguments[3] ? arguments[3] : "img_form";
     var ajax_option={
         url: Siteurl+"/files/upload",//默认是form action
         dataType:"json",
         success:function(data){
                console.log(data);
             if(data.error==0){
                 var iv = document.getElementById(imgid);
                 var reader = new FileReader();
                 reader.onload = function(evt) {
                     src1 = evt.target.result;
                     iv.src = src1;
                 };
                 reader.readAsDataURL(file.files[0]);
                 $("#"+inputid).attr("value",data.url);
//                    alert(data.mess);
             }else {
                 // 处理错误
                 layer.open({ content: data.message});
                 return false;
             }
         }
     }
     $('#'+img_form).ajaxSubmit(ajax_option);
 }


$(function() {
    if ($("#navact").length>0) {
        var navact = $("#navact");
        $(".ad-topnav2 span").css({
            "left": navact[0].offsetLeft + 20,
            "width": navact.width()
        });
        $(".ad-topnav2 ul li").hover(function() {
            $(".ad-topnav2 span").stop().animate({
                "left": $(this)[0].offsetLeft + 20,
                "width": $(this).width()
            }, 300)
        }, function() {
            $(".ad-topnav2 span").stop().animate({
                "left": navact[0].offsetLeft + 20,
                "width": navact.width()
            }, 300)
        })
    } else {
        return false;
    }
    $(".tips-close").click(function() {
        $(".ad-top-tips").hide();
    })
    $(".ad-newkind").hover(function() {
        $(this).find(".ad-newkind2").stop().slideDown(300);
    }, function() {
        $(this).find(".ad-newkind2").stop().slideUp(300);

    })
})