<?php
$tab = $tag;
switch ($tab){
    case 'user':
        echo $this->renderpartial('/common/activity_userlist',array('aid'=>$aid,'userdata'=>$userdata,'time'=>$time));
        break;
    case 'pvuv':
        echo $this->renderpartial('/common/activity_pvuvlist',array('aid'=>$aid,'pvuv'=>$pvuv,'time'=>$time));
        break;
}
?>