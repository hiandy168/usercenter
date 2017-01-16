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

    <div class="acdetails-tit vote-rankingtit">我的投票记录</div>


    <div class="vote-votelist">
        <div class="vote-votelist1">

            <ul>

                <?php foreach ($mylist as $k=>$v){?>
                <li>
                    <div class="vote-votelistdiv">
							<span>
								<img src="<?php echo JkCms::show_img($v['join']['img']) ?>"/>
							</span>

                        <dl>
                            <dd>
                                <em>名称：<?php echo $v['join']['title'] ?></em>
                                <em>排名：<?php echo $v['join']['top']?></em>
                            </dd>
                            <dd>
                                <em>ID：<?php echo $v['join']['id'] ?></em>
                                <em>票数：<?php echo $v['join']['vote_number'] ?></em>
                            </dd>

                        </dl>

                    </div>
                </li>

                <?php } ?>





            </ul>


        </div>

    </div>



</div>



</body>
</html>





