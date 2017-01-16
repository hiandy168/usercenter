<!DOCTYPE html>
<html>
<head>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
    </script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=8;IE=9;chrome=1">
    <meta name="robots" content="all">
    <meta name="renderer" content="webkit">
    <title><?php echo $site_title ?></title>
    <meta name="Keywords" content="<?php echo $Keywords ?>" />
    <meta name="Description" content="<?php echo $Description ?>" />
    <link href="<?php echo $this->_theme_url; ?>assets/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->_theme_url; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/main.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js" type="text/javascript"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/validate.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    </script>
    <style>
        .three{
            margin-right: 34px;
        }
    </style>
    <script type="text/javascript">


        //倒计时60秒
        function timer(){
            var times = $('#send_message .time').html();
//        alert(times);
            if(times > 1){
                --times;
                $('#send_message .time').html(times);
                setTimeout(function(){
                    timer();
                },1000);
            }else{
                $('#codes').focus();
                $("#send_message").removeClass('unclick');
                $("#send_message").attr("onclick",'send_code()');
                $("#send_message").html('免费获取验证码');

            }
        }
        /*发送验证码*/
        function send_code(){
            var tel = $("#uname").val();
            var reg = /^1[3|4|5|7|8]\d{9}$/;
            if(!reg.test($.trim(tel))){
                $("#uname").focus();
                layer.msg('请填写正确的手机号!');
                return false;
            }

            $.ajax({
                url: site_url+'/member/SendMessage',
                data: {mobile: tel},
                dataType: 'json',
                type: 'post',
                beforeSend:function(){
                    $("#send_message").addClass('unclick');
                    $("#send_message").attr("onclick",'');
                },
                success: function (data) {
                    layer.msg(data.info);
                    if (data.status) {
//                        $('#ver').attr("ajaxurl","<?php //echo Mod::app()->createUrl('/member/verifyMsg')?>//?mobile="+mobile);
                        setTimeout(function () {
                            $("#send_message").html('<i class="time">60</i>秒后重新获取');
                            timer();
                        }, 100);
                    }else{
                        $('#codes').focus();
                        $("#send_message").removeClass('unclick');
                        $("#send_message").attr("onclick",'send_code()');
                        $("#send_message").html('免费获取验证码');
                    }
                }
            });
        }
    </script>
    <script type="text/javascript">
        var childWindow;
        function toQzoneLogin()
        {
            window.location.href="<?php echo $this->createUrl('member/qqlogin/state/computer')?>";
            //childWindow = window.open("<?php echo $this->createUrl('member/qqlogin/state/computer')?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
        }

    </script>
    <script type="text/javascript">
        var childWindow;
        function WxLogin()
        {
            window.location.href="<?php echo $this->createUrl('member/WXgetcode/state/computer')?>";
         //  childWindow = window.("<?php //echo $this->createUrl('member/WXgetcode')?>","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
        }

        function closeChildWindow()
        {
            childWindow.close();
        }
    </script>
</head>

