<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="<?php echo $info['title']?>" />
    <meta name="description" content="<?php echo $info['title']?>" />
    <title><?php echo $info['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/login/css/login1.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/vote/css/style.css"/>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/layout.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>/assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/layer/layer.js" type="text/javascript" charset="utf-8"></script>



</head>
<script type="application/javascript">
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    // 上传图片显示
    $(function(){
        $(".vote-form-inp .select select").change(function(){
            if($(this).find("option:checked").val()==""){
                $(this).prev().html('请选择');
                layer.msg("请选择");
            }else{
                var str=$(this).find("option:checked").text();
                $(this).prev().html(str);
            }
        })
    })


</script>
<style>
    #imgPreview{
        width: 100%;
        min-height: 4rem;
        border-radius: .2rem;
        position: absolute;
        top: 0;
        left: 0;
        display: none;
        overflow: hidden;
    }
</style>

<body>


<div class="div-main">

    <form method="POST" id="img_form" name="img_form" action="<?php echo $this->createUrl('/activity/vote/adminAdd')?>" enctype="multipart/form-data" >
    <div class="vote-main">
        <div class="pos-r vote-hd-rankdiv1">
            <input type="hidden" value="<?php echo $vid ?>" name="vid">
            <?php
            if (isset($id) && !empty($id)) {
                ?>
                <input type="hidden" value="<?php echo $id ?>" name="id">
            <?php
             }
            ?>
            <h3 class="tit">我要报名</h3>
            <img src="<?php echo $this->_theme_url; ?>assets/vote/images/vote-banner.jpg" width="100%" />
            <div class="pos-a linear-bg"></div>
        </div>

        <div class="bsd1 clearfix mgrl10 mgb10 vote-form1">
            <div class="vote-form-inp pos-r bb">
                <i class="left-icon">
                    <img src="<?php echo $this->_theme_url; ?>assets/vote/images/User.png"/>
                </i>
                <span class="inp">
                    <input type="text" placeholder="请填写名称 ..." name="title" id="title" value="<?php echo isset($activity_info['title']) ? $activity_info['title'] : ''; ?>" />
                </span>
            </div>
            <div class="vote-form-inp">
                <i class="left-icon">
                    <img src="<?php echo $this->_theme_url; ?>assets/vote/images/num.png"/>
                </i>
                <span class="inp">
                    <input type="text" placeholder="请填写号码 ..." name="phone" id="phone" value="<?php echo isset($activity_info['phone']) ? $activity_info['phone'] : ''; ?>" />
                </span>
            </div>
        </div>

        <?php if(!empty($formList)){?>
        <div class="vote-form2 bsd1 clearfix mgrl10 mgb10">

            <?php foreach($formList as $form){if($form['forms']==0){?>
                <div class="vote-form-inp pos-r bb">
                    <i class="left-icon">
                        <img src="<?php echo $this->_theme_url; ?>assets/vote/images/uniline.png"/>
                    </i>
					<span class="inp">
						 <input type="text" placeholder="请填写<?php echo $form['title'] ?>" name="<?php echo $form['id'] ?>"  value="<?php echo $form['answer']['message']  ?>" />
					</span>
                </div>
            <?php }elseif($form['forms']==1){?>
                <div class="pos-r bb vote-form-inp">
                    <i class="left-icon">
                        <img src="/themes/new/assets/vote/images/rowmuch.png">
                    </i>
					<span class="select">
						<em><?php echo $form['title'] ?></em>
					</span>
                </div>
                <div class="pos-r bb vote-form-inp">
                    <i class="left-icon">
                    </i>
					<span>
						<textarea style="border: none;width: 100%;"  class="fs30"  placeholder="请填写<?php echo $form['title'] ?>" name="<?php echo $form['id'] ?>" id="remark" cols="30" rows="10"><?php echo $form['answer']['message']  ?></textarea>
					</span>
                </div>
            <?php } elseif($form['forms']==2){?>
                <div class="pos-r bb vote-form-inp">
                    <i class="left-icon">
                        <img src="<?php echo $this->_theme_url; ?>assets/vote/images/radio.png"/>
                    </i>
					<span class="select">
						<em><?php echo $form['title'] ?></em>
						<select name="<?php echo $form['id'] ?>">
                            <option value="">请选择</option>
                            <?php foreach($form['question'] as $ss){?>
                                <option value="<?php echo $ss['id']?>"><?php echo $ss['question']?></option>
                            <?php }?>
                        </select>
						<i></i>
					</span>
                </div>
            <?php }elseif($form['forms']==3){ ?>

                <div class="pos-r bb vote-form-inp">
                    <i class="left-icon">
                        <img src="<?php echo $this->_theme_url; ?>assets/vote/images/checkbox.png"/>
                    </i>
					<span class="checkbox1">
						<em style="position: relative;top: 3px;"><?php echo $form['title'] ?> <i>（多选）</i></em>
					</span>
                </div>
                <div class="pos-r vote-form-inp bb">
					<span class="checkbox2">
                        <?php foreach($form['question'] as $ss){?>
						<label for="<?php echo $ss['id']?>">
                            <input type="checkbox" <?php if($ss['id']==$form['answer']['message']){ ?>checked ="checked "<?php } ?> name="<?php echo $form['id'] ?>[]" id="<?php echo $ss['id']?>" value="<?php echo $ss['id']?>_" />
                            <i></i>
                            <em><?php echo $ss['question']?></em>
                        </label>
                        <?php }?>
					</span>
                </div>
            <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="fs24 bsd1 clearfix mgrl10 mgb10 vote-detail3">
            <div class="vote-detail2 pos-r bb">
                <i>
                    <img src="<?php echo $this->_theme_url; ?>assets/vote/images/Cup.png"/>
                </i>
                <label class=" fc259">活动宣言</label>
            </div>

            <div class="vote-form-txt">
                <textarea name="remark" id="remark" rows="remark" class="fs30" placeholder="请填写活动宣言，控制在200个字符..." cols=""></textarea>
            </div>

        </div>


        <div class="fs24 bsd1 clearfix mgrl10 mgb10 vote-detail3">
            <div class="vote-detail2 pos-r bb">
                <i>
                    <img src="<?php echo $this->_theme_url; ?>assets/vote/images/Picture.png"/>
                </i>
                <label class="fc259">上传作品</label>
                <p class="fc259">大小:小于2MB,图片类型:jpg,jpeg,png</p>
            </div>


            <div class="vote-form-upimg">
                <span class="pos-r" style="overflow: hidden">
                    <em id="imgPreview"></em>
                    <img id="examepleImg" src="<?php echo $this->_theme_url; ?>assets/vote/images/xj-icon.png" />
                    <input  type="file" accept="image/*" id="uploadphoto" name="uploadfile"  value="1"   />
                    <input type="hidden" name="share_img" id="share_img" value="1">
                    <input type="hidden" name="whojoin" id="whojoin" value="1">

                   <!-- 图片上传loading -->

                   <div class="progress" style="display: none;">
                       <div class="progress-bar progress-bar-info progress-bar-striped active" style="width:0%;">
                           <i style="visibility: hidden;">&nbsp;</i>
                       </div>
                       <div class="progress-bar-txt  percent">加载中...</div>
                   </div>
                    <div id="voteSuccess" class="vote-success"><img style="width:100%;" src="<?php echo $this->_theme_url; ?>assets/vote/images/vote-success-icon.png"/></div>
                </span>
            </div>
        </div>


        <div class="vote-form-btn">
            <input class="save_button bg4 fcfff fs30" type="submit" name="" id="" value="提交" />
        </div>

    </div>

    </form>

    <!--main end-->

    <?php echo $this->renderpartial('/common/footer_app',array('active'=>0,'id'=>$id,'pid'=>$pid,'param'=>$param)); ?>


    <div class="mask"></div>

    <!--pop-->

    <div class="vote-pop bg4">
        <span><img src="images/vote-test.jpg"/></span>
        <p class="fcfff fs30">恭喜，您已成功投票</p>
        <!--<p class="fcfff fs30">遗憾，不可重复投票！</p>-->
        <div class="closebtn fs30">确定</div>
    </div>


</div>



 <script src="<?php echo $this->_theme_url; ?>assets/vote/js/lrz.bundle.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

$("#uploadphoto").on('change', function () {

    var progress = $(".progress");
    var progress_bar = $(".progress-bar");
    var percent = $('.percent');
    var eximg=$("#examepleImg");
    var successIcon=$("#voteSuccess");
    var that = this;
    lrz(that.files[0], {
        width: 500
    }).then(function (rst) {

            var img = new Image(),
                sourceSize = toFixed2(that.files[0].size / 1024),
                resultSize = toFixed2(rst.fileLen / 1024),
                scale = parseInt(100 - (resultSize / sourceSize * 100));

            if(sourceSize>5120){
             alert("上传文件过大，请上传小于5MB的图片");
                return false;
            }else{

                var xhr = new XMLHttpRequest();
                xhr.open('POST', Siteurl+'/files/upload');
                
                xhr.onloadstart=function(){
                successIcon.hide();
                eximg.hide();
                progress.show();
                var percentVal = '0%';
                progress_bar.width(percentVal);
                percent.html(percentVal);

                };
                xhr.onload = function ()
                {
                    var data = JSON.parse(xhr.response);
                    // 上传成功
                    if (data.error==0) {
                        $("#imgPreview").html("<img style='width:100%;min-height: 4rem;' src=/"+data.url+">").show();
                        $("#share_img").val(data.url);
                        successIcon.show();
                        progress.hide();
                        return true;
                    } else {
                        // 处理错误
                        return false;
                    }
                };

                 xhr.upload.onprogress = function (e) {
                 var percentComplete =parseInt(((e.loaded / e.total) || 0) * 100);
                 var percentVal = percentComplete + '%'; //获得进度
                    progress_bar.width(percentVal); 
                    percent.html(percentVal); 

                 };
                    xhr.onerror = function () {
                     alert("网络错误")
                 };
                    rst.formData.append('fileLen', rst.fileLen);//参数，可继续增加
                    xhr.send(rst.formData);// 触发上传
                    return rst;
            }

        });
});



function toFixed2 (num) {
    return parseFloat(+num.toFixed(2));
}


String.prototype.render = function (obj) {
    var str = this, reg;

    Object.keys(obj).forEach(function (v) {
        reg = new RegExp('\\!\\{' + v + '\\}', 'g');
        str = str.replace(reg, obj[v]);
    });

    return str;
};


function fireEvent (element, event) {
    var evt;
    if (document.createEventObject) {
        evt = document.createEventObject();
        return element.fireEvent('on' + event, evt)
    }
    else {

        evt = document.createEvent('HTMLEvents');
        evt.initEvent(event, true, true);
        return !element.dispatchEvent(evt);
    }
}



    var url = "<?php echo $this->createUrl('/activity/vote/adminAdd'); ?>";
    $('.save_button').click(function () {

        <?php if(!$param['mid']){?>
            showloginssss();
            return false;
        <?php } ?>
        var id = $("input[name='id']").val();
        var vid = $("input[name='vid']").val();
        var title = $("input[name='title']").val();
        var phone = $("input[name='phone']").val();
        var start_time = $("input[name='start_time']").val();
        var remark = $("#remark").val();
        var share_img = $("input[name='share_img']").val();
        var data = {
            id: id,
            vid: vid,
            title: title,
            remark: remark,
            img: share_img,
            whojoin: 1
        };
        if (!title || !remark || !share_img|| !phone) {
            layer.msg("所有参数不能为空");
            return false;
        }

        if(!(/^1[34578]\d{9}$/.test(phone))){
            layer.msg("手机号码有误");
            return false;
        }
        if (remark.length > 200) {
            layer.msg("对不起您的宣言超过字数限制（200）");
            return false;
        }
        if (title.length > 20) {
            layer.msg("对不起您的标题超过字数限制（20）");
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

</body>

<?php  echo $this->renderpartial('/common/wxshare',array('signPackage'=>$signPackage,'info'=>$info,'url'=>$this->createUrl('/activity/vote/view',array('id'=>$id) ))); ?>
</html>
