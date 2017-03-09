<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $config['site_title'] ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/new/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js" type="text/javascript" charset="utf-8"></script>


</head>
<script type="text/javascript">
    openid = "<?php echo $param['openid']?>";
    id = "<?php echo $param['id']?>";
    pid = "<?php echo $param['id']?>";
    backUrl = "<?php echo $param['backUrl']?>";
    mid = "<?php echo $param['mid'] ?>";
    table = "wenda";
    start_time="<?php echo$info['start_time'];?>"
    end_time="<?php echo$info['end_time'];?>"
</script>
<body>



<div id="loaddiv" class="loading-div">
		<span>
			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/loading.gif"/>
			<i>努力加载中...</i>
		</span>
</div>


<div class="mask"></div>
<div class="dial-pop" >

    <div class="dial-poptxt">
        <h3>恭喜！你中奖了</h3>
        <p>中得<i>“一等奖”</i>领奖码 <i>123456</i><br>
            你还有<b>8</b>次刮奖机会</p>
    </div>

    <div class="dial-confirmbtn">
        <a data-a-link="a" href="">确定</a>
    </div>
</div>

<div class="div-main">


    <div class=""><img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/dati-img1.jpg" width="100%"/></div>
    <div class="pos-r" style="overflow: hidden;">
    <!-- <img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/dati-img3.jpg" width="100%"/> -->
        <form action="" method="post" >
            <div class="wrapper">
                <div id="answer" class="card_wrap">
                    <!--Q1-->
                    <?php if($question_arr){
                    foreach ($question_arr as $q_key=>$q_val){ ?>
                    <div class="card_cont card<?php echo $q_val['sort'];?>">
                        <div class="card">
                            <p class="question"><span>Q<?php echo $q_val['sort'];?>、</span><?php echo $q_val['question'];?></p>
                            <ul class="select" data-select="select">
                                <?php foreach ($q_val['answer_arr'] as $a_key => $a_val){ ?>
                                <li>
                                    <input id="q<?php echo $q_val['sort'];?>_<?php echo $a_key+1;?>" type="radio" name="r-group-<?php echo  $a_val['questionid'];?>" value="<?php echo $a_val['id'];?>" >
                                    <label for="q<?php echo $q_val['sort'];?>_<?php echo $a_key+1;?>"><?php echo $a_val['answer'];?></label>
                                </li>
                                <?php } ?>


                            </ul>
                            <div class="card_bottom"><?php if ($q_val['sort']>1){ ?><a class="prev">上一题</a><?php } ?><span><b><?php echo $q_val['sort'];?></b>/<?php echo $q_val['count'];?></span></div>
                        </div>
                    </div>
                    <?php }}?>





                </div><!--/card_wrap-->

            </div>


            <div class="dati-submit pos-r">
                <input type="button"  id="subbtn" value="提交答题"/>
            </div>
        </form>

        <div class="deggs-rule" >
            <h3>活动规则</h3>
	    		<span>
	    			<?php echo $info['rule'];?>
	    		</span>
        </div>


        <?php if($info['is_prize']==1){?>
        <div class="deggs-rule">
            <h3>获奖资格</h3>
	    		<span>
	    			活动期间，同一用户答对<?php echo $info['wenda_prize_num'];?>题，即可有机会参与抽奖。
	    		</span>
        </div>
        <?php } ?>


    </div>

</div>

