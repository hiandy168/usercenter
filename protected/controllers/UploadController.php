<?php
/**
 * @name	UploadController
 * @author	Steve Lui
 * @desc	api for upload
 * @version	1.5
 * @date	2014/2/25
 */

class UploadController extends FrontController
{
	// 	public $error_code=array(
	// 		'100'=>'CSRF拒绝',
	// 		'101'=>'uin错误',
	// 		'102'=>'文件上传失败',
	//		'103'=>'非正常上传文件',
	//		'104'=>'文件尺寸超出',
	//		'105'=>'非可上传文件类型',
	//		'106'=>'保存用户数据失败',
	//		'107'=>'上传文件夹没有写权限',
	//		'108'=>'保存数据到附件文件库失败',
	//		'109'=>'保存数据到附件库失败',
	//		'110'=>'vid传递错误',
	//		'111'=>'文件名传递错误',
	//		'112'=>'文件链接传递错误',
	//		'113'=>'获取远程文件失败',
	//		'114'=>'openid错误',
	//		'115'=>'wechatid错误',
	// 	);
	
	public $size_limit=20971520; //20MB
// 	public $type_limit=array('image/jpeg','image/gif','image/png','image/bmp',
// 			'audio/3gpp','audio/amr','audio/amr-wb','audio/amr-wb+','audio/mp4','audio/mpeg','audio/x-ms-wma','audio/x-pn-realaudio','audio/x-wav',
// 			'application/octet-stream'
// 			);

	function __construct() {
		//判断访问来源，只能指定站点访问
		//if(!Tool::isAllowip()) throw new CHttpException(403,'禁止访问');
	}

	/*
	 * 供表单提交使用的Token
	 */

	public function actionGetUploadToken(){
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
                        if(strstr($callback, '<body')){
                             header("HTTP/1.1 502 Bad Gateway");exit;  
                        }
                        if(strstr($callback, 'alert')){
                               header("HTTP/1.1 502 Bad Gateway");exit;  
                        }
//                         if(strstr($callback, 'e')){
//                           header("HTTP/1.1 502 Bad Gateway");exit;  
//                        }
			$session=new CHttpSession;
			$session->open();
			//如果允许了csrf认证，获取csrf token，否则直接用token字串
			$session['token']=Mod::app()->request->enableCsrfValidation?Mod::app()->request->getCsrfToken():'token';
			$token=array('name'=>Mod::app()->request->csrfTokenName,'token'=>$session['token']);
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
			'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
			'data'=>$token
		);

