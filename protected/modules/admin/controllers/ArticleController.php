<?php

class ArticleController extends AController {
    
    public function actionIndex() {
        $this->actionLists();
    }
    
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
//        $result = Article::model()->findAll();
        $model = new Article();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
        if(isset($_REQUEST['category_id'])&& $_REQUEST['category_id']){
           $data['category_id'] = isset($_REQUEST['category_id'])?intval($_REQUEST['category_id']):'';
           
            $child_category_model = Category::model()->findAll("fid ='" . intval($_REQUEST['category_id']) . "' and lang ='" . $this->lang . "'");
            $child_id_arr =  array();
            $id_arr = array(intval($_REQUEST['category_id']));
            foreach($child_category_model as $c){
                $child_id_arr[] = $c->id;
            }
            if(!empty($child_id_arr)){
                $id_arr = array_merge(array(intval($_REQUEST['category_id'])),$child_id_arr);
            }
            $criteria->addCondition("t.category_id in(".implode(',', $id_arr).")");
           $data['s']['category_id'] = intval($_REQUEST['category_id']);
        }
        if(isset($_REQUEST['title'])&& $_REQUEST['title']){
           $criteria->addCondition("t.title like '%".trim($_REQUEST['title']."%'"));
            $data['s']['title'] = trim($_REQUEST['title']);
        }

        isset($_REQUEST['recommend']) && $data['s']['recommend'] = trim($_REQUEST['recommend']);
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'top')){
            $criteria->addCondition("t.top = 1");
        }
        if( isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'focus')){
            $criteria->addCondition("t.focus = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'recommend')){
            $criteria->addCondition("t.recommend = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'choiceness')){
            $criteria->addCondition("t.choiceness = 1");
        }
        if(isset($_REQUEST['recommend']) && trim($_REQUEST['recommend'] == 'hot')){
            $criteria->addCondition("t.hot = 1");
        }

        $criteria->order = 't.`top` desc,t.`order` desc,t.`createtime` desc';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        
        if(isset($data['category_id'])){
        $pages->params=array('category_id'=>$data['category_id']); 
        }
        if(isset($data['title'])){
        $pages->params=array('title'=>$data['title']); 
        }
        
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;   
          
        $result = $model->findAll($criteria);
        
        $data['pagebar'] = $pages ;
        
        
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

        //获取文章栏目
        $categorymodel =  Category::model()->findAll("lang=:lang and model = 'article'",array(":lang"=>$this->lang));
        foreach($categorymodel as $c){
                $data['categoryarr'][$c->id] = $c->attributes;
        }
        
   if(isset($data['categoryarr'])&& !empty($data['categoryarr'])){
                $tree = new Tree($data['categoryarr']);
                $data['categoryarr'] = $tree->tree2(0);
            }

        $this->render('article', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if(Mod::app()->request->isPostRequest){
            $model = new Article;
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->content  = str_replace($this->_siteUrl,'{{site_path}}', $data['content'] );
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->createtime = strtotime($data['createtime']);
                $model->tags = Tags::loadTagIds($data['tags'],$this->lang);
                $model->keywords = isset($data['keywords'])?Keywords::loadKeywordIds($data['keywords'],$this->lang):'';
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                $model->lang = $this->lang;
                if($model->save()){
                    $target_url = $this->createUrl('/admin/article/lists',array('category_id'=>$model->category_id));
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            $data['view']['category_id'] = intval($_REQUEST['category_id']);
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request

            //获取栏目
              $categorymodel =Category::model()->findAll("lang=:lang and model=:model",array(":lang"=>$this->lang,':model'=>'article'));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }
            $tree = new Tree($data['categoryarr']);
            $data['categoryarr'] = $tree->tree2(0);

            $data['fun'] = 'add';
            $this->render('article_edit', $data);
        }
    }
   
    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id = intval(isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:''));
        $model = Article::model()->findbypk($id);

        if(Mod::app()->request->isPostRequest){
                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                $model->content  = str_replace($this->_siteUrl,'{{site_path}}', $data['content'] );
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->updatetime = time();
                $model->createtime = strtotime($data['createtime']);
                $model->tags = Tags::loadTagIds($data['tags'],$this->lang);
                $model->keywords = isset($data['keywords'])?Keywords::loadKeywordIds($data['keywords'],$this->lang):'';
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                if($model->save()){
                      $target_url = $this->createUrl('/admin/article/lists',array('category_id'=>$model->category_id));
                      $this->admin_message('添加成功', $target_url);
                      exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
                $data['view']['tags'] = Tags::loadTags($data['view']['tags'],$this->lang);
                $data['view']['keywords'] = Keywords::loadKeywords($data['view']['keywords'],$this->lang);
            }
            $data['fun'] = 'edit';
            
            $data['view']['content']  = str_replace('{{site_path}}', $this->_siteUrl, $data['view']['content'] );
            
             //获取栏目
              $categorymodel =Category::model()->findAll("lang=:lang and model=:model",array(":lang"=>$this->lang,':model'=>'article'));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }
                if(isset($data['categoryarr'])&& !empty($data['categoryarr'])){
                $tree = new Tree($data['categoryarr']);
                $data['categoryarr'] = $tree->tree2(0);
            }

            $this->render('article_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
 
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Article;
                $res = $model->deleteAll( 'id IN(' . $id_str . ')');
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
            }
     
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

   public function actionOrder() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Tool::getValidParam('id','string');
        $order_str =Tool::getValidParam('order','string');
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Article;
            $res = $model->order_bat($id_arr, $order_arr);
            if ($res) {
                $mess = '更新成功！';
                $state = 1;
            } else {
                $mess = '更新失败！';
                $state = 0;
            }
        }
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }

}
