<?php
$tab = $tag;
switch ($tab){
    case 'user':
        echo $this->renderpartial('/common/main-con-user',array('config'=>$config,'user'=>$user,'project_list'=>$project_list,"view"=>$view,"pid"=>$pid,'activity'=>$activity));
        break;
    case 'pvuv':
        echo $this->renderpartial('/common/activity_pvuvlist');
        break;
}
?>