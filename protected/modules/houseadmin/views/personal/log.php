
<section class="content-header">
	<h1><?php echo $this->thisclassname;?><small></small></h1>
    <ol class="breadcrumb">
	    <li><a href="<?php echo $this->createUrl('/admin/desktop/index') ?>"><i class="fa fa-dashboard"></i> 首页</a></li>
		<?php if(isset($position)){?>
            <?php echo $position; ?>
		<?php } ?>
    </ol>
</section>

<section class="content">

    <div class="box box-info">
        
		<div class="box-header with-border clearfix">
            <i class="fa fa-legal"></i> <h3 class="box-title">个人系统日志</h3>
			<div class="pull-right">
            </div>
		</div>
        
		<div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="10%" style='text-align:center'>id</th>
                        <th width="20%">时间</th>
                        <th width="50%">内容</th>
                        <th width="20%">ip</th>
			        </tr>
                </thead>
                <tbody id="tbinfo">
                    <?php if(!empty($list)){foreach($list as $k=>$item){?>
                    <tr id="list_<?php echo $item['id']?>">
                        <td style="text-align:center;"><?php echo $item['id']?></td>
                        <td style="text-align:center;"><?php echo date('Y-m-d H:i:s',$item['logtime'])?></td>
                        <td style="text-align:center;"><span style='color:#06c'><?php echo $item['message']?></span></td>
                        <td><span style='color:#06c'><?php echo $item['ip']?></span></td>
                    </tr>	
                    <?php }}else{ ?>
                    <tr><td colspan="4" style='text-align:center'>no data</td></tr>
                    <?php } ?>
                </tbody>
			</table>
		</div>
        
		<div class="box-footer clearfix">
            <div class="pull-right pages">
                                <?php
                                    $this->widget('JumpLinkPager', array('pages' => $pagebar,
                                                    'cssFile' => false,
                                                    'header'=>'',
                                                    'firstPageLabel' => '«', //定义首页按钮的显示文字
                                                    'lastPageLabel' => '»', //定义末页按钮的显示文字
                                                    'nextPageLabel' => '›', //定义下一页按钮的显示文字
                                                    'prevPageLabel' => '‹',
                                                    'maxButtonCount'=>1,    //分页数目
                                                    'htmlOptions'=>array(
                                                            'class'=>'pagination',   //包含分页链接的div的class
                                                    )
                                                    )
                                    );
                                ?>           
            </div>
        </div>
    
	</div>

</section>


