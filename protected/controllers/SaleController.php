<?php

class SaleController extends FrontController {
    public  $url;
    public function actionIndex() {
        $model = new Product();
        $criteria = new CDbCriteria();
        $criteria->condition = "lang ='" . $this->lang . "' and status =1";
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
        if(isset($_REQUEST['brand'])&& $_REQUEST['brand']){
           $data['brand'] = isset($_REQUEST['brand'])?trim($_REQUEST['brand']):'';
            $criteria->addCondition("t.brand  = '". $data['brand']."'");
         $data['s']['brand'] = urldecode($_REQUEST['brand']);
        }
        if(isset($_REQUEST['price'])&& $_REQUEST['price']){
           $data['price'] = isset($_REQUEST['price'])?trim($_REQUEST['price']):'';
           $temp_price = explode('-',  $data['price']);
           if($temp_price[0]){
                $criteria->addCondition("t.price  > ".$temp_price[0]);
           }
           if($temp_price[1]){
                $criteria->addCondition("t.price  < ".$temp_price[1]);
           }
           $data['s']['price'] = urldecode(trim($_REQUEST['price']));
        }
        
       
        $criteria->order = 't.top desc,t.order DESC,t.id desc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = 20;
        $pages->currentPage = isset($_GET['page'])?(intval($_GET['page']-1)):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }
      
        $data['config'] = $this->site_config;
//        
//        $data['config']['site_title'] = $thiscategory['name']."-".$this->site_config['site_title'];
//        $data['config']['site_keywords'] = $thiscategory['name'].",".$this->site_config['site_keywords'];
//        $data['config']['site_description'] = $thiscategory['description']?$thiscategory['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
      
        $this->url = $this->createUrl('sale/'.intval($_REQUEST['category_id']));
//        $url_params_arr = $_GET;
        $url_params_arr['brand'] = Tool::getValidParam('brand');;
        $url_params_arr['price'] = Tool::getValidParam('price');;


        //导航
        //品牌的
        $brand_url_params_arr =$url_params_arr;
        if(isset($_GET['brand'])){
            unset($brand_url_params_arr['brand']);
        }
       $data['url']['brand_url'] =  $this->url.'?'.http_build_query($brand_url_params_arr);

