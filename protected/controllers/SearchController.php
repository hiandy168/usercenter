<?php

class SearchController extends FrontController {
    
    public function actionIndex() {
        echo "开发中";exit;
        $data['config'] = $this->site_config;
        $where =$data['pagebar'] =$data['list'] = array();
        $type_id =  Tool::getValidParam("type", "integer");
        $model_name = Tool::getValidParam('model','string');
        $data['keyword'] =  trim(Tool::getValidParam("keyword", "string"));
        
        $data['config']['site_title'] =    $data['keyword']."-项目搜索-".$this->site_config['site_title'];
        $data['config']['site_keywords'] =   $data['keyword'].",项目搜索,".$this->site_config['site_keywords'];
        $data['config']['site_description'] =   $data['keyword'].',项目搜索,'.$this->site_config['site_description'] ;
        
        if($model_name&&$data['keyword']){
                $model_name = Tool::getValidParam('model','string');
                $model = new $model_name;
                $criteria = new CDbCriteria();
                $criteria->condition = "status = 1";
                
                if($type_id){
                    $data['s']['type_id'] = intval($type_id);
                    $criteria->addCondition("t.type_id  =".  $data['s']['type_id']);
                }

                if($data['keyword']){
                   $criteria->addCondition("t.title like '%".$data['keyword']."%'");
                }

                $criteria->order = 't.id DESC';
                $count = $model->count($criteria);
                $pages = new CPagination($count);
                $pages->pageSize = 12;
                $criteria->limit = $pages->pageSize;
                $criteria->offset = $pages->currentPage * $pages->pageSize;
                $result = $model->findAll($criteria);

                $data['pagebar'] = $pages ;


                foreach ($result as $c) {
                    $data['list'][$c->id] = $c->attributes;
                    $data['list'][$c->id]['url'] = Mod::app()->createUrl($model_name.'/',array('id'=>$c->id));
                }

//                //获取文章栏目
//                $categorymodel =  Category::model()->findAll("model = '".$model_name."'");
//                foreach($categorymodel as $c){
//                        $data['categoryarr'][$c->id] = $c->attributes;
//                }

                switch ($model_name) {
                    case 'article':
                        $model_name_cn ='文章';
                        break;
                    case 'pic':
                        $model_name_cn ='图片';
                        break;
                    case 'project':
                        $model_name_cn ='项目';
                        break;
                    default:
                        $model_name_cn ='文章';
                        break;
                }
//                //start我的位置
//                $data['position'] = array(
//                    array('name' =>'搜索'.$model_name_cn.' 关键字：'.$data['keyword'], 'now' => true),
//                );
//                //end我的位置
        }
//        var_dump($data);die;
        $this->render('/search/project', $data);
    }

}
