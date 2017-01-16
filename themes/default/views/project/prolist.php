<?php  echo $this->renderpartial('/common/header_new',$config); ?>
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

    </style>
<div class="new_wrap clearfix">

    <?php echo $this->renderpartial('/common/left_new'); ?>

    <div class="right">
        <div class="table_content" style="">
                        <div class="content application_app_info" style='margin:0 10px;'>
            

        <h2>我的应用 <a class="fr" href="<?php echo $this->createAbsoluteUrl('/project/createpro'); ?>"><span></span>添加应用</a></h2>
        <div class="application_list_cont">
        	  <?php foreach ($datalist as $k => $v) {?>
			<a class="my_application clearfix" onclick="checkStatus('<?php echo $v['status'];?>','<?php echo $this->createUrl('/project/appmgt',array('id'=>$v['id'])); ?>',<?php echo $v['id'];?>)" href="#">
			<div class="my_application_l fl">
                <?php  if($v['wechat_url']){?>
                    <img width="100" height="100" style="border-radius:20px" class="fl" alt="" src="<?php echo  JkCms::show_img($v['wechat_url'])?>">

                <?php }else{?>
                    <img width="100" height="100" style="border-radius:20px" class="fl" alt="" src="<?php echo $this->_theme_url.'images/my_application_icon_1.png'?>">

                <?php  }?>

				<div class="my_application_cont fl">
					<h3 style="color: #29b6b0;"><?php echo $v['name']; ?></h3>
					<p><span>运行状态：</span> <label class="not_open">  
                                            <?php if($v['status']==1){ ?>
                                                正在运行
                                            <?php }else{ ?>
                                                未审核
                                            <?php }?>
                                              
                                            </label></p>
                                        <p><span>创建时间：</span><?php echo date('Y-m-d H:i:s',$v['createtime']); ?></p>
				</div>
			</div>
			<table class="fr application_data">
					<thead>
						<tr>
							<th width="66"></th>
							<th width="77">用户数</th>
<!--							<th width="118">消耗积分</th>-->
<!--							<th width="109">产生的积分</th>-->
							<th width="68">UV</th>
							<th width="100">PV</th>
							<th width="20"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><span>昨日</span></td>
                                                        <?php if($v['id']==1){?>
							<td>865</td>
                                                        <?php }else{ ?>
                                                        <td><?php echo isset($v['z_counts'])?$v['z_counts']:0;?></td>
                                                        <?php }?>
                            <td>0</td>
                            <td>0</td>
<!--							<td>--><?php //echo rand(1,10000);?><!--</td>-->
<!--							<td>--><?php //echo rand(1,10000);?><!--</td>-->
							<td></td>
						</tr>
						<tr>
							<td><span>本周</span></td>
                                                        <?php if($v['id']==1){?>
							<td>665</td>
                                                        <?php }else{ ?>
                                                        <td><?php echo isset($v['w_counts'])?$v['w_counts']:0;?></td>
                                                        <?php }?>
							
							<td>0</td>
							<td>0</td>
							<!--<td><?php /*echo rand(1,100000);*/?></td>
							<td><?php /*echo rand(1,100000);*/?></td>-->
							<td></td>
						</tr>
					</tbody>
				</table>
		</a>
		<?php } ?>	
			
			
        
        </div>
    </div>
        </div>
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


        <div class="content content1">

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
    function del(id){
    	layer.confirm('删除后将不可恢复！确定要删除该项目吗？', function(index){
      		
        	$.ajax({
                url:'<?php echo $this->createUrl("/project/del_project"); ?>',
                data:{id:id},
                dataType:'json',
                type:'post',
                success : function (data) {
                   layer.msg(data.msg,{time:2000},function(){
               	    location.reload();
                   })
                }
            });
  		});   
    }
    function addPro(){
        var name = $('.input_text').val();
        var info = $('.textarea_text').val();
        var url = $('#url').val();
        if(name.trim() == ''){
            layer.msg('应用名不能为空',{icon:5});
            return false;
        }
        if(info.trim() == ''){
            layer.msg('应用简介不能为空',{icon:5});
            return false;
        }
        if(url.trim() == ''){
            layer.msg('URL不能为空',{icon:5});
            return false;
        }
        //验证url
        url = url.trim();
        var strRegex = "^((https|http|ftp|rtsp|mms)://)?[a-z0-9A-Z]{1,3}\.[a-z0-9A-Z][a-z0-9A-Z]{0,61}?[a-z0-9A-Z]\.com|net|cn|cc (:s[0-9]{1-4})?/$";
        var reg = new RegExp(strRegex);
        if(!reg.test(url) ){
            layer.msg('url格式不正确',{icon:5});
            return false;
        }

        var ckbox = $('#inputbox:checked').val();
        if(!ckbox){
            layer.msg('没有同意本站协议',{icon:5});
            return false;
        }

        var attention = $('input[name="Fruit"]:checked').val();
//        alert(attention);
//        return false;
        $.ajax({
            url:'<?php echo $this->createUrl("/project/projectReg",array('id'=>$model->id)); ?>',
            data:{name:name,introduction:info,url:url,attention:attention},
            dataType:'json',
            type:'post',
            beforeSend: function(){  //防止重复提交数据
                $('.save_button').attr('onclick','javascript:void(0)');
            },
            success : function (data) {
                if (data.state == 1) {
                    layer.msg(data.mess,{
                        icon:6,
                        shift: 5,
                        time:1000,
                        end:function(){
                            top.location.href = "<?php echo $this->createUrl('/project/appMgt'); ?>";
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        }
                    });

                } else {
                    layer.msg(data.mess,{icon:5});
                }
            }
        });
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
<?php echo $this->renderpartial('/common/footer', $config); ?>