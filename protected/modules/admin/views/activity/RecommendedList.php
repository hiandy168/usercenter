<style>
    .dail-upimgl {
        position: relative;
        width: 80px;
        height: 80px;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #dedede;
    }
    .dail-upimgl:before {
        content: "";
        display: block;
        width: 40px;
        height: 0px;
        position: absolute;
        border: 2px solid #ddd;
        top: 50%;
        left: 50%;
        margin-top: -1px;
        margin-left: -20px;
    }
    .dail-upimgl:after {
        content: "";
        display: block;
        width: 0px;
        height: 40px;
        position: absolute;
        border: 2px solid #ddd;
        top: 50%;
        left: 50%;
        margin-top: -20px;
        margin-left: -1px;
    }

</style>
<script src="<?php echo $this->_siteUrl?>/themes/new/assets/js/main.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_siteUrl?>/themes/new/assets/js/layer/layer.js" type="text/javascript"></script>
<script src="<?php echo $this->_siteUrl?>/themes/new/assets/js/validate.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $this->_siteUrl?>/themes/new/assets/js/jqueryform.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
    var Siteurl = "<?php echo $this->_siteUrl; ?>";
</script>

<div class='bgf clearfix'>

        <div class="center_top clearfix">
            <form action="" method="post">
            <span>项目</span>
            <select name="project" id="project">
                <option value="">全部</option>
                <?php foreach ($project as $k => $v) { ?>
                    <option value="<?php echo $v->id ?>" <?php if ($v->id == $projectid) {
                        echo "selected";
                    } ?>><?php echo $v->name ?></option>
                <?php } ?>
            </select>

            <span>活动组件</span>
            <select name="activity">
                <option value="2" <?php if ($activityid == 2) {
                    echo "selected";
                } ?>>刮刮卡
                </option>
                <option value="1" <?php if ($activityid == 1) {
                    echo "selected";
                } ?>>签到
                </option>

                <option value="4" <?php if ($activityid == 4) {
                    echo "selected";
                } ?>>投票
                </option>
                <option value="5" <?php if ($activityid == 5) {
                    echo "selected";
                } ?>>大转盘
                </option>
                <option value="6" <?php if ($activityid == 6) {
                    echo "selected";
                } ?>>海报
                </option>
            </select>
            <span>标题</span>
            <input type="text" name="title" value="<?php echo $title?>" placeholder="请输入标题">
            <input type="submit" class="button" value="查找">
            <input type="button" onclick="chooes()" class="button" value="全部列表">
        </div>
    </from>


        <div class="clearfix"></div>
        <div class="list">
            <form name="list_frm" id="form_shareimg" action=""method="POST" enctype="multipart/form-data">
                <table width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th style='width:50px;text-align:center'>id</th>
                        <th>标题</th>
                        <th>类型</th>
                        <th>项目</th>
                        <th>描述</th>
                        <th>活动图片</th>
                        <th>列表图片</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                        <th>状态</th>
                        <th>操作</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list as $k => $item) { ?>
                        <tr id="list_<?php echo $item['id'] ?>">

                            <td style='width:50px;text-align:center'><?php echo $item['id'] ?></td>
                            <td><?php echo $item['title'] ?></td>
                            <td>
                                <?php echo $item['type'][0];
                                $type = $item['type'][1] ?>
                            </td>
                            <td><?php echo $item['project'] ?></td>
                            <td><?php echo $item['describe'] ?></td>
                            <td><img width="80px" height="80px" src="<?php echo JkCms::show_img($item['image']) ?>"
                                     alt="活动图片"/></td>
                            <td class="thumb" width="80" >
                                <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic_save('img_thumb<?php echo $item['id'] ?>','picture<?php echo $item['id'] ?>',<?php echo $item['id'] ?>)"  src="<?php  echo isset($view['picture'])?(Tool::show_img($view['picture'])):(Tool::show_img(''))?>" width="80" height='80' width="80" id="img_thumb<?php echo $item['id'] ?>">
                                <input type="hidden" name="picture"  id="picture<?php echo $item['id'] ?>"  value="<?php echo  isset($view['picture']) ? $view['picture'] : ''; ?>">
                                <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                                    <span  class="btn btn-danger" onclick="upload_pic_save('img_thumb<?php echo $item['id'] ?>','picture<?php echo $item['id'] ?>',<?php echo $item['id'] ?>)"><?php echo Mod::t('admin','upload_pic')?></span>
                                </p>
                            </td>

                            <td><?php
                                if (!empty($item['start_time'])) {
                                    echo date('Y-m-d H:i:s', $item['start_time']);
                                }
                                ?></td>
                            <td><?php
                                if (!empty($item['end_time'])) {
                                    echo date('Y-m-d H:i:s', $item['end_time']);
                                }
                                ?></td>
                            <td><?php echo $item['status'] == 1 ? '已推荐' : '未推荐'; ?></td>
                            <td>
                                <!--                                        <a href="http://<?php /*echo $_SERVER['HTTP_HOST'] */ ?>/activity/<?php /*echo $type*/ ?>/view/id/<?php /*echo $item['id']*/ ?>">预览</a>&nbsp;|&nbsp;-->

                                <?php if ($item['status'] == 1) { ?>
                                    <a href="javascript:;" onclick="recommend(<?php echo $item['id']; ?>,2);">取消推荐</a>
                                <?php } else { ?>
                                    <a href="javascript:;" onclick="recommend(<?php echo $item['id']; ?>,1);">推荐</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

                <div class="pages clearfix">
                    <?php
                    /* $this->widget('CLinkPager', array('pages' => $pagebar,
                                                    'cssFile' => false,
                                                    'header'=>'',
                                                    'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                    'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                    'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                    'prevPageLabel' => '前一页',
                                                        )
                    ); */
                    ?></div>
            </form>
        </div>


</div>
<script type="text/javascript">
    function save(){
        console.log(123);
    }
</script>
<script>
    function chooes() {
            window.location.href = '<?php echo $this->createUrl('activity/recommendedlist')?>';

    }

    function recommend(id, isStar) {
        var project = $('#project').val();
        $.ajax({
            type: "get",
            url: "<?php echo $this->createUrl('activity/recommende')?>",
            data: {
                "id": id,
                "aid":<?php echo intval($activityid)?>,
                "isstar": isStar,
                "project": project
            },
            success: function (msg) {
                //  alert(msg);
                if (msg == 'ok') {
                    alert("推荐成功");
                    window.location.reload();
                    return false;
                } else if (msg == 2) {
                    alert("取消成功");
                    window.location.reload();
                    return false;
                } else {
                    alert("失败了");
                    return false;
                }
            }
        });

    }

</script>