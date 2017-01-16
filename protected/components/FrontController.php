<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class FrontController extends CController {

    /**
     * @var string the def ault layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = false;
   
//    public  $layout='//layouts/admin';
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */


    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    protected $pid;
    protected $site_title;
    protected $active_1;
    protected $active_2;
    protected $active_3;
    protected $_baseUrl;
    protected $_wwwPath;
    protected $_siteUrl;
    protected $_theme_url;
    protected $lang;
    protected $cache_type;
    protected $site_config;
    protected $alias;
    protected $member;//登录的用户信息
//    protected $project;//登录的用户当前应用
    protected $member_project;//登录的用户当前应用以及openid信息  仅当注册登录时采用 其他时候查数据库表
    protected $error_code;

    public function init() {
        parent::init();
//         if(!in_array(Mod::app()->request->userHostAddress,array('127.0.0.1','111.47.243.43','14.17.22.54','27.17.15.94','183.61.38.182'))){die('非法的IP访问地址');}
//        $this->_baseUrl = (Mod::app()->baseUrl?Mod::app()->baseUrl:'').'/';
        $this->_baseUrl = Mod::app()->baseUrl;
        $this->_siteUrl = Mod::app()->request->hostInfo.Mod::app()->request->baseUrl;
        $this->_wwwPath = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
//        $this->_wwwPath = str_replace(array('\\', '\\\\'), DIRECTORY_SEPARATOR, dirname(__FILE__));
        $this->check_install(); //检查是否被安装
        $this->lang = Lang::getLang('front');
        $this->site_config = JkCms::SiteConfig();
        Mod::app()->setTheme(!$this->site_config['site_template']?$this->site_config['site_template']:'new');//设置视图路径
        $this->_theme_url = Mod::app()->theme->baseUrl.'/';
        $this->member = Mod::app()->session['member'];
//        $this->member['id'] = 77943;
//        $this->member['pstatus']  = 1;
        
        $this->member_project = Mod::app()->session['member_project'];
        $this->error_code =   Tool::geterroecode();
        header("Content-type: text/html; charset=utf-8");

    }

    //检测系统是否已经安装
    public function check_install() {
        if(!is_file($this->_wwwPath.'data'.DIRECTORY_SEPARATOR.'install.lock'))
            $this->redirect(array('/install'));
    }

    /* 关闭状态 */
    protected function _closed() {
        $this->render('/error/close', array('message' => '本站关闭中'));
        exit;
    }

    function message($content,$target_url = '', $delay_time = 0,$script='') { 
        if ($delay_time < 0)
            $delay_time = 0;
        $data = array('content' => $content, 'target_url' => $target_url, 'delay_time' => $delay_time,'script'=>$script);
        $message = $this->renderPartial('/message', $data, true);
        echo $message;
        exit;

    }


    
   /**
     * 检查openid和pid的绑定关系,是否有手机号
     * 
     * @return  有绑定返回手机号,没有绑定返回0
     */
    public function checkUserbypidopenid($pid,$openid){
      
       
       $returnCode = array('result'=>false,'status'=>0,'phone'=>'','message'=>'');    


 
            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$pid,'openid'=>$openid));
            if($member_project_info){
                $member_info = Member::model()->findByPk($member_project_info->mid);               
                if($member_info){
                    $returnCode['status'] = 1;
                    $returnCode['mid'] = $member_info['id'];
                    $this->member = Mod::app()->session['member'] = $member_info;
                }else{
                    $returnCode['status'] = 0;
                }
            }else{
                    $returnCode['status'] = 0;
            } 
    
       
       // echo json_encode($returnCode);    
       return $returnCode;
   }

    /**
    * 检查openid和pid的绑定关系,是否有手机号
    * 
    * @return  有绑定返回手机号,没有绑定返回0
    */
    public function checkToken($pid,$token){
        
        $ken = Mod::app()->memcache->get("project_access_token_".$pid);
        if($ken === $token){
            return 1;
        }else{
            return false;
        }
    }
 
   public function actionCheckUser(){
       $openid = Tool::getValidParam('openid','string');
       $appid = Tool::getValidParam('appid','string');
       $appsecret = Tool::getValidParam('appsecret','string');
       
       $returnCode = array('result'=>false,'status'=>0,'phone'=>'','message'=>'');    

       $project_info = Jkcms::getProjectByidsecret($appid,$appsecret);

       //验证appid,appsecret是否合法
       if($project_info){   
            $member_project_info = Member_project::model()->findByAttributes(array('pid'=>$project_info['id'],'openid'=>$openid));
            if($member_project_info){
                $member_info = Member::model()->findByPk($member_project_info->mid);               
                if($member_info){
                    $returnCode['result'] = true;
                    $returnCode['status'] = 1;
                    $returnCode['phone'] = $member_info->phone;
                    $returnCode['message'] = '手机号已绑定';
                }
            } 
       }
       else{
           $returnCode['message'] = '非法请求';
       }
       
       // echo json_encode($returnCode);    
       return $returnCode['status'];
   }
        
    public function check_waporwap(){
        if(Checkwap::check_wap()){
               return "wap";
        }else{
               return "web";
        }
    }
    
    //注册行为
    public function regbehavior($mid,$pid){
        //插入行为表(注册得积分)
        $win = 0;
        $name = "";

        $res = Behavior::behavior_points(1, $mid, $pid, $name, $win, 0, 'null');
        if ($res['code'] == 200) {
            $jifen = array(
                'pid' => $pid,
                'mid' => $mid,
                'qty' => $res['points'],
                'type' => 1,
                'createtime' => time(),
                'content' => '注册',
            );
            $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);
        }
    }

    //注册行为
    public function activity_status($table_name){
        $sql = "SELECT * FROM dym_activity  WHERE  activity_table_name='".$table_name."'";
        $res_check=Mod::app()->db->createCommand($sql)->queryRow();
        return $res_check;
    }

    public function activity_permissions($table_name){
//       var_dump( $_GET['pid']);
//        $pid=$_GET['pid'];
     $pid=  Tool::getValidParam('pid','integer');
        if($pid){
            $sql = "SELECT * FROM dym_activity_project_relation a,dym_activity b WHERE  a.activity_id=b.id and  a.pid=".$pid." and  b.activity_table_name='".$table_name."'";
            $res_check=Mod::app()->db->createCommand($sql)->queryRow();
//            return $res_check['status'];
                if ($res_check['status'] == 2 ) {
                    return false;
                } else {
                    return true;
                }
            
        }
            return true;


    }


    /*我的消息*/
    public function my_message($title,$datetime,$result,$pid,$url,$tablename){
  /*      $arr['title']=$title;
        $arr['datetime']=$datetime;
        $arr['result']=$result;
        $arr['mid']=$mid;
        $arr['pid']=$pid;
        $arr['url']=$url;
        $arr['createtime']=time();
        $query = Mod::app()->db->createCommand()->insert('dym_message', $arr);

        exit;*/
        $message=new Message();
        $message->title=$title;
        $message->datetime=$datetime;
        $message->result=$result;
        $message->tablename=$tablename;
        $message->pid=$pid;
        $message->url=$url;
        $message->createtime=time();
        if($message->save()){
            return true;
        }else{
            $message->errors;
        }

    }

    public function wx_jssdk($wx_appid,$wx_appsecret){
        $jssdk = new Jssdk($wx_appid?$wx_appid:'wx37e6cc950b4fd03a', $wx_appsecret?$wx_appsecret:'84ca70e17f41cf53e8994c353c40318f');
        $signPackage = $jssdk->GetSignPackage();
        return $signPackage;
    }
    
    public function selectmembergroup(){
        $sql = "select * from dym_membergroup where FIND_IN_SET('".$this->member['id']."',permission) and  status=1 and admin=1";
        $membergroup = Mod::app()->db->createCommand($sql)->queryAll();
        return $membergroup;
    }
    
    public function getpermission(){
        $sql = "select a.id,a.permission,a.permission_id,b.mid,b.status from dym_membergroup a LEFT JOIN  dym_membergroup_admin b on a.id = b.group_id  where FIND_IN_SET('".$this->member['id']."',a.permission) and  a.status=1 and a.admin=1";
        $membergroup = Mod::app()->db->createCommand($sql)->queryAll();
        $tmp=array();
        $all_admin = false;
        foreach ($membergroup as $v){
            if($v['permission_id']==1) {  //如果所在组中有所有权限跳出循环
                $all_admin = TRUE;
                break;
            }
            if ($v['status'] == 1) {
                $tmp = array_merge($tmp, explode(",", $v['permission']));
            } else {
                array_push($tmp, $this->member['id']);
            }
        }

        if($all_admin){
            return false;
        }else{
            return array_unique($tmp);
        }
    }

    public function memberverify($mid){
        $membergroup = $this->selectmembergroup();
        if($membergroup){
            $re = $this->getpermission();
            if($re){
                if (!in_array($mid,$re)) {
                    return true;
                }
            }else{
                return false;
            }
        }else {
            if ($mid != $this->member['id']) {
                return true;
            }
        }
    }
}
