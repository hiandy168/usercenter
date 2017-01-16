<?php  
   include 'Dachu.php';
   $dachu    = new Dachu('101011','f7d0b291df927f5d');
   $dachu->getAccessToken(); 
   $dachu->openid   = 'testwen';
   $res = $dachu->sendver('15997567510');
   var_dump($res);die;
//   $redirect = $dachu->getMemberUrl();//获取会员中心URL
   $redirect =   'http://m.dachuw.net/activity/scratchcard/view/id/48';
   $url      = $dachu->buildAutoLoginRequest($openid,$redirect);//获取自动登录URL
   $dachu->redirect($url);die;
?>  