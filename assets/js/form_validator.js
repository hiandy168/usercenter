/**
 * Created by zhangwen on 13-12-9.
 */
//define(function(require, exports, module){
   // var main = require('main');
    //顶部错误提示层
    var alert_error = function (msg, obj){
        var error_html = '<div class="alert alert-block alert-error fade in">' +
                         '<button type="button" class="close" data-dismiss="alert">×</button>' +
                         '<p class="alert-heading">' + msg + '</p></div>';
        if(obj.find('.alert').length > 0){
            obj.find('.alert').remove();
        }
        if(obj.find('legend').length > 0){
            $(error_html).insertAfter(obj.find('legend'));
        }else{
            obj.prepend($(error_html));
        }
    }
    //右侧错误提示层
    var insert_error = function(msg, obj){
        var html_obj = obj.parents('.control-group').find('span.help-inline');
        var old_text;
        if(html_obj.length < 1){
            html_obj = $('<span class="help-inline">*</span>');
            html_obj.insertAfter(obj);
            old_text = '*';
        }else{
            old_text = html_obj.attr('data-text');
            if(old_text === '' || old_text === undefined){
                old_text = html_obj.text();
                html_obj.attr('data-text', old_text);
            }
        }
        html_obj.html(msg);
        obj.parents('.control-group').addClass('error');
        var tag_name = obj[0].tagName;
        var event = tag_name === 'TEXTAREA' ? 'input' : 'change';
        
        obj.on(event, function(){
            obj.parents('.control-group').removeClass('error');
            obj.parents('.control-group').find('span.help-inline').html(old_text);
        });
    }
    
    //清楚表单错误信息
    var clear_error = function(obj){
        var tag_name = obj[0].tagName;
        if(tag_name === 'FORM'){
            obj.find('.alert').remove();
        }else{
            obj.parents('.control-group').removeClass('error');
            var error_ele = obj.parents('.control-group').find('span.help-inline');
            error_ele.html(error_ele.attr('data-text'));
        }
    }
    //表单单项验证
    var input_validator = function(obj, type){
        var reg_text;
        switch(type){
            case 'uname':
                reg_text = /^[\w]{4,16}$/;
                break;
            case 'idcard':
                reg_text = /(^\d{15}$)|(^\d{17}(\d|X|x)$)/;
                break;
            case 'email':
                reg_text = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                break;
            case 'num':
                reg_text = /^([+-]?)\d*\.?\d+$/;
                break;
            case 'url':
                reg_text = /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/;
                break;
            case 'pwd':
                reg_text = /^[\w]{6,20}$/;
                break;
            case 'mobile':
                reg_text = /^(13|15|18)[0-9]{9}$/;
                break;
			case 'tel':
				reg_text = /(^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/;
				break;
            case 'require':
                reg_text = 'require';
                break;
            case 'qq':
                reg_text = /^\d{5,13}$/;
                break;
            case 'sitename':
                reg_text = /^[\s\S]{1,12}$/;
                break;
            case 'no_special':
                reg_text = /^[a-zA-Z0-9\u0391-\uFFE5]{1,10}$/;
                break;
            case 'length_10':
                reg_text = /^[\s\S]{1,10}$/;
                break;
            case 'length_12':
                reg_text = /^[\s\S]{1,12}$/;
                break;
            case 'length_14':
                reg_text = /^[\s\S]{1,14}$/;
                break;
            case 'length_20':
                reg_text = /^[\s\S]{1,20}$/;
                break;
            case 'length_40':
                reg_text = /^[\s\S]{1,40}$/;
                break;
            case 'length_50':
                reg_text = /^[\s\S]{1,50}$/;
                break;
            case 'dot_two':
                reg_text = /^[-+]?\d{1,4}(?:\.\d{1,2})?$/ig;
                break;
            default:
                reg_text = /^[\w]{4,16}$/;
                break;
        }
        var test_value = $(obj).val();
        if(test_value === ''){
            return false;
        }else{
            if(reg_text === 'require'){
                if(test_value === ''){
                    return false;
                }else{
                    return true;
                }
            }else{
                return reg_text.test(test_value);
            }
        }
    }
    
    //判断等于事件
    function checkEqVal(obj){
        var string = obj.attr('data-pattern').split(':')[1];
        var _pwd = string.replace(/\s+/g,'');
        var pwd_val = $('#' + _pwd).val();
        var eq_val = obj.val();
        if(pwd_val !== eq_val){
            return false;
        }
        return true;
    }
    
    //判断小于事件
    function checkLtVal(obj){
        var string = obj.attr('data-pattern').split(':')[1];
        var _pwd = string.replace(/\s+/g,'');
        var pwd_val = $('#' + _pwd).val() - 0;
        var lt_val = obj.val() - 0;
        if(!(lt_val < pwd_val) || obj.val() === ''){
            return false;
        }
        return true;
    }
    
    //判断大于事件
    function checkGtVal(obj){
        var string = obj.attr('data-pattern').split(':')[1];
        var _pwd = string.replace(/\s+/g,'');
        var pwd_val = $('#' + _pwd).val() - 0;
        var gt_val = obj.val() - 0;
        if(!(gt_val > pwd_val) || obj.val() === ''){
            return false;
        }
        return true;
    }
    //判断自己的验证规则
    function checkReg(obj, pattern){
        var test_val = obj.val();
        var reg_input = eval(pattern).test(test_val);
        if(!reg_input){
            return false;
        }
        return true;
    }
    
    //ajax验证，因为异步验证，请在focus时使用
    function checkAjax(obj, url, async){
        async = async === false ? async : true;
        $.ajax({
            url: url,
            type: obj.attr('data-ajax-type'),
            data: {'checkVal': obj.val},
            async: async,
            beforeSend: function(){
                main.loading();
            },
            success: function(data){
                if(parseInt(data.error) !== 0){
                    error_msg = obj.attr('data-msg');
                    obj.focus();
                    flag = 1;
                    return_obj = obj;
                    return false;
                }
            },
            error: function(){
                main.alert_warning('网络错误，请重试！');
            }
        });
    }
    
    function _checkInput(obj, pattern){
        if(pattern.indexOf('eq:') > -1){
            //判断如果是等于某个文本框的事件
            return checkEqVal(obj);
                
        }else if(pattern.indexOf('lt:') > -1){
            //判断是否是大于某个文本框的事件
            return checkLtVal(obj);

        }else if(pattern.indexOf('gt:') > -1){
            //判断是否是大于某个文本框的事件
            return checkGtVal(obj);

        }else if(pattern.indexOf('ajax_url') > -1){
            var url = $.trim(pattern.split(':')[1]);
            //判断是否是ajax方法
            return checkAjax(obj, url, false);

        }else if(obj.attr('data-reg') && obj.attr('data-reg') !== undefined){
            //继续判断是否是自定义正则规则的表单验证
            return checkReg(obj, pattern);

        }else if(pattern.indexOf('func:') > -1){
            //判断如果是函数验证，返回验证函数
            var f = pattern.split(':')[1];
            if(f.indexOf('$(this)') > -1){
                f = f.replace('$(this)', 'obj');
            }
            return eval('window.' + f);
        }else if(pattern.indexOf('all_phone') > -1){
            //判断如果是所有电话验证事件
            var mobile_input = input_validator(obj, 'mobile');
            var tel_input = input_validator(obj, 'tel');
            return mobile_input | tel_input;
		}else{
            //如果没有的话，继续执行
            var reg_input = input_validator(obj, pattern);
            if(!reg_input){                    
                return false;
            }
            return true;
        }
    }
    
    function checkInput(obj){
        var pattern = obj.attr('data-pattern');  //获取相应的验证规则
        if(pattern && pattern !== undefined && pattern !== 'undefined'){
            if(obj.attr('data-reg') === undefined && pattern.indexOf('|') > -1){
                //判断是否是多个验证规则
                var patterns = pattern.split('|');
                //循环验证规则
                for(var i = 0; i < patterns.length; i++){
                    pattern = patterns[i];
                    var checked = _checkInput(obj, pattern);
                    //如果有一条验证不通过，则返回失败
                    if(!checked){
                        return false;
                    }
                }
                return true;
            }else{
                var f = _checkInput(obj, pattern);
                return f;
            }   
        }
    }
    
    
    //验证select框
    function checkSelect(obj){
        var pattern = obj.attr('data-pattern');     //获取相应的验证规则
        if(pattern && pattern !== undefined){
            if(obj.attr('data-reg') && obj.attr('data-reg') !== undefined){
            //判断是否是自定义正则规则的表单验证
                return checkReg(obj, pattern);

            }if(pattern.indexOf('func:') > -1){
                //判断如果是函数验证，返回验证函数
                var f = pattern.split(':')[1];
                if(f.indexOf('$(this)') > -1){
                    f = f.replace('$(this)', 'obj');
                }
                return eval('window.' + f);
            }else{
                //如果没有选择的时候返回验证失败
                if(parseInt(obj.val()) === 0 || obj.val() === ''){
                    return false;
                }
            }
        }
    }
    
    //表单验证
    var form_validator = function(obj){
        var flag = 0;
        var error_msg = '';
        var return_obj;
        //循环判断表单元素，在提交时执行
        $(obj).find('input, textarea, select').each(function(){
            var ele_tag_name = $(this)[0].tagName;
            var pattern = $(this).attr('data-pattern');
            if(pattern && pattern !== undefined){
                if(ele_tag_name === 'SELECT'){
                    var check = checkSelect($(this));
                }else{
                    var check = checkInput($(this));
                }
                
                if(check !== undefined && !check){
                    flag = 1;
                    error_msg = $(this).attr('data-msg');
                    return_obj = $(this);
                    if($(this).attr('type') === 'hidden'){
                        $(this).trigger('click');
                    }else{
                        $(this).focus();
                    }
                    //如果验证不通过的时候，退出循环
                    return check;
                }
            }
        });
        //验证不通过时，返回验证不通过的信息和对象
        if(flag === 1 && error_msg !== ''){
            var result = [];
            result['success'] = false;
            result['error_msg'] = error_msg;
            result['obj'] = return_obj;
            return result;
        }else{
            var result = [];
            result['success'] = true;
            return result;
        }
    }

   // exports.input_validator = input_validator;
   // exports.checkInput = checkInput;
   // exports.checkSelect = checkSelect;
   // exports.form_validator = form_validator;
   // exports.alert_error = alert_error;
   // exports.insert_error = insert_error;
   // exports.clear_error = clear_error;
//});
