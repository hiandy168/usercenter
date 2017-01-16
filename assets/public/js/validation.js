$(function(){     
        //如果是必填的，则加红星标识.
        $("form :input.required").each(function(){
            var $required = $("<span style='height:22px;line-height:22px;color:#ff0000;margin:5px'>*</span>"); //创建元素
            $(this).parent().append($required); //然后将它追加到文档中
        });


         //文本框失去焦点后
        $('form input').blur(function(){
             var $parent = $(this).parent();
             $parent.find(".formtips").remove();
             
             //验证用户名
             if( $(this).is('#username') ||  $(this).is('#name') ||  $(this).is('#title') ){
                    if( this.value=="" || this.value.length < 2 ){
                        var errorMsg = '请输入至少2位的字符串.';
//                        this.value = errorMsg;
//                        $(this).addClass('onError');
                        $parent.append('<div class="clearfix"></div><div class="formtips onError">'+errorMsg+'</div>');
                    }else{
//                        $(this).removeClass('onError');
//                        var okMsg = '输入正确.';
//                        $parent.append('<div class="clearfix"></div><span class="formtips onSuccess">'+okMsg+'</span>');
                    }
             } else  if( $(this).is('#email') ){       //验证邮件
                if( this.value=="" || ( this.value!="" && !/.+@.+\.[a-zA-Z]{2,4}$/.test(this.value) ) ){
                        var errorMsg = '请输入正确的E-Mail地址.';
                          $parent.append('<div class="clearfix"></div><div class="formtips onError">'+errorMsg+'</div>');
                }
             }else   if( $(this).is('.required') ){ //必填项
                    if( !this.value ){
                        var errorMsg = '该选项不能为空';
                        $parent.append('<div class="clearfix"></div><div class="formtips onError">'+errorMsg+'</div>');
                    }
             }
             
           
        })


         //下拉框失去焦点后
        $('form select.required').change(function(){
            var $parent = $(this).parent();
             $parent.find(".formtips").remove();
                    if( !this.value ){
                        var errorMsg = '该选项不能为空';
                        $parent.append('<div class="clearfix"></div><div class="formtips onError">'+errorMsg+'</div>');
                    }
        })

     
        
        //提交，最终验证。submit
         $('input:submit').click(function(){
                $("form input.required").trigger('blur');
                $("form select.required").trigger('change');
                var numError = $('form .onError').length;
                if(numError){
                    return false;
                } 
         });

        //重置
         $('#res').click(function(){
                $(".formtips").remove(); 
         });
})