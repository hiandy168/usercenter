<?php echo $this->renderpartial('/common/header_1',$config); ?>

<script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/js/echarts.min.js"></script>

<!-- 数据分析 start -->
<div class="data_analysis w960 clearfix">
    <div class="left">
        <a href="<?php echo $this->createUrl('/behavior/index',array('id'=>$pid))?>"><div class="icon icon1">应用趋势</div></a>
        <a href="<?php echo $this->createUrl('/behavior/userBehavior',array('id'=>$pid))?>"><div class="icon icon1">用户分析</div></a>
        <!-- //报名列表 -->
        <?php foreach($signUp as $v){ ?>
        <a href="<?php echo $this->createUrl('/activity/signup/list',array('pid'=>$pid,'sid'=>$v->id,'day'=>isset($_GET['day'])?$_GET['day']:''))?>"><div class="icon icon1 <?php if($sid==$v->id)echo 'on1';?>"><?php echo $v->title; ?></div></a>
        <?php } ?>
        <!-- //活动列表 -->
        <?php foreach($asList as $list):?>
        <a href="<?php echo $this->createUrl('/behavior/view',array('fid'=>$list->FID,'id'=>$pid))?>"><div class="icon icon1 <?php if($fid==$list->FID)echo 'on1';?>"><?php echo $list->FTitle?></div></a>
       <?php endforeach;?>
    </div>
    <div class="right">
        <div class="title_wrap clearfix">
            <div class="title icon1">
            </div>
            <div class="search">

            </div>
        </div>
        <div class="date_wrap clearfix">


            <div class="content content1">
                <style type="text/css">
                    .content_table {
                        width: 100%;
                        border-collapse: collapse;
                        /* 关键属性：合并表格内外边框(其实表格边框有2px，外面1px，里面还有1px哦) */
                        /*border: solid #999;*/
                        /* 设置边框属性；样式(solid=实线)、颜色(#999=灰) */
                        /*border-width: 1px 0 0 1px;*/
                        /* 设置边框状粗细：上 右 下 左 = 对应：1px 0 0 1px */
                    }
                    thead{
                        color: #fff;
                        background-color: #888;
                        height: 35px;
                        line-height: 35px;
                    }
                    .content_table td {
                        height: 58px;
                        line-height: 58px;
                        text-align: center;
                        border-bottom: 1px solid #1399e5;
                    }

                    .content_table .no1 {
                        width: 120px;
                    }

                    .content_table .no2 {
                        width: 220px;
                    }

                    .content_table .no3 {
                        width: 120px;
                    }

                    .content_table .no4 {
                        width: 190px;
                    }

                    .content_table .no5 {
                        width: 100px;
                    }
                    .content_table .no6 {
                        width: 180px;
                    }
                </style>
                <div class="date" style="margin-bottom: 15px;width: 500px;">
                    <div class="day <?php if($_GET['day'] == 1){echo 'on';}?>"><a href="<?php echo $this->createUrl('/activity/signup/list',array('day'=>'1','pid'=>$pid,'sid'=>isset($_GET['sid'])?$_GET['sid']:'')); ?>">今天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 2){echo 'on';}?>"><a href="<?php echo $this->createUrl('/activity/signup/list',array('day'=>'2','pid'=>$pid,'sid'=>isset($_GET['sid'])?$_GET['sid']:'')); ?>">昨天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 7){echo 'on';}?>"><a href="<?php echo $this->createUrl('/activity/signup/list',array('day'=>'7','pid'=>$pid,'sid'=>isset($_GET['sid'])?$_GET['sid']:'')); ?>">7天</a></div>
                    <div class="day <?php if(isset($_GET['day']) && $_GET['day'] == 30){echo 'on';}?>"><a href="<?php echo $this->createUrl('/activity/signup/list',array('day'=>'30','pid'=>$pid,'sid'=>isset($_GET['sid'])?$_GET['sid']:'')); ?>">30天</a></div>
                    <div class="long_day">
                        <div class="time">2016-04-10至2014-06-28</div>
                    </div>
                    <div class="day <?php if(!isset($_GET['day']) || $_GET['day'] == ''){echo 'on';}?>" style="margin-left: 40px;"><a href="<?php echo $this->createUrl('/activity/signup/list',array('day'=>'','pid'=>$pid,'sid'=>isset($_GET['sid'])?$_GET['sid']:'')); ?>">全部</a></div>
                </div>
                <table class="content_table">
                    <thead>
                    <tr>
                        <th>用户名</th>
                        <th>手机号</th>
                        <th>状态</th>
                        <th>时间</th>
                    </tr>
                    </thead>

                    <?php foreach ($lists as $k => $v) {?>
                        <tr>
                            <td class="no1"><?php echo $v['username']?$v['username']:$v['name']; ?></td>
                            <td class="no2"><?php echo $v['phone']; ?></td>
                            <td class="no3"><?php echo $v['status']; ?></td>
                            <td class="no6"><?php echo date('Y-m-d H:i:s',$v['createtime']); ?></td>

                        </tr>
                    <?php } ?>
                </table>
                <div class="pages cl">
                    <?php
                    $this->widget('CLinkPager', array('pages' => $pages,
                            'cssFile' => false,
                            'header'=>'<span style="float: right;margin: 0 2px;line-height: 28px;height: 28px;">总条数:'.$count.'</span>',
                            'firstPageLabel' => '首页', //定义首页按钮的显示文字
                            'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                            'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                            'prevPageLabel' => '上一页',
                            'maxButtonCount'=>8,
                        )
                    );
                    ?>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- 数据分析 end -->
<!-- 底部样式 start -->
<div class="foot">
    <div class="w980">
        <ul class="clearfix">
            <?php $friendlinks = JkCms::getFriendlink(3); ?>
        <?php if($friendlinks){$i=1;foreach ($friendlinks as $f) { ?>
                <li><a href="<?php echo $f['url'] ?>" title="<?php echo $f['title'] ?>" target="_blank"><?php echo $f['title'] ?></a></li>
        <?php }}?>
        </ul>
        <div class="copy_right copy_right1">
            Copyright © 1998 - 2016 Tencent. All Rights Reserved.
        </div>
        <div class="copy_right copy_right2">
            腾讯·大楚网 版权所有
        </div>
    </div>
</div>
</body>

</html>
