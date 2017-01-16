<?php $this->renderPartial('/common/header',array('config'=>$config));?>
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
       		
        <a class="nav_on" href="<?php echo $this->createUrl('/member');?>">
            <span class="nav_icon1"></span><span class="nav_text">我的名片</span>
        </a>

        <a class="nav_off" href="<?php echo $this->createUrl('/member/msg');?>">
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
        <div class="user_center_h1">我的名片</div>

<style>
.quxiao,.wait_sign_quxiao{color:#3479c7;font-size: 14px; background: none; border: none;}
.ok {z-index:9999;}
.ok p {width:320px;height:50px;line-height:50px;text-indent:70px;font-size:22px;color:#fff;background:#333 url("/images/ok.png") no-repeat 20px 8px;}
.clear {clear:both;height:20px;}
</style>
<div class="user_center_order_list">
    <div class="my_infodetail">
						<h3>联系方式  <a class="zhuyu_lianxi" href="javascript:void(0);">修改</a></h3>
						<div class="my_detail clearfix">
							<span class="floter">手机：15997567510 </span> 
							<span class="rightor">微信： </span>   
                            <span class="floter">邮箱： </span>                                                 
                            <span class="rightor">QQ： </span> 
						</div>
						<h3>供应 / 求购  <a class="gong" href="javascript:void(0);">修改</a></h3>
						<div class="my_detail clearfix">
							<span>写下您的商业需求，合作伙伴可能会找上门哦</span>                                                                
						</div>
						<h3>公司介绍  <a class="gongsiend" href="javascript:void(0);">修改</a></h3>
						<div class="my_detail clearfix">
							<span>公司网址：<br>展示您的企业形象的绝佳机会</span>                                                     
						</div>

        <div class="my_detail clearfix">
        <a class="nav_off" href="<?php echo $this->createUrl('/project');?>">
            <span  style="font-size:20px;color:blue;font-weight:bold;" class="nav_text">创建项目</span>
        </a>
        </div>
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




<div class="layer-mask"></div>

    </div>

    <div style="clear:both"><!----></div>
</div>

</div>

<?php $this->renderPartial('/common/footer',array('config'=>$config));?>
