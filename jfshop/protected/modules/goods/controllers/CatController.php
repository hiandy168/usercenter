<?php
/**
 * 分类管理
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */

class CatController extends BaseController
{
    public $pagesize = 1000;

    public function init()
    {
        $this->registerJs(
            array('jquery.uploadify'),'end','bootstrap'
        );
        $this->registerJs(
            array('bootbox.min','oct/goods/cat')
        );
    }
    /**
     * 分类列表
     */
    public function actionIndex()
    {
        $pageIndex =  Tool::getValidParam('page')? Tool::getValidParam('page'):1;

        $GoodsCat = new GoodsCat();
        $result = $GoodsCat->CatList($pageIndex,$this->pagesize);

        //分页
        $pages = new CPagination($result['count']);

        $this->render('index',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1
        ));
    }

    /**
     * 分类编辑
     */
    public function actionUpdate()
    {
        $cat_id = Tool::getValidParam('cat_id','int');

        $GoodsCat = new GoodsCat();
        $cat_row = GoodsCat::model()->find('cat_id = :cat_id',array(':cat_id'=>$cat_id));
        if ($_POST) {
            $cat_attributes = Tool::getValidParam('Cat');
            $cat_attributes['parent_id'] = $cat_attributes['parent_id']?$cat_attributes['parent_id']:0;

            $cat_path = ',';
            if ($cat_attributes['parent_id']) {
                $parent_row = GoodsCat::model()->find('cat_id = :cat_id',array(':cat_id'=>$cat_attributes['parent_id']));
                $cat_path = $parent_row['cat_path'];
            }
            $cat_attributes['cat_path'] = $cat_attributes['parent_id']?$cat_path.$cat_attributes['parent_id'].',':',';

            $result = GoodsCat::model()->updateByPk(
                $cat_id,
                $cat_attributes
            );
            if ($result) {
                $this->referrer();
            } else {
                $this->message('error',CHtml::errorSummary($GoodsCat),$this->createUrl('index'));            }
        }
        //商品类型
        $type_list = GoodsType::model()->findAll(array('condition' => 'disabled=:disabled','params' => array(':disabled'=>'false')));
        $type_arr = array();
        if ($type_list) {
            foreach ($type_list as $v) {
                $type_arr[$v['type_id']] = $v['name'];
            }
        }
        $model['type'] = $type_arr;
        $result = $GoodsCat->CatList(0,$this->pagesize);
        $model['parent'] = $result['item'];
        $model['cat_row'] = $cat_row;
        $this->render('update',array('model'=>$model));
    }

    /**
     * 分类添加
     */
    public function actionCreate()
    {
        $GoodsCat = new GoodsCat();
        if ($_POST) {
            $cat_attributes = Tool::getValidParam('Cat');
            $cat_attributes['parent_id'] = $cat_attributes['parent_id']?$cat_attributes['parent_id']:0;

            $cat_path = ',';
            if ($cat_attributes['parent_id']) {
                $parent_row = GoodsCat::model()->find('cat_id = :cat_id',array(':cat_id'=>$cat_attributes['parent_id']));
                $cat_path = $parent_row['cat_path'];
            }
            $cat_attributes['cat_path'] = $cat_attributes['parent_id']?$cat_path.$cat_attributes['parent_id'].',':',';

            $GoodsCat->attributes = $cat_attributes;
            if ($GoodsCat->save()) {
                $this->referrer();
            } else {
                $this->message('error',CHtml::errorSummary($GoodsCat),$this->createUrl('index'));
            }
        }
        $result = $GoodsCat->CatList(0,$this->pagesize);
        $model['parent'] = $result['item'];

        //商品类型
        $type_list = GoodsType::model()->findAll(array('condition' => 'disabled=:disabled','params' => array(':disabled'=>'false')));
        $type_arr = array();
        if ($type_list) {
            foreach ($type_list as $v) {
                $type_arr[$v['type_id']] = $v['name'];
            }
        }
        $model['type'] = $type_arr;

        if (Tool::getValidParam('parent_id')) {
            $model['cat_row']['parent_id'] = Tool::getValidParam('parent_id');
        }

        $this->render('create',array('model'=>$model));
    }

    /**
     * 品牌删除
     */
    public function actionDelete()
    {
        $cat_id = Tool::getValidParam('cat_id','int');
        $cat_arr = GoodsCat::model()->findAll(array('condition'=>'cat_path like :cat_path','params'=>array(':cat_path'=>"%,".$cat_id.",%")));
        $cat_attributes['disabled'] = 'true';
        $cat_attributes['last_modify'] = time();
        $query_status = true;
        $result = GoodsCat::model()->updatebypk($cat_id,$cat_attributes);
        if(!$result){
            $query_status = false;
        }
        foreach ($cat_arr as $v) {
            $result2 = GoodsCat::model()->updatebypk($v['cat_id'],$cat_attributes);
                if(!$result2){
                    $query_status = false;
                }
        }

        if ($query_status) {
            $this->message('success','删除成功',$this->createUrl('index'));
        } else {
            $GoodsCat = new GoodsCat();
            $this->message('error',CHtml::errorSummary($GoodsCat),$this->createUrl('index'));
        }
    }

    /**
     * 分类图片
     */
    public function actionImg()
    {
        echo $this->renderPartial('img',array(),true);
    }

    /**
     * Ajax获取商品分类
     */
    public function actionAjaxgoodscat()
    {
        $cat_id = Tool::getValidParam('cat_id','int');
        $GoodsCat = new GoodsCat();

        $default = Tool::getValidParam('default');
        $result = $GoodsCat->CatSelect($cat_id,$default);
        $goods_select = $result['item'];
        if ($default == 0) {
            $cat_one = isset($goods_select['one'])?$goods_select['one']:array();
            $cat_two = isset($goods_select['two'])?$goods_select['two']:array();
            //$cat_three = isset($goods_select['three'])?$goods_select['three']:array();
            $cat_three = array();

            echo $this->renderPartial('_model_goods_cat',
                array(
                    'cat_id'=>$cat_id,
                    'cat_one'=>$cat_one,
                    'cat_two'=>$cat_two,
                    'cat_three'=>$cat_three,
                    'active'=>$result['active']
                ),
                true
            );
        }
        else if ($default == 1) {
            $cat_two = $goods_select['two'];
            echo TbHtml::navList($cat_two);
        }
        else if ($default == 2) {
            $cat_three = $goods_select['three'];
            echo TbHtml::navList($cat_three);
        }
    }
} 