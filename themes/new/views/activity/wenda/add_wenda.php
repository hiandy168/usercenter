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
                            <a href="<?php echo $this->createUrl('/activity/wenda/add',array('id'=>$activity_info['id']))?>">编辑问答</a>
                        <?php }else if($config['pid']){ ?>
                            <a href="<?php echo $this->createUrl('/activity/wenda/add',array('pid'=>$config['pid']))?>">添加问答</a>
                        <?php } ?>
                    </li>
                    <li class="">
                        <?php if($activity_info['id']){ ?>
                            <a href="<?php echo $this->createUrl('/activity/wenda/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
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
                            <p>本模块为问答活动基本信息，为了保证活动顺利创建，除活动规则和领奖方式选填外其余的为必填。</p>
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
                            <div class="t_title">获奖资格--用户答对多少题即可有抽奖机会<span>（请填写整数）</span></div>
                            <div class="form-inp">
                                      <span>
                                    <input type="number"
                                           value="<?php echo isset($activity_info['wenda_prize_num']) ? $activity_info['wenda_prize_num'] : ''; ?>"
                                           placeholder="用户可中奖次数" class="form-control" name="wenda_prize_num"/>
                                    </span>
                            </div>
                        </div>


                        <div class="fl" style="width: 45%;">
                            <div class="t_title">每人每天可玩次数</div>
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
                            <div class="t_title">是否参与抽奖<span></span></div>
                            <div class="form-inp">
                                <select name="is_prize" id="is_prize" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                    <option value="1" <?php if($activity_info['is_prize']==1){ ?>selected ="selected "<?php } ?>>是</option>
                                    <option value="0" <?php if($activity_info['is_prize']==0){ ?>selected ="selected "<?php } ?>>否</option>
                                </select>
                            </div>

                        </div>
                        <div class="fl" style="width: 45%; <?php if($activity_info['is_prize']==0){ echo "display:none";}?>" id="prize">
                            <div class="t_title">抽奖组件<span></span></div>
                            <div class="form-inp">
                                <select name="activity_type" id="activity_type" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                    <option value="1" <?php if($activity_info['activity_type']==1){ ?>selected ="selected "<?php } ?>>刮刮卡</option>
                                    <option value="2" <?php if($activity_info['activity_type']==2){ ?>selected ="selected "<?php } ?>>大转盘</option>
                                </select>
                            </div>

                            <div class="t_title">抽奖活动列表<span></span></div>
                            <div class="form-inp">
                                <select name="activitylist" id="activitylist" style="display: block;width: 94%;height: 36px;border: 1px solid #ccc;color: #444;border-radius: 4px;cursor: pointer;outline: none;"  class="display_type">
                                    <?php if ($activity_info['activity_type'] == 2) {
                                        $activitylist = Activity_bigwheel::model()->findAll("pid=:pid", array(':pid' => $config['pid']));
                                        if ($activitylist) {
                                            foreach ($activitylist as $key => $val) {
                                                ?>
                                                <option value="<?php echo $val->id ?>"
                                                        <?php if ($activity_info['activity_id'] == $val->id){ ?>selected="selected "<?php } ?> ><?php echo $val->title ?></option>
                                                <?
                                            }
                                        } else {
                                            ?>
                                            <option value="0">该组件下没有活动</option>
                                        <?php }
                                    } else { ?>
                                        <?php $activityscratch = Activity_scratch::model()->findAll("pid=:pid", array(':pid' => $config['pid']));
                                        if ($activityscratch) {
                                            foreach ($activityscratch as $key => $val) {
                                                ?>
                                                <option value="<?php echo $val->id ?>"
                                                        <?php if ($activity_info['activity_id'] == $val->id){ ?>selected="selected "<?php } ?> ><?php echo $val->title ?></option>
                                            <?php }
                                        } else {
                                            ?>
                                            <option value="0">该组件下没有活动</option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>


                    <!--问答活动题目设置-->
                    <div class="dail-formdiv1 dail-formdiv2">
                        <h3>题目设置</h3>
                        <div class="tips">
                            <em>*Tips：</em>
                            <p>
                                添加此次活动的题库，最少配置1道题，最多可以配置20道题。
                            </p>
                        </div>
                        <style>
                            #timu_table{ width: 100%}
                            #timu_table tr{}
                            #timu_table tr.t1{}
                            #timu_table tr td{}


                        </style>


                        <div style="    padding: 10px 20px;
    background: #eaf8ff;
    color: #7f7f7f;
    border: 1px solid #55c9ff;
    border-radius: 5px;
    margin: 20px 66px 20px 0px;
    background-color: white;">

                            <table  border="0" cellspacing="0" cellpadding="0" id="timu_table">
                                <tr>
                                    <td >排序</td>
                                    <td >题目</td>
<!--                                    <td >类型</td>-->
                                    <td colspan="2" style="text-align:center">操作</td>
                                </tr>
                                <tr id="nothing" <?php if($question_all){echo 'hidden="hidden"';}?> >
                                    <td colspan="4" style="text-align: center;padding-left: 0px">还没有配置题目</td>
                                </tr>
                                <?php if($question_all){
                                    foreach ($question_all as $val){
                                        ?>
                                        <input type="hidden" value="<?php echo $val['id']?>" data-inphide-value="<?php echo $val['id']?>" name="qanda_id[]">
                                    <?php  }} ?>
                                <?php if($question_all){
                                    foreach ($question_all as $val){
                                        ?>
                                        <tr class="lee">
                                            <td><?php echo isset($val['sort'])?$val['sort']:""; ?></td>
                                            <td><?php echo isset($val['question'])?$val['question']:""; ?></td>
                                            <td style="text-align:center"><span data-span="span"   data-data='<?php echo isset($val['body'])?$val['body']:"";?>' onclick=edit_question(this)>编辑</span></td>
                                            <td style="text-align:center"><span data-data='<?php echo isset($val['body'])?$val['body']:"";?>' onclick=del_question(this,"<?php echo $val['id']?>")>删除</span></td>
                                        </tr>
                                    <?php  }} ?>

                            </table>


                            <div class="input upload_pic clearfix" style="    padding: 10px;
    background: #fff;
    border-radius: 5px;
    text-align: center;">
                                <div style="    width: 20%;
    line-height: 36px;
    display: inline-block;" class="adbtn linear" id="continue_adtimu_20160422">添加题目
                                </div>
                            </div>


                        </div>




                    </div>
                    <!--问答活动题目设置-->

                    

                    <div class="dail-formdiv1 dail-formdiv2">
                        <h3>主题图片上传</h3>
                        <div class="tips">
                            <em>*Tips：</em>
                            <p>
                                图片上传模块是为了满足客户个性化的主题需求，请按照我们的上传规定上传图片以达到最好的适配和浏览效果，上传图片前请仔细阅读图片样例说明，如果不会使用专业的图片处理软件请直接使用QQ截图，以确保达到规定的尺寸。此模块不是必填模块，如果不上传将默认使用系统自带的默认主题图片。</p>
                        </div>

                        <div class="dail-upimg">
                            <ul>

                                <li class="clearfix">

                                    <div class="dail-upimgl fl" onclick="upload('input_shareimg')">
                                        <input type="hidden" name="share_img" id="share_img" value="<?php echo $activity_info['share_img']?>"/>
                                    </div>
                                    <div class="dail-upimgr clearfix">
                                        <form id="form_shareimg" method="POST" enctype="multipart/form-data">
                                            <img id="img_shareimg" src="<?php if ($activity_info['share_img']) {
                                                echo JkCms::show_img($activity_info['share_img']);
                                            } else {
                                                echo $this->_theme_url."assets/subassembly/wenda/images/dati-img1.jpg";
                                            } ?> "/>
                                            <input class="fileinput" style="display: none" type="file"
                                                   onchange="uploadImages(this,'share_img','img_shareimg')"
                                                   name="imgFile" id="input_shareimg" value=""/>
                                        </form>
                    		    		<span>
                                        <h4>图片样例说明--微信分享使用图片</h4>
                    		    		<p>微信分享使用图片是用于微信活动分享时左边显示的小图片&nbsp;&nbsp;宽度为300px，高度为300px</p>
                    		    		</span>
                                    </div>
                                </li>




                            </ul>
                        </div>

                    </div>

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
                                   value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : '问答，真相只有一个！'; ?>"
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
                        <button class="save_button adbtn linear"  id='save_button' style="width: 30%;margin-bottom: 40px;margin-left: 50px;display:none">
                            保存
                        </button>
                    <?php }else{ ?>
                        <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;">
                            保存
                        </button>
                    <?php } ?>

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

        <!---->
        $("#is_prize").change(function(){
            var val=$(this).val();
            if(val==0){
                $("#prize").hide();
            }else{
                $("#prize").show();
            }
        });
        $("#activity_type").change(function(){
            var activity_type=$(this).val();
            var html = "";
            if(activity_type==2){
                <?php $activitylist=Activity_bigwheel::model()->findAll("pid=:pid",array(':pid'=>$config['pid'])); ?>
                <?php if($activitylist){ foreach($activitylist as $k=>$v){ ?>
                html+= '<option value="<?php echo $v->id ?>"><?php echo $v->title ?></option>';
                <?php }}else{?>
                html+= '<option value="0">该组件下没有活动</option>';
                <?php }?>
                $("#activitylist").html(html);
            }else{
                <?php $activityscratch = Activity_scratch::model()->findAll("pid=:pid",array(':pid'=>$config['pid'])) ?>
                <?php if($activityscratch){ foreach($activityscratch as $k=>$v){ ?>
                html+= '<option value="<?php echo $v->id ?>"><?php echo $v->title ?></option>';
                <?php }}else{?>
                html+= '<option value="0">该组件下没有活动</option>';
                <?php }?>
                $("#activitylist").html(html);

            }
        });
        <!---->

        $("#continue_adtimu_20160422").on('click', function () {
            var len = $(".lee").length + 1;
            if (len > 20) {
                alert("问答题目最多只能添加20个噢！");
                return false;
            }

            edit_question();

//            var parent = $(this).parents(".upload_pic");
//            $(temp_html).insertBefore(parent);
        });

        function sub_form(type="",num=""){
            var len = $(".lee").length + 1;
            var timu = new Object();
                timu.question = $("input[name='question']").val(), //题目文案
                timu.option1 = $("input[name='option1']").val(), //选项1
                timu.option2 = $("input[name='option2']").val(), //选项2
                timu.option3 = $("input[name='option3']").val(), //选项3
                timu.option4 = $("input[name='option4']").val(), //选项4
                timu.answer = $("input[name='rightAnswer']:checked").val(); //正确答案选项值
                timu.id = $("input[name='question_id']").val(); //主键id
            $("#nothing").attr("hidden", "");
            layer.closeAll();
            if (type == "add") {
                timu.no = len;
                var data = JSON.stringify(timu);
                var html = '<tr class="lee"><td>' + len + '</td><td>' + timu.question + '</td><td style="text-align:center"><span data-span="span"   data-data='+data+' onclick=edit_question(this)>编辑</span></td><td style="text-align:center"><span  data-data='+data+' onclick=del_question(this)>删除</span></td></tr>';
                $("#timu_table").append(html);
            }else{
                timu.no = num;
                var data = JSON.stringify(timu);
                var num_id = num+1;
                var edit_html='<td>' + num + '</td><td>' + timu.question + '</td><td style="text-align:center"><span data-span="span"   data-data='+data+' onclick=edit_question(this)>编辑</span></td><td style="text-align:center"><span   data-data='+data+' onclick=del_question(this,"'+timu.id+'")>删除</span></td>';
                $("tr:eq("+num_id+")").html(edit_html);
            }


        }

        function del_question(obj,hideid){
//            var obj_timu = $(obj).attr("data-data");
//            var timu = JSON.parse(obj_timu);

//             if( $(obj).parent().parent().prev().has("input[type=hidden]")){
//                 $(obj).parent().parent().prev().remove();
//             }
             $(obj).parent().parent().remove();
             if($('[data-inphide-value="'+hideid+'"]').length){
                $('[data-inphide-value="'+hideid+'"]').remove();
             }
              var len=$("[data-span='span']").length;
              var arr1=[];
              for(var i=0;i<len;i++){
                  arr1[i]=JSON.parse($("[data-span='span']").eq(i).attr("data-data"));
              }

            var html="";
            for (var i=0; i<arr1.length;i++){
                arr1[i].no = i+1;
                console.log(arr1[i]);
                console.log(JSON.stringify(arr1[i]));
                var jsonarr =JSON.stringify(arr1[i]);
                html += '<tr class="lee">';
                html += '<td>'+(i+1)+'</td>';
                html += '<td>'+arr1[i].question+'</td>';
                html += '<td style="text-align:center"><span data-span="span" data-data='+jsonarr+' onclick="edit_question(this)">编辑</span></td>';
                html+='<td style="text-align:center"><span data-data='+jsonarr+' onclick="del_question(this,\''+arr1[i].id+'\')">删除</span></td>';
                html+='</tr>';
//              console.log(html);

            }
            $(".lee").remove();
            $("#nothing").after(html);







        }


        function edit_question(obj){
            var timu = $(obj).attr("data-data");
            if( typeof(timu)=="string" ){
                var timu = JSON.parse(timu);
                var temp_html = '<div class="wenda_num"><div>题目文案<input type="hidden" name="question_id" value="'+timu.id+'">' +
                    '<input type="text"  name="question"  value="'+timu.question+'" placeholder="题目的文案，不超过20个字符"  class="form-control"  />' +
                    '</div>' +'<div><p>设置选项后，勾选唯一正确答案！</p> </div>'+
                    '<div>选项A<input type="radio" name="rightAnswer" value="1"  checked="checked"  />' +
                    '<input type="text" name="option1" value="'+timu.option1+'" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项B<input type="radio" name="rightAnswer" value="2" />' +
                    '<input type="text" name="option2" value="'+timu.option2+'" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项C<input type="radio" name="rightAnswer" value="3" />' +
                    '<input type="text" name="option3" value="'+timu.option3+'" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项D<input type="radio" name="rightAnswer" value="4" />' +
                    '<input type="text" name="option4" value="'+timu.option4+'" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div></div><input type="button" onclick=sub_form("edit",'+timu.no+') value="修改">';
            }else {
                var temp_html = '<div class="wenda_num"><div>题目文案<input type="hidden" name="question_id" value="0">' +
                    '<input type="text"  name="question"  value="" placeholder="题目的文案，不超过20个字符"  class="form-control"  />' +
                    '</div>' + '<div><p>设置选项后，勾选唯一正确答案！</p> </div>' +
                    '<div>选项A<input type="radio" name="rightAnswer" value="1" checked="checked"  />' +
                    '<input type="text" name="option1" value="" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项B<input type="radio" name="rightAnswer" value="2" />' +
                    '<input type="text" name="option2" value="" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项C<input type="radio" name="rightAnswer" value="3" />' +
                    '<input type="text" name="option3" value="" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div>' +
                    '<div>选项D<input type="radio" name="rightAnswer" value="4" />' +
                    '<input type="text" name="option4" value="" placeholder="选项答案，不超过20个字符" class="form-control" />' +
                    '</div></div><input type="button" onclick=sub_form("add") value="确认">';
            }


            layer.open({
                title: "题目设置",
                type: 1,
                skin: 'layui-layer-rim', //加上边框
                area: ['800px', '600px'], //宽高
                content: temp_html
            });
            if( typeof(timu)=="object" ) {
                var checked_id = timu.answer-1;
                $("input[name='rightAnswer']:eq(" + checked_id + ")").attr("checked","checked");
            }

        }



       

        var url = "<?php echo $this->createUrl('/activity/wenda/add'); ?>";


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
                        url: "<?php echo $this->createUrl('/activity/wenda/activitystatus'); ?>",
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




        $('.save_button').click(function () {
            var id = $("input[name='id']").val();
            //为真表示编辑，活动进行的时候不能编辑
            if(id){
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->createUrl('/activity/wenda/is_status'); ?>",
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
            var wenda_prize_num = $("input[name='wenda_prize_num']").val();//用户抽奖资格数
            if (wenda_prize_num <= 0) {
                layer.msg("用户抽奖资格数必须大于零");
                $('.save_button').removeAttr('disabled');
                $('.save_button').text("保存");
                return false;
            }
            var day_count = $("input[name='day_count']").val();//每天可以玩的次数
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


            var share_img = $("input[name='share_img']").val();//分享图片
//            var img = $("input[name='background']").val();//背景图片
//            var biaoyu = $("input[name='biaoyu']").val();//活动标语图片
//            var bootmbackground = $("input[name='bootmbackground']").val();//底部背景图片
//            var rotaryfive = $("input[name='rotaryfive']").val();//转盘图片
//            var pointer = $("input[name='pointer']").val();//转盘指针图片
//            var recordbutton = $("input[name='recordbutton']").val();//中奖记录按钮
//            var rules = $("input[name='rules']").val();//活动规则按钮
//            var colse = $("input[name='colse']").val();//弹窗关闭按钮
//            var alertyes = $("input[name='alertyes']").val();//恭喜弹窗背景图
//            var alertno = $("input[name='alertno']").val();//遗憾（未能中奖或是其他）弹窗背景图
//            var winninglist = $("input[name='winninglist']").val();//中奖记录弹窗背景图

            var share_desc = $("input[name='share_desc']").val();//分享描述
            var share_url = $("input[name='share_url']").val();//分享地址
            //var share_switch     = $("input[name='share_switch']").val();
            var obj_share_switch=document.getElementsByName('share_switch');
            var is_prize     = $("select[name='is_prize']").find('option:selected').val();
            var activity_type     =$("select[name='activity_type']").find('option:selected').val();
            var activity_id  = $("select[name='activitylist']").find('option:selected').val();

            var share_switch='';
            for(var i=0; i<obj_share_switch.length; i++){
                if(obj_share_switch[i].checked) share_switch+=obj_share_switch[i].value;
            }
            if(!share_switch){
                layer.msg("请选择是否分享");
                return false;
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

            <!-- 题目设置取值-->
            var len=$("[data-span='span']").length;
            var obj_question = $("[data-span='span']").attr("data-data");
            var question_arr=[];
            for(var i=0;i<len;i++){
                question_arr[i]=$("[data-span='span']").eq(i).attr("data-data");
            }
            var obj_qanda_id = $("input[name='qanda_id[]']");
            var qanda_id = new Array();
            obj_qanda_id.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                qanda_id[index] = $(this).val();
            });
            console.log(question_arr);
            console.log(qanda_id);
            <!-- 题目设置取值-->

            var data = {
                id: id,
                pid: pid,
                title: title,
                start_time: start_time,
                end_time: end_time,
                wenda_prize_num: wenda_prize_num,
                day_count: day_count,
                win_msg: win_msg,
                lose_msg: lose_msg,
                rule: rule,
                share_img: share_img,
//                img: img,
                share_desc: share_desc,
                share_url: share_url,
                tag: tag,

//                biaoyu:biaoyu,
//                bootmbackground:bootmbackground,
//                rotaryfive:rotaryfive,
//                pointer:pointer,
//                recordbutton:recordbutton,
//                rules:rules,
//                colse:colse,
//                alertyes:alertyes,
//                alertno:alertno,
//                winninglist:winninglist,
                share_switch:share_switch,
                question_arr:question_arr,
                qanda_id:qanda_id,
                is_prize:is_prize,
                activity_type:activity_type,
                activity_id:activity_id
            };
            $.post(url, data, function (res) {
                var res = JSON.parse(res);
                $('.save_button').attr("disabled","true");
                $('.save_button').text("提交中....");
                if (res.state == 1) {
                    layer.msg(res.msg, {time: 2000}, function () {
                        window.location.href = "<?php echo $this->createUrl('/activity/wenda/list') . '/pid/' . $config['pid'] . '/active/1'; ?>";

                    });



                } else {
                    $('.save_button').attr("disabled","false");
                    $('.save_button').text("保存");
                    layer.msg(res.msg)
                }
            })
        })

    </script>

<?php echo $this->renderpartial('/common/footer', $config); ?>