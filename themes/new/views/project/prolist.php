<?php  echo $this->renderpartial('/common/header_new',$config); ?>

<?php //echo $this->renderpartial('/common/left_new'); ?>

<style type="text/css">
    /*样式重置不用粘贴*/
    *{ margin: 0; padding: 0; outline: 0; border: 0; font-family: "microsoft yahei";}


    /*要粘贴样式*/
    .kfpop-mask { position: fixed; z-index: 999; bottom: 0; left: 0; right: 0; top: 0; background: #E2E2E2; background: rgba(0, 0, 0, .1); display: block; }
    .kfpop-div { width: 600px; position: absolute; left: 50%; margin-left: -300px; top: 50%; background: #fff; border-radius: 5px;  margin-top: -130px; }
    .modal-header { padding: 8px 14px; margin: 0; font-size: 14px; font-weight: normal; line-height: 18px; background-color: #f7f7f7; border-bottom: 1px solid #ebebeb; -webkit-border-radius: 5px 5px 0 0; -moz-border-radius: 5px 5px 0 0; border-radius: 5px 5px 0 0; height: 35px; }
    .modal-header .modal_title { float: left; padding: 1px 0 5px 10px; margin-bottom: 1px; font-weight: bold; }
    .modal-header .modal_close { float: right; padding: 1px 0 5px 10px; margin-bottom: 1px; font-weight: bold; cursor: pointer; }
    .modal-body { padding: 9px 14px; overflow: hidden; }
    .modal-body .text { color: #FF6B6B; margin-bottom: 10px; }
    .modal-body textarea { border: 1px solid #ccc; width: 99%; height: 100px; }
    .modal-body .btn-green { color: #fff; background: #FF6B6B; padding: 3px 10px; border-radius: 3px; margin-top: 8px; cursor: pointer; }
    .modal-body .copy_ok { color: #FF6B6B; font-size: 14px; padding-left: 10px; display: none; }
    .modal-footer { padding-bottom: 20px; text-align: center; }
    .modal-footer .btn { cursor: pointer; background: #FF6B6B; padding: 6px 15px; border-radius: 3px; color: #FFFFFF; margin: 0px 10px; }
    .modal-footer .rowbnt { background: #ABABAB; }
    #del {
        width: 32px;
        height: 32px;
        border: 1px solid #dedede;
        border-radius: 3px;
        background: url(<?php echo $this->_theme_url;?>assets/images/del.png) no-repeat center;
        background-size: 17px 17px;
        float: right;
        margin-right: 0px;
        margin-left: 13px;
    }

</style>
    <div class="ad-app-list w1000 clearfix bxbg mgt30">
       
        
        <div class="clearfix ad-alltit mgb30 mgt30">
            
            <div class="fl ad-alltit-left">
                <i><img src="<?php echo $this->_theme_url; ?>assets/images/ad-tit-icon-yingyong.png"/></i>
                <span>应用管理</span>
            </div>
            
            
            <div class="fr ad-alltit-right clearfix">
                
                
                <div class="ad-alltit-rightnav fr">
                    <a href="javascript:window.history.go(-1);" class="a1" title="返回上一级"></a>
                    <a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" class="a2" title="添加应用"></a>
                </div>
 
            </div>
            
            
            
        </div>


        <?php

            if(empty($datalist)){
        ?>

        <div class="ad-nodata w1000 mgb30 mgt30">
            
            <img src="<?php echo $this->_theme_url; ?>assets/images/ad-nodata-bg.png"/>
            <p>噢噢，还没有记录！！！</p>
            <a href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>" class="linear adbtn">创建应用</a>
        </div>
            
        <?php
            }else{
        ?>
        <!--没有记录的情况-->
        
        <!--tit end-->
        <div class="ad-app-list1">

        <?php foreach ($datalist as $k => $v) {?>


            <div class="ad-app-listdiv clearfix linear">
                <div class="fl ad-app-listdiv-fl">
                    <?php  if($v['wechat_url']){?>
                    <img  src="<?php echo  JkCms::show_img($v['wechat_url'])?>">

                <?php }else{?>
                    <img  src="<?php echo $this->_theme_url.'assets/images/1556c138f70cd73.png'?>">

                <?php  }?>
                </div>
                <div class="ad-app-listdiv-fr">
                    <div class="ad-app-listdiv-fr1">
                        <div class="fl">
                            <div class="fl ad-app-list-icontit">
                                <i class="icon1"></i> 运行状态：
                            </div>
                            <div class="ad-app-listdiv-run ad-app-list-mgf">
                                    <?php if($v['status']==1){ ?>
                                                <i class="r1">正在运行</i>
                                    <?php }else{ ?>
                                                <i class="r2">待审核</i>
                                     <?php }?>
                            </div>
                        </div>
                        <div class="fr">
                            <div class="fl ad-app-list-icontit">
                                <i class="icon2"></i> 创建时间：
                            </div>
                            <div class="ad-app-list-time ad-app-list-mgf"><?php echo date('Y-m-d H:i:s',$v['createtime']); ?></div>
                        </div>
                    </div>
                    <div class="ad-app-listdiv-fr1 clearfix">
                        <div class="fl">
                            <div class="fl ad-app-list-icontit">
                                <i class="icon3"></i> 应用名称：
                            </div>
                            <div class="ad-app-listdiv-tit ad-app-list-mgf">
                                <i><?php echo $v['name']; ?></i>
                            </div>
                        </div>
                    </div>
                    <div class="ad-app-listdiv-fr1 ad-app-listdiv-fr1-3 clearfix">
                        <div class="fl">
                            <div class="fl ad-app-list-icontit">
                                <i class="icon4"></i> 应用数据：
                            </div>
                            <div class="ad-app-list-mgf">
                                <div class="ad-app-listdiv-data">
                                    <div class="ad-app-listdiv-datanav">
                                        <ul>
                                            <li class="selected">昨日数据</li>
                                            <li>今日数据</li>
                                            <li>本周数据</li>
                                        </ul>
                                    </div>
                                    <div class="ad-app-listdiv-datadiv">
                                        <div class="datadiv1">
                                            <ul>
                                                <li>
                                                    <p>新增用户数</p>
                                                    <em><?php echo isset($v['adduser_yesterday'])?$v['adduser_yesterday']:0;?></em>
                                                </li>
                                                <li class="midd">
                                                    <p>独立访客数（UV）</p>
                                                    <em><?php echo isset($v['uv_yesterday'])?$v['uv_yesterday']:0;?></em>
                                                </li>
                                                <li>
                                                    <p>浏览量（PV）</p>
                                                    <em><?php echo isset($v['pv_yesterday'])?$v['pv_yesterday']:0;?></em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="datadiv1" style="display: none;">
                                            <ul>
                                                <li>
                                                    <p>新增用户数</p>
                                                    <em><?php echo isset($v['adduser_today'])?$v['adduser_today']:0;?></em>
                                                </li>
                                                <li class="midd">
                                                    <p>独立访客数（UV）</p>
                                                    <em><?php echo isset($v['uv_today'])?$v['uv_today']:0;?></em>
                                                </li>
                                                <li>
                                                    <p>浏览量（PV）</p>
                                                    <em><?php echo isset($v['pv_today'])?$v['pv_today']:0;?></em>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="datadiv1" style="display: none;">
                                            <ul>
                                                <li>
                                                    <p>新增用户数</p>
                                                    <em><?php echo isset($v['adduser_week'])?$v['adduser_week']:0;?></em>
                                                </li>
                                                <li class="midd">
                                                    <p>独立访客数（UV）</p>
                                                    <em><?php echo isset($v['uv_week'])?$v['uv_week']:0;?></em>
                                                </li>
                                                <li>
                                                    <p>浏览量（PV）</p>
                                                    <em><?php echo isset($v['pv_week'])?$v['pv_week']:0;?></em>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ad-app-listdiv-fr1 ad-app-listdiv-fr1-4 clearfix">
                        <div class="fl">
                            <div class="fl ad-app-list-icontit">
                                <i class="icon5"></i> 快捷操作：
                            </div>
                            <div class="ad-app-listdiv-opt ad-app-list-mgf">
                                <a class="c1 linear" onclick="checkStatus('<?php echo $v['status'];?>','<?php echo $this->createUrl('/project/appmgt',array('id'=>$v['id'])); ?>',<?php echo $v['id'];?>)" href="#">应用数据</a>
                                <a class="c2 linear" onclick="checkStatus('<?php echo $v['status'];?>','<?php echo $this->createUrl('/project/activityall',array('pid'=>$v['id'])); ?>',<?php echo $v['id'];?>)" href="#">活动组件</a>
                                <a class="c3 linear" href="<?php echo $this->createUrl('project/appinfo/',array('id'=>$v['id'])); ?>">应用配置</a>
                                <a  onclick="delActivity(<?php echo $v['id']?>)" class="a1" id="del" title="删除"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--list right end-->
            </div>


            
        <?php } ?>  
        </div>
        <!--list end-->


            <div class="pages cl">
                <?php
                $this->widget('CLinkPager', array('pages' => $pagebar,
                        'cssFile' => false,
                        'header'=>'',
                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                        'prevPageLabel' => '前一页',
                    )
                );
                ?>
            </div>
        </div>

        <?php
            }
        ?>
    </div>
<?php echo $this->renderpartial('/common/footer'); ?>




    <!--login-->
    <div class="op-mask"></div>
    <div class="op-login-div" style="padding: 20px 40px; z-index: 999; display: none;">
        
        <form>
           
           <div class="op-login-tit">
            <img src="images/login-div-txt.png">
           </div>
        
        <div class="op-login-input">
            <input type="text" id="uname" placeholder="请输入用户名/手机号" value="">
        </div>
         
         <div class="op-login-input">
            <input type="password" id="upwd" placeholder="请输入密码">
         </div>
         
         <div class="op-login-error" style="margin: 5px auto;"></div>
         
         <div class="op-login-reg clearfix">
                <span class="fl"><input type="checkbox" checked="checked" name="regname" id="regname" value="1"><label for="regname">记住账号</label></span>
                <span class="fr"><a href="/member/findPass">忘记密码</a></span>
            </div>
            
          <div class="op-login-dlbtn">
            <a id="loginbtn">登录</a>
          </div>
  
          <div class="op-login-dlbtn op-login-regbtn">
            <a href="/member/regone">注册</a>
          </div>
          

        </form>
    </div>

<div class="kfpop-mask" style="display: none;">

    <div class="kfpop-div">
        <div class="modal-header clearfix">
            <div class="modal_title">获取代码</div>
            <div class="modal_close" onclick='$(".kfpop-mask").hide()'>点击关闭</div>
        </div>
        <div class="modal-body">
            <div class="text">将内容复制到网站首页head内，点击确认进行验证</div>
            <textarea class="input_text span70 textarea_text" name="log_text" id="log_text"></textarea>
            <input name="button" onclick="Copy()" type="button" class="btn btn-green big" id="getcode" value="复制代码">
            <span class="copy_ok" id="copy_ok"></span>

        </div>
        <div class="modal-footer">
            <button id="modeal_ok" class="btn bnt51a35"  onclick="yanzheng()" type="submit">验证</button>
            <button id="modeal_cancel" onclick='$(".kfpop-mask").hide()' class="btn rowbnt" type="submit">取消</button>
        </div>
    </div>




</div>
<script>

    function delActivity(fid){
        layer.confirm('确认要删除该项目吗？', {
            btn: ['确定','取消']
        }, function(){
            $.post('<?php echo $this->createUrl('/project/delete')?>', { fid: fid }, function (data,status) {
                if(data.errorcode == 1){
                    layer.msg('删除成功！', {icon: 1});
                    setTimeout(function(){ window.location.reload();},300);
                }
                else if(data.errorcode == 0){
                    layer.msg('删除失败', {icon: 1});
                }
                else{
                    layer.msg('系统错误...', {icon: 1});
                }
            },'json');
        });return;

    }



    function checkStatus(appstauts,url,pid){
        var pid=pid;
        var nr="dcw_"+pid;
        if(appstauts==0){
            $("#modeal_ok").attr("pid",pid);
            $("#log_text").html('<meta name="dachuw" content="'+nr+'">');
            $(".kfpop-mask").show();
        }else{
            window.location.href=url;
        }
    }

    function Copy(id){
        var e=document.getElementById("log_text");
        var c=document.getElementById("copy_ok");
        e.select();
        document.execCommand("Copy");
        c.innerHTML="复制成功！";
        c.style.display="inline";
    }

    function yanzheng(){
        var pid=$("#modeal_ok").attr("pid");
//        alert($("#modeal_ok").attr("pid"));
        $.ajax({
            url:'<?php echo $this->createUrl("/project/addrtest"); ?>',
            data:{id:pid},
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
                $('.save_button').attr('onclick','javascript:void(0)');
            },
            success : function (data) {
                if(data.code==200){
                    console.log(data.msg);
                    location.reload();
                }else{
                    console.log(data.msg);
                }

            }
        });
    }
</script>