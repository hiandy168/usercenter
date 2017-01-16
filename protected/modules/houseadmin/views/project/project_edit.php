  <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/css/matrix-style.css" />
        <link rel="stylesheet" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/css/uniform.css" />
        <link rel="stylesheet" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/css/select2.css" />
        <link rel="stylesheet" href="<?php echo $this->_baseUrl; ?>/assets/public/bootstrap/font-awesome/css/font-awesome.css" />
<style>
    html,body,span,iframe,h1,h2,h3,h4,h5,h6,p,pre,a,em,img,small,strong,b,i,dl,dt,dd,ol,ul,li,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,footer,header,menu,nav,section{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}aside,footer,header,menu,nav,section{display:block}ol,ul{list-style:none}table{border-collapse:collapse;border-spacing:0}a{display:inline-block;text-decoration:none; font-size:12px;}
    .cl{ clear:both;}.l{ float:left;}.r{ float:right;}
    em,i{ font-style:normal;}
    img { border: medium none; border:o;}
    dt,dl{ padding:0; margin:0;}
    .fl{ float:left; display:inline;}
    .fr{ float:right;display:inline;}
    .tc{ text-align:center;}
    .wb100{ width:100%;}

    body{color:#999;font-size:16px; margin:0 auto;font: 14px/24px "Microsoft YaHei","微软雅黑";}
    html{width:100%;}
    a{display:inline-block;text-decoration:none;}
    .hidden{display:none}
    .f14{ font-size:14px;}
    .f12{ font-size:12px;}
    .cff{ color: #FFF;}
    .p10{ padding:10px;}
    .pl10{ padding-left:10px;}
    .pl30{ padding-left:30px;}
    .mt17{margin-top: 17px;}
    .mt17{margin-top: 15px;}

    .w1200{ width:1200px; margin:0 auto;}
    .top{ height:60px; background:#0078d7;}
    .logo{ float:left; display:inline; position:relative; top:8px; padding-right:25px; }
    .le{ display:inline;}
    .le span{ padding-right:25px; font-size:20px; color:#fff; line-height:60px; }
    .le span:hover{ color:#f0ea0d;}
    .box{border:1px solid #75b6e9; margin-top:10px; display:inline; position:relative;}
    .bod{ height:30px;line-height: 30px;background: none; border: none;padding-left: 20px;color: #75b6e9; font-size: 14px;}
    .search-icon{ display:block; width:20px; height:20px; background:url(../images/search.png) no-repeat; background-size:20px 20px; position:absolute; top:8px; right:10px;}
    .search a{ line-height:60px; color:#fff; font-size:13px;}
    #slider { width: 100%; margin: 0px auto;height: 347px;position: relative;}
    .slider-item { width: 100% !important;}
    #slideshow{ float: left; width: 100%; height: 350px; overflow: hidden;}
    /*first_w*/
    /*first_1*/
    .first_w{ margin-top:22px;}
    .first_1{width: 782px;padding-right: 26px;}
    .title{width: 782px;overflow: hidden;margin-top: -5px;}
    .lcc-title{font-family: 微软雅黑 !important;font-weight: bold;color: #393939;}
    .title a{font-size:30px;ont-weight: bolder; color:#666;}	
    .title-sub{font-size: 12px;line-height: 40px;}
    .title-time{color: #7C7C7C;}
    .title-edu{background: #FEA405 none repeat scroll 0% 0%;color: #FFF;margin-left: 16px;padding: 0px 3px 2px 3px;}
    .con{position: relative; border-right: 1px solid #E6E6E6;padding-right: 26px;  width: 782px;}
    .videoBtn{display: block;position: absolute;height: 56px;width: 56px;background: transparent url(../images/videoBtn.png) no-repeat scroll 0% 0%;left: 363px;top: 187px;cursor: pointer;}
    /*first_2*/
    .first_2{width: 365px;margin-top: 11px;}
    .ar-index-title{width: 100%;position: relative;margin-bottom: 30px;}
    .clearfix:after {content:"."; display:block; height:0px; clear:both; visibility:hidden; }
    .clearfix {zoom:1;}
    .col_a{ color:#aaa;}
    .ar-title{position: relative;font-size: 1.5em;color: #000;font-weight: bold;text-align: center;}
    .con_r{width: 365px;height: 208px;overflow: hidden;position: relative;}
    .videoBtn2{display: block;position: absolute;height: 56px;width: 56px;background: transparent url(../images/videoBtn.png) no-repeat scroll 0% 0%;left: 149px;top: 53px;cursor: pointer;}
    .con_title a{ font-size: 20px; color:#333;}

    /*second_w*/
    .ar-index-title{width: 100%;position: relative;margin-bottom: 30px;}
    .second_w_l{ padding-right: 24px;margin-right: 24px;}
    .second_w_l,.second_w_m,.second_w_r{width: 365px;}
    .pic_model,.pic_model2{ width: 365px; overflow: hidden;}
    .fl_pic { width: 365px; height: 170px;overflow: hidden;}
    .fl_title { padding: 10px; font-weight: bold;}
    .fl_title a{font-size: 18px;line-height: 40px; color:#333;}
    .sm_title{display: block; height:44px; line-height: 22px;overflow: hidden;font-weight: normal;}
    .tl{ text-align:left;}
    .sun{font-size: 12px;color: #8C8C8C;}
    .lcc-grey {color: #AAA; font-family: 宋体;}
    .lcc-inline { width: 234px; margin-left: 18px;line-height: 18px; height: 52px;overflow: hidden; font-size: 12px;}
    .second_w_m{padding-right: 24px;margin-right: 24px;}
    .right_border {border-right: 1px solid #E6E6E6;}
    /*wz_list*/
    .wz_list,.ar-sponsor{ display:none;}
    .ar-project-list3 {margin-top: 20px;}
    .wz_bq{ width:300px; box-sizing: border-box;margin-bottom: 40px; margin-top:-23px;}
    .wz_tit{ border-bottom:1px solid #E7E7E7;}
    .bq{ width:100%; background:#fafafa;}
    .cy,.jz,.mr,.qc,.ly,.yl,.jr,.yj,.sj,.fc,.jy,.cx,.ds,.yx,.dt,.yd,.yy,.zx,.aq,.gj,.yjs,.sh{ display:block;float: left;margin:10px 25px; text-align:center;}
    .industry_class{ width:49px;padding-top: 40px;font-size: 16px;color: #B1AAAA;text-align: left;}
    .cy_bg{background: transparent url(../images/cy2.png) no-repeat scroll 0% 0% ; }
    .jz_bg{background: transparent url(../images/jz2.png) no-repeat scroll 0% 0%;}
    .mr_bg{background: transparent url(../images/mr2.png) no-repeat scroll 0% 0%;}
    .qc_bg{background: transparent url(../images/qc2.png) no-repeat scroll 0% 0%;}
    .ly_bg{background: transparent url(../images/ly2.png) no-repeat scroll 0% 0%;}
    .yl_bg{background: transparent url(../images/yl2.png) no-repeat scroll 0% 0%;}
    .jr_bg{background: transparent url(../images/jr2.png) no-repeat scroll 0% 0%;}
    .yj_bg{background: transparent url(../images/yj2.png) no-repeat scroll 0% 0%;}
    .sj_bg{background: transparent url(../images/sj2.png) no-repeat scroll 0% 0%;}
    .fc_bg{background: transparent url(../images/fc2.png) no-repeat scroll 0% 0%;}
    .jy_bg{background: transparent url(../images/jy2.png) no-repeat scroll 0% 0%;}
    .cx_bg{background: transparent url(../images/cx2.png) no-repeat scroll 0% 0%;}
    .ds_bg{background: transparent url(../images/ds2.png) no-repeat scroll 0% 0%;}
    .yx_bg{background: transparent url(../images/yx2.png) no-repeat scroll 0% 0%;}
    .dt_bg{background: transparent url(../images/dt2.png) no-repeat scroll 0% 0%;}
    .yd_bg{background: transparent url(../images/yd2.png) no-repeat scroll 0% 0%;}
    .yy_bg{background: transparent url(../images/yy2.png) no-repeat scroll 0% 0%;}
    .zx_bg{background: transparent url(../images/zx2.png) no-repeat scroll 0% 0%;}
    .aq_bg{background: transparent url(../images/aq2.png) no-repeat scroll 0% 0%;}
    .gj_bg{background: transparent url(../images/gj2.png) no-repeat scroll 0% 0%;}
    .yjs_bg{background: transparent url(../images/yjs2.png) no-repeat scroll 0% 0%;}
    .sh_bg{background: transparent url(../images/cy2.png) no-repeat scroll 0% 0%;}
    .cy_bg:hover{ color:#FEA405;background: transparent url(../images/cy.png) no-repeat scroll 0% 0%;}
    .jz_bg:hover{color:#FEA405;background: transparent url(../images/jz.png) no-repeat scroll 0% 0%;}
    .mr_bg:hover{color:#FEA405;background: transparent url(../images/mr.png) no-repeat scroll 0% 0%;}
    .qc_bg:hover{color:#FEA405;background: transparent url(../images/qc.png) no-repeat scroll 0% 0%;}
    .ly_bg:hover{color:#FEA405;background: transparent url(../images/ly.png) no-repeat scroll 0% 0%;}
    .yl_bg:hover{color:#FEA405;background: transparent url(../images/yl.png) no-repeat scroll 0% 0%;}
    .jr_bg:hover{color:#FEA405;background: transparent url(../images/jr.png) no-repeat scroll 0% 0%;}
    .yj_bg:hover{color:#FEA405;background: transparent url(../images/yj.png) no-repeat scroll 0% 0%;}
    .sj_bg:hover{color:#FEA405;background: transparent url(../images/sj.png) no-repeat scroll 0% 0%;}
    .fc_bg:hover{color:#FEA405;background: transparent url(../images/fc.png) no-repeat scroll 0% 0%;}
    .jy_bg:hover{color:#FEA405;background: transparent url(../images/jy.png) no-repeat scroll 0% 0%;}
    .cx_bg:hover{color:#FEA405;background: transparent url(../images/cx.png) no-repeat scroll 0% 0%;}
    .ds_bg:hover{color:#FEA405;background: transparent url(../images/ds.png) no-repeat scroll 0% 0%;}
    .yx_bg:hover{color:#FEA405;background: transparent url(../images/yx.png) no-repeat scroll 0% 0%;}
    .dt_bg:hover{color:#FEA405;background: transparent url(../images/dt.png) no-repeat scroll 0% 0%;}
    .yd_bg:hover{color:#FEA405;background: transparent url(../images/yd.png) no-repeat scroll 0% 0%;}
    .yy_bg:hover{color:#FEA405;background: transparent url(../images/yy.png) no-repeat scroll 0% 0%;}
    .zx_bg:hover{color:#FEA405;background: transparent url(../images/zx.png) no-repeat scroll 0% 0%;}
    .aq_bg:hover{color:#FEA405;background: transparent url(../images/aq.png) no-repeat scroll 0% 0%;}
    .gj_bg:hover{color:#FEA405;background: transparent url(../images/gj.png) no-repeat scroll 0% 0%;}
    .yjs_bg:hover{color:#FEA405;background: transparent url(../images/yjs.png) no-repeat scroll 0% 0%;}
    .sh_bg:hover{color:#FEA405;background: transparent url(../images/cy.png) no-repeat scroll 0% 0%;}
    .cy a,.jr a,.yj a,.yjs a,.cy a:hover,.jr a:hover,.yj a:hover,.yjs a:hover{ background-position:5px 0px;}
    /*wz_bq end*/
    .first{width: 35%;box-sizing: border-box;margin-bottom: 46px;margin-left: 2.45%;}
    .item{border: 1px solid #E4E4E4;width: 100%;}
    .item img{height: 168px;width:100%;}
    .item_title{margin-top:0px;font-size: 18px;box-sizing: border-box;padding: 0px 22px;overflow: hidden;color: #333;font-weight: bold;}
    .desc{height: 40px;margin-top: 22px;line-height: 20px;box-sizing: border-box;padding: 0px 22px;font-size: 12px;color: #8C8C8C;overflow: hidden;}
    .action{margin-top: 22px;box-sizing: border-box;padding: 0px 22px 20px;position: relative;font-size: 12px;color: #8C8C8C;}
    .favrite{color: #FF6869;font-family: Sun;}
    .more{border: 1px solid #E6E6E6;height: 40px;font-size: 16px;width: 1191px;line-height: 42px;}
    .more a{display: block;width: 100%;height: 40px;font-size: 18px; text-align:center; color:#333; text-decoration:none;}
    .more a:hover{ color:#8b0000; background:#f4f4f4;}

    /*ar-sponsor*/
    .ar-sponsor{width: 1200px;margin: 90px auto 0px;overflow: hidden;}
    .name{position: relative;font-size: 24px;color: #333;font-weight: bold;text-align: center;margin-bottom: 50px;}
    .line-left{position: absolute;left: 425px;top: 19px;height: 1px;width: 100px;background: transparent url(../images/line-left.jpg) repeat scroll 0% 0% / 100% 100%;}
    .line-right{position: absolute;left: 675px;top: 19px;height: 1px;width: 100px;background: transparent url(../images/line-right.jpg) repeat scroll 0% 0% / 100% 100%;}
    .startup_ul li { float: left;  margin: 20px 18px 20px 0px;}
    .startup_ul li a { text-decoration: none;color: #333;}
    .startup_ul li img { width: 280px; height: 146px; overflow: hidden;}
    .startup_ul li p {text-align: center; font-size: 14px;}
    /*cslm*/
    .line-left1{position: absolute;left: 390px;top: 19px;height: 1px;width: 100px;background: transparent url(../images/line-left.jpg) repeat scroll 0% 0% / 100% 100%;}
    .line-right1{position: absolute;left: 715px;top: 19px;height: 1px;width: 100px;background: transparent url(../images/line-right.jpg) repeat scroll 0% 0% / 100% 100%;}
    .paiming {color: #CCC; font-size: 14px;font-weight: normal; margin: 0px; font-family: Sun;}
    .cslm ul { float: left;width: 180px; height: 120px;margin: 25px 10px 0px 38px;}
    .cslm ul li {font-size: 16px; color: #333;  margin: 4px 0px 0px;}
    .cslm ul li i { background: transparent url(../images/cslm_icon.png) no-repeat scroll 0px -10px; width: 20px; height: 35px; display: block; float: left; margin: -5px 20px 0px 14px;}
    .cslm ul li img {margin: 20px 0px 0px; width: 160px;}
    .cslm a:hover li i { background: transparent url(../images/cslm_icon.png) no-repeat scroll -1px -57px;}

    /*合作*/
    .hz_first { margin-left: 0px;}
    .hz_item { width: 15%; float: left; box-sizing: border-box; background: #F3F3F3 none repeat scroll 0% 0%; margin-left: 1%; height: 180px; display: table;
               text-align: center; margin-bottom: 12px;}
    .child{display: table-cell;vertical-align: middle;width: 100%;text-align: center;}
    .hz_item a{ display:block;}
    .hz_logo{height: auto;width: 90%;}
    /*footer*/
    .footer {width: 100%; height: auto; margin: 40px auto;padding: 8px 0px; font-size: 12px; line-height: 28px; color: #8C8C8C; text-align: center; overflow: hidden; clear: both;}
    .footer a { color: #8C8C8C; padding-right:5px;}
    .qq2wei { position: fixed; left: 50%; margin-left: 634px;bottom: 20px; z-index: 999;  width: 73px; height: 180px;}
    .goTop { display: block; width: 65px; height: 65px; margin: 0px auto;background: transparent url(../images/lcc-top.jpg) repeat scroll 0% 0%;}
    /*index end*/
    /*detail*/
    .wz_content .wz_content_l {  width: 782px;}
    .mt30 { margin-top: 30px;}
    .wz_content .wz_content_l .det_title h1 {font-size: 36px; color:#333;font-weight: bold;}
    .wz_content .wz_content_l .det_title .biaoqian { background-color: #FEA405; padding: 2px 3px;color: #FFF;}
    .wz_content .wz_content_l .pic_con {  width: 782px; height: 560px; overflow: hidden; position: relative;}
    .wz_content .wz_content_l .text_con .zhengwen {line-height: 30px; letter-spacing: normal;}
    .zhengwen { overflow: hidden; display: block; margin: 0px auto;}
    .article-conent { word-wrap: break-word; font-family: 微软雅黑; margin-top: 10px; white-space: pre-wrap; font-size: 18px;}
    .wz_content .wz_content_l .text_con .zhengwen h3 { margin-top: 30px; line-height: 30px;color:#444; font-size:20px;font-weight: bold;}
    .lcc-grey-bottom {color: #707070 !important;}
    .shenming {  color: #8BAAD0;  font-size: 16px; line-height: 32px; margin: 0px 0px 30px;}
    .h2.wzjh { font-size: 18px;font-weight: normal; padding-top: 15px; display: block;}
    .oh { overflow: hidden;}
    .con_1{position: relative;padding-right: 26px;width: 782px;}
    .wz_content .wz_content_l .more_text .con_1 .pic_model { width: 230px; height: 150px;margin-left: 30px; border: 1px solid #E6E6E6;}
    .wz_content .wz_content_l .more_text .con_1 .first { margin-left: 0px;}
    .pic_model { width: 365px;overflow: hidden;}
    .wz_content .wz_content_l .more_text .con_1 .pic_model .pic {width: 230px;  height: 105px; overflow: hidden;position: relative;}
    .wz_content .wz_content_l .more_text .con_1 .pic .videoBtn {display: block;position: absolute;height: 56px;  width: 56px; left: 87px; top: 24px;
                                                                cursor: pointer; background: transparent url(../images/videoBtn.png) no-repeat scroll 0% 0%;}
    .tuisong{width: 230px;height: 105px;position: relative;}
    .pic_model .tit_2 { padding:0px 10px; height: 70px; font-weight: bold;}
    .pic_model .tit_2 a{font-size: 14px;width: 200px; color:#333;  line-height:40px;}
    .wz_content .wz_content_r { width: 380px;}
    .wz_content .wz_content_r h3 { position: relative; overflow: hidden;}
    .mr10-c {  margin-right: 10px; font-size:20px; font-weight:bold; color:#333;}
    .wz_content .wz_content_r h3 hr {border-width: 0px 0px 1px; border-style: none none solid;  border-color: -moz-use-text-color -moz-use-text-color #333; -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none;width: 270px;
                                     margin-top: 19px;  margin-left: 5px;}
    .ar-headimg { padding: 50px 0px; text-align: center;}
    .ar-headimg img { height: 120px; width: 120px;}
    .wz_content .wz_content_r h4 { line-height: 30px; color: #333;}
    .lcc-grey-bottom {color: #707070 !important;}







    /*detail end*/
    /*czzy*/
    .cjwt_zh {margin: 0px auto;position: relative;overflow: hidden;height: 15529px;}
    .p80 {  padding: 80px;}
    .czzy_nav { width: 200px; position: fixed;top: 100px; z-index: 99;}
    .czzy_nav li{height: 32px; line-height: 32px; background-color: #2E55BC;font-size: 12px; margin: 0px 0px 6px;}
    .czzy_nav li a {color: #FFF; padding: 0px 30px 0px 22px; display: block;background: transparent url("http://mat1.gtimg.com/ent/aber/2013/fmrw/fmrw13_icon01.png") no-repeat scroll right center;
    }

    .czzy_nav li:hover a,.czzy_nav li.current a{background:#FEA405 url("http://mat1.gtimg.com/ent/aber/2013/fmrw/fmrw13_icon01.png") no-repeat scroll right center;}

    .czzy_cont { width: 1000px; position: absolute; right: 160px; top: 95px;}
    .czzy_cont p {color: #787878;font-size: 18px;line-height: 40px;}
    .czzy_p { position: relative; padding: 0px 0px 0px 40px; margin: 20px 0px;}
    .czzy_p i { background-color: #FEA405; text-align: center;line-height: 24px;top: 8px;padding: 0px 7px;left: 0px; color: #FFF; position: absolute;}
    .czzy_cont img { margin: 30px 0px;}
    /*problem*/
    .cjwt_zh1 { margin: 0px auto;position: relativ; overflow: hidden;height: inherit;}
    .cjwtDiv_zh { border-bottom: 1px solid #E8E8E8; padding: 40px 0;}
    .que_zh, .aws_zh { color: #2E2E2E; position: relative; font-size: 20px; padding: 0 0 0 35px; margin: 0 0 20px 0;}
    .que_zh {font-weight: bold;}
    .que_zh i, .aws_zh i { background: url(../images/qa.png) no-repeat top left; width: 26px;height: 26px; display: inline-block;position: absolute; left: 0; top: 0px;}
    .aws_zh { color: #787878;}
    .aws_zh i {background: transparent url(../images/qa.png) no-repeat scroll left bottom;}
    .pass_zh { margin: 20px; position: relative;}
    .num1_zh { padding: 0px 0px 0px 40px; position: relative; margin: 20px 0px;}
    .num1_zh i { width:30px; height:30px; line-height:30px; background:#b7b7b7; background-position:5px 0px; border-radius:50%; text-align:center; color:#fff; line-height:-13px; position: absolute; top: 4px; left:0px;}

    /*about*/
    .mgauto { margin: 0px auto;}
    .aboutus h2 {font-size: 20px; color:#333; font-weight:bold;}
    .aboutus p { line-height: 30px; padding: 40px 0px;  font-size: 18px; color: #999;}
    .aboutus span.fk { background-color: #FEA405; padding: 1px 5px; color: #FFF; margin-right: 5px;}

    /*fabu*/
    .mt-menu{ padding-top:10px;}
    .dropdown {  color: #FFF; margin-left: 10px; z-index: 999; position: relative; float: right; width: 120px;}
    .search a:hover{ color:#a4e4ff;}
    .dropdown a { display: inline-block;width: 120px; height: 40px; line-height: 40px !important; text-align: center;}
    .icon-people-white { margin-bottom: -2px;background-repeat: no-repeat;display: inline-block; height: 17px; width: 17px;
                         background-image: url(../images/tx_icon.png);}
    .mt50{ margin-top:50px;}
    .dropdown-menu { left: 0px; top: 50px; position: absolute;background: #2C53BA none repeat scroll 0% 0%; display: none;}
    .dropdown li { width: 120px; height: 40px; line-height: 40px;}
    .member_nav{width: 270px;}
    .mb_con{background-color: #fff;border: 1px solid #E6E6E6;padding-bottom: 20px;}
    .headimg { margin-top: 45px;margin-left: 70px; width: 125px; height: 125px; background-color: #EEE;}
    .fb_nav,.fb_nav1 { height: 58px; line-height: 58px; overflow: hidden; border-bottom: 1px solid #E6E6E6; border-top: 1px solid #E6E6E6; display: block; background-position: 0px 999px;}
    .fb_nav h2,.fb_nav1 h2{ height: 58px;line-height: 58px; overflow: hidden;font-size: 16px;font-weight: normal;  }
    .fb_nav h2{color: #333; background-position: 78px 23px;background:url(../images/zc_icon.png) no-repeat left ;background-position:75px 22px;}
    .fb_nav h2:hover{color: #fff; background-position: 78px 23px;background:url(../images/nr_icon.png) no-repeat left ;background-position:75px 22px;}
    .next_nav { font-size: 12px;  font-family: '"宋体" Arial';}
    .mt10{ margin-top:10px;}
    .next_nav li { line-height: 30px; background:url(../images/list_icon.png) no-repeat scroll 85px 10px/ 5px 12px; }
    .next_nav li a {margin-left: 100px; color:#333;}
    .next_nav li a:hover{ color:#8b0000;}
    .next_nav li a.active{ color:#8b0000;}
    .fb_nav_active {background-color: #8D8F96; background-position: 259px -60px;}
    .fb_nav_active h2{color: #fff; background:url(../images/nr_icon.png) no-repeat ;background-position:75px 22px;}
    .fb_nav:hover{background-color: #8D8F96; background-position: 259px -60px;}
    .fb_nav:hover h2{color: #fff; background:url(../images/nr_icon.png) no-repeat ;background-position:75px 22px;}

    .member .member_con {width: 856px;  border: 1px solid #E6E6E6;}
    .pb50{ padding-bottom:50px;}
    .member .member_con .form-con {  padding:5px 0;   width: 100%;  float: left;border-bottom: 1px solid #e6e6e6}
    .member .member_con .form-con h3 { font-size: 16px;  color: #333; font-weight: normal; line-height: 30px; text-align: right; padding-right: 18px;}
    .member .member_con .form-con h3 b{color: #E60012;line-height: 24px; padding-right: 5px;}
    .w100 {  width: 150px;border-right: 1px solid #e6e6e6;margin-right:10px;display:block}



    .member .member_con .form-con .commom { font-size: 12px; color: #999; line-height: 30px;  padding-left: 8px;}
    #browse_0{ width:170px; border:none; position:relative; top:-5px;}
    .btm{ position:relative; top:5px;}
    .member .member_con .form-con h4 { font-size: 16px; color: #333; font-weight: normal; line-height: 30px;  width: 700px;}
    .member .member_con .form-con h4 b {color: #E60012; line-height: 24px; padding-right: 5px;}
    .tl { text-align: left !important;}
    #browse_01{ border:none; ;}
    .a-upload{ margin-left:10px;width:96px; height:117px; background:url(../images/updateimg.jpg) no-repeat}
    .a-upload input,.btn input{position: absolute; font-size: 100px; right: 0; opacity: 0; filter: alpha(opacity=0); cursor: pointer}
    .ml124-1110 { margin-left: 123px;}
    .oh-1110 { overflow: hidden; clear: both;}
    .current-1110 {  background: #CFCDCE none repeat scroll 0% 0%;color: #FFF;}
    .lcc-item-1110 {  display: block; height: 46px; text-align: center; line-height: 46px; border-width: 1px 1px 0px; border-style: solid solid none; border-color: #E6E6E6 #E6E6E6 -moz-use-text-color; -moz-border-top-colors: none;  -moz-border-right-colors: none; -moz-border-bottom-colors: none;  -moz-border-left-colors: none; border-image: none; margin-top: 20px;  float: left;  padding-left: 24px;padding-right: 24px;}
    .content_delete_tig { margin-right: 30px; color:#333;}
    .w520-1110 {  width: 520px !important; float: left;}

    .add_question_div { padding-left: 108px;}
    .add_question_input {color: #F00; font-size: 18px;}
    .member .member_con .member_submit { margin-top: 66px; margin-left: 350px;}
    .blue_btn { color: #FFF; background-color: #488FCD; border: 0px none; cursor: pointer;}
    /*fabu end*/

    /*fabu_vd */
    .upload_video h2 { margin-top: 30px; margin-left: 90px; color:#333; font-size: 22px; font-weight: normal;}
    .upload_video .fenlei { margin-top: 40px; width: 745px;}
    .upload_video .fenlei li { color:#333; font-size:16px; float: left; margin-left: 92px; margin-bottom: 35px;}
    .upload_video .upload_video_btn { width: 700px;}
    .pt30 { padding-top: 30px;}
    .upload_video .upload_video_btn p a.gz { font-size: 16px; line-height:14px;  padding-bottom: 3px;  border-bottom: 1px solid #6481CD; color: #6481CD; margin-left: 4px;}
    .f16{ font-size:16px; color:#333;}
    .pt15 { padding-top: 15px;}
    /*fabu_vd end */
    /*fabu_sck */
    .member .video_sc { border: 0px none;}
    .w500 { width: 500px;}
    .form_class {height: 30px; border: 1px solid #E6E6E6;  padding-left:5px; line-height: 30px;}
    .btn_sm { padding:3px 12px; font-size: 12px;}
    .ml10 {  margin-left: 10px;}
    .w300 {width: 300px;}
    .ml5 { margin-left: 5px;}
    .w200 { width: 200px;}
    .btn_sm1{padding:0px 12px; font-size: 12px; height:33px; border:1px solid #488FCD; line-height:30px;}
    .mt15{ margin-top:15px;}
    .table_class { font-size: 12px;  font-family: "宋体"; font-weight: normal;  border: 1px solid #E6E6E6; padding: 0px; border-collapse: collapse;}
    .table_class tr { border-bottom: 1px solid #E6E6E6;}
    .table_class thead th {line-height:35px; color:#333;}
    .table_class tbody th {line-height:35px; color:#666;}
    .table_class tbody th a { padding-right:5px; color:#488FCD;}
    .table_class thead td {line-height:35px; color:#333;}
    .table_class tbody td {line-height:35px; color:#666;}
    .table_class tbody td a { padding-right:5px; color:#488FCD;}


    /*	#pages {font: 16px/38px "Arial"; color: #696864; vertical-align: middle;}
            #pages { font: 16px/38px "Arial"; color: #696864;}
            #pages a, #pages .current { float: left;}
            #pages a { display: inline-block;  padding: 0px 10px; height: 28px; margin-right: 12px; font: 12px/28px "Arial";  background: #FFF none repeat scroll 0% 0%; color: #696864; text-align: center; overflow: hidden; cursor: pointer;}
            div.badoo { padding-right: 0px; padding-left: 0px;font-size: 20px; color: #48B9EF;  font-family: arial,helvetica,sans-serif; text-align: center;}
            div.badoo a { border-width: 2px; border-style: solid; border-color: #F0F0F0; padding: 2px 5px;margin: 0px 2px;color: #48B9EF;  text-decoration: none;}*/

    /*fabu_sck nd*/
    /*zhuce */
    .member .register h2 { font-size: 20px; color:#333; font-weight: normal;}
    .member .register .form-con .commom {color: #65A3DC;}
    .member .member_con .form-con .commom {font-size: 12px;  line-height: 30px; padding-left: 8px;}
    .ml108{ margin-left:108px;margin-top: 25px;float: left;}
    .member .register .form-con .ggdiv input { width: 115px; margin-right: 8px;}
    .reduceGg {background: transparent url(../images/icopeng.png) no-repeat scroll 0px -406px; padding-left: 24px;cursor: pointer}
    #addGg { background: transparent url(../images/icopeng.png) no-repeat scroll 0px -353px; padding-left: 24px;cursor: pointer}

    .user-upload-label {width: 230px;}
    .reg_gz {  margin: 40px 0px 0px 260px; position: relative;}
    .reg_gz i { background: transparent url(../images/reg_gz.png) no-repeat scroll 0px -27px; width: 23px; height: 23px; position: absolute; left: 0px; top: 0px;
                cursor: pointer;}
    .reg_gz span { position: absolute; left: 30px;}
    .reg_gz span a {color: #5E9BDA; font-size: 16px; text-decoration: underline;}
    .reg_gz i.active {  background-position: 0px -1px;}
    .xz_che{ float:left; position:relative; top:3px;}




    .tabs ul li{list-style: none;float:left;padding:0;margin:0 1px 0 0;text-align:left}
    .tabs ul li.active{background:#e6e6e6;color:#000000}
    .tabs ul li.active a, .tabs ul li.active span{color:#000000}

    .gaoguan .commom {color: #65a3dc;}
    .gaoguan .commom {font-size: 12px;  line-height: 30px; padding-left: 8px;}
    .ggdiv input { margin-right: 8px; width: 115px; height: 24px; line-height: 24px;  padding-left: 5px;}
    .ggdiv textarea { height: 90px;  line-height: 26px; padding: 5px 0 0 5px;  width: 550px;}


    .pages{width:100%;text-align:right;margin:28px auto}
    .pages ul{padding:0 3px 0 0;margin:0 auto;display:inline-block; *display:inline;position:relative}
    .pages ul li{float:left;margin:0 2px;line-height:22px;}
    .pages ul li a,.pages ul li span{color:#696864;padding:2px 10px;line-height:22px;height:22px;border:1px solid #F0F0F0;}
    .pages ul li a:hover,.pages ul li a.hover{color:#fff;background:#06c;border:1px solid #fff;}
    .pages ul li.selected{background:#06c;color:#fff;}
    .pages ul li.selected a,.pages ul li.selected span{color:#ffffff;border:0;border:1px solid #fff}
    .pages ul li.page_frist {}	
    .pages ul li.page_extend {}	
    .pages ul li.first{width:auto;}
    .pl108{padding-left: 108px;}

    
    

</style>
      
<!--cobntent-->

<div class='bgf clearfix'>

    <div class="center_top clearfix">
        <a href="javascript:void(0)" class="btn btn-info current" >项目信息&nbsp;&nbsp;&nbsp;项目名:<?php echo $view['title'] ?>&nbsp;&nbsp;&nbsp;</a>
        <a href="<?php echo Mod::app()->request->urlReferrer; ?>" class="" style="float:right;margin-right: 10px;display:block;color:#00c;font-size: 14px;" >返回</a>
    </div>

    <div class="content member" style="margin:10px 0 0 10px">

        <!--member_nav end-->
        <div style="" id="loadDiv">
            <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/project/edit' . $fun); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo isset($view['id']) ? $view['id'] : ''; ?>">
                <div class="member_con" style="width:auto;margin:10px;">

             
            
                       <div class="form-con">
                            <h3 class="fl w100">推送位置</h3>
<div class="fl">
                    <label  class='w_10' for='top'  style="display:inline" >顶置</label>
                    <input id='top' class='w_30' type="checkbox" name="typefor[top]" value='1' <?php if(isset($view['top']) && ($view['top'] == 1)) {
                    echo 'checked';
                    } ?> />
                    <label  class='w_10' for='focus' style="display:inline" >焦距</label>
                    <input  id="focus" class='w_30' type="checkbox" name="typefor[focus]" value='1' <?php if(isset($view['focus']) && ($view['focus'] == 1)) {
                    echo 'checked';
                    } ?> />
                    <label class='w_10' for='recommend' style="display:inline" >推荐</label>
                    <input  id='recommend'class='w_30' type="checkbox" name="typefor[recommend]"  value='1'  <?php if(isset($view['recommend']) && $view['recommend'] == 1) {
                    echo 'checked';
                    } ?>  />
                    <label  class='w_10' for='choiceness' style="display:inline" >精选</label>
                    <input id='choiceness' class='w_30' type="checkbox" name="typefor[choiceness]"  value='1'  <?php if(isset($view['choiceness']) && $view['choiceness'] == 1) {
                    echo 'checked';
                    } ?> />
                    <label class='w_10' for='hot' style="display:inline" >热点</label>
                    <input  id='hot' class='w_30' type="checkbox" name="typefor[hot]"  value='1'  <?php if(isset($view['hot']) && $view['hot'] == 1) {
                    echo 'checked';
                    } ?>  />
</div>
                        </div>
        
                        <label class="form-con">
                            <h3 class="fl w100"><b>*</b> 行业分类</h3>

                            <?php $project_type_arr = JkCms::getproject_type(); ?>
                            <select class="fl" name="project[type_id]">
                                <option value="" selected="">--请选择行业--</option>
                                <?php foreach ($project_type_arr as $project_type): ?>
                                    <option value="<?php echo $project_type['id'] ?>" <?php if (isset($view['type_id']) && $view['type_id'] == $project_type['id']): ?>selected<?php endif; ?>><?php echo $project_type['title'] ?></option>
                                <?php endforeach; ?>
                            </select>


                        </label>
                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>项目名称</h3>
                            <input type="text" name="project[title]" class="fl" style="width:500px;"  value="<?php echo isset($view['title']) ? $view['title'] : ''; ?>">
                        </label>
                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>项目负责人</h3>
                            <input type="text" name="project[director]" class="fl"  value="<?php echo isset($view['director']) ? $view['director'] : ''; ?>">
                            <h3 class="fl w100"><b>*</b>负责人电话</h3>
                            <input type="text" name="project[phone]" class="fl" value="<?php echo isset($view['phone']) ? $view['phone'] : ''; ?>">
                        </label>

                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>负责人职务</h3>
                            <input type="text" name="project[job]" class="fl" value="<?php echo isset($view['job']) ? $view['job'] : ''; ?>">
                            <h3 class="fl w100"><b>*</b>邮箱</h3>
                            <input type="text" name="project[email]" class="fl" value="<?php echo isset($view['email']) ? $view['email'] : ''; ?>">
                        </label>
                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>项目网址</h3>
                            <input type="text" name="project[app_address]" class="fl" style="width:550px;" value="<?php echo isset($view['app_address']) ? $view['app_address'] : ''; ?>">
                        </label>
                        <!--            <div class="cl"></div>
                                    <label class="form-con ">
                                         <h3 class="fl w100"><b>*</b>产品下载地址</h3>
                                         <input type="text" name="project[title]" class="fl" style="width:550px;">
                                    </label>-->
                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>融资进度</h3>
                            <select class="fl" name="project[finance]">
                                <?php
                                $company_finance_arr = array('天使轮', 'Pre A轮', 'A轮', 'A+轮', 'B轮', 'B+轮', 'C轮', 'D轮', 'E轮', 'F轮', 'G轮', 'H轮', '暂未融资');
                                foreach ($company_finance_arr as $company_finance) {
                                    echo "<option value='" . $company_finance . "' " . ((isset($view['finance']) && $view['finance'] == $company_finance) ? "selected=selected" : '') . ">" . $company_finance . "</option>";
                                }
                                ?>      
                            </select>
                        </label>
                         <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>融资金额</h3>
                            <input type="text" name="project[money]" class="fl" style="width:550px;" value="<?php echo isset($view['money']) ? $view['money'] : ''; ?>">
                        </label>

                        <div class="cl"></div>
                        <label class="form-con ">
                        <h3 class="fl w100"><b>*</b>banner图</h3>
                        <div style="margin:0 0 0 105px;">
                        <div class="fl" style="">
                        <input id="file_upload1" name="file_upload" type="file" multiple="true">
                        <?php $banner_img_attachment = JkCms::getAttachmentByid($view['banner_attachment']); ?>
                        <img id="form_banner_img"  src="<?php echo Tool::show_img($banner_img_attachment['url'])?>" style="margin:auto;height:150px;">
                        <input name="project[banner_attachment]" value="<?php echo $view['banner_attachment']?>" type="hidden" id="banner_attachment" class="fl" ></div>
                        <div class="clearfix"></div>
                        </div>
                        </label>
                        
                        
                        <div class="cl"></div>
                        <label class="form-con ">
                            <h3 class="fl w100"><b>*</b>项目描述</h3>
                            <div style="margin:0 0 0 105px;">
                                <textarea name="project[description]" placeholder="800字之内" class="fl" style="width:680px;height:200px;"><?php echo isset($view['description']) ? $view['description'] : ''; ?></textarea>
                                <div class="clearfix"></div>
                                              
<!--                                                        <div style='margin:10px 0px 30px 3px;position:relative' class="clearfix">
                                                            <span id="file_upload"></span>
                                                            <span class="fl commom btm" style="display:block;position: absolute;top:15px;left:130px;">可上传Word、PPt、Excel、JPG图片文件</span>
                                                            <input  type="hidden" id="attachments" name="project[attachments]" value="">
                                                        </div>
                                                        
                                                        <div class="clearfix"></div>-->
                            </div>
                        </label>

                        <div class="cl"></div>
                        <div class="form-con  J_items1110 oh-1110  tabs" style="">
                            <h3 class="fl w100">&nbsp;</h3>
                            <div class="fl">
                                <ul class="clearfix">
                                    <li class="active"><label name="fenye" value="6" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">管理团队</label></li>
                                    <li><label name="fenye" value="7" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">针对人群</label></li>
                                    <li><label name="fenye" value="8" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">用户痛点</label></li>
                                    <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">产品功能</label></li>
                                    <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">产品未来规划</label></li>
                                    <li><label name="fenye" value="9" class="" style=" border:1px solid #e6e6e6;border-bottom: 0px;display: block;float: left;height: 46px;line-height: 46px;padding: 0 24px;text-align: center;">市场分析</label></li>
                                </ul>
                                <div style="border:1px solid #CFCDCE; ">
                                    <div class="tabscon clearfix" style="padding:0 0 20px 0">
                                        <div  style="display:inline-block;width:550px;margin:10px" class="gaoguan" >


                                            <?php $company_leaders = unserialize($view['company_leaders']); ?>
                                            <?php
//                    var_dump($company_leaders);die;
                                            $leaders_count = count($company_leaders['name']);
                                            if ($leaders_count) {
                                                for ($i = 0; $i < $leaders_count; $i++) {
                                                    ?>
                                                    <div class="ggdiv fl " style="position:relative;margin:0 0 10px 0">
                                                        <div>
                                                            <input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名" value="<?php echo $company_leaders['name'][$i] ?>"></input>
                                                            <input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写职位"  value="<?php echo $company_leaders['position'][$i] ?>"></input>
                                                            <span class="commom" style="position:absolute;top:0px;left:370px;">
                                                                <?php if ($i) { ?>
                                                                    <a class="reduceGg">(点击 -进行删除))</a>
                                                                <?php } else { ?>
                                                                    <a id="addGg">(点击+继续添加))</a>
                                                                <?php } ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <textarea class=''   name='company_leaders[remark][]' id='' placeholder='过往经历，如：教育背景、曾就职信息等'><?php echo $company_leaders['remark'][$i]; ?></textarea>
                                                        </div>
                                                        <div class="cl"></div> 
                                                    </div>
                                                <?php }
                                            } else { ?>

                                                <div class="ggdiv fl "  style="position:relative;margin:0 0 10px 0">
                                                    <div>
                                                        <input class="ggxm" type="text" name="company_leaders[name][]" placeholder="请填写姓名"></input>
                                                        <input class="ggxm" type="text" name="company_leaders[position][]" placeholder="请填写职位"></input>
                                                        <span class="commom" style="position:absolute;top:0px;left:370px;">
                                                            <a id="addGg">(点击+继续添加))</a>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <textarea class=''   name='company_leaders[remark][]' id='' placeholder='过往经历，如：教育背景、曾就职信息等'></textarea>
                                                    </div>
                                                    <div class="cl"></div> 
                                                </div>

<?php } ?>

                                        </div>
                                    </div>
                                    <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">

                                        <label style="position:relative" class="form-con  ">
                                            <h4 class="tl">
                                                <span>产品的目标用户群体是谁？有哪些特征？打算如何获取早期用户？</span>

                                            </h4>
                                            <textarea placeholder="800字之内" class="w520-1110" name="project[zzrq]" style="height:100px;"><?php echo isset($view['zzrq']) ? $view['zzrq'] : ''; ?></textarea>

                                        </label>

                                    </div>
                                    <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                                        <label style="position:relative" class="form-con  ">
                                            <h4 class="tl">
                                                <span>当前用户的痛点是什么？如何解决目前的用户痛点?</span>

                                            </h4>
                                            <textarea placeholder="800字之内" class="w520-1110"  name="project[yhtd]" style="height:100px;"><?php echo isset($view['yhtd']) ? $view['yhtd'] : ''; ?></textarea>

                                        </label>     
                                    </div>
                                    <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                                        <label style="position:relative" class="form-con  ">
                                            <h4 class="tl">
                                                <span>你的产品/服务定位是什么？你的产品/服务的最大特点或者核心要素是什么？你的产品/服务行业问题？</span>

                                            </h4>
                                            <textarea placeholder="800字之内" class="w520-1110"  name="project[cpgn]" style="height:100px;"><?php echo isset($view['cpgn']) ? $view['cpgn'] : ''; ?></textarea>

                                        </label>
                                    </div>
                                    <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                                        <label style="position:relative" class="form-con  ">
                                            <h4 class="tl">
                                                <span>未来的产品规划是什么？</span>

                                            </h4>
                                            <textarea placeholder="800字之内" class="w520-1110"  name="project[wlgh]" style="height:100px;"><?php echo isset($view['wlgh']) ? $view['wlgh'] : ''; ?></textarea>

                                        </label>
                                    </div>
                                    <div class="tabscon clearfix" style="display:none;padding:0 0 20px 0">
                                        <label style="position:relative" class="form-con  ">
                                            <h4 class="tl">
                                                <span>你所创业的领域，目前的现状是什么样？存在哪些问题？该领域前景如何？市场规模有多大？有哪些主要的用户？</span>

                                            </h4>
                                            <textarea placeholder="800字之内" class="w520-1110" name="project[scfx]" style="height:100px;"><?php echo isset($view['scfx']) ? $view['scfx'] : ''; ?></textarea>

                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="cl"></div>
                     
                        
<!--                        
  <div class="widget-box" style="margin:0 5px">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5>附件管理</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th  width="20px"></th>
                  <th width="50px" align="center">id</th>
                  <th width="" >文件名</th>
                   <th width="" >文件类型</th>
                  <th width=""><?php echo Mod::t('admin','createtime')?></th>
                  <th width=""><?php echo Mod::t('admin','operation')?></th>
                </tr>
              </thead>
              <tbody>
                    <?php if(!empty($view['attachments_arr'] )){foreach($view['attachments_arr'] as $k=>$a){?>
                    <tr id="list_<?php echo $item['id']?>">
                      <td   width="20px"><input type="checkbox" name="id[]"  value="<?php echo $item['id']?>" ></td>
                      <td><?php echo $a['id']?></td>
                      <td>
                       
                          <?php  if($a['type']=='image'){ ?>
                          <img src="<?php echo Tool::show_img($a['url'])?>" style="height:100px;">
                          <?php }else{ ?>
                             <a href="<?php echo Tool::show_img($a['url'])?>" target="_blank"><?php echo $a['original_name']?></a>
                          <?php } ?>
                      </td>
                       <td><?php echo $a['ext']?></td>
                      <td><?php echo date('Y-m-d H:i:s',$a['createtime'])?></td>
                      <td></td>
                    </tr>	
                    <?php }}else{ ?>
                    <tr><td></td><td></td><td></td><td>no data</td><td></td><td></td><td></td><td></td></tr>
                    <?php } ?>

              </tbody>
            </table>
          </div>
        </div>-->

                        
                    </form>

                    <p class="fl" style="margin:20px 50px;">
                        <button class=" submit_btn btn btn-primary" id="submit_btn"  type="button" onclick="submit_project();"> 确定修改</button>
                    </p>
                    <div class="cl"></div>
                </div>
        </div>
    </div>

    <div class="form clearfix" style="padding-left:200px;">
        <form  action="<?php echo $this->createUrl('project/dostatus'); ?>" method="post" id='actionform'>
            <input type="hidden"  value="<?php echo $view['id']; ?>" name="id"/>
            <div style="margin:10px 0;">
                <span style="color:#000">审批操作：</span>
                <span><input type="radio" name='action' value="1"  id='tongguo'><label for="tongguo" style='display:inline;color:#000000'>审核通过</label></span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <span> <input type="radio" name='action' value="0"  id='foujue'><label for="foujue"  style='display:inline;color:#000000'>否决</label></span>
            </div>
            <div id="commentdiv" style="display:none">
                <span style="color:#000">批示意见：</span><textarea class="form-control"  style="width:240px;height:70px;" cols="" name="comment" id='comment'></textarea>
            </div>
            <input  type="button"  value="提交审批" class="btn btn-success btn-flat" onclick='submit_action();'> 	
        </form>
    </div>
    <br><br>
        
    
    
</div>



<script src="<?php echo $this->_siteUrl ?>/assets/public/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.css">


<script type="text/javascript">
var site_url = "<?php echo $this->_siteUrl; ?>";
// $('#file_upload').uploadify({
//            'formData': {
//                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
//            },
//            'fileObjName': 'Filedata',
//            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp;*.xls;*.doc;*.xlsx;*.docx',
//            'fileSizeLimit': '10MB',
//            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
//            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
//            'buttonText': "上传文件资料",
//            'buttonImage' : '',
//            'height':'60',
//            'width':'120',
//            'onUploadSuccess': function(file, data, response) {
//                var strJSON = data;//得到的JSON
//                var obj = new Function("return" + strJSON)();//转换后的JSON对象
////                alert(obj.url);
////                alert(obj.id);
//                if ($('#attachments').val()){
//                        $('#attachments').val($('#attachments').val() + ',' + obj.id);
//                } else{
//                        $('#attachments').val(obj.id);
//                }
//
//                
//            }
//        });
  $('#file_upload1').uploadify({
            'formData': {
                'PHPSESSID': '<?php echo Mod::app()->session->sessionID ?>',
            },
            'fileObjName': 'Filedata',
            'fileTypeExts': '*.gif; *.jpg; *.png;*.bmp',
            'fileSizeLimit': '10MB',
            'swf': '<?php echo $this->_siteUrl ?>/assets/public/uploadify/uploadify.swf',
            'uploader': '<?php echo Mod::app()->createAbsoluteUrl('files/upload') ?>',
            'buttonText': "上传图片",
            'buttonImage' : '',
            'height':'60',
            'width':'120',
            'onUploadSuccess': function(file, data, response) {
                var strJSON = data;//得到的JSON
                var obj = new Function("return" + strJSON)();//转换后的JSON对象
                $('#banner_attachment').val(obj.id);
                $('#form_banner_img').attr('src',showimg(obj.url));
                $('#form_banner_img').show();
            }
        });
function submit_project() {
    $.ajax({
        url: "<?php echo $this->createUrl('project/edit') ?>",
        data: $('#formview').serialize(),
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            parent.ship_mess('提交中!!!', 8000, 0, 820);
        },
        success: function(data) {
            if (data.state) {
                parent.ship_mess('提交成功', 5000, 0, 820);
            } else {
                parent.ship_mess('提交失败,请联系管理员', 5000,0, 820);
            }
        },
        error: function() {
        }
    });
    return false;
}
    
    
$('#foujue').click(function(){
$('#commentdiv').show();
});

function submit_action(){
    var action = get_radio_value('action');
    if(action=='undefined'){
        alert('请选择审核结果！');
        return false;
    }
    
    if(action==0 && !$('#comment').val()){
        alert('请填写批示意见！');
        return false;
    }
     $.ajax({
        type: "post",
        url: admin_url + "/project/dostatus",
        data: $('#actionform').serialize(),
        dataType: 'json',
        beforeSend: function(XMLHttpRequest) { },
        success: function(data) {
            alert(data.mess);
        },
//        complete: function(XMLHttpRequest, textStatus){},
        error: function() { }
    });
}
     
</script>

