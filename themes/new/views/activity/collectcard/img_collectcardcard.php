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
                        <a href="<?php echo $this->createUrl('/activity/collectcard/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">奖品/概率</a>
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
                                        <h4>图片样例说明--活动标语图片</h4>
                    		    		<p>活动标语图片宽度为750px，高度在300-500px之间</p>
                    		    		</span>
                            </div>
                        </li>

                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_background')">
                                <input type="hidden" name="background" id="background" value="<?php echo $images->background ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_background" method="POST" enctype="multipart/form-data">
                                    <img id="img_background" src="<?php if ($images->background) {
                                        echo JkCms::show_img($images->background);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-bg2.jpg';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'background','img_background','form_background')"
                                           name="imgFile" id="input_background" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--转盘背景图片</h4>
                    		    		<p>转盘背景图片宽度为750px，高度为大转盘的高度为640px，大转盘背景图图片最好和上面的标语图片和于拼接正常以确保页面美观</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_bootmbackground')">
                                <input type="hidden" name="bootmbackground" id="bootmbackground" value="<?php echo $images->bootmbackground ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_bootmbackground" method="POST" enctype="multipart/form-data">
                                    <img id="img_bootmbackground"
                                         src="<?php if ($images->bootmbackground) {
                                             echo JkCms::show_img($images->bootmbackground);
                                         } else {
                                             echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-bg3.jpg';
                                         } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'bootmbackground','img_bootmbackground','form_bootmbackground')"
                                           name="imgFile" id="input_bootmbackground" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--底部背景图片</h4>
                    		    		<p>
                                            高度不限定，宽度750px，请在改图片显示奖项说明的上面预留出120px高度，放置中奖记录按钮，为了更好适配不同手机屏幕，整个大转盘的背景图片其实是将整个页面长度的背景图片分为三部分。</p>
                    		    		</span>
                            </div>
                        </li>

                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_rotaryfive')">
                                <input type="hidden" name="rotaryfive" id="rotaryfive" value="<?php echo $images->rotaryfive ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_rotaryfive" method="POST" enctype="multipart/form-data">
                                    <img id="img_rotaryfive" src="<?php if ($images->rotaryfive) {
                                        echo JkCms::show_img($images->rotaryfive);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-img1.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'rotaryfive','img_rotaryfive','form_rotaryfive')"
                                           name="imgFile" id="input_rotaryfive" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--转盘图片（一）五种奖项</h4>
                    		    		<p>
                                            转盘图片只用上传一种，根据的设计奖项的数量来选择上传哪一种，转盘设置有五种中奖项目的转盘图片，宽度640px，高度640px，在设计转盘的时候保证转盘的扇形分区大小（十等分五种奖项的为每分36度，八等分四种奖项的为每分45度，六等分三种奖项的为每分60度）以及位置和现有的样例转盘保持一致，不然容易出bug。图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <!--  <li class="clearfix">

                                    <div class="dail-upimgr clearfix">
                                        <img src="<?php echo $this->_theme_url?>assets/subassembly/collectcard/newassets/images/dial-img1_2.png"/>
                    		    		<span>
                                        <h4>图片样例说明--转盘图片（二）四种奖项</h4>
                    		    		<p>
                                            转盘图片只用上传一种，根据的设计奖项的数量来选择上传哪一种，转盘设置有四种奖项目的转盘图片，宽度640px，高度640px，在设计转盘的时候保证转盘的扇形分区大小（八等分四种奖项的为没分45度）以及位置和现有的样例转盘保持一致，不然容易出bug。图片为png类型</p>
                    		    		</span>
                                    </div>
                                </li>


                                <li class="clearfix">

                                    <div class="dail-upimgr clearfix">
                                        <img src="<?php echo $this->_theme_url?>assets/subassembly/collectcard/newassets/images/dial-img1_3.png"/>
                    		    		<span>
                                        <h4>图片样例说明--转盘图片（三）三种种奖项</h4>
                    		    		<p>转盘图片只用上传一种，根据的设计奖项的数量来选择上传哪一种，转盘设置有三种奖项目的转盘图片，宽度640px&nbsp;&nbsp;高度640px，在设计转盘的时候保证转盘的扇形分区大小（六等分三种奖项的为没分60度）以及位置和现有的样例转盘保持一致，不然容易出bug。图片为png类型</p>
                    		    		</span>
                                    </div>
                                </li>
 -->

                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_pointer')">
                                <input type="hidden" name="pointer" id="pointer" value="<?php echo $images->pointer ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_pointer" method="POST" enctype="multipart/form-data">
                                    <img id="img_pointer" src="<?php if ($images->pointer) {
                                        echo JkCms::show_img($images->pointer);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-img2.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'pointer','img_pointer','form_pointer')"
                                           name="imgFile" id="input_pointer" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--转盘指针图片</h4>
                    		    		<p>大小为&nbsp;&nbsp;宽度465px&nbsp;&nbsp;高度 195px&nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_recordbutton')">
                                <input type="hidden" name="recordbutton" id="recordbutton" value="<?php echo $images->recordbutton ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_recordbutton" method="POST" enctype="multipart/form-data">
                                    <img id="img_recordbutton" style=" height: auto;width: 300px;" src="<?php if ($images->recordbutton) {
                                        echo JkCms::show_img($images->recordbutton);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-logbtn.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'recordbutton','img_recordbutton','form_recordbutton')"
                                           name="imgFile" id="input_recordbutton" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--中奖记录按钮</h4>
                    		    		<p>中奖记录按钮&nbsp;&nbsp;宽度650px &nbsp;&nbsp;高度100px &nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_rules')">
                                <input type="hidden" name="rules" id="rules" value="<?php echo $images->rules ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_rules" method="POST" enctype="multipart/form-data">
                                    <img id="img_rules" style=" height: auto;width: 300px;" src="<?php if ($images->rules) {
                                        echo JkCms::show_img($images->rules);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-rulebtn.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'rules','img_rules','form_rules')"
                                           name="imgFile" id="input_rules" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--活动规则按钮</h4>
                    		    		<p>活动规则按钮&nbsp;&nbsp;宽度650px &nbsp;&nbsp;高度100px &nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_colse')">
                                <input type="hidden" name="colse" id="colse" value="<?php echo $images->colse ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_colse" method="POST" enctype="multipart/form-data">
                                    <img id="img_colse" style=" height: auto;width: 300px;" src="<?php if ($images->colse) {
                                        echo JkCms::show_img($images->colse);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-confirmbtn.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'colse','img_colse','form_colse')"
                                           name="imgFile" id="input_colse" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--弹窗关闭按钮</h4>
                    		    		<p>弹窗关闭按钮&nbsp;&nbsp;宽度375px &nbsp;&nbsp;高度100px &nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>

                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_alertyes')">
                                <input type="hidden" name="alertyes" id="alertyes" value="<?php echo $images->alertyes ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_alertyes" method="POST" enctype="multipart/form-data">
                                    <img id="img_alertyes" src="<?php if ($images->alertyes) {
                                        echo JkCms::show_img($images->alertyes);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-img3.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'alertyes','img_alertyes','form_alertyes')"
                                           name="imgFile" id="input_alertyes" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--恭喜弹窗背景图</h4>
                    		    		<p>恭喜弹窗背景图&nbsp;&nbsp;宽度620px &nbsp;&nbsp;最小高度450px &nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_alertno')">
                                <input type="hidden" name="alertno" id="alertno" value="<?php echo $images->alertno ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_alertno" method="POST" enctype="multipart/form-data">
                                    <img id="img_alertno" src="<?php if ($images->alertno) {
                                        echo JkCms::show_img($images->alertno);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-img4.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'alertno','img_alertno','form_alertno')"
                                           name="imgFile" id="input_alertno" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--遗憾（未能中奖或是其他）弹窗背景图</h4>
                    		    		<p>遗憾（未能中奖或是其他）弹窗背景图&nbsp;&nbsp;宽度620px &nbsp;&nbsp;最小高度450px &nbsp;&nbsp;图片为png类型</p>
                    		    		</span>
                            </div>
                        </li>


                        <li class="clearfix">

                            <div class="dail-upimgl fl" onclick="upload('input_winninglist')">
                                <input type="hidden" name="winninglist" id="winninglist" value="<?php echo $images->winninglist ?>"/>
                            </div>
                            <div class="dail-upimgr clearfix">
                                <form id="form_winninglist" method="POST" enctype="multipart/form-data">
                                    <img id="img_winninglist" src="<?php if ($images->winninglist) {
                                        echo JkCms::show_img($images->winninglist);
                                    } else {
                                        echo $this->_theme_url.'assets/subassembly/collectcard/newassets/images/dial-img5.png';
                                    } ?> "/>
                                    <input class="fileinput" style="display: none" type="file"
                                           onchange="uploadImg(this,'winninglist','img_winninglist','form_winninglist')"
                                           name="imgFile" id="input_winninglist" value=""/>
                                </form>
                    		    		<span>
                                        <h4>图片样例说明--中奖记录弹窗背景图</h4>
                    		    		<p>中奖记录弹窗背景图&nbsp;&nbsp;宽度620px &nbsp;&nbsp;高度770px &nbsp;&nbsp;图片为png类型</p>
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