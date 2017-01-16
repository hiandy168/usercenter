<?php

class TagsController extends FrontController {


    public function actionIndex() {
        echo "开发中";exit;
        $tag = urldecode(base64_decode(Mod::app()->request->getQuery('tags', 0)));//get
        $id =  Tags::loadTagIds(trim($tag));
        $model = new Article();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1";
        $criteria->addCondition(" FIND_IN_SET('".$id."',tags)  ");
        $criteria->order = 't.order DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = 20;
        $pages->currentPage = isset($_GET['page'])?(intval($_GET['page'])-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = 'tags:'.$tag."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] ='tags:'.$tag.",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = 'tags:'.$tag.",".$this->site_config['site_description'] ;
        
        
       
        
        //start我的位置
        $position_arr = array(
            array('name' => 'Tags', 'url' =>'', 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        $tpl = '/common/articlelist';
        $this->render($tpl,$data);
    }

}
