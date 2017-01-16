<?php

class ArticleController extends FrontController {

    public function actionView() {
        $id = Tool::getValidParam('id','integer');
        $page = Tool::getValidParam('page','integer');
        if ($id) {
            $article_model = Article::model()->find("id ='" . $id. "' and lang ='" . $this->lang . "'");
            if(!empty($article_model)){
                     $data['view'] = $article_model->attributes;
                     $category_model = Category::model()->find("id ='" . $data['view']['category_id'] . "' and lang ='" . $this->lang . "'"); 
                     $data['category'] = $category_model->attributes;
                     $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
            }else{
                 $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }
        
        $data['category_parent'] = JkCms::getCategoryparentByid($data['category']['id']);
         
        //文章分页
        $data['view']['content'] = explode('<hr style="page-break-after:always;" class="ke-pagebreak" />', $data['view']['content']);
        $count = count($data['view']['content']);
        $page = $page?($page-1):0;
        if($page>$count){$this->redirect($this->createUrl('article/id/'.$id));}
        $pages = new CPagination($count);
        $pages->pageSize = 1;
        $pages->currentPage = $page;
        $data['view']['content'] = $data['view']['content'][$pages->currentPage];
        $data['view']['content']  = str_replace('{{site_path}}', $this->_siteUrl, $data['view']['content'] );
        $data['pagebar'] = $pages;
        
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $data['view']['title'].'-'.$data['category']['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $data['view']['title'].'-'.$data['category']['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $data['view']['title'].'-'.$data['category']['description']?$data['category']['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => "协和西院", 'url' =>""),
            array('name' =>  $data['category_parent']['name'], 'url' =>""),
        );
        if($data['category_parent']['id'] != $data['category']['id']){
            $position_arr[] =  array('name' =>  $data['category']['name'], 'url' => $this->createUrl( $data['category']['alias']), 'now' => true);
        }
        $data['position'] = $position_arr;
        //end我的位置
        
        
        $tpl = $data['category']['tpl_detail']?$data['category']['tpl_detail']:'/article/detail';
//        echo $tpl;
        $this->render($tpl,$data);
        
    }
    


 
}
