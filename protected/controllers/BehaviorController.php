<?php
/**
 * 
 * 
 * 用户行为控制器，用户操作后分别调用方法，将行为存入数据库并获取积分；
 *
 */
class BehaviorController extends FrontController {
    public function init() {
        parent::init();
    }
    /* @author yuwanqiao
     * 用户登录，注册或参加活动时调用将用户的操作存入数据库并添加积分
     * @parame 
     * mark  对应的操作的pinyin 
     * pid   应用的id    mark和pid联合查询到用户具体的行为操作，如：登录，注册等等
     * openid用户的openid 用于查询用户信息
     */
   
    
    
    
    //用户总览
    public function actionIndex() {
        $pid =  trim(Tool::getValidParam('id', 'integer'));
        $day =  trim(Tool::getValidParam('day', 'integer',1));//天数
        if ($day) {
            if ($day==1) {
                $begin = strtotime(date('Y-m-d 00:00:00'));
                $end = strtotime(date('Y-m-d 23:59:59'));
                $day= 0;
            } else if ($day==2) {
                $begin = strtotime(date('Y-m-d 00:00:00',strtotime('-1 day')));
                $end = strtotime(date('Y-m-d 23:59:59',strtotime('-1 day')));
                $day = 0;
            } else {
                $day = $day - 1;
                $begin = strtotime(date('Y-m-d 00:00:00',strtotime('-'.$day . ' day')));
                $end = strtotime(date('Y-m-d 23:59:59'));
            }
        } 
        $begin2 = strtotime(trim(Tool::getValidParam('begin', 'string')));
        $end2 = strtotime(trim(Tool::getValidParam('end', 'string')));
        if ($begin2 && $end2) {
            $begin = $begin2;
            $end = $end2;
            $day = ceil(($end-$begin)/86400);
        }
        $activity = urldecode(trim(Tool::getValidParam('activity', 'string',0)));
        $model = new Member_behavior();
        //获取柱形图数据
        for ($i=0;$i<=$day;++$i) {
            $endByday = $begin + 86400;
            $criteria = new CDbCriteria();
            if ($activity) {
                $criteria->compare('type',$activity);
            }
            $criteria->compare('pid',$pid);
            $criteria->addBetweenCondition('createtime',$begin,$endByday);
            $list[$i]['count'] = $model->count($criteria);
            $list[$i]['day'] = date('y-m-d',$begin);
            $begin = $endByday;
        }
        //报名列表
        $signUp = SignUp::model()->findAllByAttributes(array('pid'=>$pid));

        //获取项目列表
        $project_list = Project::model()->getProjectList($pid,$this->member['id'],$pid);
        $config['project_list'] = $project_list['other'];
        $config['project_now'] = $project_list['now'];         
        $config['site_title'] = '应用趋势';  
   
        //活动列表 
        $as_list = Activity_scratchcard::model()->getActivityList($this->member['id'],$pid);              
        
        $this->render('index',array('signUp'=>$signUp,'asList'=>$as_list,'datalist' => $list ,'count'=>$count, 'pagebar' => $pages,'pid'=>$pid,'config'=>$config));
    }

    
    //查看详情
    public function actionView(){
        $pid =  trim(Tool::getValidParam('id', 'integer'));           
        
        //活动ID
        $fid =  trim(Tool::getValidParam('fid', 'integer'));
        
        $aswModel = new Activity_scratchcard_win;
     
        $criteria = new CDbCriteria();
        $criteria->with = array('win');
        $criteria->condition = 't.FActivityID= '. $fid ;
        $criteria->order = 't.FCreateTime DESC';
        $count = $aswModel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $winList = $aswModel->findAll($criteria);
             
        //获取项目列表
        $project_list = Project::model()->getProjectList($pid,$this->member['id']);
        $config['project_list'] = $project_list['other'];
        $config['project_now'] = $project_list['now'];         
        $config['site_title'] = '活动';

        //报名列表
        $signUp = SignUp::model()->findAllByAttributes(array('pid'=>$pid));

        //活动列表 
        $as_list = Activity_scratchcard::model()->getActivityList($this->member['id'],$pid);      
           
        $this->render('list',array('signUp'=>$signUp,'asList'=>$as_list,'winList' => $winList ,'count'=>$count, 'pagebar' => $pages,'pid'=>$pid,'fid'=>$fid,'config'=>$config));        
    }

    //用户分析
    public function actionUserBehavior(){        
        $this->layout = 'ulayout';
        
        $this->pid = $pid = trim( Tool::getValidParam('pid','integer'));
        $this->active_2 = 1;           
        $model = new Member_behavior();
        
        $criteria = new CDbCriteria();
        $criteria->with =  array('minfo');        
        $criteria->condition = "pid='" . $pid . "'";
        $criteria->order = 't.createtime DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 7;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $list = array();
        foreach ($result as $k=>$v) {         
            $list[$k]['phone'] = $v->minfo['phone'];
            $list[$k]['openid'] = $v->openid;
            $list[$k]['type'] = Member_behavior::status($v->type);
            $list[$k]['createtime'] = $v->createtime;
            $list[$k]['ip'] = $v->ip;
            if ($v->ip) {
                $result = Tool::getIplookup($v->ip);
                $list[$k]['address'] = $result['province'] . '·' . $result['city'];
            }
            
        }
        
        $this->site_title = '用户管理';
        $this->render('user_behavior',array('datalist' => $list , 'pagebar' => $pages,'count'=>$count));               
    }
    
