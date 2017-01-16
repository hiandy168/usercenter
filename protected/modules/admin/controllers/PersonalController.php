<?php

class PersonalController  extends AController {
        //父类菜单 用于菜单栏选定
        public $parent_menu='mysetting';
        public $thisclass='personal';
        public $thisclassname='个人信息';

   
    public function actionPassword() {
        if (Mod::app()->request->isPostRequest) {
            $data['password'] =  Mod::app()->request->getParam('password');
            $repassword =  Mod::app()->request->getParam('repassword');
            if($repassword == $data['password']){
                    $target_url = $this->createUrl('/'.$this->getModule()->getId().'/personal/password');
                    $User = User::model()->findByPk(intval($this->user['id'])); 
//                    var_dump($User);die;
                    if($User){
                        $User->source = Tool::random_keys(5);//随机生成5位字符串
                        $User->password = Tool::md5str($data['password'],$User->source);
                        $User->lastlogintime=time();
                        if ($User->save()) {
                            $this->admin_message($msg . '成功', $target_url);
                        } else {
                            $this->admin_message($msg . '失败', $target_url);
                        }

                    }else{
                            $this->admin_message($msg . '失败', $target_url);
                    }
            }else{
                    $target_url = $this->createUrl('/'.$this->getModule()->getId().'/member/add');
                    $this->admin_message('两次密码不一致或者密码为空', $target_url);
                    exit();
            }
        }
        $data['info'] = array();
        if ($this->user['id']) {
            $data['info'] = User::model()->findByPk(intval($this->user['id']))->attributes;
        }

      
        $this->render('password',$data);
        
    }
    
  

    public function actionInfo() {
        if (Mod::app()->request->isPostRequest) {
            $data = $_POST;
            if(isset($data['password']))unset($data['password']);//编辑用户能能不能修改密码
            //var_dump(isset($data['id']));exit;
            $msg = '修改';
            $target_url = $this->createUrl('/'.$this->getModule()->getId().'/personal/info');
          
            $User = User::model()->findByPk(intval($this->user['id'])); 
            if($User){
                foreach ($User->attributes as $k => $v) {
                    isset($data[$k]) && $User->$k = $data[$k];
                }


                $User->updatetime=time();
                if ($User->save()) {
                    $this->admin_message($msg . '成功', $target_url);
                } else {
                    $this->admin_message($msg . '失败', $target_url);
                }
            
            }else{
                    $this->admin_message($msg . '失败', $target_url);
            }
        }
        $data['info'] = array();
        if ($this->user['id']) {
            $data['info'] = User::model()->findByPk(intval($this->user['id']))->attributes;
        }
        $this->thisclass = 'personal/info';

        $this->render('info',$data);
    }
    
      public function actionLog() {
         $this->check_permission(__CLASS__, __FUNCTION__);
        $sql = "select * from {{logs}} where uid =".$this->user['id'];
        $criteria=new CDbCriteria();
        $result = Mod::app()->db->createCommand($sql)->query();
        $pages=new CPagination($result->rowCount);
        $pages->pageSize=15;
        $pages->applyLimit($criteria);
        $result=Mod::app()->db->createCommand($sql." LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $data['list']=$result->queryAll();
  
        $data['pagebar'] = $pages ;
        
     

        $this->render('log', $data);
    }
    
    

}