		Output::push($result, 'jsonp', $callback);
	}
        
	/*
	 * 检查提交的Token值和生成的Token值是否相同
	 * @return bool
	*/
	private function checkToken(){
		$token=Tool::getValidParam('MOD_CSRF_TOKEN','string');
		$session=new CHttpSession;
		$session->open();
		if($session['token']==$token) return true;
		else return false;
	}
	/*
	 * 接收图片上传类
	*/
	public function actionImageUpload(){
		set_time_limit(0);
		try{
//		    file_put_contents('111.txt', '进入图片上传');
			//如果设置了csrf，检查Token值
			if(Mod::app()->request->enableCsrfValidation&&!$this->checkToken()) throw new CException('100');
			//检查uin
			$uin=Tool::getValidParam('uin','bigint');
//			file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:uin='.$uin.PHP_EOL,FILE_APPEND);
			if(!$uin) throw new CException('101');
			//如果没有文件对象传上直接报错
			if(!$_FILES) throw new CException('102');
			//检查是否上传文件，app来源会出错
			if(!is_uploaded_file($_FILES['Filedata']['tmp_name'])) throw new CException('103');
			//上传出错
			if($_FILES['Filedata']['error']) throw new CException($_FILES['filedata']['error']);
			//检查文件尺寸
			if($_FILES['Filedata']['size']>$this->size_limit) throw new CException('104');
			//检查文件类型 使用mime_content_type需要开启php的fileinfo模块
			$type=$this->checkFiletype($_FILES['Filedata']['tmp_name'],$_FILES['Filedata']['name']);
			$typearr=explode('/',$type);
			if($typearr[0]!='image') throw new CException('105');
			//传入的文件没有扩展名
			if( strpos($_FILES['Filedata']['name'],'.') ){
				$f=explode('.',$_FILES['Filedata']['name']);
				$fn=$f[0];
				$ext=strtolower($f[count($f)-1]);
			}else{
				$fn=$_FILES['Filedata']['name'];
				$ext=strtolower($typearr[1]);
			}

			$hash=md5_file($_FILES['Filedata']['tmp_name']);
//			file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:hash='.$hash.PHP_EOL,FILE_APPEND);
			$basename=$hash.'.'.$ext;
			//生成路径
			$path=Mod::getPathOfAlias('webroot').'/attachment/';
			//获取uid
			$uid=$this->member['id'];
			if($uid===0) throw new CException('106');
			//检查外层文件夹是否可写
			if(!is_writable($path)) throw new CException('107');
			$path.=$uid.'/';
			//检查路径是否存在，否则新建，使用uid为文件夹
			if(!is_dir($path))	mkdir($path, 0777);
			//生成完整文件路径
			$file=$path.$basename;
			//将临时文件更名为带扩展名的文件，上传到存储服务器，返回文件链接
			move_uploaded_file($_FILES['Filedata']['tmp_name'], $file);
			
			$c=Tool::getValidParam('c','string');
			
//			file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:c='.$c.PHP_EOL,FILE_APPEND);
			$info=getimagesize($file);
			$image=array();
			if($c=='subject'){
				if($info[0]<640) throw new CException('101');
				//将图片处理成不同规格1350274 1200244 640130
				if($info[0]>=640) $s=3;
				if($info[0]>=1200) $s=2;
				if($info[0]>=1350) $s=1;
				file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:s='.$s.PHP_EOL,FILE_APPEND);
				switch($s){
				case 1:
					$r=Tool::cut($file,$ext,1350,274);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_1350274','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i1350274']=$r['data'];
					}
				case 2:
					$r=Tool::cut($file,$ext,1200,244);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_1200244','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i1200244']=$r['data'];
					}
				case 3:
					$r=Tool::cut($file,$ext,640,130);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_640130','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i640130']=$r['data'];
					}
				}
			}elseif($c=='hd'){
			    file_put_contents('111.txt', '进入hd');
				if($info[0]>=200){
				    file_put_contents('111.txt', '进入ifno[0]');
					//存原图
					$url=Mod::app()->CWaeStore->fileUploadByName($file);
					file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.PHP_EOL.'值:url='.$url.PHP_EOL,FILE_APPEND);
					$atta=new Attachment;
					$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash,'ext'=>$ext,'original_name'=>$basename,'description'=>$url,'type'=>$typearr[0],'create_time'=>time()));
					unset($atta);
					$image['original']=$url;
					
					$r=Tool::cut($file,$ext,200,136);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_200136','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i200136']=$r['data'];
					}
				}else throw new CException('101');
			}else{
				if($info[0]<150) throw new CException('101');
				//将图片处理成不同规格960495 640330 , 450330 300220 150110 
				if($info[0]>=150) $s=5;
				if($info[0]>=300) $s=4;
				if($info[0]>=450) $s=3;
				if($info[0]>=640) $s=2;
				if($info[0]>=960) $s=1;
				switch($s){
				case 1:
					$r=Tool::cut($file,$ext,960,495);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_960495','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i960495']=$r['data'];
					}
				case 2:
					$r=Tool::cut($file,$ext,640,330);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_640330','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i640330']=$r['data'];
					}
				case 3:
					$r=Tool::cut($file,$ext,450,330);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_450330','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i450330']=$r['data'];
					}
				case 4:
					$r=Tool::cut($file,$ext,300,220);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_300220','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i300220']=$r['data'];
					}
				case 5:
					$r=Tool::cut($file,$ext,150,110);
					if($r['sys_param']['ret_code']==0){
						//写入到attachment表
						$atta=new Attachment;
						$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_150110','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
						unset($atta);
						$image['i150110']=$r['data'];
					}
				}
			}
			if($aid===0) throw new CException('109');
			$data=array('aid'=>$aid,'type'=>$typearr[0],'images'=>$image,'width'=>$info[0],'height'=>$info[1]);
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$data
		);

		Output::push($result,'json');
	}
	/*
	 * 接收文件上传类
	 */
	public function actionFileUpload(){       
		set_time_limit(0);
		try{
			//如果设置了csrf，检查Token值
			if(Mod::app()->request->enableCsrfValidation&&!$this->checkToken()) throw new CException('100');
			//检查uin
			$uin=Tool::getValidParam('uin','bigint');
			if(!$uin) throw new CException('101');
			//如果没有文件对象传上直接报错
			if(!$_FILES) throw new CException('102');
			//检查是否上传文件，app来源会出错
 			if(!is_uploaded_file($_FILES['Filedata']['tmp_name'])) throw new CException('103');
			//上传出错
			if($_FILES['Filedata']['error']) throw new CException($_FILES['filedata']['error']);
			//检查文件尺寸
			if($_FILES['Filedata']['size']>$this->size_limit) throw new CException('104');
			//检查文件类型 使用mime_content_type需要开启php的fileinfo模块
                        $type=$this->checkFiletype($_FILES['Filedata']['tmp_name'],$_FILES['Filedata']['name']);
		        if(strstr($type,'application')){
                            try {
                                 $type  =  mime_content_type($_FILES['Filedata']['tmp_name']);

                            } catch (Exception $ex) {
                              $finfo = new finfo(FILEINFO_MIME); 
                                $type =  $finfo->file($_FILES['Filedata']['tmp_name']);
                            }
                        }
                        $typearr=explode('/',$type);
                        $content_type = $typearr[0];                   
                         if(!in_array($content_type,array('image','audio','video'))) throw new CException('105');
//                        if(!in_array($ext, array('jpg','jpeg','gif','png','bmp','mp3','mp4','3gp','avi'))){
//                            throw new CException('105');
//                        }
                         
//                       file_put_contents('debug.txt',$content_type,FILE_APPEND);
                        		
			//传入的文件没有扩展名
			if( strpos($_FILES['Filedata']['name'],'.') ){
				$f=explode('.',$_FILES['Filedata']['name']);
				$fn=$f[0];
				$ext=strtolower($f[count($f)-1]);
			}else{
				$fn=$_FILES['Filedata']['name'];
				$ext=strtolower($typearr[1]);
			}
                                        		
			$hash=md5_file($_FILES['Filedata']['tmp_name']);
			$basename=$hash.'.'.$ext;
			file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:hash='.$hash.PHP_EOL,FILE_APPEND);
			//生成路径
			$path=Mod::getPathOfAlias('webroot').'/attachment/';
			//获取uid
			$uid=$this->member['id'];
			if($uid===0) throw new CException('106');
			//检查外层文件夹是否可写
			if(!is_writable($path)) throw new CException('107');
			$path.=$uid.'/';
			//检查路径是否存在，否则新建，使用uid为文件夹
			if(!is_dir($path))	mkdir($path, 0777);
			//生成完整文件路径
			$file=$path.$basename;
			//将临时文件更名为带扩展名的文件，上传到存储服务器，返回文件链接
			move_uploaded_file($_FILES['Filedata']['tmp_name'], $file);
			$url=Mod::app()->CWaeStore->fileUploadByName($file);
			file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.__METHOD__.PHP_EOL.'值:url='.$url.PHP_EOL,FILE_APPEND);
			//写入到attachment表
			$atta=new Attachment;
//                        file_put_contents('debug.txt',var_export(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$fn,'ext'=>$ext,'original_name'=>$_FILES['Filedata']['name'],'description'=>$url,'type'=>$content_type,'create_time'=>time()), 1),FILE_APPEND);
			$aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$fn,'ext'=>$ext,'original_name'=>$_FILES['Filedata']['name'],'description'=>$url,'type'=>$content_type,'create_time'=>time()));
			unset($atta);

			if($aid===0) throw new CException('109');

			$data=array('type'=>$content_type,'aid'=>$aid);
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$data
		);
		
		Output::push($result,'json');
	}
        
        /*
	 * 接收文件上传类
	 */
	public function actionImageUploadnew(){
//               file_put_contents('debug.txt', "1\r\n",FILE_APPEND);
//                if (isset($_POST["PHPSESSID"])) {
//                    session_id($_POST["PHPSESSID"]);
//                }
//                session_start();
		set_time_limit(0);
		try{
//                      file_put_contents('debug.txt', "2\r\n",FILE_APPEND);
			//如果设置了csrf，检查Token值
			if(Mod::app()->request->enableCsrfValidation&&!$this->checkToken()) throw new CException('100');
			//检查uin
//                          file_put_contents('debug.txt', "3\r\n",FILE_APPEND);
			$uin=Tool::getValidParam('uin','bigint');
			if(!$uin) throw new CException('101');
			//如果没有文件对象传上直接报错
			if(!$_FILES) throw new CException('102');
			//检查是否上传文件，app来源会出错
			if(!is_uploaded_file($_FILES['Filedata']['tmp_name'])) throw new CException('103');
			//上传出错
			if($_FILES['Filedata']['error']) throw new CException($_FILES['filedata']['error']);
			//检查文件尺寸
			if($_FILES['Filedata']['size']>$this->size_limit) throw new CException('104');
			//检查文件类型 使用mime_content_type需要开启php的fileinfo模块
			$type=$this->checkFiletype($_FILES['Filedata']['tmp_name'],$_FILES['Filedata']['name']);
			$typearr=explode('/',$type);
			if($typearr[0]!='image') throw new CException('105');
			//传入的文件没有扩展名
			if( strpos($_FILES['Filedata']['name'],'.') ){
				$f=explode('.',$_FILES['Filedata']['name']);
				$fn=$f[0];
				$ext=strtolower($f[count($f)-1]);
			}else{
				$fn=$_FILES['Filedata']['name'];
				$ext=strtolower($typearr[1]);
			}

			$hash=md5_file($_FILES['Filedata']['tmp_name']);
			$basename=$hash.'.'.$ext;
			//生成路径
			$path=Mod::getPathOfAlias('webroot').'/attachment/';
			//获取uid
			$uid=$this->member['id'];
			if($uid===0) throw new CException('106');
			//检查外层文件夹是否可写
			if(!is_writable($path)) throw new CException('107');
			$path.=$uid.'/';
			//检查路径是否存在，否则新建，使用uid为文件夹
			if(!is_dir($path))	mkdir($path, 0777);
			//生成完整文件路径
			$file=$path.$basename;
			//将临时文件更名为带扩展名的文件，上传到存储服务器，返回文件链接
			move_uploaded_file($_FILES['Filedata']['tmp_name'], $file);
			
			$c=Tool::getValidParam('c','string');
			$info=getimagesize($file);
			$image=array();
		
                        //存原图
                        $url=Mod::app()->CWaeStore->fileUploadByName($file);
//                        file_put_contents('111.txt', '时间:'.date('y-m-d h:i:s',time()).' 路径:'.__FILE__.__LINE__.PHP_EOL.'值:url='.$url.PHP_EOL,FILE_APPEND);
                        $atta=new Attachment;
                        $aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash,'ext'=>$ext,'original_name'=>$basename,'description'=>$url,'type'=>$typearr[0],'create_time'=>time()));
                        unset($atta);
                        $image['original']=$url;

