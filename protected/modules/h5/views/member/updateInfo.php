<?php echo $this->renderpartial('/common/header1',$config); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_theme_url;?>assets/h5/1.1/js/common1.css"/>
    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/h5/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/h5/1.1/js/date.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url;?>assets/h5/1.1/js/iscroll.js"></script>
    <script src="<?php echo $this->_theme_url;?>assets/h5/1.1/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>

<script>
    $(function(){
        $("#sex").change(function() {
            var checkText=$("#sex").find("option:selected").text();
            $("#sextxt").text(checkText);
        });
        $("#birthday").date();
    })

</script>

<div class="div-main" style="background: #FFFFFF;">

    <form action="<?php echo $this->createUrl('/h5/member/updateInfo'); ?>" method="POST" enctype="multipart/form-data" id="infoform">


        <div class="u-useredit-mid bt">
            <ul>

                <li class="bb">
                    <label>昵称</label>
                    <i class="btnmore"></i>
                    <input type="text" name="username" id="username" value="<?php echo $this->member['username']?$this->member['username']:$this->member['name']; ?>">
                </li>

                <li class="bb">
                    <label>性别</label>
                    <i class="btnmore"></i>
                    <em id="sextxt" style="float:right;margin-right: 13px;color: #a8a8a8;"><?php echo $this->member['sex']==1?'男':'女'?></em>
                    <select id="sex" name="sex" style=" border: 0px;width: 100%;opacity: 0;height: 100%;top: 0;left: 0;position: absolute;">
                        <option value="1" <?php echo $this->member['sex']==1?'selected':''?>  >男</option>
                        <option value="2" <?php echo $this->member['sex']==2?'selected':''?>>女</option>
                    </select>
                </li>

                <li class="bb">
                    <label>生日</label>
                    <i class="btnmore"></i>
                    <input type="text" name="birthday" id="birthday" value="<?php echo date("Y/m/d",$this->member['birthday']) ?>">
                </li>

                <li class="bb">
                    <label>邮箱</label>
                    <i class="btnmore"></i>
                    <input type="text" name="email" id="email" value="<?php echo $this->member['email']; ?>">
                </li>

                <li class="bb">
                    <label>职业</label>
                    <i class="btnmore"></i>
                    <input type="text" name="career" id="career" value="<?php echo $this->member['career']; ?>">
                </li>

            </ul>

        </div>

        <div class="u-useredit-btn">
            <input type="button" name="" onclick="fromsub()" id="save_edit" value="保存修改" />
            <i class="loadingdiv"><img src="images/load.gif"/></i>
        </div>

    </form>

</div>
    <div id="datePlugin"></div>

    <script type='text/javascript'>
        /*个人中心个人信息底部banner*/
        var cpro_id=30;
    </script>
    <script type='text/javascript' src='http://ads.dachuw.com/js/front/ads.js'></script>


</body>
</html>
    <script>
        function fromsub(){
            if(!$("#email").val().match(/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/) && $("#email").val()){
                  alert("邮箱格式不正确");
                  return false;
            }else{
                
                var ajax_option={
                url:"<?php echo $this->createUrl('/h5/member/updateInfo'); ?>",//默认是form action
                dataType:"json",
                success:function(data){
                    if(data.state==1){
                        alert(data.mess);
                        location.href="<?php echo $this->createUrl('/h5/member/index'); ?>";
                    }else{
                        alert(data.mess);
                    }
                }
            }
            $('#infoform').ajaxSubmit(ajax_option);
            }
            
        }
    </script>



<?php  exit;?>