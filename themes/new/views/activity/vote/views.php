<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no" />
    <meta name="Keywords" content="报名-大楚用户开放平台首页" />
    <meta name="description" content="报名-大楚用户开放平台首页" />
    <title><?php echo $info['title']?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/h5/1.1/css/style.css" />
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/jquery.js"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/jquery-1.12.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5/login/js/login.js?v=164654313"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url; ?>assets/h5/login/css/login1.css"/>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/vote/js/common.js" type="text/javascript" charset="utf-8"></script>
    <style>
        .jf-bm3 .btn input {
            width: 40%;
            margin: 0 10px;
        }
    </style>

</head>

<script type="text/javascript">
    openid = "<?php echo $param['openid']?>";
    id = "<?php echo $id?>";
    pid = "<?php echo $pid?>";
    //	backUrl = "<?php echo $param['backUrl']?>";
    mid = "<?php echo $param['mid'] ?>";
    table = "vote";

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

<body>
<?php

$pid = $pid; //服务器传过来的应用id,直接使用
$openid=$param['openid'];//微信开实时获取用户的openid
$userinfo = Activity_signup::getuserinfo($openid,$pid);

?>


<div class="div-main" >

    <!--<div class="top-title clearfix">
         <a class="lefta fl" href="javascript:history.back();void(0)">报名</a>
    </div>-->

    <div class="jf-bm1"><img src="<?php echo ($signup['img'] == '')?$this->_theme_url."assets/h5/1.1/images/jf-img1.jpg":"/".$signup['img'];?>" width="100%" /></div>

    <div class="jf-bm2">
        <h2><?php echo $signup['title'] ?></h2>
        <p id="xdesc"><?php echo $signup['desc'] ?></p>
        <em><?php echo date('Y年m月d日 H时i分s秒',$signup['start_time']) == "00:00:00"?date("Y年m月d日",$signup['start_time']):date("Y年m月d日",$signup['start_time']) ?>
            -- <?php echo date("Y年m月d日 H时i分s秒",$signup['end_time']) == "00:00:00"?date("Y年m月d日",$signup['end_time']-1):date("Y年m月d日",$signup['end_time']) ?></em>
        <!-- <i>免费活动</i> -->
        <i id="actxxshow" style="background: none;bottom: 10px;top: auto;color :#27CCD6;">活动详情</i>
    </div>

    <div class="jf-bm3" style="border: none;">
        <form method="POST" id="img_form" name="img_form" action="<?php echo $this->createUrl('/activity/vote/adminAdd')?>" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $id ?>" name="vid">
            

            <div class="bsd1 clearfix mgrl10 mgb10 vote-form1">
            <div class="vote-form-inp pos-r bb">
                <i class="left-icon">
                    <img src="/themes/new/assets/vote/images/User.png">
                </i>
                <span class="inp">
                    <input type="text" placeholder="请填写名称 ..." name="title" id="title" value="<?php echo $votejoin['title']?>">
                </span>
            </div>
            <div class="vote-form-inp pos-r bb">
                <i class="left-icon">
                    <img src="/themes/new/assets/vote/images/num.png">
                </i>
                <span class="inp">
                    <input type="text" placeholder="请填写号码 ..." name="phone" id="phone" value="<?php echo $votejoin['phone']?>">
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
						 <input type="text" placeholder="<?php echo $form['title'] ?>" name="<?php echo $form['id'] ?>"  value="<?php echo $form['answer']['message']  ?>" />
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
						<textarea style="border: none;width: 100%;" placeholder="填写信息"  name="<?php echo $form['id'] ?>" id="remark" cols="30" rows="10"><?php echo $form['answer']['message']  ?></textarea>
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

<!--            <div class="error" id="error">带<i>*</i>为 必填项目</div>-->
            <div class="btn" style="margin-top: 30px; padding-bottom:30px;">
                <?php if(isset($end_activity)){?>
                    <input  onclick="times()" type="button" value="未开始" />
                <?php }elseif($joinstatus==1){?>
                    <input id="btn" class="save_button" type="submit" value="报名" />
                <?php }elseif($joinstatus==0) { ?>
                    <input style="background: #a9acaf;"type="button" value="已报名" />
                <?php } ?>
               <a href="<?php echo $this->createUrl('/activity/vote/mysignup')?>"> <input  type="button" value="我的报名" /></a>
                <i class="loadingdiv" id="loadingdiv"><img src="<?php echo $this->_theme_url;?>assets/h5/1.1/images/load.gif"/></i>
            </div>
        </form>
    </div>
