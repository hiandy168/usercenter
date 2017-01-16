<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RegForm extends CFormModel
{
	public $username;
	public $password;
        public $repassword;
        public $rememberMe;
        public $group_id;
        public $email;
        public $verify;
        public $agree;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
                
                return array(  
                        // username and password are required  
                        array('username, password, repassword, email', 'required'),  
                        array('username', 'length', 'max'=>20, 'min'=>2),  
                        array('username', 'checkname'),  
                        // 密码一致性验证  
                        array('repassword', 'compare', 'compareAttribute'=>'password','message'=>'两处输入的密码并不一致'),  
                        // 电子邮件验证  
                        //array('email', 'email'),
                        //array('email', 'checkemail'),
                        array('name,username','safe')
                 );  
    
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}

	public function update_reg_user($data){
        //$member_model = new Member();
        $member_model =Member::model()->findByPk($data['id']);
        //return array('state'=>0,'message'=>$data['openid']);
        //        exit;

        $return_url= Mod::app()->request->getHostInfo().'/test/demo/index';
        if($data['username'] &&$data['password'] )
		{
			$member_info = Member::model()->find('t.name=:name',array(':name'=>$data['username']));
                if(!empty($member_info)){
                    return array('state'=>0,'message'=>'用户已存在xx');
                    exit;
                }
                        
            $member_model->name = $member_model->tel = $data['name'];
            //$data['group_id'] = $data['group_id'];
//            $member_model->source = $data['source'] = Tool::random_keys(5);//随机生成5位字符串
            $member['password'] = $data['password'] = Tool::md5str($data['password'],$data['source']);
                        //$data['admin'] =  $data['status']= 1;
            $member['regtime'] = $data['regtime'] = time();
                        //$data['regip'] = Tool::get_ip();
            $member['regip'] = $data['regip'] = Mod::app()->request->userHostAddress;
            $member['status'] = 1;
            $res = Member::model()->updateByPk($data['id'],$member);
//            var_dump($data);exit;
                        if($res){
//                        Mod::import('application.vendors.*');  
//                                include_once '/../vendor/ucenter.php';
//                                $uid = @uc_user_register($this->username, $this->password, $this->email);
                               //return array('state'=>1,'message'=>'注册成功','login_url'=>'member/login');

                               //Mod::app()->session->add('reg', $member_model->name);
                               Mod::app()->session['member'] = array('mid'=>$member_model->id,'name'=>$member_model->name);
                               return array('state'=>1,'message'=>'注册成功','login_url'=>$return_url);
                               exit;
					    }else{
                               return array('state'=>0,'message'=>'注册失败');
                               exit;
                        }
                            

                        
		}
                  	
	}

    public function reg_member_api($data)
    {

        $member_model = new Member();

        if ($data['access_token'] && $data['tel'] && $data['openid']) {
            $Project_token = Project_token::model()->find('t.access_token=:access_token', array(':access_token' => $data['access_token']));
            if (!$Project_token) {
                return array('state' => 100003, 'message' => '商户不存在');
                exit;
           } // else if ($Project_token->expires_in > time()) {
//                return array('state' => 100004, 'message' => 'access_token已过期');
//                exit;
//            }

            $data['pid'] = Project_token::getPid($data['access_token']);

            $member_info=$member_model->getMemberIsNull($data['tel']);

            //用户关系绑定openid+pid+mid
            $member_project_model=new Member_project;
            $member_project_model->openid=$data['openid'];
            $member_project_model->pid=$data['pid'];

            //查下手机号码用户是否存在
            if ($member_info['id']) {
                //绑定用户关系
                $count=$member_project_model->countByAttributes(array('mid'=>$member_info['id'],'pid'=>$data['pid']));
                if(!$count){
                    $member_project_model->mid=$member_info['id'];
                    $member_project_model->createtime=time();
                    $member_project_model->status=1;
                    if($member_project_model->save()){
                        return array('state' => 1, 'message' => '注册成功');
                        exit;
                    }
                    else{
                        return array('state' => 100006, 'message' => '注册失败');
                        exit;
                    }
                }
                else{
                    return array('state' => 100007, 'message' => '用户已存在');
                    exit;
                }

            } else {

                //注册用户并绑定关系
                $data['source'] = Tool::random_keys(5);//随机生成5位字符串
                $data['password'] = Tool::md5str($data['password'], $data['source']);
                $data['admin'] = 0;
                $data['regtime'] = time();
                $data['regip'] = Mod::app()->request->userHostAddress;
                $member_model = new Member('create');
                $member_model->attributes = $data;


                $transaction=Mod::app()->db->beginTransaction();
                try {
                    $member_model->save();
                    $member_project_model->mid = $member_model->attributes['id'];
                    $member_project_model->createtime=time();
                    $member_project_model->status=1;
                    $member_project_model->save();
                    $transaction->commit();
                    return array('state' => 1, 'message' => '注册成功');
                    exit;
                }
                catch(Exception $e){
                        $transaction->rollback();
                        return array('state' => 100006, 'message' => '注册失败');
                        exit;
                    }
                }
            }
    }


    public function checkname($attribute,$params)  
    {  
        //ucenter  
        Mod::import('application.vendors.*');  
        include_once dirname(__FILE__).'/../vendor/ucenter.php'; 
        $flag = uc_user_checkname($this->username); 
        switch($flag)  
        {  
            case -1:  
                $this->addError('username', '用户名不合法');  
                break;  
            case -2:  
                $this->addError('username','包含不允许注册的词语');  
                break;  
            case -3:  
                $this->addError('username','用户名已经存在');  
                break;  
        }  
    }  
      
    public function checkemail($attribute,$params)  
    {  
        //ucenter  
//        Mod::import('application.vendors.*');  
          include_once dirname(__FILE__).'/../vendor/ucenter.php'; 
        $flag = uc_user_checkemail($this->email);  
        switch($flag)  
        {  
            case -4:  
                $this->addError('email', 'Email 格式有误');  
                break;  
            case -5:  
                $this->addError('email','Email 不允许注册');  
                break;  
            case -6:  
                $this->addError('email','该 Email 已经被注册');  
                break;  
        }  
    }  
    
        
}
