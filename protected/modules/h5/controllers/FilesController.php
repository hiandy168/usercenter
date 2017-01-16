<?php

class FilesController extends CController {
    public  $root_path;
//    public function init() {
//        parent::init();
//        //根目录路径，可以指定绝对路径，比如 /var/www/attached/
//        $this->root_path = 'data/attachment/';
//    }
//
//    public function actionFile_manager() {
//        if(isset($_POST['PHPSESSID'])){
////        file_put_contents('text3.txt', var_export($_REQUEST,1),FILE_APPEND);
//                    Mod::app()->session->close();
//                    Mod::app()->session->sessionID = $_POST['PHPSESSID'];
//                    Mod::app()->session->open();
//        }
//        $member = Mod::app()->session['admin_member'];
//
//        if(!$member['id']){
//                $result = array('error'=>1,'message'=>'没有权限');
//                echo json_encode($result);exit;
//        }
//        //根目录路径，可以指定绝对路径，比如 /var/www/attached/
//        $root_path = $this->root_path;
//        //根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
//        $root_url =  Mod::app()->baseUrl.'/'.$root_path;
//        //图片扩展名
//        $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
//
//        //目录名
//        $dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
//        if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
//            echo "Invalid Directory name.";
//            exit;
//        }
//        if ($dir_name !== '') {
//            $root_path .= $dir_name . "/";
//            $root_url .= $dir_name . "/";
//            if (!file_exists($root_path)) {
//                mkdir($root_path);
//            }
//        }
//
//        //根据path参数，设置各路径和URL
//        if (empty($_GET['path'])) {
//            $current_path = realpath($root_path) . '/';
//            $current_url = $root_url;
//            $current_dir_path = '';
//            $moveup_dir_path = '';
//        } else {
//            $current_path = realpath($root_path) . '/' . $_GET['path'];
//            $current_url = $root_url . $_GET['path'];
//            $current_dir_path = $_GET['path'];
//            $moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
//        }
//        //echo realpath($root_path);
//        //排序形式，name or size or type
//        $order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
//
//        //不允许使用..移动到上一级目录
//        if (preg_match('/\.\./', $current_path)) {
//            echo 'Access is not allowed.';
//            exit;
//        }
//        //最后一个字符不是/
//        if (!preg_match('/\/$/', $current_path)) {
//            echo 'Parameter is not valid.';
//            exit;
//        }
//        //目录不存在或不是目录
//        if (!file_exists($current_path) || !is_dir($current_path)) {
//            echo 'Directory does not exist.';
//            exit;
//        }
//
//        //遍历目录取得文件信息
//        $file_list = array();
//        if ($handle = opendir($current_path)) {
//            $i = 0;
//            while (false !== ($filename = readdir($handle))) {
//                if ($filename{0} == '.')
//                    continue;
//                $file = $current_path . $filename;
//                if (is_dir($file)) {
//                    $file_list[$i]['is_dir'] = true; //是否文件夹
//                    $file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
//                    $file_list[$i]['filesize'] = 0; //文件大小
//                    $file_list[$i]['is_photo'] = false; //是否图片
//                    $file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
//                } else {
//                    $file_list[$i]['is_dir'] = false;
//                    $file_list[$i]['has_file'] = false;
//                    $file_list[$i]['filesize'] = filesize($file);
//                    $file_list[$i]['dir_path'] = '';
//                    $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
//                    $file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
//                    $file_list[$i]['filetype'] = $file_ext;
//                }
//                $file_list[$i]['filename'] = $filename; //文件名，包含扩展名
//                $file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
//                $i++;
//            }
//            closedir($handle);
//        }
//
//        usort($file_list,array("tool", "cmp_func"));
//
//        $result = array();
//        //相对于根目录的上一级目录
//        $result['moveup_dir_path'] = $moveup_dir_path;
//        //相对于根目录的当前目录
//        $result['current_dir_path'] = $current_dir_path;
//        //当前目录的URL
//        $result['current_url'] = $current_url;
//        //文件数
//        $result['total_count'] = count($file_list);
//        //文件列表数组
//        $result['file_list'] = $file_list;
//
//        echo json_encode($result);
//    }
//
//    public  function actionUpload() {
//
//        if(isset($_POST['PHPSESSID'])){
////        file_put_contents('text3.txt', var_export($_REQUEST,1),FILE_APPEND);
//                    Mod::app()->session->close();
//                    Mod::app()->session->sessionID = $_POST['PHPSESSID'];
//                    Mod::app()->session->open();
//        }
//        $member = Mod::app()->session['admin_member'];
//
//
//
//
//        //文件保存目录路径
//        $save_path = $this->root_path;
////         file_put_contents('/text.txt', $save_path);
//        //文件保存目录URL
//        $save_url = $save_path;
//
//        //定义允许上传的文件扩展名
//        $ext_arr = array(
//            'image' => array( 'jpg', 'jpeg', 'png', 'bmp'),
//            'flash' => array('swf', 'flv'),
//            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
//         //   'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
//            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'zip', 'rar', 'gz', 'bz2'),
////            'file' => array(),
//
//        );
////最大文件大小
//        $max_size = 20971520;
//        @chmod(realpath($save_path), 0777);
//        $save_path = realpath($save_path) . '/';
//
////        file_put_contents('/text3.txt', $save_path);
//        //多图上传
//        if($_FILES['file']['name']){
//            $_FILES['imgFile']=$_FILES['file'];
//        }
////PHP上传失败
//        if (!empty($_FILES['imgFile']['error'])) {
//            switch ($_FILES['imgFile']['error']) {
//                case '1':
//                    $error = '超过php.ini允许的大小。';
//                    break;
//                case '2':
//                    $error = '超过表单允许的大小。';
//                    break;
//                case '3':
//                    $error = '图片只有部分被上传。';
//                    break;
//                case '4':
//                    $error = '请选择图片。';
//                    break;
//                case '6':
//                    $error = '找不到临时目录。';
//                    break;
//                case '7':
//                    $error = '写文件到硬盘出错。';
//                    break;
//                case '8':
//                    $error = 'File upload stopped by extension。';
//                    break;
//                case '999':
//                default:
//                    $error = '未知错误。';
//            }
//            $this->alert($error);
//        }
//
////有上传文件时
//        if (empty($_FILES) === false) {
//            //原文件名
//            $file_name = $_FILES['imgFile']['name'];
//            //服务器上临时文件名
//            $tmp_name = $_FILES['imgFile']['tmp_name'];
//            //文件大小
//            $file_size = $_FILES['imgFile']['size'];
//            //检查文件名
//            if (!$file_name) {
//                $this->alert("请选择文件。");
//            }
//            //检查目录
//            if (@is_dir($save_path) === false) {
//                $this->alert("上传目录不存在。");
//            }
//            //检查目录写权限
//            if (@is_writable($save_path) === false) {
//                $this->alert("上传目录没有写权限。");
//            }
//            //检查是否已上传
//            if (@is_uploaded_file($tmp_name) === false) {
//                $this->alert("上传失败。");
//            }
//            //检查文件大小
//            if ($file_size > $max_size) {
//                $this->alert("上传文件大小超过限制。");
//            }
//            //检查目录名
//                //文件类型
//            $typearray=array('image/png','image/jpeg');
//            $application=array('application/zip');
//            $text=array();
//            $audio=array();
//
//            $type = $_FILES['imgFile']['type'];
//            $typ=substr($type,0,strpos($type,'/'));
//            switch ($typ){
//                case 'image':
//                    if(!in_array($type,$typearray)){
//                        $this->alert("文件类型不允许。");
//                    }
//                break;
//                case 'application':
//                    if(!in_array($type,$application)){
//                        $this->alert("文件类型不允许。");
//                    }
//                break;
//                case 'text':
//                    if(!in_array($type,$text)){
//                        $this->alert("文件类型不允许。");
//                    }
//                break;
//                case 'audio':
//                    if(!in_array($type,$audio)){
//                        $this->alert("文件类型不允许。");
//                    }
//                break;
//                default:
//                    if(!in_array($type,$typearray)){
//                        $this->alert("文件类型不允许。");
//                    }
//
//            }
//
//
//
//            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
//            if (empty($ext_arr[$dir_name])) {
//                $this->alert("文件类型不允许。");
//            }
//            //获得文件扩展名
//            $temp_arr = explode(".", $file_name);
//            $file_ext = array_pop($temp_arr);
//            $file_ext = trim($file_ext);
//            $file_ext = strtolower($file_ext);
//
//
//              //检查扩展名
//            $in_ext_arr=false;
//            foreach ($ext_arr as $temp_dir_name=>$temp_ext_arr){
////                $dir_name = $temp_dir_name;
//                foreach($temp_ext_arr as $temp_ext){
//                    if($file_ext == $temp_ext){
//                        $in_ext_arr = true;
//                        $dir_name = $temp_dir_name;
//                        break;
//                    }
//                }
//            }
//
//            unset($temp_dir_name,$temp_ext_arr,$temp_ext_arr,$temp_ext);
//
//            if(!$in_ext_arr){
//                 $this->alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
//            }
//
//                         //检查目录名
////            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
//            if (empty($ext_arr[$dir_name])) {
//                $this->alert("目录名不正确。");
//            }
//
//            //创建文件夹
//            if ($dir_name !== '') {
//                $save_path .= $dir_name . "/";
//                $save_url .= $dir_name . "/";
//                if (!file_exists($save_path)) {
//                    mkdir($save_path);
//                }
//            }
//            $ymd = date("Ymd");
//            $save_path .= $ymd . "/";
//            $save_url .= $ymd . "/";
//            if (!file_exists($save_path)) {
//                mkdir($save_path,0777);
//                @chmod($file_path, 0777);
//            }
//            //新文件名
//            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) ;
//            $new_file_name_full = $new_file_name. '.' . $file_ext;
//            //移动文件
//            $file_path = $save_path . $new_file_name_full;
//            @chmod($file_path, 0777);
//            if (move_uploaded_file($tmp_name, $file_path) === false) {
//                $this->alert("上传文件失败。");
//            }
//
//
//            // 按比例生成缩略图 
//            $param = array( 
//              'type' => 'fit', 
//              'width' => 100, 
//              'height' => 100, 
//            ); 
//            $obj = new Imgtool(); 
////            $obj->set_config($param); 
////            $flag = $obj->create_thumb($file_path, $save_path.$new_file_name.'_'.$param['width'].'x'.$param['height']. '.' . $file_ext,$param['width'],$param['height'],'fit'); 
//            $flag = $obj->create_thumb_fit($file_path, $save_path.$new_file_name.'_120x120.' . $file_ext,120,120); 
//            $flag = $obj->create_thumb_fit($file_path, $save_path.$new_file_name.'_320x320.' . $file_ext,320,320); 
//            $flag = $obj->create_thumb_fit($file_path, $save_path.$new_file_name.'_640x640.' . $file_ext,640,640); 
//            
//            $flag = $obj->create_thumb_crop($file_path, $save_path.$new_file_name.'_120x120_crop.' . $file_ext,120,120); 
//            $flag = $obj->create_thumb_crop($file_path, $save_path.$new_file_name.'_320x320_crop.' . $file_ext,320,320); 
//            $flag = $obj->create_thumb_crop($file_path, $save_path.$new_file_name.'_640x640_crop.' . $file_ext,640,640); 
//
//            
//            
//             $file_url = $save_url . $new_file_name;
//            $result = array('error' => 0, 'url' => $file_url);
//        }
////                file_put_contents('/text2.txt', var_export($result, 1));
//        echo json_encode( $result);
//    }
//
//    function alert($msg) {
//	$result =array('error' => 1, 'message' => $msg);
//        echo json_encode($result);
//	exit;
//    }
//
//    public function actionUp(){
//        echo "开发中";exit;
//        $base64_string = $_POST['base64_string'];
//        $savename = uniqid().'.jpeg';//localResizeIMG压缩后的图片都是jpeg格式
//        $dir_name= $this->root_path;
//        //创建文件夹
//        $ymd = date("Ymd");
//        $save_path =$dir_name."image/". $ymd ;
//        if (!file_exists($save_path)) {
//            mkdir($save_path,0777);
//            @chmod($save_path, 0777);
//        }
//
//
//        $savepath =  $save_path."/".$savename;
//        /**/
//        $image = $this->base64_to_img( $base64_string, $savepath );
//
//        if($image){
//            echo '{"status":1,"content":"上传成功","url":"'.$image.'"}';
//        }else{
//            echo '{"status":0,"content":"上传失败"}';
//        }
//    }
//    function base64_to_img( $base64_string, $output_file ) {
//        $ifp = fopen( $output_file, "wb" );
//        fwrite( $ifp, base64_decode( $base64_string) );
//        fclose( $ifp );
//        return( $output_file );
//    }




}
