<?php

class Project_token extends CActiveRecord {

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
        return '{{project_token}}';
    }
    
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid,access_token,expires_in','safe'),
        );
    }

    /**
     * @param $access_token
     * @return pid
     */
    public  static function getPid($access_token){
        $model=self::model();
        $Project_token = $model->find('t.access_token=:access_token',array(':access_token'=>$access_token));
        return $Project_token->pid;
    }

    //验证accessToken
    public  function checkAccessToken($token)
    {
        return Project_token::model()->findByAttributes(array('access_token'=>$token));
    }
}
