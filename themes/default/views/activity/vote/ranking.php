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

    <div class="acdetails-tit vote-rankingtit">票数排名</div>


    <div class="vote-ranking">
        <div class="vote-ranking1">
            <ul>
                <li class="tit">
                    <span>排名</span>
                    <span>ID/名称</span>
                    <span>票数</span>
                </li>

                <?php
                $i=1;
                foreach ($votelist as $k=>$v){

                ?>
                <li class="bb">
                    <span><?php echo $i?></span>
                    <span><i>ID:<?php echo $v['id']?></i><i><?php echo $v['title']?></i></span>
                    <span><?php echo $v['vote_number']?></span>
                </li>
                <?php
                    $i++;
                }
                ?>


            </ul>
        </div>

    </div>



</div>



</body>
</html>





