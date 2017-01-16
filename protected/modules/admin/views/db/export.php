<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>导出</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl . '/assets/public/css/admin.css' ?>" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl . '/assets/public/js/jquery-1.11.0.min.js' ?>"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl . '/assets/js/artDialog/jquery.artDialog.js?skin=default' ?>"></script>
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
            <div class="list" style='margin: 5px 15px;'>
<form action="<?php echo $this->createUrl('db/doExport')?>" method="post">
  <table width="100%" cellspacing="0">
    <tr>
      <td class="tb_title">分卷大小：</td>
    </tr>
    <tr >
      <td ><input type="hidden" name="tabletype" value="9open" id="9open">
        大小
        <input name="sizelimit" type="text" id="sizelimit" value="2048" />
        kb<br /></td>
    </tr>
    <tr>
      <td class="tb_title">建表语句格式：</td>
    </tr>
    <tr >
      <td ><input type="radio" name="sqlcompat" value="" checked="">
        默认 &nbsp;
        <input type="radio" name="sqlcompat" value="MYSQL40">
        MySQL 3.23/4.0.x &nbsp;
        <input type="radio" name="sqlcompat" value="MYSQL41">
        MySQL 4.1.x/5.x &nbsp;</td>
    </tr>
    <tr>
      <td class="tb_title">强制字符集：</td>
    </tr>
    <tr >
      <td ><input type="radio" name="sqlcharset" value="" checked="">
        默认&nbsp;
        <input type="radio" name="sqlcharset" value="latin1">
        LATIN1 &nbsp;
        <input type="radio" name="sqlcharset" value="utf8">
        UTF-8 </td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="dosubmit" value="开始备份"  class="btn  btn-primary" tabindex="3" id="dosubmit" /></td>
    </tr>
  </table>
</form>

            </div>


        </div> 


    </body>
</html>



