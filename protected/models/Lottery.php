<?php

class Lottery extends CActiveRecord
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
        return '{{lottery_log}}';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mid,pid,openid,tro_level,type,tel,code,status,description,createtime', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'member'=>array(self::BELONGS_TO, 'Member','', 'on'=>'mid=member.id'),
            'trophy'=>array(self::HAS_ONE,'Trophy','','on'=>'tro_id=trophy.id'),
        );
    }
}