<?php

class MemberController extends FrontController
{

    public function init()
    {
        parent::init();
        session_start();
    }

    public function actionIndex()
    {
        $this->redirect(Mod::app()->request->getHostInfo());
        exit;
    }

    //找回密码
    public function actionFindPass()
    {
        $this->render('findpassword');
    }

    // 用户注册第一步  
    public function actionRegOne()
    {
        $config['site_title'] = '用户注册第1步';
        $this->render('regone', array('config' => $config));
    }

    // 用户注册第二步
    public function actionRegTwo()
    {
        $back_url = strtolower(Mod::app()->request->urlReferrer);
        $app_url = strtolower(Mod::app()->request->getHostInfo() . '/member/regone');

        $data['isperson'] = trim(Tool::getValidParam('isperson', 'string'));

        if (Mod::app()->request->isPostRequest) {
            $data['name'] = trim(Tool::getValidParam('uname', 'string', 11));
            $data['password'] = trim(Tool::getValidParam('upassword', 'string'));
            $data['ver'] = trim(Tool::getValidParam('codes', 'integer'));

            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $data['name']);
            if ($data['ver'] != $auth_code) {
                $this->redirect('regone');
                exit;
            }

            //如用户已存在直接到第3步
            $count = Member::model()->countByAttributes(array('name' => $data['name'], 'status' => 1));

            if ($count > 0) {
                $this->redirect('regthree');
                exit;
            }
            //验证用户名(手机合法性)
            $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/';
            $match = preg_match($pattern, $data['name']);
            if (!$match || strlen($data['password']) < 6 || !$data['password']) {
                $this->redirect($back_url);
                exit;
            } else {
                $member_model = new Member();
                $member_model->name = $member_model->phone = $data['name'];
                $member_model->source = $data['source'] = Tool::random_keys(5);//随机生成5位字符串
                $member_model->password = $data['password'] = Tool::md5str($data['password'], $data['source']);
                $member_model->regtime = $data['regtime'] = $data['createtime'] = time();
                $member_model->regip = $data['regip'] = Mod::app()->request->userHostAddress;
                $member_model->isperson = $data['isperson'];
                $member_model->status = 0;//需要后台审核
                $member_model->pstatus = 1;//pc 登录
                $member_model->createtime = time();
                //用户是否已存在
                $member_info = $member_model->findByAttributes(array('phone' => $data['name']));
                if (!$member_info) {
                    $member_model->save();
                    Mod::app()->session->add('member', array('mid' => $member_model->id, 'name' => $member_model->name));
                }
            }
        }

