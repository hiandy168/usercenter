<!DOCTYPE html>
<html>
  <head>
    <title>行为分析</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link href="<?php echo $this->_theme_url ?>resources/data/styles.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $this->_theme_url ?>resources/appmgt/styles.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" />
  </head>
  <body>
    <div id="base" class="">

      <!-- Unnamed (形状) -->
      <div id="u0" class="ax_形状">
        <img id="u0_img" class="img " src="images/首页/u0.png"/>
        <!-- Unnamed () -->
        <div id="u1" class="text">
          <p><span></span></p>
        </div>
      </div>
        <span style="margin-left: 50px;"><?php echo '欢迎，'.$this->member['name'];?></span>
      <!-- Unnamed (Image) -->
      <div id="u2" class="ax_image">
        <img id="u2_img" class="img " src="<?php echo $this->_theme_url ?>resources/tel/u2.jpg"/>
        <!-- Unnamed () -->
        <div id="u3" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- logo (形状) -->
      <div id="u4" class="ax_形状" data-label="logo">
        <img id="u4_img" class="img " src="images/首页/logo_u6.png"/>
        <!-- Unnamed () -->
        <div id="u5" class="text">
          <p><span>Logo</span></p>
        </div>
      </div>

      <!-- Unnamed (Image) -->
      <div id="u6" class="ax_image">
        <img class="img " src="<?php echo $this->_theme_url ?>resources/appmgt/u6.png" style="width:76px;float:left "/>
        <!-- Unnamed () -->
        <div style="padding: 0 0 0 10px;float:left;text-align:left">
            <p style="height:24px;line-height:24px;margin:0;padding:0;">开发者:<?php echo $this->member['name']?></p>
          <p style="height:24px;line-height:24px;margin:0;padding:0;">类型:</p>
          <p style="height:24px;line-height:24px;margin:0;padding:0;">资料完成度:<span style="
        border: 1px solid #699F58;
    background-color: #699F00;
    width: 75px;
    display: inline-block;
    height: 16px;
    line-height: 16px;padding-left: 5px;
    ">91%</span><span style="    display: inline-block;
    border: 1px solid #699F58;
    background-color: #fff;
    width: 7px;
    height: 16px;
    line-height: 16px;">&nbsp;</span></p>
        </div>
      </div>

    

        <!-- Unnamed () -->
        <div id="u11" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u12" class="ax_形状">
        <!--<img id="u12_img" class="img " src="<?php echo $this->_theme_url ?>resources/appmgt/u12.png"/>-->
        <!-- Unnamed () -->
        <div id="u13" class="text">
          <p>&nbsp;&nbsp;&nbsp;<span><a href="<?php echo $this->createUrl('/member/logout'); ?>">退出</a></span></p>

        </div>
      </div>

      <!-- Unnamed (Image) -->
      <div id="u14" class="ax_image">
          <table style="width: 100%;">
              <a href="<?php echo $this->createurl('/behavior/console',array('pid'=>$pid,'day'=>1))?>">今天</a>
              <a href="<?php echo $this->createurl('/behavior/console',array('pid'=>$pid,'day'=>2))?>">昨天</a>
              <a href="<?php echo $this->createurl('/behavior/console',array('pid'=>$pid,'day'=>30))?>">30天</a>
          </table>
          <table style="width: 100%;">
        <thead style="background-color: #888;">
            <th>日期</th>
            <th>总数</th>
            
        </thead>
        <tbody>
        <!--foreach-->
        <?php foreach ($datalist as $k => $item) { ?>
          <tr>
            <td><?php echo $item['day'] ?></td>
            <td><?php echo $item['count'] ?></td>
            
          </tr>
        <?php } ?>
        <!--end foreach-->

        </tbody>
        </table>

          <div class="pages clearfix">
             
          </div>

      </div>


  </body>
</html>
