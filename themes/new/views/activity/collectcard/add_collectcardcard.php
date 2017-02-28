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
    <div class="ad-act-list  bxbg ">
    
        <!-- <div class="ad-app-list-tit">
            <div class="fl tl">
                <h3>编辑活动</h3>
            </div>
            <div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>
        </div> -->
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-navsd ">
                <ul>
                    <li  class="selected" >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                        <?php }else if($config['pid']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/add',array('pid'=>$config['pid']))?>">添加大转盘</a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">奖品/概率</a>
                         <?php } ?>
                    </li>
                    <li class="">
                         <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/uploadimg',array('id'=>$activity_info['id']))?>">活动图片上传</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">活动图片上传</a>
                         <?php } ?>
                    </li>
                    <li class="">
                        <?php if($activity_info['id']){ ?>
                            <a href="<?php echo $this->createUrl('/activity/collectcard/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                        <?php }else{ ?>
                            <a href="javascript:void(0)">开发者示例</a>
                        <?php } ?>
                    </li>
                    
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">

                <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block;">


                    <div class="form-content clearfix dail-formdiv1">
                        <h3>基本信息</h3>

                        <div class="tips" style="margin-bottom: 0;">
                            <em>*Tips：</em>
                            <p>本模块为大转盘活动基本信息，为了保证活动顺利创建，除活动规则和领奖方式选填外其余的为必填。</p>
                        </div>
                        <input type="hidden" value="<?php echo $config['pid'] ?>" name="pid">
                        <?php
                        if (isset($activity_info['id'])) {
                            ?>
                            <input type="hidden" value="<?php echo $activity_info['id'] ?>" name="id">
                            <?php
                        }
                        ?>
                        <div class="fl" style="width: 50%;">
                            <div class="t_title">活动名称<span>（1-20个字符）</span></div>

                            <div class="form-inp">
                                      <span>

                               <input type="text"
                                      value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>"
                                      placeholder="请填写活动名称" class="form-control " name="title"/></span>
                            </div>

                            <div class="t_title">活动开始时间<span>请填写活动开始时间</span></div>
                            <div class="form-inp">
                                      <span>
                                      <input type="text"
                                             value="<?php echo isset($activity_info['start_time']) ? date('Y-m-d H:i:s', $activity_info['start_time']) : ''; ?>"
                                             placeholder="请填写活动开始时间" class="form-control" name="start_time" id="start"/></span>
                            </div>
                            <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                            <div class="form-inp">
                                      <span>
                                     <input type="text"
                                            value="<?php echo isset($activity_info['end_time']) ? date('Y-m-d H:i:s', $activity_info['end_time']) : ''; ?>"
                                            placeholder="请填写活动结束时间" class="form-control" name="end_time"
                                            id="end"/></span>
                            </div>
                            <div class="t_title">用户可中奖次数<span>（请填写整数）</span></div>
                            <div class="form-inp">
                                      <span>
                                    <input type="number"
                                           value="<?php echo isset($activity_info['win_num']) ? $activity_info['win_num'] : ''; ?>"
                                           placeholder="用户可中奖次数" class="form-control" name="win_num"/>
                                    </span>
                            </div>
                        </div>


                        <div class="fl" style="width: 45%;">
                            <div class="t_title">每人每天抽奖次数</div>
                            <div class="form-inp">
                                      <span>
                                   <input type="number"
                                          value="<?php echo isset($activity_info['day_count']) ? $activity_info['day_count'] : ''; ?>"
                                          name='day_count' placeholder="每天每天可以抽奖的次数" class="form-control"/>                     </span>
                            </div>

                            <div class="t_title">活动规则</div>
                            <div class="form-inp">
                                      <span>
                                      	<textarea style="height: 95px;" name="rule" id="rule" placeholder="活动规则"
                                                  class="form-control" rows=""
                                                  cols=""><?php echo isset($activity_info['rule']) ? $activity_info['rule'] : ''; ?></textarea>

                                  </span>
                            </div>
                            <div class="t_title">领奖方式</div>
                            <div class="form-inp">
                                      <span>
                                    <input type="text"
                                           value="<?php echo isset($activity_info['lingjiang']) ? $activity_info['lingjiang'] : ''; ?>"
                                           name='lingjiang' placeholder="领奖方式" class="form-control"/>                                  </span>
                            </div>

                        </div>

                    </div>

                    <!--1 end-->


                    <!--3end-->

                    <div class="form-content  dail-formdiv1 dail-formdiv2">
                        <h3>提示信息设置</h3>
                        <div class="tips">
                            <em>*Tips：</em>
                            <p>提示信息模块是为用户自定义提示语信息，如中奖提示语或未中奖提示语，其他的一些提示语等</p>
                        </div>

                        <div class="t_title">中奖提示<span>（1-10个字符）</span></div>

                        <div class="form-inp">
	                          <span>

	                             <input type="text"
                                        value="<?php echo isset($activity_info['win_msg']) ? $activity_info['win_msg'] : '恭喜您，中奖率'; ?>"
                                        name='win_msg' placeholder="中奖提示" class="form-control" maxlength="10"/>
                        </div>

                        <div class="t_title">没中奖提示<span>（1-10个字符）</span></div>

                        <div class="form-inp">
	                          <span>
	                             <input type="text"
                                        value="<?php echo isset($activity_info['lose_msg']) ? $activity_info['lose_msg'] : '太遗憾了，没中奖'; ?>"
                                        name='lose_msg' placeholder="没中奖提示" class="form-control" maxlength="10"/>

                                </span>
                        </div>


                        <div class="t_title">微信分享描述<span>（1-10个字符）</span></div>

                        <div class="form-inp">
	                          <span>
                            <input type="text"
                                   value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : '大转盘，开心转转'; ?>"
                                   name='share_desc' placeholder="分享描述" class="form-control" maxlength="10"/>
                        </span>
                        </div>

                        <div class="t_title">微信分享地址<span>（不填为活动页面地址）</span></div>

                        <div class="form-inp">
	                          <span>
                            <input type="text"
                                   value="<?php echo isset($activity_info['share_url']) ? $activity_info['share_url'] : ''; ?>"
                                   name='share_url' placeholder="分享地址,请加上,http://" class="form-control" />
                        </span>
                        </div>


                        <div class="t_title">微信分享开启关闭<span>（用于活动是否可以分享到朋友圈等）</span></div>
                    <div class="add-tags">
                                        <label for="ss">
                                        <input type="radio" id="ss" name="share_switch" value="1" <?php echo $activity_info['share_switch']==1?'checked="checked"':""; ?>>
                                        <i>开启</i>
                                    </label>
                                                                    <label for="sss">
                                        <input type="radio" id="sss" name="share_switch" value="0" <?php echo $activity_info['share_switch']==0?'checked="checked"':""; ?>>
                                        <i>关闭</i>
                                    </label>
                     </div>

                        <div class="t_title">奖品数量开启关闭<span>（用于前台是否显示奖品数量）</span></div>
                        <div class="add-tags">
                            <label for="ss">
                                <input type="radio" id="ss" name="prize_number" value="1" <?php echo $activity_info['prize_number']==1?'checked="checked"':""; ?>>
                                <i>开启</i>
                            </label>
                            <label for="sss">
                                <input type="radio" id="sss" name="prize_number" value="0" <?php echo $activity_info['prize_number']==0?'checked="checked"':""; ?>>
                                <i>关闭</i>
                            </label>
                        </div>


                        <div class="t_title">+添加标签</div>
                        <?php if (!$tag[0]['id'] == null) { ?>
                            <div class="add-tags">
                                <?php foreach ($tag as $tags) { ?>
                                    <label for="<?php echo $tags['id'] ?>">
                                        <input type="checkbox"
                                               <?php if (in_array($tags['id'], $ptag)){ ?>checked="checked "<?php } ?>
                                               id="<?php echo $tags['id'] ?>" name="tag"
                                               value="<?php echo $tags['id'] ?>">
                                        <i><?php echo $tags['name'] ?></i>
                                    </label>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <!--4end-->
 
                   
                    <div class=" linear" style="width: 50%;margin-bottom: 10px;margin-left: 50px;color:#ff0000" disable="disable">
                        活动进行中不能编辑，请先暂停活动！
                    </div>
                     <?php if($activity_info['id'] &&  $activity_info['status']==1 ){?>
                    <button class="adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;background:#ff0000" id='p_button'  onclick="activitystatus()">
                        暂停
                    </button>
                     <button class="save_button adbtn linear"  id='save_button' style="width: 30%;margin-bottom: 40px;margin-left: 50px;display:none" onclick="save_button(1,'保存并下一步')">
                        保存并下一步
                     </button>
                     <?php }else{ ?>
                     <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;" onclick="save_button(1,'保存并下一步')">
                        保存并下一步
                     </button>
                     <?php } ?>
                     <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;background:#ff0000" onclick="save_button(0,'保存并返回活动列表')" >
                            保存并返回活动列表
                        </button>

                    
                </div>

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


        var url = "<?php echo $this->createUrl('/activity/collectcard/add'); ?>";

       
       function activitystatus(){
           //询问框
            layer.confirm('确定暂停活动么？', {
              btn: ['确定','取消'] //按钮
            }, function(){
                        var id = $("input[name='id']").val();
                        //为真表示编辑，活动进行的时候不能编辑
                        if(id){
                            $.ajax({
                            type: "POST",
                            url: "<?php echo $this->createUrl('/activity/collectcard/activitystatus'); ?>",
                            data:{ "id": id,'type':2},
                            dataType:'json',
                            success: function(res){
                                   layer.msg(res.msg);
                                   if(res.state==1){
                                       $('#save_button').show();
                                       $('#p_button').css({"disabled":"disabled","background":"#cccccc"});
                                   }
                                   return false;
                            }
                        });
                        }
            }, function(){

            });  
       }
       
 
       
    function save_button(stat,msg){
        //$('.save_button').click(function () {

            var id = $("input[name='id']").val();
            //为真表示编辑，活动进行的时候不能编辑
            if (id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createUrl('/activity/collectcard/is_status'); ?>",
                    data: {
                        "id": id,
                    },
                    success: function (msg) {
                        if (msg == 2) {
                            layer.msg("活动进行中，避免数据错误，暂时不能编辑");
                            return false;
                        } else if (msg == 3) {
                            layer.msg("非法提交");
                            return false;
                        }

                    }
                });
            }


            $('.save_button').attr("disabled", "true");
            $('.save_button').text("提交中....");


            var pid = $("input[name='pid']").val();
            if (!pid) {
                layer.msg("系统错误请刷新页面");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var title = $("input[name='title']").val();
            if (!title) {
                layer.msg("请填写活动标题");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var start_time = $("input[name='start_time']").val();
            var starttime = new Date(start_time).getTime();
            var newtime = new Date().getTime();
            // if (starttime < newtime && !id) {
            //     layer.msg("开始时间必须大于当前时间");
            //     $('.save_button').removeAttr('disabled');
            // $('.save_button').text(msg);
            // return false;
            // }
            if (!start_time) {
                layer.msg("开始时间必填");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var end_time = $("input[name='end_time']").val();
            var endtime = new Date(end_time).getTime();
            if (endtime < starttime) {
                layer.msg("结束时间必须大于开始时间");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var win_num = $("input[name='win_num']").val();//用户可中奖次数
            if (win_num <= 0) {
                layer.msg("用户可中奖次数必须大于零");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var day_count = $("input[name='day_count']").val();//每天可以抽奖的次数
            if (day_count <= 0) {
                layer.msg("每天可以抽奖的次数必须大于0");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }

            var win_msg = $("input[name='win_msg']").val();//中奖提示
            if (!win_msg) {
                layer.msg("请填写中奖提示");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var lose_msg = $("input[name='lose_msg']").val();//中奖提示
            if (!lose_msg) {
                layer.msg("请填写未中奖提示");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }

            var rule = $("#rule").val();//活动规则
            if (!rule) {
                layer.msg("请填写活动规则");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }
            var lingjiang = $("input[name='lingjiang']").val();//领奖方式
            if (!lingjiang) {
                layer.msg("请填写领奖方式");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
                return false;
            }


            var share_desc = $("input[name='share_desc']").val();//分享描述
            var share_url = $("input[name='share_url']").val();//分享地址
            //var share_switch     = $("input[name='share_switch']").val();
            var obj_share_switch = document.getElementsByName('share_switch');
            var share_switch = '';
            for (var i = 0; i < obj_share_switch.length; i++) {
                if (obj_share_switch[i].checked) share_switch += obj_share_switch[i].value;
            }
            if (!share_switch) {
                layer.msg("请选择是否分享");
                return false;
            }
            var obj_prize_number = document.getElementsByName('prize_number');
            var prize_number = '';
            for (var i = 0; i < obj_prize_number.length; i++) {
                if (obj_prize_number[i].checked) prize_number += obj_prize_number[i].value;
            }
            if (!share_switch) {
                layer.msg("请选择是否开启数量显示");
                return false;
            }

            if (!share_desc) {
                layer.msg("请填写分享描述");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text(msg);
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
                $('.save_button').text(msg);
                return false;
            }


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
                share_desc: share_desc,
                share_url: share_url,
                tag: tag,
                share_switch: share_switch,
                prize_number: prize_number,
            };
            $.post(url, data, function (res) {
                var res = JSON.parse(res);
                $('.save_button').attr("disabled", "true");
                $('.save_button').text("提交中....");
                if (res.state == 1) {
                    layer.msg(res.msg, {time: 2000}, function () {

                        if (stat) {
                            window.location.href = "<?php echo $this->createUrl('/activity/collectcard/prize')?>" + '?id=' + res.aid;
                        } else {
                            window.location.href = "<?php echo $this->createUrl('/activity/collectcard/list') . '/pid/' . $config['pid'] . '/active/1'; ?>";
                        }
                    });


                } else {
                    $('.save_button').attr("disabled", "false");
                    $('.save_button').text(msg);
                    layer.msg(res.msg)
                }
            })
       //     })
       }
    </script>

<?php echo $this->renderpartial('/common/footer', $config); ?>