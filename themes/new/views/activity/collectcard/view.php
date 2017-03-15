<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <title>集卡</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/css/style.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js" type="text/javascript" charset="utf-8"></script>

</head>

<body>

<div id="loaddiv" class="loading-div">
			<span>
        <img src="<?php echo $this->_theme_url; ?>assets/subassembly/bigwheel/newassets/images/loading.gif"/>
			<i>努力加载中...</i>
		</span>
</div>
  

  <div class="mask"></div>
<div class="dial-pop">

    <div class="dial-poptxt">
        <h3>恭喜，哈哈哈！</h3>
        <p>集得<i>“一等奖”</i><br />
            你还有<b>8</b>集卡机会</p>
    </div>

    <div class="dial-confirmbtn">
        <a>确定</a>
    </div>
</div>





<div class="div-main">

    <div class="">
        <?php if($images->biaoyu){ ?>
        <img src="<?php echo JkCms::show_img($images->biaoyu)?>" width="100%" />
        <?php }else{?>
            <img src="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/images/jika-img1.jpg" width="100%" />
        <?php }?>
    </div>

    <div class="jika-slide" id="jslide">
        <ul>
           <?php if($prize){

           // foreach ($win_prize as $val){
            foreach ($prize as $val){
            ?>
            <li data-cardkind="<?php echo $val['title']?>" <?php if($val['win_num']==0){ echo 'class="gray"';}?>>
            <i><?php echo $val['win_num']?></i>
            <span>
                <img src="<?php echo JkCms::show_img($val['img'])?>" />
                </span>
                <p><?php echo $val['name']?></p>
            </li>
            <?php  }}else{ ?>
             <li>
            <i>0</i>
            <span>
                <img src="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/images/jika-img1_2.jpg" />
                </span>
                <p>来张卡</p>
            </li>
            <?php }?>
        </ul>
    </div>
          
    <div class="jika-btn">
        点击集卡
    </div>

    <div class="jika-tips">
        <h3>集卡活动规则</h3>
        <p><?php echo $info['rule']?></p>
    </div>
</div>





<script src="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/js/zepto.js"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/js/touch.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/collectcard/js/layout.js" type="text/javascript" charset="utf-8"></script>
</body>

</html>
<script type="text/javascript">
        openid = "<?php echo $param['openid']?>";
        id = "<?php echo $param['id']?>";
        pid = "<?php echo $param['id']?>";
        backUrl = "<?php echo $param['backUrl']?>";
        mid = "<?php echo $param['mid'] ?>";

    </script>
<script>

    var d = <?php echo $time;?>;
    var n = 0;
    var f = <?php echo $info['start_time'] ?>;
    var g = <?php echo $info['end_time'] ?>;
    var count = "<?php echo $num?>"; //当前用户今天可刮奖的次数
    var id = "<?php echo $info['id']?>";           //刮奖活动的id
    <?php if(!$param['mid']){?>
            showlogin();
            $("#winlogin").hide();
    <?php } ?>
     
    var getcard=function(){
     $.ajax({
                    type: "post",
                    cache: !1,
                    async: !1,
                    url: "<?php echo $this->createUrl('/activity/collectcard/getwin') ?>",
                    dataType: "json",
                    data: {
                        "id": id,
                        "mid": mid
                    },
                    beforeSend: function() {},
                    success: function(a) {
                        console.log(a);
                        if (a.code == 0) {
                            showpop("", a.msg, "", (a.dayCount), 2);
                            return false
                        }
                        if (a.code == -1) {
                            showpop("", a.msg, "", "", 3);
                            return false
                        }
                        if (a.code == -2) {
                            showpop("", a.msg, "", "", 3);
                            return false
                        }
                        if (a.code == -3) {
                            showpop("", a.msg, "", "", 3);
                            return false
                        }
                        if (a.code == -4) {
                            showpop("", a.msg, "", "", 3);
                            return false
                        }
                        if(a.code>0){
                           showpop("", a.prizeName, "", (a.dayCount), 1);
                           $('[data-cardkind='+a.prizeKind+']').removeClass('gray');
                           var mum=parseInt($('[data-cardkind='+a.prizeKind+']').find("i").text())+1;
                           $('[data-cardkind='+a.prizeKind+']').find("i").text(mum);
                        }
                       
                    },
                    error: function(a, b, c) {
                        showpop("", "网络异常", "", "", 3)
                    }
                })

    }
 
    
   $("html").on("tap",".jika-btn",function(){

        <?php if(!$param['mid']){ ?>
        showloginssss();
        return false;
        <?php } ?>

        if (d < f) {
                
              showpop("", "活动未开始！", "", "", 3);
              return false

           }
        if (d > g) {
            showpop("", "活动已结束！", "", "", 3);
            return false

        }
        <?php if(!$info['status']){?>
        showpop("", "活动暂停中！", "", "", 3);
        return false;
        <?php } ?>
        if (parseInt(count) < 1) {          
               showpop("", "今天次数用完了，明天再玩吧", "", "", 3);
               return false
        }
        n++;
       if(n==1){
        getcard();
       }

       
   }) 
     
     $(".dial-confirmbtn a").on("tap",function(){
        $(".mask").hide();
        $(".dial-pop").hide().removeClass("active");
        n=0;
     })


     
    function showpop(a, b, c, d, e) {
    $(".mask").show();
    $(".dial-pop").show().addClass("active");
    if (e == 1) {
        $(".dial-poptxt").html('<h3>恭喜，哈哈哈！</h3>' + '<p>集得<i>“' + b + '”</i><br />' + '你还有<b>' + d + '</b>集卡机会</p>')
    }
    if (e == 2) {
        $(".dial-poptxt").html('<h3>没有集得卡片</h3>' + '<p><i>“' + b + '”</i><br />你还有<b>' + d + '</b>集卡机会</p>')
    }
    if (e == 3) {
        $(".dial-poptxt").html('<h3>@__@</h3>' + '<p>' + b + '</p>')
    }
 
}


</script>