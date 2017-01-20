<?php echo $this->renderpartial('/common/header_new', $config); ?>
  
    <!--组件目录-->
<?php echo $this->renderpartial('/common/assembly', array('active' => $config['active'], 'pid' => $activity_info['pid'])) ?>
    <script src="<?php echo $this->_theme_url; ?>assets/js/jqueryform.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/js/laydate/laydate.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?php echo $this->_theme_url; ?>assets/h5_base64/lrz.bundle.js" type="text/javascript"
            charset="utf-8"></script>
     <style type="text/css">
                .dail-formdiv1 { margin: 0px 0px 50px 50px; }
.dail-formdiv1 h3 { font-size: 16px; color: #008bcc; font-weight: bold; border-left: 2px solid #008bcc; padding-left: 10px; }
.dail-formdiv1 .tips { padding: 10px 20px; background: #eaf8ff; color: #7f7f7f; border: 1px solid #55c9ff; border-radius: 5px; margin: 20px 66px 20px 0px; }
.dail-formdiv1 .tips em { display: inline-block; float: left; color: #ff4141; }
.dail-formdiv1 .tips p { display: block; margin-left: 50px; color: #999; font-size: 12px; line-height: 24px; }
.dail-upimg { }
.dail-upimg ul li { margin-bottom: 40px; }
.dail-upimgl { position: relative; width: 150px; height: 150px; background: #fff; border-radius: 5px; border: 1px solid #dedede; }
.dail-upimgl:before { content: ""; display: block; width: 80px; height: 0px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -1px; margin-left: -40px; }
.dail-upimgl:after { content: ""; display: block; width: 0px; height: 80px; position: absolute; border: 2px solid #ddd; top: 50%; left: 50%; margin-top: -40px; margin-left: -1px; }
.dail-upimgr { margin-left: 200px; margin-right: 66px; }
.dail-upimgr img { height: 150px; float: left; }
.dail-upimgr span { display: block; float: left; margin-left: 40px; width: 300px; }
.dail-upimgr span p { display: inline-block; }
.dail-upimgr span h4 { color: #008bcc; margin-bottom: 20px; }
.s_num{        border-bottom: 1px solid #c1c1c1;
    padding-bottom: 30px;
    margin-bottom: 10px;
    width: 93%;}
.s_num .form-control{ width:97%}    
.s_num .t_title{padding: 10px 0px;}  
.s_num .delbtn{display: inline-block;
    float: right;
    width: 10%;
    height: 30px;
    line-height: 30px;
    text-align: center;
    position: relative;
    top: -5px;}  
            </style>       

    <!--act nav-->
  <div class="ad-act-list  bxbg ">
        <!-- <div class="ad-app-list-tit">
            <div class="fl tl">
                <h3>编辑活动</h3>
            </div>
            <div class="fr tr">
                <a href="#">
                    <i class="aicon linear"></i>新增活动
                </a>
            </div>
        </div> -->
        <!--tit end-->
        <div class="ad-edit-app">
            <div class="ad-edit-app-navsd ">
                <ul> 
                   <li >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/add',array('id'=>$activity_info['id']))?>">编辑大转盘</a>
                        <?php }else{ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/add',array('id'=>$activity_info['id']))?>">添加大转盘</a>
                        <?php } ?>
                    </li>
                    <li  class="selected" >
                        <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/prize',array('id'=>$activity_info['id']))?>">奖品/概率</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">奖品/概率</a>
                         <?php } ?>
                    </li>
                    <li class="">
                         <?php if($activity_info['id']){ ?>
                        <a href="<?php echo $this->createUrl('/activity/bigwheel/example',array('id'=>$activity_info['id']))?>">开发者示例</a>
                        <?php }else{ ?>
                         <a href="javascript:void(0)">开发者示例</a>
                         <?php } ?>

                    </li>
                </ul>
            </div>
            <!--nav end-->
            <div class="ad-edit-app-con">

                <div class="ad-edit-app-1 ad-edit-app-condiv  clearfix" style="display: block;">


                    <div class="form-content  dail-formdiv1">
                        <h3>奖品/概率</h3>

                        <div class="tips" style="margin-bottom: 0;">
                            <em>*Tips：</em>
                            <p>本模块为大转盘活动基本信息，为了保证活动顺利创建，除活动规则和领奖方式选填外其余的为必填。</p>
                            <p style='color:#ff0000'>停止状态才可以编辑提交成功</p>
                            <p>
                            奖品设置是大转盘核心必填模块，我们支持三到五种奖品，其中活动创建最少添加三个活动奖品最多五个，超过或者少于均会创建失败。添加的奖品默认的第一个就是一等奖奖品，以此类推到五等奖奖品，添加的奖项里面的项目都是必填。<br/>
                            奖品概率和数量请在活动开始前预算规划好设置好请不要随意修改，若不知道如何填写，请联系开发人员。
                            </p>
                        </div>
                        <?php
                        if (isset($activity_info['id'])) {
                            ?>
                            <input type="hidden" value="<?php echo $activity_info['id'] ?>" name="id">
                            <?php
                        }
                        ?>
                       


                     

                    </div>

                    <!--1 end-->


                    <div class="dail-formdiv1 dail-formdiv2">
  

                        <?php
                        if($prize){
                            foreach ($prize as $val){
                                ?>
                                <div class="s_num" style=''>
                                    <input type="hidden" value="<?php echo $val['id']?>" name="p_id[]">
                                    <div class="t_title">自定义名称  <span class="adbtn linear delbtn">删除该项</span></div>
                                    <div class="form-inp">
                                        <input type="text"  value="<?php echo $val['title']?>" placeholder="" class="form-control" name="p_title[]" />
                                    </div>
                                    <div class="t_title">奖品名称</div>
                                    <div class="form-inp">
                                        <input type="text"  value="<?php echo $val['name']?>" placeholder="" class="form-control"  name="p_name[]" />
                                     
                                    </div>
                                    <div class="t_title">奖品数量</div>
                                    <div class="form-inp">
                                        <input type="text"  value="<?php echo $val['count']?>" placeholder="" class="form-control" name="p_num[]"/>
                                    </div>
                                    <div class="t_title">奖品剩余数量</div>
                                    <div class="form-inp">
                                        <input type="text"  value="<?php echo $val['remainder']?>" placeholder="" class="form-control" name="p_snum[]"/>
                                    </div>
                                    <div class="t_title">奖品概率<span>(填入整数)</span></div>
                                    <div class="form-inp">
                                        <input type="text"  value="<?php echo $val['probability']?>" placeholder="" class="form-control" name="p_v[]"/>
                                    </div>
                                </div>
                       
                       
                                <?php
                            }
                        }else{ ?>

                    
                        <?php }?>
                        
                            <div class="input upload_pic clearfix" style="margin-bottom: 20px;">
                            <div class="adbtn linear"
                                 style=" width: 23%;line-height: 36px;text-align: center;margin-top: 20px;"
                                 id="continue_ad_20160422">添加奖项
                            </div>
                           <!--  <div class="adbtn linear"
                                 style=" width: 23%;line-height: 36px;text-align: center;margin-top: 20px;"
                                 id="continue_del_20160422">删除一个奖项
                            </div> -->
                        </div>
                        
                        
                        <div class="t_title">概率基数<span style="color: #999;font-size: 12px;margin-left: 10px;">(奖品概率5,概率基数100000,则中奖概率十万分之五)</span>
                        </div>
                        <div class="form-inp">
                                  <span>
                                   <input type="number" value="<?php echo isset($activity_info['jishu']) ? $activity_info['jishu'] : '100000'; ?>"   name='jishu' placeholder="概率基数(填入整数)" class="form-control" />
                                  </span>
                        </div>

                    </div>

                    <!--2end-->

                    <div class=" linear" style="width: 50%;margin-bottom: 10px;margin-left: 50px;color:#ff0000" disable="disable">
                        活动进行中不能编辑，请先暂停活动！
                    </div>
                      <?php if($activity_info['id'] &&  $activity_info['status']==1 ){?>
                    <button class="adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;background:#ff0000" id='p_button'  onclick="activitystatus()">
                        暂停
                    </button>
                     <button class="save_button adbtn linear"  id='save_button' style="width: 30%;margin-bottom: 40px;margin-left: 50px;display:none">
                        保存
                     </button>
                     <?php }else{ ?>
                     <button class="save_button adbtn linear" style="width: 30%;margin-bottom: 40px;margin-left: 50px;">
                        保存
                     </button>
                     <?php } ?>
                    
                    
                </div>


                 

            </div>
        </div>
    </div>



    <!-- 组件 end -->
    <script type="text/javascript">
      
      $("html").on("click",".delbtn",function(){
        $(this).parent().parent().remove();
      })

      
        $("#continue_ad_20160422").on('click', function () {
            var len = $(".s_num").length + 1;
            console.log(len);
            if (len > 5) {
                layer.msg("大转盘奖品最多只能添加5个噢！");
                return false;
            }
            // var tit = '';
            // if (len == 1) {
            //     tit = '一等奖';
            // } else if (len == 2) {
            //     tit = '二等奖';
            // } else if (len == 3) {
            //     tit = '三等奖';
            // } else if (len == 4) {
            //     tit = '四等奖';
            // } else if (len == 5) {
            //     tit = '五等奖';
            // } 
            var temp_html = '<div class="s_num"><input type="hidden" value="" name="p_id[]"><div class="t_title">自定义名称 <span class="adbtn linear delbtn">删除该项</span></div>' +
                '<div class="form-inp">' +
                '<input type="text"   value="" placeholder=""   class="form-control" name="p_title[]" />' +

                '</div>' +
                '<div class="t_title">奖品名称</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control"  name="p_name[]" />' +

                '</div>' +
                '<div class="t_title">奖品数量</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_num[]"/>' +

                '</div>' +
                '<div class="t_title">奖品剩余数量(用户每中奖一次数量就会随之减少，请不要随意修改)</div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_snum[]"/>' +

                '</div>' +
                '<div class="t_title">奖品概率<span>(请填入整数，例如5，概率是以下面的概率基数为分母，填入数值为分子，默认概率基数为100000，中奖概率为10万分之5)</span></div>' +
                '<div class="form-inp">' +
                '<input type="text" value="" placeholder="" class="form-control" name="p_v[]"/>' +

                '</div></div>';

            var parent = $(this).parents(".upload_pic");
            $(temp_html).insertBefore(parent);
        });


        $("#continue_del_20160422").on('click', function () {
            var len=$(".s_num").length-1;
            $('.s_num').each(function(index,element){
                if(len==index){
                    $(this).remove();
                }else{
                    
                    console.log(index)
                }
            })
        });

         function activitystatus(){
           //询问框
            layer.confirm('确定暂停活动么？', {
              btn: ['确定','取消'] //按钮
            }, function(){
                        var id = $("input[name='id']").val();
                        //为真表示编辑，活动进行的时候不能编辑
                        if(id){
                            $.ajax({
                            type: "POST",
                            url: "<?php echo $this->createUrl('/activity/bigwheel/activitystatus'); ?>",
                            data:{ "id": id,'type':2},
                            dataType:'json',
                            success: function(res){
                                   layer.msg(res.msg);
                                   if(res.state==1){
                                       $('#save_button').show();
                                       $('#p_button').css({"disabled":"disabled","background":"#cccccc"});
                                   }
                                   return false;
                            }
                        });
                        }
            }, function(){

            });  
       }
       
       
        var url = "<?php echo $this->createUrl('/activity/bigwheel/prize'); ?>";

       

        $('.save_button').click(function () {

            var id = $("input[name='id']").val();
            //为真表示编辑，活动进行的时候不能编辑
          
            $('.save_button').attr("disabled","true");
                $('.save_button').text("提交中....");
            var jishu = $("input[name='jishu']").val();//概率基数
            if (jishu <= 0) {
                layer.msg("请填写概率基数");
            $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            
            if ($(".s_num").length < 3) {
                layer.msg("请至少添加3个奖品噢！");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }
            
            var checkes = false;
            var obj_p_id = $("input[name='p_id[]']");
            var p_id = new Array();
            obj_p_id.each(function (index, item) {
//                if (!$(this).val()) {
//                    checkes = true;
//                }
                p_id[index] = $(this).val();
                
            });


            
            var obj_p_title = $("input[name='p_title[]']");//奖项
            var p_title = [];
            obj_p_title.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_title[index] = $(this).val();
                
            });

            var obj_p_name = $("input[name='p_name[]']");
            var p_name = [];
            obj_p_name.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_name[index] = $(this).val();
                
            });


            var obj_p_num = $("input[name='p_num[]']");
            var p_num = [];
            obj_p_num.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_num[index] = $(this).val();
                 
            });


            /*奖品剩余数量*/
            var obj_p_snum = $("input[name='p_snum[]']");
            var num = $("input[name='p_snum[]']");
            var p_snum = [];
            obj_p_snum.each(function (index, item) {
                var snumber=$(num[index]).val();//剩余奖品数据
                var number=$(this).val();//奖品数据量
                if (!number || number<=snumber && snumber<0) {
                    checkes = true;
                }
                p_snum[index] = $(this).val();
                
            });


            var obj_p_v = $("input[name='p_v[]']");
            var p_v = [];
            var p_v_all = 0;
            obj_p_v.each(function (index, item) {
                if (!$(this).val()) {
                    checkes = true;
                }
                p_v_all += parseInt($(this).val());
                p_v[index] = $(this).val();
                
            });

            if (checkes) {
                layer.msg("请添加奖项信息");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }

            if (p_v_all > jishu) {
                layer.msg("请注意,概率基数应大于或等于奖品概率总和");
                $('.save_button').removeAttr('disabled');
            $('.save_button').text("保存");
            return false;
            }


            if(id){
                $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('/activity/bigwheel/is_status'); ?>",
                data:{
                    "id": id,
                },
                success: function(msg){
                   if(msg==2){     
                        layer.msg("活动进行中，避免数据错误，暂时不能编辑", {time: 2000}, function (index) {
                        layer.close(index);
                        });
                        $('.save_button').removeAttr('disabled');
                        $('.save_button').text("保存");
                        return false;
                   }else if(msg==3){
                       layer.msg("非法提交", {time: 2000}, function (index) {
                            layer.close(index);
                       });
                       $('.save_button').removeAttr('disabled');
                    $('.save_button').text("保存");
                        return false;
                   }

                }
            });
            }


            var data = {  id: id,    p_title: p_title,   p_name: p_name,  p_num: p_num, p_snum: p_snum, p_v: p_v, p_id: p_id, jishu: jishu};
            $.ajax({
                type: "post",
                url: url,
                data:data,
                dataType:'json',
                beforeSend: function(){
                    $('.save_button').attr("disabled","true");
                    $('.save_button').text("提交中....");
                    layer.msg("提交中....", {time: 1000}, function (index) {
                        layer.close(index);
                    });
                },
                success: function(res){
                     layer.msg(res.msg, {time: 2000}, function (index) {
                        layer.close(index);
                     });
                     window.location.reload();
                    $('.save_button').removeAttr('disabled');
                    $('.save_button').text("保存");
                },
                error: function(res){
                     $('.save_button').removeAttr('disabled');
                        $('.save_button').text("保存");
                     layer.msg(res.msg, {time: 2000}, function (index) {
                        layer.close(index);
                     });
                }
            });

        })

    </script>

<?php echo $this->renderpartial('/common/footer', $config); ?>