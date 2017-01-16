<?php

/**
 * "car_desktop_users" ���ݱ�ģ����.
 *
 
 * @copyright     Copyright (c) 2007-2014 shop.feipin0512. All rights reserved.
 * @link          http://shop.feipin0512.com
 * @package       yiishop.model
 * @license       http://www.shop.feipin0512.com/license
 
 */
class AdminUsers extends BaseModel
{
    public $role;
    /**
     * @return string ��ص����ݿ�������
     */
	public function tableName()
	{
		return '{{admin_users}}';
	}

    /**
     * @return string ��ص����ݿ�������
     */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, logincount', 'numerical', 'integerOnly'=>true),
			array('status, super', 'length', 'max'=>1),
			array('name', 'length', 'max'=>30),
			array('lastlogin', 'length', 'max'=>10),
			array('lastip', 'length', 'max'=>20),
			array('disabled', 'length', 'max'=>5),
			array('op_no', 'length', 'max'=>50),
			array('config, favorite, memo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, status, name, lastlogin, config, favorite, super, lastip, logincount, disabled, op_no, memo', 'safe', 'on'=>'search'),
		);
	}

    /**
     * @return array ��ģ�͵�������֤����.
     */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

    /**
     * @return array ��ģ�͵�������֤����.
     */
	public function attributeLabels()
	{
		return array(
			'user_id' => '��̨�û�ID',
			'status' => '����',
			'name' => '����',
			'lastlogin' => '����¼ʱ��',
			'config' => '������Ϣ',
			'favorite' => '����',
			'super' => '��������Ա',
			'lastip' => '�ϴε�¼ip',
			'logincount' => '��¼����',
			'disabled' => 'Disabled',
			'op_no' => '����Աno',
			'memo' => '��ע',
			'password' => '����',
		);
	}

    /**
     * ����ָ����AR��ľ�̬ģ��.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Admin the static model class
     */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
