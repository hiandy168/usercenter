<?php

class HelpController extends FrontController {
    
    public function actionIndex() {
         $this->actionlists();
       
    }

    private function actionlists() {
        $id = Tool::getValidParam('id','integer');
        $alias = Tool::getValidParam('alias','string');
        $page = Tool::getValidParam('page','integer');
        
        if ($alias) {
            $thiscategory_model = Category::model()->find("alias ='" . trim($alias) . "' and lang ='" . $this->lang . "'");
        }else if ($id) {
            $thiscategory_model = Category::model()->find("id ='" . $id . "' and lang ='" . $this->lang . "'");
        }

        $model = new Help();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1";
        if($thiscategory_model){
            $child_category_model = Category::model()->findAll("fid ='" . trim($thiscategory_model->id) . "' and lang ='" . $this->lang . "'");
            $child_id_arr =  array();
            $id_arr = array($thiscategory_model->id);
            foreach($child_category_model as $c){
                $child_id_arr[] = $c->id;
            }
            if(!empty($child_id_arr)){
                $id_arr = array_merge(array($thiscategory_model->id),$child_id_arr);
            }
            $criteria->addCondition("t.category_id in(".implode(',', $id_arr).")");
        }
        $criteria->order = 't.order DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = $thiscategory_model->pagesize;
        $pages->currentPage = $page?($page-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

        $data['config'] = $this->site_config;
        $data['config']['site_title'] = ($thiscategory_model->name?$thiscategory_model->name.'-帮助中心':'帮助中心')."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = ($thiscategory_model->name?$thiscategory_model->name.',帮助中心':'帮助中心').",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = ($thiscategory_model->description?$thiscategory_model->description.',帮助中心':'帮助中心').",".$data['category']['description']?$data['category']['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        
        $data['category'] = $thiscategory_model->attributes;
        $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
        
        //start我的位置
        if($data['category']['name']){
         $position_arr = array(
            array('name' => '帮助中心', 'url' => $this->createUrl('/help')),
            array('name' => $data['category']['name'], 'url' => $this->createUrl($data['category']['alias']?'help/'.$data['category']['alias']:'help')),
        );
        }else{ 
            $position_arr = array(
            array('name' => '帮助中心', 'url' => $this->createUrl('/help')),
            );
        }
        $data['position'] = $position_arr;
        //end我的位置
        $this->render('list',$data);
    }
      
    public function actionView() {
         $data['config'] = $this->site_config;
         
        $id = Tool::getValidParam('id','integer');
        $alias = Tool::getValidParam('alias','string');
        $page = Tool::getValidParam('page','integer');
        if ($id) {
           $data['view'] =  $page_model = Help::model()->find("id ='" . $id . "' ");
        }else if ($alias) {
           $data['view'] =  $page_model = Help::model()->find("alias ='" . trim($alias) . "' ");
        } 
        
        if(empty($data['view'])){
              $this->redirect($this->createUrl('error'));
        }
        
        //文章分页
        $data['view']['content'] = explode('<hr style="page-break-after:always;" class="ke-pagebreak" />', $page_model->content);
        $count = count($data['view']['content']);
        $page = $page?($page-1):0;
        if($page>$count){$this->redirect($this->createUrl('page/id/'.$page_model->id));}
        $pages = new CPagination($count);
        $pages->pageSize = 1;
        $pages->currentPage = $page;
        $data['view']['content'] = $data['view']['content'][$pages->currentPage];
        $data['view']['content']  = str_replace('{{site_path}}', $this->_siteUrl, $data['view']['content'] );
        $data['pagebar'] = $pages;
        
        $data['config']['site_title'] = $page_model->title."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $page_model->title.",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $page_model->title.','.$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => '帮助中心', 'url' => $this->createUrl('/help')),
            array('name' => $page_model->title, 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
       
      $tpl = $page_model->tpl?$page_model->tpl:'/help/detail';
//echo $tpl;
        $this->render($tpl,$data);
        
    }
    
    
  


 
}
