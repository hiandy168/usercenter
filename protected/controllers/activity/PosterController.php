<?php
/**
 * 
 * @author yuwanqiao
 * 刮刮卡控制器
 *
 */
class PosterController extends FrontController {
    public function init() {
        parent::init();
       if(!$this->member && !$_SESSION['mid']){
            //  $this->redirect(Mod::app()->request->getHostInfo());
            // exit;
        }
        //权限管理方法
        $this->activity_permissions('poster');
        Browse::add_usernum($this->member_project['pid']);  //计算独立访客数量
        Browse::add_browsenum($this->member_project['pid']); //计算浏览量
    }

    /**
     * @author yuwanqiao
     * 前端访问页面,显示刮奖的html页面
     */
    public function actionView() {
        $id = trim(Tool::getValidParam('id','integer'));
        // $openid = trim(Tool::getValidParam('openid','string'));
        $token = trim(Tool::getValidParam('accesstoken','string'));
        // if($openid && !ctype_alnum($openid)){die('非法请求');}



        //查询刮刮卡信息
        $sql = "SELECT * FROM {{activity_poster}} WHERE id=$id";
        $info=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$info || empty($info)){die('非法请求');}

        if(intval($info['starttime'])>intval(time())){
            $activity_status="活动还未开始";
        }
        if(intval($info['endtime'])<intval(time())){
            $activity_status="活动已经结束";
        }
        if($this->member['id']){//登录状态
            $mid = $this->member['id'];
        }

        Browse::add_usernum($info['pid']);  //计算独立访客数量
        Browse::add_browsenum($info['pid']); //计算浏览量

        $sql = "SELECT * FROM {{project}} WHERE id=".$info['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

//        $backUrl = "?id=".$id."&accesstoken=".$token."&openid=".$openid;
        $config['site_title'] = '活动组件海报-大楚用户开放平台首页';
        $config['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
        $config['site_description'] ="大楚用户开放平台首页";
        $parame = array(
            'info'=>$info,
            'prize'=>$prize,
            'activity_status'=>$activity_status,
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "token"=>$token,
                "id"=>$id,
                "openid" => $mid,
//                "backUrl" => $backUrl,
                "status" => $mid,
                "mid" => $mid,
                "pid" => $info['pid']
                ),
            'time'=>time(),
            'signPackage'=>$signPackage,
            'config'=>$config,
        );
        $this->render('view_scratch',$parame);
    }
    
    /**
     * @author luozhiqi
     * 后台活动列表
     */
    public function actionGenerateimg(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }


