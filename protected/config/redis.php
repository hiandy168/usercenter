<?php
/**
 * redis配置
*/
 
return array(
    'class'=>'CRedisCache',
    'nameServiceKeys'=>array(
    'devIDC'=>'sz.youa_release.redis.com',
    ),
    'getIDC'=>array('devIDC'),                   //读操作时，先读取深圳IDC，如果失败再读取天津IDC
    'setIDC'=>array('devIDC'),                   //写操作时，先写深圳IDC，再写天津IDC
    'localIDC'=>'devIDC',                                        //将深圳机房设置为本地IDC机房
    'getRetryCount'=>2,                                              //读操作重试次数2次
    'getRetryInterval'=>0,                                           //读操作重试间隔0秒
    'setRetryCount'=>3,                                              //写操作重试次数3次
    'setRetryInterval'=>0.2                                          //写操作重试间隔0.2秒
);
