<?php

class Member_behavior extends CActiveRecord {

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
        return '{{member_behavior}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pid,type,createtime,remark,updatetime,status,day,month,year,ip','safe', 'on'=>'create'),
        );
    }

    public function relations(){
        return array(
            'minfo'=>array(self::BELONGS_TO,'Member', '' ,'on'=>'t.mid=minfo.id' 
        ));
    }
    
    /**
     * 我的日历列表
     * @param string $condition
     * @param int $page
     * @param int $pageSize
     * @return array 
     */
    public function getBehaviorList($condition = '',$page = 1,$pageSize = 10){
        $criteria = new CDbCriteria();
        $criteria->condition = $condition;           
        $count = $this->count($criteria);
        $pageCount = ceil($count/$pageSize);
        $criteria->order = 'createtime desc';
        $criteria->limit = $pageSize;
        $criteria->offset = ($page-1)*$pageSize;
        $behavior['count'] = $count;
        $behavior['pageCount'] = $pageCount;
        
        //是否存在本月记录
        $behavior['code'] = 0;
        if($count){
            $behavior['code'] = 1;
        }
        
        foreach($this->findAll($criteria) as $k=>$v){
            $behavior['list'][$k]['eventDay'] = date('d',$v->createtime);
            $behavior['list'][$k]['title'] = $this->status($v->type);
            $behavior['list'][$k]['remark'] = date('Y-m-d H:i:s',$v->createtime);
            
        }
                
        return $behavior;
    }
    
    /**
     * 
     * @param int $mid
     * @param int $pid
     * @param string $openid
     * @param tinyint $type 1登录,2注册,3签到,4红包
     * @return int
     */
    static public function report($mid, $pid, $openid, $type, $ip='') {
        $behavior = new self();
        $behavior->openid = $openid;
        $behavior->pid = $pid;
        $behavior->mid = $mid;
        $behavior->type = $type;
        $behavior->createtime = time();
        $behavior->year = date('Y');
        $behavior->month = date('m');
        $behavior->day = date('d');
        $behavior->ip = $ip;
        if ($behavior->save()) {
            return 1;
        } else {
            return 0;
        }
    }
    
    static public function status($type) {
        $behaviorType = new Member_behavior_type();
        $result = $behaviorType->findByPk($type);
        return $result->name;
    }
   
}
