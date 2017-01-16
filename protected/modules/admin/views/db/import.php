<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>导入</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl . '/assets/public/css/admin.css' ?>" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl . '/assets/public/js/jquery-1.11.0.min.js' ?>"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl . '/assets/public/js/artDialog/jquery.artDialog.js?skin=default' ?>"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl . '/assets/public/js/admin.js' ?>"></script>
    </head>
    <body>
        <div class='bgf clearfix'>

                <div class="center_top clearfix">
                <ul>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('db/index') ?>" class="current"><span>管理列表</span></a></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('db/query') ?>" class=""><span>执行SQL</span></a></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('db/export') ?>" class=""><span>数据库备份</span></a></li>
                    <li><a class="btn btn-primary" href="<?php echo $this->createUrl('db/import') ?>" class=""><span>数据库还原</span></a></li>
                </ul>
            </div>

 <div class="clearfix"></div>
            <div class="list"  style='margin: 5px 15px;'>
<form action="<?php echo $this->createUrl('db/operate')?>" method="post">
  <table  width="100%" cellspacing="0">
    <thead>
      <tr class="tb_header">
        <th width="4%"align="left"></th>
        <th>名称</th>
        <th width="10%">文件大小</th>
        <th width="20%">备份时间</th>
        <th width="10%">分卷</th>
        <th width="15%">恢复/下载</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($infos)):?>
      <?php foreach($infos as $info):?>
      <tr bgcolor="<?=$info['bgcolor']?>">
        <td ><input name="sqlfile[]" type="checkbox" id="sqlfile[]" value="<?php echo $info['filename']?>"></td>
        <td><?php echo $info['filename']?></td>
        <td><?php echo $info['filesize']?> M</td>
        <td><?php echo $info['maketime']?></td>
        <td><?php echo $info['number']?></td>
        <td><a href="<?php echo $this->createUrl('db/import',array('pre'=>  urlencode($info['pre']), 'dosubmit'=>'1'))?>"><img src="<?php echo $this->_baseUrl?>/assets/public/images/refresh.png" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp; <a href="<?php echo $this->createUrl('db/operate',array('command'=>'downloadFile','sqlfile'=>$info['filename']))?>"><img src="<?php echo $this->_baseUrl?>/assets/public/images/download.png" align="absmiddle" /></a></td>
      </tr>
      <?php endforeach?>
      <?php endif?>
    </tbody>
    <tr class="submit">
      <td colspan="6" ><input name="command" type="hidden" value="deleteFile" />
        <input type="checkbox" id="chkall" name="chkall" onclick="checkall(this, 'sqlfile[]');">
        全选
        <input name="submit" type="submit" id="submit" value="删除"  class="btn  btn-primary"/>
        &nbsp;</td>
    </tr>
  </table>
</form>

            </div>


        </div> 


    </body>
</html>



