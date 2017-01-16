<?php

class MemberController extends FrontController {

    public function init() {
        parent::init();
    }

    public function actionIndex() {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        $this->render('index', $data);
    }
  
    // 用户注册第一步  
    public function actionRegOne() {
        $config['site_title'] = '用户注册第1步';
        $this->render('regone', array('config'=>$config));
    }

    // 用户注册第二步
    public function actionRegTwo(){
        $back_url=strtolower(Mod::app()->request->urlReferrer);
        $app_url=strtolower(Mod::app()->request->getHostInfo().'/member/regone');
        if($back_url!==$app_url){
            $this->redirect('regone');
            exit;
        }

        $config['site_title'] = '用户注册第2步';
        $config['active'] = 'gactive';
        $this->render('regtwo',array('config'=>$config));
    }

    // 用户注册第三步
    public function actionRegThree(){
        $back_url=strtolower(Mod::app()->request->urlReferrer);
        $app_url=strtolower(Mod::app()->request->getHostInfo().'/member/regtwo');
        if($back_url!==$app_url){
            $this->redirect('regone');
            exit;
        }
        $config['site_title'] = '用户注册第3步';
        $this->render('regthree', array('config'=>$config));
    }
 
    /**
     * 用户登录
     */
    public function actionLogin(){
        if($this->member['phone']){
            $this->redirect('/project/appmgt');
        }
        $this->render('login');
    }    
    
    /**
     * 用户注销
     */
    public function actionLoginOut()
    {
        unset(Mod::app()->session['member']);
        Mod::app()->session->clear();
        Mod::app()->session->destroy();
        $this->redirect('/');
    }  
    
    /**
     * 创建应用
     */
    public function actionCreateProject() {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        $this->render('createproject', $data);
    }

    public function actionAttention(){
        if(Mod::app()->request->post()) {
            $data['mid'] = trim(Tool::getValidParam('mid', 'integer'));
            $data['fid'] = trim(Tool::getValidParam('fid', 'integer'));

            if (empty($this->member)) {
                $this->redirect($this->createUrl('/member/login'));
            }

            $model = new Member_attention;
            if ($model->save($data)) {
                $this->redirect($this->_siteUrl);
            }
            else{
                $this->redirect(array('index'));
            }
        }

        $this->render('index');
    }

    public function actionMsg() {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
         $sql = "select t.* from {{message}} as t  where type = 'note' and send_del !=1  and send_id = ".$this->member['id'];

         if(isset($_REQUEST['content'])&& $_REQUEST['content']){
           $sql .= " and content like '%".$_REQUEST['content']."%'";
           $data['s']['content']=$_REQUEST['content'];
        }

        if(isset($_REQUEST['start_time'])&& $_REQUEST['start_time']){
           $sql .= " and createtime >= '".strtotime($_REQUEST['start_time'])."'";
           $data['s']['start_time']=$_REQUEST['start_time'];
        }

        if(isset($_REQUEST['end_time'])&& $_REQUEST['end_time']){
           $sql .= " and createtime <= '".strtotime($_REQUEST['end_time'])."'";
           $data['s']['end_time']=$_REQUEST['end_time'];
        }

        $criteria=new CDbCriteria();
        $result = Mod::app()->db->createCommand($sql)->query();
        $pages=new CPagination($result->rowCount);
        $pages->pageSize=15;
        $pages->applyLimit($criteria);
        $result=Mod::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $data['list']=$result->queryAll();

        $data['pagebar'] = $pages ;

        $this->render('msg', $data);
    }

