<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php //echo $this->renderpartial('/common/left_new'); ?>




<div class="ad-app-list w1000 clearfix bxbg mgt30">
        <div class="clearfix ad-alltit mgb30 mgt30">
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-xiugaizl.png"/></i>
                <span>修改资料</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                    <!-- <a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" class="a2" title="添加应用"></a> -->
                </div>
 
            </div>

        </div>
        <!--tit end-->
      
      
      <div class="ad-edit-info mg20 clearfix">
         
            <form action="" id="regform1" method="post" accept-charset="utf-8">
           <div class="ad-edit-info-form1">
               
              <!--  <div class="ad-haslogin-info linear">
                        <i><img id="imgPreview" src="images/ad-user-default-icon.png"/></i>
                        <span class="clearfix">
                                <a>修改图像
                                <input type="file" onchange="uploadImg(this)"  name="" id="upimg" value="" />
                                </a>
                            </span>
                        <p>
                                                                       如不上传头像，可自动默认
                            <br />为规格为100*100的默认头
                            <br />像png图片。
                        </p>
                    </div> -->
            
           </div>
         
           
            <div class="ad-edit-info-form">
                
                
                <div class="ad-creat-app-inp">
                    <span class="sp1">手机号码：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="itel" id="itel" value="<?php echo $this->member['phone']?>" />
                    </span>
                    
                    
                </div>
                
                
                
                <div class="ad-creat-app-inp">
                    <span class="sp1">邮箱地址：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="iemail" id="iemail" value="<?php echo $this->member['email']?>" />
                    </span>
                    
                    
                </div>
                
                
               <!--  <div class="ad-creat-app-inp">
                    <span class="sp1">所属行业：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="" id="infohy" value="" />
                    </span>
                    
                    
                </div> -->
                
                
                <div class="ad-creat-app-inp">
                    <span class="sp1">公司名称：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="" id="infogs" value="<?php echo $this->member['company']?>" />
                    </span>
                    
                    
                </div>
                
                
                <div class="ad-creat-app-inp">
                    <span class="sp1">公司地址：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="" id="infodz" value="<?php echo $this->member['address']?>" />
                    </span>
                    
                    
                </div>
                
                    
                
                <div class="ad-creat-app-inp">
                    <span class="sp1">&nbsp;</span>
                    <span class="sp2">
                        <div class="ad-creat-app-formbtn">
                            <input class="linear adbtn" type="submit" name="" id="" value="保存修改" />
                        </div>
                    </span>
                    
                </div>
                
                
                
            </div>
        </form>
      </div>
         
         
    </div>

    <script type="text/javascript">
var Validator = $("#regform1").validate({
    ignore:"#upimg,#infohy,#infogs,#infodz",
    rules: {
        itel: {
            required: true,
            minlength: 11,
            isMobile: true
        },
        iemail: {
            required: true,
            email: true,
        },
       
    },

    messages: {
        itel: {
            required: "请输入用户名（手机号）",
            minlength: "手机号长度因为11位",
            isMobile: "请输入正确手机号"
        },
        iemail: {
            required: "邮箱不能为空",
             email: "邮箱格式不正确",
        },
       
    },
    errorElement: "em",
    errorPlacement: function(error, element) {
        if (element.parent().parent().find('em') != null) {
            element.parent().parent().find('em').remove()
        }
        error.appendTo(element.parent().parent());
    },

    errorClass: "cerror",
    validClass: "cright",

    success: function(obj) {
        obj.text("正确").removeClass('cerror').addClass("cright");
    },
     submitHandler: function() {
         var phone = $('#itel').val().trim();
            var email = $('#iemail').val().trim();
            //var type = $('#type').val().trim();
            var company = $('#infogs').val().trim();
            var address = $('#infodz').val().trim();
            //提交数据
            $.ajax({
                url:'<?php echo $this->createUrl('/site/updateMemInfo'); ?>',
                data:{phone:phone,email:email,company:company,address:address},
                dataType:'json',
                type:'post',
                success:function(data){
                    layer.msg(data.mess);
                    if(data.state){
                        window.location.href = "<?php echo $this->createUrl('/project/prolist'); ?>";
                    }
                }
            }); 
     }
  



});

// 手机号码验证
jQuery.validator.addMethod("isMobile", function(value, element) {
    var length = value.length;
    var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
    return this.optional(element) || (length == 11 && mobile.test(value));
}, "请正确填写您的手机号码");

</script>
                


<?php echo $this->renderpartial('/common/footer'); ?>
</body>

</html>

