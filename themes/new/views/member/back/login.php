<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link href="<?php echo $this->_theme_url ?>css/login.css" rel="stylesheet" type="text/css" />
<style>
  #login  li{margin:15px 0;}
</style>
<div class="container">
  <div class="layout-width mt18 clearfix">
    <div class="bag clearfix">
      <div class="relative fr about-nipic">
       <img src="<?php echo $this->_theme_url ?>images/leres.jpg" width="377" height="496" />
      </div>
      <div class="fl bag-aside">
        <div class="bag-aside-hd">
          <h2 class="fl mr15">登录</h2>
        </div>
        <form action="#" id="loginForm" method="post" target="_self" novalidate>
          <input id="backurl" name="backurl" type="hidden" value="#">
          <input name="__RequestVerificationToken" type="hidden" value="7wJYPJFECL2LLw0U-XbuIux6576-sxKpdy5u-q57CaCmpRNDv_tuH09PN-YBDX5YlWhkgnCol-YSmZAvTr844pOtNgnCu_1X-YgkX5BfCuiu4mW2-Je_Dkn8-Xu4mSu1hVKhCFcx-o0oCYVcgHj58ml-Rg1Ne_0r0xJMTiOjOA41">
          <ul id="login" class="bag-aside-box" style="margin-left:100px;margin-top:20px;">
            <li class="clearfix bag-aside-item">
              <label class="bag-label mt7 fl">用户名：</label>
              <input autocomplete="off" class="fl bag-item-input mr5" data-val="true" id="username" name="username" maxlength="50"  type="text" value="">
              </li>
            <li class="clearfix bag-aside-item">
              <label class="bag-label mt7 fl">密 码：</label>
              <input autocomplete="off" class="fl bag-item-input mr5" maxlength="20" id="password" name="password" type="password" value="">
              <span class="field-validation-valid" data-valmsg-for="PassWord" data-valmsg-replace="true"></span> </li>
            <li class="clearfix bag-aside-item">
              <label class="bag-label mt7 fl">验证码：</label>
              <input class="fl bag-item-input mr5"  id="verify" maxlength="5" name="verify" style="width:132px;" type="text" value="">
              <img id='verify_image' style="margin:0 0 0 5px;height:32px;float:left" src="<?php echo $this->createUrl('/member/verify_image'); ?>">
              <span id="J-codeCorrect" style="display:none;" class="fl mt7 mr5 ico correct-ico"></span> <span class="field-validation-valid" data-valmsg-for="VerifyCode" data-valmsg-replace="true"></span> </li>
            <li class="clearfix bag-aside-item">
              <label class="bag-label fl"></label>
              <a href="#" class="fl blue4 underline" target="_self" title="找回密码" hidefocus="true">忘记密码？</a></li>
            <li class="clearfix mt5 bag-aside-item">
              <label class="bag-label fl"></label>
              <input type="button" value="登录" class="fl login-btn" onclick='login();'>
            </li>
            <li class="clearfix mt5 bag-aside-item"><div class="fl reg-tip">还还未注册乐信贷账号?<br /><a href="<?php echo $this->createUrl('member/register')?>" class="red1 underline" hidefocus="true" target="_self">立刻注册</a>乐信贷，精彩无需等待！</div></li>
          </ul>
        </form>
        
      </div>
    </div>
  </div>
</div>



<script>
    var JSLOADED = [];
function evalscript(s) {
	if(s.indexOf('<script') == -1) return s;
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	var arr = [];
	while(arr = p.exec(s)) {
		var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
		var arr1 = [];
		arr1 = p1.exec(arr[0]);
		if(arr1) {
			appendscript(arr1[1], '', arr1[2], arr1[3]);
		} else {
			p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
			arr1 = p1.exec(arr[0]);
			appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1);
		}
	}
	return s;
}

var safescripts = {}, evalscripts = [];

function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	if(!reload && in_array(id, evalscripts)) return;
	if(reload && $('#' + id)[0]) {
		$('#' + id)[0].parentNode.removeChild($('#' + id)[0]);
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	scriptNode.charset = charset ? charset : (!document.charset ? document.characterSet : document.charset);
	try {
		if(src) {
			scriptNode.src = src;
			scriptNode.onloadDone = false;
			scriptNode.onload = function () {
				scriptNode.onloadDone = true;
				JSLOADED[src] = 1;
			};
			scriptNode.onreadystatechange = function () {
				if((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
					scriptNode.onloadDone = true;
					JSLOADED[src] = 1;
				}
			};
		} else if(text){
			scriptNode.text = text;
		}
		document.getElementsByTagName('head')[0].appendChild(scriptNode);
	} catch(e) {}
}

function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function login(){
       var username = document.getElementById("username").value;
       var password = document.getElementById("password").value;
       var verify   = document.getElementById("verify").value;
        $.ajax({
            type: "post",
            url:baseurl+'/member/ajax_login',
            data:{username:username,password:password,verify:verify},
            dataType:'json',
            beforeSend: function(){
                ship_mess('登陆中........');
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess('登录成功，正在返回登录前页面...','8000');
                      if(data.script)evalscript(data.script);
                      setTimeout('location.href="<?php echo $this->_siteUrl ?>"',1000);
               }else{
                      ship_mess(data.mess);
               }
            },
            error: function(){
                      //ship_mess(data.mess);
            }
        });
        
}

$(document).keypress(function(e) {
if (e.which == 13)  
	login(); 
});
</script>   

<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
