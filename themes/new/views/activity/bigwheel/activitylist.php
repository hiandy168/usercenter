<?php
$tab = $tag;
switch ($tab){
    case 'user':
        echo $this->renderpartial('/common/activity_userlist');
        break;
    case 'pvuv':
        echo $this->renderpartial('/common/activity_pvuvlist',array('aid'=>$aid,'pvuv'=>$pvuv));
        break;
}
?>