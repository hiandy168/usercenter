<?php

class AskController extends FrontController {

    public function actionIndex() {
        $model = new Ask();
        $criteria = new CDbCriteria();
        $criteria->condition = "status =1";
        $criteria->order = 't.listorder DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = 30;
        $pages->currentPage = intval(isset($_GET['page']))?(intval($_GET['page'])-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "健康问答-卫生科普-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = "健康问答,卫生科普".$this->site_config['site_keywords'];
        $data['config']['site_description'] = "健康问答,卫生科普,".$this->site_config['site_description'] ;
        
        
        
        $data['category_parent'] = JkCms::getCategoryparentByid(26);
//        var_dump( $data['category_parent']);
        //start我的位置
        $position_arr = array(
            array('name' => "协和西院", 'url' =>""),
            array('name' => "卫生科普", 'url' =>""),
            array('name' => "健康问答", 'url' =>"", 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
       

        $this->render('/ask/list',$data);
    }
   

}
