<style>
    .project_list  ul  li{padding:10px 20px;border-bottom: 1px #ccc solid;min-width: 860px;}
    .project_list  .li2{
        background:#e6e6e6;
    }
    .project_list li em {
        color: #c00;
        font-style: normal;
    }
    .project_list li {
        color: #666;
        line-height: 16px;
    }
    .project_list li .ic {
        margin-right: 8px;
    }
    .project_list li a {
        color: #000;
        font-size: 16px;
        text-decoration: none;
    }
    .project_list li a:visited {
        font-size: 16px;
        text-decoration: none;
    }
    .project_list div {
        line-height: 1.6em;

    }
    .project_list div a:hover {
        text-decoration: none;
    }
    .project_list div .summary-box .summary {
        color: #555;
        word-break: break-all;
        word-wrap: break-word;
    }
    .project_list div .summary-box .detail {
        color: #888;
    }
    .project_list div .summary-box .detail .ic {
        height: 12px;
        width: 12px;
    }
    .project_list div .summary-box .detail a.ui-bz-btn-senior {
        color: #fff;
        float: right;
        margin-top: -4px;
        text-decoration: none;
    }
    .project_list div .summary-box .detail a.ui-bz-btn-senior .ui-bz-btn-p-16 {
        font-size: 14px;
        height: 26px;
        line-height: 26px;
    }
    .project_list div .wenku-verify-org {
        cursor: pointer;
        display: inline-block;
        height: 14px;
        padding-right: 20px;
        position: relative;
        vertical-align: -1px;
        width: 16px;
    }
    .project_list div .wenku-verify-user {

        cursor: pointer;
        display: inline-block;
        height: 14px;
        padding-right: 20px;
        position: relative;
        vertical-align: -1px;
        width: 16px;
    }
    .project_list div .info-box {
        height: 122px;
        left: 20px;
        padding: 14px 12px 0 19px;
        position: absolute;
        top: -10px;
        width: 208px;
        z-index: 10;
    }
    .project_list div .info-box .user-img {
        border: 1px solid #d5d5d5;
        display: block;
        margin-right: 10px;
        padding: 2px;
    }
    .project_list div .info-box .org-img {
        border: 1px solid #d5d5d5;
        display: block;
        margin-right: 10px;
        padding: 18px 0;
    }
    .project_list div .info-box .vicon {
        display: inline-block;
        height: 20px;
        vertical-align: middle;
        width: 18px;
    }
    .project_list div .info-box .gicon {
        background-position: 0 0;
    }
    .project_list div .info-box .yicon {
        background-position: -18px 0;
    }
    .project_list div .info-box a {
        color: #434343;
    }
    .project_list div .info-box .info-box-bottom ul li {
        display: block;
        float: left;
        height: 29px;
        text-align: center;
        width: 56px;
    }
    .project_list div .info-box .info-box-bottom ul li p {
        line-height: 12px;
    }
    .project_list div .info-box .info-box-bottom .w59 {
        border-right: 1px dotted #d5d5d5;
        width: 59px;
    }
    .project_list div .info-box .info-box-bottom .w86 {
        border-right: 1px dotted #d5d5d5;
        width: 86px;
    }
    .project_list div .att-doc {
        clear: both;
    }
    .project_list div .att-doc h5 {
        color: #555;
        line-height: 2.8;
    }
    .project_list div .att-doc li {
        margin-bottom: 6px;
    }
    .project_list div .att-doc a {
        display: inline-block;
        height: 19px;
        overflow: hidden;
        width: 500px;
    }
    .project_list div .att-doc li p {
        height: 19px;
    }
    .project_list div .att-doc a, .project_list div .att-doc a:link {
        color: #00c;
    }
    .project_list div .att-doc span {
        color: #888;
    }
    .project_list div .att-doc .toggle-more, .project_list div .att-doc .toggle-more:link, .project_list div .att-doc .toggle-more:hover {
        color: #888;
        cursor: pointer;
        display: block;
        outline: 0 none;
        text-decoration: none;
    }
    .project_list div .att-doc .toggle-more:focus {
        outline: 0 none;
    }
    .project_list div .att-doc .toggle-more .ic {
        background: rgba(0, 0, 0, 0) url("http://static.wenku.bdimg.com/static/wkcore/widget/search/fileList/images/arrow_90640a2.png") no-repeat scroll -14px 0;
        height: 6px;
        vertical-align: middle;
        width: 10px;
    }
    .project_list div .att-doc .toggle-more:hover .ic-arrow {
        background-position: -14px -6px;
    }
    .project_list div .att-doc .toggle-more-up .ic-arrow {
        background-position: 0 0;
    }
    .project_list div .att-doc .toggle-more-up:hover .ic-arrow {
        background-position: 0 -7px;
    }
    .project_list div .att-doc .att-doc-list {
        overflow: hidden;
    }
    .project_list div .att-doc .att-doc-list.folded {
        height: 75px;
    }
    .project_list i {
        font-style: normal;
        font-weight: 400;
        margin: 0 4px;
    }
</style>
<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <?php if (!empty($progect_type_arr)) { ?>
            <div class="center_search" style="width:auto;float:none;margin:5px 20px;">
                <form name="search_frm" action="<?php echo $this->createUrl("project/lists") ?>" id="SearchFrm" method="post"> 
                    <label>标题：</label> <input type="text" name="title"   value="<?php echo isset($s['title']) ? $s['title'] : '' ?>" /> 
                    <label>栏目：</label> 
                    <select name="type_id">
                        <option value=""><?php echo Mod::t('admin', 'select') ?></option>
                        <?php foreach ($progect_type_arr as $progect_type): ?>
                            <option value="<?php echo $progect_type['id'] ?>" <?php if (isset($s['type_id']) && $s['type_id'] == $progect_type['id']): ?>selected<?php endif; ?>><?php echo $progect_type['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>推荐位：</label>
                        <select name="recommend">
                         <option value=""><?php echo Mod::t('admin', 'select') ?></option>
                         <option value="top"  <?php if (isset($s['recommend']) && $s['recommend'] == 'top'): ?>selected<?php endif; ?> >顶置</option>
                         <option value="focus"  <?php if (isset($s['recommend']) && $s['recommend'] == 'focus'): ?>selected<?php endif; ?> >焦距</option>
                         <option value="recommend"  <?php if (isset($s['recommend']) && $s['recommend'] == 'recommend'): ?>selected<?php endif; ?> >推荐</option>
                         <option value="choiceness"  <?php if (isset($s['recommend']) && $s['recommend'] == 'choiceness'): ?>selected<?php endif; ?>  >精选</option>
                         <option value="hot"  <?php if (isset($s['recommend']) && $s['recommend'] == 'hot'): ?>selected<?php endif; ?> >热点</option>
                    </select>
                    
                       <label  style="display:none">状态：</label>
                        <select name="status"  style="display:none">
                         <option value="" ><?php echo Mod::t('admin', 'select') ?></option>
                         <option value="0"  <?php if (isset($s['status']) && $s['status'] == '0'): ?>selected<?php endif; ?> >审核中</option>
                         <option value="1"  <?php if (isset($s['status']) && $s['status'] == '1'): ?>selected<?php endif; ?> >已审核</option>
                         <option value="7"  <?php if (isset($s['status']) && $s['status'] == '7'): ?>selected<?php endif; ?> >否决</option>
                         <option value="8"  <?php if (isset($s['status']) && $s['status'] == '8'): ?>selected<?php endif; ?>  >管理员删除</option>
                         <option value="9"  <?php if (isset($s['status']) && $s['status'] == '9'): ?>selected<?php endif; ?> >用户删除</option>
                    </select>
                    <input type="submit" name="search" class="btn btn-info"  value="搜索" /> 
                </form>           
            </div>  
        <?php } ?>

    </div>



    <div class="clearfix"></div>
    <div class="list">
        <form name="list_frm" id="ListFrm" action="" method="post">
            <div  class="project_list" style="">
                <ul class="clearfix">
                    <?php if (!empty($list)) {
                        foreach ($list as $k => $item) {
                            ?>
                            <li class='clearfix'>
                                <div class='clearfix'>
                                    <div style="float:left;width:100px;"><?php echo $item['id'] ?></div>
                                    <div style="overflow:hidden;">
                                        <!--供求1:40 java供求4:1 进厂(几乎没有要求) 公务员--千军万马 独木桥 选择决定人生你的过去决定了你的今天,但决定不了你的未来,你今天的选择决定了你的...供求1:40 java供求4:1 进厂(几乎没有要求) 公务员--千军万马 独木桥 选择决定人生你的过去决定了你的今天,但决定不了你的未来,你今天的选择决定了你的...供求1:40 java供求4:1 进厂(几乎没有要求) 公务员--千军万马 独木桥 选择决定人生你的过去决定了你的今天,但决定不了你的未来,你今天的选择决定了你的...供求1:40 java供求4:1 进厂(几乎没有要求) 公务员--千军万马 独木桥 选择决定人生你的过去决定了你的今天,但决定不了你的未来,你今天的选择决定了你的...-->

                                        <div class="logFirstClickTime mb6 clearfix" style="margin-bottom:6px;">
                                            <p style="width:90%;float:left">
                                                <span class="ic ic-ppt" title="ppt" style="font-size:16px;color:#00c">
                                                    [<?php echo $progect_type_arr[$item['type_id']]['title'] ?>]
                                                </span>
                                                <a  class="log-xsend tiaoquan" target="_blank" title="" href="<?php echo $this->createUrl("project/edit/", array('id' => $item['id'])) ?>" ><?php echo $item['title'] ?></a>
        <?php if ($item['top']) { ?>顶置<?php } ?>
                                            </p>
                                            <p style="width:10%;float:right">
                                                <span class="ib score" style="font-size:13px">状态:</span>  
                                                <span class="fc99 f18 pr2 ib" style="font-size:14px;color:#995d33">
                                                    <?php 
                                                                            echo     Tool::Project_status($item['status']);
                 
                                                    ?>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="clearfix">
                                            <div class="clearfix" style="width:100%;margin-bottom: 15px;">
                                                <p class="" style="line-height:21px;">
                                                        <?php echo $item['description']; ?>
                                                   </p>
                                            </div>
                                            <div class="clearfix">
                                                <div class="detail" style="line-height:21px;float:left;">
        <?php echo date('Y-m-d H:i:s', $item['createtime']) ?>
                                                    <i>&nbsp;|&nbsp;</i>
        <?php echo $item['hits'] ?>次下载
                                                    <i>&nbsp;|&nbsp;</i>
                                                    发布人：<a target="_blank" class="Author logSend"  href=javascript:void(0)" style="font-size:14px;color:#000"><?php $member = JkCms::getMemberById($item['mid']);
        echo $member['name']
        ?></a>
                                                    <i>&nbsp;|&nbsp;</i>
                                                    发布ip： <?php echo $item['ip'] ?>

                                                </div>
                                                <div class="detail" style="line-height:21px;float:right;">
                                                    <?php if($item['focus']){ ?>
                                                    <a  class="btn btn-danger" title=""  onclick="dofocus('<?php echo $this->createUrl("project/dofocus")?>','<?php echo $item['id'] ?>',0)" href="javascript:void(0);" s style="font-size:14px;text-decoration: none;color:#fff">取消首页聚焦</a>
                                                    <?php }else{ ?>
                                                    <a  class="btn btn-danger" title=""  onclick="dofocus('<?php echo $this->createUrl("project/dofocus")?>','<?php echo $item['id'] ?>',1)" href="javascript:void(0);" s style="font-size:14px;text-decoration: none;color:#fff">设置为首页聚焦</a>
                                                     <?php } ?>
                                                    <?php if($item['choiceness']){ ?>
                                                    <a  class="btn btn-success" title=""  onclick="dochoiceness('<?php echo $this->createUrl("project/dochoiceness")?>','<?php echo $item['id'] ?>',0)" href="javascript:void(0);" s style="font-size:14px;text-decoration: none;color:#fff">取消往期精彩</a>
                                                    <?php }else{ ?>
                                                    <a  class="btn btn-success" title=""  onclick="dochoiceness('<?php echo $this->createUrl("project/dochoiceness")?>','<?php echo $item['id'] ?>',1)" href="javascript:void(0);" s style="font-size:14px;text-decoration: none;color:#fff">设置为往期精彩</a>

                                                    <?php } ?>
                                                    <a  class="btn btn-info" title="" href="<?php echo $this->createUrl("project/edit/", array('id' => $item['id'])) ?>" style="font-size:14px;text-decoration: none;color:#fff">查看</a>
                                                    <!--<a  class="btn btn-info" target="_blank" title="" href="<?php echo $this->createUrl("project/edit/", array('id' => $item['id'])) ?>" style="font-size:14px;text-decoration: none;color:#fff">编辑</a>-->
                                                    <a  class="btn btn-info" title="" onclick="del('<?php echo $this->createUrl("project/del")?>','<?php echo $item['id'] ?>')" href="javascript:void(0);" style="font-size:14px;text-decoration: none;color:#fff">删除</a>
<!--                                                    <a  class="btn btn-info" target="_blank" title="" href="<?php echo $this->createUrl("project/edit/", array('id' => $item['id'])) ?>" style="font-size:14px;text-decoration: none;color:#fff">回复</a>-->
<!--                                                    <a  class="btn btn-info" target="_blank" title="" href="<?php echo $this->createUrl("project/dostatus/", array('id' => $item['id'])) ?>" style="font-size:14px;text-decoration: none;color:#fff">否决</a>-->
<!--                                                    <a  class="btn btn-info" target="_blank" title="" href="<?php echo $this->createUrl("project/edit/", array('id' => $item['id'])) ?>" style="font-size:14px;text-decoration: none;color:#fff">设置精选</a>-->
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div> 
                                </div> 
                            </li>
                        <?php }
                    } else {
                        ?>
                        <li style="text-align:center;padding:20px 0">没有数据</li>	
<?php } ?>
                </ul>
            </div>


            <div class="pages clearfix">
                <?php
                $this->widget('JumpLinkPager', array('pages' => $pagebar,
                    'cssFile' => false,
                    'header' => '',
                    'firstPageLabel' => '首页', //定义首页按钮的显示文字
                    'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                    'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                    'prevPageLabel' => '前一页',
                        )
                );
                ?>
            </div>
        </form>
    </div>



</div>   


<script>
    $(document).ready(function() {

        var mydl = document.getElementsByTagName('li');
        for (var i = 0, j = 0; i < mydl.length; i++) {
            j++;
//            mydl[i].className = j % 2 == 0 ? '' : 'li2';
        }

    });
</script>