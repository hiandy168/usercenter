<?php

/**
 * @author        wenlijiang 5367604@qq.com
 * @link          http://www.9open.com
 * @version       v1.0
 */
class JkCms {
    
    public static function SiteConfig() {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('SiteConfig_'.$lang);
        if(empty($res)){
            $sql ="select * from {{setting}} where lang='".$lang."'";
            $res = Mod::app()->db->createCommand($sql)->queryAll();  
            foreach($res as $r){
                $data[$r['name']]=$r['value'];
            }
            MyCache::set('SiteConfig_'.$lang,$data);
        }else{
           $data =$res;
        }
        return $data;
    }
    
    /* 获取导航*/
    public static function getNav($id = '',$fid=0) {
        $key = 'nav_'.$id.'_'.$fid;
        $res = MyCache::get($key);
        if(empty($res)){
            $sql ="select * from {{nav}} where type_id='".$id."' and status=1  and fid='".$fid."' order by `order` desc,`path` ASC";
            $res = Mod::app()->db->createCommand($sql)->queryAll();  
            foreach($res as &$r){
                if($r['url']){
                    $r['url'] = (strstr($r['url'],'http://')||strstr($r['url'],'https://'))?$r['url']:Mod::app()->createAbsoluteUrl($r['url']);
                }else{
                    $r['url'] = 'javascript:void(0);';
                }
                $r['sub_nav'] = self::getNav( $r['type_id'], $r['id']);
            }
            unset($r);
            MyCache::set($key,$res);
        }
        return $res;
    }
    
      /* 获取栏目  可以做导航*/
    public static function getCategorychildens($id='' ,$limit='') {
        $lang = MyLang::getLang('front');
        $key= 'Categorychildens'.$id.'_'.$limit.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $where ='';
            if($id)$where = " and fid='".$id."'";
            if($limit){
               $sql ="select * from {{category}} where status=1 ".$where." and lang='".$lang."' limit ".$limit ;
            }else{
               $sql ="select * from {{category}} where status=1 ".$where." and lang='".$lang."'"; 
            }
            $result = Mod::app()->db->createCommand($sql)->queryAll();     
            foreach($result as $k=>$r){
                $res[$r['id']] = $r;
                $res[$r['id']]['url'] = Mod::app()->createUrl('c/'.$r['alias']);
            }
            unset($result,$r);
            MyCache::set($key,$res);
        }
        return $res;
    }
     
    
   /* 获取栏目  可以做导航*/
    public static function getCategory($model='') {
        $lang = MyLang::getLang('front');
        $key= 'category_'.$model.'_'.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $where ='';
            if($model)$where = " and model='".$model."'";
            $sql ="select * from {{category}} where status=1 ".$where." and lang='".$lang."'";
            $result = Mod::app()->db->createCommand($sql)->queryAll();     
            foreach($result as $k=>$r){
                $res[$r['id']] = $r;
                $res[$r['id']]['url'] = Mod::app()->createUrl($r['alias']).'?lang='.$lang;
            }
            unset($result,$r);
            MyCache::set($key,$res);
        }
        return $res;
    }
    
    /* 通IID获取制定的分类*/
    public static function getCategoryByid($id = '') {
        $lang = MyLang::getLang('front');
        $key = 'getCategoryByid_'.$id.'_'.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $sql ="select * from {{category}} where id='".$id."' and status=1 and lang='".$lang."'";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            MyCache::set($key,$res);
        }
        return $res;
    }
    
     /*递归获取分类的顶级父类*/
    public static function getCategoryparentByid($id) {
        $lang = MyLang::getLang('front');
        $key= 'categoryparentByid'.$id.'_'.$lang;
        $res = MyCache::get($key);
//        $res =array();
        if(empty($res)){
            $result = JkCms::getCategoryByid($id);
            if($result && !$result['fid']){
                $res = $result;
            }else if($result && $result['fid']){
                $res = JkCms::getCategoryparentByid( $result['fid']);
            }else{
                $res = array();
            }
            MyCache::set($key,$res);
        }
        return $res;
    }
    
    /* 获取友情连接*/
    public static function getFriendlink($id = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('friendlink_'.$id.'_'.$lang);
//        $res = false;
        if(empty($res)){
            $sql ="select * from {{friendlink}} where type_id='".$id."' and status=1  and lang='".$lang."' order by `order` desc,id desc ";
            $res = Mod::app()->db->createCommand($sql)->queryAll();  
            MyCache::set('friendlink_'.$id.'_'.$lang,$res);
        }
        return $res;
    }
    
