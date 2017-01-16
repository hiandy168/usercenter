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
    <script>
        var siteUrl = "<?php echo $this->_siteUrl; ?>";
    </script>
    <script src="/themes/new/assets/h5newstyle/js/zepto.js"></script>
    <script src="/themes/new/assets/h5newstyle/js/layout.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>

<div class="div-main">

    <div class="user-jf-nav clearfix user-jf-navc">
        <ul>
            <li>
                <a href="<?php echo $this->_siteUrl; ?>/b2c/wap/account/order_jflog">
                    <p><?php echo Mod::app()->session['member']['points']? Mod::app()->session['member']['points']:0?></p>
                    <p>我的积分</p>
                </a>
            </li>
            <li class="selected">
                <a href="javascript:;">
                    <p ><?php echo $count_all;?></p>
                    <p>我的兑换</p>
                </a>
            </li>
        </ul>
    </div>


    <div class="user-jf-list">
        <ul>
            <div id="li-l">
                <div class="nodata-div">
                    <span><img src="/themes/new/assets/h5newstyle/images/nodata-img-jf.png"/></span>
                    <p>暂时还没有积分兑换记录</p>
                </div>
            </div>

         </ul>

    </div>




</div>



</body>
</html>

<script src="<?php echo Mod::app()->theme->baseUrl; ?>/jifen/js/jquery-1.12.0.min.js" type="text/javascript"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            var range = 50;             //距下边界长度/单位px
            var elemt = 500;           //插入元素高度/单位px
            var maxnum = 20;            //设置加载最多次数
            var num = 0;
            var totalheight = 0;
            var content_height=$(".user-jf-list").height();
           // var jf_height=$(".jf-dh-nav").height(); //头部高度+20固定高度
            var li_height=54;

            if(content_height < parseFloat($(window).height())){
               var i_num = Math.ceil((parseFloat($(window).height()) )/ (li_height * 5));

                $.ajax({
                    type: "post",
                    url: siteUrl + '/b2c/wap/account/Ajaxorder_jf',
                    data: {page: i_num,one : true},
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

                                var htmln ="<li><div class='user-jf-listdiv user-jf-listdivc2'> <span><i>" + data.data[i]['cr_time'] + "</i><p>" + data.data[i]['name'] + "</p></span><em>x" + data.data[i]['quantity'] + "</em></div></li>";
                                    nr += htmln;
                            }
                          //  $("#li-l").append(nr);
                            if(data.data.length>0){
                                $("#li-l").html(nr);
                            }

                        } else {
                            console.log(data.mess);
                        }
                    },
                    error: function () {
                        alert(data.mess)
                    }
                });
            }
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
                            url: siteUrl + '/b2c/wap/account/Ajaxorder_jf',
                            data: {page: num},
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
                                        var htmln ="<li style='height: 100px'><div class='user-jf-listdiv user-jf-listdivc2'> <span><i>" + data.data[i]['cr_time'] + "</i><p>" + data.data[i]['name'] + "</p></span><em>x" + data.data[i]['quantity'] + "</em></div></li>";
                                        nr += htmln;
                                    }

                                   // $("#li-l").append(nr);
                                    if(data.data.length>0){
                                        $("#li-l").html(nr);
                                    }


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





