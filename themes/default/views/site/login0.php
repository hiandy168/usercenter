    <?php $this->renderPartial('/common/header2',array('config'=>$config));?>

<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/ui.js"></script>

<div id="base" class="">

      <!-- Unnamed (形状) -->
      <div id="u0" class="ax_形状">
        <img id="u0_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/u0.png"/>
        <!-- Unnamed () -->
        <div id="u1" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- Unnamed (images) -->
      <div id="u2" class="ax_images">
        <img id="u2_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/u2.jpg"/>
        <!-- Unnamed () -->
        <div id="u3" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- Unnamed (images) -->
      <div id="u4" class="ax_images">
        <img id="u4_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/u4.jpg"/>
        <!-- Unnamed () -->
        <div id="u5" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- logo (形状) -->
      <div id="u6" class="ax_形状" data-label="logo">
        <img id="u6_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/logo_u6.png"/>
        <!-- Unnamed () -->
        <div id="u7" class="text">
          <p><span>Logo</span></p>
        </div>
      </div>

      <form id="form2" name="form1" method="POST" action=""  autocomplete="off">
      <!-- 手机号默认 (形状) -->
      <div id="u8" class="ax_形状" data-label="手机号默认">
        <img id="u8_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/手机号默认_u8.png"/>
        <!-- Unnamed () -->
        <div id="u9" class="text">
          <p><span>手机号</span></p>
        </div>
      </div>

      <!-- 手机号 (文本框) -->
      <div id="u10" class="ax_文本框" data-label="手机号">
       <input type="text" id="account" class="telephone focus" name="account" placeholder="输入用户名/手机号" />
      </div>

      <!-- 手机号 (文本框) [footnote] -->
      <div id="u10_ann" class="annotation"></div>

      <!-- 密码默认 (形状) -->
      <div id="u11" class="ax_形状" data-label="密码默认">
        <img id="u11_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/手机号默认_u8.png"/>
        <!-- Unnamed () -->
        <div id="u12" class="text">
          <p><span>密码</span></p>
        </div>
      </div>

      <!-- 登录密码 (文本框) -->
      <div id="u13" class="ax_文本框" data-label="登录密码">
        <input type="password" id="password" class="telephone" name="password" placeholder="6 — 16 位字母数字组合 " />
      </div>

      <!-- 登录密码 (文本框) [footnote] -->
      <div id="u13_ann" class="annotation"></div>
      </form>
      <!-- Unnamed (形状) -->
      <div id="u14" class="ax_形状">
        <img id="u14_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/u14.png"/>
        <!-- Unnamed () -->
        <div id="u15" class="text">
          <p><span>成功案例</span></p>
        </div>
      </div>

      <!-- 立即注册 (形状) -->
      <div id="u16" class="ax_文本段落" data-label="立即注册">
        <a href="<?php echo Mod::app()->createUrl('site/regone') ?>">立即注册</a>
        <!-- Unnamed () -->
        <div id="u17" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- 立即注册 (形状) [footnote] -->
      <div id="u16_ann" class="annotation"></div>

      <!-- 使用帮助 (形状) -->
      <div id="u18" class="ax_文本段落" data-label="使用帮助">
        <img id="u18_img" class="img " src="<?php echo $this->_theme_url ?>resources/imagess/transparent.gif"/>
        <!-- Unnamed () -->
        <div id="u19" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- 使用帮助 (形状) [footnote] -->
      <div id="u18_ann" class="annotation"></div>

      <!-- Unnamed (形状) -->
      <div id="u20" class="ax_形状">
        <img id="u20_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/u20.png"/>
        <!-- Unnamed () -->
        <div id="u21" class="text">
            <!--<input type="checkbox" name="rember" id="checkbox" />
            记住密码-->
            <input type="button" name="button" value="登录" id="login" class="goregist" />
        </div>
      </div>

      <!-- Unnamed (形状) [footnote] -->
      <div id="u20_ann" class="annotation"></div>
    </div>

<script>
    var Siteurl = "<?php echo $this->_siteUrl; ?>";
</script>
<script src="<?php echo $this->_theme_url ?>js/login.js"></script>

<script>
    $(document).keypress(function(e) {
        if (e.which == 13)
            login();
    });

    function login(){
        var loginaccount= $('#account');
        var loginpassword = $('#password');
        if(loginaccount.val()==""){
            ship_mess('用户名不能为空');
            return false;
        }
        var account = loginaccount.val();
        var password = loginpassword.val();
        var verify = $('#verify').val();
        var return_url = $('#return_url').val();
        var rember = 0;
        if($('#checkbox').is(':checked')) {
            rember = 1;
        }
        $.ajax({
            url:Siteurl+'/member/Ajaxlogin',
            data:{account:account,password:password,verify:verify,rember:rember,return_url:return_url},
            dataType:'json',
            type:'post',
            success : function(data){
                if(data.state === 1){
                    ship_mess(data.message);
                    setTimeout(function(){
                        window.location.href = data.return_url;
                    },600);
                }else{
                    ship_mess(data.message);
                }
            }
        });
    }
</script>
</body>
</html>
