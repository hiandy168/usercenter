<?php echo $this->renderpartial('/common/header_new',$config); ?>
<?php //echo $this->renderpartial('/common/right_menu',array('id'=>$config['pid'])); ?>
<?php /*
<div class="ad-app-nav w1000 clearfix bxbg mgt30">
    <ul>
        <li>
            <div class="ad-app-nav1" style="border-right: 3px solid #f96a30;">
                <a href="<?php echo $this->createAbsoluteUrl('/project/appinfo',array('id'=>$view->id)); ?>">
                    <i class="b1 linear"></i>
                    <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-app-jk-icon.png" />
                    <span><em class="linear">应用信息</em></span>
                </a>
            </div>
        </li>

        <li>
            <div class="ad-app-nav1" style="border-right: 3px solid #6ed0d3;">
                <a href="<?php echo $this->createAbsoluteUrl('/project/setting',array('id'=>$view->id)); ?>">
                    <i class="b2 linear"></i>
                    <img class="linear" src="<?php echo $this->_theme_url; ?>assets/images/ad-app-info-icon.png" />
                    <span><em class="linear">接口配置</em></span>
                </a>
            </div>
        </li>
    </ul>
</div>
*/ ?>



<div class="ad-app-list w1000 clearfix bxbg mgt30">
      <div class="clearfix ad-alltit mgb30 mgt30">
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-jiekoupz.png"/></i>
                <span>接口配置</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                    <!-- <a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" class="a2" title="添加应用"></a> -->
                </div>
 
            </div>
            
            
            
        </div>
    <!--tit end-->


    <div class="ad-edit-info mg20 clearfix">



        <div class="ad-creat-app-tit">请务必保持下面信息正确，否则你的接口将不能正常工作</div>

        <div class="ad-app-portinfo">
            <ul>
                <li>
                    <span><b style="color: #ff0000;">*</b>appid :</span>
                    <em><font><?php echo $view['appid']?></font><br/>
                        该参数用来请求API接口的数据 <a href="<?php echo $this->createAbsoluteUrl('/wiki/'); ?>">技术文档</a></em>
                    <i></i>
                </li>
                <li>
                    <span><b style="color: #ff0000;">*</b>appsecret :</span>
                    <em><?php if(strlen($view['appsecret']) == 32){?>
                            <font id="app_ser">
                                <?php echo str_replace(substr($view['appsecret'],1,30),"******************************",$view['appsecret']);?>
                            </font>
                            <a  id="appser_a" target="_blank" href="javascript:void(0);" no="1" onclick="selall('<?php echo $view['appsecret'];?>','<?php echo str_replace(substr($view['appsecret'],1,30),"******************************",$view['appsecret']);?>')">查看appsecret</a>
                        <?php  }else{ ?>
                            <font id="app_ser">
                                <?php echo str_replace(substr($view['appsecret'],1,14),"**************",$view['appsecret']);?>
                             </font>
                            &nbsp;&nbsp;&nbsp;
                            <a  id="appser_a" target="_blank" href="javascript:void(0);" no="1" onclick="selall('<?php echo $view['appsecret'];?>','<?php echo str_replace(substr($view['appsecret'],1,14),"**************",$view['appsecret']);?>')">查看appsecret</a>
                        <?php } ?><br/>
                        该参数用来请求API接口的数据 <a href="<?php echo $this->createAbsoluteUrl('/wiki/'); ?>">技术文档</a><br/>
                       <!-- (<b style="color: #ff0000;">注：刷新appsecret时，对应的access_token也会更新！</b>) <a  id="update_apper_a" target="_blank" href="javascript:void(0);"  onclick="updateapp_ser('<?php /*echo $view['id'];*/?>')">刷新appsecret</a></em>-->
                    <i></i>
                </li>
                <li class="e1"><span><b style="color: #ff0000;">*</b>wx_appid :</span>
                    <em>
                        <input type="text" class="form-control" id="wx_appid" name="wx_appid" value="<?php echo $view['wx_appid']?>">
                        <b>微信接口配置appid</b>
                    </em>
                    <i></i>

                </li>
                <li class="e1"><span><b style="color: #ff0000;">*</b>wxappsecret :</span>
                    <em>
                        <input type="text" class="form-control" id="wx_appsecret" name="wx_appsecret" value="<?php echo $view['wx_appsecret']?>">
                        <b>微信接口配置appsecret</b>
                    </em>

                </li>
<!--                <li class="e1"><span><b style="color: #ff0000;">*</b>wechaturl :</span>-->
<!--                    <em>-->
<!--                        <input type="text" class="form-control" id="wechat_url" name="wechat_url" value="--><?php //echo $view['wechat_url']?><!--">-->
<!--                        <b>自定义活动组件链接</b>-->
<!--                    </em>-->
<!---->
<!--                </li>-->

                <li class="e2"><span></span>
                    <em><input type="button" class="linear adbtn" name="" value="保存修改" onclick="update_wecharurl('<?php echo $view['id'];?>')">

                    </em>

                </li>
            </ul>

        </div>


    </div>


</div>




<div class="footer">
    <div id="main_width">

        <?php $this->renderPartial('/common/footer',array('config'=>$config));?>

    </div>
    <div class="clear"></div>
</div>
<script>
    function selall(appser,appser2){
        if($("#appser_a").attr("no")==1) {
            $("#app_ser").html(appser);
            $("#appser_a").html("隐藏appsecret");
            $("#appser_a").attr("no",2);
        }else{
            $("#app_ser").html(appser2);
            $("#appser_a").html("查看appsecret");
            $("#appser_a").attr("no",1);
        }
    }

    function update_wecharurl(pid){
        url = $("#wechat_url").val();
        var wx_appid = $('#wx_appid').val();
        var wx_appsecret = $('#wx_appsecret').val();

        $.ajax({
            url:'<?php echo $this->createUrl("/project/UpdateWecharurl");?>',
            data:{pid:pid,wechaturl:url,wx_appsecret:wx_appsecret,wx_appid:wx_appid},
            dataType:'json',
            type:'post',
            success : function (data) {
                if (data.code == 200) {
                    alert("修改成功");
                    location.reload();
                } else {
                    alert(data.mess);
                    location.reload();
                }
            }
        });
    }

    function updateapp_ser(pid){
        $.ajax({
            url:'<?php echo $this->createUrl("/project/UpdateAppsecret");?>',
            data:{pid:pid},
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
                $('.button').attr('onclick','javascript:void(0)');
            },
            success : function (data) {
                if (data.code == 200) {
                    alert("刷新成功");
                    location.reload();

                } else {
                    alert(data.mess);
                    location.reload();

                }
            }
        });
    }
</script>
