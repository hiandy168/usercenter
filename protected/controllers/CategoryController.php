<?php

class CategoryController extends FrontController {

    public function actionIndex() {
        if (isset($_GET['alias']) && $_GET['alias']) {
            $this->alias = Tool::getValidParam('alias');
            $thiscategory_model = Category::model()->find("alias ='" . trim($this->alias) . "' and lang ='" . $this->lang . "'");
            if(!empty($thiscategory_model)){
                switch ($thiscategory_model->model) {
                    case 'article':
                        $this->articleList($thiscategory_model->attributes);
                        break;
                    case 'pic':
                        $this->picList($thiscategory_model->attributes);
                        break;
                    case 'ask':
                        $this->askList($thiscategory_model->attributes);
                        break;
                    default:
                        $this->redirect($this->_siteUrl);
                }
            }else{
                 $this->redirect($this->_siteUrl);
            }
           
        } else {
            $this->redirect($this->_siteUrl);
        }
    }

    private function articlelist($thiscategory) {
  
        $model = new Article();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1 and web=1 ";
        $child_category_model = Category::model()->findAll("fid ='" . trim($thiscategory['id']) . "' and lang ='" . $this->lang . "'");
        $child_id_arr =  array();

        $id_arr = array($thiscategory['id']);
        foreach($child_category_model as $c){
            $child_id_arr[] = $c->id;
        }
        if(!empty($child_id_arr)){
            $id_arr = array_merge(array($thiscategory['id']),$child_id_arr);
        }


        $criteria->addCondition("t.category_id in(".implode(',', $id_arr).")");
        $criteria->order =  't.`top` desc,t.`order` desc,t.`createtime` desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = $thiscategory['pagesize'];
        $pages->currentPage = intval(isset($_GET['page']))?(intval($_GET['page'])-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $thiscategory['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $thiscategory['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $thiscategory['description']?$thiscategory['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        
        $data['category'] = $thiscategory;
        $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
        
        
        $data['category_parent'] = JkCms::getCategoryparentByid($thiscategory['id']);
        //start我的位置
        $position_arr = array(
            array('name' => "协和西院", 'url' =>""),
            array('name' =>  $data['category_parent']['name'], 'url' =>""),
            array('name' => $thiscategory['name'], 'url' => $this->createUrl($thiscategory['alias']), 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
       
        $tpl = $thiscategory['tpl_list']?$thiscategory['tpl_list']:'/article/list';

//        var_dump
//        echo $tpl;
        $this->render($tpl,$data);
    }
    
     private function piclist($thiscategory) {
        $model = new Pic();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1";
        $child_category_model = Category::model()->findAll("fid ='" . trim($thiscategory['id']) . "' and lang ='" . $this->lang . "'");
        $child_id_arr =  array();

        $id_arr = array($thiscategory['id']);
        foreach($child_category_model as $c){
            $child_id_arr[] = $c->id;
        }
        if(!empty($child_id_arr)){
            $id_arr = array_merge(array($thiscategory['id']),$child_id_arr);
        }


        $criteria->addCondition("t.category_id in(".implode(',', $id_arr).")");
        $criteria->order = 't.order DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = $thiscategory['pagesize'];
        $pages->currentPage = isset($_GET['page'])?($_GET['page']-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $thiscategory['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $thiscategory['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $thiscategory['description']?$thiscategory['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        
        $data['category'] = $thiscategory;
        $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
        
        //start我的位置
        $position_arr = array(
            array('name' => $thiscategory['name'], 'url' => $this->createUrl($thiscategory['alias']), 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        $tpl = $thiscategory['tpl_list']?$thiscategory['tpl_list']:'/pic/list';
        $this->render($tpl,$data);
    }
    
    
    private function asklist($thiscategory) {
  
        
        $model = new Ask();
        $criteria = new CDbCriteria();
        $criteria->condition = "status =1";
      
        $child_id_arr =  array();

        $criteria->order = 't.listorder DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = $thiscategory['pagesize'];
        $pages->currentPage = isset($_GET['page'])?($_GET['page']-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $thiscategory['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $thiscategory['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $thiscategory['description']?$thiscategory['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        
        $data['category'] = $thiscategory;
        $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
        
        
        $data['category_parent'] = JkCms::getCategoryparentByid($thiscategory['id']);
        //start我的位置
        $position_arr = array(
            array('name' => "协和西院", 'url' =>""),
            array('name' =>  $data['category_parent']['name'], 'url' =>""),
            array('name' => $thiscategory['name'], 'url' => $this->createUrl($thiscategory['alias']), 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
       
        $tpl = $thiscategory['tpl_list']?$thiscategory['tpl_list']:'/ask/list';

//        var_dump
//        echo $tpl;
        $this->render($tpl,$data);
    }
    
    

}
