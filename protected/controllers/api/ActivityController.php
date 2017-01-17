<?php

class ActivityController extends FrontController {
        
    public function Init(){
        parent::init();
    }
    /*
     * 活动推荐 列表接口  报名
     * */
    public function actionSignupList(){
        //根据推荐活动 type 规则  4等于 投票 &报名，
        $page=Tool::getValidParam("page",'integer');
        $Activity_recommend= new Activity_recommend;
        $list=$Activity_recommend->apiActivityListPager();
/*        $list=Activity_recommend::model()->findAll("type=:type and status=:status",array(":type"=>4,':status'=>1));*/
        $data=array();
        if($list['criteria']){
            $msg=array();
            foreach($list['criteria'] as $key=>$val){
                //0代表报名
                $res=Activity_vote::model()->find("id=:id and component=:component ",array(":id"=>$val->aid,":component"=>0));
                if($res){
                    if($res->start_time>time()){
                        $msg['status']=1;//未开始
                    }
                    if($res->end_time<time()){
                        $msg['status']=2;//已结束
                    }

                    $msg['title']=$res->title;
                    $msg['linkDetail']=$this->_siteUrl."/activity/vote/views/id/$res->id";
                    $msg['id']=$res->id;
                    $msg['desc']=$res->desc;
                    $msg['background']=$res->background;
                    $msg['img']=$this->_siteUrl."/".$res->img;
                    $msg['start_time']=$res->start_time;
                    $msg['end_time']=$res->end_time;
                    $msg['address']=$res->address;
                    $datas[]=$msg;
                }

            }
            $page=$page*2?$page:0;
            $datapage=array_slice($datas,$page,2);
            $data=array('code'=>1,'data'=>$datapage);
        }else{
           $data=array("code"=>0,'data'=>"There is no data");
        }
        $result=json_encode($data);
        echo "flightHandler($result)";
    }
    
}
