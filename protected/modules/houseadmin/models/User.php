<?php

class User extends CActiveRecord {

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
        return '{{user}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, password,group_id,admin,source','required', 'on'=>'create,edit'),
            array('id,password,name,email,tel,address,regip,lastloginip,lastlogintime,regtime,status,admin,remark,source', 'safe'),
        );
    }
    
    public function relations()
    {
        return array(
//            'usergroup'=>array(self::HAS_ONE, 'usergroup', 'group_id'),
            'Usergroup'=>array(self::BELONGS_TO, 'Usergroup', 'group_id'),
        );
    }
    
        
     function get_user_token($user,$lang='zh_cn'){
              if(isset($user) && !empty($user)){
                    $sql = "select * from {{setting}} where `name`='site_safe_code' and  `lang`='".$lang."'";
                    $res_setting =  Mod::app()->db->createCommand($sql)->queryRow();
                    $cmskey= isset($res_setting['value'])?$res_setting['value']:'9open';
                    return  md5(base64_encode($user['id'].$user['name'].$user['password'].$cmskey));
                }else{
                     return false;
                }
    }
         
     public function getHitslist($limit=10,$type='')
	{

                $data = array();
                $criteria = new CDbCriteria() ;     
                $criteria -> condition = 'status = 1';
                $criteria -> join = 'right join {{wx_hits}} as h on t.id =h.wx_id';
                $criteria->with ='hits';
                if($type == 'day'){
                     $criteria ->addCondition("day(h.date)=day(now())");
                     $criteria -> order = 'h.d_hits,t.id desc';
                }else if($type == 'week'){
                     $criteria ->addCondition("week(h.date)=week(now())");
                     $criteria -> order = 'h.w_hits,t.id desc';
                }else if($type == 'month'){
                     $criteria ->addCondition("month(h.date)=month(now())");
                     $criteria -> order = 'h.m_hits,t.id desc';
                }
                
                $criteria -> limit = $limit;
                $result = $this->findAll($criteria); 
    
                foreach ($result as $k=>$ob){  
                                $data[$k] = $ob->attributes;  
                                $data[$k]['d_hits'] = $ob->hits->d_hits;
                                $data[$k]['w_hits'] = $ob->hits->w_hits;
                                $data[$k]['m_hits'] = $ob->hits->m_hits;
                            }   
                return $data;
                                
	}
         

}
