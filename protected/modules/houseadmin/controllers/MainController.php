<?php

class MainController extends HaController {

    public function actionIndex() {
         $data = array(
            'menu' => $this->admin_menu
        );
        $data['user_info']  = Mod::app()->session['admin_user'];
        $cache_type = $this->cache_type?$this->cache_type:'filecache';
        //获取用户分组数据
        $group_key  =  'cache_group'; 
        $data['group'] =Mod::app()->$cache_type->get($group_key);  
        if($data['group']===false  || empty($data['group']))  {  
            $membergroup = Membergroup::model()->findAll('status = 1');
            foreach($membergroup as $group ){
                $data['group'][$group['id']] = $group;
            }
            Mod::app()->$cache_type->set($group_key,$data['group']);  
        }  
        
        //语言列表
        $lang = Lang::model()->findAll("status = 1");
        foreach($lang as $l){
            $data['lang_arr'][$l->id] = $l->attributes;
        }
        $this->renderPartial('main',$data);
    }

    public function actionTop() {
        $data = array(
            'menu' => $this->admin_menu
        );
        $data['user_info']  = Mod::app()->session['admin_user'];
        $cache_type = $this->cache_type?$this->cache_type:'filecache';
        //获取用户分组数据
        $group_key  =  'cache_group'; 
        $data['group'] =Mod::app()->$cache_type->get($group_key);  
        if($data['group']===false  || empty($data['group']))  {  
            $membergroup = Membergroup::model()->findAll('status = 1');
            foreach($membergroup as $group ){
                $data['group'][$group['id']] = $group;
            }
            Mod::app()->$cache_type->set($group_key,$data['group']);  
        }  
        
        //语言列表
        $lang = Lang::model()->findAll("status = 1");
        foreach($lang as $l){
            $data['lang_arr'][$l->id] = $l->attributes;
        }
        
        
             
        $this->renderPartial('top', $data);
    }
    
    public function actionChangelang(){
        if(Mod::app()->request->isPostRequest){
            $lang = Mod::app()->request->getPost('lang', 'zh_cn');
            Lang::setLang('admin',  trim($lang));
            echo json_encode(array('state'=>1));
        }
    }

    public function actionLeft() {
        $this->renderPartial('left');
    }

    public function actionBar() {
        $this->renderPartial('bar');
    }

    public function actionCenter() {
        $this->renderPartial('center');
    }

    public function actionRight() {
        $this->renderPartial('rught');
    }

    public function actionFooter() {
        $this->renderPartial('footer');
    }
    
    public function actionAjax_menu() {
        if (isset($_POST['type']) && $_POST['type']) {
            $menu = $this->admin_menu;
            $left_menu = $menu[$_POST['type']];
             $html = '';
            if(!isset($left_menu['menu'])||!$left_menu['menu']){
                $html .='<h1><span class="ico"></span><span>' . $left_menu['title'] . '</span><span class="switchs"></span></h1>';
                $html .= '<ul>';
                $i = 1;
                foreach ($left_menu['children'] as $c) {
                    $html .= '<li ' . (($i == 1) ? 'class="active"' : '') . 'ref="' . $c['url'] . '"><span>' . $c['title'] . '</span><span class="ico"></span></li>';
                    $i++;
                }
                $html .= '</ul>';
            }else{
               $frist_chliden = $left_menu['children'][0]['children'][0];
               foreach($left_menu['children'] as $c){
                    $html .='<h1><span class="ico"></span><span>' . $c['title'] . '</span><span class="switchs"></span></h1>';
                    $html .= '<ul>';
                    $i = 1;
                    foreach ($c['children'] as $cc) {
                    $html .= '<li ' . (($frist_chliden['url'] == $cc['url']) ? 'class="active"' : '') . 'ref="' . $cc['url'] . '"><span>' . $cc['title'] . '</span><span class="ico"></span></li>';
                    $i++;
                    }
                    $html .= '</ul>';
               }
                
            }
//                file_put_contents('/text.txt', $html);
            echo $html;
        }
    }

}
