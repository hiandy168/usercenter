<?php echo $this->renderpartial('/common/header1',$config); ?>

		<div class="div-main">
             
			<!--<div class="top-title clearfix">
				<a class="lefta fl" href="javascript:window.history.go(-1);">赚积分</a>
			</div>-->

			<div class="zjf-top">
				<img class="bg" src="/assets/images/jf-img7.jpg" width="100%" />
   
			    <div class="zjf-top1">
			    <span>
				<?php if($this->member['headimgurl']){?>
					<em><img src="<?php echo $this->member['headimgurl']?>"/></em>
				<?php }else{?>
					<em><img src="<?php echo $this->_theme_url;?>assets/h5newstyle/images/user-test1.png"/></em>
				<?php }?>
				</span>
			    <span>
			    	<p><?php echo $this->member['username'] ?><br />
			    	积分&nbsp;&nbsp;<?php echo $points; ?>
			    	</p>
			    </span>
				</div>
				
				<div class="zjf-top2">
					<?php if($pccheckid){?>
					<a href="/activity/pccheckin/view/id/<?php echo $pccheckid ?>"></a>
					<?php }else{ ?>
						<a href="javascript:;" id="pccheckid" onclick="alert('还没有创建签到活动！')"></a>
					<?php }?>
				</div>
				
			</div>
			
			
			
			<div class="zjf-task">
				<h3 class="bb bt">官方任务</h3>
				<ul>
					<?php foreach($activity as $k=>$v){?>
					<li class="bb clearfix">
						<div class="zjf-taskdiv">
							<a href="<?php echo $v['url']?>">
							<img src="<?php echo JkCms::show_img($v['image'])?>"/>
							<span>
								<h3><?php echo $v['title']?></h3>
								<p><?php echo $v['describe']?></p>
								<em>奖励<b><?php echo $v['point']?$v['point']:0; ?></b>积分</em>
								<!--<em><?php /*echo $v['rule']*/?></em>-->
							</span>
							<span>
								<!--<i class="i2">已完成</i>-->
								<i class="i1">去做任务</i>
							</span>
							</a>
						</div>
					</li>
					<?php }?>
				</ul>
				
			</div>
			
			<div class="zjf-task">
				<h3 class="bb bt">商家任务</h3>
				<ul>
					<li>
						<span>暂无</span>
					</li>
					<!--<li class="bb clearfix">
						<div class="zjf-taskdiv">
							<a href="">
							<img src="/assets/images/jf-img6.jpg"/>
							<span>
								<h3>去签到的得积分</h3>
								<p>点击签到按钮，领取每日福利</p>
								<em>奖励<b>130</b>积分</em>
							</span>
							<span>
								<i class="i1">去完成</i>
							</span>
							</a>
						</div>
					</li>-->
				</ul>
				
			</div>
			
			

		</div>
	    
	   


	</body>

</html>
<?php exit; ?>