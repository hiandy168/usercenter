<?php
/**
 * 商品首页
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */
class DefaultController extends B2cController
{
    public $layout='column_home';
    /**
     * 商城入口
     */
    public function actionIndex()
    {
        //分类列表
        $Cat = new ModelCat();
        $model['cat_list'] = $Cat->Items();

        //最新上架
        $Product = new ModelProduct();
        $condition = "p.is_default = 'true'";
        $model['new_list'] = $Product->getProducts(
            'g.goods_id,g.name,g.image_default_id,g.price,p.uptime,p.product_id,p.bn',
            $condition,'p.uptime DESC',0,10
        );

        $this->render('index',array('model'=>$model));
    }
    public function actionWap(){
        //分类列表
        $Cat = new ModelCat();
        $model['cat_list'] = $Cat->Items();

        //最新上架
        $Product = new ModelProduct();
        $condition = "p.is_default = 'true'";
        $model['new_list'] = $Product->getProducts(
            'g.goods_id,g.name,g.image_default_id,g.price,p.uptime,p.product_id,p.bn',
            $condition,'p.uptime DESC',0,10
        );

        $this->render('index',array('model'=>$model));
    }
    
}