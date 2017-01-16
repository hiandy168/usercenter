<!DOCTYPE html>
<html>
  <head>
    <title>完善信息</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link href="<?php echo $this->_theme_url ?>resources/data/styles.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo $this->_theme_url ?>resources/complete/styles.css" type="text/css" rel="stylesheet"/>
      <script type="text/javascript" src="<?php echo $this->_theme_url ?>js/lib/jquery.js"></script>
      <script type="text/javascript" src="<?php echo $this->_theme_url ?>js/home.js"></script>



      <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/admin.js"></script>

      <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/kindeditor.js"></script>
      <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/kindeditor/lang/zh_CN.js"></script>
      <script type="text/javascript">
          <?php $member = Mod::app()->session['admin_member'];?>
          var site_url = "<?php echo Mod::app()->createAbsoluteUrl('/')?>";
          var admin_url = site_url+'/admin';
          var id = "<?php echo $member['id']?>";
          var token = "<?php echo $member['token']?>";
          var lang = "<?php echo $this->lang?>";
          $(document).ready(function(){
              var editor1 = KindEditor.create('.editor', {
                  fileManagerJson:admin_url+"/files/file_manager",
                  uploadJson:admin_url+'/files/upload',
                  allowFileManager : true,
                  formatUploadUrl :false,
              });
          });
      </script>
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

      <!-- Unnamed (形状) -->
      <div id="u6" class="ax_形状">
        <img id="u6_img" class="img " src="<?php echo $this->_theme_url ?>resources/tel/u6.png"/>
        <!-- Unnamed () -->
        <div id="u7" class="text">
          <p><span></span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u8" class="ax_形状">
        <img id="u8_img" class="img " src="<?php echo $this->_theme_url ?>resources/tel/u8.png"/>
        <!-- Unnamed () -->
        <div id="u9" class="text">
          <p><span>完成</span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u10" class="ax_形状">
        <img id="u10_img" class="img " src="<?php echo $this->_theme_url ?>resources/complete/u10.png"/>
        <!-- Unnamed () -->
        <div id="u11" class="text">
          <p><span>完善信息</span></p>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u12" class="ax_形状">
        <img id="u12_img" class="img " src="<?php echo $this->_theme_url ?>resources/complete/u12.png"/>
        <!-- Unnamed () -->
        <div id="u13" class="text">
          <p><span>手机注册</span></p>
        </div>
      </div>
    <form id="form2" name="form2" method="POST" action="" autocomplete="off">
      <!-- Unnamed (形状) -->
      <div id="u14" class="ax_文本段落">
        <img id="u14_img" class="img " src="<?php echo $this->_theme_url ?>resources/images/transparent.gif"/>
        <!-- Unnamed () -->
        <div id="u15" class="text">
          <p><span>开发者类型 </span></p>
        </div>
      </div>

      <!-- 公司 (单选按钮) -->
      <div id="u16" class="ax_单选按钮" data-label="公司">
        <label for="u16_input">
          <!-- Unnamed () -->
          <div id="u17" class="text">
            <p><span>公司</span></p>
          </div>
        </label>
        <input  type="radio" value="1" name="genre" checked/>
      </div>

      <!-- 公司 (单选按钮) [footnote] -->
      <div id="u16_ann" class="annotation"></div>

      <!-- 个人 (单选按钮) -->
      <div id="u18" class="ax_单选按钮" data-label="个人">
        <label for="u18_input">
          <!-- Unnamed () -->
          <div id="u19" class="text">
            <p><span>个人</span></p>
          </div>
        </label>
        <input  type="radio" value="0" name="genre"/>
      </div>

      <!-- 个人 (单选按钮) [footnote] -->
      <div id="u18_ann" class="annotation"></div>

      <!-- 开发者类型 (动态面板) -->
      <div id="u20" class="ax_动态面板" data-label="开发者类型">
        <div id="u20_state0" class="panel_state" data-label="公司">
          <div id="u20_state0_content" class="panel_state_content">

            <!-- Unnamed (形状) -->
            <div id="u21" class="ax_形状">
              <img id="u21_img" class="img " src="<?php echo $this->_theme_url ?>complete/u21.png"/>
              <!-- Unnamed () -->
              <div id="u22" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u23" class="ax_文本段落">
              <img id="u23_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u24" class="text">
                <p><span>公司名称</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u25" class="ax_文本段落">
              <img id="u25_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u26" class="text">
                <p><span>公司</span><span>地址</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u27" class="ax_文本段落">
              <img id="u27_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u28" class="text">
                <p><span>联系人姓名</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u29" class="ax_文本段落">
              <img id="u29_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u30" class="text">
                <p><span>联系人</span><span>邮箱</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u31" class="ax_文本段落">
              <img id="u31_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u32" class="text">
                <p><span>联系人手机</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u33" class="ax_形状">
              <input type="text" name="company" id="company" value="">
              <!-- Unnamed () -->
              <div id="u34" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u35" class="ax_形状">
                <input type="text" name="address" id="address" value="">
              <!-- Unnamed () -->
              <div id="u36" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u37" class="ax_形状">
                <input type="text" name="username" id="username" value="">
              <!-- Unnamed () -->
              <div id="u38" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u39" class="ax_形状">
                <input type="text" name="email" id="email" value="">
              <!-- Unnamed () -->
              <div id="u40" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u41" class="ax_文本段落">
              <img id="u41_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u42" class="text">
                <p><span><input type="text" name="tel" id="tel" value="<?php echo $tel?>"></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u43" class="ax_文本段落">
              <img id="u43_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u44" class="text">
                <p><span>修改</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u45" class="ax_文本段落">
              <img id="u45_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u46" class="text">
                <p><span>公司资质</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u47" class="ax_形状">
              <img id="u47_img" class="img " src="<?php echo $this->_theme_url ?>complete/u47.png"/>
              <!-- Unnamed () -->
              <div id="u48" class="text">
                  <img  style="max-height:123px;width:176px;padding:2px;border:1px solid #e6e6e6;" onclick="upload_pic('img_thumb','icon')"  src="<?php  //echo JkCms::show_img('')?>"  id="img_thumb">

                  <input type="hidden" name="icon" id="icon" value="">
                  <p style="margin:5px 0 10px 0;width:176px;height:28px;text-align:center">
                      <span  class="btn btn-danger" onclick="upload_pic('img_thumb','icon')"><?php echo Mod::t('admin','upload_pic')?></span>
                  </p>
              </div>
            </div>
          </div>
        </div>
        <div id="u20_state1" class="panel_state" data-label="个人">
          <div id="u20_state1_content" class="panel_state_content">

            <!-- Unnamed (形状) -->
            <div id="u49" class="ax_形状">
              <img id="u49_img" class="img " src="<?php echo $this->_theme_url ?>complete/u21.png"/>
              <!-- Unnamed () -->
              <div id="u50" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u51" class="ax_文本段落">
              <img id="u51_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u52" class="text">
                <p><span>联系人姓名</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u53" class="ax_文本段落">
              <img id="u53_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u54" class="text">
                <p><span>联系人</span><span>邮箱</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u55" class="ax_文本段落">
              <img id="u55_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u56" class="text">
                <p><span>联系人手机</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u57" class="ax_形状">
              <img id="u57_img" class="img " src="<?php echo $this->_theme_url ?>complete/u37.png"/>
              <!-- Unnamed () -->
              <div id="u58" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u59" class="ax_形状">
              <img id="u59_img" class="img " src="<?php echo $this->_theme_url ?>complete/u37.png"/>
              <!-- Unnamed () -->
              <div id="u60" class="text">
                <p><span></span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u61" class="ax_文本段落">
              <img id="u61_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u62" class="text">
                <p><span>13677788899</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u63" class="ax_文本段落">
              <img id="u63_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u64" class="text">
                <p><span>修改</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u65" class="ax_文本段落">
              <img id="u65_img" class="img " src="resources/images/transparent.gif"/>
              <!-- Unnamed () -->
              <div id="u66" class="text">
                <p><span>联系人</span><span>QQ</span></p>
              </div>
            </div>

            <!-- Unnamed (形状) -->
            <div id="u67" class="ax_形状">
              <img id="u67_img" class="img " src="<?php echo $this->_theme_url ?>complete/u37.png"/>
              <!-- Unnamed () -->
              <div id="u68" class="text">
                <p><span></span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Unnamed (形状) -->
      <div id="u69" class="ax_形状">
        <img id="u69_img" class="img " src="<?php echo $this->_theme_url ?>complete/u69.png"/>
        <!-- Unnamed () -->
        <div id="u70" class="text">
          <p><input type="button" name="button" value="下一步" id="regtwo" class="goregist"/></p>
        </div>
      </div>

      </form>
      <!-- Unnamed (形状) [footnote] -->
      <div id="u69_ann" class="annotation"></div>

      <!-- Unnamed (形状) -->
      <div id="u71" class="ax_形状">
        <img id="u71_img" class="img " src="<?php echo $this->_theme_url ?>complete/u71.png"/>
        <!-- Unnamed () -->
        <div id="u72" class="text">
          <p><span><a href="<?php echo Mod::app()->createUrl('site/regthree')?>">跳过</a> </span></p>
        </div>
      </div>

      <!-- Unnamed (形状) [footnote] -->
      <div id="u71_ann" class="annotation"></div>
    </div>
    <script>
        var Siteurl ="<?php echo $this->_siteUrl; ?>";
    </script>
    <script src="<?php echo $this->_theme_url ?>js/login.js"></script>

    <script>
        $(document).keypress(function(e) {
            if (e.which == 13)
                regtwo();
        });


        function regtwo(){
            var genre= $("input[name='genre']:checked").val();
            var company= $("#company").val();
            var icon= $("#icon").val();
            alert(111);return;
            var address= $("#address").val();
            var username= $("#username").val();
            var email = $("#email");
            var tel = $("#tel");

            if (tel.val() != "") {
                var reg = /^1[3|5|8]\d{9}$/;
                if (reg.test(tel.val()) == false) {
                    ship_mess_big('请输入正确的电话号码格式');
                    return false;
                }
            }
            if (email.val() != "") {
                var reg= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(reg.test(email.val()) == false) {
                    ship_mess('请输入正确的邮箱格式');
                    return false;
                }
            }

            $.ajax({
                url: Siteurl + '/member/AjaxRegTwo',
                data: {genre: genre, company: company, icon:icon, address: address, username: username, tel: tel.val(), email: email.val()},
                dataType: 'json',
                type: 'post',
                success: function (data) {
                    if (data.state == 1) {
                        ship_mess(data.message);
                        setTimeout(function () {
                            window.location.href = data.login_url;
                        }, 600);
                        //UI.clearPopup();
                    } else {
                        ship_mess(data.message);
                    }
                }
            });
        }
    </script>



  </body>
</html>
