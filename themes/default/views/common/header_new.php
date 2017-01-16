<!DOCTYPE html>
<html>
<head>
    <script>
        var Siteurl = "<?php echo $this->_siteUrl; ?>";
    </script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="robots" content="all">
    <meta name="renderer" content="webkit">
    <title><?php  echo $site_title?>-大楚用户开放平台</title>
    <meta name="Keywords" content="大楚用户开放平台" />
    <meta name="Description" content="大楚用户开放平台" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/index/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/index/css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_siteUrl; ?>/assets/index/css/style.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/index/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/index/js/index.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/new_site.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/common-v1.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/font-awesome.css">
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/home.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
    
</head>

<body>
   <div class="d-bg d-top-bg">
        <div class="clearfix w1140 d-top-head">
            <div class="logo fl">
                <a href=""><img src="<?php echo $this->_siteUrl; ?>/assets/index/images/op-logo.png" alt="" /></a>
                <!--<a href=""><img src="<?php echo $this->_theme_url; ?>logo.png" alt="" style='height:43px;width:320px;' /></a>-->
            </div>
            <div class="login fr">
                <ul>
                    <?php if(!$this->member){?>
                        <li><a class="linear btn1 btn-hover1" id="loginshow">登录</a></li>
                        <li><a class="linear btn2" href="<?php echo $this->createUrl('/member/regone'); ?>">注册</a></li>
                    <?php }else{ ?>
                        <li>
                        <a style="color: #97ff00;"><?php echo $this->member['name'];?></a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('/member/logout'); ?>">退出</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="nav">
                <ul>
                    <li class="<?php echo $active=='shouye' ? 'selected' : '';?>">
                        <i></i>
                        <a href="<?php echo $this->_siteUrl; ?>">首页</a>
                    </li>
                    <li class="<?php echo $active=='guanlizhongxin' ? 'selected' : '';?>">
                        <i></i>


                        <?php if(!$this->member){?>
                            <a href="javascript:void (0)" class="linear btn1 btn-hover1" id="loginshows">管理中心</a>
                        <?php }else{ ?>
                            <a href="<?php echo $this->createUrl('/project/prolist'); ?>">管理中心</a>
                        <?php } ?>

                    </li>
                    <li class="<?php echo $active=='wendangziliao' ? 'selected' : '';?>">
                        <i></i>
                        <a href="<?php echo Mod::app()->createAbsoluteUrl('/wiki')?>">文档中心</a>
                    </li>
                    <!--<li >
                        <i></i>
                        <a href="">FAQ</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>


<!--mask star login-->

<div class="op-mask"></div>
    <div class="op-login-div" style="padding: 20px 40px; z-index: 999; display: none; ">
        <!-- <i class="close" id="loginhide"><img src="<?php echo $this->_theme_url; ?>assets/index/images/login-close.png"></i> -->
        <form>
           
           <div class="op-login-tit">
            <img src="<?php echo $this->_siteUrl; ?>/assets/index/images/login-div-txt.png"/>
           </div>
        
        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" value="">
        </div>
         
         <div class="op-login-input">
            <input type="password" id="upwd" placeholder="请输入密码">
         </div>
         
         <div class="op-login-error" style="margin: 5px auto;"></div>
         
         <div class="op-login-reg clearfix">
                <span class="fl"><input type="checkbox" checked="checked" name="regname" id="regname" value="1"><label for="regname">记住账号</label></span>
                <span class="fr"><a href="<?php echo $this->createUrl('/member/findPass'); ?>">忘记密码</a></span>
            </div>
            
          <div class="op-login-dlbtn">
            <a id="loginbtn">登录</a>
          </div>
  
          <div class="op-login-dlbtn op-login-regbtn">
            <a href="<?php echo $this->createUrl('/member/regone'); ?>">注册</a>
          </div>
          

        </form>
    </div>




