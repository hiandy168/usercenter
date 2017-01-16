<?php $this->renderPartial('/common/header',array('config'=>$config));?>
<!--cobntent-->
<div class="content member w1200 mgauto mt50">
    <?php 
        $left_active = 'project';
        $left_active2 = 'attachment';
    ?>
     <?php $this->renderPartial('/common/left', array('config' => $config,'left_active'=>$left_active,'left_active2'=>$left_active2)); ?>
    <!--member_nav end-->
  <div style="width:860px;" class="fr" id="loadDiv">
    
        	<div class="member_con video_sc fr pb50">
            	<div class="fl w500">
               	 <form  name="search_frm" action="<?php echo $this->createUrl("attachment/my")?>" id="" method="post">
                    <input type="text" placeholder="请输入关键字" class="form_class input_class w200 fl" style="margin:0 0 0 5px;"  name='original_name' <?php echo isset($s['original_name'])?$s['original_name']:''; ?>>               
                    <button type="submit" class="btn blue_btn btn_sm1 fl ml5" id="search">搜索</button>
                </form>   
                </div>
  
                <div class="cl"></div>
                <div class="video_sc_con cb  mt15 fl wb100">
                	<table class="table_class wb100">
                    	<thead>
                        	<tr>
                            	<th width="25px"></th>
                                <th width="330px"><div style="text-align:center;">文件名</div></th>
                                <th width="100px">原来文件名</th>
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
                                <td width="330px"  style="text-align:center;"><?php echo $p['file_name']?></td>
                                <td width="100px"  style="text-align:center;"><?php echo $p['original_name']?></td>
                                <td width="100px" style="text-align:center;"><?php echo date('Y.m.d H:i:s',$p['createtime'])?></td>
                                <td width="100px"  style="text-align:center;">
                                     <?php echo Tool::Attachment_status($p['status']); ?>
                                </td>
                                <td width="55px">
                                	<div style="text-align:center">
                                            <a class="a_del" onclick="del('<?php echo $this->createUrl("attachment/del")?>','<?php echo $p['id'] ?>')" href="javascript:;">删除</a>
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