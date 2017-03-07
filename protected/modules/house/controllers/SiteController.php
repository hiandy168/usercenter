<?php
class SiteController extends HouseController{
    protected $_siteUrl;
    public function init(){
        parent::init();
    }
    /**
     * 活动首页
     * author  Fancy
     */
    public function actionIndex(){
        $cityurl = trim(Tool::getValidParam('city','integer'));
        if(empty($cityurl)) {
            $cityurl=1;
        }
        Cookie::set('city', $cityurl);
        $cookie_mod=Cookie::get('city');
        if($cookie_mod){}
        if($cookie_mod!=$cityurl){
            Cookie::remove('city');
        }
        $sql = "SELECT id,title,city,actime,coupon,figue,img FROM {{house_activity}} WHERE status=1 and type=1 and poststatus!=2 and recommend=2 and city=$cookie_mod order by createtime desc limit 0,5";
        $houselist=Mod::app()->db->createCommand($sql)->queryAll();

        $resql = "SELECT id,title,city,actime,coupon,figue,img FROM {{house_activity}} WHERE status=1 and type=1 and poststatus!=2 and recommend=1 and city=$cookie_mod order by createtime desc";
        $recommondlist=Mod::app()->db->createCommand($resql)->queryAll();

        $imgsql = "SELECT img_url,url FROM {{house_img}} WHERE status=1 and city=$cookie_mod order by sort desc";
        $imglist=Mod::app()->db->createCommand($imgsql)->queryAll();

        $citysql = "SELECT phone FROM {{house_city}} WHERE status=1 and id=$cookie_mod";
        $cityinfo=Mod::app()->db->createCommand($citysql)->queryRow();
        $phone=explode('|',$cityinfo['phone']);
        $houselist=$this->actionAclist($houselist);
        $recommondlist=$this->actionAclist($recommondlist);
        $signPackage = $this->wx_jssdk(Wzbank::Wxappid, Wzbank::Wxappsecret);
        $data = array(
            'config'=>array(
                'site_title'=> "腾讯楼盘商城",
                'Keywords'=>'腾讯楼盘商城',
                'Description'=>'腾讯楼盘商城'
            ),
            'info'=>array(
                'title'=> '腾讯楼盘商城',
                'share_img'=>'http://mat1.gtimg.com/hb/0000000zhuanti/share2.png',
                'share_desc'=>'我在用腾讯楼盘商城预存抵现，房源多多，实惠多多',
                'share_url'=>$this->_siteUrl.'/house/site/index',
            ),
            'signPackage'=>$signPackage,
            'houseinfo'=>$houselist,
            'recommondlist'=>$recommondlist,
            'imglist'=>$imglist,
            'phone'=>$phone,
        );
        $this->render("index",$data);
    }

    /**
     * @abstract 加载首页数据和推荐数据公共
     * @author Fancy
     */
    public function actionAclist($houselist){
        foreach($houselist as $k=>$v) {
            $sql = "SELECT city FROM {{house_city}}   WHERE status=1 and id=".$houselist[$k]['city'];
            $city=Mod::app()->db->createCommand($sql)->queryRow();
            $houselist[$k]['city']=$city['city'];
            $actime=explode("|",$houselist[$k]['actime']);
            if(!empty($actime[0])&&$actime[0]){
                $houselist[$k]['actime1']=$actime[0];
            }else{
                echo "error";
                die();
            }
            if(!empty($actime[1])&&$actime[1]){
                $houselist[$k]['actime2']= $actime[1];
            }else{
                echo "error";
                die();
            }
            if($houselist[$k]['actime1']>time()){
                $houselist[$k]['type']= "1";
            }else{
                $houselist[$k]['type']= "2";
            }
            if (mb_strlen($houselist[$k]['title'], 'utf8') > 28){
                $houselist[$k]['title']=mb_substr($houselist[$k]['title'], 0, 28, 'utf8') . '...';
            }
            if($houselist[$k]['actime2']<time()){
                $houselist[$k]['end']= "bg2";
            }else{
                $houselist[$k]['end']= "bg1";
            }

        }
        return $houselist;
    }


