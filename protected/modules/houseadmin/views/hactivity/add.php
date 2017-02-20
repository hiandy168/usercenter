<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/hactivity/add'); ?>" method="post">
            <?php if($houseinfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($houseinfo['id']) ? $houseinfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>活动城市:</td><td>
                        <select name="city" data-val="requir" data-title="活动城市"  >
                            <option value="">请选择</option>
                            <option value="1" <?php if ($houseinfo['city']==1){ ?>selected<?php } ?>>武汉</option>
                            <option value="2" <?php if ($houseinfo['city']==2){ ?>selected<?php } ?>>郑州</option>
                        </select>
                        <span style="color: red">*</span>
                    </td>

                    <td rowspan="4" class="thumb" width="200" >
                        <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','share_img')" src="<?php  echo isset($houseinfo['share_img'])?(Tool::show_img($houseinfo['share_img'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumb">
                        <input type="hidden" data-val="requir" data-title="图片"  name="share_img" id="share_img" value="<?php echo  isset($houseinfo['share_img']) ? $houseinfo['share_img'] : ''; ?>">
                        <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                            <span  class="btn btn-danger" onclick="upload_pic('img_thumb','share_img')">上传图片</span>
                        </p>
                    </td>
                    <td rowspan="4" class="thumb" width="200" >
                        <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumbs','img')" src="<?php  echo isset($houseinfo['img'])?(Tool::show_img($houseinfo['img'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumbs">
                        <input type="hidden" data-val="requir" data-title="图片"  name="img" id="img" value="<?php echo  isset($houseinfo['img']) ? $houseinfo['img'] : ''; ?>">
                        <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                            <span  class="btn btn-danger" onclick="upload_pic('img_thumbs','img')">上传图片</span>
                        </p>
                    </td>
                    <td rowspan="4" class="thumb" style='border:0'></td>
                </tr>
                <tr>
                    <td class='t'>活动类型:</td>
                    <td>
                        <label class='w_30'>正式</label>
                        <input class='w_30' type="radio"  name="type" value="1" <?php if (!isset($houseinfo['type']) || $houseinfo['type'] == 1) {
                            echo 'checked';
                        } ?> />
                        <label class='w_30'>测试</label>
                        <input class='w_30' type="radio"  name="type" value="2" <?php if (isset($houseinfo['type']) || $houseinfo['type'] == 2) {
                            echo 'checked';
                        } ?>  />
                    </td>

                </tr>

                <tr>
                    <td class='t'>是否核销:</td>
                    <td>
                        <label class='w_30'>是</label>
                        <input class='w_30' type="radio" name="verfic" value="1" <?php if (!isset($houseinfo['verfic']) || $houseinfo['verfic'] == 1) {
                            echo 'checked';
                        } ?> />
                        <label class='w_30'>否</label>
                        <input class='w_30' type="radio" name="verfic" value="2" <?php if (isset($houseinfo['verfic']) && $houseinfo['verfic'] == 2) {
                            echo 'checked';
                        } ?>  />
                    </td>

                </tr>


                <tr><td class='t'>分享标题:</td><td colspan="3"><input data-val="requir" data-title="分享标题" type="text" name="share_title" id="share_title"  size="40"  value="<?php echo  isset($houseinfo['share_title']) ? $houseinfo['share_title'] : ''; ?>"><span style="color: red">*</span></td>
                <tr>
                    <td class='t'>楼盘id:</td>
                    <td ><input data-val="requir" data-title="楼盘id" type="text" name="houseid" size="40" id="houseid" value="<?php echo  isset($houseinfo['houseid']) ? $houseinfo['houseid'] : ''; ?>"> <input type="button" onclick="gethouseinfo()" value="查询" /><span style="color: red">*</span></td>
                    <td class='t'>结算账户:</td>
                    <td colspan="2">
                        <select name="accountid" data-val="requir" data-title="结算账户">
                            <?php if($result==1){?>
                                <option value="<?php echo $tenant['id'] ?>" <?php if ($houseinfo['accountid']==$tenant['id']){ ?>selected<?php } ?>><?php echo $tenant['site'] ?></option>
                            <?php }else{ ?>
                                <option value="">请选择</option>
                            <?php } ?>
                        </select>
                        <?php if($result==2){?>
                            <a href="<?php echo $this->createUrl('/houseadmin/htenant/add') ?>">请创建</a>
                        <?php } ?>
                        <span style="color: red">*</span>
                    </td>
                </tr>
                <tr>
                    <td class='t'>主标题:</td>
                    <td ><input data-val="requir" data-title="主标题" type="text" name="title" id="title" size="40"  value="<?php echo  isset($houseinfo['title']) ? $houseinfo['title'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>优惠:</td>
                    <td colspan="2"><input  data-val="requir" data-title="优惠"  type="text" size="35" name="coupon" id="coupon" value="<?php echo  isset($houseinfo['coupon']) ? $houseinfo['coupon'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>活动有效期:</td>
                    <td >
                        <input data-val="requir" data-title="活动有效期" type="text" name="actime" id="actime"  size="40"  value="<?php echo  isset($houseinfo['actime']) ? $houseinfo['actime'] : ''; ?>">

                    </td>
                    <td class='t'>使用有效期:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="使用有效期" type="text" name="validity"  size="40" id="validity"  value="<?php echo  isset($houseinfo['validity']) ? $houseinfo['validity'] : ''; ?>">
                    </td>
                </tr>
                <tr>
                    <td class='t'>预存金额:</td>
                    <td ><input data-val="requir" data-title="预存金额" type="text" name="figue" id="figue"  size="40"  value="<?php echo  isset($houseinfo['figue']) ? $houseinfo['figue'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>选择理财活动:</td>
                    <td colspan="2">
                        <select name="financingid" data-val="requir" data-title="选择理财活动" >
                            <option value="">请选择</option>
                            <?php foreach($moneyinfo as $money) {?>
                                <option value="<?php echo $money['id'] ?>" <?php if ($houseinfo['financingid']==$money['id']){ ?>selected<?php } ?>><?php echo $money['title'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class='t'>客服电话:</td>
                    <td ><input data-val="requir" data-title="客服电话" type="text" name="phone" id="phone"  size="40"  value="<?php echo  isset($houseinfo['phone']) ? $houseinfo['phone'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>详情页title:</td>
                    <td colspan="2"><input data-val="requir" data-title="详情页title" type="text" name="dtitle"  id="dtitle"  size="35" value="<?php echo  isset($houseinfo['dtitle']) ? $houseinfo['dtitle'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>活动结束H5跳转地址:</td>
                    <td ><input data-val="requir" data-title="活动结束H5跳转地址" type="text" name="endtimeurl" id="endtimeurl"  size="40"  value="<?php echo  isset($houseinfo['endtimeurl']) ? $houseinfo['endtimeurl'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>支付成功后H5跳转地址:</td>
                    <td colspan="2"><input data-val="requir" data-title="支付成功后H5跳转地址" type="text" name="payurl"  id="payurl"  size="35" value="<?php echo  isset($houseinfo['payurl']) ? $houseinfo['payurl'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>活动详情:</td>
                    <td colspan="4" id="desc">
                        <textarea data-val="requir" data-title="活动详情"  name="desc" class="editor">
                     <?php echo  isset($houseinfo['desc']) ? htmlspecialchars($houseinfo['desc']) : ''; ?>
                     </textarea>
                    </td>
                </tr>
                <tr>
                <tr>
                    <td class='t'>分享说明:</td>
                    <td colspan="4"><textarea data-val="requir" data-title="分享说明" style="width:600px;height:280px;" name="share_desc" id="share_desc" class=""><?php echo  isset($houseinfo['share_desc']) ? htmlspecialchars($houseinfo['share_desc']) : ''; ?></textarea></td></tr>
                <tr>
                <tr>
                    <td width='80' align='right' style="border:none"></td>
                    <td  style="border:none"><input type="submit" value='提交' class="btn btn-success save_button"></td>
                    <td width='80' align='right' style="border:none"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<script type="text/javascript">

    var dateRange1 = new pickerDateRange('actime', {
        stopToday : false,
        isTodayValid : true,
        <?php if($houseinfo){
        ?>
        startDate: '<?php echo date('Y-m-d',$houseinfo['actime']); ?>',
        endDate: '<?php echo date('Y-m-d',$houseinfo['createtime']); ?>',
        <?php
        }else{
        ?>
        startDate: '<?php echo date('Y-m-d',time()); ?>',
        endDate: '<?php echo date('Y-m-d',time()); ?>',
        <?php
        }
        ?>
        needCompare : false,
        defaultText : ' | ',
        autoSubmit : false,
        inputTrigger : 'input_trigger1',
        theme : 'ta'
    });

    var dateRange1 = new pickerDateRange('validity', {
        stopToday : false,
        isTodayValid : true,
        <?php if($houseinfo){
       ?>
        startDate: '<?php echo date('Y-m-d',$houseinfo['validity']); ?>',
        endDate: '<?php echo date('Y-m-d',$houseinfo['updatetime']); ?>',
        <?php
        }else{
        ?>
        startDate: '<?php echo date('Y-m-d',time()); ?>',
        endDate: '<?php echo date('Y-m-d',time()); ?>',
        <?php
        }
        ?>
        needCompare : false,
        defaultText : ' | ',
        autoSubmit : false,
        inputTrigger : 'input_trigger1',
        theme : 'ta'
    });

    <?php $member = Mod::app()->session['admin_member'];?>
    var site_url = "<?php echo $this->_siteUrl; ?>";
    var admin_url = "<?php echo $this->_adminUrl;?>";
    var id = "<?php echo $user['id']?>";
    var token = "<?php echo $user['token']?>";
    var lang = "<?php echo $this->lang?>";
    editor1 = KindEditor.create('.editor', {
        fileManagerJson:admin_url+"/files/file_manager",
        uploadJson:admin_url+'/files/upload?id='+id+'&token='+token+'&lang='+lang,
        allowFileManager : true,
        formatUploadUrl :false,
        filterMode : false,//关闭 要不然会过滤一些代码
        urlType:'',
        afterBlur: function(){this.sync();},
        extraFileUploadParams : {
            PHPSESSID : '<?php echo session_id(); ?>'
        }
    });

    function gethouseinfo(){
        var houseid = $("input[name='houseid']").val();
        if (!houseid) {
            layer.msg("请输入楼盘id");
            return false;
        }
        $.ajax({
            url:"<?php echo $this->createUrl('hoseinfo');?>"   ,
            type: "POST",
            data:{houseid:houseid},
            dataType:"json",
            success:function(result){
                if(result['ret']==0){
                    $("#title").val(result['data']['FName']);
                    $("#phone").val(result['data']['FSellPhone']);
                    editor1.html(result['data']['FSummary']);
                }
                else{
                    layer.msg("查询失败");
                }
            }
        });
    }





    /* var url = "<?php echo $this->createUrl('/houseadmin/Hactivity/add'); ?>";
     $('.save_button').click(function () {
     var city      = $("select[name='city']").find('option:selected').val();
     var type      = $('input[name="type"]:checked').val();
     var validity      = $('input[name="validity"]:checked').val();
     var share_title      = $("input[name='share_title']").val();
     var img      = $("input[name='img']").val();
     var share_img      = $("input[name='share_img']").val();
     var share_desc         = $("textarea[name='share_desc']").val();
     var houseid      = $("input[name='houseid']").val();
     var accountid      = $("select[name='accountid']").find('option:selected').val();
     var title      = $("input[name='title']").val();
     var coupon      = $("input[name='coupon']").val();
     var actime = $("input[name='actime']").val();
     var validity = $("input[name='validity']").val();
     var figue = $("input[name='figue']").val();
     var financingid       = $("select[name='financingid']").find('option:selected').val();
     var phone = $("input[name='phone']").val();
     var dtitle = $("input[name='dtitle']").val();
     var endtimeurl = $("input[name='endtimeurl']").val();
     var payurl = $("input[name='payurl']").val();
     var desc = $("textarea[name='desc']").val();
     if(city==0){
     layer.msg("请选择活动城市");
     return false;
     }
     if(accountid==0){
     layer.msg("请选择结算账户");
     return false;
     }
     if(financingid==0){
     layer.msg("请选择理财活动");
     return false;
     }
     if(!city || !type || !validity || !share_title || !img|| ! share_img ||! share_desc || !accountid || !title || !coupon || !actime || !validity || !figue || !financingid || !dtitle || !endtimeurl || !actime){
     layer.msg("所有参数为必填");
     return false;
     } */

    /* var data = {
     city:city,
     type:type,
     share_title:share_title,
     img:img,
     share_img:share_img,
     share_desc:share_desc,
     houseid:houseid,
     accountid:accountid,
     title:title,
     coupon:coupon,
     actime:actime,
     validity:validity,
     figue:figue,
     financingid:financingid,
     phone:phone,
     dtitle:dtitle,
     endtimeurl:endtimeurl,
     payurl:payurl,
     desc:desc
     };
     $.post(url,data,function(res){
     var res = JSON.parse(res);
     if(res.statue==1){
     layer.msg(res.msg,{time:2000},function(){
     window.location.href="<?php echo $this->createUrl('/house/Hactivity/list')?>";
     })
     }else{
     layer.msg(res.msg)
     }
     })
     })*/

    var requir=$("[data-val=requir]");
    var radio_checked=$("[data-radio=checked]");
    var checkbox_checked=$("[data-checkbox=checked]");
    $(".save_button").on("click",function(){


        for(var i=0;i<requir.length;i++){
            if(!requir.eq(i).val()){
                alert("请填写"+requir.eq(i).attr("data-title"))
                requir.eq(i).focus();
                return false;
            }
        }
        for(var i=0;i<radio_checked.length;i++){
            if(radio_checked.eq(i).find("input[type=radio]:checked").val()==null){
                alert("请选择"+radio_checked.eq(i).attr("data-title"))
                return false;
            }
        }
        for(var i=0;i<checkbox_checked.length;i++){
            if(checkbox_checked.eq(i).find("input[type=checkbox]:checked").length<1){
                alert("请选择"+checkbox_checked.eq(i).attr("data-title")+"至少一项")
                return false;
            }
        }
        //alert("成功");

    })


</script>

