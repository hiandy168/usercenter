<?php
/**
 * 用户中心
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class AccountController extends B2cController
{
    /**
     * 会员中心首页
     */
    public function actionIndex()
    {
        $this->CheckLogin();

        //最近的订单
        $Order = new ModelOrder();
        $model['order_list'] = $Order->items('order_id,final_amount,createtime,status,pay_status',"member_id = {$this->member_id}");
        $this->render('index',array('model'=>$model));
    }

    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $this->render('login',array('referer'=> $_SERVER['HTTP_REFERER']));
    }

    /**
     * 用户名、密码、验证
     */
    public function actionLogincheckall()
    {
        $user_name = Tool::getValidParam('username');
        $password = Tool::getValidParam('password');

        $User = new ModelAccount();
        $result = $User->Login($user_name,$password);

        echo json_encode($result);
    }

    /**
     * 用户注册
     */
    public function actionRegister()
    {
        $this->render('register');
    }

    /**
     * 用户注册提交
     */
    public function actionRescheckall()
    {
        $account = Tool::getValidParam('username');
        $password = Tool::getValidParam('password');

        $Register = new ModelAccount();
        $result = $Register->Register($account,$password);

        echo json_encode($result);
    }

    /**
     * 重置密码
     */
    public function actionReset()
    {
        $this->CheckLogin();
        $this->render('reset');
    }

    /**
     * 重置密码
     */
    public function actionResetcheck()
    {
        $this->CheckLogin();
        $pwd = Tool::getValidParam('password');

        $user = new ModelAccount();
        if(empty($pwd) || mb_strlen($pwd,'utf-8')<6 || mb_strlen($pwd,'utf-8')>20) {

        }

        if (!$user->resetPwd($this->member_id,$pwd)) {
            echo json_encode(array('code'=>400,'msg'=>'密码重置失败'));
            die;
        }

        echo json_encode(array('code'=>200,'msg'=>'密码重置成功'));
    }

    /**
     * 用户退出
     */
    public function actionLogout()
    {
        $this->CheckLogin();
        unset(Mod::app()->session['member_id']);
        unset(Mod::app()->session['login_account']);
        unset(Mod::app()->session['mobile']);
        unset(Mod::app()->session['email']);
        unset(Mod::app()->session['login_time']);
        unset(Mod::app()->session['ctime']);
        unset(Mod::app()->session['b2c_member_total_num']);

        $this->redirect('/');
    }
}