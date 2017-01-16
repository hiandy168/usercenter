<?php

class Member extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{member}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,company,password,phone,group_id,regip,regtime,source,status,isperson,createtime','safe'),
        );
    }
    
    public function relations()
    {
        return array(
//            'membergroup'=>array(self::HAS_ONE, 'membergroup', 'group_id'),
           'Membergroup'=>array(self::BELONGS_TO, 'Membergroup', 'group_id'),
        );
    }
    
        
     function get_member_token($member,$lang='zh_cn'){
              if(isset($member) && !empty($member)){
                    $sql = "select * from {{setting}} where `name`='site_safe_code' and  `lang`='".$lang."'";
                    $res_setting =  Mod::app()->db->createCommand($sql)->queryRow();
                    $cmskey= isset($res_setting['value'])?$res_setting['value']:'9open';
                    return  md5(base64_encode($member['id'].$member['name'].$member['password'].$cmskey));
                }else{
                     return false;
                }
    }
         
    static function getMemberByopenid($openid=''){
            if($openid){
                    //根据uin获取uid
                    $member=Member::model()->find('openid="'.$openid.'"')->attributes;
                    //如果uin对应的uid不存在，添加
                    if(!$member){
                       $member_model = new Member;
                       $member=$member_model->savedata(array('openid'=>$openid,'createtime'=>time()));
                    }
                    return $member;
            }
    }
    
    public static function getMemberIsNull($name){
        $memberInfo=array();
        if($name){
            $memberInfo=self::model()->find('t.name=:name',array(':name'=>$name));
        }
        return $memberInfo;
    }

    /*
     * 查询单条或者多条数据*/
    public function select($id="",$phone="",$name=""){
        $memberInfo=array();
        if(!$id && !$phone && !$name){
            $memberInfo=self::model()->select();
        }
        if($name){
            $memberInfo=self::model()->find('t.name=:name',array(':name'=>$name));
        }
        return $memberInfo;
    }
    
    	/**
	 * 保存数据
	 * @param array $data array(key=>value)
	 * @return int 成功返回记录id，失败返回0
	 */
	public function savedata($data){
		$attributes=array();
		foreach($data as $key=>$value){
			$this->$key=$value;
			$attributes=$key;
		}
		if( $this->save(true,$attributes) ){
                    $member = $this->attributes;
                    $member['id'] = $this->id;
                    return $member;
                }else{
                    return NULL;
                }
	}
        
        /**
         * 发送短信验证码
         * @param  string $mobile  手机号
         * @return string $auth_code 短信码
         */
        public static function  SendMessage($mobile){
         $resultCode = array('info'=>'','status'=>'');  
         $mobile = trim(Tool::getValidParam('mobile','string'));
         if($mobile){
            $domain = 'http://esf.hb.qq.com';
            $params = '/c=dachu&m=sms';
            $postUrl = $domain.$params;
            $postData = array(
                'auth_code' => '9z!d4vibm$kjc3n',
                'mobile' => $mobile,
                'memPrefix' => 'ucenter_dachuw_binding_sms',
                'userID' => time().mt_rand(10000, 99999),
            );

            $tmpSmsResponseData = Tool::http_post($postUrl,$postData,$domain);
            $returnCode = json_decode($tmpSmsResponseData)->data;
            
            $auth_code = $returnCode->auth_code;           
            $expire = $returnCode->expire; //接口默认过期时间15分钟
            if($auth_code){ 
                //返回短信码存入Memcache
                Mod::app()->memcache->set('dachuw'.$mobile,$returnCode->auth_code,$expire);              
                //短信验证码过期时间
                Mod::app()->memcache->set($mobile,time()+$expire,0);
                $resultCode['info'] = '发送成功';
                $resultCode['status'] = 1;  
            }
            else{
                $resultCode['info'] = '发送失败';
                $resultCode['status'] = 0;                  
            }                        
         }
         else{
                $resultCode['info'] = '手机号为空';
                $resultCode['status'] = -1;                
         }
        
        return $resultCode; 
    }
    
    public  static function checkIsLogin($member){
       if(!$member){
            member::redirect('login');
            exit;
        }
    }



}
