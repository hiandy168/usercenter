<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/housecity/add'); ?>" method="post">
            <?php if($cityinfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($cityinfo['id']) ? $cityinfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>城市名称:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="城市名称" type="text" name="city"  size="80" id="city"  value="<?php echo  isset($cityinfo['city']) ? $cityinfo['city'] : ''; ?>"><span style="color: red">*</span>
                    </td>
                <tr>
                <tr>
                    <td class='t'>电话:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="城市名称" type="text" name="phone"  size="40" id="phone"  value="<?php echo  isset($cityinfo['phone']) ? $cityinfo['phone'] : ''; ?>"><span style="color: red">*</span>(例如：400-819-1111转612345  [400-819-1111|612345])
                    </td>
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

