<script src="<?php echo $this->theme_url; ?>/assets/public/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->theme_url; ?>/assets/public/js/dateRange.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_url; ?>/assets/public/css/dateRange.css"/>
<div class='bgf clearfix'>
    <div class="form_list">
        <form name="formview" id="formview" action="<?php echo $this->createUrl('/houseadmin/htenant/add'); ?>" method="post">
            <?php if($tenantinfo['id']){?>
                <input type="hidden" name="id" value="<?php echo isset($tenantinfo['id']) ? $tenantinfo['id'] : ''; ?>">
            <?php }?>
            <table cellSpacing=0 width="100%" class="content_view">
                <tr>
                    <td class='t'>城市:</td>
                    <td ><input data-val="requir" data-title="城市" type="text" name="city" size="40" id="city" value="<?php echo  isset($tenantinfo['city']) ? $tenantinfo['city'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>运营站点:</td>
                    <td ><input data-val="requir" data-title="运营站点" type="text" name="site" id="site" size="40"  value="<?php echo  isset($tenantinfo['site']) ? $tenantinfo['site'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>商户公司名称:</td>
                    <td ><input data-val="requir" data-title="商户公司名称" type="text" name="companyname" id="companyname" size="40"  value="<?php echo  isset($tenantinfo['companyname']) ? $tenantinfo['companyname'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>营业执照编号:</td>
                    <td colspan="2"><input  data-val="requir" data-title="营业执照编号"  type="text" size="40" name="busnum" id="busnum" value="<?php echo  isset($tenantinfo['busnum']) ? $tenantinfo['busnum'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>组织机构代码:</td>
                    <td >
                        <input data-val="requir" data-title="组织机构代码" type="text" name="code" id="code"  size="40"  value="<?php echo  isset($tenantinfo['code']) ? $tenantinfo['code'] : ''; ?>"><span style="color: red">*</span>
                    </td>
                    <td class='t'>税务登记号:</td>
                    <td colspan="2">
                        <input data-val="requir" data-title="税务登记号" type="text" name="taxid"  size="40" id="taxid"  value="<?php echo  isset($tenantinfo['taxid']) ? $tenantinfo['taxid'] : ''; ?>"><span style="color: red">*</span>
                    </td>
                </tr>
                <tr>
                    <td class='t'>开户行名称:</td>
                    <td ><input data-val="requir" data-title="开户行名称" type="text" name="bankname" id="bankname"  size="40"  value="<?php echo  isset($tenantinfo['bankname']) ? $tenantinfo['bankname'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>开户行账号:</td>
                    <td ><input data-val="requir" data-title="开户行账号" type="text" name="banknum" id="banknum"  size="40"  value="<?php echo  isset($tenantinfo['banknum']) ? $tenantinfo['banknum'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>账户名称:</td>
                    <td ><input data-val="requir" data-title="账户名称" type="text" name="accountname" id="accountname"  size="40"  value="<?php echo  isset($tenantinfo['accountname']) ? $tenantinfo['accountname'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>企业法人</td>
                    <td colspan="2"><input data-val="requir" data-title="企业法人" type="text" name="busentity"  id="busentity"  size="40" value="<?php echo  isset($tenantinfo['busentity']) ? $tenantinfo['busentity'] : ''; ?>"><span style="color: red">*</span></td>
                </tr>
                <tr>
                    <td class='t'>运营人姓名:</td>
                    <td ><input data-val="requir" data-title="运营人姓名" type="text" name="operatorname" id="operatorname"  size="40"  value="<?php echo  isset($tenantinfo['operatorname']) ? $tenantinfo['operatorname'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>运营人证件类型:</td>
                    <td colspan="2">
                        <select name="idtype" data-val="requir" data-title="运营人证件类型" >
                            <option value="">请选择</option>
                            <option value="01" <?php if ($tenantinfo['financingid']=="1"){ ?>selected<?php } ?>>身份证</option>
                        </select><span style="color: red">*</span>
                    </td>
                </tr>
                <tr>
                    <td class='t'>运营人证件号码:</td>
                    <td ><input data-val="requir" data-title="运营人证件号码" type="text" name="operatornum" id="operatornum"  size="40"  value="<?php echo  isset($tenantinfo['operatornum']) ? $tenantinfo['operatornum'] : ''; ?>"><span style="color: red">*</span></td>
                    <td class='t'>运营人手机号</td>
                    <td colspan="2"><input data-val="requir" data-title="运营人手机号" type="text" name="operatorphone"  id="operatorphone"  size="40" value="<?php echo  isset($tenantinfo['operatorphone']) ? $tenantinfo['operatorphone'] : ''; ?>"><span style="color: red">*</span></td>
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

    $(".save_button").on("click",function(){
        var operatorphone=$("input[name='operatorphone']").val();
        var operatornum=$("input[name='operatornum']").val();
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
        if(IdentityCodeValid(operatornum)){
            if(/^1[34578]\d{9}$/.test(operatorphone)){
                alert("成功");
            }else{
                alert("请正确填写手机号");
                $("input[name='operatorphone']").focus();
                return false;
            }
        }else{
             alert("请正确填写运营证件号码");
            $("input[name='operatornum']").focus();
             return false;
        }
    })

    // 身份证验证

    function IdentityCodeValid(code) {
        var city = {
            11: "北京",
            12: "天津",
            13: "河北",
            14: "山西",
            15: "内蒙古",
            21: "辽宁",
            22: "吉林",
            23: "黑龙江 ",
            31: "上海",
            32: "江苏",
            33: "浙江",
            34: "安徽",
            35: "福建",
            36: "江西",
            37: "山东",
            41: "河南",
            42: "湖北 ",
            43: "湖南",
            44: "广东",
            45: "广西",
            46: "海南",
            50: "重庆",
            51: "四川",
            52: "贵州",
            53: "云南",
            54: "西藏 ",
            61: "陕西",
            62: "甘肃",
            63: "青海",
            64: "宁夏",
            65: "新疆",
            71: "台湾",
            81: "香港",
            82: "澳门",
            91: "国外 "
        };
        var tip = "";
        var pass = true;
        if (!code || !/^[1-9]\d{5}((1[89]|20)\d{2})(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])\d{3}[\dx]$/i.test(code)) {
            tip = "身份证号格式错误";
            pass = false;
        } else if (!city[code.substr(0, 2)]) {
            tip = "地址编码错误";
            pass = false;
        } else {
            //18位身份证需要验证最后一位校验位
            if (code.length == 18) {
                code = code.split('');
                //∑(ai×Wi)(mod 11)
                //加权因子
                var factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                //校验位
                var parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                var sum = 0;
                var ai = 0;
                var wi = 0;
                for (var i = 0; i < 17; i++) {
                    ai = code[i];
                    wi = factor[i];
                    sum += ai * wi;
                }
                var last = parity[sum % 11];
                if (parity[sum % 11] != code[17]) {
                    tip = "校验位错误";
                    pass = false;
                }
            }
        }
        return pass;
    }

</script>

