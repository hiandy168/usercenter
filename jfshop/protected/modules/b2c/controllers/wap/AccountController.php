<?php
/**
 * 用户中心
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class AccountController extends B2cController
{
    
    public $layout=false;
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
        //进入这个方法表示用户是未登录状态

        //广播登录状态
        $token=Tool::getValidParam('token');
        $sid=Tool::getValidParam('sid');
        $ticket=Tool::getValidParam('ticket');
        if(isset($token) && isset($sid) && !empty($token) && !empty($sid) && isset($ticket) && !empty($ticket)){
            header("P3P: CP=CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR");
            setcookie("session_token", $token, time()+60*60*24*30);
            setcookie("PHPSESSID", $sid, time()+60*60*24*30);
            setcookie("ticket", $ticket, time()+60*60*24*30);
            session_id($sid); //设置$se位session_id
            session_start(); //开启sesseion ，注意不能与上一步对调，da工告成
        }elseif($_COOKIE['ticket']){//session过期，用票据去换取
                //其实目的是重新写一次session，也就是重新设定phpsessionid
           $ticket= $_COOKIE['ticket'];
            echo  '<script type="text/javascript" src="'.Mod::app()->request->hostInfo .'/sso/client/checkTicket/ticket='.$ticket.'" reload=1></script>';
            $re= $this->serverCmd(Mod::app()->request->hostInfo ."/sso/client/checkTicket",array('ticket'=>$ticket));
            if($re){
                header("location:".getenv('HTTP_REFERER'));   //   返回其调用页面
            }
        }else{
            //如果检测到未登录
            header("Location: ".Mod::app()->request->hostInfo ."/h5/member/login/?jump=".urlencode(Mod::app()->request->hostInfo .'/jfshop/b2c/wap/default/index'), true, 307);
        }




        //$this->render('login',array('referer'=> $_SERVER['HTTP_REFERER']));
    }


    /**
     * 执行CURL请求
     *
     * @param string $cmd Command
     * @param array $vars Post variables
     * @return array
     *
     */
    protected function serverCmd($url, $data)
    {

        $ch = curl_init(); //初始化curl

        curl_setopt($ch, CURLOPT_URL, $url);//设置链接

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设置是否返回信息

        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//设置HTTP头

        curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据

        $response = curl_exec($ch);//接收返回信息
        return $response;

    }




    /**
     * 用户名、密码、验证
     */
    public function actionLogincheckall()
    {
        $user_name = Tool::getValidParam('username');
        $password = Tool::getValidParam('password');

//        http://m.hb.qq.com/api/member/B2cLogin?name=15997567510&pass=888888
            
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
     * 积分兑换记录
     */
    public function actionOrder_jflog()
    {
        if (!$this->username) $this->redirect($this->_siteUrl."/b2c/wap/account/login");
        //更改session积分值
//        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
//        echo $dachu->Get_token();exit;
        $res = $this->dachu->getmemberpointslog($this->member_id);
        $arr=array();
        if($res['code']==200){
           $arr=$res['data'];
        }


        $count_all=0;
        $Order = new ModelOrder();
        $model['order_id_list'] = $Order->items('order_id,score_u,createtime',"member_id = {$this->member_id}");
        foreach ($model['order_id_list'] as $v) {
            if( $v['score_u']>0) {
                $arrs=$Order->GetPro($v['order_id'],'a.createtime,a.quantity,b.name,b.goods_id,b.image_default_id');
                foreach ($arrs as $val){
                    $count_all+=$val['quantity'];

                }
            }
        }

        $this->render('order_jflog',array("info"=>$arr,'count_all'=>$count_all));
    }
    /**
     * 积分兑换记录
     */
    public function actionOrder_jf()
    {
        if (!$this->username) $this->redirect($this->_siteUrl."/b2c/wap/account/login");

        $count_all=0;
        $Order = new ModelOrder();
        $model['order_id_list'] = $Order->items('order_id,score_u,createtime',"member_id = {$this->member_id}");
        foreach ($model['order_id_list'] as $v) {
            if( $v['score_u']>0) {
                $arr=$Order->GetPro($v['order_id'],'a.createtime,a.quantity,b.name,b.goods_id,b.image_default_id');
                foreach ($arr as $val){
                    $count_all+=$val['quantity'];

                }
            }
        }
        $this->render('order_jf',array('count_all'=>$count_all));
    }

    /**
     * 积分兑换记录加载
     */
    public function actionAjaxorder_jf(){
//        $page = 1;
        //最近的订单
        $Order = new ModelOrder();
        $model['order_id_list'] = $Order->items('order_id,score_u,createtime',"member_id = {$this->member_id}");
        $model['order_list']=array();
        foreach ($model['order_id_list'] as $v) {
            if( $v['score_u']>0) {
                $arr=$Order->GetPro($v['order_id'],'a.createtime,a.quantity,b.name,b.goods_id,b.image_default_id');
                foreach ($arr as $val){
                    $arr_one=$val;
                    $arr_one['order_id']=$val['order_id'];
                    $arr_one['img']=$Order->ImageDeafultId($val['image_default_id']);
                    $arr_one['cr_time']=date('Y-m-d',$val['createtime']);
                    $model['order_list'][] = $arr_one;
                }
            }
        }
        $pagecount=count($model['order_list']);
        $ys=ceil($pagecount/5);

        $on = false;
        if($_POST['page']){
            $page = Tool::getValidParam('page','int');
            $on = Tool::getValidParam('one');

        }

        if($on){
            $startlimit = 0;
            echo json_encode(array('code'=>200,'data'=>array_slice($model['order_list'],$startlimit,5*$page)));
            die;
        }

            $startlimit = ($page - 1) * 5 ;
            if($ys>=$page) {echo json_encode(array('code'=>200,'data'=>array_slice($model['order_list'],$startlimit,5))); die;}
            echo json_encode(array('code'=>400,'mess'=>'已是最后一页啦'));




//        echo "<pre>";
//        var_dump($model['order_list']);
//        exit;
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
        unset(Mod::app()->session['points']);
        unset(Mod::app()->session['member']);
        $this->redirect('/');
    }
}