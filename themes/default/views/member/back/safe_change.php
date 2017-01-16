<?php $this->renderPartial('/common/header_member',array('config'=>$config));?>

<style>
    
    
.row:after {
    clear: both;
    content: " ";
    display: block;
    font-size: 0;
    height: 0;
    visibility: hidden;
}
 .row {
    padding: 8px 0 8px 20px;
    position: relative;
}
.row .label{width:120px;text-align:right;padding:4px;}
.row .label,.row .cell{float:left}

     .text {
    border: 1px solid #ccc;
    float: left;
    font-size: 12px;
    height: 18px;
    line-height: 18px;
    padding: 5px 3px;
    width: 256px;
}
input[class="text"]:focus {
    border-color: #3971cb !important;
    outline: medium none;
}

</style>
<div class="user_main">
    <div class="user_center">
	<div class="user_center_left">
        <table cellspacing="0" cellpadding="0" border="0" width="100%" class="user_center_info">
          <tbody><tr>
            <td width="44" valign="top"><span></span></td>
            <td>
                <h1><?php echo $this->member['realname']?></h1>
                                    <p style="margin-bottom: 5px;"><?php echo $this->member['name']?></p>
                                      <i class="unCertify">
									<?php if($this->member['authentication']){?>
									<a href="javascript:void(0)">已认证</a>
									<?php }else{?>
									<a href="javascript:void(0)">已提交，等待认证</a>
									<?php }?>
									</i>
            </td>
          </tr>
        </tbody></table>


        <div class="user_center_nav">
       		
           <a class="nav_off" href="<?php echo $this->createUrl('/member');?>">
            <span class="nav_icon1"></span><span class="nav_text">我的名片</span>
        </a>

        <a class="nav_off" href="<?php echo $this->createUrl('/member/msg');?>">
            <span class="nav_icon4"></span><span class="nav_text">我的私信</span>
        </a>
            
<!--        <a class="nav_off" href="<?php echo $this->createUrl('/member/safe_center');?>">
            <span class="nav_icon3"></span><span class="nav_text">我的人脉</span>
        </a>  -->
            
        <a class="nav_on" href="<?php echo $this->createUrl('/member/safe_center');?>">
            <span class="nav_icon3"></span><span class="nav_text">安全中心</span>
        </a>
              	                <div class="bline"><!----></div>
        </div>

    </div>
        <div class="user_center_right">
         
          <h1 class="user_center_h1">安全中心</h1>


<style>
.quxiao,.wait_sign_quxiao{color:#3479c7;font-size: 14px; background: none; border: none;}
.ok {z-index:9999;}
.ok p {width:320px;height:50px;line-height:50px;text-indent:70px;font-size:22px;color:#fff;background:#333 url("/images/ok.png") no-repeat 20px 8px;}
.clear {clear:both;height:20px;}
</style>
<div class="user_center_order_list">
       <form name="regfrm" id="regfrm" method="post" action="<?php echo $this->createUrl('/member/edit_pass') ?>" autocomplete="off">
		
               <div class="row">
				<div class="label">原密码<em>*</em></div>
				<div class="cell"><input type="password" name="data[member][olduserpass]" id="oldpasswd" class="text" value="" placeholder="6-20个字母、数字或符号" /></div>
				</div>

           <div class="row">
				<div class="label">密码<em>*</em></div>
				<div class="cell"><input type="password" name="data[member][userpass]" id="passwd" class="text" value="" placeholder="6-20个字母、数字或符号" /></div>
				<div id="pwdComplex" style="display:none;"><em>密码安全强度：</em><span class="l1"></span></div>
			</div>
			<div class="row">
				<div class="label">再次密码<em>*</em></div>
				<div class="cell"><input type="password" name="re_memberpass" id="repasswd" class="text" value="" placeholder="请再次输入密码" /></div>
			</div>
           	<div class="row mt10">
                    <input onclick='editpass();'  type="agree" name="agree" id="agree"  value="修改密码" class="" tabindex="6" style='background: none repeat scroll 0 0 #ed2200;
    border: 0 none;
    cursor: pointer;
    border-radius: 3px;
    color: #fff;
    font-size: 15px;
    height: 42px;
    margin-top: 14px;
    width: 136px;text-align:center;
    margin-left:150px'/>
			</div>
    </form>


     
<!--      <form style='border-top:1px solid #ccc;margin-top:10px;padding-top:10px' name="regfrm" id="regfrm" method="post" action="<?php echo $this->createUrl('/member/edit_other') ?>" autocomplete="off">

           <div class="row">
				<div class="label">证件类型<em>*</em></div>
                                <div class="cell  text"  style='border:none'><?php echo $member->num_type?></div>
		</div>
           <div class="row">
				<div class="label">证件号码<em>*</em></div>
                                <div class="cell  text"  style='border:none'><?php echo $member->num?></div>
		</div>
       

        <div class="row">
        <div class="label">qq<em>*</em></div>
        <div class="cell" ><input type="text" name="data[member][qq]" id="qq" class="text" value="<?php echo $member->qq?>" placeholder="请输入您的QQ账号" /></div>
        </div>
          
        <div class="row">
        <div class="label">电子邮箱<em>*</em></div>
        <div class="cell"><input type="text" name="data[member][email]" id="email" class="text" value="<?php echo $member->email?>" placeholder="请输入您常用的电子邮箱" /></div>
        </div>
                   
                  
           	<div class="row mt10">
                    <input  onclick='editother();' type="agree" name="agree" id="agree"  value="修改" class="" tabindex="6" style='background: none repeat scroll 0 0 #ed2200;
    border: 0 none;
    cursor: pointer;
    border-radius: 3px;
    color: #fff;
    font-size: 15px;
    height: 42px;
    margin-top: 14px;
    width: 136px;text-align:center;
    margin-left:150px'/>
			</div>
    </form>-->
</div>




<div class="layer-mask"></div>

    </div>

    <div style="clear:both"><!----></div>
</div>

</div>

<script>
     function editpass(){
       var oldpasswd = document.getElementById("oldpasswd").value;
       var passwd = document.getElementById("passwd").value;
       var repasswd = document.getElementById("repasswd").value;
        $.ajax({
            type: "post",
            url:baseurl+'/member/edit_pass',
            data:{oldpasswd:oldpasswd,passwd:passwd,repasswd:repasswd},
            dataType:'json',
            beforeSend: function(){
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess(data.mess,'10000');
                              document.location.reload(); 
               }else{
                      ship_mess(data.mess,'10000');
               }
            },
            error: function(){
                      ship_mess(data.mess,'10000');
            }
        });
    }
        
      function editother(){
       var email = document.getElementById("email").value;
       var address = document.getElementById("address").value;
       var qq = document.getElementById("qq").value;
        $.ajax({
            type: "post",
            url:baseurl+'/member/edit_other',
            data:{email:email,address:address,qq:qq},
            dataType:'json',
            beforeSend: function(){
            },
            success: function(data){
               if(data.state === 1){
                      ship_mess(data.mess);
                              document.location.reload(); 
               }else{
                      ship_mess(data.mess);
               }
            },
            error: function(){
                      ship_mess(data.mess);
            }
        });
    }
</script>    
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>

