<?php
/**
 * @name	ReportController
 * @author	Steve Lui
 * @desc	api for post or get reports
 * @version	1.6
 * @date	2014/2/20
 */

class ReleaseController extends FrontController
{
// 	public $error_code=array(
// 		'100'=>'频道信息错误',
// 		'101'=>'参数传递错误',
// 		'102'=>'请求的用户不存在',
//		'103'=>'无法获得对应跟进人记录',
//		'104'=>'缺失有效数据',
//		'105'=>'保存用户数据失败',
//		'106'=>'请先登录',
//		'107'=>'验证码错误',
//		'108'=>'报料未审核或已删除',
//		'109'=>'callback非法字符',
//      '111'=>'同一个IP一分钟内重复提交三次',
// 	);
	
	function __construct() {
		//判断访问来源，只能指定站点访问
		//if(!Tool::isAllowip()) throw new CHttpException(403,'禁止访问');
	}

        public function actionIndex(){
                $data['config'] = $this->site_config;
                $this->render('index', $data);
        }
	/**
	 *  @desc 获取报料信息列表(已审核)
	 *  @param cateid int 报料频道ID(必须)
	 *  @param num int 报料信息条数，按照发布时间倒序排列(非必须,缺省10条)
	 *  @param pageno int 页面号，如果设置页面号，则从指定页面开始显示num条(非必须,缺省为1)
	 *  @param isReply tinyint 不传值为所有，1为未回复，2为有回复(非必须)
	 *  @return json 报料信息列表数组
	 */
	public function actionGetReportsList()
	{
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			
			$act=Tool::getValidParam('act','string');
			
			$cateid=Tool::getValidParam('cateid','integer');
			if(!$cateid) throw new CException('100');
			
			$num=Tool::getValidParam('num','integer',10);
			$pageno=Tool::getValidParam('pageno','integer',1);
			$isReply=Tool::getValidParam('isReply','integer');
			//按照类别ID分页数页号是否有回复命名cache key，如果对应数据不存在从数据库读取，保存1个小时
			$cachekey='rlist'.$cateid.'_'.$num.'_'.$pageno.'_'.$isReply;
		    if( !($data=Mod::app()->memcache->get($cachekey)) || $act=='refresh' ){
				$criteria=new CDbCriteria();
				$criteria->select='*';
				if($isReply==2) $criteria->condition='category_id=:catid and status=2 and counter_reply>0';
				elseif($isReply==1) $criteria->condition='category_id=:catid and status=2 and counter_reply=0';
				else $criteria->condition='category_id=:catid and status=2';
				$criteria->params=array(':catid'=>$cateid);
		
				$resultCount=Report::model()->count($criteria); //获取符合条件的记录总数
		
				$criteria->limit=$num;
				$criteria->offset=($pageno-1)*$num; //设置记录起始偏移量
				$criteria->order='create_time DESC, report_id DESC';

				$result=Report::model()->with('reportmedia')->findAll($criteria);
				//将从数据库获取的数据写入要输出的数组
				$list=array();
				foreach($result as $record){
					$list[$record['report_id']]['report_id']=$record['report_id'];
					$list[$record['report_id']]['category_id']=$cateid;
					$list[$record['report_id']]['title']=Tool::noscript($record['title']);
					$list[$record['report_id']]['content']=mb_substr(Tool::noscript($record['content']),0,50,'utf-8');
					$list[$record['report_id']]['create_time']=date('Y/n/j H:i',$record['create_time']);
					$list[$record['report_id']]['counter_clicks']=$record['counter_clicks'];
					$list[$record['report_id']]['counter_reply']=$record['counter_reply'];
					$list[$record['report_id']]['informant_name']=Tool::noscript($record['informant_name']);
					$list[$record['report_id']]['view']=$record['counter_clicks'];
					$list[$record['report_id']]['targetid']=$record['targetid'];
					$list[$record['report_id']]['flag']=$record['flag'];
					if($record['reportmedia']){
						foreach($record['reportmedia'] as $rs){
							//已经通过审核的
							if($rs['status']==2) $list[$record['report_id']][$rs['media_type']][]=$rs['id'];
						}
					}
				}
				$data=array('page'=>array('count'=>$resultCount,'size'=>$num,'no'=>$pageno),'list'=>$list);
				Mod::app()->memcache->set($cachekey,$data,1800);
			}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
			'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
			'data'=>$data
		);
		Output::push($result, 'jsonp', $callback);
	}

        
        public function actionNewIndexReportsList()
	{
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			//是否刷新缓存
			$act=Tool::getValidParam('act','string');
			$silence=Tool::getValidParam('silence','integer');
			
			$cityid=Tool::getValidParam('cityid','integer');
			if(!$cityid) throw new CException('101');
				
			$num=Tool::getValidParam('num','integer',10);
                        if($num<=0){ $num =10;}
			$pageno=Tool::getValidParam('pageno','integer',1);
                        if($pageno<=0){ $pageno =1;}
			//按照类别ID分页数页号是否有回复命名cache key，如果对应数据不存在从数据库读取，保存1个小时
			$cachekey='newindex_rlist'.$cityid.'_'.$num.'_'.$pageno;
			if( !($data=Mod::app()->memcache->get($cachekey)) || $act=='refresh' ){
//                               $now =time();
//                                $time =$now-15552000;//半年内
//                              太慢了 注释掉   其实不用category_id   查出来也是全部的 
//				$sql='select count(*) from report where category_id in (select category_id from category where city_id='.$cityid.') and status=2';
                                $sql='select count(*) from report where status=2';
				$resultCount=Report::model()->countBySql($sql);
//				$sql='select * from report as r where r.category_id in (select category_id from category where city_id='.$cityid.') and r.status=2 order by r.create_time DESC, r.report_id DESC limit '.($pageno-1)*$num.','.$num;
                                $sql='select * from report as r where  r.status=2 order by r.create_time DESC, r.report_id DESC limit '.($pageno-1)*$num.','.$num;
				$result=Report::model()->with('reportmedia')->findAllBySql($sql);
				//将从数据库获取的数据写入要输出的数组
				$list=array();
				$tids = array();
				foreach($result as $record){
				         $userinfo =User::getUserById($record['uid']);
                                        if($userinfo['account_id']&&$userinfo['picture']){
                                            $picture = $userinfo['picture'];
                                        }else if($userinfo['account_id']){
                                             $picture = User::getUserpictureByIdonline($userinfo['account_id']);
                                        }
                                        $picture =$picture?$picture:'';
					$tlist=array(
						'report_id'=>$record['report_id'],
						'category_id'=>$record['category_id'],
                                                'uid'=>$record['uid'],
						'title'=>Tool::noscript($record['title']),
						'content'=>Tool::truncate_utf8_string(Tool::noscript($record['content']),'110'),
						'create_time'=>date('Y/n/j H:i',$record['create_time']),
						'counter_clicks'=>$record['counter_clicks'],
						'counter_reply'=>$record['counter_reply'],
						'informant_name'=>Tool::noscript($record['informant_name']),
                                                'informant_picture'=>$picture,
						'view'=>$record['counter_clicks'],
						'targetid'=>$record['targetid'],
						'flag'=>$record['flag']
					);
					if($record['reportmedia']){
						foreach($record['reportmedia'] as $rs){
							//已经通过审核的
							if($rs['status']==2){ 
                                                            $tlist[$rs['media_type']][]=$rs['attachment_id'];
                                                        }
						}
                                                $sql='';
                                            //                                                if(!empty($tlist[$rs['media_type']])){
//                                                $sql = 'select a.description from report_media as r right join attachment as a on r.attachment_id = a.a_id  where r.id in('.  @implode(',', $tlist[$rs['media_type']]).')';
//                                                 $attr_res = Mod::app()->db->createCommand($sql)->queryAll();
//                                                 foreach($attr_res as $td){
//                                                $tlist[$rs['media_type'].'_description'][] =  $td['description'];
//                                                 }
//                                                }
                                                  if(!empty($tlist['image'])){
//                                                $sql = 'select a.description from report_media as r right join attachment as a on r.attachment_id = a.a_id  where r.id in('.  implode(',', $tlist[$rs['media_type']]).')';
//                                                 $attr_res = Mod::app()->db->createCommand($sql)->queryAll();
                                                 foreach($tlist['image'] as $v){
                                                    $tlist[$rs['media_type'].'_description'][] =  Tool::getImgByid($v);
                                                 }
                                                }
					}
					$list[]=$tlist;
					if($record['targetid'])	$tids[]=$record['targetid'];
				}
				$cnum=Comment::getCommentsNumberByTargetids($tids);
				foreach ($list as $key=>$val)
					$list[$key]['targetid_num'] = empty($cnum[$val['targetid']]['commentnum'])?'0':$cnum[$val['targetid']]['commentnum'];
				$data=array('page'=>array('count'=>$resultCount,'size'=>$num,'no'=>$pageno),'list'=>$list);
//                                var_dump($list);die;
				Mod::app()->memcache->set($cachekey,$data,300);
			}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$data
		);
		if($silence) $result=array('ret_code'=>isset($error['code'])?$error['code']:0);
		Output::push($result, 'jsonp', $callback);
	}
      
        
       
	/**
	 *  @desc 获取报料信息内容(已审核)
	 *  @param cateid int 报料频道ID(必须)
	 *  @param id int 报料信息ID(必须)
	 *  @return json 报料信息列表数组 有将回车换行符换成<br />标签
	 */
	public function actionGetReport()
	{
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			
			$act=Tool::getValidParam('act','string');
			$silence=Tool::getValidParam('silence','integer');
			
			$cateid=Tool::getValidParam('cateid','integer');			
			$id=Tool::getValidParam('id','integer');
			if(!$id) throw new CException('100');
			$cachekey='r_'.$id;
			//检查report_id是否存在，否则counter_clicks加一
			$uid=Report::model()->find('report_id=:report_id',array(':report_id'=>$id))->uid;
			if(!$uid) throw new CException('101');

			//访问日志添加记录
			Tool::visitlog($uid,$id);

			if( !($info=Mod::app()->memcache->get($cachekey)) || $act=='refresh' ){
//                                  file_put_contents('debug.txt', "select * from report where report_id=$id and status=2 \r\n",FILE_APPEND);
				$result=Report::model()->findBySql("select * from report where report_id=$id and status=2");
				//将从数据库获取的数据写入要输出的数组
				$info=array();
				if($result){
					if(!$result['targetid']){
						//将报料信息提交到评论系统
						$targetid=$this->postAritcleToCoral($result['category_id'],$result['report_id'],Tool::noscript($result['title']),Tool::noscript($result['content']));
						//保存评论系统targetid到report表对应记录
						Report::model()->updateByPk($result['report_id'],array('targetid'=>$targetid));
					}
					$info['report_id']=$result['report_id'];
					$info['uid']=$result['uid'];
					$info['category_id']=$result['category_id'];
					$info['title']=Tool::noscript($result['title']);
					$info['content']=str_replace("<br />", "\n", Tool::noscript(stripslashes($result['content'])));
					
					$info['locationx']=($result['location_x']);
					$info['locationy']=($result['location_y']);
					$info['locationlabel']=($result['location_label']);
					$info['locationscale']=($result['location_scale']);
					
					$info['top_create_time']=$result['top_create_time'];
					$info['create_time']=date('Y/n/j H:i',$result['create_time']);
					$info['ip']=$result['ip'];
					$info['counter_clicks']=$result['counter_clicks'];
					$info['counter_reply']=$result['counter_reply'];
					$info['allow_comment']=$result['allow_comment'];
					$info['informant_name']=Tool::noscript($result['informant_name']);
					$info['informant_tel']=Tool::noscript($result['informant_tel']);
					$info['targetid']=isset($targetid)?$targetid:$result['targetid'];
					$info['flag']=$result['flag']?$result['flag']:0;
					//查找所有的附件
					$rm=ReportMedia::model()->findAllBySql("select report_media.attachment_id,report_media.media_type,attachment.description as status from report_media left join attachment on report_media.attachment_id=attachment.a_id where report_media.report_id=$id and report_media.status=2");
					if($rm){
						foreach($rm as $rs){
							//已经通过审核的
							$info[$rs['media_type']][]=$rs['status'];
						}
					}
					$follow=$result->follow;
					if($follow){
						$info['follow']=array();
						foreach($follow as $rs){
							if($rs['status']==2){
								$admin=$rs->admin;
								//判断当前登录的用户id和报料用户id相同，显示所有follow
								//浏览用户和报料用户id不同，只显示跟进人follow
								$info['follow'][]=array('id'=>$rs['id'],
									'admin_id'=>$rs['admin_id'],
									'admin_name'=>Tool::noscript($admin['name']),
									'title'=>Tool::noscript($rs['title']),
									'content'=>Tool::noscript($rs['content']),
									'create_time'=>date('Y/n/j H:i',$rs['create_time'])
								);
							}
						}
					}
					Mod::app()->memcache->set($cachekey,$info,1800);
				}else{
					//报料未审核或者已被删除
					throw new CException('108');
				}
			}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$info
		);
		if($silence) $result=array('ret_code'=>isset($error['code'])?$error['code']:0);
		Output::push($result, 'jsonp', $callback);
	}

	/**
	 *  @desc 获取报料信息内容(已审核)
	 *  @param cateid int 报料频道ID(必须)
	 *  @param id int 报料信息ID(必须)
	 *  @return json 报料信息列表数组
	 */
	public function actionGetReportByContentid()
	{
		$action=substr(Mod::app()->request->PathInfo,0,strpos(Mod::app()->request->PathInfo,Mod::app()->controller->action->id)).Mod::app()->controller->action->id;
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			
			$act=Tool::getValidParam('act','string');

			$id=Tool::getValidParam('id','integer');
			if(!$id) throw new CException('100');

			$cachekey='or_'.$id;
			//检查report_id是否存在，否则counter_clicks加一
			$result=Report::model()->find('status=2 and var_1=:content_id',array(':content_id'=>$id));
			$uid=$result->attributes['uid'];
			if(!$uid) throw new CException('101');

			Tool::visitlog($uid,$result->attributes['report_id']);

			if( !($info=Mod::app()->memcache->get($cachekey)) || $act=='refresh' ){
				//$result=Report::model()->findBySql("select * from report where var_1=$id and status=2");
				//将从数据库获取的数据写入要输出的数组
				$info=array();
				if($result){
					if(!$result['targetid']){
						//将报料信息提交到评论系统
						$targetid=$this->postAritcleToCoral($result['category_id'],$result['report_id'],Tool::noscript($result['title']),Tool::noscript($result['content']));
						//保存评论系统targetid到report表对应记录
						Report::model()->updateByPk($result['report_id'],array('targetid'=>$targetid));
					}
					$info['report_id']=$result['report_id'];
					$info['uid']=$result['uid'];
					$info['category_id']=$result['category_id'];
					$info['title']=Tool::noscript($result['title']);
					$info['content']=str_replace("\n",'<br />',Tool::noscript($result['content']));
					
					$info['locationx']=($result['location_x']);
					$info['locationy']=($result['location_y']);
					$info['locationlabel']=($result['location_label']);
					$info['locationscale']=($result['location_scale']);
					
					$info['top_create_time']=$result['top_create_time'];
					$info['create_time']=date('Y/n/j H:i',$result['create_time']);
					$info['ip']=$result['ip'];
					$info['counter_clicks']=$result['counter_clicks'];
					$info['counter_reply']=$result['counter_reply'];
					$info['allow_comment']=$result['allow_comment'];
					$info['informant_name']=Tool::noscript($result['informant_name']);
					$info['informant_tel']=Tool::noscript($result['informant_tel']);
					$info['targetid']=isset($targetid)?$targetid:$result['targetid'];
					$info['flag']=$result['flag']?$result['flag']:0;
					//查找所有的附件
					$rm=ReportMedia::model()->findAllBySql("select report_media.attachment_id,report_media.media_type,attachment.description as status from report_media left join attachment on report_media.attachment_id=attachment.a_id where report_media.report_id={$result['report_id']} and report_media.status=2");
					if($rm){
						foreach($rm as $rs){
							//已经通过审核的
							$info[$rs['media_type']][]=$rs['status'];
						}
					}
					$follow=$result->follow;
					$admin=$follow[0]->admin;
					if($follow){
						$info['follow']=array();
						foreach($follow as $rs){
							if($rs['status']==2){
								//判断当前登录的用户id和报料用户id相同，显示所有follow
								//浏览用户和报料用户id不同，只显示跟进人follow
								$info['follow'][]=array('id'=>$rs['id'],
									'admin_id'=>$rs['admin_id'],
									'admin_name'=>Tool::noscript($admin['name']),
									'title'=>Tool::noscript($rs['title']),
									'content'=>Tool::noscript($rs['content']),
									'create_time'=>date('Y/n/j H:i',$rs['create_time'])
								);
							}
						}
					}
					Mod::app()->memcache->set($cachekey,$info,1800);
				}else{
					//报料未审核或者已被删除
					throw new CException('108');
				}
			}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$info
		);
		Output::push($result, 'jsonp', $callback);
	}

	/**
	 *  @desc 获取我的报料信息列表
	 *  @param uin bigint QQ用户uin(必须)
	 *  @param num int 报料信息条数，按照发布时间倒序排列(非必须,缺省10条)
	 *  @param pageno int 页面号，如果设置页面号，则从指定页面开始显示num条(非必须,缺省为1)
	 *  @param isReply tinyint 不传值为所有，1为未回复，2为有回复(非必须)
	 *  @return json 报料信息列表数组
	 */
	public function actionGetMyReportsList()
	{
		try{
			//if(Mod::app()->user->getIsGuest()) throw new CException('106');
			
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			
			$num=Tool::getValidParam('num','integer',10);
			$pageno=Tool::getValidParam('pageno','integer',1);
			$isReply=Tool::getValidParam('isReply','integer');
			$uin=Tool::getValidParam('uin','bigint');
			if(!$uin) throw new CException('101');
			$cookieuin=(int)Passport::getUin();
			//if(!$cookieuin) throw new CException('106');
			
			$cachekey='myrlist'.$uin.'_'.$num.'_'.$pageno.'_'.$isReply;
			//if( !($data=Mod::app()->memcache->get($cachekey)) ){
				$uid=$this->getAppUid();
				if(!$uid) throw new CException('103');

				$criteria=new CDbCriteria();
				$criteria->select='*';
				if($isReply==2) $criteria->condition='uid=:uid and counter_reply>0';
				elseif($isReply==1) $criteria->condition='uid=:uid and counter_reply=0';
				else $criteria->condition='uid=:uid';
				$criteria->params=array(':uid'=>$uid);
	
				$resultCount=Report::model()->count($criteria); //获取符合条件的记录总数	
	
				$criteria->limit=$num;
				$criteria->offset=($pageno-1)*$num; //设置记录起始偏移量
				$criteria->order='create_time DESC, report_id DESC';
		
				$result=Report::model()->with('reportmedia')->findAll($criteria);
				$att = array();
				$list=array();
				foreach($result as $record){
					$list[$record['report_id']]['report_id']=$record['report_id'];
					$list[$record['report_id']]['title']=Tool::noscript($record['title']);
					$list[$record['report_id']]['desc']=strip_tags(mb_substr(Tool::noscript($record['content']),0,50,'utf-8'));
					$list[$record['report_id']]['location_x']=$record['location_x'];
					$list[$record['report_id']]['location_y']=$record['location_y'];
					$list[$record['report_id']]['location_scale']=$record['location_scale'];
					$list[$record['report_id']]['location_label']=Tool::noscript($record['location_label']);
					$list[$record['report_id']]['view']=$record['counter_clicks'];
					$list[$record['report_id']]['informant_name']=Tool::noscript($record['informant_name']);
					$list[$record['report_id']]['date']=date('Y/n/j H:i',$record['create_time']);
					$list[$record['report_id']]['status']=$record['status'];
					$list[$record['report_id']]['targetid']=$record['targetid'];
					$list[$record['report_id']]['flag']=$record['flag'];
					if($record['reportmedia']){
						foreach($record['reportmedia'] as $rs){
							//$list[$record['report_id']][$rs['media_type']][]=$rs['attachment_id'];
							$att[] = $rs['attachment_id'];
						}
					}
				}
				$attachment = Attachment::model()->getFieldsByIds($att, 'a_id,description,type');
				foreach($result as $record){
					foreach($record['reportmedia'] as $rs){
						$list[$record['report_id']][$rs['media_type']][]=$attachment[$rs['attachment_id']]['description'];
					}
				}
				$data=array('page'=>array('count'=>$resultCount,'size'=>$num,'no'=>$pageno),'list'=>$list);
				//Mod::app()->memcache->set($cachekey,$data,300);
			//}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
			'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
			'data'=>$data
		);
		Output::push($result, 'jsonp', $callback);
	}
	
	/*
	 * 检查提交的Token值和生成的Token值是否相同
	* @return bool
	*/
	private function checkToken(){
//            //接手之前的代码  反正不能用
		$token=Tool::getValidParam('MOD_CSRF_TOKEN','string');
		$session=new CHttpSession;
		$session->open();
		if($session['token']==$token) return true;
		else return false;
	}
	public function actionMakeCaptcha(){       
		$captcha=new CCaptchaAction($this,'captcha');
                $captcha->transparent = true;
//                Mod::app()->session['captcha'] = $captcha->fixedVerifyCode = substr(md5(time()), 11, 4);
                $captcha->minLength = 4;
                $captcha->maxLength = 4;
                $captcha->width = 80;
                $captcha->height = 30;
		$captcha->run();
	}
	/**
	 *  @desc 接收报料内容
	 *  @param MOD_CSRF_TOKEN string Token(必须)
	 *  @param cateid int 报料频道ID(必须)
	 *  @param uid int 报料用户ID(必须)
	 *  @param title string 报料信息标题(必须)
	 *  @param content string 报料信息内容(必须)
	 *  @param aids string 报料附件IDs(非必须)
	 *  @param location_x string 纬度(非必须)
	 *  @param location_y string 经度(非必须)
	 *  @param location_scale int 缩放级别(非必须)
	 *  @param location_label string 位置标签(非必须)
	 *  @param source int 报料提交来源值(必须)
	 *  @param informant_name 报料人名(必须)
	 *  @param informant_tel 报料人电话(非必须)
	 *  @return json 处理结果
	 */
	public function actionSaveReport()
	{
		try{
			if(Mod::app()->request->enableCsrfValidation&&!$this->checkToken()) throw new CException('101');
			
			$source=Tool::getValidParam('source','integer');
			if($source==1){
				$verify=Tool::getValidParam('f_verify','string');
				$captcha=new CCaptchaAction($this,'captcha');
				if(!$captcha->validate($verify,false)) throw new CException('107 验证码不正确');
				$captcha->getVerifyCode(true);
			}
			
			$ip = ip2long(Mod::app()->request->userHostAddress);
			$create_time = time()-3600;
//                      if(!in_array($ip,array())){
//			  $times=Report::model()->countBySql("select count(*) from report where create_time > ".$create_time." and ip=:ip",array(':ip'=>$ip));
//                          if($times>=3) throw new CException('111');
//                      }
                      
			$cateid=Tool::getValidParam('cateid','integer');
			if(!$cateid) throw new CException('100');
			$uin=Tool::getValidParam('uin','bigint');
                        $uin  = Mod::app()->user->uin;
//                        file_put_contents('debug.txt', 'source:'.$source."    Mod::app()->user->uin;".Mod::app()->user->uin."   Tool::getValidParam('uin','bigint');".Tool::getValidParam('uin','bigint')."\r\n",FILE_APPEND);
//                        file_put_contents('debug.txt', var_export(Mod::app()->user,1)."\r\n",FILE_APPEND);
                        if(!$uin){
                            throw new CException('1009 用户未登录，失败请重登录');
                        }
			$uid=$this->getUid();
			if($uid==0) throw new CException('105');
			
			$title=Tool::noscript(Tool::cutf8(Tool::getValidParam('title','sentence')));
			if(!$title) throw new CException('104');
			$content=Tool::noscript(Tool::cutf8(Tool::getValidParam('content','sentence')));
			if(!$content) throw new CException('104');
			$attachments=Tool::getValidParam('attachments','string'); //客户端返回的附件TYPE_ID用 , 号隔开
                        if($arratta=explode(',',$attachments) && count($arratta)>8){
                             throw new CException('109');die;
                        }
			$location_x=Tool::getValidParam('location_x','double');
			$location_y=Tool::getValidParam('location_y','double');
			$location_scale=Tool::getValidParam('location_scale','integer');
			$location_label=Tool::noscript(Tool::cutf8(Tool::getValidParam('location_label','string')));
			$informant_name=Tool::noscript(Tool::cutf8(Tool::getValidParam('username','string')));
                        if(!$informant_name)
                           $informant_name =  Tool::getValidParam('nick','string');
                        
                        $informant_picture = Tool::cutf8(Tool::getValidParam('picture','string'));
			if(!$informant_name) throw new CException('104');
			$informant_tel=Tool::getValidParam('phone','string');
			//创建report记录
			$r=new Report;
			$r->validate('insert');
			$rid=$r->savedata(array('uid'=>$uid,'category_id'=>$cateid,'title'=>$title,'content'=>$content,'location_x'=>$location_x,'location_y'=>$location_y,'location_scale'=>$location_scale,'location_label'=>$location_label,
				'top_create_time'=>0,'create_time'=>time(),'status'=>1,'ip'=>ip2long(Mod::app()->request->userHostAddress),'source'=>$source,'allow_comment'=>2,'informant_name'=>$informant_name,'informant_tel'=>$informant_tel,'informant_picture'=>$informant_picture));
			unset($r);
			//如果有附件，保存report_media
			if($attachments){
				$arratta=explode(',',$attachments);
			
				foreach($arratta as $atta){
					$rm=new ReportMedia;
					$attav=explode('_',$atta);
					$rm->savedata(array('attachment_id'=>$attav[1],'report_id'=>$rid,'media_type'=>$attav[0],'status'=>0));
					unset($rm);
				}
			}
			//将报料信息提交到评论系统
			//$targetid=$this->postAritcleToCoral($cateid,$rid,$title,$content);
			//保存评论系统targetid到report表对应记录
			//Report::model()->updateByPk($rid,array('targetid'=>$targetid));
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$rid
		);
		if(Tool::getValidParam('from-pc','string')=='from-pc'){
			Output::pushnew($result, 'json');
			Mod::app()->end();
		}
		Output::pushnew($result, 'javascript');
	}
        
        public function actionAjaxsaveReport()
	{
//   file_put_contents('debug.txt', var_export($_REQUEST,1)."\r\n",FILE_APPEND);
		try{
			if(Mod::app()->request->enableCsrfValidation&&!$this->checkToken()){
                             $result_json =  json_encode(array('state' => 0, 'mess' => '数据不合法'));echo "flightHandler($result_json)";die;
                        }
			
			$source=Tool::getValidParam('source','integer');
                        $verify=Tool::getValidParam('f_verify','string');
                        $captcha=new CCaptchaAction($this,'captcha');
                        if(!$captcha->validate($verify,false)){
                               $result_json =  json_encode(array('state' => 0, 'mess' => '验证码错误'));echo "flightHandler($result_json)";die;
                        }
                        $captcha->getVerifyCode(true);
			
			$cateid=Tool::getValidParam('cateid','integer');
			if(!$cateid) throw new CException('100');
			$uin=Tool::getValidParam('uin','bigint');
			if(!$uin) throw new CException('104');
			$uid=$this->getUid();
			if($uid==0) throw new CException('105');
			
			$title=Tool::noscript(Tool::cutf8(Tool::getValidParam('title','sentence')));
                        if(!$title){
                               $result_json =  json_encode(array('state' => 0, 'mess' => '标题不能为空'));
                        }
			$content=Tool::noscript(Tool::cutf8(Tool::getValidParam('content','sentence')));
                        if(!$content){
                                $result_json =  json_encode(array('state' => 0, 'mess' => '内容不能为空'));
                        }
			$attachments=Tool::getValidParam('attachments','string'); //客户端返回的附件TYPE_ID用 , 号隔开
			$location_x=Tool::getValidParam('location_x','double');
			$location_y=Tool::getValidParam('location_y','double');
			$location_scale=Tool::getValidParam('location_scale','integer');
			$location_label=Tool::noscript(Tool::cutf8(Tool::getValidParam('location_label','string')));
			$informant_name=Tool::noscript(Tool::cutf8(Tool::getValidParam('username','string')));
                 
                        $informant_picture = Tool::cutf8(Tool::getValidParam('picture','string'));
                        if(!$informant_name) {
                               $result_json =  json_encode(array('state' => 0, 'mess' => '姓名不能为空')); echo "flightHandler($result_json)";die;
                        }
			$informant_tel=Tool::getValidParam('phone','string');
			//创建report记录
			$r=new Report;
			$r->validate('insert');
			$rid=$r->savedata(array('uid'=>$uid,'category_id'=>$cateid,'title'=>$title,'content'=>$content,'location_x'=>$location_x,'location_y'=>$location_y,'location_scale'=>$location_scale,'location_label'=>$location_label,
				'top_create_time'=>0,'create_time'=>time(),'status'=>1,'ip'=>ip2long(Mod::app()->request->userHostAddress),'source'=>$source,'allow_comment'=>2,'informant_name'=>$informant_name,'informant_tel'=>$informant_tel,'informant_picture'=>$informant_picture));
			unset($r);
			//如果有附件，保存report_media
			if($attachments){
				$arratta=explode(',',$attachments);
				foreach($arratta as $atta){
					$rm=new ReportMedia;
					$attav=explode('_',$atta);
					$rm->savedata(array('attachment_id'=>$attav[1],'report_id'=>$rid,'media_type'=>$attav[0],'status'=>0));
					unset($rm);
				}
			}
			//将报料信息提交到评论系统
			//$targetid=$this->postAritcleToCoral($cateid,$rid,$title,$content);
			//保存评论系统targetid到report表对应记录
			//Report::model()->updateByPk($rid,array('targetid'=>$targetid));
		}catch(Exception $e){
                      $result_json =  json_encode(array('state' => 0, 'mess' => $e->getMessage()));
		}

                 $result_json =  json_encode(array('state' => 1, 'mess' => '发布成功,请等待审核!')); echo "flightHandler($result_json)";die;
         
	}
	
	/**
	 *  @desc 发布文章到评论系统
	 *  @param cateid int 报料频道ID(必须)
	 *  @param reportid int 报料ID(必须)
	 *  @param title  报料标题(必须)
	 *  @param content 报料内容(必须)
	 *  @return json 报料信息列表数组
	 */
	private function postAritcleToCoral($cateid,$reportid,$title,$content){
		return Comment::postAritcleToCoral($cateid,$reportid,$title,$content);
	}
	
	
	/**
	 * 获取我的报料的详情页
	 * @throws CException
	 */
	public function actionGetMyReport(){
		try{
			//检查callback函数名是否正常传递
			$id=Tool::getValidParam('id','integer');
			$accounttype=Tool::getValidParam('accounttype','integer');
			$accountid=Tool::getValidParam('accountid','string');
			$wechatid=Tool::getValidParam('wechatid','string');
			if(!($id)) throw new CException('100');

// 			if(!in_array($accounttype, array(1,2))) throw new CException('109');
// 			if($accounttype==2){
// 				$user = User::model()->find('account_id=:account_id and account_type=:account_type',array(':account_id'=>$accountid,':account_type'=>$accounttype))->attributes;
// 			}else if($accounttype==1){
// 				if(!$wechatid) throw new CException('107');
// 				$user = User::model()->find('account_id=:account_id and account_type=:account_type and wechat_id=:wechat_id',array(':account_id'=>$accountid,':account_type'=>$accounttype,':wechat_id'=>$wechatid))->attributes;
// 			}
// 			if(!$user) throw new CException('106');

// 			$cachekey='wxmyr_'.$id.$accountid.$accounttype.$wechatid;

			//if( !($info=Mod::app()->memcache->get($cachekey)) ){
				$result=Report::model()->findBySql('select * from report where report_id='.$id.' and status>0');
				//将从数据库获取的数据写入要输出的数组
				$info=array();
				if($result){
					$info['report_id']=$result['report_id'];
					$info['uid']=$result['uid'];
					$info['category_id']=$result['category_id'];
					$info['title']=Tool::noscript($result['title']);
					$info['content']=str_replace("\n", '<br />', Tool::noscript($result['content']));
					$info['top_create_time']=$result['top_create_time'];
					$info['create_time']=date('Y/n/j H:i',$result['create_time']);
					$info['ip']=$result['ip'];
					$info['status']=$result['status'];
					$info['counter_clicks']=$result['counter_clicks'];
					$info['counter_reply']=$result['counter_reply'];
					$info['allow_comment']=$result['allow_comment'];
					$info['informant_name']=Tool::noscript($result['informant_name']);
					$info['informant_tel']=Tool::noscript($result['informant_tel']);
					$info['targetid']=isset($targetid)?$targetid:$result['targetid'];
					$info['flag'] = $result['flag'];
					$info['url'] = 'http://hb.qq.com/baoliao/detail.htm?id='.$result['report_id'];
// 					$info['user'] = $user;
					//查找所有的附件
					$rm=ReportMedia::model()->findAllBySql("select report_media.attachment_id,report_media.media_type,attachment.description as status from report_media left join attachment on report_media.attachment_id=attachment.a_id where report_media.report_id={$result['report_id']}");
					if($rm){
						foreach($rm as $rs){
							//已经通过审核的
							$info[$rs['media_type']][]=$rs['status'];
						}
					}
					foreach ($result->follow as $k=>$v){
						$f = $v->attributes;
						if($f['admin_id']){
							$info['follow'][$v->attributes['id']]['id']=$v->attributes['id'];
							$info['follow'][$v->attributes['id']]['admin_name']=$v->admin->attributes['name'];
							$info['follow'][$v->attributes['id']]['title']=Tool::noscript($v->attributes['title']);
							$info['follow'][$v->attributes['id']]['content']=Tool::noscript($v->attributes['content']);
							$info['follow'][$v->attributes['id']]['create_time']=date('Y/n/j H:i',$v->attributes['create_time']);
						}else if($f['uid']){
							$info['follow'][$v->attributes['id']]['id']=$v->attributes['id'];
							$info['follow'][$v->attributes['id']]['title']=Tool::noscript($v->attributes['title']);
							$info['follow'][$v->attributes['id']]['content']=Tool::noscript($v->attributes['content']);
							$info['follow'][$v->attributes['id']]['create_time']=date('Y/n/j H:i',$v->attributes['create_time']);
						}
					}
				}
// 				Mod::app()->memcache->set($cachekey,$info,1800);
			//}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$info
		);
		Output::push($result, 'json');
	}

	
        //精选
        public function actionNewChoiceReportsList()
	{
		try{
			//检查callback函数名是否正常传递
			$callback=Tool::getValidParam('callback','string');
			if( strpos($callback,'<')>0||strpos($callback,'>')>0||strpos($callback,'"')>0||strpos($callback,"'")>0 ) throw new CException('109');
			//是否刷新缓存
			$act=Tool::getValidParam('act','string');
			$silence=Tool::getValidParam('silence','integer');
			
			$cityid=Tool::getValidParam('cityid','integer');
			if(!$cityid) throw new CException('101');
				
			$num=Tool::getValidParam('num','integer',10);
                        if($num<=0){ $num =10;}
			$pageno=Tool::getValidParam('pageno','integer',1);
                        if($pageno<=0){ $pageno =1;}
			//按照类别ID分页数页号是否有回复命名cache key，如果对应数据不存在从数据库读取，保存1个小时
			$cachekey='withimglink_choicelist'.$cityid.'_'.$num.'_'.$pageno;
			if( !($data=Mod::app()->memcache->get($cachekey)) || $act=='refresh' ){
                            
                                //太慢了 注释掉   其实不用category_id   查出来也是全部的 
//				$sql='select count(*) from report where category_id in (select category_id from category where city_id='.$cityid.') and status=2 and choice=1';
                                $sql='select count(*) from report where status=2 and choice=1';
				$resultCount=Report::model()->countBySql($sql);
//				$sql='select * from report where category_id in (select category_id from category where city_id='.$cityid.') and status=2 and choice=1 order by create_time DESC, report_id DESC limit '.($pageno-1)*$num.','.$num;
                                $sql='select * from report where  status=2 and choice=1 order by create_time DESC, report_id DESC limit '.($pageno-1)*$num.','.$num;
				$result=Report::model()->with('reportmedia')->findAllBySql($sql);
				//将从数据库获取的数据写入要输出的数组
				$list=array();
				$tids = array();
				foreach($result as $record){
					$userinfo =User::getUserById($record['uid']);
                                        if($userinfo['account_id']&&$userinfo['picture']){
                                            $picture = $userinfo['picture'];
                                        }else if($userinfo['account_id']){
                                             $picture = User::getUserpictureByIdonline($userinfo['account_id']);
                                        }
                                        $picture =$picture?$picture:'';
					$tlist=array(
						'report_id'=>$record['report_id'],
						'category_id'=>$record['category_id'],
                                                'uid'=>$record['uid'],
						'title'=>Tool::noscript($record['title']),
						'content'=>Tool::truncate_utf8_string(Tool::noscript($record['content']),'110'),
						'create_time'=>date('Y/n/j H:i',$record['create_time']),
						'counter_clicks'=>$record['counter_clicks'],
						'counter_reply'=>$record['counter_reply'],
						'informant_name'=>Tool::noscript($record['informant_name']),
                                                'informant_picture'=>$picture,
						'view'=>$record['counter_clicks'],
						'targetid'=>$record['targetid'],
						'flag'=>$record['flag']
					);
					if($record['reportmedia']){
						foreach($record['reportmedia'] as $rs){
							//已经通过审核的
							if($rs['status']==2){ 
                                                            $tlist[$rs['media_type']][]=$rs['attachment_id'];
                                                        }
						}
                                                $sql='';
//                                                if(!empty($tlist[$rs['media_type']])){
//                                                $sql = 'select a.description from report_media as r right join attachment as a on r.attachment_id = a.a_id  where r.id in('.  @implode(',', $tlist[$rs['media_type']]).')';
//                                                 $attr_res = Mod::app()->db->createCommand($sql)->queryAll();
//                                                 foreach($attr_res as $td){
//                                                $tlist[$rs['media_type'].'_description'][] =  $td['description'];
//                                                 }
//                                                }
                                                  if(!empty($tlist['image'])){
//                                                $sql = 'select a.description from report_media as r right join attachment as a on r.attachment_id = a.a_id  where r.id in('.  implode(',', $tlist[$rs['media_type']]).')';
//                                                 $attr_res = Mod::app()->db->createCommand($sql)->queryAll();
                                                 foreach($tlist['image'] as $v){
                                                    $tlist[$rs['media_type'].'_description'][] =  Tool::getImg($v,'200136');
                                                 }
                                                }
					}
					$list[]=$tlist;
					if($record['targetid'])	$tids[]=$record['targetid'];
				}
				$cnum=Comment::getCommentsNumberByTargetids($tids);
				foreach ($list as $key=>$val)
					$list[$key]['targetid_num'] = empty($cnum[$val['targetid']]['commentnum'])?'0':$cnum[$val['targetid']]['commentnum'];
				$data=array('page'=>array('count'=>$resultCount,'size'=>$num,'no'=>$pageno),'list'=>$list);
				Mod::app()->memcache->set($cachekey,$data,300);
			}
		}catch(Exception $e){
			$error['code']=$e->getMessage();
		}
		$result=array(
				'sys_param'=>array('ret_code'=>isset($error['code'])?$error['code']:0,'sys_time'=>time()),
				'data'=>$data
		);
		if($silence) $result=array('ret_code'=>isset($error['code'])?$error['code']:0);
		Output::push($result, 'jsonp', $callback);
	}
        
}
