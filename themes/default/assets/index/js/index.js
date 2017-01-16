$(function() {
	function a() {
		var a = $(".op-news-list"),
			b = a.find("ul"),
			c = b.find("li"),
			d = c.height();
		b.animate({
			"margin-top": -d + "px"
		}, 500, function() {
			b.css({
				"margin-top": "0px"
			}), c.eq(0).appendTo(b)
		})
	}
	time1 = setInterval(a, 3000), $(".op-news-list").hover(function() {
		clearInterval(time1)
	}, function() {
		time1 = setInterval(a, 3000)
	})

	$("#loginshow").click(function(){
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
	

	$(".op-login-inp input").focus(function(){
		if($(this).val()==this.defaultValue){
			$(this).val("");
		}
	})
	$(".op-login-inp input").blur(function(){
		if($(this).val()==""){
			$(this).val(this.defaultValue);
		}
	})
	$("#loginbtn").click(function(){
		var account=$("#uname").val(),
			password=$("#upwd").val(),
			win=$(".op-login-error");
		var verify = $('#verify').val();
		var rember = 0;
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
				},
				url: Siteurl+'/member/Ajaxsitelogin',
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

	})

 var opLi=$(".op-doc-lnav ul li");
  var opLia=$(".op-doc-lnav ul li a");
  opLi.click(function(){
  	opLi.removeClass("selected").find("p").stop().slideUp(300);
  	$(this).addClass("selected").find("p").stop().slideDown(300);
  })
  opLia.click(function(e){
  	e.preventDefault();
  	opLia.removeClass("selected");
  	$(this).addClass("selected");
  })

});