    public function actionMsg_read() {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
          if (isset($_GET['id']) && intval($_GET['id'])) {
            $article_model = Message::model()->find("id ='" . trim(intval($_GET['id'])) . "' and send_id ='" . $this->member['id'] . "'");
            if(!empty($article_model)){
                     $data['view'] = $article_model->attributes;
            }else{
                 $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }

        $this->render('msg_read', $data);
    }


      function actionSafe_center() {
        if(empty($this->member)){
           $this->redirect($this->createUrl('/member/login'));
        }
        if(!$this->member['is_full']){
            $this->redirect($this->createUrl('/member/registerfull'));
        }
                     $data['config'] = $this->site_config;
        $data['config']['site_title'] = "安全中心-会员中心-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = "会员中心".",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = "会员中心".",".$this->site_config['site_description'] ;

        $data['member'] = Member::model()->findByPk($this->member['id']);

        $this->render('safe',$data);
    }

      function actionSafe_change() {
        if(empty($this->member)){
           $this->redirect($this->createUrl('/member/login'));
        }
        if(!$this->member['is_full']){
            $this->redirect($this->createUrl('/member/registerfull'));
        }
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "安全中心-会员中心-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = "会员中心".",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = "会员中心".",".$this->site_config['site_description'] ;

        $data['member'] = Member::model()->findByPk($this->member['id']);
        $this->render('safe_change',$data);
    }

    public function actionPass() {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        $this->render('pass', $data);
    }

    public function actionEdit_pass() {
        if(empty($this->member)){
           $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        if(Mod::app()->request->isPostRequest){
                $data['oldpasswd'] = trim(Mod::app()->request->getPost('oldpasswd'));
                $data['passwd'] = trim(Mod::app()->request->getPost('passwd'));
                $data['repasswd'] = trim(Mod::app()->request->getPost('repasswd'));
                  //旧密码

                if ($this->member['password'] !== Tool::md5str($data['oldpasswd'],$this->member['source'])){
                   echo json_encode(array('state' => 0, 'mess' => '原始密码错误'));exit;
                }
                 //密码的正确
                if($data['passwd'] != $data['passwd'] ){
                    echo json_encode(array('state' => 0, 'mess' => '两次密码不一致'));exit;
                }

                $this->member['source'] = $data['source'] = Tool::random_keys(5);//随机生成5位字符串
                $data['passwd'] = Tool::md5str($data['passwd'],$data['source']);
                Member::model()->updateByPk($this->member['id'],array('password'=>$data['passwd'],'source'=>$data['source']));
                echo json_encode(array('state' => 1, 'mess' => '修改成功'));exit;
        }

    }


    public function actionRegister() {
        $data['config'] = $this->site_config;
        $this->render('/register', $data);
    }

    public function actionWapAjaxReg(){
        if (Mod::app()->request->isPostRequest) {
            $model = new RegForm();

            $data['id'] = trim(Tool::getValidParam('mid','integer'));
            $data['pid'] = trim(Tool::getValidParam('pid','integer'));
//            exit($data['id']);
            $data['phone'] = $data['name']= trim(Tool::getValidParam('account','string'));
            $data['password'] = trim(Tool::getValidParam('password','string'));
            $re_memberpass = trim(Tool::getValidParam('repassword','string'));
            //$data['group_id'] = trim(Tool::getValidParam('type','integer',1));
            // $model->email = $data['email'] = trim(Mod::app()->request->getPost('email'));
            $verify = strtolower(trim(Tool::getValidParam('verify','string')));
            $agree = trim(Mod::app()->request->getPost('agree'));

            //协议
            if (!$agree) {
                echo json_encode(array('state' => 0, 'message' => '您没有同意本站协议'));
                //print_r(array('state' => 0, 'message' => '您没有同意本站协议'));
                exit;
            }

            //验证码 暂时关闭
//            if ($verify != Mod::app()->session['phone_verify_code']) {
//                echo json_encode(array('state' => 0, 'mess' => '验证码错误'));
//                exit;
//            }

            //验证码
//            if ($verify != Mod::app()->session['member_verify_code']) {
//                echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//                exit;
//            }

            //密码的正确
            if ($data['password'] != $re_memberpass) {
                echo json_encode(array('state' => 0, 'message' => '两次密码不一致'));
                //print_r(array('state' => 0, 'message' => '两次密码不一致'));
                exit;
            }

            //数据不能为空
            if (!$data['name'] || !$data['password']) {
                echo json_encode(array('state' => 0, 'message' => '用户名或者密码不能为空'));
                //print_r(array('state' => 0, 'message' => '用户名或者密码不能为空'));
                exit;
            }

            $res = $model->update_reg_user($data);


            echo json_encode($res);
            //print_r($res);
            exit;
        }
    }

    public function actionWapAjaxLogin()
    {
        $mid = trim(Tool::getValidParam('mid','integer'));
        $pid = trim(Tool::getValidParam('pid','integer'));
        $token = trim(Tool::getValidParam('token','string'));
        $return_url = trim(Tool::getValidParam('return_url','string'));
        $return_url = substr($return_url,strpos($return_url,'/'),strpos($return_url,'?'));
        $return_url = substr($return_url,0,strpos($return_url,'?'));
//        exit($return_url);
        $data['phone'] =  $data['username'] =   trim(Tool::getValidParam('account','string'));

        //密码
        $data['password'] = trim(Tool::getValidParam('password','string'));
        if (!$data['phone'] || !$data['password']) {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码不能为空'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码不能为空'));
            exit;
        }
        $verify = strtolower(trim(Mod::app()->request->getPost('verify')));

        //if ($verify == Mod::app()->session['member_verify_code']) {
        //初始化登陆模型
        $login_model = new Memberloginform();
        //不能直接把数组给attributes  但是可以单独的给key赋值
        foreach($login_model->attributes as $k=>$v){
            isset($data[$k]) && $login_model->$k = $data[$k];
        }

        if ($login_model->validate() && $member = $login_model->login()) {

//                Mod::import('application.vendors.*');
//                include_once dirname(__FILE__) . '/../vendor/ucenter.php';
//                list($uid, $username, $password, $email) = @uc_user_login($data['account'], $data['password']);
            $uid = $member['id'];
            if ($uid > 0) {
                //上报用户行为
                $behavior = new Member_behavior('create');
                $pro = Member_project::model()->findByAttributes(array('mid'=>$mid,'pid'=>$pid));
                $behavior->openid = $pro->openid;
                $behavior->mid = $mid;
                $behavior->pid = $pid;
                $behavior->type = '登陆';
                $behavior->createtime = time();
                $behavior->year = date('Y');
                $behavior->month = date('m');
                $behavior->day = date('d');
                $behavior->save();
//                    $symlogin_html = @uc_user_synlogin($uid);
//                    echo json_encode(array('state' => 1, 'mess' => '登录成功', 'script' => $symlogin_html));
//                    $this->message('成功登陆',$this->_siteUrl,'5',$symlogin_html);  exit;
                if($mid != $member['id']){
                    //删除临时生成的member表记录
                    Member::model()->updateByPk($mid,array('isdel'=>'1'));
                    //更新member_project
                    $pro = Member_project::model()->findByAttributes(array('mid'=>$mid,'pid'=>$pid));
                    Member_project::model()->updateByPk($pro->id,array('mid'=>$member['id']));
                    $return_url = $return_url.'?access_token=' . $token . '&mid=' . $member['id'];
                }
                echo json_encode(array('state' => 1, 'message' => '登录成功','return_url'=>$return_url));
                //print_r(array('state' => 1, 'message' => '登录成功'));
                exit;
            } else if ($uid == -1) {
                echo json_encode(array('state' => 1, 'message' => 'UCenter数据错误'));
                //print_r(array('state' => 1, 'message' => 'UCenter数据错误'));
                exit;
            } else if ($uid == -2) {
                echo json_encode(array('state' => 1, 'message' => 'UCenter密码错'));
                //print_r(array('state' => 1, 'message' => 'UCenter密码错'));
                exit;
            } else {
                echo json_encode(array('state' => 1, 'message' => '未定义'));
                //print_r(array('state' => 1, 'message' => '未定义'));
                exit;
            }
        } else {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码错误'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码错误'));
        }
