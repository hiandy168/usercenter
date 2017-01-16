<?php

class InstallController extends CController
{
    public $_wwwPath;
    public $datapath ;
    public $configPath ;
    public $site_config;
    public $_theme_url;
    public $lockfile = 'install.lock';
    public function init(){
        parent::init();
        error_reporting(E_ALL);
		header("Content-type: text/html; charset=utf-8");
        $this->_wwwPath = Mod::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
        $this->datapath = $this->_wwwPath.'data'.DIRECTORY_SEPARATOR;
        $this->configPath = Mod::app()->basePath.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;
        Mod::app()->setTheme($this->site_config['site_template']?$this->site_config['site_template']:'default');//设置视图路径
        $this->_theme_url = Mod::app()->theme->baseUrl.'/';
        $this->check_install(); //检查是否被安装
    }

    /**
     * 检测是否已经安装
     */
    private function check_install(){
        if(is_file($this->_wwwPath.'data'.DIRECTORY_SEPARATOR.'install.lock')){
             $this->render('complete');die;
        }
    }

   
    /**
     * 安装程序首页
     */
    public function actionIndex (){
        if(isset($_REQUEST['step'])&&$_REQUEST['step']){
            $step = $_REQUEST['step'];
             switch ($step) {
                    case 1:
                        $this->Env();
                        break;
                    case 2:
                        $this->Db();
                        break;
                    case 3:
                        $this->Progress();
                        break;
                    case 4:
                        $this->Complete();
                        break;
            }
        }else  if(isset($_REQUEST['dbcheck'])&&$_REQUEST['dbcheck']){
             $this->DbCheck();
        }else{
            $data['title'] = '安装前阅读协议';
            $this->render('index', $data);
        }
       

    }

  

