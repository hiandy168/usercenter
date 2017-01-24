<?php echo $this->renderpartial('/layouts/main',$config); ?>

<div class="div-main">

 <!-- <div class="pos-r bb bgfff f-form-backnav">
    <a href="javascript:history.go(-1)"><i class="icon-left"></i></a>
    <h3 class="fs36">理财产品信息</h3>
  </div>-->


    <div class="f-user-sy bgfff mgt4">
        <div class="f-user-sy1">
            <i class="fs36"><?php echo $moneyinfo['title']?></i>
        </div>
        <div class="f-user-sy2">
            <i class="fs24 fcbbb">最高年化收益率</i>
            <p class="fcf74"><?php echo $moneyinfo['earnings']?></p>
        </div>
    </div>

    <div class="pos-r  bt bgfff bb  f-user-sy3 f-cp-cpjs">
        <ul>
            <li class="br pos-r">
                <i class="fs24 fcbbb">预存周期</i>
                <?php if($moneyinfo['financingid']==1){?>
                <p class="fs36 fcf74"><b class="fs32 pos-r">无限</b></p>
                <?php }else{?>
                <p class="fs36 fcf74"><?php echo $moneyinfo['cycle']?><b class="fs32 pos-r">个月</b></p>
                <?php }?>
            </li>
            <li>
                <i class="fs24 fcbbb">预存金额(元)</i>
                <p class="fs36 fcf74"><?php echo $moneyinfo['figue']?>.00</p>
            </li>
        </ul>

    </div>

    <div class="fs26 f-user-ddlistdiv3 bgfff pos-r bb mgt4"><p>产品介绍</p></div>

    <div class="f-cp-cpjs1 pos-r bb bgfff fs24">
        <?php echo $moneyinfo['details']?>
    </div>



</div>

</body>
<?php echo $this->renderpartial('/layouts/foot'); ?>