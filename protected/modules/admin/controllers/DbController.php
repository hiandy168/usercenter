<?php

class DbController extends AController {

    private $_bakupPath;

    public function init() {
        parent::init();
        $this->_bakupPath = $this->_wwwPath . 'data' . DIRECTORY_SEPARATOR . 'db_bak'.DIRECTORY_SEPARATOR;
    }

    /**
     * 首页
     */
    public function actionIndex() {
        $this->check_permission(__CLASS__, 'index');
        $dataList = Mod::app()->db->createCommand("SHOW TABLE STATUS")->queryAll();
        $dataSize = 0;
        foreach ($dataList as $v) {
            $dataSize += $v['Data_length'];
        }
        $this->renderPartial('index', array('dataSize' => $dataSize, 'dataList' => $dataList));
    }

    /**
     * 执行查询
     */
    public function actionQuery() {
        $this->renderPartial('query', array());
    }

    /**
     * 执行相关命令
     */
    public function actionDoQuery() {

            $command = $this->_gets->getParam('command');
            $table = $this->_gets->getParam('id');
            empty($table) && exit('表必须选择');
            $tb = implode(',', $table);
            switch ($command) {
                case 'optimzeTable':
                    self::_execute("OPTIMIZE TABLE {$tb}");
                    break;
                case 'checkTable':
                    self::_execute("CHECK TABLE {$tb}");
                    break;
                case 'analyzeTable':
                    self::_execute("ANALYZE TABLE {$tb}");
                    break;
                case 'repairTable':
                    self::_execute("REPAIR TABLE {$tb}");
                    break;
                case 'showTable':
                    $table = explode(',', $tb);
                    foreach ((array) $table as $tb)
                        self::_execute("SHOW COLUMNS FROM {$tb}");
                    break;
                default:

                    break;
            }

    }

    /**
     * 执行sql
     */
    public function actionExecute() {
            $sql = $this->_gets->getParam('command');
//            echo $sql;die;
            $sqls = self::_sqlSplit($sql);
            foreach ($sqls as $execute)
                self::_execute($execute);
    }

    /**
     * 导出
     */
    public function actionExport() {

        $this->renderPartial('export');
    }

    /**
     * 导出数据
     */
    public function actionDoExport() {
        $dosubmit = $this->_gets->getParam('dosubmit');
        if ($dosubmit) {
            $tables = Mod::app()->db->schema->tableNames;

            $sqlcharset = $this->_gets->getParam('sqlcharset');
            $sqlcompat = $this->_gets->getParam('sqlcompat');
            $sizelimit = $this->_gets->getParam('sizelimit');
            $fileid = $this->_gets->getParam('fileid');
            $random = $this->_gets->getParam('random');
            $tableid = $this->_gets->getParam('tableid');
            $startfrom = $this->_gets->getParam('startfrom');
            $tabletype = $this->_gets->getParam('tabletype');
            
            self::exportDatabase($tables, $sqlcompat, $sqlcharset, $sizelimit, $fileid, $random, $tableid, $startfrom, $tabletype);
        }
    }