//        } else {
//            echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//            //print_r(array('state' => 0, 'mess' => '验证码错误'));
//        }
    }


    public function actionAjaxReg() {
        if (Mod::app()->request->isPostRequest) {
            $model = new RegForm();

            $model->username = $data['username']  = $data['account'] = trim(Tool::getValidParam('account','string'));
            $model->password = $data['password'] = trim(Tool::getValidParam('password','string'));
            $model->repassword = $re_memberpass = trim(Tool::getValidParam('repassword','string'));
            $model->group_id = $data['group_id'] = trim(Tool::getValidParam('type','integer',1));
//            $model->email = $data['email'] = trim(Mod::app()->request->getPost('email'));
            $verify = strtolower(trim(Tool::getValidParam('verify','string')));
            $agree = trim(Mod::app()->request->getPost('agree'));

            //协议
            if (!$agree) {
                echo json_encode(array('state' => 0, 'message' => '您没有同意本站协议'));
                //print_r(array('state' => 0, 'message' => '您没有同意本站协议'));
                exit;
            }

            //验证码 暂时关闭
//            if ($verify != Mod::app()->session['phone_verify_code']) {
//                echo json_encode(array('state' => 0, 'mess' => '验证码错误'));
//                exit;
//            }

            //验证码
//            if ($verify != Mod::app()->session['member_verify_code']) {
//                echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//                exit;
//            }

            //密码的正确
            if ($data['password'] != $re_memberpass) {
                echo json_encode(array('state' => 0, 'message' => '两次密码不一致'));
                //print_r(array('state' => 0, 'message' => '两次密码不一致'));
                exit;
            }

            //数据不能为空
            if (!$data['username'] || !$data['password']) {
                echo json_encode(array('state' => 0, 'message' => '用户名或者密码不能为空'));
                //print_r(array('state' => 0, 'message' => '用户名或者密码不能为空'));
                exit;
            }
            //会员类型
//            if ($data['group_id']) {
////                $member_group = Membergroup::model()->findByPk($data['group_id']);
////                if (!$member_group|| empty($member_group)) {
////                    //echo json_encode(array('state' => 0, 'message' => '数据不合法'));
////                    echo print_r(array('state' => 0, 'message' => '数据不合法'));
////                    exit;
////                }
//            } else {
//                //echo json_encode(array('state' => 0, 'message' => '会员类型不能为空'));
//                print_r(array('state' => 0, 'message' => '会员类型不能为空'));
//                exit;
//            }
//                if(!$model->validate()){
//                    $errors = $model->getErrors();
//                    echo json_encode(array('state' => 0, 'message' => ''));exit;
//                }
            $res = $model->reg_user($data);
            echo json_encode($res);
            //print_r($res);
            exit;
        }
    }

    public function actionAjaxRegTwo() {
        if (Mod::app()->request->isPostRequest) {
            $model = Member::model();
//            $membrInfo = $model->findByPk($this->member['mid']);
            $membrInfo['company'] =  trim(Tool::getValidParam('company','string'));
            $membrInfo['com_url'] =  trim(Tool::getValidParam('icon','string'));
            $membrInfo['address'] = trim(Tool::getValidParam('address','string'));
            $membrInfo['username'] = trim(Tool::getValidParam('username','string'));
            $membrInfo['email'] =  trim(Tool::getValidParam('email','string'));
            $membrInfo['tel']  = trim(Tool::getValidParam('tel','string'));
            $membrInfo['type'] = trim(Tool::getValidParam('genre','string'));
            $membrInfo['status'] = 1;
//            var_dump($membrInfo->company);exit;
            //完善信息
            if ($model->updateByPk($this->member['mid'],$membrInfo)) {
                //更新session
                $member= $this->member;
                $member['com_url'] = $membrInfo['com_url'];
                $member['username'] = $membrInfo['username'];
                $member['email'] = $membrInfo['email'];
                $member['tel'] = $membrInfo['tel'];
                $member['company'] = $membrInfo['company'];
                $member['address'] = $membrInfo['address'];
                $member['type'] = $membrInfo['type'];
                $member['status'] = $membrInfo['status'];
                Mod::app()->session['member'] = $member;
                echo json_encode(array('state' => 1, 'message' => '修改成功','login_url'=>'regthree'));
                exit;
            }
            else{
                echo json_encode(array('state' => 0, 'message' => '修改失败'));
                exit;
            }
        }
    }

    public function actionAjaxlogin() {
        //$this_lang = Lang::getLang();
        //登录名
        $data['account'] =  $data['username'] =   trim(Tool::getValidParam('account','string'));
        $return_url= Mod::app()->request->getHostInfo().'/project/appmgt';
        //$return_url = trim(Tool::getValidParam('return_url','string'));
        //密码
        $data['password'] = trim(Tool::getValidParam('password','string'));
        $rember = trim(Tool::getValidParam('rember','string'));
        //记住帐号
        if($rember){
            //首先新建cookie
            $value = $data['account'];
            $cookie = new CHttpCookie('mycookie', $value);
            //定义cookie的有效期
            $cookie->expire = time()+60*60*24*30;  //有限期30天
            //把cookie写入cookies使其生效
            Mod::app()->request->cookies['mycookie']=$cookie;
        }
        if (!$data['account'] || !$data['password']) {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码不能为空'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码不能为空'));
            exit;
        }
        $verify = strtolower(trim(Mod::app()->request->getPost('verify')));

        //if ($verify == Mod::app()->session['member_verify_code']) {
        //初始化登陆模型
        $login_model = new Memberloginform();
        //不能直接把数组给attributes  但是可以单独的给key赋值
        foreach($login_model->attributes as $k=>$v){
            isset($data[$k]) && $login_model->$k = $data[$k];
        }

        if ($login_model->validate() && $member = $login_model->login()) {
//                Mod::import('application.vendors.*');
//                include_once dirname(__FILE__) . '/../vendor/ucenter.php';
//                list($uid, $username, $password, $email) = @uc_user_login($data['account'], $data['password']);
            $uid = $member['id'];
            if ($uid > 0) {
//                    $symlogin_html = @uc_user_synlogin($uid);
//                    echo json_encode(array('state' => 1, 'mess' => '登录成功', 'script' => $symlogin_html));
//                    $this->message('成功登陆',$this->_siteUrl,'5',$symlogin_html);  exit;
                echo json_encode(array('state' => 1, 'message' => '登录成功','return_url'=>$return_url));
                //print_r(array('state' => 1, 'message' => '登录成功'));
                exit;
            } else if ($uid == -1) {
                echo json_encode(array('state' => 1, 'message' => 'UCenter数据错误'));
                //print_r(array('state' => 1, 'message' => 'UCenter数据错误'));
                exit;
            } else if ($uid == -2) {
                echo json_encode(array('state' => 1, 'message' => 'UCenter密码错'));
                //print_r(array('state' => 1, 'message' => 'UCenter密码错'));
                exit;
            } else {
                echo json_encode(array('state' => 1, 'message' => '未定义'));
                //print_r(array('state' => 1, 'message' => '未定义'));
                exit;
            }
        } else {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码错误'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码错误'));
        }
