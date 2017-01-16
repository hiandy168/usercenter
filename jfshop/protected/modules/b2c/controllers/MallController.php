<?php
/**
 * 商城首页
 *
 
 * @copyright     Copyright (c) 2011-2015 club. All rights reserved.
 * @link          http://www.club2club.com
 * @package       api.controllers.croncontroller
 
 */

class MallController extends B2cController
{
    /**
     * 商城首页
     */
    public function actionIndex()
    {
        $this->render('index');
    }
} 