<?php
 
class MemberController extends FrontController
{
 
//    protected $openid ='';
//    protected $appid = '101052';
//    protected $appsecret = 'fb6dd2d762240db4';
 
    protected $appid;
    protected $openid;
    protected $appsecret;
    protected $token;
    protected $mid;
    protected $memInfo;
 
    public function init()
    {
        parent::init();
        
//        if(Checkwap::check_wap()){
//               return "wap";
//        }else{
//               return "web";
//        }

        if(!$this->member_project['pid']){
            $this->member_project['pid']=1;
        }
 
    }
 
    /**
     * 用户登录
     * @param int $mobile 手机号
     * @param int $smsCode 手机短信码
     * @return 成功1，失败-3
     */
    public function actionLogin()
    {
        $backUrl = urldecode(trim(Tool::getValidParam('backurl', 'string')));
        $jumpUrl = urldecode(trim(Tool::getValidParam('jump', 'string')));
 
 
        if (!$backUrl) {
            $backUrl = Mod::app()->request->urlReferrer;
        }
 
        $data = array(
            'config' => array('site_title' => '用户登录注册'),
            'param' => array('backUrl' => $backUrl),
            'jump' => $jumpUrl,
        );
 
        $this->render('login', $data);
    }
 
 public  function actionlovarshop(){
     //猜你喜欢积分商城接口
     $url = "http://" . $_SERVER['HTTP_HOST'] . "/jfshop/b2c/wap/default/memberhobby/mid/" . $this->member['id'];
     $oCurl = curl_init();
     if (stripos($url, "https://") !== FALSE) {
         curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
         curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
     }
     //设置cURL允许执行的最长秒数。
     curl_setopt($oCurl, CURLOPT_URL, $url);
     curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
     $sContent = curl_exec($oCurl);
     $aStatus = curl_getinfo($oCurl);
     curl_close($oCurl);
     $love_shop = json_decode($sContent, true);
        return $love_shop;
 }

    public function actionIndex()
    {      
        $pid=$this->member_project['pid']?$this->member_project['pid']:1;
        $id=Tool::getValidParam('id','integer');//签到活动id
        $mid = $this->member['id'];

        $count_mes = Member_message::model()->countByAttributes(array('mid' => $this->member['id'], 'status' => '0'));
        // var_dump($count_mes);exit;


        //查询用户签到情况
        if($pid && !$id){
            $sql = "SELECT * FROM {{activity_pccheckin}} WHERE pid= " . $pid . " ORDER BY id desc";
            $info = Mod::app()->db->createCommand($sql)->queryRow();
            $id=$info['id'];
            //根据pid查询不到签到活动，提示 还没有创建活动
            if(!$id){
                $user = -8;
            }
        }

        //查看用户是否签到
        if ($mid && $id) {
            $sql = "SELECT * FROM {{activity_pccheckin_user}} WHERE mid=$mid  and  pid=" . $id . "  and date='" . date('Y-m-d', time()) . "'";
            $users = Mod::app()->db->createCommand($sql)->queryRow();
            if ($users) {
                $user = 1;
            }
        }
 
 
        $data = array(
            'count' => $count_mes,
            'pccheckid' => $info['id']?$info['id']:$id,
            'love_shop' => $love_shop,
            'user' => $user?$user:0,
            'jfshop' => "/jfshop/b2c/wap/default/index",
            'config' => array('site_title' => '首页'),
        );
 
        // var_dump($data['param']);exit;
        $this->render('indextest', $data);
    }
 
