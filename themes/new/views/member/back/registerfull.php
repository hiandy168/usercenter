<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<link rel="stylesheet" href="<?php echo $this->_theme_url ?>css/login.css" type="text/css" > 
<div class="container">
<div class="layout-width mt18 clearfix">
  <div class="bag clearfix">
    <div class="relative fr about-nipic">
      <img height="496" width="377" src="<?php echo $this->_theme_url ?>images/leres.jpg"></div>
    <div class="fl bag-aside">
      <div class="bag-aside-hd">
        <h2 class="fl mr15">注册新用户</h2>
        <div class="fl reg-tip">已有帐号？去<a target="_self" hidefocus="true" class="red1 underline" href="#">登录</a>&gt;</div>
      </div>
           <form name="regfrm" id="regfrm" method="post" action="<?php echo $this->createUrl('/member/registerfull') ?>" autocomplete="off">
			<ul id="register" class="bag-aside-box">
<li class="relative clearfix bag-aside-item">
				<lable class="bag-label mt7 fl">真实姓名<em>*&nbsp;</em></lable>
				<div class="cell">
                                    <input class='fl bag-item-input' name="realname" id="realname" type="text" class="text" value="<?php echo isset($view['realname'])?$view['realname']:'';?>" maxlength="15" placeholder="真实姓名"  />
                                </div>
				<div class="alert" id="usernameTip"></div>
			</li>
                    
                        <li class="relative clearfix bag-aside-item">
				<lable class="bag-label mt7 fl">证件类型<em>*&nbsp;</em></lable>
                                            <select class='fl bag-item-input' name="num_type" id='num_type' style='width:140px;height:28px;line-height:28px;'>
                                            <option value="" selected="selected">证件类型</option>
                                            <option value="身份证" <?php echo (isset($view['num_type'])&&($view['num_type']=='身份证'))?'selected="selected"':'';?>>身份证</option>
                                            <option value="户口薄" <?php echo (isset($view['num_type'])&&($view['num_type']=='户口薄'))?'selected="selected"':'';?>>户口薄</option>
                                            <option value="护照" <?php echo (isset($view['num_type'])&&($view['num_type']=='护照'))?'selected="selected"':'';?>>护照</option>
                                            <option value="军官证" <?php echo (isset($view['num_type'])&&($view['num_type']=='军官证'))?'selected="selected"':'';?>>军官证</option>
                                            <option value="士兵证" <?php echo (isset($view['num_type'])&&($view['num_type']=='士兵证'))?'selected="selected"':'';?>>士兵证</option>
                                            <option value="港澳居名来往内地通行证" <?php echo (isset($view['num_type'])&&($view['num_type']=='港澳居名来往内地通行证'))?'selected="selected"':'';?>>港澳居名来往内地通行证</option>
                                            <option value="台湾同胞来往内地通行证" <?php echo (isset($view['num_type'])&&($view['num_type']=='台湾同胞来往内地通行证'))?'selected="selected"':'';?>>台湾同胞来往内地通行证</option>
                                            <option value="临时身份证" <?php echo (isset($view['num_type'])&&($view['num_type']=='临时身份证'))?'selected="selected"':'';?>>临时身份证</option>
                                            <option value="外国人居住证" <?php echo (isset($view['num_type'])&&($view['num_type']=='外国人居住证'))?'selected="selected"':'';?>>外国人居住证</option>
                                            <option value="警官证" <?php echo (isset($view['num_type'])&&($view['num_type']=='警官证'))?'selected="selected"':'';?>>警官证</option>
                                            <option value="香港身份证" <?php echo (isset($view['num_type'])&&($view['num_type']=='香港身份证'))?'selected="selected"':'';?>>香港身份证</option>
                                            <option value="澳门身份证" <?php echo (isset($view['num_type'])&&($view['num_type']=='澳门身份证'))?'selected="selected"':'';?>>澳门身份证</option>
                                            <option value="台湾身份证" <?php echo (isset($view['num_type'])&&($view['num_type']=='台湾身份证'))?'selected="selected"':'';?>>台湾身份证</option>
                                            <option value="其他证件" <?php echo (isset($view['num_type'])&&($view['num_type']=='其他证件'))?'selected="selected"':'';?>>其他证件</option>
                                            </select> 
				<div class="alert" id="usernameTip"></div>
			</li>
                       <li class="relative clearfix bag-aside-item">
				<lable class="bag-label mt7 fl">身份证<em>*&nbsp;</em></lable>
				<div class="cell">
                                     <input class='fl bag-item-input' name="num" id="num" type="text" class="text" value="<?php echo isset($view['num'])?$view['num']:'';?>" maxlength="18" placeholder="身份证号码"  />
                                </div>
				<div class="alert" id="usernameTip"></div>
			</li>
			
