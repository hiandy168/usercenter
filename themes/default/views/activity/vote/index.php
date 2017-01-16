<?php echo $this->renderpartial('/common/header_1',$config); ?>

    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="<?php echo Mod::app()->baseUrl ?>/assets/js/laydate/laydate.js"></script>

<div class="components w980 clearfix">
<div class="left" style="float: left;">
    <div class="title">组件</div>
    <div class="slider_show">
        <div class="bd">
            <ul class="clearfix">
                <li>
                    <div class="item_wrap">
                        <div class="item">
                            <a href="<?php echo $this->createUrl('/activity/signup/index',array('pid'=>$pid)); ?>">
                            <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/18.png" height="53"
                                 width="53">
                            <div class="text"><?php echo isset($sign) ? $sign['title'] : '报名'; ?></div>
                            </a>
                        </div>
                        <div class="item">
                            <a href="<?php echo $this->createUrl('/activity/scratchcard/add',array('pid'=>$pid));?>">
                                <img src="<?php echo Mod::app()->baseUrl ?>/assets/images/18.png" height="53"
                                     width="53">
                                <div class="text">刮刮卡</div>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="hd clearfix">
            <ul>
                <li></li>
                <!-- <li></li> -->
            </ul>
        </div>
    </div>
</div>

<form id="iframe_form111" class="form-horizontal" action="<?php echo $this->createUrl('/activity/signup/addSignUp'); ?>" method="post" id="myForm" style="float: left;width: 370px;margin-left:5px;margin-right: 58px;">
    <div class="center">
        <div class="title">设置</div>
        <div class="content">
            <div class="t_title">报名标题<span>（1-20个字符）</span></div>
            <div class="input">
                <input id="title" type="text" value="<?php echo isset($sign) ? $sign['title'] : ''; ?>" placeholder="请填写报名名称" class="input_text" name="FTitle"/>
                <div class="del"></div>
            </div>

            <div class="t_title">报名说明<span>（1-20个字符）</span></div>
            <div class="input">
                <input id="desc" type="text" value="<?php echo isset($sign) ? $sign['description'] : ''; ?>" placeholder="请填写报名说明" class="input_text" name="desc"/>
                <div class="del"></div>
            </div>

            <div class="t_title">报名开始时间<span>请填写报名开始时间</span></div>
            <div class="input">
                <input id="start" type="text" value="<?php echo isset($sign) ? date('Y-m-d H:i:s',$sign['starttime']) : ''; ?>" placeholder="请填写报名开始时间" class="input_text" name="start"/>
                <div class="del"></div>
            </div>
            <div class="t_title">报名结束时间<span>请填写报名结束时间</span></div>
            <div class="input">
                <input id="end" type="text" value="<?php echo isset($sign) ? date('Y-m-d H:i:s',$sign['endtime']) : ''; ?>" placeholder="请填写报名结束时间" class="input_text" name="end"/>
                <div class="del"></div>
            </div>

            <div class="t_title" style="margin-bottom: 20px;"><h3>报名表单</h3></div>
                <?php if($form){
                    $count = count($form);
                    foreach($form as $k => $v){  ?>
                        <input type="hidden" name="form_id" value="<?php echo $v->id; ?>">

                        <div class="t_title">字段名<span>请填写字段名</span></div>
                        <div class="input">
                            <input type="text" value="<?php echo $v->title; ?>" class="input_text" name="t_title"/>
                            <div class="del"></div>
                        </div>

                        <div class="t_title">字段值<span>请填写字段值</span></div>
                        <div class="input">
                            <input id="username" type="text" value="<?php echo $v->value; ?>" class="input_text" name="s-value"/>
                            <div class="del"></div>
                        </div>

                        <div class="t_title"><input type="checkbox" class="input_text" name="isempty" <?php if($v->isempty){echo 'checked="checked"';}else{echo '';} ?>>&nbsp;是否为空</div>
                        <?php if(($count -1)  !== $k){ ?>
                            <hr style="width: 100%;border: 1px solid red;margin-top: 20px;margin-bottom: 10px;"/>
                        <?php }else{ ?>
                            <br style="width: 100%;margin-top: 10px;margin-bottom: 10px;"/>
                        <?php } ?>

                    <?php } ?>

                <?php }else{ ?>

                    <div class="t_title">字段名<span>请填写字段名</span></div>
                    <div class="input">
                        <input id="username" type="text"  class="input_text" name="t_title" placeholder="姓名"/>
                        <div class="del"></div>
                    </div>

                    <div class="t_title">字段值<span>请填写姓名</span></div>
                    <div class="input">
                        <input type="text" placeholder="张三" class="input_text" name="s-value"/>
                        <div class="del"></div>
                    </div>

                    <div class="t_title"><input type="checkbox" class="input_text" name="isempty">&nbsp;是否为空</div>

                    <hr style="width: 100%;border: 1px solid red;;margin-top: 20px;margin-bottom: 10px;"/>

                    <div class="t_title">字段名<span>请填写字段名</span></div>
                    <div class="input">
                        <input id="email" type="text"  class="input_text" name="t_title" placeholder="邮箱"/>
                        <div class="del"></div>
                    </div>

                    <div class="t_title">字段值<span>请填写邮箱</span></div>
                    <div class="input">
                        <input type="text" placeholder="123@qq.com" class="input_text" name="s-value"/>
                        <div class="del"></div>
                    </div>

                    <div class="t_title" style="margin-bottom: 35px;"><input type="checkbox" class="input_text" name="isempty">&nbsp;是否为空</div>
                <?php } ?>

            <div class="input upload_pic clearfix" id="add_inputs">
                <div class="button1" id="add_input" style="float: left;width: 170px;height: 32px;;line-height: 32px;">继续添加表单项</div>
                <div class="save_button" onclick="checkForm()" style="float: left;width: 170px;height: 32px;line-height: 32px;margin-top: 0px;margin-left: 16px;">保存</div>
            </div>

        </div>
    </div>