<body>
<div class="ad-bg ad-top-bg" style='width:100%;text-align:center'>
    <div class="ad-head  clearfix" style='margin:0 auto'>
        <div class="fl ad-logo" style="margin:0 0 0 20px">
            <a href="<?php echo $this->_siteUrl; ?>"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-logo.png"  /></a>
        </div>
        <?php if(!$this->member || $this->member['pstatus']==0 || $this->member['status']==0){
               unset(Mod::app()->session['member']);
            ?>
        <div class="fr ad-login">
            <ul>
                <li><a class="linear" id="loginshow">登录</a></li>
                <li><a class="linear ad-regbtn" href="<?php echo $this->createUrl('/member/regone'); ?>">注册</a></li>
            </ul>
        </div>
        <?php }else{ ?>
        <div class="fr ad-haslogin" style='margin:0 20px 0 0'>
            <div class="ad-haslogin1">
                <div class="ad-haslogin-img"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-user-default-icon.png" /></div>
                <div class="ad-haslogin-info linear">
                    <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-user-default-icon.png"/></i>
                    <span class="clearfix">
                         <a href="<?php echo $this->createAbsoluteUrl('/site/updatememinfo'); ?>">修改资料</a>
                        <a href="<?php echo $this->createUrl('/member/logout'); ?>" class="loginout">退出</a>
                        </span>
                    <p>
                        如不上传头像，可自动默认
                        <br />为规格为100*100的默认头
                        <br />像png图片。
                    </p>
                </div>
            </div>
        </div>

        <?php } ?>

        <div class="ad-nav fr clearfix" >
            <ul>
                <li>
                    <i></i>
                    <a href="<?php echo $this->_siteUrl; ?>">首页</a>
                </li>
                <li class="<?php echo in_array($active, array('guanlizhongxin', 'xiugaiziliao', 'chuangjianyingyong')) || in_array($this->route, array('project/appmgt', 'project/appinfo', 'project/setting')) ? 'selected' : '';?>">
                    <i></i>
                    <?php if(!$this->member){?>
                        <a href="javascript:void (0)" class="linear btn1 btn-hover1" id="loginshows">管理中心</a>
                    <?php }else{ ?>
                        <a href="<?php echo $this->createUrl('/project/prolist'); ?>">管理中心</a>
                     <?php } ?>
                </li>
                <li class="">
                    <i></i>
                    <a href="<?php echo Mod::app()->createAbsoluteUrl('/wiki/')?>">文档资料</a>
                </li>
                <li class="">
                    <i></i>
                    <a href="<?php echo Mod::app()->createAbsoluteUrl('/wiki/help')?>">帮助中心</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php if($this->member && in_array($active, array('guanlizhongxin', 'xiugaiziliao', 'chuangjianyingyong'))) { ?>
    <div class="ad-bg ad-topnav-bg clearfix">
        <div class="ad-topnav clearfix w1000">
            <div class="fl ad-topnav1">
                <a href="<?php echo $this->createAbsoluteUrl('/project/prolist'); ?>">
                    <span><i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon1.png"/></i>管理中心</span>
                    <em><i>></i>应用管理</em>
                </a>
            </div>
            <div class="fl ad-topnav2">
                <ul>
                    <li id="<?php echo $this->route == 'project/prolist' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/project/prolist'); ?>">应用管理</a></li>
                    <li id="<?php echo $this->route == 'site/updatememinfo' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/site/updatememinfo'); ?>">修改资料</a></li>
                    <li id="<?php echo $this->route == 'dachu/sdk.zip' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/dachu/sdk.zip'); ?>">SDK下载</a></li>
                    <li id="<?php echo $this->route == 'project/createpro' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>">创建应用</a></li>
                </ul>
                <span></span>
            </div>
            <div class="fr ad-topnav3">
                <ul>
                    <li><a class="c1" href="javascript:void(0);">应用数据</a></li>
                    <li><a class="c2" href="javascript:void(0);">活动组件</a></li>
                    <li><a class="c3" href="javascript:void(0);">应用配置</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ad-top-tips w1000 mgt30 clearfix">
        <span>
            温馨提示：现在所有应用、组件属于初始阶段，如有意见或者建议请联系制作团队，感谢您协助完善产品,联系人QQ：22465878
        </span>
        <i class="tips-close fr"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon2.png"/></i>
    </div>
<?php } ?>

