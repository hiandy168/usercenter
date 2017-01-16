<?php

class PageController extends FrontController {
    
    public function actionIndex() {
        $model = new Page();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1";
        $criteria->order = 't.order DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = 20;
        $pages->currentPage = isset($_GET['page'])?($_GET['page']-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = '单页列表'."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = '单页列表,'.$this->site_config['site_keywords'];
        $data['config']['site_description'] = '单页列表,'.$this->site_config['site_description'] ;
        
        
        
        //start我的位置
        $position_arr = array(
            array('name' => '单页列表', 'url' => $this->createUrl('/page'), 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        $tpl = '/page/list';
        $this->render($tpl,$data);
        
    }
      
    public function actionView() {
        $id = Tool::getValidParam('id','integer');
        $alias = Tool::getValidParam('alias','string');
        $page = Tool::getValidParam('page','integer');
        if ($id) {
           $page_model = Page::model()->find("id ='" . $id . "' and lang ='" . $this->lang . "'");
        }else if ($alias) {
           $page_model = Page::model()->find("alias ='" . trim($alias) . "' and lang ='" . $this->lang . "'");
        }else {
            $this->redirect($this->_siteUrl);
        }
        
        if( !empty( $page_model) && !$page_model){
            $this->redirect($this->_siteUrl);
        }

        $data['view'] = $page_model->attributes;
//        var_dump($data['view']);die;
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
        
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $page_model->title."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $page_model->title.",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $page_model->title.','.$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => $page_model->title, 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置

       
        $tpl = $page_model->tpl?$page_model->tpl:'/page/detail';
//        echo $tpl;die;
        $this->render($tpl,$data);
        
    }
    


 
}