//        } else {
//            echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//            //print_r(array('state' => 0, 'mess' => '验证码错误'));
//        }
    }

    function actionLogout() {

       // Mod::app()->user->logout();
        unset(Mod::app()->session['member']);
        $url = Mod::app()->createAbsoluteUrl('/');
        Mod::import('application.vendors.*');
        include_once dirname(__FILE__) . '/../vendor/ucenter.php';
        $script = uc_user_synlogout();
        $this->message('退出登陆', $this->_siteUrl, '3', $script);
    }

    function actionVerify_image() {
        $conf['name'] = 'member_verify_code'; //作为配置参数
        $conf['font'] = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'LiberationSans-Bold.ttf';
        $verify = new verify($conf);
        $verify->show();
        Mod::app()->session[$conf['name']] = $verify->get_randcode();
    }
    
    function actionSendverifycode() {
        $mobile = trim(Tool::getValidParam('phone','string'));
        $mobile ='15997567510';
        if($mobile){
            $member_info = Member::model()->find('t.name=:name',array(':name'=>$mobile));
//            if(!empty($member_info)){
//                echo  json_encode(array('state'=>0,'mess'=>'用户已存在'));exit;
//            }
                        
                        
            $conf['name'] = 'phone_verify_code'; //作为配置参数

            $alpha = "abcdefghknpqrstuvxy3456789"; //验证码内容1:字母
            $randcode = ""; //验证码字符串初始化
            $how =5;
            for ($i = 0; $i < $how; $i++) {
                $str = $alpha;
                $which = mt_rand(0, strlen($str) - 1); //取哪个字符
                $code = substr($str, $which, 1); //取字符
                $randcode .= $code; //逐位加入验证码字符串
            }

            Mod::app()->session[$conf['name']] = $randcode;
            $content =  '化妆品财经在线注册服务验证码：%s，请勿泄露！';
            $content = sprintf($content,$randcode);
            $res = $this->Send_sms($content, $mobile);
            if($res){
                  echo  json_encode(array('state'=>1,'mess'=>'发送成功'));exit;
            }else{
                  echo  json_encode(array('state'=>0,'mess'=>'发送失败'));exit;
            }
           
        }
        
        
    }
    
   //手机短信发送
    public function Send_sms($content,$mobile) {
        $url = "http://120.24.77.129:8888/sms.aspx";
        $content .='【化妆品财经在线】';
        $get_array=array(
            'action'=>'send',
            'userid'=>"341",
            'account'=>'xunfa',
            'password'=>"123456",
            'mobile'=>$mobile,
            'content'=>$content,//【化妆品财经在线】是签名必须加
            'sendTime'=>'',
            'extno'=>'',
        );
       $res = Tool::http_post($url,$get_array);
       return $res;
    }
    //WAP个人中心
    public function actionInfo() {
        $token = trim(Tool::getValidParam('access_token','string'));
        $mid = trim(Tool::getValidParam('mid','integer'));
//        echo $token;exit;
        //* 验证access_token是否合法
        $pInfo = Project_token::model()->checkAccessToken($token);
//        var_dump($pInfo->pid);exit;
        if(!$pInfo){
            exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
        }else{
            if($pInfo->expires_in < time()){
                exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
            }
        }
//        //验证用户登陆态
        $memInfo = Member::model()->findByPk($mid);
        if(!$memInfo->phone){
            exit(json_encode(array('status'=>2,'mess'=>'您还未注册,请先注册.')));
        }

        $this->render('memInfo',array('member'=>$memInfo));
    }
    //个人帐户管理
    public function actionAccount()
    {
        $token = trim(Tool::getValidParam('access_token','string'));
        $mid = trim(Tool::getValidParam('mid','integer'));
//        echo $token;exit;
        //* 验证access_token是否合法
        $pInfo = Project_token::model()->checkAccessToken($token);
//        var_dump($pInfo->pid);exit;
        if(!$pInfo){
            exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
        }else{
            if($pInfo->expires_in < time()){
                exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
            }
        }
//        //验证用户登陆态
        $memInfo = Member::model()->findByPk($mid);
        if(!$memInfo->phone){
            exit(json_encode(array('status'=>2,'mess'=>'您还未注册,请先注册.')));
        }
        $this->render('account',array('member'=>$memInfo));
    }
    //个人资料
    public function actionDatum()
    {
        $token = trim(Tool::getValidParam('access_token','string'));
        $mid = trim(Tool::getValidParam('mid','integer'));
//        echo $token;exit;
        //* 验证access_token是否合法
        $pInfo = Project_token::model()->checkAccessToken($token);
//        var_dump($pInfo->pid);exit;
        if(!$pInfo){
            exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
        }else{
            if($pInfo->expires_in < time()){
                exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
            }
        }
//        //验证用户登陆态
        $memInfo = Member::model()->findByPk($mid);
        if(!$memInfo->phone){
            exit(json_encode(array('status'=>2,'mess'=>'您还未注册,请先注册.')));
        }
        $this->render('datum',array('member'=>$memInfo));
    }

}
