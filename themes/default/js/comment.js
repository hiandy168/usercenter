 $(document).ready(function() {
    $.fn.extend({    
        comment:function(){    
            $(this).click(function(){   
                comment_btn($(this));
            });    
        } 
    });
    $("#comment_btn").comment(); 
    
     $.fn.extend({    
        guestcomment:function(){    
            $(this).click(function(){   
                guestcomment_btn($(this));
            });    
        } 
    });
    $("#guest_comment_btn").guestcomment(); 
            
    $.fn.extend({    
        math_length:function(){    
            $(this).keyup(function(){   
                var len = 255 - $("textarea[name='content']").val().length;
                $("#num").html(len); 
            });    
        } 
    })
    $("textarea[name='content']").math_length(); 
            
    $.fn.extend({    
        do_top:function(){    
            $(this).click(function(){   
//             jQuery.dotop($(this));
               jQuery.dotop($(this));
            });    
        } 
    });
    $(".do_top").do_top();
   $.fn.extend({    
        do_step:function(){    
            $(this).click(function(){   
               jQuery.dostep($(this));
            });    
        } 
    });
    $(".do_step").do_step();
    
    $('#comment_verify_image').click(
            function(){
            $('#comment_verify_image').attr('src',Siteurl +'/comment/verify_image?'+ Math.random());
            $('#comment_verify').focus();
            return false;
            }
    );
   
});
(function($){
    $.fn.slide=function($guest){
                            var form_comment = $('#form_comment');
                            var guest = form_comment.find("input[name='guest']").val();
//                            alert(guest);
                            if($guest && !guest){
                                      ship_mess_big('昵称不能为空');
                            }
                            
//                           form_comment.attr('action' , "index.php?do=comment&action=insert_comment");
                            var url = form_comment.attr('action');
                            var content = $("#content").val();
                            var id = form_comment.find("input[name='id']").val();
                            var model = form_comment.find("input[name='type']").val();
                            var verify = form_comment.find("input[name='comment_verify']").val();
                            if( content.length > 255){ ship_mess_big('评论内容不能超过255');return false;}                                                   
                            if(url){
                                    if(content && verify && model){
                                            $.ajax({
                                            url: Siteurl +'/comment/docomment',
                                            type: 'POST',
                                            data:{id:id,content:content,model:model,verify:verify,guest:guest},
                                            dataType: 'json',
                                            timeout: 10000,
                                            error: function(){alert('Error Comment');},
                                            success: function(data){
                                                if(data.stats =='-1'){
//                                                     var mess = '不支持匿名评论,请先登录！';
//                                                     show_login();
        //                                            location.href='logging.php';
                                                }else if(data.stats =='1'){
                                                    var mess = '评论成功！';
                                                    form_comment.find("input[name='verify']").val('');
                                                    form_comment.find('textarea').val('');
//                                                    $('#imgcaptcha').attr('src','captcha.php?sid=' + Math.random());
                                                    document.location.reload(); 
                                                }else{
                                                    var mess = data.mess;
                                                }
                                                ship_mess_big(mess);
                                            }
                                            });
                                    }else{
                                        ship_mess_big('您没有填写内容或者验证码！');return false;
                                    }
                          }
    };
    $.extend({
        dotop:function(obj){
              var $id = obj.parent().attr('data-id');
              var $type = obj.parent().attr('data-model');
              var $what = 'top';
              $.ajax({
                                            url: Siteurl +'/comment/upcomment',
                                            type: 'POST',
                                            data:{id:$id,what:$what,type:$type},
                                            dataType: 'json',
                                            timeout: 10000,
                                            error: function(){alert('Error Comment');},
                                            success: function(data){
                                                if(data.stats =='1'){
                                                    var mess = '评论成功！';
                                                    obj.find('em').html(parseInt(obj.find('em').html())+parseInt(1));
                                                }else{
                                                    var mess = data.mess;
                                                }
                                                ship_mess_big(mess);
                                            }
                                            });
        },
        dostep:function(obj){
              var $id = obj.parent().attr('data-id');
              var $type = obj.parent().attr('data-model');
              var $what = 'step';
              $.ajax({
                                            url: Siteurl +'/comment/upcomment',
                                            type: 'POST',
                                            data:{id:$id,what:$what,type:$type},
                                            dataType: 'json',
                                            timeout: 10000,
                                            error: function(){alert('Error Comment');},
                                            success: function(data){
                                                if(data.stats =='1'){
                                                    var mess = '评论成功！';
                                                    obj.find('em').html(parseInt(obj.find('em').html())+parseInt(1));
                                                }else{
                                                    var mess = data.mess;
                                                }
                                                ship_mess_big(mess);
                                            }
                                            });
        },
    });
    
})(jQuery);

function comment_btn(obj){
     jQuery("#comment_btn").slide(false);
}
function guestcomment_btn(obj){
    jQuery("#guest_comment_btn").slide(true);
}



$('#login_btn').click(function(){
     var returnurl = top.location.href;
     top.location.href= Siteurl +'/member/login?return_url='+returnurl+'#commentiframe';
})