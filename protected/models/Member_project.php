<?php

class Member_project extends CActiveRecord {

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
        return '{{member_project}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('openid,mid,pid,createtime,status','safe'),
        );
    }

    public function relations(){
        return array(
            'minfo'=>array(self::BELONGS_TO,'Member', '' ,'on'=>'t.mid=minfo.id')
        );
    }
    
    public function getMemberInfo($id)
    {
        $dbUser = self::model()->findByPk($id);
        $result = array();
        if ($dbUser) {
            $result = $dbUser->attributes;
        }
        return $result;
    }

    public function createMember($openid,$pid){
        $member_project=self::model()->findByAttributes(array('openid'=>$openid,'pid'=>$pid));
        $mid= $member_project->mid;
        if(!$member_project){
            //创建临时用户
            $data['phone']=$data['name']=0;//'1'.mt_rand(3,9).mt_rand(10000,99999).mt_rand(1000,9999);
            $data['regtime']=time();
            $data['status']=0;
            $member_model = new Member();
            $member_model->attributes = $data;
            $member_model->save();
            //绑定openid
            $member_project_model=new Member_project;
            $mid = $member_project_model->mid = $member_model->attributes['id'];
            $member_project_model->pid = $pid;
            $member_project_model->openid = $openid;
            $member_project_model->createtime = time();
            $member_project_model->status = 1;
            $member_project_model->save();
        }
        return $mid;
    }
 
    /**
     * 用户是否合法并且登录状态
     * @param string $openid openid
     * @param int $pid 项目Id
     * @param int $mid 用户Id
     */
    public static  function meberIsLogin($openid,$appid,$appkey){
        $mid = 0;      
        if(!empty($openid) && !empty($appid) && !empty($appkey)){
            $pid = Project::checkAppKey($appid,$appkey);
            if(!$pid){
                $mid = -1;
            }
            if(!empty($openid) && !empty($pid)){
                $mid = $member_project_info = self::model()->findByAttributes(array('pid'=>$pid,'openid'=>$openid)); 
            }       
        }
        
       return $mid;
    }

    /**
     * 判断Member_Project中是否存在用户记录
     * @param string $mid
     * @param string $appid
     * @param string $appsecret
     * @param string $openid
     */
    public static function memberIsBind($mid,$appid,$appsecret,$openid){
        $result = false;
        if(!empty($mid) && !empty($appid) && !empty($appsecret) && !empty($openid)){
          
            $project_model = new Project();
            $member_project_model = new Member_project(); 
            
            $project_info = $project_model->findByAttributes(array('appid'=>$appid,'appsecret'=>$appsecret));
             
            if($project_info){                
                $member_project_info = $member_project_model->findByAttributes(array('mid'=>$mid,'pid'=>$project_info->id,'openid'=>$openid));            
                if(!$member_project_info){                 
                    $member_project_model->mid = $mid;
                    $member_project_model->pid = $project_info->id;
                    $member_project_model->openid = $openid;
                    $member_project_model->createtime = time();
                    //添加一条记录
                    if($member_project_model->save()){
                         $result = TRUE;
                    }                  
                }else{
                    //存在记录
                    $result = TRUE;
                }
            }
        }
        
        return $result;
    }
    
    /**
     * 判断用户是否合法
     * 
     * @param type $appid
     * @param type $appkey
     * @param type $openid
     * @return object 用户信息
     */
    public static function memberIslegal($appid,$appsecret,$openid){
       
        $memInfo = null;
        if(!empty($appid) && !empty($appsecret) && !empty($openid)){
            $pInfo = Project::model()->findByAttributes(array('appid'=>$appid,'appsecret'=>$appsecret));
            if($pInfo){
                $mPro = Member_project::model()->findByAttributes(array('pid'=>$pInfo->id,'openid'=>$openid));
                if($mPro){
//                    $memInfo =  Member::model()->findByAttributes(array('id'=>$mPro->mid));

                    $memInfo = Member::model()->findByPk($mPro->mid);
                    Mod::app()->session['openid']=$openid;
                    Mod::app()->session['appid']=$appid;
                    Mod::app()->session['appsecret']=$appsecret;
                    Mod::app()->session['member_id']=$mPro->mid;
                    Mod::app()->session['login_account']=$memInfo['name'];
                    Mod::app()->session['mobile'] = $memInfo['phone'];
                    Mod::app()->session['email'] = $memInfo['email'];
                    Mod::app()->session['login_time'] = time();
                    Mod::app()->session['ctime'] = $memInfo['createtime'];
                    Mod::app()->session['points'] = $memInfo['points'];
                    Mod::app()->session['member'] = $memInfo;

                }
            }            
        }
        
        return $memInfo;
    }
}
