<?php $this->renderPartial('/common/header_member',array('config'=>$config));?>

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

        <a class="nav_on" href="<?php echo $this->createUrl('/member/msg');?>">
            <span class="nav_icon4"></span><span class="nav_text">我的私信</span>
        </a>
            
<!--        <a class="nav_off" href="<?php echo $this->createUrl('/member/safe_center');?>">
            <span class="nav_icon3"></span><span class="nav_text">我的人脉</span>
        </a>  -->
            
        <a class="nav_off" href="<?php echo $this->createUrl('/member/safe_change');?>">
            <span class="nav_icon3"></span><span class="nav_text">安全中心</span>
        </a>
              	                <div class="bline"><!----></div>
        </div>

    </div>
	<div class="user_center_right">
        <div class="user_center_h1">我的私信</div>

<style>
.quxiao,.wait_sign_quxiao{color:#3479c7;font-size: 14px; background: none; border: none;}
.ok {z-index:9999;}
.ok p {width:320px;height:50px;line-height:50px;text-indent:70px;font-size:22px;color:#fff;background:#333 url("/images/ok.png") no-repeat 20px 8px;}
.clear {clear:both;height:20px;}
</style>
<div class="user_center_order_list">
    <div class="my_infodetail">
           <?php  if(!empty($list)){?>   
        <?php foreach($list as $r){?>
        <h3>发送人 <?php $member = JkCms::getMemberId($r['send_id']); echo $member['name'];?> <a class="zhuyu_lianxi" href="javascript:void(0);">删除</a></h3>
            <div class="my_detail clearfix">
            <span class="floter"><?php echo $r['title']?></span> 
            <span class="rightor"><?php echo $r['content']?></span>   
            </div>	
           <?php } }else{ ?>
         
            <div class="my_detail clearfix">
              暂时没有您的私信
            </div>	
           <?php } ?>
            
    </div>
    
</div>
<div class="listpage">
<div id="pages" class="pages clearfix">
            <?php if(isset($pagebar)){
            $this->widget('CLinkPager', array('pages' => $pagebar,
                                            'cssFile' => false,
                                            'header'=>'',
                                            'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                            'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                            'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                            'prevPageLabel' => '前一页',
                                                )
            );}
            ?>
</div>
</div>

<div id="order_cancel_reason_options" style='z-index:999;position:fixed; top:200px;left:50%;margin-left:-230px;'>
        <h4 class="cancel_order_title">取消订单</h4>
        <div id="order_cancel_content">
            <p class="reason_desc">您取消订单的原因：</p>
            <ul>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="重新下单">&nbsp;&nbsp;重新下单</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="重新下单">&nbsp;&nbsp;重新下单</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="商品价格较贵">&nbsp;&nbsp;商品价格较贵</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="嫌麻烦">&nbsp;&nbsp;嫌麻烦</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="想试试了解流程">&nbsp;&nbsp;想试试了解流程</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="价格波动">&nbsp;&nbsp;价格波动</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="等待签约时间过长">&nbsp;&nbsp;等待签约时间过长</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="重新考虑">&nbsp;&nbsp;重新考虑</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="选择其他分期产品">&nbsp;&nbsp;选择其他分期产品</li>
                            <li><input type="checkbox" class="cancel_reason_options" name="order_cancel_reason[]" value="不想购买">&nbsp;&nbsp;不想购买</li>
                        </ul>
            <div class="clear"></div>
            <div class="notice">
                <p class="cancel_notice" style="display:block;">*为改进我们的工作，亲，请填写取消原因哦～</p>
            </div>
            <div class="cancel_button">
                <a href="javascript:void(0)" class="buttons" id='clean_yes' data-id="">确认取消</a>
                <a href="javascript:void(0)" class="buttons" id='clean_no'>暂不取消</a>
            </div>
        </div>
    </div>


<div class="layer-mask"></div>

    </div>

    <div style="clear:both"><!----></div>
</div>

</div>
<script> 

</script>
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
