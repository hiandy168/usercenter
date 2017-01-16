<?php

class Project extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{project}}';
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = $this->getCDbCriteria();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->params['pageSize'],
            ),
            'sort' => array(
                'defaultOrder' => array('createtime' => true, 'id' => true),
            ),
        ));
    }

    public function getCDbCriteria()
    {
        $criteria = new CDbCriteria;
        if ($this->salesman) {
            $criteria->compare('salesman', $this->salesman, true);
        }
        if ($this->company) {
            $criteria->compare('company', $this->company, true);
        }
        if ($this->vip_level) {
            $criteria->compare('vip_level', $this->vip_level);
        }
        $criteria->compare("is_deleted", 0);
        if ($this->discount)
            $criteria->compare("discount", "<>95");
        if ($this->create_time) {
            $times = explode("@", $this->create_time);
            $startTime = $times['0'];
            $endTime = $times['1'];
            $criteria->addBetweenCondition('create_time', $startTime, $endTime);
        }
        if ($this->usemoney) {
            $criteria->order = 'money ' . $this->usemoney;
        }
        if ($this->usepoints) {
            $criteria->order = 'points ' . $this->usepoints;
        }
        if ($this->allpoints) {
            $criteria->order = 'points_amount ' . $this->allpoints;
        }
        if ($this->debtinfo) {
            $criteria->order = 'debt ' . $this->debtinfo;
        }
        $criteria->addSearchCondition('username', $this->username);
        return $criteria;
    }

    public static function checkAppKey(){
        $appId = trim(Tool::getValidParam('appid','integer'));
        $appSecret = trim(Tool::getValidParam('appsecret','string'));
        $model = self::model()->findByAttributes(array('appid'=>$appId,'appsecret'=>$appSecret));
        if($model->mid){
            return $model->mid;
         }
        else{
            return null;
        }
    }

    /**
     * 获取项目列表
     * @param string $pid
     * @return array $list
     */
    public function getProjectList($pid,$mid){
        $list=array();
        if($pid && $mid){
            $project_model = self::model()->findByPk($pid);
            $list['now'] = $project_model;
            //项目列表
            $porject_list = self::model()->findAll("mid=:mid",array(":mid"=>$mid));
            $plist=array();
            if($porject_list){
                foreach ($porject_list as $k => $val) {
                    if($val->id != $project_model->id){
                        $plist[$k]['id'] = $val->id;
                        $plist[$k]['mid'] = $val->mid;
                        $plist[$k]['name'] = $val->name;
                    }
                }
                $list['other'] = $plist;
            }
        }

        return $list;
    }



}