    /**
     * 数据备份
     * @param  $tables
     * @param  $sqlcompat
     * @param  $sqlcharset
     * @param  $sizelimit
     * @param  $fileid
     * @param  $random
     * @param  $tableid
     * @param  $startfrom
     * @param  $tabletype
     */
    private function exportDatabase($tables, $sqlcompat, $sqlcharset, $sizelimit, $fileid, $random, $tableid, $startfrom, $tabletype) {
        $dumpcharset = $sqlcharset ? $sqlcharset : 'UTF8';

        $fileid = ($fileid != '') ? $fileid : 1;
        if ($fileid == 1 && $tables)
            $random = mt_rand(1000, 9999);

        if (Mod::app()->db->serverVersion > '4.1') {
            if ($sqlcharset) {
                Mod::app()->db->createCommand("SET NAMES '" . $sqlcharset . "';\n\n")->execute();
            }
            if ($sqlcompat == 'MYSQL40') {
                Mod::app()->db->createCommand("SET SQL_MODE='MYSQL40'")->execute();
            } elseif ($sqlcompat == 'MYSQL41') {
                Mod::app()->db->createCommand("SET SQL_MODE=''")->execute();
            }
        }

        $tabledump = '';

        $tableid = ($tableid != '') ? $tableid - 1 : 0;
        $startfrom = ($startfrom != '') ? intval($startfrom) : 0;

        for ($i = $tableid; $i < count($tables) && strlen($tabledump) + 500 < $sizelimit * 1000; $i ++) {
            global $startrow;
            $offset = 100;
            if (!$startfrom) {

                $tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
                $createtable = Mod::app()->db->createCommand("SHOW CREATE TABLE `$tables[$i]` ")->queryAll(false);
                $tabledump .= $createtable[0][1] . ";\n\n";

                if ($sqlcompat == 'MYSQL41' && Mod::app()->db->serverVersion < '4.1') {
                    $tabledump = preg_replace("/TYPE\=([a-zA-Z0-9]+)/", "ENGINE=\\1 DEFAULT CHARSET=" . $dumpcharset, $tabledump);
                }
                if (Mod::app()->db->serverVersion > '4.1' && $sqlcharset) {
                    $tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=" . $sqlcharset, $tabledump);
                }
                /* if($tables[$i]==DB_PRE.'session') {
                  $tabledump = str_replace("CREATE TABLE `".DB_PRE."session`", "CREATE TABLE IF NOT EXISTS `".DB_PRE."session`", $tabledump);
                  } */
            }

            $numrows = $offset;
            while (strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
                $sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";

                $exe = Mod::app()->db->createCommand($sql);

                $q = $exe->queryAll();
                $numrows = count($q);
                if($numrows){
                $keys = array_keys((array) $q[0]);
                $numfields = count($keys);
                $r = array();
                $rows = $exe->query();
                foreach ((array) $q as $row) {
                    $r[] = $row;
                    $comma = "";
                    $tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
                    //for ($j = 0; $j < $numfields; $j ++) {
                    foreach ($keys as $k) {
                        $tabledump .= $comma . "'" . mysql_escape_string($row[$k]) . "'";
                        $comma = ",";
                    }
                    $tabledump .= ");\n";
                }
                }
                $startfrom += $offset;
            }
            $tabledump .= "\n";
            $startrow = $startfrom;
            $startfrom = 0;
        }

        if (trim($tabledump)) {
            $tabledump = "/*time:" . date('Y-m-d H:i:s') . "\n# --------------------------------------------------------#\n*/\n\n" . $tabledump;
            $tableid = $i;
            $filename = $tabletype . '_' . date('Ymd') . '_' . $random . '_' . $fileid . '.sql';
            $altid = $fileid;
            $fileid ++;

            $bakfile = $this->_bakupPath . $filename;
            file_put_contents($bakfile, $tabledump);
            $this->admin_message("备份文件 $filename 写入成功!", $this->createUrl('db/doExport', array('sizelimit' => $sizelimit, 'tableid' => $tableid, 'fileid' => $fileid, 'random' => $random, 'startfrom' => $startrow, 'dosubmit' => 1, 'sqlcompat' => $sqlcompat, 'sqlcharset' => $sqlcharset, 'tabletype' => $tabletype)));
        } else {
            @file_put_contents($this->_bakupPath . 'index.html', '');
            $this->redirect($this->createUrl('db/export'));
        }
    }