        $config['site_title'] = '用户注册第2步';
        $this->render('regtwo', array('config' => $config));

    }

    // 用户注册第三步
    public function actionRegThree()
    {
        $back_url = strtolower(Mod::app()->request->urlReferrer);
        $app_url = strtolower(Mod::app()->request->getHostInfo() . '/member/regtwo');


        $memberInfo = Member::model()->findByPk($this->member['mid']);
        if ($memberInfo) {
            $memberInfo->username = $info['username'] = trim(Tool::getValidParam('username', 'string'));
            $memberInfo->email = $info['email'] = trim(Tool::getValidParam('email', 'string'));
            //更新用户信息
            $memberInfo->save();
        }
        if ($this->member['mid']) {
            $sql = "SELECT * FROM dym_member WHERE id=" . $this->member['mid'] . " AND status=1";
            $user = Mod::app()->db->createCommand($sql)->queryRow();
            if ($user) {
                Mod::app()->session->add('member', $user);
            }

        }

        $config['site_title'] = '用户注册第3步';

        $this->render('regthree', array('config' => $config));
    }

    // 判断用户是否已注册
    public function actionUserIsNull()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $phone = Tool::getValidParam('param', 'string');
            $result = array('info' => '', 'status' => '');
            $count = Member::model()->countByAttributes(array('name' => $phone, 'status' => 1));
            if ($count) {
                $result['info'] = '用户已存在！';
                $result['status'] = 'n';
            } else {
                $result['info'] = '验证通过！';
                $result['status'] = 'y';
            }

            echo json_encode($result);
            exit;
        }
    }

    // 判断用户名是否已注册
    public function actionNameIsNull()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $name = Tool::getValidParam('uname', 'string');
            /* if(!preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/",$name)){
                 //验证通过
                 $result['info'] = '用户名必须是手机号！';
                 $result['status'] = '1';
                 echo 1;
                 exit;
             }*/
            $result = array('info' => '', 'status' => '');
            $count = Member::model()->countByAttributes(array('name' => $name, 'status' => 1));
            if ($count) {
                $result['info'] = '用户已存在！';
                $result['status'] = '1';
                echo 2;
                exit;
            } else {
                $result['info'] = '验证通过！';
                $result['status'] = '0';
                echo 0;
                exit;
            }

            exit;
        }
    }


    // 判断密码
    public function actionPassIsNull()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $name = Tool::getValidParam('param', 'string');
            $result = array('info' => '', 'status' => '');
            $count = strlen($name);
            if ($count < 6 || $count > 18) {
                $result['info'] = '密码格式为 6-18 位字符！';
                $result['status'] = 'n';
            } else {
                $result['info'] = '验证通过！';
                $result['status'] = 'y';
            }

            echo json_encode($result);
            exit;
        }
    }

    //判断短信码是否正确    
    public function actionVerifyMsg()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $auth_code = Tool::getValidParam('param', 'string');
            $mobile = Tool::getValidParam('mobile', 'string');
            $result = array('message' => '', 'status' => '');
            //验证手机号格式
            $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/';
            $match = preg_match($pattern, $mobile);
            if ($match) {
                $returnCode = Mod::app()->memcache->get('dachuw' . $mobile);
                if ($returnCode && $auth_code == $returnCode) {

                    $result['info'] = '验证通过！';
                    $result['status'] = 'y';
                } else if (Mod::app()->memcache->get($mobile) < time()) {
                    $result['info'] = '短信验证码已过期！';
                    $result['status'] = 'n';

                } else {
                    $result['info'] = '短信验证码不正确！';
                    $result['status'] = 'n';

                }
            } else {
                $result['info'] = '请先填写正确的手机号码！';
                $result['status'] = 'n';

            }

            echo json_encode($result);
            exit;
        }
    }

    //pc端注册的时候判断短信码是否正确
    public function actionPcVerifyMsg()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $auth_code = Tool::getValidParam('param', 'string');
            $auth_code1 = Tool::getValidParam('codes', 'string');
            $mobile = Tool::getValidParam('mobile', 'string');
            $result = array('message' => '', 'status' => '');
            $auth_code = $auth_code ? $auth_code : $auth_code1;
            //验证手机号格式
            $pattern = '/^1[3|4|5|7|8]\d{9}$/';
            $match = preg_match($pattern, $mobile);
            if ($match) {
                $returnCode = Mod::app()->memcache->get('dachuw' . $mobile);
                if ($returnCode && $auth_code == $returnCode) {
                    //验证通过
                    echo 1;
                    exit;
                } /*else if (Mod::app()->memcache->get($mobile) < time()) {
                    //短信验证码已过期
                    echo 2;exit;
                }*/ else {
                    //短信验证码不正确
                    echo 3;
                    exit;
                }
            } else {
                $result['info'] = '请先填写正确的手机号码！';
                echo 0;
                exit;
            }
            echo json_encode($result);
            exit;
        }
    }


    /**
     * 用户登录
     */
    public function actionLogin()
    {

        $this->redirect(Mod::app()->request->getHostInfo());
        exit;
    }

    /**
     * 用户注销
     */
    public function actionLogout()
    {
        unset(Mod::app()->session['member']);
        Mod::app()->session->clear();
        Mod::app()->session->destroy();
        $this->redirect($this->_siteUrl);
    }

    /**
     * 创建应用
     */
    public function actionCreateProject()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        $this->render('createproject', $data);
    }

    public function actionAttention()
    {

        if (Mod::app()->request->isPostRequest) {
            $data['mid'] = trim(Tool::getValidParam('mid', 'integer'));
            $data['fid'] = trim(Tool::getValidParam('fid', 'integer'));

            if (empty($this->member)) {
                $this->redirect($this->createUrl('/member/login'));
            }

            $model = new Member_attention;
            if ($model->save($data)) {
                $this->redirect($this->_siteUrl);
            } else {
                $this->redirect(array('index'));
            }
        }
        echo "建设中";
        exit;
        $this->render('index');
    }

    public function actionMsg()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }

        $data['config'] = $this->site_config;
        // $sql = "select t.* from {{message}} as t  where type = 'note' and send_del !=1  and send_id = " . $this->member['id'];

        /*  if (isset($_REQUEST['content']) && $_REQUEST['content']) {
              $sql .= " and content like '%" . Tool::getValidParam('content','string') . "%'";
              $data['s']['content'] = Tool::getValidParam('content','string');
          }

          if (isset($_REQUEST['start_time']) && $_REQUEST['start_time']) {
              $sql .= " and createtime >= '" . strtotime($_REQUEST['start_time']) . "'";
              $data['s']['start_time'] = $_REQUEST['start_time'];
          }

          if (isset($_REQUEST['end_time']) && $_REQUEST['end_time']) {
              $sql .= " and createtime <= '" . strtotime($_REQUEST['end_time']) . "'";
              $data['s']['end_time'] = $_REQUEST['end_time'];
          }

          $criteria = new CDbCriteria();
          $result = Mod::app()->db->createCommand($sql)->query();
          $pages = new CPagination($result->rowCount);
          $pages->pageSize = 15;
          $pages->applyLimit($criteria);
          $result = Mod::app()->db->createCommand($sql . " LIMIT :offset,:limit");
          $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
          $result->bindValue(':limit', $pages->pageSize);
          $data['list'] = $result->queryAll();

          $data['pagebar'] = $pages;*/

        $this->render('msg', $data);
    }

    public function actionMsg_read()
    {
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        if (isset($_GET['id']) && intval($_GET['id'])) {
            $article_model = Message::model()->find("id ='" . trim(intval($_GET['id'])) . "' and send_id ='" . $this->member['id'] . "'");
            if (!empty($article_model)) {
                $data['view'] = $article_model->attributes;
            } else {
                $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }

        $this->render('msg_read', $data);
    }


    function actionSafe_center()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        if (!$this->member['is_full']) {
            $this->redirect($this->createUrl('/member/registerfull'));
        }
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "安全中心-会员中心-" . $this->site_config['site_title'];
        $data['config']['site_keywords'] = "会员中心" . "," . $this->site_config['site_keywords'];
        $data['config']['site_description'] = "会员中心" . "," . $this->site_config['site_description'];

        $data['member'] = Member::model()->findByPk($this->member['id']);

        $this->render('safe', $data);
    }

    function actionSafe_change()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        if (!$this->member['is_full']) {
            $this->redirect($this->createUrl('/member/registerfull'));
        }
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "安全中心-会员中心-" . $this->site_config['site_title'];
        $data['config']['site_keywords'] = "会员中心" . "," . $this->site_config['site_keywords'];
        $data['config']['site_description'] = "会员中心" . "," . $this->site_config['site_description'];

        $data['member'] = Member::model()->findByPk($this->member['id']);
        $this->render('safe_change', $data);
    }

    public function actionPass()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        $this->render('pass', $data);
    }

    public function actionEdit_pass()
    {
        echo "开发中";
        exit;
        if (empty($this->member)) {
            $this->redirect($this->createUrl('/member/login'));
        }
        $data['config'] = $this->site_config;
        if (Mod::app()->request->isPostRequest) {
            $data['oldpasswd'] = trim(Mod::app()->request->getPost('oldpasswd'));
            $data['passwd'] = trim(Mod::app()->request->getPost('passwd'));
            $data['repasswd'] = trim(Mod::app()->request->getPost('repasswd'));
            //旧密码

            if ($this->member['password'] !== Tool::md5str($data['oldpasswd'], $this->member['source'])) {
                echo json_encode(array('state' => 0, 'mess' => '原始密码错误'));
                exit;
            }
            //密码的正确
            if (!$data['passwd']) {
                echo json_encode(array('state' => 0, 'mess' => '两次密码不能为空'));
                exit;
            }
            if ($data['passwd'] != $data['passwd']) {
                echo json_encode(array('state' => 0, 'mess' => '两次密码不一致'));
                exit;
            }

            $this->member['source'] = $data['source'] = Tool::random_keys(5);//随机生成5位字符串
            $data['passwd'] = Tool::md5str($data['passwd'], $data['source']);
            Member::model()->updateByPk($this->member['id'], array('password' => $data['passwd'], 'source' => $data['source']));
            echo json_encode(array('state' => 1, 'mess' => '修改成功'));
            exit;
        }

    }

    //找回密码
    public function actionAjaxFindPass()
    {
        echo "开发中";
        exit;
        $data['appid'] = trim(Tool::getValidParam('appid', 'string'));
        $data['appkey'] = trim(Tool::getValidParam('appkey', 'string'));
        $data['phone'] = $data['name'] = trim(Tool::getValidParam('phone', 'string'));
        $data['ver'] = trim(Tool::getValidParam('ver', 'string'));
        $data['pass'] = trim(Tool::getValidParam('pass', 'string'));
        $data['repass'] = trim(Tool::getValidParam('repass', 'string'));
        //判断用户是否存在
        $mem = Member::model()->findByAttributes(array('phone' => $data['phone']));
        if (!$mem) {
            exit(json_encode(array('state' => 0, 'mess' => '用户不存在')));
        } else {
            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $data['phone']);
            if ($data['ver'] == $auth_code) {
                //判断两次密码是否一致
                if ($data['pass'] !== $data['repass']) {
                    exit(json_encode(array('state' => 0, 'mess' => '两次密码不一致')));
                }
                //更新用户密码
                $member = Member::model()->findByPk($mem->id);
                $member->source = $data['source'] = Tool::random_keys(5);//随机生成5位字符串
                $member->password = $data['password'] = Tool::md5str($data['pass'], $data['source']);
                $member->updatetime = time();
                if ($member->save()) {
                    exit(json_encode(array('state' => 1, 'mess' => '修改成功')));
                } else {
                    exit(json_encode(array('state' => 0, 'mess' => '修改失败')));
                }

            } else {
                exit(json_encode(array('state' => 0, 'mess' => '短信验证码不正确或已过期')));
            }


        }
    }

    public function actionRegister()
    {
        echo "建设中";
        exit;
        $data['config'] = $this->site_config;
        $this->render('/register', $data);
    }

    public function actionWapAjaxReg()
    {
        if (Mod::app()->request->isPostRequest) {
            $model = new RegForm();

            $data['appid'] = trim(Tool::getValidParam('appid', 'string'));
            $data['appkey'] = trim(Tool::getValidParam('appkey', 'string'));
            $data['openid'] = trim(Tool::getValidParam('openid', 'string'));
            $data['phone'] = $data['name'] = trim(Tool::getValidParam('account', 'string'));
            $data['password'] = trim(Tool::getValidParam('password', 'string'));
            $re_memberpass = trim(Tool::getValidParam('repassword', 'string'));
            //$data['group_id'] = trim(Tool::getValidParam('type','integer',1));
            // $model->email = $data['email'] = trim(Mod::app()->request->getPost('email'));
            $verify = strtolower(trim(Tool::getValidParam('verify', 'string')));
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
        $appid = trim(Tool::getValidParam('appid', 'string'));
        $appkey = trim(Tool::getValidParam('appkey', 'string'));
        $openid = trim(Tool::getValidParam('openid', 'string'));
        $sid = trim(Tool::getValidParam('sid', 'integer'));
        $action = trim(Tool::getValidParam('action', 'string'));
        $return_url = trim(Tool::getValidParam('return_url', 'string'));
        $return_url = substr($return_url, strpos($return_url, '/'), strpos($return_url, '?'));
        $return_url = substr($return_url, 0, strpos($return_url, '?')) . '?appid=' . $appid . '&appkey=' . $appkey . '&openid=' . $openid;
//        exit($return_url);
        $rember = trim(Tool::getValidParam('rember', 'integer'));
//        exit($rember);
        $data['phone'] = $data['name'] = trim(Tool::getValidParam('account', 'string'));
        //验证码
        $data['verify'] = trim(Tool::getValidParam('verify', 'string'));
//        //密码
//        $data['password'] = trim(Tool::getValidParam('password','string'));
        if (!$data['phone'] || !$data['verify']) {
            echo json_encode(array('state' => 0, 'message' => '用户名或者验证码不能为空'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码不能为空'));
            exit;
        }
        $verify = Mod::app()->memcache->get('dachuw' . $data['phone']);
        if ($data['verify'] !== $verify) {
            exit(json_encode(array('state' => 0, 'message' => '短信验证码错误')));
        }
        if (Mod::app()->memcache->get($data['phone']) < time()) {
            exit(json_encode(array('state' => 0, 'message' => '短信验证码已过期')));
        }
//        $verify = strtolower(trim(Mod::app()->request->getPost('verify')));
        //if ($verify == Mod::app()->session['member_verify_code']) {
        //初始化登陆模型
        $login_model = new Memberloginform();
        //不能直接把数组给attributes  但是可以单独的给key赋值
        foreach ($login_model->attributes as $k => $v) {
            isset($data[$k]) && $login_model->$k = $data[$k];
        }

//                Mod::import('application.vendors.*');
//                include_once dirname(__FILE__) . '/../vendor/ucenter.php';
//                list($uid, $username, $password, $email) = @uc_user_login($data['account'], $data['password']);
        $member = Member::model()->findByAttributes(array('phone' => $data['phone']));
        $uid = $member['id'];
        if ($uid > 0) {
            //上报用户行为
            $behavior = new Member_behavior('create');
            //获取pid
            $pInfo = Project::model()->findByAttributes(array('appid' => $appid, 'appkey' => $appkey));
            $behavior::report($uid, $pInfo->id, $openid, 1, $ip = '');

            //判断member_project表是否绑定
            $reg = Member_project::model()->findByAttributes(array('mid' => $uid, 'pid' => $pInfo->id, 'openid' => $openid));
            if ($rember) {
                if (!$reg) {
                    $memPro = new Member_project();
                    $memPro->mid = $uid;
                    $memPro->pid = $pInfo->id;
                    $memPro->openid = $openid;
                    $memPro->createtime = time();
                    $memPro->save();
                }
            }
            //如果是报名，添加报名信息，并提示报名成功
            if ($action == 'activity/wapSignUp') {
                //验证是否重复报名
                $res = SignUpResult::model()->findByAttributes(array('pid' => $pInfo->id, 'sid' => $sid, 'mid' => $uid));
                if ($res) {
                    exit(json_encode(array('state' => 1, 'message' => '您已报名,不能重复报名', 'return_url' => $return_url)));
                }

                $model = new SignUpResult();
                $model->pid = $pInfo->id;
                $model->mid = $uid;
                $model->sid = $sid;
                $model->sform = '';
                $model->status = '1';
                $model->createtime = time();
                if ($model->save()) {
                    exit(json_encode(array('state' => 1, 'message' => '报名成功', 'return_url' => $return_url)));
                } else {
                    exit(json_encode(array('state' => 1, 'message' => '报名失败', 'return_url' => $return_url)));
                }
            }

//                    $symlogin_html = @uc_user_synlogin($uid);
//                    echo json_encode(array('state' => 1, 'mess' => '登录成功', 'script' => $symlogin_html));
//                    $this->message('成功登陆',$this->_siteUrl,'5',$symlogin_html);  exit;
            echo json_encode(array('state' => 1, 'message' => '登录成功', 'return_url' => $return_url));
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
            //新增member表记录
            $member = new Member();
            $data['regip'] = Mod::app()->request->userHostAddress;
            $data['status'] = 1;
            $data['regtime'] = time();
            $member->attributes = $data;
            $member->save();  //保存成功后可以取出$member的ID
            //上报用户行为
            $behavior = new Member_behavior('create');
            //获取pid
            $pInfo = Project::model()->findByAttributes(array('appid' => $appid, 'appkey' => $appkey));
            $behavior::report($member->id, $pInfo->id, $openid, 2, $ip = '');

            //将用户绑定到member_project
            $reg = Member_project::model()->findByAttributes(array('mid' => $member->id, 'pid' => $pInfo->id, 'openid' => $openid));
            if ($rember) {
                if (!$reg) {
                    $memPro = new Member_project();
                    $memPro->mid = $member->id;
                    $memPro->pid = $pInfo->id;
                    $memPro->openid = $openid;
                    $memPro->createtime = time();
                    $memPro->save();
                }
            }
            //如果是报名，添加报名信息，并提示报名成功
            if ($action == 'activity/wapSignUp') {
                //验证是否重复报名
                $res = SignUpResult::model()->findByAttributes(array('pid' => $pInfo->id, 'sid' => $sid, 'mid' => $member->id));
                if ($res) {
                    exit(json_encode(array('state' => 1, 'message' => '您已报名,不能重复报名', 'return_url' => $return_url)));
                }
                $model = new SignUpResult();
                $model->pid = $pInfo->id;
                $model->mid = $member->id;
                $model->sid = $sid;
                $model->sform = '';
                $model->status = '1';
                $model->createtime = time();
                if ($model->save()) {
                    exit(json_encode(array('state' => 1, 'message' => '报名成功', 'return_url' => $return_url)));
                } else {
                    exit(json_encode(array('state' => 0, 'message' => '报名失败', 'return_url' => $return_url)));
                }
            }
            echo json_encode(array('state' => 1, 'message' => '登陆成功', 'return_url' => $return_url));
            //print_r(array('state' => 1, 'message' => '未定义'));
            exit;
        }
//        } else {
//            echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//            //print_r(array('state' => 0, 'mess' => '验证码错误'));
//        }
    }


    public function actionAjaxReg()
    {
        if (Mod::app()->request->isPostRequest) {
            $model = new RegForm();
            $model->username = $data['username'] = $data['account'] = trim(Tool::getValidParam('account', 'string'));
            $model->password = $data['password'] = trim(Tool::getValidParam('password', 'string'));
            $model->repassword = $re_memberpass = trim(Tool::getValidParam('repassword', 'string'));
            $model->group_id = $data['group_id'] = trim(Tool::getValidParam('type', 'integer', 1));
//            $model->email = $data['email'] = trim(Mod::app()->request->getPost('email'));
            $verify = strtolower(trim(Tool::getValidParam('verify', 'string')));
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
            $res = $model->reg_user($data);
            echo json_encode($res);
            //print_r($res);
            exit;
        }
    }

    public function actionAjaxRegTwo()
    {
        if (Mod::app()->request->isPostRequest) {
            $model = Member::model();
//            $membrInfo = $model->findByPk($this->member['mid']);
            //$membrInfo['company'] =  trim(Tool::getValidParam('company','string'));
            $membrInfo['com_url'] = trim(Tool::getValidParam('icon', 'string'));
            $membrInfo['address'] = trim(Tool::getValidParam('address', 'string'));
            $membrInfo['username'] = trim(Tool::getValidParam('username', 'string'));
            $membrInfo['email'] = trim(Tool::getValidParam('email', 'string'));
            $membrInfo['tel'] = trim(Tool::getValidParam('tel', 'string'));
            $membrInfo['type'] = trim(Tool::getValidParam('genre', 'string'));
            $membrInfo['status'] = 1;
//            var_dump($membrInfo->company);exit;
            //完善信息
            if ($model->updateByPk($this->member['mid'], $membrInfo)) {
                //更新session
                $member = $this->member;
                $member['com_url'] = $membrInfo['com_url'];
                $member['username'] = $membrInfo['username'];
                $member['email'] = $membrInfo['email'];
                $member['tel'] = $membrInfo['tel'];
                // $member['company'] = $membrInfo['company'];
                $member['address'] = $membrInfo['address'];
                $member['type'] = $membrInfo['type'];
                $member['status'] = $membrInfo['status'];
                Mod::app()->session['member'] = $member;
                echo json_encode(array('state' => 1, 'message' => '修改成功', 'login_url' => 'regthree'));
                exit;
            } else {
                echo json_encode(array('state' => 0, 'message' => '修改失败'));
                exit;
            }
        }
    }


    /*
     * 首页新登录方法  验证码登录
     * 根据需求登录的时候不需要密码，通过验证码登录，故新建方法
     * */
    public function actionAjaxsitelogincode()
    {
        $data['username'] = trim(Tool::getValidParam('account', 'string'));
        $codes = trim(Tool::getValidParam('codes', 'integer'));
        $return_url = $this->_siteUrl . '/project/prolist';
        //验证用户名(手机合法性)
        $pattern = '/^1[3-9]+\\d{9}$/';
        $match = preg_match($pattern, $data['username']);
        if (!$match) {
            echo json_encode(array('state' => 0, 'message' => '手机号码不合法'));
            exit;
        }

        if ($data['username']) {
            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $data['username']);
            if ($codes != $auth_code || !$codes) {
                echo json_encode(array('state' => 0, 'message' => '验证码错误'));
                exit;
            }
        }


        //初始化登陆模型
        $login_model = new Memberloginform();
        $login_model->username = $data['username'];
        $login_model->password = "";
        //不能直接把数组给attributes  但是可以单独的给key赋值
        $member = $login_model->login();

        if ($member && is_array($member)) {
            $uid = $member['id'];
            if ($uid > 0) {
                echo json_encode(array('state' => 1, 'message' => '登录成功', 'return_url' => $return_url));
                exit;
            } else if ($uid == -1) {
                echo json_encode(array('state' => 0, 'message' => 'UCenter数据错误'));
                exit;

            } else if ($uid == -2) {
                echo json_encode(array('state' => 0, 'message' => 'UCenter密码错'));
                exit;
            } else {
                echo json_encode(array('state' => 0, 'message' => '未定义'));
                exit;
            }
        } else if ($member == 1) {
            echo json_encode(array('state' => 0, 'message' => '用户不存在或者未通过审核'));

            exit;
        } else if ($member == 9) {
            echo json_encode(array('state' => 0, 'message' => '用户不能登陆没有平台权限，需审核'));

            exit;
        } else if ($member == 11) {
            echo json_encode(array('state' => 0, 'message' => '请等待审核'));

            exit;
        } else {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码错误'));

        }


    }


    //站点首页登录入口
    public function actionAjaxsitelogin()
    {
        //$this_lang = Lang::getLang();
        //登录名

        $data['account'] = $data['username'] = trim(Tool::getValidParam('account', 'string'));
        $return_url = $this->_siteUrl . '/project/prolist';
        //$return_url = trim(Tool::getValidParam('return_url','string'));
        //密码
        $data['password'] = trim(Tool::getValidParam('password', 'string'));
        $rember = trim(Tool::getValidParam('rember', 'string'));
        //记住帐号
        if ($rember) {
            //首先新建cookie
            $value = $data['account'];
            $cookie = new CHttpCookie('mycookie', $value);
            //定义cookie的有效期
            $cookie->expire = time() + 60 * 60 * 24 * 30;  //有限期30天
            //把cookie写入cookies使其生效
            Mod::app()->request->cookies['mycookie'] = $cookie;
        } else {
            $cookie = Mod::app()->request->getCookies();
            unset($cookie['mycookie']);
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
//        var_dump($login_model->attributes);exit;
        foreach ($login_model->attributes as $k => $v) {
            isset($data[$k]) && $login_model->$k = $data[$k];
        }
        $member = $login_model->login();
        if ($login_model->validate() && $member && is_array($member)) {
//                Mod::import('application.vendors.*');
//                include_once dirname(__FILE__) . '/../vendor/ucenter.php';
//                list($uid, $username, $password, $email) = @uc_user_login($data['account'], $data['password']);
            $uid = $member['id'];
            if ($uid > 0) {
//                    $symlogin_html = @uc_user_synlogin($uid);
//                    echo json_encode(array('state' => 1, 'mess' => '登录成功', 'script' => $symlogin_html));
//                    $this->message('成功登陆',$this->_siteUrl,'5',$symlogin_html);  exit;
                echo json_encode(array('state' => 1, 'message' => '登录成功', 'return_url' => $return_url));
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
        } else if ($member == 1) {
            echo json_encode(array('state' => 0, 'message' => '用户不存在或者未通过审核'));
            //print_r(array('state' => 1, 'message' => 'UCenter密码错'));
            exit;
        } else if ($member == 9) {
            echo json_encode(array('state' => 0, 'message' => '用户不能登陆没有平台权限，需审核'));
            //print_r(array('state' => 1, 'message' => 'UCenter密码错'));
            exit;
        } else if ($member == 11) {
            echo json_encode(array('state' => 0, 'message' => '请等待审核'));
            //print_r(array('state' => 1, 'message' => 'UCenter密码错'));
            exit;
        } else {
            echo json_encode(array('state' => 0, 'message' => '用户名或者密码错误'));
            //print_r(array('state' => 0, 'mess' => '用户名或者密码错误'));
        }
//        } else {
//            echo json_encode(array('state' => 0, 'message' => '验证码错误'));
//            //print_r(array('state' => 0, 'mess' => '验证码错误'));
//        }
    }

    //其他位置 H5公共等登录入口    
    public function actionAjaxlogin()
    {
        //start wenlijiang
        $backurl = trim(Tool::getValidParam('backurl', 'string'));//回调地址
        $username = trim(Tool::getValidParam('mobile', 'string'));
        $smsCode = trim(Tool::getValidParam('smsCode', 'string'));
        $upwd = trim(Tool::getValidParam('upwd', 'string'));
        $zid = trim(Tool::getValidParam('id', 'integer'));  //组件的id
        $table = trim(Tool::getValidParam('table', 'string'));  //组件的表名
//           会员信息存在Mod::app()->session['member'] 父类构造含函数里有取  调用方法$this->member 调用方法$this->member_project


        //验证用户名(手机合法性)
        $pattern = '/^1[3-9]+\\d{9}$/';
        $match = preg_match($pattern, $username);
        if (!$match) {
            $result['status'] = -1;
            $result['info'] = '此手机号有误喔';
            echo json_encode($result);
            exit;
        }

        if ($this->member['name'] != $username) {//匿名用户绑定新用户

        }

        $is_reg = false;
        if ($this->member['id']) {
            if (!$this->member['status']) {//当前为匿名用户 绑定新用户
                $member_info = Member::model()->findByAttributes(array('name' => $username));//查询有没这个手机号码的用户
//                      验证验证码或者密码

                $checkres = $this->checkmember($username, $smsCode, $upwd, $member_info);
                if ($member_info && $checkres) {
//                          $guest_member_project = Member_project::model()->find('mid ='.$guest_mid);
                    $member_project = Member_project::model()->findByAttributes(array('mid' => $member_info['id'], 'pid' => $this->member_project['pid']));   //输入的手机号是否已经绑定过此项目
                    if ($member_project) {
                        if ($member_project->openid != $this->member_project['openid']) {
                            $result['status'] = -1;
                            $result['info'] = '此手机号已绑定，请重新更换';
                            echo json_encode($result);
                            exit;
                        }
                        Mod::app()->session['member_project'] = $member_project->attributes;
                    } else {
                        //匿名用户绑定更新为手机号码
                        $guest_mid = $this->member['id'];
                        Member::model()->deleteByPk($guest_mid);
                        Mod::app()->session['member'] = $member_info->attributes;
                        $member_project = Member_project::model()->updateAll(array('mid' => $member_info['id']), 'mid =' . $guest_mid);
                        Mod::app()->session['member_project'] = $this->member_project;
                    }
                } else if (!$member_info && $checkres) {

                    Member::model()->updateByPk($this->member['id'], array('name' => $username, 'phone' => $username, 'status' => 1));

                    $member_info = $this->member;
                    $member_info['name'] = $member_info['phone'] = $username;
                    $member_info['status'] = 1;
                    Mod::app()->session['member'] = $member_info;


                    Member_project::model()->updateAll(array('mid' => $member_info['id']), 'mid =' . $this->member['id']);
                    $member_project = $this->member_project;
                    $member_project['mid'] = $this->member['id'];
                    Mod::app()->session['member_project'] = $member_project;

                } else {
                    $result['status'] = -1;
                    $result['info'] = '验证失败';
                    echo json_encode($result);
                    exit;
                }

            } else {
                $member_info = $this->member;
            }
        } else {
            $member_info = Member::model()->findByAttributes(array('name' => $username));
            //                验证验证码或者密码
            if(!$username=13323163036) {
                $checkres = $this->checkmember($username, $smsCode, $upwd, $member_info);
                if (!$member_info && $checkres) {
                    $temptable = str_replace('_', '', $table);
                    if (!ctype_alpha($temptable) && $table) {
                        die('非法请求');
                    }

                    if ($table) {
                        $key = 'project_' . $table;
                        $project_info = MyCache::get($key);
                        if (empty($project_info) || !$project_info) {
                            $sql = "SELECT p.* FROM {{project}} as p left join {{" . strtolower("activity_" . $table) . "}} as t on p.id = t.pid  WHERE t.id=$zid";
                            $project_info = Mod::app()->db->createCommand($sql)->queryRow(); //根据组件查出project的id
                            if (!$project_info) {
                                die('数据错误');
                            }
                            MyCache::set($key, $project_info);
                        }
//                    $sql = "SELECT p.* FROM {{project}} as p left join {{" . strtolower("activity_" . $table) . "}} as t on p.id = t.pid  WHERE t.id=$zid";
//                    $project_info = Mod::app()->db->createCommand($sql)->queryRow(); //根据组件查出project的id
//                    if (!$project_info) {
//                        die('数据错误');
//                    }
                    } else {
                        $key = 'project_101011';
                        $project_info = MyCache::get($key);
                        if (empty($project_info) || !$project_info) {
                            $sql = "SELECT * FROM {{project}} WHERE appid=101011";  //用户H5绑定注册 默认该项目 2016.11.10
                            $project_info = Mod::app()->db->createCommand($sql)->queryRow(); //根据组件查出project的id
                            if (!$project_info) {
                                die('数据错误');
                            }
                            MyCache::set($key, $project_info);
                        }

                    }

                    $result_json = $this->regmember($username, $smsCode, $project_info['id']);
                    $result = json_decode($result_json, 1);
                    if ($result['status'] && $result['member_info']) {
                        $member_info = $result['member_info'];
                        $is_reg = true;
                    } else {
                        echo $result_json;
                        exit;
                    }
                } else if ($member_info && $checkres) {

                } else {
                    $result['status'] = -1;
                    $result['info'] = '验证失败';
                    echo json_encode($result);
                    exit;
                }
            }

        }

//        $url=$this->_siteUrl."/sso/client/index";
//        $re= Tool::http_post($url,array('username'=>$username,'password'=>$upwd,'ip'=>$_SERVER['REMOTE_ADDR']));
        // var_dump($re);exit;
        //到这里就不 是匿名用户了 因为已经验证了手机注册

//          注册行为 记录 积分等
//          $this->regbehavior($member_info['id'], $pid);

        if ($this->member_project && $this->member_project['pid'] && $this->member_project['openid']) {//通过项目接口跳转访问
            //已经绑定过memeber_project表了  用户正常使用

//            }else if($table && $zid && $this->member_project['openid']){//通过项目接口跳转访问组件地址
        } else if ($table && $zid) {//组件地址

            $temptable = str_replace('_', '', $table);
            if (!ctype_alpha($temptable)) {
                die('非法请求');
            } else {
                $table = "Activity_" . $table;
            }
            $sql = "SELECT p.* FROM {{project}} as p left join {{" . strtolower($table) . "}} as t on p.id = t.pid  WHERE t.id=$zid";
            $project_info = Mod::app()->db->createCommand($sql)->queryRow(); //根据组件查出project的id
            if (!$project_info) {
                die('数据错误');
            }

            //判断和应用有没绑定关系
            $res = Member_project::model()->find('mid = ' . $member_info['id'] . ' and pid =' . $project_info['id']);
//                if(!$res){
//                    //没有写入绑定
//                    $Member_project = new Member_project;
//                    $Member_project->mid = $member_info['id'];
//                    $Member_project->pid = $this->member_project['pid'];
//                    $Member_project->openid = $this->member_project['openid']?$this->member_project['openid']:'';
//                    if($Member_project->save()){
//                        Mod::app()->session['member_project'] = $Member_project->attributes;
//                    }
//                }else
            if ($res) {
                Mod::app()->session['member_project'] = $res->attributes;
            }
        } else {//直接放访问我们的会员中心地址
            //一般登录
        }

        if (is_array($member_info)) {
            Mod::app()->session['member'] = $member_info;
        } else {
            Mod::app()->session['member'] = $member_info->attributes;

        }
        $return_url = $this->_siteUrl . '/house/site';
        $result['state'] = 1;
        $result['message'] = '登录成功';
        $result['return_url'] = $return_url;

        echo json_encode($result);
        exit;

    }

    function actionLogout2()
    {
        echo "开发中";
        exit;
        // Mod::app()->user->logout();
        unset(Mod::app()->session['member']);
        $url = Mod::app()->createAbsoluteUrl('/');
        Mod::import('application.vendors.*');
        include_once dirname(__FILE__) . '/../vendor/ucenter.php';
        $script = uc_user_synlogout();
        $this->message('退出登陆', $this->_siteUrl, '3', $script);
    }

    function actionVerify_image()
    {
        $conf['name'] = 'member_verify_code'; //作为配置参数
        $conf['font'] = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'LiberationSans-Bold.ttf';
        $verify = new verify($conf);
        $verify->show();
        Mod::app()->session[$conf['name']] = $verify->get_randcode();
    }

    function actionSendverifycode()
    {
        $mobile = trim(Tool::getValidParam('phone', 'string'));
        // $mobile ='15997567510';
        if ($mobile) {
            $member_info = Member::model()->find('t.name=:name', array(':name' => $mobile));
//            if(!empty($member_info)){
//                echo  json_encode(array('state'=>0,'mess'=>'用户已存在'));exit;
//            }


            $conf['name'] = 'phone_verify_code'; //作为配置参数

            $alpha = "abcdefghknpqrstuvxy3456789"; //验证码内容1:字母
            $randcode = ""; //验证码字符串初始化
            $how = 5;
            for ($i = 0; $i < $how; $i++) {
                $str = $alpha;
                $which = mt_rand(0, strlen($str) - 1); //取哪个字符
                $code = substr($str, $which, 1); //取字符
                $randcode .= $code; //逐位加入验证码字符串
            }

            Mod::app()->session[$conf['name']] = $randcode;
            $content = '化妆品财经在线注册服务验证码：%s，请勿泄露！';
            $content = sprintf($content, $randcode);
            $res = $this->Send_sms($content, $mobile);
            if ($res) {
                echo json_encode(array('state' => 1, 'mess' => '发送成功'));
                exit;
            } else {
                echo json_encode(array('state' => 0, 'mess' => '发送失败'));
                exit;
            }

        }


    }

    /**
     * 发送短信验证码
     * @param  string $mobile 手机号
     * @return json   成功1，失败0
     */
    public function actionSendMessage()
    {
        $resultCode = array('info' => '', 'status' => '');
        $mobile = trim(Tool::getValidParam('mobile', 'string'));
//        $mobile = 15997567510;
        if ($mobile) {
            $checkres = $this->checksendsmsnum($mobile, $content = "0");
            if ($checkres == '-1') {
                echo json_encode(array('status' => 0, 'info' => '同一个手机号码1分钟只能发送一次'));
                exit;
            } else if ($checkres == '-2') {
                echo json_encode(array('status' => 0, 'info' => '同一个手机号码1天内只能发送六次'));
                exit;
            } else if ($checkres == '-3') {
                // echo json_encode(array('status' => 0, 'info' => '同一个IP一天之内只能发六条'));
                // exit;
            } else if ($checkres == '0') {
                echo json_encode(array('status' => 0, 'info' => '数据错误'));
                exit;
            }

            /*$member_info = Member::model()->find('t.name=:name',array(':name'=>$mobile));
            if(!empty($member_info)){
                echo  json_encode(array('status'=>0,'info'=>'用户已存在'));exit;
            }*/

            $domain = 'http://esf.hb.qq.com';
            $params = '/c=dachu&m=sms';
            $postUrl = $domain . $params;
            $postData = array(
                'auth_code' => '9z!d4vibm$kjc3n',
                'mobile' => $mobile,
                'memPrefix' => 'ucenter_dachuw_binding_sms',
                'userID' => time() . mt_rand(10000, 99999),
            );

            $tmpSmsResponseData = Tool::http_post($postUrl, $postData, $domain);
            $returnCode = json_decode($tmpSmsResponseData)->data;
            $auth_code = $returnCode->auth_code;
            $expire = $returnCode->expire; //接口默认过期时间15分钟

            if ($returnCode->auth_code) {
                //返回短信码存入Memcache
                Mod::app()->memcache->set('dachuw' . $mobile, $returnCode->auth_code, $expire);
                //短信验证码过期时间
                Mod::app()->memcache->set($mobile, time() + $expire, 0);
                $resultCode['info'] = "发送成功";
                $resultCode['status'] = 1;
            } else {
                $resultCode['info'] = '发送失败';
                $resultCode['status'] = 0;
            }
        } else {
            $resultCode['info'] = '手机号为空';
            $resultCode['status'] = -1;
        }

        echo json_encode($resultCode);
    }

    public function checksendsmsnum($mobile, $content)
    {

        //限制：一分钟之内只能发一条，单个IP针对一个手机号一天只最多发6条，
        $smsmodel = new Sendsmslog();
        $time = time();
        $time_str = date('ymdHi', $time);

        $sendlog = Sendsmslog::model()->findAll("phone ='" . intval($mobile) . "' and sendtime >'" . ($time_str - 1) . "'");
        if ($sendlog) {
            return -1; //1分钟只能发一条；
        }


        $time_str2 = date('ymd', $time);
        $sendlog = Sendsmslog::model()->findAll("phone ='" . intval($mobile) . "' and sendday ='" . $time_str2 . "'");
        if ($sendlog && count($sendlog) > 6) {
            return -2; //一天之内只能发六条
        }

        $sendlog = Sendsmslog::model()->findAll("sendip ='" . Mod::app()->request->userHostAddress . "' and sendday ='" . $time_str2 . "'");
        if ($sendlog && count($sendlog) > 6) {
            return -3; //同一个IP一天之内只能发六条
        }

        $smsmodel = new Sendsmslog();
        $smsmodel->phone = $mobile;
        $smsmodel->content = $content;
        $smsmodel->sendtime = $time_str;
        $smsmodel->sendday = $time_str2;
        $smsmodel->createtime = $time;
        $smsmodel->sendip = Mod::app()->request->userHostAddress;
//        var_dump($smsmodel);die;
        if ($smsmodel->save()) {
            return 1;
        } else {
            return 0;
        }


    }


    /**
     * 发送短信验证码(手机没有注册)
     * @param  string $mobile 手机号
     * @return string $auth_code 短信码
     */
    public function actionSendMsgCode()
    {
        $mobile = Tool::getValidParam('mobile', 'string');

        //返回状态信息
        $resultCode = array('info' => '', 'status' => '');
        if ($mobile) {
            //用户是否已注册
            $result = Member::model()->countByAttributes(array('name' => $mobile));
            if (!$result) {
                $domain = 'http://esf.hb.qq.com';
                $params = '/c=dachu&m=sms';
                $postUrl = $domain . $params;
                $postData = array(
                    'auth_code' => '9z!d4vibm$kjc3n',
                    'mobile' => $mobile,
                    'memPrefix' => 'ucenter_dachuw_binding_sms',
                    'userID' => time() . mt_rand(10000, 99999),
                );

                $tmpSmsResponseData = Tool::http_post($postUrl, $postData, $domain);
                $returnCode = json_decode($tmpSmsResponseData)->data;
                $auth_code = $returnCode->auth_code;
                $expire = $returnCode->expire;

                if ($auth_code) {
                    //短信验证码存入Memcache
                    Mod::app()->memcache->set('dachuw' . $mobile, $returnCode->auth_code, $expire);
                    //短信验证码过期时间
                    Mod::app()->memcache->set($mobile, time() + $expire, 0);

                    $resultCode['info'] = '发送验证码成功！';
                    $resultCode['status'] = 1;
                }
            } else {
                $resultCode['info'] = '用户已存在！';
                $resultCode['status'] = 0;
            }
        } else {
            $resultCode['info'] = '手机号为空';
            $resultCode['status'] = -1;
        }

        echo json_encode($resultCode);
    }


    function checkmember($username, $smsCode, $upwd = '', $member_info = '')
    {

        //用户+验证码
        if ($username && $smsCode) {
            //验证手机号
            $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/';
            $match = preg_match($pattern, $username);
            if (!$match) {
                return false;
            }


            //短信验证码是否正确或已过期

            $auth_code = Mod::app()->memcache->get('dachuw' . $username);

            if ($smsCode != $auth_code) {

                if (Mod::app()->memcache->get($username) < time()) {
                    return false;
                }
                if (!$auth_code) {
                    return false;
                } else {
                    return false;
                }
            } else if (Mod::app()->memcache->get($username) < time()) {
                return false;
            }

            return true;
        }


        if ($username && $upwd && (Tool::md5str($upwd, $member_info->source) == $member_info->password)) {
            return true;
        }

        return false;

    }


    function regmember($username, $smsCode, $pid)
    {
        //用户+验证码
        if ($username && $smsCode) {

            //验证手机号
            $pattern = '/^13[0-9]{9}$|14[0-9]{9}|15[0-9]{9}$|18[0-9]{9}$/';
            $match = preg_match($pattern, $username);
            if (!$match) {
                $result['info'] = '手机号格式错误';
                $result['status'] = -2;
                return json_encode($result);
            }


            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $username);

            if ($smsCode != $auth_code) {
                if (Mod::app()->memcache->get($username) < time()) {
                    $result['info'] = '此手机短信验证码已过期';
                    $result['status'] = -1;
                    return json_encode($result);
                }
                if (!$auth_code) {
                    $result['status'] = -5;
                    $result['info'] = '手机号不正确';
                    return json_encode($result);
                } else {
                    $result['status'] = 0;
                    $result['info'] = '短信验证码错误';
                    return json_encode($result);
                }
            } else if (Mod::app()->memcache->get($username) < time()) {
                $result['status'] = -1;
                $result['info'] = '短信验证码已过期';
                return json_encode($result);
            }

            //注册绑定新用户
            $member_model = new Member();
            $member_model->name = $member_model->phone = $username;
            $member_model->regtime = time();
            $member_model->regip = Mod::app()->request->userHostAddress;
            $member_model->status = 1;
            if ($member_model->save()) {
                $member_info = $member_model->attributes;
                $member_info['id'] = Mod::app()->db->getLastInsertID();
                $result['status'] = 1;
                $result['info'] = '注册成功';
                $result['member_info'] = $member_info;
                $this->regbehavior($member_info['id'], $pid);
                return json_encode($result);
            }


        }


    }

    /*
     * 绑定认证手机号
     * */
    public function actionbind()
    {
        if (Mod::app()->request->isAjaxRequest) {
            $phone = trim(Tool::getValidParam('account', 'string'));
            $codes = trim(Tool::getValidParam('codes', 'integer'));
            if (Mod::app()->session['state'] == "computer") {
                $return_url = $this->_siteUrl . '/project/prolist';
            } else {
                $return_url = Mod::app()->session['state'];
            }

            //验证用户名(手机合法性)
            $pattern = '/^1[3-9]+\\d{9}$/';
            $match = preg_match($pattern, $phone);
            if (!$match) {
                echo json_encode(array('state' => 0, 'message' => '手机号码不合法!'));
                exit;
            }

            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $phone);
            if ($codes != $auth_code || !$codes) {
                echo json_encode(array('state' => 0, 'message' => '验证码错误'));
                exit;
            }

            //检查手机号是否存在，是表示已经绑定，否表示没有绑定
            $res = Member::model()->find('phone=:phone', array(':phone' => $phone));
            if ($res) {

                if ($res->pstatus == 0 && Mod::app()->session['state'] == "computer") {
                    echo json_encode(array('state' => 0, 'message' => '该账号没有权限登录大楚开放平台，请联系管理员审核'));
                    exit;
                }
                //如果手机号存在，变更新数据
                $data['name'] = $phone;
                $data['phone'] = $phone;
                $data['sex'] = Mod::app()->session['newuser']['sex'];
                $data['province'] = Mod::app()->session['newuser']['province'];
                $data['city'] = Mod::app()->session['newuser']['city'];

                if (Mod::app()->session['newuser']['type'] == 'qq') {
                    $data['qqid'] = Mod::app()->session['newuser']['unionid'];
                } else {
                    $data['unionid'] = Mod::app()->session['newuser']['unionid'];
                }

                $data['headimgurl'] = Mod::app()->session['newuser']['headimgurl'];
                $results = Member::model()->updateByPk($res->id, $data);
                if ($results) {
                    //查找出来 写入session  进行登陆
                    $res = Member::model()->findByPk($res->id);
                    Mod::app()->session['member'] = $res->attributes;
                    echo json_encode(array('state' => 1, 'message' => '绑定成功', 'return_url' => $return_url));
                    exit;

                }
                echo json_encode(array('state' => 0, 'message' => '绑定失败'));
                exit;
            } else {
                //插入数据
                $user = Mod::app()->session['newuser'];
                $type = Mod::app()->session['newuser']['type'] ? 'qq' : '微信';
                $results = $this->actioninsertmember($user, $phone, $type);

                if ($results) {
                    //查找出来 写入session  进行登陆
                    $res = Member::model()->findByPk($results);
                    Mod::app()->session['member'] = $res->attributes;
                    echo json_encode(array('state' => 1, 'message' => '绑定成功', 'return_url' => $return_url));
                    exit;

                }
                echo json_encode(array('state' => 0, 'message' => '绑定失败!'));
                exit;
            }
        } else {
            $this->render('bind');
        }

    }

    /*
     * 当已经绑定过手机号之后给用户确认页面，手机号是否更改绑定，如果没有更改绑定直接跳到相应的页面*/
    public function actionupphone()
    {

        if (Mod::app()->session['state'] == "computer") {
            $return_url = $this->_siteUrl . '/project/prolist';
        } else {
            $return_url = Mod::app()->session['state'];
        }

        if (Mod::app()->request->isAjaxRequest) {
            $phone = trim(Tool::getValidParam('account', 'string'));
            $codes = trim(Tool::getValidParam('codes', 'integer'));
            $id = trim(Tool::getValidParam('id', 'integer'));

            //验证用户名(手机合法性)
            $pattern = '/^1[3-9]+\\d{9}$/';
            $match = preg_match($pattern, $phone);
            if (!$match) {
                echo json_encode(array('state' => 0, 'message' => '手机号码不合法!'));
                exit;
            }

            //短信验证码是否正确或已过期
            $auth_code = Mod::app()->memcache->get('dachuw' . $phone);
            if ($codes != $auth_code || !$codes) {
                echo json_encode(array('state' => 0, 'message' => '验证码错误'));
                exit;
            }

            //修改用户手机号
            $res = Member::model()->updateByPk($id, array('phone' => $phone));
            if ($res) {
                echo json_encode(array('state' => 1, 'message' => '登录成功', 'callback' => $return_url));
                exit;
            }

        } else {
            //获取该微信或者qq 所绑定的手机号

            $phone = "";
            $id = Mod::app()->session['member']['id'];
            if ($id) {
                $res = Member::model()->findByPk($id);
                $phone = $res->phone;
                //登录的行为
               Behavior::behavior_points(2, $id, Mod::app()->memcache->get('projectid'), "登录", "", Mod::app()->memcache->get('activityid'), Mod::app()->memcache->get('model'));
            }

            $this->render('upphone', array('phone' => $phone, 'callback' => $return_url, 'id' => $res->id));
        }
    }


    /*
     * 第三方登录 微信登录
     * 微信登录第一步 获取code*/
    public function actionWXgetcode()
    {
        //获取跳转地址 兼 匹配字符串
        $str = Tool::getValidParam('state', 'string');
        //去掉分享之后 微信带的参数
        $state = substr($str, 0, strpos($str, "?"));

        if (!$state) {
            Mod::app()->session['state'] = $str;
        } else {
            Mod::app()->session['state'] = $state;
        }


        $login_url = "https://open.weixin.qq.com/connect/qrconnect?appid=" . WXAPPID . "&redirect_uri=" . urlencode(REDIRECT_URI) . "&response_type=code&scope=snsapi_login&state=" . $_SESSION['state'] . "#wechat_redirect";
        header("Location:$login_url");
    }

    /*微信登录第二部，通过code 获取access_token*/
    public function actionWXgetaccesstoken()
    {
        $code = Tool::getValidParam('code', 'string');
        $state = Tool::getValidParam('state', 'string');
        if ($state != Mod::app()->session['state']) {

            echo $state;
            echo "Invalid state";
            echo Mod::app()->session['state'];
            exit;
        }

        if ($code) {//为真表示微信回调成功

            //根据这个参数判断来自于什么地方所注册的用户
            //可能来自三个地方，开发平台首页登录，组件页面登录，个人中心登录
            //首先查询组件表
            $sql = "SELECT * FROM {{activity}} WHERE status=1";
            $activity = Mod::app()->db->createCommand($sql)->queryAll();
            if($activity){
            foreach ($activity as $k => $v) {
                //如果能够匹配得到,并返回剩余部分
                $str = strstr($state, $v['activity_table_name']);
                if ($str) {
                    $arr = explode("/", $str);
                    //根据现有组件地址的尿性，组件后面肯定都会跟id
                    $idstr = strstr($str, "id");
                    $arrstr = explode("/", $idstr);
                    $aid = $arrstr[1];
                    $model = $arr[0];//返回的字符串转成数组之后第一个是组件名称
                    break;
                } else if ($state == "computer") {//如果为真肯定来自开发平台登录
                    $model = "computer";
                    $aid = -1;
                } else {//如果以上都为假说明来自用户中心
                    $model = "h5";
                    $aid = -5;
                }
            }
        } else {
            $model = "computer";
            $aid = -1;
        }

            //根据aid 查找pid
            //如果没有aid 表示是pc 或者h5 首页 注册登录的！ 默认是1
            if ($aid > 1) {
                //因为 刮刮卡 model 名字和控制器不统一 避免报错 所以做判断
                if($model=="scratchcard"){
                    $model="scratch";
                }

                //查找pid
                $model = "Activity_" . $model;
                $model =  ucfirst($model);
                $res = $model::model()->findByPk($aid);
                if ($res) {
                    $projectid = $res->pid ? $res->pid : 1;
                }
            } else {
                $projectid = 1;
            }
            Mod::app()->memcache->set('activityid',$aid);
            Mod::app()->memcache->set('model',$model);
            Mod::app()->memcache->set('projectid',$projectid);


            //如果token没有过期就直接去获取用户信息
            $token = Mod::app()->session['access_token'];
            $time = Mod::app()->session['access_token_time'];
            $openid = Mod::app()->session['openid'];
            //  判断token openid 是否过期  过期重新获取
            if ($token && $openid) {//$token && (time()-$time)<6800
                //获取用户信息
                $results = $this->actiongetuserinfo($model, $aid);
                if ($results) {
                    //登录成功之后 跳转绑定页面
                    $this->redirect('bind');
                }

            } else {
                //通过code去换取token
                $login_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . WXAPPID . "&secret=" . WXAPPKEY . "&code=" . $code . "&grant_type=authorization_code";
                $re = Tool::http_get($login_url);
                //如果为真 ，就把用户信息插入数据表
                //var_dump(json_decode($re,true));
                $accesstoken = json_decode($re, true);

                if (is_array($accesstoken)) {
                    //把token存入memcache
                    Mod::app()->session['access_token'] = $accesstoken['access_token'];
                    Mod::app()->session['access_token_time'] = time();
                    Mod::app()->session['openid'] = $accesstoken['openid'];

                    //获取用户信息
                    $results = $this->actiongetuserinfo($model, $aid);
                    if ($results) {
                        //登录成功之后 跳转绑定页面
                        $this->redirect('bind');
                    }
                }
            }
        } else {
            echo "Invalid code";
            exit;
        }
    }

    /*微信获取用户信息*/
    public function actiongetuserinfo($model = "", $aid = "")
    {
        //获取用户头像等信息
        $access_token = Mod::app()->session['access_token'];
        $openid = Mod::app()->session['openid'];
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
        $userinfo = Tool::http_get($url);
        $user = json_decode($userinfo, true);
        //当获取到用户信息的时候，插入数据库并写入session
        if (is_array($user)) {
            $user['model'] = $model;
            $user['aid'] = $aid;
            $this->actionuserSure($user['unionid'], $user);
        } else {
            echo "<h3>error:</h3>1000026";
            echo "<h3>msg  :</h3>数据错误，请重新请求";
            exit;
        }

    }

    /*
     * 微信获取用户信息之后的操作 */
    public function actionuserSure($unionid, $user)
    {
        //判断是否是老用户
        $state = Mod::app()->session['state'];
        $member = Member::model()->find('unionid=:unionid', array(':unionid' => $unionid));
        session_start();
        if ($member) {
            Mod::app()->session['member'] = $member->attributes;
            //登录的行为
            Behavior::behavior_points(2, $member->id, Mod::app()->memcache->get('projectid'), "登录", "", Mod::app()->memcache->get('activityid'), Mod::app()->memcache->get('model'));
            //检查有没有手机号，有没有认证，如果有直接跳管理中心页面
            if ($member->phone && $member->status && $member->pstatus) {
                if ($state == "computer") {
                    $this->redirect('/project/prolist');
                } else {//如果不是pc 还需要跳转 手机号确认页面 ，确认手机号是否更改
                    $this->redirect('/member/upphone');
                    // header("Location:$state");
                    exit;
                }
            } elseif ($member->pstatus == 0 && $state == "computer") {
                echo "<h3>error:</h3>1000025";
                echo "<h3>msg  :</h3>该账号没有权限登录大楚开放平台，请联系管理员审核！";
                exit;
            } elseif ($member->pstatus == 0 && $member->phone) {//表示是h5 用户
                // 跳转绑定页面
                Mod::app()->session['newuser'] = $member->attributes;
                $this->redirect('/member/upphone');
            } else {
                // 跳转绑定页面
                Mod::app()->session['newuser'] = $member->attributes;
                $this->redirect('bind');
            }
        } else {
            //如果早不到说明是新用户，先去绑定在插入
            Mod::app()->session['newuser'] = $user;
            $this->redirect('bind');
        }
    }


    /*
     * 把得到的用户插入用户表
     * $member 用户信息  array
     * $type   用户类型  string  微信或者QQ
    */
    public function actioninsertmember($member, $phone = 0, $type)
    {
        $member_model = new Member();
        $member_model->name = $type . '用户' . date('MDHi', time());
        $member_model->regtime = time();
        $member_model->regip = Mod::app()->request->userHostAddress;
        $member_model->status = $phone ? 1 : 0;
        $member_model->pstatus = 1;
        $member_model->phone = $phone;
        if ($type == "qq") {
            $member_model->qqid = $member['unionid'];
        } else {
            $member_model->unionid = $member['unionid'];
        }
        $member_model->headimgurl = $member['headimgurl'];
        $member_model->sex = $member['sex'];
        $member_model->province = $member['province'];
        $member_model->city = $member['city'];
        $member_model->username = $member['nickname'];
        $member_model->createtime = time();
        $member_model->updatetime = time();
        $member_model->save();
        $member_id = Mod::app()->db->getLastInsertID();
        $member_info = $member_model->attributes;
        $member_info['id'] = $member_id;


        //根据aid 查找pid
        //如果没有aid 表示是pc 或者h5 首页 注册登录的！ 默认是1
        if ($member['aid'] > 1) {
            $member['model']= str_replace("Activity_","",$member['model']);
            $model = "Activity_" . $member['model'];
            $model =  ucfirst($model);
            $res = $model::model()->findByPk($member['aid']);

            if ($res) {
                $pid = $res->pid;
            }else{
                $pid = 1;
            }

        }


        //绑定mid,openid,pid
        //写入member_project
        $member_project_model = new Member_project();
        $member_project_model->mid = $member_id;
        $member_project_model->pid = $pid;//原来是$projectinfo->id;，因为这个是在pc首页注册没办法得到pid  ，默认是储蓄罐！
        $member_project_model->status = 1;
        $member_project_model->openid = $member['openid'];
        $member_project_model->unionid = $member['unionid'];
        $member_project_model->createtime = time();
        $member_project_model->save();
        $member_project_id = Mod::app()->db->getLastInsertID();


        //写入 用户注册来源表
        $Member_activity = new Member_activity();
        $Member_activity->mid = $member_id;
        $Member_activity->aid = $member['aid'];
        $Member_activity->pid = $pid;
        $Member_activity->model = $member['model'];
        $Member_activity->createtime = time();
        $Member_activity->save();


        //注册的行为
        $this->regbehavior($member_model->id, $pid);
        if ($member_project_id && $member_id) {
            // session 存储用户
            Mod::app()->session['member'] = $member_info;
            // session 存储用户房钱关联的项目
            $member_project = array();
            $member_project['openid'] = $member['openid'];
            $member_project['pid'] = $pid;
            $member_project['mid'] = $member_info['id'];
            Mod::app()->session['member_project'] = $member_project;
            return $member_id;
        } else {
            return false;
        }
    }


    /*第三方登录 qq */

    public function actionqqlogin()
    {
        $appid = APPID;
        $scope = SCOPE;
        $callback = CALLBACK;
        $state = Tool::getValidParam('state', "string");//功能验证回调的时候是否被篡改，还有就是跳转地址！
        Mod::app()->session['state'] = $state; //CSRF protection
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id="
            . $appid . "&redirect_uri=" . urlencode($callback)
            . "&state=" . urlencode(Mod::app()->session['state'])
            . "&scope=" . $scope;
        //echo $login_url;
        header("Location:$login_url");
    }


    /*qq  回调方法*/

    public function actionqqcallback()
    {
        $state = Tool::getValidParam('state', 'string');
        if ($state == Mod::app()->session['state']) //csrf
        {
            //根据这个参数判断来自于什么地方所注册的用户
            //可能来自三个地方，开发平台首页登录，组件页面登录，个人中心登录
            //首先查询组件表
            $sql = "SELECT * FROM {{activity}} WHERE status=1";
            $activity = Mod::app()->db->createCommand($sql)->queryAll();
            if ($activity) {
                foreach ($activity as $k => $v) {
                    //如果能够匹配得到,并返回剩余部分
                    $str = strstr($state, $v['activity_table_name']);
                    if ($str) {
                        $arr = explode("/", $str);
                        //根据现有组件地址的尿性，组件后面肯定都会跟id
                        $idstr = strstr($str, "id");
                        $arrstr = explode("/", $idstr);
                        $aid = $arrstr[1];
                        $model = $arr[0];//返回的字符串转成数组之后第一个是组件名称
                        break;
                    } else if ($state == "computer") {//如果为真肯定来自开发平台登录
                        $model = "computer";
                        $aid = -1;
                    } else {//如果以上都为假说明来自用户中心
                        $model = "h5";
                        $aid = -5;
                    }
                }
            } else {
                $model = "computer";
                $aid = -1;
            }
            //根据aid 查找pid
            //如果没有aid 表示是pc 或者h5 首页 注册登录的！ 默认是1
            if ($aid > 1) {
                //因为 刮刮卡 model 名字和控制器不统一 避免报错 所以做判断
                if($model=="scratchcard"){
                    $model="scratch";
                }

                //查找pid
                $model = "Activity_" . $model;
                $model =  ucfirst($model);
                $res = $model::model()->findByPk($aid);
                if ($res) {
                    $projectid = $res->pid ? $res->pid : 1;
                }
            } else {
                $projectid = 1;
            }
            Mod::app()->memcache->set('activityid',$aid);
            Mod::app()->memcache->set('model',$model);
            Mod::app()->memcache->set('projectid',$projectid);


            //把state 存入 session 方便控制跳转
            if ($state == "computer") {
                Mod::app()->session['state'] = "computer";
            } else {
                Mod::app()->session['state'] = $state;
            }
            //获取accesstoken
            // if (!Mod::app()->session['wxaccess_token']) {
            $response = $this->actionaccesstoken(Tool::getValidParam('code', 'string'));
            // }
            //获取openid
            $openid = $this->actionget_openid();
            //如果获取到openid，检查该openid 是否绑定过
            if ($openid) {
                $res = Member::model()->find('qqid=:qqid', array(':qqid' => $openid));
                //为真表示 用户已经绑定过qq  就不需要获取用户信息了！ 直接进行登录步骤
                if ($res) {
                    Mod::app()->session['member'] = $res->attributes;
                    //检查有没有手机号，有没有认证，如果有直接跳管理中心页面,
                    if ($res->phone && $res->status && $res->pstatus) {
                        if ($state == "computer") {
                            //登录的行为
                            Behavior::behavior_points(2, $res->id, Mod::app()->memcache->get('projectid'), "登录", "", Mod::app()->memcache->get('activityid'), Mod::app()->memcache->get('model'));

                            $this->redirect('/project/prolist');
                        } else {//如果不是pc 还需要跳转 手机号确认页面 ，确认手机号是否更改
                            $this->redirect('/member/upphone');
                            // header("Location:$state");
                            exit;
                        }
                    } elseif ($res->pstatus == 0 && $state == "computer") {
                        echo "<h3>error:</h3>1000025";
                        echo "<h3>msg  :</h3>该账号没有权限登录大楚开放平台，请联系管理员审核！";
                        exit;
                    } elseif ($res->pstatus == 0 && $res->phone) {//表示是h5 用户
                        // 跳转绑定页面
                        Mod::app()->session['newuser'] = $res->attributes;
                        $this->redirect('/member/upphone');
                    } else {
                        // 跳转绑定页面
                        Mod::app()->session['newuser'] = $res->attributes;
                        $this->redirect('bind');
                    }
                } else {//如果为假，表示用户第一次用qq登录
                    //获取用户信息
                    $user = $this->actionget_user_info();
                    //组he数据
                    $data['sex'] = $user['gender'] == "男" ? 1 : 2;
                    $data['province'] = $user['province'];
                    $data['city'] = $user['city'];
                    $data['unionid'] = $openid;
                    $data['headimgurl'] = $user['figureurl_qq_1'];
                    $data['nickname'] = $user['nickname'];
                    $data['openid'] = $openid;
                    $data['type'] = 'qq';
                    $data['model'] = $model;
                    $data['aid'] = $aid;
                    Mod::app()->session['newuser'] = $data;
                    //新用户 登录 跳转到 绑定页面  通过时输入手机号检查 该用户是否存在
                    //
                    $this->redirect('bind');
                }
            }

        } else {
            echo $state . "==" . Mod::app()->session['state'];
            echo("The state does not match. You may be a victim of CSRF.");
            exit;
        }
    }


    /*qq  获取Accesstoken*/
    public function actionaccesstoken($code)
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . APPID . "&redirect_uri=" . urlencode(CALLBACK)
            . "&client_secret=" . APPKEY . "&code=" . $code;
        // $response = file_get_contents($token_url);  //服务器原因  PHP报错
        $response = Tool::http_get($token_url);
        if (strpos($response, "callback") !== false) {
            //file_put_contents('test.txt','获取token,'.$response,FILE_APPEND);
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
            $msg = json_decode($response);
            if (isset($msg->error)) {
                echo "<h3>err:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }
        $params = array();
        parse_str($response, $params);
        Mod::app()->session['wxaccess_token'] = $params["access_token"];
        return $response;

    }


    /*qq  获取用户openid*/
    public function actionget_openid()
    {
        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token="
            . Mod::app()->session['wxaccess_token'];

        $str = Tool::http_get($graph_url);
        if (strpos($str, "callback") !== false) {
            $lpos = strpos($str, "(");
            $rpos = strrpos($str, ")");
            $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
        }

        $user = json_decode($str);
        if (isset($user->error)) {
            echo "<h3>error:</h3>" . $user->error;
            echo "<h3>msg  :</h3>" . $user->error_description;
            exit;
        }

        Mod::app()->session['wxopenid'] = $user->openid;
        return $user->openid;
    }

    /*
     * qq  获取用户信息
     * */
    public function actionget_user_info()
    {
        $get_user_info = "https://graph.qq.com/user/get_user_info?"
            . "access_token=" . Mod::app()->session["wxaccess_token"]
            . "&oauth_consumer_key=" . APPID
            . "&openid=" . Mod::app()->session["wxopenid"]
            . "&format=json";

        $info = Tool::http_get($get_user_info);
        $arr = json_decode($info, true);
        if ($arr['ret'] != 0) {
            echo "<h3>error:</h3>" . $arr['ret'];
            echo "<h3>msg  :</h3>" . $arr['msg'];
            exit;
        }
        return $arr;
    }

    /*
     * 微信公众平台登录*
     *
     *第一步获取 code
     */
    public function actionWeixinLogin()
    {
        //获取跳转地址 兼 匹配字符串
        $str = Tool::getValidParam('state', 'string');
        //去掉分享之后 微信带的参数
        $state = substr($str, 0, strpos($str, "?"));

        if (!$state) {
            Mod::app()->session['state'] = $str;
        } else {
            Mod::app()->session['state'] = $state;
        }

        //如果 token 还有值的话 直接获取用户信息
        if (Mod::app()->session['weixin_access_token'] && Mod::app()->session['weixin_openid']) {
            $this->actionWeixinGetuserinfo();
        }
        $redirect_uri = $this->_siteUrl . "/member/Gettoken";
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . WEIXINAPPID . "&redirect_uri=" . $redirect_uri . "&response_type=code&scope=snsapi_userinfo&state=" . Mod::app()->session['state'] . "#wechat_redirect";
        header("Location:$url");
    }

    /*
    * 微信公众平台登录*
    *
    *第二步获取 token
    */
    public function actionGettoken()
    {
        $state = Tool::getValidParam('state', 'string');

        $code = Tool::getValidParam('code', 'string');
        /*        echo $state;
                echo "<br>====";
                echo Mod::app()->session['state'];exit;*/
        if ($state == Mod::app()->session['state']) {

            //根据这个参数判断来自于什么地方所注册的用户
            //可能来自三个地方，开发平台首页登录，组件页面登录，个人中心登录
            //首先查询组件表
            $sql = "SELECT * FROM {{activity}} WHERE status=1";
            $activity = Mod::app()->db->createCommand($sql)->queryAll();
            if($activity){
            foreach ($activity as $k => $v) {
                //如果能够匹配得到,并返回剩余部分
                $str = strstr($state, $v['activity_table_name']);
                if ($str) {
                    $arr = explode("/", $str);
                    //根据现有组件地址的尿性，组件后面肯定都会跟id
                    $idstr = strstr($str, "id");
                    $arrstr = explode("/", $idstr);
                    $aid = $arrstr[1];
                    $model = $arr[0];//返回的字符串转成数组之后第一个是组件名称
                    break;
                } else if ($state == "computer") {//如果为真肯定来自开发平台登录
                    $model = "computer";
                    $aid = -1;
                } else {//如果以上都为假说明来自用户中心
                    $model = "h5";
                    $aid = -5;
                }
            }
        } else {
            $model = "computer";
            $aid = -1;
        }

            //根据aid 查找pid
            //如果没有aid 表示是pc 或者h5 首页 注册登录的！ 默认是1
            if ($aid > 1) {

                //因为 刮刮卡 model 名字和控制器不统一 避免报错 所以做判断
                if($model=="scratchcard"){
                    $model="scratch";
                }

                //查找pid
                $model = "Activity_" . $model;
                $model =  ucfirst($model);
                $res = $model::model()->findByPk($aid);
                if ($res) {
                    $projectid = $res->pid;
                }else{
                    $projectid = 1;
                }
            } else {
                $projectid = 1;
            }
            Mod::app()->memcache->set('activityid',$aid);
            Mod::app()->memcache->set('model',$model);
            Mod::app()->memcache->set('projectid',$projectid);


            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . WEIXINAPPID . "&secret=" . WEIXINSECRET . "&code=" . $code . "&grant_type=authorization_code ";
            $re = Tool::http_get($url);
            $res = json_decode($re, true);
            if (!$res['errcode']) {
                Mod::app()->session['weixin_access_token'] = $res['access_token'];
                Mod::app()->session['weixin_openid'] = $res['openid'];
                //获取用户信息
                $this->actionWeixinGetuserinfo($model, $aid);
            }
        } else {
            echo "<h3>error:</h3> 100024";
            echo "<h3>msg  :</h3> invalid state...!";
            exit;
        }

    }

    /*
     * 微信公众平台登录*
     *
     *第三步获取 token
     */
    public function actionWeixinGetuserinfo($model = "", $aid = "")
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . Mod::app()->session['weixin_access_token'] . "&openid=" . Mod::app()->session['weixin_openid'] . "&lang=zh_CN";
        $res = Tool::http_get($url);
        $user = json_decode($res, true);
        if (!$user['errcode']) {//表示数据返回正常
            $user['model'] = $model;
            $user['aid'] = $aid;
            //根据返回的数据  unionid  去查找用户是否存在
            $this->actionuserSure($user['unionid'], $user);
            //return $user;
        }

    }
}
