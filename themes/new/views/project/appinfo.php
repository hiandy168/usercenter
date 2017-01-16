<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php //echo $this->renderpartial('/common/right_menu',array('id'=>$config['pid'])); ?>
<?php /*
<div class="ad-app-nav w1000 clearfix bxbg mgt30">
    <ul>
        <li>
            <div class="ad-app-nav1" style="border-right: 3px solid #f96a30;">
                <a href="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$view->id)); ?>">
                    <i class="b1 linear"></i>
                    <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-app-jk-icon.png" />
                    <span><em class="linear">应用信息</em></span>
                </a>
            </div>
        </li>

        <li>
            <div class="ad-app-nav1" style="border-right: 3px solid #6ed0d3;">
                <a href="<?php echo $this->createAbsoluteUrl('/project/setting',array('id'=>$view->id)); ?>">
                    <i class="b2 linear"></i>
                    <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-app-info-icon.png" />
                    <span><em class="linear">接口配置</em></span>
                </a>
            </div>
        </li>

    </ul>
</div>
*/ ?>

<div class="ad-app-list w1000 clearfix bxbg mgt30">
    <div class="clearfix ad-alltit mgb30 mgt30">
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-yingyongxx.png"/></i>
                <span>应用信息</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                
                </div>
 
            </div>
            
            
            
        </div>
    <!--tit end-->





    <div class="ad-edit-info mg20 clearfix">


        <form id="img_form" method="POST" enctype="multipart/form-data" >
            <div class="ad-edit-info-form1" style="position: absolute;">

                <div class="ad-haslogin-info linear">
                    <i><img style=" width: 100%;height: auto;border-radius: 0;" src="<?php if($view['wechat_url']) {echo JkCms::show_img($view['wechat_url']); }else{ echo
                            $this->_theme_url."assets/images/1556c138f70cd73.png";} ?> " id="imgPreview" width="" height=""></i>
                        <span class="clearfix">
                                <a>修改应用图像
                                    <input style="height: 70%" type="file" onchange="uploadImg(this)"  name="imgFile" id="upimg"  value="">

                                </a>
                            </span>
                    <p>

                        如不上传图像，可自动默认
                        <br>为规格为320*270的默认头
                        <br>像png图片。
                    </p>
                </div>

            </div>
        </form>
        <form action="" id="regform1" method="post" accept-charset="utf-8">
            <input type="hidden" name="share_img" id="share_img" value="<?php echo $view['wechat_url']?>">
        <div class="ad-edit-info-form">
            <div class="ad-creat-app-inp">
                <span class="sp1">应用名称：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="pname" id="name" value="<?php echo $view['name']?$view
                        ['name']:''?>">
                    </span>


            </div>



            <div class="ad-creat-app-inp">
                <span class="sp1">应用简介：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="pname1" id="introduction" value="<?php echo
                        $view['introduction']?$view['introduction']:''?>">
                    </span>


            </div>


            <div class="ad-creat-app-inp">
                <span class="sp1">服务器地址：</span>
                    <span class="sp2">
                        <input class="form-control" type="text" placeholder="" name="purl" id="url" value="<?php echo $view['url']?$view
                        ['url']:''?>">
                    </span>


            </div>



            <div class="ad-creat-app-inp">
                <span class="sp1">应用类别：</span>
                    <span class="sp2 sp3">
                        <div class="ad-reg-form-sel">
                            <select name="ykind" id="type" style="width: 96.5%;">
                                <option value="" >请选择</option>
                                <?php
                                foreach($type as $type) {
                                    ?>
                                    <option value="<?php echo $type['id']?>"<?php if($view['type']==$type['id']){?>selected="selected"<?php } ?>><?php echo $type['name']?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </span>

            </div>



            <input name="id" value="<?php echo $view['id']?>" id="id" type="hidden">
            <div class="ad-creat-app-inp">
                <span class="sp1">&nbsp;</span>
                    <span class="sp2">
                        <div class="ad-creat-app-formbtn">
                            <input class="linear adbtn" type="submit" name="" id="" value="保存配置">
                        </div>
                    </span>

            </div>

           
       
     </div>
      </form>
    </div>


</div>




</div>

  <style>
       .ad-creat-app-inp .sp3 em{top:0;left: 402px;}
      
    </style>
<script type="text/javascript">
    var Validator = $("#regform1").validate({
        ignore:"#upimg",

        rules: {
            pname: {
                required: true,

            },
            purl: {
                required: true,
                isUrl:true,
            },
            ykind:{
                required: true,
            },

        },

        messages: {
            pname: {
                required: "请填写应用名",

            },
            purl: {
                required: "请填写服务器地址",
                isUrl:"请输入正确服务器地址",
            },
            ykind:{
                required: "请选择应用类别",
            },

        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            if (element.parent().parent().find('em') != null) {
                element.parent().parent().find('em').remove()
            }
            error.appendTo(element.parent().parent());
        },

        errorClass: "cerror",
        validClass: "cright",

        success: function(obj) {
            obj.text("正确").removeClass('cerror').addClass("cright");
        },

        submitHandler: function() {
            var name=$("#name").val();
            var wechat_url=$("#share_img").val();
            var introduction=$("#introduction").val();
            var url=$("#url").val();
            var type=$("#type").val();
            var id=$("#id").val();

            $.ajax({

                url:"<?php echo $this->createUrl("/project/appinfo")?>",
                data:{
                    name:name,
                    wechat_url:wechat_url,
                    introduction:introduction,
                    url:url,
                    type:type,
                    id:id,
                },
                dataType:'json',
                type:'post',
                beforeSend: function(){  //防止重复提交数据
                    $('#fromsubmit').attr("disabled",true);
                },
                success : function (data) {

                    $('#fromsubmit').removeAttr("disabled");
                    if (data.state == 200) {
                        layer.msg(data.mess,{
                            icon:6,
                            shift: 5,
                            time:1000,
                            end:function(){

                                // parent.layer.close(index);
                            }
                        })
                    } else {
                        layer.msg(data.mess,{icon:5});
                    }
                }
            });
        },


    });

    // 服务器地址验证
    jQuery.validator.addMethod("isUrl", function(value, element) {
        var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{1,3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
        var reg = new RegExp(strRegex);
        return this.optional(element) || (reg.test(value));
    }, "请输入正确服务器地址");


</script>



<div class="footer">
    <div id="main_width">

        <?php $this->renderPartial('/common/footer',array('config'=>$config));?>

    </div>
    <div class="clear"></div>
</div>

