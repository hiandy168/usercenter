<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/houseip/add'); ?>" method="post">
            <?php if($imginfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($imginfo['id']) ? $imginfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>ip:</td><td colspan="1"><input data-val="requir" data-title="ip" type="text" name="ip" id="ip"  size="35"  value="<?php echo  isset($imginfo['ip']) ? $imginfo['ip'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr><td class='t'>备注:</td><td colspan="1"><input data-val="requir" data-title="备注" type="text" name="remark" id="remark"  size="35"  value="<?php echo  isset($imginfo['remark']) ? $imginfo['remark'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
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
    var requir=$("[data-val=requir]");
    var radio_checked=$("[data-radio=checked]");
    var checkbox_checked=$("[data-checkbox=checked]");
    var strRegex = /^((2[0-4]\d|25[0-5]|[01]?\d\d?)\.){3}(2[0-4]\d|25[0-5]|[01]?\d\d?)$/;
    var reg = new RegExp(strRegex);
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
        if(!reg.test($("#ip").val())){alert("请填写正确的Ip链接");return false;}
    })

</script>

