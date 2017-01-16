<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<script src="<?php echo $this->_theme_url; ?>/scrtch_files/jquery.js"></script>
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>/css/site.css">
    <script src="<?php echo $this->_theme_url;; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>js/lib/layer/layer.js"></script>
    <style type="text/css">
        .table-striped td,.table-striped th{
        	text-align:center;
        }
        .table-striped{
        	margin-bottom:0px;
        }
        .ep-pages{
        	margin-top:0px;
        }
    </style>
</head>
<body>
    <div style="margin: 10px;">
        <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/vote/ExportCsv',array('fid'=>$id,'title'=>$title))?>" role="button">导出列表</a>
    </div>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>用户姓名</th>
            <th>用户手机</th>
            <th>投票对象</th>
            <th>投票时间</th>
        </thead>
        <?php 
        if($users){
            foreach ($users as $val){?>
        <tr>
            <td><?php echo $val['id']?></td>
            <td><?php echo $val['username']?></td>
            <td><?php echo $val['phone']?></td>
            <td><?php echo $val['title'] ?></td>
            <td><?php echo date('Y-m-d H:i',$val['create_time'])?></td>
        </tr>
        <?php 
            }
        }else{
        ?>
        <tr><td colspan="7">暂无数据</td></tr>
        <?php }?>
    </table>
    <div class="page_222">
        <div class="ep-pages">
        <?php
          $this->widget('CoLinkPager', array('pages' => $pagebar,
          'cssFile' => false,
          'header'=>'',
          'firstPageLabel' => '首页', //定义首页按钮的显示文字
          'lastPageLabel' => '尾页',  //定义末页按钮的显示文字
          'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
          'prevPageLabel' => '前一页',
           )
         );
        ?>
        </div>
    </div>
 
    </body>
</html>