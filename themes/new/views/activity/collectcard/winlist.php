<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
    <title><?php echo $config['site_title']?></title>
    <meta name="Keywords" content="<?php echo $config['Keywords']?>" />
    <meta name="Description" content="<?php echo $config['Description']?>" />
    <script src="<?php echo $this->_theme_url; ?>assets/subassembly/scrtch_files/jquery.js"></script>
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/subassembly/wincss/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->_theme_url; ?>assets/subassembly/wincss/site.css">
    <script src="<?php echo $this->_theme_url; ?>assets/js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url; ?>assets/js/layer/layer.js"></script>
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
    <form action="<?php echo $this->createUrl('/activity/collectcard/WinList/fid/'.$id)?>" method="post">
    <div style="margin: 10px;">
        <input type="text" value="<?php echo $search ?>" name='search' placeholder="请输入兑奖码" class="btn" style="margin-right: 10px; border: 1px solid #ccc" />
        <input type="text" value="<?php echo $username ?>" name='username' placeholder="请输入用户名" class="btn" style="margin-right: 10px; border: 1px solid #ccc" />
        <button type="submit" class="btn btn-primary">搜索</button>
    </div>
    <div style="margin: 10px;">
        <a class="btn <?php echo $active=='active_all' ? 'btn-primary' : 'btn-default'?>" href="<?php echo $this->createUrl('/activity/collectcard/WinList/fid/'.$id)?>" role="button">所有用户</a>
        <a class="btn <?php echo $active=='active_win' ? 'btn-primary' : 'btn-default'?>" href="<?php echo $this->createUrl('/activity/collectcard/WinList/fid/'.$id.'/datatype/1')?>" role="button">中奖用户</a>
        <a class="btn <?php echo $active=='active_no' ? 'btn-primary' : 'btn-default'?>" href="<?php echo $this->createUrl('/activity/collectcard/WinList/fid/'.$id.'/datatype/2')?>" role="button">未中奖用户</a>
        <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/collectcard/ExportCsv',array('fid'=>$id,'type'=>1))?>" role="button">导出中奖列表</a>
    </div>
    <table class="table table-striped">
        <thead>
            <th>活动ID</th>
            <th>用户手机</th>
            <th>用户名</th>
            <th>兑奖码</th>
            <th>奖品等级</th>
            <th>中奖时间</th>
            <th>领奖状态</th>
        </thead>
        <?php 
        if($users){
            foreach ($users as $val){?>
        <tr>
            <td><?php echo $val['collectcard_id']?></td>
            <td><?php echo $val['phone']?></td>
            <td><?php echo $val['username']?></td>
            <td><?php echo $val['code'] ? $val['code'] :""?></td>
            <td><?php echo $val['level'] ? $val['level'] : ""?></td>
            <td><?php echo date('Y-m-d H:i',$val['time'])?></td>
            <td>
            <?php 
            if($val['code']){
                echo $val['accept']==1 ? '<font color="green">已领</font>' : '<font color="red" onclick="set_lingjiang('.$val[id].')">未领</font>';
            }else{
                echo '<font color="Gray">未中奖</font>';
            }
            ?></td>
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
    </form>
    <script>
    function set_lingjiang(parame){
    	layer.confirm('确定用户已经领奖了吗？', {
  		  btn: ['确定','取消'] //按钮
  		}, function(){
  		  var url = '<?php echo $this->createUrl('/activity/collectcard/lingjiang')?>'
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