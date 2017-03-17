<?php

/**
 *
 * @author yuwanqiao
 * 大转盘控制器
 *
 */
class WendaController extends FrontController
{
    public function init()
    {
        parent::init();

    }

    /**
     * @author yuwanqiao
     * 前端访问页面,显示刮奖的html页面
     */

    public function actionView()
    {

        //关联投票组件
        $start=strtotime(date('Y-m-d'));//今天
        $end=strtotime(date('Y-m-d',strtotime('+1 day')));//明天
        $id = trim(Tool::getValidParam('id', 'integer'));

        //查询活动信息
        $sql = "SELECT * FROM {{activity_wenda}} WHERE id=$id";
        $info = Mod::app()->db->createCommand($sql)->queryRow();

      
        Browse::add_activity_browse($info['pid'],$id,"wenda");
        if (!$info || empty($info)) {
            die('非法请求');
        }

        //查询问答活动对应的题目
        $quetion_tmp_arr = array();
        $sql_que_count = "SELECT count(0) as count_t FROM {{activity_wenda_question}} WHERE wendaid=$id and status=1 ";
        $question_count = Mod::app()->db->createCommand($sql_que_count)->queryRow();
        $sql = "SELECT * FROM {{activity_wenda_question}} WHERE wendaid=$id and status=1 order by sort asc";
        $question_arr = Mod::app()->db->createCommand($sql)->queryAll();
        foreach ($question_arr as $k=>$v){
            $sql = "SELECT * FROM {{activity_wenda_answer}} WHERE questionid=".$v['id'];
            $answer_arr = Mod::app()->db->createCommand($sql)->queryAll();
            $question_arr[$k]['count'] = $question_count['count_t'];
            $question_arr[$k]['answer_arr']=$answer_arr;
        }

      
        if ($this->member['id']) {//登录状态
            $mid = $this->member['id'];
        }

        $sql = "SELECT * FROM {{project}} WHERE id=" . $info['pid'];
        $project_info = Mod::app()->db->createCommand($sql)->queryRow();

        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);
        //token验证
//        $checkToken = $this->checkToken($project_info['id'],$token);
        // if(!$checkToken || empty($checkToken)){die('token is error');}

//        $backUrl = "?id=".$id."&accesstoken=".$token."&openid=".$openid;
//
//        $prize_id = explode(',', rtrim($info['prize_id'], ','));
//        foreach ($prize_id as $key => $val) {
//            //查询奖品信息
//            $sql = "SELECT * FROM {{activity_wenda_prize}} WHERE id=$val";
//            $prize[$key] = Mod::app()->db->createCommand($sql)->queryRow();
//        }


//        $images= Activity_wenda_img::model()->find("bigwheel_id=:id",array(':id'=>$id));
        $parame = array(
            'info' => $info,
//            'prize' => $prize,
//            'images' => $images,
//            'countprize' => count($prize),
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
//                "token"=>$token,
                "id" => $id,
                "openid" => $mid,
                "backUrl" => $url?$url:0,
//                "status" => $mid,
                "mid" => $mid,
                "pid" => $info['pid'],
            ),
            'question_arr'=> $question_arr,
            'signPackage' => $signPackage,
            'time' => time(),
            'config'=>array(
                'site_title'=> $info['title'].'-问答抽奖',
                'Keywords'=>$info['title'].',问答,抽奖,一等奖',
                'Description'=>$info['title'].',问答,抽奖,一等奖',
            ),

        );

//        echo "<pre>";
//        print_r($question_arr);
//        exit;
        $this->render('view', $parame);
    }


    /*
     * 检查活动状态，如果是启用则不能编辑
     * */

    public function actionis_status(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            die('非法访问');
        }

        if (Mod::app()->request->isPostRequest) {
            $id=Tool::getValidParam('id','integer');
            if($id){
                $res=Activity_wenda::model()->findByPk($id);
                if($res){
                    if($res->status==1 && $res->end_time>time() && $res->start_time<time()){
                        echo 2;//等于1的时候表示活动进行中 不能编辑
                        exit;
                    }else{
                        echo 1;
                        exit;
                    }
                }else{
                    echo 3;
                    exit;
                }
            }else{
                echo 3;
                exit;
            }

        }else{
            echo "非法访问";exit;
        }
    }




    /**
     * @author yuwanqiao
     * 后台活动列表
     */
    public function actionlist()
    {

        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            die('非法访问');
        }

        $pid = trim(Tool::getValidParam('pid', 'integer'));

        //防止ID遍历
        $projectinfo =  JkCms::getprojectByid($pid);
        if($this->memberverify($projectinfo['mid'])){
            $this->redirect('/project/prolist');
            $this->checkpressserror();
            exit;
        }


        //获取当前应用
        $project_model = Project::model()->findByPk($pid);
        if (!$project_model) {
            $this->redirect('/project/prolist');
            exit;
        }



        //获取应用列表
        $project_list = Project::model()->findAll("mid=:mid", array(":mid" => $this->member['id']));
        //刮刮卡活动列表
        $as_list = Activity_wenda::model()->getActivityListPager($pid);

