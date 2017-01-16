<?php
/**
 * 会员信息管理.
 *
 
 
 
 * @package       yiishop.model
 * @license       http://www.yiitian.com/license
 
 */

class ModelAccount extends B2cModel
{
    
    /**
     * ucenter_api 用户注册
     * @param type $account
     * @param type $password
     * @return type
     */
    public function Register($user,$password)
    {        
        //$get_url = Mod::app()->request->hostInfo.'/api/member/B2cLogin?name='.$user.'&pass='.$password;
        $url = Myconfig::DACHUHOST.'/api/member/B2cReg?name='.$user.'&pass='.$password;
        $obj = json_decode($this->http_get($url));   
        $user_info_member = $obj->result;        

        if ($obj->status == -1){
            return array('code'=>400,'msg'=>'用户名已存在');
        }
        if($obj->status == 1){
            Mod::app()->session['member_id'] = $user_info_member->member_id;
            Mod::app()->session['login_account'] = $user_info_member->login_account;
            Mod::app()->session['mobile'] = '';
            Mod::app()->session['email'] = '';
            Mod::app()->session['login_time'] = time();
            Mod::app()->session['ctime'] = $user_info_member->createtime;
            Mod::app()->session['points'] = $user_info_member->points;

            $data = array(
                'code'=>200,
                'msg'=>'用户注册成功',
                'member_id'=>$user_info_member->member_id,
                'member_name'=>$user_info_member->username,
                'login_time'=>time(),
                'ctime'=>$user_info_member->createtime,
                'url_ref'=>$this->UrlRef()
            );
            return $data;
        }
        if($obj->status == 0){
            return array('code'=>400,'msg'=>'用户注册失败');
        }
    }    
    
    
    /**
     * ucenter_api用户登录校验
     * @return array
     */
    public function Login($user,$password)
    {
        //$get_url = Mod::app()->request->hostInfo.'/api/member/B2cLogin?name='.$user.'&pass='.$password;
        $dachu = new Dachu(Myconfig::DACHUAPPID, Myconfig::DACHUAPPSKEY);
        $token=$dachu->Get_token();
        $url = Myconfig::DACHUHOST.'/api/member/B2cLogin?access_token='.$token['access_token'].'&name='.$user.'&pass='.$password;
        $data = json_decode($this->http_get($url));
        $user_info_member = $data->result;
    



        if ($data->status == -1)
        {
            return array('code'=>400,'msg'=>'用户不存在');      
        }         
        if ($data->status == 0)
        {
            return array('code'=>400,'msg'=>'密码错误');
        }
        Mod::app()->session['member'] = (array)$user_info_member;

        Mod::app()->session['member_project'] =  (array)$data->result_project;

        return array(
            'code'=>200,
            //'msg'=>$this->UrlRef(),
            'data'=>array(
                'member_id'=>$user_info_member->id,
                'member_name'=>$user_info_member->name,
                'login_time'=>time(),
                'ctime'=>$user_info_member->createtime,
                'timeout'=>3600*5,
            )
        );        
    }
    /**
     * 用户登录校验
     *
     * @param $user
     * @param $password
     * @return array
     */
    public function Login2($user,$password)
    {
        $user_info = $this->ModelQueryRow("SELECT * FROM {{pam_members}} WHERE login_account = '{$user}'");

        if (!$user_info) return array('code'=>400,'msg'=>'用户不存在');
        $user_info_member = $this->ModelQueryRow("SELECT member_id,mobile,email FROM {{b2c_members}} WHERE member_id = {$user_info['member_id']}");

        if ($user_info['login_password'] != $this->extends_md5($password,$user_info['login_account'],$user_info['createtime']))               
        {
            return array('code'=>400,'msg'=>'密码错误');
        }

        Mod::app()->session['member_id'] = $user_info['member_id'];
        Mod::app()->session['login_account'] = $user_info['login_account'];
        Mod::app()->session['mobile'] = $user_info_member['mobile'];
        Mod::app()->session['email'] = $user_info_member['email'];
        Mod::app()->session['login_time'] = time();
        Mod::app()->session['ctime'] = $user_info['createtime'];

        //合并购物车
//        $Cart = new WapCart();
//        $Cart->CartCacheInsert($user_info['member_id'],$Cart->CartProductSum($user_info['member_id']));

        return array(
            'code'=>200,
            //'msg'=>$this->UrlRef(),
            'data'=>array(
                'member_id'=>$user_info['member_id'],
                'member_name'=>$user_info['login_account'],
                'login_time'=>time(),
                'ctime'=>$user_info['createtime'],
                'timeout'=>3600*5,
            )
        );
    }

