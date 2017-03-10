<?php

/**
 *
 * @author yuwanqiao
 * 集卡控制器
 *
 */
class CollectcardController extends FrontController
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
        //目前考虑的是通过 签到 投票 报名等方式来集卡
        //思路
        /*
         * 1、当 投票或者报名成功之后  给一个跳转提示，来到集卡活动页面，然后通过抽奖系统，生成卡片
         * 2、在投票或者签到或者报名 活动处设置是否开启集卡，是，则签到成功的时候 通过抽奖算法 生成卡片，然后到集卡活动页面查看 和合成
         *
         * */
        $this->render('view');


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
                $res=Activity_collectcard::model()->findByPk($id);
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
        $as_list = Activity_collectcard::model()->getActivityListPager($pid);

//        if(1==1) { //default模板风格
//            if (!$as_list['count']) {
//                $redirect_url = Mod::app()->baseUrl . '/activity/collectcard/add/pid/' . $pid;
//                $this->redirect($redirect_url);
//            }
//        }
        $config['site_title'] = '集卡活动列表-大楚用户开放平台首页';
        $config['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网,活动组件,集卡";
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
        $this->render('list_collectcardcard', $parame);
    }


    //修改奖品   wenlijiang
    public function actionPrize(){
        $activity_id =   trim(Tool::getValidParam('id', 'integer'));
        
        //start所属权限
        if($activity_id){//编辑
                //判断是不是自己的所属项目 不是没有权限
                $sql = "select * from {{activity_collectcard}} where id=$activity_id";
                $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                if(!$activity_info['pid']){die('数据非法！');}
                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                if($this->memberverify($projectinfo['mid'])){
                     echo json_encode(array(  'state' => 0,   'msg' => '非法访问' )); exit;
                }
        }else{
               die('非法访问');
        }
        //end所属权限   
            
          if (Mod::app()->request->isPostRequest) {
                   //活动进行中不能编
                   if($activity_info['status']==1){
                       $res = array(  'state' => 0,   'msg' => '活动进行中不能编辑' );
                       echo json_encode($res); exit;
                   }
                   
                    /*先将奖品信息插入数据库*/
                    $p_title = Tool::getValidParam('p_title');
                    // $p_title= Mod::app()->request->getParam('p_title');
                    $p_name = Tool::getValidParam('p_name');
                    $p_num = Tool::getValidParam('p_num');
                    $p_snum = Tool::getValidParam('p_snum');//剩余奖品数量
                    $p_v = Tool::getValidParam('p_v');
                    $p_id = Tool::getValidParam('p_id');//奖品ID

                    $prize_id_arr = array();
                    $prize_id = '';
                    $p_num_all = 0;  
                    
                    
                    //步骤1：查找之前的奖品
                    $prize_arr_id = array();
                    $sql = "select * from {{activity_collectcard_prize}} where aid=".$activity_info['id']." and status =1";
                    $prize = Mod::app()->db->createCommand($sql)->queryAll();
                    foreach($prize as $val){
                        $prize_arr_id[] = $val['id'];
                    }
                    

    
                    //取交集
                    $prize_id_intersect = array_intersect($prize_arr_id,$p_id);
                    //取差集
                    $prize_id_diff = array_diff($prize_arr_id,$p_id);
                    
//                    var_dump($prize_arr_id);
//                    var_dump($p_id);
//                    var_dump($prize_id_intersect);
//                    var_dump($prize_id_diff);
//             
                     //开启事务
                    $transaction = Mod::app()->db->beginTransaction();
                    try {
                    
             
                            $new_prize_arr_id = array();
         //                    步骤2：对比现在的奖品  更新之前编辑的奖品
                            
                            foreach ($prize_id_intersect as $key => $val) {
                                //更新的
                                if(in_array($val,$prize_arr_id)){

                                    $prize_data['title'] = $p_title[$key];
                                    $prize_data['mid'] = $this->member['id'];
                                    $prize_data['name'] = $p_name[$key];
                                    $prize_data['count'] = $p_num[$key];
                                    $prize_data['probability'] = $p_v[$key];
                                    $prize_data['remainder'] = $p_snum[$key]<=$p_num[$key]?$p_snum[$key]:0;
                                    $prize_data['updatetime']=time();
                                    $prize_data['aid']=$activity_info['id'];
                                    $prize_data['mid'] = $this->member['id'];
                                    $prize_data['status'] = 1;
                                    $update_id = array(':id' => $val);

                                    //查询历史中数量
                                     $sql = "select * from {{activity_collectcard_user}} where collectcard_id =".$activity_info['id']." and prize_id = ".$val." and is_win =1 ";
                                     $this_win_list = Mod::app()->db->createCommand($sql)->queryAll();
                                     if(($prize_data['remainder']+count($this_win_list)) >$prize_data['count']){
                                           $transaction->rollBack();
                                           
                                           //严重数据错误
                                            echo json_encode(array(  'state' => 0,   'msg' => '中奖的数量加上+剩余的数量已经大于奖品的数量' )); exit;
//                                           die('中奖的数量加上+剩余的数量已经大于奖品的数量');
                                     }
                                     
                                     if(($prize_data['remainder']+count($this_win_list)) !=$prize_data['count']){
                                           $transaction->rollBack();
                                           
                                           //严重数据错误
                                            echo json_encode(array(  'state' => 0,   'msg' => '中奖的数量加上+剩余的数量不等于奖品的数量，现在已中奖数为'.+count($this_win_list) )); exit;
                                     }
                                    $res = Mod::app()->db->createCommand()->update('{{activity_collectcard_prize}}', $prize_data, 'id=:id', $update_id);
                                    $new_prize_arr_id[] = $val;
                                }
                            }

        //                   步骤3：对比现在的奖品  有删除的就删除掉    
                            foreach ($prize_id_diff as $key => $val) {
                                //删除的 
                                if(in_array($val,$prize_arr_id)){
                                    Mod::app()->db->createCommand()->update('{{activity_collectcard_prize}}', array('aid'=>$activity_info['id'],'status'=>0,'updatetime'=>time()), 'id='.$val);
                                } 
                            }

        //                    步骤5：对比现在的奖品  写入新增的奖品        
                            foreach($p_id as $key => $val ){
                                //新增的 
                                if(!$val){
                                    $prize_data['title'] = $p_title[$key];
                                    $prize_data['mid'] = $this->member['id'];
                                    $prize_data['name'] = $p_name[$key];
                                    $prize_data['count'] = $p_num[$key];
                                    $prize_data['probability'] = $p_v[$key];
                                    $prize_data['remainder'] = $p_snum[$key]<=$p_num[$key]?$p_snum[$key]:0;
                                    $prize_data['createtime']=time();
                                    $prize_data['aid']=$activity_info['id'];  
                                    $prize_data['status'] = 1;
                                    $prize_model = new Activity_collectcard_prize();
                                    $prize_model->attributes = $prize_data;
                                    $prize_model->save();
                                    $id = $prize_model->primaryKey;
            
                                    $new_prize_arr_id[] = $id;
                                }

                            }

                            if(count($new_prize_arr_id)<4 ||count($new_prize_arr_id)>12){
                                    $transaction->rollBack();
                                    echo json_encode(array(  'state' => 0,   'msg' => '集卡的奖品种类至少是4张,最多12张' )); exit;
                            }

                            Activity_collectcard::model()->updateByPk($activity_id, array('prize_id'=> implode(',',$new_prize_arr_id),'jishu'=>Tool::getValidParam('jishu')));//更新基数 ，更新奖品字段冗余吧 之前开发写的 我也更新下吧
                                        
                         $transaction->commit();
                          echo json_encode(array(  'state' => 1,  'aid'=>$activity_id, 'msg' => '修改成功' )); exit;
                    } catch (Exception $e) { //如果有一条查询失败，则会抛出异常
                        $transaction->rollBack();
                          echo json_encode(array(  'state' => 0,   'msg' => '修改失败' )); exit;
                    }
                    die;
           }else{
               
           
                    
                   $activity_collectcard_info = $activity_info;
                 
                    $sql = "select * from {{activity_collectcard_prize}} where aid=".$activity_info['id']."  and status =1";
                    $prize = Mod::app()->db->createCommand($sql)->queryAll();
                            

                    //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
                    $config['active_1'] = '3';
                    //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
                    $config['active'] = 10;
                    $config['site_title']='奖品设置-编辑集卡活动-大楚网用户开放平台';
                    $config['Keywords']='大楚网用户开放平台,集卡，抽奖，一等奖';
                    $config['Description']='添加集卡活动_编辑集卡活动'; 
 
                    $parame = array(
                        'config' => $config,
                        'activity_info' =>$activity_collectcard_info,
                        'prize' => $prize,
                        'status' => $this->activity_status('collectcard'),
                    );
      
                    $this->render('prize_collectcardcard', $parame);
        }
        

    }


    /*
     * 上传活动图片 方法
     * */

    public function actionUploadimg(){
        $activity_id =   trim(Tool::getValidParam('id', 'integer'));

        //start所属权限
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_collectcard}} where id=$activity_id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法！');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->memberverify($projectinfo['mid'])){
                echo json_encode(array(  'state' => 0,   'msg' => '非法访问' )); exit;
            }
        }else{
            die('非法访问');
        }
        //end所属权限

        if (Mod::app()->request->isPostRequest) {
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
              $img['share_img'] = Tool::getValidParam('share_img', 'string');

            $update_id = array(':id' => $activity_id);
            if($img){
                $has_edit_img = false;
                $re=Activity_collectcard_img::model()->find("collectcard_id=:id",$update_id);
                if($re){
                    $img['updatetime']=time();
                    $imgre = Mod::app()->db->createCommand()->update('{{activity_collectcard_img}}', $img, 'collectcard_id=:id', $update_id);
                    $str = "编辑";

                }else{
                    $img['collectcard_id']=$activity_id;
                    $img['createtime']=time();
                    $imgre = Mod::app()->db->createCommand()->insert('{{activity_collectcard_img}}', $img);
                    $str = "新增";
                }
            }else{
                echo json_encode(array(  'state' => 0,   'msg' => '没有数据提交，请联系管理员！' )); exit;
            }
            if($imgre){
                echo json_encode(array(  'state' => 1,   'msg' => $str.'成功' )); exit;
            }else{
                //如果保存失败，删除已经给上产的文件
                foreach($img as $v){
                    unlink($v);
                }

                echo json_encode(array(  'state' => 0,   'msg' => $str.'失败， 请联系管理员！' )); exit;
            }


        }





        //获取各种图片
        $images=Activity_collectcard_img::model()->find("collectcard_id=:collectcard_id",array(':collectcard_id'=>$activity_id));

        //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
        $config['active_1'] = '3';
        //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
        $config['active'] = 10;
        $config['site_title']='奖品设置-编辑集卡活动-大楚网用户开放平台';
        $config['Keywords']='大楚网用户开放平台,集卡，抽奖，一等奖';
        $config['Description']='添加集卡活动_编辑集卡活动_活动图片上传';
        $parame = array(
            'config' => $config,
            'activity_info' =>$activity_info,
            'images'=>$images,
            'status' => $this->activity_status('collectcard'),
        );
        $this->render('img_collectcardcard', $parame);
    }

    /**
     * @author yuwanqiao
     * 后台添加集卡活动和编辑在一起
     */
    public function actionAdd()
    {
    /*******************************************安全验证 *****************************************/
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
                    $sql = "select * from {{activity_collectcard}} where id=$activity_id";
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

            /*******************************************安全验证end *****************************************/
            //活动进行中不能编辑

           if($activity_info['status']==1 && $activity_info['end_time']>time() && $activity_info['start_time']<time()){
               $res = array(
                   'state' => 1,
                   'msg' => '活动进行中不能编辑',
               );
               echo json_encode($res);
               exit;
           }



            //组装数据
            $arr=array();
            //转换时间戳
            $data['start_time'] = strtotime(trim(Tool::getValidParam('start_time', 'string')));
            $data['end_time'] = strtotime(trim(Tool::getValidParam('end_time', 'string')));

            //拼装活动数据
            $arr['pid']=$pid;
            $arr['title']=Safetool::SafeFilter($data['title']);
            $arr['start_time']=Safetool::SafeFilter($data['start_time']);
            $arr['end_time']=Safetool::SafeFilter($data['end_time']);
            $arr['win_num']=Safetool::SafeFilter($data['win_num']);
            $arr['day_count']=Safetool::SafeFilter($data['day_count']);
            $arr['win_msg']=Safetool::SafeFilter($data['win_msg']);
            $arr['lose_msg']=Safetool::SafeFilter($data['lose_msg']);
            $arr['rule']=Safetool::SafeFilter($data['rule']);
            $arr['lingjiang']=Safetool::SafeFilter($data['lingjiang']);
            $arr['share_desc']=Safetool::SafeFilter($data['share_desc']);
            $arr['share_url']=Safetool::SafeFilter($data['share_url']);
            $arr['tag']=Safetool::SafeFilter($data['tag']);
            $arr['share_switch']=Safetool::SafeFilter($data['share_switch']);
            $arr['prize_number']=Safetool::SafeFilter($data['prize_number']);
            $arr['mid'] = $this->member['id'];

            //处理换行
            $arr['rule'] = str_replace('\n',"<br>",$arr['rule']);
            $arr['rule'] = str_replace('\r\n',"<br>",$arr['rule']);


            $res = 1;
            //为真表示编辑
            if ($activity_id) {
                $update_id = array(':id' => $activity_id);
                $query = Mod::app()->db->createCommand()->update('{{activity_collectcard}}', $arr, 'id=:id', $update_id);
                $str = '编辑';

            } else {
                $arr['add_time'] = time();
                $query = Mod::app()->db->createCommand()->insert('{{activity_collectcard}}', $arr);
                $str = '添加';
                if ($query) {
                    $activity_id = Mod::app()->db->getLastInsertID();
                        //新增加活动之后生成站内信息
                        $tablename = "collectcard";
                        $url = $this->_siteUrl . "/activity/collectcard/view/id/" . $activity_id;
                        $this->my_message("集卡活动[" . $arr['title'] . "]", time(), "新增", $arr['pid'], $url, $tablename);
                }
            }
            //把  活动id 存期来，方便后面添加奖品和图片（本来也可以传的，但是考虑到不安全所以存session）
                 Mod::app()->session['playegg_id']=$activity_id;

            if ($query) {
                $res = array(
                    'state' => 1,
                    'aid' => $activity_id,
                    'msg' => $str . '集卡成功'
                );
            } else {
                $res = array(
                    'state' => 0,
                    'msg' => $str . '集卡失败'
                );
            }
            echo json_encode($res);
        } else {
            //获取点击编辑是得到的活动id
            $fid = trim(Tool::getValidParam('id', 'integer'));//活动ID 开发写的不一致
            if(!$fid)   $fid = trim(Tool::getValidParam('id', 'integer'));//做下hack
            
  
           
            if ($fid) {
                //start所属权限开始
                $sql = "select * from {{activity_collectcard}} where id=$fid";
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
                $sql = "select * from {{activity_collectcard}} where id=$fid";
                $result = Mod::app()->db->createCommand($sql);
                $query = $result->queryAll();
                //查询对应的奖项

                //获取奖品
                $sql = "select * from {{activity_collectcard_prize}} where aid=".$activity_info['id']." and status =1";
                $prize = Mod::app()->db->createCommand($sql)->queryAll();
                        
        
                //获取各种图片
                $images=Activity_collectcard_img::model()->find("collectcard_id=:collectcard_id",array(':collectcard_id'=>$fid));

            } else {
                $prize = array();
                $query = array();

            }



           $pid = $activity_info['pid']?$activity_info['pid']:  Tool::getValidParam('pid','integer');
         
            //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
            $config['active_1'] = '3';
            //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
            $config['active'] = 10;
            $config['pid'] = $pid;
            $config['site_title']='添加集卡活动-编辑集卡活动-大楚网用户开放平台';
            $config['Keywords']='大楚网用户开放平台,集卡，抽奖，一等奖';
            $config['Description']='添加集卡活动_编辑集卡活动';


            $psql = "SELECT p.type,a.id,a.name from {{project}} as p LEFT JOIN {{application_tag}} as a on p.type=a.classid WHERE p.id=$pid  order by a.updatetime desc";
            $ptag = Mod::app()->db->createCommand($psql);
            $tag = $ptag->queryAll();
            $ptag = explode('_', substr($query[0]['tag'], 0, -1));

            
            
             //处理换行
            $query[0]['rule'] = str_replace("<br>","\n",$query[0]['rule']);  
            
            
            $parame = array(
                'config' => $config,
                'activity_info' => $query[0],
                'prize' => $prize,
                'ptag' => $ptag,
                'tag' => $tag,
                'images'=>$images,
                'status' => $this->activity_status('collectcard'),

            );

            $this->render('add_collectcardcard', $parame);
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
                //查询集卡中的奖品
                $collectcard = Mod::app()->db->createCommand()->select('*')->from('{{activity_collectcard}}')->where('id=' . $fid)->queryRow();
                if (!$collectcard) {
                    $result = array(
                        'errorcode' => 0
                    );
                    echo json_encode($result);
                    exit;
                }

                //防止ID遍历
                $projectinfo =  JkCms::getprojectByid($collectcard['pid']);
                if($this->memberverify($projectinfo['mid'])){
                    $result = array(
                        'errorcode' => 0
                    );
                    echo json_encode($result);
                    exit;
                }


                $prizeid = rtrim($collectcard['prize_id'], ',');
                $arr_id = explode(',', $prizeid);
                foreach ($arr_id as $val) {
                    Mod::app()->db->createCommand()->delete('{{activity_collectcard_prize}}', 'id IN(' . $prizeid . ')');
                }
                $res = Mod::app()->db->createCommand()->delete('{{activity_collectcard}}', 'id IN(' . $fid . ')');
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
            $sql = "select * from {{activity_collectcard}} where id=$activity_id";
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
        $query = Mod::app()->db->createCommand()->update('{{activity_collectcard}}', $arr, 'id=:id', $update_id);
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
     * ajax请求
     * 用户查看自己的中奖列表
     */
    public function actionUserWinPrize()
    {
        if(!$this->member  ||  !$this->member['id'] ){
           die('非法访问');
        }
        $id = trim(Tool::getValidParam('id', 'integer'));



        $openid = trim(Tool::getValidParam('openid', 'string'));
        $mid = $this->member['id'];
        $where = array(
            ':mid' => $mid,
            ':openid' => $openid,
            ':collectcard_id' => $id,
            ':is_win' => 1
        );
        $win_prize_res = Mod::app()->db->createCommand()->select('*')->from('{{activity_collectcard_user}}')->where("collectcard_id=:collectcard_id and mid=:mid and openid=:openid and is_win=:is_win", $where)->queryAll();

        if ($win_prize_res) {
            foreach ($win_prize_res as $key => $val) {
                $id = $val['prize_id'];
                $sql = "SELECT * FROM {{activity_collectcard_prize}} WHERE id=$id and status =1";
                $prize_info = Mod::app()->db->createCommand($sql)->queryRow();

                $win_prize[$key]['title'] = $prize_info['title'];
                $win_prize[$key]['name'] = $prize_info['name'];
                $win_prize[$key]['code'] = $val['code'];
            }
        } else {
            $win_prize = array();
        }

        if ($win_prize) {
            $result = array(
                'msg' => $win_prize,
                'code' => 1
            );
        } else {
            $result = array(
                'msg' => $win_prize,
                'code' => 0
            );
        }
        echo json_encode($result);
    }

    /**
     * @author yuwanqiao
     * 用户刮卡之后通过ajax调用获取中奖状态,并将用户操作写入数据库保存
     * 这里进行计算用户是否中奖
     */
    public function actionGetWin(){
        $id = trim(Tool::getValidParam('id', 'integer'));
        // $mid = trim(Tool::getValidParam('mid','integer'));
        $openid = trim(Tool::getValidParam('openid', 'string'));
        $mid = $this->member['id'];

        $sql = "select * from {{activity_collectcard}} where id=$id  ";
        $info = Mod::app()->db->createCommand($sql)->queryRow();
        
        if(!$id || !$mid || !$info){
            echo "非法访问";
            exit;
        }

        if($info['status']!=1){
            $res_arr = array(
                'msg' => "活动已暂停",
                'code' => "-1"
            );
            echo json_encode($res_arr);
            exit;
        }
        
        //活动未开始
        if($info['start_time']>time()){
            $res_arr = array(
                'msg' => "活动未开始",
                'code' => "-1"
            );
            echo json_encode($res_arr);
            exit;
        }
        
        /*活动暂停中*/
        if(!$info['status']){
            $res_arr = array(
                'msg' => "活动暂停中",
                'code' => "-2"
            );
            echo json_encode($res_arr);
            exit;
        }
        
        //活动已经结束
        if($info['end_time']<time()){
            $res_arr = array(
                'msg' => "活动已经结束",
                'code' => "-3"
            );
            echo json_encode($res_arr);
            exit;
        }

        $prize_id = rtrim($info['prize_id'], ',');
        $sql = "SELECT * FROM {{activity_collectcard_prize}} WHERE status =1  and id IN ($prize_id)";
        $prize = Mod::app()->db->createCommand($sql)->queryAll();
        if(!$prize){die('数据不合法');}
        $count_prize = count($prize);
        $prize_arr = array();
        foreach ($prize as $key => $val) {
            $prize_arr[$key]['id'] = $val['id'];
            $prize_arr[$key]['v'] = $val['probability'];
            $count_v += $val['probability'];
        }

        //下面设置的是不中奖的概率 加入不中奖的奖品 做概率计算 jishu是中奖的基数
        $prize_arr[$count_prize]['id'] = 0;
        $prize_arr[$count_prize]['v'] = abs($info['jishu'] - $count_v);

        $sql = "select count(id) as con from {{activity_collectcard_user}} where collectcard_id=" . $id . " and  mid=" . $mid . " and is_win=1";
        $zj_con = Mod::app()->db->createCommand($sql)->queryRow();

        if ($zj_con['con'] >= $info['win_num']) {
            $prize_id = 0;
        } else {
            //获取中奖的商品的id，0表示没有中奖
            $prize_id = $this->actionGetPrize($prize_arr);
            $sql = "SELECT * FROM {{activity_collectcard_prize}} WHERE id=$prize_id and status =1";
            $prize_info = Mod::app()->db->createCommand($sql)->queryRow();
            if ($prize_info['remainder'] > 0) {
                $prize_id = $prize_id;
                //查询中奖的id 该用户是否中过此等奖 防止重复中奖
                $re=Activity_collectcard_user::model()->find('prize_id=:prize_id AND collectcard_id=:collectcard_id AND mid=:mid',array(':prize_id'=>$prize_id,':collectcard_id'=>$id,':mid'=>$this->member['id']));
                if($re){
                    $prize_id = 0;
                }
            } else {
                $prize_id = 0;
            }

        }

        //查询当前用户剩余抽奖次数
        $wheretime = strtotime(date('Y-m-d'));//今天凌晨时间戳
        $endtime = strtotime(date('Y-m-d', strtotime('+1 day')));//明天凌晨时间戳
        //得到该用户在当天参加的次数
        $usercount = Activity_collectcard_user::model()->count('mid=:mid AND time>:time AND time<:timeend AND collectcard_id=:collectcard_id', array(':mid' => $mid, ':time' => $wheretime, ':timeend' => $endtime, ':collectcard_id' => $id));
        //用活动设定当天可抽奖次数减去已参加次数等于还可以抽奖次数
        //var_dump($usercount);
        $dayCount = intval($info['day_count']) - intval($usercount);
        $dayCount = $dayCount > 0 ? $dayCount : 0;
        if(!$dayCount){
            $res_arr = array(
                "startTime" => $info['start_time'],
                "endTime" => $info['end_time'],
                "dayCount" => $dayCount,
                "prizeKind" => 0,
                "prizeName" => "0",
                'msg' => '今天没有抽奖次数了！',
                'code' => "0"
            );
            echo json_encode($res_arr);
            exit;
        }

 //开启事务
$transaction = Mod::app()->db->beginTransaction();
try {
//        echo $prize_id;exit;
        if ($prize_id && $dayCount) {//表中奖
//            $redis_key="collectcard_prize_".$prize_id;
//            $check = $redis->lPop($redis_key);
//            if($check && $check!="nil") {
            //如果中奖则减少奖品
           
//                    if ($check) {
                //根据奖品id查询奖品信息
                $sql = "SELECT * FROM {{activity_collectcard_prize}} WHERE id=$prize_id and status = 1 for update";
                $prize_info = Mod::app()->db->createCommand($sql)->queryRow();
                $data_user['is_win'] = 1;
                $data_user['prize_id'] = $prize_id;
                $data_user['code'] = rand(100000, 999999);

                //几等奖把文字换成数字
                $prizeKind = 0;
                switch ($prize_info['title']) {
                    case "一等奖":
                        $prizeKind = 1;
                        break;
                    case "二等奖":
                        $prizeKind = 2;
                        break;
                    case "三等奖":
                        $prizeKind = 3;
                        break;
                    case "四等奖":
                        $prizeKind = 4;
                        break;
                    case "五等奖":
                        $prizeKind = 5;
                        break;
                    case "六等奖":
                        $prizeKind = 6;
                        break;
                }

                $res_arr = array(
                    "startTime" => $info['start_time'],
                    "endTime" => $info['end_time'],
                    "dayCount" => $dayCount,
                    "prizeKind" => $prizeKind,
                    "prizeName" => $prize_info['name'],
                    'msg' => $prize_info['title'],
                    'code' => $data_user['code']
                );


//                    $result = $redis->lPush('collectcard_user_' . $id, $data_user['code'] . "-" . $mid);

                $sql = " UPDATE {{activity_collectcard_prize}} SET remainder = remainder-1 WHERE id = $prize_id and status =1 ";
                $res = Mod::app()->db->createCommand($sql)->execute();
//                    }
        

        } else {//表示没有中奖
            $prize_id = 0;
            $data_user['is_win'] = 0;

            $res_arr = array(
                "startTime" => $info['start_time'],
                "endTime" => $info['end_time'],
                "dayCount" => $dayCount,
                "prizeKind" => 0,
                "prizeName" => "0",
                'msg' => "not prize",
                'code' => "0"
            );

        }

        $data_user['collectcard_id'] = $id;//活动id
        $data_user['day_count'] = intval($info['day_count'] - 1) > 0 ? intval($info['day_count'] - 1) : 0;//每天可以刮卡的次数，先保存先在没用到，后期用户分享后增加刮卡次数会修改这个字段的值
        $data_user['mid'] = $mid;
        $data_user['openid'] = $openid;
        $data_user['time'] = time();
        $resjifen = Mod::app()->db->createCommand()->insert('{{activity_collectcard_user}}', $data_user);

        
    $transaction->commit();
} catch (Exception $e) { //如果有一条查询失败，则会抛出异常
    $transaction->rollBack();
}
            
            
        //插入行为表
        $win = 0;
        $name = "";
        if ($prize_id) {
            $win = 1;
            $name = $prize_info['name'];
        }
        $res = Behavior::behavior_points(5, $mid, $info['pid'], $name, $win, $id, 'activity_collectcard');
        if ($res['code'] == 200) {
            $jifen = array(
                'pid' => $info['pid'],
                'mid' => $mid,
                'qty' => $res['points'],
                'type' => 1,
                'createtime' => time(),
                'content' => '集卡得积分',
            );
            $query = Mod::app()->db->createCommand()->insert('dym_member_point_log', $jifen);
        }

        echo json_encode($res_arr);
        exit;
    }
    /**
     * @author yuwanqiao
     * 根据概率算法获取中奖的项目
     */
    /*
     * 经典的概率算法，
     * $proArr是一个预先设置的数组，
     * 假设数组为：array(100,200,300，400)，
     * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，
     * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间，
     * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。
     * 这样 筛选到最终，总会有一个数满足要求。
     * 就相当于去一个箱子里摸东西，
     * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。
     * 这个算法简单，而且效率非常 高，
     * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。
     */
    function get_rand($proArr)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
    }

    public function actionGetPrize($prize_arr)
    {

        /*
         * 奖项数组
         * 是一个二维数组，记录了所有本次抽奖的奖项信息，
         * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。
         * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0，
         * 数组中v的总和（基数），基数越大越能体现概率的准确性。
         * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%，
         * 如果v的总和是10000，那中奖概率就是万分之一了。
         *
         */
        /* $prize_arr = array(
            '0' => array('id'=>1,'prize'=>'平板电脑','v'=>1),
            '1' => array('id'=>2,'prize'=>'数码相机','v'=>5),
            '2' => array('id'=>3,'prize'=>'音箱设备','v'=>10),
            '3' => array('id'=>4,'prize'=>'4G优盘','v'=>12),
            '4' => array('id'=>5,'prize'=>'10Q币','v'=>22),
            '5' => array('id'=>0,'prize'=>'下次没准就能中哦','v'=>50)，//0不中奖
        );
         */
        /*
         * 每次前端页面的请求，PHP循环奖项设置数组，
         * 通过概率计算函数get_rand获取抽中的奖项id。
         * 最后输出json个数数据给前端页面。
        */

        foreach ($prize_arr as $key => $val) {
            $arr[$val['id']] = $val['v'];
        }
        $rid = $this->get_rand($arr); //根据概率获取奖项id
        return $rid;
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
        $datatype = trim(Tool::getValidParam('datatype', 'integer'));
        $search = trim(Tool::getValidParam('search', 'string'));
        $username = trim(Tool::getValidParam('username', 'string'));

        //start所属权限开始
        $activity_id =   $fid;
        if($activity_id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_collectcard}} where id=$activity_id";
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
             $Usql = "select m.id from dym_member as m right join dym_activity_collectcard_user as b on m.id=b.mid where m.username like '%".$username."%'";
             $userid = Mod::app()->db->createCommand($Usql)->queryAll();
         }*/
        if ($datatype == 1) {
            $is_win = 1;
            $active = 'active_win';
        } elseif ($datatype == 2) {
            $is_win = 2;
            $active = 'active_no';
        } else {
            $is_win = '';
            $active = 'active_all';
        }
        $as_list = Activity_collectcard_user::model()->getUserListPager($fid, $is_win, $search, $username);
        if ($as_list['count']) {
            foreach ($as_list['criteria'] as $key => $val) {
                //根据用户id查询用户信息
                $mid = $val['mid'];
                $sql = "select * from dym_member where id = $mid";
                $user = Mod::app()->db->createCommand($sql)->queryRow();
                //根据奖品id查询奖品信息
                $prizeid = $val['prize_id'];
                if ($prizeid) {
                    $sql = "select * from {{activity_collectcard_prize}} where id = $prizeid";
                    $prize = Mod::app()->db->createCommand($sql)->queryRow();
                } else {
                    $prize = array();
                }
                $as_list['users'][$key]['id'] = $val['id'];
                $as_list['users'][$key]['collectcard_id'] = $val['collectcard_id'];
                $as_list['users'][$key]['mid'] = $val['mid'];
                $as_list['users'][$key]['phone'] = $user['phone'];
                $as_list['users'][$key]['username'] = $user['username'];
                $as_list['users'][$key]['code'] = $val['code'];
                $as_list['users'][$key]['level'] = $prize['title'];
                $as_list['users'][$key]['time'] = $val['time'];
                $as_list['users'][$key]['accept'] = $val['accept'];
            }
        } else {
            $as_list['count'] = '0';
            $as_list['users'] = array();
        }
        $as_list['active'] = $active;
        $as_list['id'] = $fid;
        $as_list['search'] = $search;
        $as_list['username'] = $username;
        $as_list['type'] = $datatype;
        $as_list['config']=array(
            'site_title'=> '添加集卡活动-编辑集卡活动-大楚网用户开放平台',
            'Keywords'=>'大楚网用户开放平台,集卡，抽奖，一等奖',
            'Description'=>'添加集卡活动_编辑集卡活动'
        );
        $this->render('winlist', $as_list);
    }

    /**
     * @author yuwanqiao
     * 设置用户领奖状态
     */
    public function actionLingjiang()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        //start所属权限开始
        $activity_id=Activity_collectcard_user::model()->findByPk($id);

        if($activity_id){//编辑

            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_collectcard}} where id=$activity_id->collectcard_id";
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




        $update_data = array(
            'accept' => 1
        );
        $where_data = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->update('{{activity_collectcard_user}}', $update_data, 'id=:id', $where_data);
        if ($res) {
            $arr = array(
                'code' => 1,
                'msg' => '设置领奖成功'
            );
        } else {
            $arr = array(
                'code' => 0,
                'msg' => '设置领奖失败'
            );
        }
        echo json_encode($arr);
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
            $sql = "select * from {{activity_collectcard}} where id=$fid";
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




        $datatype = trim(Tool::getValidParam('type', 'string'));
        if ($datatype == 1) {
            $where = "collectcard_id = $fid and is_win = 1";
        } elseif ($datatype == 2) {
            $where = "collectcard_id = $fid and is_win = 0";
        } else {
            $where = "collectcard_id = $fid";
        }
        Mod::import('ext.ECSVExport');
        $list = Mod::app()->db->createCommand()
            ->select('*')
            ->from('{{activity_collectcard_user}}')
            ->where($where)
            ->queryAll();
        if ($list) {
            foreach ($list as $key => $val) {
                //根据用户id查询用户信息
                $mid = $val['mid'];
                $sql = "select * from dym_member where id = $mid";
                $user = Mod::app()->db->createCommand($sql)->queryRow();
                //根据奖品id查询奖品信息
                $prizeid = $val['prize_id'];
                if ($prizeid) {
                    $sql = "select * from {{activity_collectcard_prize}} where id = $prizeid";
                    $prize = Mod::app()->db->createCommand($sql)->queryRow();
                } else {
                    $prize = array();
                }
                $as_list[$key]['id'] = $val['id'];
                $as_list[$key]['collectcard_id'] = $val['collectcard_id'];
                $as_list[$key]['mid'] = $val['mid'];
                $as_list[$key]['username'] = $user['username'];
                $as_list[$key]['phone'] = $user['phone'];
                $as_list[$key]['code'] = $val['code'];
                $as_list[$key]['level'] = $prize['title'];
                $as_list[$key]['prizename'] = $prize['name'];
                $as_list[$key]['time'] = $val['time'];
                $as_list[$key]['accept'] = $val['accept'];
                $as_list[$key]['is_win'] = $val['is_win'];
            }
        } else {
            $as_list = array();
        }
        $list = array();
        if ($as_list) {
            foreach ($as_list as $k => $v) {
                $list[$k]['活动id'] = $v['collectcard_id'];
                $list[$k]['用户名'] = $v['username'];
                $list[$k]['手机号'] = $v['phone'];
                $list[$k]['中奖码'] = $v['code'];
                $list[$k]['中奖等级'] = $v['level'];
                $list[$k]['奖品'] = $v['prizename'];
                $list[$k]['抽奖时间'] = date('Y-m-d H:i:s', $v['time']);
                $list[$k]['领奖状态'] = $v['accept'] == 1 ? '已经领奖' : '没有领奖';
                $list[$k]['是否中奖'] = $v['is_win'] == 1 ? '是' : '否';
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
        Mod::app()->getRequest()->sendFile('参与抽奖用户列表.csv', $output, "text/csv", false);
        exit();
    }

    public function actionPcview()
    {
        $id = trim(Tool::getValidParam('id', 'integer'));

        //start所属权限开始
        if($id){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_collectcard}} where id=$id";
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
                'site_title'=> '集卡活动页面-pc版活动页面-大楚网用户开放平台',
                'Keywords'=>'大楚网用户开放平台,集卡，抽奖，一等奖',
                'Description'=>'大楚网用户开放平台_集卡活动页面_pc版活动页面'
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
            $sql = "select * from {{activity_collectcard}} where id=$fid";
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
            $sql = "select * from {{activity_collectcard}} where id=$fid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();


            //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
            $config['active_1'] = '3';
            //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、报名(3)
            $config['active'] = 10;
            $config['pid'] = $activity_info['pid'];
            $config['site_title']='开发者示例-编辑集卡活动-大楚网用户开放平台';
            $config['Keywords']='大楚网用户开放平台,集卡，抽奖，一等奖';
            $config['Description']='添加集卡活动_编辑集卡活动';


           
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
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $config['aid'] = trim(Tool::getValidParam('fid', 'integer'));//活动ID 开发写的不一致
        $config['tag'] = trim(Tool::getValidParam('tag', 'string'));//活动ID 开发写的不一致
        $config['model'] = "collectcard";
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
                    $pv = Mod::app()->db->createCommand()->select('count_num')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=1 and model = "' . collectcard . '" and createtime=' . $v['day_date'])->queryRow();
                    $uv = Mod::app()->db->createCommand()->select('count(0)')->from('dym_activity_browse')->where('aid=' . $config['aid'] . ' and type=2 and model = "' . collectcard . '" and createtime=' . $v['day_date'])->queryRow();
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
                $table_user = "dym_activity_".collectcard."_user";
                $data['signup'] = Mod::app()->db->createCommand()->select('count(0)')->from('dym_member_activity')->where('aid=' . $config['aid'] . ' and model = "' . collectcard . '" and (createtime between '.strtotime($last).' and '.$now.')')->queryRow();
                $data['join'] = Mod::app()->db->createCommand()->select('count(0)')->from($table_user)->where('collectcard_id=' . $config['aid'] . '  and (time between '.strtotime($last).' and '.$now.')')->queryRow();
                $config['userdata']['signup'] = $data['signup']['count(0)'];
                $config['userdata']['join'] = $data['join']['count(0)'];
                $config ['time']['start_time'] = $last;
                $config ['time']['end_time'] = date('Y-m-d',$now);
                break;
        }


        $this->render('activitylist',$config);
    }

}



 