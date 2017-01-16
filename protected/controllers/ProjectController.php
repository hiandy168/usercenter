<?php
 
class ProjectController extends FrontController {

    public function init() {
        parent::init();
        if(!$this->member){
            $this->redirect($this->_siteUrl);
            exit;
        }
    }
    /*删除项目*/
 public function actiondelete(){
        $id=Tool::getValidParam('fid','integer');
        if($id){

            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($id);
            if($this->member['id'] &&  $projectinfo['mid']  && $this->member['id'] !=   $projectinfo['mid'] ){
                $this->redirect(Mod::app()->request->getHostInfo());
                exit;
            }

            $res=Project::model()->updateByPk($id,array('status'=>9));
            if($res){
                echo json_encode(array('errorcode'=>1,'msg'=>'删除成功'));
                exit;
            }else{
                echo json_encode(array('errorcode'=>0,'msg'=>'删除失败'));
                exit;
            }
        }
 }
    public function actionProlist(){
        $data['config'] = $this->site_config;
        $data['phone']=$this->member['name'];

        //
        $model = new Project();
        $criteria = new CDbCriteria();
        if(isset($_GET['status'])){
            $criteria->compare('status','0');
        }
        $membergroup = $this->selectmembergroup();
        if($membergroup) {
            $tmp = $this->getpermission();
            if($tmp){
                $criteria->compare('t.mid', $tmp);
            }
        }else{
            $criteria->compare('t.mid', $this->member['id']);
        }
       
        
        $criteria->compare('t.status',1);
        //$search_text=Mod::app()->request->getParam('search_text');
		$search_text=Tool::getValidParam('search_text','string');
        if($search_text) {
            $criteria->addSearchCondition('name',$search_text);
            $criteria->addSearchCondition('introduction',$search_text,true,'OR');
            $criteria->addSearchCondition('appid',$search_text,true,'OR');
        }

        $criteria->order = 'createtime DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $temp_arr = array();
 
 
 
        foreach ($result as  $k=>$v){
            $temp_arr[]=$v->attributes;
            foreach ($temp_arr as $k1=>$v1){
                //求昨日
                $sql = "select count(0) z_counts from  dym_member_project where pid=".$v1['id']." and  date_sub(curdate(),interval 1 day) = from_unixtime(createtime,'%Y-%m-%d')";
                $res = Mod::app()->db->createCommand($sql)->queryRow();
                //求本周
                $sql = "select count(0) w_counts from  dym_member_project where pid=".$v1['id']." and   YEARWEEK(from_unixtime(createtime)) = YEARWEEK(now())";
                $res2 = Mod::app()->db->createCommand($sql)->queryRow();
                $v1['z_counts']=$res['z_counts'];
                $v1['w_counts']=$res2['w_counts'];
                $temp_arr[$k1]=$v1;
            }
        }
        //计算资料完整度
        $total = 4;
        $num = 0;
        $meb = Member::model()->findByPk($this->member['id']);
        $num = ($meb->company)?($num+1):$num;
        $num = ($meb->address)?($num+1):$num;
        $num = ($meb->username)?($num+1):$num;
        $num = ($meb->email)?($num+1):$num;
        //$num = ($meb->com_url)?($num+1):$num;
        $degree = round(($num/$total)*100,0);
        $config['site_title'] = '管理中心-大楚用户开放平台首页';
        $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
        $config['config']['site_description'] ="大楚用户开放平台首页";
        $config['active'] = 'guanlizhongxin';
 
        $user_session = Mod::app()->session['member'];
        $user = array(
            'id'=>$user_session['id'],
            'name'=>$user_session['name'],
            'phone'=>$user_session['phone'],
            'username'=>$user_session['username']
        );
        $config['admin'] =$user;
 
        $config['position'] = array(
            array('name'=>'管理中心'),
            array('name'=>'应用管理'),
        );
        $this->render('prolist', array ('datalist' => $temp_arr , 'pagebar' => $pages,'degree'=> $degree ,'config'=>$config));
    }
 
 
    public function actionCreatePro(){
        $config['site_title'] = '创建应用-大楚用户开放平台首页';
        $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
        $config['config']['site_description'] ="大楚用户开放平台首页" ;
        $config['active'] = 'chuangjianyingyong';
        $AlcClassModel = Application_class::model();
        $criteria = new CDbCriteria();
        $criteria->order = 'updatetime DESC';
        $typeList = $AlcClassModel->findAll($criteria);
        $config['position'] = array(
            array('name'=>'管理中心'),
            array('name'=>'创建应用'),
        );
        $this->render('edit', array ('config'=>$config,'type'=>$typeList));
    }
 
 
    public function actionProjectReg() {
        if (!Mod::app()->session['member']['name']) {
            echo json_encode(array('state'=>101001,'mess'=>'请先登录!'));
            return;
        }
        if(Mod::app()->request->isPostRequest){
 
            $projectName = trim(Tool::getValidParam('name','string'));
            $projectIntroduction = trim(Tool::getValidParam('introduction','string'));
            $projectUrl = trim(Tool::getValidParam('url','string'));
            $projectSelect = trim(Tool::getValidParam('select','string'));
            $wx_appid = trim(Tool::getValidParam('wx_appid','string'));
            $wx_appsecret = trim(Tool::getValidParam('wx_appsecret','string'));

            if(!$projectName ){
                echo json_encode(array('state'=>101002,'mess'=>'项目名称为空'));
                return;
            }
            if(!$projectIntroduction ){
                echo json_encode(array('state'=>101003,'mess'=>'项目简介为空'));
                return;
            }
 
            $mtime=explode(' ',microtime());
            $startTime="$mtime[1]"."$mtime[0]";
            $genStr = $startTime;
            $appsecret = md5($genStr); // 16位MD5加密
 
            // 判断是否appkey是否已经存在
            $project_model = Project::model()->find('appsecret ="'.$appsecret.'"' );
            while ($project_model){
                $appsecret = md5($genStr."1");
                $appsecret = md5($genStr);
                $project_model = Project::model()->find('appsecret ="'.$appsecret.'"' );
            }
 
            //插入记录 先插入 在更新appid
            $project_model = new Project;
            $project_model->name = $projectName;
            $project_model->wx_appid = $wx_appid;
            $project_model->wx_appsecret = $wx_appsecret;
            $project_model->introduction = $projectIntroduction;
            $project_model->type = $projectSelect?$projectSelect:"";
            $project_model->url = $projectUrl;
            $project_model->mid = $this->member['id'];
            $project_model->appsecret = $appsecret;
            $project_model->status = 1;
            $project_model->createtime = $project_model->updatetime = time();
 
            $project_model->save();
            $sId = $project_model->attributes['id'];
            $project_model->appid = $sId + 101010;
            $project_model->save();
 
            if(!$project_model->save()){
                echo json_encode(array('state' => 101004, 'mess' => '创建项目失败'));
                exit;
            }
            exit(json_encode(array('state'=>1,'mess'=>'创建成功')));
        }
 
    }
 
 
 
