<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="format-detection" content="telephone=no">
	<title>砸金蛋</title>
	<link rel="stylesheet" type="text/css" href="/assets/scratch/default/css/base.css">
        <script src="<?php echo Mod::app()->createUrl('/')?>/assets/js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo Mod::app()->createUrl('/')?>/assets/scratch/default/js/wx.js"></script>        	
</head>
<!-- body background: 背景图片铺平颜色 -->
<body >
<link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/css/style.css" />
<script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/js/main.js"></script>
<script src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<script src="<?php echo $this->_theme_url; ?>wap/js/login.js"></script>
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
      .cd-form input.has-border:focus, .cd-form input.has-padding{
          height: 50px;
          width: 509px;
      }
      .cd-form input.has-padding{
          padding: 0 40px;
      }
</style>
<script type="text/javascript">
      $(function(){
          var $form_modal = $('.cd-user-modal'),
              $form_login = $form_modal.find('#cd-login'),
              $form_signup = $form_modal.find('#cd-signup'),
              $form_modal_tab = $('.cd-switcher'),
              $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
              $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
              $main_nav = $('.main_nav');

          //自动加载登陆弹出窗
          var status= <?php echo $status;?>;
          if(status) {
              $main_nav.children('ul').removeClass('is-visible');
              $form_modal.addClass('is-visible');
              ( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();
          }

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

  

<script type="text/javascript">
    function ckLogin(){
        var $form_modal = $('.cd-user-modal'),
            $form_login = $form_modal.find('#cd-login'),
            $form_signup = $form_modal.find('#cd-signup'),
            $form_modal_tab = $('.cd-switcher'),
            $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
            $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
            $main_nav = $('.main_nav');

        var status = <?php echo $status;?>;
        if(status) {
            //自动加载登陆弹出窗
            $main_nav.children('ul').removeClass('is-visible');
            $form_modal.addClass('is-visible');
            ( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();
        }
        
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
    }
</script>
        <img src="http://mat1.gtimg.com/hb/chenz/iyong1201/images/bg_3.png" alt="" width="0" height="0">
	<!-- banner以及背景图，640*960，多余部分使用纯色铺开 -->
	<div class="content_wrap_style_1" style="background:url('/assets/scratch/default/images/bg_1.png') no-repeat center top;background-size: 320px 480px;">
		<div class="style_1_part_1">
			<div class = "change" style="background:url('/assets/scratch/default/images/bg_2.png') no-repeat center center;background-size: 276px 133px ">
				<div class="text">
					您还有<span id="changeNumber"><?php echo $info['FDaycount'];?></span>次机会
				</div>
                            <div class="scratchCard" id="scratchCard" style="cursor: crosshair;">
                                 <img src="<?php echo $this->_theme_url; ?>images/bg_4.png" crossorigin="" style="position: absolute; width: 100%; height: 100%; display: block;">
                                <canvas style="position: absolute; width: 100%; height: 100%;" width="185" height="40"></canvas>
                            </div>
                                
				<div class="prizeText" id="prizeText"></div>
			</div>
		</div>
		<div class="style_1_part_2 web_flex">
			<div class="button button1 web_flex_1" id="share"></div>
			<div class="button button2 web_flex_1" id="myPrizeRecord"></div>
		</div>
		<div class="style_1_part_3" style="background:url('/assets/scratch/default/images/bg_7.png') repeat left top;">
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>活动时间</strong></div>
				</div>
				<div class="content">
					<p><span class="icon"></span><?php echo  date('n月j日 H时i分',$info['FStartTime']);?>--<?php echo date('n月j日 H时i分',$info['FEndTime']);?></p>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>惊喜奖品</strong></div>
				</div>
				<div class="content">
					<?php foreach ($list as $k=>$v):?>
						<p><span class="icon"></span><?php echo $v['FTitle']?>：<?php echo $v['FNum']?>名</p>
					<?php endforeach;?>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>活动规则</strong></div>
				</div>
				<div class="content">
					<p><span class="icon"></span><?php echo $info['FRule'];?></p>
				</div>
			</div>
			<div class="info_wrap">
				<div class="tile web_flex">
					<div class="icon"></div>
					<div class="text web_flex_1"><strong>领取规则</strong></div>
				</div>
				<div class="content">
					<p><span class="icon"></span><?php echo $info['FLingjiang'];?></p>
				</div>
			</div>
		</div>
	</div>
	<!-- 中奖列表浮层 -->
	<div class="winning_list" id="winning_list">
		<div class="title">
			中奖列表
		</div>
		<div class="content">
			<div class="head_wrap web_flex">
				<div class="h h1 web_flex_1">中奖名称</div>
				<div class="h h2 web_flex_1">兑换码</div>
			</div>
			<ul class="list">
				<li class="web_flex">
					<div class = "l l1 web_flex_1">iphone6iphone6iphone6</div>
					<div class = "l l2 web_flex_1">UUUUUUUUUUUUUUUUUUUU</div>
				</li>
				<li class="web_flex">
					<div class="l l1 web_flex_1">iphone6</div>
					<div class="l l2 web_flex_1">UUUUU</div>
				</li>
				<li class="web_flex">
					<div class="l l1 web_flex_1">iphone6</div>
					<div class="l l2 web_flex_1">UUUUU</div>
				</li>
				<li class="web_flex">
					<div class="l l1 web_flex_1">iphone6</div>
					<div class="l l2 web_flex_1">UUUUU</div>
				</li>
			</ul>
			<div class="button" id="winning_button"></div>
		</div>
	</div>
	<!-- 中奖浮层 -->
	<div class="prize_layer_wrap" id="prize_layer_wrap">
		<div class="prize_layer">
			<div class="top"></div>
			<div class="content">
				<p class="text">
					谢谢参与
				</p>
			</div>
			<div class="button" id="make_sure"></div>
		</div>
	</div>
	<!-- 报名浮层 -->
	<div class="sign_up_layer_wrap" id="sign_up_layer_wrap" <?php if($info['FFrom_p']==1 && $form_flag):?>style="display:block;"<?php endif;?>>
		<div class="sign_up_layer" id="sign_up_layer">
			<!-- ad 编辑上传代理图片 494*250-->
			<div class="ad" style="background:url('/assets/scratch/default/images/pic_1.png') no-repeat; background-size: 246px 125px;"></div>
			<div class="content">
				<?php foreach ($from_list as $k=>$v):?>
				<div class="input">
					<input type="text" class="submit_input" placeholder="<?php echo $v['FValue'];?>" name="field[<?php echo $v['FName'];?>]" data-msg="<?php echo $v['FName'];?>" />
				</div>
				<?php endforeach;?>
			</div>
			<div class="bottom"></div>
			<div class="button" id="submit_button"></div>
		</div>
	</div>
	<!-- 分享浮层 -->
	<div class="wx_share_layer" id="wx_share_layer"></div>
        <script type="text/javascript" src="/assets/scratch/default/js/wScratchPad.min.js?v=1787875448"></script>
   	<script>
	var count = $('#changeNumber').html();
		var openId = "";
		var FID = "";
		var winId = 0;
		var flag = 1;
		var form_flag = ''?'':false;
		var userId = "";
		jQuery(document).ready(function($) {
		
			var number = 0;
			var show   = 0;
			if(parseInt(count)<1){
				$(".prizeZero").show();
				$("#make_sure").hide();
				$("#make_sure_ok").show();
    		}
			$('#scratchCard').wScratchPad({
				size: 12,
        		bg: '/assets/scratch/default/images/bg_4.png',
        		fg: '/assets/scratch/default/images/bg_3.png',
        		scratchMove: function (e, percent) {
        			if(parseInt(count)<1){
        				$(".prizeZero").show();
        				$('#make_sure_ok').show();
                                        $('#make_sure').hide();
        				$("#prize_layer_wrap").show();
						$("#prize_layer_wrap p").text('<?php echo $info['FEndNumMess'];?>');
						return false;
            		}
        			var time = <?php echo time();?>;
        			var startTime = <?php echo $info['FStartTime']?>;
        			var endTime = <?php echo $info['FEndTime']?>;
        	
        			if(time<startTime){
        				$("#prize_layer_wrap").show();
						$("#prize_layer_wrap p").text('亲！活动尚未开始!');
						return false;
            		}
        			if(time>endTime){
        				$("#prize_layer_wrap").show();
						$("#prize_layer_wrap p").text('亲！活动已结束!');
						return false;
            		}
        			if(percent >= 50) {
        				this.clear();
        				show++;
        				if(show == 1) {
        					$("#prize_layer_wrap").show();
        				}
        			}
					
        			//ajax请求
        			number++;
        			if(number == 1) {
                                var fid=<?php echo $info['FID']?>;
                                var pid=<?php echo $info['FSiteID']?>;
                                var mid=<?php echo $mid?>;
            			$.ajax({
			    			url: '/activity/scratchcard/winner/fid/'+fid+'/pid/'+pid+'/mid/'+mid,
						dataType: 'json'
						}).done(function(data, status, jqXHR){
							
							//$("#prize_layer_wrap").show();
							if(data.error==0) {                              
								winId = data.winId;
								var FWin_mess = data.FWin_mess?data.FWin_mess:'';
								$("#prize_layer_wrap .text").html(FWin_mess+'<br/>' + data.msg);
                                                                console.log(data.msg);
								 $("#prizeText").text(data.msg);
							}else{                                     
								$("#prizeText").text( data.msg);
								$("#prize_layer_wrap p").text(data.msg);
							}
						   
						});
						
        			}
        	  }
        	});

			$(".button[data-index='submit_button']").on('click',function(){
                        alert(111);return;
				var status = false;
				var field ={};
				var _this = $(this);
				$('.submit_input').each(function(i,item){
					$(this).attr('data-msg');
					if(!$(this).val()){
						status = true;
					}
					field[$(this).attr('data-msg')] = $(this).val();
				});
				if(status){
					alert("请补全数据");
					return ;
				}
				_this.attr('data-index','');
				$.post('/Components/f/ID/117/do/AjaxScratchGetUserInfo',{field:field,openId:'269924',FID:75,flag:flag,userId:userId,winId:winId},function(msg){
                                    alert(222);return;
					if(msg.errcode==0){
						$("#sign_up_layer_wrap").hide();
					}else{
						_this.attr('data-index','submit_button');
						alert(msg.msg);
					}
				},'json');
				
			});
			$(".prizeZero").on('touchmove', function(){
				$("#prize_layer_wrap").show();
				$("#prize_layer_wrap p").text('宋仲基欧巴邀请你分享朋友圈，今天可以再抽一次哦~');
			});
			//点击关闭浮层
			$("#wx_share_layer").on('click', function() {
				$(this).hide();
			});

			//打开浮层
			$("#share").on('click', function() {
				$("#wx_share_layer").show();
			});

			//中奖浮层关闭
			$("#make_sure").on('click', function() {
				$("#prize_layer_wrap").hide();
			});
			//中奖浮层关闭
			$("#make_sure_ok").on('click', function() {
				$("#prize_layer_wrap").hide();
			});
                        
                        var fid=<?php echo $info['FID']?>;
			//中奖列表
			$("#myPrizeRecord").on('click', function() {
				$.post('/activity/scratchcard/getMyPrice',{fid:fid},function(data){

					$("#winning_list").show();
					$('#winning_list .list').html('');
					if(data.errCode){
						alert(data.msg);
						return ;
					}
					var _li = '';
					for(var i in data.msg){
						_li+= '<li class="web_flex"><div class = "l l1 web_flex_1">'+data.msg[i].FPrizeInfo+'</div><div class = "l l2 web_flex_1">'+data.msg[i].FValidateCode+'</div></li>';
					}
					_li = _li==''?'无中奖记录':_li;
					$('#winning_list .list').append(_li);
					$("#winning_list").show();
				},'json');
			});
			$("#winning_list").on('click', function() {
				$(this).hide();
			});

			//点击关闭
			$("#make_sure").on('click', function(){
				var count1 = parseInt(count);
		
				if(count1>0){
					count = count1-1;
					$('#changeNumber').html(count);
				}
				//window.location.reload();	
				show = 0;
				number = 0;
				$('#scratchCard').wScratchPad('reset');
			})

		});
		
	</script>
  <!-- 弹窗注册登录 -->
      <div class="cd-user-modal">
        <div class="cd-user-modal-container">
            <ul class="cd-switcher">
                <li><a href="#0">用户登录</a></li>
                <li><a href="#0">注册新用户</a></li>
            </ul>

            <div id="cd-login">
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
                        <input style="margin-top:-5px;" type="checkbox" id="remember-me">
                        <label style="display:inline;" for="remember-me">记住登录状态</label>
                    </p>

                    <p class="fieldset">
                        <input class="full-width2" type="button" id="login" value="登 录">
                    </p>
                </form>
            </div>

            <div id="cd-signup">
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

            <a href="#0" class="cd-close-form">关闭</a>
        </div>
        <div>
            <input type="hidden" id="return_url" value="<?php echo $return_url?>"/>
        </div>
    </div>
  
<script type="text/javascript">
        function scratCard(){
            $.ajax({
            url:  "<?php echo $this->createUrl('/activity/scratchcard/index/fid/153')?>",
            data: {access_token:"<?php echo $token; ?>",mid:"<?php echo $mid; ?>"},
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (!data.status) {
                    ckLogin();
                    return false;
             }
             ship_mess(data.mess);
           }           
        }); 
    }
</script>
</body>
</html>