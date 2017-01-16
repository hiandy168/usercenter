<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
        public $rememberMe;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// password needs to be authenticated
			array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
                'username'=>'用户名',
                'password'=>'密&nbsp;&nbsp;&nbsp;&nbsp;码',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
//	public function authenticate($attribute,$params)
//	{
//		if(!$this->hasErrors())
//		{
//			$this->_identity=new UserIdentity($this->username,$this->password);
//			if(!$this->_identity->authenticate())
//				$this->addError('password','Incorrect username or password.');
//		}
//	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login($lang='zh_cn')
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
                          
		}
                  
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{ 
                        Mod::app()->user->login($this->_identity,3600*24*7);  
                        $duration=$this->rememberMe ? 3600*24*7 : 0; // 7 days
                        $member = $this->_identity->member_info;
                        $member['token'] = Member::model()->get_member_token($member,$lang);
                        Mod::app()->session['member'] = $member;
			return true;
		}
		else{
                    return false;
                }
			
	}
}
