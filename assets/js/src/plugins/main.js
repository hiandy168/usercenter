/**
 * Created by zhangwen on 13-12-9.
 */
//define(function(require, exports, module){
    //var $ = require('jquery');
    //require('bootstrap')($);
    //var validator = require('form_validator');
    //require('ajax_form');
    //require('jquery-ui');
    //require('hotkey')($);
    /*引入jQuery的扩展包*/
    //require('jquery_extend')($);
    
    
    var base_href = $('#base_href').val();

    //弹出框alert方法
    var alert = function(content, title, callback, close_callback){
        var html = '<div class="modal-body"><p>' + content + '</p></div>';
        if(!title && title === undefined){
            title = '提示';
        }
        var alertDialog = $(html).dialog({
            autoOpen: false,
            width: 250,
            modal: true,
            title: title,
            resizable: false,
            buttons: {
                "确定": function(){
                    if(callback && callback !== undefined){
                        callback();
                    }
                    $(this).dialog('close');
                }
            },
            close: function(){
                if(close_callback && close_callback !== undefined){
                    close_callback.call(this);
                }
                $(this).remove();
            }
        });
        alertDialog.dialog('open');
    }
    //ajax提交浮动层
    var alert_float = function(content){
        //提示框只会出现一个
        var _body = $('body');
        var _alert_length = _body.find('.alert_float').length;
        if(_alert_length > 0)
        {
            $('.alert_float').remove();
        }
        var html = $('<div class="alert_float label label-success">' + content + '</div>').hide();
        _body.append(html);
        html.fadeIn();
        var window_width = $(window).width();
        html.css({
            'left': '50%',
            'marginLeft': 0 - (html.width() / 2)
        });
        setTimeout(function(){
            html.fadeOut(function(){
                html.remove();
            });
        }, 3000);
    }
    //弹出警告层
    var alert_warning = function(content){
        //提示框只会出现一个
        var _body = $('body');
        var _alert_length = _body.find('.alert_float').length;
        if(_alert_length > 0)
        {
            $('.alert_float').remove();
        }
        var html = $('<div class="alert_float label label-warning">' + content + '</div>').hide();
        _body.append(html);
        html.fadeIn();
        var window_width = $(window).width();
        html.css({
            'left': '50%',
            'marginLeft': 0 - (html.width() / 2)
        });
        setTimeout(function(){
            html.fadeOut(function(){
                html.remove();
            });
        }, 3000);
    }
    //弹出确认层
    var confirm = function(content, title, callback){
        var html = '<div class="modal-body"><p>' + content + '</p></div>';
        if(!title && title === undefined){
            title = '请确认';
        }
        var result = false;
        var confirmDialog = $(html).dialog({
            autoOpen: false,
            width: 300,
            modal: true,
            title: title,
            resizable: false,
            buttons: {
                "确定": function(){
                    if(callback && callback !== undefined){
                        callback();
                    }
                    $(this).dialog('close');
                },
                "取消": function(){
                    $(this).dialog('close');
                }
            },
            close: function(){
                $(this).remove();
                return result;
            }
        });
        confirmDialog.dialog('open');
    };
    //弹出确认层
    var getUrl = function(content, title){
        var html = '<div class="modal-body"><p>' + content + '</p></div>';
        var result = false;
        var confirmDialog = $(html).dialog({
            autoOpen: false,
            width: 620,
            modal: true,
            title: title,
            resizable: false,
            buttons: {
                "确定": function(){
                    $(this).dialog('close');
                }
            },
            close: function(){
                $(this).remove();
                return result;
            }
        });
        confirmDialog.dialog('open');
    };
    //图片上传弹出框
    var img_upload = function(options){
        var defaults = {
            file_name: 'imgFile',
            upload_url: 'login'
        }
        options = $.extend({}, defaults, options);
        var form_id = Math.floor(Math.random() * ( 100000000 + 1));
        var html =  '<div class="img_upload_form"><form method="post" id="' + form_id + '" enctype="multipart/form-data" action="' + options.upload_url + '"><input readonly="readonly" class="vb_input" style="width:165px;height:37px;vertical-align: top; float:left;" type="text" id="upload_text"/><div style="float: left;width: 105px;overflow: hidden;position: relative"><button type="button" style="margin-left: 5px;" class="vb_btn_small vb_btn_gray">选择图片' +
            '</button><input type="file" style="position: absolute; top: 0;right:0;opacity: 0;filter: alpha(opacity=0);" name="' + options.file_name + '" id="' + options.file_name + '"/></div></form></div>';
        var imgDialog = $(html).dialog({
            autoOpen: false,
            width: 330,
            modal: true,
            title: '上传图片',
            resizable: false,
            buttons: {
                "上传": function () {
                    var _self = $(this);
                    var _self_btn = _self.parents('.ui-dialog').find('.ui-dialog-buttonset button').eq(0);
                    if(_self_btn.hasClass('disabled')) return false;
                    $('#' + form_id).ajaxSubmit({
                        dataType: 'JSON',
                        beforeSend: function(){
                            _self_btn.addClass('disabled').addClass('btn');
                            _self_btn.html('<i style="font-size: 20px" class="icon-spinner icon-spin"></i>');
                        },
                        success: function(data){
                            if(parseInt(data.error) === 1){
                                alert(data.msg);
                                _self.dialog('close');
                            }else{
                                if(options.success && options.success !== undefined){
                                    options.success(data);
                                    _self.dialog('close');
                                }else{
                                    alert('上传成功' + data.img_src);
                                    _self.dialog('close');
                                }
                            }
							$(document).find('input[type="hidden"]').change();
                        },
                        error: function(){
                            alert('网络错误,请重试');
                            _self_btn.removeClass('disabled').removeClass('btn');
                            _self_btn.text('上传');
                        }
                    });
                },
                "取消": function () {
                    $(this).dialog('close');
                }
            },
            close: function(){
                $(this).remove();
            }
        });
        imgDialog.dialog('open');
        $(document).on('change', '#' + form_id + ' #' + options.file_name, function(){
            var local_img = $(this).val();
            $('#' + form_id + ' #upload_text').val(local_img);
        });
    };
    //文件上传弹出框
       var file_upload = function(options){
        var defaults = {
            file_name: 'Files',
            upload_url: 'login'
        }
        options = $.extend({}, defaults, options);
        var form_id = Math.floor(Math.random() * ( 100000000 + 1));
        var html =  '<div class="img_upload_form"><form method="post" id="' + form_id + '" enctype="multipart/form-data" action="' + options.upload_url + '"><input readonly="readonly" class="vb_input" style="width:165px;height:37px;vertical-align: top; float:left;" type="text" id="upload_text"/><div style="float: left;width: 105px;overflow: hidden;position: relative"><button type="button" style="margin-left: 5px;" class="vb_btn_small vb_btn_gray">选择文件' +
            '</button><input type="file" style="position: absolute; top: 0;right:0;opacity: 0;filter: alpha(opacity=0);" name="' + options.file_name + '" id="' + options.file_name + '"/></div></form></div>';
        var imgDialog = $(html).dialog({
            autoOpen: false,
            width: 330,
            modal: true,
            title: '上传文件',
            resizable: false,
            buttons: {
                "上传": function () {
                    var _self = $(this);
                    var _self_btn = _self.parents('.ui-dialog').find('.ui-dialog-buttonset button').eq(0);
                    if(_self_btn.hasClass('disabled')) return false;
                    $('#' + form_id).ajaxSubmit({
                        dataType: 'JSON',
                        beforeSend: function(){
                            _self_btn.addClass('disabled').addClass('btn');
                            _self_btn.html('<i style="font-size: 20px" class="icon-spinner icon-spin"></i>');
                        },
                        success: function(data){
                            if(parseInt(data.error) === 1){
                                alert(data.msg);
                                _self.dialog('close');
                            }else{
                                if(options.success && options.success !== undefined){
                                    options.success(data);
                                    _self.dialog('close');
                                }else{
                                    alert('上传成功' + data.img_src);
                                    _self.dialog('close');
                                }
                            }
							$(document).find('input[type="hidden"]').change();
                        },
                        error: function(){
                            alert('网络错误,请重试');
                            _self_btn.removeClass('disabled').removeClass('btn');
                            _self_btn.text('上传');
                        }
                    });
                },
                "取消": function () {
                    $(this).dialog('close');
                }
            },
            close: function(){
                $(this).remove();
            }
        });
        imgDialog.dialog('open');
        $(document).on('change', '#' + form_id + ' #' + options.file_name, function(){
            var local_img = $(this).val();
            $('#' + form_id + ' #upload_text').val(local_img);
        });
    };

    //ajax加载页面
    var ajax_load_right = function(options){
        var defaults = {
            url: base_href + '',
            type: 'GET',
            html_cont: '#right_opera_panel',
            beforeSend: function(){
                $('.page_loading_cont').show();
            },
            error: function(){
                alert_float('网络错误！请重试！');
                $('.page_loading_cont').hide();
                return false;
            }
        };
        options = $.extend({}, defaults, options);
        //判断是否有成功的回调函数
        if(!options.success || options.success === undefined){
            options.success = function(data){
                $('.page_loading_cont').hide();
                $(options.html_cont).html(data);
            }
        }else{
            var _success = options.success;
            options.success = function(data){
                _success(data);
                $('.page_loading_cont').hide();
            }
        }
        $.ajax(options);
    }

    //form弹出层
    var form_dialog = function(options){
        var defaults = {
            content : '请确定！',
            title : '提示',
            url: '',
            width: 300,
            //form_rules 需要在表单的ajax执行前执行的验证动作，返回true或者false，默认返回true
            form_rules: function(){
                return true;
            }
        };
        var form_id = Math.floor(Math.random() * ( 100000000 + 1));
        options = $.extend({}, defaults, options);
        if(options.url && options.url !== undefined && options.url !== ''){
            options.content = '<div class="form_dialog"><form id="form_dialog_' + form_id + '" action="' + options.url + '" method="post">' + options.content + '</form></div>';
        }else{
            options.content = '<div class="form_dialog">' + options.content + '</div>';
        }
        var is_ajax = false;
        var formDialog = $(options.content).dialog({
            autoOpen: false,
            width: options.width,
            modal: true,
            title: options.title,
            resizable: false,
            buttons: {
                "提交": function(){
                    var _self = $(this);
                    var _self_btn = _self.parents('.ui-dialog').find('.ui-dialog-buttonset button').eq(0);
                    var form_rules = options.form_rules();
                    if(form_rules === true){
                        var _self = $(this);
                        var _self_btn = _self.parents('.ui-dialog').find('.ui-dialog-buttonset button').eq(0);
                        if(options.url && options.url !== undefined && options.url !== ''){
                            //防止ajax重复提交
                            if(!is_ajax){
                                $('#form_dialog_' + form_id).ajaxSubmit({
                                    dataType: 'JSON',
                                    beforeSend: function(){
                                        is_ajax = true;
                                        _self_btn.addClass('disabled').addClass('btn');
                                        _self_btn.text('提交中...');
                                    },
                                    success: function(data){
                                        if(options.callback && options.callback !== undefined){
                                            _self_btn.removeClass('disabled').removeClass('btn');
                                            _self_btn.text('提交');
                                            options.callback(data, _self);
                                        }else{
                                            alert_float('提交成功！');
                                            _self_btn.removeClass('disabled').removeClass('btn');
                                            _self_btn.text('提交');
                                            _self.dialog('close');
                                        }
                                        is_ajax = false;
                                    },
                                    error: function(){
                                        alert_float('网络错误,请重试');
                                        _self_btn.removeClass('disabled').removeClass('btn');
                                        _self_btn.text('提交');
                                        is_ajax = false;
                                    }
                                });
                            }
                        }else{
                            if(options.callback && options.callback !== undefined){
                                options.callback($(this));
                            }else{
                                $(this).dialog('close');
                            }
                        }
                    }
                },
                "取消": function(){$(this).dialog('close');}
            },
            close: function(){
                $(this).remove();
            }
        });
        formDialog.dialog('open');
    }


    //弹出ajax调取的页面
    var alert_ajax_cont = function(options){
        var defaults = {
            url: base_href + '',
            type: 'get',
            title : '提示',
            width: 600,
            height: 'auto',
            beforeSend: function(){
                $('.page_loading_cont').show();
            },
            dialog_create: function(){},
            error: function(){
                alert_float('网络错误！请重试！');
                $('.page_loading_cont').hide();
            },
            buttons:{
                "提交": function(){
                    if(options.callback && options.callback !== undefined){
                        options.callback($(this));
                    }else{
                        $(this).dialog('close');
                    }
                },
                "取消": function(){$(this).dialog('close');}
            }
        }
        options = $.extend({}, defaults, options);
        var dialog_html = '';
        if(options.success && options.success !== undefined){
            var _success = options.success;
        }
        options.success = function(data){
            dialog_html = '<div class="dialog_cont">' + data + '</div>';
            var ajaxDialog = $(dialog_html).dialog({
                autoOpen: false,
                width: options.width,
                height: options.height,
                modal: true,
                title: options.title,
                resizable: false,
                buttons: options.buttons,
                beforeClose:function(){
                    if(options.beforeClose && options.beforeClose !== undefined){
                        return options.beforeClose($(this));
                    }
                    return true;
                },
                create: function(event, ui){
                    options.dialog_create.apply(this,arguments);
                },
                close: function(){
                    $(this).remove();
                }
            });
            ajaxDialog.dialog('open');
            if(_success && _success !== undefined){
                _success(data);
            }
            $('.page_loading_cont').hide();
        }

        $.ajax(options);
    }

    var alert_page_dialog = function(options){
        var defaults = {
            type: 'get',
            title : '提示',
            width: 600,
            buttons:{
                "确认": function(){
                    if(options.callback && options.callback !== undefined){
                        options.callback($(this));
                    }else{
                        $(this).dialog('close');
                    }
                },
                "取消": function(){$(this).dialog('close');}
            },
            dialog_create: function(){},
            close_callback: function(){}
        }
        options = $.extend({}, defaults, options);
        var _window_h = $(window).height() - 200;
        var dialog_html = '<div class="dialog_cont" style="max-height: ' + _window_h + 'px">' + options.content + '</div>';
        var ajaxDialog = $(dialog_html).dialog({
            autoOpen: false,
            width: options.width,
            modal: true,
            title: options.title,
            resizable: false,
            buttons: options.buttons,
            create: function(event, ui){
                options.dialog_create.apply(this,arguments);
            },
            close: function(){
                options.close_callback.call(this);
                $(this).remove();
            }
        });
        ajaxDialog.dialog('open');
    }

    var strlen = function(str){
        var len = 0;
        for (var i=0; i<str.length; i++) {
            var c = str.charCodeAt(i);
            //单字节加1
            if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
                len++;
            }
            else {
                len+=2;
            }
        }
        return len;
    }

    var siteStrlen = function(obj, len){
        var str = obj.val();
        var _len = strlen(str);
        return _len <= len && _len !== 0 ? true : false;
    }
    
    //初始化事件
    $(function(){
        $(document).ajaxSuccess(function(event,data){
            //vking, 如果没有登录跳转到登录页面
            if(data.responseText.indexOf('"error":1')>-1){
                eval("var json="+data.responseText);
                if(typeof json.url != 'undefined' && json.url != ''){
                    if(json.clear==true){
                        try{
                            D.login.loginOut(function(){
                                setTimeout(function(){
                                    location.href=json.url;
                                },500);
                            });
                        }catch(ex){
                            location.href=json.url;
                        }
                    }else{
                        location.href=json.url;
                    }
                }
            }
        });
        $.getScript('http://pingjs.qq.com/ping.js',function(){
            if(typeof(pgvMain) == 'function')pgvMain();
        });
        setMainH();
        $(window).resize(function() {
            setMainH();
        });
        function setMainH(){
            var _window_h = $(window).height();
            var _min_main_height = _window_h - 70 - 237;
            var _main_height = $('#main_content').height();
            if(_main_height < _min_main_height){
                $('#main_content').css('minHeight', _min_main_height);
            }
        }

        var url_href = window.location.href.toLowerCase();
        var nav_flag = false;
        var $li=$('.nav-bar li');
        for(var i=$li.length-1;i>0;i--){
            var nav_href = $li.eq(i).find('a').attr('href');
            if(url_href.indexOf(nav_href)>-1){
                $li.eq(i).addClass('active');
                nav_flag=true;
                break;
            }
        }
        var _dropNav = $('.header .dropdown a');
        _dropNav.each(function(i){
            var _url = $(this).attr('href');
            if(url_href.indexOf(_url.toLowerCase()) > -1){
                if(i === 0){
                   return false;
                }
                $('.header .dropdown a').eq(0).appendTo($('.header .dropdown'));
                $(this).insertBefore($('.header .dropdown img'));
                return false;
            }
        });
        if(!nav_flag){
            $('.nav-bar li').eq(1).addClass('active');
        }
       
        //失去焦点后验证表单事件
        function checkBlur(obj){
            var pattern = obj.attr('data-pattern');
            var tag_name = obj[0].tagName;
            if(pattern && pattern !== undefined && pattern !== 'undefined'){
                if(tag_name === 'SELECT'){
                    var check = checkSelect(obj);
                }else{
                    var check = checkInput(obj);   
                }
                var msg_pos = obj.parents('form').attr('data-msg-pos');
                if(!check && check !== undefined){
                    var msg = obj.attr('data-msg');
                    if(msg && msg !== undefined){
                        if(msg_pos === 'right'){
                            insert_error(msg, obj);
                        }else{
                           alert_error(msg, obj.parents('form'));
                        }
                    }
                }else{
                    if(msg_pos === 'right'){
                        clear_error(obj);
                    }else{
                        clear_error(obj.parents('form'));
                    }
                }
            }
        }
        //绑定事件
        $(document).on('blur', 'input, textarea', function(){
            if($(this).attr('data-blur') !== 'false'){
                checkBlur($(this));
            }
        });
		//触发上传事件
	    $(document).on('change', 'input', function(){
            if($(this).attr('data-pattern') !== undefined){
                checkBlur($(this));
            }
        });
        $(document).on('blur', '.editor', function(){
            if($(this).attr('data-blur') !== 'false'){
                checkBlur($('#' + $(this).parent().attr('id').replace('editor_cont', '')));
            }
        });
        $(document).on('change', 'select', function(){
            if($(this).attr('data-blur') !== 'false'){
                checkBlur($(this)); 
            }
        });
        //ajax提交表单方法
        //var form_ajax_init = exports.form_ajax_init = function(){
        var form_ajax_init = function(){
            $(document).off('submit', 'form');
            $(document).on('submit', 'form', function(e){
                var _self = $(this);
                if(_self.parents('.ui-dialog-content').length > 0){
                    e.preventDefault();
                    $(this).parents('.ui-dialog').find('.ui-dialog-buttonpane').find('button').eq(0).trigger('click');
                    return false;
                }
                var submit_btn = _self.find('button[type="submit"]');
                var old_text = submit_btn.text();
                //注册全局ajax回调函数
                var is_ajax = $(this).attr('data-ajax');
                var msg_pos = $(this).attr('data-msg-pos');
                //表单验证
                try{
                    var validator_result = form_validator($(this));
                }catch(e){
                    window.alert(e);
                }
                
                //判断表单验证
                if(validator_result['success'] === true){
                    //判断是否需要ajax提交表单
                    if(is_ajax !== 'false' && is_ajax === 'true'){
                        e.preventDefault();
                        $(this).ajaxSubmit({
                            dataType: 'JSON',
                            beforeSend: function(){
                                $('.page_loading_cont').show();
                                submit_btn.prop('disabled', true);
                                submit_btn.addClass('disabled');
                                submit_btn.text('提交中...');
                            },
                            success: function(data){
                                $('.page_loading_cont').hide();
                                submit_btn.prop('disabled', false);
                                submit_btn.removeClass('disabled');
                                if(parseInt(data.error) === 0){
                                    var msg = data.msg && data.msg !== undefined ? data.msg : '提交成功!';
                                    submit_btn.prop('disabled', false);
                                    submit_btn.removeClass('disabled');
                                    submit_btn.text(old_text);
                                    alert_float(msg);
                                    if(data.url && data.url !== undefined){
                                        setTimeout(function(){
                                            window.location.href = data.url;
                                        },1000);
                                    }
                                }
                                /*else if(parseInt(data.error) === 3)
                                {
                                    var _data= eval('('+data.data+')');
                                    confirm(data.title, '提示!', function(){
                                        $.ajax({
                                            url: base_href + data.url,
                                            type: 'post',
                                            dataType: 'json',
                                            data: _data,
                                            beforeSend: function(){
                                                $('.page_loading_cont').show();
                                            },
                                            success: function(data){
                                                $('.page_loading_cont').hide();
                                                if(parseInt(data.error) === 0){
                                                    var msg = data.msg !== undefined ? data.msg : '操作成功!';
                                                    alert_float(msg);
                                                }else{
                                                    var msg = data.msg !== undefined ? data.msg : '操作失败!';
                                                    alert_warning(msg);
                                                }
                                            },
                                            error: function(){
                                                $('.page_loading_cont').hide();
                                                alert_warning('网络错误！请重试！');
                                            }
                                        });
                                    });
                                }*/
                                else{
                                    var msg = data.msg && data.msg !== undefined ? data.msg : '提交失败!';
                                    alert_warning(msg);
                                    submit_btn.prop('disabled', false);
                                    submit_btn.removeClass('disabled');
                                    submit_btn.text(old_text);
                                }
                            },
                            error: function(){
                                $('.page_loading_cont').hide();
                                alert_warning('网络错误,请重试！');
                                submit_btn.prop('disabled', false);
                                submit_btn.removeClass('disabled');
                                submit_btn.text(old_text);
                            }
                        });
                    }
                }else{
                    //判断表单错误信息出现的方向
                    if(msg_pos === 'right'){
                        if($('.img_text_item').length > 0){
                            var obj = validator_result['obj'];
                            var flag = false;
                            if(!obj.parents('.img_text_item').hasClass('on')){
                                flag = true;
                            }
                            if(flag){
                                $('.img_text_item.on').find('.img_text_content').slideUp(500, function(){
                                    $('.img_text_item.on').removeClass('on');
                                })
                            }
                            obj.parents('.img_text_content').slideDown(500, function(){
                                obj.parents('.img_text_item').addClass('on');
                            });
                            insert_error(validator_result['error_msg'], obj);
                        }else{
                            var obj = $('input[data-msg="' + validator_result['error_msg'] + '"]');
                            if(obj.length < 1){
                                obj = $('textarea[data-msg="' + validator_result['error_msg'] + '"]');
                            }
                            if(obj.length < 1){
                                obj = $('select[data-msg="' + validator_result['error_msg'] + '"]');
                            }
                            insert_error(validator_result['error_msg'], obj);
                        }
                    }else{
                        var obj = $(this);
                        valert_error(validator_result['error_msg'], obj);
                    }
                    e.preventDefault();
                    return false;
                }
            });
        }
        form_ajax_init();
        //退出图片切换
        $('#user_quit').hover(function(){
            var url = base_href + '/assets/img/power_.png';
            $(this).attr("src",url);
        },function(){
            var new_url = base_href + '/assets/img/power.png';
            $(this).attr("src",new_url);
        });
        //QQ 登录组件
        try{
            D.login(
                function() {
                    var info = D.login.getInfo();
                    $('#userinfo').html('<img class="nick_img" style="width:30px;height:30px;" id="h'+info.uin+'" /><span class="nick">'+info.nick+'</span>');
                    D.login.getFace(info.uin);
                },
                function () {
                    $('#userinfo').html('非QQ用户');
                }
            );
        }catch(e){}

        $('#user_quit').click(function(e){
            e.preventDefault();
            that=this;
            try{
                D.login.loginOut(function(){
                    setTimeout(function(){
                        location.href=that.href;
                    },500);
                });
            }catch(ex){
                location.href=that.href;
            }
        });
    })

    //分页类
    var page = function(options){
        var defaults = {
            page_cont: 'page',
            action_url: base_href + '',
            is_ajax: true,
            current_page: 1,
            type: 'post',
            dataType: 'JSON',
            page_url: base_href + '',
            data: {"per_number":1,"cur_page":1},
            beforeSend: function(){
                $('.page_loading_cont').show();
            },
            success: function(){
                $('.page_loading_cont').hide();
            },
            error: function(){
                $('.page_loading_cont').hide();
                alert_float('网络错误！请重试！');
            }
        };
        options = $.extend({}, defaults, options);
        options.current_page = options.data.cur_page;
        options.page_count = parseInt(options.page_count);
        var page_html = '<div class="pagination"><ul>';
        if(options.current_page === 1){
            page_html += '<li class="disabled"><a>首页</a></li>';
        }else{
            page_html += '<li><a data-page="1" href="' + options.page_url + '&page=1' + '">首页</a></li>';
        }

        var page_start = options.current_page - 2 > 0 ? options.current_page - 2 : 1;
        var page_end = page_start + 4 >= options.page_count ? options.page_count :  page_start + 4;

        if(page_start > 1){
            page_html += '<li><a data-page="' + (options.current_page - 3) + '" href="' + options.page_url + '&page=' +(options.current_page - 3) + '"><<<</a></li>';
        }

        for(var i = page_start; i<=page_end; i++){
            if(i === options.current_page){
                page_html += '<li class="disabled current"><a>' + i + '</a></li>';
            }else{
                page_html += '<li><a data-page="'+ i +'" href="' + options.page_url + '&page=' + i + '">' + i + '</a></li>'
            }
        }

        if(page_end < options.page_count){
            page_html += '<li><a data-page="'+ (page_start + 5) +'" href="' + options.page_url + '&page=' +(page_start + 5) + '">>>></a></li>';
        }

        if(options.current_page === options.page_count){
            page_html += '<li class="disabled"><a>尾页</a></li>';
        }else{
            page_html += '<li><a data-page="'+ options.page_count +'" href="' + options.page_url + '&page=' + options.page_count + '">尾页</a></li>';
        }

        page_html += '</ul></div>';
        $('#' + options.page_cont).html(page_html);
        $(document).off('click', '#' + options.page_cont + ' a');
        $(document).on('click', '#' + options.page_cont + ' a', function(e){
            if(options.is_ajax && $(this).attr('href') !== '' && $(this).attr('href') !== undefined){
                e.preventDefault();
                var click_page = $(this).attr('data-page');
                options.data.cur_page = click_page;
                $.ajax({
                    url: options.action_url,
                    type: options.type,
                    data: options.data,
                    dataType: options.dataType,
                    beforeSend: options.beforeSend,
                    success: function(data){
                        $('.page_loading_cont').hide();
                        options.success(data);
                        options.current_page = parseInt(click_page);
                        options.data.cur_page = parseInt(click_page);
                        options.page_count = parseInt(data.page_count);
                        return page(options);
                    },
                    error: options.error
                });
            }
        });
    }
    
    
    //在页面上添加loading画面的方法
    var loading = function(action){
        var _page_loading_cont;
        if (top.location !== self.location){
            _page_loading_cont = $(top.document).find('.page_loading_cont');
        }else{
            _page_loading_cont = $('.page_loading_cont');
        }
        
        if(_page_loading_cont.length > 0){
            var _loading_ele = _page_loading_cont;
        }else{
            var _html = '<div class="page_loading_cont" style="display: none;">' + 
                        '<div class="page_loading"></div>' +
                        '<div class="page_modal"></div>' +
                        '</div>';
            $(top).find('body').append('_html');
            var _loading_ele = $('.page_loading_cont');
        }
        
        if(action === 'show'){
            _loading_ele.show();
        }else{
            _loading_ele.hide();
        }
    }
   

   // exports.alert = alert;
   // exports.img_upload = img_upload;
   // exports.file_upload =file_upload;
   // exports.form_dialog = form_dialog;
//    exports.strlen = window.strlen = strlen;
//    exports.siteStrlen = window.siteStrlen = siteStrlen;
//    exports.confirm = confirm;
//    exports.base_href = base_href;
//    exports.alert_float = alert_float;
//    exports.alert_warning = alert_warning;
//    exports.ajax_load_right = ajax_load_right;
//    exports.alert_ajax_cont = alert_ajax_cont;
//    exports.alert_page_dialog = alert_page_dialog;
//    exports.loading = loading;
//    exports.page = page;
//    exports.getUrl = getUrl;
//    exports.$ = window.$ = $;
//    exports.validator = window.validator = validator;
//});