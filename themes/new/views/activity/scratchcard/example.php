<?php echo $this->renderpartial('/common/header_new', $config); ?>
    <style>
        .ceil_thumbs li {
            float: left;
            width: 77px;
            height: 77px;
            border: 1px solid #e2e2e2;
            background-size: cover;
            margin-right: 10px;
            position: relative;
            background-image: url( <?php echo $this->_theme_url."assets/images/d-data-img2.png"?>)
        }

        .ceil_thumbs li input[type=file] {
            opacity: 0;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .ceil_thumbs li:before, .ceil_thumbs li:after {
            content: " ";
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            background-color: #D9D9D9;
        }
    </style>

    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $config['pid'])) ?>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jqueryform.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/laydate/laydate.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>

    <!--act nav-->
    <div class="ad-act-list w1000 bxbg mgt30 clearfix">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>编辑活动</h3>
            </div>
            <!--<div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>-->
        </div>
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-navsd clearfix">
                <ul>
                   <li  >
                        <a href="<?php echo $this->createUrl('/activity/scratch/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('/activity/scratch/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                    </li>
                    <li  class="selected">
                        <a href="<?php echo $this->createUrl('/activity/scratch/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                    </li>
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">

             

                 <style type="text/css">
                .dail-formdiv1 { margin: 0px 0px 50px 50px; }