        header("Content-type: image/jpeg");    //浏览器只输出图片,调试时请注释此行
        if (!empty($_FILES['share_img'])) {
            $uploaddir = dirname(__FILE__)."/../../../data/attachment/image/activity/poster/".date("Ymd")."/";
            $path_upload="";
            if(!is_dir($uploaddir)) {
                mkdir($uploaddir, 0777, true);
            }
            $upload=$uploaddir.   "old". time().".jpg";
            if(move_uploaded_file($_FILES["share_img"]["tmp_name"], $upload)) {  
                //插入行为表
                $win = 0;
                $name = "";
                $mid=trim(Tool::getValidParam('mid','integer'));
                //查询海报信息
               $id= trim(Tool::getValidParam('id','integer'));


                $sql = "SELECT * FROM {{activity_poster}} WHERE id=".$id;
                $info=Mod::app()->db->createCommand($sql)->queryRow();
                $res=Behavior::behavior_points(19,$mid,$info['pid'],$name,$win,$id,'activity_poster');

                //获取文字颜色
                $font_color = explode(",", trim(Tool::getValidParam('color','string')));

                $img_type = "jpg";        
             
                switch ($_FILES['share_img']['type']) {
                    case 'image/png':
                        $im = @imagecreatefrompng($upload);    //从图片建立文件，此处以jpg文件格式为例
                        $white = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
                        $img_type = "png";
                        break;
                    case 'image/jpeg':
                        $im = @imagecreatefromjpeg($upload);    //从图片建立文件，此处以jpg文件格式为例
                        $white = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
                        break;
                    case 'image/jpg':
                        $im = @imagecreatefromjpeg($upload);    //从图片建立文件，此处以jpg文件格式为例
                        $white = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
                        break;
                    default:
                        $im = @imagecreatefromjpeg($upload);    //从图片建立文件，此处以jpg文件格式为例
                        $white = imagecolorallocate($im, $font_color[0], $font_color[1], $font_color[2]);
                        break;
                }
                
   
                $text = trim(Tool::getValidParam('content','string')); //要写到图上的文字
                $family = trim(Tool::getValidParam('family','string')); //要写到图上的文字
                $fontsize = trim(Tool::getValidParam('fontsize','integer')); //要写到图上的文字
                $angle = trim(Tool::getValidParam('angle','string')); //要写到图上的文字
                $font = "./assets/font/".$family.'.ttf';  //写的文字用到的字体。
                // $font = $_POST['family'].'.ttf';  //写的文字用到的字体。

                $aa=getimagesize($upload);

			//写入到attachment表
                $weight=$aa["0"];////获取图片的宽
                $height=$aa["1"];///获取图片的高
                $font_size = mb_strlen($text)*10;//获取文字width

                //imagettftext(图片资源,字体尺寸,倾斜度,X轴坐标,Y轴坐标,颜色,字体,文字);

                switch($fontsize){
                    case '16':
                        $fontsize=16;
                    case '18':
                        $fontsize=18;
                    case '22':
                        $fontsize=22;
                    case '24':
                        $fontsize=24;
                    default:
                        $fontsize=20;

                }


                switch ($angle) {
                    case '左上角':
                        //左上角
                        imagettftext($im, $fontsize, 0, 10, 40, $white, $font, $text);
                        break;
                    case '右上角':
                        //右上角
                        imagettftext($im, $fontsize, 0, $weight-$font_size, 40, $white, $font, $text);
                        break;
                    case '左下角':
                        //左下角
                        imagettftext($im, $fontsize, 0, 10, $height-40, $white, $font, $text);
                        break;
                    case '右下角':
                        //右下角
                        imagettftext($im, $fontsize, 0, $weight-$font_size, $height-40, $white, $font, $text);
                        break;
                }

                if($img_type == "jpg"){
                    //$path= "/data/attachment/image/".date("Ymd")."/".time().".jpeg";
                    $path= $uploaddir."poster".time().".jpeg";
                    $saveimgres = imagejpeg($im,$path);//保存文件
                }else{
                    $path=$uploaddir."poster".time().".png";
                    $saveimgres = imagepng($im,$path);//保存文件
                }
                imagedestroy($im);//释放内存
                if($saveimgres){
                //插入表
                $arr = $_POST;
                $arr['createtime']  =time();
                $arr['url'] = $path;
                $arr['pid'] = $id;
                $arr['openid'] = trim(Tool::getValidParam('openid','integer'));
                    foreach($arr as $k=>&$v){
                        $v = strval($v);
                        $v = Safetool::SafeFilter($v);
                    }

                $query = Mod::app()->db->createCommand()->insert('{{activity_poster_user}}',$arr);
                $poster_id = Mod::app()->db->getLastInsertID();
                    $attachment  =  new Attachment();
                    $attachment->mid = $this->member['id'];
                    $attachment->url = $path;
//                    $attachment->path = $path;
                    $attachment->fid = 0;
                    $attachment->level = 0;
                    $attachment->file_name = basename($path);
                    $attachment->ext = $img_type;
                    $attachment->original_name = "old". time().".jpg";
                    $attachment->type = 3;
                    $attachment->createtime = time();
                    $attachment->status = 1;
                   if($attachment->save()){
                       $this->redirect($this->createUrl('/activity/poster/showposter',array('poster_id'=>$poster_id)));
                       exit;
                   }
                    
                }

            }else{
                echo "上传失败!";
            }


        }else{
            $id=trim(Tool::getValidParam('id','integer'));
            $openid=trim(Tool::getValidParam('openid','integer'));

            $this->redirect($this->createUrl('/activity/poster/list/view/',array('id'=>$id,'openid'=>$openid)));
        }
    }
    
    public function actionshowposter(){
        $poster_id = trim(Tool::getValidParam('poster_id','integer'));
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }



        $sql = "select a.url,b.pid,b.share_desc,b.title from dym_activity_poster_user a,dym_activity_poster b where a.pid=b.id and a.id=".$poster_id;
        $res = Mod::app()->db->createCommand($sql)->queryRow();

        $poster_img=explode("/data",$res['url']);
        $share_img=explode("/attachment",$res['url']);


        $res['share_img']=$share_img[1];
        $sql = "SELECT * FROM {{project}} WHERE id=".$res['pid'];
        $project_info=Mod::app()->db->createCommand($sql)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

        $this->render('showposter',array('poster_img'=>$poster_img[1],'info'=>$res,'signPackage'=>$signPackage,'poster_id'=>$poster_id));

    }


    /**
     * @author yuwanqiao
     * 后台活动列表
     */
    public function actionlist(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
         $pid = trim(Tool::getValidParam('pid','integer'));

         //获取当前应用
         $project_model = Project::model()->findByPk($pid);
         if($this->member['id'] != $project_model['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
         }
         //获取应用列表
         $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
         //刮刮卡活动列表 
         $as_list = Activity_poster::model()->getActivityListPager($pid); 
         
         if(!$as_list['count']){ 
             $redirect_url = Mod::app()->baseUrl.'/activity/poster/add/pid/'.$pid;
             $this->redirect($redirect_url);
         }
        $config['site_title'] = '海报活动页面-大楚网用户开放平台';
        $config['site_keywords'] = "大楚网用户开放平台,海报，活动";
        $config['site_description'] ="大楚网用户开放平台";
         $config['active_1']=3;
         $config['active'] =4;
         $config['pid']=$pid;
         $parame = array(
             'project_list'=>$project_list,
             'view'=> $project_model,
             'asList'=>$as_list['criteria'],
             'pagebar' => $as_list['pagebar'],
             'count'=>$as_list['count'],
             'config'=>$config
         );
         $this->render('list_scratchcard',$parame);
    }       
    
    
    /**
     * @author yuwanqiao
     * 后台添加刮刮卡活动和编辑在一起
     */
    public function actionAdd(){
        if(!$this->member  ||  !$this->member['id'] || !$this->member['pstatus']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
         if(Mod::app()->request->isPostRequest){
             $data = $_POST;
             $activity_id = trim(Tool::getValidParam('id','integer'));
             $data['starttime']=strtotime(Tool::getValidParam('starttime','string'));
             $data['endtime']  =strtotime(Tool::getValidParam('endtime','string'));

             $pid = trim(Tool::getValidParam('pid', 'integer'));
             if($activity_id){//编辑
                 //判断是不是自己的所属项目 不是没有权限
                 $sql = "select * from {{activity_poster}} where id=$activity_id";
                 $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                 if(!$activity_info['pid']){die('数据非法');}
                 //防止ID遍历
                 $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                 if($this->member['id'] !=   $projectinfo['mid'] ){
                     die('非法访问');
                 }
             }else if($pid){//添加 //添加必带项目ID
                 if(!$pid) die('非法访问');
                 $projectinfo =  JkCms::getprojectByid($pid);
                 if($this->member['id'] !=   $projectinfo['mid'] ){
                     die('非法访问');
                 }
             }else{
                 die('非法访问');
             }
             //end权限




            foreach($data as $k=>$v){
                $arr[$k]=Safetool::SafeFilter($v);
            }
            $arr = $data;
             $arr['mid'] = $this->member['id'];
            if($activity_id){
                $update_id = array(':id'=>$activity_id);
                $query = Mod::app()->db->createCommand()->update('{{activity_poster}}',$arr,'id=:id', $update_id);  
                $str ='编辑';
            }else{
                $arr['createtime']  =time();
                $query = Mod::app()->db->createCommand()->insert('{{activity_poster}}',$arr);
                $str ='添加';
            }
            if($query){
                $res = array(
                    'statue'=>1,
                    'msg'   =>$str.'海报成功'
                );
            }else{
                $res = array(
                    'statue'=>0,
                    'msg'   =>$str.'海报失败'
                );
            }
            echo json_encode($res);
        }else{
            //获取点击编辑是得到的活动id
             $fid = trim(Tool::getValidParam('fid', 'integer'));
             $pid = trim(Tool::getValidParam('pid', 'integer'));

             $projectinfo =  JkCms::getprojectByid($pid);
             if($this->member['id'] !=   $projectinfo['mid']  || !$this->member['pstatus']){
                 die('非法访问');
             }

             if ($fid) {
                 //start所属权限开始
                 $sql = "select * from {{activity_poster}} where id=$fid";
                 $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
                 if(!$activity_info['pid']){die('数据非法');}
                 //防止ID遍历
                 $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
                 if($this->member['id'] !=   $projectinfo['mid'] ){
                     $this->redirect(Mod::app()->request->getHostInfo());
                     exit;
                 }
                 //end权限
                 //查询活动数据
                 $sql = "select * from {{activity_poster}} where id=$fid";
                 $result = Mod::app()->db->createCommand($sql);
                 $query = $result->queryAll();
             }else{
                 $query = array();
                 $prize = array();
             }


             //获取当前项目
             $project_model = Project::model()->findByPk($pid);
             //获取项目列表
             $project_list = Project::model()->findAll("mid=:mid",array(":mid"=>$this->member['id']));
             //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
             $config['active_1'] ='3';
             //组件assembly中的选中高亮背景图片 刮刮卡(1)、海报(2)、报名(3)
             $config['active']=4;
             $config['site_title'] = '海报活动页面-添加编辑海报活动-大楚网用户开放平台';
             $config['site_keywords'] = "大楚网用户开放平台,海报，活动";
             $config['site_description'] ="大楚网用户开放平台_海报活动页面_添加编辑海报活动";
             $config['pid']=$pid;

             $psql = "SELECT p.type,a.id,a.name from {{project}} as p LEFT JOIN {{application_tag}} as a on p.type=a.classid WHERE p.id=$pid order by a.updatetime desc";
             $ptag = Mod::app()->db->createCommand($psql);
             $tag = $ptag->queryAll();
             $ptag=explode('_',substr($query[0]['tag'],0,-1));
             $parame = array(
                 'project_list'=>$project_list,
                 'view'=> $project_model,
                 'config'=>$config,
                 'activity_info'=>$query[0],
                 'status'=>$this->activity_status('poster'),
                 'ptag'=>$ptag,
                 'tag'=>$tag,
                 'prize'=>$prize
             );
             $this->render('add_scratchcard',$parame);
        }
    }
    
    /**
     * @author yuwanqiao
     * 后台删除活动
     */
    public function actionDelete(){
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isAjaxRequest){
            $fid = Tool::getValidParam('fid');
            if($fid){
                //防止ID遍历
                $respcck=Activity_pccheckin::model()->findByPk($fid);
                if(!$respcck){
                    $result = array(
                        'errorcode'=>0
                    );
                    echo json_encode($result);exit;
                }
                $projectinfo =  JkCms::getprojectByid($respcck->pid);
                if($this->member['id'] !=   $projectinfo['mid'] ){
                    $result = array(
                        'errorcode'=>0
                    );
                    echo json_encode($result);exit;
                }

                //查询刮刮卡中的奖品
                $res = Mod::app()->db->createCommand()->delete('{{activity_poster}}', 'id IN('.$fid.')');
                if($res){
                    $recommend = Mod::app()->db->createCommand()->select('id')->from('{{activity_recommend}}')->where('aid='.$fid)->queryRow();
                    if($recommend){
                        Mod::app()->db->createCommand()->delete('{{activity_recommend}}', 'aid IN('.$fid.')');
                    }
                    $result['errorcode'] = 1;
                }
            }else{
                $result = array(
                        'errorcode'=>0
                 );
            }
            echo json_encode($result);exit;
        }
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
            $sql = "select * from {{activity_poster}} where id=$id";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->member['id'] !=   $projectinfo['mid'] ){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->member['id'] !=   $projectinfo['mid'] ){
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
            $arr       = array('starttime'=>time());
        }
        if($type==2){
            $str = '结束';
            $arr       = array('endtime'=>time());
        }
        $update_id = array(':id'=>$id);
        $query = Mod::app()->db->createCommand()->update('{{activity_poster}}',$arr,'id=:id', $update_id);
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
     * 导出数据列表
     */
    public function actionExportCsv(){
        $fid      = trim(Tool::getValidParam('fid','integer'));
        //活动的id

        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($fid){//编辑
            //判断是不是自己的所属项目 不是没有权限
            $sql = "select * from {{activity_poster}} where id=$fid";
            $activity_info = Mod::app()->db->createCommand($sql)->queryRow();
            if(!$activity_info['pid']){die('数据非法');}
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($activity_info['pid']);
            if($this->member['id'] !=   $projectinfo['mid'] ){
                die('非法访问');
            }
        }else if($pid){//添加 //添加必带项目ID
            if(!$pid) die('非法访问');
            $projectinfo =  JkCms::getprojectByid($pid);
            if($this->member['id'] !=   $projectinfo['mid'] ){
                die('非法访问');
            }
        }else{
            die('非法访问');
        }
        //end权限


        $datatype = trim(Tool::getValidParam('type','string'));

        if($datatype == 1){
            $where = "scratch_id = $fid and is_win = 1";
        }elseif($datatype==2){
            $where = "scratch_id = $fid and is_win = 0";
        }else{
            $where = "scratch_id = $fid";
        }
        Mod::import('ext.ECSVExport');
        $list = Mod::app()->db->createCommand()  
           ->select('*')  
           ->from('{{activity_poster_user}}')
           ->where($where)
           ->queryAll();  
        if($list){
            foreach($list as $key=>$val){
                //根据用户id查询用户信息
                $mid = $val['mid'];
                $sql = "select * from dym_member where id = $mid";
                $user = Mod::app()->db->createCommand($sql)->queryRow();
                //根据奖品id查询奖品信息
                $prizeid = $val['prize_id'];
                if($prizeid){
                    $sql = "select * from {{activity_poster_prize}} where id = $prizeid";
                    $prize = Mod::app()->db->createCommand($sql)->queryRow();
                }else{
                    $prize = array();
                }
                $as_list[$key]['id']=$val['id'];
                $as_list[$key]['scratch_id']=$val['scratch_id'];
                $as_list[$key]['mid']=$val['mid'];
                $as_list[$key]['username']=$user['username'];
                $as_list[$key]['phone']=$user['phone'];
                $as_list[$key]['code']=$val['code'];
                $as_list[$key]['level']=$prize['title'];
                $as_list[$key]['prizename']=$prize['name'];
                $as_list[$key]['time']=$val['time'];
                $as_list[$key]['accept']=$val['accept'];
                $as_list[$key]['is_win']=$val['is_win'];
            }
        }else{
            $as_list=array();
        }
        $list = array();
        if($as_list) {
            foreach ($as_list as $k => $v) {
                $list[$k]['活动id'] = $v['scratch_id'];
                $list[$k]['用户名'] = $v['username'];
                $list[$k]['手机号'] =$v['phone'];
                $list[$k]['中奖码'] = $v['code'];
                $list[$k]['中奖等级'] = $v['level'];
                $list[$k]['奖品'] = $v['prizename'];
                $list[$k]['抽奖时间'] = date('Y-m-d H:i:s',$v['time']);
                $list[$k]['领奖状态'] = $v['accept']==1 ? '已经领奖' : '没有领奖';
                $list[$k]['是否中奖'] = $v['is_win']==1 ? '是' : '否';
            }
        }
        //生成cvs文件
        $csv = new ECSVExport($list);
        $output = $csv->toCSV();
        Mod::app()->getRequest()->sendFile('参与抽奖用户列表.csv', $output, "text/csv", false);
        exit();
    }
}
 
