<?php

class Product_spec extends CActiveRecord {

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
        return '{{product_spec}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
         //   array('category_id,title,keywords,description,content,copyfrom,auther,picture,tpl,order,status', 'safe'),
        );
    }

    function order_bat($ids,$res){
        $num = count($ids);
        $data = array();
        for($i=0;$i<$num;$i++){
                $data[] = array('id'=>$ids[$i],'order'=>$res[$i]);
                $count =$this->updateByPk($ids[$i],array('order'=>$res[$i])); 
        }
 
        return true;
    }
    
    static public function insertAll($data) {
		$sql = "insert into {{product_spec}} %s VALUES %s";
		$sqlValue = '';
		foreach($data as $k => $value) {
			$keys = array_keys($value);
			foreach ($value as $key=>$val){
				$sqlValue.= "'$val',";
			}
			$sqlValue = substr($sqlValue, 0, -1);
			$sqlV[] = "(".$sqlValue.")";
			$sqlValue='';
		}
		 
		$keys = '('.join(',', $keys).")";
		$sqlVs = join(',', $sqlV);
		$sql = sprintf($sql, $keys, $sqlVs);
		Mod::app()->db->createCommand($sql)->query();
	
	}
        
    
         

}
