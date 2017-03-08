<!DOCTYPE html>
<html lang="en" style=" height: 100%;">
<head>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
        var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="腾讯楼盘商城" />
    <meta name="description" content="腾讯楼盘商城" />
    <title>腾讯楼盘商城</title>
    <link href="<?php echo $this->_theme_url; ?>assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_theme_url; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_siteUrl;?>/assets/house/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js" type="text/javascript"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/validate.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
</head>

<body style=" height: 100%;background: #fff;">
<a id="wxlogin" href="<?php echo $this->_siteUrl ?>/member/WeixinLogin<?php echo $reurl?>" style="
    display: block;
    height: 100%;
    position: relative;
"><em style="
    display: block;
    vertical-align: middle;
    text-align: center;
    box-shadow: 0px 0px 20px 1px rgba(0, 0, 0, .1);
    padding: 30px;
    border-radius: 10px;
    position: absolute;
    left: 30px;
    right: 30px;top: 50%;margin-top: -80px;"><img src="/themes/new/assets/h5/login/images/login-wx-icon.png" style="
    width: 50px;
    padding: 20px;
    padding-bottom: 0px;
"><p style="
    margin-top: 20px;
">使用微信快捷登录</p></em></a>
<script type="text/javascript">
    var childWindow;
    function toQzoneLogin()
    {
        window.location.href="<?php echo $this->createUrl('member/qqlogin/state/computer')?>";
    }
</script>
</body>
</html>