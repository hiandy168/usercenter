<?php

/**
 * Created by PhpStorm.
 * User: xiaoxindezhihui
 * Date: 2016/11/4
 * Time: 17:04
 * 零元测评控制器
 */
class ZeroController extends FrontController
{
    public function init()
    {
        parent::init();


    }

    /*
     * 添加商品
     * 编辑商品*/
    public function actionGoodsAdd()
    {
        if (!$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $data = array();
        //活动所属的应用的id
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $fid = trim(Tool::getValidParam('fid', 'integer'));

        if ($fid) {
            $re = Activity_zero::model()->findByPk($fid);
            $activity_info = $re->attributes;
        }
        $data = array(
            'activity_info' => $activity_info,
            'config' => array('site_title' => '零元测评', 'active' => 9, 'pid' => $pid)
        );
        $this->render('goodsadd', $data);
    }

    /*ajax添加编辑商品*/
    public function actionAjaxGoodsAdd()
    {
        if (Mod::app()->request->isPostRequest) {
            $id = Tool::getValidParam('id', "integer");
            $data['pid'] = Tool::getValidParam('pid', 'integrt');
            $data['title'] = Tool::getValidParam('title', 'string');
            $data['inventory'] = Tool::getValidParam('total', 'integer');
            $data['price'] = Tool::getValidParam('productprice', 'double');
            $data['unit'] = Tool::getValidParam('unit', 'string');
            $data['starttime'] = strtotime($_POST['timestart']);
            $data['endtime'] = strtotime($_POST['timeend']);
            $data['img'] = Tool::getValidParam('img', 'string');
            $data['share_desc'] = Tool::getValidParam('share_desc', 'string');
            $data['share_img'] = Tool::getValidParam('share_img', 'string');
            $data['details'] = Tool::getValidParam('desc', 'sttring');
            $data['is_wear'] = Tool::getValidParam('is_wear', 'integer') ? 1 : 0;

            if ($id) {
                $data['updatetime'] = time();
                $update_id = array(':id' => $id);
                $query = Mod::app()->db->createCommand()->update('dym_activity_zero', $data, 'id=:id', $update_id);
                if ($query) {
                    $results = array('statue' => 1, 'msg' => "修改数据成功");
                }
            } else {
                $data['createtime'] = time();
                $query = Mod::app()->db->createCommand()->insert('dym_activity_zero', $data);
                if ($query) {
                    $results = array('statue' => 1, 'msg' => "编辑数据成功");
                }
            }
            if (!$query) {
                $results = array('statue' => 0, 'msg' => "数据提交失败，请刷新页面重新尝试");
            }
            echo json_encode($results);
            exit;
        } else {
            $results = array('statue' => 2, 'msg' => "no default value");
            echo json_encode($results);
            exit;
        }
    }

    /*
     * 商品活动列表*/
    public function actionGoodsList()
    {
        if (!$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }

        //活动所属的应用的id
        $pid = trim(Tool::getValidParam('pid', 'integer'));
        $data = array();
        $as_list = Activity_zero::model()->getActivityListPager($pid);

        $data = array(
            'asList' => $as_list['criteria'],
            'pagebar' => $as_list['pagebar'],
            'count' => $as_list['count'],
            'config' => array('site_title' => '零元测评', 'active' => 9, 'pid' => $pid)
        );
        $this->render('goodslist', $data);
    }

    /*
     * 删除活动商品*/
    public function actionGoodsDel()
    {
        if (!$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        $id = trim(Tool::getValidParam('fid', 'integer'));
        //删除
        $where = array(
            ':id' => $id
        );
        $res = Mod::app()->db->createCommand()->delete('dym_activity_zero', 'id=:id', $where);
        if ($res) {
            $mess = array('errorcode' => 0, 'status' => 'success');
        } else {
            $mess = array('errorcode' => 1, 'status' => 'fail');
        }
        echo json_encode($mess);
        exit;
    }

    /*
    * 活动开始/结束*/
    public function actionGoodsstart()
    {
        if (!$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        //活动的id
        $id = Tool::getValidParam('fid', 'integer');
        //type 1表是设置开始 2表示设置结束
        $type = Tool::getValidParam('type','string');
        if ($type == 1) {
            $str = '开始';
            $arr = array('starttime' => time());
        }
        if ($type == 2) {
            $str = '结束';
            $arr = array('endtime' => time());
        }
        $update_id = array(':id' => $id);
        $query = Mod::app()->db->createCommand()->update('dym_activity_zero', $arr, 'id=:id', $update_id);
        if ($query) {
            $res = array(
                'statue' => 1,
                'msg' => '设置' . $str . '成功'
            );
        } else {
            $res = array(
                'statue' => 0,
                'msg' => '设置' . $str . '失败'
            );
        }
        echo json_encode($res);
    }

    /*
    * 用户数据*/
    public function actionUserData()
    {
        $pid = Tool::getValidParam('pid', 'integer');
        $data = array(
            'config' => array('site_title' => '零元测评', 'active' => 9, 'pid' => $pid)
        );
        $this->render('addlist', $data);
    }

    /*
     * 零元测评活动页面*/
    public function actionview()
    {
        $pid = Tool::getValidParam('pid', 'integer');
        $id = trim(Tool::getValidParam('id', 'integer'));
        $goods = Activity_zero::model()->findByPk($id);
        if ($goods) {
            $project_info = Project::model()->findByPk($goods->pid);//

        }
        Browse::add_usernum($pid);  //计算独立访客数量
        Browse::add_browsenum($pid); //计算浏览量

        $data = array(
            'param' => array(
                "appid" => $project_info['appid'],
                "appsecret" => $project_info['appsecret'],
                "openid" => $this->member_project['openid'],
                "status" => $this->member['status'],
                "mid" => $this->member['id']
            ),
            'goods'=>$goods,
            'config' => array('site_title' => '零元测评', 'active' => 9, 'pid' => $pid)
        );
        $this->render('view', $data);
    }

    /*
     * 申请页面 订单生城*/
    public function actionApplication(){
        if (!$this->member['id']) {
            $this->redirect(Mod::app()->request->getHostInfo());
            exit;
        }
        if (Mod::app()->request->isPostRequest) {
             //$data['id'] =Tool::getValidParam('id','integer');
             $data['mid']=$this->member['id'];//用户id
             $data['gid'] =Tool::getValidParam('gid','integer');//商品id
             $data['name'] =Tool::getValidParam('name','string');//收货人姓名
             $data['phone'] =Tool::getValidParam('phone','string');//联系电话
             $data['Provincial'] =Tool::getValidParam('Provincial','string');//省
             $data['city'] =Tool::getValidParam('city','string');//市
             $data['area']=Tool::getValidParam('area','string');//地区
             $data['addr'] =Tool::getValidParam('addr','string');//街道地址
             $data['reason'] =Tool::getValidParam('reason','string');//申请理由
            // $data['status'] =1;
             $data['orderid']="zero".date("YmdHis").mt_rand(10,99);//订单号
             $data['createtime']=time();
             $data['updatetime'] =time();

            $re=Activity_zero_order::model()->insert($data);
            if($re){
                echo 1;
            }else{
                echo "订单创建失败！请刷新页面再试！";
            }
            exit;
        }

        $data = array(
            'config' => array('site_title' => '零元测评', 'active' => 9, 'pid' => $pid)
        );
            $this->render('application',$data);
    }

    /*
     * 申请理由列表
    */
    public function actionApplicationlist(){
           $re= Activity_zero_order::model()->findAll();
    }

    /*
     * 审核订单*/
    public function actionAuditOrder(){

    }
    /*
    * 审核评价*/
    public function actionAuditEvaluation(){

    }


    /*ajax 审核 理由和评价*/
    public  function actionAjaxAudit(){
        //活动结束之后并且申请理由审核完成，然后再来计算中奖率
        //s首先如果参与人数不足奖品数量，那么参与的人100%中奖！
        if (Mod::app()->request->isPostRequest) {
            //如果有提交根据提交的内容判断是审核申请理由还是评价审核
            $type= Tool::getValidParam('type','integer');//是更新的谁
            $status= Tool::getValidParam('status','integer');//审核状态
            $id= Tool::getValidParam('id','integer');//对应id
            if(!$id){
                echo "no sumbit value";
                exit;
            }

            switch($type){
                //等于1 表示审核理由
                case 1:
                  $re= Activity_zero_order::model()-> updateByPk($id,array('status'=>$status,'updatetime'=>time()));
                    break;
                //等于2 表示审核评价
                case 2:
                    $re= Activity_zero_evaluation::model()-> updateByPk($id,array('status'=>$status,'updatetime'=>time()));
                    break;
                default:
                    echo "You submitted a wrong value";
                    exit;
            }
            echo $re?1:"系统开小差了，审核失败！请稍后再试！";
            exit;
        }else{
            echo "no sumbit value";
            exit;
        }
    }

    /*
     * 计算中奖的算法，根据需求，目前有两个参数计算中奖率
     * 点赞数，活跃度
     *
     * parameter : 总的试用份数
     * mid:参与本次活动的用户id*/
    public function actionalgorithm($parameter,$mid){
        //首先查出该用户的活跃度
        $number=  Member_behavior::model()->count("mid=:mid",array(":mid"=>$mid));
        if(!$number){
            $number=0;
        }
        //该用户所有的评价
        $praise=Activity_zero_evaluation::model()->findAll("mid=:mid",array(":mid"=>$mid));
        $praisenumber=0;
        if($praise) {
            foreach ($praise as $value) {
                $praisenumber = intval($value->praise) + $praisenumber;//该用户所有的赞数相加
            }
        }
       $probably= ($number+$praisenumber)/$parameter;//活跃度加上赞数除以总数等于用户中奖的概率
        return $probably;


    }

}