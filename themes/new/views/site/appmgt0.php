<!DOCTYPE html>
<html>
  <head>
    <title>应用管理</title>
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

      <!-- 编辑资料 (形状) -->
      <div id="u8" class="ax_形状" data-label="编辑资料">
        <img id="u8_img" class="img " src="resources/images/transparent.gif"/>
        <!-- Unnamed () -->
        <div id="u9" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- 编辑资料 (形状) [footnote] -->
      <div id="u8_ann" class="annotation"></div>

      <!-- Unnamed (Image) -->
      <div id="u10" class="ax_image">
        <!--<img id="u10_img" class="img " src="<?php echo $this->_theme_url ?>resources/appmgt/u10.png"/>-->

          <form name="search_frm"  action="<?php echo Mod::app()->createUrl('site/appmgt');?>" id="SearchFrm" method="get">
              
              <input type="text" name="search_text" value="<?php if(isset($_GET['search_text']))echo $_GET['search_text'];?>"/>
              <input type="submit" value="搜索" />
          </form>

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
          <p><span><a href="<?php echo $this->createUrl('/project'); ?>">创建应用</a></span>&nbsp;&nbsp;&nbsp;<span><a href="<?php echo $this->createUrl('/member/logout'); ?>">退出</a></span></p>

        </div>
      </div>

      <!-- Unnamed (Image) -->
      <div id="u14" class="ax_image">
          <table style="width: 100%;">
        <thead style="background-color: #888;">
            <th>项目ID</th>
            <th>项目名称</th>
            <th>项目简介</th>
            <th>APPID</th>
            <th>APPKEY</th>
            <th>注册时间</th>
            <th>注册更新</th>
            <th>项目状态</th>
            <th>操作</th>
        </thead>
        <tbody>
        <!--foreach-->
        <?php foreach ($datalist as $k => $item) { ?>
          <tr id="list_<?php echo $item['id'] ?>">
            <td><?php echo $item->id ?></td>
            <td><?php echo $item->name ?></td>
            <td><?php echo $item->introduction ?></td>
            <td><?php echo $item->appid ?></td>
            <td><?php echo $item->appkey ?></td>
            <td><?php echo date('Y-m-d H:i:s', $item->createtime) ?></td>
            <td><?php echo date('Y-m-d H:i:s', $item->updatetime) ?></td>
            <td><?php echo $item->status ? Mod::t('admin', 'state_1') : Mod::t('admin', 'state_0'); ?></td>
            <td>
              <a  class='a_edit' href="<?php echo $this->createUrl("project/edit/",array('id'=>$item['id']) ) ?>"><?php echo Mod::t('admin', 'edit') ?></a>
              <a   class='a_del'  onclick="del('<?php echo $this->createUrl("project/del/") ?>', '<?php echo $item->id ?>')" href="javascript:;"><?php echo Mod::t('admin', 'del') ?></a>

                <a href="<?php echo $this->createUrl("activity/scratchcard/console",array('pid'=>$item->id)) ?>">组件</a>
                <a target="_blank" href="<?php echo $this->createUrl("behavior/console",array('pid'=>$item->id)) ?>">用户行为</a>

            </td>
          </tr>
        <?php } ?>
        <!--end foreach-->

        </tbody>
        </table>

          <div class="pages clearfix">
              <?php
              $this->widget('CLinkPager', array('pages' => $pagebar,
                      'cssFile' => false,
                      'header'=>'',
                      'firstPageLabel' => '首页', //定义首页按钮的显示文字
                      'lastPageLabel' => '尾页', //定义末页按钮的显示文字
                      'nextPageLabel' => '下一页', //定义下一页按钮的显示文字
                      'prevPageLabel' => '前一页',
                  )
              );
              ?>
          </div>

      </div>

      <!-- 已发布应用 (形状) -->
      <div id="u16" class="ax_形状" data-label="已发布应用">
        <img id="u16_img" class="img " src="<?php echo $this->_theme_url ?>resources/appmgt/已发布应用_u16.png"/>
        <!-- Unnamed () -->
        <div id="u17" class="text">
          <p><span>已发布应用</span></p>
        </div>
      </div>

      <!-- 已发布应用 (形状) [footnote] -->
      <div id="u16_ann" class="annotation"></div>

      <!-- 违规应用 (形状) -->
      <div id="u18" class="ax_形状" data-label="违规应用">
        <img id="u18_img" class="img " src="<?php echo $this->_theme_url ?>resources/appmgt/已发布应用_u16.png"/>
        <!-- Unnamed () -->
        <div id="u19" class="text">
          <p><span>违规应用</span></p>
        </div>
      </div>

      <!-- 违规应用 (形状) [footnote] -->
      <div id="u18_ann" class="annotation"></div>

      <!-- 应用 (动态面板) -->

  </body>
</html>