    /**
     * 用户注册
     *
     * @param $account
     * @param $password
     * @return array
     */
    public function Register2($account,$password)
    {
        $user_info_member = $this->ModelQueryRow("SELECT member_id FROM {{pam_members}} WHERE password_account = '{$account}'");
        if ($user_info_member) return array('code'=>400,'msg'=>'用户名已存在');

        $user_name = $account;
        $insert_time = time();
        $password = $this->extends_md5($password,$user_name,$insert_time);

        //$Point = new WapPoint();

        $transaction = Mod::app()->db->beginTransaction();
        try {
            //新增数据到会员信息主表：car_b2c_members
            $this->ModelInsert('{{b2c_members}}',array(
                'name'=>$user_name,
                'regtime'=>$insert_time,
                'cur'=>'CNY',
                'source'=>'pc',
                'tel'=>$account,
                'sex'=>'0',
                'member_lv_id'=>1,
            ));
            $member_id = Mod::app()->db->getLastInsertID();
            //新增数据到会员用户名、密码表：car_pam_members
            $this->ModelInsert('{{pam_members}}',array(
                'member_id'=>$member_id,
                'login_account'=>$account,
                'login_type'=>'mobile',
                'login_password'=>$password,
                'password_account'=>$account,
                'disabled'=>'false',
                'createtime'=>$insert_time
            ));
            //注册送积分
            //$Point->Register($member_id);

            $transaction->commit();

            Mod::app()->session['member_id'] = $member_id;
            Mod::app()->session['login_account'] = $user_name;
            Mod::app()->session['mobile'] = $account;
            Mod::app()->session['email'] = '';
            Mod::app()->session['login_time'] = time();
            Mod::app()->session['ctime'] = $insert_time;

            $data = array(
                'code'=>200,
                'msg'=>'用户注册成功',
                'member_id'=>$member_id,
                'member_name'=>$account,
                'login_time'=>$insert_time,
                'ctime'=>$insert_time,
                'url_ref'=>$this->UrlRef()
            );

            return $data;
        } catch(Exception $e) {
            $transaction->rollback();
            return array('code'=>400,'msg'=>'用户注册失败');
        }
    }

    /**
     * 找回密码
     *
     * @param $account
     * @param $password
     * @return mixed
     */
    public function FindPw($account,$password)
    {
        $user_info = $this->ModelQueryRow("SELECT * FROM car_pam_members WHERE login_account = '$account' AND login_type = 'mobile'");
        $user_name = $account;
        $insert_time = $user_info['createtime'];
        $password = $this->extends_md5($password,$user_name,$insert_time);
        if ($user_info['login_password'] == $password) return true;

        return $this->ModelEdit(
            'car_pam_members',
            array('login_account'=>$account,'login_type'=>'mobile'),
            array('login_password'=>$password)
        );
    }

    /**
     * 重置密码
     * @param $member_id
     * @param string $password
     * @return bool
     */
    public function resetPwd($member_id,$password)
    {
        $user_info = $this->ModelQueryRow("SELECT * FROM {{pam_members}} WHERE member_id = {$member_id}");
        $user_name = $user_info['login_account'];
        $insert_time = $user_info['createtime'];
        $password = $this->extends_md5($password,$user_name,$insert_time);
        return $this->ModelExecute("UPDATE {{pam_members}} SET login_password ='$password'
        WHERE member_id = {$member_id}");
    }

    /**
     * 返回页面
     *
     * @return mixed
     */
    public function UrlRef()
    {
        if (Mod::app()->session['url_referrer']) return Mod::app()->session['url_referrer'];
        return Mod::app()->request->urlReferrer;
    }
} 