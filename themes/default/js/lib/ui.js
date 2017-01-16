/**
 * UI模块对象
 * @author panbing
 */
(function(){
    //构造函数
    var UI = function(name){
        return new UI.fn.init();
    }

    //原型
    UI.fn = UI.prototype = {
        init:function(){
            return this;
        }
    }

    //模块扩展属性
    UI.extend = UI.fn.extend = function () {
        // copy reference to target object
        var target = arguments[0] || {}, i = 1, length = arguments.length, deep = false, options, name, src, copy;

        // Handle a deep copy situation
        if (typeof target === "boolean") {
            deep = target;
            target = arguments[1] || {};
            // skip the boolean and the target
            i = 2;
        }

        // Handle case when target is a string or something (possible in deep copy)
        if (typeof target !== "object" && !Pinguan.isFunction(target)) {
            target = {};
        }

        // extend Pinguan itself if only one argument is passed
        if (length === i) {
            target = this;
            --i;
        }

        for (; i < length; i++) {
            // Only deal with non-null/undefined values
            if ((options = arguments[i]) != null) {
                // Extend the base object
                for (name in options) {
                    src = target[name];
                    copy = options[name];

                    // Prevent never-ending loop
                    if (target === copy) {
                        continue;
                    }

                    // Recurse if we're merging object values
                    if (deep && copy && typeof copy == "object" && !copy.nodeType)
                        target[name] = Pinguan.extend(deep,
                            // Never move original objects, clone them
                            src || (copy.length != null ? [] : {})
                        , copy);

                        // Don't bring in undefined values
                    else if (copy !== undefined)
                        target[name] = copy;
                }
            }
        }

        // Return the modified object
        return target;
    };

    //扩展方法
    UI.extend({
		gallery : function(obj,automatic,previous,next){//图片切换
			//obj父标签 automatic 是否自动播放 previous 上一页 next下一页
			var i = 0;
			var g = 0;
			var tath = this;
			if(automatic){//自动播放加按钮翻页
				var t1 = null;
				function galleryF(){//自动播放函数
					var len = (obj.length-1)*obj.width()*-1;
					var left = parseInt(obj.parent().css('margin-left'))-obj.width();
					if(left<len){
						i = 0;
						obj.parent().animate({"margin-left":0},1000);
					}else{
						i++;
						obj.parent().animate({"margin-left":left},1000);
					}
				}
				t1 = setInterval(galleryF,3000);
				previous.click(function(){//上一页按钮
					var left = parseInt(obj.parent().css('margin-left'));
					var width = obj.width();
					if(left==0){
						alert("没有上一张了");
					}else{
						clearInterval(t1);
						left = left+width*1;
						obj.parent().animate({"margin-left":left},1000,function(){
							t1 = setInterval(galleryF,3000);
						});
					}
				});
				next.click(function(){//下一页按钮
					var left = parseInt(obj.parent().css('margin-left'));
					var width = obj.width();
					var leng = width*-1*(obj.length-1);
					if(left==leng){
						alert('没有下一张了');
					}else{
						clearInterval(t1);
						left = left+width*-1;
						obj.parent().animate({"margin-left":left},1000,function(){
							t1 = setInterval(galleryF,3000);
						});
					}
				});
			}else{//不用自动播放
				previous.click(function(){//上一页
					var width = obj.width();
					if(g<=0){
						tath.popup({
							html:'没有上一张了',
							type:1
						});
						return false;
					}else{
						g--;
						obj.parent().stop(true).animate({"margin-left":g*width*-1},1000);
					}
				});
				next.click(function(){//下一页
					var width = obj.width();
					if(g>=obj.length-1){
						tath.popup({
							html:'没有下一张了',
							type:1
						});
						return false;
					}else{
						g++;
						obj.parent().stop(true).animate({"margin-left":g*width*-1},1000);
					}
				});
			}
		},
		tab : function(obj,className,cont,star){
			obj.mouseenter(function(){
				obj.removeClass(className);
				var index = $(this).index();
				cont.css('display','none');
				cont.eq(index).css('display','block');
				$(this).addClass(className);
				if(star==true){
					obj.find('span').remove();
					$(this).append('<span><i class="fa fa-caret-down"></i></span>');
				}
			});
		},
		/*slide : function(obj){
			
		}*/
		dianzan : function(obj,url){
			var star = true;
			if(star==true){
				star = false;
				$.ajax({
					url : url,
					dataType : 'json',
					success:function(data){
						if(data.status=='y'){
							var css = {
							  'position': 'absolute',
							  'color':'#f00',
							  'right':'-60%',
							  'top':'25px',
							  'font-size':'14px'
							}
							obj.append('<span class="add">+1</span>');
							$(".add").css(css);
							obj.css("background",'#e15345 url(/Public/pc/images/icon_heart.png) no-repeat center center');
							$(".add").parent().css('position',"relative");
							$('.add').animate({'top':0,'opacity':0},1000,function(){
								star = true;
								$(".mynum").html((obj.data("num")+1)+"个人点赞");
							});
						}else{
							UI.popup({
								html : data.info
							});
							UI.clearPopup();
							return false;
						}
					}
				});
			}
		},
		star : null,
		huifu : function(json){
			var tath = this;
			var pid = null;
			var fid = null;
			var content = null;
			var type = null;
			//huifu 回复按钮  endHuifu 取消回复 ajaxHF 提交回复 box 评论容器 fun 函数
			json.box.die().live('mouseenter',function(){//显示回复按钮
				$(this).find(".huifu").show();
			});
			json.box.live('mouseleave',function(){
				$(this).find(".huifu").hide();//隐藏回复按钮
			});
			//回复
			json.huifu.die().live('click',function(){
				pid = $(this).data('pid');
				fid = $(this).data('fid');
				type = $(this).data('type');
				var html = '<div class="returnwriteto">'+
								'<textarea name="textarea" class="writeText" cols="45" rows="5"></textarea>'+
									'<div class="wesure">'+
										'<input type="button" name="button" class="plcencle" value="取消">'+
										'<input type="button" name="button" class="plok" value="提交"></div>'+
							'</div>';
				$(this).removeClass('huifu').addClass('huifuK');
				if($(this).parent().next().length>0){
					$(this).parent().next().remove();
				}
				if($(this).parents(".pltexter").length>0){
					$(this).parents(".pltexter").append(html);	
				}else if($(this).parents(".returnTexter").length>0){
					$(this).parents(".returnTexter").append(html);
				}
			});
			//取消留言
			json.endHuifu.live('click',function(){
				$(this).parents(".returnwriteto").prev().find('.huifuK').removeClass('huifuK').addClass('huifu');
				$(this).parents(".returnwriteto").prev().find('.huifu').hide();
				$(this).parents('.returnwriteto').remove();
			});
			//提交留言
			json.ajaxHF.die().live('click',function(){
				if($(this).parents(".returnwriteto").find('.writeText').val()==""){
					tath.popup({
						html : "回复不能为空",
						type : "1",
						zoo : 10
					});
					return false;
				}
				json.fun(pid,fid,type,$(this).parents(".returnwriteto").find('.writeText'),$(this).parents(".pinglin"),$(this));
				$(this).parents(".returnwriteto").prev().find('.huifuK').removeClass('huifuK').addClass('huifu');
				$(this).parents(".returnwriteto").prev().find('.huifu').hide();
				$(this).parents('.returnwriteto').remove();
			});
		},
		yzmT : null,
		yzm : function(){
			//获取验证码
			var star = true;
			$('.yzmbt').click(function(){
				//判断是否已经获取过验证码
				if(star == false){
					return false;
				};
				star = false;
				var reg = /^1[3|5|8]\d{9}$/;//电话号码
				var val = $("#tele").val();
				if($("#tele").val()=="" || reg.test(val)==false){
					UI.popup({
						type:1,
						html:'请填写正确的手机号,并且不能空'
					});
					star = true;
					return false;
				}else{
					$.ajax({
						url : '/Code?phone='+val,
						dataType:'json',
						success : function(data){
							if(data.msg!=1){
								UI.popup({
									type:1,
									html:data.info
								});
								star = true;
								return false;
							}else{
								yzm = data.info;
								UI.yzmT = yzm;
								var i = 60;
								var t1 = null;
								$('.yzmbt').removeClass('yzmbt').addClass('yzmno');
								t1 = setInterval(function(){
									if(i==1){
										$(".yzmno").html("获取验证码");
										$('.yzmno').removeClass('yzmno').addClass('yzmbt');
										$(".yzmbt").css('background',"#e15345");
										star = true;
										yzm = "验证码已过期";
										UI.yzmT = yzm;
										clearInterval(t1);
									}else{
										i--;
										$(".yzmno").html(i+"秒后重新发送");
										$(".yzmno").css('background',"#ccc");
										star = false;
									}
								},1000);
							}
						}
					});
				}
			});
		},
        popup:function(json){
			//title:标题
			//html : 内容
			//type : 按钮
			//shade : 遮罩
			//success : 回调函数
			if(!json){
				alert("您没有设置任何参数");
				return false;
			}else{
				$("body").append("<div class='poperbox' style='top:0px;'></div>");
				$(".poperbox").append("<div class='poper' style=' position: relative; z-index:999;'></div>");
				if(json.title){
					$(".poper").append("<h3>"+json.title+"</h3>");
				}
				if(json.html){
					$(".poper").append("<p>"+json.html+"</p>");
				}
				if(json.type){
					if(json.type==1){
						$(".poper").append("<div class='decide'></div>");
						$(".decide").append('<a href="javascript:void(0);" style="background:#e15345;color:#fff; margin:0px;" class="yes">确定</a>');
					}else if(json.type==2){
						$(".poper").append("<div class='decide'></div>");
						$(".decide").append('<a href="javascript:void(0);" class="yes">确定</a><a href="javascript:void(0);" class="no">取消</a>');
					}
					if(json.success){
						$(".yes").die().live('click',function(){
							json.success();
							$(".poperbox").remove();
						});
					}else{
						$(".no,.yes").die().live('click',function(){
							$(".poperbox").remove();
						});					
					}
				}
				if(json.shade==true){
					$(".poperbox").css("background","rgba(0,0,0,0.8)");
					$(".poperbox").die().live("click",function(){
						$(".poperbox").remove();
					});
				}
				var top = ($(window).height()-$(".poper").height()-40)/2;
				$(".poper").css("margin-top",top);
			}
        },
        clearPopup:function(){
            if($('div').hasClass('poperbox')){
                setTimeout(function(){
                    $(".poperbox").remove();
                },600)
            }
        }
    });

    UI.fn.init.prototype = UI.fn;

    window.UI = UI;
    
})();