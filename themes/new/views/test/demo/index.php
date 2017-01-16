<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>大楚用户中心Demo</title>
<style type="text/css">
*{margin:0;padding:0;list-style-type:none;}
a,img{border:0;}
body{font:12px/180% Arial, Helvetica, sans-serif, "新宋体";}
</style>


    <link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/css/style.css" />

    <link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/css/bootstrap.min.css" />
	<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/js/main.js"></script>	

<?php if(!Mod::app()->session['member']['name']){?>
<script>
$(function(){  
	var $form_modal = $('.cd-user-modal'),
		$form_login = $form_modal.find('#cd-login'),
		$form_signup = $form_modal.find('#cd-signup'),
		$form_modal_tab = $('.cd-switcher'),
		$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
		$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
		$main_nav = $('.main_nav');
 
//    自动加载登陆弹出窗
	//$main_nav.children('ul').removeClass('is-visible');
	//$form_modal.addClass('is-visible');
	//( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();
		
	function login_selected(){
		$form_login.addClass('is-selected');
		$form_signup.removeClass('is-selected');
		$tab_login.addClass('selected');
		$tab_signup.removeClass('selected');
	}

	function signup_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.addClass('is-selected');
		$tab_login.removeClass('selected');
		$tab_signup.addClass('selected');
	}
});
</script>	
<?php }?>
    <!--<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/js/bootstrap.min.js"></script>-->
    <!--<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/js/bootstrap-transition.js"></script>-->	
	
    <!--<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/js/bootstrap-modal.js"></script>-->	
	
<style>
input[type="button"] {
    padding: 16px 0;
}
.cd-form input[type="button"] {
    -moz-appearance: none;
    background: #2f889a none repeat scroll 0 0;
    border: medium none;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    padding: 16px 0;
}
</style>	
	
</head>

<body>

<pre>
<h3>接口测试</h3>
<a target="_blank" href="<?php echo $this->createUrl('/api/token/get')?>?appid=101056&appkey=26e4cc3d389b8cae">获取access_token</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/getopenid')?>">获取openid</a>
<a target="_blank" href="<?php echo $this->createUrl('/api/member/GetMember')?>">获取用户中心用户</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberReg')?>?tel=15888888888&password=scott12356&repassword=scott12356&appid=101056&appkey=26e4cc3d389b8cae">用户注册</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberLogin')?>?name=15888888888&password=scott12356&&appid=101056&appkey=26e4cc3d389b8cae">用户登录</a>
<a href="<?php echo Mod::app()->createUrl('member/logout')?>">退出登录</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberTag')?>?appid=101056&appkey=26e4cc3d389b8cae&pid=46&type=3">用户标签设置</a>
<a target="_blank" href="<?php echo $this->createUrl('/activity/checkIn/index')?>?access_token=yyfuqydadavflerydmmukbtpecqrulph&mid=242">签到</a>
<!--<a href="javascript:void(0);" onclick="checkLogin()">签到</a>-->
<a target="_blank" href="<?php echo $this->createUrl('/test/demo/addSignUp')?>?appid=101056&appkey=26e4cc3d389b8cae">报名</a>
<a target="_blank" href="<?php echo $this->createUrl('/test/demo/start')?>?appid=101056&appkey=26e4cc3d389b8cae">抽奖</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/regproject')?>?name=project_test&introduction=test_test">注册项目</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/projectlist')?>">项目编辑</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/behaviorstatistics')?>?appid=101056&appkey=26e4cc3d389b8cae&type=3&remark=test_remark">用户行为上报</a>
</pre>


<!--<input id="btntext" type="button" value="添加文本组件" data-toggle="modal" data-target="#myModal"  href="#"/>-->
<!-- Modal -->
<!--<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
        <h4 id="myModalLabel">用户中心</h4>
    </div>
<div class="modal-body">-->
<!-------start--->
	<!--<div class="demo">
		<nav class="main_nav">
			<ul>
				<li><a class="cd-signin" href="#0">登录</a></li>
				<li><a class="cd-signup" href="#0">注册</a></li>
			</ul>
		</nav>
	</div>-->
	
	<div class="cd-user-modal"> 
		<div class="cd-user-modal-container">
			<ul class="cd-switcher">
				<li><a href="#0">用户登录</a></li>
				<li><a href="#0">注册新用户</a></li>
			</ul>

			<div id="cd-login"> <!-- 登录表单 -->
				<form class="cd-form" action="<?php //echo Mod::app()->createUrl('member/Ajaxlogin')?>" method="post">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signin-username">用户名</label>
						<input class="full-width has-padding has-border" id="signin-username" type="text" placeholder="输入用户名">
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">密码</label>
						<input class="full-width has-padding has-border" id="signin-password" type="text"  placeholder="输入密码">
					</p>

					<p class="fieldset">
						<input style="margin-top:-5px;" type="checkbox" id="remember-me" checked>
						<label style="display:inline;" for="remember-me">记住登录状态</label>
					</p>

					<p class="fieldset">
						<input class="full-width2" type="button" id="login" value="登 录">
					</p>
				</form>
			</div>

			<div id="cd-signup"> <!-- 注册表单 -->
				<form class="cd-form" method="post">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-username">用户名</label>
						<input class="full-width has-padding has-border" id="signup-username" type="text" placeholder="输入手机号">
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">密码</label>
						<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="输入密码">
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">重复密码</label>
						<input class="full-width has-padding has-border" id="signup-repassword" type="text" placeholder="再次输入密码">
					</p>					
					
					<p class="fieldset">
						<input type="checkbox" name="rember" id="accept-terms" style="margin-top:-5px;">
						<label  style="display:inline;" for="accept-terms">我已阅读并同意 <a href="#0">用户协议</a></label>
					</p>

					<p class="fieldset">
						<input class="full-width2" id="zhuce" type="button" value="注册新用户">
					</p>
				</form>
			</div>

<!--			<a href="#0" class="cd-close-form">关闭</a>-->
		</div>
		<div>
			<input type="hidden" name="token" id="token" value="<?php echo $token; ?>"/>
			<input type="hidden" name="mid" id="mid" value="<?php echo $mid; ?>"/>
		</div>
	</div> 

<!-------end----->
<!--</div>-->
<script type="text/javascript">
//$('#myModal').modal('show');
//$('#myModal').modal('hide');
//$('#myModal').modal('toogle');
//$('#myModal').on('hidden', function () {// do something…});
</script>
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/themes/default/js/home.js"></script>
<script>
    //var Siteurl = "<?php //echo $this->_siteUrl; ?>";
</script>
<script src="<?php echo Mod::app()->baseUrl ?>/themes/default/js/login.js"></script>
</body>
</html>