    /**
     * 检测目录能否读写
     */
    protected function _isWritable($file){
        if(is_writable($file)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 环境检测
     */
    public function Env ()
    {
       $isWritable = array(
            array(
                '私有临时文件(protected/runtime)',
                self::_isWritable(Mod::app()->runtimePath),
                '系统核心运行必须的目录,如缓存log等，要求可读写',
            ),
           array(
                '数据目录(data)',
                self::_isWritable($this->_wwwPath.'data'),
                '数据库备份',
            ),
            array(
                '附件上传目录(data/attachment)',
                self::_isWritable($this->_wwwPath.'data/attachment'),
                '附件上传',
            ),
            array(
                '配置文件目录(protected/config)',
                self::_isWritable($this->_wwwPath.'protected'.DIRECTORY_SEPARATOR.'config'),
                '安装程序',
            ),
            array(
                '公共资源文件(assets)',
                self::_isWritable($this->_wwwPath.'assets'),
                '系统核心公共资源文件',
            ),

       );
       
        $requirements=array(
            array(
                'PHP版本',
                 version_compare(PHP_VERSION,"5.1.0",">="),
                'PHP 5.1.0 或更高版本是必须的.',
                ),
            array(
                '$_SERVER 服务器变量',
                '' === $message=  self::checkServerVar(),
                '系统核心'.$message
                ),
            array(
                'DOM 扩展模块',
                class_exists("DOMDocument",false),
                'CHtmlPurifier, CWsdlGenerator',
                ),
            array(
                'PDO 扩展模块',
                extension_loaded('pdo'),
                '所有和使用PDO数据库连接相关的类',
                ),
            array(
                'PDO MySQL 扩展模块',
                extension_loaded('pdo_mysql'),
                '使用MYSQL必须支持',
                ),
            array(
                'GD 扩展模块',
                '' === $message=  self::checkCaptchaSupport(),
                'CCaptchaAction'.$message,
                ),
    
        );
        $nopass=false;
        $requireResult = 1; 
        foreach($requirements as $i=>$requirement)
        {
            if(!$requirement[1]){$requireResult=0;break; }
        }
        
        $writeableResult = 1; 
        foreach($isWritable as $k=>$val)
        {
            if(!$val[1]){$writeableResult=0;break; }
        }
        
        if(!$requireResult || !$writeableResult){
            $nopass = true;
        }
        
        $data = array(
            'isWritable'=>$isWritable,
            'requirements'=>$requirements,
            'nopass'=>$nopass
        );
       $this->render('env', $data);
    }

    /**
     * 数据库信息设置
     */
    public function Db ()
    {
       $data = array();
       $this->render('db', $data);
    }

    /**
     * 追加安装日志
     */
    private function _doLog($message, $callBack = false){
        if($callBack)
               $callBack = " <a href='".$this->createUrl('/install/index/',array('step'=>2))."' style='color:#ff0000'>返回检查</a>";
        echo '<script>$("#dolog").append("'.$message.$callBack.'<br />");</script>';
    }

 
    public function Progress(){
        ob_end_clean(); 
        $dbHost = Tool::getValidParam('dbHost','string');
        $dbName = Tool::getValidParam('dbName','string');
        $dbUsername = Tool::getValidParam('dbUsername','string');
        $dbPassword = Tool::getValidParam('dbPassword','string');
        $dbFix = Tool::getValidParam('dbFix','string');
        $username = Tool::getValidParam('username','string');
        $password = Tool::getValidParam('password','string');
        $email = Tool::getValidParam('email','string');
        $this->render('progress');
        try {
            $dbObj = new CDbConnection('mysql:host='.$dbHost.';',$dbUsername,$dbPassword);
            $dbObj->active = true;
            $dbObj->createCommand("USE {$dbName}")->execute();
            self::_doLog('数据库信息检测通过');
            $config_db_ini = @file_get_contents($this->configPath.'/db_install.php');
            $config_db_ini = str_replace(array('~dbHost~','~dbName~', '~dbUsername~', '~dbPassword~', '~dbFix~'), array($dbHost, $dbName, $dbUsername, $dbPassword, $dbFix), $config_db_ini);
            //写入数据库配置信息
            file_put_contents($this->configPath.'/db.php', $config_db_ini);
            self::_doLog('配置文件写入成功');

            //创建数据库
            $tableSql = @file_get_contents($this->datapath.'install.sql');
            $tableSql = str_replace('~dbFix~',$dbFix,$tableSql);
            
            $dbObj->createCommand("SET NAMES 'utf8',character_set_client=binary,sql_mode=''")->execute();
            $sqls = self::_splitsql($tableSql);
            if (is_array($sqls)) {
                foreach ($sqls as $sql) {
                     if (trim($sql) != '' && strstr($sql,'CREATE TABLE')){
                           preg_match('/CREATE TABLE \`(.+?)`/', $sql, $name);
                            self::_doLog('创建表 '.$name[1].' <span style=\'color:#ff0000\'>成功</span><br />');
                            echo '<script type="text/javascript">scrollWindow();</script>';
                     }
                    $dbObj->createCommand(str_replace('#@__', $dbFix, $sql))->execute();
                }
            } else {
                $dbObj->createCommand($sql)->execute();
            }
            self::_doLog('数据库创建完成<br><span style=\"color:#ff0000\">创建成功！</span><br>');
            echo '<script type="text/javascript">scrollWindow();</script>';

            //写入默认信息
             $source = Tool::random_keys(5);//随机生成5位字符串
             $password = Tool::md5str($password,$source);
                
            $dbObj->createCommand("INSERT INTO `".$dbFix."member`(`name`,`password`,`source`,`group_id`, `email`,`regtime`,`admin`) VALUES('".$username."','".$password."','".$source."','1','".$email."', ".time().",'1');")->execute();

            //写入锁定文件
            @touch($this->datapath.$this->lockfile);
//            echo '<script>window.location="'.$this->createUrl('install/index/',array('step'=>4)).'"</script>';
            echo '<script>$("#submit_next").show();</script>';
        } catch (Exception $e) {
            $error = self::_dbError($e->getMessage(), array('dbHost'=>$dbHost, 'dbName'=>$dbName));
            if($error == false)
                self::_doLog($e->getMessage(), true);
            else
                self::_doLog($error, true);
        }
        
        self::_doLog("<br>");
        //            sleep(1);
        print str_pad("", 1024);
        @ob_flush();         //@禁止显示错误，如果前面没有缓冲内容，ob_flush是会出错的
        flush();   
            
    }
    
    /**
     * 安装完成
     */
    public function Complete (){
        $this->render('complete');
    }

    /**
     * 数据库错误信息
     */
    private function _dbError($message, $params = array()){

        if(preg_match('/Unknown database|1049/', $message))
            return '未找到数据库: '.$params['dbName']. ' 请先创建该库';
        elseif(preg_match('/failed to open the DB/', $message))
            return '连接失败，请检查数据库配置';
        elseif(preg_match('/1044/', $message))
            return '当前用户没有访问数据库的权限';
        else
            return false;
    }

     /**
     * 数据库信息检测
     */
    public function DbCheck(){
        $dbHost = Tool::getValidParam('dbHost','string');
        $dbName = Tool::getValidParam('dbName','string');
        $dbUsername = Tool::getValidParam('dbUsername','string');
        $dbPassword = Tool::getValidParam('dbPassword','string');
        try {
            if(empty($dbHost) || empty($dbName) || empty($dbUsername) || empty($dbPassword))
                throw new Exception('数据库信息必须填写完整');
            $dbObj = new CDbConnection('mysql:host='.$dbHost,$dbUsername,$dbPassword);
            $dbObj->active = true;
            $dbObj->createCommand("USE {$dbName}")->execute();
            $var['state'] = 'success';
            $var['mess'] = '连接成功';
        } catch (Exception $e) {
            $var['state'] = 'error';
            $error = self::_dbError($e->getMessage(), array('dbHost'=>$dbHost, 'dbName'=>$dbName));
            if($error == false)
                $var['mess'] = '数据库连接失败，请检查数据库配置信息是否正确';
            else
                $var['mess'] = $error ;
        }
         echo json_encode($var);exit;
    }

    /**
     * 拆分sql
     *
     * @param $sql
     */
    protected function _splitsql( $sql ) {
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=UTF8", $sql);
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
                    //$ret[$num] .= XUtils::autoCharset($query,'gbk','utf-8');
            }
            $num ++;
        }
        return ($ret);
    }


