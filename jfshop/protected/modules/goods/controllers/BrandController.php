<?php
/**
 * 品牌管理
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */
class BrandController extends BaseController
{
    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
    }

    public function init()
    {
        $this->registerJs(
            array('jquery.uploadify'),
            'end','bootstrap'
        );
        $this->registerJs(
            array(
                'oct/goods/brand'
            ),
            'end'
        );
    }

    /**
     * 品牌列表
     */
    public function actionIndex()
    {
        $pageIndex = Tool::getValidParam('page')? Tool::getValidParam('page'):1;
        $Brand = new Brand();
        $result = $Brand->BrandList($pageIndex,$this->pagesize);

        //分页
        $pages = new CPagination($result['count']);

        $this->render('index',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1
        ));
    }

    /**
     * 品牌编辑
     */
    public function actionUpdate()
    {
        $brand_id = Tool::getValidParam('brand_id','int');
        if ($_POST) {
            $transaction=Mod::app()->db->beginTransaction();
            try{
                $brand_attributes = Tool::getValidParam('Brand');
                $type_attributes = Tool::getValidParam('GoodsType');

                $brand_attributes['last_modify'] = time();
                $result = Brand::model()->updatebypk($brand_id,$brand_attributes);
                if (!$result) {
                    $Brand = new Brand();
                    $this->message('error',CHtml::errorSummary($Brand),$this->createUrl('index'));
                }

                if ($type_attributes) {
                    $TypeBrand = new TypeBrand();
                    $result = $TypeBrand->type_brand_update($brand_id,$type_attributes);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($TypeBrand),$this->createUrl('index'));
                    }
                }else{
                    $type_old = TypeBrand::model()->findAll('brand_id = :brand_id',array(':brand_id'=>$brand_id));
                    if($type_old) {
                        $sql = '';
                        foreach ($type_old as $v) {
                            $sql .= "DELETE FROM {{b2c_type_brand}} WHERE brand_id = $brand_id AND type_id = {$v['type_id']};";
                        }
                        $res = Mod::app()->db->createCommand($sql)->execute();
                    }
                }
                $transaction->commit();//如果操作失败, 数据回滚
                $this->message('success','编辑成功',$this->createUrl('index'));
            }catch (Exception $e) {
                $this->message('error','编辑失败',$this->createUrl('index'));
                $transaction->rollback();//如果操作失败, 数据回滚
            }
//            $this->referrer();
        }
        $model['brand_item'] = Brand::model()->find('brand_id = :brand_id',array(':brand_id'=>$brand_id));
        $model['type_list'] = GoodsType::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        $type_brand_list = TypeBrand::model()->findAll('brand_id = :brand_id',array(':brand_id'=>$brand_id));
        $model['type_brand_list'] = array();
        foreach ($type_brand_list as $v) {
            $model['type_brand_list'][] = $v['type_id'];
        }

        $this->render('update',array('model'=>$model));
    }

    /**
     * 品牌创建
     */
    public function actionCreate()
    {
        if ($_POST) {
            $Brand = new Brand();
            $Brand->attributes = Tool::getValidParam('Brand');
            $type_attributes = Tool::getValidParam('GoodsType');

            if (!$Brand->save()) {
                $Brand = new Brand();
                $this->message('error',CHtml::errorSummary($Brand),$this->createUrl('index'));
            }

            if ($type_attributes) {
                $brand_id = Mod::app()->db->getLastInsertID();
                $TypeBrand = new TypeBrand();
                $result = $TypeBrand->type_brand_insert($brand_id,$type_attributes);
                if (!$result) {
                    $this->message('error',CHtml::errorSummary($TypeBrand),$this->createUrl('index'));
                }
            }
            $this->referrer();
        }
        $model['type_list'] = GoodsType::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        $this->render('create',array('model'=>$model));
    }

    /**
     * 品牌删除
     */
    public function actionDelete()
    {
        $brand_id = Tool::getValidParam('brand_id','int');
        $brand_attributes['disabled'] = 'true';
        $brand_attributes['last_modify'] = time();
        $result = Brand::model()->updatebypk($brand_id,$brand_attributes);
        if ($result) {
            $this->message('success','删除成功',$this->createUrl('index'));
        } else {
            $Brand = new Brand();
            $this->message('error',CHtml::errorSummary($Brand),$this->createUrl('index'));
        }
    }

    /**
     * 品牌列表Dialog展示
     */
    public function actionSpecial()
    {
        $brand_list = Brand::model()->findAll(
            'disabled = :disabled',
            array(':disabled'=>'false'),
            array('select'=>'brand_id,brand_name')
        );

        $item = array();
        foreach ($brand_list as $v) {
            $row['label'] = $v['brand_name'];
            $row['value'] = $v['brand_name'];
            $row['brand_id'] = $v['brand_id'];
            $item[] = $row;
        }

        echo json_encode($item);
    }

    /**
     * 根据类型获取品牌
     */
    public function actionAjaxtypebrand()
    {
        $TypeBrand = new TypeBrand();
        $type_id = Tool::getValidParam('type_id','int');
        $list = $TypeBrand->type_brand($type_id);

        $str = '<option value="">请选择</option>';
        foreach ($list as $v) {
            $str .= '<option value="'.$v['brand_id'].'">'.$v['brand_name'].'</option>';
        }

        echo $str;
    }

    public function actionTest()
    {
        echo ini_get('upload_max_filesize').'<br>';
        echo ini_get('post_max_size');
    }
}