    /**
     * @abstract 上拉加载房产信息
     * @author Fancy
     */
    public function actionGethouse(){
        $page = trim(Tool::getValidParam('page','integer',1));
        $pagesize = trim(Tool::getValidParam('pagesize','integer',5));
        $cookie_mod=Cookie::get('city');
        if($page<=2){$page=2;}
        $start = ($page-1)*$pagesize;
        try {
            $sql = "SELECT id,title,actime,coupon,city,figue,img,share_img FROM {{house_activity}} WHERE status=1 and poststatus!=2 and recommend=2 and city=$cookie_mod and type=1 order by createtime desc limit $start,$pagesize";
            $houselist=Mod::app()->db->createCommand($sql)->queryAll();
            $sql = "SELECT count(id) as id FROM {{house_activity}}   WHERE status=1 and poststatus!=2 and type=1 ";
            $houtenum=Mod::app()->db->createCommand($sql)->queryRow();
        }
        catch(Exception $e) {
            echo "error";die();
        }
        $page=ceil(intval($houtenum['id'])/5);
        foreach($houselist as $k=>$v) {
            $sql = "SELECT city FROM {{house_city}}   WHERE status=1 and id=".$houselist[$k]['city'];
            $city=Mod::app()->db->createCommand($sql)->queryRow();
            $houselist[$k]['city']=$city['city'];
            $houselist[$k]['page'] = $page;
            if (mb_strlen($houselist[$k]['title'], 'utf8') > 28){
                $houselist[$k]['ftitle']=mb_substr($houselist[$k]['title'], 0, 28, 'utf8') . '...';
            }else{
                $houselist[$k]['ftitle']=$houselist[$k]['title'];
            }
            $houselist[$k]['url'] = $this->_siteUrl . '/house/site/detail/id/' . $houselist[$k]['id'];
            $houselist[$k]['img'] = $this->_siteUrl . '/' . $houselist[$k]['img'];
            $actime=explode("|",$houselist[$k]['actime']);
            if(!empty($actime[0])&&$actime[0]){
                $houselist[$k]['actime1']= $actime[0];
            }else{
                echo "error1";
                die();
            }
            if(!empty($actime[1])&&$actime[1]){
                $houselist[$k]['actime2']= $actime[1];
            }else{
                echo "error2";
                die();
            }
            if($houselist[$k]['actime1']>time()){
                $houselist[$k]['ftype']= "1";
            }else{
                $houselist[$k]['ftype']= "2";
            }
            if($houselist[$k]['actime2']<time()){
                $houselist[$k]['end']= "bg2";
            }else{
                $houselist[$k]['end']= "bg1";
            }
        }
        if($houselist){
            echo json_encode($houselist);  //转换为json数据输出
        }else{
            echo json_encode(array(fcode=>0));
        }
    }

    /**
     * 点击加载报名记录
     * author  Fancy
     */
    public function actionGetorderinfo(){
        $id=Tool::getValidParam('id','integer');
        $page = trim(Tool::getValidParam('page','integer',1));
        $pagesize = trim(Tool::getValidParam('pagesize','integer',3));
        if($page<=2){$page=2;}
        $start = ($page-1)*$pagesize;
        $count="SELECT count(*) as count FROM {{house_order}} where status=1 and paystatus!=1 and houseid=".$id;
        $ordercount=Mod::app()->db->createCommand($count)->queryRow();
        $ordersql="SELECT o.applytime,o.money,m.phone,m.realname FROM {{house_order}} as o LEFT JOIN {{member}} as m on o.mid=m.id where o.status=1 and o.paystatus!=1 and o.houseid=".$id." LIMIT $start,$pagesize";
        $orderinfo=Mod::app()->db->createCommand($ordersql)->queryAll();
        foreach($orderinfo as $k=>$v) {
            $orderinfo[$k]['applytime']=date('Y-m-d H:m:s',$orderinfo[$k]['applytime']);
            $phone3=substr($orderinfo[$k]['phone'],0,3);
            $phone7=substr($orderinfo[$k]['phone'],7,10);
            $orderinfo[$k]['phone']=$phone3."****".$phone7;
            $orderinfo[$k]['realname']= mb_substr( $orderinfo[$k]['realname'],0,1,'utf-8');
        }
        $results=array(
            'code'=>0,
            'message'=>$orderinfo,
            'count'=>$ordercount,
        );
        echo json_encode($results);
    }

