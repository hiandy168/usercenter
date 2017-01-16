<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>个人信息填写</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="1元夺宝，就是指只需1元就有机会获得一件商品，好玩有趣，不容错过。" />
    <meta name="keywords" content="1元,一元,1元夺宝,1元购,1元购物,1元云购,一元夺宝,一元购,一元购物,一元云购,夺宝奇兵" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, width=device-width">
    <meta content="telephone=no" name="format-detection">
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mimages/style.css?1445397915">

    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/index.css">
</head>
<body>

<div class="container">
    <h5 class="text-center" style="padding:12px 0;margin: 40px 0 20px 0">请填写个人信息，以便中奖后与您取得联系</h5>
    <form class="form-horizontal form" action="<?php echo $this->createUrl('/activity/duobao/address') ?>" method="post" enctype="multipart/form-data">
        <!-- <div class="form-group">
            <label class="col-sm-2 control-label">地址</label>
            <div class="col-sm-10">
                <input type="text" name="address" class="form-control" placeholder="请输入您的地址" >
            </div>
        </div> -->
        <div class="form-group">
            <label class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" name="uname" class="form-control" placeholder="请输入您的姓名" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">电话</label>
            <div class="col-sm-10">
                <input type="text" name="tel" class="form-control" placeholder="请输入您的手机号码" >
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary" style="width:100%;" />
            <input type="hidden" name="token" value="{$_W['token']}" />
            <input type="hidden" name="pid" value="<?php echo $pid ?>" />
            <input type="hidden" name="mid" value="{$memberid}" />
        </div>
    </form>

    <div class="g-footer">
        <div class="g-wrap">
            <ul class="m-state f-clear">
                <li><i class="ico ico-state ico-state-1"></i>公平公正公开</li>
                <li><i class="ico ico-state ico-state-2"></i>正品保证</li>
                <li class="last"><i class="ico ico-state ico-state-3"></i>权益保障</li>
            </ul>
            <p class="m-link">
                <a href="{php echo $this->createMobileUrl('clause')}">点击查看游戏说明</a>
            </p>
            <small>本活动的最终解释权归腾讯·大楚网所有</small>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(function(){

        function formcheck(){
            var tel = $("input[name=tel]").val(),
                name = $("input[name=uname]").val();

            if(!/^(13|14|15|18)\d{9}$/ig.test(tel)){
                alert("请输入正确的手机号！");
                return false;
            }

            if(name == ""){
                alert("请输入姓名");
                return false;
            }

            return true;
        }

    });
</script>

</body>
</html>