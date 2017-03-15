<?php

class SiteController extends FrontController{
    
    public function init() {
        parent::init();
    }
    
    public function actionIndex() {   

        $data['config']['active']='shouye';
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "大楚用户开放平台首页";
        $data['config']['site_keywords'] = "大楚用户开放平台首页,腾讯大楚网,腾讯新闻网";
        $data['config']['site_description'] ="大楚用户开放平台首页" ;
        $this->render('index',$data);

    }

//    public function actionActivity() {
//        $data['pid']= trim(Tool::getValidParam('pid', 'string'));
//        $data['config'] = $this->site_config;
//        $data['tel']=$this->member['name'];
//        $this->render('activity',$data);
//    }

    public function actionUpdateMemInfo()
    {
        if(Mod::app()->request->isPostRequest) {
            $id = $this->member['id'];

            $data['phone'] = trim(Tool::getValidParam('phone', 'string'));
            $data['email'] = trim(Tool::getValidParam('email', 'string'));
           // $data['type'] = trim(Tool::getValidParam('type', 'integer'));
            $data['company'] = trim(Tool::getValidParam('company', 'string'));
            $data['address'] = trim(Tool::getValidParam('address', 'string'));
           // $data['headimgurl'] = trim(Tool::getValidParam('share_img', 'string'));
            $data['updatetime'] = time();
            //print_r($data);exit;
//            var_dump($data['phone']);exit;
            $res = Member::model()->updateByPk($id, $data);
            if ($res) {
                //更新session
                $member = $this->member;
                $member['phone'] = $data['phone'];
                $member['email'] = $data['email'];
               // $member['type'] = $data['type'];
                $member['company'] = $data['company'];
                $member['address'] = $data['address'];
               // $member['headimgurl'] = $data['headimgurl'];
                $member['updatetime'] = $data['updatetime'];
                Mod::app()->session['member'] = $member;
                exit(json_encode(array('state' => 1, 'mess' => '修改成功')));
            } else {
                exit(json_encode(array('state' => 100027, 'mess' => '修改失败')));
            }
        }

        $config['site_title'] = '基本信息';
        $user_session = Mod::app()->session['member'];
        $user = array(
            'id'=>$user_session['id'],
            'name'=>$user_session['name'],
            'phone'=>$user_session['phone'],
            'username'=>$user_session['username'],
            //'type'=>$user_session['type'],
            'company'=>$user_session['company']
        );
        $config['admin'] =$user;
        $config['position'] = array(
            array('name'=>'管理中心'),
            array('name'=>'编辑资料'),
        );
        $config['site_title'] = '大楚用户开发平台首页-修改资料';
        $config['Keywords'] = '大楚用户开发平台首页-修改用户资料';
        $config['Description'] = '大楚用户开发平台首页-用户修改资料';
        $config['active'] = 'xiugaiziliao';
        $this->render('info',array('config'=>$config));
    }
}