<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="个人中心" />
    <meta name="description" content="个人中心" />
    <title>个人中心</title>
    <link rel="stylesheet" type="text/css" href="/themes/new/assets/h5newstyle/css/style.css"/>
    <script src="/themes/new/assets/h5newstyle/js/zepto.js"></script>
    <script src="/themes/new/assets/h5newstyle/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main">
    <div class="user-jf-nav clearfix user-jf-navc">
        <ul>
            <li class="selected">
                <a href="javascript:;">
                    <p><?php echo Mod::app()->session['member']['points']? Mod::app()->session['member']['points']:0?></p>
                    <p>我的积分</p>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->_siteUrl; ?>/b2c/wap/account/order_jf">
                    <p><?php echo $count_all;?></p>
                    <p>我的兑换</p>
                </a>
            </li>
        </ul>
    </div>


    <div class="user-jf-list">
        <ul>

            <?php if(!empty($info) && is_array($info)){ $i=1;foreach ($info as $v):?>


                <li>
                    <div class="user-jf-listdiv user-jf-listdivc1">
	    	    	  <span>
	    	    	  	<i><?php echo date('Y-m-d',$v['createtime']);?></i>
	    	    	  	<p><?php echo $v['content'];?></p>
	    	    	  </span>
                        <em><?php echo $v['qty'];?>积分</em>
                    </div>
                </li>
                <?php $i++;endforeach;}else{?>

                <li>
                    <div class="nodata-div">
                        <span><img src="/themes/new/assets/h5newstyle/images/nodata-img-jf.png"/></span>
                        <p>暂时还没有积分记录</p>
                    </div>
                    </li>
                <?php }?>

        </ul>

    </div>




</div>



</body>
</html>