    //项目首页
    public function actionAppmgt (){
        //应用id
      //  $pid = Mod::app()->request->getParam('id','integer');
        $pid = Tool::getValidParam('id','integer');
       // if($pid && !ctype_alnum($pid)){die('非法请求');}
 
        //对应的应用下点击的哪个操作：访问数据(默认为空)、用户数据(user)、用户行为(behavior)、积分数据(points)
        $tab = Tool::getValidParam('tab','string');
       // if($tab && !ctype_alnum($tab)){die('非法请求');}
 
        //查询当前应用数据
        $project_model = Project::model()->findByPk($pid);
        //
        if($this->memberverify($project_model->mid)){
             $this->redirect('/project/prolist');
        }
        //
        //获取应用列表
        $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));

        switch($tab){
            //操作数据库查询用户数据
            case 'user':
                //默认的最开始的时间是2016-01
                if($_POST){
                    $now_year=Tool::getValidParam('z-year','integer');
                    $now_month=Tool::getValidParam('z-month','integer');
                }else {
                    $now_year = date('Y', time());
                    $now_month = date('m', time());
                    if(1<= $now_month && $now_month <=6){
                        $now_month=6;
                    }else{
                        $now_month=12;
                    }
                }
                $config['year']=$now_year;
                $config['month']=$now_month;
                $num = $now_year-2016;
                $count_month = $num*12+$now_month;
//                 echo $count_month;exit;
                if($count_month==12){
                    $i=6;
                }else{
                    $i=1;
                }
                for($i;$i<=$count_month;$i++){
                    $year = floor($i/12);
                    $month= $i%12;
                    if($month==0){
                        $month = 12;
                        $year  = $year-1;
                    }
                    $year = $now_year.'-'.$month;
                    $year = strtotime($year);
                    $year = date('Y-m',$year);
                    $first_day = date('Y-m-01', strtotime($year));
                    $last_day  = date('Y-m-d', strtotime(date('Y-m-01', strtotime($year)) . ' +1 month -1 day'));
                    $year_arr[$year]['first_day']=$first_day;
                    $year_arr[$year]['last_day'] =$last_day;
                }
//                print_r($year_arr);
//                exit;
                $activity=Tool::getValidParam('behaviorid','string');


                //查询每个月的用户数据
                $count=0;
                foreach($year_arr as $key=>$val){
                    if($activity){
                        $count_user[$key] = Mod::app()->db->createCommand()->select('count(*)')->from('dym_member_behavior')->where('pid='.$pid.' and type=1 and tablename like "%'.$activity.'%" and (createtime between '.strtotime($key).' and '.strtotime($val['last_day']).')')->queryRow();
                    }else{
                        $count_user[$key] = Mod::app()->db->createCommand()->select('count(*)')->from('dym_member_behavior')->where('pid='.$pid.' and type=1 and (createtime between '.strtotime($key).' and '.strtotime($val['last_day']).')')->queryRow();

                    }
                    $count+=$count_user[$key]['count(*)'];
                }
//                $count = Mod::app()->db->createCommand()->select('count(*)')->from('dym_member_project')->where('pid='.$pid)->queryRow();
                $count_everymonth = ceil($count/$count_month);

//                print_r($count_user);exit;
                $arr=$count_user;
                    $disArr = array();
                    foreach($arr as $value) {
                        $disArr[] = floatval($value['count(*)']);
                    }
                    sort($disArr);
                    $resArr = !empty($disArr) ? array($disArr[0],$disArr[count($disArr)-1]) : array(10,10);
                    unset($disArr);

                $from=Activity::model()->findAll();

                $user = array(
                    'count_user'=>$count_user,
                    'count'=>$count,
                    'count_everymonth'=>$count_everymonth,
                    'res'=>$resArr,
                    'from'=>$from?$from:false,
                );
                break;
            //操作数据库查询用户行为
            case 'behavior':
                if($_POST){
                    $now_year=Tool::getValidParam('z-year','integer');
                    $now_month=Tool::getValidParam('z-month','integer');
                }else {
                    $now_year = date('Y', time());
                    $now_month = date('m', time());
                }
                $config['year']=$now_year;
                $config['month']=$now_month;

                $first_day = $now_year.'-'.$now_month.'-01';
                $last_day  = date('Y-m-d', strtotime(date('Y-m-01', strtotime($first_day)) . ' +1 month -1 day'));





                $sql = "select * from dym_member_behavior_type ";
                $result = Mod::app()->db->createCommand($sql);
                $query = $result->queryAll();
                if($query){
                    foreach ($query as $key=>$val){
                        $count = Mod::app()->db->createCommand()->select('count(*)')->from('dym_member_behavior')->where('pid = '.$pid.' and type='.$val['id']  .' and (createtime between '.strtotime($first_day).' and '.strtotime($last_day).')')->queryRow();
                        $res[$key]['name']=$val['name'];
                        $res[$key]['value']= $count['count(*)'];
                    }
                }else{
                    $res = array();
                }
            //    var_dump($res);exit;

                if(empty($res)){
                    $res = array (
                        0 => array ( 'name' => '注册', 'value' => '0', ),
                        1 => array ( 'name' => '登录', 'value' => '0', ),
                        2 => array ( 'name' => '签到', 'value' => '0', ),
                        3 => array ( 'name' => '红包', 'value' => '0', ),
                        4 => array ( 'name' => '抽奖', 'value' => '0', ),
                        5 => array ( 'name' => '报名', 'value' => '0', ),
                        6 => array ( 'name' => '投票', 'value' => '0', ),
                        7 => array ( 'name' => '问卷', 'value' => '0', ),
                        8 => array ( 'name' => '一元购', 'value' => '0', ),
                        9 => array ( 'name' => '0元购', 'value' => '0', ),
                        10 => array ( 'name' => '众筹', 'value' => '0', ),
                        11 => array ( 'name' => '小游戏', 'value' => '0', ),
                        12 => array ( 'name' => '文章浏览', 'value' => '0', ),
                        13 => array ( 'name' => '点赞', 'value' => '0', ),
                        14 => array ( 'name' => '点踩', 'value' => '0', ),
                        15 => array ( 'name' => '车辆违章查询', 'value' => '0', ),
                        16 => array ( 'name' => '驾驶证绑定', 'value' => '0', ),
                        17 => array ( 'name' => '车辆绑定', 'value' => '0', ), ) ;
                }
                $behavior=array(
                    'behavior'=>$res
                );
                break;
            //操作数据库查询积分数据
            case 'points':
                //根据pid查询应用下的所有用户

                if($_POST){
                    $username= Tool::getValidParam('username', 'string');
                }else{
                    $username="";
                }
                $user = Mod::app()->db->createCommand()->select('*')->from('dym_member_project')->where('pid='.$pid)->queryAll();

                $criteria = new CDbCriteria();
                $model    = new Member_project();
                if($username){
                    $criteria->condition ="t.pid=".$pid." and ( minfo.username like '%".$username."%' or minfo.name like '%".$username."%' ) ";
                }else{
                    $criteria->condition ="t.pid=".$pid;
                }
                $criteria->order = 't.id DESC';
                $count = $model->with('minfo')->count($criteria);
                $pager = new CPagination($count); //实例化分页类
                $pager->pageSize = 15; //每页显示条数
                $pager->applyLimit($criteria);
                $dataList = $model->with('minfo')->findAll($criteria);
//                 var_dump($dataList);exit;
                $arr_user = array();
                if(!empty($dataList)){
                    foreach ($dataList as $key=>$val){
                        $userid =  $val->mid;
                        $user = Mod::app()->db->createCommand()->select('*')->from('dym_member')->where('id='.$userid)->queryRow();
                        if(!empty($user)) {
                            $arr_user[$key]['id'] = $user['id'];
                            $arr_user[$key]['phone'] = $user['phone'];
                            $arr_user[$key]['username'] = $user['username'];
                            $arr_user[$key]['point'] = $user['points'];
                        }
                    }
                }
                $arr_user = array(
                    'user'=>$arr_user,
                    'pagebar' => $pager,
                    'count'=>$count,
                    'username'=>$username
                );
                break;
            //操作数据库查询访问数据
            default:
                //默认的最开始的时间是2016-01
                if($_POST){
                    $now_year=Tool::getValidParam('z-year','integer');
                    $now_month=Tool::getValidParam('z-month','integer');
                }else {
                    $now_year = date('Y', time());
                    $now_month = date('m', time());
                    if(1<= $now_month && $now_month <=6){
                        $now_month=6;
                    }else{
                        $now_month=12;
                    }
                }
                $config['year']=$now_year;
                $config['month']=$now_month;
//                echo $now_month;
//                echo $now_year;exit;
                $num = $now_year-2016;
                $count_month = $num*12+$now_month;
//                 echo $count_month;exit;
                if($count_month==12){
                    $i=6;
                }else{
                    $i=1;
                }
                for($i;$i<=$count_month;$i++){
                    $year = floor($i/12);
                    $month= $i%12;
                    if($month==0){
                        $month = 12;
                        $year  = $year-1;
                    }
                    $year = 2016+$year.'-'.$month;
                    $year = strtotime($year);
                    $year = date('Y-m',$year);
                    $first_day = date('Ym', strtotime($year));
                    $last_day  = date('Y-m-d', strtotime(date('Y-m-01', strtotime($year)) . ' +1 month -1 day'));
                    $days = date('d', strtotime(date('Y-m-01', strtotime($year)) . ' +1 month -1 day'));
                    $year_arr[$year]['days']=$days;
                    $year_arr[$year]['first_day']=$first_day;
                    $year_arr[$year]['last_day'] =$last_day;
                }
                $arr_con=json_decode(file_get_contents("userbrowse.txt"),true);


                $visit=array();

                //查询每个月的用户数据
                foreach($year_arr as $key=>$val){
                    $sql="select count_num as count_pv from dym_browse_num where pid=$pid and datetime=".$val['first_day'];
                    $arr = Mod::app()->db->createCommand($sql)->queryRow();
                    $temp_uv=array();
                    if(count($arr_con)) {
                        foreach ($arr_con as $ks => $vs) {
                            if (strtotime($key) <= $vs['c_time'] && $vs['c_time'] <= strtotime($val['last_day']) && $vs['pid'] == $pid) {
                                $temp_uv[] = $vs;
                            }
                        }
                    }
                    if(!$arr['count_pv']) $arr['count_pv']=0;

                    $arr['count_uv']=count($temp_uv);
                    $visit['count_all_pv']+=$arr['count_pv'];
                    $visit['count_all_uv']+=$arr['count_uv'];
                    $temp[$key]=$arr;
                }

                $visit['count_all']=$visit['count_all_uv']+$visit['count_all_pv'];
                    if($visit['count_all']!=0) {
                        $visit['pv_num'] = sprintf("%.2f", $visit['count_all_pv'] / $visit['count_all']);
                        $visit['uv_num'] = sprintf("%.2f", $visit['count_all_uv'] / $visit['count_all']);
                    }else{
                        $visit['pv_num']=0;
                        $visit['pv_num']=0;
                    }
                $visit['count_visit']=$temp;
//                echo "<pre>";
//                print_r($arr_con);
//
//                print_r($visit);
//                echo $count_all_uv;
//                echo $count_all_pv;
//
//                exit;
//                $visit =  $visit = array ( 'count_visit' => array (
//
//                    '2016-04' => array ( 'count_pv' => '1', 'count_uv' => '1',),
//                    '2016-05' => array ( 'count_pv' => 1, 'count_uv' => '1',),
//                    '2016-06' => array ( 'count_pv' => 4565,'count_uv' => '1', ),
//                    '2016-07' => array ( 'count_pv' => 1,'count_uv' => '99', ),
//                    '2016-08' => array ( 'count_pv' => 13600, 'count_uv' => '1',),
//                    '2016-09' => array ( 'count_pv' => '3600','count_uv' => '1', ),
//                    '2016-10' => array ( 'count_pv' => '210','count_uv' => '20', ),
//                    '2016-11' => array ( 'count_pv' => '119','count_uv' => '1', ),
//                ) );
//                print_r($visit);
//                exit;
//                if($pid==1){
//                    $visit = array ( 'count_visit' => array (
//
//                        '2016-04' => array ( 'count_pv' => '3215', 'count_uv' => '10576',),
//                        '2016-05' => array ( 'count_pv' => 2567, 'count_uv' => '8432',),
//                        '2016-06' => array ( 'count_pv' => 1870,'count_uv' => '6546', ),
//                        '2016-07' => array ( 'count_pv' => 3600,'count_uv' => '9706', ),
//                        '2016-08' => array ( 'count_pv' => 4568, 'count_uv' => '12976',),
//                        '2016-09' => array ( 'count_pv' => '3450','count_uv' => '7543', ),
//                        '2016-10' => array ( 'count_pv' => '2466','count_uv' => '7543', ),
//                        '2016-11' => array ( 'count_pv' => '4565','count_uv' => '13347', ),
//                    ) );
//                }
 
                break;
        }

        $config['site_title'] = '应用数据-大楚用户开放平台首页';
        $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
        $config['config']['site_description'] ="大楚用户开放平台首页";
        $config['active_1'] = '1';
        $config['tab']=$tab;
        $config['pid']=$pid;
        $parame = array (
            'project_list'=>$project_list,
            'view'=> $project_model,
            'config'=>$config,
            'behavior'=>$behavior,
            'user'=>$user,
            'point'=>$arr_user,
            'visit'=>$visit,
            'activity'=>$activity,
            'pid'=>$pid
        );
        // echo "<pre>";
