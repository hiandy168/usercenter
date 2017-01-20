<!-- 组件 start -->
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

<div class="ad-act-kind bxbg">

    <div class="ad-act-nav ">
        <ul>
            <?php   $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
            foreach ($activity_class as $val){
                $sql = "SELECT * FROM dym_activity WHERE cid=".$val['id'];
                $res=Mod::app()->db->createCommand($sql)->queryAll();
                $temp = array();
                $active_arr = array();
                if(count($res) >0 ) {
                    foreach ($res as $vals) {
                        $sqld = "SELECT * FROM dym_activity where id =" . $vals['id'];
                        $res_check = Mod::app()->db->createCommand($sqld)->queryRow();
                        if ($res_check['activity_name'] == '刮刮乐') {
                            $active_arr[] = 1;
                        } else if ($res_check['activity_name'] == '大转盘') {
                            $active_arr[] = 6;
                        } else if ($res_check['activity_name'] == '报名') {
                            $active_arr[] = 3;
                        } else if ($res_check['activity_name'] == '签到') {
                            $active_arr[] = 2;
                        } else if ($res_check['activity_name'] == '海报') {
                            $active_arr[] = 4;
                        } else if ($res_check['activity_name'] == '投票&报名') {
                            $active_arr[] = 5;
                        }else if ($res_check['activity_name'] == '一元购') {
                            $active_arr[] = 8;
                        }
                        $temp[] = $res_check;
                    }
                }
//                $temp = array();
//                $active_arr = array();
//                if($res['id'] ) {
//                    $resid = explode(",", $res['activity_id']);
//                    foreach ($resid as $vals) {
//                        $sqld = "SELECT * FROM dym_activity where id =".$vals;
//                        $res_check = Mod::app()->db->createCommand($sqld)->queryRow();
//                        if($res_check['activity_name']=='刮刮乐'){
//                            $active_arr[]=1;
//                        }else if($res_check['activity_name']=='大转盘'){
//                            $active_arr[]=6;
//                        }else if($res_check['activity_name']=='报名'){
//                            $active_arr[]=3;
//                        }else if($res_check['activity_name']=='签到'){
//                            $active_arr[]=2;
//                        }else if($res_check['activity_name']=='海报'){
//                            $active_arr[]=4;
//                        }else if($res_check['activity_name']=='投票'){
//                            $active_arr[]=5;
//                        }
//                        $temp[] = $res_check;
//                    }
//                }


                ?>
                <li <?php if(in_array($active,$active_arr)){echo 'class="selected"';}?>><b><?php echo $val['class_name'];?></b></li>
            <?php } ?>

        </ul>
    </div>

    <div class="ad-act-con">
        <?php   $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
        foreach ($activity_class as $val){
            $sql = "SELECT * FROM dym_activity WHERE cid=".$val['id'];
            $res=Mod::app()->db->createCommand($sql)->queryAll();
            $active_arr = array();
            $temp=array();
            if(count($res) >0 ) {
                foreach ($res as $vals) {
                    $sqld = "SELECT * FROM dym_activity where id =" . $vals['id'];
                    $res_check = Mod::app()->db->createCommand($sqld)->queryRow();
                    if($res_check['activity_name']=='刮刮乐'){
                        $active_arr[]=1;
                        $res_check['active']=1;
                    }else if($res_check['activity_name']=='大转盘'){
                        $active_arr[]=6;
                        $res_check['active']=6;
                    }else if($res_check['activity_name']=='报名'){
                        $active_arr[]=3;
                        $res_check['active']=3;
                    }else if($res_check['activity_name']=='签到'){
                        $active_arr[]=2;
                        $res_check['active']=2;
                    }else if($res_check['activity_name']=='海报'){
                        $active_arr[]=4;
                        $res_check['active']=4;
                    }else if($res_check['activity_name']=='投票&报名'){
                        $active_arr[]=5;
                        $res_check['active']=5;
                    }
                    else if($res_check['activity_name']=='一元购'){
                        $active_arr[]=8;
                        $res_check['active']=8;
                    }
                    $temp[]=$res_check;
                }
            }
//        foreach ($activity_class as $val){
//            $sql = "SELECT activity_id FROM dym_activity_relation WHERE cid=".$val['id'];
//            $res=Mod::app()->db->createCommand($sql)->queryRow();
//            $temp = array();
//            $active_arr = array();
//            if($res['activity_id'] ) {
//                $resid = explode(",", $res['activity_id']);
//                foreach ($resid as $vals) {
//                    $sqld = "SELECT * FROM dym_activity where id =".$vals;
//                    $res_check = Mod::app()->db->createCommand($sqld)->queryRow();
//                    if($res_check['activity_name']=='刮刮乐'){
//                        $active_arr[]=1;
//                        $res_check['active']=1;
//                    }else if($res_check['activity_name']=='大转盘'){
//                        $active_arr[]=6;
//                        $res_check['active']=6;
//                    }else if($res_check['activity_name']=='报名'){
//                        $active_arr[]=3;
//                        $res_check['active']=3;
//                    }else if($res_check['activity_name']=='签到'){
//                        $active_arr[]=2;
//                        $res_check['active']=2;
//                    }else if($res_check['activity_name']=='海报'){
//                        $active_arr[]=4;
//                        $res_check['active']=4;
//                    }else if($res_check['activity_name']=='投票'){
//                        $active_arr[]=5;
//                        $res_check['active']=5;
//                    }
//                    $temp[] = $res_check;
//                }
//            }


            ?>

            <div class="ad-act-con-d"  <?php if(in_array($active,$active_arr)){echo 'style="display: block;"';}?>>

                <div class="ad-act-con-d1">

                    <a class="lbtn" onclick="prevBtn(this)"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-act-lefticon.png"/></a>

                    <a class="rbtn" onclick="nextBtn(this)"><img src="<?php echo $this->_theme_url; ?>assets/images/ad-act-righticon.png"/></a>

                    <div class="ad-act-con-d2 clearfix">
                        <ul>
                            <?php  if($temp){foreach ($temp as $val){ ?>
                            <li <?php if($active==$val['active']){echo 'class="selected"';}?> >
                                <?php if(status($val['activity_name'],$pid)){
                                if($val['activity_name']=='刮刮乐'){?>
                                <a href="<?php echo $this->createUrl('/activity/scratchcard/list',array('pid'=>$pid,'active'=>1));?>">
                                    <?php }else if($val['activity_name']=='大转盘'){?>
                                    <a href="<?php echo $this->createUrl('/activity/bigwheel/list', array('pid' => $pid, 'active' => 6)); ?>">
                                     <?php }else if ($val['activity_name'] == '报名'){ ?>
                                     <a href="<?php echo $this->createUrl('/activity/signup/list', array('pid' => $pid, 'active' => 3)); ?>">
                                     <?php }else if ($val['activity_name'] == '签到'){ ?>
                                     <a href="<?php echo $this->createUrl('/activity/pccheckin/list', array('pid' => $pid, 'active' => 2)); ?>">
                                     <?php }else if ($val['activity_name'] == '海报'){ ?>
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
                                    <img src="<?php  echo $this->_theme_url.$val['activity_nouse_img'];  ?>">
                                    <?php }else{ ?>
                                    <img src="<?php if(status($val['activity_name'],$pid)){ echo $this->_theme_url.$val['activity_img'];}else{ echo $this->_theme_url.$val['activity_nouse_img']; } ?>">
                                    <?php } ?>
                                    <p><?php echo $val['activity_name'];?></p>
                                </a>
                            </li>
                            <?php }}?>

                        </ul>
                    </div>
                </div>

            </div>
        <?php } ?>



        <!-- 4 end -->



    </div>

</div>


<?php echo $this->renderpartial('/common/right_menu',array('id'=>$pid)); ?>


    
            