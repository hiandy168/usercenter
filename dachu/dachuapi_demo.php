<?php  
   include 'Dachu.php';
   $dachu    = new Dachu('101012','9581ceffr346bc53');
   $dachu->getAccessToken(); 
   
    /*start 发酸短讯验证码  openid 喂项目自身的用户标书*/
   //$res = $dachu->sendver('15997567510');
   /*end 发酸短讯验证码  openid 喂项目自身的用户标书*/  
   
  /*openid 为项目自身的用户标识*/
  //$dachu->openid   = 'testwen';
   




//   $redirect = $dachu->getMemberUrl();//获取会员中心URL

/*获取自动登录URL*/
//   $redirect =   'http://tengchu.comm.dachuw.net/activity/scratchcard/view/id/48';
//   $url      = $dachu->buildAutoLoginRequest($openid,$redirect);//获取自动登录URL
//   $dachu->redirect($url);die;
   
   
   /*开发登陆并回调*/
    $dachu->loginSso();//获取自动登录URL
?>  