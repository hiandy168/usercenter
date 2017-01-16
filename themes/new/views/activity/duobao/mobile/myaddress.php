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
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/common.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/mcss/index.css">
</head>
<body>
<div class="container">
    <h5 class="text-center" style="padding:12px 0;margin: 40px 0 20px 0">请填写个人信息，以便中奖后与您取得联系</h5>
    <form class="form-horizontal form" action="<?php echo $this->createUrl('/activity/duobao/doInfo') ?>" method="post" enctype="multipart/form-data">
        <!--<div class="form-group">
            <label class="col-sm-2 control-label">地址</label>
            <div class="col-sm-10">
                <input type="text" name="address" class="form-control" value="<?php /*echo $info['address'] */?>" placeholder="请输入您的地址" >
            </div>
        </div>-->
        <div class="form-group">
            <label class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" name="uname" value="<?php echo $info['realname'] ?>" class="form-control" placeholder="请输入您的姓名" >
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">电话</label>
            <div class="col-sm-10">
                <input type="text" name="tel" value="<?php echo $info['mobile'] ?>" class="form-control" placeholder="请输入您的手机号码" >
            </div>
        </div>
        <div class="form-group col-sm-12">
            <input type="submit" name="submit" value="提交" class="btn btn-primary" style="width:100%;" />
            <input type="hidden" name="pid" value="<?php echo $info['pid'] ?>" />
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
                <a href="">点击查看游戏说明</a>
            </p>
            <small>本活动的最终解释权归腾讯·大楚网所有</small>
        </div>
    </div>
</div>
<script language="JavaScript" type="text/javascript">
    $.validator.addMethod("checkKey", function(value, element) {
        return this.optional(element) || /^[a-zA-Z]+$/.test($('#key').val());
    }, "格式不正确");
    $("#form_b").validate({
        errorClass: "error",
        highlight: function(element) {
            $(element).closest('td').addClass("f_error");
        },
        unhighlight: function(element) {
            $(element).closest('td').removeClass("f_error");
        },
        rules: {
            key: {
                required: true,
                checkKey: true
            },
            name: {
                required: true
            }
        },
        messages: {

            key: {
                required: "银行缩写不能为空"
            },
            name: "银行名称不能为空"


        },

        errorElement: 'span' ,
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler : function(form) {
            //box.confirm('提交后需等待管理员审核，<br />确认提交申请。',300,'审请广告', function(bool){
            //if(bool){
            form.submit();
            //}
            //});
        }

    });

</script>


</body>
</html>