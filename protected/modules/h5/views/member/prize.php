<?php echo $this->renderpartial('/common/header',$config); ?>
<style>
    .top-title {    height: 72px;
    line-height: 72px;
    background: #3497da; }
    .top-title .lefta {     font-size: 28px;
    color: #fff;
    padding-left: 55px;
    position: relative; }
    .top-title .lefta:after {     content: "";
    display: block;
    border-top: 2px solid #fff;
    border-left: 2px solid #fff;
    width: 22px;
    height: 22px;
    position: absolute;
    top: 50%;
    transform: rotate(-45deg);
    -webkit-transform: rotate(-45deg);
    left: 28px;
    margin-top: -11px;}
    .u-top { position: relative; overflow: hidden; height: 100px; }
</style>
<div class="my_list_detail" style="margin-top: 0px">
    <div class="top-title clearfix">
        <a class="lefta fl" href="javascript:history.back();void(0)">我的奖品</a>
    </div>

<script type='text/javascript'>
/*个人中心我的奖品顶部banner*/
var cpro_id=28;
</script>
<script type='text/javascript' src='http://ads.dachuw.com/js/front/ads.js'></script>
    
<!--    <div class="title">-->
<!--        <div class="blank"></div>-->
<!--        <div class="name web_flex_1">我的奖品</div>-->
<!--         <!--<a class="all" href="#">-->
<!--                            查看全部 <span>></span>-->
<!--                    </a>-->
<!--    </div>-->
    <input type="hidden" id="limit" value="1">
    <?php if($prize){
        foreach ($prize as $list){?>
    <div class="item_style item_style_2">
        <div class="box">
            <div class="content">
                <!-- <div class="tag tag1"></div> -->
                <!-- <div class="out_time">3天过期</div> -->
                <a href="#" class="use">去使用</a>
                <div class="des1">
                    <?php echo $list['win_name'];?>
                </div>
                <div class="des2">使用条件：</div>
                <div class="des3">无门槛</div>
            </div>
            <div class="date"><?php echo $list['year']."-".$list['month']."-".$list['day']; ?>到期</div>
        </div>
    </div>
  <?php } } ?>
 </div>
</body>
<script type="text/javascript">
$(function(){
    $(window).scroll(function() {
        //$(document).scrollTop() 获取垂直滚动的距离
        //$(document).scrollLeft() 这是获取水平滚动条的距离
        // console.log("滚动条:"+$(document).scrollTop(),"document:"+$(document).height(),"window:"+$(window).height());
        // if ($(document).scrollTop() <= 0) {
        //     alert("滚动条已经到达顶部为0");
        // }
        if ($(document).scrollTop() >= $(document).height() - $(window).height() - 1) {
            var limit = $("#limit").val();
            // alert("滚动条已经到达底部为" + $(document).scrollTop());
             $.ajax({
                type: "GET",
                url: "<?php echo $this->createUrl('ajaxprize');?>",
                data: {
                    'limit': limit
                },
                success: function (result) {
                    if(result!=0){
                        $(".my_list_detail").append(result);
                        $("#limit").val(limit+1);
                    }
                }
            });
        }
    });
})
</script>
</html>
<?php exit; ?>


