<?php
/**
 * 商品类型管理
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */
class TypeController extends BaseController
{
    public function __construct($id,$module)
    {
        parent::__construct($id,$module);
    }

    public function init()
    {
        $this->registerJs(array('oct/goods/type'));
    }

    /**
     * 类型列表
     */
    public function actionIndex()
    {
        $pageIndex = Tool::getValidParam('page','int')?Tool::getValidParam('page','int'):1;
        $GoodsType = new GoodsType();
        $result = $GoodsType->TypeList($pageIndex,$this->pagesize);

        //分页
        $pages = new CPagination($result['count']);

        $this->render('index',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1
        ));
    }

    /**
     * 类型编辑
     */
    public function actionUpdate()
    {
        $type_id = Tool::getValidParam('type_id','int');
        if ($_POST) {
            $transaction=Mod::app()->db->beginTransaction();
            try{
                $type_attributes = Tool::getValidParam('Type');
                $type_brand_attributes = Tool::getValidParam('TypeBrand');
                //商品类型主表修改
                $type_attributes['lastmodify'] = time();
                $result = GoodsType::model()->updatebypk($type_id,$type_attributes);
                if (!$result) {
                    $GoodsType = new GoodsType();
                    $this->message('error',CHtml::errorSummary($GoodsType),$this->createUrl('index'));
                }
                //类型-品牌
                if ($type_brand_attributes) {
                    $TypeBrand = new TypeBrand();
                    $result = $TypeBrand->brand_type_update($type_id,$type_brand_attributes);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($TypeBrand),$this->createUrl('index'));
                    }
                }
                //类型-扩展属性
                $type_props_attributes = Tool::getValidParam('TypeProps');
                if ($type_props_attributes) {
                    $GoodsTypePropsRelation = new GoodsTypePropsRelation();
                    $result = $GoodsTypePropsRelation->props_update($type_id,$type_props_attributes['props_id']);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($GoodsTypePropsRelation),$this->createUrl('index'));
                    }
                }else{
                    $type_props_list = GoodsTypePropsRelation::model()->findAll('type_id = :type_id',array(':type_id'=>$type_id));
                    if($type_props_list) {
                        $sql = '';
                        foreach ($type_props_list as $v) {
                            $sql .= "DELETE FROM {{b2c_goods_type_props_relation}} WHERE type_id = $type_id AND relation_id = {$v['relation_id']};";
                        }
                        $res = Mod::app()->db->createCommand($sql)->execute();
                    }
                }
                //类型-规格
                $type_props_spec = Tool::getValidParam('Spec');
                if ($type_props_spec['spec_id']) {
                    $GoodsTypeSpec = new GoodsTypeSpec();
                    $result = $GoodsTypeSpec->spec_update($type_id,$type_props_spec['spec_id']);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($GoodsTypeSpec),$this->createUrl('index'));
                    }
                }else{
                    $type_spec_list = GoodsTypeSpec::model()->findAll('type_id = :type_id',array(':type_id'=>$type_id));
                    if($type_spec_list) {
                        $sql = '';
                        foreach ($type_spec_list as $v) {
                            $sql .= "DELETE FROM {{b2c_goods_type_spec}} WHERE type_id = $type_id AND spec_id = {$v['spec_id']};";
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

        }
        $model['type_item'] = GoodsType::model()->find('type_id = :type_id',array(':type_id'=>$type_id));
        //品牌列表
        $model['brand_list'] = Brand::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        //类型-品牌
        $type_brand_list = TypeBrand::model()->findAll('type_id = :type_id',array(':type_id'=>$type_id));
        $model['type_brand_list'] = array();
        foreach ($type_brand_list as $v) {
            $model['type_brand_list'][] = $v['brand_id'];
        }
        //扩展属性
        $GoodsTypeProps = new GoodsTypeProps();
        $model['props_list'] = $GoodsTypeProps->TypeProps($type_id);

        //规格
        $GoodsTypeSpec = new GoodsTypeSpec();
        $model['spec_list'] = Specification::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        $spec_list = $GoodsTypeSpec->TypeSpec($type_id);
        $model['spec_selected'] = array();
        foreach ($spec_list as $v) {
            $model['spec_selected'][$v['spec_id']] = $v['spec_id'];
        }

        $this->render('update',array('model'=>$model));
    }

    /**
     * 类型添加
     */
    public function actionCreate()
    {
        if ($_POST) {
            $transaction=Mod::app()->db->beginTransaction();
            try{
                $GoodsType = new GoodsType;
                $GoodsType->attributes = Tool::getValidParam('Type');
                $type_brand_attributes = Tool::getValidParam('TypeBrand');
                //商品类型主表修改
                $result = $GoodsType->save();
                if (!$result) {
                    $GoodsType = new GoodsType();
                    $this->message('error',CHtml::errorSummary($GoodsType),$this->createUrl('index'));
                }
                $type_id = Mod::app()->db->getLastInsertID();
                //类型-品牌
                if ($type_brand_attributes) {
                    $TypeBrand = new TypeBrand();
                    $result = $TypeBrand->brand_type_update($type_id,$type_brand_attributes);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($TypeBrand),$this->createUrl('index'));
                    }
                }
                //类型-扩展属性
                $type_props_attributes = Tool::getValidParam('TypeProps');
                if (isset($type_props_attributes['props_id']) && $type_props_attributes['props_id']) {
                    $GoodsTypePropsRelation = new GoodsTypePropsRelation();
                    $result = $GoodsTypePropsRelation->props_update($type_id,$type_props_attributes['props_id']);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($GoodsTypePropsRelation),$this->createUrl('index'));
                    }
                }
                //类型-规格
                $type_props_spec = Tool::getValidParam('Spec');
                if (isset($type_props_spec['spec_id']) && $type_props_spec['spec_id']) {
                    $GoodsTypeSpec = new GoodsTypeSpec();
                    $result = $GoodsTypeSpec->spec_update($type_id,$type_props_spec['spec_id']);
                    if (!$result) {
                        $this->message('error',CHtml::errorSummary($GoodsTypeSpec),$this->createUrl('index'));
                    }
                }
                $transaction->commit();//如果操作失败, 数据回滚
                $this->message('success','创建成功',$this->createUrl('index'));
            }catch (Exception $e) {
                $this->message('error','创建失败',$this->createUrl('index'));
                $transaction->rollback();//如果操作失败, 数据回滚
            }
        }
        //品牌列表
        $model['brand_list'] = Brand::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        //规格
        $model['spec_list'] = Specification::model()->findAll('disabled = :disabled',array(':disabled'=>'false'));
        $this->render('create',array('model'=>$model));
    }

    /**
     * 类型删除
     */
    public function actionDelete()
    {
        $type_id = Tool::getValidParam('type_id','int');
        //商品类型主表修改
        $type_attributes['disabled'] = 'true';
        $type_attributes['lastmodify'] = time();
        $transaction=Mod::app()->db->beginTransaction();
        try{
        $result = GoodsType::model()->updatebypk($type_id,$type_attributes);
//        if (!$result) {
//            $GoodsType = new GoodsType();
//            $this->message('error',CHtml::errorSummary($GoodsType),$this->createUrl('index'));
//        }
        //类型-品牌
        $result = TypeBrand::model()->deleteAll('type_id = :type_id',array(':type_id'=>$type_id));
//        if (!$result) {
//            $TypeBrand = new TypeBrand();
//            $this->message('error',CHtml::errorSummary($TypeBrand),$this->createUrl('index'));
//        }
        //类型-扩展属性
        $result = GoodsTypePropsRelation::model()->deleteAll('type_id = :type_id',array(':type_id'=>$type_id));
//        if (!$result) {
//            $GoodsTypePropsRelation = new GoodsTypePropsRelation();
//            $this->message('error',CHtml::errorSummary($GoodsTypePropsRelation),$this->createUrl('index'));
//        }
        //类型-规格
        $result = GoodsTypeSpec::model()->deleteAll('type_id = :type_id',array(':type_id'=>$type_id));
//        if (!$result) {
//            $GoodsTypeSpec = new GoodsTypeSpec();
//            $this->message('error',CHtml::errorSummary($GoodsTypeSpec),$this->createUrl('index'));
//        }
            $transaction->commit();//如果操作失败, 数据回滚
            $this->message('success','删除成功',$this->createUrl('index'));
        }catch (Exception $e) {
            $this->message('error','删除失败',$this->createUrl('index'));
            $transaction->rollback();//如果操作失败, 数据回滚
        }
    }

    /**
     * 根据类型获取规格、扩展属性
     */
    public function actionAjaxspecprops()
    {
        $type_id = Tool::getValidParam('type_id','int');

        //规格
        $GoodsTypeSpec = new GoodsTypeSpec();
        if ($GoodsTypeSpec->TypeSpec($type_id)) $model['spec'] = true;
        else $model['spec'] = false;

            //扩展属性
        $GoodsTypeProps = new GoodsTypeProps();
        if ($GoodsTypeProps->TypePropsRelation($type_id)) $model['props'] = true;
        else $model['props'] = false;

        echo json_encode($model);
    }
} 