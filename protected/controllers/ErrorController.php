<?php

class ErrorController extends FrontController
{

    public function actionIndex ()
    {
//        $data['config'] = $this->site_config;
//        var_dump(Mod::app()->errorHandler->error);die;
        if ($data = Mod::app()->errorHandler->error) {
            $data['redirect'] = Mod::app()->request->urlReferrer ? Mod::app()->request->urlReferrer: Mod::app()->homeUrl;
            if (Mod::app()->request->isAjaxRequest){
                echo $data['message'];
            }else{
                echo '<div style="width:100%;text-align:center;margin:50px 0;font-size:30px;">'.$data['code'].'</div>';
                die;
//              $data['code']='404';
//              $data['message']='页面没有找到';
//              $data['redirect']='22222222222222';
//                $this->renderPartial('error', $data);
                $this->renderPartial('404', $data);
            }
        }
    }
    
     public function actionTest ()
    {
//            header("HTTP/1.1 404 xxx");
            throw new CHttpException(404, 'The requested page does not exist.');
    }
    
     public function actionBuilding ()
    {
//            header("HTTP/1.1 404 xxx");
            throw new CHttpException(404, 'The requested page does not exist.');
    }
}