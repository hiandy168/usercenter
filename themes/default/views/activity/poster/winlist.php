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
        <a class="btn <?php echo $active=='active_all' ? 'btn-primary' : 'btn-default'?>" href="<?php echo $this->createUrl('/activity/poster/WinList/fid/'.$id)?>" role="button">所有用户</a>
        <!-- <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/poster/ExportCsv',array('fid'=>$id))?>" role="button">导出列表</a> -->
    </div>
    <table class="table table-striped">
        <thead>
            <th>活动ID</th>
            <th>海报标题</th>
            <th>海报路径</th>
            <th>创建时间</th>
        </thead>
        <?php 
        if($users){
            foreach ($users as $val){
              $data = explode("/data",$val['url']);
            ?>
        <tr>
            <td><?php echo $val['pid'] ?></td>
            <td><?php echo $val['content'] ?></td>
            <td><a target="_blank" href="<?php echo "/data".$data[1];?>">查看图片</a></td>
            <td><?php echo date('Y-m-d H:i',$val['createtime'])?></td>
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
    <script>
    function set_lingjiang(parame){
    	layer.confirm('确定用户已经领奖了吗？', {
  		  btn: ['确定','取消'] //按钮
  		}, function(){
  		  var url = '<?php echo $this->createUrl('/activity/scratchcard/lingjiang')?>'
  		  var data = {id:parame}
  		  $.post(url,data,function(res){
  	  		  var res = JSON.parse(res);
    		    layer.msg(res.msg,{time:2000},function(){
    		        location.reload();
        		})
 		   })
  		});
    }
    </script>
    </body>
</html>