//                        $r=Tool::cut($file,$ext,200,136);
//                        if($r['sys_param']['ret_code']==0){
//                                //写入到attachment表
//                                $atta=new Attachment;
//                                $aid=$atta->savedata(array('a_fid'=>0,'uid'=>$uid,'file_name'=>$hash.'_200136','ext'=>$ext,'original_name'=>$basename,'description'=>$r['data'],'type'=>$typearr[0],'create_time'=>time()));
//                                unset($atta);
//                        }
//			
//                        if(isset($r['data'])&&$r['data']){
//                           $thumb_url = $r['data'];
//                        }else{
//                           $thumb_url =$url;
//                        }

                   
                        $file_data = file_get_contents($file);
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $cachekey='image'.$aid;
                        Mod::app()->memcache->set($cachekey,$file_data,30);
                        $thumb_url = $this->createAbsoluteUrl('/thumb/index',array('id'=>$aid,'ext'=>$ext));
//                        file_put_contents('./debug.txt', ('success|'.$aid.'|'.$thumb_url));
                        echo ('success|'.$aid.'|'.$thumb_url);die;
			$data=array('aid'=>$aid,'type'=>$typearr[0],'images'=>$image,'width'=>$info[0],'height'=>$info[1]);
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
	
                      

//		echo ('success|'.$aid.'|'.$url);die;
	}

	
	
	private function checkFiletype($file,$orifilename){
                $image = exif_imagetype($file); 
                $type = image_type_to_mime_type($image); 
//		$type=mime_content_type($file);
		//记录下对各种格式的识别
		Tool::log($type.'--'.$file.'--'.$orifilename,'upload.log');

		if($type=='application/octet-stream'){
			$f1=fopen($file,'rb');
			$content=fread($f1, 3);
			if($content=='ID3') $type='audio/mpeg';
			do{}while( !rewind($f1) );
			$content=fread($f1, 5);
			if($content=='#!AMR') $type='audio/amr';
			do{}while( !rewind($f1) );
			$i=1;
			do{
				$s=strtolower(dechex(ord(fread($f1, 1))));
				switch($i){
					case 1:
						$i=$s=='ff'?$i:0;
						break;
					case 2:
						$type=substr($s,0,1)=='e'||substr($s,0,1)=='f'?'audio/mpeg':$type;
						$i=0;
						break;
				}
			}while($i++);
			fclose($f1);
		}

		return $type;
	}
	

	
	private function log($content){
		$logfile=realpath(dirname(__FILE__).'/../../runtime').'/'.date('Ymd',time()).'/upload.log';
		error_log(date('Ymd H:i:s',time()).' '.$content."\r\n", 3, $logfile);
	}
}
?>