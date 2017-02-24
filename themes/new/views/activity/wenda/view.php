<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <title>答题</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/css/style.css"/>


</head>

<body>

<div id="loaddiv" class="loading-div">
		<span>
			<img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/loading.gif"/>
			<i>努力加载中...</i>
		</span>
</div>
<div class="div-main">


    <div class=""><img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/dati-img2.jpg" width="100%"/></div>
    <div class="pos-r" style="overflow: hidden;"><img src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/images/dati-img3.jpg" width="100%"/>
        <form action="" method="post" style="position: absolute;width: 100%;top: 0;">
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
<!--                                <li>-->
<!--                                    <input id="q1_2" type="radio" name="r-group-1">-->
<!--                                    <label for="q1_2">坑定是</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q1_3" type="radio" name="r-group-1">-->
<!--                                    <label for="q1_3">绝对是</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q1_4" type="radio" name="r-group-1">-->
<!--                                    <label for="q1_4">就是</label>-->
<!--                                </li>-->

                            </ul>
                            <div class="card_bottom"><?php if ($q_val['sort']>1){ ?><a class="prev">上一题</a><?php } ?><span><b><?php echo $q_val['sort'];?></b>/<?php echo $q_val['count'];?></span></div>
                        </div>
                    </div>
                    <?php }}?>
                    <!--Q2-->
<!--                    <div class="card_cont card2" >-->
<!--                        <div class="card">-->
<!--                            <p class="question"><span>Q2、</span>主管是SB么？</p>-->
<!--                            <ul class="select" data-select="select">-->
<!--                                <li>-->
<!--                                    <input id="q2_1" type="radio" name="r-group-2" >-->
<!--                                    <label for="q2_1">是智障</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q2_2" type="radio" name="r-group-2">-->
<!--                                    <label for="q2_2">是大SB</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q2_3" type="radio" name="r-group-2">-->
<!--                                    <label for="q2_3">脑子进水了</label>-->
<!--                                </li>-->
<!---->
<!--                            </ul>-->
<!--                            <div class="card_bottom"><a class="prev">上一题</a><span><b>2</b>/3</span></div>-->
<!--                        </div>-->
<!--                    </div>-->
                   <!--Q3-->
<!--                    <div class="card_cont card3">-->
<!--                        <div class="card">-->
<!--                            <p class="question"><span>Q3、</span>主管是SB么？</p>-->
<!--                            <ul class="select" data-select="select">-->
<!--                                <li>-->
<!--                                    <input id="q3_1" type="radio" name="r-group-3" >-->
<!--                                    <label for="q3_1">是智障</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q3_2" type="radio" name="r-group-3">-->
<!--                                    <label for="q3_2">是大SB</label>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <input id="q3_3" type="radio" name="r-group-3">-->
<!--                                    <label for="q3_3">脑子进水了</label>-->
<!--                                </li>-->
<!---->
<!--                            </ul>-->
<!--                            <div class="card_bottom"><a class="prev">上一题</a><span><b>3</b>/3</span></div>-->
<!--                        </div>-->
<!--                    </div>-->




                </div><!--/card_wrap-->

            </div>


            <div class="dati-submit pos-r">
                <input type="button"  id="subbtn" value="提交答题"/>
            </div>
        </form>

        <div class="deggs-rule" style=" margin-top: -40px;">
            <h3>活动规则</h3>
	    		<span>
	    			2015.07.02 - 2015.07.30
	    		</span>
        </div>

        <div class="deggs-rule">
            <h3>参与对象</h3>
	    		<span>
	    			仅限上海、北京、武汉、广州地区的用户参与。
	    		</span>
        </div>

        <div class="deggs-rule">
            <h3>参与方法</h3>
	    		<span>
	    			活动期间，同一用户每天可参与一次抽
奖的机会，过时作废。
	    		</span>
        </div>


    </div>

</div>

<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/zepto.js"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/answer.js"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/touch.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_theme_url; ?>assets/subassembly/wenda/js/layout.js" type="text/javascript" charset="utf-8"></script>
<script>
    Zepto(function(){
        Zepto("#answer").answerSheet({});
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

            }
        })


    })



</script>

</div>

</body>
</html>


}