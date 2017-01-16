<?php
class MessageController extends FrontController {
	public function actionIndex() {
		if(Mod::app()->request->isPostRequest){
                                $data=array();
                                $data['type'] = Tool::getValidParam('type','string');
                                $data['title'] = Tool::getValidParam('title','string');
                                $data['content'] = Tool::getValidParam('content','string');
                                $data['createtime'] = time();
                                $data['send_id'] = $this->member['id'];
                                $data['receive_id'] = 1;
                                $data['status'] = 1;
                                Mod::app()->db->createCommand()->insert('{{message}}', $data);
                                echo json_encode(array('state' => 1, 'mess' => '发送成功'));exit;
                }
                   echo json_encode(array('state' => 1, 'mess' => '发送失败'));
	}



    
    
    public function actionSendnotedel() {   
        $id_str = Tool::getValidParam('id','integer');
        $id_arr = explode(',', $id_str);
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Message();
                $res = $model->updateAll(array('send_del' => 1), 'type="note" and id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }else{
                $mess = '删除失败！';
                $state = 0;
            }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }
    
    
    public function actionIs_read() {
        $id_str = Tool::getValidParam('id','integer');
        $id_arr = explode(',', $id_str);
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Message();
                  $res = $model->updateAll(array('is_read' => 1), ' id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '标记为已读成功！';
                    $state = 1;
                } else {
                    $mess = '标记为已读失败！';
                    $state = 0;
                }
            }else{
                $mess = '标记为已读失败！';
                $state = 0;
            }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }
    
    public  function actionDel()
    {
        $id = Tool::getValidParam('id','integer');
        if(!$id){
            $data = array('state'=>0,'mess'=>'数据错误');
            exit(json_encode($data));
        }
        $re=Member_message::model()->findByPk($id);
        if(!$re){
            $data = array('state'=>0,'mess'=>'数据错误');
            exit(json_encode($data));
        }
        $res = Member_message::model()->deleteByPk($id);
        if($res){
            $data = array('state'=>1,'mess'=>'删除成功');
        }else{
            $data = array('state'=>0,'mess'=>'删除失败');
        }
        exit(json_encode($data));
    }
        
}