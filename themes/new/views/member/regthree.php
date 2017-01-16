<?php echo $this->renderpartial('/common/header_new',$config); ?>
<div class="ad-reg-form w1000 clearfix bxbg mgt30">

    <div class="ad-reg-form-tit clearfix">
        <ul>
            <li>
                第一步：创建用户
                <i></i>
            </li>
            <li>
                第二步：完善信息
                <i></i>
            </li>
            <li class="selected">
                第三步：注册成功
            </li>
        </ul>
    </div>


    <div class="ad-reg-form-success">
        <img src="<?php echo $this->_theme_url?>assets/images/ad-right-icon-big.png"/>

        <p>恭喜你！成功注册大楚开放平台，请等待审核通过</p>

    </div>

</div>

<?php echo $this->renderpartial('/common/footer',$config); ?>