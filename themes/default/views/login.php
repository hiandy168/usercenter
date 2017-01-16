<?php $this->renderPartial('/common/header', array('config' => $config)); ?>

<script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/ui.js"></script>

<div class="wp">
    <div class="logo2">
        <a href="www.cbo.cn"><img src="<?php echo $this->_theme_url ?>images/logo2.gif" /></a>
    </div>
</div>

<div class="regist">
    <div class="register cl">
        <!--表单部分 begin-->
        <div class="registbox ">
            <div class="registboxer">
                <h2>登录化妆品财经在线</h2>
                <div class="formbox">
                    <form id="form2" name="form1" method="POST" action=""  autocomplete="off">
                        <input type="hidden" id="return_url"  name="return_url" value="<?php echo $return_url ?>" />
                        <div class="linebox">
                            <span class="line_titler">用户名</span>
                            <span class="line_text">
                                <input type="text" id="account" class="telephone focus" name="account" placeholder="输入用户名/手机号" />
                            </span>
                        </div>
                        <div class="linebox pad35">
                            <span class="line_titler">密码</span>
                            <span class="line_text">
                                <input type="password" id="password" class="telephone" name="password" placeholder="6 — 16 位字母数字组合 " />
                            </span>
                        </div>
                        <div class="linebox">
                            <span class="line_titler">验证码</span>
                            <span class="line_text">
                                <input type="text" name="verify" id="verify" class="verificatCode " placeholder="验证码" />
                            </span>
                            <span class="getyzm">
                                <a href="javascript:void(0);">
                                    <img class="zhuceyzm"   id='verify_image' src="<?php echo Mod::app()->createUrl('member/verify_image') ?>" />
                                </a>

                            </span>
                        </div>
                        <div class="rempassword">
                            <input type="checkbox" name="rember" id="checkbox" />
                            记住密码
                            <a href="<?php echo Mod::app()->createUrl('member/404') ?>">忘记密码?</a>
                        </div>
                        <div class="lineboxsure">
                            <input type="button" name="button" value="登录xx" id="login" class="goregist" />
                            <span>
                                没有账号？
                                <a href="<?php echo Mod::app()->createUrl('member/register') ?>">请注册</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--表单部分 end-->
        <!--二维码部分 begin-->
        <div class="qrcode">
            <div class="codepic" id="login_container">

            </div>

            <!--p>请使用微信扫描二维码登录<br/></p-->
        </div>
        <!--二维码部分 end-->
    </div>
</div>



<script>
    var Siteurl = "<?php echo $this->_siteUrl; ?>";
</script>
<script src="<?php echo $this->_theme_url ?>js/login.js"></script>



<?php $this->renderPartial('/common/footer', array('config' => $config)); ?>


