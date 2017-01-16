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
                    <li  class="selected" >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                        <?php }else{ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/add',array('id'=>$activity_info['id']))?>">添加大转盘</a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void()">奖品/概率</a>
                         <?php } ?>
                    </li>
                    <li class="">
                         <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                        <?php }else{ ?>
                         <a href="javascript:void()">开发者示例</a>
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


                    <div class="dail-formdiv1 dail-formdiv2">
                        <h3>奖品设置</h3>
                        <div class="tips">
                            <em>*Tips：</em>
                            <p>
                                奖品设置是大转盘核心必填模块，我们支持三到五种奖品，其中活动创建最少添加三个活动奖品最多五个，超过或者少于均会创建失败。添加的奖品默认的第一个就是一等奖奖品，以此类推到五等奖奖品，添加的奖项里面的项目都是必填。<br/>
                                奖品概率和数量请在活动开始前预算规划好设置好请不要随意修改，若不知道如何填写，请联系开发人员。
                                </p>
                        </div>


                        <?php
                        if($prize){
                            foreach ($prize as $val){
                                ?>
                                <div class="s_num">
                                    <input type="hidden" value="<?php echo $val['id']?>" name="p_id[]">
                                    <div class="t_title">自定义名称</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['title']?>" placeholder="" class="form-control" name="p_title[]" />
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品名称</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['name']?>" placeholder="" class="form-control"  name="p_name[]" />
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品数量</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['count']?>" placeholder="" class="form-control" name="p_num[]"/>
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品剩余数量</div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['remainder']?>" placeholder="" class="form-control" name="p_snum[]"/>
                                        <div class="del"></div>
                                    </div>
                                    <div class="t_title">奖品概率<span>(填入整数)</span></div>
                                    <div class="form-inp">
                                        <input type="text" readonly="readonly" value="<?php echo $val['probability']?>" placeholder="" class="form-control" name="p_v[]"/>
                                        <div class="del"></div>
                                    </div>
                                </div>
                                <?php
                            }
                        }else{
                        ?>

                        <div class="input upload_pic clearfix" style="margin-bottom: 20px;">
                            <div class="adbtn linear"
                                 style=" width: 23%;line-height: 36px;text-align: center;margin-top: 20px;"
                                 id="continue_ad_20160422">添加奖项
                            </div>
                            <div class="adbtn linear"
                                 style=" width: 23%;line-height: 36px;text-align: center;margin-top: 20px;"
                                 id="continue_del_20160422">删除最后一个奖项
                            </div>
                        </div>
                        <?php }?>
                        
                        <div class="t_title">概率基数<span style="color: #999;font-size: 12px;margin-left: 10px;">(奖品概率5,概率基数100000,则中奖概率十万分之五)</span>
                        </div>
                        <div class="form-inp">
                                      <span>
                                     <?php if($activity_info['id'] && $activity_info['id']){ ?>
                                   <input type="number"
                                          value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : '100000'; ?>"
                                          name='jishu' placeholder="概率基数(填入整数)" class="form-control" disabled="disabled"/>
                                     <?php }else{ ?>
                                       <input type="number"
                                          value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : '100000'; ?>"
                                          name='jishu' placeholder="概率基数(填入整数)" class="form-control" />
                                     <?php } ?>
                                  </span>
                        </div>

                    </div>

                    <!--2end-->

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
                                                echo $this->_theme_url."assets/subassembly/bigwheel/newassets/images/dial-bg1_weixin.jpg";
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-bg1.jpg';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-bg2.jpg';
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
                                                     echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-bg3.jpg';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-img1.png';
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
                                        <img src="<?php echo $this->_theme_url?>assets/subassembly/bigwheel/newassets/images/dial-img1_2.png"/>
                    		    		<span>
                                        <h4>图片样例说明--转盘图片（二）四种奖项</h4>
                    		    		<p>
                                            转盘图片只用上传一种，根据的设计奖项的数量来选择上传哪一种，转盘设置有四种奖项目的转盘图片，宽度640px，高度640px，在设计转盘的时候保证转盘的扇形分区大小（八等分四种奖项的为没分45度）以及位置和现有的样例转盘保持一致，不然容易出bug。图片为png类型</p>
                    		    		</span>
                                    </div>
                                </li>


                                <li class="clearfix">

                                    <div class="dail-upimgr clearfix">
                                        <img src="<?php echo $this->_theme_url?>assets/subassembly/bigwheel/newassets/images/dial-img1_3.png"/>
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-img2.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-logbtn.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-rulebtn.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-confirmbtn.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-img3.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-img4.png';
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
                                                echo $this->_theme_url.'assets/subassembly/bigwheel/newassets/images/dial-img5.png';
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


                        <div class="t_title">微信分享描述文件<span>（1-10个字符）</span></div>

                        <div class="form-inp">
	                          <span>
                            <input type="text"
                                   value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : '大转盘，开心转转'; ?>"
                                   name='share_desc' placeholder="分享描述" class="form-control" maxlength="10"/>
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

        var url = "<?php echo $this->createUrl('/activity/bigwheel/add'); ?>";

       
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
                            url: "<?php echo $this->createUrl('/activity/bigwheel/activitystatus'); ?>",
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
                url: "<?php echo $this->createUrl('/activity/bigwheel/is_status'); ?>",
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
                        
                        if(res.aid &&  res.aid!='undefined'){
                            window.location.href = "<?php echo $this->createUrl('/activity/bigwheel/prize')?>"+'?id='+res.aid;
                        }else{
                            window.location.href = "<?php echo $this->createUrl('/activity/bigwheel/list') . '/pid/' . $config['pid'] . '/active/1'; ?>";
                        }
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