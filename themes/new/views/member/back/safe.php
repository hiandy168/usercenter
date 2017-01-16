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
            
        <a class="nav_on" href="<?php echo $this->createUrl('/member/safe_change');?>">
            <span class="nav_icon3"></span><span class="nav_text">安全中心</span>
        </a>
              	                <div class="bline"><!----></div>
        </div>

    </div>
        <div class="user_center_right">
          <h1 class="user_center_h1">安全中心</h1>
          <table cellspacing="0" cellpadding="0" border="0" style="margin:30px 0px 25px 0px;">
            <tbody>
              <tr>
                <td>安全级别：</td>
                <td><span style="width:400px;" class="percent"><span style="width:55%;" class="percent_active"></span></span></td>
                <td>&nbsp;
                  中
                  &nbsp;&nbsp;</td>
              </tr>
            </tbody>
          </table>
          <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:5px;">
            <tbody>
              <tr style="border-bottom:1px dashed #ccc;">
                <td height="40"><i class="user_safe_ok"></i></td>
                <td>&nbsp;绑定手机&nbsp;&nbsp;</td>
                <td style="color:#999">绑定手机号码，账户资金变动、使用额度、修改密码时使用</td>
                <td align="right"></td>
              </tr>
            </tbody>
          </table>

             
<!--              <tr style="border-bottom:1px dashed #ccc;">
                <td height="40"><i class="user_safe_ok"></i></td>
                <td>&nbsp;绑定邮箱&nbsp;&nbsp;</td>
                <td style="color:#999">绑定邮箱，账户资金变动、使用额度、修改密码时使用</td>
                <td align="right"><a class="blue" href="#">修改</a></td>
              </tr>
              <tr style="border-bottom:1px dashed #ccc;">
                <td height="40"><i class="user_safe_no"></i></td>
                <td>&nbsp;绑定邮箱&nbsp;&nbsp;</td>
                <td style="color:#999">绑定邮箱，账户资金变动、使用额度、修改密码时使用</td>
                <td align="right"><a class="blue" href="#">修改</a></td>
              </tr>
              <tr style="border-bottom:1px dashed #ccc;">
                <td height="40"><i class="user_safe_no"></i></td>
                <td>&nbsp;绑定邮箱&nbsp;&nbsp;</td>
                <td style="color:#999">绑定邮箱，账户资金变动、使用额度、修改密码时使用</td>
                <td align="right"><a class="blue" href="#">修改</a></td>
              </tr>-->
            </tbody>
          </table>
          <br><br>
            <table cellspacing="0" cellpadding="0" border="0" style="margin:30px 0px 25px 0px;">
            <tbody>
              <tr>
                <td> <a class="blue" href="<?php echo $this->createUrl('/member/safe_change');?>"  style="margin-left:20px;background: none repeat scroll 0 0 #ed2200; border: 0 none; cursor: pointer; border-radius: 3px; color: #fff; font-size: 15px; height: 42px; width: 136px;text-align:left; padding:15px;" >修改个人资料/密码</a></td>
          </td>
               
              </tr>
            </tbody>
          </table>
          
        </div>
        
	

    <div style="clear:both"><!----></div>
</div>

</div>

<script>
     function editpass(){
       var passwd = document.getElementById("passwd").value;
       var repasswd = document.getElementById("repasswd").value;
        $.ajax({
            type: "post",
            url:Siteurl+'/member/edit_pass',
            data:{passwd:passwd,repasswd:repasswd},
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
        
      function editother(){
       var email = document.getElementById("email").value;
       var address = document.getElementById("address").value;
        $.ajax({
            type: "post",
            url:Siteurl+'/member/edit_other',
            data:{email:email,address:address},
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

