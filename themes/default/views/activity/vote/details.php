<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="投票" />
    <meta name="description" content="投票" />
    <title>投票</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>vote/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>vote/js/zepto.js"></script>
    <script src="<?php echo $this->_theme_url; ?>vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main" style="background: #f6f7f7;">

    <div class="vote-details">

        <div class="">
            <img src="<?php echo $this->_theme_url; ?>vote/images/vote-img1.jpg" width="100%" />
        </div>

        <div class="vote-details1 clearfix">
            <em class="fl">ID:<?php echo $join['id']?></em>
            <em class="fr"><?php echo $join['title']?></em>
        </div>
        <div class=" vote-details1 vote-details2 clearfix">
            <em class="fl">排名：<?php echo $join['top']?></em>
            <em class="fr">票数：<?php echo $join['vote_number']?></em>
        </div>
        <div class="vote-details1 vote-details3">
            <h3>参赛宣言</h3>
        </div>
        <div class="vote-details4">
            <p><?php echo $join['remark']?></p>
        </div>
        <div class="vote-details5">
            <a  onclick="vote(<?php echo $join['id']?>)">投我一票</a>
        </div>

    </div>

</div>
<script>
    function vote(vid){
        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('/activity/vote/ajaxvote');?>",
            data:{
                "vid": <?php echo $vid?>,
                "id":vid,
                "mid":<?php echo $mid?>
            },
            success: function(msg){
                // alert(msg);
                if(msg==1){
                    alert("投票成功");
                    window.location.reload();//刷新当前页面
                }else if(msg==2){
                    alert("参数错误");
                }else if(msg==4){
                    alert("您已经投过票了");
                    //window.location.reload();
                }else{
                    alert("数据错误");
                }
            }
        });

    }
</script>


</body>
</html>





