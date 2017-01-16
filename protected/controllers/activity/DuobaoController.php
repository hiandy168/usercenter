<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/2
 * Time: 11:16
 */
class DuobaoController extends FrontController
{
    public function init()
    {
        parent::init();
        //判断用户是否登录，如果没有登录直接跳转到登录页面
        if (!$this->member && !$_SESSION['mid']) {
            // $this->redirect(Mod::app()->request->getHostInfo());
            //  exit;
        }
    }

    /*
     * 夺宝首页
     */
    /*public function actionIndex()
    {
        $sql = "select * from {{duobao_gz_adv}} where enabled=1  order by displayorder asc";
        $piclist=Mod::app()->db->createCommand($sql)->query();
        var_dump($piclist);
        $this->render("index",$piclist);

    }*/


    public function actionUpload(){
        $this->render("upload");
    }

    /**
     * @author Fancy
     *  一元购
     */
    public function actionManage(){
        $request = Mod::app()->request;
        $pid = intval(Tool::getValidParam('pid','integer'));
        $acitvie=intval(Tool::getValidParam('acitvie','integer'));
        $viewData['pid'] = $pid;
        $viewData['acitvie'] = $acitvie;
        $this->render("manage",$viewData);
    }

    /**
     * @author Fancy
     * 商品管理
     */
    public function actionGoodManage(){

        $this->render("good_manage");
    }
    /**
     * @author Fancy
     * 商品分类列表
     */
    public function actionGoodType(){
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //$pid=intval($_GET['pid']);
        $pid =trim(Tool::getValidParam('pid', 'integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_category}} WHERE  pid=".$pid." AND status=1 order by id desc";
        $asList=Mod::app()->db->createCommand($sql)->queryAll();
        $config['site_title'] = '一元购';
        $config['active'] =8;
        $config['pid']=$pid;
        $parame = array(
            'pid'=>  $pid,
            'config'=>$config,
            'asList'=>$asList
        );
        $this->render('goodtypelist',$parame);

    }

    /**
     * @author Fancy
     * 商品分类添加
     */
    public function actionTypeAdd()
    {
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isPostRequest) {
            /*$data['pid'] = $_POST['pid'];
            $data['name'] = $_POST['title'];
            $data['create_time'] = time();
            $data['thumb'] = $_POST['share_img'];
            $data['description'] = $_POST['description'];*/
            $data['pid'] = trim(Tool::getValidParam('pid', 'integer'));
            $data['name'] = trim(Tool::getValidParam('title', 'string'));
            $data['create_time'] = time();
            $data['thumb'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['description'] = trim(Tool::getValidParam('description', 'string'));
            $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_category',$data);
            if($query){
                echo '{"statue":1,"msg":"添加成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"添加失败"}';
                exit;
            }
        }
        //$pid=intval($_GET['pid']);
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $config['site_title'] = '一元购';
        $config['active'] =8;
        $param=array(
            'pid'=>  $pid,
            'config'=>$config,
        );
        $this->render("typeadd",$param);
    }

    /**
     * @author Fancy
     * 商品分类编辑
     */
    public  function  actionTypeEdit(){
          if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isPostRequest) {
            /*$id= $_POST['id'];
            $data['pid'] = $_POST['pid'];
            $data['name'] = $_POST['title'];
            $data['update_time'] = time();
            $data['thumb'] = $_POST['share_img'];
            $data['description'] = $_POST['description'];*/
            $id= trim(Tool::getValidParam('id', 'integer'));
            $data['pid'] = trim(Tool::getValidParam('pid', 'integer'));
            $data['name'] = trim(Tool::getValidParam('title', 'string'));
            $data['update_time'] = time();
            $data['thumb'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['description'] = trim(Tool::getValidParam('description', 'string'));
            $sql = "UPDATE  {{activity_duobao_gz_category}} SET name=".'\''.$data['name'].'\''.",description=".'\''.$data['description'].'\''.",update_time=".time().",thumb=".'\''.$data['thumb'].'\''." WHERE id= ".$id." AND pid=". $data['pid'];
            $query=Mod::app()->db->createCommand($sql)->execute();
            if($query){
                echo '{"statue":1,"msg":"编辑成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"编辑失败"}';
                exit;
            }
        }
        /*  $id=intval($_GET['id']);
          $pid=intval($_GET['pid']);*/
        $id=trim(Tool::getValidParam('id', 'integer'));
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_category}} WHERE id= ".$id." AND pid=".$pid." AND status=1 ";
        $re=Mod::app()->db->createCommand($sql)->queryRow();
        $config['site_title'] = '一元购';
        $config['active'] =8;
        $config['pid']=$pid;
        $param=array(
            'id'=>  $id,
            'pid'=>  $pid,
            'edit'=>  $re,
            'config'=>$config,
        );
        $this->render("typeedit",$param);
    }

