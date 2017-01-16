 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>排班</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Generator" content="EditPlus">
        <meta name="Author" content="">
        <meta name="Keywords" content="">
        <meta name="Description" content="">
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/artDialog/jquery.artDialog.js?skin=default"></script>
        <script type="text/javascript" src="<?php echo $this->_baseUrl; ?>/assets/public/js/validation.js"></script>  

        <script type="text/javascript">
        <?php $member = Mod::app()->session['admin_member'];?>
        var site_url = "<?php echo $this->_siteUrl; ?>";
        var admin_url = "<?php echo $this->_adminUrl;?>";
        var id = "<?php echo $member['id']?>"; 
        var token = "<?php echo $member['token']?>";
        var lang = "<?php echo $this->lang?>";
        $(document).ready(function(){  
            var editor1 = KindEditor.create('.editor', {
                fileManagerJson:admin_url+"/files/file_manager",
                uploadJson:admin_url+'/files/upload?id='+id+'&token='+token+'&lang='+lang,
                allowFileManager : true,
                formatUploadUrl :false,
                urlType:''
            });
        });
        </script>
 </head>
 <body>
     <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/admin.css" /> 
 <link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl; ?>/assets/public/css/style_xhx.css" />
 <style>
     input{border:0;border: 1px solid #ffffff;background:none; text-align:center;display:inline-block;width:90%;margin:0 auto}

 </style>
 <div  style=" margin:10px;float:left">
      <form name="formview" id="formview" action="<?php echo $this->createUrl('/admin/dutyorder/dosubmit'); ?>" method="post">
          <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mdrlist">
              <tbody><tr class="tableheader">
                <td rowspan="2" style="width:90px;border-right:1px solid #e6e6e6">科室</td>
                <td colspan="2">周一</td>
                <td colspan="2">周二</td>
                <td colspan="2">周三</td>
                <td colspan="2">周四</td>
                <td colspan="2">周五</td>
                <td colspan="2">周六</td>
                <td colspan="2">周日</td>
              </tr>
              <tr class="tableheader">
                
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
                <td>上午</td>
                <td>下午</td>
              </tr>
              <?php 
               $sql ="select * from {{offices}} where status=1  and  fid !=0 "; 
               $keshiarr = Mod::app()->db->createCommand($sql)->queryAll();     
              if($keshiarr){foreach($keshiarr as $keshi){ ?>
               <tr>
                <td class="tableleft"><?php echo $keshi['title']?></td>
                <?php for($i=1;$i<=14;$i++){?>
                <td class="tablecontent2"><input maxlength='4' value="<?php echo $duty[$keshi['id']][$i]?>" name="duty[<?php echo $keshi['id']?>][<?php echo $i?>]"></td>
                <?php } ?> 
              </tr>
              <?php }} ?>
<!--              <tr>
                <td class="tableleft">心血管内科</td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
                <td class="tablecontent2"><input value="" name="doctor['keshi'][1]"></td>
              </tr>
              <tr>
                <td class="tableleft">肾病内科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">刘建社</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">杨晓</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">内分泌</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">高峰</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">呼吸科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">辛建保</td>
                <td class="tablecontent2">辛建保</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">辛建保</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">辛建保</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">老年病</td>
                <td class="tablecontent2">孙麓</td>
                <td class="tablecontent2">孙麓</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">孙麓</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">骨外科</td>
                <td class="tablecontent2">刘勇</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">刘勇</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">胃肠外科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王荣亮</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王荣亮</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王荣亮</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王荣亮</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">肝胆外科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">刘绍彬</td>
                <td class="tablecontent2">刘绍彬</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">郑启昌</td>
                <td class="tablecontent2">郑启昌</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">泌尿外科</td>
                <td class="tablecontent2">朱朝辉</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">张齐钧</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">陈晓春</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">张润清</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">朱朝辉</td>
                <td class="tablecontent2">朱朝辉</td>
              </tr>
              <tr>
                <td class="tableleft">血管外科</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">罗维宏</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">手术外科</td>
                <td class="tablecontent2">陈振兵</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王发斌</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">胸外科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">王建军</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">乳甲外科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">屈新才</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">儿科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">金润铭</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">中医科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">范恒</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">眼科</td>
                <td class="tablecontent2">覃淑华</td>
                <td class="tablecontent2">覃淑华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">张明昌<br>姜发纲</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">覃淑华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">耳鼻喉科</td>
                <td class="tablecontent2">李佩华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">杨桂华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">李佩华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">李佩华</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">皮肤科</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">冯爱平</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">刘厚君</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>
              <tr>
                <td class="tableleft">消化内科</td>
                <td class="tablecontent2">侯晓华<br>于云鹤</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2">于云鹤</td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
                <td class="tablecontent2"></td>
              </tr>-->
            </tbody></table>
          <input type="submit" value='提交' class="btn btn-success">
      </form>
		  </div>
<!-- <div  style=" width:730px;float:left">
     医生列表
 </div>-->