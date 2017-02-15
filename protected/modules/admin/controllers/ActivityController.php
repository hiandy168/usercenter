<?php

/**
 *
 * @author yu
 * 积分管理系统的控制器
 */
class ActivityController extends AController
{

    //活动管理列表
    public function actionList()
    {
        $projectid = Tool::getValidParam('project', 'integer');
        $activityid = Tool::getValidParam('activity', 'integer');
        $title = Tool::getValidParam('title', 'string');
        $id = $activityid == 0 ? 2 : $activityid;
        //名称，控制器方法，表名

        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            //    3 => array("报名", "signup", "signup"),
            4 => array("投票", "vote", "vote"),
            5 => array("大转盘", "bigwheel", "bigwheel"),
            6 => array("海报", "poster", "poster"),


        );
        $where = ' 1=1 ';
        if ($projectid) {
            $where .= ' and pid=' . $projectid;
        }
        if ($title) {
            $where .= ' and title like "%' . $title . '%"';
        }
        switch ($id) {
            case 1:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_pccheckin')->where($where)->order("id desc")->queryAll();
                break;
//            case 3:
//                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_signup')->where($where)->queryAll();
//                break;
            case 4:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_vote')->where($where)->order("id desc")->queryAll();
                break;
            case 5:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_bigwheel')->where($where)->order("id desc")->queryAll();
                break;
            case 6:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_poster')->where($where)->order("id desc")->queryAll();
                break;
            default:
                $res = Mod::app()->db->createCommand()->select('id,pid,prize_id,title,start_time,end_time,win_num,day_count,share_num,share_add_num,win_msg,rule,lingjiang,end_num_msg,end_msg,jishu,share_img as img,banner_img,bg_img,scratch_img,myprize_img,status,add_time')->from('dym_activity_scratch')->where($where)->order("id desc")->queryAll();
                break;
        }

