<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>执行结果</title>
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
            <div class="clearfix" style="margin:15px">
                SQL:<?php echo $command ?>
            </div>


            <div class="clearfix"></div>
            <div class="list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr class="tb_header">
                            <?php foreach ((array) $fields as $k): ?>
                                <th><?php echo $k ?></th>
                            <?php endforeach ?>
                        </tr>
                    </thead>
                    <?php foreach ((array) $dataList as $row): ?>
                        <tr class="tb_list">
                            <?php foreach ((array) $fields as $d): ?>
                                <td><?php echo $row[$d] ?></td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
                </form>

            </div>


        </div> 


    </body>
</html>






