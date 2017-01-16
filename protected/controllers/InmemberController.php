<?php

class InmemberController extends FrontController {
      public function actionTest() {
         die('0000000');
      }

    public function actionIndata() {
        ob_end_clean(); 
        $page = Mod::app()->request->getQuery('page', 1);//get
        $page_size = 50;
        $offset = isset($page)?($page-1):0;
//          echo $offset*$page_size.'&nbsp;&nbsp;&nbsp;'.$page_size.'<br><br><br><br>';
       $result  =  $this->csv_get_lines("ucenter.csv", $page_size, $offset*$page_size);  //从第11行到第20行
       var_dump($result);
          if($result){
                foreach ($result as $item){
//                       $item = explode(',', $dd);
                    
                        if(!$item[1]) continue;
                        if(!ctype_digit($item[1]))continue;
                        $memberinfo = Member::model()->find('phone ='. $item[1]);
                        if(!$memberinfo){
                            echo $item[1]."     <span style='color:#00ff00'>insert</span>";
                            echo '&nbsp;&nbsp;>>>>&nbsp;&nbsp;';
                            $model = new Member();
                            $model->username =  $item[0]?$item[0]:'';
                            $model->phone =$model->name =  $item[1];
                            $model->regtime =  $item[2]?strtotime($item[2]):0;
                              if($item[3]=='女'){
                                $model->sex =  2;
                            }else  if($item[3]=='男'){
                                $model->sex =  1;
                            }
//                             $model->num = $item[4];
                            $model->status =1;
                            $model->save();
                        }else{
                            echo $item[1]."     <span style='color:#ff0000'>repeat</span> ";
                            echo '&nbsp;&nbsp; >>>>&nbsp;&nbsp; ';
 
                        }
                        //            sleep(1);
                    print str_pad("", 1024);
                    @ob_flush();         //@禁止显示错误，如果前面没有缓冲内容，ob_flush是会出错的
                    flush();       
                }
                
                $url = $this->createUrl('Inmember/indata/',array('page'=>$page+1));
                echo '<script>window.location.href="'.$url.'";</script>';
                $this->redirect($url);
          
          }


         
    }
 /**
 * csv_get_lines 读取CSV文件中的某几行数据
 * @param $csvfile csv文件路径
 * @param $lines 读取行数
 * @param $offset 起始行数
 * @return array
 * */
function csv_get_lines($csvfile, $lines, $offset = 0) {
    if(!$fp = fopen($csvfile, 'r')) {
     return false;
    }
    $i = $j = 0;
 while (false !== ($line = fgets($fp))) {
  if($i++ < $offset) {
   continue;
  }
  break;
 }
 $data = array();
 while(($j++ < $lines) && !feof($fp)) {
  $data[] = fgetcsv($fp);
 }
 fclose($fp);
    return $data;
}

//
// public function actionreadcsv(){   
//      $result  =  $this->get_file_line("2406.csv", 11, 20);  //从第11行到第20行
////      var_dump($result);die;
//        foreach ($result as $dd){
//            $item = explode(',', $dd);
//              echo $item[2].'<br>';
////                $memberinfo = Member::model()->find('phone ='. $arr[2]);
////                die;
//////                  $model = new Member();
//////                  $model->
//        }
//       
//            
//   }
//   

}

