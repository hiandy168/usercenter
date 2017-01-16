<div class="span3">
                                  
					<!--左侧功能开始-->
					<div class="inner_container">
						<!--菜单管理开始-->
						<div class="inner_container_title row-fluid">
							<div class="span4">
								<h5>活动类型</h5>
							</div>
                                                        <div class="span8 text-right">
								<div id="simple_btns" class="right_btns">
                                                                        <a class="blue m-l-10" id="add_menu" href="javascript:void(0)">+ 新增</a>              
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div style="margin-top: 12px;" class="inner_container_box">
							<div id="custom_menu_cont" class="inner_container_list inner_sub_list">	
                                                            
                                                            <!--报名类活动-->
                                                            <dl style="height: 30px;">
                                                            <dt class="active" style="line-height: 30px;"><a furl="" nid="0" type="0" href="javascript:void(0);" class="view">报名类活动</a></dt>
                                                            </dl>	
                                                            <dl class="sort_dl <?php if($type=='scratchcard'){echo 'on';}?>" style="margin:0 20px;line-height: 30px;">
                                                            <dt class="" style="line-height: 30px;"><a furl="" href="<?php echo $this->createUrl("activity/scratchcard/console",array('pid'=>$pid)) ?>" class="view">刮刮卡</a> </dt>
                                                            </dl> 

                                                            
                                                            
                                                          
                                                            

                                                            <!--其他类活动-->
                                                            <dl style="height: 30px;">
                                                            <dt class="active" style="line-height: 30px;"><a furl="" nid="0" type="0" href="javascript:void(0);" class="view">其他类活动</a></dt>
                                                            </dl>
                                                            <dl class="sort_dl" style="margin:0 20px;line-height: 30px;">
                                                            <dt class="" style="line-height: 30px; font-size:14px;"><a furl="" nid="4746" type="2" href="<?php echo $this->createUrl("activity/checkIn/console",array('pid'=>$pid)) ?>" class="view">签到</a> </dt>
                                                            </dl>
								
								
                           
								
							</div>
							
						</div>
						<!--菜单管理结束-->
                                                <div class="inner_container_title row-fluid">
							<div class="span4">
								<h5>表单填写项</h5>
							</div>
                                                        <div class="span8 text-right">
								<div id="simple_btns" class="right_btns">
                                                                        <a class="blue m-l-10" id="add_menu" href="<?php echo $this->URL('do/inputlist'); ?>">+ 管理</a>              
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--左侧结束-->