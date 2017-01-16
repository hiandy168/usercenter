    <?php echo $this->renderpartial('/common/header_1',$config);?>

    <link href="<?php echo $this->_theme_url ?>resources/three/styles.css" type="text/css" rel="stylesheet"/>
    <script src="<?php echo $this->_theme_url ?>resources/three/data.js"></script>
    <script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/jquery.js"></script>

    <div id="base" class="">

      <!-- Unnamed (形状) -->
      <div id="u0" class="ax_形状">
          <img id="u2_img" class="img " src="<?php echo $this->_theme_url ?>resources/tel/u2.jpg"/>
        <!-- Unnamed () -->
        <div id="u1" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- Unnamed (Image) -->
      <div id="u2" class="ax_image">
        <img id="u2_img" class="img " src="images/手机注册/u2.jpg"/>
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

      <!-- Unnamed (形状) -->
      <div id="u6" class="ax_形状">
        <img id="u6_img" class="img " src="<?php echo $this->_theme_url ?>resources/three/u6.png"/>
        <!-- Unnamed () -->
        <div id="u7" class="text">
          <p><span>完成</span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u8" class="ax_形状">
        <img id="u8_img" class="img " src="<?php echo $this->_theme_url ?>resources/three/u10.png"/>
        <!-- Unnamed () -->
        <div id="u9" class="text">
          <p><span>完善信息</span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u10" class="ax_形状">
        <img id="u10_img" class="img " src="<?php echo $this->_theme_url ?>resources/three/u12.png"/>
        <!-- Unnamed () -->
        <div id="u11" class="text">
          <p><span>手机注册</span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u12" class="ax_形状">
        <img id="u12_img" class="img " src="<?php echo $this->_theme_url ?>resources/three/u12.png"/>
        <!-- Unnamed () -->
        <div id="u13" class="text">
          <p><span>注册完成！</span></p>
        </div>
      </div>

      <!-- 创建应用 (形状) -->
      <div id="u14" class="ax_形状" data-label="创建应用">
        <img id="u14_img" class="img " src="images/完成/创建应用_u14.png"/>
        <!-- Unnamed () -->
        <div id="u15" class="text">
          <p><span><a href="<?php echo $this->createUrl('/project/appMgt')?>">现在创建应用</a></span></p>
        </div>
      </div>

      <!-- 创建应用 (形状) [footnote] -->
      <div id="u14_ann" class="annotation"></div>

      <!-- 查看开发文档 (形状) -->
      <div id="u16" class="ax_形状" data-label="查看开发文档">
        <img id="u16_img" class="img " src="images/完成/创建应用_u14.png"/>
        <!-- Unnamed () -->
        <div id="u17" class="text">
          <p><span>查看开发文档</span></p>
        </div>
      </div>

      <!-- 查看开发文档 (形状) [footnote] -->
      <div id="u16_ann" class="annotation"></div>
    </div>

    <script>
        $(document).keypress(function(e) {
            if (e.which == 13)
                regthree();
        });

        function regthree(){
            setTimeout(function(){
                window.location.href ="<?php echo Mod::app()->createAbsoluteUrl('/project/appmgt')?>";
            },600);
        }
     </script>
  </body>
</html>
