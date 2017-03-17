<?php
/**
 * @author yuwanqiao
 * 用户签到的控制器
 */
class PccheckinController extends FrontController{
    public function init(){
        parent::init();
        //判断用户是否登录，如果没有登录直接跳转到登录页面
        if(!$this->member && !$_SESSION['mid']){
            // $this->redirect(Mod::app()->request->getHostInfo());
            //  exit;
        }
        $this->activity_permissions('pccheckin');
    }
    /**
     * @author yuwanqiao
     * 签到活动html页面
     */
    public function actionView(){

        $id = trim(Tool::getValidParam('id','integer'));
        $token = trim(Tool::getValidParam('accesstoken','string'));
        $pid= Tool::getValidParam('pid','integer');
        $pid2=$pid?$pid:$this->member_project['pid'];
        $pid=$pid2?$pid2:1;
        if(!$id){
            $this->redirect('/project/prolist');
            exit;
        }



        //判断该用户是否需要登录
        $pwd = trim(Tool::getValidParam('pwd','integer'));
        // $appid = trim(Tool::getValidParam('appid','integer'));
        // $appsecret = trim(Tool::getValidParam('appsecret','string'));
        // $openid = trim(Tool::getValidParam('openid','string'));
        // if($openid && !ctype_alnum($openid)){die('非法请求');}

        //查询签到信息
        $sql = "SELECT * FROM {{activity_pccheckin}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$info || empty($info)){die('非法请求');}

       
        Browse::add_activity_browse($info['pid'],$id,"pccheckin");

        if($this->member['id']){//登录状态
            $mid = $this->member['id'];

            //查看签到状态
            $sql = "SELECT * FROM dym_activity_pccheckin_user WHERE mid=$mid  and  pid=$pid  and date='".date('Y-m-d',time())."'";
            $users=Mod::app()->db->createCommand($sql)->queryRow();
            $is_pccheck=$users?1:0;
        }

        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

        //token验证
        $checkToken = $this->checkToken($project_info['id'],$token);
        // if(!$checkToken || empty($checkToken)){die('token is error');}

        $backUrl = "?id=".$id."&accesstoken=".$token."&openid=".$openid;

        //根据活动id查询活动信息
        //查询一条数据
        $sql = "SELECT * FROM dym_activity_pccheckin WHERE id=$id";
        $pccheckin=Mod::app()->db->createCommand($sql)->queryRow();
        $end_time = $pccheckin['end_time'];
        $start_time = $pccheckin['start_time'];
        if($end_time<time()){
            $pccheckin['status']='活动已经结束';
        }elseif($start_time>time()){
            $pccheckin['status']='活动未开始';
        }
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_agent, 'MicroMessenger') === false) {
            // 非微信浏览器禁止浏览
            $explorer=1;
        }else {
           $explorer=2;
        }

        $parame = array(
            'info'=>$info,
            'id'=>$id,
            'pid'=>$pid,
            'pccheckin'=>$pccheckin,
            'explorer'=>$explorer,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $mid,
                "backUrl" => $mid,
                "status" => $mid,
                "mid" => $mid,
                "is_pccheck" => $is_pccheck
                ),
            'date'=>date('Y年m月d日'),
            'signPackage'=>$signPackage,
             'config'=>array(
                'site_title'=> '签到活动页面-大楚网用户开放平台',
                'Keywords'=>'签到活动页面-大楚网用户开放平台',
                'Description'=>'签到活动页面-大楚网用户开放平台'
            ),
        );
        $this->render('view',$parame);
    }
    /**
     *
     * @author yuwanqiao
     * 后台添加报名活动
     */
    public function actionAdd(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        if(Mod::app()->request->isPostRequest){
             $data = $_POST;
             $activity_id = trim(Tool::getValidParam('id','integer'));

            $pid = trim(Tool::getValidParam('pid', 'integer'));
            if($activity_id){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_pccheckin}} where id=$activity_id";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid']) ){
                    die('非法访问');
                }
            }else if($pid){//添加 //添加必带项目ID
                if(!$pid) die('非法访问');
                $projectinfo =  JkCms::getprojectByid($pid);
                if($this->memberverify($projectinfo['mid']) ){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }
            //end权限

             $data['start_time']=strtotime(trim(Tool::getValidParam('start_time','string')));
             $data['end_time']  =strtotime(trim(Tool::getValidParam('end_time','string')));

            if(!$data['share_img']){
                unset($data['share_img']);
            }
             $sql = "SHOW FULL FIELDS FROM dym_activity_pccheckin";
             $result = Mod::app()->db->createCommand($sql);
             $query = $result->queryAll();
             foreach ($query as $key=>$val){
                 foreach ($data as $key_data=>$val_data){
                     if($val['Field']==$key_data){
                         $arr[$key_data]=Safetool::SafeFilter($val_data);
                     }
                 }
            }
            $arr['mid'] = $this->member['id'];
            if($activity_id){
                $arr['update_time']  =time();
                $update_id = array(':id'=>$activity_id);
                $query = Mod::app()->db->createCommand()->update('dym_activity_pccheckin',$arr,'id=:id', $update_id);
                $str ='编辑';
            }else{
                $arr['create_time']  =time();
                $arr['update_time']  =time();
                $query = Mod::app()->db->createCommand()->insert('dym_activity_pccheckin',$arr);
                $str ='添加';
            }
            if($query){
                $res = array(
                    'statue'=>1,
                    'msg'   =>$str.'签到活动成功'
                );
            }else{
                $res = array(
                    'statue'=>0,
                    'msg'   =>$str.'签到失败'
                );
            }
            echo json_encode($res);
        }else{
            //获取点击编辑是得到的活动id
             $fid = trim(Tool::getValidParam('fid', 'integer'));
            $pid = trim(Tool::getValidParam('pid', 'integer'));

            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid'])  || !$this->member['pstatus']){
                die('非法访问');
            }

            if ($fid) {
                //start所属权限开始
                $sql = "select * from {{activity_pccheckin}} where id=$fid";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid']) ){
                    $this->redirect(Mod::app()->request->getHostInfo());
                    exit;
                }
                //end权限
                 //查询活动数据
                 $sql = "select * from dym_activity_pccheckin where id=$fid";
                 $result = Mod::app()->db->createCommand($sql);
                 $query = $result->queryAll();
             }else{
                 $query = array();
             }


            //获取当前项目
             $project_model = Project::model()->findByPk($pid);
             //获取项目列表
             $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
             //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
             $config['active_1'] ='3';
             //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
             $config['active']=2;
             $config['pid']=$pid;
            $psql = "SELECT p.type,a.id,a.name from {{project}} as p LEFT JOIN {{application_tag}} as a on p.type=a.classid WHERE p.id=$pid order by a.updatetime desc";
            $ptag = Mod::app()->db->createCommand($psql);
            $tag = $ptag->queryAll();
            $ptag=explode('_',substr($query[0]['tag'],0,-1));

            $config['site_title']='签到活动页面-添加编辑签到活动-大楚网用户开放平台';
            $config['Keywords']='大楚网用户开放平台,签到，活动';
            $config['Description']='大楚网用户开放平台_签到活动页面_添加编辑签到活动';
            //var_dump($query);
             $parame = array(
                 'project_list'=>$project_list,
                 'view'=> $project_model,
                 'config'=>$config,
                 'activity_info'=>$query[0],
                 'prize'=>$prize,
                 'ptag'=>$ptag,
                 'tag'=>$tag,
                'status'=>$this->activity_status('pccheckin')

             );
             $this->render('add_pccheckin',$parame);
        }
    }
    /**
     * @author yuwanqiao
     * 后台签到活动列表
     */
    public function actionlist(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动所属的应用的id
        $pid = trim(Tool::getValidParam('pid','integer'));
        if(!$pid ){
            $this->redirect('/project/prolist');
            exit;
        }
        //获取当前应用
        $project_model = Project::model()->findByPk($pid);
         if($this->memberverify($project_model['mid'])){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
         }
        //获取应用列表
        $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
        //报名活动列表
        $as_list = Activity_pccheckin::model()->getActivityListPager($pid);
//        if(1==1) { //default模板风格
//            if (!$as_list['count']) {
//                $redirect_url = Mod::app()->baseUrl . '/activity/pccheckin/add/pid/' . $pid;
//                $this->redirect($redirect_url);
//            }
//        }
        $config['active_1']=3;
        $config['active'] =2;
        $config['pid']=$pid;

        $config['site_title'] = '签到活动页面-添加编辑签到活动-大楚网用户开放平台';
        $config['site_keywords'] = "大楚网用户开放平台,签到，活动";
        $config['site_description'] ="大楚网用户开放平台_签到活动页面_添加编辑签到活动";
        $parame = array(
            'project_list'=>$project_list,
            'view'=> $project_model,
            'asList'=>$as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count'=>$as_list['count'],
            'config'=>$config
        );
        $this->render('list_pccheckin',$parame);
    }

  /**
     * @author 删除报名活动
     *
     */
    public function actionDelete() {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('fid','integer'));
        if(!$id ){
            $this->redirect('/project/prolist');
            exit;
        }

        //防止ID遍历
        $respcck=Activity_pccheckin::model()->findByPk($id);
        if(!$respcck){
            $mess = array('errorcode'=>1,'status'=>'fail');
            echo json_encode($mess);
            exit;
        }
        $projectinfo =  JkCms::getprojectByid($respcck->pid);
        if($this->memberverify($projectinfo['mid']) ){
            $mess = array('errorcode'=>1,'status'=>'fail');
            echo json_encode($mess);
            exit;
        }

        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_pccheckin', 'id=:id',$where);
        if($res){
            $recommend = Mod::app()->db->createCommand()->select('id')->from('{{activity_recommend}}')->where('aid='.$id)->queryRow();
            if($recommend){
                Mod::app()->db->createCommand()->delete('{{activity_recommend}}', 'aid IN('.$id.')');
            }

            $mess = array('errorcode'=>0,'status'=>'success');
        }else{
            $mess = array('errorcode'=>1,'status'=>'fail');
        }
        echo json_encode($mess);
    }