<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/zepto.js"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/answer.js"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/touch.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/layout.js" type="text/javascript" charset="utf-8"></script>
<script>
   /**
     *   ┏┓　　　┏┓
     * ┏┛┻━━━┛┻┓
     * ┃　　　　　　　┃
     * ┃　　　━　　　┃
     * ┃　┳┛　┗┳　┃
     * ┃　　　　　　　┃
     * ┃　　　┻　　　┃
     * ┃　　　　　　　┃
     * ┗━┓　　　┏━┛
     *    ┃　　　┃
     *    ┃　　　┃
     *    ┃　　　┗━━━┓
     *    ┃　　　　　　　┣┓
     *    ┃　　　　　　　┏┛
     *    ┗┓┓┏━┳┓┏┛
     *      ┃┫┫　┃┫┫
     *      ┗┻┛　┗┻┛
     *        神兽保佑
     *        代码无BUG!
     */

   <?php if(!$param['mid']){?>
   showlogin();
   <?php } ?>

    var d = <?php echo $time;?>;
    var f = <?php echo $info['start_time'] ?>;
    var g = <?php echo $info['end_time'] ?>;

    $(function(){
        $("#answer").answerSheet({});
    })

    var answer_arr_id=[];
    var sel=$('[data-select="select"]')
    $("#subbtn").on("click",function(){
        for (var i=0,n=sel.length;i<n;i++) {
            if(sel.eq(i).find("input[type=radio]:checked").length==0){
                alert("请选择"+sel.eq(i).prev().text()+"的答案");
                return false;
            }else{
                answer_arr_id[i]=sel.eq(i).find("input[type=radio]:checked").val();

            }
        }
//        console.log(answer_arr_id);


        var _this=$(this);

        if (d < f) {

            showpop("", "活动未开始！", "", 5);
            return false

        }
        if (d > g) {

            showpop("", "活动已结束！", "", 5);
            return false

        }
        <?php if(!$info['status']){?>
        showpop("", "活动暂停中！", "",  5);
        return false;
        <?php } ?>
//
        $.ajax({
            type: "post",
            cache: !1,
            async: !1,
            url: "<?php echo $this->createUrl('activity/wenda/getuseranswer')?>",
            dataType: "json",
            data: {
                "wendaid":<?php echo $info['id']?>,
                "answer_arr_id":answer_arr_id,
            },
            success: function (data) {
                var url = "<?php echo $this->createUrl('activity/wenda/view',array('id'=>$info['id']))?>?v"+Math.random();
                if(data.status==200){
                    //是否参与抽奖
                    if(<?php echo $info['is_prize']?1:0;?>){
                        //抽奖组件 等于2 是大转盘  等于1 是刮刮卡
                        <?php if($info['activity_type']==2){ ?>
                        var url="<?php echo $this->createUrl('/activity/bigwheel/view/id/'.$info['activity_id'])?>";
                        <?php }else{ ?>
                        var url="<?php echo $this->createUrl('/activity/scratchcard/view/id/'.$info['activity_id'])?>";
                        <?php }?>
                        showpop(data.data['bingo_num'],url,data.data['chance_count'],1);

                    }else{
                        showpop(data.data['bingo_num'],url,data.data['chance_count'],3);
                    }

                }else if(data.status == 201){
                    showpop(data.data['bingo_num'],url,data.data['chance_count'],2);

                }else{
                    showpop(0,url,0,4);

                }

            }
        })


    })


    function showpop(a,b,c,e) {
        $(".mask").show();
        $(".dial-pop").show().addClass("active");
        if (e == 1) {
            $(".dial-poptxt").html('<h3>恭喜，棒棒棒哒</h3>' + '<p>答对了<i>“' + a + '”</i>道题目 <br />' + '点击下方按钮参与抽奖</p>');
            $("[data-a-link='a']").removeAttr("href").attr("href",b)
        }
        if (e == 2) {
            $(".dial-poptxt").html('<h3>很遗憾！答对的题数不够</h3>' + '<p>你还有<i>“' + c + '”</i>次机会！</p>');
            $("[data-a-link='a']").removeAttr("href").attr("href",b)
        }
        if (e == 3) {
            $(".dial-poptxt").html('<h3>恭喜，棒棒棒哒</h3>' + '<p>答对了<i>“' + a + '”</i>道题目 <br />' + '你还有<i>“' + c + '”</i>次机会！</p>');
            $("[data-a-link='a']").removeAttr("href").attr("href",b)
        }
        if (e == 4) {
            $(".dial-poptxt").html('<h3>很遗憾！你没有机会了</h3>' + '<p>明天再来答题吧</p>');
            $("[data-a-link='a']").removeAttr("href").attr("href",b)
        }
        if (e == 5) {
            $(".dial-poptxt").html('<h3>@__@</h3>' + '<p>' + b + '</p>')
        }
    }
</script>

<!--微信分享-->
<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info)); ?>

<!--微信分享-->

</body>
</html>