 public function actionajaxnum(){
     if(Mod::app()->request->isAjaxRequest) {

         $pid = $this->member_project['pid'] ? $this->member_project['pid'] : 1;
         //申明一个数组
         $data = array();
         //获取用户积分
         $sql = "SELECT `points` FROM {{member}} WHERE id = '" . $this->member['id'] . "'";
         $list = Mod::app()->db->createCommand($sql)->queryRow();
         $points = $list['points'];
         $data['points'] = $points ? $points : 0;
         //我的活动条数
         $sql = "SELECT * FROM {{activity_recommend}} where status=1";
         $recommendnum = Mod::app()->db->createCommand($sql)->queryAll();
         $data['recommendnum'] = count($recommendnum) > 0 ? count($recommendnum) : 0;
         //消息条数

         $arr = array(
             "select" => "*", //要查询的字段
             "condition" => "pid=" . $pid, //查询条件
             "order" => "id desc",
             "limit" => 10,
         );
         //查询全部消息
         $all_list = Message::model()->findAll($arr);

         foreach ($all_list as $key => $val) {
             if ($this->member['id']) {
                 //用户是否查看
                 $sql = "select id from {{message_read}} where pid=" . $val->pid . " AND mid=" . $this->member['id'] . " AND msgid=" . $val->id;

                 $re = Mod::app()->db->createCommand($sql)->queryRow();
                 if (!$re) {
                     $list[] = $all_list[$key];
                 }
             }
         }
         $data['list'] = (count($list) - 1) > 0 ? count($list) - 1 : 0;


         //猜你喜欢积分商城接口
         $love_shop=$this->actionlovarshop();
         $data['shop']=$love_shop;


         echo json_encode($data);
         exit;
     }
 }
    //活动
    public function actionActivity()
    {
 
        //名称，控制器方法，表名
        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            // 3 => array("报名", "signup", "signup"),
            3 => array("投票", "vote", "vote"),
            4 => array("大转盘", "bigwheel", "bigwheel"),
            5 => array("海报", "poster", "poster"),
 
        );
 
        $param = '';
 
        $mid = $this->member['id'];
        if (!$mid) {
            $this->redirect('/h5/member/login' . $param);
            exit;
        }
 
        $page = Tool::getValidParam('page','integer');
 
        //$sql = "SELECT `type`,`tablename`,`aid`,`pid` FROM {{member_behavior}} WHERE mid = '" . $mid . "' AND pid=" . $this->member_project['pid'] . "  GROUP BY `tablename`,`aid`,`type`,`pid` ";
        $sql = "SELECT `type`,`tablename`,`aid`,`pid` FROM {{member_behavior}} WHERE mid = '" . $mid . "'   GROUP BY `tablename`,`aid`,`type` ,`pid`";
 
        $list = Mod::app()->db->createCommand($sql)->queryAll();
        $activity = array();
        $arr = array();
 
