<?php

class MemberController extends AController
{

    public function actionIndex()
    {
        $status = Tool::getValidParam('status', 'integer');
        $phone = Tool::getValidParam('phone', 'string');
        $this->actionlists($status, $phone);
    }

    public function actionlists($status, $phone)
    {

        $this->check_permission(__CLASS__, 'lists');
        //会员分组信息
        $group_model = new Membergroup();
        $group = $group_model->findAll("status = 1");

        $group_id = Mod::app()->request->getParam('group_id');

        $model = new Member();
        $criteria = new CDbCriteria();

        //筛选 审核状态
        if ($status == 2) {
            $criteria->condition = "t.status=0 AND t.pstatus=0";
        } elseif ($status == 1) {
            $criteria->condition = "t.status=1 AND t.pstatus=0";
        }

        if ($group_id) {
            $criteria->addCondition("t.group_id=" . $group_id);
        }

        if (isset($_REQUEST['username']) && $_REQUEST['username']) {
            $criteria->addCondition("t.username like '%" . trim($_REQUEST['username'] . "%'"));
            $data['s']['username'] = trim($_REQUEST['username']);
        }


        if (isset($phone) && $phone) {
            $criteria->addCondition("t.phone like '%" . trim($phone . "%'"));
            $data['s']['phone'] = trim($phone);
        }

        if (isset($_REQUEST['group_id']) && $_REQUEST['group_id']) {
            $criteria->addCondition("t.group_id  = '" . trim($_REQUEST['group_id'] . "'"));
            $data['s']['group_id'] = trim($_REQUEST['group_id']);
        }


        if (isset($_REQUEST['type']) && $_REQUEST['type']) {

            $data['s']['type'] = trim($_REQUEST['type']);
            if ($_REQUEST['type'] == 'phone') {
                $criteria->addCondition("t.name  <> '' ");
            } else if ($_REQUEST['type'] == 'wx') {
                $criteria->addCondition("t.unionid <> '' ");
            }
        }


        $criteria->order = 't.id DESC';
        $criteria->with = 'Membergroup';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $data['pages_params'] = array();
        if (isset($data['s']['category_id']) && $data['s']['category_id']) {
            $data['pages_params']['category_id'] = $data['s']['category_id'];
        }
        if (isset($data['s']['title']) && $data['s']['title']) {
            $data['pages_params']['title'] = $data['s']['title'];
        }
        if (isset($data['s']['recommend']) && $data['s']['recommend']) {
            $data['pages_params']['recommend'] = $data['s']['recommend'];
        }
        $pages->params = $data['pages_params'];
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('member', array('s' => $data['s'], 'datalist' => $result,'phone'=>$phone, 'group' => $group, 'pagebar' => $pages));
    }

    public function actionAdd()
    {
        $this->check_permission(__CLASS__, 'add');
        $data['name'] = Mod::app()->request->getParam('name');
        $data['password'] = Mod::app()->request->getParam('password');
        $repassword = Mod::app()->request->getParam('repassword');
        if (isset($_POST) && $repassword == $data['password']) {
            $data['group_id'] = Mod::app()->request->getParam('group_id');
            $data['source'] = Tool::random_keys(5);//随机生成5位字符串
            $data['password'] = Tool::md5str($data['password'], $data['source']);
            $data['status'] = Mod::app()->request->getParam('status');
            $data['remark'] = Mod::app()->request->getParam('remark');
            $data['regtime'] = $data['lastlogintime'] = time();
            $data['regip'] = $data['lastloginip'] = Tool::get_ip();
            $model = new Member('create');
            $model->attributes = $data;
            if ($model->save()) {
                $target_url = $this->createUrl('/' . $this->getModule()->getId() . '/member/');
                $this->admin_message('添加成功', $target_url);
                exit();
            }
        } else {
            $target_url = $this->createUrl('/' . $this->getModule()->getId() . '/member/add');
            $this->admin_message('两次密码不一致或者密码为空', $target_url);
            exit();
        }

        //会员分组信息
        $group_model = new Membergroup();
        $group = $group_model->findAll("status = 1");

        $this->render('member_edit', array('model' => $model, 'group' => $group, 'fun' => 'add'));
    }

