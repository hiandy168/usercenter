<?php
/**
 * 模型基础类，所有模型均需继承此类
 
 */

class B2CModel extends CDbCommand
{
    private $connection = null;
    public $img_url = '';
    public $cart_expire = 7200;
    public $table;

    public function __construct()
    {
        $this->connection = Mod::app()->db;
    }

    /**
     *
     * 连接状态
     */
    public function stats ()
    {
        return $this->connection ? 'connection successful!' : 'connection fail!';
    }

    /**
     * Controller 直接执行SQL
     *
     * @param $sql
     * @return mixed
     */
    public function ModelColumn($sql)
    {
        $command = $this->connection->createCommand($sql);
        $result = $command->queryColumn();
        return $result[0];
    }

    /**
     * 直接执行SQL
     *
     * @param $sql
     * @return mixed
     */
    public function ModelQueryRow($sql)
    {
        $command = $this->connection->createCommand($sql);
        $result = $command->queryRow();
        return $result;
    }

    /**
     * 直接执行SQL
     *
     * @param $sql
     * @return mixed
     */
    public function ModelQueryAll($sql)
    {
        $command = $this->connection->createCommand($sql);
        $result = $command->queryAll();
        return $result;
    }

    /**
     * 直接执行SQL
     *
     * @param $sql
     * @return mixed
     */
    public function ModelExecute($sql)
    {
        $command = $this->connection->createCommand($sql);
        $result = $command->execute();
        return $result;
    }

    /**
     * Update操作
     *
     * @param $table
     * @param $conditionArr
     * @param $params
     * @return mixed
     */
    public function ModelEdit($table,$conditionArr,$params)
    {
        $condition = $this->_ArrToSql($conditionArr);
        $set_str = $this->_ArrToSqlUpdate($params);
        return $this->ModelExecute("UPDATE {$table} SET $set_str WHERE $condition");
    }

    /**
     * Insert操作
     *
     * @param $table
     * @param $params
     * @return mixed
     */
    public function ModelInsert($table,$params)
    {
        $insert_data = $this->_ArrToSqlInsert($params);
        return $this->ModelExecute("INSERT INTO {$table} ({$insert_data['key']}) VALUE ({$insert_data['val']})");
    }
    
    
         
    public function insertAll($table,$data) {
		$sql = "insert into ".$table." %s VALUES %s";
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
   
   public function insertRow($table,$data) {
		$sql = "insert into ".$table." %s VALUES %s";
		$sqlValue = '';
                $keys = array_keys($data);
                foreach ($data as $key=>$val){
                        $sqlValue.= "'$val',";
                }
                $sqlValue = substr($sqlValue, 0, -1);
                $sqlV = "(".$sqlValue.")";
		$keys = '('.join(',', $keys).")";
		$sql = sprintf($sql, $keys, $sqlV);
		Mod::app()->db->createCommand($sql)->query();
                return  Mod::app()->db->getLastInsertID();
   }
    

    /**
     * 查询SQL
     *
     * @param string $select
     * @param string $condition
     * @return string
     */
    public function selectSql($select="*",$condition='')
    {
        $sql = "SELECT {$select} FROM {$this->table}";
        if ($condition) $sql .= " WHERE {$condition}";
        return $sql;
    }

    /**
     *  数组转SQL
     *
     * @param $data
     * @return string
     */
    private function _ArrToSql($data)
    {
        foreach ($data as $k=>$v) {
            $condition_arr[] = $k.'='."'".$v."'";
        }
        $condition = implode(' AND ',$condition_arr);

        return $condition;
    }

    /**
     *  数组转SQL
     *
     * @param $data
     * @return string
     */
    private function _ArrToSqlUpdate($data)
    {
        foreach ($data as $k=>$v) {
            $condition_arr[] = $k.'='."'".$v."'";
        }
        $condition = implode(' , ',$condition_arr);

        return $condition;
    }

    /**
     * 插入数据数组转SQL
     *
     * @param $data
     * @return array
     */
    private function _ArrToSqlInsert($data)
    {
        foreach ($data as $k=>$v) {
            if (!empty($v)) {
                $key[] = $k;
                $val[] = "'".$v."'";
            }
        }
        $key_str = implode(',',$key);
        $val_str = implode(',',$val);
        return array(
            'key'=>$key_str,
            'val'=>$val_str
        );
    }

    /**
     * 用户密码加密算法
     *
     * @param $source_str
     * @param $username
     * @param $createtime
     * @return string
     */
    public function extends_md5($source_str,$username,$createtime)
    {
        //密码的MD5值连接用户名和注册时间，再算MD5
        $string_md5 = md5(md5($source_str).$username.$createtime);
        //取上面MD5值的前31位
        $front_string = substr($string_md5,0,31);
        //在前面加上字符s
        $end_string = 's'.$front_string;
        return $end_string;
    }
    
    /**
     * GET 请求
     * @param string $url
     */
    public function http_get($url, $timeout=3) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
         //设置cURL允许执行的最长秒数。
        curl_setopt($oCurl,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($oCurl,CURLOPT_TIMEOUT,$timeout); 
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }    
}