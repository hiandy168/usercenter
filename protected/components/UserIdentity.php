<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
        public $user_info;
        private $_id;



        public function authenticate($admin='')
	{
            //在这个地方来校验用户名和密码的真实性
            //首先来看看是否有此用户名存在
            //find() 如果没有查询出来数据，则会返回null
            //findAll()  空数据会返回空数组
            //根据用户名查询是否有一个用户信息

            if($admin){
              $user_model = User::model()->with('Usergroup')->find('t.name=:name and t.status=1',array(':name'=>$this->username));
//              file_put_contents('ttt.txt', var_export($user_model->attributes,1));
            }else{
              $user_model = User::model()->with('Usergroup')->find('t.name=:name and t.status=1',array(':name'=>$this->username));
            }

            //如果用户名不存在
            if($user_model === null){
                $this ->errorCode = self::ERROR_USERNAME_INVALID;
            } else if ($user_model->password !== Tool::md5str($this->password,$user_model->source)){
                //密码判断
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode=self::ERROR_NONE;
                $this->user_info = $user_model->attributes;
                $this->user_info['group_name'] = $user_model->Usergroup->name;
                $this->user_info['permission'] = $user_model->Usergroup->permission;
                $this->user_info['group_description'] = $user_model->Usergroup->description; 
                $this->_id = $user_model->id;
            }
            return !$this->errorCode;
            
	}
        
        
}