    /**
     * 管理员编辑
     *
     * @param  $id
     */
    public function actionEdit()
    {
        $this->check_permission(__CLASS__, 'edit');
        $data['id'] = Mod::app()->request->getParam('id');
        $model = Member::model()->findbypk($data['id']);
        if ($data['id'] && !empty($_POST)) {
//            $data['password'] = $_POST['password'];
//            $repassword = $_POST['repassword'];
//            if ($repassword == $data['password']) {
            $model->group_id = Mod::app()->request->getParam('group_id');
//                $data['source'] = Tool::random_keys(5);//随机生成5位字符串
//                $data['password'] = Tool::md5str($data['password'], $data['source']);
            $model->status = Mod::app()->request->getParam('status');
            $model->remark = Mod::app()->request->getParam('remark');
            $model->lastlogintime= time();
            $model->lastloginip = Tool::get_ip();
//                $model->attributes = $data;
//                var_dump($data);exit;
                if ($model->save()) {
                    $target_url = $this->createUrl('/' . $this->getModule()->getId() . '/member/edit/id/' . $data['id']);
                    $this->admin_message('编辑成功', $target_url);
                    exit();
                }
//            } else {
//                $target_url = $this->createUrl('/' . $this->getModule()->getId() . '/member/add');
//                $this->admin_message('两次密码不一致', $target_url);
//                exit();
//            }
            exit();
        }

//              会员分组信息
        $group_model = new Membergroup();
        $group = $group_model->findAll("status = 1");

        $this->render('member_edit', array('model' => $model, 'group' => $group, 'fun' => 'edit'));

    }

    public function actionDel()
    {
        $this->check_permission(__CLASS__, 'del');
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
//            file_put_contents('/text.txt', var_export($id_arr, 1));
        if (in_array(1, $id_arr)) {
            $mess = '删除失败！超级分组不允许被删除！';
            $state = 0;
        } else {
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Member;
                $res = $model->deleteAll('id IN(' . $id_str . ') and admin=0');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

    public function actionpclists()
    {

        $this->check_permission(__CLASS__, 'lists');
        //会员分组信息
        $group_model = new Membergroup();
        $group = $group_model->findAll("status = 1");

        $group_id = Mod::app()->request->getParam('group_id');

        $model = new Member();
        $criteria = new CDbCriteria();

        if ($_POST['phone']) {
            $phone = Tool::getValidParam('phone', 'string');
            $criteria->condition = "t.phone=$phone";
        }
        $status = Tool::getValidParam('status', 'integer');
        //筛选 审核状态
        if ($status == 2) {
            $criteria->condition = "t.status=0 AND t.pstatus=1";
        } elseif ($status == 1) {
            $criteria->condition = "t.status=1 AND t.pstatus=1";
        }


        $criteria->addCondition("t.pstatus=1");
        $criteria->order = 't.id DESC';
        $criteria->with = 'Membergroup';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('pcmember', array('datalist' => $result, 'group' => $group,'phone'=>$phone, 'pagebar' => $pages));
    }


    /*
* ajax审核方法*/
    public function actionaudit()
    {
        $data = "";
        if (Mod::app()->request->isPostRequest) {
            $id = intval(Mod::app()->request->getParam('id'));
            $model = Member::model()->findbypk($id);
            if ($model) {
                $data['status'] = 1;
                $data['pstatus'] = 1;
                $sql = "UPDATE `dym_member` SET `pstatus`='1',`status`='1' WHERE (`id`=$id)";
                $re = Mod::app()->db->createCommand($sql)->execute();
                if ($re) {
                    echo 1;
                    exit;
                } else {
                    echo 0;
                    exit;
                }
            } else {
                echo 0;
                exit;
            }
        }
    }

    /*用户来源列表*/
    public function actionfromlists()
    {
        $phone = Tool::getValidParam("phone", "string");
        $startdate = Tool::getValidParam("startdate", "string");
        $enddate = Tool::getValidParam("enddate", "string");
        $activity = trim(Tool::getValidParam("activity", "string"));
        //关联member  member_activity
        if ($startdate && $enddate && !$activity) {
            echo "<script>alert('组件不能是空')</script>";
            exit;
        }
        $startdate = strtotime($startdate);
        $enddate = strtotime($enddate);

        $Member_activity_model = new Member_activity();
        if ($phone) {//表示有根据手机号搜素
            $where = "Member.phone=:phone";
            $params = array(':phone' => $phone);
        } else if ($activity && $startdate && $enddate) {
            $where = "t.model=:model AND t.createtime>:start AND t.createtime<:end";
            $params = array(':start' => $startdate, ':end' => $enddate, ':model' => $activity);
        } else if ($activity) {
            $where = "t.model=:model";
            $params = array(':model' => $activity);
        } else {
            $where = "";
            $params = array();
        }
        $member = $Member_activity_model->getMemberListPager($where, $params);

        //组件列表
        $sql = "SELECT * FROM {{activity}} WHERE status=1";
        $info = Mod::app()->db->createCommand($sql)->queryAll();

        $parameter = array(
            "datalist" => $member,
            "activity" => $info,
            "phone"=>$phone,
            "startdate"=>$startdate,
            "enddate"=>$enddate,
            "select"=>$activity,
        );
        $this->render('fromlist', $parameter);
    }


}

