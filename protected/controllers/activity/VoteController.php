<?php
/**
 *
 * @author yuwanqiao
 * 用户投票控制器
 *
 */
class VoteController extends FrontController{
    public function init(){
        parent::init();

        $this->activity_permissions('scratch');

    }
    /**
     *@author yuwanqiao
     *活动预览页面
     */
    public function actionView(){

//        file_put_contents( 'debug.txt','访问域名：'.Mod::app()->request->hostInfo.'     访问IP：'.Mod::app()->request->userHostAddress. "\r\n",FILE_APPEND);

        $id = trim(Tool::getValidParam('id','integer'));
        $page = trim(Tool::getValidParam('page','integer'));
        $start = $page*4;
        $token = trim(Tool::getValidParam('accesstoken','string'));
        $pid= trim(Tool::getValidParam('pid','integer'));
        if(!$id){
            $this->redirect('/project/prolist');
            exit;
        }
        //查询投票信息
        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$info || empty($info)){die('非法请求');}


        if($this->member['id']){//登录状态
            $mid = $this->member['id'];
        }
        
        Browse::add_activity_browse($info['pid'],$id,"vote");

        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);



        //根据活动id查询活动信息
        //查询一条数据
        $sql = "SELECT * FROM dym_activity_vote WHERE id=$id";
        $vote=Mod::app()->db->createCommand($sql)->queryRow();
        $end_time = $vote['end_time'];

        $results= Activity_vote::activityStatus($vote['start_time'],$vote['end_time']);

        if($results['status']!=1){
            $end_activity=$results['message'];
        }


        /*搜索参赛选手*/

        $search=trim(Tool::getValidParam('search','string'));

        if($search){
            if(intval($search)==0){//如果是名字  就==0
                $where=" WHERE title like ".'\'%'.$search.'%\''." AND voteid=$id and  status=1 and whojoin=0";
            }else{
                $ids=intval($search);
                $where=" WHERE id=$ids AND status=1 and whojoin=0";
            }
        }else{
            $where=" WHERE voteid=$id AND status=1 and whojoin=0  order by vote_number desc   LIMIT $start,4 ";
            /* $where=" WHERE voteid=$id AND status=1 and whojoin=0";*/
        }

        //根据活动id 查询参赛的人
        $sql = "SELECT * FROM {{activity_vote_join}} $where";
        $votelist=Mod::app()->db->createCommand($sql)->queryAll();


        //判断该用户是否投票
        if(!$mid){
            $mid=0;
        }
        $t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));
        foreach($votelist as $k=>$v){
            if($vote['rule']==1){
                $sql = "SELECT * FROM {{activity_vote_user}} WHERE joinid=".$v['id']." AND mid= ".$mid." AND voteid=".$id." AND status=1";
            }elseif($vote['rule']==2){
                $sql = "SELECT * FROM {{activity_vote_user}} WHERE joinid=".$v['id']." AND mid= ".$mid." AND voteid=".$id." AND status=1 and create_time between $start and $end";
            }
            $isjoin=Mod::app()->db->createCommand($sql)->queryRow();
            if($isjoin){
                //验证持有票数
                $isjoin=Mod::app()->db->createCommand($sql)->queryAll();
                $count= count($isjoin);

                if($count>0 && $count<$vote['hold_vote']){
                    $votelist[$k]['isjoin']= "bg2";
                }else{
                    $votelist[$k]['isjoin']= "bg1";
                }

            }else{
                $votelist[$k]['isjoin']= "bg2";
            }

        }


        //根据活动id 查询投票的人数
        $sql = "SELECT mid FROM {{activity_vote_user}} WHERE voteid=$id AND status=1 GROUP BY mid";
        $usernum=Mod::app()->db->createCommand($sql)->queryAll();

        //我已投票数
        $sql = "SELECT mid FROM {{activity_vote_user}} WHERE voteid=$id AND status=1";
        $myed=Mod::app()->db->createCommand($sql)->queryAll();
        $i=0;
        foreach($myed AS $k=>$v){
            $re=array_intersect(array('mid'=>$mid),$v);
            if($re){
                $i++;
            }
        }

        //查询参与选手数量
        $sql = "SELECT count(id) as id FROM {{activity_vote_join}}  WHERE voteid=$id AND status=1 and whojoin=0 ";
        $votenum=Mod::app()->db->createCommand($sql)->queryRow();


        $count=ceil(intval($votenum['id'])/3);


        $sql = "SELECT * FROM {{activity_vote_join}} where status=1 and whojoin=1 and voteid=$id and mid=$mid";
        $voucher=Mod::app()->db->createCommand($sql)->queryAll();

        //根据需求，每个用户只能上传一篇作品
        $re= Activity_vote_join::model()->find("mid=:mid AND status=:status and voteid=:voteid",array(':mid'=>$this->member['id'],':voteid'=>$id,':status'=>1));
        //如果有返回值，说明用户自己已经投了参赛作品
        $is_join=$re?1:0;

        $mids = $this->member['id'];
        if($mids){
            $mids=1;
        }
        if(!empty($page) && empty($search)){
            if($votelist){
                echo json_encode($votelist);  //转换为json数据输出
            }else{
                echo json_encode(0);
            }
            die();
        }elseif(!empty($page) && !empty($search))
        {
            echo json_encode(0);
            die();
        }


        $parame = array(
            'info'=>$info,
            'id'=>$id,
            'pid'=>$info['pid'],
            'vote'=>$vote,
            'count'=>$count,
            'is_join'=>$is_join,
            'isshow'=>$vote['isshow'],
            'voucher'=>$voucher[0],
            'end_activity'=>$end_activity,
            'signPackage'=>$signPackage,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $mid,
                "status" => $mid,
                "mid" => $mid,
                "mids" => $mids
            ),
            'votelist'=>$votelist,
            'joinnum'=>$votenum['id'],
            'usernum'=>count($usernum),
            'mynum'=>$i,
            'search'=>$search,
        );
        $this->render('view',$parame);

    }

    /**
     * @abstract 报名专题接口数据
     * @author Fancy
     */

    public function actionViews(){
        $id= trim(Tool::getValidParam('id', 'integer'));
        $page = trim(Tool::getValidParam('page','integer',1));
        $pagesize = trim(Tool::getValidParam('pagesize','integer',10));
        if($page<=0){$page=1;}
        $start = ($page-1)*$pagesize;

        //排行榜
        $sql = "SELECT * FROM {{activity_vote_join}} WHERE voteid=$id AND status=1 and whojoin=0 order by vote_number desc limit $start,$pagesize";
        $votelist=Mod::app()->db->createCommand($sql)->queryAll();
        foreach($votelist as $k=>$v) {
            $votelist[$k]['img'] = $this->_siteUrl . '/' . $votelist[$k]['img'];
        }

        if($votelist){
            echo "flightHandler(".json_encode($votelist).")";  //转换为json数据输出
        }else{
            echo "flightHandler(".json_encode(0).")";
        }


    }

    /**
     * @abstract 报名专题排行榜数据接口
     * @author Fancy
     */
    public function actionRankings(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id= trim(Tool::getValidParam('id', 'integer'));
        $page = trim(Tool::getValidParam('page','integer'));
        $start = $page*3;
        $sql = "SELECT * FROM {{activity_vote_join}} WHERE voteid=$id AND status=1 and whojoin=0 limit $start,3";
        $votelist=Mod::app()->db->createCommand($sql)->queryAll();
        foreach($votelist as $k=>$v) {
            $votelist[$k]['img'] = $this->_siteUrl . '/' . $votelist[$k]['img'];
        }
        if($votelist){
            echo "flightHandler(".json_encode($votelist).")";  //转换为json数据输出
        }else{
            echo "filightHandler(".json_encode(0).")";
        }
    }
    /**
     * @abstract 参与投票审核
     * @author Fancy
     */
    public function actionCheck(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('id','integer'));
        $whojoin = trim(Tool::getValidParam('whojoin','integer'));
        $msgInfo = Activity_vote_join::model()->find('id=:id', array(':id'=>$id));
        if(!empty($msgInfo)){
            if($whojoin==1){
                $msgInfo->whojoin = 0;
            }else{
                $msgInfo->whojoin = 1;
            }
            if ($msgInfo->save()) {
                $returnData = '100';
            }
        }
        echo $returnData;
    }


    /**
     * @author 后台添加的投票活动列表
     *  投票活动详情
     */
    public function actionlist(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动所属的应用的id
        $pid = trim(Tool::getValidParam('pid','integer'));
        if( !$pid){
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
        //投票活动列表
        $as_list = Activity_vote::model()->getActivityListPager($pid);
//        if(!$as_list['count']){
//            $redirect_url = Mod::app()->baseUrl.'/activity/vote/add/pid/'.$pid;
//            $this->redirect($redirect_url);
//        }
        $config['site_title'] = '投票-大楚用户开放平台';
        $config['active_1']=3;
        $config['active'] =5;
        $config['pid']=$pid;
        $parame = array(
            'project_list'=>$project_list,
            'view'=> $project_model,
            'asList'=>$as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count'=>$as_list['count'],
            'config'=>$config
        );
        $this->render('list_vote',$parame);
    }
    /**
     *
     * @author yuwanqiao
     * 后台添加投票活动
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
                $sql = "select * from {{activity_vote}} where id=$activity_id";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else if($pid){//添加 //添加必带项目ID
                if(!$pid) die('非法访问');
                $projectinfo =  JkCms::getprojectByid($pid);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }
            //end权限

            foreach($data as $k=>&$value){
                $value=Safetool::SafeFilter($value);
            }


            $data['start_time']=strtotime(trim(Tool::getValidParam('start_time','string')));
            $data['end_time']  =strtotime(trim(Tool::getValidParam('end_time','string')));
            $desc=trim(Tool::getValidParam('desc','string'));
            $background=trim(Tool::getValidParam('background','string'));
            //处理换行
            $data['desc'] = str_replace('\n',"<br>",$desc);
            $data['desc'] = str_replace('\r\n',"<br>",$desc);
            $data['desc'] = str_replace('\r',"<br>",$desc);

            $data['background'] = str_replace('\n',"<br>",$background);
            $data['background'] = str_replace('\r\n',"<br>",$background);
            $data['background'] = str_replace('\r',"<br>",$background);

            if(!$data['share_img']){
                unset($data['share_img']);
            }
            $sql = "SHOW FULL FIELDS FROM dym_activity_vote";
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
                $query = Mod::app()->db->createCommand()->update('dym_activity_vote',$arr,'id=:id', $update_id);
                $str ='编辑';
            }else{
                $arr['create_time']  =time();
                $arr['update_time']  =time();
                $query = Mod::app()->db->createCommand()->insert('dym_activity_vote',$arr);
                $str ='添加';
                if($query){
                    //新增加活动之后发送消息
                    $id= Mod::app()->db->getLastInsertID();
                    $tablename="vote";
                    $url=$this->_siteUrl."/activity/vote/view/id/".$id;
                    $this->my_message("投票活动[".$data['title']."]",time(),"新增",$data['pid'],$url,$tablename);
                }
            }
            if($query){
                $res = array(
                    'statue'=>1,
                    'msg'   =>$str.'活动成功'
                );
            }else{
                $res = array(
                    'statue'=>0,
                    'msg'   =>$str.'投票失败'
                );
            }
            echo json_encode($res);
        }else{
            //获取点击编辑是得到的活动id
            $fid = trim(Tool::getValidParam('fid', 'integer'));
            $pid = trim(Tool::getValidParam('pid', 'integer'));

            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid']) || !$this->member['pstatus']){
                die('非法访问');
            }

            if ($fid) {
                //start所属权限开始
                $sql = "select * from {{activity_vote}} where id=$fid";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    $this->redirect(Mod::app()->request->getHostInfo());
                    exit;
                }
                //end权限
                //查询活动数据
                $sql = "select * from dym_activity_vote where id=$fid";
                $result = Mod::app()->db->createCommand($sql);
                $query = $result->queryAll();
                $formsql = "SELECT id,title,forms,shows,requires,list FROM {{activity_vote_form}} WHERE voteid=".$fid." AND status=1";
                $formslist=Mod::app()->db->createCommand($formsql)->queryAll();
                $tmp = array();
                foreach($formslist as $key=>$val){
                    $tmp[$val['id']]['id'] = $val['id'];
                    $tmp[$val['id']]['title'] = $val['title'];
                    $tmp[$val['id']]['list'] = $val['list'];
                    $tmp[$val['id']]['forms'] = $val['forms'];
                    $tmp[$val['id']]['shows'] = $val['shows'];
                    $tmp[$val['id']]['requires'] = $val['requires'];
                    $sqlss = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
                    $arr=Mod::app()->db->createCommand($sqlss)->queryAll();
                    $questionlist = "";
                    $qid = "";
                    $count = count($arr);
                    for($i = 0; $i < $count; $i++){
                        $questionlist .=$arr[$i]['question'].'_';
                        $qid .= $arr[$i]['id'].'_';
                    }
                    $questionlist = substr($questionlist,0,-1);
                    $qid = substr($qid,0,-1);
                    $tmp[$val['id']]['question'] =  $questionlist;
                    $tmp[$val['id']]['qid'] =  $qid;
                }
            }else{
                $query = array();

            }

            //参与抽奖 默认是刮刮卡的
            $activityscratch=Activity_scratch::model()->findAll("pid=:pid",array(":pid"=>$pid));

            //获取当前项目
            $project_model = Project::model()->findByPk($pid);
            //获取项目列表
            $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
            //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
            $config['active_1'] ='3';
            //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、投票(3)
            $config['active']=5;
            $config['site_title']='活动组件-大楚用户开放平台';
            $config['pid']=$pid;
            $psql = "SELECT p.type,a.id,a.name from {{project}} as p LEFT JOIN {{application_tag}} as a on p.type=a.classid WHERE p.id=$pid order by a.updatetime desc";
            $ptag = Mod::app()->db->createCommand($psql);
            $tag = $ptag->queryAll();
            $ptags=explode('_',substr($query[0]['tag'],0,-1));

            $parame = array(
                'project_list'=>$project_list,
                'view'=> $project_model,
                'fid'=> $fid,
                'config'=>$config,
                'activity_info'=>$query[0],
                'ptag'=>$ptags,
                'formslist'=>$tmp,
                'tag'=>$tag,
                'pid'=>$pid,
                'activityscratch'=>$activityscratch,
                'status'=>$this->activity_status('poster'),
            );
            $this->render('add_vote',$parame);
        }
    }
    /**
     * @author 删除投票活动
     *
     */
    public function actionDelete() {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('fid','integer'));
        if(!$id){
            $this->redirect('/project/prolist');
            exit;
        }

        //防止ID遍历
        $respcck=Activity_vote::model()->findByPk($id);
        $projectinfo =  JkCms::getprojectByid($respcck->pid);
        if($this->memberverify($projectinfo['mid'])){
            $mess = array('errorcode'=>1,'status'=>'fail');
            echo json_encode($mess);
            exit;
        }


        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_vote', 'id=:id',$where);
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
        $activity_id = $id;
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_vote}} where id=$activity_id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限

        //type 1表是设置开始 2表示设置结束
        $type=Tool::getValidParam('type');
        if($type==1){
            $str = '开始';
            $arr       = array('start_time'=>time());
        }
        if($type==2){
            $str = '结束';
            $arr       = array('end_time'=>time());
        }
        $update_id = array(':id'=>$id);
        $query = Mod::app()->db->createCommand()->update('dym_activity_vote',$arr,'id=:id', $update_id);
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
     * 用户提交的投票信息
     */
    public function actionAddUser(){
        $uname  = trim(Tool::getValidParam('uname','string'));
        $utel   = trim(Tool::getValidParam('utel','string'));
        // $ucount = trim(Tool::getValidParam('ucount','integer'));
        $openid = trim(Tool::getValidParam('openid','string'));
        $pid    = trim(Tool::getValidParam('pid','integer'));
        $appid  = trim(Tool::getValidParam('appid','integer'));
        // $mid  = trim(Tool::getValidParam('mid','integer'));
        $mid = $this->member['id'];

        if(!$mid){
            $this->redirect('/project/prolist');
            exit;
        }
        $sql = "SELECT * FROM dym_activity_vote_user WHERE openid='".$openid."' and pid=$pid";
        $users=Mod::app()->db->createCommand($sql)->queryRow();
        if($users){
            $return_res=array(
                'code'=>2,
                'msg' =>'您已经投票过了'
            );
        }else{
            $arr = array(
                'uname'=>$uname,
                'utel' =>$utel,
                // 'ucount'=>$ucount,
                'openid'=>$openid,
                'pid'=>$pid,
                'appid'=>$appid,
                'mid'=>$mid,
                'add_time'=>time()
            );
            $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_user',$arr);
            if($query){
                $return_res=array(
                    'code'=>1,
                    'msg' =>'投票成功'
                );
            }else{
                $return_res=array(
                    'code'=>0,
                    'msg' =>'投票失败'
                );
            }
        }
        echo json_encode($return_res);
    }
    /**
     * @author yuwanqiao
     * 获取用户投票活动列表
     */
    public function actionAddList(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $vid = trim(Tool::getValidParam('fid', 'integer'));
        $title = trim(Tool::getValidParam('title', 'string'));
        $username = trim(Tool::getValidParam('username', 'string'));
        $activity_id = $vid;
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_vote}} where id=$activity_id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限
        //投票的用户
        $as_list = Activity_vote_user::model()->getUserListPager($vid,$username);
        if($this->member['id']){//登录状态
            $mid = $this->member['id'];
        }else{
            $mid=0;
        }
        //报名的用户
        $signuser=  Activity_vote_join::model()->getVoteListPager($vid,$username);
        foreach($signuser['criteria'] as $k=>$v){
            $mem= Member::model()->findByPk($v->mid);
            if($mem){
                $user['create_time']=$v->create_time;
                $user['name']=$mem->name;
                $user['username']=$mem->username;
                $user['id']=$v->id;
                $users[]=$user;
            }else{
                $users[]=array();
            }

        }
        $signuser['users']=$signuser['criteria'];
        $signuser['id']=$vid;
        $signuser['title']=$title;
        $signuser['username']=$username;
        $this->render('addlist',$signuser);
    }
    /**
     * @author yuwanqiao
     * 导出活动投票用户的数据列表CSV
     */
    public function actionExportCsv(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            die('非法访问');
        }
        $vid = trim(Tool::getValidParam('fid', 'integer'));
        if(!$vid){die('非法访问');}
        $title = trim(Tool::getValidParam('title', 'string'));
        $activity_id = $vid;
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_vote}} where id=$activity_id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限
        $as_list = Activity_vote_user::model()->getUserListPager($vid);
        if($this->member['id']){//登录状态
            $mid = $this->member['id'];
        }else{
            echo "没有登录！";exit;
        }

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
                $signuser['criteria']=  Activity_vote_join::model()->findAll("voteid=:voteid and create_time>:starttime and create_time<:endtime",array(':voteid'=>$vid,':starttime'=>$start,':endtime'=>$end));
                break;
            case 2:
                $signuser['criteria']=  Activity_vote_join::model()->findAll("voteid=:voteid and status=:status",array(':voteid'=>$vid,':status'=>1));
                break;
            default:
                //报名的用户
                $signuser=  Activity_vote_join::model()->getVoteListPager($vid);
        }
        if(empty($signuser) || !is_array($signuser) || !$signuser['criteria']){
            echo "暂时没有数据不能导出";
            exit;
        }
        foreach($signuser['criteria'] as $k=>$v){
            $user['create_time']=$v->create_time;
            $user['phone']=$v->phone;
            $user['title']=$v->title;
            $user['id']=$v->id;
            $users[]=$user;
        }

        $as_list['users']=$users;

        $list = array();
        if($as_list['users']) {
            foreach ($as_list['users'] as $k => $v) {
                $list[$k]['活动id'] = $v['id'];
                $list[$k]['名称']= $v['title'];
                $list[$k]['用户手机'] = $v['phone'];
                $list[$k]['报名时间'] = date('Y-m-d H:i:s',$v['create_time']);
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
        Mod::app()->getRequest()->sendFile('参与活动用户列表.csv', $output, "text/csv", false);
        exit();

    }

    /*活动说明*/
    public function actionIntroduce(){
        $id= trim(Tool::getValidParam('id', 'integer'));
        $pid= trim(Tool::getValidParam('pid', 'integer'));
        $project_list = Activity_vote::model()->find("id=:id",array(":id"=>$id));

        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);



        $info['title'] =  strip_tags($info['title']);


        $param=array(
            'info'=>$info,
            'signPackage'=>$signPackage,
            'id'=>  $id,
            'pid'=>  $pid,
            'desc'=>  $project_list->desc,
            'isshow'=>  $project_list->isshow,
            'background'=>  $project_list->background,
            'img'=>  $project_list->img,
            'param' => array(
                "mid" => $this->member['id'],
            ),
        );
        $this->render('introduce',$param);
    }


    /*参赛宣言*/
    public function actionDetails(){


        $code=trim(Tool::getValidParam('code', 'string'));
        $id= trim(Tool::getValidParam('id', 'integer'));
        $vid= trim(Tool::getValidParam('vid', 'integer'));
        $mid=$this->member['id'];
        if(!$mid){
            $mid=0;
        }
        $sql = "SELECT * FROM {{activity_vote_join}} WHERE id=$id AND voteid=$vid AND status=1";
        $join=Mod::app()->db->createCommand($sql)->queryRow();


        //排名
        $sql = "SELECT id FROM {{activity_vote_join}} WHERE  voteid=$vid AND status=1 order by vote_number desc";
        $list=Mod::app()->db->createCommand($sql)->queryAll();

        //查询投票信息
        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$vid";
        $info=Mod::app()->db->createCommand($sql)->queryRow();

        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

        foreach($list as $k=>$v){
            if($v['id']==$join['id']){
                $join['top']=$k+1;
            }
        }
        $sqljoin = "SELECT * FROM {{activity_vote_user}} WHERE joinid=".$id." AND mid= ".$mid." AND voteid=".$vid." AND status=1";


        $t=time();
        $id=trim(Tool::getValidParam('id', 'integer'));
        $vid=trim(Tool::getValidParam('vid', 'integer'));
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));

        if($info['rule']==1){
            $sqljoin = "SELECT * FROM {{activity_vote_user}} WHERE joinid=".$id." AND mid= ".$mid." AND voteid=".$vid." AND status=1";
        }elseif($info['rule']==2){
            $sqljoin = "SELECT * FROM {{activity_vote_user}} WHERE joinid=".$id." AND mid= ".$mid." AND voteid=".$vid." AND status=1 and create_time between $start and $end";
        }
        $isjoin=Mod::app()->db->createCommand($sqljoin)->queryRow();
        if($isjoin){
            $isjoin= "bg1";
        }else{
            $isjoin= "bg2";
        }

        $id=trim(Tool::getValidParam('id', 'integer'));
        $vid=trim(Tool::getValidParam('vid', 'integer'));

        $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
        $re=Mod::app()->db->createCommand($sql)->queryRow();

        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$vid,':shows'=>1,':status'=>1);
        $criteria->order = 'createtime asc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();
        foreach($formList['type'] as $key=>$val){
            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
            $questionlist=Mod::app()->db->createCommand($sql)->queryAll();
            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;
            $sqls = "SELECT * FROM {{activity_vote_formjoin}} WHERE formid= ".$val['id']." AND votejoin=".$id." AND status=1 ";
            $res=Mod::app()->db->createCommand($sqls)->queryRow();
            $tmp[$val['id']]['answer']=$res;
            if(strpos($res['message'],'_') == true){
                $tmp[$val['id']]['checkbox']= explode('_',$res['message']);
            }

        }



        $param=array(
            'info'=>$join,
            'pid'=>$info['pid'],
            'id'=>  $id,
            'vid'=>  $vid,
            'join'=>  $join,
            'isjoin'=>  $isjoin,
            'mid'=>  $mid,
            'param' => array(
                "mid" => $this->member['id'],
            ),
            'signPackage'=>$signPackage,
            'formList'=> $tmp,
            'edit'=>  $re,
        );

        $voteinfo=array(
            'info'=>$join,
            'id'=>  $id,
            'vid'=>  $vid,
            'join'=>  $join,
            'isjoin'=>  $isjoin,
            'formList'=> $tmp,
            'edit'=>  $re,
        );
        if(empty($code)){
            $this->render('details',$param);
        }else{
            echo "flightHandler(".json_encode($voteinfo).")";
        }

    }



    /*票数排行*/
    public function actionRanking(){
        $id= trim(Tool::getValidParam('id', 'integer'));
        $pid= trim(Tool::getValidParam('pid', 'integer'));
        $project_list = Activity_vote::model()->find("id=:id",array(":id"=>$id));
        $mid=$this->member['id'];

        //排行榜
        $sql = "SELECT * FROM {{activity_vote_join}} WHERE voteid=$id AND status=1 and whojoin=0 order by vote_number desc";
        $votelist=Mod::app()->db->createCommand($sql)->queryAll();


        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);
        $param=array(
            'id'=>  $id,
            'pid'=>  $pid,
            'info'=>  $info,
            'desc'=>  $project_list->desc,
            'isshow'=>  $project_list->isshow,
            'votelist'=>  $votelist,
            'signPackage'=>$signPackage,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $mid,
                "mid" => $this->member['id'],
            ),
        );

        $this->render('ranking',$param);
    }
    /*我的投票*/
    public function actionmyvote(){
        $mid=$this->member['id'];
        $id= trim(Tool::getValidParam('id', 'integer'));
        $pid= trim(Tool::getValidParam('pid', 'integer'));
        $project_list = Activity_vote::model()->find("id=:id",array(":id"=>$id));
        if($mid==""){
            $mid=0;
        }

        //查询我的投票
        $sql = "SELECT * FROM {{activity_vote_user}} WHERE mid= ".$mid." AND voteid=".$id." AND status=1";
        $mylist=Mod::app()->db->createCommand($sql)->queryAll();



        //查询选手信息
        $sql = "SELECT id FROM {{activity_vote_join}} WHERE voteid=$id AND status=1 ORDER BY vote_number DESC ";
        $list=Mod::app()->db->createCommand($sql)->queryAll();

        //根据我投票的活动id去找到活动信息
        foreach($mylist AS $k=>$v){
            $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$v['joinid']." AND voteid=".$id." AND status=1 order by vote_number desc";
            $re=Mod::app()->db->createCommand($sql)->queryRow();
            if($re){
                foreach($list as $key=>$val){
                    if($val['id']==$re['id']){
                        $re['top']=$key+1;
                    }
                }
                $mylist[$k]['join']=$re;
            }else{
                $mylist[$k]['join']=null;
            }
        }

        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);
        $param=array(
            'id'=>  $id,
            'pid'=>  $pid,
            'info'=>  $info,
            'desc'=>  $project_list->desc,
            'mylist'=>  $mylist,
            'signPackage'=>$signPackage,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $mid,
                "mid" => $mid,
            ),
        );
        $this->render('myvote',$param);
    }

    /*ajax  投票*/
    public function actionajaxvote(){
        if(Mod::app()->request->isAjaxRequest){
            if(!Tool::isMobile()){
                echo -2;
                exit;
            }
            $id= trim(Tool::getValidParam('id', 'integer'));
            $vid= trim(Tool::getValidParam('vid', 'integer'));
            $mid=trim(Tool::getValidParam('mid', 'integer'));
            if(!$id||!$vid||!$mid){
                echo 2;
                exit;
            }
            //查询活动信息
            $sql = "SELECT * FROM {{activity_vote}} WHERE id=$vid";
            $info=Mod::app()->db->createCommand($sql)->queryRow();
                if(!$info){
                    echo -1;exit;
                }
            $results= Activity_vote::activityStatus($info['start_time'],$info['end_time']);

            if($results['status']!=1 && intval($info['end_time'])<intval(time())){
                echo -1;
                exit;
            }

            //插入行为表
            $win = 0;
            $name = "投票";
            $res = Behavior::behavior_points(7,$mid,$info['pid'],$name,$win,$vid,'activity_vote');


            if($res['code']==200) {
                $jifen = array(
                    'pid' => $info['pid'],
                    'mid' => $mid,
                    'qty' => $res['points'],
                    'type' => 1,
                    'createtime' => time(),
                    'content' => '投票积分',
                );
                $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);
            }
            $t = time();
            $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
            $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t));

            if($info['rule']==1){
                $sql = "SELECT * FROM {{activity_vote_user}} WHERE joinid= ".$id." AND voteid=".$vid." AND mid= $mid";
            }elseif($info['rule']==2){
                $sql = "SELECT * FROM {{activity_vote_user}} WHERE joinid= ".$id." AND voteid=".$vid." AND mid= $mid  and create_time between $start and $end";
            }
            $res=Mod::app()->db->createCommand($sql)->queryRow();
            if($res){
                //验证持有票数
                $isjoin=Mod::app()->db->createCommand($sql)->queryAll();
                $count= count($isjoin);
                if($count>0 && $count<$info['hold_vote']){
                    //剩余票数
                    $num= $info['hold_vote']-$count;
                    $num=$num>0?$num:0;
                    $msg=array('code'=>1,'num'=>$num);
                }else{
                    echo 4;
                    exit;
                }

            }else{
                $num= $info['hold_vote'];
                $num=$num>0?$num:0;
                $msg=array('code'=>1,'num'=>$num);
            }

            $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
            $re=Mod::app()->db->createCommand($sql)->queryRow();
            if(!$re){
                echo 3;
                exit;
            }
            $sql = "UPDATE  {{activity_vote_join}} SET vote_number=vote_number+1 WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
            $res=Mod::app()->db->createCommand($sql)->execute();
            if(!$res){;
                echo 3;
                exit;
            }
            $arr=array(
                'mid'=>$mid,
                'voteid'=>$vid,
                'joinid'=>$id,
                'create_time'=>time()
            );
            $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_user',$arr);
            if($query){
                echo json_encode($msg);
                exit;
            }else{
                echo 3;
                exit;
            }
        }else{
            echo -1;
            exit;
        }

    }

    /*投票后台管理*/

    //参赛者列表
    public function actionadmin(){
        $id=trim(Tool::getValidParam('vid', 'integer'));
        //start所属权限开始
        if(!$id){die('非法访问');}
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            die('非法访问');
        }

        //start权限
        //判断是不是自己的所属项目 不是没有权限
        $sql = "select * from {{activity_vote}} where id=$id";
        $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
        if(!$activity_info['pid']){die('数据非法');}
        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($activity_info['pid']);

        if($this->memberverify($projectinfo['mid'])){
            die('非法访问!');
        }
        //end权限


        $votename=trim(Tool::getValidParam('votename', 'string'));
        $whojoins=Tool::getValidParam('whojoins', 'integer','null');
        $as_list = Activity_vote_join::model()->getVoteListPager($id,$votename,$whojoins);
        $param=array(
            'vid'=>  $id,
            'whojoins'=>  $whojoins,
            'list'=>$as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count'=>$as_list['count'],
            'votename'=>$votename,
            'config'=>array(
                'site_title'=>'投票管理-大楚用户开放平台'
            )

        );
        $this->render('admin',$param);

    }
    /**
     * @abstract 添加参赛者
     * @author Fancy
     */
    public function actionAdminAdd(){
        if(!$this->member  ||  !$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id=trim(Tool::getValidParam('id', 'integer'));
        $vid=trim(Tool::getValidParam('vid', 'integer'));
        if(Mod::app()->request->isPostRequest) {
            $data['voteid'] = trim(Tool::getValidParam('vid', 'integer'));
            $data['title'] = trim(Tool::getValidParam('title', 'string'));
            $data['create_time'] = time();
            $data['img'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['remark'] = trim(Tool::getValidParam('remark', 'string'));
            $data['phone'] = trim(Tool::getValidParam('phone', 'string'));
            $data['mid'] = $this->member['id'];


            $sqlv = "SELECT * FROM {{activity_vote}} where id=". $data['voteid'];
            $voteid=Mod::app()->db->createCommand($sqlv)->queryRow();
            $data['whojoin'] = trim(Tool::getValidParam('whojoin', 'integer'))?trim(Tool::getValidParam('whojoin', 'integer')):0;
            if($voteid['component']==0){
                $sqljoin = "SELECT * FROM {{activity_vote_join}} where voteid=".$data['voteid']." and mid=".$data['mid'];
                $joinid=Mod::app()->db->createCommand($sqljoin)->queryRow();
                if(empty($joinid)){
                    $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_join',$data);
                }else{
                    $this->redirect('/activity/vote/signup/id/' . $vid);
                    exit;
                }
            }elseif($voteid['component']==1){
                $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_join',$data);
            }
            if($query){
                $insertid = Mod::app()->db->getLastInsertID();
                $message=$_POST;
                foreach($message as $k=>&$value){
                    $value=Safetool::SafeFilter($value);
                }
                foreach($message as $k=>$v){
                    if($k=="title" || $k=="vid" || $k=="id"||$k=="remark"||$k=="share_img"||$k=="whojoin"||$k=="phone"){
                        unset($message[$k]);
                    }else{
                        if(is_array($v)){
                            $v = implode('_',$v);
                        }
                        $d['voteid']=Safetool::SafeFilter($data['voteid']);
                        $d['votejoin']=Safetool::SafeFilter($insertid);
                        $d['formid']=Safetool::SafeFilter($k);
                        $d['message']=Safetool::SafeFilter($v);
                        $d['status']=1;
                        $d['createtime']=time();
                        $d['updatetime']=time();
                        $forms = Mod::app()->db->createCommand()->insert('dym_activity_vote_formjoin',$d);
                    }
                }

                if($data['whojoin']==0&&$voteid['component']==1){
                    $this->redirect('/activity/vote/admin' . '/vid/' . $vid . '/id/' . $vid);
                    exit;
                }elseif($data['whojoin']==0&&$voteid['component']==0){
                    $this->redirect('/activity/vote/signup/id/' . $vid);
                    exit;
                }else{
                    $this->redirect('/activity/vote/view' . '/id/ '.$vid);
                    exit;
                }
            }
        }



        if($vid){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_vote}} where id=$vid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }
        //end权限


        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$vid,':shows'=>1,':status'=>1);
        $criteria->order = 'createtime asc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();
        foreach($formList['type'] as $key=>$val){
            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
            $questionlist=Mod::app()->db->createCommand($sql)->queryAll();
            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;
        }
        $param=array(
            'id'=>  $id,
            'vid'=>  $vid,
            'formList'=> $tmp,
            'config'=>array(
                'site_title'=>'新增参赛作品-大楚用户开放平台'
            )
        );
        $this->render('adminAdd',$param);
    }

    /**
     * @abstract 上拉加载
     * @author Fancy
     */

    public function actionGetvjoin(){

        $id=trim(Tool::getValidParam('id', 'integer'));
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $page=trim(Tool::getValidParam('page', 'integer'));
        $start = $page*3;
        $sql = "";
        $data=Mod::app()->db->createCommand($sql)->queryAll();
        echo json_encode($data);  //转换为json数据输出

    }

    /**
     * @abstract 新增字段
     * @author Fancy
     */
    public function actionAddForms(){


        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        if(Mod::app()->request->isPostRequest) {
            $data['voteid'] = trim(Tool::getValidParam('id','integer'));
            $data['title'] = trim(Tool::getValidParam('title', 'string'));
            $data['list'] = trim(Tool::getValidParam('list', 'integer'));
            //$data['question'] = trim(Tool::getValidParam('type', 'string'));
            $data['forms'] = Tool::getValidParam('forms', 'integer',0);
            $data['shows'] = Tool::getValidParam('shows', 'integer',0);
            $data['requires'] = Tool::getValidParam('requires', 'integer',0);
            $data['createtime'] = time();
            $data['updatetime'] = time();
            $data['mid'] = $this->member['id'];


            $activity_id = $data['voteid'];
            $pid = trim(Tool::getValidParam('pid', 'integer'));
            if($activity_id){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_vote}} where id=$activity_id";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else if($pid){//添加 //添加必带项目ID
                if(!$pid) die('非法访问');
                $projectinfo =  JkCms::getprojectByid($pid);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }
            //end权限





            $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_form',$data);
            if($query){
                $id= Mod::app()->db->getLastInsertID();
                $type=trim(Tool::getValidParam('type', 'string'));
                $forms['question']=explode('_',$type);
                $forms['formid']=$id;
                $forms['creatime'] = time();
                $forms['updatetime'] = time();
                $forms['status'] = 1;
                foreach($forms['question'] as $v){
                    $forms['question']=$v;
                    if($v!=""){
                        $querys = Mod::app()->db->createCommand()->insert('dym_activity_vote_form_question',$forms);
                    }
                }

                $sql = "SELECT title,forms FROM {{activity_vote_form}} WHERE id= ".$id;
                $re=Mod::app()->db->createCommand($sql)->queryRow();
                if($re){
                    $sqlq = "SELECT id FROM {{activity_vote_form_question}} WHERE formid= ".$id;
                    $qusetion=Mod::app()->db->createCommand($sqlq)->queryAll();
                    $qid = 0;
                    $count = count($qusetion);
                    for($i = 0; $i < $count; $i++){
                        $qid .= $qusetion[$i]['id'].'_';
                    }
                    $qid = substr($qid,1);
                    echo '{"statue":1,"formid":'.$id.',"title":"'.$re['title'].'","qid":"'.$qid.'","forms":'.$re['forms'].',"msg":"添加成功"}';
                    exit;
                }

            }else{
                echo '{"statue":2,"msg":"添加失败"}';
                exit;
            }
        }

    }

    //删除字段
    public function actionDelForms(){

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        if(Mod::app()->request->isPostRequest) {
            $id = trim(Tool::getValidParam('id','integer'));
            $re=Activity_vote_form::model()->findByPk($id);
            if($re){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_vote}} where id=$re->voteid";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }

            $sql = "UPDATE  {{activity_vote_form}} SET updatetime=" . time() . ",status=0  WHERE id=".$id;
            $query = Mod::app()->db->createCommand($sql)->execute();
            if($query){
                echo '{"statue":1,"msg":"删除成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"删除失败"}';
                exit;
            }
        }

    }
    //新增字段设置
    public function actionAddForm(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        $time= time();
        $data = array(
            array(
                'voteid'=>'46','title'=>'姓名','forms'=>'0','shows'=>'1','requires'=>'1','status'=>'1','type'=>'varchar','createtime'=>$time,'updatetime'=>$time
            ),
            array(
                'voteid'=>'46','title'=>'电话','forms'=>'0','shows'=>'1','requires'=>'1','status'=>'1','type'=>'varchar','createtime'=>$time,'updatetime'=>$time
            ),
            array(
                'voteid'=>'46','title'=>'性别','forms'=>'0','shows'=>'1','requires'=>'1','status'=>'1','type'=>'varchar','createtime'=>$time,'updatetime'=>$time
            ),
            array(
                'voteid'=>'46','title'=>'Email','forms'=>'0','shows'=>'1','requires'=>'1','status'=>'1','type'=>'varchar','createtime'=>$time,'updatetime'=>$time
            ),
        );

        for($a=0;$a<count($data);$a++) {
            $message['voteid'] = $data[$a]['voteid'];
            $message['title'] = $data[$a]['title'];
            $message['forms'] = $data[$a]['forms'];
            $message['shows'] = $data[$a]['shows'];
            $message['requires'] = $data[$a]['requires'];
            $message['status'] = $data[$a]['status'];
            $message['type'] = $data[$a]['type'];
            $message['createtime'] = $data[$a]['createtime'];
            $message['updatetime'] = $data[$a]['updatetime'];
            $message['mid'] =$this->member['id'];
            $query = Mod::app()->db->createCommand()->insert('dym_activity_vote_form',$message);
        }
    }
    /**
     * @abstract 修改字段设置
     * @author Fancy
     */
    public function actionEditForms(){

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        if(Mod::app()->request->isPostRequest) {
            $data=$_POST["result"];

            foreach($data as $k=>&$val){
                foreach($val as $k=>&$value){
                    $value=Safetool::SafeFilter($value);
                }
            }
            $time= time();
            // $tmp = array();

            for($a=0;$a<count($data);$a++) {
                $msgInfo['id'] = $data[$a][1];
                $msgInfo['list'] = $data[$a][0];
                $msgInfo['title'] = $data[$a][2];
                $msgInfo['forms'] = $data[$a][3];
                $msgInfo['type'] = $data[$a][4];
                $msgInfo['qid'] = $data[$a][5];
                $type = explode("_",$msgInfo['type']);
                $qid = explode("_",$msgInfo['qid']);
                $msgInfo['shows'] = $data[$a][6];
                $msgInfo['requires'] = $data[$a][7];
                $msgInfo['status'] = 1;
                $msgInfo['updatetime'] = $time;
                $msgInfo['mid'] = $this->member['id'];

                $sql = "UPDATE  {{activity_vote_form}} SET list=".$msgInfo['list'].",title='".$msgInfo['title']."',forms=".$msgInfo['forms'].",shows=".$msgInfo['shows'].",requires=".$msgInfo['requires'].",status=".$msgInfo['status'].",updatetime=".time()." WHERE id= ". $msgInfo['id'];
                $query=Mod::app()->db->createCommand($sql)->execute();

                if($query){
                    //$tmp=array();
                    $formid=$msgInfo['id'];
                    $res = Mod::app()->db->createCommand()->delete('dym_activity_vote_form_question', 'formid=:formid',array(':formid' => $formid));
                    if($res){
                        $i=0;
                        foreach($type as $vals){
                            if($vals!=""){
                                //$tmp[$vals]=$type[$i];
                                /*$sqlq = "UPDATE  {{activity_vote_form_question}} SET question='" .$type[$i]. "',updatetime=" . time() . " WHERE id= ".$vals;
                                $queryq = Mod::app()->db->createCommand($sqlq)->execute();*/
                                $arr = array(
                                    'formid'=>$formid,
                                    'question' =>$vals,
                                    'status'=>1,
                                    'creatime'=>time(),
                                    'updatetime'=>time(),
                                );
                                $queryq = Mod::app()->db->createCommand()->insert('dym_activity_vote_form_question',$arr);
                            }
                            $i++;
                        }

                    }else{
                        $i=0;
                        foreach($type as $vals) {
                            if ($vals != "") {
                                $arr = array(
                                    'formid' => $msgInfo['id'],
                                    'question' => $vals,
                                    'status' => 1,
                                    'creatime' => time(),
                                    'updatetime' => time(),
                                );
                                $queryq = Mod::app()->db->createCommand()->insert('dym_activity_vote_form_question', $arr);
                            }
                            $i++;
                        }
                    }

                }
            }

            if($query){
                echo '{"statue":1,"msg":"修改成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"修改失败"}';
                exit;
            }
        }
    }
    /**
     * @abstract form  类型
     * @author Fancy
     */
    public function actionType(){
        if(Mod::app()->request->isPostRequest) {
            $rowkey=trim(Tool::getValidParam('rowkey', 'integer'));
            $sql = "SELECT * FROM {{activity_vote_form_question}} WHERE formid= ".$rowkey." AND status=1 ";
            $re=Mod::app()->db->createCommand($sql)->queryAll();
            if($re){
                echo '{"statue":1,"ss":'.$re['question'].',"msg":"修改成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"修改失败"}';
                exit;
            }
        }

    }
    /**
     * @abstract 编辑参赛者
     * @author Fancy
     */
    public function actionadminEdit(){

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        if(Mod::app()->request->isPostRequest) {

            $data['voteid'] = trim(Tool::getValidParam('vid', 'integer'));
            $id = trim(Tool::getValidParam('id', 'integer'));
            $data['title'] = trim(Tool::getValidParam('title', 'string'));
            $data['create_time'] = time();
            $data['img'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['phone'] = trim(Tool::getValidParam('phone', 'string'));
            $data['vote_number'] = trim(Tool::getValidParam('vote_number', 'integer'));
            $data['remark'] = trim(Tool::getValidParam('remark', 'string'));
            $whojoin = trim(Tool::getValidParam('whojoin', 'integer'));

            $activity_id =  $data['voteid'];
            $pid = trim(Tool::getValidParam('pid', 'integer'));
            if($activity_id){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_vote}} where id=$activity_id";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else if($pid){//添加 //添加必带项目ID
                if(!$pid) die('非法访问');
                $projectinfo =  JkCms::getprojectByid($pid);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }
            //end权限




            $sql = "UPDATE  {{activity_vote_join}} SET title=".'\''.$data['title'].'\''.",phone=".'\''.$data['phone'].'\''.",vote_number=".'\''.$data['vote_number'].'\''.",remark=".'\''.$data['remark'].'\''.",update_time=".time().",img=".'\''.$data['img'].'\''." WHERE id= ".$id." AND voteid=".$data['voteid'];
            $query=Mod::app()->db->createCommand($sql)->execute();
            if($query){
                $message=$_POST;
                foreach($message as $k=>&$value){
                    $value=Safetool::SafeFilter($value);
                }
                foreach($message as $k=>$v){
                    if($k=="title" || $k=="vid"||$k=="remark"||$k=="share_img"||$k=="id"||$k=="phone"||$k=="whojoin"||$k=="vote_number"){
                        unset($message[$k]);
                    }else{
                        if(is_array($v)){
                            $v = implode('_',$v);
                        }
                        $val['voteid']=$data['voteid'];
                        $val['votejoin']=$data['voteid'];
                        $val['formid']=$k;
                        $val['message']=$v;
                        $sqlf = "UPDATE  {{activity_vote_formjoin}} SET message=".'\''.$val['message'].'\''.",updatetime=".time()." WHERE voteid=".$val['voteid']." AND votejoin=".$id." and formid=".$val['formid'];
                        $forms=Mod::app()->db->createCommand($sqlf)->execute();
                    }
                }
                if($whojoin==1){
                    $this->redirect('/activity/vote/view'.'/id/'.$data['voteid'].'/vid/'.$id);
                    exit;
                }else{
                    $this->redirect('/activity/vote/admin'.'/vid/'.$data['voteid']);
                    exit;
                }
            }
        }

        $id=trim(Tool::getValidParam('id', 'integer'));
        $vid=trim(Tool::getValidParam('vid', 'integer'));


        if($vid){
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_vote}} where id=$vid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                die('非法访问');
            }
        }


        $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
        $re=Mod::app()->db->createCommand($sql)->queryRow();

        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$vid,':shows'=>1,':status'=>1);
        $criteria->order = 'createtime asc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();
        foreach($formList['type'] as $key=>$val){
            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
            $questionlist=Mod::app()->db->createCommand($sql)->queryAll();
            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;
            $sqls = "SELECT * FROM {{activity_vote_formjoin}} WHERE formid= ".$val['id']." AND votejoin=".$id." AND status=1 ";
            $res=Mod::app()->db->createCommand($sqls)->queryRow();
            $tmp[$val['id']]['answer']=$res;
            if(strpos($res['message'],'_') == true){
                $tmp[$val['id']]['checkbox']= explode('_',$res['message']);
            }
        }
        $param=array(
            'id'=>  $id,
            'vid'=>  $vid,
            'edit'=>  $re,
            'formList'=> $tmp,
            'config'=>array(
                'site_title'=>'编辑参赛作品-大楚用户开放平台'
            )
        );

        $this->render('adminEdit',$param);
    }
    //删除参赛者
    public function actionadminDel(){

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        $id=trim(Tool::getValidParam('id', 'integer'));
        $vid=trim(Tool::getValidParam('vid', 'integer'));
        if($id&&$vid) {
            if($vid){
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_vote}} where id=$vid";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }

            $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
            $re=Mod::app()->db->createCommand($sql)->queryRow();
            if($re){
                $sql = "UPDATE  {{activity_vote_join}} SET update_time=" . time() . ",status=0  WHERE id= " . $id . " AND voteid=" . $vid;
                $query = Mod::app()->db->createCommand($sql)->execute();

                if ($query) {
                    $sql = "UPDATE  {{activity_vote_user}} SET status=0  WHERE joinid= ".$id;
                    $querys = Mod::app()->db->createCommand($sql)->execute();
                    if ($querys) {
                        echo '{"errorcode":0,"msg":"删除成功"}';
                        exit;
                    }else{
                        echo '{"errorcode":1,"msg":"删除失败"}';
                        exit;
                    }
                } else {
                    echo '{"errorcode":1,"msg":"删除失败"}';
                    exit;
                }

            }else{
                echo '{"errorcode":2,"msg":"系统错误"}';
                exit;
            }



        }else{
            echo '{"errorcode":2,"msg":"系统错误"}';
        }

    }


    /*
     * 我的报名
     * */
    public function actionMySignup(){
        //查询我的所有报名，按时间倒序,显示最近的10条
        $joinModel = new Activity_vote_join;
        $criteria = new CDbCriteria();
        $criteria->condition = 't.mid=:mid AND vote.component=0';
        $criteria->with = 'vote';
        $criteria->params = array(':mid'=>$this->member['id']);
        $criteria->order = 't.create_time DESC';
        $criteria->limit = 10;
        $list= $joinModel->findAll($criteria);

       
        $parameter=array('mylist'=>$list);
        $this->render('mysignup',$parameter);
    }



    /**
     * @abstract 报名
     * @author Fancy
     */
    public function actionSignup(){
        $id = trim(Tool::getValidParam('id','integer'));
        $token = trim(Tool::getValidParam('accesstoken','string'));
        $pid= trim(Tool::getValidParam('id','integer'));
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


        //查询报名信息
        // var_dump($id);die();
        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$info || empty($info)){die('非法请求');}


        if($this->member['id']){//登录状态
            $mid = $this->member['id'];
        }else{
            $mid=0;
        }

        
        Browse::add_activity_browse($info['pid'],$id,"vote");


        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

        //token验证
        $checkToken = $this->checkToken($project_info['id'],$token);
        // if(!$checkToken || empty($checkToken)){die('token is error');}



        //根据活动id查询活动信息
        //查询一条数据
        $sql = "SELECT * FROM dym_activity_vote WHERE id=$id";
        $signup=Mod::app()->db->createCommand($sql)->queryRow();
        $end_time = $signup['end_time'];
        if($end_time<time()){
            $signup['status']='活动已经结束';
        }

        $sql = "SELECT * FROM dym_activity_vote WHERE id=$id";
        $vote=Mod::app()->db->createCommand($sql)->queryRow();
        $sqlj = "SELECT * FROM dym_activity_vote_join WHERE voteid=$id and mid=".$mid;
        $votejoin=Mod::app()->db->createCommand($sqlj)->queryRow();
        if($votejoin){
            $joinstatus=0;
        }else{
            $joinstatus=1;
        }

        $results= Activity_vote::activityStatus($vote['start_time'],$vote['end_time']);

        if($results['status']!=1){
            $end_activity=$results['message'];
        }

        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$id,':shows'=>1,':status'=>1);
        $criteria->order = 'list desc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();

        foreach($formList['type'] as $key=>$val){

            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
           $questionlist=Mod::app()->db->createCommand($sql)->queryAll();

            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;


        }
        $parame = array(
            'info'=>$info,
            'id'=>$id,
            'pid'=>$info['pid'],
            'signup'=>$signup,
            'joinstatus'=>$joinstatus,
            'votejoin'=>$votejoin,
            'signPackage'=>$signPackage,
            'end_activity'=>$end_activity,
            'formList'=> $tmp,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $mid,
                "status" => $mid,
                "mid" =>  $this->member['id'],

            ),
        );
        $this->render('views',$parame);
    }

    /*
     * 用户参与活动，上传自己的作品*/
    public  function actionParticipate(){
        $id=trim(Tool::getValidParam('id','integer'));
        $vid=trim(Tool::getValidParam('vid','integer'));
        $pid=trim(Tool::getValidParam('pid','integer'));
        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$id,':shows'=>1,':status'=>1);
        $criteria->order = 'list desc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();
        foreach($formList['type'] as $key=>$val){
            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
            $questionlist=Mod::app()->db->createCommand($sql)->queryAll();
            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;
        }
        //根据需求，每个用户只能上传一篇作品
        $vid=$vid?$vid:$id;
        $re= Activity_vote_join::model()->find("mid=:mid AND status=:status and whojoin=:whojoin and voteid=:voteid",array(':mid'=>$this->member['id'],':whojoin'=>1,':voteid'=>$vid,':status'=>1));
        $res= Activity_vote_join::model()->find("mid=:mid AND status=:status and whojoin=:whojoin and voteid=:voteid",array(':mid'=>$this->member['id'],':whojoin'=>0,':voteid'=>$vid,':status'=>1));


        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$vid";
        $info=Mod::app()->db->createCommand($sql)->queryRow();

        $results= Activity_vote::activityStatus($info['start_time'],$info['end_time']);

        $sql = "SELECT * FROM {{activity_vote}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);


        //如果有返回值，说明用户自己已经参与了参赛作品
        $data=array(
            'info'=>$info,
            'signPackage'=>$signPackage,
            'vid'=>$vid,
            'pid'=>$pid,
            'id'=>$id,
            'formList'=> $tmp,
            'param' => array(
                "mid" => $this->member['id'],
            ),
        );
        if($re){
            $this->render('participate',$data);
            Tool::alert('您已成功参与，等待审核','/activity/vote/editParti/id/'.$vid.'/vid/'.$re['id'].'/pid/'.$pid);
            exit;
        }elseif($res){
            $this->render('participate',$data);
            Tool::alert('您已成功参与','/activity/vote/view/id/'.$vid);
            exit;
        }elseif($results['status']!=1 && intval($info['end_time'])<intval(time())){
            $this->render('participate',$data);
            Tool::alert('活动已结束','/activity/vote/view/id/'.$vid);
            exit;
        }elseif($results['status']!=1 && intval($info['end_start'])<intval(time())){
            $this->render('participate',$data);
            Tool::alert('活动未开始','/activity/vote/view/id/'.$vid);
            exit;
        }
        $this->render('participate',$data);
    }

    /**
     * @abstract 用户编辑上传作品
     * @author Fancy
     */
    public function actioneditParti(){
        if(Mod::app()->request->isPostRequest) {

            $data['voteid'] = trim(Tool::getValidParam('id', 'integer'));
            $id = trim(Tool::getValidParam('vid', 'integer'));
            $data['title'] = trim(Tool::getValidParam('title', 'string'));
            $data['create_time'] = time();
            $data['img'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['phone'] = trim(Tool::getValidParam('phone', 'string'));
            $data['remark'] = trim(Tool::getValidParam('remark', 'string'));

            $sql = "UPDATE  {{activity_vote_join}} SET title=".'\''.$data['title'].'\''.",phone=".'\''.$data['phone'].'\''.",remark=".'\''.$data['remark'].'\''.",update_time=".time().",img=".'\''.$data['img'].'\''." WHERE id= ".$id." AND voteid=".$data['voteid'];
            $query=Mod::app()->db->createCommand($sql)->execute();
            if($query){
                $message=$_POST;
                foreach($message as $k=>&$value){
                    $value=Safetool::SafeFilter($value);
                }
                foreach($message as $k=>$v){
                    if($k=="title" || $k=="vid"||$k=="remark"||$k=="share_img"||$k=="id"||$k=="phone"){
                        unset($message[$k]);
                    }else{
                        if(is_array($v)){
                            $v = implode('_',$v);
                        }
                        $val['voteid']=$data['voteid'];
                        $val['votejoin']=$data['voteid'];
                        $val['formid']=$k;
                        $val['message']=$v;
                        $sqlf = "UPDATE  {{activity_vote_formjoin}} SET message=".'\''.$val['message'].'\''.",updatetime=".time()." WHERE voteid=".$val['voteid']." AND votejoin=".$id." and formid=".$val['formid'];
                        $forms=Mod::app()->db->createCommand($sqlf)->execute();
                    }
                }

                if($query){
                    $this->redirect('/activity/vote/admin'.'/vid/'.$data['voteid']);
                    exit;
                }else{
                    echo '{"statue":2,"msg":"编辑失败"}';
                    exit;
                }
            }
        }

        $id=trim(Tool::getValidParam('vid', 'integer'));
        $vid=trim(Tool::getValidParam('id', 'integer'));
        $pid=trim(Tool::getValidParam('pid', 'integer'));


        $sql = "SELECT * FROM {{activity_vote_join}} WHERE id= ".$id." AND voteid=".$vid." AND status=1 ";
        $re=Mod::app()->db->createCommand($sql)->queryRow();

        $formModel = Activity_vote_form::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'voteid=:voteid and shows=:shows and status=:status';
        $criteria->params = array(':voteid'=>$vid,':shows'=>1,':status'=>1);
        $criteria->order = 'createtime asc';
        $formList['type'] = $formModel->findAll($criteria);
        $tmp = array();
        foreach($formList['type'] as $key=>$val){
            $sql = "SELECT * FROM {{activity_vote_form_question}} where formid=".$val['id'];
            $questionlist=Mod::app()->db->createCommand($sql)->queryAll();
            $tmp[$val['id']]['id'] = $val['id'];
            $tmp[$val['id']]['title'] = $val['title'];
            $tmp[$val['id']]['forms'] = $val['forms'];
            $tmp[$val['id']]['question'] = $questionlist;
            $sqls = "SELECT * FROM {{activity_vote_formjoin}} WHERE formid= ".$val['id']." AND votejoin=".$id." AND status=1 ";
            $res=Mod::app()->db->createCommand($sqls)->queryRow();
            $tmp[$val['id']]['answer']=$res;
            if(strpos($res['message'],'_') == true){
                $tmp[$val['id']]['checkbox']= explode('_',$res['message']);
            }
        }

        $param=array(
            'id'=>  $id,
            'vid'=>  $vid,
            'pid'=>  $pid,
            'edit'=>  $re,
            'formList'=> $tmp,
            'param' => array(
                "mid" => $this->member['id'],
            ),
        );
        $this->render('editparti',$param);
    }


    /**
     * @abstract pc  投票PC预览
     * @author Fancy
     */

    public function actionPcview()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));
        $parame = array(
            'id' => $id,
            'config'=>array(
                'site_title'=> '投票活动页面-pc版活动页面-大楚网用户开放平台',
                'Keywords'=>'投票活动页面-pc版活动页面-大楚网用户开放平台',
                'Description'=>'投票活动页面-pc版活动页面-大楚网用户开放平台'
            ),
        );

        $this->render('pcview', $parame);
    }
    /**
     * @abstract pc  报名PC预览
     * @author Fancy
     */

    public function actionPcviews()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));
        $parame = array(
            'id' => $id,
            'config'=>array(
                'site_title'=> '报名活动页面-pc版活动页面-大楚网用户开放平台',
                'Keywords'=>'报名活动页面-pc版活动页面-大楚网用户开放平台',
                'Description'=>'报名活动页面-pc版活动页面-大楚网用户开放平台'
            ),
        );

        $this->render('pcviews', $parame);
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
        $config['model'] = "vote";
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
                    $pvuv[$v['day_date']]['pv'] = $pv['count_num'];
                    $pvuv[$v['day_date']]['uv'] = $uv['count(0)'];

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
                $table_user = "dym_activity_".$config['model']."_user";
                $data['signup'] = Mod::app()->db->createCommand()->select('count(0)')->from('dym_member_activity')->where('aid=' . $config['aid'] . ' and model = "' . $config['model'] . '" and (createtime between '.strtotime($last).' and '.$now.')')->queryRow();
                $data['join'] = Mod::app()->db->createCommand()->select('count(0)')->from($table_user)->where($config['model'].'id=' . $config['aid'] . '  and (create_time between '.strtotime($last).' and '.$now.')')->queryRow();
                $config['userdata']['signup'] = $data['signup']['count(0)'];
                $config['userdata']['join'] = $data['join']['count(0)'];
                $config ['time']['start_time'] = $last;
                $config ['time']['end_time'] = date('Y-m-d',$now);
                break;
        }


        $this->render('activitylist',$config);
    }






}