<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="积分商城" />
    <meta name="description" content="积分商城" />
    <title>积分商城</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/css/style.css"/>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo Mod::app()->theme->baseUrl; ?>/wap/template/1.1/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<script>
    var siteUrl = "<?php echo $this->_siteUrl; ?>";
</script>

<div class="div-main" id="content">
   <!-- <div class="top-title clearfix">
        <a class="lefta fl" href="javascript:history.back();void(0)">搜索</a>
    </div>-->


    <input type="hidden" id="keyword" value="<?php echo htmlspecialchars($keyword);?>">

    <div class="shop-cplistrdiv shop-morecplistrdiv clearfix">
        <ul>
            <div id="li-l">

            </div>
            <!--            <li>-->
            <!--                <a href="">-->
            <!--                    <div class="shop-cpdiv">-->
            <!--                        <img src="--><?php //echo Mod::app()->theme->baseUrl; ?><!--/wap/template/1.1/images/shop-img4.jpg"/>-->
            <!--          						<span>-->
            <!--          							<h3>腾讯QQ公仔（经典款）</h3>-->
            <!--          							<h4>积分：20000</h4>-->
            <!--          							<p>已有5000人兑换</p>-->
            <!--          						</span>-->
            <!--                    </div>-->
            <!---->
            <!--                </a>-->
            <!--            </li>-->
        </ul>
    </div>






</div>
<script src="<?php echo Mod::app()->theme->baseUrl; ?>/jifen/js/jquery-1.12.0.min.js" type="text/javascript"></script>

<script type="text/javascript">

    $(document).ready(function(){
        var range = 50;             //距下边界长度/单位px
        var elemt = 500;           //插入元素高度/单位px
        var maxnum = 20;            //设置加载最多次数
        var num = 0;
        var totalheight = 0;
        var content_height=$("#content").height();
        var jf_height=$(".top-title ").height(); //头部高度
        var li_height=170+12;

        var keyword=$("#keyword").val();
        console.log((parseFloat($(window).height())-jf_height ));
        console.log((li_height * 4));
//        if(content_height < parseFloat($(window).height())){

        var i_num = Math.ceil((parseFloat($(window).height())-jf_height )/ (li_height * 4));
        console.log(i_num);
        $.ajax({
            type: "post",
            url: siteUrl + '/b2c/wap/default/Ajaxsearchpro',
            data: {page: i_num,one : true,keyword:keyword},
            dataType: 'json',
            beforeSend: function () {
//                            ship_mess_big('记载中........');
            },
            success: function (data) {
                console.log(data);
                num=i_num;
                if (data.code === 200) {
                    var nr = "";
                    for (var i = 0; i < data.data.length; i++) {
                        var htmln = "<li style='height:170px;'><a href='/jfshop/b2c/wap/product/detail/id/"+data.data[i]['goods_id']+".html'><div class='shop-cpdiv'><img style='height: 130px;' src='<?php echo $this->_siteUrl; ?>" + "/" + data.data[i]['s_url'] + "'/><span><h3>"+data.data[i]['name'] +"</h3><h4>积分："+data.data[i]['price_jifen'] +"</h4><p>已有"+data.data[i]['con']+"人兑换</p></span></div></a></li>";
                        nr += htmln;
                    }
                    $("#li-l").append(nr);

                } else {
                    console.log(data.mess);
                }
            },
            error: function () {
                alert(data.mess)
            }
        });
//        }
        $(window).scroll(function(){
            var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)
//                console.log( parseFloat(srollPos));
            //console.log("滚动条到顶部的垂直高度: "+$(document).scrollTop());
            //console.log("页面的文档高度 ："+$(document).height());
            //console.log('浏览器的高度：'+$(window).height());
//                console.log(($(document).height()-range));
//                console.log(totalheight);

            totalheight = parseFloat($(window).height()) + parseFloat(srollPos);

            if(($(document).height()-range) <= totalheight  && num != maxnum && parseFloat(srollPos) > 0  ) {
//                    if(num > 0) {
                num++;

                console.log(num);
                $.ajax({
                    type: "post",
                    url: siteUrl + '/b2c/wap/default/Ajaxsearchpro',
                    data: {page: num,keyword:keyword},
                    dataType: 'json',
                    async:false,//false代表只有在等待ajax执行完毕后才执行window.open('http://www.daimajiayuan.com')语句
                    beforeSend: function () {
//                            ship_mess_big('记载中........');
                    },
                    success: function (data) {
                        console.log(data);
//                                num++;
                        if (data.code === 200) {
                            var nr = "";
                            for (var i = 0; i < data.data.length; i++) {
                                var htmln = "<li style='height:170px;'><a href='/jfshop/b2c/wap/product/detail/id/"+data.data[i]['goods_id']+".html'><div class='shop-cpdiv'><img style='height: 130px;' src='<?php echo $this->_siteUrl; ?>" + "/" + data.data[i]['s_url'] + "'/><span><h3>"+data.data[i]['name'] +"</h3><h4>积分："+data.data[i]['price_jifen'] +"</h4><p>已有"+data.data[i]['con']+"人兑换</p></span></div></a></li>";
                                nr += htmln;
                            }
                            $("#li-l").append(nr);

                        } else {
                            console.log(data.mess);
                        }
                    },
                    error: function () {
                        alert(data.mess)
                    }
                });
//                    }
            }
        });
    });


</script>

</body>
</html>
