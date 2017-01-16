<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="<?php echo $this->_theme_url; ?>assets/mjs/jquery-1.11.1.min.js" type="text/javascript" charset="utf-8"></script>
    <title></title>
</head>
<body>

<div style="margin-left: 10px;color:#556B2F;font-size:30px;font-weight: bolder;"</div><br/>
<img alt="模式二扫码支付" src="http://paysdk.weixin.qq.com/example/qrcode.php?data=<?php echo urlencode($url2);?>" style="width:150px;height:150px;"/>
</body>
<script type="text/javascript">
   /* var int=self.setInterval("orderStatus()",3000);*/
    function orderStatus()
    {
        $.getJSON("http://m.dachuw.net/activity/duobao/ss", function(code){
            if(code=='100'){
                alert("支付成功");
                window.location.href="http://m.dachuw.net/activity/duobao/mylog/pid/<?php echo $pid;?>";
            }
        });
    }
    window.setInterval(function(){
        orderStatus();
    },3000);
</script>


</html>