//        if(1==1) { //default模板风格
//            if (!$as_list['count']) {
//                $redirect_url = Mod::app()->baseUrl . '/activity/bigwheel/add/pid/' . $pid;
//                $this->redirect($redirect_url);
//            }
//        }
        $config['site_title'] = '问答活动列表-大楚用户开放平台首页';
        $config['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网,活动组件,问答";
        $config['site_description'] ="大楚用户开放平台首页";
        $config['active_1'] = 3;
        $config['active'] = 10;
        $config['pid'] = $pid;
        $parame = array(
            'project_list' => $project_list,
            'view' => $project_model,
            'asList' => $as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count' => $as_list['count'],
            'config' => $config
        );
        $this->render('list_wenda', $parame);
    }



    /**
     * @author yuwanqiao
     * 后台添加问答活动和编辑在一起
     */
    public function actionAdd()
    {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        if (Mod::app()->request->isPostRequest) {
            $data = $_POST;

            //start所属权限开始
            $activity_id =   trim(Tool::getValidParam('id', 'integer'));
            $pid = trim(Tool::getValidParam('pid', 'integer'));
            if($activity_id){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_wenda}} where id=$activity_id";
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
                if($this->memberverify($projectinfo['mid'])){
                    die('非法访问');
                }
            }else{
                die('非法访问');
            }
            //end权限
            //活动进行中不能编辑

            if($activity_info['status']==1 && $activity_info['end_time']>time() && $activity_info['start_time']<time()){
                $res = array(
                    'state' => 1,
                    'msg' => '活动进行中不能编辑',
                );
                echo json_encode($res);
                exit;
            }

            $data['start_time'] = strtotime(trim(Tool::getValidParam('start_time', 'string')));
            $data['end_time'] = strtotime(trim(Tool::getValidParam('end_time', 'string')));

            //接收所有的图片，转盘 弹窗  背景 等
            $img['background'] = Tool::getValidParam('img', 'string');
            $img['biaoyu'] = Tool::getValidParam('biaoyu', 'string');
            $img['bootmbackground'] = Tool::getValidParam('bootmbackground', 'string');
            $img['rotaryfive'] = Tool::getValidParam('rotaryfive', 'string');
            $img['pointer'] = Tool::getValidParam('pointer', 'string');
            $img['recordbutton'] = Tool::getValidParam('recordbutton', 'string');
            $img['rules'] = Tool::getValidParam('rules', 'string');
            $img['colse'] = Tool::getValidParam('colse', 'string');
            $img['alertyes'] = Tool::getValidParam('alertyes', 'string');
            $img['alertno'] = Tool::getValidParam('alertno', 'string');
            $img['winninglist'] = Tool::getValidParam('winninglist', 'string');

            //因为图片不是必传，避免报错
            foreach($img as $k=>$v){
                if(!$v){
                    unset($img[$k]);
                }
            }


            $question_id_arr =array();
            $question_arr = $_POST['question_arr'];
            $qanda_id = Tool::getValidParam('qanda_id');
            if(!$qanda_id){
                $qanda_id = array();
            }
            $question_query = true ; //编辑成功判断

            if ($activity_id) {
                //步骤1：查找之前的题目
                $wenda_question_arr_id = array();
                $sql = "select * from {{activity_wenda_question}} where wendaid=".$activity_info['id']." and status =1";
                $wenda_question = Mod::app()->db->createCommand($sql)->queryAll();
                foreach($wenda_question as $val){
                    $wenda_question_arr_id[] = $val['id'];
                }

                $qanda_id_diff = array_diff($wenda_question_arr_id, $qanda_id);

                if($wenda_question_arr_id) {
                    //取交集
                    $qanda_id_intersect = array_intersect($wenda_question_arr_id, $qanda_id);
                    //取差集
                    $qanda_id_diff = array_diff($wenda_question_arr_id, $qanda_id);

                }

                //开启事务
                $transaction = Mod::app()->db->beginTransaction();
                try {
                    if($question_arr) {
                        foreach ($question_arr as $key => $val) {
                            $question = json_decode($val, true);
                            //步骤1  更新的 对比现在的题目  更新之前编辑的题目
                            if ($question['id']) {
                                $quest_update_data['body'] = $val;
                                $quest_update_data['sort'] = $question['no'];
                                $quest_update_data['question'] = $question['question'];
                                $quest_update_data['mid'] = $this->member['id'];
                                $quest_update_data['updatetime'] = time();

                                $res = Activity_wenda_question::model()->updateByPk($question['id'], array('body' => $quest_update_data['body'], 'sort' => $quest_update_data['sort'], 'question' => $quest_update_data['question'], 'mid' => $quest_update_data['mid'], 'updatetime' => $quest_update_data['updatetime']));

//                            $res = Mod::app()->db->createCommand()->update('{{activity_wenda_question}}', $quest_update_data, 'id=:id', $question['id']);
                                if ($res) {
                                    $sql = "select * from dym_activity_wenda_answer where questionid=" . $question['id'] . "  order by id asc limit 1";
                                    $answer_arr = Mod::app()->db->createCommand($sql)->queryRow();
                                    if ($answer_arr) {
//                                  var_dump($answer_arr);exit;
                                        $answer_checked_id = $question['answer'];
                                        $answer['updatetime'] = time();
                                        for ($i = 1; $i <= 4; $i++) {
                                            $answer['id'] = $answer_arr['id'] + $i - 1;
                                            $answername = "option" . $i;
                                            $answer['answer'] = $question[$answername];
                                            if ($i == $answer_checked_id) {
                                                $answer['status'] = 1;
                                            } else {
                                                $answer['status'] = 0;
                                            }
                                            $res = Activity_wenda_answer::model()->updateByPk($answer['id'], array('answer' => $answer['answer'], 'status' => $answer['status'], 'updatetime' => $answer['updatetime']));
                                        }
                                    }
                                }
                            }


                        }
                    }

                    if($qanda_id_diff) {
                        //   步骤2：对比现在的题库  有删除的就删除掉
                        foreach ($qanda_id_diff as $key => $val) {
                            //删除的
                            if (in_array($val, $wenda_question_arr_id)) {
                                Mod::app()->db->createCommand()->update('{{activity_wenda_question}}', array('wendaid' => $activity_info['id'], 'status' => 0, 'updatetime' => time()), 'id=' . $val); // 删除题目
                                Mod::app()->db->createCommand()->delete('{{activity_wenda_answer}}', 'questionid=' . $val); // 删除题目对应的答案
                            }
                        }
                    }


                 if($question_arr) {
                     //   步骤3：对比现在的题目  写入新增的题目
                     foreach ($question_arr as $key => $val) {
                         $question = json_decode($val, true);
                         //新增的
                         if (!$question['id']) {

                             $quest_insert_data['body'] = $val;
                             $quest_insert_data['sort'] = $question['no'];
                             $quest_insert_data['question'] = $question['question'];
                             $quest_insert_data['mid'] = $this->member['id'];
                             $quest_insert_data['createtime'] = time();
                             $quest_insert_data['updatetime'] = time();
                             $query = Mod::app()->db->createCommand()->insert('dym_activity_wenda_question', $quest_insert_data);
                             if ($query) {
                                 $id = Mod::app()->db->getLastInsertID();
                                 $question['id'] = $id;
                                 $body = json_encode($question, true);
                                 Activity_wenda_question::model()->updateByPk($id, array('body' => $body));
                                 $question_id_arr[] = $id;
                                 $answer_checked_id = $question['answer'];
                                 $answer_insert['questionid'] = $id;
                                 $answer_insert['createtime'] = time();
                                 $answer_insert['updatetime'] = time();
                                 for ($i = 1; $i <= 4; $i++) {
                                     $answername = "option" . $i;
                                     $answer_insert['answer'] = $question[$answername];
                                     if ($i == $answer_checked_id) {
                                         $answer_insert['status'] = 1;
                                     } else {
                                         $answer_insert['status'] = 0;
                                     }
                                     $querys = Mod::app()->db->createCommand()->insert('dym_activity_wenda_answer', $answer_insert);
                                 }
                             }

                         }

                     }
                 }


                    //这里是 添加的题目数限制
//                    if(count($new_prize_arr_id)<3 || count($new_prize_arr_id)>5){
//                        $transaction->rollBack();
//                        echo json_encode(array(  'state' => 0,   'msg' => '大转盘的奖品种类只能为3-5个' )); exit;
//                    }

                    $transaction->commit();
                    $question_query = true;
                } catch (Exception $e) { //如果有一条查询失败，则会抛出异常
                    $transaction->rollBack();
                    $question_query = false;
                }


            } else { //新增题库            
                foreach ($question_arr as $key => $val) {
                    $question = json_decode($val, true);
                    $data_question['body'] = $val;
                    $data_question['sort'] = $question['no'];
                    $data_question['question'] = $question['question'];
                    $data_question['mid'] = $this->member['id'];
                    $data_question['createtime'] = time();
                    $data_question['updatetime'] = time();
                    $query = Mod::app()->db->createCommand()->insert('dym_activity_wenda_question', $data_question);
                    if ($query) {
                        $id = Mod::app()->db->getLastInsertID();
                        $question['id'] = $id;
                        $body = json_encode($question,true);
                        Activity_wenda_question::model()->updateByPk($id,array('body'=>$body));
                        $question_id_arr[] = $id;
                        $answer_checked_id = $question['answer'];
                        $answer['questionid'] = $id;
                        $answer['createtime'] = time();
                        $answer['updatetime'] = time();
                        for ($i = 1; $i <= 4; $i++) {
                            $answername = "option" . $i;
                            $answer['answer'] = $question[$answername];
                            if ($i == $answer_checked_id) {
                                $answer['status'] = 1;
                            } else {
                                $answer['status'] = 0;
                            }
                            $querys = Mod::app()->db->createCommand()->insert('dym_activity_wenda_answer', $answer);
                        }
                    }
                }
            }
