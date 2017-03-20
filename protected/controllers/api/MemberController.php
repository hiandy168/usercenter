<?php

class MemberController extends FrontController {
        
    public function Init(){
        parent::init();
    }
    
    /*
    * 自动登录地址
    */
    public function actionAutoLogin(){
       $openid =  Tool::getValidParam('openid', 'string');
       $redirect =  Tool::getValidParam('redirect', 'string');
       $appid =  Tool::getValidParam('appid', 'string');
       $sign =  Tool::getValidParam('sign', 'string');
       $timestamp =  Tool::getValidParam('timestamp', 'string');
       $headimg =  urldecode(Tool::getValidParam('avatar', 'string'));  //微信头像


       // $a=array( "openid"=>$openid,"appid"=>$appid,"timestamp"=>$timestamp,'redirect'=>urlencode($redirect));
      // var_dump($a);exit;
        //1 根据APPID查project表
        $projectinfo=Project::model()->findByAttributes(array('appid'=>$appid));

        $appsecret=$projectinfo->appsecret;

        //签名参数
        $params=array("openid"=>$openid,"appid"=>$appid,"appsecret"=>$appsecret,"timestamp"=>$timestamp,'redirect'=>$redirect);
        // $newsign = Tool::sign($params);
        // echo $sign;
        // echo '<br>';
        // echo $newsign;
        // echo '<br>';
        // echo $redirect;die;

        $params['sign'] = $sign;

        // echo "sign1: ".md5($sign)."<br>sign2: <br>";
        $res  = Tool::signVerify($projectinfo->appsecret,$params);

        //验证$sgin失效验证
        if(!$res){
            //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40005;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);

            echo urldecode(json_encode($returnCode));exit;
        }
         //根据timestamp验证$sgin  5分钟失效验证
        if($timestamp/1000 +300 < time()){
             //验证失败
            //验证$sgin合法性
            $returnCode['code'] = 40006;
            $returnCode['mess'] = urlencode($this->error_code[$returnCode['code']]);

            echo urldecode(json_encode($returnCode));exit;
            
        }


       //根据openid 和appid判断用户
        $Member_projectinfo=Member_project::model()->findByAttributes(array('pid'=>$projectinfo->id,'openid'=>$openid));

       if(empty($Member_projectinfo)){//新用户
       //帮他做注册  设置未激活status=0
           $member_model = new Member();
           $member_model->name ='匿名用户'.date('MDHi',time());
           $member_model->regtime = time();
           $member_model->regip = Mod::app()->request->userHostAddress;
           $member_model->status = 0;
           $member_model->headimgurl = $headimg;
           $member_model->save();
           $member_id= Mod::app()->db->getLastInsertID();
           $member_info= $member_model->attributes;
           $member_info['id'] = Mod::app()->db->getLastInsertID();

           //绑定mid,openid,pid
           $member_project_model = new Member_project();
           $member_project_model->mid = $member_id;
           $member_project_model->pid = $projectinfo->id;
           $member_project_model->openid = $openid;
           $member_project_model->status = 1;
           $member_project_model->createtime = time();
           $member_project_model->save();
           $status = 0;

           //注册的行为
           $this->regbehavior($member_model->id, $projectinfo->id);

       }else{
           $member_model=Member::model()->findByPk($Member_projectinfo->mid);
           $member_info= $member_model->attributes;
           Member::model()->updateAll(array('headimgurl' =>$headimg ), 'id =' . $Member_projectinfo->mid);
           //插入行为表(注册得积分)
            $win = 0;
            $name = "";
            if(date("Y-m-d",$member_model->attributes['lastlogintime']) != date("Y-m-d",time()) ){
                $res=Behavior::behavior_points(2,$member_model->id,$projectinfo->id,$name,$win,0,'null');
                if($res['code']==200) {
                    $jifen = array(
                        'pid' => $projectinfo->id,
                        'mid' => $member_model->id,
                        'qty' => $res['points'],
                        'type' => 1,
                        'createtime' => time(),
                        'content' => '登录',
                    );
                    $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);

                    $sql = " UPDATE {{member}} SET lastlogintime = ".time()." WHERE id = ".$member_model->id;

                    $res = Mod::app()->db->createCommand($sql)->execute();

                }
            }

           $status = $member_model->status;
       }

       // session 存储用户

        Mod::app()->session['member'] = $member_info;

