<?php
/**
 * 规格管理
 *
 * @author     chenfenghua<843958575@qq.com>
 * @copyright  Copyright 2008-2013 shop.feipin0512.com
 * @version    1.0
 */
class SpecController extends BaseController
{
    public $spec_type;
    public $spec_show_type;
    public function __construct($id,$module)
    {
        parent::__construct($id,$module);

        $this->registerJs(array('oct/goods/spec'));
    }

    public function init()
    {
        $this->spec_type = array('text'=>'文字','image'=>'图片');
        $this->spec_show_type = array('flat'=>'平铺','select'=>'下拉');
    }

    /**
     * 规格列表
     */
    public function actionIndex()
    {
        $pageIndex = Tool::getValidParam('page','int')?Tool::getValidParam('page','int'):1;
        $Specification = new Specification();
        $result = $Specification->SpecList($pageIndex,$this->pagesize);

        //分页
        $pages = new CPagination($result['count']);

        $this->render('index',array(
            'dataProvider'=>$result['item'],
            'pages' => $pages,
            'pageIndex'=>$pageIndex-1
        ));
    }

    /**
     * 规格编辑
     */
    public function actionUpdate()
    {
        $spec_id = Tool::getValidParam('spec_id','int');
        $model['spec_value_list'] = SpecValues::model()->findAll(
            array('condition'=>'spec_id = :spec_id','params'=>array(':spec_id'=>$spec_id),'order'=>'p_order ASC')
        );
        if ($_POST) {
            $transaction=Mod::app()->db->beginTransaction();
            try{
                $spec_attributes = Tool::getValidParam('Spec');
                $spec_value_attributes = Tool::getValidParam('SpecValue');

                $result = Specification::model()->updatebypk($spec_id,$spec_attributes);
                if($spec_value_attributes) {
                    $SpecValues = new SpecValues();
                    $result = $SpecValues->SpecValuesEdit($spec_id, $spec_value_attributes, $model['spec_value_list']);
                }else{
                    $spec_value = SpecValues::model()->findAll('spec_id = :spec_id',array(':spec_id'=>$spec_id));
                    if($spec_value) {
                        $sql = '';
                        foreach ($spec_value as $v) {
                            $sql .= "DELETE FROM {{b2c_spec_values}} WHERE spec_id=$spec_id  AND spec_value_id = {$v['spec_value_id']};";
                        }
                        $result = Mod::app()->db->createCommand($sql)->execute();
                    }
                }
//                if ($result) {
//                    $this->message('success','编辑成功',$this->createUrl('index'));
//                } else {
//                    $this->message('error',CHtml::errorSummary($SpecValues),$this->createUrl('index'));
//                }
                $transaction->commit();//如果操作失败, 数据回滚
                $this->message('success','编辑成功',$this->createUrl('index'));
            }catch (Exception $e) {
                $this->message('error','编辑失败',$this->createUrl('index'));
                $transaction->rollback();//如果操作失败, 数据回滚
            }
        }
        $model['spec_item'] = Specification::model()->find('spec_id = :spec_id',array(':spec_id'=>$spec_id));


        $this->render('update',array('model'=>$model));
    }

    /**
     * 规格创建
     */
    public function actionCreate()
    {
        if ($_POST) {
            $Specification = new Specification();
            $SpecValues = new SpecValues();

            $Specification->attributes = Tool::getValidParam('Spec');
            $spec_value_attributes = Tool::getValidParam('SpecValue');
            if (!$Specification->save()) $this->message('error',CHtml::errorSummary($Specification),$this->createUrl('index'));
            $spec_id = Mod::app()->db->getLastInsertID();

            $result = $SpecValues->SpecValuesAdd($spec_id,$spec_value_attributes);
            if ($result) {
                $this->message('success','新增成功',$this->createUrl('index'));
            } else {
                $this->message('error',CHtml::errorSummary($SpecValues),$this->createUrl('index'));
            }
        }
        $this->render('create');
    }

    /**
     * 规格删除
     */
    public function actionDelete()
    {
        $spec_id = Tool::getValidParam('spec_id','int');

        $result = Specification::model()->deleteAll('spec_id = :spec_id',array(':spec_id'=>$spec_id));
//        if (!$result) {
//            $Specification = new Specification();
//            $this->message('error',CHtml::errorSummary($Specification),$this->createUrl('index'));
//        }
        $result = SpecValues::model()->deleteAll('spec_id = :spec_id',array(':spec_id'=>$spec_id));
        if ($result) {
            $this->message('success','删除成功',$this->createUrl('index'));
        } else {
            $SpecValues = new SpecValues();
            $this->message('error',CHtml::errorSummary($SpecValues),$this->createUrl('index'));
        }
    }

    /**
     * 根据规格生成货品
     */
    public function actionAjaxspecproducts()
    {
        $goods_id = Tool::getValidParam('goods_id','int');
        $spec_str = trim(Tool::getValidParam('spec_str'),',');

        $GoodsTypeSpec = new GoodsTypeSpec();
        $list = $GoodsTypeSpec->SpecValue($spec_str,$goods_id);

        echo json_encode($list);
    }
}