<!--			<div class="row">
				<div class="label">电子邮箱<em>*</em></div>
				<div class="cell"><input type="text" name="email" id="email" class="text" value="<?php echo isset($view['email'])?$view['email']:'';?>" placeholder="请输入您常用的电子邮箱" /></div>
			</div>-->
                   
                       <li class="relative clearfix bag-aside-item">
				<lable class="bag-label mt7 fl">地址<em>*&nbsp;</em></lable>
                                      <div style='width:260px;overflow:hidden;'> 
                                          <p>
                                        &nbsp;&nbsp;省
                                        <select class='bag-item-input' name="province_id" id="province_id" onchange="getarea(2,'city_id',this)" style='width:140px;height:28px;line-height:28px;'>
                                        <option selected="selected"  value=''>请选择省份</option>
                                        <?php if(isset($province)&& !empty($province)){foreach($province as $p){ ?>
                                        <option value="<?php echo $p['area_id']?>" <?php if(isset($view['province_id']) && $p['area_id'] ==$view['province_id']){echo 'selected="selected"';}?>><?php echo $p['name']?></option>
                                        <?php }} ?> 
                                        </select>
                                        </p>
                                        <p style='margin:5px 0'>
                                        &nbsp;&nbsp;市
                                        <select class='bag-item-input' name="city_id" id="city_id" onchange="getarea(3,'district_id',this)"  style='width:140px;height:28px;line-height:28px;'>
                                        <option selected="selected"  value=''>请选择市</option>
                                        <?php if(isset($city) && !empty($city)){foreach($city as $p){ ?>
                                        <option value="<?php echo $p['area_id']?>" <?php if(isset($view['city_id']) && $p['area_id'] ==$view['city_id']){echo 'selected="selected"';}?>><?php echo $p['name']?></option>
                                        <?php }} ?> 
                                        </select>
                                        </p>
                                        <p>
                                        &nbsp;&nbsp;区
                                        <select class='bag-item-input' name="district_id" id="district_id" style='width:140px;height:28px;line-height:28px;'>
                                        <option selected="selected" value=''>请选择区</option>
                                        <?php if(isset($district) && !empty($district)){foreach($district as $p){ ?>
                                        <option value="<?php echo $p['area_id']?>" <?php if(isset($view['district_id']) && $p['area_id'] ==$view['district_id']){echo 'selected="selected"';}?>><?php echo $p['name']?></option>
                                        <?php }} ?> 
                                        </select>
                                        </p>
                                        <p style='margin:5px 0;'>
                                        <span style='float:left;height:28px;line-height:28px;'>&nbsp;&nbsp;详细地址&nbsp;&nbsp;</span>
                                        <input class='fl bag-item-input' type="text" name="address" id="address" class="text" value="<?php echo isset($view['address'])?$view['address']:'';?>" placeholder="请输入您住址" />
                                         </p>
                                         </div>
                           
			</li>
                   

            
            
			<div class="row mt10">
                            <input onclick='full()' type="button" name="agree" id="agree"  value="完成认证" class="" tabindex="6" style='background: none repeat scroll 0 0 #ed2200;
    border: 0 none;
    border-radius: 3px;
    color: #fff;
    font-size: 15px;
    height: 42px;
    margin-top: 14px;
    width: 136px;text-align:center;
    margin-left:150px;
    cursor: pointer'/>
                        

			</div>
</ul>
		    </form>
    
	
	
</div>
      </div>
    </div>
     </div>
    
<script>

    function full(){
       var realname = document.getElementById("realname").value;
       var num = document.getElementById("num").value;
       var num_type = document.getElementById("num_type").value;
       var province_id = document.getElementById("province_id").value;
       var city_id = document.getElementById("city_id").value;
       var district_id = document.getElementById("district_id").value;
       var address = document.getElementById("address").value;
        $.ajax({
            type: "post",
            url:baseurl+'/member/ajax_regfull',
            data:{realname:realname,num_type:num_type,num:num,province_id:province_id,city_id:city_id,district_id:district_id,address:address},
            dataType:'json',
            beforeSend: function(){
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess(data.mess+'     8秒后跳转到用户中心','8000');
                      location.href = baseurl+'/member/index';
               }else{
                      ship_mess(data.mess);
               }
            },
            error: function(){
                      ship_mess(data.mess);
            }
        });
        
}

 
<?php if(!isset($view['province_id'])){?>
getarea(1,'province');
<?php } ?>



//pid=>父类ID    grade=>地区级别  target=> 目标ID
function getarea(grade,target,obj){
        var pid =  $(obj).val();
        switch(grade){
            case 1:
//                $grade_name =  'province';
                $grade_name_cn = '省份';
                break;
            case 2:
//                $grade_name =  'city';
                $grade_name_cn = '城市';
                break;
            case 3:
//                $grade_name =  'district';
                $grade_name_cn = '地区';
                break;
            default:
               return;
        }
        $.ajax({    
            url:"<?php echo $this->createUrl('area/get')?>",// 跳转到 action    
            data:{pid : pid,grade : grade},    
            type:'post',    
            dataType:'json',    
            success:function(data) {    
//                var dataObj=eval("("+data+")");
                        $("#"+target).empty();
                        $("#"+target).prepend("<option value='0'>请选择"+$grade_name_cn+"</option>"); 		
                        for(var p in data){
                                $("#"+target).append("<option value="+data[p].area_id+">"+data[p].name+"</option>");
                        }
             },    
             error : function() {    alert("异常！");    }    
        });  
}


</script>

<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
