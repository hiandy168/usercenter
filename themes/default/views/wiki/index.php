<?php echo $this->renderpartial('/common/header_new', $config); ?>


<?php
//左边接口导航列表，顺序不能改变
$left_menu=array(
    array('title'=>'获取accesstoken','url'=>$this->createurl('wiki/index', array('p' => 0))),
    array('title'=>'组件:签到','url'=>$this->createurl('wiki/index', array('p' => 1))),
    array('title'=>'组件:刮刮卡','url'=>$this->createurl('wiki/index', array('p' => 2))),
    array('title'=>'组件:报名','url'=>$this->createurl('wiki/index', array('p' => 3))),
    array('title'=>'用户注册','url'=>$this->createurl('wiki/index', array('p' => 4))),
    array('title'=>'用户登录','url'=>$this->createurl('wiki/index', array('p' => 5))),
    array('title'=>'用户用户标签设置登录','url'=>$this->createurl('wiki/index', array('p' =>6))),
    array('title'=>'获取用户中心用户','url'=>$this->createurl('wiki/index', array('p' =>7))),
    array('title'=>'微信授权,获取用户信息','url'=>$this->createurl('wiki/index', array('p' =>8))),
    array('title'=>'添加签到日志','url'=>$this->createurl('wiki/index', array('p' =>9))),
    array('title'=>'启动抽奖程序','url'=>$this->createurl('wiki/index', array('p' =>10))),
    array('title'=>'添加报名日志','url'=>$this->createurl('wiki/index', array('p' =>11))),
    array('title'=>'项目注册','url'=>$this->createurl('wiki/index', array('p' =>12))),
    array('title'=>'创建的项目列表,删除和编辑','url'=>$this->createurl('wiki/index', array('p' =>13))),
    array('title'=>'用户行为统计','url'=>$this->createurl('wiki/index', array('p' =>14)))


);
//以下数组是右边内容区  顺序不可以改变
$right_content=array(
    array(
        'function'=>'Get_token',
        'url'=>"",
        'name'=>'获取accesstoken',
        'method'=>'get',
        'parameter'=>'appid,appsecret,openid',
        'return'=>'{"code":200,"access_token":"FA7wzik260423912","expires_in":7200}',
        'describe'=>'所有接口都必须通过accesstoken来请求,在V1.0版本中获取accesstoken必须传递微信用户的openid,微信公众号的appid和appsecret',
        'case'=>'$Dachuw = new Dachuw($this->appid,$this->appsecret,$this->openid);$data = $Dachuw->Get_token();',

    ),
    array(
        'function'=>'checkIn',
        'url'=>'"http://m.hb.qq.com/activity/checkIn/index/id/$id?accesstoken=\".$accesstoken.\"&openid=\".$openid"',
        'name'=>'组件:签到',
        'method'=>'get',
        'parameter'=>'accesstoken,openid',
        'return'=>'返回',
        'describe'=>'',
        'case'=>'',
    ),
    array(
        'function'=>'Scratchcard',
        'url'=>'"http://m.hb.qq.com/activity/Scratchcard/index/id/$id?accesstoken=".$accesstoken."&openid=".$openid"',
        'name'=>'组件:刮刮卡',
        'method'=>'get',
        'parameter'=>'accesstoken,openid',
        'return'=>'返回',
        'describe'=>'',
        'case'=>'',
    ),
    array(
        'function'=>'Scratchcard',
        'url'=>'"http://m.hb.qq.com/activity/SignUp/index/id/$id?accesstoken=".$accesstoken."&openid=".$openid"',
        'name'=>'组件:报名',
        'method'=>'get',
        'parameter'=>'accesstoken,openid',
        'return'=>'返回',
        'describe'=>'',
        'case'=>'',
    ),
    array(
        'function'=>'reg',
        'url'=>'"http://m.hb.qq.com/api/member/reg"',
        'name'=>'用户注册',
        'method'=>'POST',
        'parameter'=>'appid，accesstoken，tel',
        'return'=>'{"state":100005,"message":用户已存在}  具体state返回值，参考返回代码说明',
        'describe'=>'文件 protected\controllers\api\MemberController.php',
        'case'=>'',
    ),
    array(
        'function'=>'login',
        'url'=>'"http://m.hb.qq.com/api/member/login"',
        'name'=>'用户登陆',
        'method'=>'get',
        'parameter'=>'openid，accesstoken',
        'return'=>'{"state":100010,"message":用户名或密码不正确} 具体state返回值，参考返回代码',
        'describe'=>'文件 protected\controllers\api\MemberController.php',
        'case'=>'',
    ),
    array(
        'function'=>'tag',
        'url'=>'"http://m.hb.qq.com/api/Behavior/tag"',
        'name'=>'用户标签设置',
        'method'=>'POST',
        'parameter'=>'openid，pid，accesstoken，type',
        'return'=>'{"state":100016,"message":用户标签设置失败} 具体state返回值，参考返回代码',
        'describe'=>'文件 protected\controllers\api\MemberController.php',
        'case'=>'',
    ),
    array(
        'function'=>'GetMember',
        'url'=>'"http://m.hb.qq.com/api/Member/GetMember"',
        'name'=>'获取用户中心用户',
        'method'=>'GET',
        'parameter'=>'page（必须），limit（默认一次10个用户信息），condition（默认status=1）',
        'return'=>'{"count":"9","pageCount":1,"list":[{"id":"49","name":"18688886666","tel":"0","username":"0","points":"0","group_id":"1","password":"2f47b3aba7a99ffd2177878d6bc33fb9","headimgurl":"0","vip_level":"1","sex":"1","email":"0","province":"0","city":"0","country":"0","address":"0","authentication":"0","regip":"27.17.15.94","regtime":"1459489623","lastlogintime":"0","lastloginip":"0","logincount":"0","status":"1","remark":"0","source":"30sbu"},{"id":"48","name":"15827019610","tel":"0","username":"0","points":null,"group_id":"1","password":"8f87a2f013c4109c9a0f9b5424a5ff13","headimgurl":"0","vip_level":"1","sex":"1","email":"0","province":"0","city":"0","country":"0","address":"0","authentication":"0","regip":"127.0.0.1","regtime":"1458892318","lastlogintime":"0","lastloginip":"0","logincount":"0","status":"1","remark":"0","source":"dxd0g"},{"id":"47","name":"15827019626","tel":"0","username":"0","points":null,"group_id":"1","password":"913018a22256c3bc8d595c1dbfc8e940","headimgurl":"0","vip_level":"1","sex":"1","email":"0","province":"0","city":"0","country":"0","address":"0","authentication":"0","regip":"127.0.0.1","regtime":"1458889411","lastlogintime":"0","lastloginip":"0","logincount":"0","status":"1","remark":"0","source":"cmd5q"}',
        'describe'=>'文件 protected\controllers\api\MemberController.php',
        'case'=>'',
    ),
    array(
        'function'=>'auth',
        'url'=>'"http://m.hb.qq.com/weixin/auth"',
        'name'=>'微信授权，获取用户信息',
        'method'=>'GET',
        'parameter'=>'accesstoken',
        'return'=>'{"subscribe": 1, "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M", "nickname": "Band", "sex": 1, "language": "zh_CN", "city": "广州", "province": "广东", "country": "中国", "headimgurl":   "http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",  "subscribe_time": 1382694957,"unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL""remark": "","groupid": 0
}',
        'describe'=>'文件 protected\controllers\api\MemberController.php',
        'case'=>'',
    ),
    array(
        'function'=>'addSignLog',
        'url'=>'"http://m.hb.qq.com/plug/checkIn/addSignLog"',
        'name'=>'添加签到日志',
        'method'=>'POST',
        'parameter'=>'access_token : (必须);Openid : （必须）',
        'return'=>'{"status":100012,"mess":"您今天已签到，不能重复签到"} status返回值，参考返回代码说明',
        'describe'=>'文件 protected\controllers\plug\CheckInController.php',
        'case'=>'',
    ),
    array(
        'function'=>'start',
        'url'=>'"http://m.hb.qq.com/plug/lottery/start"',
        'name'=>'启动抽奖程序',
        'method'=>'POST',
        'parameter'=>'access_token : (必须);Openid : （必须）',
        'return'=>'{"status":100018,"mess":"您已抽奖,不能重复抽奖"}  status返回值，参考返回代码说明',
        'describe'=>'文件 protected\controllers\plug\LotteryController.php',
        'case'=>'',
    ),
    array(
        'function'=>'addSignUp',
        'url'=>'"http://m.hb.qq.com/plug/SignUp/addSignUp"',
        'name'=>'添加报名日志',
        'method'=>'POST',
        'parameter'=>'access_token : (必须)Openid :(必须)Type: 报名类型(必须)Description: 描述（可选）',
        'return'=>'{"status":100017,"mess":"报名失败"}   status返回值，参考返回代码说明',
        'describe'=>'文件 protected\controllers\plug\SignUpController.php',
        'case'=>'',
    ),
    array(
        'function'=>'reg',
        'url'=>'"http://m.hb.qq.com/ucenter/project/reg"',
        'name'=>'项目注册',
        'method'=>'GET',
        'parameter'=>'',
        'return'=>'',
        'describe'=>'',
        'case'=>'',
    ),
    array(
        'function'=>'projectlist',
        'url'=>'"http://m.hb.qq.com/ucenter/project/projectlist"',
        'name'=>'创建的项目列表，删除和编辑',
        'method'=>'GET',
        'parameter'=>'',
        'return'=>'',
        'describe'=>'',
        'case'=>'',
    ),
    array(
        'function'=>'statistics',
        'url'=>'"http://m.hb.qq.com/api/behavior/statistics"',
        'name'=>'创建的项目列表，并可以删除和编辑',
        'method'=>'GET',
        'parameter'=>'accesstoken 用户token;openid 用户微信openid ;type 用户行为类型;remark 用户行为备注',
        'return'=>'{"state":0,"message":"\u4e0a\u62a5\u7528\u6237\u884c\u4e3a\u6210\u529f"}',
        'describe'=>'',
        'case'=>'',
    ),
);