//            exit;

            $question_id = implode(',', $question_id_arr);//奖品id，用逗号链接






            /*奖品写入数据库后拿到奖品的id 用逗号链接*/
            $sql = "SHOW FULL FIELDS FROM {{activity_wenda}}";
            $result = Mod::app()->db->createCommand($sql);
            $query = $result->queryAll();
            foreach ($query as $key => $val) {
                foreach ($data as $key_data => $val_data) {
                    if ($val['Field'] == $key_data) {
                        $arr[$key_data] = Safetool::SafeFilter($val_data);
                    }
                }
            }
//            $arr['prize_id'] = $prize_id;
            $arr['mid'] = $this->member['id'];
            //处理换行
            $arr['rule'] = str_replace('\n',"<br>",$arr['rule']);
            $arr['rule'] = str_replace('\r\n',"<br>",$arr['rule']);

            $res = 1;
            if ($activity_id) {
//                if($res && $redis->lLen($redis_key)!=$p_num_all){
////                    $redis->del('bigwheel_user_'.$id);
//                    $redis->del($redis_key);
//                    for($i=1;$i<=$p_num_all;$i++) {
//                        $redis->lPush($redis_key,$i); //生成奖品队列
//                    }
//                }
                $update_id = array(':id' => $activity_id);
//                unset($arr['prize_id']);//强制修改不让修改奖品
                $query = Mod::app()->db->createCommand()->update('{{activity_wenda}}', $arr, 'id=:id', $update_id);

                //更新问答题目的wendaid字段
                if($question_id && $id){
                    $query = Activity_wenda_question::model()->updateAll(array('wendaid' => $activity_id), 'id  in ('.$question_id.')');
                }
                $str = '编辑';
//                if($img){
//                    $has_edit_img = false;
//                    $re=Activity_bigwheel_img::model()->find("bigwheel_id=:id",$update_id);
//                    if($re){
//                        $img['updatetime']=time();
//                        $imgre = Mod::app()->db->createCommand()->update('{{activity_bigwheel_img}}', $img, 'bigwheel_id=:id', $update_id);
//                        $has_edit_img = true;
//                    }else{
//                        $img['bigwheel_id']=$activity_id;
//                        $img['createtime']=time();
//                        $imgre = Mod::app()->db->createCommand()->insert('{{activity_bigwheel_img}}', $img);
//                        $has_edit_img = true;
//                    }
//
//                }

            } else {
                $arr['add_time'] = time();
                $query = Mod::app()->db->createCommand()->insert('{{activity_wenda}}', $arr);
                $str = '添加';
                if ($query) {
                    //插入成功把对应的图片文件插入
                    $id = Mod::app()->db->getLastInsertID();
//                    //更新奖品的aid字段
//
//                    if($arr['prize_id'] && $id){
//                        Activity_wenda_prize::model()->updateAll(array('aid' => $id), 'id  in ('.$arr['prize_id'].')');
//                    }
                    //更新问答题目的wendaid字段
                    if($question_id && $id){
                        Activity_wenda_question::model()->updateAll(array('wendaid' => $id), 'id  in ('.$question_id.')');
                    }
                    $img['wenda_id']=$id;
                    $img['createtime']=time();
//                    $imgre = Mod::app()->db->createCommand()->insert('{{activity_bigwheel_img}}', $img);
                    $imgre=true;
                    if(!$imgre){
                        Activity_wenda::model()->updateByPk($id,array('status'=>-1));
                        $has_edit_img = true;
                    }else {
                        //新增加活动之后生成站内信息
                        $tablename = "wenda";
                        $url = $this->_siteUrl . "/activity/wenda/view/id/" . $id;
//                        $this->my_message("问答活动[" . $prize_data['title'] . "]", time(), "新增", $arr['pid'], $url, $tablename);
                    }
                }
            }


            if ( $query  || $has_edit_img || $question_query) {
                $res = array(
                    'state' => 1,
                    'aid' => $activity_id,
                    'msg' => $str . '问答活动成功'
                );
            } else {
                $res = array(
                    'state' => 0,
                    'msg' => $str . '问答失败'
                );
            }
            echo json_encode($res);
        } else {
            //获取点击编辑是得到的活动id
            $fid = trim(Tool::getValidParam('id', 'integer'));//活动ID 开发写的不一致
            if(!$fid)   $fid = trim(Tool::getValidParam('id', 'integer'));//做下hack



            if ($fid) {
                //start所属权限开始
                $sql = "select * from {{activity_wenda}} where id=$fid";
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
                $sql = "select * from {{activity_wenda}} where id=$fid";
                $result = Mod::app()->db->createCommand($sql);
                $query = $result->queryAll();
                //查询对应的奖项

                //获取奖品
//                $sql = "select * from {{activity_wenda_prize}} where aid=".$activity_info['id']." and status =1";
//                $prize = Mod::app()->db->createCommand($sql)->queryAll();

                //获取奖品
                $sql = "select * from {{activity_wenda_question}} where wendaid=".$activity_info['id']." and status=1";
                $question_all = Mod::app()->db->createCommand($sql)->queryAll();
                
                //获取各种图片
                $images=Activity_bigwheel_img::model()->find("bigwheel_id=:bigwheel_id",array(':bigwheel_id'=>$fid));

            } else {
                $question_all=array();
//                $prize = array();
                $query = array();

            }



            $pid = $activity_info['pid']?$activity_info['pid']:  Tool::getValidParam('pid','integer');

            //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
            $config['active_1'] = '3';
            //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
            $config['active'] = 10;
            $config['pid'] = $pid;
            $config['site_title']='添加问答活动-编辑问答活动-大楚网用户开放平台';
            $config['Keywords']='大楚网用户开放平台,问答，抽奖，一等奖';
            $config['Description']='添加问答活动_编辑问答活动';


            $psql = "SELECT p.type,a.id,a.name from {{project}} as p LEFT JOIN {{application_tag}} as a on p.type=a.classid WHERE p.id=$pid  order by a.updatetime desc";
            $ptag = Mod::app()->db->createCommand($psql);
            $tag = $ptag->queryAll();
            $ptag = explode('_', substr($query[0]['tag'], 0, -1));



            //处理换行
            $query[0]['rule'] = str_replace("<br>","\n",$query[0]['rule']);

         
            $parame = array(
                'config' => $config,
                'activity_info' => $query[0],
//                'prize' => $prize,
                'question_all' =>$question_all,//问题题库
                'ptag' => $ptag,
                'tag' => $tag,
                'images'=>$images,
                'status' => $this->activity_status('wenda'),

            );

            $this->render('add_wenda', $parame);
        }
    }

    /**
     * @author yuwanqiao
     * 后台删除活动
     */
    public function actionDelete()
    {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if (Mod::app()->request->isAjaxRequest) {
            // $fid = Mod::app()->request->getParam('fid');
            $fid = Tool::getValidParam('fid');

            if ($fid) {
                //查询问答活动组件
                $wenda = Mod::app()->db->createCommand()->select('*')->from('{{activity_wenda}}')->where('id=' . $fid)->queryRow();

                if (!$wenda) {
                    $result = array(
                        'errorcode' => 0
                    );
                    echo json_encode($result);
                    exit;
                }

                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($wenda['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    $result = array(
                        'errorcode' => 0
                    );
                    echo json_encode($result);
                    exit;
                }


                //查询问答活动组件对应的题目和答案
                $wenda_question = Mod::app()->db->createCommand()->select('*')->from('{{activity_wenda_question}}')->where('wendaid=' . $fid)->queryAll();
                foreach ($wenda_question as $val) {
                    Mod::app()->db->createCommand()->delete('{{activity_wenda_question}}', 'id IN(' . $val['id'] . ')');
                    $wenda_answer = Mod::app()->db->createCommand()->select('*')->from('{{activity_wenda_answer}}')->where('questionid=' . $val['id'])->queryAll();
                    foreach ($wenda_answer as $val2){
                        Mod::app()->db->createCommand()->delete('{{activity_wenda_answer}}', 'id IN(' . $val2['id'] . ')');
                    }
                }

                $res = Mod::app()->db->createCommand()->delete('{{activity_wenda}}', 'id IN(' . $fid . ')');
                if ($res) {
                    $recommend = Mod::app()->db->createCommand()->select('id')->from('{{activity_recommend}}')->where('aid=' . $fid)->queryRow();
                    if ($recommend) {
                        Mod::app()->db->createCommand()->delete('{{activity_recommend}}', 'aid IN(' . $fid . ')');
                    }

                    $result['errorcode'] = 1;
                }
            } else {
                $result = array(
                    'errorcode' => 0
                );
            }
            echo json_encode($result);
            exit;
        } else {
            $result = array(
                'errorcode' => 0,
                'message' => "No value to submit"
            );
            echo json_encode($result);
            exit;
        }
    }


    /**
     * @author yuwanqiao
     * 设置结束活动
     */
    public function actionActivitystatus()
    {



        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $res = array( 'state' => 0,   'msg' => '非法访问' );
            echo json_encode($res);die();
        }
        //活动的id
        $id = Tool::getValidParam('fid','integer');
        if(!$id) $id = Tool::getValidParam('id','integer'); //hack下 传参应该是ID的 wenlijiang
        //start所属权限开始
        $activity_id =   $id;

        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_wenda}} where id=$activity_id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){
                $res = array( 'state' => 0,   'msg' => '非法访问1' );
                echo json_encode($res);die();
            }
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                $res = array( 'state' => 0,   'msg' => '非法访问2' );
                echo json_encode($res);die();
            }
        }else{
            $res = array( 'state' => 0,   'msg' => '非法访问3' );
            echo json_encode($res);die();
        }
        //end权限


        //type 1表是设置开始 2表示设置结束
        $type = Tool::getValidParam('type','integer',0);
        if ($type == 1) {
            $str = '开始';
            $arr = array('status' => 1);
        }
        if ($type == 2) {
            $str = '暂停';
            $arr = array('status' => 0);
        }

        $update_id = array(':id' => $id);
        $query = Mod::app()->db->createCommand()->update('{{activity_wenda}}', $arr, 'id=:id', $update_id);
        if ($query) {
            $res = array(
                'state' => 1,
                'msg' => '设置' . $str . '成功'
            );
        } else {
            $res = array(
                'state' => 0,
                'msg' => '设置' . $str . '失败'
            );
        }
        echo json_encode($res);
    }




    /**
     * @author yuwanqiao
     * 获取用户参与刮刮卡的活动用户列表和中奖列表
     */
    public function actionWinlist()
    {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        $fid = trim(Tool::getValidParam('fid', 'integer'));
//        $datatype = trim(Tool::getValidParam('datatype', 'integer'));
        $search = trim(Tool::getValidParam('search', 'string'));
        $username = trim(Tool::getValidParam('username', 'string'));

        //start所属权限开始
        $activity_id =   $fid;
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_wenda}} where id=$activity_id";
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



        if(!$fid){die('非法的数据访问');}
        /* if(!empty($username)){
             $Usql = "select m.id from dym_member as m right join dym_activity_bigwheel_user as b on m.id=b.mid where m.username like '%".$username."%'";
             $userid = Mod::app()->db->createCommand($Usql)->queryAll();
         }*/