        foreach ($res as $k => $v) {
            $reco = Mod::app()->db->createCommand()->select('*')->from('dym_activity_recommend')->where('aid=' . $v['id'] . ' AND type=' . $id)->queryRow();
            if ($reco) {
                $res[$k]['status'] = $reco['status'];
                $res[$k]['rid'] = $reco['id'];
            } else {
                $res[$k]['status'] = 0;
            }
            $pro = Project::model()->findByPk($v['pid']);
            if ($pro) {
                $res[$k]['project'] = $pro->name;
            }
        }
        //项目列表
        $project = Project::model()->findAll("status>0");
        $this->render('list', array('datalist' => $res, 'title' => $title, 'id' => $id, 'type_id' => $type[$id], 'project' => $project, 'projectid' => $projectid));
    }


    public function actionRecommendedList()
    {
        //名称，控制器方法，表名
        $type = array(
            1 => array("签到", "pccheckin", "pccheckin"),
            2 => array("刮刮卡", "scratchcard", "scratch"),
            //   3=>array("报名","signup","signup"),
            4 => array("投票", "vote", "vote"),
            5 => array("大转盘", "bigwheel", "bigwheel"),
            6 => array("海报", "poster", "poster"),

        );
        $projectid = Tool::getValidParam('project', 'integer');
        $activityid = Tool::getValidParam('activity', 'integer');
        $title = Tool::getValidParam('title', 'string');
        $where="status=1";
        if ($title) {
            $where.= ' and title like "%' . $title . '%"';
        }
        if ($projectid) {
            $project = Project::model()->findByPk($projectid);
            if ($project) {
                $where.= ' and pid=' . $projectid;
            }
        }
        if ($activityid) {
            $where.=' and type=' . $activityid;
        }

        $list = Mod::app()->db->createCommand()->select('*')->from('dym_activity_recommend')->where($where)->order("id desc")->queryAll();

        foreach ($list as $k => $v) {
            $list[$k]['type'] = $type[$v['type']];
            $pro = Mod::app()->db->createCommand()->select('*')->from('dym_project')->where('id=' . $v['pid'])->queryRow();
            if ($pro) {
                $list[$k]['project'] = $pro['name'];
            }
        }

        $project = Project::model()->findAll("status>:status", array(":status" => 0));

        $parameter = array(
            'list' => $list,
            'project' => $project,
            "projectid" => $projectid,
            "activityid" => $activityid,
            "title" => $title,
        );
        $this->render('RecommendedList', $parameter);

    }
    //添加接口列表展示图片
    public function actionListimg(){
        if (Mod::app()->request->isPostRequest) {
            $image=Tool::getValidParam('image','string');
            $id=Tool::getValidParam('id','integer');
            if(!$image|| !$id ){
                echo 0;
                exit;
            }
            $res=Activity_recommend::model()->updateByPk($id,array("listimg"=>$image));
            if($res){
                echo "ok";
                exit;
            }else{
                echo 0;
                exit;
            }
        }else{
            echo "非法请求";
            exit;
        }
    }

    //活动推荐
    public function actionRecommende()
    {
        $aid = intval($_GET['aid']);//h活动组件id， //    2刮刮卡  1签到  3报名
        $id = intval($_GET['id']);//活动id
        $isstar = intval($_GET['isstar']);//是否推荐
        $model = new Activity();
        if (!$id) {
            echo 'error id null';
            exit;
        }
        $aid = $aid == 0 ? 2 : $aid;
        switch ($aid) {
            case 1:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_pccheckin')->where('id=' . $id)->queryRow();
                break;
            /* case 3:
                 $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_signup')->where('id=' . $id)->queryRow();
                 break;*/
            case 4:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_vote')->where('id=' . $id)->queryRow();
                break;
            case 5:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_bigwheel')->where('id=' . $id)->queryRow();
                break;
            case 6:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_poster')->where('id=' . $id)->queryRow();
                break;
            default:
                $res = Mod::app()->db->createCommand()->select('*')->from('dym_activity_scratch')->where('id=' . $id)->queryRow();
                break;
        }
        //表示取消推荐
        if ($isstar == 2) {
            // $sql='UPDATE dym_activity_recommend SET status='.$isstar.' , updatetime='.time().' WHERE aid ='. $id .' AND type='.$aid.' AND status=1';
            $sql = 'DELETE  FROM dym_activity_recommend WHERE id =' . $id . ' AND status=1';
            $results = Mod::app()->db->createCommand($sql)->execute();
            if ($results) {
                echo 2;
                exit;
            } else {
                echo 3;
                exit;
            }
        }

        if ($res) {
            $refults = $model->find(array('condition' => 'aid=:aid AND type=:type AND status=:status',
                'params' => array(':aid' => $id, ':type' => $aid, ':status' => 1)));
            if ($refults) {
                echo 'error yse';
                exit;
            }
            $image = isset($res['img']) ? $res['img'] : $res['share_img'];

            $model->type = $aid;
            $model->aid = Mod::app()->request->getParam('id');
            $model->pid = $res['pid'];
            $model->title = isset($res['title']) ? $res['title'] : '默认标题';
            $model->describe = isset($res['desc']) ? $res['desc'] : '无';
            $model->image = $image;
            $model->start_time = $res['start_time'] > 0 ? $res['start_time'] : time();
            $model->end_time = $res['end_time'] > 0 ? $res['end_time'] : time();
            $model->createtime = time();
            $model->updatetime = time();
            $model->status = $isstar;

            $results = $model->save();
            if ($results) {
                echo 'ok';
                exit;
            } else {
                echo 'error 插入失败';
                exit;
            }
        } else {
            echo 'error 没有活动';
            exit;
        }

    }


    public function actionActivityList()
    {

        //组件表
        $activity = Mod::app()->db->createCommand()->select('*')->from('dym_activity')->queryAll();

        $this->render('activitylist', array('list' => $activity));
    }

    //编辑
    public function actionActivityEdit()
    {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM dym_activity WHERE id=$id";


        $result = Mod::app()->db->createCommand($sql)->queryRow();
        //组件分类表
        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
        $this->render('addactivity', array('result' => $result, 'model' => $this->tree($activity_class)));
    }

    public function actionAddactivity()
    {
        if (Mod::app()->request->isPostRequest) {
            $activity_name = Tool::getValidParam('activity_name', 'string');
            $activity_table_name = Tool::getValidParam('activity_table_name', 'string');
            $id = Tool::getValidParam('id', 'integer');
            $see_status = Tool::getValidParam('see_status', 'integer');
            $status = Tool::getValidParam('status', 'integer');
            $activity_img = trim(Tool::getValidParam('activity_img', 'string'));
            $activity_nouse_img = trim(Tool::getValidParam('activity_nouse_img', 'string'));
            $cid = Tool::getValidParam('cid', 'integer');
            if ($id) {
                $data = array(
                    'activity_name' => $activity_name,
                    'activity_table_name' => $activity_table_name,
                    'status' => $status,
                    'see_status' => $see_status,
                    'activity_img' => $activity_img,
                    'activity_nouse_img' => $activity_nouse_img,
                    'update_time' => time(),
                    'id' => $id,
                    'cid' => $cid
                );

                $sql = "SELECT * FROM dym_activity  WHERE activity_name='" . $activity_name . "' and activity_table_name='" . $activity_table_name . "' and id !=" . $id;
                $res_check = Mod::app()->db->createCommand($sql)->queryRow();
                if ($res_check) {
                    $target_url = $this->createUrl('activity/addclass');
                    $this->admin_message('编辑失败,标识 ' . $activity_name . ' 已经添加过', $target_url);
                }
                $where = array(':id' => $id);
                $res = Mod::app()->db->createCommand()->update('dym_activity', $data, 'id=:id', $where);
                if ($res) {
                    $target_url = $this->createUrl('activity/ActivityList');
                    $this->admin_message('编辑成功', $target_url);
                } else {
                    $target_url = $this->createUrl('activity/Addactivity');
                    $this->admin_message('编辑失败', $target_url);
                }
            } else {
                $data = array(
                    'activity_name' => $activity_name,
                    'activity_table_name' => $activity_table_name,
                    'see_status' => $see_status,
                    'activity_img' => $activity_img,
                    'activity_nouse_img' => $activity_nouse_img,
                    'update_time' => time(),
                    'create_time' => time(),
                    'cid' => $cid
                );

                $sql = "SELECT * FROM dym_activity  WHERE activity_name='" . $activity_name . "' and activity_table_name='" . $activity_table_name . "'";
                $res_check = Mod::app()->db->createCommand($sql)->queryRow();
                if ($res_check) {
                    $target_url = $this->createUrl('activity/addclass');
                    $this->admin_message('添加失败,标识 ' . $activity_name . ' 已经添加过', $target_url);
                }
                $res = Mod::app()->db->createCommand()->insert('dym_activity', $data);
                if ($res) {
                    $target_url = $this->createUrl('activity/ActivityList');
                    $this->admin_message('添加成功', $target_url);
                } else {
                    $target_url = $this->createUrl('activity/Addactivity');
                    $this->admin_message('添加失败', $target_url);
                }
            }

        }

        //组件分类表
        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
        $this->render('addactivity', array('model' => $this->tree($activity_class)));
    }

    public function actionClassManager()
    {

        $activity_id_arr = array();
        $cid = "";
        if (isset($_GET['cid'])) {
            $cid = intval($_GET['cid']);
            $sql = "SELECT * FROM dym_activity_relation WHERE cid=" . $cid;
            $show_relation = Mod::app()->db->createCommand($sql)->queryRow();
            if ($show_relation) {
                $activity_id_arr = explode(",", $show_relation['activity_id']);
            }
        }
        if (Mod::app()->request->isPostRequest) {
            $cid = Tool::getValidParam('cid', 'integer');
            if (is_array($_POST['activity_id'])) {
                $activity_id = implode(",", $_POST['activity_id']);
            } else {
                $activity_id = $_POST['activity_id'];
            }
            $data = array(
                'activity_id' => $activity_id,
                'create_time' => time(),
                'update_time' => time(),
                'cid' => $cid
            );
            $sql = "SELECT * FROM dym_activity_relation WHERE cid=" . $cid;
            $res_check = Mod::app()->db->createCommand($sql)->queryRow();
            if ($res_check) {
                $where = array(':cid' => $cid);
                $res = Mod::app()->db->createCommand()->update('dym_activity_relation', $data, 'cid=:cid', $where);
                $name = '编辑';
            } else {
                $res = Mod::app()->db->createCommand()->insert('dym_activity_relation', $data);
                $name = '添加';
            }
            if ($res) {
                $target_url = $this->createUrl('activity/ClassManager');
                $this->admin_message($name . '成功', $target_url);
            } else {
                $target_url = $this->createUrl('activity');
                $this->admin_message($name . '失败', $target_url);
            }
        }
        //组件分类表
        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
        //项目列表
        $activity = Mod::app()->db->createCommand()->select('*')->from('dym_activity')->queryAll();


        $this->render('classmanager', array('model' => $this->tree($activity_class), 'activity' => $activity, 'relation' => $activity_id_arr, 'cid' => $cid));
    }

    public function actionProjectManager()
    {
        $activity_id = intval($_GET['activity_id']);
        $res = "";
        $pid = "";
        if (isset($_GET['pid'])) {
            $pid = intval($_GET['pid']);
            $sql = "SELECT * FROM dym_activity_project_relation WHERE  activity_id=" . $activity_id . " and pid=" . $pid;
            $res = Mod::app()->db->createCommand($sql)->queryRow();
        }
        if (Mod::app()->request->isPostRequest) {
            $pid = Tool::getValidParam('pid', 'integer');
            $status = Tool::getValidParam('status', 'integer');
            $data = array(
                'activity_id' => $activity_id,
                'create_time' => time(),
                'update_time' => time(),
                'status' => $status,
                'pid' => $pid
            );
            $sql = "SELECT * FROM dym_activity_project_relation WHERE activity_id=" . $activity_id . " and pid=" . $pid;
            $res_check = Mod::app()->db->createCommand($sql)->queryRow();
            if ($res_check) {
                $where = array(':cid' => $pid);
                $res = Mod::app()->db->createCommand()->update('dym_activity_project_relation', $data, 'pid=:pid', $where);
                $name = '编辑';
            } else {
                $res = Mod::app()->db->createCommand()->insert('dym_activity_project_relation', $data);
                $name = '添加';
            }
            if ($res) {
                $target_url = $this->createUrl('activity/ProjectManager', array('activity_id' => $activity_id));
                $this->admin_message($name . '成功', $target_url);
            } else {
                $target_url = $this->createUrl('activity');
                $this->admin_message($name . '失败', $target_url);
            }
        }
        //项目列表
        $project = Mod::app()->db->createCommand()->select('*')->from('dym_project')->queryAll();

        $this->render('projectmanager', array('project' => $project, 'activity_id' => $activity_id, 'result' => $res, 'pid' => $pid));

    }


    public function actionClassajax()
    {
        $cid = intval($_POST['cid']);
        $sql = "SELECT * FROM dym_activity_relation WHERE cid=" . $cid;
        $res_check = Mod::app()->db->createCommand($sql)->queryRow();
        echo json_encode($res_check);

    }

    public function actionClassList()
    {
        //项目列表
        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();

        $this->render('classlist', array('list' => $this->tree($activity_class)));
    }

    //编辑
    public function actionClassEdit()
    {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM dym_activity_class WHERE id=$id";

        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();
        $result = Mod::app()->db->createCommand($sql)->queryRow();

        $this->render('addclass', array('model' => $this->tree($activity_class), 'result' => $result));
    }

    //添加分类
    public function actionAddClass()
    {
        if (Mod::app()->request->isPostRequest) {
            $class_name = Tool::getValidParam('class_name', 'string');
            $id = Tool::getValidParam('id', 'integer');
            $pid = Tool::getValidParam('parent_id', 'integer');
            $class_logo = Tool::getValidParam('class_logo', 'string');

            if ($id) {
                $data = array(
                    'class_name' => $class_name,
                    'class_logo' => $class_logo,
                    'update_time' => time(),
                    'parent_id' => $pid
                );
//                if ($pid) {
//                    $sql = "SELECT * FROM dym_activity_class WHERE id=$pid";
//                    $par_result=Mod::app()->db->createCommand($sql)->queryRow();
//                    $p_path=$par_result['p_path'];
//                }
//                $data['p_path']=$p_path?$p_path.$pid.',':',';
                $sql = "SELECT * FROM dym_activity_class WHERE class_name='" . $class_name . "' and id!=" . $id;
                $res_check = Mod::app()->db->createCommand($sql)->queryRow();
                if ($res_check) {
                    $target_url = $this->createUrl('activity/addclass');
                    $this->admin_message('添加失败,标识 ' . $class_name . ' 已经添加过', $target_url);
                }
                $where = array(':id' => $id);
                $res = Mod::app()->db->createCommand()->update('dym_activity_class', $data, 'id=:id', $where);
                if ($res) {
                    $target_url = $this->createUrl('activity/classlist');
                    $this->admin_message('编辑成功', $target_url);
                } else {
                    $target_url = $this->createUrl('activity/ClassEdit', array('id' => $id));
                    $this->admin_message('编辑失败', $target_url);
                }
            } else {
                $data = array(
                    'class_name' => $class_name,
                    'class_logo' => $class_logo,
                    'create_time' => time(),
                    'update_time' => time(),
                    'parent_id' => $pid
                );
//                if ($pid) {
//                    $sql = "SELECT * FROM dym_activity_class WHERE id=$pid";
//                    $par_result=Mod::app()->db->createCommand($sql)->queryRow();
//                    $p_path=$par_result['p_path'];
//                }
//                $data['p_path']=$p_path?$p_path.$pid.',':',';
                $sql = "SELECT * FROM dym_activity_class WHERE class_name='" . $class_name . "' and parent_id=$pid";
                $res_check = Mod::app()->db->createCommand($sql)->queryRow();
                if ($res_check) {
                    $target_url = $this->createUrl('activity/addclass');
                    $this->admin_message('添加失败,标识 ' . $class_name . ' 已经添加过', $target_url);
                }
                $res = Mod::app()->db->createCommand()->insert('dym_activity_class', $data);
                if ($res) {
                    $target_url = $this->createUrl('activity/classlist');
                    $this->admin_message('添加成功', $target_url);
                } else {
                    $target_url = $this->createUrl('activity/addclass');
                    $this->admin_message('添加失败', $target_url);
                }
            }

        }
        $activity_class = Mod::app()->db->createCommand()->select('*')->from('dym_activity_class')->queryAll();


        $this->render('addclass', array('model' => $this->tree($activity_class)));
    }

    /**
     * @abstract活动组件-》标签管理-》 应用分类
     * @author fancy
     */
    public function actionAlctionClass()
    {
        $application_class = Application_class::model();
        $criteria = new CDbCriteria();
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $returnData['typeList'] = $application_class->findAll($criteria);
        $returnData['pages'] = $pages;
        $this->render('alctionclass', $returnData);
    }

    /**
     * @abstract活动组件-》标签管理-》 添加(修改)应用分类
     * @author fancy
     */
    public function actionAddAlctionClass()
    {
        $request = Mod::app()->request;
        /* $name=trim($request->getParam('class_name'));
         $id=trim($request->getParam('id'));*/
        $name = Tool::getValidParam('class_name', 'string');
        $id = Tool::getValidParam('id', 'integer');
        $alctionclassModel = Application_class::model();
        if (!empty($id)) {
            $typeInfo = $alctionclassModel->findByPk($id);
        }
        if ($request->isPostRequest) {
            if (empty($id)) {
                $typeInfo = new Application_class();
                $typeInfo->createtime = time();
            }
            $typeInfo->name = $name;
            $typeInfo->updatetime = time();
            if ($typeInfo->validate()) {
                if (empty($id) && Application_class::model()->find('`name`=:name', array(':name' => $name))) {
                    $target_url = $this->createUrl('/admin/activity/addAlctionClass');
                    $this->admin_message('分类名已存在', $target_url);
                } elseif (!empty($id) && Application_class::model()->find('`name`=:name', array(':name' => $name))) {
                    $target_url = $this->createUrl('/admin/activity/addAlctionClass', array(id => $id));
                    $this->admin_message('分类名已存在或未做任何修改', $target_url);
                } else {
                    $typeInfo->save();
                    $target_url = $this->createUrl('/admin/activity/alctionClass');
                    $this->admin_message('操作成功', $target_url);
                }
            }
        }
        $typeInfos['typeInfo'] = $typeInfo;
        $this->render('addalctionclass', $typeInfos);
    }

    /**
     * @abstract活动组件-》标签管理-》 删除应用分类
     * @author fancy
     */
    public function actionDelAlctionClass()
    {
        /* $request = Mod::app()->request;
         $id = trim($request->getParam('id'));*/
        $id = Tool::getValidParam('id', 'integer');
        if ($id) {
            $alctionclassModel = Application_class::model();
            $alctionclassModel->deleteAll('`id`=:id', array(':id' => $id));
            $mess = '删除成功！';
            $state = 1;
        } else {
            $mess = '删除失败！';
            $state = 0;
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

    /**
     * @abstract活动组件-》标签管理-》标签列表
     * @author fancy
     */
    public function actionAlctionTag()
    {
        $application_class = Application_tag::model();
        $criteria = new CDbCriteria();
        $criteria->order = 't.classid asc';
        $count = $application_class->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 6;
        $pages->applyLimit($criteria);
        $returnData['typeList'] = $application_class->with('application_class')->findAll($criteria);
        $returnData['pages'] = $pages;
        $this->render('alctiontag', $returnData);
    }

    /**
     * @abstract活动组件-》标签管理-》添加(修改)标签
     * @author fancy
     */
    public function actionAddAlctionTag()
    {
        $request = Mod::app()->request;
        $name = Tool::getValidParam('class_name', 'string');
        $id = Tool::getValidParam('id', 'integer');
        $classid = trim($request->getParam('classid'));
        $applicationtagModel = Application_tag::model();
        if (!empty($id)) {
            $typeInfo = $applicationtagModel->findByPk($id);
        }
        $criteria = new CDbCriteria();
        $criteria->condition = 'name=:name AND classid=:classid';
        $criteria->params = array(':name' => $name, ':classid' => $classid);
        if ($request->isPostRequest) {
            if (empty($id)) {
                $typeInfo = new Application_tag();
                $typeInfo->createtime = time();
            }
            $typeInfo->name = $name;
            $typeInfo->classid = $classid;
            $typeInfo->updatetime = time();
            if ($typeInfo->validate()) {
                if (empty($id) && Application_tag::model()->find($criteria)) {
                    $target_url = $this->createUrl('/admin/activity/addAlctionTag');
                    $this->admin_message('分类名已存在', $target_url);
                } elseif (!empty($id) && Application_tag::model()->find($criteria)) {
                    $target_url = $this->createUrl('/admin/activity/addAlctionTag', array(id => $id));
                    $this->admin_message('分类名已存在或未做任何修改', $target_url);
                } else {
                    $typeInfo->save();
                    $target_url = $this->createUrl('/admin/activity/alctionTag');
                    $this->admin_message('操作成功', $target_url);
                }
            }
        }
        $sql = "SELECT * FROM {{application_class}} ";
        $re = Mod::app()->db->createCommand($sql)->queryAll();
        $returnData['typeList'] = $re;
        $returnData['typeInfo'] = $typeInfo;
        $this->render('addalctiontag', $returnData);
    }

    /**
     * @abstract活动组件-》标签管理-》删除标签
     * @author fancy
     */

    public function actionDelAlctionTag()
    {
        $id = Tool::getValidParam('id', 'integer');
        if ($id) {
            $alctionclassModel = Application_tag::model();
            $alctionclassModel->deleteAll('`id`=:id', array(':id' => $id));
            $mess = '删除成功！';
            $state = 1;
        } else {
            $mess = '删除失败！';
            $state = 0;
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
