<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>接口测试</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/css/bootstrap.min.css" />
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>js/lib/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl?>/assets/public/bootstrap/js/bootstrap.min.js"></script>
</head>

<body>

<pre>
<h3>接口测试</h3>
<a target="_blank" href="<?php echo $this->createUrl('/api/token/get')?>?appid=101056&appkey=26e4cc3d389b8cae">获取token</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/getopenid')?>">获取openid</a>
<a target="_blank" href="<?php echo $this->createUrl('/api/member/GetMember')?>">获取用户中心用户</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberReg')?>?tel=15888888888&password=scott12356&repassword=scott12356&appid=101056&appkey=26e4cc3d389b8cae">用户注册</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberLogin')?>?name=15888888888&password=scott12356&&appid=101056&appkey=26e4cc3d389b8cae">用户登录</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/MemberTag')?>?appid=101056&appkey=26e4cc3d389b8cae&pid=46&type=3">用户标签设置</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/addsignlog')?>?appid=101056&appkey=26e4cc3d389b8cae">签到</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/addSignUp')?>?appid=101056&appkey=26e4cc3d389b8cae">报名</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/start')?>?appid=101056&appkey=26e4cc3d389b8cae">抽奖</a>
<a target="_blank" href="<?php echo $this->createUrl('/activity/scratchcard/')?>">刮刮卡</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/projectreg')?>">注册项目</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/projectlist')?>">项目编辑</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/behaviorstatistics')?>?appid=101056&appkey=26e4cc3d389b8cae&type=3&remark=test_remark">用户行为上报</a>
<a target="_blank" href="<?php echo $this->createUrl('/demo/citylife')?>">城市服务</a>
</pre>


<input id="btntext" type="button" value="添加文本组件" data-toggle="modal" data-target="#myModal"  href="../SysManage/ZuJianManage.aspx"/>
<script type="javascript">
    $(document).ready(function(){
      $('#myModal').modal('show');
    });
</script>
<!-- Modal -->
<div class="modal hide fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
        <h3 id="myModalLabel">Modal header</h3>
    </div>
    <div class="modal-body"></div>
</div>

</body>
</html>