//        if ($datatype == 1) {
//            $is_win = 1;
//            $active = 'active_win';
//        } elseif ($datatype == 2) {
//            $is_win = 2;
//            $active = 'active_no';
//        } else {
//            $is_win = '';
//            $active = 'active_all';
//        }
        $as_list = Activity_wenda_user::model()->getUserListPager($fid, $search, $username);
        if ($as_list['count']) {
            foreach ($as_list['criteria'] as $key => $val) {
                //根据用户id查询用户信息
                $mid = $val['mid'];
                $sql = "select * from dym_member where id = $mid";
                $user = Mod::app()->db->createCommand($sql)->queryRow();

                $as_list['users'][$key]['id'] = $val['id'];
                $as_list['users'][$key]['wendaid'] = $val['wendaid'];
                $as_list['users'][$key]['mid'] = $val['mid'];
                $as_list['users'][$key]['phone'] = $user['phone'];
                $as_list['users'][$key]['username'] = $user['username'];
                $as_list['users'][$key]['answer_bingo_num'] = $val['answer_bingo_num'];
                $as_list['users'][$key]['time'] = $val['time'];
            }
        } else {
            $as_list['count'] = '0';
            $as_list['users'] = array();
        }
//        $as_list['active'] = $active;
        $as_list['id'] = $fid;
        $as_list['search'] = $search;
        $as_list['username'] = $username;
