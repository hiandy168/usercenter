<?php

class WikiController extends FrontController {
    
    public function actionIndex() {

        $model=Article::model();
        $result=$model->findAll();
        $as_list = $model->getArticleListPager();
        //var_dump($as_list['pagebar']);
        $config['site_title'] = '大楚用户开放平台首页-文档资料';
        $config['Keywords'] = '大楚用户开放平台首页,文章列表,文档资料';
        $config['Description'] = '大楚用户开放平台首页';
        $config['active'] = 'wendangziliao';
        $this->render('index',array('list'=>$result,'pagebar'=>$as_list['pagebar'],'config'=>$config));
    }

    public function actionArticle() {
        $id=intval($_GET['id']);
        $model=Article::model();
        $result=$model->findByPk($id);
     //   var_dump($result);
       $tags= Tags::model()->findBypk($result->tags);
        $this->render('article',array('list'=>$result,'tags'=>$tags,'config'=>$config));
    }

    public function actionhelp() {
        $id=intval($_GET['id']);
//        $model=Article::model();
//        $result=$model->findByPk($id);
//        $tags= Tags::model()->findBypk($result->tags);
        $data['config']['active'] = 'bangzhuzhongxin';

        $data['config'] = $this->site_config;
        $data['config']['site_title'] = "大楚用户开放平台首页-帮助中心";
        $data['config']['site_keywords'] = "大楚用户开放平台首页-帮助中心";
        $data['config']['site_description'] ='大楚用户开放平台首页-帮助中心' ;
        /*   $data['config']['site_title'] = "帮助中心,".$this->site_config['site_title'];
        $data['config']['site_keywords'] = "帮助中心,".$this->site_config['site_keywords'];
        $data['config']['site_description'] ='帮助中心,'.$this->site_config['site_description'] ;*/
        
        $this->render('help',$data);
    }


}