<?php

class DutyorderController extends AController {

    public function init()  {      
        parent::init();     
    }  
    
    public function actionIndex() {
        $this->actionDutyorder();
    }
    
    public function actionDutyorder() {
             $this->check_permission(__CLASS__, __FUNCTION__);
             $data['id'] = Mod::app()->request->getParam('id', 1);//request
             $sql ="select * from {{dutyorder}} where id=".$data['id'];
             $result = Mod::app()->db->createCommand($sql)->queryRow();   
             $data['duty'] = unserialize($result['value']);
             $this->renderPartial('dutyorder',$data);
    }
    
     public function actionDosubmit() {
       
         if($_POST['duty'] && $_POST['id']){
            Mod::app()->db->createCommand()->update('{{dutyorder}}',array('value'=>serialize($_POST['duty'])),'id = '.intval($_POST['id']));   
            $target_url = $this->createUrl('/admin/dutyorder/dutyorder');
            $this->admin_message('排班成功', $target_url);
            exit();
         }
                    
 
         
     }
    
}

