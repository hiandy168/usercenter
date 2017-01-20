<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/hmoney/add'); ?>" method="post">
            <?php if($houseinfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($houseinfo['id']) ? $houseinfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>产品类型:</td>
                    <td colspan="2">
                        <label class='w_30'>活期</label>
                        <input class='w_30' type="radio" name="type" value="1" <?php if (!isset($houseinfo['type']) || $houseinfo['type'] == 1) {
                            echo 'checked';
                        } ?> />
                        <label class='w_30'>固定</label>
                        <input class='w_30' type="radio" name="type" value="2" <?php if (isset($houseinfo['type']) && $houseinfo['type'] == 2) {
                            echo 'checked';
                        } ?>  />
                    </td>
                <tr>
                <tr>
                    <td class='t'>产品名称:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="产品名称" type="text" name="title"  size="80" id="title"  value="<?php echo  isset($houseinfo['title']) ? $houseinfo['title'] : ''; ?>"><span style="color: red">*</span>
                    </td>
                <tr>
                <tr>
                    <td class='t'>产品周期:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="产品周期" type="text" name="cycle"  size="80" id="cycle"  value="<?php echo  isset($houseinfo['cycle']) ? $houseinfo['cycle'] : ''; ?>">个月（0表示无限）<span style="color: red">*</span>
                    </td>
                <tr>
                <tr>
                    <td class='t'>预存收益:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="预存收益" type="text" name="earnings"  size="80" id="earnings"  value="<?php echo  isset($houseinfo['earnings']) ? $houseinfo['earnings'] : ''; ?>">%<span style="color: red">*</span>
                    </td>
                <tr>
                <tr>
                    <td class='t'>活动详情:</td>
                    <td colspan="4"><textarea data-val="requir" data-title="活动详情" style="width:600px;height:280px;" name="details" id="details" class=""><?php echo  isset($houseinfo['details']) ? htmlspecialchars($houseinfo['details']) : ''; ?></textarea><span style="color: red">*</span></td></tr>
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

