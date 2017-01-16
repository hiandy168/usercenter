<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="description" content="乐享微信">
    <title><?php echo $info['FTitle']?></title>
    <link href="<?php echo $this->_theme_url; ?>bigwheel/assets/activity-style.css" rel="stylesheet" type="text/css">
    <script src="http://mat1.gtimg.com/hb/js/common/jquery/jquery-2.1.0.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://mat1.gtimg.com/hb/js/wxapizxb.js"></script>
    <style type="text/css">
        .winning_list .list {
            height: 180px;
            overflow-y: scroll;
        }
    </style>
    <script type="text/javascript">
        openid = "<?php echo $param['openid']?>";
        id = "<?php echo $param['id']?>";
        pid = "<?php echo $param['id']?>";
        //	backUrl = "<?php echo $param['backUrl']?>"; 
        mid = "<?php echo $param['mid'] ?>";
        table = "bigwheel";
        //table = "activity_bigwheel";
        day_count  = "<?php echo $info['day_count'] ?>";

    </script>
    <script src="<?php echo $this->_siteUrl; ?>/assets/activtiy/login.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>h5/login/css/login1.css"/>
</head>
<?php
$mid = $param['mid'];
$openid = $param['openid'];
$day_count     = $info['day_count'];
$num = Activity_bigwheel::getNum($info['id'],$mid,$openid,$day_count);
//echo $day_count;
//echo $num.$info['id'];
/* echo '<pre>';
print_r($num);exit; */
?>
<style>
    .wx_share_layer
    {
        position: fixed;
        z-index: 11;
        top: 0;
        left: 0;

        display: none;

        width: 100%;
        height: 100%;

        background: url(<?php echo $this->_theme_url; ?>bigwheel/assets/bg_11.png) no-repeat right top rgba(0, 0, 0, .8);
        background-size: 192px 183px;
    }
    .prize_layer_wrap {
        position:   fixed;
        width:      100%;
        height:     100%;
        z-index:    11;
        background: rgba(0, 0, 0, 0.8);
        left:       0;
        top:        0;
        display:    none;
    }
    .prize_layer {
        width:          247px;
        position:       absolute;
        left:           50%;
        margin-left:    -124px;
        top:            30%;
        background:     #e2e2e2;
        border-radius:  10px;
        padding-bottom: 10px;
    }
    .prize_layer .top {
        height:          40px;
        background:      url(<?php echo $this->_theme_url; ?>bigwheel/assets/bg_19.png) no-repeat center top;
        background-size: 247px 40px;
    }
    .prize_layer .content {
        padding: 10px 20px;
    }
    .prize_layer .content p {
        margin-top:  10px;
        font-size:   24px;
        text-align:  center;
        line-height: 30px;
        color:       #012d78;
    }
    .prize_layer .button {
        width:           74px;
        height:          30px;
        background:      url(<?php echo $this->_theme_url; ?>bigwheel/assets/bg_18.png) no-repeat center center;
        background-size: 74px 30px;
        margin:          10px auto;
    }
    .Detail a{text-decoration:none;}
    .zj-listdiv { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); -webkit-transform: translate(-50%, -50%); background: rgba(255, 255, 255, 0.9); padding: 20px; min-width: 260px; border-radius: 4px; z-index: 999; border: 1px solid #ECECEC; box-shadow: 0px 0px 15px 2px rgba(0, 0, 0, .15); display: block;}
    .zj-listcon { }
    .zj-listcon h3 { text-align: center; font-size: 16px; margin-bottom: 15px; }
    .zj-listtable { min-height: 100px; }
    .zj-listtable .tit{overflow: hidden;}
    .zj-listtable .tit ul li{width: 50%;float: left;text-align: center;line-height: 20px;margin-bottom: 5px;}
    .zj-listtable .none{text-align: center;margin-top: 30px;}
    .zj-listclose { text-align: center; width: 120px; margin: 0 auto; height: 34px; border-radius: 3px; line-height: 34px; background: #51D1FF; color: #fff; margin-top: 20px; }
</style>
<body class="activity-lottery-winning" >
<div class="zl" id="zl" style="display:none;"></div>
<div class="boxcontent boxyellow" id="result" style="display:none;">
    <div class="box">
        <div class="title-orange"><span>填写资料</span></div>
        <p id="zjiang" style="display:none">你中了：<span class="red" id="prizetype"></span></p>


        <p>
            <input class="pxbtn" id="save-btn" name="提 交" type="button" value="提 交">
        </p>

    </div>
</div>
</div>

<div id="bannerzxb"></div>
<div class="main">
    <div id="outercont">
        <div id="outer-cont">
            <div id="outer" style="width:268px;height:268px"><img src="<?php echo $this->_theme_url; ?>bigwheel/assets/activity-lottery-<?php echo count($prize);?>.png" width="310px"></div>
        </div>
        <div id="inner-cont" style="top:100px">
            <div id="inner" style="width:75px"><img src="<?php echo $info['FPointerImg']?$info['FPointerImg']:'http://mat1.gtimg.com/hb/00000011/activity-lottery.png';?>"></div>
        </div>
    </div>
    <input type="hidden" id="form_flag" value="<?php if($info['FFrom_p']==1 && $form_flag) {echo 1;}else{echo 0;}?>">
    <div class="content" style="width:300px; margin: 0 auto;">
        <div class="boxcontent boxyellow">
            <div class="box" id="myPrizeRecord">
                <div class="title-green"><span>中奖记录</span></div>
                <div class="Detail" id="myjiangp">
                    点击查看中奖记录
                </div>
            </div>
        </div>
        <div class="boxcontent boxyellow">
            <div class="box">
                <div class="title-green"><span>奖项设置：</span></div>
                <div class="Detail" id="jiangp">
                    <?php foreach ($prize as $k=>$v):?>
                        <p><span class="icon"></span><?php echo $v['title']?>:<?php echo $v['name']?>：<?php echo $v['count']?>名</p>
                    <?php endforeach;?>


                </div>
            </div>
        </div>
        <div class="boxcontent boxyellow">
            <div class="box">
                <div class="title-green">活动说明：</div>
                <div class="Detail" id="sming">
                    <?php echo $info['rule'];?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 中奖浮层 -->
<div class="prize_layer_wrap" id="prize_layer_wrap">
    <div class="prize_layer">
        <div class="top"></div>
        <div class="content">
            <p class="text">

            </p>
        </div>
        <div class="button" id="make_sure"></div>
        <div class="button" id="make_sure_ok" style="display:none"></div>
    </div>
</div>
<div class="wx_share_layer" id="wx_share_layer"></div>
<!-- 中奖列表浮层 -->
<div class="zj-listdiv" style="display: none;">
    <div class="zj-listcon">
        <h3>中奖列表</h3>
        <div class="zj-listtable">
            <div class="tit">
                <ul>
                    <li>中奖名称</li>
                    <li>兑换码</li>
                </ul>
            </div>

            <div class="tit">
                <ul id="sss">

                </ul>
            </div>


        </div>

    </div>
    <div class="zj-listclose">关闭</div>
</div>

<script type="text/javascript">
    <?php if(!$param['mid']){?>
            showlogin();
    <?php } ?>
    var Maxcount = "<?php echo $num?>"; //当前用户今天可刮奖的次数
    var id = "<?php echo $info['id']?>";           //刮奖活动的id

    var url_user = "/Components/f/ID/117/do/bigwheelWinner";
    var openId = '617954';
    var FID = 72;
    var flag = 1;
    var win = 0;
    var form_flag = '1';
    var userId = "148394";
    var shareUrl = "/Components/f/ID/117/do/ajaxBigwheelShare";//分享后触发的连接地址
    var getPriceUrl = "/Components/f/ID/117/do/bigwheelGetMyPrice";//获取我的奖品列表
    var getUserUrl = "/Components/f/ID/117/do/AjaxBigwheelGetUserInfo";//收集用户信息连接
    var time = '1470363197';
    var startTime = '1470208864';
    var endTime = '1472628064';


    var wxData = {
        "appId": "", // 服务号可以填写appId
        "imgUrl" : '',
        "link" :'1',
        "desc" : '1',
        "title" : '1'
    };
    var numMax = "1";
    var FEndNumMess = '1';

    var globedy = {
        bgcolor: '#000000', //背景颜色
        bgimage: '',
        // sming: "",
        //myjiangp: "", //中奖记录
        jiangnum: 3, //奖项等级
        innerimg:"http://mat1.gtimg.com/hb/00000011/activity-lottery.png",//指针图片 http://mat1.gtimg.com/hb/00000011/activity-lotterya.png
        zimg:"",//转盘图片dzp/activity-lottery-6.png
        imgUrl:'',
        wxlink:'1',
        wxdesc:'1',
        wxtitle:'1',
        resultshow:$('#form_flag').val(),//1先填写资料
        jiangp: [{
            jiangpname: "一等奖：陪聊6小时",
            jiangpcs: "1"
        },
            {
                jiangpname: "二等奖：陪聊5小时",
                jiangpcs: "3"
            },
            {
                jiangpname: "三等奖：陪聊4小时",
                jiangpcs: "5"
            },
            {
                jiangpname: "四等奖：陪聊3小时",
                jiangpcs: "7"
            },
            {
                jiangpname: "五等奖：陪聊2小时",
                jiangpcs: "9"
            },
            {
                jiangpname: "",
                jiangpcs: ""
            }]
    };
    var url = "<?php echo $this->createUrl('/activity/bigwheel/getwin')?>";
    var data ={id:id,openid:openid,mid:mid};
    var url2 = "<?php echo $this->createUrl('/activity/bigwheel/userwinprize')?>";
    var time = <?php echo $time;?>;
    var startTime = <?php echo $info['start_time']?>;
    var endTime = <?php echo $info['end_time']?>;
</script>



<script type="text/javascript" src="<?php echo $this->_theme_url; ?>bigwheel/assets/main.js"></script>




<script type="text/javascript">

    
    $(function () {
        zxb(globedy);
        myjiangp();
    });

    function myjiangp(){
        var _myjiangp = $("#myjiangp");
        _myjiangp.html('<p>无中奖记录</p>');
        $.post('',{openId:<?php echo $is_user['FID'];?>,id:FID},function(data){
            if(data.errCode==0){
                if(data.msg){
                    var _p = "";
                    for(var i in data.msg){
                        _p+= "<p>"+data.msg[i].FPrizeInfo+':'+data.msg[i].FValidateCode+"&nbsp;&nbsp;&nbsp; 1 次</p>";
                    }
                    _myjiangp.html(_p);
                }
            }else{
                alert(data.msg);
            }
        },'json');
        
    }
    
    
</script>
<script type="text/javascript" src="<?php echo $this->_theme_url; ?>bigwheel/assets/globe.js"></script>


<script>
    // 初始化WeixinApi，等待分享
    WeixinApi.ready(function(Api) {

        // 微信分享的数据


        // 分享的回调
        var wxCallbacks = {
            // 分享操作开始之前
            ready : function() {
                // 你可以在这里对分享的数据进行重组
                // alert("准备分享");
            },
            // 分享被用户自动取消
            cancel : function(resp) {
                // 你可以在你的页面上给用户一个小Tip，为什么要取消呢？
                // alert("分享被取消，msg=" + resp.err_msg);
            },
            // 分享失败了
            fail : function(resp) {
                // 分享失败了，是不是可以告诉用户：不要紧，可能是网络问题，一会儿再试试？
                // alert("分享失败，msg=" + resp.err_msg);
            },
            // 分享成功
            confirm : function(resp) {
                var shareFlag = "<?php echo $info['FShareIsAdd'];?>";
                if(shareFlag==1){
                    $.post(shareUrl,{FID:FID,openId:openId},function(){},'json');
                }
                // 分享成功了，我们是不是可以做一些分享统计呢？
                // alert("分享成功，msg=" + resp.err_msg);
            },
            // 整个分享过程结束
            all : function(resp,shareTo) {
                // 如果你做的是一个鼓励用户进行分享的产品，在这里是不是可以给用户一些反馈了？
                // alert("分享" + (shareTo ? "到" + shareTo : "") + "结束，msg=" + resp.err_msg);
            }
        };

        // 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
        Api.shareToFriend(wxData, wxCallbacks);

        // 点击分享到朋友圈，会执行下面这个代码
        Api.shareToTimeline(wxData, wxCallbacks);

        // 点击分享到腾讯微博，会执行下面这个代码
        Api.shareToWeibo(wxData, wxCallbacks);

        // iOS上，可以直接调用这个API进行分享，一句话搞定
        Api.generalShare(wxData,wxCallbacks);
    });
</script>

<script language="javascript" src="http://pingjs.qq.com/ping.js"></script><script language="javascript">if(typeof(pgvMain) == 'function'){pvCSTM = 'all';pgvMain();}</script>

</body>
</html>