</div>

<!--mask-->


<div class="cal-mask">
    <div class="cal-mask-con" id="regtips">
				<span class="img">
         			<img src="<?php echo $this->_theme_url;?>assets/h5/1.1/images/cal-error-icon.png"/>
         		</span>
        <p>提示文字</p>
    </div>
</div>


<div class="more-mask"></div>

<div class="act-xx">
    <div class="act-xx-img">
        <img src="<?php echo ($signup['img'] == '')?$this->_theme_url."assets/h5/1.1/images/jf-img1.jpg":"/".$signup['img'];?>" width="100%" />
        <i></i>
    </div>

    <div class="act-xx-scroll">
        <div class="act-xx-txt">
            <div class="act-xx-h1">
                活动详情
            </div>

            <div class="act-xx-txtcon">
                <!-- <h3>活动说明</h3>

                <h4>1、 如何享受满减优惠？    </h4>
                <p>满减活动期间，单一订单购买商品总金额达到满减活动额度要求，便可享受相应的满减优惠。部分商品可能并不在满减活动商品范围之内，这部分商品不参与满减活动商品总金额的计算。</p>

                <h4>2、 如何享受满减优惠？    </h4>
                <p>满减活动期间，单一订单购买商品总金额达。</p>
                 -->
                <?php echo $signup['desc']; ?>
            </div>

            <div class="act-xx-txtcon1">
                <p>活动时间:<?php echo date('Y年m月d日 H时i分s秒',$signup['start_time']) == "00:00:00"?date("Y年m月d日",$signup['start_time']):date("Y年m月d日",$signup['start_time']) ?>
                    -- <?php echo date("Y年m月d日 H时i分s秒",$signup['end_time']) == "00:00:00"?date("Y年m月d日",$signup['end_time']-1):date("Y年m月d日",$signup['end_time']) ?></p>
                <p>活动地点:<?php echo $signup['address']?></p>
                <p>联系方式:<?php echo $signup['phone']?></p>
                <!-- <p><i>报名人数 </i>/ <i>总需人数 </i> / <i>咨询电话</i></p>
                <p><i>564人次 </i> / <i>20</i> / <i>15107130636</i></p> -->
            </div>

            <div class="act-xx-txtcon3">更多问题请咨询主办方</div>
        </div>
    </div>

</div>




<script src="<?php echo $this->_theme_url;?>assets/h5/1.1/js/zepto.js" type="text/javascript" charset="utf-8"></script>


<script type="text/javascript">

    function times() {
        layer.alert('活动<?php echo $end_activity?>', {icon: 5});
    }
    function signup() {
        layer.alert('已报名', {icon: 5});
    }

    <?php if($joinstatus==0){?>
        window.onload=function(){
            layer.alert('已报名成功', {icon: 6});
        }
    <?php } ?>


    <?php if(!$param['mid']){?>
        showlogin();
        $("#winlogin").hide();
    <?php } ?>


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
        if (!title || !phone) {
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

    $("#actxxshow").on("touchstart",function(){
        $(".more-mask").addClass("more-mask-active");
        $(".act-xx").addClass("act-xx-active");
    })
    $(".act-xx-img i").on("touchstart",function(){
        $(".more-mask").removeClass("more-mask-active");
        $(".act-xx").removeClass("act-xx-active");
    })
    function touchb() {
        return false;
    }
    document.addEventListener("touchstart", touchb, false);
    $(function(){
        $("#btn").click(function(){
            checkform();
        });
    })
</script>

</body>

<?php

    if ($info['share_url']) {
        $url = $info['share_url'];
    } else {
        $url = $this->createUrl('/activity/vote/signup/', array('id' => $id));
    }
    echo $this->renderpartial('/common/wxshare', array('signPackage' => $signPackage, 'info' => $info, 'url' => $url));
?>



</html>
<?php  exit; ?>