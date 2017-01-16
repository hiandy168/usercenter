<?php
/**
 * 
 * @author yu
 * 积分管理系统的控制器
 */
class ManagementController extends AController {
    //积分管理列表
    public function actionList(){
        $res = Mod::app()->db->createCommand()->select('*')->from('dym_member_behavior_type')->queryAll();
        foreach($res as $key=>$val){
            if($val){
                $project = Mod::app()->db->createCommand()->select('*')->from('dym_project')->where('id='.$val['pid'])->queryRow();
                $res[$key]['project_name']=$project['name'];
            }else{
                $res[$key]['project_name']='';
            }
        }
        $this->render('list',array ('datalist' => $res));
    }
    //添加管理
    public function actionAdd(){
        if(Mod::app()->request->isPostRequest){
            $name = Tool::getValidParam('name','string');
            $score=  Mod::app()->request->getParam('point');
            $rule = Tool::getValidParam('rule','string');
            $mark = Tool::getValidParam('mark','string');
            $id   = Tool::getValidParam('id','integer');
            $pid  = Tool::getValidParam('pid','integer');
            if($id){
                $data =array(
                    'name'=>$name,
                    'pid'=>$pid,
                    'point'=>$score,
                    'rule' =>$rule,
                    'mark' =>$mark,
                    'update_time'=>time()
                );
                $sql = "SELECT * FROM dym_member_behavior_type WHERE mark='".$mark."' and pid = $pid and  id !=".$id;
                $res_check=Mod::app()->db->createCommand($sql)->queryRow();
                if($res_check){
                    $target_url = $this->createUrl('management/list',array('id'=>$id));
                    $this->admin_message('编辑失败,标识 '.$mark.' 已经添加过', $target_url);
                }
                $where = array(':id' => $id);
                $res = Mod::app()->db->createCommand()->update('dym_member_behavior_type',$data, 'id=:id', $where);
                if($res){
                    $target_url = $this->createUrl('management/list');
                    $this->admin_message('编辑成功', $target_url);
                }else{
                    $target_url = $this->createUrl('management/add',array('id'=>$id));
                    $this->admin_message('编辑失败', $target_url);
                }
            }else{
                $data =array(
                    'name'=>$name,
                    'point'=>$score,
                    'rule' =>$rule,
                    'mark' =>$mark,
                    'create_time'=>time(),
                    'update_time'=>time(),
                    'pid'=>$pid
                );
                $sql = "SELECT * FROM dym_member_behavior_type WHERE mark='".$mark."' and pid=$pid";
                $res_check=Mod::app()->db->createCommand($sql)->queryRow();
                if($res_check){
                    $target_url = $this->createUrl('management/add');
                    $this->admin_message('添加失败,标识 '.$mark.' 已经添加过', $target_url);
                }
                $res = Mod::app()->db->createCommand()->insert('dym_member_behavior_type', $data);  
                if($res){
                    $target_url = $this->createUrl('management/list');
                    $this->admin_message('添加成功', $target_url);
                }else{
                    $target_url = $this->createUrl('management/add');
                    $this->admin_message('添加失败', $target_url);
                }
            }
        }else{
            //查询数据库中的所有应用
            $res = Mod::app()->db->createCommand()->select('*')->from('dym_project')->queryAll();
            $param = array(
                'res'=>$res
            );
            $this->render('add',$param);
        }
    }
    //删除
    public function actionDel(){
        $id = Mod::app()->request->getParam('id');
        $res = Mod::app()->db->createCommand()->delete('dym_member_behavior_type', 'id IN('.$id.')');
      
        if($res){
            $mess = '删除成功！';
            $state = 1;
        }else{
            $mess = '删除失败！';
            $state = 0;
        }
        echo json_encode(array('state'=>$state,'mess'=>$mess));
    }
    //编辑
    public function actionEdit(){
        $id = Tool::getValidParam('id','integer');
        $sql = "SELECT * FROM dym_member_behavior_type WHERE id=$id";
        //查询数据库中的所有应用
        $res = Mod::app()->db->createCommand()->select('*')->from('dym_project')->queryAll();
        $result=Mod::app()->db->createCommand($sql)->queryRow();
        $param = array(
            'res'=>$res,
            'result'=>$result
        );
        $this->render('add',$param);
    }
    //积分记录
    public function actionJilu(){
        $criteria = new CDbCriteria();
        $model    = new Member_behavior();
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pager = new CPagination($count); //实例化分页类
        $pager->pageSize = 15; //每页显示条数
        $pager->applyLimit($criteria);
        $dataList = $model->findAll($criteria);
        foreach($dataList as $key=>$val){
            //根据用户id查询用户姓名
            $userid = $val->mid;
            $user = Mod::app()->db->createCommand()->select('*')->from('dym_member')->where('id='.$userid)->queryRow();
            $dataList[$key]->mid = $user['username'];
            //根据应用id查询应用名称
            $pid = $val->pid;
            $project = Mod::app()->db->createCommand()->select('*')->from('dym_project')->where('id='.$pid)->queryRow();
            $dataList[$key]->pid = $project['name'];
            //根据type查询用户的操作
            $type = $val->type;
            $project = Mod::app()->db->createCommand()->select('*')->from('dym_member_behavior_type')->where('id='.$type)->queryRow();
            $dataList[$key]->type = $project['name'];
            $dataList[$key]->point= $project['point'];
        }
        $assign = array (
            'datalist' => $dataList ,
            'pagebar' => $pager,
            'count'   =>$count
        );
        $this->render('jilu', $assign);
    }
    //删除积分记录
    public function actionDel_jilu(){
        $id = Mod::app()->request->getParam('id');
        $res = Mod::app()->db->createCommand()->delete('dym_member_behavior', 'id IN('.$id.')');
        
        if($res){
            $mess = '删除成功！';
            $state = 1;
        }else{
            $mess = '删除失败！';
            $state = 0;
        }
        echo json_encode(array('state'=>$state,'mess'=>$mess));
    }
}
