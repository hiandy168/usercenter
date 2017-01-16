/**
 * Created by zhangwen on 13-12-9.
 */

//define(function(require, exports, module) {
    //var main = require('main');
    //var editor_init = require('editor_init');
   // require('timepicker')($);
    $(function() {
        startInit();
        endInit();
        editor_init({
            id: 'editer',
            //upload_url: main.base_href + '/upload/image'
            upload_url: '/upload/image'
        });
        $('.nav-bar li').eq(1).removeClass('active');
        $('input.datepicker').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            minDate: new Date()
        },
        $.datepicker.regional["zh-CN"]);
        $.datepicker.regional["zh-CN"] = {
            closeText: "关闭",
            prevText: "&#x3c;上月",
            nextText: "下月&#x3e;",
            currentText: "今天",
            monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthNamesShort: ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十", "十一", "十二"],
            dayNames: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"],
            dayNamesShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六"],
            dayNamesMin: ["日", "一", "二", "三", "四", "五", "六"],
            weekHeader: "周",
            dateFormat: "yy-mm-dd",
            firstDay: 1,
            isRTL: !1,
            showMonthAfterYear: !0,
            yearSuffix: "年"
        }
        $.datepicker.setDefaults($.datepicker.regional["zh-CN"]);
        $(document).ajaxSend(function(event, xhr, options) {
            if (options.dataType && options.dataType !== undefined) {
                if (options.dataType.toLowerCase() === 'json') {
                    return false;
                }
            }
            activity_save();
        });
        $(document).ajaxStop(function() {
            if ($('input[name="FStartTime"]').length > 0 && $('input[name="FEndTime"]').length > 0) {
                $('input.datepicker').datetimepicker("destroy");
                startInit();
                endInit();
            }

        });
        
        
        $('#add_win_set').click(function(){
                    var $html='';
                    if($('.win_set').length>=3){
                      $html += '<div class=\"win_set\" style="position:relative"><span class=\"del_this\" style="position:absolute;left:580px;top:-20px ; cursor:pointer">删除本项</span>';
                    }else{
                      $html += '<div class=\"win_set\" style="position:relative">';
                    }
  
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">自定义名称：</span><input type=\"text\"  value=\"\" name=\"p_title[]\" placeholder=\"一等奖\" data-msg=\"不能为空\" data-pattern=\"require\"></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品名称：</span><input type=\"text\"  value=\"\" name=\"p_name[]\" placeholder=\"iphone\"  data-msg=\"不能超于50个字符\" data-pattern=\"require\" ></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品数量：</span><input type=\"text\"  value=\"\" name=\"p_num[]\"  placeholder=\"10\"  data-msg=\"请填写奖品数量\" data-pattern=\"require\"></p>';
                      $html += '<p><span style=\"display:block;width:240px;float:left;text-align:right\">奖品概率：</span><input type=\"text\"  value=\"\" name=\"p_v[]\" placeholder=\"5\" data-msg=\"请填入一个整数\" data-pattern=\"require\" ><span style="margin:0 5px;font-size:12px;" >填入整数5就是中奖概率为5%</span></p>';
                      $html += '<hr>';
                      $html += '</div>';
                $($html).insertBefore($('#add_win_set'));
        });
        
        $('#iframe_form').delegate(".del_this","click",function(){
               $(this).parent().remove();
        });
        
        $('#add_input').click(function(){
                    var $html='';
                    if($('.alert_input').length>=2){
                      $html += '<div class=\"alert_input\" style="position:relative"><span class=\"del_this\" style="position:absolute;left:580px;top:-20px ; cursor:pointer">删除本项</span>';
                    }else{
                      $html += '<div class=\"alert_input\" style="position:relative">';
                    }
                    $html += '<p><span style="display:block;width:240px;float:left;text-align:right">自定义名称：</span><input type="text"  value="" name="input_name[]" ><span style="margin:0 5px;font-size:12px;" >提交的属性</span></p>';
                    $html += '<p><span style="display:block;width:240px;float:left;text-align:right">初始内容：</span><input type="text"  value="" name="input_value[]" ><span style="margin:0 5px;font-size:12px;" >提交的value</span></p>';
                    $html += '<hr>';
                    $html += '</div>';
                $($html).insertBefore($('#add_input'));
        });
        
     parent.window.triggerIframeSubmit = function() {
        console.log("parent.window.triggerIframeSubmit");
         var has_input=0;
        $("input[name='input[]']").each(function(){
            if(this.checked){
               has_input++;
            }
        });
    
        //if(!has_input && ($("#iframe_form").attr('data-name') !='input') ){
           // var $required = $("<span style='height:22px;line-height:22px;color:#ff0000;margin:5px'>必选一项</span>"); //创建元素
         //   $('.f_input').find('span').remove();
          //  $('.f_input').append($required);
          //  return false;
        //}
        //$("#iframe_form").trigger("submit");
        $("#iframe_form").submit();
    };
    
    
    });

    function startInit(date) {
        var maxDate = date === '' || date === undefined ? '' : new Date(date);
        var maxDay = maxDate === '' ? '' : maxDate.getDate() - 1;
        if (date !== '' && date !== undefined) {
            var maxDate = new Date(date);
            maxDate.setDate(maxDate.getDate() - 1);
        } else {
            var maxDate = '';
        }
        $('input[name="FStartTime"]').datetimepicker('destroy');
        $('input[name="FStartTime"]').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            maxDate: maxDate,
            minDate: date === '' || date === undefined ? new Date() : '',
            onSelect: function(dateText, inst) {
                endInit(dateText.split('-'));
            }
        },
        $.datepicker.regional["zh-CN"]);
    }
    function endInit(date) {
        date = date === '' || date === undefined ? new Date() : new Date(date);
        date.setDate(date.getDate() + 1);
        $('input[name="FEndTime"]').datetimepicker("destroy");
        $('input[name="FEndTime"]').datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: "yy-mm-dd",
            minDate: date,
            onSelect: function(dateText, inst) {
                startInit(dateText.split('-'));
            }
        },
        $.datepicker.regional["zh-CN"]);
    }









    $('.edit_activtity').click(function() {
        var thishref = $(this).attr('data-href');console.log(thishref);
        var $html = '<iframe id="right_opera_panel_iframe" name="right_opera_panel_iframe" src="' + thishref + '">';
        $('#right_opera_panel').html($html);

    });
    $('.del_activtity').click(function() {
        that = $(this);
        var thishref = that.attr('data-href');
        main.confirm('确认删除？', '确认', function() {
            $.post(thishref, {}, function(data) {
                if (data.error == 0) {
                    that.parent().parent().remove();
                } else {
                    main.alert_warning(data.msg);
                }
            },
                    'json');

        });
    })
    
   
    //红包的添加图片     轮播图也在使用
    $(document).on('click','.img_uplode_local',
            function() {
                var $this = $(this);
                var data_id = $this.attr('data-id');
                var id = '#img_' + data_id;
                var img_id = '#onload_image_' + data_id;
                main.img_upload({
                    upload_url: base_href + '/upload/imagelocal',
                    success: function(data)
                    {
                        $this.val('更换图片');
                        $(id).val(data.img_src);
                        $(img_id).attr('src', data.img_src);
                        $(img_id).show();
                    }
                });
            });
            
  //红包的添加图片     轮播图也在使用
    $(document).on('click','.upload_img',
            function() {
                var $this = $(this);
                var data_id = $this.attr('data-id');
                var id = '#img_' + data_id;
                var img_id = '#onload_image_' + data_id;
                img_upload({
                    upload_url: base_href + '/upload/image',
                    success: function(data)
                    {
                        $this.val('更换图片');
                        $(id).val(data.img_src);
                        $(img_id).attr('src', data.img_src);
                        $(img_id).show();
                    }
                });
            });
    
    $('.upload_excel').click(
            function() {
                var $this = $(this);
                var data_id = $this.attr('data-id');
                var id = '#excel_' + data_id;
                var excel_id = '#onload_excel_' + data_id;
                main.file_upload({
                    upload_url: base_href + '/upload/File',
                    success: function(data)
                    {
                        $this.val('更换excel');
                        $(id).val(data.img_src);
                        $(excel_id).html(data.img_src);
                    }
                });
            });
    //
    
    


//});