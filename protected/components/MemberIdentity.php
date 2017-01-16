<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MemberIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
    	const ERROR_NONE=0;
	const ERROR_USERNAME_INVALID=1;
	const ERROR_PASSWORD_INVALID=2;
	const ERROR_UNKNOWN_IDENTITY=100;
	const ERROR_PSTATUS=9;
	const ERROR_STATUS=11;
        public $member_info;
        private $_id;



        public function authenticate($admin='')
	{
            //在这个地方来校验用户名和密码的真实性
            //首先来看看是否有此用户名存在
            //find() 如果没有查询出来数据，则会返回null
            //findAll()  空数据会返回空数组
            //根据用户名查询是否有一个用户信息

            if($admin){
             // $member_model = Member::model()->with('Membergroup')->find('t.name=:name  and t.status=1',array(':name'=>$this->username));
              $member_model = Member::model()->with('Membergroup')->find('(t.phone=:phone or t.name=:name)',array(':phone'=>$this->username,':name'=>$this->username));
//              file_put_contents('ttt.txt', var_export($member_model->attributes,1));
            }else{
             // $member_model = Member::model()->with('Membergroup')->find('t.name=:name and t.status=1',array(':name'=>$this->username));
              $member_model = Member::model()->with('Membergroup')->find('(t.phone=:phone or t.name=:name)',array(':phone'=>$this->username,':name'=>$this->username));
            }

            //如果用户名不存在
            if($member_model == null || empty($member_model)){
              // echo  $member_model->password ."!==". Tool::md5str($this->password,$member_model->source);
                $this ->errorCode = self::ERROR_USERNAME_INVALID;
            }/* else if ($member_model->password !== Tool::md5str($this->password,$member_model->source)){
                //密码判断
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }*/ else if ($member_model->pstatus ==0){
                //账号类型判断
                $this->errorCode=self::ERROR_PSTATUS;  //==9 表示 不是pc端注册用户不能登陆
            } else if ($member_model->status ==0){
                //审核状态判断
                $this->errorCode=self::ERROR_STATUS;  //==11 表示 没有通过审核
            }else {
                $this->errorCode=self::ERROR_NONE;
                $this->member_info = $member_model->attributes;
                $this->member_info['group_name'] = $member_model->Membergroup->name;
                $this->member_info['permission'] = $member_model->Membergroup->permission;
                $this->member_info['group_description'] = $member_model->Membergroup->description; 
                $this->_id = $member_model->id;
            }
            return !$this->errorCode;
            
	}
        
        
}