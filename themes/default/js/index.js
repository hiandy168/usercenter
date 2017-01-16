jQuery(function($){
    //头部
    var headLi = $('.da_header ul li');
    //headLi.hover(function(){
      //  $(this).addClass('action').siblings().removeClass('action');
   // });

    //密码强度
    $('#pass').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        if (false == enoughRegex.test($(this).val())) {
            $('#passstrength01').css("background-color", "#e5e5e5");
            $('#passstrength02').css("background-color", "#e5e5e5");
            $('#passstrength03').css("background-color", "#e5e5e5");
        } else if (strongRegex.test($(this).val())) {
            $('#passstrength01').css("background-color", "#3d7bc2");
            $('#passstrength02').css("background-color", "#3d7bc2");
            $('#passstrength03').css("background-color", "#3d7bc2");
        } else if (mediumRegex.test($(this).val())) {
            $('#passstrength01').css("background-color", "#3d7bc2");
            $('#passstrength02').css("background-color", "#3d7bc2");
        } else {
            $('#passstrength01').css("background-color", "#3d7bc2");
        }
        return true;
    });
});