      // session 存储用户房钱关联的项目
        $member_project = array();
        $member_project['openid'] = $openid;
        $member_project['pid'] = $projectinfo->id;
        $member_project['mid'] = $member_info['id'];
        Mod::app()->session['member_project'] = $member_project;

       $this->redirect(urldecode($redirect));
    }
    
    
    /**
     * 检查openid和pid的绑定关系,是否有手机号
     * 
     * @return  有绑定返回手机号,没有绑定返回0
     */
   public function actionCheckPhoneBind(){
       $openid = Tool::getValidParam('openid','string');
       $access_token = Tool::getValidParam('access_token','string');
       $project_info = Jkcms::getProjectByAccesstoken($access_token);

       //验证appid,appsecret是否合法
       if($project_info){   
            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid));
            if($member_project_info){
                $member_info = Member::model()->findByPk($member_project_info->mid);               
                if($member_info){
                    $returnCode['result'] = true;
                    $returnCode['code'] = 200;
                    $returnCode['phone'] = $member_info->phone;
                    $returnCode['member_info'] = $member_info->attributes;
                    $returnCode['mess'] = '手机号已绑定';                 
                     //感觉这个位置是可以设置其为登录状态的   如果有绑定 autologin(); author wenlijiang
                    Mod::app()->session['member'] = $member_info;  
                    echo json_encode($returnCode);exit;
                }
            }else{
                    $returnCode['result'] = false;
                    $returnCode['code'] = 101009;
                    $returnCode['mess'] = $this->error_code[$returnCode['code']];
                    echo json_encode($returnCode);exit;
            }
       } else{
            $returnCode['result'] = false;
            $returnCode['code'] = 40002;
            $returnCode['mess'] = $this->error_code[$returnCode['code']];
            echo json_encode($returnCode);exit;
       }
       
   }
  
    /**
     * 
     * @param string $phone 手机号
     * @param string $ver  发送给手机的验证码
     * @param string $pass 登录密码,可以接受为空
     * @return 成功1,失败0
     */