    //商家用户列表
    public function actionUserList(){
        $this->layout = 'ulayout';
        $this->pid = $pid =  trim(Tool::getValidParam('pid', 'integer'));
        $this->active_1 = 1;
        $model = new Member_project();
   
        $criteria = new CDbCriteria();
        $criteria->with =  array('minfo');
        $criteria->condition = "pid='" . $pid . "'";
        $criteria->order = 't.createtime DESC';
        $count = $model->count($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = 3;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $list = $model->findAll($criteria);          
        
        $this->site_title = '用户管理';
        $this->render('user_list',array('datalist' => $list , 'pagebar' => $pages,'count'=>$count,'pid'=>$pid));           
    }

    //发送站内消息
    public function actionSendMessage(){
        if(Mod::app()->request->isAjaxRequest){
           $data['pid'] = $pid =  trim(Tool::getValidParam('pid', 'integer'));
           $data['mid'] = $mid =  trim(Tool::getValidParam('mid', 'integer'));
           $data['title'] = $title =  trim(Tool::getValidParam('title', 'string'));
           $data['content'] = $content =  trim(Tool::getValidParam('content', 'string')); 
                      
           $rec = array('state'=>0,'mess'=>'消息发送失败！');
           if($pid && $mid && $title && $content){
               $msModel = new Member_message;
               foreach ($data as $k=>$v){
                   if($k!='' && $v!=''){
                      $msModel->$k = $v;
                   }
               }
               //保存消息
               $msModel->sendTime = time();
               if($msModel->save()){
                   $rec['state'] = 1;
                   $rec['mess'] = '消息发送成功！';
               } 
           }
           
           echo json_encode($rec);
           exit;
        }
    }   
    
    //发送站内信息视图
    public function actionMessageIframe(){
        $pid =  trim(Tool::getValidParam('pid', 'integer'));
        $mid =  trim(Tool::getValidParam('mid', 'integer'));
  
        $this->render('message_iframe',array('pid'=>$pid,'mid'=>$mid));
    }
    
    //消息列表
    public function actionMessageListIframe(){
        $pid =  trim(Tool::getValidParam('pid', 'integer'));
        $mid =  trim(Tool::getValidParam('mid', 'string'));   
        
        $msmodel = new Member_message();
        $criteria = new CDbCriteria();
        $criteria->condition = 'pid='.$pid.' and mid='.$mid;
        $criteria->order = 'sendTime DESC';

        $count = $msmodel->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 3;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $list = $msmodel->findAll($criteria);        
        $this->render('messagelist_iframe',array('datalist' => $list , 'pagebar' => $pages,'count'=>$count));
    }
    
    //数据分析
    public function actionDataAnalysis()
    {
        if(empty($this->member)){
            $this->redirect('/member/login');
            exit;
        }
  
        $pid =  trim(Tool::getValidParam('id', 'integer'));
        $day =  trim(Tool::getValidParam('day', 'integer',1));//天数
        if ($day) {
            if ($day==1) {
                $begin = strtotime(date('Y-m-d 00:00:00'));
                $end = strtotime(date('Y-m-d 23:59:59'));
                $day= 0;
            } else if ($day==2) {
                $begin = strtotime(date('Y-m-d 00:00:00',strtotime('-1 day')));
                $end = strtotime(date('Y-m-d 23:59:59',strtotime('-1 day')));
                $day = 0;
            } else {
                $day = $day - 1;
                $begin = strtotime(date('Y-m-d 00:00:00',strtotime('-'.$day . ' day')));
                $end = strtotime(date('Y-m-d 23:59:59'));
            }


        } else {
            $begin = strtotime(trim(Tool::getValidParam('begin', 'string')));
            $end = strtotime(trim(Tool::getValidParam('end', 'string')));
            $day = ceil(($end-$begin)/86400);
        }
        $activity = urldecode(trim(Tool::getValidParam('activity', 'string',0)));
        $model = new Member_behavior();
        //获取柱形图数据
        for ($i=0;$i<=$day;++$i) {
            $endByday = $begin + 86400;
            $criteria = new CDbCriteria();
            if ($activity) {
                $criteria->compare('type',$activity);
            }
            $criteria->compare('pid',$pid);
            $criteria->addBetweenCondition('createtime',$begin,$endByday);
            $list[$i]['count'] = $model->count($criteria);
            $list[$i]['day'] = date('y-m-d',$begin);
            $begin = $endByday;
        }
        
        //获取项目列表
        $project_list = Project::model()->getProjectList($pid,$this->member['id']);
        $config['project_list'] = $project_list['other'];
        $config['project_now'] = $project_list['now'];         
        $config['site_title'] = '应用趋势';
        
        $this->render('data',array('datalist' => $list ,'pid'=>$pid,'config'=>$config));
    }
 
}

