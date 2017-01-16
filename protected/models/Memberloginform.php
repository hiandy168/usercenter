<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Memberloginform extends CFormModel
{
    public $username;
    public $password;
    public $reuserMe;
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
            array('reuserMe', 'boolean'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => '用户名',
            'password' => '密&nbsp;&nbsp;&nbsp;&nbsp;码',
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
    public function login($lang = 'zh_cn')
    {
        if ($this->_identity === null) {
            $this->_identity = new MemberIdentity($this->username, $this->password);
            $this->_identity->authenticate(1);

        }

        if ($this->_identity->errorCode === MemberIdentity::ERROR_NONE) {


//                     Yii::app()->user->login($this->_identity);  
            // 保留用户登陆状态时间7天
            // 确保用户部件的allowAutoLogin被设置为true。
            // Yii::app()->user->login($this->_identity,85400*7);
            // Yii::app()->user->logout();

            $duration = $this->reuserMe ? 85400 * 7 : 0; // 7 days
            $member = $this->_identity->member_info;
            $member['token'] = Member::model()->get_member_token($member, $lang);
            Mod::app()->session['member'] = $member;
            return $member;
        } else if($this->_identity->errorCode==9) {
            return 9;//不是pc 注册的用户。不能登录
        }else if($this->_identity->errorCode==1) {
            return 1;//用户不存在
        }else if($this->_identity->errorCode==11) {
            return 11;//没有通过审核的用户不能登录
        }else{
            return fasle;

        }

    }
}