    /**
     * 检测服务器变量
     */
    function checkServerVar()
    {
        $vars=array('HTTP_HOST','SERVER_NAME','SERVER_PORT','SCRIPT_NAME','SCRIPT_FILENAME','PHP_SELF','HTTP_ACCEPT','HTTP_USER_AGENT');
        $missing=array();
        foreach($vars as $var)
        {
            if(!isset($_SERVER[$var]))
                $missing[]=$var;
        }
        if(!empty($missing))
            return '$_SERVER缺少{vars}。';
       /* if(realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__))
            return '$_SERVER["SCRIPT_FILENAME"]必须与入口文件路径一致。';*/

        if(!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"]))
            return '$_SERVER["REQUEST_URI"]或$_SERVER["QUERY_STRING"]必须存在。';
        if(!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"],$_SERVER["SCRIPT_NAME"]) !== 0)
            return '无法确定URL path info。请检查$_SERVER["PATH_INFO"]（或$_SERVER["PHP_SELF"]和$_SERVER["SCRIPT_NAME"]）的值是否正确。';
        return '';
    }

    /**
     * 检测图片处理类
     */
    function checkCaptchaSupport()
    {
        if(extension_loaded('imagick'))
        {
            $imagick=new Imagick();
            $imagickFormats=$imagick->queryFormats('PNG');
        }
        if(extension_loaded('gd'))
            $gdInfo=gd_info();
        if(isset($imagickFormats) && in_array('PNG',$imagickFormats))
            return '';
        elseif(isset($gdInfo))
        {
            if($gdInfo['FreeType Support'])
                return '';
            return 'GD库已安装,<br />FreeType未安装';
        }
        return 'GD or ImageMagick 均未安装';
    }
    
    
    
}