.dail-formdiv1 h3 { font-size: 16px; color: #008bcc; font-weight: bold; border-left: 2px solid #008bcc; padding-left: 10px; }
.dail-formdiv1 .tips { padding: 10px 20px; background: #eaf8ff; color: #7f7f7f; border: 1px solid #55c9ff; border-radius: 5px; margin: 20px 66px 20px 0px; }
.dail-formdiv1 .tips em { display: inline-block; float: left; color: #ff4141; }
.dail-formdiv1 .tips p { display: block; margin-left: 50px; color: #999; font-size: 12px; line-height: 24px; }
.dail-upimg { }
.dail-upimg ul li { margin-bottom: 40px; }
.dail-upimgl { position: relative; width: 150px; height: 150px; background: #fff; border-radius: 5px; border: 1px solid #dedede; }
.dail-upimgl:before { content: ""; display: block; width: 80px; height: 0px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -1px; margin-left: -40px; }
.dail-upimgl:after { content: ""; display: block; width: 0px; height: 80px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -40px; margin-left: -1px; }
.dail-upimgr { margin-left: 200px; margin-right: 66px; }
.dail-upimgr img { height: 150px; float: left; }
.dail-upimgr span { display: block; float: left; margin-left: 40px; width: 300px; }
.dail-upimgr span p { display: inline-block; }
.dail-upimgr span h4 { color: #008bcc; margin-bottom: 20px; }
.s_num{        border-bottom: 1px solid #c1c1c1;
    padding-bottom: 30px;
    margin-bottom: 10px;
    width: 93%;}
.s_num .form-control{ width:97%}    
.s_num .t_title{padding: 10px 0px;}  
.s_num .delbtn{display: inline-block;
    float: right;
    width: 10%;
    height: 30px;
    line-height: 30px;
    text-align: center;
    position: relative;
    top: -5px;}  
            </style>    

                <!--right form-->


                <!--right form-->
                <style>
                    .add-tags {
                        margin-top: 5px;
                    }

                    .add-tags label {
                        display: inline-block;
                        margin-right: 15px;
                        cursor: pointer;
                        margin-bottom: 5px;
                    }

                    .add-tags label input {
                        margin: 0;
                        position: relative;
                        top: 2px;
                    }

                    .add-tags label i {
                    }
                </style>

              <!--   <div class="ad-view-app-1 ad-edit-app-condiv clearfix">

                    <div class="ad-view-app-sx"><a href=""><i><img
                                    src="<?php echo $this->_theme_url; ?>assets/images/ad-act-reflash-icon.png"/></i>刷新</a>
                    </div>

                    <div class="ad-view-app-code">
                        <?php if ($activity_info['id']) { ?>
                            <img
                                src="http://qr.topscan.com/api.php?text=<?php echo $this->_siteUrl . '/activity/scratch/view/id/' . $activity_info['id'] ?>"
                                width="150" height="150"/>
                        <?php } else { ?>
                            <img src="http://qr.topscan.com/api.php?text=http://m.dachuw.net/h5" width="150"
                                 height="150"/>
                        <?php } ?>
                        <p>扫码在移动设备上<br/>体验效果更加</p>
                    </div>


                    <div class="ad-view-app-main">


                        <img class="phonebg" src="<?php echo $this->_theme_url; ?>assets/images/ad-act-phone-bg.png"/>

                        <div class="ad-view-app-maindiv">
                            <?php if ($activity_info['id']) { ?>
                                <iframe
                                    src="<?php echo $this->createUrl('/activity/scratch/view', array('id' => $activity_info['id'])) ?>"
                                    scrolling="yes" width="" height=""></iframe>
                            <?php } else {
                                if ($status['see_status'] == 1) {
                                    echo "PC";
                                } else if ($status['see_status'] == 2) {
                                    echo "weixin";
                                } else {
                                    echo "all";
                                } ?>
                                <iframe src="http://m.dachuw.net/h5" width="" height=""></iframe>
                            <?php } ?>
                        </div>

                    </div>


                </div> -->

                <!--view end-->

                <div class="ad-example-app-1 ad-edit-app-condiv clearfix" style="display:block">


                    <div class="ad-example-app-2">
                        <ul>
                            <li><span>开发者示例：</span>
                                <em>&nbsp;</em>
                                <i></i>
                            </li>
                            <li>
<pre name="code" class="c-sharp">
include 'Dachuw.php';
$dachu=new Dachu('aapid','appsercert');
//项目的用户的唯一标识符;
$openid= '***';
//$redirect = $dachu->getMemberUrl();//获取会员中心URL
$redirect   =   'http://m.dachuw.net/activity/scratchcard/view/id/<?php echo $_GET['fid'] ?>';
//获取自动登录URL
$url        = $dachu->buildAutoLoginRequest($openid,$redirect);
//跳转
$dachu->redirect($url);
</pre>
                            </li>
                            <!--                            <li><span>URL<b style="visibility: hidden;">方式</b>：</span>
                                                            <em>http://m.hb.qq.com/activity/SignUp/index/id/$id</em>
                                                            <i></i>
                                                        </li>-->
                            <!--                            <li><span>传入参数：</span>-->
                            <!--                                <em>openid : 微信用户的openid</em>-->
                            <!--                            </li>-->
                        </ul>

                        <a href="/dachu/activity_sdk.zip" class="demo-down linear adbtn">DEMO下载</a>

                    </div>


                </div>
            </div>
        </div>
    </div>


    <script>
        function upload(id) {
            document.getElementById(id).click();
        }
    </script>

    <!-- 组件 end -->
    <script type="text/javascript">
        var start = {
            elem: '#start',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            // choose: function (datas) {
            //     end.min = datas; //开始日选好后，重置结束日的最小日期
            //     end.start = datas //将结束日的初始值设定为开始日
            //     console.log(datas);
            //     $('input[name="FStartTime"]').trigger("validate");
            // }
        };
        var end = {
            elem: '#end',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            // choose: function (datas) {
            //     var ts = new Date(document.getElementById("start").value);
            //     var ts1 = ts.getTime() + 86400000;
            //     var te = new Date(document.getElementById("end").value);
            //     var te1 = te.getTime();
            //     if (te1 < ts1) {
            //         document.getElementById("end").value = "";
            //         layer.msg("开始和结束时间必须间隔一天");
            //     }
            //     start.max = datas; //结束日选好后，重置开始日的最大日期
            //     $('input[name="FEndTime"]').trigger("validate");
            // }
        };
        laydate(start);
        laydate(end);
        $("#continue_ad_20160422").on('click', function () {
            var len = $(".s_num").length + 1;
            if (len > 5) {
                alert("大转盘奖品最多只能添加5个噢！");
                return false;
            }
            var tit = '';
            if (len == 1) {
                tit = '一等奖';
            } else if (len == 2) {
                tit = '二等奖';
            } else if (len == 3) {
                tit = '三等奖';
            } else if (len == 4) {
                tit = '四等奖';
            } else if (len == 5) {
                tit = '五等奖';
            } 
            var temp_html = '<div class="s_num"><div class="t_title">自定义名称</div>' +
                '<div class="form-inp">' +
                '<input type="text" value=' + tit + '  value="" placeholder="" disabled="true "  class="form-control" name="p_title[]" />' +

                '</div>' +
                '<div class="t_title">奖品名称</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control"  name="p_name[]" />' +

                '</div>' +
                '<div class="t_title">奖品数量</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_num[]"/>' +

                '</div>' +
                '<div class="t_title">奖品剩余数量(用户每中奖一次数量就会随之减少，请不要随意修改)</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_snum[]"/>' +

                '</div>' +
                '<div class="t_title">奖品概率<span>(请填入整数，例如5，概率是以下面的概率基数为分母，填入数值为分子，默认概率基数为100000，中奖概率为10万分之5)</span></div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_v[]"/>' +

                '</div></div>';

            var parent = $(this).parents(".upload_pic");
            $(temp_html).insertBefore(parent);
        });


        $("#continue_del_20160422").on('click', function () {
            var len=$(".s_num").length-1;
            $('.s_num').each(function(index,element){
                if(len==index){
                    $(this).remove();
                }else{

                    console.log(index)
                }
            })
        });

        var url = "<?php echo $this->createUrl('/activity/scratch/add'); ?>";

       

        $('.save_button').click(function () {

            var id = $("input[name='id']").val();
            //为真表示编辑，活动进行的时候不能编辑
            if(id){
                $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('/activity/scratch/is_status'); ?>",
                data:{
                    "id": id,
                },
                success: function(msg){
                   if(msg==2){
                       layer.msg("活动进行中，避免数据错误，暂时不能编辑");
                       return false;
                   }else if(msg==3){
                        layer.msg("非法提交");
                        return false;
                   }

                }
            });
            }


            
            $('.save_button').attr("disabled","true");
                $('.save_button').text("提交中....");


            var pid = $("input[name='pid']").val();
            if (!pid) {
                layer.msg("系统错误请刷新页面");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var title = $("input[name='title']").val();
            if (!title) {
                layer.msg("请填写活动标题");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var start_time = $("input[name='start_time']").val();
            var starttime = new Date(start_time).getTime();
            var newtime = new Date().getTime();
            // if (starttime < newtime && !id) {
            //     layer.msg("开始时间必须大于当前时间");
            //     $('.save_button').removeAttr('disabled');
            // $('.save_button').text("保存");
            // return false;
            // }
            if (!start_time) {
                layer.msg("开始时间必填");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var end_time = $("input[name='end_time']").val();
            var endtime = new Date(end_time).getTime();
            if (endtime < starttime) {
                layer.msg("结束时间必须大于开始时间");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var win_num = $("input[name='win_num']").val();//用户可中奖次数
            if (win_num <= 0) {
                layer.msg("用户可中奖次数必须大于零");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var day_count = $("input[name='day_count']").val();//每天可以抽奖的次数
            if (day_count <= 0) {
                layer.msg("每天可以抽奖的次数必须大于0");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }

            var win_msg = $("input[name='win_msg']").val();//中奖提示
            if (!win_msg) {
                layer.msg("请填写中奖提示");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var lose_msg = $("input[name='lose_msg']").val();//中奖提示
            if (!lose_msg) {
                layer.msg("请填写未中奖提示");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }

            var rule = $("#rule").val();//活动规则
            if (!rule) {
                layer.msg("请填写活动规则");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var lingjiang = $("input[name='lingjiang']").val();//领奖方式
            if (!lingjiang) {
                layer.msg("请填写领奖方式");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var jishu = $("input[name='jishu']").val();//概率基数
            if (jishu <= 0) {
                layer.msg("请填写概率基数");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var share_img = $("input[name='share_img']").val();//分享图片
            var img = $("input[name='background']").val();//背景图片
            var biaoyu = $("input[name='biaoyu']").val();//活动标语图片
            var bootmbackground = $("input[name='bootmbackground']").val();//底部背景图片
            var rotary = $("input[name='rotary']").val();//转盘图片
            var pointer = $("input[name='pointer']").val();//转盘指针图片
            var recordbutton = $("input[name='recordbutton']").val();//中奖记录按钮
            var rules = $("input[name='rules']").val();//活动规则按钮
            var colse = $("input[name='colse']").val();//弹窗关闭按钮
            var alertyes = $("input[name='alertyes']").val();//恭喜弹窗背景图
            var alertno = $("input[name='alertno']").val();//遗憾（未能中奖或是其他）弹窗背景图
            var winninglist = $("input[name='winninglist']").val();//中奖记录弹窗背景图

            var share_desc = $("input[name='share_desc']").val();//分享描述
            //var share_switch     = $("input[name='share_switch']").val();
            var obj_share_switch=document.getElementsByName('share_switch');
            var share_switch='';
            for(var i=0; i<obj_share_switch.length; i++){
                if(obj_share_switch[i].checked) share_switch+=obj_share_switch[i].value;
            }
            if(!share_switch){
                layer.msg("请选择是否分享");
                return false;
            }
            var obj_prize_number=document.getElementsByName('prize_number');
            var prize_number='';
            for(var i=0; i<obj_prize_number.length; i++){
                if(obj_prize_number[i].checked) prize_number+=obj_prize_number[i].value;
            }
            if(!share_switch){
                layer.msg("请选择是否开启数量显示");
                return false;
            }

            if (!share_desc) {
                layer.msg("请填写分享描述");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var obj_p_title = $("input[name='p_title[]']");//奖项

            var obj = document.getElementsByName('tag');
            var tag = '';
            for (var i = 0; i < obj.length; i++) {
                if (obj[i].checked) tag += obj[i].value + '_';
            }


            if (!tag) {
                layer.msg("请选择标签");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            var checkes = false;
            var p_title = new Array();
            if ($(".s_num").length < 3) {
                layer.msg("请至少添加3个奖品噢！");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            obj_p_title.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_title[index] = $(this).val();
            });
            var obj_p_name = $("input[name='p_name[]']");
            var p_name = new Array();
            obj_p_name.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_name[index] = $(this).val();
            });
            var obj_p_num = $("input[name='p_num[]']");
            var p_num = new Array();
            obj_p_num.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_num[index] = $(this).val();
            });

            /*奖品剩余数量*/
            var obj_p_snum = $("input[name='p_snum[]']");
            var num = $("input[name='p_snum[]']");
            var p_snum = new Array();
            obj_p_snum.each(function (index, item) {
                var snumber=$(num[index]).val();//剩余奖品数据
                var number=$(this).val();//奖品数据量
                if (!number || number<=snumber && snumber<0) {
                    checkes = true;
                }
                p_snum[index] = $(this).val();
            });
            var obj_p_v = $("input[name='p_v[]']");
            var p_v = new Array();
            var p_v_all = 0;
            obj_p_v.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_v_all += parseInt($(this).val());
                p_v[index] = $(this).val();
            });
            var obj_p_id = $("input[name='p_id[]']");
            var p_id = new Array();
            obj_p_id.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_id[index] = $(this).val();
            });

            if (p_v_all > jishu) {
                layer.msg("请注意,概率基数应大于或等于奖品概率总和");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }

            if (checkes) {
                layer.msg("请添加奖项信息");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }

            if (jishu)
                var data = {
                    id: id,
                    pid: pid,
                    title: title,
                    start_time: start_time,
                    end_time: end_time,
                    win_num: win_num,
                    day_count: day_count,
                    win_msg: win_msg,
                    lose_msg: lose_msg,
                    rule: rule,
                    lingjiang: lingjiang,
                    jishu: jishu,
                    share_img: share_img,
                    img: img,
                    share_desc: share_desc,
                    tag: tag,
                    p_title: p_title,
                    p_name: p_name,
                    p_num: p_num,
                    p_snum: p_snum,
                    p_v: p_v,
                    p_id: p_id,

                    biaoyu:biaoyu,
                    bootmbackground:bootmbackground,
                    rotary:rotary,
                    pointer:pointer,
                    recordbutton:recordbutton,
                    rules:rules,
                    colse:colse,
                    alertyes:alertyes,
                    alertno:alertno,
                    winninglist:winninglist,
                    share_switch:share_switch,
                    prize_number:prize_number,
                };
            $.post(url, data, function (res) {
                var res = JSON.parse(res);
                $('.save_button').attr("disabled","true");
                $('.save_button').text("提交中....");
                if (res.state == 1) {
                    layer.msg(res.msg, {time: 2000}, function () {
                        window.location.href = "<?php echo $this->createUrl('/activity/scratch/list') . '/pid/' . $config['pid'] . '/active/1'; ?>";
                    })
                } else {
                    $('.save_button').attr("disabled","false");
                    $('.save_button').text("保存");
                    layer.msg(res.msg)
                }
            })
        })

    </script>

<?php echo $this->renderpartial('/common/footer', $config); ?>