    /**
     * 导入数据
     */
    public function actionImport() {
        if ($this->_gets->getParam('dosubmit')) {
            $pre = urldecode(trim($this->_gets->getParam('pre')));
            $fileid = $this->_gets->getParam('fileid');
            self::_import($pre, $fileid);
        } else {

            $sqlfiles = glob($this->_bakupPath . '*.sql');
            if (is_array($sqlfiles)) {
                asort($sqlfiles);
                $prepre = '';
                $info = $infos = $other = $others = array();
                foreach ($sqlfiles as $id => $sqlfile) {
                    if (preg_match("/(9open_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i", basename($sqlfile), $num)) {
                        $info['filename'] = basename($sqlfile);
                        $info['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
                        $info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                        $info['pre'] = $num[1];
                        $info['number'] = $num[2];
                        if (!$id)
                            $prebgcolor = '#CFEFFF';
                        if ($info['pre'] == $prepre) {
                            $info['bgcolor'] = $prebgcolor;
                        } else {
                            $info['bgcolor'] = $prebgcolor == '#F2F9FD' ? '' : '#F2F9FD';
                        }
                        $prebgcolor = $info['bgcolor'];
                        $prepre = $info['pre'];
                        $infos[] = $info;
                    } else {
                        $other['filename'] = basename($sqlfile);
                        $other['filesize'] = round(filesize($sqlfile) / (1024 * 1024), 2);
                        $other['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
                        $others[] = $other;
                    }
                }
            }
            $show_validator = true;
            $this->renderPartial('import', array('infos' => $infos, 'otherData' => $others));
        }
    }

    /**
     * 数据恢复
     * @param  $filename
     * @param  $fileid
     */
    private function _import($filename, $fileid) {
        if ($filename && CFileHelper::getExtension($filename) == 'sql') {
            $filepath = $this->_bakupPath . $filename;
            if (!file_exists($filepath))
                      $this->admin_message('文件不存在',$this->createUrl('db/import'));
            $sql = file_get_contents($filepath);
            self::_sqlExecute($sql);
            $this->admin_message($filename . '中的数据成功导入', $this->createUrl('db/import'));
        } else {
            $fileid = $fileid ? $fileid : 1;
            $pre = $filename;
            $filename = $filename . $fileid . '.sql';
            $filepath = $this->_bakupPath . $filename;
            if (file_exists($filepath)) {
                $sql = file_get_contents($filepath);
                $this->_sqlExecute($sql);
                $fileid ++;

                $this->admin_message('数据文件' . $filename . ' 导入成功', $this->createUrl('db/import', array('pre' => $pre, 'fileid' => $fileid, 'dosubmit' => '1')));
            } else {
                $this->admin_message('数据成功导入', $this->createUrl('db/import'));
            }
        }
    }

    /**
     * 执行SQL
     * @param  $sql
     */
    private function _sqlExecute($sql) {
        $sqls = self::_sqlSplit($sql);
        if (is_array($sqls)) {
            foreach ($sqls as $sql) {
                if (trim($sql) != '') {
                    Mod::app()->db->createCommand($sql)->execute();
                }
            }
        } else {
            Mod::app()->db->createCommand($sql)->execute();
        }
        return true;
    }

    /**
     * 拆分sql
     * @param  $sql
     */
    private function _sqlSplit($sql) {
        if (Mod::app()->db->serverVersion > '4.1' && Mod::app()->db->charset) {
            $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=" . Mod::app()->db->charset, $sql);
        }
        if (Mod::app()->db->tablePrefix != "os_")
            $sql = str_replace("`os_", '`' . Mod::app()->db->tablePrefix, $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num ++;
        }
        return ($ret);
    }

    /**
     * 执行sql
     */
    private function _execute($command = '') {
        $exeSql = empty($command) ? trim($this->_gets->getParam('command')) : $command;
        $formatExeSql = $this->splitsql($exeSql);
        foreach ($formatExeSql as $sql) {
            if (empty($sql))
                continue;
            try {
                $resultData = self::_executeCommand($sql);
                if (false !== $resultData['result']) {
                    if ($resultData['type'] == 'query') {
                        if (empty($resultData['result']))
                            echo '执行完成';
                        $fields = array_keys($resultData['result'][0]);
                        echo $this->renderPartial('query_result', array('fields' => $fields, 'dataList' => $resultData['result'], 'command' => $command), true);
                    } else {
                        echo "<div style='color:red;padding:10px 0'>执行完成: {$sql}</div>";
                    }
                } else {
                    echo "执行失败";
                }
            } catch (Exception $e) {
                echo "<div style='color:red;padding:10px 0'>执行失败: {$sql}</div>";
            }
        }
    }

    /**
     * 查询分析器
     * @param  $sql
     */
    private function _executeCommand($sql = '') {

        if ( ini_get('magic_quotes_gpce')=='on') {
            $sql = stripslashes($sql);
        }
        if (empty($sql))
            exit('SQL不能为空');

        $queryType = 'INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|SELECT .* INTO|COPY|ALTER|GRANT|TRUNCATE|REVOKE|LOCK|UNLOCK';
        if (preg_match('/^\s*"?(' . $queryType . ')\s+/i', $sql)) {
            $data['result'] = Mod::app()->db->createCommand($sql)->execute();
            $data['type'] = 'execute';
        } else {
            $data['result'] = Mod::app()->db->createCommand($sql)->queryAll();
            $data['type'] = 'query';
        }

        return $data;
    }

    /**
     * 批处理
     */
    public function actionOperate() {
        $command = trim($this->_gets->getParam('command'));

        switch ($command) {
            case 'deleteFile':
                $filenames = $this->_gets->getParam('sqlfile');

                if ($filenames) {
                    if (is_array($filenames)) {
                        foreach ($filenames as $filename) {
                            if (CFileHelper::getExtension($filename) == 'sql') {
                                @unlink($this->_bakupPath . $filename);
                            }
                        }

                        $this->admin_message( '删除完成', $this->createUrl('db/import'));
                    } else {
                        if (CFileHelper::getExtension($filenames) == 'sql') {
                            @unlink($this->_bakupPath . $filename);
                            $this->admin_message( '删除完成', $this->createUrl('db/import'));
                        }
                    }
                } else {
                    $this->admin_message( '请选择要删除的文件', $this->createUrl('db/import'));
                }

                break;
            case 'downloadFile':
                $sqlfile = $this->_gets->getParam('sqlfile');
                Http::download($this->_bakupPath . $sqlfile, '', '', 3600);
                break;
            default:
                throw new CHttpException(404, '未找到操作');
                break;
        }
    }
    
     /**
     * 拆分sql
     *
     * @param $sql
     */
    public static function splitsql( $sql ) {
         $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=" . Mod::app()->db->charset, $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array ();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-')
                    $ret[$num] .= $query;
            }
            $num ++;
        }
        return ($ret);
    }

}
