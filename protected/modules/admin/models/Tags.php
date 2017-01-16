<?php

class Tags extends CActiveRecord {
        public $tags;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Wx the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{tags}}';
    }

    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
        );
    }

   	static function loadTags($ids,$lang='zh_cn',$isurl=false){
		if(!$ids){return FALSE;}
                $langstr = '?lang='.$lang;
		$idarr = explode(',',$ids);
                $model  = New Tags();
		$data = $model->findALL(" `id` in ('".implode("','", $idarr)."') and `lang`='".$lang."'");
		if(!$data){return FALSE;}
		$dataarr = array();
		foreach($data as $item){
			$dataarr[] = $isurl?'<a href="'.Mod::app()->createUrl('tags/'.base64_encode(urlencode($item['title'])).$langstr).'">'.$item['title'].'</a>':$item['title'];
		};
		$datastr = implode(',',$dataarr);
		return $datastr;
	}
	
	static function loadTagIds($tags,$lang='zh_cn'){
                $key = md5('tags'.$tags.'_'.$lang.'JkCms');
                $res = MyCache::get($key);
                if(empty($res)){
                            $tags = trim($tags);
                            if($tags==''){return FALSE;}
                            $tags = str_replace("",",",$tags);		
                            $tagsarr = explode(',',$tags);
                            $idarr = array();
                            foreach($tagsarr as $tag){
                                    $model  = New Tags();
                                    $row = $model->find('title="'.$tag.'" and lang="'. $lang.'"');
                                    if($row){
                                            $idarr[] = $row['id'];
                                    }else{
                                            $model->title = $tag;
                                            $model->lang = $lang;	
                                            if($model->save()){
                                               $idarr[] = $model->id;
                                            }
                                    }
                            }
                            $idarr = array_unique($idarr);
                            $res = implode(',',$idarr);
                            MyCache::set($key,$res);
                }
                return $res;
	}
        
    
         

}
