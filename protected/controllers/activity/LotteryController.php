<?php

class LotteryController extends FrontController
{
    public $prize_arr;

    public function init()
    {
        //奖项初始化
        $this->prize_arr = array(
            '0' => array('id'=>1,'min'=>array(1,346),'max'=>array(17,360),'prize'=>'一等奖','v'=>1),
            '1' => array('id'=>2,'min'=>109,'max'=>136,'prize'=>'二等奖','v'=>5),
            '2' => array('id'=>3,'min'=>225,'max'=>252,'prize'=>'三等奖','v'=>10),
            '3' => array('id'=>4,'min'=>139,'max'=>165,'prize'=>'再接再厉','v'=>20),
            '4' => array('id'=>5,'min'=>81,'max'=>108,'prize'=>'祝你好运','v'=>20),
            '5' => array('id'=>6,'min'=>18,'max'=>47,'prize'=>'不要灰心','v'=>20),
            '6' => array('id'=>7,'min'=>196,'max'=>222,'prize'=>'运气先攒着','v'=>20),
            '7' => array('id'=>8,'min'=>253,'max'=>281,'prize'=>'要加油哦','v'=>20),
            '8' => array('id'=>9,'min'=>315,'max'=>345,'prize'=>'谢谢参与','v'=>20),
            '9' => array('id'=>10,'min'=>array(48,166,282),
                'max'=>array(80,195,315),'prize'=>'您未中奖','v'=>50)
        );

        parent::init();
    }

    public function actionIndex()
    {
        $token = trim(Tool::getValidParam('access_token','string'));
        $mid = trim(Tool::getValidParam('mid','integer'));
        //* 验证access_token是否合法
        $pInfo = Project_token::model()->checkAccessToken($token);
        if(!$pInfo){
            exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
        }else{
            if($pInfo->expires_in < time()){
                exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
            }
        }
        //判断用户是否登陆
        $meb = Member::model()->findByPk($mid);
//        var_dump($mid);
        $status = 1;
        if(!$meb->phone){
            $status = 2;
        }
//        exit(json_encode(array('status'=>$status)));
        $this->render('index',array('token'=>$token,'mid'=>$mid,'pid'=>$pInfo->pid,'status'=>$status));
    }

    //抽奖开始
    public function actionStart()
        {
            $token = trim(Tool::getValidParam('access_token','string'));
            $mid = trim(Tool::getValidParam('mid','integer'));
            //* 验证access_token是否合法
            $pInfo = Project_token::model()->checkAccessToken($token);
            if(!$pInfo){
                exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
            }else{
                if($pInfo->expires_in < time()){
                    exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
                }
            }
            //判断用户是否登陆
            $meb = Member::model()->findByPk($mid);
            //        var_dump($mid);
            if(!$meb->phone){
                $status = 2;
                exit(json_encode(array('status'=>$status,'mess'=>'您还未注册,请先注册')));
            }
            //判断是否中过奖
            $memPro = Member_project::model()->findByAttributes(array('pid'=>$pInfo->pid,'mid'=>$mid));
            $lot = Lottery::model()->findByAttributes(array('mid'=>$memPro->mid,'pid'=>$pInfo->pid,'status'=>1));

            if($lot){
//                exit(json_encode(array('status'=>100018,'mess'=>'本次活动你已经中过奖，本次只显示你上次抽奖结果!兑奖SN码为:'.$lot->code)));
            }
            //判断抽奖次数
            $count = Lottery::model()->countByAttributes(array('mid'=>$memPro->mid,'pid'=>$pInfo->pid));
            if($count > 1){
//                exit(json_encode(array('status'=>100025,'mess'=>'您已抽过两次,不能再抽奖了')));
            }
            foreach ($this->prize_arr as $key => $val) {
                $arr[$val['id']] = $val['v'];
            }
            $rid = $this->getRand($arr); //根据概率获取奖项id
            $res = $this->prize_arr[$rid - 1]; //中奖项
    //        var_dump($res);exit;
            $min = $res['min'];
            $max = $res['max'];

            if ($res['id'] == 10) { //未中奖
                $i = mt_rand(0, 2);
                $result['angle'] = mt_rand($min[$i], $max[$i]);
            }elseif($res['id'] == 1){
                $i = mt_rand(0, 1);
                $result['angle'] = mt_rand($min[$i], $max[$i]);
            } else {
                $result['angle'] = mt_rand($min, $max); //随机生成一个角度
            }
            //返回前台参数
            $result['prize'] = $res['prize'];  //中奖提示
            if($res['id'] < 4){
                $result['prize'] = '恭喜您中了'.$res['prize'];
            }
            $result['id'] = $res['id'];     //中奖ID
            $result['success'] = 1;     //中奖ID

            //添加抽奖记录
            $model = new Lottery();
            $data['pid'] = $pInfo->pid;
            $data['mid'] = $mid;
            $data['tro_level'] = $res['id'];
            $data['status'] = ($res['id']>3)?0:1;  //设置中奖状态
            $data['createtime'] = time();
            //生成中奖码
            $str = '0123456789abcdefghigklmnopqrstuvwxyzQWERTYUIOPLKJHGFDSAZXCVBNM';
            $string = substr(str_shuffle($str),0,10);
            $data['code'] = ($res['id']>3)?'':$string;
            $model->attributes = $data;
            $model->save();
            //上报用户行为
            $behavior = new Member_behavior('create');
            $data['openid'] = $memPro->openid;
//            $be_type = Behavior_type::model()->findByAttributes(array('pid'=>$pInfo->pid,'name'=>'抽奖'));
//            $data['type'] = $be_type->id;
            $data['type'] = '大转盘';
            $behavior->attributes = $data;
            $behavior->save();
            $result['sn'] = $data['code'];
            exit(json_encode($result));
//            $this->render('index',array('res'=>$result));
        }

    /**
     * 根据概率获取奖项
     * @param unknown $proArr
     * @return Ambigous <string, unknown>
     */
    public function getRand($proArr) {
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
    //更新中奖人信息
    public function actionUpdateLot()
    {
        $token = trim(Tool::getValidParam('access_token','string'));
        $mid = trim(Tool::getValidParam('mid','integer'));
        $tel = trim(Tool::getValidParam('tel','string'));
        $code = trim(Tool::getValidParam('code','string'));
        //* 验证access_token是否合法
        $pInfo = Project_token::model()->checkAccessToken($token);
        if(!$pInfo){
            exit(json_encode(array('status'=>100009,'mess'=>'非法access_token请求')));
        }else{
            if($pInfo->expires_in < time()){
                exit(json_encode(array('status'=>100004,'mess'=>'access_token已过期')));
            }
        }
        $lot = Lottery::model()->findByAttributes(array('mid'=>$mid,'pid'=>$pInfo->pid,'code'=>$code));
        $res = Lottery::model()->updateByPk($lot->id,array('tel'=>$tel));
        if($res){
            exit(json_encode(array('success'=>1)));
        }else{
            exit(json_encode(array('success'=>0)));
        }
    }

}