<html>
<head>
    <title>我要报名</title>
</head>
<body>
<form action="<?php echo $this->createUrl('/activity/signup/addSignUp'); ?>" method="post" id="myForm">
    <table align="center">
        <tr>
            <td>用户名：</td>
            <td><input type="text" name="username" id="username"/></td>
        </tr>
        <tr>
            <td>邮箱：</td>
            <td><input type="text" name="email" id="email"/></td>
        </tr>
        <tr>
            <td colspan="2"><button type="button" onclick="checkForm()">提交</button></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<script src="<?php echo $this->_theme_url; ?>js/jquery.2.1.1.min.js"></script>
<script type="text/javascript">
    function checkForm(){
        var username = $('#username').val();
        var email = $('#email').val();
        if(username.trim() == ''){
            ship_mess('用户名不能为空');
            $('#username').focus();
            return false;
        }
        //验证邮箱
        if(email.trim()=="")
        {
            ship_mess("邮箱不能为空");
            return false;
        }
        if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
        {
            ship_mess("邮箱格式不正确！请重新输入");
            $("#email").focus();
            return false;
        }
        $.getJSON('<?php echo $this->createUrl('/activity/signup/addSignUp') ?>',
            {access_token:'<?php echo $token; ?>',openid:'<?php echo $openid; ?>',username:username,email:email},
            function(data){
                ship_mess(data.mess);
            });
    }
</script>