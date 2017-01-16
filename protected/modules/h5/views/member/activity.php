<?php echo $this->renderpartial('/common/header1',$config); ?>

<div class="div-main">

    <div class="user-jf-nav clearfix user-tips-navc">
        <ul>
            <li class="selected" id="list">
                <a href="javascript:;" >
                    <p><?php echo count($recommend)?></p>
                    <p>活动汇</p>
                </a>
            </li>
            <li id="join">
                <a href="javascript:;" >
                    <p><?php echo count($activity)?></p>
                    <p>有我参与</p>
                </a>
            </li>
        </ul>
    </div>

<!--我的参加的活动   ---------------start-------------------------------------------------------->
    <div class="user-act-list" id="myactivity">

        <ul>
            <?php if(!empty($activity)){
            foreach ($activity as $key=>$list){
                ?>
            <li>
                <a href="javascript:;" onclick="clickpv(<?php echo $list['aid']?>,'<?php echo $list['url']?>')">
                    <div class="user-act-listdiv">

                        <div class="user-act-listdiv1 user-act-listdiv1c1">
                            <?php if($list['img']){?>
                                <img src="<?php echo JkCms::show_img($list['img'])?>" width="100%" />
                            <?php }else{ ?>
                                <img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/test1.jpg" width="100%" />

                            <?php }?>                            <i></i>
	    	    			<span>
	    	    				<font>点击查看</font>
	    	    				<p><?php echo date("Y-m-d",$list['start_time']);?>至<?php echo date("Y-m-d",$list['end_time']);?><br/><?php echo $project->name?></p>
	    	    			</span>
                        </div>

                        <div class="user-act-listdiv2">
                            <p><?php echo $list['title'];?></p>
                           <!-- <i class="icon-num1"><?php /* echo $list['uv']?$list['uv']:0;*/?></i>-->
                            <i class="icon-num2" style=" right: 1rem;"><?php  echo $list['pv']?$list['pv']:0;?></i>
                        </div>


                    </div>
                </a>
            </li>
            <?php }}else{ ?>
                <div class="nodata-div">
                    <span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-hd.png"/></span>
                    <p>您还没有参加过活动</p>
                </div>
            <?php }?>

        </ul>

    </div>

<!--------------------------------------------------end-------------------------------------------------------------->

    <!---------------------------------------活动汇 start--------------------------------------->
    <div class="user-act-list" id="activitylist" style="display: none">

        <ul>
            <?php if(!empty($recommend) && is_array($recommend)){
                foreach ($recommend as $list){ ?>
                    <li>
                        <a href="javascript:;" onclick="clickpv(<?php echo $list['aid']?>,'<?php echo $list['url']?>')">
                            <div class="user-act-listdiv">

                                <div class="user-act-listdiv1 user-act-listdiv1c1">
                                    <?php if($list['image']){?>
                                    <img src="<?php echo JkCms::show_img($list['image'])?>" width="100%" />
                                    <?php }else{ ?>
                                     <img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/test1.jpg" width="100%" />

                                    <?php }?>
                                    <i></i>
	    	    			<span>
	    	    				<font>点击参加</font>
	    	    				<p><?php echo date("Y-m-d",$list['start_time']);?>至<?php echo date("Y-m-d",$list['end_time']);?><br/><?php echo $project->name?></p>
	    	    			</span>
                                </div>
                                <div class="user-act-listdiv2">
                                    <p><?php echo $list['title'];?></p>
                                    <!--<i class="icon-num1"><?php /* echo $list['uv']?$list['uv']:0;*/?></i>-->
                                    <i class="icon-num2" style=" right: 1rem;"><?php  echo $list['pv']?$list['pv']:0;?></i>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php }}else{ ?>
                <div class="nodata-div">
                    <span><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/nodata-img-hd.png"/></span>
                    <p>暂时还没有活动</p>
                </div>
            <?php }?>
        </ul>

    </div>
<!--------------------------------------end-------------------------------------------->

    <!--<div class="user-act-fixnav">
        <ul>
            <li><i><img src="images/user-icon-img11.png"/></i></li>
            <li><i><img src="images/user-icon-img10.png"/></i></li>
        </ul>
    </div>-->


</div>



</body>
</html>
<script>
    $("#join").click(function(){
        $("#myactivity").show();
        $("#activitylist").hide();
        $(this).removeClass("selected");
        $("#list").addClass("selected");
    })
    $("#list").click(function(){
        $("#myactivity").hide();
        $("#activitylist").show();
        $(this).removeClass("selected");
        $("#join").addClass("selected");
    })

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
