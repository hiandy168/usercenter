<?php
/**
 * 单页管理
 *
 
 
 
 * @package       /protected/modules/b2c/controllers
 
 */

class PageController extends B2cController
{
    /**
     * 关于商城
     */
    public function actionAbout()
    {
        $this->render('about');
    }
} 