<?php
/**
 * Created by PhpStorm.
 * User: xiaoxindezhihui
 * Date: 2016/9/23
 * Time: 11:45
 */
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="活动" />
    <meta name="description" content="活动" />
    <title>活动</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/newapp/css/style.css"/>
    <script src="<?php echo $this->_theme_url;?>assets/h5/newapp/js/zepto.js"></script>
    <script src="<?php echo $this->_theme_url;?>assets/h5/newapp/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main" style="overflow: hidden;">


    <div class="news-nav clearfix">
        <ul>
            <li class="bb">
                <div class="tnav">
                    <i class="icon1"></i>
                    <em>选择时间段查看</em>
                    <b></b>
                </div>
            </li>
            <li class="bb bl">
                <div class="tnav">
                    <i class="icon2"></i>
                    <em>选择类型查看</em>
                    <b></b>
                </div>
            </li>
        </ul>
    </div>

    <div class="user-mask1" id="umask"></div>

    <div class="news-t-nav">

        <div class="news-t-navlist">
            <ul>
                <li class="bb selected"><a href="<?php echo $this->createUrl('/h5/newApp/index/datetime/all'); ?>">全部</a></li>
                <li class="bb"><a href="<?php echo $this->createUrl('/h5/newApp/index/datetime/day'); ?>">最近一天</a></li>
                <li class="bb"><a href="<?php echo $this->createUrl('/h5/newApp/index/datetime/three'); ?>">最近三天</a></li>
                <li class="bb"><a href="<?php echo $this->createUrl('/h5/newApp/index/datetime/week'); ?>">最近一周</a></li>
                <li class="bb"><a href="<?php echo $this->createUrl('/h5/newApp/index/datetime/month'); ?>">最近一月</a></li>
            </ul>
        </div>


        <div class="news-t-navlist">
            <ul>
                <li class="bb <?php echo $selected?false:"selected"; ?>"><a href="<?php echo $this->createUrl('/h5/newApp/index'); ?>">全部</a></li>
                <?php
                $criteria = new CDbCriteria();
                $criteria->condition ='is_delete=0';
                 $listClass=Activity_class::model()->findAll();
                foreach($listClass as $val){?>
                <li class="bb <?php echo $selected==$val->id?"selected":false; ?>" value="<?php echo $val->id ?>">
                    <a href="<?php echo $this->createUrl('/h5/newApp/index/classid/'.$val->id); ?>"><?php echo $val->class_name?></a>
                </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <div class="news-list">
        <ul>
            <?php if($recommendlist){ foreach($recommendlist as $k=>$v){ ?>
            <li>
                <div class="news-listdiv news-listdivc1">

                    <i class="img-mask"></i>
                    <?php if(!$v['image']){?>
                        <img class="img-bg" src="<?php echo $this->_theme_url;?>assets/h5/newapp/images/news-img1.jpg"/>
                    <?php }else{?>
                        <img class="img-bg" src="<?php echo Tool::show_img($v['image'])?>"/>
                    <?php }?>
                    <div class="t-data clearfix">
                        <em class="fl"><?php echo $v['class']?></em>
	    	    	   	<span class="fr">
	    	    	   		<i class="icon-num1"><?php echo $v['pv']?></i>
	    	    	   	<!--	<i class="icon-num2"><?php /*echo $v['uv']*/?></i>-->
	    	    	   	</span>
                    </div>

                    <div class="news-txta">
                        <h2><?php echo $v['title']?></h2>
                        <h3><?php echo $v['describe']?></h3>
                        <a href="javascript:;" onclick="clickpv(<?php echo $v['aid']?>,'<?php echo $v['url']?>')">
                            立即参加</a>
                    </div>

                </div>

            </li>
            <?php }}else{?>
                <li>
                    <div class="news-listdiv news-listdivc1">

                     <p style="text-align: center"> 没有数据</p>

                    </div>

                </li>
            <?php }?>
        </ul>

    </div>




</div>



<script type="text/javascript" charset="utf-8">

    var navli=$(".news-nav ul li");
    var navli1=$(".news-t-navlist ul li");
    var newscon=$(".news-t-navlist");
    var umask=$("#umask");
    navli.on("touchstart",function(){
        navli.removeClass("selected");
        $(this).addClass("selected");
        var i=navli.index(this);
        umask.show();
        newscon.hide().eq(i).show();
    })
    umask.on("touchstart",function(){
        navli.removeClass("selected");
        umask.hide();
        newscon.hide();
    })
    navli1.on("touchstart",function(){
        $(this).addClass("selected").siblings().removeClass("selected");
    })


    //增加点击量
    function clickpv( aid,url){

        $.ajax({
            type: "get",
            url: "<?php echo $this->createUrl('/h5/member/click');?>",
            data:{
                "aid": aid,
            },
            success: function(msg){
                //  alert(msg);
            }


        });
        //alert(url);
        location.href= url;
    }



</script>



</body>
</html>
