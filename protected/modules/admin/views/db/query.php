<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>执行sql语句</title>
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
            <div class="list"  style='margin: 5px 15px;'>
<form action="<?php echo $this->createUrl('execute')?>" method="post" id="queryForm">
  <table width="100%" cellspacing="0">
    <tr>
      <td class="tb_title">输入SQL：</td>
    </tr>
    <tr >
      <td ><textarea name="command" cols="100" rows="8" id="command"  ></textarea></td>
    </tr>
    <tr >
      <td >每行一条SQL语句</td>
    </tr>
    <tr class="submit">
      <td ><input name="execute" type="submit" id="execute" value="提交"  class="btn btn-primary" class="button" /></td>
    </tr>
  </table>
</form>


            </div>


        </div> 


    </body>
</html>