?>


    <body style="background: #e3e3e3">
<div class="w1200 clearfix op-doc">
    <div class="fl op-doc-l">
        <div class="op-doc-lnav">
            <ul>
                <?php foreach ($left_menu as $k=>$v){?>
                <li class="selected">
                    <h3><?php echo $v['title']?><i></i></h3>
                    <p <?php if ($p==$k) { echo 'style="display: block;"';}?>>
                        <a onclick="window.location.href='<?php echo  $v['url'];?>'">
                            <i></i>
                            接口说明
                        </a>
                    </p>
                </li>
                <?php }?>
            </ul>
        </div>

    </div>

    <!--left end-->

    <div class="op-doc-r">
        <div class="op-doc-rdiv">
            <div class="op-doc-rdiv-tit">
                <h2><?php echo $right_content[$p]['name']?></h2>
                <h3><?php echo $right_content[$p]['describe']?></h3>
            </div>

            <div class="op-doc-rdiv-con">
                <table class="table table-bordered" style="text-align: center">
                    <tr>
                        <th width="100px">功能</th>
                        <th  width="100px">方法名</th>
                        <th  width="300px">url</th>
                        <th  width="150px">提交方式</th>
                        <th  width="200px">参数</th>
                        <th  width="600px">返回数据</th>
                    </tr>

                    <tr style="text-align: center">
                        <td><?php echo $right_content[$p]['name']?></td>
                        <td><?php echo $right_content[$p]['function']?></td>
                        <td><?php echo $right_content[$p]['url']?></td>
                        <td><?php echo $right_content[$p]['method']?></td>
                        <td><?php echo $right_content[$p]['parameter']?></td>
                        <td style="word-wrap:break-word;word-break:break-all;"><?php echo $right_content[$p]['return']?></td>

                    </tr>
                </table>
                <h3 class="title">示例</h3>
                <p><?php echo $right_content[$p]['case']?></p>
            </div>
        </div>
    </div>



</div>
<?php echo $this->renderpartial('/common/footer', $config); ?>