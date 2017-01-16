<?php

class ProductController extends AController {
    
    public function actionIndex() {
        $this->actionLists();
    }
    
    public function actionLists() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $where = array();
//        $result = Product::model()->findAll();
        $model = new Product();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='".$this->lang."'";
         if(isset($_REQUEST['category_id'])&& $_REQUEST['category_id']){
           $data['category_id'] = isset($_REQUEST['category_id'])?trim($_REQUEST['category_id']):'';
           $criteria->addCondition("t.category_id=".intval($_REQUEST['category_id']));
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

        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        
        if(isset($data['category_id'])){
        $pages->params=array('category_id'=>$data['category_id']); 
        }
        if(isset($data['keyword'])){
        $pages->params=array('keyword'=>$data['keyword']); 
        }
        
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;   
          
        $result = $model->findAll($criteria);
        
        $data['pagebar'] = $pages ;
        
        
        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

        //获取文章栏目
        $categorymodel =  Category::model()->findAll("lang=:lang and model = 'product'",array(":lang"=>$this->lang));
        foreach($categorymodel as $c){
                $data['categoryarr'][$c->id] = $c->attributes;
        }
            

        $this->render('product', $data);
    }

    public function actionAdd() {
        $this->check_permission(__CLASS__, __FUNCTION__);
          if(Mod::app()->request->isPostRequest){
            $model = new Product;
                $data = $_POST;		
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
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
                    $id = Mod::app()->db->lastInsertID;
                    $sku = $this->build_sku($data,$id);
                    if(!empty($sku) && $sku){
                        Product_spec::insertAll($sku);
                    }
        
                    $target_url = $this->createUrl('product/lists');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {
            
            $data['fid'] = $fid = Mod::app()->request->getParam('fid');//request

            //获取栏目
              $categorymodel =Category::model()->findAll("lang=:lang and model=:model",array(":lang"=>$this->lang,':model'=>'product'));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }

            $data['fun'] = 'add';
            $this->render('product_edit', $data);
        }
    }
   
    function build_sku($data,$product_id){
        $spec_key_arr = array_keys($data['spec']);
        foreach($data['product_money'] as $kk=>$vv){
   
            $res[$kk]['product_id'] =  $product_id;
            $res[$kk]['product_money'] = $vv;
            $res[$kk]['product_smoney'] = $data['product_smoney'][$kk];
            $res[$kk]['product_num'] = $data['product_num'][$kk];
            $temp_product_spec = array();
            foreach($spec_key_arr as $sk){
                if($data['spec'][$sk][$kk]){
                    $temp_product_spec[] = $data['spec'][$sk][$kk];
                }
            }
            $res[$kk]['product_spec'] = implode(',', $temp_product_spec); 
            
        }
        
        foreach($res as $r){
             if(!$r['product_money'] && !$r['product_num'])
                                  continue;
             else
                 $result[] = $r;
        }
        return $result;
    }

    public function actionEdit() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id =intval( isset($_GET['id'])?$_GET['id']:(isset($_POST['id'])?$_POST['id']:''));
        $model = Product::model()->findbypk($id);
    
        if(Mod::app()->request->isPostRequest){

                $data = $_POST;	
               //不能直接把数组给attributes  但是可以单独的给key赋值
	        foreach($model->attributes as $k=>$v){
                    isset($data[$k]) && $model->$k = $data[$k];
                }
                if(!empty($data['sku_arr']))
                    $model->spec_str = implode(',', $data['sku_arr']);
                $model->picture = ltrim($data['picture'], $this->_siteUrl.'/');
                $model->updatetime = time();
                $model->createtime = strtotime($data['createtime']);
                $model->keywords = isset($data['keywords'])?Keywords::loadKeywordIds($data['keywords'],$this->lang):'';
                $model->top = isset($data['typefor']['top'])?$data['typefor']['top']:0;
                $model->focus = isset($data['typefor']['focus'])?$data['typefor']['focus']:0;
                $model->recommend = isset($data['typefor']['recommend'])?$data['typefor']['recommend']:0;
                $model->choiceness = isset($data['typefor']['choiceness'])?$data['typefor']['choiceness']:0;
                $model->hot = isset($data['typefor']['hot'])?$data['typefor']['hot']:0;
                if($model->save()){
                    $sku = $this->build_sku($data,$id);
                    Product_spec::model()->deleteAll('product_id = '.$id);
                    if(!empty($sku) && $sku){
                        Product_spec::insertAll($sku);
                    }
                    $target_url = $this->createUrl('product/lists');
                    $this->admin_message('添加成功', $target_url);
                    exit();
                }
        }else {

            if (isset($model)) {
                $data['view'] = $model->attributes;
                $data['view']['keywords'] = Keywords::loadKeywords($data['view']['keywords'],$this->lang);
                if( $data['view']['spec_str'])
                $data['view']['spec_arr'] = explode(',', $data['view']['spec_str']);
            }
            $data['fun'] = 'edit';
            
             //获取栏目
             $categorymodel =Category::model()->findAll("lang=:lang and model=:model",array(":lang"=>$this->lang,':model'=>'product'));
             foreach($categorymodel as $cm){
                 $data['categoryarr'][] = $cm->attributes;
             }

             
             //获取本商品规格
             $prospecmodel=  Product_spec::model()->findAll("product_id =:product_id",array(':product_id'=>$id));
             foreach($prospecmodel as $cm){
                 $data['pro_spec'][] = $cm->attributes;
             }
             
//             var_dump($data['pro_spec']);die;
             
             //获取商品规格

             $specmodel=Spec::model()->findAll("lang=:lang and status=:status",array(":lang"=>$this->lang,':status'=>'1'));
             foreach($specmodel as $k=>$cm){
                 $data['specarr'][$k] = $cm->attributes;
                 $sql = 'select * from {{spec_element}}  where spec_id='.$cm->id;
                 $data['specarr'][$k]['element'] = Mod::app()->db->createCommand($sql)->queryAll();
             }
             

            $this->render('product_edit', $data);
        }
    }

    public function actionDel() {
        $this->check_permission(__CLASS__, __FUNCTION__);
        $id_str = Mod::app()->request->getParam('id');
        $id_arr = explode(',', $id_str);
 
            if ($id_arr && !empty($id_arr)) {
                $res = '';
                $model = new Product;
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
        $id_str = $_POST['id'];
        $order_str = $_POST['order'];
        $id_arr = explode(',', $id_str);
        $order_arr = explode(',', $order_str);
        if (count($id_arr) > 0 && count($id_arr) == count($order_arr)) {
            $model = new Product;
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
