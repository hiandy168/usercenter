<?php

class PicController extends FrontController {
    
    public function actionView() {
        if (isset($_GET['id']) && $_GET['id']) {
            $pic_model = Pic::model()->with('Pictures')->find("t.id ='" . trim(intval($_GET['id'])) . "' and t.lang ='" . $this->lang . "'");
            if(!empty($pic_model)){
                     $data['view'] = $pic_model->attributes;
                     foreach($pic_model->Pictures as $p){
                         $data['view']['pic_list'][$p->id] = $p->attributes;
                         $data['view']['pic_list'][$p->id]['picture'] = Tool::show_img($p->picture);
                     }unset($p);
                     $category_model = Category::model()->find("id ='" . $data['view']['category_id'] . "' and lang ='" . $this->lang . "'"); 
                     $data['category'] = $category_model->attributes;
                     $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
            }else{
                 $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }
               
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $data['view']['title'].'-'.$data['category']['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $data['view']['title'].'-'.$data['category']['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $data['view']['title'].'-'.$data['category']['description']?$data['category']['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => $data['category']['name'], 'url' => $this->createUrl($data['category']['alias'])),
            array('name' => $data['view']['title'], 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        
        $tpl = $data['category']['tpl_detail']?$data['category']['tpl_detail']:'/pic/detail';
        $this->render($tpl,$data);
        
    }
    


 
}
