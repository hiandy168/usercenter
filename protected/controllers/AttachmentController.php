<?php

/**
 * @name	ReportController
 * @author	Steve Lui
 * @desc	api for post or get reports
 * @version	1.6
 * @date	2014/2/20
 */
class AttachmentController extends FrontController {

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

    public function actionMy() {
        $data['config'] = $this->site_config;
        $where = array();
//        $result = Article::model()->findAll();
        $model = new Attachment();
        $criteria = new CDbCriteria();
        $criteria->condition = "mid = ".$this->member['id'];
         if (isset($_REQUEST['s']['original_name']) && $_REQUEST['s']['original_name']) {
            $criteria->addCondition("t.original_name like '%" . trim($_REQUEST['s']['original_name'] . "%'"));
            $data['s']['original_name'] = trim($_REQUEST['s']['original_name']);
        }
        $criteria->order = 't.`id` desc';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;

        $pages_params = array();
        if (isset($data['s']['original_name']) && $data['s']['original_name']) {
            $pages_params['original_name']  =  $data['s']['original_name'];
        }
        
        $pages->params   = $pages_params;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;

        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;


        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
        }

            $data['config'] = $this->site_config;
            $data['config']['site_title'] =  "我的素材库-".$this->site_config['site_title'];
            $data['config']['site_keywords'] = "我的素材库,".$this->site_config['site_keywords'];
            $data['config']['site_description'] = '我的素材库,'.$this->site_config['site_description'] ;
        $this->render('/attachment/my', $data);
    }

    
     public function actionDel() {
       // $id = Mod::app()->request->getParam('id');
        $id = Tool::getValidParam('id','integer');

 
        if ($id && $id==$this->member['id']){
               
                $res = '';
                $model = new Attachment;
                $res = $model->updateByPk( $id,array( "status"=>'9'));//9为用户删除
                if ($res) {
                    $mess = '删除成功！';
                    $state = 1;
                } else {
                    $mess = '删除失败！';
                    $state = 0;
                }
        }else{
                    $mess = '非法的数据操作！';
                    $state = 0;
        }
     
        echo json_encode(array('state' => $state, 'mess' => $mess));
    }
    
}
