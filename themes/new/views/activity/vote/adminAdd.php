<?php echo $this->renderpartial('/common/header_new', $config); ?>
<?php //echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>

    <!-- <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/vote/css/site.css"> -->
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery-1.12.0.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script type="text/javascript"
            src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.SuperSlide.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/home.js"></script>
    <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>
    <style>
        .components .center {
            width: 100%
        }
         .ceil_thumbs li {
             float: left;
             width: 200px;
             height: 200px;
             border: 1px solid #e2e2e2;
             background-size: cover;
             margin-right: 10px;
             position: relative;
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
    <div class="components w980 clearfix">

        <script type="text/javascript"
                src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/kindeditor.js"></script>
        <script type="text/javascript"
                src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
        <script type="text/javascript">
            var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
            var admin_url = site_url;
            $(document).ready(function () {
                var editor1 = KindEditor.create('.editor', {
                    uploadJson: admin_url + '/files/upload'
                });
            });
        </script>
        <script type="text/javascript"
                src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.min.js"></script>
        <script type="text/javascript"
                src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.cn.js"></script>

        <form method="POST" id="img_scratch" name="img_form" action="<?php echo $this->createUrl('/activity/vote/adminAdd')?>" enctype="multipart/form-data" >
        <div class="ad-app-list w1000 clearfix bxbg mgt30">
            <div class="ad-app-list-tit clearfix">
                <div class="fl tl">
                    <h3>添加参赛作品</h3>
                </div>
            </div>

            <div class="ad-data-map">
                <input type="hidden" value="<?php echo $vid ?>" name="vid">
                <?php
                if (isset($activity_info['id'])) {
                    ?>
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                    <?php
                }
                ?>

                <div class="form-content" style="margin-top:20px;">
                    <div class="t_title">名称<span>（1-20个字符）</span></div>
                    <div class="input">
                        <input type="text"
                               value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>"
                               placeholder="请填写名称" class="form-control" name="title"/>
                    </div>
                    <div class="t_title">电话<span>（1-20个字符）</span></div>
                    <div class="input">
                        <input type="text"
                               value="<?php echo isset($activity_info['phone']) ? $activity_info['phone'] : ''; ?>"
                               placeholder="请填写电话号码" class="form-control" name="phone"/>
                    </div>
                    <?php foreach($formList as $form){if($form['forms']==0){?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <input type="text" value="" placeholder="请填写名称" class="form-control" name="<?php echo $form['id'] ?>"/>
                            </div>
                        <?php }elseif($form['forms']==1){?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <textarea class="form-control" placeholder="请填写<?php echo $form['title'] ?>" name="<?php echo $form['id'] ?>" id="remark" style="resize-y:none;width:90%;height:150px;border:1px solid #CDCDCD;"></textarea>
                            </div>
                        <?php } elseif($form['forms']==2){?>
                        <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                        <div class="input">
                            <?php foreach($form['question'] as $ss){?>
                                <input type="radio" name="<?php echo $form['id'] ?>" value="<?php echo $ss['id']?>" checked> <?php echo $ss['question']?>
                            <?php }?>
                        </div>
                        <?php }elseif($form['forms']==3){ ?>
                        <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                        <div class="input">
                            <?php foreach($form['question'] as $ss){?>
                                <input name="<?php echo $form['id'] ?>[]" type="checkbox" value="<?php echo $ss['id']?>_" /><?php echo $ss['question']?>
                            <?php }?>
                        </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="form-content" style="margin-top:20px;">
                        <div class="t_title">宣言<span>（200个字符）</span></div>
                        <div style="margin-top:10px;margin-bottom:20px;">
                                <textarea class="form-control" placeholder="请填写宣言" name="remark" id="remark" style="resize-y:none;width:90%;height:150px;border:1px solid #CDCDCD;"></textarea>
                        </div>
                        <!-- 上传图片1 start -->
                        <div class="form-content" style="margin-top:20px;">
                            <div class="t_title">作品</div>
                            <div class="" style="margin-top:20px;">
                                <ul class="ceil_thumbs  mt10 clearfix">
                                    <li>
                                        <img class="img"  id="imagess" src="<?php echo $this->_theme_url."assets/images/d-data-img2.png"?>" width="200" height="200" />
                                        <input type="file" onchange="uploadImages(this, 'imgss','imagess', 1)"/>
                                    </li>
                                </ul>
                                <input type="hidden" name="share_img" id="imgss" value="<?php /*echo $activity_info['img']*/?>">
                            </div>
                        </div>
                        <button style="margin-top: 40px;width: 30%;" type="submit" class="save_button adbtn linear">添加</button>
                    </div>
                </div>
            </div>

            </form>
            <!-- 组件 end -->
            <script type="text/javascript">


                function upload() {
                    document.getElementById("upimg1").click();
                }

                function checkPhone(phone){
                    if(!(/^1[34578]\d{9}$/.test(phone))){
                        alert("手机号码有误，请重填");
                        return false;
                    }
                }

                var url = "<?php echo $this->createUrl('/activity/vote/adminAdd'); ?>";
                $('.save_button').click(function () {

                    var id = $("input[name='id']").val();
                    var vid = $("input[name='vid']").val();
                    var title = $("input[name='title']").val();
                    var start_time = $("input[name='start_time']").val();
                    var remark = $("#remark").val();
                    var share_img = $("input[name='share_img']").val();
                    var phone    = $("input[name='phone']").val();

                    if (!title || !remark || !share_img ||!phone) {
                        alert("所有参数不能为空");
                        return false;
                    }
                    if(!(/^1[34578]\d{9}$/.test(phone))){
                        layer.msg("手机号码有误");
                        return false;
                    }
                    if (title.length > 20) {
                        alert("对不起您的标题超过字数限制（20）");
                        return false;
                    }
                    for(var i=0;i<document.img_form.elements.length-1;i++)
                    {
                        if(document.img_form.elements[i].value=="")
                        {
                            layer.msg("所有表单必填");
                            document.img_form.elements[i].focus();
                            return false;
                        }
                    }
                    return true;





                })


            </script>

        </div>

<?php echo $this->renderpartial('/common/footer', $config); ?>