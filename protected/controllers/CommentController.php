<?php

class CommentController extends FrontController {
    public  $code = 'comment_verify_code';
    public function init(){
         parent::init();
     }
    

    function actionList() {
        $id =  Mod::app()->request->getQuery('id', 0);
        $model = ucfirst(Mod::app()->request->getQuery('model', 'article'));
        $con_model  = new $model();
        $class_name = $model.'_comment';
        $comment_model = new $class_name();
        if ($id&&$model) {
            $con = $con_model->find("id ='" . trim(Tool::getValidParam('id','integer')) . "' and lang ='" . $this->lang . "'");
            if(!empty($con)){
                     $data['view'] = $con->attributes;
                     $category_model = Category::model()->find("id ='" . $con->category_id . "' and lang ='" . $this->lang . "'"); 
                     $data['category'] = $category_model->attributes;
                     $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
            }else{
                 $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }
        
        
        
        $criteria = new CDbCriteria();
        $data['count'] = $comment_model->count($criteria);
        
        $criteria->select = 'c.id,c.content,c.createtime,c.top,c.step,m.name as member_name';
        $criteria->alias = 'c';
        $criteria->join='LEFT JOIN {{member}} as m ON c.member_id=m.id';
        $criteria->with='Member';
        $criteria->condition = "c.lang ='" . $this->lang . "' and c.status =1";
        $criteria->addCondition('c.cid ='.$con->id);
        $criteria->order = 'c.id desc';
        
        $pages = new CPagination($data['count']);
        $pages->pageSize = 20;
        $pages->currentPage = isset($_GET['page'])?($_GET['page']-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $comment_model->findAll($criteria);
      
        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][$c->id] = $c->attributes;
            $data['list'][$c->id]['member_name'] = $c->Member->name;
        }
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $data['category']['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $data['category']['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $data['category']['description']?$data['category']['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        
        $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
        
        //start我的位置
        $position_arr = array(
            array('name' =>'评论列表','now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        $data['model'] = $model;
        $tpl = '/comment/list';
        $this->render($tpl,$data);
    }

    function actionVerify_image() {
        $conf['name'] = $this->code; //作为配置参数
        $conf['font'] = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'LiberationSans-Bold.ttf';
        $verify = new verify($conf);
        $verify->show();
        Mod::app()->session[$conf['name']] = $verify->get_randcode();
    }
    
    function actionSubmit() {
          $stats =0;
          $mess ='非法的数据操作!';
          if(Mod::app()->request->isPostRequest){
                $member_info = $this->member;
                if(!$member_info['id']){
                        $stats = -1;
                        $mess = '登陆后才可以评论呢！';
                }else{
                       //验证码验证
                        $verify = trim(Tool::getValidParam('verify','string'));
                        if ($verify) {
                            if($verify!=Mod::app()->session[$this->code]){
                                $stats =0;
                                $mess ='验证码不正确!';
                            }else{
                                $type =  ucfirst(trim(Tool::getValidParam('type','string')));
                                $class = $type.'_comment';
                                $model = new $class(); 
                                $model->member_id=$member_info['id'];
                                $model->cid = trim(Tool::getValidParam('id','integer'));
                                $model->content =trim(Tool::getValidParam('content','string'));
                                $model->createtime = time();
                                if($model->save()){
                                    $stats =1;
                                    $mess ='ok';
                                }
                            }
			}    
               }
            }
           echo  json_encode(array('stats'=>$stats,'mess'=>$mess));        
    }
        function actionDocomment() {
          $stats =0;
          $mess ='非法的数据操作!';
          if(Mod::app()->request->isPostRequest){
                $id =trim(Tool::getValidParam('id','integer'));
                $what = trim(Tool::getValidParam('what','integer'));
                $member_info = $this->member;
                if(!$member_info['id']){
                        $stats = -1;
                        $mess = '登陆后才可以评论呢！';
                }else{
                      $type =  strtolower(trim(Tool::getValidParam('type','string')));
                      $class = $type.'_comment';
                      $session_name = $class.'_'.$id.'by'.$member_info['id'];
                      if(Mod::app()->session[$session_name]){
                          echo  json_encode(array('stats'=>0,'mess'=>'您已经评论过了!暂时不能继续评论这个内容'));   
                          exit;
                      }
                        $sql  = "UPDATE {{".$class."}} SET `".$what."`=`".$what."`+1 WHERE `id`=".$id;
                        $res = Mod::app()->db->createCommand($sql)->execute();  
                        if($res){
                            Mod::app()->session[$session_name] = true;
                            $stats =1;
                            $mess ='ok';
                        }
               }
            }
           echo  json_encode(array('stats'=>$stats,'mess'=>$mess));        
    }
}