        //价格的 
        $price_url_params_arr =$url_params_arr;
        if(isset($_GET['price'])){
            unset($price_url_params_arr['price']);
        }
        $data['url']['price_url'] =  $this->url.'?'.http_build_query($price_url_params_arr);
        
       
        $tpl = '/sale/index';
        $this->render($tpl,$data);
    }
    
     public function actionJingpin() {
        $model = new Product();
        $criteria = new CDbCriteria();
        $criteria->condition = "choiceness = 1 and lang ='" . $this->lang . "' and status =1";
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
                if(isset($_REQUEST['brand'])&& $_REQUEST['brand']){
           $data['brand'] = isset($_REQUEST['brand'])?trim($_REQUEST['brand']):'';
            $criteria->addCondition("t.brand  = '". $data['brand']."'");
         $data['s']['brand'] = urldecode($_REQUEST['brand']);
        }
        if(isset($_REQUEST['price'])&& $_REQUEST['price']){
           $data['price'] = isset($_REQUEST['price'])?trim($_REQUEST['price']):'';
           $temp_price = explode('-',  $data['price']);
           if($temp_price[0]){
                $criteria->addCondition("t.price  > ".$temp_price[0]);
           }
           if($temp_price[1]){
                $criteria->addCondition("t.price  < ".$temp_price[1]);
           }
           $data['s']['price'] = urldecode(trim($_REQUEST['price']));
        }
       
        $criteria->order = 't.top desc,t.order DESC,t.id desc';
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
//        
//        $data['config']['site_title'] = $thiscategory['name']."-".$this->site_config['site_title'];
//        $data['config']['site_keywords'] = $thiscategory['name'].",".$this->site_config['site_keywords'];
//        $data['config']['site_description'] = $thiscategory['description']?$thiscategory['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
      
       
        $this->url = $this->createUrl('sale/jingpin');
        $url_params_arr['brand'] = $_GET['brand'];
        $url_params_arr['price'] = $_GET['price'];

        //导航
        //品牌的
        $brand_url_params_arr =$url_params_arr;
        if(isset($_GET['brand'])){
            unset($brand_url_params_arr['brand']);
        }
        $data['url']['brand_url'] =  $this->url.'?'.http_build_query($brand_url_params_arr);

        //价格的 
        $price_url_params_arr =$url_params_arr;
        if(isset($_GET['price'])){
            unset($price_url_params_arr['price']);
        }
        $data['url']['price_url'] =  $this->url.'?'.http_build_query($price_url_params_arr);
        
        $tpl = '/sale/jingxuan';
        $this->render($tpl,$data);
    }
    
     
    public function actionView() {
        if (isset($_GET['id']) && $_GET['id']) {
            $product_model = Product::model()->find("id ='" . trim(Tool::getValidParam('id')) . "' and lang ='" . $this->lang . "'");
            

            if(!empty($product_model)){
                     $data['view'] = $product_model->attributes;
                     $category_model = Category::model()->find("id ='" . $data['view']['category_id'] . "' and lang ='" . $this->lang . "'"); 
                     $data['category'] = $category_model->attributes;
                     $this->alias = isset($data['category']['alias'])?$data['category']['alias']:''; 
            }else{
                 $this->redirect($this->_siteUrl);
            }
        } else {
            $this->redirect($this->_siteUrl);
        }
        
        
        if( $data['view']['spec_str']){
            $data['view']['spec_arr'] =  $data['view']['spec_str'];
            
            $data['ruledata_list'] = MyCache::get('spec_str_'.$data['view']['spec_str']);
            if(empty($ruledata_list)){
                $ruledata_list_model = Spec::model()->findAll('id IN(' . $data['view']['spec_str'] . ')');
                foreach ($ruledata_list_model as $k=>$v) {
                        $data['ruledata_list'][$v->id] = $v->attributes;
                        $sql = 'select * from {{spec_element}}  where spec_id='.$v->id;
                        $data['ruledata_list'][$v->id]['element'] = Mod::app()->db->createCommand($sql)->queryAll();
                }
               
                MyCache::set('spec_str_'.$data['view']['spec_str'],$data['ruledata_list']);
            }
            $temp_pro_spec = array();
            
            $pro_spec_list_model = Product_spec::model()->findAll('product_id='.$_GET['id']);
            foreach($pro_spec_list_model as $p){
                $data['view']['pro_spec_list'][] = $p->attributes;
                $temp_pro_spec[] = $p->attributes['product_spec'];
            }
            if(!empty($temp_pro_spec)){
                  $temp_pro_spec_str  = implode(',', $temp_pro_spec);
                  $pro_spec_arr = array_unique(explode(',', $temp_pro_spec_str));
            }
        
        
            //最终我们调用的规格
            $data['new_ruledata_list'] = array();
            foreach($data['ruledata_list'] as $kk=>$vv){
                $data['new_ruledata_list'][$kk] = $vv;
                $data['new_ruledata_list'][$kk]['element'] = array();
                foreach($vv['element'] as $kkk=>$vvv){
                            if(in_array($vvv['id'],$pro_spec_arr))
                                     $data['new_ruledata_list'][$kk]['element'][] = $vvv;              
                }
            }
            unset($kk,$vv,$kkk,$vvv);
            
            $data['view']['prospec_json'] = json_encode($data['view']['pro_spec_list']);

       
        }

 
        
        $data['config'] = $this->site_config;
        $data['config']['site_title'] = $data['view']['title'].'-'.$data['category']['name']."-".$this->site_config['site_title'];
        $data['config']['site_keywords'] = $data['view']['title'].'-'.$data['category']['name'].",".$this->site_config['site_keywords'];
        $data['config']['site_description'] = $data['view']['title'].'-'.$data['category']['description']?$data['category']['description'].",".$this->site_config['site_description']:$this->site_config['site_description'] ;
        
        //start我的位置
        $position_arr = array(
            array('name' => $data['category']['name'], 'url' => $this->createUrl($data['category']['alias'])),
            array('name' => $data['view']['title'], 'now' => true),
        );
        $data['position'] = $position_arr;
        //end我的位置
        
        $tpl = '/sale/detail';
        $this->render($tpl,$data);
        
    }

 
}
