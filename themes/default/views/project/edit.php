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
        <div class="tips">
                            创建一个项目后才能申请入驻
        </div>
        <div class="add_application">
            <div class="item clearfix">
                <div class="l">应用名称</div>
                <div class="r">
                    <div class="input">
                        <input class="input_text" name="name" type="text" value=""  placeholder="请填写"/>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">简介</div>
                <div class="r">
                    <div class="input">
                        <textarea class="textarea_text" name="introduction"  placeholder="请填写"></textarea>
                    </div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l">服务器地址</div>
                <div class="r">
                    <div class="input">
                        <input id="url" name="url" type="text" placeholder="http://www.baidu.com" class="input_text" />
                    </div>
                </div>
            </div>      
            <div class="item clearfix">
                <div class="l">应用类别：</div>
                <div class="r">
                    <select name="type" class="input_text" class="select" id="select">
                        <option value="" >请选择</option>
                        <option value="新闻" <?php if($view['type']=='新闻'){?>selected="selected"<?php } ?>>新闻</option>
                        <option value="房产"<?php if($view['type']=='房产'){?>selected="selected"<?php } ?>>房产</option>
                        <option value="汽车"<?php if($view['type']=='汽车'){?>selected="selected"<?php } ?>>汽车</option>
                        <option value="家居"<?php if($view['type']=='家居'){?>selected="selected"<?php } ?>>家居</option>
                        <option value="健康"<?php if($view['type']=='健康'){?>selected="selected"<?php } ?>>健康</option>
                        <option value="社区"<?php if($view['type']=='社区'){?>selected="selected"<?php } ?>>社区</option>
                        <option value="教育"<?php if($view['type']=='教育'){?>selected="selected"<?php } ?>>教育</option>
                        <option value="亲子" <?php if($view['type']=='亲子'){?>selected="selected"<?php } ?>>亲子</option>
                        <option value="体育" <?php if($view['type']=='体育'){?>selected="selected"<?php } ?>>体育</option>
                        <option value="时尚" <?php if($view['type']=='时尚'){?>selected="selected"<?php } ?>>时尚</option>
                        <option value="旅游" <?php if($view['type']=='旅游'){?>selected="selected"<?php } ?>>旅游</option>
                        <option value="创业" <?php if($view['type']=='创业'){?>selected="selected"<?php } ?>>创业</option>
                        <option value="电商" <?php if($view['type']=='电商'){?>selected="selected"<?php } ?>>电商</option>
                        <option value="文化" <?php if($view['type']=='文化'){?>selected="selected"<?php } ?>>文化</option>
                        <option value="视频" <?php if($view['type']=='视频'){?>selected="selected"<?php } ?>>视频</option>
                        <option value="其他" <?php if($view['type']=='其他'){?>selected="selected"<?php } ?>>其他</option>
                    </select> 
                    
                </div>
            </div>
            <div class="item clearfix">
                <div class="l icon1">帮助文档</div>
                <div class="r">
                    <div class="p">项目创建完毕后可在项目管理页面进行项目信息编辑</div>
                </div>
            </div>
            <div class="item clearfix">
                <div class="l"></div>
                <div class="r">
                    <div class="p1">
                        <label>
                            <input type="checkbox" name="" id="inputbox" value="1" checked />同意<span><a href="<?php echo $this->createurl('agreement/index')?>" target="_blank" style="color: #1b66c7;">《大楚开放平台协议》</a></span>
                        </label>
                    </div>
                    <!-- <div class="p1">
                        <label><input name="Fruit" type="checkbox" value="1" />关注大楚开放平台微信号</label>
                    </div> -->
                </div>
            </div>
            <div class="item clearfix">
                <div class="l"></div>
                <div class="r"><div class="button" onclick="addPro();">保存</div></div>
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

    function addPro(){
        var name = $('.input_text').val();
        var info = $('.textarea_text').val();
        var url = $('#url').val();
        if(name.trim() == ''){
            ship_mess_big('应用名不能为空');
            return false;
        }
        if(info.trim() == ''){
            ship_mess_big('应用简介不能为空');
            return false;
        }
        if(url.trim() == ''){
            ship_mess_big('URL不能为空');
            return false;
        }
        //验证url
        url = url.trim();
        var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{1,3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
        var reg = new RegExp(strRegex);
        if(!reg.test(url) ){
            ship_mess_big('URL格式不正确');
            return false;
        }

        var ckbox = $('#inputbox:checked').val();
        if(!ckbox){
            ship_mess_big('没有同意本站协议');
            return false;
        }
        var select = $('#select').val();
        if(!select){
            ship_mess_big('请选择应用类型');
            return false;
        }

        var attention = $('input[name="Fruit"]:checked').val();
//        alert(attention);
//        return false;
        $.ajax({
            url:'<?php echo $this->createUrl("/project/projectReg",array('id'=>$model->id)); ?>',
            data:{name:name,introduction:info,url:url,attention:attention,select:select},
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
                $('.button').attr('onclick','javascript:void(0)');
            },
            success : function (data) {
                if (data.state == 1) {
                	ship_mess_big(data.mess);
                	window.setTimeout(window.location.href="<?php echo $this->createUrl('/project/prolist'); ?>",2000)
                	
                    /*layer.msg(data.mess,{
                        icon:6,
                        shift: 5,
                        time:1000,
                        end:function(){
                            top.location.href = "<?php echo $this->createUrl('/project/prolist'); ?>";
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }
                    });*/

                } else {
                	ship_mess_big(data.mess);
                }
            }
        });
    }

</script>
<?php echo $this->renderpartial('/common/footer', $config); ?>