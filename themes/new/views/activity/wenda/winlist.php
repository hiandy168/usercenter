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
<form action="<?php echo $this->createUrl('/activity/wenda/WinList/fid/'.$id)?>" method="post">
    <div style="margin: 10px;">
<!--        <input type="text" value="--><?php //echo $search ?><!--" name='search' placeholder="体术" class="btn" style="margin-right: 10px; border: 1px solid #ccc" />-->
        <input type="text" value="<?php echo $username ?>" name='username' placeholder="请输入用户名" class="btn" style="margin-right: 10px; border: 1px solid #ccc" />
        <button type="submit" class="btn btn-primary">搜索</button>
    </div>
    <div style="margin: 10px;">
        <a class="btn <?php echo $active=='active_all' ? 'btn-primary' : 'btn-default'?>" href="<?php echo $this->createUrl('/activity/wenda/WinList/fid/'.$id)?>" role="button">所有用户</a>
<!--        <a class="btn --><?php //echo $active=='active_win' ? 'btn-primary' : 'btn-default'?><!--" href="--><?php //echo $this->createUrl('/activity/wenda/WinList/fid/'.$id.'/datatype/1')?><!--" role="button">中奖用户</a>-->
<!--        <a class="btn --><?php //echo $active=='active_no' ? 'btn-primary' : 'btn-default'?><!--" href="--><?php //echo $this->createUrl('/activity/wenda/WinList/fid/'.$id.'/datatype/2')?><!--" role="button">未中奖用户</a>-->
        <a class="btn btn-success" href="<?php echo $this->createUrl('/activity/wenda/ExportCsv',array('fid'=>$id,'type'=>1))?>" role="button">导出参与列表</a>
    </div>
    <table class="table table-striped">
        <thead>
        <th>活动ID</th>
        <th>用户手机</th>
        <th>用户名</th>
        <th>答对题数</th>
        <th>参与时间</th>
        </thead>
        <?php
        if($users){
            foreach ($users as $val){?>
                <tr>
                    <td><?php echo $val['wendaid']?></td>
                    <td><?php echo $val['phone']?></td>
                    <td><?php echo $val['username']?></td>
                    <td><?php echo $val['answer_bingo_num']?></td>
                    <td><?php echo date('Y-m-d H:i',$val['time'])?></td>
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

</body>
</html>