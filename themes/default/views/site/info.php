<?php echo $this->renderpartial('/common/header_new',$config); ?>
<div class="new_address">
    <div class="nav_111">
        <a href="#" target="_blank" class="txt">我的站点</a>
            <span class="arrow">
            <img src="<?php echo $this->_theme_url; ?>images/1010.png" alt="">
        </span>
        <?php echo isset($config['position'])?Tool::get_position($config['position'],$this->_theme_url.'images/1010.png'):'';?>
    </div>
</div>
<link rel="stylesheet" href="<?php echo $this->_theme_url; ?>css/prolist.css">

<div class="new_wrap clearfix">

    <?php echo $this->renderpartial('/common/left_new'); ?>

    <div class="right">
        <div class="add_application">
<!--            <div class="item clearfix">-->
<!--                <div class="l">用户名</div>-->
<!--                <div class="r">-->
<!--                    <div class="input">-->
<!--                        <input name="name" id="name" type="text" value="--><?php //echo $this->member['name']?><!--" class="input_text" readonly/>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="item clearfix">-->
<!--                <div class="l">密码</div>-->
<!--                <div class="r">-->
<!--                    <div class="input">-->
<!--                        <input type="password" placeholder="请填写" value="--><?php //echo $this->member['password']?><!--">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <div class="item clearfix">
                <div class="l">手机号码</div>
                <div class="r">
                    <div class="input">
                        <input id="phone" class="input_text" type="text" placeholder="请填写" value="<?php echo $this->member['phone']?>">
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">邮箱地址</div>
                <div class="r">
                    <div class="input">
                        <input id="email" class="input_text" type="text" placeholder="请填写" value="<?php echo $this->member['email']?>"/>
                    </div>
                </div>
            </div>
<!--            <div class="item clearfix">
                <div class="l">所属行业</div>
                <div class="r">
                    <div class="input triangle">

                        <select id="type" class="input_text" name="type">
                            <option style="padding:5px;" value="" >请选择</option>
                            <option style="padding:5px;" value="1" <?php /*if($this->member['type']=='1'){*/?>selected="selected"<?php /*} */?>>财务</option>
                            <option style="padding:5px;" value="2"<?php /*if($this->member['type']=='2'){*/?>selected="selected"<?php /*} */?>>参考</option>
                            <option style="padding:5px;" value="3"<?php /*if($this->member['type']=='3'){*/?>selected="selected"<?php /*} */?>>导航</option>
                            <option style="padding:5px;" value="4"<?php /*if($this->member['type']=='4'){*/?>selected="selected"<?php /*} */?>>儿童</option>
                            <option style="padding:5px;" value="5"<?php /*if($this->member['type']=='5'){*/?>selected="selected"<?php /*} */?>>工具</option>
                            <option style="padding:5px;" value="6"<?php /*if($this->member['type']=='6'){*/?>selected="selected"<?php /*} */?>>健康健美</option>
                            <option style="padding:5px;" value="7"<?php /*if($this->member['type']=='7'){*/?>selected="selected"<?php /*} */?>>教育</option>
                            <option style="padding:5px;" value="8" <?php /*if($this->member['type']=='8'){*/?>selected="selected"<?php /*} */?>>旅行</option>
                            <option style="padding:5px;" value="9" <?php /*if($this->member['type']=='9'){*/?>selected="selected"<?php /*} */?>>美食佳饮</option>
                            <option style="padding:5px;" value="10" <?php /*if($this->member['type']=='10'){*/?>selected="selected"<?php /*} */?>>商业</option>
                            <option style="padding:5px;" value="11" <?php /*if($this->member['type']=='11'){*/?>selected="selected"<?php /*} */?>>商品指南</option>
                            <option style="padding:5px;" value="12" <?php /*if($this->member['type']=='12'){*/?>selected="selected"<?php /*} */?>>社交</option>
                            <option style="padding:5px;" value="13" <?php /*if($this->member['type']=='13'){*/?>selected="selected"<?php /*} */?>>摄影与录像</option>
                            <option style="padding:5px;" value="14" <?php /*if($this->member['type']=='14'){*/?>selected="selected"<?php /*} */?>>生活</option>
                            <option style="padding:5px;" value="15" <?php /*if($this->member['type']=='15'){*/?>selected="selected"<?php /*} */?>>体育</option>
                            <option style="padding:5px;" value="16" <?php /*if($this->member['type']=='16'){*/?>selected="selected"<?php /*} */?>>天气</option>
                            <option style="padding:5px;" value="17" <?php /*if($this->member['type']=='17'){*/?>selected="selected"<?php /*} */?>>图书</option>
                            <option style="padding:5px;" value="18" <?php /*if($this->member['type']=='18'){*/?>selected="selected"<?php /*} */?>>效率</option>
                            <option style="padding:5px;" value="19" <?php /*if($this->member['type']=='19'){*/?>selected="selected"<?php /*} */?>>新闻</option>
                            <option style="padding:5px;" value="20" <?php /*if($this->member['type']=='20'){*/?>selected="selected"<?php /*} */?>>医疗</option>
                            <option style="padding:5px;" value="21" <?php /*if($this->member['type']=='21'){*/?>selected="selected"<?php /*} */?>>音乐</option>
                            <option style="padding:5px;" value="22" <?php /*if($this->member['type']=='22'){*/?>selected="selected"<?php /*} */?>>娱乐</option>
                            <option style="padding:5px;" value="23"  <?php /*if($this->member['type']=='23'){*/?>selected="selected"<?php /*} */?>>游戏</option>
                            <option style="padding:5px;" value="24" <?php /*if($this->member['type']=='24'){*/?>selected="selected"<?php /*} */?>>视频</option>
                            <option style="padding:5px;" value="25" <?php /*if($this->member['type']=='25'){*/?>selected="selected"<?php /*} */?>>软件开发工具</option>
                            <option style="padding:5px;" value="26" <?php /*if($this->member['type']=='26'){*/?>selected="selected"<?php /*} */?>>图形和设计</option>
                        </select>


                        <div class="icon2"></div>
                    </div>
                </div>
            </div>-->
            <div class="item clearfix">
                <div class="l">公司名称</div>
                <div class="r">
                    <div class="input">
                        <input id="company" class="input_text" type="text" placeholder="请填写" value="<?php echo $this->member['company']?>"/>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">公司地址</div>
                <div class="r">
                    <div class="input">
                        <input id="address" class="input_text" type="text" placeholder="请填写" value="<?php echo $this->member['address']?>"/>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l"></div>
                <div class="r">
                    <div class="button">保存</div>
                </div>
            </div>
        </div>
        
    </div>