</form>

<div>
    <input type="hidden" name="pid" id="pid" value="<?php echo $pid; ?>"/>
    <input type="hidden" name="return_url" id="return_url" value="<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"/>
</div>

    <div class="right" style="float: left;">
        <div class="qr">
            <div class="qr_img">

            </div>
        </div>
        <div class="create_url">
            <textarea name="" id="create_url"><?php echo $pro->url; ?>/dachu.php?redirecturl=<?php echo urlencode('http://' . Mod::app()->params['domain'].'/activity/checkIn/index?appid='.$pro->appid.'&appkey='.$pro->appkey); ?></textarea>
        </div>
        <div class="copy_url" id="copy_url">
            复制链接
        </div>
    </div>

</div>
</body>
</html>
<script src="<?php echo $this->_theme_url; ?>js/home.js"></script>
<!--<script src="--><?php //echo $this->_theme_url; ?><!--js/jquery.2.1.1.min.js"></script>-->
<script type="text/javascript">
    $(document).ready(function () {
        var start = {
            elem: '#start',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(), //设定最小日期为当前日期
            max: '2099-06-16 23:59:59', //最大日期
            istime: true,
            istoday: false,
            choose: function (datas) {
                end.min = datas; //开始日选好后，重置结束日的最小日期
                end.start = datas //将结束日的初始值设定为开始日
                console.log(datas);
                $('input[name="FStartTime"]').trigger("validate");
            }
        };
        var end = {
            elem: '#end',
            event: 'focus',
            format: 'YYYY-MM-DD hh:mm:ss',
            min: laydate.now(),
            max: '2099-06-16 23:59:59',
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas; //结束日选好后，重置开始日的最大日期
                $('input[name="FEndTime"]').trigger("validate");
            }
        };
        laydate(start);
        laydate(end);
    });

    $(function(){
        $('#add_input').click(function(){
            $('#add_input').parents('#add_inputs').before('<hr style="width: 100%;border: 1px solid red;margin-top: -15px;margin-bottom: 10px;"/><div class="t_title">字段名<span>请填写字段名</span></div><div class="input"> <input type="text"  class="input_text" name="t_title"/> <div class="del"></div></div><div class="t_title">字段值<span>请填写字段值</span></div><div class="input"><input id="username" type="text" class="input_text" name="s-value"/><div class="del"></div></div><div class="t_title" style="margin-bottom: 35px;"><input type="checkbox" class="input_text" name="isempty">&nbsp;是否为空</div>');
        });
    });
	
	$("#copy_url").on('click', function () {
            var url = $("#create_url").val();
            if (url == '') {
                alert("无链接复制");
                return false;
            } else {
                copyToCliper(url);
//                $(".qr_img").qrcode({
//                    render: "table",
//                    width: "190",
//                    height: "190",
//                    text: url
//                });
            }


        });

        function copyToCliper(msg) {
            var Sys = {};
            var ua = navigator.userAgent.toLowerCase();
            var s;
            (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
                    (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
                            (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
                                    (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
                                            (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
            if (Sys.ie) {
                var _text = document.createElement("textarea");
                _text.style.width = "1px";
                _text.style.height = "1px";
                _text.style.background = "transparent";
                _text.style.border = "none";
                _text.style.resize = "none";
                _text.style.filter = "alpha(opacity=0)";
                _text.textContent = msg;
                document.body.appendChild(_text);
                _text.select(); //选择对象
                document.execCommand("Copy"); //执行浏览器复制命令
                alert("已复制。");
            }
            else {
                window.prompt("您的浏览器不支持直接复制\n请使用Ctrl+C来复制文本框内容，确认完成后点击关闭。", msg);
            }
        }

    function ckLogin(){
        var $form_modal = $('.cd-user-modal'),
            $form_login = $form_modal.find('#cd-login'),
            $form_signup = $form_modal.find('#cd-signup'),
            $form_modal_tab = $('.cd-switcher'),
            $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
            $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
            $main_nav = $('.main_nav');
            $status = "<?php echo $status?$status:false ?>";
//        alert($status);
        //自动加载登陆弹出窗
        $main_nav.children('ul').removeClass('is-visible');
        $form_modal.addClass('is-visible');
        ( $('.main_nav'.target).is('.cd-signup') ) ? signup_selected() : login_selected();

        function login_selected(){
            $form_login.addClass('is-selected');
            $form_signup.removeClass('is-selected');
            $tab_login.addClass('selected');
            $tab_signup.removeClass('selected');
        }

        function signup_selected(){
            $form_login.removeClass('is-selected');
            $form_signup.addClass('is-selected');
            $tab_login.removeClass('selected');
            $tab_signup.addClass('selected');
        }
    }

    function checkForm(){
        var sid = "<?php echo isset($sign) ? $sign['id'] : ''; ?>";
        var title = $('#title').val();
        var desc = $('#desc').val();
        var start = $('#start').val();
        var end = $('#end').val();
        var username = '';
            username = $('#username').val();
        var email = '';
            email = $('#email').val();
//        alert(start);
//        var emp = $('#isempty').attr('checked');

        if(title.trim() == ''){
            ship_mess_big('报名标题不能为空');
            $('#title').focus();
            return false;
        }

        if(start.trim()=='' || end.trim()==''){
            ship_mess_big('报名时间不能为空');
//            $('#start').focus();
            return false;
        }

//        if(username.trim() == ''){
//            $('#username').focus();
//            ship_mess_big("姓名不能为空");
//            return false;
//        }
//        alert(email);
//        //验证邮箱
//
//        if(email.trim()=="")
//        {
//            ship_mess_big("邮箱不能为空");
//            return false;
//        }
//        if(!email.match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
//        {
//            ship_mess_big("邮箱格式不正确！请重新输入");
//            $("#email").focus();
//            return false;
//        }

        //获取表单所有值
        var form_id = $("input[name='form_id']");
        var ob_titles = $("input[name='t_title']");
        var ob_values = $("input[name='s-value']");
        var ob_empty = $("input[name='isempty']");
        var arr_form_ids = new Array();
        var arr_tit = new Array();
        var arr_val = new Array();
        var arr_emp = new Array();
        form_id.each(function(){
            arr_form_ids.push($(this).val());
        });
        ob_titles.each(function(){
//            alert($(this).val());
            arr_tit.push($(this).val());
        });
        ob_values.each(function(){
//            alert($(this).val());
            arr_val.push($(this).val());
        });
        ob_empty.each(function(){
//            alert($(this).attr('checked'));
            $(this).val('0');
            if($(this).attr('checked')){
                $(this).val('1');
            }
            arr_emp.push($(this).val());
        });
//        alert(arr_emp);



        $.getJSON('<?php echo $this->createUrl('/activity/signup/addSignUp') ?>',
            {sid:sid,pid:$('#pid').val(),title:title,desc:desc,start:start,end:end,arr_form_ids:arr_form_ids,arr_tit:arr_tit,arr_val:arr_val,arr_emp:arr_emp},
            function(data){
                ship_mess_big(data.mess);

                if(data.status){
					
					//生产二维码
				$(".qr_img").qrcode({
                    render: "table",
                    width: "190",
                    height: "190",
                    text: "http://www.qq.com"
                });
                    //操作右侧手机
                    location.reload(); //刷新当前页
//                    window.location.href = "<?php //echo $this->createUrl('/project/edit',array('id'=>$pid)); ?>//";
                }

            });
    }
</script>