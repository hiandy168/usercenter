<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>数据库管理</title>
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
                <form name="list_frm" id="ListFrm" action="<?php echo $this->createUrl('db/doQuery') ?>" method="post">
                    <table width="100%" cellspacing="0">
                        <thead>
                            <tr class="tb_header">
                                <th style="width:5%">&nbsp;</th>
                                <th>名称</th>
                                <th style="width:10%">类型</th>
                                <th style="width:15%">字符集</th>
                                <th style="width:8%">记录数</th>
                                <th style="width:8%">大小</th>
                                <th style="width:8%">碎片</th>
                                <th style="width:15%">注释</th>
                            </tr>
                        </thead>
                        <?php foreach ((array) $dataList as $row): ?>
                            <tr class="tb_list">
                                <td><input type="checkbox" name="id[]" value="<?php echo $row['Name'] ?>" id="<?php echo $row['Name'] ?>"></td>
                                <td><label for="<?php echo $row['Name'] ?>"><?php echo $row['Name'] ?></label></td>
                                <td><?php echo $row['Engine'] ?></td>
                                <td><?php echo $row['Collation'] ?></td>
                                <td><?php echo $row['Rows'] ?></td>
                                <td><?php echo $row['Data_length'] ?></td>
                                <td><?php echo $row['Data_free'] ?></td>
                                <td><?php echo $row['Comment'] ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    <div class="center_footer clearfix" style="margin:10px 0 0 0 ">
                        <ul>
                            <li style=""><input style='margin:5px 5px 0 0' type="checkbox" name="idAll" id="idAll" onclick="checkall(this, 'id[]');">全选</li>
                            <li><select name="command">
                                <option value="optimzeTable">优化表</option>
                                <option value="showTable">查看表结构</option>
                                <option value="checkTable">检查</option>
                                <option value="analyzeTable">分析</option>
                                <option value="repairTable">修复</option>
                            </select>
                                </li>
                                <li><input name="submit" type="submit" id="submit" value="提交" class="btn btn-primary" style=""/><li></li>
                        </ul>
                    </div>

                  
                </form>

            </div>


        </div> 


    </body>
</html>