/**
     * @author yuwanqiao
     * 设置结束活动
     */
    public function actionActivityStatus(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动的id
        $id = Tool::getValidParam('fid');

        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_pccheckin}} where id=$id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限




        //type 1表是设置开始 2表示设置结束
        $type=Tool::getValidParam('type');

        if(!$id){
            $this->redirect('/project/prolist');
            exit;
        }


        if($type==1){
            $str = '开始';
            $arr       = array('start_time'=>time());
        }
        if($type==2){
            $str = '结束';
            $arr       = array('end_time'=>time());
        }
        $update_id = array(':id'=>$id);
        $query = Mod::app()->db->createCommand()->update('dym_activity_pccheckin',$arr,'id=:id', $update_id);
        if($query){
            $res = array(
                'statue'=>1,
                'msg'=>'设置'.$str.'成功'
            );
        }else{
            $res = array(
                'statue'=>0,
                'msg'=>'设置'.$str.'失败'
            );
        }
        echo json_encode($res);
    }


    /**
     * @author yuwanqiao
     * 用户提交的签到信息
     */
    public function actionAddUser(){
        $openid = trim(Tool::getValidParam('openid','string'));
        $pid    = trim(Tool::getValidParam('pid','integer'));//这个是活动id
         $mid    = trim(Tool::getValidParam('mid','integer'));
        $mid = $this->member['id'];
        if(!$pid || !$mid){
           echo "非法访问";
            exit;
        }

        $transaction=Mod::app()->db->beginTransaction();

        try{

            if(!$openid){
                $sql = "SELECT * FROM dym_activity_pccheckin_user WHERE mid=$mid  and  pid=$pid  and date='".date('Y-m-d',time())."'";
            }else{
                $sql = "SELECT * FROM dym_activity_pccheckin_user WHERE openid='".$openid."' and pid=$pid and date='".date('Y-m-d',time())."'";
            }
            $users=Mod::app()->db->createCommand($sql)->queryRow();
            if($users){
                $return_res=array(
                    'code'=>2,
                    'msg' =>'您今天已经签到了'
                );
            }else{

                $arr = array(
                    'openid'=>$openid,
                    'pid'=>$pid,
                    'mid'=>$mid,
                    'date'=>date('Y-m-d',time()),
                    'add_time'=>time()
                );
                $query = Mod::app()->db->createCommand()->insert('dym_activity_pccheckin_user',$arr);

                if($query){
                    //查询签到信息
                    $sql = "SELECT * FROM {{activity_pccheckin}} WHERE id=$pid";
                    $info=Mod::app()->db->createCommand($sql)->queryRow();
                    //插入行为表
                    $win = 0;
                    $name = "签到";
                    $res = Behavior::behavior_points(3,$mid,$info['pid'],$name,$win,$pid,'activity_pccheckin');


                    if($res['code']==200) {
                        $jifen = array(
                            'pid' => $info['pid'],
                            'mid' => $mid,
                            'qty' => $res['points'],
                            'type' => 1,
                            'createtime' => time(),
                            'content' => '签到积分',
                        );
                        $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);
                        if($query){
                            $return_res=array(
                                'code'=>1,
                                'msg' =>'签到成功'
                            );
                        }

                    }else{
                        $return_res=array(
                            'code'=>0,
                            'msg' =>'签到失败'
                        );
                    }
                }else{
                    $return_res=array(
                        'code'=>0,
                        'msg' =>'签到失败'
                    );
                }
            }

        $transaction->commit();
        }catch(Exception $e){ //如果有一条查询失败，则会抛出异常
                $transaction->rollBack();
        }

       echo json_encode($return_res);
    }
    /**
     * @author yuwanqiao
     * 获取用户签到活动列表
     */
    public function actionAddList(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $fid = trim(Tool::getValidParam('fid', 'integer'));
        $title = trim(Tool::getValidParam('title', 'string'));
        $username = trim(Tool::getValidParam('username', 'string'));

        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($fid){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_pccheckin}} where id=$fid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限

        $as_list = Activity_pccheckin_user::model()->getUserListPager($fid,$username);
        if($as_list['count']){
            foreach($as_list['criteria'] as $key=>$val){

                $sql = "SELECT * FROM {{member}} WHERE id=".$val['mid'];
                $info=Mod::app()->db->createCommand($sql)->queryRow();

                $as_list['users'][$key]['name']=$info['username']?$info['username']:$info['name'];
                $as_list['users'][$key]['phone']=$info['phone'];

                $as_list['users'][$key]['id']=$val['id'];
                $as_list['users'][$key]['openid']=$val['openid'];
                $as_list['users'][$key]['add_time']=$val['add_time'];
            }

        }else{
            $as_list['count']= '0';
            $as_list['users']=array();
        }
        $as_list['id']=$fid;
        $as_list['title']=$title;
        $as_list['username']=$username;
        $this->render('addlist',$as_list);
    }
 /**
     * @author yuwanqiao
     * 导出签到用户的数据列表CSV
     */
    public function actionExportCsv(){

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $fid      = trim(Tool::getValidParam('fid','integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($fid){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_pccheckin}} where id=$fid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid']) ){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限

        $type=Tool::getValidParam('type','integer');
        $start=Tool::getValidParam('starttime','string');
        $end=Tool::getValidParam('endtime','string');
        $start= $start?strtotime($start):"";
        $end= $end?strtotime($end):"";
        switch($type){
            case 3:
                if(!$start|| !$end){
                    echo '导出请选择时间';
                    exit;
                }
                $where="pid=$fid and add_time>$start and add_time<$end";
                break;
            case 1:
                echo "数据错误!";exit;
                break;
            default:
                $where = "pid = $fid";
        }

        Mod::import('ext.ECSVExport');

        $list = Mod::app()->db->createCommand()
           ->select('*')
           ->from('dym_activity_pccheckin_user')
           ->where($where)
           ->queryAll();
        if($list){
            foreach($list as $key=>$val){
                $sql = "SELECT * FROM {{member}} WHERE id=".$val['mid'];
                $info=Mod::app()->db->createCommand($sql)->queryRow();

                $as_list[$key]['name']=$info['username']?$info['username']:$info['name'];
                $as_list[$key]['phone']=$info['phone'];
                $as_list[$key]['openid']      = $val['openid'];
                $as_list[$key]['add_time'] = $val['add_time'];
            }
        }else{

            $as_list=array();
            echo "没有数据不能导出！";
            exit;
        }

        $list = array();
        if($as_list) {
            foreach ($as_list as $k => $v) {
                $list[$k]['签到用户昵称'] = $v['name'];
                $list[$k]['签到用户手机'] = $v['phone'];
                $list[$k]['签到用户OPENID'] = $v['openid'];
                $list[$k]['签到时间'] = date('Y-m-d H:i:s',$v['add_time']);
            }
        }

        $data=array();
        foreach($list as $key=>$val){
            foreach($val as $k=>$v){
                $ke= mb_convert_encoding($k,"GBK","UTF-8");
                $va= mb_convert_encoding($v,"GBK","UTF-8");
                $data[$key][$ke]=$va;
            }

        }
        //生成cvs文件
        $csv = new ECSVExport($data);
        $output = $csv->toCSV();
        Mod::app()->getRequest()->sendFile('签到用户列表.csv', $output, "text/csv", false);
        exit();

    }


    /**
     * @abstract pc  签到PC预览
     * @author Fancy
     */

    public function actionPcview()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $parame = array(
            'id' => $id,
            'pid' => $pid,
            'config'=>array(
                'site_title'=> '签到活动页面-pc版活动页面-大楚网用户开放平台',
                'Keywords'=>'签到活动页面-pc版活动页面-大楚网用户开放平台',
                'Description'=>'签到活动页面-pc版活动页面-大楚网用户开放平台'
            ),
        );

        $this->render('pcview', $parame);
    }


    /*
    *  活动PVUV统计图表
    */
    public function actionActivitylist(){
        if (!isset(Mod::app()->session['admin_user'])) {  //后台管理员可看
            if (!$this->member || !$this->member['id'] || !$this->member['pstatus']) {
                $this->redirect(Mod::app()->request->getHostInfo());
                exit;
            }
        }
        $config['aid'] = trim(Tool::getValidParam('fid', 'integer'));//活动ID 开发写的不一致
        $config['tag'] = trim(Tool::getValidParam('tag', 'string'));//活动ID 开发写的不一致
        $config['model'] = "pccheckin";
        if (Mod::app()->request->isPostRequest) {
            $startdate = Tool::getValidParam('startdate', 'integer');
            $enddate = Tool::getValidParam('enddate', 'integer');
            $day = intval(($enddate - $startdate) / 86400) + 1;
        }
        switch ($config['tag']) {
            case "pvuv";
                if (empty($startdate) && empty($enddate)) {
                    $day = 7; //查询当前开始前7天的数据
                    $now = date('Y-m-d', time());
                } else {
                    $now = date('Y-m-d', $enddate);
                }
                for ($i = 0; $i < $day; $i++) {
                    $day_date = date('Ymd', strtotime($now . "-" . $i . " day"));
                    $last = date('Y-m-d', strtotime($now . "-" . $i . " day"));
                    $day_arr[$i]['day_date'] = $day_date;
                }
                foreach ($day_arr as $k => $v) {
                    $pv = Mod::app()->db->createCommand()->select('count_num')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=1 and model = "' . $config['model'] . '" and createtime=' . $v['day_date'])->queryRow();
                    $uv = Mod::app()->db->createCommand()->select('count(0)')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=2 and model = "' . $config['model'] . '" and createtime=' . $v['day_date'])->queryRow();
                    $pvuv[$v['day_date']]['pv'] = !empty($pv['count_num'])?$pv['count_num']:0;
                    $pvuv[$v['day_date']]['uv'] = !empty($uv['count(0)'])?$uv['count(0)']:0;

                }
                $config ['pvuv'] = $pvuv;
                $config ['time']['start_time'] = $last;
                $config ['time']['end_time'] = $now;
                break;
            case "user":
                if (empty($startdate) && empty($enddate)) {
                    $now = time(); //查询当前开始前7天的数据
                    $last= date('Y-m-d', strtotime(date('Y-m-d', $now) . "- 6 day"));
                } else {
                    $now = strtotime(date('Y-m-d', $enddate) . "+ 1 day")-1;
                    $last = date('Y-m-d',$startdate);
                }
                $table_user = "dym_activity_pccheckin_user";
                $data['signup'] = Mod::app()->db->createCommand()->select('count(0)')->from('dym_member_activity')->where('aid=' . $config['aid'] . ' and model = "' . $config['model'] . '" and (createtime between '.strtotime($last).' and '.$now.')')->queryRow();
                $data['join'] = Mod::app()->db->createCommand()->select('count(0)')->from($table_user)->where('pccheckin_id=' . $config['aid'] . '  and (add_time between '.strtotime($last).' and '.$now.')')->queryRow();
                $config['userdata']['signup'] = $data['signup']['count(0)'];
                $config['userdata']['join'] = $data['join']['count(0)'];
                $config ['time']['start_time'] = $last;
                $config ['time']['end_time'] = date('Y-m-d',$now);
                break;
        }


        $this->render('activitylist',$config);
    }

}