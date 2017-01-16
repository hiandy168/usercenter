<?php echo $this->renderpartial('/common/header_new',$config); ?>
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/subassembly/vote/css/site.css"> -->
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.SuperSlide.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.placeholder.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/home.js"></script>
    <style>
        .components .center{width:100%}
    </style>
    <div class="components w980 clearfix">
        <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/kindeditor.js"></script>
        <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
        <script type="text/javascript">
            var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
            var admin_url = site_url;
            $(document).ready(function () {
                var editor1 = KindEditor.create('.editor', {
                    uploadJson: admin_url + '/files/upload'
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/subassembly/vote/js/jquery.validator.cn.js"></script>


        <div class="ad-app-list w1000 clearfix bxbg mgt30">
            <div class="ad-app-list-tit clearfix">
                <div class="fl tl">
                    <h3>添加幻灯片</h3>
                </div>
            </div>
            <div class="ad-data-map">
                <input type="hidden" value="<?php echo $pid?>" name="pid">
                <?php
                if(isset($edit['id'])){
                    ?>
                    <input type="hidden" value="<?php echo $id?>" name="id">
                <?php
                }
                ?>
                <div class="form-content" style="margin-top:20px;">
                    <div class="t_title">名称<span>（1-20个字符）</span></div>
                    <div class="input">
                        <input type="text" value="<?php echo isset($edit['advname']) ? $edit['advname'] : ''; ?>"
                               placeholder="请填写名称" class="form-control" name="title"/>
                    </div>
                    <div class="t_title">显示顺序<span>（数字）</span></div>
                    <div class="input">
                        <input type="text" value="<?php echo isset($edit['displayorder']) ? $edit['displayorder'] : ''; ?>"
                               placeholder="请填写显示顺序" class="form-control" name="displayorder"/>
                    </div>
                    <div class="form-content" style="margin-top:20px;">
                        <div class="t_title">链接<span></span></div>
                        <div style="margin-top:10px;margin-bottom:20px;">
                            <input type="text" value="<?php echo isset($edit['link']) ? $edit['link'] : ''; ?>"
                                   placeholder="请填写链接" class="form-control" name="link"/>
                        </div>
                        <!-- 上传图片1 start -->
                        <div class="form-content" style="margin-top:20px;">
                            <div class="t_title">图片</div>
                            <div class="">
                                <img onclick="upload_pic('img_thumb1','icon1')" src="<?php echo JkCms::show_img($edit['thumb']) ?>" id="img_thumb1" width="30%"/>
                                <input type="hidden" name="share_img" id="icon1" value="<?php echo $edit['thumb']?>">
                            </div>
                        </div>
                        <button style="    margin-top: 40px;width: 30%;" class="save_button adbtn linear">添加</button>
                    </div>
                </div>
            </div>
            <!-- 组件 end -->
            <script type="text/javascript">
                var url          = "<?php echo $this->createUrl('/activity/duobao/advEdit'); ?>";
                $('.save_button').click(function(){
                    var id          = $("input[name='id']").val();
                    var pid          = $("input[name='pid']").val();
                    var title        = $("input[name='title']").val();
                    var link   = $("input[name='link']").val();
                    var share_img    = $("input[name='share_img']").val();
                    var displayorder    = $("input[name='displayorder']").val();
                    var data = {
                        id:id,
                        pid:pid,
                        title:title,
                        link:link,
                        img:share_img,
                        displayorder:displayorder
                    };
                    if(!title||!share_img){
                        alert("所有参数不能为空");
                        return false;
                    }
                    $.post(url,data,function(res){
                        var res = JSON.parse(res);
                        if(res.statue==1){
                            layer.msg(res.msg,{time:2000},function(){
                                window.location.href="<?php echo $this->createUrl('/activity/duobao/duobao_advlist').'/pid/'.$pid ?>";
                            })
                        }else{
                            layer.msg(res.msg)
                        }
                    })
                })

            </script>

        </div>

<?php echo $this->renderpartial('/common/footer', $config); ?>