<?php echo $this->renderpartial('/common/header_new', $config); ?>
  
    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $activity_info['pid'])) ?>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jqueryform.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/laydate/laydate.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>
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
                   <li >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                        <?php }else if($config['pid']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/add',array('pid'=>$config['pid']))?>">添加大转盘</a>
                        <?php } ?>
                    </li>
                    <li  class="" >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/prize',array('id'=>$activity_info['id']))?>">卡片/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">卡片/概率</a>
                         <?php } ?>
                    </li>
                    <li class="selected">
                         <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/collectcard/example',array('id'=>$activity_info['id']))?>">活动图片上传</a>
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
                                        echo $this->_theme_url."assets/subassembly/collectcard/newassets/images/dial-bg1_weixin.jpg";
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


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_biaoyu')">
                                <input type="hidden" name="biaoyu" id="biaoyu" value="<?php echo $images->biaoyu?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_biaoyu" method="POST" enctype="multipart/form-data">
                                    <img id="img_biaoyu" src="<?php if ($images->biaoyu) {
                                        echo JkCms::show_img($images->biaoyu);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-bg1.jpg';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'biaoyu','img_biaoyu','form_biaoyu')"
                                           name="imgFile" id="input_biaoyu" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--活动banner图片</h4>
                    		    		<p>活动标语图片宽度为750px，高度在300-500px之间</p>
                    		    		</span>
                            </div>
                        </li>


                    </ul>
                </div>
                <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;background:#ff0000"  onclick="save_button(0,'保存并返回活动列表')">
                    保存返回活动列表
                </button>
            </div>

            <script>
                function upload(id) {
                    document.getElementById(id).click();
                }
            </script>


            <script>
                var url = "<?php echo $this->createUrl('/activity/collectcard/uploadimg/id/'.$activity_info['id']); ?>";
                $('.save_button').click(function () {
                    
                var share_img = $("input[name='share_img']").val();//分享图片
                var img = $("input[name='background']").val();//背景图片
                var biaoyu = $("input[name='biaoyu']").val();//活动标语图片
                var bootmbackground = $("input[name='bootmbackground']").val();//底部背景图片
                var rotaryfive = $("input[name='rotaryfive']").val();//转盘图片
                var pointer = $("input[name='pointer']").val();//转盘指针图片
                var recordbutton = $("input[name='recordbutton']").val();//中奖记录按钮
                var rules = $("input[name='rules']").val();//活动规则按钮
                var colse = $("input[name='colse']").val();//弹窗关闭按钮
                var alertyes = $("input[name='alertyes']").val();//恭喜弹窗背景图
                var alertno = $("input[name='alertno']").val();//遗憾（未能中奖或是其他）弹窗背景图
                var winninglist = $("input[name='winninglist']").val();//中奖记录弹窗背景图


                var data = {
                    biaoyu: biaoyu,
                    bootmbackground: bootmbackground,
                    rotaryfive: rotaryfive,
                    pointer: pointer,
                    recordbutton: recordbutton,
                    img: img,
                    rules: rules,
                    colse: colse,
                    alertyes: alertyes,
                    alertno: alertno,
                    winninglist: winninglist,
                    share_img: share_img,

                }



                    $.post(url, data, function (res) {
                        var res = JSON.parse(res);
                        $('.save_button').attr("disabled","true");
                        $('.save_button').text("提交中....");
                        if (res.state == 1) {
                            layer.msg(res.msg, {time: 2000}, function () {
                                    window.location.href = "<?php echo $this->createUrl('/activity/collectcard/list') . '/pid/' . $config['pid'] . '/active/1'; ?>";
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