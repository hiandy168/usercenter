/*一些jQuery的扩展方法----张文--2014-04-15*/

//define(function(require, exports, module){
    
    //return function($){
        /*扩展dialog的重置位置方法--张文--2014-04-15*/
        $.fn.resizeDialog = function(position){
            if(position)
                this.dialog('option','position',position);
            else   
                this.dialog('option','position','center');
        }
        //扩展jquery的一些方法
        $.fn.extend({
            //按钮变换成loading状态
            btnLoading: function(){
                var that = this;
                that.html('<i style="font-size: 20px" class="icon-spinner icon-spin"></i>');
                return this;
            },
            //按钮变换成指定的文字
            btnText: function(text){
                var that = this;
                that.html(text);
                return this;
            }
        });
  //  }
//});