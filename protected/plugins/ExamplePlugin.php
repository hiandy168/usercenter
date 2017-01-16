<?php
class ExamplePlugin extends Plugin {

    public function init() {                    #插件初始化,配置插件信息 必须
        // set plugin's info
        $this->identify = 'Example';            #必要参数, 插件的唯一标识.
        $this->name = 'Example Plugin';         #必要参数, 插件的显示名称.
        $this->version = '1.0';                 #插件版本号
        $this->description = 'description here';    #插件描述
        $this->copyright = '插件版权信息'; #插件版权信息
        $this->website = 'http://example.com';      #网站
        $this->icon = 'ExamplePlugin.png'; #插件图标,最大72*72, 如果不设置将使用默认图标;
    }

    // 返回要使用的钩子的数组,值是钩子对应的方法名
    public function Hooks(){
        return array(
            //'钩子名称' => '钩子方法';
            'Hook_Index_Header' => 'header',
        );
    }

    // 钩子对应的方法
    public function header(){
        // some codes here
        echo '这将在显示在 Hook_Index_Header 钩子处';
    }

    // 如果你想显示一个单页(独立url)而不是在页面中渲染一个小组件,
    // 你可以在方法名前"action"单词予以标识, "action"后的就是该动作的动作名
    // e.g.:
    public function actionPage() {
        echo "此action有如下url(以下rul带伪静态):";
        # 域名/plugin<模块名>/plugin<控制器名>/index<动作分发Action>
        # ?id=xx<插件唯一标识>&action=xxx<插件内单页动作名>
        echo "You_Domain.com/plugin/plugin/index?id=example&action=page";

        #可以通过调用方法 'createUrl' 来生成该链接
        echo $this->createUrl('page',array('param'=>'test'));
    }

    public function actionExample(){
        # 这个动作以该插件的identify命名
        # $action 参数可以留空或者设为非真值
        echo $this->createUrl();
    }

    // 如果你的插件需要在后台进行相关配置
    // 可以继承此方法:
    public function admincp() {
        // You can put codes here.
        // Like some inputs
        $this->setSetting('key','value');   # 写入配置
        echo $this->getSetting('key');      # 读取配置
    }

    // 继承下面两个函数可以在安装和卸载时进行额外的操作
    public function Install() {
        //codes here
        $sql = "create `tbl_xxxxxx` .....";     # 使用带表前缀的sql语句
        $this->query($sql,'tbl_');              # 并将表前缀传入query函数
                                                # 默认表前缀为'tbl_'
        return true; #此方法必须返回true,否则安装无法正常完成
    }

    public function Uninstall() {
        // just like the method install.
        return true; #此方法必须返回true,否则卸载无法正常完成
    }

    // 一个简单的插件就完成了
    // 高级使用方法,见Demo
}