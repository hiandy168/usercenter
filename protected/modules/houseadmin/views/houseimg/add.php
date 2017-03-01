<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/houseimg/add'); ?>" method="post">
            <?php if($imginfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($imginfo['id']) ? $imginfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>城市:</td><td colspan="1">
                        <select style="width: 288px;border-radius: 3px;" name="city" data-val="requir" data-title="城市"  <?php echo $imginfo ? 'disabled="disabled"' : ''; ?>  >
                            <option value="">请选择</option>
                            <?php foreach($city as $item) {?>
                            <option value="<?php echo $item['id'] ?>" <?php if ($item['id']==$imginfo['city']){ ?>selected<?php } ?>><?php echo $item['city'] ?></option>
                            <?php } ?>
                        </select>
                        <span style="color: red">*</span>
                    </td>
                    <td rowspan="3" class="thumb" colspan="2"  >
                        <div style="    display: inline-block; margin: 0px 20px;">
                            <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','img_url')" src="<?php  echo isset($imginfo['img_url'])?(Tool::show_img($imginfo['img_url'])):(Tool::show_img(''))?>" width="176" height='123' width="150" id="img_thumb">
                            <input type="hidden" data-val="requir" data-title="图片"  name="img_url" id="img_url" value="<?php echo  isset($imginfo['img_url']) ? $imginfo['img_url'] : ''; ?>">
                            <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                                <span  class="btn btn-danger" onclick="upload_pic('img_thumb','img_url')">上传图片</span>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr><td class='t'>排序:</td><td colspan="1"><input data-val="requir" data-title="排序" type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="sort" id="sort"  size="35"  value="<?php echo  isset($imginfo['sort']) ? $imginfo['sort'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                </tr>
                <tr><td class='t'>链接:</td><td colspan="1"><input data-val="requir" data-title="链接" type="text" name="url" id="url"  size="35"  value="<?php echo  isset($imginfo['url']) ? $imginfo['url'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
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
    var strRegex = /^(http|https):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/;
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
        if(!reg.test($("#url").val())){alert("请填写正确的URL链接");return false;}
    })







</script>