<?php if($this->member && in_array($this->route, array('project/appmgt', 'project/appinfo', 'project/setting'))) { ?>
    <div class="ad-bg ad-topnav-bg clearfix">
        <div class="ad-topnav clearfix w1000">
            <div class="fl ad-topnav1">
                <a href="<?php echo $this->createAbsoluteUrl('/project/prolist'); ?>">
                    <span><i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon1.png"/></i>管理中心</span>
                    <em><i>></i>应用管理</em>
                </a>
            </div>
            <div class="fl ad-topnav2">
                <ul>
                    <?php if($active_1 == 1) { ?>
                        <li id="<?php echo implode('/', $this->actionParams) == $this->actionParams['id'] ? 'navact' : ''; ?>"><a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid)); ?>">访问数据</a></li>
                        <li id="<?php echo implode('/', $this->actionParams) == $this->actionParams['id'].'/user' ? 'navact' : ''; ?>"><a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'user')); ?>">用户数据</a></li>
                        <li id="<?php echo implode('/', $this->actionParams) == $this->actionParams['id'].'/behavior' ? 'navact' : ''; ?>"><a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>'behavior')); ?>">行为数据</a></li>
                        <li id="<?php echo implode('/', $this->actionParams) == $this->actionParams['id'].'/points' ? 'navact' : ''; ?>"><a href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid,'tab'=>"points")); ?>">积分数据</a></li>
                    <?php } ?>
                    <?php if(in_array($active_1, array(3, 4))) { ?>
                        <li id="<?php echo $this->route == 'project/appinfo' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$pid)); ?>">应用信息</a></li>
                        <li id="<?php echo $this->route == 'project/setting' ? 'navact' : ''; ?>"><a href="<?php echo $this->createAbsoluteUrl('/project/setting',array('id'=>$pid)); ?>">接口配置</a></li>
                    <?php } ?>
                </ul>
                <span></span>
            </div>
            <div class="fr ad-topnav3">
                <ul>
                    <li class="<?php echo $active_1 == 1 ? 'selected' : ''; ?>"><a class="c1" href="<?php echo $this->createUrl('/project/appmgt',array('id'=>$pid))?>">应用数据</a></li>
                    <li class="<?php echo $active_1 == 2 ? 'selected' : ''; ?>"><a class="c2" href="<?php echo $this->createUrl('project/activityall',array('pid'=>$pid))?>">活动组件</a></li>
                    <li class="<?php echo in_array($active_1, array(3, 4)) ? 'selected' : ''; ?>"><a class="c3" href="<?php echo $this->createUrl('/project/appinfo',array('id'=>$pid))?>">应用配置</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ad-top-tips w1000 mgt30 clearfix">
        <span>
            温馨提示：现在所有应用、组件属于初始阶段，如有意见或者建议请联系制作团队，感谢您协助完善产品,联系人QQ：22465878
        </span>
        <i class="tips-close fr"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon2.png"/></i>
    </div>
<?php } ?>

<!--登录框-->
<div class="op-mask"></div>
<div class="op-login-div" style="padding: 20px 40px; z-index: 999; display: none; " >
    <!-- <i class="close" id="loginhide"><img src="<?php echo $this->_theme_url; ?>assets/index/images/login-close.png"></i> -->
    <form id="op-login-div">

        <div class="op-login-tit">
            <img src="<?php echo $this->_siteUrl; ?>/assets/index/images/login-div-txt.png"/>
        </div>

        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" value="">
        </div>

        <div class="op-login-input">
          <!--  <input type="password" id="upwd" placeholder="请输入密码">-->
            <input type="text" style="width: 60%;" id="codes" name="codes" placeholder="请输入验证码">
            <span>
                <a href="javascript: void(0);" style=" padding: 8px 10px;  cursor: pointer;  position: relative;  right: -24px;" id="send_message" class="adbtn linear" onclick="send_code()">免费获取验证码</a>
            </span>
        </div>

        <div class="op-login-error" style="margin: 5px auto;"></div>

        <div class="op-login-reg clearfix">
<!--            <span class="fl"><input type="checkbox" checked="checked" name="regname" id="regname" value="1"><label for="regname">记住账号</label></span>
-->          <!--  <span class="fr"><a href="<?php /*echo $this->createUrl('/member/findPass'); */?>">忘记密码</a></span>-->
        </div>

        <div class="op-login-dlbtn">
            <a id="loginbtn">登录</a>
        </div>

        <div class="op-login-dlbtn op-login-regbtn">
            <a href="<?php echo $this->createUrl('/member/regone'); ?>">注册</a>
        </div>
        <a href="#" class="three" onclick='toQzoneLogin()'><img src="<?php echo $this->_theme_url; ?>assets/images/QQ.png"></a>
        <a href="#"  onclick='WxLogin()'><img src="<?php echo $this->_theme_url; ?>assets/images/weixin.png"></a>
    </form>
</div>

