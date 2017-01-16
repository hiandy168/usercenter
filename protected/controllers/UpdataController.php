<?php

class UpdataController extends FrontController {

    public function actionPic() {
        echo "开发中";exit;
        ob_end_clean(); 
        $page = Mod::app()->request->getQuery('page', 1);//get
        $model = new Article();
        $criteria = new CDbCriteria();
        $criteria->order = 't.id asc';
        $data['count'] = $model->count($criteria);
        $pages = new CPagination($data['count']);
        $pages->pageSize = 200;
        $pages->currentPage = isset($page)?($page-1):0;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);

        $data['pagebar'] = $pages;

        foreach ($result as $c) {
            $data['list'][] = $c->attributes;
            $match =array();
            preg_match("<img.*src=[\"](.*?)[\"].*? >", $c->content, $match);
            $log = '处理id:'.$c->id.'    ';
            if(isset($match[1])&&$match[1]){
                $picture = str_replace('http://www.ufena.com/', '', $match[1]);
                $sql = 'update {{article}} set `picture` ="'.$picture.'" where id ='.$c->id;
                $log .= $sql.'  ';
                Mod::app()->db->createCommand($sql)->execute();
            }
            file_put_contents('pic_updata.log', $log."\r\n",FILE_APPEND);
            echo $log."<br>";
//            sleep(1);
            print str_pad("", 1024);
            @ob_flush();         //@禁止显示错误，如果前面没有缓冲内容，ob_flush是会出错的
            flush();               
        }   
          $url = $this->createUrl('updata/pic/',array('page'=>$page+1));
          echo '<script>window.location.href="'.$url.'";</script>';
//          $this->redirect($url);
    }

}


//ob_end_clean();     //在循环输出前，要关闭输出缓冲区 
//sleep(1);
//print "一共10000个档案要处理<hr>";
//for ($i = 1; $i <= 10000; $i++) {
//    sleep(1);
//    print "#$i,";
//    print str_pad("", 1024);
//    @ob_flush();         //@禁止显示错误，如果前面没有缓冲内容，ob_flush是会出错的
//    flush();       //浏览器在接受输出一定长度内容之前不会显示缓冲输出，这个长度值 IE是256，火狐是1024
//}
    
//方法一：
//        preg_match_all("/src=\"\/?(.*?)\"/", $test, $match);
//        //print_r($match[1]);
//        echo($match[1][0]);    
//方法二：
//        preg_match("<img.*src=[\"](.*?)[\"].*? >", $test, $match);
//        echo "$match[1]";