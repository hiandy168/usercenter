<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 9:41
 */

class SignUpForm extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        //用户报名表
        return '{{member_signup_form}}';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sid,title,value,isempty,status,createtime,updatetime', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'member'=>array(self::BELONGS_TO, 'Member','', 'on'=>'mid=member.id'),
        );
    }
}