//         var_dump($behavior['behavior']);exit;
        $this->render('appmgt', $parame);
    }
 
    public function actionAppinfo(){
       // $pid = Mod::app()->request->getParam('id');
        $pid = Tool::getValidParam('id','integer');
        $config['pid'] = $pid;
//        echo $pid;die;
        $project_model = Project::model()->findByPk($pid);

        if($this->memberverify($project_model->mid)){
            $this->redirect('/project/prolist');
        }
        if(Mod::app()->request->isPostRequest){
//            die('1231');
            $data = $_POST;
 
            //不能直接把数组给attributes  但是可以单独的给key赋值
        /*    foreach($project_model->attributes as $k=>$v){
                isset($data[$k]) && $project_model->$k = $data[$k];
            }*/
            $project_model->updatetime = time();
            $project_model->name = Tool::getValidParam('name');
            $project_model->wechat_url = Tool::getValidParam('wechat_url');
            $project_model->introduction = Tool::getValidParam('introduction');
            $project_model->url = Tool::getValidParam('url');
            $project_model->type = Tool::getValidParam('type');
           // $project_model->id = Tool::getValidParam('id');
            if($project_model->save()){
                echo json_encode(array('state'=>200,'mess'=>'修改成功!'));
            }else{
                echo json_encode(array('state'=>101005,'mess'=>'修改失败!'));
            }
        }else {
            //获取项目列表
            $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
            $config['active'] = 'iactive';
            $config['active_1']='3';
            $config['site_title'] = '应用配置-大楚用户开放平台首页';
            $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
            $config['config']['site_description'] ="大楚用户开放平台首页";
            $AlcClassModel = Application_class::model();
            $criteria = new CDbCriteria();
            $criteria->order = 'updatetime DESC';
            $typeList = $AlcClassModel->findAll($criteria);
            $this->render('appinfo',array('project_list'=>$project_list,'view'=> $project_model,'config'=>$config,'type'=>$typeList));
        }
 
    }
 
    public function actionSetting(){
       // $pid = Mod::app()->request->getParam('id');
        $pid = Tool::getValidParam('id','integer');

        $config['pid'] = $pid;

        $project_model = Project::model()->findByPk($pid);
 
        //
        if($this->memberverify($project_model->mid)){
            $this->redirect('/project/prolist');
        }        //

 
        if(Mod::app()->request->isPostRequest){
            $data = $_POST;
            //不能直接把数组给attributes  但是可以单独的给key赋值
            foreach($project_model->attributes as $k=>$v){
                isset($data[$k]) && $project_model->$k = Tool::getValidParam($k,'string');
            }
            $project_model->updatetime = time();
            if($project_model->save()){
                echo json_encode(array('state'=>200,'mess'=>'修改成功!'));
            }
        }else {
            //获取项目列
            $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
            $config['active_1']='4';
            $config['site_title'] = '接口配置-大楚用户开放平台首页';
            $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
            $config['config']['site_description'] ="大楚用户开放平台首页";
            $this->render('setting',array('project_list'=>$project_list,'view'=> $project_model,'config'=>$config));
        }
    }
 
    /**
     * 添加项目弹窗
     */
