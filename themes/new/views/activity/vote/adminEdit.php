<?php echo $this->renderpartial('/common/header_new', $config); ?>
<?php //echo $this->renderpartial('/common/header_app',array('view'=>$view,'project_list'=>$project_list,'config'=>$config)); ?>

    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery-1.12.0.min.js" type="text/javascript"
            charset="utf-8"></script>
    <script type="text/javascript"
            src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.SuperSlide.js"></script>
    <script type="text/javascript"
            src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/home.js"></script>
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
             margin-right: 100px;
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

    </style>
    <form method="POST" action="<?php echo $this->createUrl('/activity/vote/adminEdit')?>" enctype="multipart/form-data" >
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
                    uploadJson: admin_url + '/files/upload',
                });
            });
        </script>
        <script type="text/javascript"
                src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.min.js"></script>
        <script type="text/javascript"
                src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.cn.js"></script>

        <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>
       <div class="ad-app-list w1000 clearfix bxbg mgt30">
            <div class="ad-app-list-tit clearfix">
                <div class="fl tl">
                    <h3>编辑参赛作品</h3>
                </div>
            </div>
                <div class="ad-data-map">

                    <input type="hidden" value="<?php echo $vid ?>" name="vid">
                    <?php
                    if (isset($id)) {
                        ?>
                        <input type="hidden" value="<?php echo $id ?>" name="id">
                        <?php
                    }
                    ?>
                    <div class="form-content" style="margin-top:20px;">
                        <div class="t_title">名称<span>（1-20个字符）</span></div>
                        <div class="input">

                            <input type="text" class="form-control" value="<?php echo isset($edit['title']) ? $edit['title'] : ''; ?>"
                                   placeholder="请填写活动名称" class="input_text" name="title"/>
                            <div class="del"></div>
                        </div>


                        <div class="t_title">票数<span>（1-20个字符）</span></div>
                        <div class="input">

                            <input type="text" class="form-control" value="<?php echo isset($edit['vote_number']) ? $edit['vote_number'] : ''; ?>"
                                   placeholder="请填写活动名称" class="input_text" name="vote_number"/>
                            <div class="del"></div>
                        </div>

                          <div class="t_title">电话<span>（1-20个字符）</span></div>
                        <div class="input">
                            <input type="text" class="form-control" value="<?php echo isset($edit['phone']) ? $edit['phone'] : ''; ?>"
                                   placeholder="请填写电话" class="input_text" name="phone"/>
                            <div class="del"></div>
                        </div>


                        <?php foreach($formList as $form){if($form['forms']==0){?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <input type="text" value="<?php echo $form['answer']['message']  ?>" placeholder="请填写名称" class="form-control" name="<?php echo $form['id'] ?>"/>
                            </div>
                        <?php }elseif($form['forms']==1){?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <textarea class="form-control" name="<?php echo $form['id'] ?>" id="remark" style="resize-y:none;width:90%;height:150px;border:1px solid #CDCDCD;"><?php echo $form['answer']['message']  ?></textarea>
                            </div>
                       <?php } elseif($form['forms']==2){?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <?php foreach($form['question'] as $ss){?>
                                    <input type="radio" name="<?php echo $form['id'] ?>" <?php if($ss['id']==$form['answer']['message']){ ?>checked ="checked "<?php } ?> value="<?php echo $ss['id']?>"> <?php echo $ss['question']?>
                                <?php }?>
                            </div>
                        <?php }elseif($form['forms']==3){ ?>
                            <div class="t_title"><?php echo $form['title'] ?><span>（1-20个字符）</span></div>
                            <div class="input">
                                <?php foreach($form['question'] as $ss){?>
                                    <input name="<?php echo $form['id'] ?>[]"  <?php if(in_array($ss['id'],$form['checkbox'])){ ?>checked ="checked "<?php } ?> type="checkbox" value="<?php echo $ss['id']?>_" /><?php echo $ss['question']?>
                                <?php }?>
                            </div>
                        <?php } ?>
                        <?php } ?>

                        <div class="form-content" style="margin-top:20px;">
                            <div class="t_title">宣言<span>（200个字符）</span></div>
                            <div style="margin-top:10px;margin-bottom:20px;">
                                <textarea name="remark" id="remark" class="form-control" style="resize-y:none;width:90%;height:150px;border:1px solid #CDCDCD;"><?php echo $edit['remark'] ?></textarea>
                                <div class="del"></div>
                            </div>

                            <!-- 上传图片1 start -->

                            <div class="t_title">作品</div>
                            <div class="form-content" style="margin-top:20px;">
                               <!-- <img onclick="upload_pic('img_thumb1','icon1')"
                                     src="<?php /*echo JkCms::show_img($edit['img']) */?>" id="img_thumb1" width="30%"/>
                                <input type="hidden" name="share_img" id="icon1" value="<?php /*echo $edit['img'] */?>">-->


                                <ul class="ceil_thumbs  mt10 clearfix">
                                    <li>
                                        <img class="img"  id="imagess" src="<?php echo JkCms::show_img($edit['img']) ?>" width="200" height="200" />
                                        <input type="file" onchange="uploadImages(this, 'imgss','imagess', 1)"/>
                                    </li>
                                </ul>
                                <input type="hidden" name="share_img" id="imgss" value="<?php echo $edit['img']?>">
                            </div>

                            <button style=" margin-top: 40px;width: 30%;" class="save_button adbtn linear">编辑</button>
                        </div>
                    </div>
            
        </div>
           </form>
        <!-- 组件 end -->
        <script type="text/javascript">

            var url = "<?php echo $this->createUrl('/activity/vote/adminEdit'); ?>";
            $('.save_button').click(function () {
                var id = $("input[name='id']").val();
                var vid = $("input[name='vid']").val();
                var title = $("input[name='title']").val();
                var phone = $("input[name='phone']").val();
                var vote_number = $("input[name='vote_number']").val();
                var start_time = $("input[name='start_time']").val();
                var remark = $("#remark").val();
                var share_img = $("input[name='share_img']").val();
                var data = {
                    id: id,
                    vid: vid,
                    title: title,
                    remark: remark,
                    vote_number: vote_number,
                    img: share_img,
                    phone: phone
                };
                if(!(/^1[34578]\d{9}$/.test(phone))){
                        layer.msg("手机号码有误");
                        return false;
                    }
                    if(!(/^[0-9]*$/.test(vote_number))){
                        layer.msg("票数只能为数字");
                        return false;
                    }

                if (!title || !remark || !share_img || !phone || !vote_number) {
                    alert("所有参数不能为空");
                    return false;
                }

                if (title.length > 20) {
                    alert("对不起您的标题超过字数限制（20）");
                    return false;
                }



                /*$.post(url, data, function (res) {
                    var res = JSON.parse(res);
                    if (res.statue == 1) {
                        layer.msg(res.msg, {time: 2000}, function () {
                            window.location.href = "<?php echo $this->createUrl('/activity/vote/admin') . '/vid/' . $vid; ?>";
                        })
                    } else {
                        layer.msg(res.msg)
                    }
                })*/
            })

            function checkPhone(phone){
                if(!(/^1[34578]\d{9}$/.test(phone))){
                    alert("手机号码有误，请重填");
                    return false;
                }
            }

        </script>

 </div>

<?php echo $this->renderpartial('/common/footer', $config); ?>