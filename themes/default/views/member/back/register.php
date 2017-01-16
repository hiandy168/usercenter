<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link rel="stylesheet" href="<?php echo $this->_theme_url ?>css/login.css" type="text/css" > 

<div class="container">
<div class="layout-width mt18 clearfix">
  <div class="bag clearfix">
    <div class="relative fr about-nipic">
      <img height="496" width="377" src="<?php echo $this->_theme_url ?>images/leres.jpg"></div>
    <div class="fl bag-aside">
      <div class="bag-aside-hd">
        <h2 class="fl mr15">注册新用户</h2>
        <div class="fl reg-tip">已有帐号？去<a target="_self" hidefocus="true" class="red1 underline" href="<?php echo $this->createUrl('member/login')?>">登录</a>&gt;</div>
      </div>
      <form novalidate="" target="_self" method="post" id="regForm">
        <ul class="bag-aside-box" id="register">
          <li class="relative clearfix bag-aside-item">
                <label class="bag-label mt7 fl">手机<em style='color:red'>*</em>：</label>
                <input type="text" value="" name="UserName" maxlength="16" id="mobile"  data-val="true" class="fl bag-item-input password mr5">
                <span style="height:31px;line-height:31px;margin-right:5px;" class="fl red3">*注册后不可修改</span>
          </li>   
          <li class="relative clearfix bag-aside-item">
                <label class="bag-label mt7 fl">验证码<em style='color:red'>*</em>：</label>
                <input type="text" value="" name="UserName" maxlength="16" id="mobile_verify"  data-val="true" class="fl bag-item-input password mr5">
                <button class="reg_tel_btn" type="button" onclick='mobileverify();' style='padding:4px;border:1px solid #000'>获取验证码</button>
          </li>   
          
          <li class="relative clearfix bag-aside-item">
            <label class="bag-label mt7 fl">密&nbsp;&nbsp;码：</label>
            <input type="password" onpaste="return false;" name="Password" maxlength="20" id="passwd" data-val="true" class="fl bag-item-input mr5">
          </li>
          <li class="relative clearfix bag-aside-item">
            <label class="bag-label mt7 fl">确认密码：</label>
            <input type="password" onpaste="return false;" name="ConfirmPassword" maxlength="20" id="repasswd" data-val="true" class="fl bag-item-input mr5">
          </li>
          <li class="relative clearfix bag-aside-item">
            <label class="bag-label mt7 fl">邮&nbsp;&nbsp;箱：</label>
            <input type="text" value="" name="Email" maxlength="50" id="email" data-val="true" class="fl bag-item-input mr5">
            <span style="height:31px;line-height:31px;margin-right:5px;" class="fl red3">*注册后不可修改</span> </li>
          <li class="relative clearfix bag-aside-item">
            <label class="bag-label mt7 fl">QQ：</label>
            <input type="text" value="" name="QQ" maxlength="20" id="qq" data-val="true" class="fl bag-item-input mr5">
            <span style="height:31px;line-height:31px;margin-right:5px;" class="fl red3">*注册后不可修改</span></li>
<!--          <li class="relative clearfix bag-aside-item">
            <label class="bag-label mt7 fl">验证码：</label>
            <input type="text" value="" style="width:127px;margin-right:10px;" name="VerifyCode" maxlength="4" id="VerifyCode" data-val="true" class="fl bag-item-input">
            <img id="verifycodeImg" style="width:78px;height:32px;cursor:pointer;" class="fl J-verifycode mr5" src="./images/verifycode" alt="验证码" title="点击切换验证码"></li>-->
          <li class="relative clearfix bag-aside-item">
            <label class="bag-label fl"></label>
            <div style="height: 34px; line-height: 34px;" class="fl">
              <input type="checkbox" value="true" name="Agree" id="agree" class="fl mt10 mr3 required mr5">
              <input type="hidden" value="false" name="Agree">
              <span style="width: 221px;font-weight:bold;" class="fl mr5">已阅读，同意<a hidefocus="true" class="blue3 underline" href="<?php echo $this->createUrl('help/zcxy')?>" target="_blank">《用户注册协议》</a></span> <span data-valmsg-replace="false" data-valmsg-for="Agree" class="field-validation-valid">请同意用户注册协议</span> </div>
          </li>
          <li class="clearfix bag-aside-item">
            <label class="bag-label fl"></label>
            <input type="button" class="fl register-btn" value="注册" onclick='reg()'>
          </li>
        </ul>
      </form>
    </div>
  </div>
</div>
</div>


<script>
    function reg(){
       var mobile = document.getElementById("mobile").value;
       var mobile_verify = document.getElementById("mobile_verify").value;
       var password = document.getElementById("passwd").value;
       var repassword = document.getElementById("repasswd").value;
       var email = document.getElementById("email").value;
       var qq = document.getElementById("qq").value;
       var agree = document.getElementById("agree").value;
        $.ajax({
            type: "post",
            url:baseurl+'/member/ajax_reg',
            data:{mobile:mobile,mobile_verify:mobile_verify,agree:agree,password:password,repassword:repassword,email:email,qq:qq},
            dataType:'json',
            beforeSend: function(){
                ship_mess('注册中........');
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess(data.mess+'10秒后自动跳转到首页');
                      location.href = baseurl+'/member/registerfull';
               }else{
                      ship_mess(data.mess);
               }
            },
            error: function(){
                      ship_mess(data.mess);
            }
        });
        
}
$(document).keypress(function(e) {
if (e.which == 13)  
	reg(); 
});

function mobileverify(){
       var mobile = document.getElementById("mobile").value;
        $.ajax({
            type: "post",
            url:baseurl+'/ajax/ajax_sendsms',
            data:{mobile:mobile},
            dataType:'json',
            beforeSend: function(){
                ship_mess('短信发送中........');
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess(data.mess);
//                      location.href = baseurl;
               }else{
                      ship_mess(data.mess);
               }
            },
            error: function(){
                      ship_mess(data.mess);
            }
        });
        
}

</script>

<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