//    public function actionAddIframe(){
//
//        $this->render('add_iframe');
//    }
//
    /**
     * 修改项目iframe
     */
//    public function actionModifyIframe(){
//      $pid = Mod::app()->request->getParam('pid');
//      $project_model = Project::model()->findByPk($pid);
//
//      $this->render('modify_iframe',array('model'=>$project_model));
//    }
 
 
 
//    // http://localhost/ucenter/project/validation?appid=100023&appkey=ede9b4e37eab8619
//    public function actionValidation(){
//        $appId = trim(Tool::getValidParam('appid','integer'));
//        $appKey = trim(Tool::getValidParam('appkey','string'));
//
//        $Project = Project::model()->find('appid ="'.$appId.'"' );
//
//        if($Project){
//            if ($Project->appkey == $appKey){
//                echo json_encode(array('state'=>0,'mess'=>'validation  success!'));
//                return;
//            }
//        }
//        echo json_encode(array('state'=>101005,'mess'=>'appid and appkey is not match!'));
//    }
 
 
    /**
     * 完善个人信息
     */
   /* public function actionShowInfo()
    {
      /* // echo "建设中";exit;
        $mid = Mod::app()->session['member']['id'];
        $member = Member::model()->findByPk($mid);
        $back_url =  Mod::app()->request->urlReferrer;

        $this->render('add_iframe',array('member'=>$member,'back_url'=>$back_url));
    }*/
    /**
     * 删除创建的项目
     * */
    public function actionDel_project(){
        //$id = Mod::app()->request->getParam('id');
        $id = Tool::getValidParam('id','integer');
        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($id);
        if($this->member['id'] !=   $projectinfo['mid'] ){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $project_model=new Project;
        $res = $project_model->deleteAll( 'id IN(' . $id . ')');
        if($res){
            $array = array(
                'code'=>1,
                'msg'=>'删除成功'
            );
        }else{
            $array = array(
                'code'=>0,
                'msg'=>'删除失败'
            );
        }
        echo json_encode($array);
    }
 
    /**
     * 验证域名
     */
    public function actionAddrTest()
    {
        $pid = Tool::getValidParam('id','integer');
        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($pid);
        if($this->member['id'] !=   $projectinfo['mid'] ){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $project_model = Project::model()->findByPk($pid);
        $url=$project_model->attributes['url'];
        if(!$url){
            echo json_encode(array("code" => -1, "msg" => "验证失败"));exit;
        }
        if((strpos($url,"http://") == 0 || strpos($url,"https://") == 0 ) && $url != '#' ) {
            $str = '<meta name="dachuw" content="dcw_' . $pid . '">';
//        $urls = '<h3><meta name="dachuw" content="dcw_23">';
            if (strstr(file_get_contents($url), $str)) {
                $update_data = array(
                    'status' => 1
                );
                $where = array(
                    'id' => $pid
                );
                Mod::app()->db->createCommand()->update('dym_project', $update_data, 'id=:id', $where);
                echo json_encode(array("code" => 200, "msg" => "验证成功"));
            } else {
                echo json_encode(array("code" => -1, "msg" => "验证失败"));
            }
        }else{
            echo json_encode(array("code" => -1, "msg" => "验证失败"));
 
        }
 
 
    }
    /**
     * 刷新Appsecret和access_token
     */
    public function actionUpdateAppsecret(){
        $pid = trim(Tool::getValidParam('pid','integer'));
        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($pid);
        if($this->member['id'] !=   $projectinfo['mid'] ){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        $project_model = Project::model()->findByPk($pid);
 
        //生成新的appsecret
        $mtime=explode(' ',microtime());
        $startTime="$mtime[1]"."$mtime[0]";
        $genStr = $startTime;
        $appsecret = md5($genStr); // 16位MD5加密
 
        // 判断是否appkey是否已经存在
        $project_model_app = Project::model()->find('appsecret ="'.$appsecret.'"' );
        while ($project_model_app){
            $appsecret = md5($genStr."1");
            $appsecret = md5($genStr);
            $project_model_app = Project::model()->find('appsecret ="'.$appsecret.'"' );
        }
        $data['appsecret']=$appsecret;
 
 
        //开启事务
        $transaction=Mod::app()->db->beginTransaction();
 
        try{
            //不能直接把数组给attributes  但是可以单独的给key赋值
            foreach($project_model->attributes as $k=>$v){
                isset($data[$k]) && $project_model->$k = $data[$k];
            }
            $project_model->updatetime = time();
            $project_model->save();
 
            //生成新的access_token
            $expires_in = mt_rand(86400,100000);
            $str = Tool::getrandtoken($project_model->attributes['id']);
            Mod::app()->memcache->set($str,$project_model->attributes['id'],$expires_in-100);//通过access_token设置project_id;
            Mod::app()->memcache->set('project_access_token_'.$project_model->attributes['id'],$str,$expires_in-100);//设置access_token
            $returnCode['code'] = 200;
            $returnCode['appsecret']=$appsecret;
            $returnCode['access_token'] = $str;
            $returnCode['expires_in'] = $expires_in;    //凭证有效时间，单位：秒
            $transaction->commit();
            echo json_encode($returnCode);
        }catch(Exception $e){ //如果有一条查询失败，则会抛出异常
            $transaction->rollBack();
            echo json_encode(array('state' => -1, 'mess' => '刷新失败'));
        }
 
 
    }
    /*
        修改微信自定义链接
    */
    public function actionUpdateWecharurl(){
        $pid = trim(Tool::getValidParam('pid','integer'));
        $wechaturl = trim(Tool::getValidParam('wechaturl','string'));
        $wx_appsecret = trim(Tool::getValidParam('wx_appsecret','string'));
        $wx_appid = trim(Tool::getValidParam('wx_appid','string'));
        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($pid);
        if($this->member['id'] !=   $projectinfo['mid'] ){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
 
        $project_model = Project::model()->findByPk($pid);
 
        $transaction=Mod::app()->db->beginTransaction();
 
        try{
            $project_model->wx_appid = $wx_appid;
            $project_model->wx_appsecret = $wx_appsecret;
 
//            $project_model->wechat_url = $wechaturl;
            $project_model->updatetime = time();
            $project_model->save();
            echo json_encode(array('code' => 200, 'mess' => '更新成功'));
        }catch(Exception $e){ //如果有一条查询失败，则会抛出异常
            $transaction->rollBack();
            echo json_encode(array('state' => -1, 'mess' => '刷新失败'));
        }
 
    }
 
    public function actionActivityall(){
        $pid = trim(Tool::getValidParam('pid','integer'));
        $config['active_1'] = '2';
        $config['site_title'] = '活动组件-大楚用户开放平台首页';
        $config['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网,活动组件";
        $config['config']['site_description'] ="大楚用户开放平台首页";
 
 
        $this->render('activityall',array('pid'=>$pid, 'config'=>$config));
    }
 
 
}