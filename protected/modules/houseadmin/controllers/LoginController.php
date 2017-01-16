<?php

class LoginController extends LController {
    public function actionIndex() {
        $this->renderPartial('login_color');
    }

    public function actionLogin_old() {
        $this->renderPartial('login');
    }

    public function actionAjax_login() {
        $this_lang = Lang::getLang();
        $data['username'] = trim(Tool::getValidParam('username','string'));
        $data['password'] = trim(Tool::getValidParam('password','string'));
        if (!$data['username'] || !$data['password']) {
            echo json_encode(array('state' => 0, 'mess' => '用户名或者密码不能为空'));
            exit;
        }
        $verify = strtolower(trim($_POST['verify']));
        
        if ($verify == Mod::app()->session['verify_code']) {
            //初始化登陆模型
            $login_model = new LoginForm();
            $login_model->attributes = $data;
             
            if ($login_model->validate() &&  $login_model->login($this_lang)) {
                echo json_encode(array('state' => 1, 'mess' => '登录成功'));
            } else {
                echo json_encode(array('state' => 0, 'mess' => '用户名或者密码错误'));
            }
        } else {
            echo json_encode(array('state' => 0, 'mess' => '验证码错误'));
        }
    }

    function actionLogout() {
        Mod::app()->user->logout();
        unset(Mod::app()->session['admin_member']);
//        Mod::app()->session->clear();
//        Mod::app()->session->destroy();
        $url = Mod::app()->createAbsoluteUrl('houseadmin/login');
        echo '<script> top.location.href= "'.$url.'";</script> ';
        exit();
    }

    function actionVerify_image() {
//        echo Mod::getPathOfAlias('webroot').'/';
        $conf['name'] = 'verify_code'; //作为配置参数
        $conf['font'] = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'LiberationSans-Bold.ttf';
        $verify = new verify($conf);
        $verify->show();
        Mod::app()->session[$conf['name']] = $verify->get_randcode();
    }

//    function actionTest() {
//        $conf['name'] = 'verify_code'; //作为配置参数
//        $verify = new verify($conf);
//        echo $verify->get_lujing();
//    }

}