/* 获取广告*/
    public static function getAds($id = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('ads_type_'.$id.'_'.$lang);
        if(empty($res)){
            $sql ="select * from {{ads}} where type_id='".$id."'  and status=1 and lang='".$lang."' order by id desc";
            $res = Mod::app()->db->createCommand($sql)->queryAll();  
            MyCache::set('ads_'.$id.'_'.$lang,$res);
        }
        return $res;
    }
    
    /* 获取广告*/
    public static function getAdsbyid($id = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('ads_byid_'.$id.'_'.$lang);
        if(empty($res)){
            $sql ="select * from {{ads}} where id='".$id."'  and status=1 order by id desc";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            MyCache::set('ads_byid_'.$id.'_'.$lang,$res);
        }
        return $res;
    }
    
   /* 获取幻灯片 Id是 typeid*/
    public static function getSlider($id = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('slider_'.$id.'_'.$lang);
        if(empty($res)){
            $sql ="select * from {{slider}} where type_id='".$id."'  and status=1  and lang='".$lang."' order by `order` desc,id desc";
            $res = Mod::app()->db->createCommand($sql)->queryAll();  
            MyCache::set('slider_'.$id.'_'.$lang,$res);
        }
        return $res;
    }
    
   /* 获取碎片 by ID*/
    public static function getFragmentId($id = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('fragment_'.$id.'_'.$lang);
        if(empty($res)){
            $sql ="select * from {{fragment}} where id='".$id."'  and status=1  and lang='".$lang."'";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            $res = $res['content'];
            MyCache::set('fragment_'.$id.'_'.$lang,$res);
        }
        return $res;
    }
    
   /* 获取碎片 by alias*/
    public static function getFragment($alias = '') {
        $lang = MyLang::getLang('front');
        $res = MyCache::get('fragment_'.$alias.'_'.$lang);
        if(empty($res)){
            $sql ="select * from {{fragment}} where alias='".$alias."'  and status=1  and lang='".$lang."'";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            MyCache::set('fragment_'.$alias.'_'.$lang,$res);
        }
        return $res;
    }
    
    /* 获取tags*/
    public static function getTags($idstr = '',$html=',',$isurl=true) {
        if(!$idstr){return FALSE;}
        $lang = MyLang::getLang('front');
        $langstr = '?lang='.$lang;
        $res = MyCache::get('tags_'.$idstr.'_'.$lang);
        if(empty($res)){
            $idarr = explode(',',$idstr);
            $sql ="select * from {{tags}} where `id` in ('".implode("','", $idarr)."') and status=1 and `lang`='".$lang."'";
            $data = Mod::app()->db->createCommand($sql)->queryAll();  
            if(!$data){return FALSE;}
		$dataarr = array();
		foreach($data as $item){
			$dataarr[] = $isurl?'<a href="'.Mod::app()->createUrl('tags/'.base64_encode(urlencode($item['title'])).$langstr).'">'.$item['title'].'</a>':$item['title'];
		};
		$res = implode($html,$dataarr);
                MyCache::set('tags_'.$idstr.'_'.$lang,$res);
        }
        return $res;
    }
    
   /* 获取列表记录*/ 
    public static function getList($model, $type_id = '',$recommend ='',$picture='', $order ='`order` desc,id desc',$num='10',$cache=true) {
            $lang = MyLang::getLang('front');
            $key='';
            $cache && $key = $model.'_'.(is_array($type_id)?implode(',',$type_id):$type_id).'_'.$recommend.'_'.$picture.'_'.$order.'_'.$num.'_'.$lang;
            $res = MyCache::get($key);
            if (empty($res)){
                    if(is_array($type_id)){
                        if(in_array($model,array('article','pic','help','page','doctocs'))){
                            $where = "category_id in (".implode(',',$type_id).")";
                        }else{
                            $where = "type_id in (".implode(',',$type_id).")";
                        }
                    }else{
                        if(in_array($model,array('article','pic','help','page','doctocs'))){
                            $where = "category_id='".$type_id."'";
                        }else{
                            $where = "type_id='".$type_id."'";
                        }
                    }
                    
                    $where =  $type_id?$where:'1=1';
                    $where .= " and status=1  and lang='".$lang."' ";  
                    if($model=='article'||$model=='product'){
                        if($recommend == 'top' || $recommend == 't') $where .= "  and top=1 ";  
                        if($recommend == 'recommend' || $recommend == 'r') $where .= "  and recommend=1 ";  
                        if($recommend == 'focus' || $recommend == 'f') $where .= "  and focus=1 "; 
                        if($recommend == 'choiceness' || $recommend == 'c') $where .= "  and choiceness=1 ";  
                        if($recommend == 'hot' || $recommend == 'h') $where .= "  and hot=1 "; 
                    }
                    if($model=='article'){
                         $where .= "  and wap=1 "; 
                    }

                    if($picture) $where .= "  and picture  <> ''  "; 
                    if(!$order){
                            if($model=='article'){
                                 $order = '`top` desc,`order` desc,`createtime` desc';
                            }else{
                                 $order = '`order` desc,id desc';
                            }
                    }
                    $limit =  $num?" limit ".$num:'';
                    $sql ='select * from {{'.$model.'}} where '.$where.' order by '.$order.' '.$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    $res = self::handleData($res,$model);
                    $cache && MyCache::set($key, $res, 300);
//                    var_dump($res);die;
                    return $res;
            }else{
//                  var_dump($res);die;
                return $res;
            }
    }
    
     /* 获取列表记录*/
    public static function getItem($model, $type_id, $id= '',$position ='before',$cache=true) {
            $lang = MyLang::getLang('front');
            $cache && $key = $model.'_'.$type_id.'_'.$id.'_'.$position;
            $res = MyCache::get($key);
            if (empty($res)){
                    if(in_array($model,array('article','pic')))
                         $where = "category_id='".$type_id."'";
                    else
                         $where = "type_id='".$type_id."'";
                    $where =  $type_id?$where:'1=1';
                    $where .= "  and lang='".$lang."' and status =1 ";  
                    if($position == 'before') {
                        $where .= "  and id < ".$id;
                        $order = ' order by id desc';
                    }
                    if($position == 'after'){
                        $where .= "  and id > ".$id;
                        $order = ' order by id asc';
                    }
                    if(!$position){
                        $where .= "  and id = ".$id;
                    }
                      if($model=='article'){
                         $where .= "  and wap=1 "; 
                    }
                    $sql ='select * from {{'.$model.'}} where '.$where .$order.' limit 1';
                    $res = Mod::app()->db->createCommand($sql)->queryRow();  
                    $res = self::handleData(array($res),$model);
                    $res = array_shift($res);
                    $cache && MyCache::set($key, $res, 300);
            }
                return $res;
    }
    
    /* 获取列表记录*/ 
    public static function getListWap($model, $type_id = '',$recommend ='',$picture='', $order ='`order` desc,id desc',$num='10',$cache=true) {
            $lang = MyLang::getLang('front');
            $key='';
            $cache && $key = 'wap_'.$model.'_'.(is_array($type_id)?implode(',',$type_id):$type_id).'_'.$recommend.'_'.$picture.'_'.$order.'_'.$num.'_'.$lang;
            $res = MyCache::get($key);
            if (empty($res)){
                    if(is_array($type_id)){
                        if(in_array($model,array('article','pic','help','page','doctocs'))){
                            $where = "category_id in (".implode(',',$type_id).")";
                        }else{
                            $where = "type_id in (".implode(',',$type_id).")";
                        }
                    }else{
                        if(in_array($model,array('article','pic','help','page','doctocs'))){
                            $where = "category_id='".$type_id."'";
                        }else{
                            $where = "type_id='".$type_id."'";
                        }
                    }
                    
                    $where =  $type_id?$where:'1=1';
                    $where .= " and status=1  and lang='".$lang."' ";  
                    if($model=='article'){
                         $where .= "  and wap=1 "; 
                    }
                    if($model=='article'||$model=='product'){
                        if($recommend == 'top' || $recommend == 't') $where .= "  and top=1 ";  
                        if($recommend == 'recommend' || $recommend == 'r') $where .= "  and recommend=1 ";  
                        if($recommend == 'focus' || $recommend == 'f') $where .= "  and focus=1 "; 
                        if($recommend == 'choiceness' || $recommend == 'c') $where .= "  and choiceness=1 ";  
                        if($recommend == 'hot' || $recommend == 'h') $where .= "  and hot=1 "; 
                    }

                    if($picture) $where .= "  and picture  <> ''  "; 
                    if($model=='article'){
                         $order = '`top` desc,`order` desc,`createtime` desc';
                    }else{
                         $order = '`order` desc,id desc';
                    }
                    $limit =  $num?" limit ".$num:'';
                    $sql ='select * from {{'.$model.'}} where '.$where.' order by '.$order.' '.$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    $res = self::handleDatawap($res,$model);
                    $cache && MyCache::set($key, $res, 300);
//                    var_dump($res);die;
                    return $res;
            }else{

                return $res;
            }
    }
    
     /* 获取列表记录*/
    public static function getItemWap($model, $type_id, $id= '',$position ='before',$cache=true) {
            $lang = MyLang::getLang('front');
            $cache && $key = 'wap_'.$model.'_'.$type_id.'_'.$id.'_'.$position;
            $res = MyCache::get($key);
            if (empty($res)){
                    if(in_array($model,array('article','pic')))
                         $where = "category_id='".$type_id."'";
                    else
                         $where = "type_id='".$type_id."'";
                    $where =  $type_id?$where:'1=1';
                    $where .= "  and lang='".$lang."' and status =1 ";  
                    if($position == 'before') {
                        $where .= "  and id < ".$id;
                        $order = ' order by id desc';
                    }
                    if($position == 'after'){
                        $where .= "  and id > ".$id;
                        $order = ' order by id asc';
                    }
                    if(!$position){
                        $where .= "  and id = ".$id;
                    }
                      if($model=='article'){
                         $where .= "  and wap=1 "; 
                    }
                    
                    $sql ='select * from {{'.$model.'}} where '.$where .$order.' limit 1';
                    $res = Mod::app()->db->createCommand($sql)->queryRow();  
                    $res = self::handleDatawap(array($res),$model);
                    $res = array_shift($res);
                    $cache && MyCache::set($key, $res, 300);
            }
                return $res;
    }
    
    /* 获取tags列表*/
    public static function getTagsList( $tags='',$model='article',$order ='id desc',$num='10',$not_id='',$cache=true) {
            $lang = MyLang::getLang('front');
            $cache && $key = $tags.'_'.$model.'_'.$order.'_'.$num.'_'.$not_id.'_'.$lang;
            $res = MyCache::get($key);
            if (empty($res) && $tags){
                    $where =  '1=1';
                    $where .= " and status=1  and lang='".$lang."' ";  
                    $tag_arr =  explode(',', $tags);
                    foreach($tag_arr as $tag){
                        $where .= "  and  FIND_IN_SET($tag,tags)  ";
                    }
                    if($not_id)$where .= "  and  id <> ".$not_id;
                    if(!$order)$order = '`top` desc,`order` desc,`id` desc';
                    $limit =  $num?" limit ".$num:'';    
                    $sql ='select * from {{'.$model.'}} where '.$where.' order by '.$order.' '.$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    $res = self::handleData($res,$model);
                    $cache && MyCache::set($key, $res, 3600);
                    return $res;
            }else{
                return $res;
            }
    }
    
    
     /* 获取品论总数 缓存5分钟*/
    public static function getCommentCount( $id,$model='article') {
            $lang = MyLang::getLang('front');
            $key = 'comment_count_'.$model.'_'.$id.'_'.$lang;
            if (empty($res)){
                    $where =  '1=1';
                    $where .= " and status=1  and lang='".$lang."' ";  
                    $where .= " and cid='".intval($id)."' ";  
                    $sql ='select count(id) as count from {{'.$model.'_comment}} where '.$where;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    MyCache::set($key, $res[0]['count'], 300);
                    return $res[0]['count'];
            }else{
                return $res;
            }
    }
    /* 获取品论记录*/
    public static function getComment( $id,$model='article',$num='10',$cache=true) {
            $lang = MyLang::getLang('front');
            $cache && $key = 'comment_'.$model.'_'.$id.'_'.$num.'_'.$lang;
            $res = MyCache::get($key);
            if (empty($res)){
                    $where =  '1=1';
                    $where .= " and t.status=1  and t.lang='".$lang."' ";  
                    $where .= " and cid='".intval($id)."' ";  
                    $order = 't.id desc';
                    $limit =  $num?" limit ".$num:'';    
                    $sql ='select t.id,t.content,t.createtime,t.top,t.step,m.name as member_name from {{'.$model.'_comment}} as t left join {{member}} as m on t.member_id=m.id where '.$where.' order by '.$order.' '.$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    $cache && MyCache::set($key, $res, 500);
                    return $res;
            }else{
                return $res;
            }
    }
    
    
    
      /* 取模型字段*/
      public static function handleData($data = array(),$model='article',$host='') {
        if (empty($data) || !$model) {
            return $data;
        } else {
            	$category = self::getCategory();
            	foreach($data as $item){
                    if(isset($item['id'])){
                            $item['url'] = Mod::app()->createUrl($model.'/id/'.$item['id']);
                            $item['picture'] =Tool::show_img($item['picture'],$host);
                            $category = self::getCategory($model);
                            $item['category_name'] = isset($item['category_id']) && isset($category[$item['category_id']])?$category[$item['category_id']]['name']:'';
                            $item['content'] = str_replace('{{site_path}}',str_replace('index.php', '', Mod::app()->createAbsoluteUrl('/')), $item['content']);
                            $list[$item['id']] = $item;
                            
                    }else{
                            $list[] = array();
                    }
		} 
        }
        return $list;
    }
    
       /* 取模型字段*/
      public static function handleDatawap($data = array(),$model='article',$host='') {
        if (empty($data) || !$model) {
            return $data;
        } else {
            	$category = self::getCategory();
            	foreach($data as $item){
                    if(isset($item['id'])){
                            $item['url'] = Mod::app()->createUrl('/wap/'.$model.'/view/id/'.$item['id']);
                            $item['picture'] =Tool::show_img($item['picture'],$host);
                            $category = self::getCategory($model);
                            $item['category_name'] = isset($item['category_id']) && isset($category[$item['category_id']])?$category[$item['category_id']]['name']:'';
                            $list[$item['id']] = $item;
                    }else{
                            $list[] = array();
                    }
		} 
        }
        return $list;
    }
    

    /* 取模型字段*/
    private static function _attributes($fields = '', $model = '') {
        if (empty($fields) || trim($fields) == '*') {
            return $model->attributeNames();
        } else {
            $fields = str_replace('，', ',', $fields);
            return explode(',', $fields);
        }
    }
    
     static function get_position($array='') {
        if (is_array($array)) {
            $position = '您当前的位置：';
            $end = array_pop($array);
            foreach ($array as $k => $v) {
                $position .=   '<a  href="' . ((isset($v['url']) && $v['url']) ? $v['url'] : 'javascript:;') . '">' . $v['name'] . '</a> > ';
            }
            $position .=  '<a  href="' . ((isset($end['url']) && $end['url']) ? $end['url'] : 'javascript:;') . '">' . $end['name'] . '</a>';
        }
        return $position;
    }

    static function show_img($thumb='',$width='',$height='',$host ='') {
       
        $cache_key = $thumb.'_'.$width.'_'.$height.'_'.$host;
        $new_thumb = MyCache::get($cache_key);
        if(!$new_thumb){
                if ($thumb) {
                    if($width && $height){
                       $res  = Attachment::model()->find('url="'.$thumb.'"')->attributes;
                       if($res){
                           $res2  = Attachment::model()->find('fid='.$res['id'].' and ratio ="'.$width.'x'.$height.'"' )->attributes;
                           if($res2){
                               $thumb = $res2['url'];
                           }
                       }
                    }
                    $key_str ='data/attachment/';
                    $host = $host?$host:Mod::app()->baseUrl;
                    if(substr(trim($thumb), 0,4) == 'http'){
                            $new_thumb =$thumb;
                    }else{
                        if(substr(trim($thumb), 0,16) == $key_str || strstr($thumb,$key_str))
                            $new_thumb = $host.'/' . $thumb;
                        else
                           $new_thumb = $host.'/' .$key_str. $thumb;
                    }  
                } else {
                    $new_thumb = Mod::app()->baseUrl.'/data/nopic.jpg';
                }
                MyCache::set($cache_key,$new_thumb);
        }
        return $new_thumb;
    }
    
    static function show_member_thumb($thumb='',$host ='') {
        if ($thumb) {
            $key_str ='data/attachment/';
            $host = $host?$host:Mod::app()->baseUrl;
            if(substr(trim($thumb), 0,4) == 'http'){
                    $new_thumb =$thumb;
            }else{
                if(substr(trim($thumb), 0,16) == $key_str || strstr($thumb,$key_str))
                    $new_thumb = $host.'/' . $thumb;
                else
                   $new_thumb = $host.'/' .$key_str. $thumb;
            }
        } else {
            $new_thumb = Mod::app()->baseUrl.'/data/nopic.jpg';
        }
        return $new_thumb;
    }
    
    
    
    public static function truncate_utf8_string($string, $length, $etc = '...')  
        {  
            $result = '';  
            $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');  
            $strlen = strlen($string);  
            for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)  
                {  
                if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))  
                        {  
                    if ($length < 1.0)  
                                {  
                        break;  
                    }  
                    $result .= substr($string, $i, $number);  
                    $length -= 1.0;  
                    $i += $number - 1;  
                }  
                        else  
                        {  
                    $result .= substr($string, $i, 1);  
                    $length -= 0.5;  
                }  
            }  
            $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');  
            if ($i < $strlen)  
                {  
                        $result .= $etc;  
            }  
            return $result;  
    }
    
    public static function delhtmlimg($html){
        return preg_replace('/<img[^>]+>/i','',$html);
    }

    public static function delhtmltags($html){
        return preg_replace('/<[^>]+>/','',$html);
    }

    
     /* 获取碎片 by ID*/
    public static function getProductId($id = '') {
        $res = MyCache::get('product_'.$id);
        if(empty($res)){
            $sql ="select * from {{product}} where id='".$id."'  and status=1 ";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            MyCache::set('product_'.$id,$res);
        }
        return $res;
    }
    
     /* 获取碎片 by ID*/
    public static function getMemberById($id = '') {
        $key = 'member_'.$id;
        $res = MyCache::get($key);
        if(!$res){
            $sql ="select * from {{member}} where id='".$id."' ";
            $res = Mod::app()->db->createCommand($sql)->queryRow();  
            MyCache::set($key,$res);
        }
        return $res;
    }
    
    
    /* 获取科室*/
    public static function getOffices($limit='') {
        $lang = MyLang::getLang('front');
        $key= 'getOffices'.$limit.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            if($limit){
               $sql ="select * from {{offices}} where status=1  limit ".$limit ;
            }else{
               $sql ="select * from {{offices}} where status=1 "; 
            }
            $result = Mod::app()->db->createCommand($sql)->queryAll();    
            $res = array();
              foreach($result as $k=>$r){
                $res[$r['id']] = $r;
            }
            unset($result,$r);
            MyCache::set($key,$res);
        }
        return $res;
    }
    
    
    /* 获取科室  可以做导航*/
    public static function getOfficeschildens($id='' ,$limit='') {
        $lang = MyLang::getLang('front');
        $key= 'getOfficeschildens'.$id.'_'.$limit.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $where ='';
            if($id)$where = " and fid='".$id."'";
            if($limit){
               $sql ="select * from {{offices}} where status=1 ".$where." and lang='".$lang."' limit ".$limit ;
            }else{
               $sql ="select * from {{offices}} where status=1 ".$where." and lang='".$lang."'"; 
            }
            $result = Mod::app()->db->createCommand($sql)->queryAll();     
            foreach($result as $k=>$r){
                $res[$r['id']] = $r;
                $res[$r['id']]['url'] = Mod::app()->createUrl('c/'.$r['alias']);
            }
            unset($result,$r);
            MyCache::set($key,$res);
        }
        return $res;
    }
     
    
    /* 获取列表记录*/ 
    public static function getDoctocs($type_id = '',$recommend ='',$picture='', $order ='`order` desc,id desc',$num='10',$cache=true) {
            $lang = MyLang::getLang('front');
            $key='';
            $cache && $key = (is_array($type_id)?implode(',',$type_id):$type_id).'_'.$recommend.'_'.$picture.'_'.$order.'_'.$num.'_'.$lang;
            $res = MyCache::get($key);
            if (empty($res)){
                    if(is_array($type_id)){
                            $where = "offices_id in (".implode(',',$type_id).")";
                    }else{
                            $where = "offices_id='".$type_id."'";
                    }
                    $where =  $type_id?$where:'1=1';
                    $where .= " and status=1  and lang='".$lang."' ";  
                        if($recommend == 'top' || $recommend == 't') $where .= "  and top=1 ";  
                        if($recommend == 'recommend' || $recommend == 'r') $where .= "  and recommend=1 ";  
                        if($recommend == 'focus' || $recommend == 'f') $where .= "  and focus=1 "; 
                        if($recommend == 'choiceness' || $recommend == 'c') $where .= "  and choiceness=1 ";  
                        if($recommend == 'hot' || $recommend == 'h') $where .= "  and hot=1 "; 


                    if($picture) $where .= "  and picture  <> ''  "; 
                    if(!$order)$order = '`order` desc,id desc';
                    $limit =  $num?" limit ".$num:'';
                    $sql ='select * from {{doctors}} where '.$where.' order by '.$order.' '.$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
//                    $res = self::handleData($res,$model);
                    foreach($res as $k=>&$item){
                      $item['picture'] =Tool::show_img($item['picture']);
                    } 
                
                    $cache && MyCache::set($key, $res, 3600);
//                    var_dump($res);die;
                    return $res;
            }else{
//                  var_dump($res);die;
                return $res;
            }
    }
    
      /* 获取问答记录*/ 
    public static function getAsk($num='10',$cache=true) {
            $key='ask_limit'.$num."cache".$cache;
            $res = MyCache::get($key);
            if (empty($res) || !$cache){
                    $limit =  $num?" limit ".$num:'';
                    $sql ='select * from {{ask}} order by id desc ' .$limit;
                    $res = Mod::app()->db->createCommand($sql)->queryAll();  
                    $cache && MyCache::set($key, $res, 3600);
//                    var_dump($res);die;
                    return $res;
            }else{
//                  var_dump($res);die;
                return $res;
            }
    }
    
          /* 获取问答记录*/ 
    public static function getPageByalias($alias='',$cache=true) {
            $key='getPageByalias_'.$alias."_cache_".$cache;
            $res = MyCache::get($key);
            if (empty($res) || !$cache){
                    $sql ='select * from {{page}}  where alias ="'.$alias.'"';
                    $res = Mod::app()->db->createCommand($sql)->queryRow();  
                    $cache && MyCache::set($key, $res, 3600);
//                    var_dump($res);die;
                    return $res;
            }else{
//                  var_dump($res);die;
                return $res;
            }
    }
    

      public static function getdutyorderbyid($id='') {
            $key='getdutyorderbyid'.$id;
            $res = MyCache::get($key);
            if (empty($res)){
                    $sql ='select * from {{dutyorder}}  where id = '.$id;
                    $res = Mod::app()->db->createCommand($sql)->queryRow();  
                    $cache && MyCache::set($key, $res, 3600);
//                    var_dump($res);die;
                    return $res;
            }else{
//                  var_dump($res);die;
                return $res;
            }
    }
    
    
      public static function getDoctocdutyorder($title='') {
            $key='getDoctocdutyorder'.$title;
            $result = self::getdutyorderbyid(1);//查门诊的数据
            $result = unserialize($result['value']);
//            var_dump($result);
            $duty = array();
            foreach($result as $dk=>$dv){
                for($i=1;$i<=14;$i++){
                    if($dv[$i] == $title){
                       $duty[$dk][] = $i;
                    }  
                }
            }
            
            $str =array();
            foreach ($duty as $kk=>$vv){
                foreach($vv as $day){
                            switch ($day) {
                                case 1:
                                    $str[] ='周一上午';
                                    break;
                                case 2:
                                    $str[] ='周二下午';
                                    break;
                                case 3:
                                    $str[] ='周二上午';
                                    break;
                                case 4:
                                    $str[] ='周三下午';
                                    break;
                                case 5:
                                    $str[] ='周三上午';
                                    break;
                                case 6:
                                    $str[] ='周四下午';
                                    break;
                                case 7:
                                    $str[] ='周四上午';
                                    break;
                                case 8:
                                    $str[] ='周五下午';
                                    break;
                                case 9:
                                    $str[] ='周五上午';
                                    break;
                                case 10:
                                    $str[] ='周六下午';
                                    break;
                                case 11:
                                    $str[] ='周六下午';
                                    break;
                                case 12:
                                    $str[] ='周日上午';
                                    break;
                                case 13:
                                    $str[] ='周日下午';
                                    break;
                                case 14:
                                    break;
                            }
                    }
            }
            return implode(',', array_unique($str));
    }
    
      
    
       /* 获取栏目  可以做导航*/
    public static function getprojectByid($id) {
        $lang = MyLang::getLang('front');
        $key= 'project_'.$id."_".$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $sql ="select * from {{project}} where id= ".intval($id);
            $res = Mod::app()->db->createCommand($sql)->queryRow();     
            MyCache::set($key,$res);
        }
        return $res;
    }
    
    
   /* 获取栏目  可以做导航*/
    public static function getproject_type() {
        $lang = MyLang::getLang('front');
        $key= 'project_type_'.$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $sql ="select * from {{project_type}} where status=1 and lang='".$lang."'";
            $result = Mod::app()->db->createCommand($sql)->queryAll();     
            foreach($result as $k=>$r){
                $res[$r['id']] = $r;
            }
            unset($result,$r);
            MyCache::set($key,$res);
        }
        return $res;
    }
    
       /* 获取栏目  可以做导航*/
    public static function getproject_typeByid($id) {
        $lang = MyLang::getLang('front');
        $key= 'project_type_'.$id."_".$lang;
        $res = MyCache::get($key);
        if(empty($res)){
            $sql ="select * from {{project_type}} where id= ".intval($id);
            $res = Mod::app()->db->createCommand($sql)->queryRow();     
            MyCache::set($key,$res);
        }
        return $res;
    }
    
       /* 获取附件记录*/ 
    public static function getAttachmentByid($id,$cache=true) {
            $key='attachment_'.$id;
            $res = MyCache::get($key);
            if (empty($res) || !$cache){
                    $limit =  $num?" limit ".$num:'';
                    $sql ='select * from {{attachment}} where id='.intval($id);
                    $res = Mod::app()->db->createCommand($sql)->queryRow();  
                    $cache && MyCache::set($key, $res, 3600);
            }
             return $res;
    }
    
       

    
   /* 获取项目信息  修改的时候本缓存一定记得刷新*/
    public static function getProjectByidsecret($appid = '',$appsecret='') {
        $key = 'getProjectByidsecret_'.$appid.'_'.$appsecret;
        $res = MyCache::get($key);
        if(empty($res)){
            $res = Project::model()->findByAttributes(array('appid'=>$appid,'appsecret'=>$appsecret));
            if($res){
                MyCache::set($key,$res->attributes);
                return $res->attributes;
            }
        }
        return $res;
    }
    
    //根据access_token获取project的信息
   public static function getProjectByAccesstoken($access_token){
                $project_info['id'] =  Mod::app()->memcache->get($access_token);
               if( !$project_info['id']){
                    $returnCode['result'] = false;
                    $returnCode['code'] = 40002;
                    $returnCode['mess'] = $returnCode['code'];
                    echo json_encode($returnCode);exit;
               }

               $project_model = Project::model()->findByPk($project_info['id']);
               return $project_model->attributes;
}
    

}