    /**
     * @author Fancy
     * 商品分类删除
     */
    public function  actionTypeDel(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('id','integer'));
        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_category', 'id=:id',$where);
        if($res){
            $mess = array('errorcode'=>0,'status'=>'success');
        }else{
            $mess = array('errorcode'=>1,'status'=>'fail');
        }
        echo json_encode($mess);
    }
    /**
     * @author Fancy
     * 幻灯片管理
     */
    public function actionDuoBao_AdvList(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //$pid=intval($_GET['pid']);
        $pid=trim(Tool::getValidParam('pid','integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_adv}} WHERE  pid=".$pid." AND status=1 order by id desc";
        $re=Mod::app()->db->createCommand($sql)->queryAll();
        $param=array(
            'pid'=>  $pid,
            'list'=>  $re,
        );
        $this->render("duobaoadvlist",$param);
    }
    //添加幻灯片
    public function actionAdvAdd(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isPostRequest) {
            /*$data['pid'] = $_POST['pid'];
            $data['advname'] = $_POST['title'];
            $data['link'] = $_POST['link'];
            $data['create_time'] = time();
            $data['thumb'] = $_POST['img'];
            $data['displayorder'] = $_POST['displayorder'];*/

            $data['pid'] = trim(Tool::getValidParam('pid','integer'));
            $data['advname'] =trim(Tool::getValidParam('title','string'));
            $data['link'] = trim(Tool::getValidParam('link','string'));
            $data['create_time'] = time();
            $data['thumb'] = trim(Tool::getValidParam('img','string'));
            $data['displayorder'] = trim(Tool::getValidParam('displayorder','string'));
            $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_adv',$data);
            if($query){
                echo '{"statue":1,"msg":"添加成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"添加失败"}';
                exit;
            }
        }
        //$pid=intval($_GET['pid']);
        $pid=trim(Tool::getValidParam('pid','integer'));
        $param=array(
            'pid'=>  $pid,
        );
        $this->render('advadd',$param);
    }

    //编辑幻灯片
    public function actionAdvEdit(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isPostRequest) {
            /* $id= $_POST['id'];
             $data['pid'] = $_POST['pid'];
             $data['advname'] = $_POST['title'];
             $data['link'] = $_POST['link'];
             $data['create_time'] = time();
             $data['thumb'] = $_POST['img'];
             $data['displayorder'] = $_POST['displayorder'];*/
            $id= trim(Tool::getValidParam('id','integer'));
            $data['pid'] = trim(Tool::getValidParam('pid','integer'));
            $data['advname'] = trim(Tool::getValidParam('title','string'));
            $data['link'] = trim(Tool::getValidParam('link','string'));
            $data['create_time'] = time();
            $data['thumb'] = trim(Tool::getValidParam('img','string'));
            $data['displayorder'] = trim(Tool::getValidParam('displayorder','string'));
            $sql = "UPDATE  {{activity_duobao_gz_adv}} SET advname=".'\''.$data['advname'] .'\''.",link=".'\''.$data['link'].'\''.",displayorder=".'\''.$data['displayorder'].'\''.",update_time=".time().",thumb=".'\''.$data['thumb'].'\''." WHERE id= ".$id." AND pid=". $data['pid'];
            $query=Mod::app()->db->createCommand($sql)->execute();
            if($query){
                echo '{"statue":1,"msg":"编辑成功"}';
                exit;
            }else{
                echo '{"statue":2,"msg":"编辑失败"}';
                exit;
            }
        }
        /*  Tool::getValidParamAutoType('link');*/
        /* $id=intval($_GET['id']);
         $pid=intval($_GET['pid']);*/
        $id=trim(Tool::getValidParam('id','integer'));
        $pid=trim(Tool::getValidParam('pid','integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_adv}} WHERE id= ".$id." AND pid=".$pid." AND status=1 ";
        $re=Mod::app()->db->createCommand($sql)->queryRow();
        $param=array(
            'id'=>  $id,
            'pid'=>  $pid,
            'edit'=>  $re,
        );
        $this->render('advedit',$param);
    }
    //删除幻灯片
    public function actionDelete(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('fid','integer'));
        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_adv', 'id=:id',$where);
        if($res){
            $mess = array('errorcode'=>0,'status'=>'success');
        }else{
            $mess = array('errorcode'=>1,'status'=>'fail');
        }
        echo json_encode($mess);

    }

    /**
     * @author Fancy
     *  夺宝商品列表
     */
    public function actionList(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动所属的应用的id
        $pid = trim(Tool::getValidParam('pid','integer'));
        //报名活动列表
        $as_list = Activity_duobao_gz_goods::model()->getActivityListPager($pid);
        $config['site_title'] = '1元购';
        $config['active'] =8;
        $config['pid']=$pid;
        $parame = array(
            'asList'=>$as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count'=>$as_list['count'],
            'config'=>$config
        );

        /* $goodsid=84;
         $fancy=" SELECT m.*,max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t LEFT JOIN {{activity_duobao_gz_member}} AS m ON t.openid=m.openid WHERE t.goodsid=$goodsid GROUP BY t.openid order by ordertime desc limit 5";

         for($tt=0;$tt<5;$tt++){
             $getData = $this->getUrl($this->_siteUrl."/activity/duobao/caipiao");
             if($getData['retMsg'] != "error"){
                 break;
             }
             sleep(1);
         }
         if($getData && is_array($getData) && ("success" == $getData['retMsg'])){
             $openCode = intval(preg_replace("/\,/","",$getData['data']['openCode']));
             $openExpect = $getData['data']['expect'];
             var_dump("彩票码: ".$openCode." === 彩票期数:".$openExpect);
         }
         $ogoods=Mod::app()->db->createCommand($fancy)->queryAll();
         $totalTime = 0;
         $max=206;
         foreach($ogoods as $key => $value){
             $totalTime += intval(date("His",$value['ordertime']));
         }
         $award = ($openCode + $totalTime)%($max);
         $result_ticket = intval($goodsid) * 100000 + $award;*/



        /* $sqlog="SELECT * FROM {{activity_duobao_gz_order}} as o left JOIN {{activity_duobao_gz_order_goods}} as g on o.id=g.orderid WHERE o.ordersn=09191163 ";
         $ogoods=Mod::app()->db->createCommand($sqlog)->queryAll();
         foreach ($ogoods as $row) {
             if (empty($row)) {
                 continue;
             }
             $sqlt="select max(ticket) as ticket from {{activity_duobao_gz_ticket}} where pid=".$row['pid']." and goodsid=".$row['goodsid']." ";
             $oticket=Mod::app()->db->createCommand($sqlt)->queryAll();
             for($i=0;$i<count($oticket);$i++){
                 //var_dump($oticket[$i]['ticket']);
                 if(empty($oticket[$i]['ticket'])){
                     $ticket = intval($row['goodsid']) * 100000;
                 }
                 else{
                     $ticket = intval($oticket[$i]['ticket']) + 1;
                 }
                 $d = array(
                     'pid' => $row['pid'],
                     'openid' => $row['optionid'],
                     'memberid' => $this->member['id'],
                     'createtime' => time(),
                     'orderid' => $row['orderid'],
                     'goodsid' => $row['goodsid'],
                     'ticket' => $ticket,
                 );
                 $querys = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_ticket',$d);
                 if($querys){
                     $gosql=" SELECT * FROM {{activity_duobao_gz_goods}} WHERE id=".$row['goodsid'];
                     $goods=Mod::app()->db->createCommand($gosql)->queryAll();
                     for($j=0;$j<count($goods);$j++)
                     {
                         $ticket_total=intval($goods[$j]['ticket_total'])+1;
                         //var_dump($ticket_total);
                         $sql = "UPDATE  {{activity_duobao_gz_goods}} SET ticket_total=".$ticket_total." WHERE id= ".$row['goodsid'];
                         $query=Mod::app()->db->createCommand($sql)->execute();
                         if($query){
                             echo "成功";
                         }
                     }
                 }else{
                     echo "失败";
                 }
             }

         }*/



        $this->render('list',$parame);
    }

    //获取彩票期数和彩票5D数字
    public  function actionCaiPiao(){
        $ch = curl_init();
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , array('apikey:d61f5f79c334ebf25b4c4607007c11d1'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , 'http://apis.baidu.com/apistore/lottery/lotteryquery?lotterycode=pl5&recordcnt=1');
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        $returnData['retMsg'] = 'error';
        if(!empty($res) && $res['retMsg'] == 'success'){
            $openTime = date('Y-m-d', strtotime('-1 day')) . ' 20:30:00';
            $openTimeStamp = strtotime($openTime);
            if($res['retData']['data'][0]['openTimeStamp'] >= $openTimeStamp && $res['retData']['data'][0]['openTimeStamp'] <= ($openTimeStamp+600)){
                $returnData['retMsg'] = 'success';
                $returnData['data'] = $res['retData']['data'][0];
            }
        }
        echo json_encode($returnData);
    }


    public function getUrl($url){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HEADER,0);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($curl);
        curl_close($curl);
        return json_decode($data,true);
    }
    //商品添加
    public function  actionAddGood(){
        if(!$this->member  ||  !$this->member['id']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if(Mod::app()->request->isPostRequest){
            $data = $_POST;
            /* $activity_id = $_POST['id'];
             $data['timestart']=strtotime($_POST['timestart']);
             $data['timeend']  =strtotime($_POST['timeend']);
             $data['pcate']  =$_POST['pcate'];
             $data['thumb']  =$_POST['share_img'];
             //$data['thumb_url']  =substr($_POST['thumb_url'],0,strlen($_POST['thumb_url'])-1);
             $data['thumb_url']  =$_POST['thumb_url'];
             $data['share_desc']  =$_POST['share_desc'];*/

            $activity_id = trim(Tool::getValidParam('id','integer'));
            $data['timestart']=strtotime(trim(Tool::getValidParam('timestart','string')));
            $data['timeend']  =strtotime(trim(Tool::getValidParam('timestart','string')));
            $data['pcate']  =trim(Tool::getValidParam('pcate','integer'));
            $data['thumb']  =trim(Tool::getValidParam('pid','string'));
            //$data['thumb_url']  =substr($_POST['thumb_url'],0,strlen($_POST['thumb_url'])-1);
            $data['thumb_url']  =trim(Tool::getValidParam('thumb_url','string'));
            $data['share_desc']  =trim(Tool::getValidParam('share_desc','string'));
            $sql = "SHOW FULL FIELDS FROM dym_activity_duobao_gz_goods";
            $result = Mod::app()->db->createCommand($sql);
            $query = $result->queryAll();
            foreach ($query as $key=>$val){
                foreach ($data as $key_data=>$val_data){
                    if($val['Field']==$key_data){
                        $arr[$key_data]=Safetool::SafeFilter($val_data);
                    }
                }
            }
            if($activity_id){
                $arr['update_time']  =time();
                $update_id = array(':id'=>$activity_id);
                $query = Mod::app()->db->createCommand()->update('dym_activity_duobao_gz_goods',$arr,'id=:id', $update_id);
                $str ='编辑';
            }else{
                $arr['create_time']  =time();
                $arr['update_time']  =time();
                $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_goods',$arr);
                $str ='添加';
            }
            if($query){
                $res = array(
                    'statue'=>1,
                    'msg'   =>$str.'活动成功'
                );
            }else{
                $res = array(
                    'statue'=>0,
                    'msg'   =>$str.'活动失败'
                );
            }
            echo json_encode($res);
        }else {
            //获取点击编辑是得到的活动id
            $fid = trim(Tool::getValidParam('fid', 'integer'));
            if ($fid) {
                //查询活动数据
                $sql = "select * from dym_activity_duobao_gz_goods where id=$fid";
                $result = Mod::app()->db->createCommand($sql);
                $query = $result->queryAll();
            } else {
                $query = array();

            }
            
//            $pid = trim(Tool::getValidParam('pid', 'integer'));

            $pid = $query['pid']?$query['pid']:Tool::getValidParam('pid','integer');
            
            //防止ID遍历
            $projectinfo =  JkCms::getprojectByid($pid);        
            if($this->member['id'] !=   $projectinfo['mid'] ){
                $this->redirect(Mod::app()->request->getHostInfo());
                exit;
            }


            
            //获取当前项目
            $project_model = Project::model()->findByPk($pid);
            //获取项目列表
            $project_list = Project::model()->findAll("mid=:mid", array(":mid" => $this->member['id']));
            //head_app中的 应用首页（1）、基础配置（2）、应用组件（3）三个按钮选中加背景
            $config['active_1'] = '3';
            //组件assembly中的选中高亮背景图片 刮刮卡(1)、签到(2)、投票(3)
            $config['active'] = 8;
            $config['site_title'] = '1元购';
            $config['pid'] = $pid;
            $sql = "SELECT * FROM {{activity_duobao_gz_category}} WHERE  pid=".$pid." AND status=1 order by id desc";
            $re=Mod::app()->db->createCommand($sql)->queryAll();
            $thumb_urlss=substr($query[0]['thumb_url'],0,strlen($query[0]['thumb_url'])-1);
            $thumb_url = explode(',',$thumb_urlss);
            //var_dump($thumb_url);
            $parame = array(
                'project_list' => $project_list,
                'view' => $project_model,
                'config' => $config,
                'thumb_url' => $thumb_url,
                'adtype'=>$re,
                'activity_info' => $query[0],
            );
            $this->render('addgood',$parame);
        }
    }
    //删除图片
    public function actionDelimg(){
        $request = Mod::app()->request;
        $newobj = trim(Tool::getValidParam('newobj','string'));
        $id =trim(Tool::getValidParam('id', 'integer'));
        if($newobj){
            $sql = "UPDATE  {{activity_duobao_gz_goods}} SET thumb_url='".$newobj."' WHERE id= ".$id;
            $query=Mod::app()->db->createCommand($sql)->execute();
            if($query){
                $returnData = '100';
            }else{
                $returnData = '101';
            }
        }
        else{
            $returnData = '102';
        }
        echo $returnData;
    }
    /**
     * @author Fancy
     *   删除商品
     */
    public function actionGoodDel() {
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('fid','integer'));
        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_goods', 'id=:id',$where);
        if($res){
            $mess = array('errorcode'=>0,'status'=>'success');
        }else{
            $mess = array('errorcode'=>1,'status'=>'fail');
        }
        echo json_encode($mess);
    }


    /**
     * @author Fancy
     * 获取参加活动列表
     */
    public function actionAddList(){
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('id', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $title = trim(Tool::getValidParam('title', 'string'));
        $as_list = Activity_duobao_gz_ticket::model()->getUserListPager($id,$pid);
        if($as_list['count']){
            foreach($as_list['criteria'] as $key=>$val){

                $sql = "SELECT * FROM {{member}} WHERE id=".$val['memberid'];
                $info=Mod::app()->db->createCommand($sql)->queryRow();

                $as_list['users'][$key]['name']=$info['username']?$info['username']:$info['name'];
                $as_list['users'][$key]['phone']=$info['phone'];

                $as_list['users'][$key]['id']=$val['id'];
                $as_list['users'][$key]['openid']=$val['openid'];
                $as_list['users'][$key]['ticket']=$val['ticket'];
                $as_list['users'][$key]['createtime']=$val['createtime'];

            }

        }else{
            $as_list['count']= '0';
            $as_list['users']=array();
        }
        $as_list['id']=$id;
        $as_list['title']=$title;
        $as_list['pid']=$pid;


        $this->render('addlist',$as_list);
    }


    /**
     * @author Fancy
     * 导出签到用户的数据列表CSV
     */
    public function actionExportCsv(){
        $id      = trim(Tool::getValidParam('id','integer'));
        $pid      = trim(Tool::getValidParam('pid','integer'));
        Mod::import('ext.ECSVExport');
        $list  = Activity_duobao_gz_ticket::model()->getUserListPager($id,$pid);
        if($list['criteria']){
            foreach($list['criteria'] as $key=>$val){
                $sql = "SELECT * FROM {{member}} WHERE id=".$val['memberid'];
                $info=Mod::app()->db->createCommand($sql)->queryRow();

                $as_list[$key]['name']=$info['username']?$info['username']:$info['name'];
                $as_list[$key]['phone']=$info['phone'];
                $as_list[$key]['openid']      = $val['openid'];
                $as_list[$key]['createtime'] = $val['createtime'];
                $as_list[$key]['id']=$val['id'];
            }
        }else{
            $as_list=array();
        }
        $list = array();
        if($as_list) {
            foreach ($as_list as $k => $v) {
                $list[$k]['Id'] = $v['id'];
                $list[$k]['签到用户昵称'] = $v['name'];
                $list[$k]['签到用户手机'] = $v['phone'];
                $list[$k]['签到用户OPENID'] = $v['openid'];
                $list[$k]['报名时间'] = date('Y-m-d H:i:s',$v['createtime']);
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
        Mod::app()->getRequest()->sendFile('夺宝用户列表.csv', $output, "text/csv", false);
        exit();

    }

    /**
     * @author Fancy
     * 设置结束活动
     */
    public function actionActivityStatus(){
        if(!$this->member && !$_SESSION['mid']){
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动的id
        $id      = trim(Tool::getValidParam('fid','integer'));
        //type 1表是设置开始 2表示设置结束
        $type=Tool::getValidParam('type','string');
        if($type==1){
            $str = '开始';
            $arr       = array('timestart'=>time());
        }
        if($type==2){
            $str = '结束';
            $arr       = array('timeend'=>time());
        }
        $update_id = array(':id'=>$id);
        $query = Mod::app()->db->createCommand()->update('dym_activity_duobao_gz_goods',$arr,'id=:id', $update_id);
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
    //一元夺宝  活动详情页
    public  function actionMobileIndex(){
        $id =trim(Tool::getValidParam('id', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_goods}} WHERE  pid=".$pid." AND id=".$id;

        Browse::add_usernum($pid);  //计算独立访客数量
        Browse::add_browsenum($pid); //计算浏览量

        $sql_project = "SELECT * FROM {{project}} WHERE id=".$pid;
        $project_info=Mod::app()->db->createCommand($sql_project)->queryRow();
        $signPackage = $this->wx_jssdk($project_info['wx_appid'], $project_info['wx_appsecret']);

        $good=Mod::app()->db->createCommand($sql)->queryRow();
        $good['share_img']=$good['thumb'];
        $adModel = Activity_duobao_gz_ticket::model();
        $criteria = new CDbCriteria();
        $criteria->order = 'createtime DESC';
        $criteria->condition = 'pid = :pid and memberid=:memberid and goodsid=:goodsid';
        $criteria->params = array(':pid'=> $pid,':memberid'=>$this->member['id'],':goodsid'=>$id);
        $count = $adModel->count($criteria);

        if($this->member['id']){//登录状态
            $mid=$this->member['id'];
        }
        $sqls="SELECT  m.*,COUNT(t.id) AS total,max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t LEFT JOIN {{member}} AS m ON t.memberid=m.id WHERE t.goodsid=".$id." GROUP BY t.openid order by ordertime desc limit 15";
        $ret = Mod::app()->db->createCommand($sqls)->queryAll();
        $ticket="SELECT g.id,g.ticket,g.ticket_time,g.productprice,g.ticket_total,g.ticket_nickname,m.headimgurl from {{activity_duobao_gz_goods}} as g left join {{member}} as m on g.ticket_openid=m.id WHERE g.id=$id and g.pid=$pid";
        $tret = Mod::app()->db->createCommand($ticket)->queryAll();
        if(!empty($tret[0]['ticket'])){
            $mem="SELECT memberid FROM dym_activity_duobao_gz_ticket WHERE ticket=".$tret[0]['ticket'];
            $tmems = Mod::app()->db->createCommand($mem)->queryAll();
            if($tmems){
                $countg="SELECT count(*) as count FROM dym_activity_duobao_gz_ticket WHERE goodsid=$id and pid=$pid and memberid=".$tmems[0]['memberid'];
                $counts=Mod::app()->db->createCommand($countg)->queryRow();
            }
        }
        $returnData['adList'] = $adModel->findAll($criteria);
        $thumb_urlss=substr($good['thumb_url'],0,strlen($good['thumb_url'])-1);
        $thumb_url = explode(',',$thumb_urlss);
        $returnData['thumb_url']=$thumb_url;
        $returnData['good']=$good;
        $returnData['tmems']=$tmems;
        $returnData['tret']=$tret;
        $returnData['uid']=$this->member['id'];
        $returnData['id']=$id;
        $returnData['id']=$id;
        $returnData['pid']=$pid;
        $returnData['count']=$count;
        $returnData['counts']=$counts;
        $returnData['ret']=$ret;
        $returnData['mid']=$mid;
        //$returnData['info']=$good;
        $returnData['signPackage']=$signPackage;

        $this->render("mobile/index",$returnData);
    }
    //查看计算详情
    public function actionTicketTotal(){

        $goodsid =trim(Tool::getValidParam('id', 'integer'));
        /* $fancy = " SELECT max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t  WHERE t.goodsid=$goodsid GROUP BY t.openid order by ordertime desc limit 5";*/
        $ticketRecords = " SELECT m.*,max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t LEFT JOIN {{member}} AS m ON t.openid=m.id WHERE t.goodsid=".$goodsid." GROUP BY t.openid order by ordertime desc limit 5";
        $ogoods = Mod::app()->db->createCommand($ticketRecords)->queryAll();
        $sql = "select * from {{activity_duobao_gz_goods}}  WHERE id=$goodsid";
        $goods = Mod::app()->db->createCommand($sql)->queryRow();
        $memberid=$goods['ticket_openid'];
        $sqls = "select count(*) as count from {{activity_duobao_gz_ticket}}  WHERE goodsid=$goodsid and memberid=$memberid";
        $ticket = Mod::app()->db->createCommand($sqls)->queryRow();
        $max=$goods['productprice'];
        $totalTime = 0;
        foreach ($ogoods as $key => $value) {
            $totalTime += intval(date("His", $value['ordertime']));
        }
        /* for ($tt = 0; $tt < 5; $tt++) {
             $getData = $this->getUrl("http://m.dachuw.net/activity/duobao/caipiao");
             if ($getData['retMsg'] != "error") {
                 break;
             }
             sleep(1);
         }
         if ($getData && is_array($getData) && ("success" == $getData['retMsg'])) {
             $openCode = intval(preg_replace("/\,/", "", $getData['data']['openCode']));//彩票码
             $openExpect = $getData['data']['expect'];//彩票期数
         }*/
        $sqlm = "SELECT ticket_expect,ticket_code FROM {{activity_duobao_gz_goods}} WHERE  id=$goodsid";
        $rowm=Mod::app()->db->createCommand($sqlm)->queryRow();
        $openCode = $rowm['ticket_code'];//彩票码
        $openExpect = $rowm[ticket_expect];//彩票期数
        $award = ($openCode + $totalTime) % ($max);
        $result_ticket = intval($goodsid) * 100000 + $award;
        $returnData['totalTime']=$totalTime;
        $returnData['result_ticket']=$result_ticket;
        $returnData['ticket']=$ticket['count'];
        $returnData['goods']=$goods;
        $returnData['ogoods']=$ogoods;
        $returnData['openCode']=$openCode;
        $returnData['openExpect']=$openExpect;
        $this->render("mobile/tickettotal",$returnData);
    }
    // 查看全部参与记录
    public  function actionMoreRecords(){
        $id =trim(Tool::getValidParam('id', 'integer'));
        $sqls="SELECT m.*, COUNT(t.id) AS total,max(t.createtime) as ordertime FROM(select * from {{activity_duobao_gz_ticket}} order by 'createtime' desc) AS t LEFT JOIN {{member}} AS m ON t.memberid=m.id WHERE t.goodsid=".$id." GROUP BY t.openid order by ordertime desc limit 15";
        $ret = Mod::app()->db->createCommand($sqls)->queryAll();
        $returnData['ret']=$ret;
        $this->render("mobile/morerecords",$returnData);
    }
    //一元夺宝  个人中心
    public function actionUser(){
        $uid = trim(Tool::getValidParam('uid', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $adModel = Member::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 'id = :uid';
        $criteria->params = array(':uid'=> $uid);
        $returnData['adList'] = $adModel->findAll($criteria);
        $returnData['pid'] = $pid;
        $this->render("mobile/user",$returnData);

    }
    //夺宝记录
    public function actionMylog(){
        $uid=$this->member['id'];
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $sql="SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  {{activity_duobao_gz_goods}} as g LEFT JOIN {{activity_duobao_gz_ticket}} AS t ON  g.id=t.goodsid WHERE t.openid=".$uid."  AND t.pid=$pid  GROUP BY t.goodsid ORDER BY t.createtime DESC";
        $goods=Mod::app()->db->createCommand($sql)->queryAll();
        $returnData['goods'] = $goods;
        $this->render("mobile/mylog",$returnData);
    }
    //中奖记录
    public function actionMyaward(){
        $uid=$this->member['id'];
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $sql="SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  {{activity_duobao_gz_goods}} as g LEFT JOIN {{activity_duobao_gz_ticket}} AS t ON  g.id=t.goodsid WHERE g.ticket_openid=".$uid."  AND t.pid=$pid  GROUP BY t.goodsid ORDER BY t.createtime DESC";
        $goods=Mod::app()->db->createCommand($sql)->queryAll();
        $returnData['goods'] = $goods;
        $this->render("mobile/myaward",$returnData);
    }
    //我要晒单
    public function actionMyshai(){
        $uid=$this->member['id'];
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $sql="SELECT t.createtime as t_createtime, COUNT(t.id) AS my_total , g.* FROM  {{activity_duobao_gz_goods}} as g LEFT JOIN {{activity_duobao_gz_ticket}} AS t ON  g.id=t.goodsid WHERE g.ticket_openid=".$uid."  AND t.pid=$pid  GROUP BY t.goodsid ORDER BY t.createtime DESC";
        $goods=Mod::app()->db->createCommand($sql)->queryAll();
        $returnData['goods'] = $goods;
        $this->render("mobile/myshai",$returnData);
    }

    public function actionShai(){
        $this->render("mobile/shai");
    }
    //立即参与
    public function actionBuy(){
        $id =trim(Tool::getValidParam('id', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        if($this->member['id']){//登录状态
            $from_user=$this->member['id'];
        }
        $sqls = "SELECT * FROM {{activity_duobao_gz_goods}} WHERE id = $id";
        $goods=Mod::app()->db->createCommand($sqls)->queryAll();
        $sql = "SELECT id, total FROM {{activity_duobao_gz_cart}} WHERE from_user = $from_user AND pid = $pid AND goodsid = $id ";
        $row=Mod::app()->db->createCommand($sql)->queryRow();
        $count=$goods[0]['productprice']-$goods[0]['ticket_total'];
        if($count>$row['total']){
            if ($row == false) {
                //不存在
                $data = array(
                    'pid' => $pid,
                    'goodsid' => $id,
                    'marketprice' => $goods[0]['marketprice'],
                    'from_user' =>$from_user,//微信openid
                    'total' => 1,
                    'createtime'=>time()
                );
                $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_cart',$data);
            } else {
                //累加最多限制购买数量
                $t = 1 + $row['total'];
                if (!empty($goods['maxbuy'])) {
                    if ($t > $goods['maxbuy']) {
                        $t = $goods['maxbuy'];
                    }
                }
                $sqlcart = "UPDATE  {{activity_duobao_gz_cart}} SET total=".$t.",updatetime=".time()." WHERE goodsid= ".$id." AND pid=". $pid." and from_user =". $from_user;
                $query=Mod::app()->db->createCommand($sqlcart)->execute();
            }
            if($query){
                $this->redirect(array('activity/duobao/checkOrder','id'=>$id,pid=>$pid,uid=>$from_user));
            }else{
                exit;
            }
            $result = array(
                'result' => 1,
            );
        }else{
            $this->redirect(array('activity/duobao/checkOrder','id'=>$id,pid=>$pid,uid=>$from_user));
        }
        die(json_encode($result));
    }

    //加入清单
    public function actionBuys(){
        $id =trim(Tool::getValidParam('id', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $from_user=$this->member['id'];
        $sqls = "SELECT * FROM {{activity_duobao_gz_goods}} WHERE id = $id";
        $goods=Mod::app()->db->createCommand($sqls)->queryAll();
        $sql = "SELECT id, total FROM {{activity_duobao_gz_cart}} WHERE from_user = $from_user AND pid = $pid AND goodsid = $id ";
        $row=Mod::app()->db->createCommand($sql)->queryRow();
        $count=$goods[0]['productprice']-$goods[0]['ticket_total'];
        if($count>$row['total']){
            if ($row == false) {
                //不存在
                $data = array(
                    'pid' => $pid,
                    'goodsid' => $id,
                    'marketprice' => $goods[0]['marketprice'],
                    'from_user' =>$from_user,//微信openid
                    'total' => 1,
                    'createtime'=>time()
                );
                $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_cart',$data);
            } else {
                //累加最多限制购买数量
                $t = 1 + $row['total'];
                if (!empty($goods[0]['maxbuy'])) {
                    if ($t > $goods[0]['maxbuy']) {
                        $t = $goods[0]['maxbuy'];
                    }
                }
                $sqlcart = "UPDATE  {{activity_duobao_gz_cart}} SET total=".$t.",updatetime=".time()." WHERE goodsid= ".$id." AND pid=". $pid." and from_user =". $from_user;
                $query=Mod::app()->db->createCommand($sqlcart)->execute();
            }
            $result = array(
                'result' => 1,
            );
        }else{
            $result = array(
                'result' => 0,
            );
        }
        die(json_encode($result));
    }
    //购物车
    public function actionCheckOrder(){
        $uid = trim(Tool::getValidParam('uid', 'integer'));
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $adModel = Activity_duobao_gz_cart::model();
        $criteria = new CDbCriteria();
        $criteria->condition = 't.from_user = :from_user and t.pid=:pid';
        $criteria->params = array(':from_user'=> $uid,'pid'=>$pid);
        $returnData['adList'] = $adModel->with('goods')->findAll($criteria);
        $this->render("mobile/checkorder",$returnData);
    }
    //购物车单个商品数量加减
    public function actionUpdateCart(){
        $id  = trim(Tool::getValidParam('id', 'integer'));
        $num = trim(Tool::getValidParam('num', 'integer'));
        $sqlcart = "UPDATE  {{activity_duobao_gz_cart}} SET total=".$num.",updatetime=".time()." WHERE id= ".$id;
        $query=Mod::app()->db->createCommand($sqlcart)->execute();
        echo json_encode(array('result' => $num));
        die();
    }
    //删除购物车商品
    public function actionRemove(){
        $id  = trim(Tool::getValidParam('id', 'integer'));
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_cart', 'id=:id',$where);
        if($res){
            die(json_encode(array("result" => 1, "cartid" => $id)));
        }
    }
    //是否填写收货地址
    public function actionInfo(){
        $member=$this->member;
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $returnData['pid'] = $pid;
        $sql = "SELECT id FROM {{activity_duobao_gz_address}} WHERE openid = ".$member['id']." AND pid = $pid";
        $row=Mod::app()->db->createCommand($sql)->queryRow();
        if(!$row){
            $this->render("mobile/info",$returnData);
        }else{
            $this->redirect(array('activity/duobao/wxPay',pid=>$pid));
        }
    }

    public function actionDoInfo(){
        $member=$this->member;
        if(Mod::app()->request->isPostRequest) {
            $uname=trim(Tool::getValidParam('uname', 'string'));
            $tel=trim(Tool::getValidParam('tel', 'string'));
            $pid=trim(Tool::getValidParam('pid', 'integer'));
            $sqlcart = "UPDATE  {{activity_duobao_gz_address}} SET realname='".$uname."',updatetime=".time().",mobile='".$tel."' WHERE openid= '".$member['id']."'";
            $query=Mod::app()->db->createCommand($sqlcart)->execute();
            if($query){
                $this->redirect(array('activity/duobao/user',pid=>$pid));
                exit;
            }else{
                echo '{"statue":2,"msg":"添加失败"}';
                exit;
            }
        }
    }
    //收货地址
    public function actionMyaddress(){
        $member=$this->member;
        $uid=trim(Tool::getValidParam('uid', 'integer'));
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $sql = "SELECT * FROM {{activity_duobao_gz_address}} WHERE openid = ".$uid." AND pid = $pid";
        $row=Mod::app()->db->createCommand($sql)->queryRow();
        $returnData['info'] = $row;
        $this->render("mobile/myaddress",$returnData);
    }
    public function actionAddress(){
        $member=$this->member['id'];
        if(Mod::app()->request->isPostRequest) {
            $data = array(
                /*  'realname' => $_POST['uname'],
                  'mobile' => $_POST['tel'],
                  'openid' => $member['id'],
                  'pid' =>$_POST['pid'],*/
                'realname' => trim(Tool::getValidParam('uname', 'string')),
                'mobile' => trim(Tool::getValidParam('tel', 'string')),
                'openid' => "$member",
                'pid' =>trim(Tool::getValidParam('pid', 'integer')),
            );
            $pid=trim(Tool::getValidParam('pid', 'integer'));
            $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_address',$data);
            if($query){
                $this->redirect(array('activity/duobao/wxPay',pid=>$pid));
                exit;
            }else{
                echo '{"statue":2,"msg":"添加失败"}';
                exit;
            }
        }
    }


    public  function actionWxPay(){
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $uid=$this->member['id'];
        $sqls = "SELECT sum(c.total) as price FROM {{activity_duobao_gz_cart}} as c left JOIN {{activity_duobao_gz_goods}} as g on c.goodsid=g.id  WHERE c.pid = $pid and c.from_user=$uid ";
        $cart=Mod::app()->db->createCommand($sqls)->queryAll();
        $sqlss = "SELECT g.title as title FROM {{activity_duobao_gz_cart}} as c left JOIN {{activity_duobao_gz_goods}} as g on c.goodsid=g.id  WHERE c.pid = $pid and c.from_user=$uid ";
        $carts=Mod::app()->db->createCommand($sqlss)->queryAll();
        if(empty($carts)){
            $code=0;
        }
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            $weixin=123;
        }
        $result = array(
            'price' => $cart[0]['price'],
            'title' => $carts[0]['title'],
            'pid' => $pid,
            'weixin' => $weixin,
            'code' => $code,
            'uid' => $uid,
        );

        $this->render("mobile/wxpay",$result);
    }

    //native  扫码支付
    public function actionDoPays(){
        $uid=$this->member['id'];
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $sqlc = "SELECT id FROM {{activity_duobao_gz_cart}} WHERE from_user = $uid AND pid =". $pid;
        $row=Mod::app()->db->createCommand($sqlc)->queryRow();
        if($row){
            if(Mod::app()->request->isPostRequest) {
                $data = array(
                    'pid' =>  $pid,
                    'from_user' => $this->member['id'],
                    'ordersn' => date('md') . $this->random(4, 1),
                    /*   'price' =>  $_POST['price'],
                       'goodsprice' =>  $_POST['price'],*/
                    'price' =>  trim(Tool::getValidParam('price', 'integer')),
                    'goodsprice' =>  trim(Tool::getValidParam('price', 'integer')),
                    'status' => 0,
                    'sendtype' => 1,
                    'goodstype' => 1,
                    /*'remark' => $_POST['way'],*/
                    'remark' => trim(Tool::getValidParam('way', 'string')),
                    'addressid' => $this->member['id'],
                    'createtime' => time()
                );
                $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_order',$data);
                if($query){
                    $insert_id = Mod::app()->db->getLastInsertID();
                    $sqls = "SELECT * from {{activity_duobao_gz_cart}} where from_user=$uid and pid=".$pid;
                    $allcart=Mod::app()->db->createCommand($sqls)->queryAll();
                    foreach ($allcart as $row) {
                        if (empty($row)) {
                            continue;
                        }
                        $d = array(
                            'pid' => $pid,
                            'goodsid' => $row['goodsid'],
                            'from_user' => $row['from_user'],
                            'orderid' => $insert_id,
                            'total' => $row['total'],
                            'price' => $row['total'],
                            'createtime' => time(),
                            'optionid' => $row['optionid']
                        );

                        $querys = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_order_goods',$d);
                        if($querys){
                            $where = array(
                                ':from_user' => $uid,
                                ':pid'=>$pid
                            );
                            $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_cart', 'from_user=:from_user and pid=:pid',$where);
                        }
                    }
                }
            }
        }
        $sqlo = "SELECT s.title,o.ordersn,o.price FROM {{activity_duobao_gz_order}} as o left JOIN {{activity_duobao_gz_order_goods}} as g on o.id=g.orderid left join {{activity_duobao_gz_goods}} as s on g.goodsid=s.id  WHERE o.id = $insert_id";
        $order=Mod::app()->db->createCommand($sqlo)->queryAll();
        //微信支付
        $openid=$this->member_project['openid'];
        $re= $this->actionPaying($order[0]['title'], $order[0]['price'],$order[0]['ordersn']);
        $result = array(
            'title' => $order[0]['title'],
            'ordersn' => $order[0]['ordersn'],
            'price' => $order[0]['price'],
            'url2' => $re,
            'pid'=> $pid,
        );
        Mod::app()->session['ordersn']=$order[0]['ordersn'];
        /* $sqlst = "SELECT * FROM {{activity_duobao_gz_order}} WHERE  ordersn=07084341 and status=1 ";
         $rowlst=Mod::app()->db->createCommand($sqlst)->queryRow();
         if($rowlst){
             $returnData = '100';
         }else{
             $returnData = '102';
         }
         echo  json_encode($returnData);*/

        $this->render("mobile/dopays",$result);
    }
    public function actionTest(){
        $this->render("mobile/dopays");
    }
    public function actionSs(){
        $ordersn=Mod::app()->session['ordersn'];
        $sqlst = "SELECT * FROM {{activity_duobao_gz_order}} WHERE  ordersn=$ordersn and status=1 ";
        $rows=Mod::app()->db->createCommand($sqlst)->queryRow();
        if($rows){
            $returnData = '100';
            unset(Mod::app()->session['ordersn']);
        }else{
            $returnData = '102';
        }
        echo  json_encode($returnData);
    }

    public function actionPaying($title,$price,$ordersn){
        ini_set('date.timezone','Asia/Shanghai');
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/lib/WxPay.Api.php';
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/example/WxPay.NativePay.php';
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/example/log.php';
        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($title);
        $input->SetAttach($title);
        $input->SetOut_trade_no($ordersn);
        $input->SetTotal_fee("1");
        /*$input->SetTotal_fee($price*100);*/
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($title);
        $input->SetNotify_url("http://m.dachuw.net/activity/notify");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id("123456789");
        $result = $notify->GetPayUrl($input);
        $url2 = $result["code_url"];
        return $url2;
    }

    //jsapi  支付
    public function actionDoPay(){
        $uid=$this->member['id'];
        $pid=trim(Tool::getValidParam('pid', 'integer'));
        $sqlc = "SELECT id FROM {{activity_duobao_gz_cart}} WHERE from_user = $uid AND pid =". $pid;
        $row=Mod::app()->db->createCommand($sqlc)->queryRow();
        if($row){
            if(Mod::app()->request->isPostRequest) {
                $data = array(
                    'pid' => $pid,
                    'from_user' => $this->member['id'],
                    'ordersn' => date('md') . $this->random(4, 1),
                    'price' =>  trim(Tool::getValidParam('price', 'string')),
                    'goodsprice' => trim(Tool::getValidParam('price', 'string')),
                    'status' => 0,
                    'sendtype' => 1,
                    'goodstype' => 1,
                    'remark' => trim(Tool::getValidParam('way', 'string')),
                    'addressid' => $this->member['id'],
                    'createtime' => time()
                );
                $query = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_order',$data);
                if($query){
                    $insert_id = Mod::app()->db->getLastInsertID();
                    $sqls = "SELECT * from {{activity_duobao_gz_cart}} where from_user=$uid and pid=".$pid;
                    $allcart=Mod::app()->db->createCommand($sqls)->queryAll();
                    foreach ($allcart as $row) {
                        if (empty($row)) {
                            continue;
                        }
                        $d = array(
                            'pid' => $pid,
                            'goodsid' => $row['goodsid'],
                            'from_user' => $row['from_user'],
                            'orderid' => $insert_id,
                            'total' => $row['total'],
                            'price' => $row['total'],
                            'createtime' => time(),
                            'optionid' => $row['optionid']
                        );

                        $querys = Mod::app()->db->createCommand()->insert('dym_activity_duobao_gz_order_goods',$d);
                        if($querys){
                            $where = array(
                                ':from_user' => $uid,
                                ':pid'=>$pid
                            );
                            $res = Mod::app()->db->createCommand()->delete('dym_activity_duobao_gz_cart', 'from_user=:from_user and pid=:pid',$where);
                        }
                    }
                }
            }
        }
        $sqlo = "SELECT s.title,o.ordersn,o.price FROM {{activity_duobao_gz_order}} as o left JOIN {{activity_duobao_gz_order_goods}} as g on o.id=g.orderid left join {{activity_duobao_gz_goods}} as s on g.goodsid=s.id  WHERE o.id = $insert_id";
        $order=Mod::app()->db->createCommand($sqlo)->queryAll();
        //微信支付
        $openid=$this->member_project['openid'];
        $re= $this->actionWxpaying($order[0]['title'], $order[0]['price'],$order[0]['ordersn'], $openid);
        $result = array(
            'title' => $order[0]['title'],
            'ordersn' => $order[0]['ordersn'],
            'price' => $order[0]['price'],
            'jsApiParameters' => $re['jsApiParameters'],
            'editAddress' => $re['editAddress'],
            'pid'=>$pid,
        );
        $this->render("mobile/dopay",$result);
    }
    //jsapi
    public function actionWxpaying($title,$price,$ordersn,$openId){
        ini_set('date.timezone','Asia/Shanghai');
        //error_reporting(E_ERROR);
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/lib/WxPay.Api.php';
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/example/WxPay.JsApiPay.php';
        include dirname(dirname(dirname(__FILE__))).'/vendor/wxpay/example/log.php';
        //初始化日志
        //$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
        //$log = Log::Init($logHandler, 15);
        //①、获取用户openid
        $tools = new JsApiPay();
        //$openId = $tools->GetOpenid();
        //$openId="oqXmpwZ7lcCT6YBq82tZ1roAh2aY";
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($title);
        $input->SetAttach($title);
        $input->SetOut_trade_no($ordersn);
        /*$input->SetTotal_fee($price*100);*/
        $input->SetTotal_fee(1);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($title);
        $input->SetNotify_url("http://m.dachuw.net/activity/notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        /*  file_put_contents("notify.txt","支付成功",FILE_APPEND);*/
        //获取共享收货地址js函数参数
        $editAddress = $tools->GetEditAddressParameters();
        return array("jsApiParameters"=>$jsApiParameters,"editAddress"=>$editAddress);
        //③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
        /**
         * 注意：
         * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
         * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
         * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
         */

    }
    //游戏说明
    public function ActionClause(){

        $this->render("mobile/clause");
    }
    //订单号生成
    public function random($length, $numeric = FALSE) {
        $seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
        if ($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }
}