    /**
     * 活动详情页
     * author  Fancy
     */
    public function actionDetail(){
        $id=Tool::getValidParam('id','integer');
        $city=Tool::getValidParam('city','integer');
        if($city){
            Cookie::set('city', $city);
        }
        $cookie_mod=Cookie::get('city');

        if(!empty($id)){
            $sql = "SELECT a.id,a.phone,a.city,a.financingid,a.actime,a.repertory,a.coupon,a.desc,a.figue,a.img,a.dtitle,a.share_img,m.title,m.earnings FROM {{house_activity}} as a LEFT JOIN {{house_money}} as m on a.financingid=m.id WHERE a.status=1 and a.type=1 and city=$cookie_mod and a.id=$id";
            $houseinfo=Mod::app()->db->createCommand($sql)->queryRow();
            if($houseinfo){
                $sql = "SELECT city FROM {{house_city}}   WHERE status=1 and id=".$houseinfo['city'];
                $city=Mod::app()->db->createCommand($sql)->queryRow();
                $houseinfo['city']=$city['city'];
                $actime=explode("|",$houseinfo['actime']);
                if(!empty($actime[1])&&$actime[1]){
                    $houseinfo['actime']=$actime[1];
                }
                if($houseinfo['actime']<time()){
                    $houseinfo['end']= "bg2";
                }else{
                    $houseinfo['end']= "bg1";
                }
                if (mb_strlen($houseinfo['dtitle'], 'utf8') > 23){
                    $houseinfo['dtitle']=mb_substr($houseinfo['dtitle'], 0, 23, 'utf8') . '...';
                }
            }else{
                echo "error";
                die();
            }
        }else{
            echo "error";
            die();
        }
        $count="SELECT count(*) as count FROM {{house_order}} where status=1 and paystatus!=1 and houseid=".$id;
        $ordercount=Mod::app()->db->createCommand($count)->queryRow();
        $ordersql="SELECT o.applytime,o.money,m.phone,m.realname FROM {{house_order}} as o LEFT JOIN {{member}} as m on o.mid=m.id where o.status=1 and o.paystatus!=1 and o.houseid=".$id." LIMIT 0,3";
        $orderinfo=Mod::app()->db->createCommand($ordersql)->queryAll();
        if(!$ordercount){
            echo "error";
            die();
        }
        $phone= explode('|',$houseinfo['phone']);
        $houseinfo['createtime']=$phone[0];
        $houseinfo['updatetime']=$phone[1];
        $signPackage = $this->wx_jssdk(Wzbank::Wxappid, Wzbank::Wxappsecret);
        $data = array(
            'config'=>array(
                'site_title'=> $houseinfo['dtitle'],
                'Keywords'=>'产品详细',
                'Description'=>'产品详细'
            ),
            'infos'=>array(
                'title'=> $houseinfo['dtitle'],
                'share_img'=>'http://mat1.gtimg.com/hb/0000000zhuanti/share2.png',
                'share_desc'=>'我在用腾讯楼盘商城预存抵现，房源多多，实惠多多',
                'share_url'=>'/house/site/detail/id/'.$id,
            ),
            'signPackage'=>$signPackage,
            'houseinfo'=>$houseinfo,
            'orderinfo'=>$orderinfo,
            'count'=>$ordercount['count'],
        );
        $this->render("detail",$data);
    }

    public function actionTest(){
        $houseid=172631;
        $appId = 10000127;
        $appKey = 'c3a8c431d386516044e80211978aeab6';
        $rand = time();
        $_signatureParamArr = array ($appId, $appKey,$rand );
        sort ( $_signatureParamArr, SORT_STRING );
        $_signature = sha1 ( implode ( ($_signatureParamArr) ) );
        $url="http://api.wii.qq.com/app/access_token?app_id=".$appId."&rand=".$rand."&signature=".$_signature;
        if(empty(Mod::app()->session['facctoken'])){
            $info=$this->http_get($url);
            Mod::app()->session['facctoken'] = $info['data']['access_token'];
        }
        if($info['res']==0){
            $ss=$this->http_post(Mod::app()->session['facctoken'],$houseid);
            echo $ss;
        }else{
            echo $info;
        }
    }



    static function http_get($url){
        $curl = curl_init();
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $aStatus = curl_getinfo($curl);
        curl_close($curl);
        if(intval($aStatus["http_code"])==200){
            return json_decode($data, true);
        }else{
            return json_decode($data, true);
        }
    }

    static function http_post($token,$houseid){
        $url = "http://api.wii.qq.com/s/house/house/house/get_house_info?access_token=".$token;
        $post_data = array ("house_id" => $houseid);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
}