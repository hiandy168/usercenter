<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php echo $this->renderpartial('/common/right_menu',array('id'=>$pid)); ?>

<?php
function   status($activity_name,$pid){
    $sql_activity = "select * from dym_activity where status=1 and activity_name='".$activity_name."'";
    $sql = "SELECT a.status FROM dym_activity_project_relation a, dym_activity b WHERE a.activity_id=b.id  and b.activity_name='".$activity_name."' and a.pid=".$pid;
    $res=Mod::app()->db->createCommand($sql)->queryRow();
    $activity=Mod::app()->db->createCommand($sql_activity)->queryRow();
    if($activity) {
        if ($res) {
            if ($res['status'] == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }else{
        return false;
    }
}
?>


<div class="ad-act-all   clearfix " >

    <?php   $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
    foreach ($activity_class as $val){
        $sql = "SELECT * FROM dym_activity WHERE cid=".$val['id'];
        $temp=Mod::app()->db->createCommand($sql)->queryAll();
//            $temp = array();
//            if($res['activity_id'] ) {
//                 $resid = explode(",", $res['activity_id']);
//                 foreach ($resid as $vals) {
//                     $sqld = "SELECT * FROM dym_activity where id =".$vals;
//                     $res_check = Mod::app()->db->createCommand($sqld)->queryRow();
//                     $temp[] = $res_check;
//                 }
//             }

        ?>
        <div class="ad-app-list-tit clearfix" style='margin-top:10px;margin-right:0;border-top: 1px solid #E6E6E6;padding: 0;overflow: inherit;'>
            
            <div class="clearfix ad-alltit" style='margin:0;background:#ffffff'>
            <div class="fl ad-alltit-left" style='margin:-5px 0 0 20px;height:30px;line-height:30px;'>
                <i><img src="<?php echo $this->_theme_url.$val['class_logo']; ?>"/></i>
                <span style='font-size:14px;height:28px;line-height:28px;'><?php echo $val['class_name'];?></span>
            </div>
 
        </div>
        </div>
        <div class="ad-act-all-list clearfix bxbg" style='margin:0 auto;text-align:center; box-shadow: none;    margin-bottom: 30px;'>
            <ul  class='clearfix w1000 ' style="margin:0 auto;text-align:left">
                <?php  if($temp){foreach ($temp as $val){ ?>
                    <li  style='margin-bottom: 20px;float:none;display:inline-block;border:0' <?php if(!status($val['activity_name'],$pid) || $val['activity_name']=='众筹' || $val['activity_name']=='零元购' ){ echo 'class="unable" onclick="layer.msg(\'活动未启用\')" ';}?>>
                        <?php if(status($val['activity_name'],$pid)){
                        if($val['activity_name']=='刮刮乐'){?>
                        <a href="<?php echo $this->createUrl('/activity/scratchcard/list',array('pid'=>$pid,'active'=>1));?>">
                            <?php }else if($val['activity_name']=='大转盘'){?>
                            <a href="<?php echo $this->createUrl('/activity/bigwheel/list',array('pid'=>$pid,'active'=>6));?>">
                                <?php }else if($val['activity_name']=='报名'){?>
                                <a href="<?php echo $this->createUrl('/activity/signup/list',array('pid'=>$pid,'active'=>3));?>">
                                    <?php }else if($val['activity_name']=='签到'){?>
                                    <a href="<?php echo $this->createUrl('/activity/pccheckin/list',array('pid'=>$pid,'active'=>2));?>">
                                        <?php }else if($val['activity_name']=='海报'){?>
                                        <a href="<?php echo $this->createUrl('/activity/poster/list',array('pid'=>$pid,'active'=>4));?>">
                                            <?php }else if($val['activity_name']=='投票&报名'){?>
                                            <a href="<?php echo $this->createUrl('/activity/vote/list',array('pid'=>$pid,'active'=>5));?>">
                                                <?php }else if($val['activity_name']=='众筹'){?>
                                                <a href="#">
                                                    <?php }else if($val['activity_name']=='一元购'){?>
                                                    <a href="<?php echo $this->createUrl('/activity/duobao/list',array('pid'=>$pid,'active'=>8));?>">
                                                        <?php }else if($val['activity_name']=='零元购'){?>
                                                        <a href="#">
                                                            <?php }
                                                            }else{?>
                                                            <a href="#">
                                                                <?php }?>
                                                                <?php if($val['activity_name']=='众筹' || $val['activity_name']=='零元购'){?>
                                                                <span><img  style='width:50px;height:50px;' src="<?php echo $this->_theme_url.$val['activity_nouse_img']; ?>"></span>
                                                                <?php }else{ ?>
                                                                <span><img  style='width:50px;height:50px;' src="<?php if(status($val['activity_name'],$pid)){ echo $this->_theme_url.$val['activity_img'];}else{ echo $this->_theme_url.$val['activity_nouse_img']; } ?>"></span>
                                                                <?php } ?>
                                                                <i style='margin-top:8px'><?php echo $val['activity_name'];?></i>
                                                            </a>
                    </li>
                <?php }
                } ?>
            </ul>
        </div>
    <?php } ?>




</div>



<?php echo $this->renderpartial('/common/footer', $config); ?>