//   public function actionReg(){     
//        $openid = Tool::getValidParam('openid','string');
//        if(!$openid){
//            $returnCode['result'] = false;
//            $returnCode['code'] = 101006;
//            $returnCode['mess'] = $this->error_code[$returnCode['101006']];
//            echo json_encode($returnCode);exit;
//        }
//        
//        $phone = trim(Tool::getValidParam('phone','string'));
//        $pass = trim(Tool::getValidParam('pass','string'));
//        $jsonp = trim(Tool::getValidParam('jsonp','string'));
//        $ver =  Tool::getValidParam('ver','string');
//        $ip =  Tool::getValidParam('ip','string');
//        
//        $returnCode = array('result'=>false,'status'=>0,'message'=>'');  
//        
//        
//        $access_token = Tool::getValidParam('access_token','string');
//        $project_info = Jkcms::getProjectByAccesstoken($access_token);
//       
//
//        if($project_info){
//            //手机短信验证    
//            if(Mod::app()->memcache->get('dachuw'.$phone) == $ver && !$ver){
//                $member_model = new Member;                                            
//                $member_model->name = $member_model->phone = $phone;           
//                if($pass){
//                    //用户密码不为空
//                    $member_model->source = Tool::random_keys(5);//随机生成5位字符串
//                    $member_model->password =  Tool::md5str($pass,$member_model->source);
//                }
//                $member_model->regtime = time();
//                $member_model->status = 1;   
//                
//                $member_info = $member_model->countByAttributes(array('name'=>$phone));
//                    if(!$member_info){
//                         //保存用户并绑定mid,pid,openid
//                         $member_model->save();
//                         $member_project_model = new Member_project();
//                         $member_project_model->mid = $member_model->id;
//                         $member_project_model->pid = $project_info['id'];
//                         $member_project_model->openid = $openid;
//                         $member_project_model->status = 1;
//                         $member_project_model->createtime = time();
//
//                         $member_project_model->save();
//                         $returnCode['result'] = true;
//                         $returnCode['status'] = 1;
//                         $returnCode['message'] = '注册成功'; 
//
//                         //用户行为上报;
//                         Member_behavior::report($member_model->id, $project_info['id'], $openid, 2, $ip);
//
//                    } else {
//                        $returnCode['status'] = 1;
//                        $returnCode['message'] = '用户已存在'; 
//                    }
//                }
//                else{
//                    $returnCode['message'] = '短信验证码错误';
//                }                  
//        }
//        else{
//            $returnCode['message'] = '非法请求';
//        }
//        if ($jsonp) {
//            echo $jsonp.'(' . json_encode($returnCode) . ')';
//        } else {         
//            echo json_encode($returnCode);
//        }
//   }   
   
   
//     /**
//     * 
//     * @param string $phone 手机号
//     * @return 成功1,失败0
//     */
//   public function actionRegn(){     
//        $openid = Tool::getValidParam('openid','string');
//        $phone = trim(Tool::getValidParam('phone','string'));
//        $pass = trim(Tool::getValidParam('pass','string'));
//        $jsonp = trim(Tool::getValidParam('jsonp','string'));
//        $ip =  Tool::getValidParam('ip','string');
//        
//        $returnCode = array('result'=>false,'status'=>0,'message'=>'');
//        if(!preg_match("/^1[34578]{1}\d{9}$/",$phone)){  
//            $returnCode['message'] = '手机号不正确';
//            echo json_encode($returnCode);
//            die();
//        }
//        
//        $access_token = Tool::getValidParam('access_token','string');
//        $project_info = Jkcms::getProjectByAccesstoken($access_token);
//       
//        if($project_info){
//            //手机短信验证    
//                $member_model = new Member;                                            
//                $member_model->name = $member_model->phone = $phone;           
//                if($pass){
//                    //用户密码不为空
//                    $member_model->source = Tool::random_keys(5);//随机生成5位字符串
//                    $member_model->password =  Tool::md5str($pass,$member_model->source);
//                }
//                $member_model->regtime = time();
//                $member_model->status = 1;   
//                
//                $member_info = $member_model->countByAttributes(array('name'=>$phone));
//                    if(!$member_info){
//                         //保存用户并绑定mid,pid,openid
//                         $member_model->save();
//                         $member_project_model = new Member_project();
//                         $member_project_model->mid = $member_model->id;
//                         $member_project_model->pid = $project_info['id'];
//                         $member_project_model->openid = $openid;
//                         $member_project_model->status = 0;
//                         $member_project_model->createtime = time();
//
//                         $member_project_model->save();
//                         $returnCode['result'] = true;
//                         $returnCode['status'] = 1;
//                         $returnCode['message'] = '注册成功'; 
//
//                         //用户行为上报;
//                         Member_behavior::report($member_model->id, $project_info['id'], $openid, 2, $ip);
//
//                    } else {
//                        $returnCode['status'] = 1;
//                        $returnCode['message'] = '用户已存在'; 
//                    }
//                                 
//        }
//        else{
//            $returnCode['message'] = '非法请求';
//        }
//        if ($jsonp) {
//            echo $jsonp.'(' . json_encode($returnCode) . ')';
//        } else {         
//            echo json_encode($returnCode);
//        }
//   }   
   
   
   
   
   
    /**
     * 通过帐号密码登录
     * 
     * @param string openid  第三方项目用户标识
     * @param string $access_token  项目accesstoken
     * 
     */
    public function actionLogin(){
        $openid = Tool::getValidParam('openid','string');
        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);
        //验证appid,appsecret是否合法
        if($project_info){
            $member_project_model = new Member_project();
            $member_project_info = $member_project_model->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid));
            if(!$member_project_info){
                $member_model = new Member();
                $member_model->name ='匿名用户';
                $member_model->regtime = time();
                $member_model->regip = Mod::app()->request->userHostAddress;
                $member_model->status = 0;
                $member_model->save();
                $member_id= Mod::app()->db->getLastInsertID();
                //绑定mid,openid,pid
                $member_project_model->mid = $member_id;
                $member_project_model->pid = $project_info['id'];
                $member_project_model->openid = $openid;
                $member_project_model->status = 1;
                $member_project_model->createtime = time();
                $member_project_model->save();
                Mod::app()->session['member_status']=0;
            }else{
                $member_id= $member_project_info->mid;
                Mod::app()->session['member_status']=1;
            }

            $returnCode['result'] = true;
            $returnCode['status'] = 1;
            $returnCode['message'] = '登录成功';

            //用户行为上报;
            Member_behavior::report($member_id, $project_info['id'], $openid, 1);
            Mod::app()->session['openid']=$openid;
            Mod::app()->session['access_token']=$access_token;
            Mod::app()->session['pid']=$project_info['id'];
            Mod::app()->session['member_id']=$member_id;

            Mod::app()->memcache->set('thisopenid' ,$member_id.'-001');

        }
        else{
            $returnCode['message'] = '非法请求';
        }

        echo json_encode($returnCode);
    }



    /**
     * 商城用户注册
     */