        foreach ($list as $key => $values) {
            if ($values['tablename'] == "" || $values['tablename'] == "null" || strpos($values['tablename'],"signup")) {
                unset($list[$key]);
            } else {
                $sql = " SELECT * FROM {{" . $values['tablename'] . "}} WHERE id = " . $values['aid'];
                $res = Mod::app()->db->createCommand($sql)->queryRow();
 
                //点击数
                $sql = " SELECT * FROM {{activity_click}} WHERE aid = " . $values['aid'] . " AND pid=" . $values['pid'];
                $pv = Mod::app()->db->createCommand($sql)->queryRow();
 
 
                //查询pid 属于哪个应用
                $project = Project::model()->findByPk($values['pid']);
 
                //根据表明查询控制器名字
                foreach ($type as $val) {
                    $re = in_array(str_replace('activity_', "", $values['tablename']), $val);
                    if ($re) {
                        $function = $val[1];
                        break;
                    }
                }
                if ($res) {
                    if ($values['tablename'] == "activity_poster") {
                        $list[$key]['type'] = $values['type'];
                        $list[$key]['aid'] = $values['aid'];
                        $list[$key]['title'] = $res['title'];
                        $list[$key]['start_time'] = $res['starttime'];
                        $list[$key]['end_time'] = $res['endtime'];
                        $list[$key]['img'] = $res['share_img'];
                    } else {
                        $list[$key]['type'] = $values['type'];
                        $list[$key]['aid'] = $values['aid'];
                        $list[$key]['title'] = $res['title'];
                        $list[$key]['describe'] = $res['desc'];
                        $list[$key]['start_time'] = $res['start_time'];
                        $list[$key]['end_time'] = $res['end_time'];
                        $list[$key]['pv'] = $pv['pv'];
                        $list[$key]['uv'] = $pv['uv'];
                        $list[$key]['img'] = $res['share_img'] ? $res['share_img'] : $res['img'];
                        $list[$key]['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/activity/' . $function . '/view/id/' . $values['aid'];
 
                    }
 
                } else {
                    unset($list[$key]);
                }
            }
        }
        $activity = $list;
        //活动汇------------------------------start---------------
        //官方推荐任务
        //$sql = "SELECT * FROM {{activity_recommend}} where status=1 AND  pid=" . $this->member_project['pid'];
        $sql = "SELECT * FROM {{activity_recommend}} where status=1";
        $recommend = Mod::app()->db->createCommand($sql)->queryAll();
 
        foreach ($recommend as $k => $v) {
            //查看结束时间是否小于当前时间
            if ($v['end_time'] < time()) {
                unset($v);
            } else {
            $recommend[$k]['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/activity/' . $type[$v['type']][1] . '/view/id/' . $v['aid'] . $param;
            if ($v['type'] == 2 || $v['type'] == 5) {
                $name = "抽奖";
            } else {
                $name = $type[$v['type']][0];
            }
            //查询奖励积分
            $sql = "SELECT * FROM {{member_behavior_type}} where name=" . '\'' . $name . '\'';
            $result = Mod::app()->db->createCommand($sql)->queryRow();
            if ($result) {
                $recommend[$k]['rule'] = $result['rule'];
                $recommend[$k]['point'] = $result['point'];
            }
            //查询点击量及参与人数
            $sql = " SELECT * FROM {{activity_click}} WHERE aid = " . $v['aid'] . " AND pid=" . $v['pid'];
            $pv = Mod::app()->db->createCommand($sql)->queryRow();

            $recommend[$k]['pv'] = $pv['pv'];
            $recommend[$k]['uv'] = $pv['uv'];
        }
        }
 
        //获取用户积分
        $sql = "SELECT `points` FROM {{member}} WHERE id = '" . $this->member['id'] . "'";
        $list = Mod::app()->db->createCommand($sql)->queryRow();
        $points = $list['points'];
        //  ------------------------end------------------------------
 
 
        $data = array(
            'param' => $param,
            'activity' => $activity,//我参加的活动
            'recommend' => $recommend,//活动汇
            'project' => $project,//活动汇
            'config' => array('site_title' => '活动管理'),
        );
 
        $this->render('activity', $data);
    }
 
    //赚积分
    public function actionPoint()
    {
 
        $param = '';
 
        $mid = $this->member['id'];
        if (!$mid) {
            $this->redirect('/h5/member/login' . $param);
            exit;
        }
 
        // var_dump($memInfo->headimgurl);exit;
 
        $page = Tool::getValidParam('page','integer');
 
        // $activity = Member_behavior_activity::model()->getActivityList('mid='.$memInfo->id,$page ,10);
 
 
        //官方推荐任务
        $sql = "SELECT * FROM {{activity_recommend}} where status=1";
        $activity = Mod::app()->db->createCommand($sql)->queryAll();
 
        //名称，控制器方法，表名
        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            //3 => array("报名", "signup", "signup"),
            3 => array("投票", "vote", "vote"),
            4 => array("大转盘", "bigwheel", "bigwheel"),
            5 => array("海报", "poster", "poster"),
 
        );
 
        foreach ($activity as $k => $v) {
            $activity[$k]['url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/activity/' . $type[$v['type']][1] . '/view/id/' . $v['aid'] . $param;
            if ($v['type'] == 2 || $v['type'] == 5) {
                $name = "抽奖";
            } else {
                $name = $type[$v['type']][0];
            }
            //查询奖励积分
            $sql = "SELECT * FROM {{member_behavior_type}} where name=" . '\'' . $name . '\'';
            $result = Mod::app()->db->createCommand($sql)->queryRow();
            if ($result) {
                $activity[$k]['rule'] = $result['rule'];
                $activity[$k]['point'] = $result['point'];
            }
            //查询是否完成任务
 
        }
 
 
        //获取用户积分
        $sql = "SELECT `points` FROM {{member}} WHERE id = '" . $this->member['id'] . "'";
        $list = Mod::app()->db->createCommand($sql)->queryRow();
        $points = $list['points'];
 
        // var_dump($activity);exit;
        //签到 赚积分id
            //获取当前pid 下最新的签到活动
        $pid=$this->member_project['pid']?$this->member_project['pid']:Tool::getValidParam('pid','integer');
 
            if(!$pid){
                $pid=1;
            }
 
           if($pid){
               $sql = "SELECT id FROM {{activity_pccheckin}} WHERE pid = " . $pid." order by id desc" ;
 
               $pccheckid = Mod::app()->db->createCommand($sql)->queryRow();
               //$pccheckid=Activity_pccheckin::model()->find(array('pid'=>$this->member_project['pid']));
           }
        $data = array(
            'param' => $param,
            'points' => $points,
            'activity' => $activity,
            'pccheckid' => $pccheckid['id'],
            'config' => array('site_title' => '我的活动'),
        );
 
 
        $this->render('jfindex', $data);
 
    }
 
    /*增加点击量*/
    public function actionclick()
    {
        $aid = trim(Tool::getValidParam('aid', 'integer'));
        if(!$aid){
            echo "非法访问";exit;
        }
        $pid = intval($this->member_project['pid']);
        $sql = "SELECT id FROM {{activity_click}} WHERE aid = $aid AND pid=$pid";
        $list = Mod::app()->db->createCommand($sql)->queryRow();
        if ($list) {
            $sql = "UPDATE {{activity_click}} SET pv=pv+1 WHERE id = " . $list['id'];
            $list = Mod::app()->db->createCommand($sql)->execute();
        } else {
            $arr["aid"] = $aid;
            $arr["pv"] = 1;
            $arr["pid"] = $pid;
            $query = Mod::app()->db->createCommand()->insert('dym_activity_click', $arr);
            if ($query) {
                echo 1;
                exit;
            }
        }
 
 
    }
 
    /*我的消息列表*/
    public function actionmessage()
    {
 
        if($this->member_project['pid']){
            $pid=$this->member_project['pid'];
        }else{
            $pid=1;
        }
        if(Mod::app()->request->isAjaxRequest){
 
            $id=intval( $_GET['id']);
            $sql="select * from {{message_read}} where pid=".$pid." AND mid=".$this->member['id']." AND msgid=".$id;
            $user=Mod::app()->db->createCommand($sql)->queryRow();
            if(!$user){
                $arr['mid']=$this->member['id'];
                $arr['pid']=$this->member_project['pid'];
                $arr['msgid']=$id;
                $arr['createtime']=time();
                $query = Mod::app()->db->createCommand()->insert('dym_message_read', $arr);
                if($query){
                    echo 1;
                    exit;
                }else{
                    echo 2;
                    exit;
                }
            }else{
                echo 3;
                exit;
            }
 
        }else {
            // $this->member_project['pid'] = 61;
            $arr = array(
                "select" => "*", //要查询的字段
                "condition" => "pid=" . $pid, //查询条件
                "order" => "id desc",
                "limit" => 10,
            );
            //查询全部消息
            $all_list = Message::model()->findAll($arr);
 
                foreach ($all_list as $key => $val) {
                    //报名组件删除已经


                    //避免出现非法请求
                    $id = substr($val->url, -3);
                    $id = str_replace("/", "", $id);

                    //根据活动id 去查找活动存在不
                    if ($val->tablename != "signup") {
                        $mo = "Activity_" . $val->tablename;
                        $re = $mo::model()->findByPk($id);

                        if (!$re) {
                            Message::model()->deleteByPk($val->id);
                        }
                        //用户是否查看
                        $sql = "select * from {{message_read}} where pid=" . $val->pid . " AND mid=" . $this->member['id'] . " AND msgid=" . $val->id;

                        $re = Mod::app()->db->createCommand($sql)->queryRow();
                        if (!$re) {
                            $list[] = $all_list[$key];
                        }
                    }
                }
 
            $data = array(
                'all_list' => $all_list,//全部消息
                'list' => $list,//全部消息
            );
            $this->render('message', $data);
        }
    }
 
 
    //奖品
    public function actionPrize()
    {
 
 
        $param = '';
 
//        $memInfo = Member_project::memberIslegal($appid,$appsecret,$openid);
        $mid = $this->member['id'];
        if (!$mid) {
            $this->redirect('/h5/member/login' . $param);
            exit;
        }
 
        $page = Mod::app()->request->getParam('page', 1);
 
        $sql = "SELECT * FROM {{member_behavior}} WHERE mid = " . $mid . " order by createtime desc limit 0,5";
        $prize = Mod::app()->db->createCommand($sql)->queryAll();
 
        $data = array(
            'prize' => $prize,
            'config' => array('site_title' => '我的奖品'),
        );
 
        $this->render('prize', $data);
    }
 
    public function actionAjaxprize()
    {
        $mid = $this->member['mid'];
        if (!$mid) {
            die('未登录');
        }
        $limit = trim(Tool::getValidParam('limit', 'integer')) * 5;
        $sql = "SELECT * FROM {{member_behavior}} WHERE mid = " . $mid . " order by createtime desc limit " . $limit . ",5";
        $prize = Mod::app()->db->createCommand($sql)->queryAll();
        if (!empty($prize)) {
            foreach ($prize as $key => $list) {
                echo '<div class="item_style item_style_2"><div class="box"><div class="content"><a href="#" class="use">去使用</a><div class="des1">' . $list['win_name'] . '</div><div class="des2">使用条件：</div><div class="des3">无门槛</div></div><div class="date">' . $list['year'] . "-" . $list['month'] . "-" . $list['day'] . '到期</div></div></div>';
            }
        } else {
            echo 0;
        }
    }
 
 
    /**
     * 发送手机短信验证码
     * @param int $mobile 手机号
     * @return array
     */
    public function actionSendMsCode()
    {
        $mobile = trim(Tool::getValidParam('mobile','string'));

        if($mobile){
            $checkres = $this->checksendsmsnum($mobile,$content="0");
            if($checkres=='-1'){
                echo  json_encode(array('status'=>0,'info'=>'同一个手机号码1分钟只能发送一次'));exit;
            }else if($checkres=='-2'){
                echo  json_encode(array('status'=>0,'info'=>'同一个手机号码1天内只能发送六次'));exit;
            }else if($checkres=='-3'){
              //  echo  json_encode(array('status'=>0,'info'=>'同一个IP一天之内只能发六条'));exit;
            }else if($checkres=='0'){
                echo  json_encode(array('status'=>0,'info'=>'数据错误'));exit;
            }

            $result = Member::SendMessage($mobile);
        }

        echo json_encode($result);
    }


    public  function checksendsmsnum($mobile,$content){

        //限制：一分钟之内只能发一条，单个IP针对一个手机号一天只最多发6条，
        $smsmodel = new Sendsmslog();
        $time =time();
        $time_str = date('ymdHi',$time);

        $sendlog = Sendsmslog::model()->findAll("phone ='" . intval($mobile) . "' and sendtime >'" . ($time_str-1) . "'");
        if($sendlog){
            return -1; //1分钟只能发一条；
        }


        $time_str2 = date('ymd',$time);
        $sendlog = Sendsmslog::model()->findAll("phone ='" . intval($mobile) . "' and sendday ='" . $time_str2 . "'");
        if($sendlog &&  count($sendlog)>6){
            return -2; //一天之内只能发六条
        }

        $sendlog = Sendsmslog::model()->findAll("sendip ='" .Mod::app()->request->userHostAddress. "' and sendday ='" . $time_str2 . "'");
        if($sendlog &&  count($sendlog)>6){
            return -3; //同一个IP一天之内只能发六条
        }

        $smsmodel = new Sendsmslog();
        $smsmodel->phone = $mobile;
        $smsmodel->content = $content;
        $smsmodel->sendtime = $time_str;
        $smsmodel->sendday = $time_str2;
        $smsmodel->createtime = $time;
        $smsmodel->sendip = Mod::app()->request->userHostAddress;
//        var_dump($smsmodel);die;
        if($smsmodel->save()){
            return 1;
        }else{
            return 0;
        }


    }



 
    //修改个人信息
    public function actionUpdateInfo()
    {
        //上传图片
        if ($_FILES['imgFile']) {
            $file = new FilesController();
            $re = $file->actionUpload();
        }
        if (Mod::app()->request->isAjaxRequest) {
            $data['username'] = trim(Tool::getValidParam('username', 'string'));
            //$data['sex'] = trim(Tool::getValidParam('sex','string'));
            $data['sex'] = Tool::getValidParam('sex', 'integer');
            $data['birthday'] = strtotime(trim(Mod::app()->request->getParam('birthday')));
            $data['email'] = trim(Tool::getValidParam('email', 'string'));
            $data['career'] = trim(Tool::getValidParam('career', 'string'));
            $data['headimgurl'] = $re['url'] ? $re['url'] : trim(Tool::getValidParam('share_img', 'string'));
            $data['updatetime'] = time();
 
            $str = "";
 
            if(strlen($data['username'])>24 || strlen($data['username'])<3){
                exit(json_encode(array('state' => 0, 'mess' => '修改失败,昵称长度3-8')));
            }elseif(strlen($data['career'])>45 || strlen($data['career'])<2){
                exit(json_encode(array('state' => 0, 'mess' => '修改失败,职业长度2-15')));
            }
            
            $model = new member();
           //不能直接把数组给attributes  但是可以单独的给key赋值
            foreach($model->attributes as $k=>$v){
                isset($data[$k]) && $model->$k = $data[$k];
            }
            $model->id =  $this->member['id'];
            $row = $model->save();
            
//            foreach ($data as $key => $value) {
//                if (!isset($data[$key])) {
//                    unset($data[$key]);
//                } else {
//                    $str .= "`$key` = '$value',";
//                }
// 
//            }
//            $mid = $this->member['id'];
//            $str = trim($str, ",");
//            $sql = " UPDATE {{member}} SET " . $str . " WHERE id = " . $mid;
// 
//            $row = Mod::app()->db->createCommand($sql)->execute();
            if ($row) {
//                var_dump($memInfo->attributes);exit;
                //echo "修改成功";
                $member_info = Member::model()->findByPk($this->member['id']);
                Mod::app()->session['member'] = $member_info->attributes;
                exit(json_encode(array('state' => 1, 'mess' => '修改成功')));
            } else {
                //  echo "修改失败";s
                exit(json_encode(array('state' => 0, 'mess' => '修改失败')));
            }
        }
 
 
        $param = '';
 
        $mid = $this->member['id'];
        if (!$mid) {
            $this->redirect('/h5/member/login' . $param);
            exit;
        }
 
 
        $this->render('updateInfo', array('config' => array('site_title' => '修改个人信息')));
    }
 
    //站内信列表
    public function actionMsg()
    {
 
        $param = '';
 
 
        $mid = $this->member['id'];
        if (!$mid) {
            $this->redirect('/h5/member/login' . $param);
            exit;
        }
        //分布
        $criteria = new CDbCriteria();
//        $criteria->with = 'member';
//        $criteria->compare('pid',$pInfo->id);
        $criteria->compare('mid', $mid);
 
        $model = new Member_message();
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $list = $model->findAll($criteria);
 
        $data = array(
            'param' => $param,
            'list' => $list,
            'pages' => $pages,
            'config' => array('site_title' => '信息列表'),
        );
 
        $this->render('message', $data);
 
 
    }
 
 
 
 
}