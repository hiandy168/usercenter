<script type="text/javascript">
    openid = "<?php echo $param['openid']?>";
    id = "<?php echo $id?>";
    pid = "<?php echo $pid?>";
    //	backUrl = "<?php echo $param['backUrl']?>";
    mid = "<?php echo $param['mid'] ?>";
    table = "vote";


</script>
<script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js?v=164654313"></script>


<?php
$res= Activity_vote::model()->find("id=:id",array(':id'=>$id));
?>
<div class="vote-foot clearfix <?php if($res['isshow']!= 1){
    echo "vote-foot-havebb";
} ?>" >

    <ul>
        <li>
            <span <?php if($active==1){?>class="active"<?php }?>>
                <a href="<?php echo $this->createUrl('/activity/vote/view',array('id'=>$id))?>">
                    <i class="vote-icon vote-icon1"></i>
                    <em>投票首页</em>
                </a>
            </span>

            <span <?php if($active==2){?>class="active"<?php }?>>
                <a href="<?php echo $this->createUrl('/activity/vote/introduce',array('id'=>$id,'pid'=>$pid))?>">
                    <i class="vote-icon vote-icon2"></i>
                    <em>活动说明</em>
                </a>
            </span>
        </li>

        <?php
        $re= Activity_vote_join::model()->find("mid=:mid AND status=:status",array(':mid'=>$this->member['id'],':status'=>1));

        if($res['isshow']==1){
        if($re){
        ?>
            <div class="bg4 pos-a bsd1 vote-bm-btn">
                <a href="<?php echo $this->createUrl('/activity/vote/participate',array('id'=>$id,'pid'=>$pid,'joinid'=>$re['id']))?>">
                    <i class="vote-icon5"></i>
                    <em>我要报名</em>
                </a>
            </div>
        <?php }else{?>

            <div class="bg4 pos-a bsd1 vote-bm-btn">
                <a href="<?php echo $this->createUrl('/activity/vote/participate',array('id'=>$id,'pid'=>$pid))?>">
                    <i class="vote-icon5"></i>
                    <em>我要报名</em>
                </a>
            </div>

        <?php }}?>
        <li>
                <span <?php if($active==4){?>class="active"<?php }?>>
                    <a href="<?php echo $this->createUrl('/activity/vote/ranking',array('id'=>$id,'pid'=>$pid))?>">
                        <i class="vote-icon vote-icon4"></i>
                        <em>投票排名</em>
                    </a>
                </span>
                <span <?php if($active==3){?>class="active"<?php }?>>
                    <a href="<?php echo $this->createUrl('/activity/vote/myvote',array('id'=>$id,'pid'=>$pid))?>">
                        <i class="vote-icon vote-icon3"></i>
                        <em>我的投票</em>
                    </a>
                </span>
        </li>
    </ul>

</div>
<script type="application/javascript">
    <?php if(!$param['mid']){?>
        showlogin();
    <?php } ?>
</script>