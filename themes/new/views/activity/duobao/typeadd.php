<?php echo $this->renderpartial('/common/header_new',$config); ?>
    <!--组件目录-->
    <?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $pid)) ?>
    <script src="<?php echo $this->_theme_url;?>assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url;?>assets/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>
    <script>
        var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    </script>
    <!--act nav-->
    <div class="ad-act-list w1000 bxbg mgt30 clearfix">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>新增活动</h3>
            </div>
            <!--<div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>-->
        </div>
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-nav clearfix">
                <ul>
                    <li class="selected">
                        <a href="">新增分类</a>
                    </li>
                  <!--  <li class="">
                        <a href="">实时预览</a>
                    </li>
                    <li class="">
                        <a href="">接口示例</a>
                    </li>-->
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">
                <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block">
                    <div class="ad-edit-app-1formbg fl">
                        <form id="img_form" method="POST" enctype="multipart/form-data" >
                            <img id="imgPreview" src="<?php if($activity_info['share_img']) {echo JkCms::show_img($activity_info['share_img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                            <i>上传图像
                                <input class="fileinput" type="file" onchange="uploadImg(this)"  name="imgFile" id="upimg" value="<?php echo $activity_info['share_img']?>" /></i>
                            <input type="hidden" name="share_img" id="share_img" value="<?php echo $activity_info['share_img']?>">
                            <p>该图像是用于微信分享时使用建议上传大小为300*300</p>
                        </form>
                    </div>
                    <!--left bg end-->
                    <div class="ad-edit-app-1form">
 
                        <div class="ad-act-formmain">
                            <h2 class="h2-tit">请您耐心填写完表单，活动的效果会更好！</h2>
                            <input type="hidden" value="<?php echo $pid?>" name="pid">
                            <?php
                            if(isset($activity_info['id'])){
                                ?>
                                <input type="hidden" value="<?php echo $activity_info['id']?>" name="id">
                            <?php
                            }
                            ?>
                            <div class="form-content">
                                <div class="t_title">分类名称<span>（1-20个字符）</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>" placeholder="请填写分类名称" class="form-control " name="title" /></span>
                                </div>
 
 
                                <div class="t_title">分类描述<span>（1-20个字符）</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['description']) ? $activity_info['description'] : ''; ?>" placeholder="请填写分类名称" class="form-control " name="description" /></span>
                                </div>
                                <!-- 上传图片 end -->
                                <button class="save_button adbtn linear" style="width: 30%;margin: 30px 0px;">保存</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--right form-->
 
                <div class="ad-view-app-1 ad-edit-app-condiv clearfix" >
 
                    <div class="ad-view-app-sx"><a href=""><i><img src="<?php echo $this->_theme_url;?>assets/images/ad-act-reflash-icon.png"/></i>刷新</a></div>
 
                    <div class="ad-view-app-code">
                        <img src="<?php echo $this->_theme_url;?>assets/images/ad-act-code.png" width="150" height="150"/>
                        <p>扫码在移动设备上<br />体验效果更加</p>
                    </div>
 
 
                    <div class="ad-view-app-main">
 
 
                        <img class="phonebg" src="<?php echo $this->_theme_url;?>assets/images/ad-act-phone-bg.png"/>
 
                        <div class="ad-view-app-maindiv">
                            <?php if($activity_info['id']){ ?>
                                <iframe src="<?php echo $this->createUrl('/activity/poster/view',array('id'=>$activity_info['id']))?>"  scrolling="yes" width="" height=""></iframe>
                            <?php }else{?>
                                <iframe src="http://m.dachuw.net/h5" width="" height=""></iframe>
                            <?php }?>
                        </div>
 
                    </div>
 
 
 
                </div>
 
                <!--view end-->
 
                <div class="ad-example-app-1 ad-edit-app-condiv clearfix">
 
 
                    <div class="ad-example-app-2">
                        <ul>
                            <li><span>请求方式：</span>
                                <em>get</em>
                                <i></i>
                            </li>
                            <li><span>URL<b style="visibility: hidden;">方式</b>：</span>
                                <em>http://m.hb.qq.com/activity/SignUp/index/id/$id</em>
                                <i></i>
                            </li>
                            <li><span>传入参数：</span>
                                <em>openid : 微信用户的openid</em>
                            </li>
                        </ul>
 
                        <a href="/demo/activity_demo.rar" class="demo-down linear adbtn">DEMO下载</a>
 
                    </div>
 
 
                </div>
            </div>
        </div>
    </div>
    <!-- 组件 end -->
    <script type="text/javascript">
        var url          = "<?php echo $this->createUrl('/activity/duobao/typeAdd'); ?>";
        $('.save_button').click(function(){
            var id           = $("input[name='id']").val();
            var pid          = $("input[name='pid']").val();
            var title        = $("input[name='title']").val();
            var description  = $("input[name='description']").val();
            var share_img      = $("input[name='share_img']").val();
            if(!title||!share_img){
                layer.msg("所有参数为必填");
                return false;
            }
            var data = {
                id:id,
                pid:pid,
                title:title,
                share_img:share_img,
                description:description
            };
            $.post(url,data,function(res){
                var res = JSON.parse(res);
                if(res.statue==1){
                    layer.msg(res.msg,{time:2000},function(){
                        window.location.href="<?php echo $this->createUrl('/activity/duobao/goodType').'/pid/'.$pid.'/active/7'; ?>";
                    })
                }else{
                    layer.msg(res.msg)
                }
            })
        })
 
    </script>
 
<?php echo $this->renderpartial('/common/footer', $config); ?>