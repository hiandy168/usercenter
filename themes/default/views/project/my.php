<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<!--cobntent-->
<div class="content member w1200 mgauto mt50">
    <?php
    $left_active = 'project';
    $left_active2 = 'my';
    ?>
    <?php $this->renderPartial('/common/left', array('config' => $config, 'left_active' => $left_active, 'left_active2' => $left_active2)); ?>
    <!--member_nav end-->
    <div style="width:860px;" class="fr" id="loadDiv">
        	<div class="member_con video_sc fr pb50">
            	<div class="fl w500">
                <form  name="search_frm" action="<?php echo $this->createUrl("project/my")?>" id="" method="post">
                    <select class="form_class fl" name="type">
                        <option value="" selected="">--请选择行业--</option>
                        <?php
                        $company_type_arr = array('餐饮', '家政', '美业', '汽车', '旅游', '医疗', '金融', '硬件', '社交', '房产', '教育', '出行', '电商', '游戏', '电台', '阅读', '音乐', '资讯', '安全', '云计算', '其他');
                        foreach ($company_type_arr as $company_type) {
                            echo "<option value='" . $company_type . "' " .((isset($s['type']) && $s['type']==$company_type)?"selected=selected":''). ">" . $company_type . "</option>";
                        }
                        ?>
                    </select>
                    <input type="text" placeholder="请输入关键字" class="form_class input_class w200 fl" style="margin:0 0 0 5px;" name='title'  value="<?php echo isset($s['title'])?$s['title']:''; ?>">               
                    <button type="submit" class="btn blue_btn btn_sm1 fl ml5" id="search">搜索</button>
                </form>    
                     <!--<a href="" class=" blue_btn btn_sm fl ml10" id="J_addNewVideo">提交视频</a>-->
                </div>
                <div class="fr w300">
                	 <a href="<?php echo Mod::app()->createUrl('project/release')?>" class=" blue_btn btn_sm fr ml10" id="J_addNewArticle">提交新内容</a>
                 </div>
                <div class="cl"></div>
                <div class="video_sc_con cb  mt15 fl wb100">
                	<table class="table_class wb100">
                    	<thead>
                        	<tr>
                            	<th width="25px"></th>
                                <th width="330px"><div style="text-align:center;">标题</div></th>
                                <th width="100px">内容分类</th>
                                <th width="100px"><div style="text-align:center">发布时间</div></th>
                                <th width="100px">状态</th>
                                <th width="55px">
                                	<div style="text-align:center">操作</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($list){foreach($list as $p){?>
                            <tr>
                            	<td width="25px"></td>
                                <td width="330px" style="text-align:center;">
                                    <?php if($p['status']==1){ ?>
                                    <a href="<?php echo Mod::app()->createUrl('project/detail',array('id'=>$p['id']))?>"><?php echo $p['title']?></a>
                                    <?php }else{ ?>
                                    <?php echo $p['title']?>
                                    <?php } ?>
                                </td>
                                <td width="100px" style="text-align:center;"><?php echo $p['type']?></td>
                                <td width="100px" style="text-align:center;"><?php echo date('Y.m.d',$p['createtime'])?></td>
                                <td width="100px"  style="text-align:center;">
                                <?php echo Tool::Project_status($p['status']); ?>
                                </td>
                                <td width="55px">
                                	<div style="text-align:center">
                                            <?php if($p['status']==1){ ?>
                                            <a class="a_edit" href="<?php echo $this->createUrl("project/detail/",array('id'=>$p['id']))?>">查看</a>
                                            <?php } ?>
                                            <a class="a_del" onclick="del('<?php echo $this->createUrl("project/del")?>','<?php echo $p['id'] ?>')" href="javascript:;">删除</a>
                                        </div>
                                </td>
                            </tr>
                            <?php }}else{ ?>
                            <tr>
                                <td colspan="6" style="text-align:center;">没有数据</td>
                            </tr>
                            <?php } ?>
                         </tbody>
                     </table>
<!--                     <div class="page fr mt10">
                     	<div class="badoo" id="pages">
                        	<a href="#" paged="1">首页</a> 
                            <a href="#" paged="-1">上一页</a> 
                            <a href="#" paged="1">下一页</a> 
                            <a href="#" paged="0">尾页</a> 
                        </div>
                      </div>-->
                    
        <div class="pages clearfix fr">
            <?php
                        $this->widget('JumpLinkPager', array('pages' => $pagebar,
                                                        'cssFile' => false,
                                                        'header'=>'',
                                                        'firstPageLabel' => '首页', //定义首页按钮的显示文字
                                                        'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                                                        'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                                                        'prevPageLabel' => '前一页',
                                                            )
                        );
             ?>
        </div>
                
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
<?php $this->renderPartial('/common/footer',array('config'=>$config));?>