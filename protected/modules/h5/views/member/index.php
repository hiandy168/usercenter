<?php echo $this->renderpartial('/common/header1', $config); ?>

<div class="div-main">

    <div class="u-top">
        <img class="bg" src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-bg.png"/>

        <?php /*?><div class="u-top-icon1">
               	<a href="<?php echo $this->createUrl('/h5/member/msg'.$param); ?>">
               		<img src="<?php echo $this->_theme_url;?>assets/h5/1.1/images/user-icon4.png"/>
               		<i><?php echo $count?$count:0; ?></i>
               	</a>
          	</div><?php */ ?>

        <div class="u-top-icon2">
            <?php if (Mod::app()->session['app']['status'] == 0) { ?>
                <a href="/h5/member/login"><img
                        src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon5.png"/></a>

            <?php } else { ?>
                <a href="<?php echo $this->createUrl('/h5/member/updateInfo' . $param) ?>"><img
                        src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon5.png"/></a>
            <?php } ?>
        </div>

        <div class="u-top-left">
	          	    <span class="img">
	          	    	<em>

                            <?php if ($member->headimgurl) { ?>
                                <img width="54px" height="54px"
                                     src="<?php echo JkCms::show_img(str_replace("/data", "data", $member->headimgurl)); ?>"
                                     alt="">
                            <?php } else { ?>
                                <img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-test1.png"/>
                            <?php } ?>
                        </em>
	          	    </span>


            <?php if ($member) {
                $username = $member->name;
                if (!$member->name) {
                    $username = $member->username;
                }
                ?>
                <!--未登录的情况-->
                <span class="login">
						    	<p>
                                    <?php echo $username ?><br/>
                                    积分：<?php echo $member->points ? $member->points : 0; ?>
                                </p>
                    <?php if (Mod::app()->session['app']['status'] == 0) { ?>
                        <a href="/h5/member/login">赚积分</a>
                    <?php } else { ?>
                        <a href='/h5/member/point<?php echo $param ?>'>赚积分</a>
                    <?php } ?>
						    </span>
                <?php
            } else { ?>

                <!--登录的情况-->
                <span class="reg">
						<p>
                            手机注册新用户
                        </p>
						<em>注册就送100积分</em><br/>
						<a href='/h5/member/login<?php echo $param ?>'>登录</a>/<a
                        href='/h5/member/login<?php echo $param ?>'>注册</a>
					</span>
            <?php } ?>


        </div>

        <!-- <div class="u-top-img">
          		<span>
          			<em>
					<?php if ($member->com_url) { ?>
						<img src="<?php echo $member->com_url; ?>" alt="">
					<?php } else { ?>
          				<img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-test1.png"/>
					<?php } ?>
          			</em>
          		</span>

          		<p>
					<?php if ($member) {
            $username = $member->username;
            if (!$member->username) {
                $username = $member->name;
            }
            echo "<a  href='/h5/member/updateInfo{$param}'>$username</a>";
        } else {
            echo "<a  href='/h5/member/login{$param}'>未登陆，点击登陆</a>";
        }
        ?>
          			<br/><a href='<?php echo $jfshop; ?>b2c/wap/account/order_jf.html' >积分：<?php echo $member->points ? $member->points : 0; ?></a>
          		</p>
          	</div> -->

    </div>
    <!--u topend-->


    <div class="u-mid clearfix">
        <ul>
            <li class="bb bt br">
                <i><img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon1-1.png"/></i>
                <a href="<?php echo $this->createUrl('/h5/cityLife/index' . $param); ?>">

					     	<span>
					        <img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon1.png"/>
					     	<p>城市服务</p>
					     	</span>

                </a>
            </li>
            <li class="bb bt br">
                <?php if (!$this->member['id']){ ?>
                <a href="/h5/member/login">
                    <?php }else{ ?>
                    <a href="<?php echo $jfshop; ?>">
                        <?php } ?>
                        <span>
						    <img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon2.png"/>
							<p>积分商城</p>
							</span>

                    </a>
            </li>
            <li class="bb bt">
                <?php if (Mod::app()->session['app']['status'] == 0){ ?>
                <a href="/h5/member/login">
                    <?php }else{ ?>
                    <a href="<?php echo $this->createUrl('/h5/calendar/index' . $param) ?>">
                        <?php } ?>
                        <span>
							<img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon3.png"/>
							<p>日历</p>
							</span>

                    </a>
            </li>
        </ul>

    </div>

    <div class="u-like bb bt clearfix">
        <h2>猜你喜欢</h2>
        <a><img src="<?php echo $this->_theme_url; ?>assets/h5/1.1/images/user-icon6.png"/></a>
    </div>

    <div class="u-like1 clearfix">
        <ul>
            <li>
	    				<span><?php if (Mod::app()->session['app']['status'] == 0){ ?>
                            <a href="/h5/member/login">
                                <?php }else{ ?>
                                <a href="/jfshop/b2c/wap/product/detail/id/<?php echo $love_shop[0]['product_id'] ?>.html">
                                    <?php } ?>
                                    <img src="/jfshop/<?php echo $love_shop[0]['l_url'] ?>"/></a>
						</span>
            </li>
            <li>
                <?php
                if (!empty($love_shop)) {
                    unset($love_shop[0]);
                    foreach ($love_shop as $key => $value) {
                        if (Mod::app()->session['app']['status'] == 0) {
                            $href = '<a href="/h5/member/login">';
                        } else {
                            $href = '<a href="/jfshop/b2c/wap/product/detail/id/' . $value['product_id'] . '.html">';
                        }
                        echo '<span>' . $href . '<img src="/jfshop/' . $value['l_url'] . '"/></a></span>';
                    }
                }

                ?>
            </li>
        </ul>
    </div>

    <!--u mid-->

    <div class="u-bot">
        <ul>
            <li class="bb bt">
                <?php if (!$this->member['id']){ ?>
                <a href="/h5/member/login">
                    <?php }else{ ?>
                    <a href="<?php echo $this->createUrl('/h5/member/activity' . $param) ?>">
                        <?php } ?>
                        <h5>我的活动</h5>
                        <i class="btnmore">查看详细</i>
                    </a>
            </li>
            <!--	<li class="bb bt">

					<?php /*if( Mod::app()->session['app']['status'] ==0){*/ ?>
						<a href="/h5/member/login">
						<?php /*}else{*/ ?>
						<a href="<?php /*echo $this->createUrl('/h5/member/prize'.$param)*/ ?>">
					<?php /*}*/ ?>
						<h5>我的奖品</h5>
	    				<i class="btnmore">查看详细</i>
	    			</a>
	    		</li>-->
            <li class="bb bt">
                <?php if (!$this->member['id']){ ?>
                <a href="/h5/member/login">
                    <?php }else{ ?>
                    <a href="/jfshop/b2c/wap/account/order_jflog.html">
                        <?php } ?>
                        <h5>我的积分</h5>
                        <i class="btnmore">查看详细</i>
                    </a>
            </li>
        </ul>

    </div>

</div>

<script type='text/javascript'>
    /*个人中心首页底部banner*/
    var cpro_id = 27;
</script>
<script type='text/javascript' src='http://ads.dachuw.com/js/front/ads.js'></script>

</body>
</html>
<?php echo exit; ?>