//        $as_list['type'] = $datatype;
        $as_list['config']=array(
            'site_title'=> '添加问答活动-编辑大转盘活动-大楚网用户开放平台',
            'Keywords'=>'大楚网用户开放平台,问答，抽奖，一等奖',
            'Description'=>'添加问答活动_编辑大转盘活动'
        );
        $this->render('winlist', $as_list);
    }

    

    /**
     * @author yuwanqiao
     * 导出数据列表
     */
    public function actionExportCsv()
    {
        $fid = trim(Tool::getValidParam('fid', 'integer'));
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //start所属权限开始

        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($fid){//编辑

            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_wenda}} where id=$fid";
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




//        $datatype = trim(Tool::getValidParam('type', 'string'));
//        if ($datatype == 1) {
//            $where = "bigwheel_id = $fid and is_win = 1";
//        } elseif ($datatype == 2) {
//            $where = "bigwheel_id = $fid and is_win = 0";
//        } else {
//            $where = "bigwheel_id = $fid";
//        }
        Mod::import('ext.ECSVExport');
        $list = Mod::app()->db->createCommand()
            ->select('*')
            ->from('{{activity_wenda_user}}')
//            ->where($where)
            ->queryAll();
        if ($list) {
            foreach ($list as $key => $val) {
                //根据用户id查询用户信息
                $mid = $val['mid'];
                $sql = "select * from dym_member where id = $mid";
                $user = Mod::app()->db->createCommand($sql)->queryRow();

                $as_list[$key]['id'] = $val['id'];
                $as_list[$key]['wendaid'] = $val['wendaid'];
                $as_list[$key]['mid'] = $val['mid'];
                $as_list[$key]['username'] = $user['username'];
                $as_list[$key]['phone'] = $user['phone'];
                $as_list[$key]['answer_bingo_num'] = $val['answer_bingo_num'];
                $as_list[$key]['time'] = $val['time'];
            }
        } else {
            $as_list = array();
        }
        $list = array();
        if ($as_list) {
            foreach ($as_list as $k => $v) {
                $list[$k]['活动id'] = $v['wendaid'];
                $list[$k]['用户名'] = $v['username'];
                $list[$k]['手机号'] = $v['phone'];
                $list[$k]['答对题数'] = $v['answer_bingo_num'];
                $list[$k]['抽奖时间'] = date('Y-m-d H:i:s', $v['time']);
            }
        }
        $data = array();
        foreach ($list as $key => $val) {
            foreach ($val as $k => $v) {
                $ke = mb_convert_encoding($k, "GBK", "UTF-8");
                $va = mb_convert_encoding($v, "GBK", "UTF-8");
                $data[$key][$ke] = $va;
            }

        }
        //生成cvs文件
        $csv = new ECSVExport($data);
        $output = $csv->toCSV();
        Mod::app()->getRequest()->sendFile('参与文旦用户列表.csv', $output, "text/csv", false);
        exit();
    }

    public function actionPcview()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));

        //start所属权限开始
        if($id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_wenda}} where id=$id";
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



        $parame = array(
            'id' => $id,
            'config'=>array(
                'site_title'=> '问答活动页面-pc版活动页面-大楚网用户开放平台',
                'Keywords'=>'大楚网用户开放平台,问答，抽奖，一等奖',
                'Description'=>'大楚网用户开放平台_问答活动页面_pc版活动页面'
            ),
        );

        $this->render('pcview', $parame);
    }


    public function actionExample()
    {
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        //获取点击编辑是得到的活动id
        $fid = trim(Tool::getValidParam('id', 'integer'));//活动ID 开发写的不一致
        if(!$fid)   $fid = trim(Tool::getValidParam('id', 'integer'));//做下hack

        if (!$fid) {die('非法访问');}

        //start所属权限开始
        $sql = "select * from {{activity_wenda}} where id=$fid";
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
        $sql = "select * from {{activity_wenda}} where id=$fid";
        $activity_info = Mod::app()->db->createCommand($sql)->queryRow();


        //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
        $config['active_1'] = '3';
        //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
        $config['active'] = 6;
        $config['pid'] = $activity_info['pid'];
        $config['site_title']='开发者示例-编辑问答活动-大楚网用户开放平台';
        $config['Keywords']='大楚网用户开放平台,问答，抽奖，一等奖';
        $config['Description']='添加问答活动_编辑大转盘活动';



        $parame = array(
            'config' => $config,
            'activity_info' => $activity_info,
        );
        $this->render('example', $parame);

    }

    /*
     *  活动PVUV统计图表
     */
    public function actionActivitylist(){
        if(!isset(Mod::app()->session['admin_user'])) {  //后台管理员可看
            if (!$this->member || !$this->member['id'] || !$this->member['pstatus']) {
                $this->redirect(Mod::app()->request->getHostInfo());
                exit;
            }
        }
        $config['aid'] = trim(Tool::getValidParam('fid', 'integer'));//活动ID 开发写的不一致
        $config['tag'] = trim(Tool::getValidParam('tag', 'string'));//活动ID 开发写的不一致
        $config['model'] = "wenda";
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
                    $pv = Mod::app()->db->createCommand()->select('count_num')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=1 and model = "' . wenda . '" and createtime=' . $v['day_date'])->queryRow();
                    $uv = Mod::app()->db->createCommand()->select('count(0)')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=2 and model = "' . wenda . '" and createtime=' . $v['day_date'])->queryRow();
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
                $table_user = "dym_activity_".wenda."_user";
                $data['signup'] = Mod::app()->db->createCommand()->select('count(0)')->from('dym_member_activity')->where('aid=' . $config['aid'] . ' and model = "' . wenda . '" and (createtime between '.strtotime($last).' and '.$now.')')->queryRow();
                $data['join'] = Mod::app()->db->createCommand()->select('count(0)')->from($table_user)->where('wendaid=' . $config['aid'] . '  and (time between '.strtotime($last).' and '.$now.')')->queryRow();
                $config['userdata']['signup'] = $data['signup']['count(0)'];
                $config['userdata']['join'] = $data['join']['count(0)'];
                $config ['time']['start_time'] = $last;
                $config ['time']['end_time'] = date('Y-m-d',$now);
                break;
        }


        $this->render('activitylist',$config);
    }
    
    /*
     *   处理用户答题
     */
    public function actionGetuseranswer(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $wendaid = trim(Tool::getValidParam('wendaid', 'integer'));//活动ID
        $answer_arr_id = Tool::getValidParam('answer_arr_id',"array");//用户回答的答案ID组

        //查询活动数据
        $sql = "select * from {{activity_wenda}} where id=$wendaid";
        $info = Mod::app()->db->createCommand($sql)->queryRow();

        //查询用户抽奖的次数
        $wheretime = strtotime(date('Y-m-d'));//今天凌晨时间戳
        $endtime = strtotime(date('Y-m-d', strtotime('+1 day')));//明天凌晨时间戳
        $usercount = Activity_wenda_user::model()->count('mid=:mid AND time>:time AND time<:timeend AND wendaid=:wendaid', array(':mid' => $this->member['id'], ':time' => $wheretime, ':timeend' => $endtime, ':wendaid' => $wendaid));

        $dayCount = intval($info['day_count']) - intval($usercount);
        $dayCount = $dayCount > 0 ? $dayCount : 0;
        if(!$dayCount){
            echo json_encode(array('status'=>-2,'msg'=>'没机会了'));
            exit;

        }
        $info['chance_count'] = $dayCount-1;

        $bingo_num = 0 ; //答对题数
        $answer_bingo_arr = array(); //答对题数id组
        foreach ($answer_arr_id as $v){
            //查询答案是否正确
            $sql = "select * from {{activity_wenda_answer}} where id=$v";
            $answer_info = Mod::app()->db->createCommand($sql)->queryRow();
            if($answer_info['status']==1){
                $bingo_num++;
                $answer_bingo_arr[]=$answer_info['questionid'];
            }
        }

        $answer_bingo_id = implode(",",$answer_bingo_arr);
        $datajoin['mid'] = $this->member['id'];
        $datajoin['answer_bingo_num'] = $bingo_num;
        $datajoin['answer_bingo_id'] = $answer_bingo_id;
        $datajoin['wendaid'] = $wendaid;
        $datajoin['time'] = time();

        $resjifen = Mod::app()->db->createCommand()->insert('{{activity_wenda_user}}', $datajoin);

        $info['bingo_num']=$bingo_num;

        //如果大于活动所设置的获奖资格数量 即可抽奖
        if($bingo_num >= $info['wenda_prize_num']){
            echo json_encode(array('status'=>200,'data'=>$info));
            exit;
        }else{
            echo json_encode(array('status'=>201,'data'=>$info));
            exit;
        }
    }
    


}



