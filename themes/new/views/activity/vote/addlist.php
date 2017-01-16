<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
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
<form action="<?php echo $this->createUrl('/activity/vote/ExportCsv')?>" method="post">
    <div style="margin: 10px;">
        <input type="text" value="<?php echo $username ?>" name='username' placeholder="请输入用户名" class="btn" style="margin-right: 10px; border: 1px solid #ccc" />
        <button type="button"  id="search" class="btn btn-primary">搜索</button>
    </div>
    <div style="margin: 10px;">
        <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/vote/ExportCsv',array('fid'=>$id,'title'=>$titles,'type'=>1))?>" role="button">导出当页列表</a>
        <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/vote/ExportCsv',array('fid'=>$id,'title'=>$titles,'type'=>2))?>" role="button">导出全部数据</a>

            <input type="hidden" name="fid" value="<?php echo $id?>">
            <input type="hidden" name="type" value="3">
        <input type="date" name="starttime" value="" /><span>至</span><input type="date" name="endtime" value="" />
        <input class="btn btn-success" type="submit" value="导出">
        </form>

    </div>
    <table class="table table-striped">
        <thead>
            <th>ID</th>
            <th>用户姓名</th>
            <th>用户手机</th>
            <th>报名时间</th>
        </thead>
        <?php 
        if($users){
            foreach($users as $k=>$v){?>
        <tr>
            <td><?php echo $v->id ?></td>
            <td><?php echo $v->title ?></td>
            <td><?php echo $v->phone?></td>
            <td><?php echo date('Y-m-d H:i',$v->create_time)?></td>
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

<!--    <div class="page_222">-->
<!--        <div class="ep-pages">-->
<!--        --><?php
//          $this->widget('CoLinkPager', array('pages' => $pagebar,
//          'cssFile' => false,
//          'header'=>'',
//          'firstPageLabel' => '首页', //定义首页按钮的显示文字
//          'lastPageLabel' => '尾页',  //定义末页按钮的显示文字
//          'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
//          'prevPageLabel' => '前一页',
//           )
//         );
//        ?>
<!--        </div>-->
<!--    </div>-->
 
    </body>
</html>
<script>
    $("#search").click(function (){
        var username=$("input[name='username']").val();
        window.location.href="<?php echo $this->createUrl('/activity/vote/AddList/fid/'.$id)?>/username/"+username+"/title/签到用户列表";
    })
</script>