//    public function actionB2cReg(){
//        $name = trim(Tool::getValidParam('name','string'));
//        $pass = trim(Tool::getValidParam('pass','string'));
//        $returnCode = array('result'=>'','status'=>0,'message'=>''); 
//        $member_model = new Member;  
//        $member_info = $member_model->find('name=:name',array(':name'=>$name)); 
// 
//        if(!$member_info && !$member_info->name){   
//            $member_model->name = $name;           
//            $member_model->source = Tool::random_keys(5);//随机生成5位字符串
//            $member_model->password =  Tool::md5str($pass,$member_model->source);             
//            $member_model->regtime = time();
//            $member_model->createtime = time();
//            $member_model->status = 1;   
//
//            if($member_model->save()){
//                 $list = array(
//                    'member_id'=>$member_model->id,
//                    'login_account'=>$member_model->name,
//                    'login_password'=>$member_model->password,
//                    'password_account'=>$member_model->username,
//                    'createtime'=>$member_model->createtime                         
//                 );
//
//                 $returnCode['status'] = 1;
//                 $returnCode['message'] = '注册成功'; 
//                 $returnCode['result'] = $list;
//            }           
//        }
//        else{
//            $returnCode['status'] = -1;
//            $returnCode['message'] = '用户已注册';             
//        }  
//        
//        echo json_encode($returnCode);
//    }
    
    /**
     * 商城用户登录
     */
    public function actionB2cLogin(){
        $name = trim(Tool::getValidParam('name','string'));
        $pass = trim(Tool::getValidParam('pass','string'));

//        $appid = Tool::getValidParam('appid','string');
//        $appsecret = Tool::getValidParam('appsecret','string');
//        $project_info = Project::model()->findByAttributes(array('appid'=>$appid,'appsecret'=>$appsecret));

        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);
        
        $returnCode = array('result'=>'','status'=>0,'message'=>''); 
//                http://m.hb.qq.com/api/member/B2cLogin?name=15997567510&pass=888888      
        $member_info = Member::model()->find('name=:name',array(':name'=>$name));
        $mem = array();
        
        //用户是否存在
        if($member_info && $member_info->name){  
            $result = Tool::md5str($pass,$member_info->source);
            if($result == $member_info->password &&  $member_info->password){
                foreach($member_info as $k=>$val){
                    $mem = $member_info->attributes;
                }
                if($project_info){
                    $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$member_info->id));
                    if(!$member_project_info){
                        $member_project_model = new Member_project();
                        $member_project_model->mid = $member_info->id;
                        $member_project_model->pid = $project_info['id'];
                        $member_project_model->openid = $member_info->id;
                        $member_project_model->createtime = time();
                        //添加一条记录
                        if($member_project_model->save()){
                            $result = TRUE;
                        }

                    }
                }
                $member_info = $member_info->attributes;
                $mem_project=array();
                $mem_project['openid'] = $mem['id'];
                $mem_project['pid'] = $project_info['id']; //积分商城的appid
                $mem_project['mid'] = $mem['id'];


