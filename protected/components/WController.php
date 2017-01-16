<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class WController extends CController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    protected  $mid = null;
    protected  $openid = null;
    protected  $access_token=null;
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $breadcrumbs = array();

    //用户信息$openid = $memberInfo['wechat']['openid']
    public function init()
    {
        header("Content-type: text/html; charset=utf-8");
        $memberInfo = Mod::app()->session['member'];
        if ($memberInfo['wechat']['openid']) {
            //$wm_id = $memberInfo['wechat']['id'];
            #覆盖session
            //$wechatInfo = Member_project::model()->getMemberInfo($wm_id);
            //Mod::app()->session->add('member', array('wechat' => $wechatInfo));
            $this->openid = $memberInfo['wechat']['openid'];
//            $this->access_token= $memberInfo['wechat']['access_token'];
//            $this->mid=Member_project::model()->createMember(Mod::app()->session['member']['wechat']['openid']);
            $this->access_token= $memberInfo['wechat']['access_token'];
            
            //$this->mid=Member_project::model()->createMember($memberInfo['wechat']['openid']);

        } else {
            $callBackUrl = Mod::app()->request->getBaseUrl(true) . Mod::app()->request->url;
            Mod::app()->session->add('wechat_callback', $callBackUrl);
            $this->redirect(array('weixin/auth'));
            Mod::app()->end();
        }
    }

    public function jsonData($result)
    {
        header("Cache-Control: no-cache, no-store, must-revalidate, max-age=-1");
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($result);
        exit;
    }
}