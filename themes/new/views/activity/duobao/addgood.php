<?php echo $this->renderpartial('/common/header_new',$config); ?>
    <script src="jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/diyUpload/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/diyUpload/css/diyUpload.css">

    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/diyUpload/js/webuploader.html5only.min.js"></script>

    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/diyUpload/js/diyUpload.js"></script>
<style>
    *
    {
        margin: 0;
        padding: 0;
    }
    #box
    {
        margin: 50px auto;
        width: 540px;
        min-height: 400px;
        background: #FF9;
    }
</style>
<?php echo $this->renderpartial('/common/assembly',array('active'=>$config['active'],'pid'=>$config['pid']))?>
    <script src="<?php echo $this->_theme_url;?>assets/js/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>

    <div class="ad-act-list w1000 bxbg mgt30 clearfix" xmlns="http://www.w3.org/1999/html">
        <div class="ad-app-list-tit clearfix">
            <div class="fl tl">
                <h3>新增活动</h3>
            </div>
        </div>
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-nav clearfix">
                <ul>
                    <li class="selected">
                        <a href="">编辑活动</a>
                    </li>
                    <li class="">
                        <a href="">实时预览</a>
                    </li>
                    <li class="">
                        <a href="">接口示例</a>
                    </li>
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">
                <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block;">
                    <div class="ad-edit-app-1formbg fl">
                        <form id="img_form" method="POST" enctype="multipart/form-data" >
                            <img id="imgPreview" src="<?php if($activity_info['thumb']) {echo JkCms::show_img($activity_info['thumb']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> "/>
                            <i>上传图像
                                <input class="fileinput" type="file" onchange="uploadImg(this)"  name="imgFile" id="upimg" value="<?php echo $activity_info['share_img']?>" /></i>
                            <input type="hidden" name="share_img" id="share_img" value="<?php echo $activity_info['thumb']?>">
                            <p>该图像是用于微信分享时使用建议上传大小为300*300</p>
                        </form>

                    </div>
                    <!--left bg end-->
                    <div class="ad-edit-app-1form">

                        <div class="ad-act-formmain">
                            <h2 class="h2-tit">请您耐心填写完表单，活动的效果会更好！</h2>
                            <input type="hidden" value="<?php echo $config['pid']?>" name="pid">
                            <?php
                            if(isset($activity_info['id'])){
                                ?>
                                <input type="hidden" value="<?php echo $activity_info['id']?>" name="id">
                            <?php
                            }
                            ?>
                            <div class="form-content">
                                <div class="t_title">商品名称<span>（1-20个字符）</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>" placeholder="请填写商品名称" class="form-control " name="title" /></span>
                                </div>

                                <div class="t_title">库存数量</div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['total']) ? $activity_info['total'] : ''; ?>" placeholder="请填写库存数量" class="form-control " name="total" /></span>
                                </div>
                                <div class="t_title">购买金额</div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['productprice']) ? $activity_info['productprice'] : ''; ?>" placeholder="请填写购买金额" class="form-control " name="productprice" /></span>
                                </div>

                                <div class="t_title">商品单位<span>（件|个）</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['unit']) ? $activity_info['unit'] : ''; ?>" placeholder="请填写单位" class="form-control " name="unit" /></span>
                                </div>

                                <div class="t_title">分享描述</div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['share_desc']) ? $activity_info['share_desc'] : ''; ?>" placeholder="请填写分享描述" class="form-control " name="share_desc" id="share_desc" /></span>
                                </div>
                                <div class="t_title">图片显示</div>
                                <ul style="background:#FFF;">
                                    <?php
                                    foreach($thumb_url as $adVal){
                                        ?>
                                        <li style="text-align:center;list-style: none;">
                                            <a onclick="del('<?php echo $adVal ?>',<?php echo  $activity_info['id']?>)"  rel='<?php echo JkCms::show_img($adVal) ?>'>
                                                <img src="<?php echo JkCms::show_img($adVal) ?>" height="200px" style="text-align: -webkit-center;display: -webkit-inline-box;" />删除
                                            </a>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                </ul>
                                <div class="t_title">图片上传</div>
                                <div id="box" class="form-inp">
                                    <div id="test">
                                    </div>
                                </div>
                                <input type="hidden" name="thumb_url" id="thumb_url" value="<?php echo $activity_info['thumb_url']?>">

                                <div class="t_title">活动开始时间<span>请填写活动开始时间</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['timestart']) ? date('Y-m-d H:i:s', $activity_info['timeend']) : ''; ?>" placeholder="请填写活动开始时间" class="form-control" name="timestart" id="start" /></span>

                                </div>
                                <div class="t_title">活动结束时间<span>请填写活动结束时间</span></div>
                                <div class="form-inp">
                                      <span>
                                        <input type="text" value="<?php echo isset($activity_info['timeend']) ? date('Y-m-d H:i:s', $activity_info['timeend']) : ''; ?>" placeholder="请填写活动结束时间" class="form-control" name="timeend" id="end" />
                                      </span>

                                </div>

                                <div class="t_title">商品分类</div>
                               <!-- <select name="pcate" id="pcate" style="padding:5px; width:180px">
                                    <option  value="0" selected="selected">无上级</option>
                                    <?php /*foreach ($adtype as  $typeKey=>$typeVal){
                                        echo '<option value="'.$typeVal['id'].'" ' . ($typeVal['id'] == $activity_info['pcate'] ? 'selected="selected"' : '') . '>'.$typeVal['advname'].'</option>';
                                    } */?>
                                </select>-->
                                <div class="ad-creat-app-inp">

                                <span class="sp2 sp3">
                                    <div class="ad-reg-form-sel">
                                        <select name="pcate" id="pcate" style="width: 97%;">
                                            <option  value="" selected="selected">无上级</option>
                                            <?php foreach ($adtype as  $typeKey=>$typeVal){
                                        echo '<option value="'.$typeVal['id'].'" ' . ($typeVal['id'] == $activity_info['pcate'] ? 'selected="selected"' : '') . '>'.$typeVal['name'].'</option>';
                                    } ?>
                                        </select>
                                    </div>
                                </span>
                                </div>
                                <div class="t_title">+添加标签</div>


                               <!-- <div class="t_title"><i style="color: red">*</i>活动介绍</div>
                                <div class="form-inp">
                                      <span>
                                     <textarea style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;" value="" name='desc' rows="3" cols="20" placeholder="活动详情" class="input_text"><?php /*echo isset($activity_info['desc']) ? $activity_info['desc'] : ''; */?></textarea>                                     </span>
                                </div>

                                <div class="t_title"><i style="color: red">*</i>活动背景</div>
                                <div class="form-inp">
                                      <span>
                                    <textarea style="resize-y:none;width:100%;height:150px;border:1px solid #CDCDCD;" value="" name='background' rows="3" cols="20" placeholder="活动详情" class="input_text"><?php /*echo isset($activity_info['desc']) ? $activity_info['desc'] : ''; */?></textarea>
                                    </span>
                                </div>-->

                                <!-- 上传图片1 start -->
                               <!-- <div class="t_title"><i style="color: red">*</i>投票专题图片(图片大小：640*280)</div>
                                <div class="form-inp">
                                    <form id="img_vote" method="POST" enctype="multipart/form-data" >
                                        <img id="imgPreview_vote" src="<?php /*if($activity_info['img']) {echo JkCms::show_img($activity_info['img']); }else{ echo $this->_theme_url."assets/images/1556c138f70cd73.png";} */?> "/>
                                        <input class="fileinput" type="file" onchange="uploadImg_vote(this)"  name="imgFile" id="upimg" value="" />
                                    </form>
                                    <input type="hidden" name="img" id="img" value="<?php /*echo $activity_info['img']*/?>">
                                </div>-->

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
                        <?php if($activity_info['id']){ ?>
                            <img src="http://qr.topscan.com/api.php?text=<?php echo $this->_siteUrl.'/activity/duobao/MobileIndex/id/'.$activity_info['id'].'/pid/'.$config['pid']?>" width="150" height="150"/>
                        <?php }else{?>
                            <img src="http://qr.topscan.com/api.php?text=http://m.dachuw.net/h5" width="150" height="150"/>
                        <?php }?>
                        <p>扫码在移动设备上<br />体验效果更加</p>
                    </div>


                    <div class="ad-view-app-main">

                        <img class="phonebg" src="<?php echo $this->_theme_url;?>assets/images/ad-act-phone-bg.png"/>

                        <div class="ad-view-app-maindiv">
                            <?php if($activity_info['id']){ ?>
                                <iframe src="<?php echo $this->createUrl('/activity/duobao/MobileIndex',array('id'=>$activity_info['id'],'pid'=>$config['pid']))?>"  scrolling="yes" width="" height=""></iframe>
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
                                <em>http : //m.hb.qq.com/activity/duobao/addGood/id/$id</em>
                                <i></i>
                            </li>
                           <!-- <li><span>传入参数：</span>
                                <em>openid : 微信用户的openid</em>
                            </li>-->
                        </ul>

                        <a href="/dachu/activity_sdk.zip" class="demo-down linear adbtn">DEMO下载</a>

                    </div>


                </div>

                <!--example end-->

            </div>
        </div>
    </div>
    <script type="text/javascript">

        /*
         * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
         * 其他参数同WebUploader
         */

        $('#test').diyUpload({
            url:"<?php echo $this->createUrl('/files/upload'); ?>",//默认是form action
            success:function( data ) {
                if(data.error==0){
                    var picnum=$(".fileBoxUl li").size();
                    var str="";
                  //  for(var i=0;i<picnum;i++){
                        str+=data.url+",";
                    //}
                    var old_str=$("#thumb_url").val();
                    $("#thumb_url").val(str+old_str);
                }
                console.info( data );
            },
            error:function( err ) {
                console.info( err );
            }
        });
    </script>
    <script>
        // 上传图片显示
        function uploadImg_vote(file) {
            var ajax_option={
                url:"<?php echo $this->createUrl('/files/upload'); ?>",//默认是form action
                dataType:"json",
                success:function(data){
//                console.log(data);
                    var iv = document.getElementById("imgPreview_vote");
                    var reader = new FileReader();
                    reader.onload = function(evt) {
                        src1 = evt.target.result;
                        iv.src = src1;
                    };
                    reader.readAsDataURL(file.files[0]);
                    if(data.error==0){
                        $("#img").attr("value",data.url);
//                    alert(data.mess);
                    }
                }
            }
            $('#img_vote').ajaxSubmit(ajax_option);
        }
    </script>
    <script type="text/javascript">
        var start = {
            elem: '#start',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function(datas){
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
                console.log(datas);
                $('input[name="FStartTime"]').trigger("validate");
            }
        };
        var end = {
            elem: '#end',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function(datas){
                start.max = datas; //结束日选好后，重置开始日的最大日期
                $('input[name="FEndTime"]').trigger("validate");
            }
        };
        laydate(start);
        laydate(end);



        var url          = "<?php echo $this->createUrl('/activity/duobao/addGood'); ?>";
        $('.save_button').click(function(){
            var id           = $("input[name='id']").val();
            var pid          = $("input[name='pid']").val();
            var pcate          = $("#pcate ").val();;
            var share_desc          = $("#share_desc ").val();
            var title        = $("input[name='title']").val();
            var total        = $("input[name='total']").val();
            var productprice        = $("input[name='productprice']").val();
            var unit        = $("input[name='unit']").val();
            var timestart   = $("input[name='timestart']").val();
            var timeend     = $("input[name='timeend']").val();
      /*      var desc         = $("textarea[name='desc']").val();
            var background         = $("textarea[name='background']").val();*/
            var share_img    = $("input[name='share_img']").val();
            var thumb_url    = $("input[name='thumb_url']").val();
            var img    = $("input[name='img']").val();
            if(!title ||!timestart ||! timeend ||! total ||! title ||! share_img||!share_desc ){
                layer.msg("所有参数为必填");
                return false;
            }
            if(!pcate ){
                layer.msg("请添加分类");
                return false;
            }
            var data = {
                id:id,
                pid:pid,
                title:title,
                pcate:pcate,
                total:total,
                productprice:productprice,
                unit:unit,
                timestart:timestart,
                timeend:timeend,
                img:img,
                thumb_url:thumb_url,
                share_desc:share_desc,
                share_img:share_img
            };
            $.post(url,data,function(res){
                var res = JSON.parse(res);
                if(res.statue==1){
                    layer.msg(res.msg,{time:2000},function(){
                        window.location.href="<?php echo $this->createUrl('/activity/duobao/list').'/pid/'.$config['pid'].'/active/8'; ?>";
                    })
                }else{
                    layer.msg(res.msg)
                }
            })
        })

        function del(data,id){
            var thumb_url=$("#thumb_url").val();
            var newobj=thumb_url.replace(data+",","");
            layer.confirm('确认要删除图片吗？', {
                btn: ['确定','取消']
            }, function(){
            $.ajax({
                    url:"<?php echo $this->createUrl('delimg');?>",
                    type: "POST",
                    data:{newobj:newobj,id:id},
                    dataType:"json",
                    success:function(data){
                        if(data==100){
                            layer.msg('图片已删除！', {icon: 1,time:2000},function(){
                                location.reload()
                            });
                        }
                        else{
                            layer.msg('图片删除失败', {icon: 1});
                        }
                    }
                });
            });return;

        }

    </script>
<?php echo $this->renderpartial('/common/footer', $config); ?>