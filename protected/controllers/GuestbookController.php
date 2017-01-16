<?php

class GuestbookController extends FrontController {
    
    public function actionIndex() {
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "留言板-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = '留言板,'.$this->site_config['site_keywords'];
        $data['config']['site_description'] = '留言板,'.$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => '留言板', 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        $this->render('index',$data);   
    }
    


 
}