//                Mod::app()->session['member'] = $mem;
//                Mod::app()->session['member_project'] = $mem_project;

                $returnCode['status'] = 1;
                $returnCode['message'] = '登录成功';
                $returnCode['result'] = $mem;
                $returnCode['result_project'] = $mem_project;

            }
            else{
                $returnCode['status'] = 0;
                $returnCode['message'] = '密码错误';                
            }
        }
        else{
             $returnCode['status'] = -1;
             $returnCode['message'] = '用户名错误';
        }      
      
        echo json_encode($returnCode);
    }

    /**
     * 商城用户登录
     */
    public function actionB2cCheckIn(){
        $openid= trim(Tool::getValidParam('openid','string'));
        $mid = trim(Tool::getValidParam('mid','string'));
        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);

        $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid,'mid'=>$mid));
        if(!$member_project_info){
            $member_project_model = new Member_project();
            $member_project_model->mid = $mid;
            $member_project_model->pid = $project_info['id'];
            $member_project_model->openid = $openid;
            $member_project_model->createtime = time();
            //添加一条记录
            if($member_project_model->save()){
                $result = TRUE;
            }

        }
        $result = TRUE;
        return $result;
    }

    
    /**
     * 通过短信验证码登录
     * @param string $phone 手机号
     * @param string $smscode 手机短信码
     * @return json 成功1，失败0
     */
    public function actionLoginByVer(){       
        $openid = Tool::getValidParam('openid','string');

        $phone = trim(Tool::getValidParam('phone','string'));
        $ver = trim(Tool::getValidParam('ver','string'));
        $ip = trim(Tool::getValidParam('ip','string'));
        
        //登录返回提示
        $returnCode = array('status'=>0,'message'=>''); 
        
        $member_info = Member::model()->findByAttributes(array('name'=>$phone));
        
        $access_token = Tool::getValidParam('access_token','string');
        $project_info = Jkcms::getProjectByAccesstoken($access_token);
       
        if($project_info){
            if($phone){
             //验证手机合法性
             $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/'; 
             $match = preg_match($pattern,$phone);
            if($match){
                if($ver){
                    //短信码验证
                    if(Mod::app()->memcache->get('dachuw'.$phone) == $ver){
                        //用户是否存在
                        if(!$member_info){                                     
                            //保存用户
                            $member_model = new Member;                                            
                            $member_model->name = $member_model->phone = $phone;           
                            $member_model->regtime = time();
                            $member_model->status = 1;
                            $member_model->save();
                        }

                        //是否为新用户
                        $mid = $member_model->id?$member_model->id:$member_info->id;

                        $member_project_model = new Member_project();
                        $member_project_info = $member_project_model->findByAttributes(array('mid'=>$mid,'pid'=>$project_info['id'],'openid'=>$openid));
                        if(!$member_project_info){
                            //绑定mid,openid,pid
                            $member_project_model->mid = $member_info->id;
                            $member_project_model->pid = $project_info['id'];
                            $member_project_model->openid = $openid;
                            $member_project_model->status = 1;
                            $member_project_model->createtime = time();
                            $member_project_model->save();
                        } 
                        
                        //用户行为上报;
                        $result = Member_behavior::report($member_info->id, $project_info['id'], $openid, 1, $ip);  
                        
                        $returnCode['status'] = 1;
                        $returnCode['message'] = '登录成功';
                        $returnCode['expire_time'] = date('Y-m-d H:i:s',Mod::app()->memcache->get($phone));
                        
                        //清除短信验证码缓存
                        Mod::app()->memcache->delete('dachuw'.$phone); 
                        Mod::app()->memcache->delete($phone);
                    }
                    else if(Mod::app()->memcache->get($phone) <time()){
                        $returnCode['message'] = '短信验证码已过期';                       
                    }
                    else{
                        $returnCode['message'] = '短信验证码错误';
                    }
                }
                else{
                    $returnCode['message'] = '短信验证码为空';
                }   
            }
            else{
                $returnCode['message'] = '手机格式不正确';
            }         
          }
          else{
              $returnCode['message'] = '手机号为空';
          }
        }
        else{
            $returnCode['message'] = '非法请求';
        }   
        
        echo json_encode($returnCode);
//        print_r($returnCode);
    }    
    
    
    /**
     * 发送验证码
     *
     * @param string $phone 手机号
     * @return 成功1,失败0
     */    
    public function actionSendver(){
        $openid = Tool::getValidParam('openid','string');
        $phone = trim(Tool::getValidParam('phone','string'));
        $jsonp = trim(Tool::getValidParam('jsonp','string'));
        
        $returnCode = array('status'=>'','message'=>''); 
            
        $access_token = Tool::getValidParam('access_token','string');
        
        if(!$access_token){
                $returnCode['status'] = 0;
                $returnCode['message'] = 'access_token为空';
                echo json_encode($returnCode);die;
        }
        
        $project_info = Jkcms::getProjectByAccesstoken($access_token);   
        if($project_info){
            //发送短信验证码
            $auth_code = $this->_sendMessage($phone);
            if($auth_code['status']){
                $returnCode['status'] = 1;
                $returnCode['message'] = '发送短信验证码成功';
            }
            else{
                $returnCode['status'] = 0;
                $returnCode['message'] = '发送短信验证码失败';                
            }
        }
        else{
            $returnCode['status'] = -1;
            $returnCode['message'] = '非法请求';
        }
        if ($jsonp) {
            echo $jsonp.'(' . json_encode($returnCode) . ')';
        } else {         
            echo json_encode($returnCode);
        }
    } 
    
    /**
     * 发送短信验证码
     * @param  string $mobile  手机号
     * @return string $auth_code 短信码
     */
    private function  _sendMessage($mobile){
         $resultCode = array('info'=>'','status'=>'');
         //验证手机合法性
         $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/'; 
         $match = preg_match($pattern,$mobile);         
         if($match){
            $domain = 'http://esf.hb.qq.com';
            $params = '/c=dachu&m=sms';
            $postUrl = $domain.$params;
            $postData = array(
                'auth_code' => '9z!d4vibm$kjc3n',
                'mobile' => $mobile,
                'memPrefix' => 'ucenter_dachuw_binding_sms',
                'userID' => time().mt_rand(10000, 99999),
            );

            $tmpSmsResponseData = Tool::http_post($postUrl,$postData,$domain);
            $returnCode = json_decode($tmpSmsResponseData)->data;
            $auth_code = $returnCode->auth_code;
            $expire = $returnCode->expire;
            
            if($auth_code){
                //短信验证码存入Memcache
                Mod::app()->memcache->set('dachuw'.$mobile,$returnCode->auth_code,$expire);
                //短信验证码过期时间
                Mod::app()->memcache->set($mobile,time()+$expire,0);
                $resultCode['info'] = '发送手机短信码成功';
                $resultCode['status'] = 1; 
            }
            else{
               $resultCode['info'] = '发送手机短信码失败';
               $resultCode['status'] = 0;                
            }
         }
         else{
             $resultCode['info'] = '手机号格式不正确';
             $resultCode['status'] = -1; 
         }
         
        return $resultCode;
    }

    //判断短信码是否正确    
    public function actionAuthCode(){ 
            $auth_code = Tool::getValidParam('param', 'string');
            $mobile = Tool::getValidParam('mobile', 'string');
            
            $result = array('info'=>'','status'=>'');  
            $returnCode = Mod::app()->memcache->get('dachuw'.$mobile);
            if($returnCode && $auth_code==$returnCode){
                $result['info'] = '验证通过！';
                $result['status'] = 1;                  
            }
            else if(Mod::app()->memcache->get($mobile) <time()){
                $result['info'] = '短信验证码已过期！';
                $result['status'] = -1;  
            }
            else{
                $result['info'] = '短信验证码不正确！';
                $result['status'] = 0;                   
            }
            
            echo json_encode($result);
            exit;  
    }       
    
       /**
     * 发送大楚站内用户消息api
     * @param string $title 消息标题
     * @param string $content 消息内容
     * @return json 1:成功 0:失败
     */
    public function actionMessage(){
        

       $openid = trim(Tool::getValidParam('openid', 'integer'));       
       $title = trim(Tool::getValidParam('title', 'string'));      
       $content = trim(Tool::getValidParam('content', 'string'));
       
       $returnCode = array('result'=>'','message'=>''); 
       
       $access_token = Tool::getValidParam('access_token','string');
       $project_info = Jkcms::getProjectByAccesstoken($access_token);  
        
        if($project_info && $openid && $title && $content){
            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid));
            $return = Member_message::snedMessage($project_info['id'], $member_project_info['mid'], $title, $content);
            if($return['result']!=null && $return['status']==1){
                    $returnCode['result'] = TRUE;
                    $returnCode['code'] = 200;
                    $returnCode['mess'] = $this->error_code[$returnCode['200']];
                    echo json_encode($returnCode);exit;
            }else{
                     $returnCode['result'] = FALSE;
                    $returnCode['code'] = 500;
                    $returnCode['mess'] = $this->error_code[$returnCode['500']];
                    echo json_encode($returnCode);exit;  
            }                      
        }
        else{
                    $returnCode['result'] = FALSE;
                    $returnCode['code'] = 500;
                    $returnCode['mess'] = $this->error_code[$returnCode['500']];
                    echo json_encode($returnCode);exit;   
        }
        
        echo json_encode($returnCode);           
    }

    public function  actionMemberinfo(){
        $mid = $this->member['id'];
        if(!$mid)die('非法数据');
        $member = Member::model()->findByAttributes(array('id'=>$mid));
        $returnCode['code'] = 200;
        if($member) {
            $returnCode['member_info']=$member->attributes;
//            foreach ( $member->attributes as $k=>$v){
//                $returnCode['member_info'][$k]=urlencode($v);
//            }

        }else{
            $returnCode['member_info'] = array();

        }
        echo json_encode($returnCode);

    }
    
}