</div>
<script>
    $(document).ready(function () {

//        $(".new_wrap .left .title2").hover(function () {
//            $(this).find('.arrow').addClass("arrow_down");
//            $(this).find('.title22').addClass('on_hover');
//            $(this).find(".subtitle").show();
//        }, function () {
//            $(this).find('.arrow').removeClass("arrow_down");
//            $(this).find('.title22').removeClass('on_hover');
//            $(this).find(".subtitle").hide();
//        });
  $(".new_wrap .left .title2").click(function () {
            if($(this).find('.arrow').hasClass('arrow_down')){
                    $(this).find('.arrow').removeClass("arrow_down");
                    $(this).find('.title22').removeClass('on_hover');
                    $(this).find(".subtitle").hide();
            }else{
                    $(this).find('.arrow').addClass("arrow_down");
                    $(this).find('.title22').addClass('on_hover');
                    $(this).find(".subtitle").show();
            }
        });

        $("#change_td_bg tr").hover(function () {
            $(this).addClass('hover');
        }, function () {
            $(this).removeClass('hover');
        });

    });

    $(function(){
        $('.button').click(function(){
            var phone = $('#phone').val().trim();
            var email = $('#email').val().trim();
            //var type = $('#type').val().trim();
            var company = $('#company').val().trim();
            var address = $('#address').val().trim();
            //验证手机号
            if(phone) {
                var reg = /^1[3|4|5|7|8]\d{9}$/;
                if (!reg.test(phone)) {
                    ship_mess_big('请填写正确的手机号');
                    $('#phone').focus();
                    return false;
                }
            }
            //验证邮箱
            if(email){
                var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                if(!reg.test(email)){
                    $('#email').focus();
                    ship_mess_big('邮箱格式错误');
                    return false;
                }
            }
            if(company.length > 100){
                $('#company').focus();
                ship_mess_big('限100字以内');
                return false;
            }
            if(address.length > 100){
                $('#address').focus();
                ship_mess_big('限100字以内');
                return false;
            }
            //提交数据
            $.ajax({
                url:'<?php echo $this->createUrl('/site/updateMemInfo'); ?>',
                data:{phone:phone,email:email,company:company,address:address},
                dataType:'json',
                type:'post',
                success:function(data){
                    ship_mess_big(data.mess);
                    if(data.state){
                        window.location.href = "<?php echo $this->createUrl('/project/prolist'); ?>";
                    }
                }
            });

        });

    });

</script>
<?php echo $this->renderpartial('/common/footer', $config); ?>