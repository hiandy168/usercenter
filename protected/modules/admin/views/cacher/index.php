<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>添加/编辑模块</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" />
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/formcheck.js"></script>  
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/validation.js"></script>  
    </head>
    <body>

        <div class='bgf clearfix'>
        
            <div class="center_top clearfix" style='border-bottom: 1px solid #c2d1d8;'>
                <span class="btn btn-primary">设置缓存</span>
                <div class="form_list">
                <form onsubmit="" method="post" action="<?php echo $this->createUrl('/admin/cacher/index/', array('flush' => 'setting')); ?>" id="formview" name="formview">
                    <table width="100%" cellspacing="0" class="content_view">  
                        <tbody>
                            <tr>
                                <td width="80" align="right"></td>
                                <td>
                                    <input type="radio" value="filecache" name="type" <?php  if($cache=='filecache')echo 'checked=checked'?> >文件缓存（不会配置环境的建议使用这个）
                                </td>
                            </tr>
                            <tr>
                                <td width="80" align="right"></td>
                                <td>
                                    <input type="radio" value="memcahce"  name="type" <?php  if($cache=='memcache')echo 'checked=checked'?>  >memcahce（请配置好服务器的apccache环境 否则会报错）
                                </td>
                            </tr>
                            <tr>
                                <td width="80" align="right"></td>
                                <td>
                                    <input type="radio" value="apccache"  name="type"<?php  if($cache=='apccache')echo 'checked=checked'?>  >apccache（请配置好服务器的apccache环境 否则会报错）
                                </td>
                            </tr>
                            <tr>
                                <td width="80" align="right"></td>
                                <td>
                                    <input type="radio" value="dbcahce"  name="type" <?php  if($cache=='dbcahce')echo 'checked=checked'?> >dbcahce（请配置好服务器的dbcahce环境 否则会报错）
                                </td>
                            </tr>
                             <input type="hidden" value="1"  name="setting" >
                            <tr>
                                <td width="80" align="right" style="border:none"></td>
                                <td style="border:none"><input type="submit" class="btn btn-success" value="提交"></td>
                            </tr>
                        </tbody></table>        
                </form>
                    </div>
            </div>

            <div class="center_top clearfix" style="margin:20px 0;">
                <ul>
                    <li>
                        <a class="btn btn-primary" href="<?php echo $this->createUrl('/admin/cacher/index/', array('flush' => 'flush')); ?>">
                            清理缓存
                        </a>
                </ul>
            </div>



        </div>

    </div>   
</body>
</html>
